@extends('layouts.admin.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Manage Travel Companies</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Travel Companies
                    </a>
                </li>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Travel Companies</h5>
                <div class="ms-auto">
                    <a href="{{ route('admin.travel-companies.create') }}"
                        class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
                        <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                        Add Travel Companies
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table id="user-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
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

    <!--  Change User Roles -->
    <div class="modal fade" id="changeRole" tabindex="-1" aria-labelledby="changeRoleLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title fs-5" id="changeRoleLabel">Change User Role</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form action="#">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <input type="hidden" id="edit_id">

                        <div class="row">
                            <div class="col-12 mb-20">
                                <label for="country" class="form-label fw-semibold text-primary-light text-sm mb-8">Role *
                                </label>
                                <select class="form-control radius-8 form-select" name="role_id" id="role_id">
                                    <option selected disabled>Select Role</option>
                                    @foreach (DB::table('roles')->get() as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="role_id_error"></span>
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-1 mt-10">
                                <button type="button" onclick="changeRole()"
                                    class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8">
                                    Change Role
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $('#user-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?= route('admin.travel-companies.show') ?>",
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
                    "data": "name",
                    "searchable": true,
                    "orderable": true
                },
                {
                    "data": "email",
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
                    "orderable": true
                },

            ]

        });
    </script>

    <script>
        var changeRoleModal = document.getElementById('changeRole')
        changeRoleModal.addEventListener('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var data = jQuery.parseJSON(atob(button.data('data')));

            $('#edit_id').val(data.id);
            $('#role_id').val(data.roles[0]['id']);

        })

        function changeRole() {
            var id = $('#edit_id').val();
            var role_id = $('#role_id').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "<?= route('admin.users.role.change') ?>",
                type: 'POST',
                data: {
                    id: id,
                    role_id: role_id,

                },
                success: function(response) {
                    const toastMagic = new ToastMagic();
                    toastMagic.success("Success!", "Your data has been saved!");
                    location.reload();
                },
                error: function(response) {
                    if (response.status == 422) {
                        $('#role_id_error').text(response.responseJSON.errors.role);
                    }
                }
            });

        }

        function deleteUser(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this User!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= route('admin.users.delete') ?>",
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
@endsection
