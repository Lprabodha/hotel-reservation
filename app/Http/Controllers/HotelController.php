<?php

namespace App\Http\Controllers;

use App\Models\Hotel;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();

        return view('hotel.index', compact('hotels'));
    }

    public function view($slug)
    {

        $hotel = Hotel::where('slug', $slug)->firstOrFail();
        if (! $hotel) {
            abort(404, 'Hotel not found');
        }

        return view('hotel.view', compact('hotel'));
    }
}
