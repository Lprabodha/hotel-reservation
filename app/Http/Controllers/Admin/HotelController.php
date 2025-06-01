<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHotelRequest;
use App\Models\Hotel;
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
                    $filename = Str::uuid().'.'.$image->getClientOriginalExtension();
                    $path = Storage::disk('s3')->putFileAs(
                        'hotels',
                        $image,
                        $filename,
                        'public'
                    );

                    if ($path) {
                        $imagesPaths[] = 'hotels/'.$filename;
                    }
                }
            }

            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $counter = 1;

            while (Hotel::where('slug', $slug)->exists()) {
                $slug = $originalSlug.'-'.$counter;
                $counter++;
            }

            $hotel = Hotel::create([
                'name' => $request->name,
                'slug' => $slug,
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
            if (! empty($imagesPaths)) {
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
    public function show($slug)
    {
        $hotel = Hotel::where('slug', $slug)->firstOrFail();

        $imageUrls = $this->getImageUrls($hotel->images ?? []);

        return view('admin.hotel.show', [
            'hotel' => $hotel,
            'imageUrls' => $imageUrls,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hotel $hotel)
    {
        return view('admin.hotel.edit', compact('hotel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreHotelRequest $request, Hotel $hotel)
    {
        try {
            $imagesPaths = $hotel->images ?? [];

            if ($request->hasFile('images')) {
                foreach ($imagesPaths as $oldImage) {
                    Storage::disk('s3')->delete($oldImage);
                }

                $imagesPaths = [];
                foreach ($request->file('images') as $image) {
                    $filename = Str::uuid().'.'.$image->getClientOriginalExtension();
                    $path = Storage::disk('s3')->putFileAs(
                        'hotels',
                        $image,
                        $filename,
                        'public'
                    );
                    if ($path) {
                        $imagesPaths[] = 'hotels/'.$filename;
                    }
                }
            }

            $slug = $hotel->slug;
            if ($request->name !== $hotel->name) {
                $slug = Str::slug($request->name);
                $originalSlug = $slug;
                $counter = 1;
                while (Hotel::where('slug', $slug)->where('id', '!=', $hotel->id)->exists()) {
                    $slug = $originalSlug.'-'.$counter;
                    $counter++;
                }
            }

            $hotel->update([
                'name' => $request->name,
                'slug' => $slug,
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

            return redirect()->route('admin.hotels')->with('success', 'Hotel updated successfully!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->withInput()->with('error', 'Failed to update hotel. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        if (is_array($hotel->images)) {
            foreach ($hotel->images as $imagePath) {
                Storage::disk('s3')->delete($imagePath);
            }
        }

        $hotel->delete();
        $hotel->users()->detach();

        return redirect()->route('admin.hotels')->with('success', 'Hotel deleted successfully.');
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
