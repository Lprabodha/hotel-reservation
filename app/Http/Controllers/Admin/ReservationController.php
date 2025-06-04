<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.reservations.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $user = User::whereHas('roles', function ($query) {
            $query->where('name', 'hotel-clerk');
        })->first();

        if (! $user) {
            return redirect()->back()->with('error', 'Hotel clerk not found.');
        }

        $hotel = $user->hotels()->with(['rooms' => function ($q) {
            $q->where('is_available', 1);
        }])->first();

        $bookedDates = [];

        $reservations = Reservation::where('hotel_id', $hotel->id)->get();

        foreach ($reservations as $reservation) {
            $period = CarbonPeriod::create($reservation->check_in_date, $reservation->check_out_date->subDay());
            foreach ($period as $date) {
                $bookedDates[] = $date->format('Y-m-d');
            }
        }

        $bookedDates = array_unique($bookedDates);

        return view('admin.reservations.create', [
            'hotel' => $hotel,
            'rooms' => $hotel->rooms,
            'bookedDates' => $bookedDates,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $userId = $request->customer_type === 'individual'
                ? $request->customer_email
                : $request->travel_agency;

            $paymentMethod = ($request->card_number && $request->card_expire_date && $request->csv)
                ? 'credit_card'
                : 'none';

            $checkinDate = Carbon::parse($request->checkin);
            $checkoutDate = Carbon::parse($request->checkout);
            $nights = $checkinDate->diffInDays($checkoutDate);

            $firstRoom = Room::where('id', $request->rooms[0])->firstOrFail();
            $hotelId = $firstRoom->hotel_id;

            $totalPrice = 0;

            $reservation = Reservation::create([
                'user_id' => $userId,
                'hotel_id' => $hotelId,
                'check_in_date' => $request->checkin,
                'check_out_date' => $request->checkout,
                'status' => 'booked',
                'number_of_guests' => $request->guests,
                'special_requests' => $request->special_requests,
                'total_price' => $totalPrice,
                'payment_status' => 'pending',
                'payment_method' => $paymentMethod,
                'confirmation_number' => strtoupper(Str::random(10)),
            ]);

            $reservation->rooms()->sync($request->rooms);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Reservation created successfully.',
                'reservation_id' => $reservation->id,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create reservation.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request) {}

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
}
