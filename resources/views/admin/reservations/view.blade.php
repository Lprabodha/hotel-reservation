@extends('layouts.admin.app')

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Reservation View</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.reservation.index') }}"
                        class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Reservation View</li>
            </ul>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2">
                    <a href="{{ route('admin.reservation.download', $reservation->id) }}"
                        class="btn btn-sm btn-warning radius-8 d-inline-flex align-items-center gap-1">
                        <iconify-icon icon="solar:download-linear" class="text-xl"></iconify-icon>
                        Download Invoice
                    </a>

                    <button type="button" class="btn btn-sm btn-danger radius-8 d-inline-flex align-items-center gap-1"
                        onclick="printInvoice()">
                        <iconify-icon icon="basil:printer-outline" class="text-xl"></iconify-icon>
                        Print
                    </button>
                </div>
            </div>

            <div class="card-body py-40">
                <div class="row justify-content-center" id="invoice">
                    <div class="col-lg-8">
                        <div class="shadow-4 border radius-8">
                            <div class="p-20 d-flex flex-wrap justify-content-between gap-3 border-bottom">
                                <div>
                                    <h3 class="text-xl">Invoice: {{ $reservation->confirmation_number }}</h3>
                                    <p class="mb-1 text-sm">Date Issued: {{ \Carbon\Carbon::now()->format('Y-m-d') }}</p>
                                    <p class="mb-1 text-sm">Status:
                                        @switch($reservation->status)
                                            @case('booked')
                                                <span class="badge bg-success">Booked</span>
                                            @break

                                            @case('pending')
                                                <span class="badge bg-info">Pending</span>
                                            @break

                                            @case('cancelled')
                                                <span class="badge bg-danger">Cancelled</span>
                                            @break

                                            @case('no_show')
                                                <span class="badge bg-warning">No Show</span>
                                            @break

                                            @case('checked_in')
                                                <span class="badge bg-primary">Checked In</span>
                                            @break

                                            @case('checked_out')
                                                <span class="badge bg-secondary">Checked Out</span>
                                            @break

                                            @case('completed')
                                                <span class="badge bg-success">Completed</span>
                                            @break

                                            @default
                                                <span class="badge bg-light">Unknown</span>
                                        @endswitch
                                    </p>
                                </div>
                                <div>
                                    <p class="mb-1 text-sm">Galle Road, Colombo, SL</p>
                                    <p class="mb-0 text-sm">info@click2checkin.com</p>
                                </div>
                            </div>

                            <div class="py-28 px-20">
                                <div class="d-flex flex-wrap justify-content-between align-items-end gap-3">
                                    <div>
                                        <h6 class="text-md">Issued For:</h6>
                                        <table class="text-sm text-secondary-light">
                                            <tbody>
                                                <tr>
                                                    <td>Name</td>
                                                    <td class="ps-8">:
                                                        @if ($reservation->user->type === 'travel_agency')
                                                            {{ $reservation->user->company_name }}
                                                        @else
                                                            {{ $reservation->user->name }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Address</td>
                                                    <td class="ps-8">:
                                                        {{ $reservation->user->address ?? '4517 Washington Ave, USA' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Phone number</td>
                                                    <td class="ps-8">:
                                                        {{ $reservation->user->phone_number ?? '+94 77 4778  784' }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div>
                                        <table class="text-sm text-secondary-light">
                                            <tbody>
                                                <tr>
                                                    <td>Check In Date</td>
                                                    <td class="ps-8">: {{ $reservation->check_in_date }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Check Out Date</td>
                                                    <td class="ps-8">: {{ $reservation->check_out_date }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="mt-24">
                                    <div class="table-responsive scroll-sm">
                                        <table class="table bordered-table text-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-sm">Room ID</th>
                                                    <th scope="col" class="text-sm">Guests</th>
                                                    <th scope="col" class="text-sm">Type</th>
                                                    <th scope="col" class="text-sm">Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($reservationRooms as $room)
                                                    <tr>
                                                        <td>{{ $room['id'] }}</td>
                                                        <td>{{ $room['occupancy'] }}</td>
                                                        <td>{{ $room['room_type'] }}</td>
                                                        <td>LKR: {{ number_format($room['price'], 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    {{-- Extra Services --}}
                                    @if ($bill && $bill->services->count() > 0)
                                        <h6 class="text-lg fw-semibold mt-4 mb-3">Extra Services</h6>
                                        <div class="table-responsive scroll-sm mb-4">
                                            <table class="table bordered-table text-sm">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Service Name</th>
                                                        <th>Charge (LKR)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($bill->services as $index => $service)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $service->name }}</td>
                                                            <td>LKR: {{ number_format($service->pivot->charge, 2) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif

                                    <div class="d-flex flex-wrap justify-content-between gap-3">
                                        <div></div>
                                        <div>
                                            <table class="text-sm">
                                                <tbody>
                                                    <tr>
                                                        <td class="pe-64">Room Charges:</td>
                                                        <td class="pe-16">
                                                            <span class="text-primary-light fw-semibold">LKR:
                                                                {{ number_format($bill->room_charges ?? 0, 2) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pe-64">Extra Charges:</td>
                                                        <td class="pe-16">
                                                            <span class="text-primary-light fw-semibold">LKR:
                                                                {{ number_format($bill->extra_charges ?? 0, 2) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pe-64">Discount:</td>
                                                        <td class="pe-16">
                                                            <span class="text-primary-light fw-semibold">LKR:
                                                                {{ number_format($bill->discount ?? 0, 2) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pe-64 border-bottom pb-4">Tax:</td>
                                                        <td class="pe-16 border-bottom pb-4">
                                                            <span class="text-primary-light fw-semibold">LKR:
                                                                {{ number_format($bill->taxes ?? 0, 2) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pe-64 pt-4">
                                                            <span class="text-primary-light fw-semibold">Total:</span>
                                                        </td>
                                                        <td class="pe-16 pt-4">
                                                            <span class="text-primary-light fw-semibold">LKR:
                                                                {{ number_format($bill->total_amount ?? $reservation->total_price, 2) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    {{-- End of Totals --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function printInvoice() {
            const printContents = document.getElementById('invoice').innerHTML;
            const originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
@endsection
