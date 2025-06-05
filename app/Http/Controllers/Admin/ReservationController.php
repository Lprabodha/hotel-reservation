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
            $period = CarbonPeriod::create(
                Carbon::parse($reservation->check_in_date),
                Carbon::parse($reservation->check_out_date)->subDay()
            );
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

            if (empty($request->rooms) || !is_array($request->rooms)) {
                throw new \Exception('No rooms selected.');
            }

            $firstRoom = Room::where('id', $request->rooms[0])->firstOrFail();
            $hotelId = $firstRoom->hotel_id;

            $specialRequests = $request->special_requests;

            $totalGuests = $request->guests;
            if (!$totalGuests) {
                $totalGuests = Room::whereIn('id', $request->rooms)->sum('occupancy');
            }

            $totalPrice = Room::whereIn('id', $request->rooms)
                ->sum('price_per_night') * $nights;

            $reservation = Reservation::create([
                'user_id' => $userId,
                'hotel_id' => $hotelId,
                'check_in_date' => $request->checkin,
                'check_out_date' => $request->checkout,
                'status' => 'booked',
                'number_of_guests' => $totalGuests,
                'special_requests' => $specialRequests,
                'total_price' => $totalPrice,
                'payment_status' => 'pending',
                'payment_method' => $paymentMethod,
                'confirmation_number' => strtoupper(Str::random(10)),
            ]);

            $reservation->rooms()->sync($request->rooms);
            Room::whereIn('id', $request->rooms)->update(['is_available' => false]);

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
    public function show(Request $request)
    {
        $columns = [
            0 => 'id',
            1 => 'guest_email',
            2 => 'hotel_name',
            3 => 'reservation_date',
            4 => 'status',
            5 => 'action',
        ];

        $query = Reservation::query();

        if (! auth()->user()->hasRole('super-admin')) {
            $user = auth()->user();
            $hotel = $user->hotels()->first();
            $query->where('hotel_id', $hotel->id);
        }

        $totalData = $query->count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $reservations = $query->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = $totalData;
        } else {
            $search = $request->input('search.value');

            $reservations = $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('confirmation_number', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('payment_status', 'like', "%{$search}%");
            })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('confirmation_number', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('payment_status', 'like', "%{$search}%");
            })
                ->count();
        }

        $data = [];

        if ($reservations) {
            foreach ($reservations as $r) {
                $nestedData['id'] = $r->id;
                $nestedData['guest_email'] = $r->user->email ?? 'N/A';
                $nestedData['hotel_name'] = $r->hotel->name ?? 'N/A';
                $nestedData['reservation_date'] = $r->check_in_date;
                $nestedData['status'] = match ($r->status) {
                    'booked' => '<span class="badge bg-success">Booked</span>',
                    'cancelled' => '<span class="badge bg-danger">Cancelled</span>',
                    'no_show' => '<span class="badge bg-warning">No Show</span>',
                    'checked_in' => '<span class="badge bg-primary">Checked In</span>',
                    'checked_out' => '<span class="badge bg-secondary">Checked Out</span>',
                    default => '<span class="badge bg-light">Unknown</span>',
                };
                $nestedData['action'] = '
                    <a href="#" class="btn btn-outline-primary-600 radius-8 px-20 py-11">View</a>
                    <a href="#" class="btn btn-outline-lilac-600 radius-8 px-20 py-11">Edit</a>
                    <button onclick="deleteReservation(' . $r->id . ')" class="btn btn-outline-danger-600 radius-8 px-20 py-11">Delete</button>
                ';
                $data[] = $nestedData;
            }
        }

        $json_data = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $data,
        ];

        return response()->json($json_data);
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
}
