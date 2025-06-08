<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Reservation;
use App\Models\ReservationRequest;
use App\Models\TravelCompany;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $user = auth()->user();

        $totalReservations = Reservation::where('user_id', $user->id)->count();

        $totalPayments = Bill::whereHas('reservation', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
            ->where('status', 'paid')
            ->sum('total_amount');

        $totalSuccessReservations = Reservation::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'checked_out'])
            ->count();

        $latestBillings = Bill::with(['reservation', 'payment'])
            ->where('status', 'paid')
            ->whereHas('reservation', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->latest()
            ->take(15)
            ->get();

        $reservations = Reservation::where('user_id', $user->id)
            ->latest()
            ->take(15)
            ->get();

        if ($user->hasRole('travel-company')) {

            $travelCompany = TravelCompany::where('user_id', $user->id)->first();

            return view('dashboard.travel-company.index', compact(
                'reservations',
                'latestBillings',
                'totalReservations',
                'totalPayments',
                'totalSuccessReservations',
                'travelCompany'
            ));
        }

        return view('dashboard.index', compact(
            'reservations',
            'latestBillings',
            'totalReservations',
            'totalPayments',
            'totalSuccessReservations'
        ));
    }

    public function getUserProfile()
    {
        return view('admin.users.user-profile');
    }

    public function showReservation(Request $request)
    {
        $columns = [
            0 => 'id',
            1 => 'guest_email',
            2 => 'hotel_name',
            3 => 'reservation_date',
            4 => 'status',
            5 => 'action',
        ];

        $query = Reservation::query()->where('user_id', Auth::user()->id);

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

            $action = '
                <a href="'.route('admin.reservation.view', ['id' => $r->confirmation_number]).'" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                    <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                </a>
            ';

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

    public function payments(Request $request)
    {

        $columns = [
            0 => 'id',
            1 => 'confirmation_number',
            2 => 'payment_method',
            3 => 'extra_charges',
            4 => 'discount',
            5 => 'total_amount',
            6 => 'status',
            7 => 'action',
        ];

        $totalData = Bill::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderDirection = $request->input('order.0.dir', 'asc');

        $query = Bill::with(['reservation', 'payment'])->where('status', 'paid');

        if (! auth()->user()->hasRole('super-admin')) {
            $user = auth()->user();
            $hotel = $user->hotels()->first();

            $query = $query->whereHas('reservation', function ($q) use ($hotel) {
                $q->where('hotel_id', $hotel->id);
            });
        }

        if (! empty($request->input('search.value'))) {
            $search = $request->input('search.value');

            $query = $query->where(function ($query) use ($search) {
                $query->whereHas('reservation', function ($q) use ($search) {
                    $q->where('confirmation_number', 'like', "%{$search}%");
                })->orWhere('extra_charges', 'like', "%{$search}%")
                    ->orWhere('discount', 'like', "%{$search}%")
                    ->orWhere('total_amount', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $totalFiltered = $query->count();

        $posts = $query->offset($start)
            ->limit($limit)
            ->orderBy('id', $orderDirection)
            ->get();

        $data = [];

        foreach ($posts as $r) {
            $nestedData['id'] = $r->id;
            $nestedData['confirmation_number'] = $r->reservation->confirmation_number ?? '-';
            $nestedData['payment_method'] = $r->payment->method ?? '-';
            $nestedData['extra_charges'] = 'LKR '.number_format($r->extra_charges, 2);
            $nestedData['discount'] = 'LKR '.number_format($r->discount, 2);
            $nestedData['total_amount'] = 'LKR '.number_format($r->total_amount, 2);
            $nestedData['status'] = $r->status == 'paid'
                ? '<span class="badge bg-success">Paid</span>'
                : '<span class="badge bg-danger">Unpaid</span>';

            $action = '
                <a href="" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                    <iconify-icon icon="material-symbols:download"></iconify-icon>
                </a>
            ';

            if ($r->status == 'paid') {
                $action .= '
                    <button type="button" onclick="refundBill('.$r->id.')" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                        <iconify-icon icon="gridicons:refund"></iconify-icon>
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

    public function viewReservation($id)
    {

        $reservation = Reservation::where('confirmation_number', $id)->first();

        if (! $reservation) {
            return redirect()->route('dashboard');
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

    public function requestReservation(Request $request)
    {
        return view('dashboard.travel-company.reservation-request');
    }

    public function storeRequestReservation(Request $request)
    {
        $validated = $request->validate([
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'description' => 'nullable|string',
        ]);

        $user = Auth::user()->travelCompany;

        ReservationRequest::create([
            'travel_company_id' => $user->id,
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('dashboard')->with('success', 'Reservation request submitted successfully.');
    }

    public function cancelReservation($id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->status === 'booked' && Carbon::parse($reservation->check_in_date)->isFuture()) {
            $reservation->status = 'cancelled';
            $reservation->cancellation_reason = 'Customer Cancel the reservation';
            $reservation->cancellation_date = now();
            $reservation->save();

            return redirect()->back()->with('success', 'Reservation cancelled successfully.');
        }

        return redirect()->back()->with('error', 'Reservation cannot be cancelled.');
    }
}
