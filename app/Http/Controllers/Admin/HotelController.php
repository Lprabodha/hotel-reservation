<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHotelRequest;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels = Hotel::all();

        return view('admin.hotel.index', compact('hotels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.hotel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHotelRequest $request)
    {
        try {
            $imagesPaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
                    $path = Storage::disk('s3')->putFileAs(
                        'hotels',
                        $image,
                        $filename,
                        'public'
                    );

                    if ($path) {
                        $imagesPaths[] = 'hotels/' . $filename;
                    }
                }
            }

            $hotel = Hotel::create([
                'name' => $request->name,
                'location' => $request->location,
                'phone' => $request->phone,
                'type' => $request->type,
                'email' => $request->email,
                'star_rating' => $request->star_rating ?? 0,
                'description' => $request->description,
                'address' => $request->address,
                'country' => $request->country,
                'website' => $request->website,
                'images' => $imagesPaths,
                'active' => $request->active ?? false,
            ]);

            return redirect()
                ->route('admin.hotels')
                ->with('success', 'Hotel created successfully!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            if (!empty($imagesPaths)) {
                foreach ($imagesPaths as $imagePath) {
                    Storage::disk('s3')->delete($imagePath);
                }
            }

            return back()
                ->withInput()
                ->with('error', 'Failed to create hotel. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel)
    {
         $imageUrls = $this->getImageUrls($hotel->images ?? []);
        //  dd($hotel->images);
        
        return view('admin.hotel.show', [
            'hotel' => $hotel,
            'imageUrls' => $imageUrls
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function getImageUrls(array $imagePaths)
    {
        return collect($imagePaths)->map(function ($path) {
            logger("Checking path: $path");
            $exists = Storage::disk('s3')->exists($path);
            logger("Exists? " . ($exists ? 'yes' : 'no'));

            if ($exists) {
                return Storage::disk('s3')->url($path);
            }
            return null;
        })->filter()->values()->toArray();
    }

}
