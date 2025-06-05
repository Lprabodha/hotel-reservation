<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $hotels = Hotel::all();

        return view('index', compact('hotels'));
    }

    public function aboutUs()
    {
        return view('pages.about-us');
    }

    public function contact()
    {
        return view('pages.contact-us');
    }

    public function faq()
    {
        return view('pages.faq');
    }

    public function reservation($hotelId)
    {
        $hotel = Hotel::with('rooms', 'services')->findOrFail($hotelId);

        $roomImages = $hotel->rooms
            ->pluck('images')
            ->flatten()
            ->filter()
            ->toArray();

        $roomImageUrls = $this->getImageUrls($roomImages);

        return view('reservation', compact('hotel', 'roomImageUrls'));
    }

    private function getImageUrls(array $imagePaths)
    {
        return collect($imagePaths)->map(function ($path) {
            $exists = Storage::disk('s3')->exists($path);

            if ($exists) {
                return Storage::disk('s3')->url($path);
            }

            return null;
        })->filter()->values()->toArray();
    }
}
