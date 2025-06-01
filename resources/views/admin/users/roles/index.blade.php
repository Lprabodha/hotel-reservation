@extends('layouts.admin.app')

@section('content')

    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Manage Users Roles</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Users Roles
                    </a>
                </li>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Roles</h5>
                <div class="ms-auto">
                    <button type="button" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                        Add Role
                    </button>
                </div>
            </div>

            <div class="card-body">
                <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                    <thead>
                        <tr>
                            <th scope="col">
                                <div class="form-check style-check d-flex align-items-center">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">
                                        ID
                                    </label>
                                </div>
                            </th>
                            <th scope="col">Name</th>
                            <th scope="col">Roles</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="form-check style-check d-flex align-items-center">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">
                                        01
                                    </label>
                                </div>
                            </td>
                            <td><a href="javascript:void(0)" class="text-primary-600">#526534</a></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="assets/images/user-list/user-list1.png" alt=""
                                        class="flex-shrink-0 me-12 radius-8">
                                    <h6 class="text-md mb-0 fw-medium flex-grow-1">Kathryn Murphy</h6>
                                </div>
                            </td>
                            <td>
                                <a href="javascript:void(0)"
                                    class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                </a>
                                <a href="javascript:void(0)"
                                    class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                </a>
                                <a href="javascript:void(0)"
                                    class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        $('#dataTable').DataTable({
            pageLength: 10,
        });
    </script>
@endsection
