@extends('layouts.admin.app')

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Payments</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.hotel-clerks.create') }}"
                        class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Payments
                    </a>
                </li>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Payments</h5>
            </div>

            <div class="card-body">
                <table id="payment-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Confirmation Number</th>
                            <th>Extra charges</th>
                            <th>Discount</th>
                            <th>Total amount</th>
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
    <script>
        $('#payment-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?= route('admin.payments.show') ?>",
                "type": "POST",
                "data": {
                    "_token": "{{ csrf_token() }}"
                },
            },
            "columns": [{
                    "data": "id",
                    "searchable": true,
                    "orderable": false
                },
                {
                    "data": "confirmation_number",
                    "searchable": true,
                    "orderable": true
                },
                {
                    "data": "extra_charges",
                    "searchable": true,
                    "orderable": true
                },
                {
                    "data": "discount",
                    "searchable": true,
                    "orderable": true
                },
                {
                    "data": "total_amount",
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
                    "searchable": true,
                    "orderable": true
                }

            ]

        });
    </script>
@endsection
