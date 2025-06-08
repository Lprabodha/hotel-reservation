@extends('layouts.admin.app')

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Dashboard</h6>

            @if (!auth()->user()->hasRole('hotel-clerk'))
                <ul class="d-flex align-items-center gap-2">
                    <li class="fw-medium">
                        <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                            Dashboard
                        </a>
                    </li>
                    <li></li>
                    <li class="fw-medium"></li>
                </ul>
            @endif

            @if (auth()->user()->hasRole('hotel-clerk'))
                <div class="ms-auto m-2">
                    <a href="{{ route('admin.reservation.create') }}"
                        class="btn btn-primary d-flex align-items-center gap-2">
                        <i class="bi bi-plus-lg"></i> + New Reservation
                    </a>
                </div>
            @endif
        </div>

        <div class="d-flex flex-wrap gap-3">
            <div class="col">
                <div class="card shadow-none border bg-gradient-start-1 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total Users</p>
                                <h6 class="mb-0">{{ $users->count() }}</h6>
                            </div>
                            <div
                                class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="gridicons:multiple-users"
                                    class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                        <p class="fw-medium text-sm text-primary-light mt-12 mb-0 d-flex align-items-center gap-2">
                            <span class="d-inline-flex align-items-center gap-1 text-success-main"><iconify-icon
                                    icon="bxs:up-arrow" class="text-xs"></iconify-icon> +{{ $users->count() }}</span>
                            Last 30 days users
                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-none border bg-gradient-start-2 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total Reservations</p>
                                <h6 class="mb-0">{{ $reservations->count() }}</h6>
                            </div>
                            <div
                                class="w-50-px h-50-px bg-purple rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="fa-solid:award" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                        <p class="fw-medium text-sm text-primary-light mt-12 mb-0 d-flex align-items-center gap-2">
                            <span class="d-inline-flex align-items-center gap-1 text-success-main"><iconify-icon
                                    icon="bxs:up-arrow" class="text-xs"></iconify-icon> +{{ $reservations->count() }}</span>
                            Last 30 days reservations
                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-none border bg-gradient-start-4 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total Income</p>
                                <h6 class="mb-0">Rs{{ $reservations->sum('total_price') }}</h6>
                            </div>
                            <div
                                class="w-50-px h-50-px bg-success-main rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="solar:wallet-bold" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                        <p class="fw-medium text-sm text-primary-light mt-12 mb-0 d-flex align-items-center gap-2">
                            <span class="d-inline-flex align-items-center gap-1 text-success-main"><iconify-icon
                                    icon="bxs:up-arrow" class="text-xs"></iconify-icon>
                                +Rs{{ $reservations->sum('total_price') }}</span>
                            Last 30 days income
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <div class="row gy-1 mt-2">
            <div class="col-xxl-12 col-lg-8">
                <div class="card h-100 p-0">
                    <div class="card-body p-24">
                        <div id='wrap'>
                            <div id='reservation-calendar'></div>
                            <div style='clear:both'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-4 mt-1">

            <div class="col-xxl-12 col-xl-12">
                <div class="card h-100">
                    <div class="card-body p-24">

                        <div class="d-flex flex-wrap align-items-center gap-1 justify-content-between mb-16">
                            <ul class="nav border-gradient-tab nav-pills mb-0" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link d-flex align-items-center active" id="pills-to-do-list-tab"
                                        data-bs-toggle="pill" data-bs-target="#pills-to-do-list" type="button"
                                        role="tab" aria-controls="pills-to-do-list" aria-selected="true">
                                        Latest Customers
                                        <span
                                            class="text-sm fw-semibold py-6 px-12 bg-neutral-500 rounded-pill text-white line-height-1 ms-12 notification-alert">{{ $customers->count() }}</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link d-flex align-items-center" id="pills-recent-leads-tab"
                                        data-bs-toggle="pill" data-bs-target="#pills-recent-leads" type="button"
                                        role="tab" aria-controls="pills-recent-leads" aria-selected="false"
                                        tabindex="-1">
                                        Latest Reservations
                                        <span
                                            class="text-sm fw-semibold py-6 px-12 bg-neutral-500 rounded-pill text-white line-height-1 ms-12 notification-alert">{{ $reservations->count() }}</span>
                                    </button>
                                </li>
                            </ul>
                            <a href="javascript:void(0)"
                                class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
                                View All
                                <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
                            </a>
                        </div>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-to-do-list" role="tabpanel"
                                aria-labelledby="pills-to-do-list-tab" tabindex="0">
                                <div class="table-responsive scroll-sm">
                                    <table class="table bordered-table sm-table mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">Customer ID</th>
                                                <th scope="col">Customer Details</th>
                                                <th scope="col">Registered On</th>
                                                <th scope="col" class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($customers as $customer)
                                                <tr>
                                                    <td>{{ $customer->id }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div
                                                                class="w-50-px h-50-px bg-warning rounded-circle d-flex justify-content-center align-items-center">
                                                                <iconify-icon icon="raphael:customer"
                                                                    class="text-2xl mb-0"></iconify-icon>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="text-md mb-0 fw-medium">{{ $customer->name }}
                                                                </h6>
                                                                <span
                                                                    class="text-sm text-secondary-light fw-medium">{{ $customer->email }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $customer->created_at->format('F j, Y') }}</td>
                                                    <td class="text-center">
                                                        <span
                                                            class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Active</span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>No Customers Registered yet</tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-recent-leads" role="tabpanel"
                                aria-labelledby="pills-recent-leads-tab" tabindex="0">
                                <div class="table-responsive scroll-sm">
                                    <table class="table bordered-table sm-table mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">Reservation ID </th>
                                                <th scope="col">CheckIn Date</th>
                                                <th scope="col">CheckOut Date</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">Number of Guests</th>
                                                <th scope="col" class="text-center">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($reservations as $reservation)
                                                <tr>
                                                    <td>{{ $reservation->confirmation_number }}</td>
                                                    <td>{{ $reservation->check_in_date }}</td>
                                                    <td>{{ $reservation->check_out_date }}</td>
                                                    <td class="text-center">
                                                        <span
                                                            class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">{{ $reservation->status }}</span>
                                                    </td>
                                                    <td>{{ $reservation->number_of_guests }}</td>
                                                    <td>{{ $reservation->total_price }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <div>No reservations found</div>
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
    <script src="/assets/js/admin/lib/apexcharts.min.js"></script>
    @vite(['resources/js/admin/homeOneChart.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


    <script>
        $(document).ready(function() {
            var reservations = @json($reservations);

            if ($('#reservation-calendar').fullCalendar('getCalendar')) {
                $('#reservation-calendar').fullCalendar('destroy');
            }

            var calendar = $('#reservation-calendar').fullCalendar({
                header: {
                    left: 'title',
                    center: 'agendaDay,agendaWeek,month',
                    right: 'prev,next today'
                },
                editable: true,
                firstDay: 1,
                selectable: true,
                defaultView: 'month',
                axisFormat: 'h:mm',
                columnFormat: {
                    month: 'ddd',
                    week: 'ddd d',
                    day: 'dddd M/d',
                    agendaDay: 'dddd d'
                },
                titleFormat: {
                    month: 'MMMM yyyy',
                    week: "MMMM yyyy",
                    day: 'MMMM yyyy'
                },
                allDaySlot: false,
                selectHelper: true,
                dayClick: function(date, allDay, jsEvent, view) {
                    if (allDay) {
                        calendar.fullCalendar('changeView', 'agendaDay')
                            .fullCalendar('gotoDate', date.getFullYear(), date.getMonth(), date
                                .getDate());
                    }
                },
                events: reservations.map(function(reservation) {
                    let color = '';
                    switch (reservation.status) {
                        case 'booked':
                            color = '#3b82f6';
                            break;
                        case 'checked_in':
                            color = '#6366f1';
                            break;
                        case 'checked_out':
                            color = '#22c55e';
                            break;
                        case 'cancelled':
                            color = '#ef4444';
                            break;
                        case 'no_show':
                            color = '#facc15';
                            break;
                        case 'pending':
                        default:
                            color = '#9ca3af';
                            break;
                    }

                    return {
                        id: reservation.id,
                        title: reservation.confirmation_number + ' (' + reservation.status.replace(
                            '_', ' ') + ')',
                        start: reservation.check_in_date,
                        end: reservation.check_out_date,
                        backgroundColor: color,
                        borderColor: color,
                        textColor: '#fff'
                    };
                })
            });
        });
    </script>

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
