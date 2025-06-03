<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();

        return view('hotel.index', compact('hotels'));
    }

    public function view($slug)
    {
        $hotel = Hotel::where('slug', $slug)->with('rooms', 'services')->firstOrFail();

        $hotelImages = $hotel->images ?? [];

        $roomImages = $hotel->rooms
            ->pluck('images')
            ->flatten()
            ->filter()
            ->toArray();

        $allImagePaths = array_merge($hotelImages, $roomImages);

        $allImageUrls = $this->getImageUrls($allImagePaths);

        $roomsImagesUrls = $this->getImageUrls($roomImages);
        $hotelsImagesUrls = $this->getImageUrls($hotelImages);

        return view('hotel.view', compact('hotel', 'allImageUrls', 'roomsImagesUrls', 'hotelsImagesUrls'));
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
