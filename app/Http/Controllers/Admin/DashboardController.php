<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $users = User::orderBy('created_at', 'desc')->take(10)->get();

        $customers = User::whereHas('roles', function ($query) {
            $query->where('name', 'customer');
        })->orderBy('created_at', 'desc')->take(10)->get();

        if ($user->roles[0]->name === 'super-admin') {
            $reservations = Reservation::orderBy('created_at', 'desc')->take(10)->get();
        } else {
            $hotelIds = $user->hotels->pluck('id')->toArray();

            $reservations = Reservation::whereIn('hotel_id', $hotelIds)->get();
        }

        return view('admin.index', compact('reservations', 'users', 'customers'));
    }

    public function fetchRooms(Request $request)
    {

        info($request);
        $user = auth()->user();
        $hotel = $user->hotels()->first();

        $roomsQuery = $hotel->rooms();

        if ($request->filled('checkin') && $request->filled('checkout')) {
            $checkin = $request->checkin;
            $checkout = $request->checkout;

            $roomsQuery->whereDoesntHave('reservations', function ($query) use ($checkin, $checkout) {
                $query->where(function ($q) use ($checkin, $checkout) {
                    $q->where('check_in_date', '<', $checkout)
                        ->where('check_out_date', '>', $checkin);
                });
            });
        }

        if ($request->filled('guests')) {
            $roomsQuery->where('occupancy', '>=', $request->guests);
        }

        $rooms = $roomsQuery->get();

        $html = '';
        foreach ($rooms as $room) {
            $html .= '
    <div class="col-xxl-3 col-sm-6 mb-4">
        <div class="card radius-12 h-100">
            <div class="card-body py-3 px-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <iconify-icon icon="mdi:guest-room" class="text-xxl"></iconify-icon>
                        <h6 class="text-lg mb-0">Room #'.$room->room_number.'</h6>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="rooms[]" value="'.$room->id.'" id="room_'.$room->id.'">
                    </div>
                </div>
                <p class="card-text text-muted mb-2"><strong>Room Type:</strong> '.$room->room_type.'</p>
                <p class="card-text text-muted mb-0"><strong>Max Guests:</strong> '.$room->occupancy.'</p>
            </div>
        </div>
    </div>';
        }

        return response()->json([
            'html' => $html,
        ]);
    }

    public function getCustomers()
    {
        $customers = User::role('customer')->select('id', 'email')->get();

        return response()->json($customers);
    }

    public function getTravelCompany()
    {
        $companies = User::role('travel-company')->select('id', 'name')->get();

        return response()->json($companies);
    }
}
