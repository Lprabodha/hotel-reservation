@extends('layouts.admin.app')

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Financial Reports</h6>

            <form method="GET" action="{{ route('admin.reports.index') }}" class="d-flex align-items-center gap-2">
                <select name="filter" class="form-select" onchange="this.form.submit()">
                    <option value="30" {{ request('filter') == 30 ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="7" {{ request('filter') == 7 ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="1" {{ request('filter') == 1 ? 'selected' : '' }}>Today</option>
                </select>
            </form>
        </div>

        <!-- Payment Bills Table -->
        <div class="card basic-data-table mt-5">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Bills</h5>
            </div>

            <div class="card-body">
                <table id="bill-table" class="table table-bordered table-striped">
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

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>


    <script>
        $('#bill-table').DataTable({
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
                "url": "<?= route('admin.reports.bill') ?>",
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

            ],
        });
    </script>
@endsection
