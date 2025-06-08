<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\Bill;
use App\Models\Hotel;
use App\Models\Reservation;
use App\Models\ReservationRequest;
use App\Models\Room;
use App\Models\TravelCompany;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
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

    public function request()
    {
        return view('admin.reservations.request');
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

            $checkinDate = Carbon::parse($request->check_in_date);
            $checkoutDate = Carbon::parse($request->check_out_date);
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

            $maskedCard = null;
            if ($request->card_number) {
                $lastFour = substr($request->card_number, -4);
                $maskedCard = 'xxxx'.$lastFour;
            }

            $reservation = Reservation::create([
                'user_id' => $userId,
                'hotel_id' => $hotelId,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
                'status' => 'booked',
                'number_of_guests' => $totalGuests,
                'special_requests' => $specialRequests,
                'total_price' => $totalPrice,
                'discount_rate' => $discountRate,
                'payment_status' => 'pending',
                'payment_method' => $paymentMethod,
                'card_number' => $maskedCard,
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

                Mail::to($email)->send(new SendMail($data));
            } catch (\Exception $e) {
                Log::error('Email failed to send: '.$e->getMessage());
            }

            return redirect()->route('admin.reservation.index')->with('success', 'Reservation created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create reservation.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function requestShow(Request $request)
    {
        $columns = [
            0 => 'travel_company',
            1 => 'check_in_date',
            2 => 'check_out_date',
            3 => 'description',
            4 => 'action',
        ];

        $totalData = ReservationRequest::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDirection = $request->input('order.0.dir', 'asc');
        $orderBy = $columns[$orderColumnIndex];

        $query = ReservationRequest::with('travelCompany');

        if (! empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhereHas('travelCompany', function ($tc) use ($search) {
                        $tc->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $totalFiltered = $query->count();

        $requests = $query->offset($start)
            ->limit($limit)
            ->orderBy($orderBy === 'travel_company' ? 'travel_company_id' : $orderBy, $orderDirection)
            ->get();

        $data = [];

        foreach ($requests as $r) {
            $data[] = [
                'travel_company' => $r->travelCompany->company_name ?? 'N/A',
                'check_in_date' => Carbon::parse($r->check_in_date)->format('Y-m-d'),
                'check_out_date' => Carbon::parse($r->check_out_date)->format('Y-m-d'),
                'description' => $r->description,
                'action' => '
                <button type="button" onclick="viewRequest('.$r->id.')"
                    class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                    <iconify-icon icon="line-md:confirm"></iconify-icon>
                </button>
            ',
            ];
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $data,
        ]);
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

        $query = Reservation::query()->orderBy('created_at', 'desc');

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

            $allowedStatuses = ['booked', 'checked_in', 'checked_out', 'pending'];

            if (Auth::user()->hasRole('hotel-clerk') && in_array($r->status, $allowedStatuses)) {
                $nestedData['status'] = '
                    <select onchange="changeReservationStatus('.$r->id.', this.value)" class="form-select form-select-sm">
                ';

                foreach ($allowedStatuses as $status) {
                    $selected = ($r->status == $status) ? 'selected' : '';
                    $nestedData['status'] .= '<option value="'.$status.'" '.$selected.'>'.ucfirst(str_replace('_', ' ', $status)).'</option>';
                }

                $nestedData['status'] .= '</select>';
            } else {
                $statusBadgeClass = match ($r->status) {
                    'booked' => 'px-24 py-4 rounded-pill fw-medium text-sm
                                    bg-success-focus text-success-main',
                    'checked_in' => 'px-24 py-4 rounded-pill fw-medium text-sm
                                    bg-primary-focus text-primary-main',
                    'checked_out' => 'px-24 py-4 rounded-pill fw-medium text-sm
                                    bg-secondary-focus text-secondary-main',
                    'cancelled' => 'px-24 py-4 rounded-pill fw-medium text-sm
                                    bg-danger-focus text-danger-main',
                    'no_show' => 'px-24 py-4 rounded-pill fw-medium text-sm
                                    bg-warning-focus text-warning-main',
                    'completed' => 'px-24 py-4 rounded-pill fw-medium text-sm
                                    bg-success-focus text-success-main',
                    'pending' => 'px-24 py-4 rounded-pill fw-medium text-sm
                                    bg-success-focus text-success-main',
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

            if (\Carbon\Carbon::parse($r->check_out_date)->isFuture() && ($r->status != 'cancelled' && $r->status != 'no_show' && $r->status != 'checked_out' && $r->status != 'completed')) {
                $action .= '
            <a href="'.route('admin.reservation.edit', ['id' => $r->confirmation_number]).'" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                <iconify-icon icon="lucide:edit"></iconify-icon>
            </a>
            ';
            }

            if ($r->status == 'completed') {
                $action .= '
                    <a href="'.route('admin.reservation.download', $r->id).'" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                        <iconify-icon icon="la:file-invoice"></iconify-icon>
                    </a>
                ';
            }

            if ($r->status != 'cancelled' && $r->status != 'no_show' && $r->status != 'checked_out' && $r->status != 'completed') {

                $action .= '
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
    public function edit($id)
    {
        $reservation = Reservation::where('confirmation_number', $id)->firstOrFail();

        if (! auth()->user()->hasRole('hotel-clerk')) {
            return redirect()->back()->with('error', 'Access denied.');
        }

        if (Carbon::parse($reservation->check_in_date)->isToday() || Carbon::parse($reservation->check_in_date)->isPast()) {
            return redirect()->back()->with('error', 'Cannot edit a reservation that has already started.');
        }

        $hotel = auth()->user()->hotels()->with(['rooms' => function ($q) {
            $q->where('is_available', 1);
        }])->first();

        $bookedDates = [];

        $reservations = Reservation::where('hotel_id', $hotel->id)
            ->where('id', '!=', $reservation->id)
            ->get();

        foreach ($reservations as $r) {
            $period = CarbonPeriod::create(
                Carbon::parse($r->check_in_date),
                Carbon::parse($r->check_out_date)->subDay()
            );

            foreach ($period as $date) {
                $bookedDates[] = $date->format('Y-m-d');
            }
        }

        $bookedDates = array_unique($bookedDates);

        return view('admin.reservations.edit', compact('reservation', 'hotel', 'bookedDates'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        if (Carbon::parse($reservation->check_in_date)->isToday() || Carbon::parse($reservation->check_in_date)->isPast()) {
            return redirect()->back()->with('error', 'Cannot edit a reservation that has already started.');
        }

        $request->validate([
            'checkin' => 'required|date|after:today',
            'checkout' => 'required|date|after:checkin',
            'guests' => 'required|integer|min:1',
            'rooms' => 'required|array|min:1',
        ]);

        $extraNight = false;
        $checkoutDate = Carbon::parse($request->checkout);

        $lastPossibleCheckout = Carbon::parse($reservation->check_out_date)->copy()->addDay();

        if ($checkoutDate->gt($reservation->check_out_date)) {
            if ($checkoutDate->eq($lastPossibleCheckout)) {
                $extraNight = true;
            } else {
                return back()->with('error', 'Only one extra night can be added.');
            }
        }

        $bookedDates = Reservation::where('hotel_id', $reservation->hotel_id)
            ->where('id', '!=', $reservation->id)
            ->get()
            ->flatMap(function ($r) {
                return CarbonPeriod::create(
                    Carbon::parse($r->check_in_date),
                    Carbon::parse($r->check_out_date)->subDay()
                )->map->format('Y-m-d');
            })->unique();

        $selectedDates = CarbonPeriod::create($request->checkin, $checkoutDate->subDay())->map->format('Y-m-d');

        foreach ($selectedDates as $date) {
            if ($bookedDates->contains($date)) {
                return back()->with('error', 'One or more selected dates are already booked.');
            }
        }

        $reservation->update([
            'check_in_date' => $request->checkin,
            'check_out_date' => $request->checkout,
            'guests' => $request->guests,
            'special_requests' => $request->special_requests,
        ]);

        $reservation->rooms()->sync($request->rooms);

        return redirect()->route('admin.reservation.index')->with('success', 'Reservation updated successfully.');
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

    public function downloadInvoice($id)
    {
        $reservation = Reservation::with(['user', 'bill.services'])->findOrFail($id);
        $reservationRooms = $reservation->rooms;
        $bill = $reservation->bill;

        $pdf = Pdf::loadView('admin.reservations.invoice_pdf', compact('reservation', 'reservationRooms', 'bill'));

        return $pdf->download('invoice_'.$reservation->confirmation_number.'.pdf');
    }
}
