<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $userSocial = Socialite::driver($provider)->stateless()->user();
        $user = User::where(['email' => $userSocial->getEmail()])->first();

        if (! $user) {
            $user = User::create([
                'name' => $userSocial->getName(),
                'email' => $userSocial->getEmail(),
                'provider_id' => $userSocial->getId(),
                'provider' => $provider,
            ]);
            $user->assignRole('customer');

            try {
                $data = [
                    'title' => 'Welcome to Our Hotel Booking Platform',
                    'template' => 'welcome',
                    'login_url' => route('hotels'),
                    'name' => $user->name,
                    'reservation_url' => route('about-us'),
                ];

                Mail::to($user->email)->send(new SendMail($data));
            } catch (\Exception $e) {
                Log::error('Email failed to send: '.$e->getMessage());
            }
        }
        Auth::login($user);

        if ($user->hasRole('admin') || $user->hasRole('hotel-clerk') || $user->hasRole('hotel-manager')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('customer') || $user->hasRole('travel-company')) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('admin.dashboard');
        }
    }

    public function oneTap($request)
    {
        $client = new \GuzzleHttp\Client;
        $request = $client->get('https://oauth2.googleapis.com/tokeninfo?id_token='.$request->id);
        $response = json_decode($request->getBody());
        $user = User::where('email', $response->email)->first();

        if (! $user) {
            $user = User::create([
                'name' => $response->name,
                'email' => $response->email,
                'provider_id' => $response->sub,
                'provider' => 'google',
            ]);
            $user->assignRole('user');
        }

        Auth::login($user);
    }
}
