<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with('hotel')->latest()->get();

        return view('admin.room.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hotels = Hotel::active()->orderBy('name')->get();

        return view('admin.room.create', compact('hotels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request)
    {
        try {
            $imagePaths = [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = Str::uuid().'.'.$image->getClientOriginalExtension();
                    $path = Storage::disk('s3')->putFileAs('rooms', $image, $filename, 'public');
                    if ($path) {
                        $imagePaths[] = 'rooms/'.$filename;
                    }
                }
            }

            Room::create([
                'hotel_id' => $request->hotel_id,
                'room_number' => $request->room_number,
                'room_type' => $request->room_type,
                'occupancy' => $request->occupancy,
                'price_per_night' => $request->price_per_night,
                'is_available' => $request->is_available ?? true,
                'description' => $request->description,
                'images' => $imagePaths,
            ]);

            return redirect()->route('admin.rooms')
                ->with('success', 'Room created successfully!');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            foreach ($imagePaths as $path) {
                Storage::disk('s3')->delete($path);
            }

            return back()->withInput()->with('error', 'Failed to create room.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        $imageUrls = $this->getImageUrls($room->images ?? []);

        return view('admin.room.show', [
            'hotel' => $room,
            'imageUrls' => $imageUrls,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        $hotels = Hotel::all();
        return view('admin.room.edit', compact('room', 'hotels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRoomRequest $request, Room $room)
    {
        try {
            $imagePaths = $room->images ?? [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
                    $path = Storage::disk('s3')->putFileAs('rooms', $image, $filename, 'public');
                    if ($path) {
                        $imagePaths[] = 'rooms/' . $filename;
                    }
                }
            }

            $room->update([
                'hotel_id' => $request->hotel_id,
                'room_number' => $request->room_number,
                'room_type' => $request->room_type,
                'occupancy' => $request->occupancy,
                'price_per_night' => $request->price_per_night,
                'is_available' => $request->is_available ?? true,
                'description' => $request->description,
                'images' => $imagePaths,
            ]);

            return redirect()->route('admin.rooms')->with('success', 'Room updated successfully!');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            return back()->withInput()->with('error', 'Failed to update room.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        if (is_array($room->images)) {
            foreach ($room->images as $imagePath) {
                Storage::disk('s3')->delete($imagePath);
            }
        }

        $room->delete();

        return redirect()->route('admin.rooms')->with('success', 'Room deleted successfully.');
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
