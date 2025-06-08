<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Hotel;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $days = $request->get('filter', 30);

        $startDate = now()->subDays($days);

        $hotelId = auth()->user()->hotels()->first()->id ?? null;

        $reservations = Reservation::where('hotel_id', $hotelId)
            ->whereBetween('check_in_date', [$startDate, now()])
            ->get();

        $totalRooms = Room::where('hotel_id', $hotelId)->count();
        $occupiedRooms = $reservations->where('check_in_date', today())->count();
        $occupancyRate = ($totalRooms > 0) ? ($occupiedRooms / $totalRooms) * 100 : 0;

        $futureDate = now()->addDays(7)->toDateString();
        $futureOccupiedRooms = Reservation::where('hotel_id', $hotelId)
            ->where('check_in_date', $futureDate)
            ->count();
        $futureOccupancyRate = ($totalRooms > 0) ? ($futureOccupiedRooms / $totalRooms) * 100 : 0;

        $roomRevenue = Bill::whereHas('reservation', function ($q) use ($hotelId) {
            $q->where('hotel_id', $hotelId);
        })->whereBetween('created_at', [$startDate, now()])
            ->sum('room_charges');

        $extraRevenue = Bill::whereHas('reservation', function ($q) use ($hotelId) {
            $q->where('hotel_id', $hotelId);
        })->whereBetween('created_at', [$startDate, now()])
            ->sum('extra_charges');

        $bills = Bill::whereHas('reservation', function ($q) use ($hotelId) {
            $q->where('hotel_id', $hotelId);
        })->whereBetween('created_at', [$startDate, now()])
            ->get();

        $hotels = Hotel::select('id', 'name')->orderBy('name')->get();

        return view('admin.reports.index', compact(
            'reservations',
            'occupiedRooms',
            'totalRooms',
            'occupancyRate',
            'futureDate',
            'futureOccupiedRooms',
            'futureOccupancyRate',
            'roomRevenue',
            'extraRevenue',
            'bills',
            'hotels'
        ));
    }

    public function payments()
    {
        return view('admin.reports.payments');
    }

    /**
     * Display the specified resource.
     */
    public function bill(Request $request)
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
                ? '<span class="px-24 py-4 rounded-pill fw-medium text-sm
                                    bg-success-focus text-success-main">Paid</span>'
                : '<span class="px-24 py-4 rounded-pill fw-medium text-sm
                                    bg-danger-focus text-danger-main">Unpaid</span>';

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

    public function latestReservation(Request $request)
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

        $user = auth()->user();
        $hotel = $user->hotels()->first();

        $query->where('hotel_id', $hotel->id);

        $query->whereDate('check_in_date', '>=', Carbon::today());

        $status = $request->input('status');
        $date = $request->input('date');

        if ($status) {
            $query->where('status', $status);
        }

        if ($date) {
            $query->whereDate('check_in_date', $date);
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
            })->count();
        }

        $data = [];

        foreach ($reservations as $r) {
            $nestedData['id'] = $r->confirmation_number;
            $nestedData['guest_email'] = $r->user->email ?? 'N/A';
            $nestedData['hotel_name'] = $r->hotel->name ?? 'N/A';
            $nestedData['reservation_date'] = $r->check_in_date;

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

    public function pastReservation(Request $request)
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
        $user = auth()->user();
        $hotel = $user->hotels()->first();

        $query->where('hotel_id', $hotel->id);

        $query->whereDate('check_in_date', '<', Carbon::today())
            ->where('status', '!=', 'no_show');
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
            })->count();
        }

        $data = [];

        foreach ($reservations as $r) {
            $nestedData['id'] = $r->confirmation_number;
            $nestedData['guest_email'] = $r->user->email ?? 'N/A';
            $nestedData['hotel_name'] = $r->hotel->name ?? 'N/A';
            $nestedData['reservation_date'] = $r->check_in_date;

            $statusBadgeClass = match ($r->status) {
                'booked' => 'px-24 py-4 rounded-pill fw-medium text-sm
                                    bg-success-focus text-success-main',
                'checked_in' => 'bg-info-focus text-info-main px-24 py-4 rounded-pill fw-medium text-sm',
                'checked_out' => 'bg-info-focus text-info-main px-24 py-4 rounded-pill fw-medium text-sm',
                'cancelled' => 'px-24 py-4 rounded-pill fw-medium text-sm
                                    bg-danger-focus text-danger-main',
                'no_show' => 'px-24 py-4 rounded-pill fw-medium text-sm
                                    bg-warning-focus text-warning-main',
                'completed' => 'px-24 py-4 rounded-pill fw-medium text-sm
                                    bg-success-focus text-success-main',
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

    public function noShowReservation(Request $request)
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
        $user = auth()->user();
        $hotel = $user->hotels()->first();

        $query->where('hotel_id', $hotel->id)
            ->where('status', 'no_show');

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
            })->count();
        }

        $data = [];

        foreach ($reservations as $r) {
            $nestedData['id'] = $r->confirmation_number;
            $nestedData['guest_email'] = $r->user->email ?? 'N/A';
            $nestedData['hotel_name'] = $r->hotel->name ?? 'N/A';
            $nestedData['reservation_date'] = $r->check_in_date;

            $statusBadgeClass = match ($r->status) {
                'booked' => 'px-24 py-4 rounded-pill fw-medium text-sm
                                    bg-success-focus text-success-main',
                'checked_in' => 'bg-info-focus text-info-main px-24 py-4 rounded-pill fw-medium text-sm',
                'checked_out' => 'bg-info-focus text-info-main px-24 py-4 rounded-pill fw-medium text-sm',
                'cancelled' => 'px-24 py-4 rounded-pill fw-medium text-sm
                                    bg-danger-focus text-danger-main',
                'no_show' => 'px-24 py-4 rounded-pill fw-medium text-sm
                                    bg-warning-focus text-warning-main',
                'completed' => 'px-24 py-4 rounded-pill fw-medium text-sm
                                    bg-success-focus text-success-main',
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
}
