@extends('layouts.admin.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <div class="dashboard-main-body">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Manage Reservations</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.hotel-clerks.create') }}"
                        class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Reservations
                    </a>
                </li>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Reservations</h5>
                @if (auth()->user()->hasRole('hotel-clerk'))
                    <div class="ms-auto">
                        <a href="{{ route('admin.hotel-clerks.create') }}"
                            class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
                            <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                            Add Reservations
                        </a>
                    </div>
                @endif
            </div>

            <div class="card-body">
                <table id="reservation-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Guest Email</th>
                            <th>Hotel</th>
                            <th>Room</th>
                            <th>Type</th>
                            <th>Reservation Date</th>
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

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $('#reservation-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('admin.reservation.show') }}",
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
                    "data": "room_number",
                    "searchable": true,
                    "orderable": true
                },
                {
                    "data": "reservation_date",
                    "searchable": true,
                    "orderable": true
                },
                {
                    "data": "type",
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
        function deleteUser(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this Hotel Clerks!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= route('admin.hotel-clerks.destroy') ?>",
                        type: 'POST',
                        data: {
                            id: id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire('Deleted!', response.success, 'success')
                                .then(() => location.reload());
                        },
                        error: function(response) {
                            Swal.fire({
                                title: "Error",
                                text: response.responseText,
                                icon: "error",
                            });
                        }
                    });
                }
            });
        }
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
