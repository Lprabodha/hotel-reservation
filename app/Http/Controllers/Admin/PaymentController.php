<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.payments.index');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $columns = [
            0 => 'id',
            1 => 'confirmation_number',
            2 => 'extra_charges',
            3 => 'discount',
            4 => 'total_amount',
            5 => 'status',
            6 => 'action',
        ];

        $totalData = Bill::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderDirection = $request->input('order.0.dir', 'asc');

        $query = Bill::with('reservation');

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

    public function cashPayment(Request $request, Reservation $reservation)
    {
        $reservation->payment_status = 'paid';
        $reservation->status = 'completed';
        $reservation->save();

        $this->createBill($reservation, $request->services);

        return response()->json(['success' => true]);
    }

    public function stripePayment(Request $request, Reservation $reservation)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $subtotal = $reservation->total_price;
        $extraTotal = collect($request->services)->sum('price');
        $totalAmount = $subtotal + $extraTotal;

        $checkoutSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Hotel Reservation Payment',
                    ],
                    'unit_amount' => (int) ($totalAmount * 1000),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('admin.payments.stripe.success', ['reservation' => $reservation->id]),
            'cancel_url' => route('admin.reservation.index').'?cancelled=true',
        ]);

        session()->put('stripe_services_'.$reservation->id, $request->services);

        return response()->json(['url' => $checkoutSession->url]);
    }

    public function stripeSuccess(Request $request, Reservation $reservation)
    {
        $reservation->payment_status = 'paid';
        $reservation->status = 'completed';
        $reservation->save();

        $services = session()->get('stripe_services_'.$reservation->id, []);
        $this->createBill($reservation, $services);

        session()->forget('stripe_services_'.$reservation->id);

        return redirect()->route('admin.reservation.index')->with('success', 'Payment successful!');
    }

    protected function createBill(Reservation $reservation, $services)
    {
        $subtotal = $reservation->total_price;
        $extraTotal = collect($services)->sum('price');
        $grandTotal = $subtotal + $extraTotal;

        $bill = Bill::create([
            'reservation_id' => $reservation->id,
            'room_charges' => $subtotal,
            'extra_charges' => $extraTotal,
            'discount' => 0,
            'taxes' => 0,
            'total_amount' => $grandTotal,
            'status' => 'paid',
        ]);

        foreach ($services as $service) {
            $bill->services()->attach($service['id'], [
                'charge' => $service['price'],
            ]);
        }
    }
}
