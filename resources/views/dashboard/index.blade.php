@extends('layouts.admin.app')

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Hi {{ Auth::user()->name }} !</h6>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row row-cols-xxxl-3 row-cols-lg-3 row-cols-sm-2 row-cols-1 gy-4">
            <div class="col">
                <div class="card shadow-none border bg-gradient-start-1 h-80">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total Reservation</p>
                                <h6 class="mb-0">{{ number_format($totalReservations) }}</h6>
                            </div>
                            <div
                                class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="tabler:brand-booking" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card shadow-none border bg-gradient-start-2 h-80">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total Payments</p>
                                <h6 class="mb-0">LKR {{ number_format($totalPayments, 2) }}</h6>
                            </div>
                            <div
                                class="w-50-px h-50-px bg-purple rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="material-symbols:payments"
                                    class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card shadow-none border bg-gradient-start-3 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total Success Reservation</p>
                                <h6 class="mb-0">{{ number_format($totalSuccessReservations) }}</h6>
                            </div>
                            <div
                                class="w-50-px h-50-px bg-info rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="icon-park-outline:success"
                                    class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="row gy-4 mt-1">

            <div class="d-flex justify-content-end">
                <a href="{{ route('hotels') }}"
                    class="btn btn-primary-500  text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
                    <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                    Add Reservations
                </a>
            </div>

            <div class="col-xxl-12 col-xl-12">
                <div class="card h-100">
                    <div class="card-body p-24">

                        <div class="d-flex flex-wrap align-items-center gap-1 justify-content-between mb-16">
                            <ul class="nav border-gradient-tab nav-pills mb-0" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link d-flex align-items-center active" id="pills-to-do-list-tab"
                                        data-bs-toggle="pill" data-bs-target="#pills-to-do-list" type="button"
                                        role="tab" aria-controls="pills-to-do-list" aria-selected="true">
                                        My Reservation
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link d-flex align-items-center" id="pills-recent-leads-tab"
                                        data-bs-toggle="pill" data-bs-target="#pills-recent-leads" type="button"
                                        role="tab" aria-controls="pills-recent-leads" aria-selected="false"
                                        tabindex="-1">
                                        My Billing
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-to-do-list" role="tabpanel"
                                aria-labelledby="pills-to-do-list-tab" tabindex="0">
                                <div class="table-responsive scroll-sm">
                                    <table class="table striped-table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Confirmation Number</th>
                                                <th>Hotel</th>
                                                <th>Reservation Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($reservations as $reservation)
                                                @php
                                                    $statusClasses = [
                                                        'booked' =>
                                                            'bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm',
                                                        'checked_in' =>
                                                            ' bg-primary-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm badge ',
                                                        'checked_out' => 'badge bg-secondary',
                                                        'cancelled' =>
                                                            'bg-danger-focus text-warning-main px-24 py-4 rounded-pill fw-medium text-sm badge',
                                                        'no_show' =>
                                                            'bg-warning-focus text-warning-main px-24 py-4 rounded-pill fw-medium text-sm badge',
                                                        'completed' =>
                                                            'bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm',
                                                    ];
                                                @endphp

                                                <tr>
                                                    <td>{{ $reservation->confirmation_number }}</td>
                                                    <td>{{ $reservation->hotel->name ?? '-' }}</td>
                                                    <td>{{ $reservation->created_at->format('Y-m-d') }}</td>
                                                    <td>
                                                        @php
                                                            $status = $reservation->status;
                                                            $badgeClass = $statusClasses[$status] ?? 'badge bg-light';
                                                        @endphp
                                                        <span class="{{ $badgeClass }}">
                                                            {{ ucfirst($status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-wrap justify-content-center gap-2"
                                                            style="width: 60px;">
                                                            <div class="d-flex gap-2 justify-content-center w-200">
                                                                <a href="{{ route('view.reservations', ['id' => $reservation->confirmation_number]) }}"
                                                                    class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"
                                                                    title="View">
                                                                    <iconify-icon icon="mdi:eye-outline"></iconify-icon>
                                                                </a>
                                                                @if ($reservation->status == 'booked')
                                                                    <form
                                                                        action="{{ route('cancel.reservations', ['id' => $reservation->id]) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Are you sure?')">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"
                                                                            title="Delete">
                                                                            <iconify-icon
                                                                                icon="mdi:trash-can-outline"></iconify-icon>
                                                                        </button>
                                                                    </form>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No Reservations Found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-recent-leads" role="tabpanel"
                                aria-labelledby="pills-recent-leads-tab" tabindex="0">
                                <div class="table-responsive scroll-sm">
                                    <table class="table striped-table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Confirmation Number</th>
                                                <th>Extra Charges</th>
                                                <th>Discount</th>
                                                <th>Total Amount</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($latestBillings as $bill)
                                                <tr>
                                                    <td>{{ $bill->reservation->confirmation_number ?? '-' }}</td>
                                                    <td>LKR {{ number_format($bill->extra_charges, 2) }}</td>
                                                    <td>LKR {{ number_format($bill->discount, 2) }}</td>
                                                    <td>LKR {{ number_format($bill->total_amount, 2) }}</td>
                                                    <td>
                                                        @if ($bill->status == 'paid')
                                                            <span
                                                                class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Paid</span>
                                                        @else
                                                            <span
                                                                class="bg-danger-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Unpaid</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href=""
                                                            class="btn rounded-pill btn-info-100 text-info-600 radius-8 px-20 py-11">
                                                            <iconify-icon icon="lucide:download"></iconify-icon>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">No Billing Records Found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
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
        setTimeout(function() {
            let alert = document.getElementById('success-alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }
        }, 3000);
    </script>
@endsection
