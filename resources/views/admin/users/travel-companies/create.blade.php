@extends('layouts.admin.app')

@section('content')
    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Form Validation</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Form Validation</li>
            </ul>
        </div>

        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Input Status</h5>
                    </div>
                    <div class="card-body">
                        <form class="row gy-3 needs-validation" novalidate>
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <div class="icon-field has-validation">
                                    <span class="icon">
                                        <iconify-icon icon="f7:person"></iconify-icon>
                                    </span>
                                    <input type="text" name="#0" class="form-control" placeholder="Enter First Name"
                                        required>
                                    <div class="invalid-feedback">
                                        Please provide first name
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <div class="icon-field has-validation">
                                    <span class="icon">
                                        <iconify-icon icon="f7:person"></iconify-icon>
                                    </span>
                                    <input type="text" name="#0" class="form-control" placeholder="Enter Last Name"
                                        required>
                                    <div class="invalid-feedback">
                                        Please provide last name
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <div class="icon-field has-validation">
                                    <span class="icon">
                                        <iconify-icon icon="mage:email"></iconify-icon>
                                    </span>
                                    <input type="email" name="#0" class="form-control" placeholder="Enter Email"
                                        required>
                                    <div class="invalid-feedback">
                                        Please provide email address
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <div class="icon-field has-validation">
                                    <span class="icon">
                                        <iconify-icon icon="solar:phone-calling-linear"></iconify-icon>
                                    </span>
                                    <input type="text" name="#0" class="form-control"
                                        placeholder="+1 (555) 000-0000" required>
                                    <div class="invalid-feedback">
                                        Please provide phone number
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <div class="icon-field has-validation">
                                    <span class="icon">
                                        <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                                    </span>
                                    <input type="password" name="#0" class="form-control" placeholder="*******"
                                        required>
                                    <div class="invalid-feedback">
                                        Please provide password
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirm Password</label>
                                <div class="icon-field has-validation">
                                    <span class="icon">
                                        <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                                    </span>
                                    <input type="password" name="#0" class="form-control" placeholder="*******"
                                        required>
                                    <div class="invalid-feedback">
                                        Please confirm password
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary-600" type="submit">Submit form</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
