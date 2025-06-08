@extends('layouts.admin.app')

@section('content')
    <div class="dashboard-main-body">


        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Hotel Occupancy & Financial Reports</h6>
        </div>

        <div class="row row-cols-xxxl-4 row-cols-lg-4 row-cols-sm-2 row-cols-1 gy-4">
            <div class="col">
                <div class="card shadow-none border bg-gradient-start-1 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Occupancy Today</p>
                                <h6 class="mb-0">{{ $occupiedRooms }}/{{ $totalRooms }} Rooms</h6>
                            </div>
                            <div
                                class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="mdi:hotel" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                        <p class="fw-medium text-sm text-primary-light mt-12 mb-0">Occupancy Rate:
                            {{ number_format($occupancyRate, 2) }}%</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card shadow-none border bg-gradient-start-2 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Projected Occupancy ({{ $futureDate }})</p>
                                <h6 class="mb-0">{{ $futureOccupiedRooms }}/{{ $totalRooms }} Rooms</h6>
                            </div>
                            <div
                                class="w-50-px h-50-px bg-purple rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="mdi:calendar-clock" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                        <p class="fw-medium text-sm text-primary-light mt-12 mb-0">Projected Rate:
                            {{ number_format($futureOccupancyRate, 2) }}%</p>
                    </div>
                </div>
            </div>

            <!-- Total Income -->
            <div class="col">
                <div class="card shadow-none border bg-gradient-start-4 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Room Revenue</p>
                                <h6 class="mb-0">LKR {{ number_format($roomRevenue, 2) }}</h6>
                            </div>
                            <div
                                class="w-50-px h-50-px bg-success-main rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="solar:wallet-bold" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                        <p class="fw-medium text-sm text-primary-light mt-12 mb-0">Filtered Period</p>
                    </div>
                </div>
            </div>

            <!-- Extra Services Revenue -->
            <div class="col col-md-3">
                <div class="card shadow-none border bg-gradient-start-5 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Extra Services Revenue</p>
                                <h6 class="mb-0">LKR {{ number_format($extraRevenue, 2) }}</h6>
                            </div>
                            <div
                                class="w-50-px h-50-px bg-warning rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="mdi:room-service" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                        <p class="fw-medium text-sm text-primary-light mt-12 mb-0">Filtered Period</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Bills Table -->
        <div class="card basic-data-table mt-5">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Latest Reservation</h5>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="filter-status" class="form-label">Status</label>
                        <select class="form-select filter-status" name="status">
                            <option value="">All</option>
                            <option value="booked">Booked</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="pending">Pending</option>
                            <option value="checked_in">Checked In</option>
                            <option value="checked_out">Checked Out</option>
                            <option value="no_show">No Show</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="filter-date" class="form-label">Reservation Date</label>
                        <input type="date" class="form-control filter-date" name="date">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button class="btn btn-primary w-100 filter-btn">Apply Filters</button>
                    </div>
                </div>

                <table id="latest-reservation-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Confirmation Number</th>
                            <th>Guest Email</th>
                            <th>Hotel</th>
                            <th>Check In Date</th>
                            <th>Check Out Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card basic-data-table mt-5">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Past Reservation</h5>
            </div>

            <div class="card-body">
                <table id="past-reservation-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Confirmation Number</th>
                            <th>Guest Email</th>
                            <th>Hotel</th>
                            <th>Check In Date</th>
                            <th>Check Out Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card basic-data-table mt-5">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">NoShow Reservation</h5>
            </div>

            <div class="card-body">
                <table id="noshow-reservation-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Confirmation Number</th>
                            <th>Guest Email</th>
                            <th>Hotel</th>
                            <th>Check In Date</th>
                            <th>Check Out Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <script>
        $('#past-reservation-table').DataTable({
            "processing": true,
            "serverSide": true,
            dom: '<"row mb-3"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 text-end"B>>' +
                '<"row"<"col-sm-12"tr>>' +
                '<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            buttons: [{
                    extend: 'copyHtml5',
                    className: 'w-50-px h-32-px bg-primary-light text-primary-600  d-inline-flex align-items-center justify-content-center',
                    text: '<iconify-icon icon="solar:copy-bold"></iconify-icon>'
                },
                {
                    extend: 'csvHtml5',
                    className: 'w-50-px h-32-px bg-primary-light text-success-600  d-inline-flex align-items-center justify-content-center',
                    text: '<iconify-icon icon="material-symbols:csv"></iconify-icon>'
                },
                {
                    extend: 'print',
                    className: 'w-50-px h-32-px bg-primary-light text-primary-600  d-inline-flex align-items-center justify-content-center',
                    text: '<iconify-icon icon="material-symbols:print"></iconify-icon>'
                }
            ],
            "ajax": {
                "url": "{{ route('admin.reports.past-reservation') }}",
                "type": "POST",
                "data": {
                    "_token": "{{ csrf_token() }}"
                },
            },
            "columns": [{
                    "data": "id",
                    "searchable": true,
                    "orderable": true
                },
                {
                    "data": "guest_email",
                    "searchable": true,
                    "orderable": true
                },
                {
                    "data": "hotel_name",
                    "searchable": true,
                    "orderable": true
                },
                {
                    "data": "check_in_date",
                    "searchable": true,
                    "orderable": true
                },
                {
                    "data": "check_out_date",
                    "searchable": true,
                    "orderable": true
                },
                {
                    "data": "status",
                    "searchable": true,
                    "orderable": true
                },
                {
                    "data": "action",
                    "searchable": false,
                    "orderable": false
                }
            ]
        });

        $('#latest-reservation-table').DataTable({
            processing: true,
            serverSide: true,
            dom: '<"row mb-3"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 text-end"B>>' +
                '<"row"<"col-sm-12"tr>>' +
                '<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            buttons: [{
                    extend: 'copyHtml5',
                    className: 'w-50-px h-32-px bg-primary-light text-primary-600 d-inline-flex align-items-center justify-content-center',
                    text: '<iconify-icon icon="solar:copy-bold"></iconify-icon>'
                },
                {
                    extend: 'csvHtml5',
                    className: 'w-50-px h-32-px bg-primary-light text-success-600 d-inline-flex align-items-center justify-content-center',
                    text: '<iconify-icon icon="material-symbols:csv"></iconify-icon>'
                },
                {
                    extend: 'print',
                    className: 'w-50-px h-32-px bg-primary-light text-primary-600 d-inline-flex align-items-center justify-content-center',
                    text: '<iconify-icon icon="material-symbols:print"></iconify-icon>'
                }
            ],
            ajax: {
                url: "{{ route('admin.reports.latest-reservation') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                    d.status = $('.filter-status').val();
                    d.date = $('.filter-date').val();
                }
            },
            columns: [{
                    data: "id",
                    searchable: true,
                    orderable: true
                },
                {
                    data: "guest_email",
                    searchable: true,
                    orderable: true
                },
                {
                    data: "hotel_name",
                    searchable: true,
                    orderable: true
                },
                {
                    data: "check_in_date",
                    searchable: true,
                    orderable: true
                },
                {
                    data: "check_out_date",
                    searchable: true,
                    orderable: true
                },
                {
                    data: "status",
                    searchable: true,
                    orderable: true
                },
                {
                    data: "action",
                    searchable: false,
                    orderable: false
                }
            ]
        });


        $('#noshow-reservation-table').DataTable({
            "processing": true,
            "serverSide": true,
            dom: '<"row mb-3"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 text-end"B>>' +
                '<"row"<"col-sm-12"tr>>' +
                '<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            buttons: [{
                    extend: 'copyHtml5',
                    className: 'w-50-px h-32-px bg-primary-light text-primary-600  d-inline-flex align-items-center justify-content-center',
                    text: '<iconify-icon icon="solar:copy-bold"></iconify-icon>'
                },
                {
                    extend: 'csvHtml5',
                    className: 'w-50-px h-32-px bg-primary-light text-success-600  d-inline-flex align-items-center justify-content-center',
                    text: '<iconify-icon icon="material-symbols:csv"></iconify-icon>'
                },
                {
                    extend: 'print',
                    className: 'w-50-px h-32-px bg-primary-light text-primary-600  d-inline-flex align-items-center justify-content-center',
                    text: '<iconify-icon icon="material-symbols:print"></iconify-icon>'
                }
            ],
            "ajax": {
                "url": "{{ route('admin.reports.noshow-reservation') }}",
                "type": "POST",
                "data": {
                    "_token": "{{ csrf_token() }}"
                },
            },
            "columns": [{
                    "data": "id",
                    "searchable": true,
                    "orderable": true
                },
                {
                    "data": "guest_email",
                    "searchable": true,
                    "orderable": true
                },
                {
                    "data": "hotel_name",
                    "searchable": true,
                    "orderable": true
                },
                {
                    "data": "check_in_date",
                    "searchable": true,
                    "orderable": true
                },
                {
                    "data": "check_out_date",
                    "searchable": true,
                    "orderable": true
                },
                {
                    "data": "status",
                    "searchable": true,
                    "orderable": true
                },
                {
                    "data": "action",
                    "searchable": false,
                    "orderable": false
                }
            ]
        });
    </script>

    <script>
        $('.filter-btn').on('click', function() {
            $('#latest-reservation-table').DataTable().ajax.reload();
        });
    </script>
@endsection
