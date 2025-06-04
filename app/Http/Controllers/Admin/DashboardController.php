<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function fetchRooms(Request $request)
    {

        $user = auth()->user();
        $hotel = $user->hotels()->first();

        info($hotel);

        $roomsQuery = $hotel->rooms()->where('is_available', 1);

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

        info($rooms);

        $html = '';
        foreach ($rooms as $room) {
            $html .= '
            <div class="col-xxl-3 col-sm-6">
                <div class="card radius-12 h-60">
                    <div class="card-body py-16 px-24">
                        <div class="d-flex align-items-center gap-2 mb-12">
                            <iconify-icon icon="mdi:guest-room" class="text-xxl"></iconify-icon>
                            <h6 class="text-lg mb-0">Room Number - #'.$room->room_number.'</h6>
                            <div class="room-checkbox">
                                <input type="checkbox" name="rooms[]" value="'.$room->id.'" class="form-check-input">
                            </div>
                        </div>
                        <p class="card-text text-muted mb-2">Room Type: '.$room->room_type.'</p>
                        <p class="card-text text-muted mb-2">Max Guests: '.$room->occupancy.'</p>
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
