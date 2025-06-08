<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    public function index(Request $request)
    {

        $checkIn = $request->query('check_in');
        $checkOut = $request->query('check_out');
        $guests = $request->query('guests');

        if ($checkIn) {
            if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $checkIn)) {
                $checkIn = Carbon::createFromFormat('m/d/Y', $checkIn)->format('Y-m-d');
            } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $checkIn)) {
                $checkIn = Carbon::parse($checkIn)->format('Y-m-d');
            }
        }

        if ($checkOut) {
            if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $checkOut)) {
                $checkOut = Carbon::createFromFormat('m/d/Y', $checkOut)->format('Y-m-d');
            } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $checkOut)) {
                $checkOut = Carbon::parse($checkOut)->format('Y-m-d');
            }
        }

        if ($checkIn || $checkOut || $guests) {
            $hotels = Hotel::with('rooms')
                ->when($checkIn && $checkOut, function ($query) use ($checkIn, $checkOut) {
                    $query->whereHas('rooms', function ($roomQuery) use ($checkIn, $checkOut) {
                        $roomQuery->whereDoesntHave('reservations', function ($resQuery) use ($checkIn, $checkOut) {
                            $resQuery->where(function ($q) use ($checkIn, $checkOut) {
                                $q->where('check_in_date', '<', $checkOut)
                                    ->where('check_out_date', '>', $checkIn);
                            });
                        });
                    });
                })
                ->when($guests, function ($query) use ($guests) {
                    $query->whereHas('rooms', function ($roomQuery) use ($guests) {
                        $roomQuery->where('occupancy', '>=', $guests);
                    });
                })
                ->get();
        } else {
            $hotels = Hotel::with('rooms')->get();
        }

        return view('hotel.index', compact('hotels', 'checkIn', 'checkOut', 'guests'));
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
