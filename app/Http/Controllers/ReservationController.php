<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Vite;
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
            $reservation->load('hotel');
            // dd($reservation);

            try {
                $mailData = [
                    'title' => 'Reservation Confirmed: '.$reservation->confirmation_number,
                    'name' => auth()->user()?->name ?? 'Guest',
                    'reservation_id' => $reservation->confirmation_number,
                    'date' => $reservation->check_in_date->format('Y-m-d'),
                    'time' => '12:00 PM',
                    'hotel_name' => $reservation->hotel->name ?? 'N/A',
                    'hotel_location' => $reservation->hotel->address ?? 'N/A',
                    'location' => $reservation->hotel->city ?? 'N/A',
                    'reservation_url' => route('about-us'),
                    'template' => 'reservation',
                ];

                Mail::to(auth()->user()->email)->send(new SendMail($mailData));
            } catch (\Exception $e) {
                Log::error($e);
            }

            $reservation->rooms()->sync($request->rooms);

            DB::commit();

            return redirect()->route('reservation.confirmed', ['reservation' => $reservation->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            return redirect()->back()->with('error', 'Reservation failed. Please try again.');
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

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'checkin' => 'required|date',
            'checkout' => 'required|date|after:checkin',
        ]);

        $checkin = Carbon::parse($request->checkin);
        $checkout = Carbon::parse($request->checkout);

        $conflictingReservations = DB::table('reservation_room')
            ->join('reservations', 'reservation_room.reservation_id', '=', 'reservations.id')
            ->where('check_in_date', '<', $checkout)
            ->where('check_out_date', '>', $checkin)
            ->pluck('room_id');

        $availableRooms = Room::whereNotIn('id', $conflictingReservations)
            ->get()
            ->map(function ($room) {
                return [
                    'id' => $room->id,
                    'room_number' => $room->room_number,
                    'room_type' => ucfirst($room->room_type),
                    'price_per_night' => $room->price_per_night,
                    'image' => ! empty($room->images[0])
                                ? Storage::disk('s3')->url($room->images[0])
                                : Vite::asset('resources/images/default-room.jpg'),
                ];
            });

        return response()->json(['rooms' => $availableRooms]);
    }

    public function reservationConfirmed(Reservation $reservation)
    {
        $reservation->load('rooms', 'hotel');

        return view('thank-you-page', compact('reservation'));
    }
}
