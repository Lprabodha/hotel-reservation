<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Hotel;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\TravelCompany;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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

            $user = User::where('id', $userId)->first();
            $email = $user->email;

            $paymentMethod = ($request->card_number && $request->card_expire_date && $request->csv)
                ? 'credit_card'
                : 'none';

            $checkinDate = Carbon::parse($request->checkin);
            $checkoutDate = Carbon::parse($request->checkout);
            $nights = $checkinDate->diffInDays($checkoutDate);

            if (empty($request->rooms) || ! is_array($request->rooms)) {
                throw new \Exception('No rooms selected.');
            }

            $firstRoom = Room::where('id', $request->rooms[0])->firstOrFail();
            $hotelId = $firstRoom->hotel_id;

            $hotel = Hotel::findOrFail($hotelId);

            $specialRequests = $request->special_requests;
            $totalGuests = $request->guests ?: Room::whereIn('id', $request->rooms)->sum('occupancy');

            $totalPrice = 0;

            foreach ($request->rooms as $roomId) {
                $rates = DB::table('room_rates')
                    ->where('room_id', $roomId)
                    ->pluck('amount', 'rate_type');

                $dailyRate = $rates['daily'] ?? 0;
                $weeklyRate = $rates['weekly'] ?? 0;
                $monthlyRate = $rates['monthly'] ?? 0;

                $remainingDays = $nights;
                $roomPrice = 0;

                if ($remainingDays >= 30 && $monthlyRate > 0) {
                    $months = intdiv($remainingDays, 30);
                    $roomPrice += $months * $monthlyRate;
                    $remainingDays -= $months * 30;
                }

                if ($remainingDays >= 7 && $weeklyRate > 0) {
                    $weeks = intdiv($remainingDays, 7);
                    $roomPrice += $weeks * $weeklyRate;
                    $remainingDays -= $weeks * 7;
                }

                if ($remainingDays > 0 && $dailyRate > 0) {
                    $roomPrice += $remainingDays * $dailyRate;
                }

                $totalPrice += $roomPrice;
            }

            $discountRate = 0;
            if ($user->hasRole('travel-company')) {
                $travelCompany = TravelCompany::where('user_id', $userId)->first();
                if ($travelCompany && $travelCompany->discount > 0) {
                    $discountRate = $travelCompany->discount;
                    $discountAmount = ($totalPrice * $discountRate) / 100;
                    $totalPrice = $totalPrice - $discountAmount;
                }
            }

            $reservation = Reservation::create([
                'user_id' => $userId,
                'hotel_id' => $hotelId,
                'check_in_date' => $request->checkin,
                'check_out_date' => $request->checkout,
                'status' => 'booked',
                'number_of_guests' => $totalGuests,
                'special_requests' => $specialRequests,
                'total_price' => $totalPrice,
                'discount_rate' => $discountRate,
                'payment_status' => 'pending',
                'payment_method' => $paymentMethod,
                'confirmation_number' => strtoupper(Str::random(10)),
            ]);

            $reservation->rooms()->sync($request->rooms);

            Room::whereIn('id', $request->rooms)->update(['is_available' => false]);

            DB::commit();

            try {
                $data = [
                    'title' => 'Thank You for Your Reservation: '.$reservation->confirmation_number,
                    'email' => $email,
                    'template' => 'reservation',
                    'reservation_id' => $reservation->confirmation_number,
                    'date' => Carbon::parse($request->checkin)->toFormattedDateString(),
                    'hotel_name' => $hotel->name,
                    'hotel_location' => $hotel->location,
                    'reservation_url' => route('about-us'),
                ];

                Mail::to($email)->send(new \App\Mail\SendMail($data));
            } catch (\Exception $e) {
                Log::error('Email failed to send: '.$e->getMessage());
            }

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

        foreach ($reservations as $r) {
            $nestedData['id'] = $r->confirmation_number;
            $nestedData['guest_email'] = $r->user->email ?? 'N/A';
            $nestedData['hotel_name'] = $r->hotel->name ?? 'N/A';
            $nestedData['reservation_date'] = $r->check_in_date;
            if (Auth::user()->hasRole(['hotel-clerk'])) {
                $nestedData['status'] = '
                    <select onchange="changeReservationStatus('.$r->id.', this.value)" class="form-select form-select-sm">
                        <option value="booked" '.($r->status == 'booked' ? 'selected' : '').'>Booked</option>
                        <option value="checked_in" '.($r->status == 'checked_in' ? 'selected' : '').'>Checked In</option>
                        <option value="checked_out" '.($r->status == 'checked_out' ? 'selected' : '').'>Checked Out</option>
                        <option value="cancelled" '.($r->status == 'cancelled' ? 'selected' : '').'>Cancelled</option>
                        <option value="no_show" '.($r->status == 'no_show' ? 'selected' : '').'>No Show</option>
                        <option value="completed" '.($r->status == 'completed' ? 'selected' : '').'>Completed</option>
                    </select>
                ';
            } else {
                $statusBadgeClass = match ($r->status) {
                    'booked' => 'badge bg-success',
                    'checked_in' => 'badge bg-primary',
                    'checked_out' => 'badge bg-secondary',
                    'cancelled' => 'badge bg-danger',
                    'no_show' => 'badge bg-warning',
                    'completed' => 'badge bg-success',
                    default => 'badge bg-light',
                };

                $nestedData['status'] = '<span class="'.$statusBadgeClass.'">'.ucfirst(str_replace('_', ' ', $r->status)).'</span>';
            }

            $action = '
                <a href="'.route('admin.reservation.view', ['id' => $r->confirmation_number]).'" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                    <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                </a>
            ';

            if ($r->status == 'checked_out') {
                $action .= '
                    <a href="'.route('admin.reservation.payment', ['id' => $r->confirmation_number]).'" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                        <iconify-icon icon="streamline:payment-10-solid"></iconify-icon>
                    </a>
                ';
            }

            if ($r->status == 'pending') {
                $action .= '
                    <a href="'.route('admin.reservation.edit', ['id' => $r->confirmation_number]).'" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                        <iconify-icon icon="lucide:edit"></iconify-icon>
                    </a>
                    <button onclick="deleteReservation('.$r->id.')" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                    </button>
                ';
            }

            $nestedData['action'] = $action;
            $data[] = $nestedData;
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

    public function view($id)
    {

        $reservation = Reservation::where('confirmation_number', $id)->first();

        if (! $reservation) {
            return redirect()->route('admin.reservation.index');
        }

        $bill = Bill::with('services')->where('reservation_id', $reservation->id)->first();

        $reservationRooms = [];

        $checkIn = Carbon::parse($reservation->check_in_date);
        $checkOut = Carbon::parse($reservation->check_out_date);
        $nights = $checkIn->diffInDays($checkOut);

        foreach ($reservation->rooms as $room) {
            $rates = DB::table('room_rates')
                ->where('room_id', $room->id)
                ->pluck('amount', 'rate_type');

            $dailyRate = $rates['daily'] ?? 0;
            $weeklyRate = $rates['weekly'] ?? 0;
            $monthlyRate = $rates['monthly'] ?? 0;

            $remainingDays = $nights;
            $price = 0;

            if ($remainingDays >= 30 && $monthlyRate > 0) {
                $months = intdiv($remainingDays, 30);
                $price += $months * $monthlyRate;
                $remainingDays -= $months * 30;
            }

            if ($remainingDays >= 7 && $weeklyRate > 0) {
                $weeks = intdiv($remainingDays, 7);
                $price += $weeks * $weeklyRate;
                $remainingDays -= $weeks * 7;
            }

            if ($remainingDays > 0 && $dailyRate > 0) {
                $price += $remainingDays * $dailyRate;
            }

            $reservationRooms[] = [
                'id' => $room->id,
                'occupancy' => $room->occupancy,
                'room_type' => $room->room_type,
                'price' => $price,
            ];
        }

        return view('admin.reservations.view', compact('reservation', 'reservationRooms', 'bill'));
    }

    public function payment($id)
    {

        $reservation = Reservation::where('confirmation_number', $id)->first();

        if (! $reservation) {
            return redirect()->route('admin.reservation.index');
        }

        $services = $reservation->hotel->services;

        $reservationRooms = [];

        $checkIn = Carbon::parse($reservation->check_in_date);
        $checkOut = Carbon::parse($reservation->check_out_date);
        $nights = $checkIn->diffInDays($checkOut);

        foreach ($reservation->rooms as $room) {
            $rates = DB::table('room_rates')
                ->where('room_id', $room->id)
                ->pluck('amount', 'rate_type');

            $dailyRate = $rates['daily'] ?? 0;
            $weeklyRate = $rates['weekly'] ?? 0;
            $monthlyRate = $rates['monthly'] ?? 0;

            $remainingDays = $nights;
            $price = 0;

            if ($remainingDays >= 30 && $monthlyRate > 0) {
                $months = intdiv($remainingDays, 30);
                $price += $months * $monthlyRate;
                $remainingDays -= $months * 30;
            }

            if ($remainingDays >= 7 && $weeklyRate > 0) {
                $weeks = intdiv($remainingDays, 7);
                $price += $weeks * $weeklyRate;
                $remainingDays -= $weeks * 7;
            }

            if ($remainingDays > 0 && $dailyRate > 0) {
                $price += $remainingDays * $dailyRate;
            }

            $reservationRooms[] = [
                'id' => $room->id,
                'occupancy' => $room->occupancy,
                'room_type' => $room->room_type,
                'price' => $price,
            ];
        }

        return view('admin.reservations.payment', compact('reservation', 'reservationRooms', 'services'));
    }

    public function changeStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:booked,checked_in,checked_out,cancelled,no_show,completed',
        ]);

        $reservation = Reservation::findOrFail($id);
        $reservation->status = $request->status;
        $reservation->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
        ]);
    }
}
