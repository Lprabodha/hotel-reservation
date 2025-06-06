<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'checkin' => 'required|date',
            'checkout' => 'required|date|after:checkin',
            'guests' => 'required|integer|min:1',
            'rooms' => 'required|array|min:1',
            'rooms.*' => 'exists:rooms,id',
        ]);

        try {
            DB::beginTransaction();

            $checkinDate = Carbon::parse($request->checkin);
            $checkoutDate = Carbon::parse($request->checkout);
            $nights = $checkinDate->diffInDays($checkoutDate);

            $firstRoom = Room::findOrFail($request->rooms[0]);
            $hotelId = $firstRoom->hotel_id;

            $totalPrice = 0;
            foreach ($request->rooms as $roomId) {
                $room = Room::findOrFail($roomId);
                $totalPrice += $room->price_per_night * $nights;
            }

            $paymentMethod = ($request->card_number && $request->card_expire_date && $request->csv)
                ? 'credit_card'
                : 'none';

            $reservation = Reservation::create([
                'user_id' => auth()->check() ? auth()->id() : null,
                'hotel_id' => $hotelId,
                'check_in_date' => $checkinDate,
                'check_out_date' => $checkoutDate,
                'number_of_guests' => $request->guests,
                'special_requests' => $request->special_requests,
                'total_price' => $totalPrice,
                'status' => 'booked',
                'payment_status' => 'pending',
                'payment_method' => $paymentMethod,
                'confirmation_number' => strtoupper(Str::random(10)),
            ]);

            $reservation->rooms()->sync($request->rooms);

            DB::commit();

            return redirect()->back()->with('success', 'Reservation successful!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            return redirect()->back()->withErrors(['error' => 'Reservation failed: '.$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
