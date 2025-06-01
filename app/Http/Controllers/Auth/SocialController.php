<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        }
        Auth::login($user);

        if( $user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('dashboard');
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
