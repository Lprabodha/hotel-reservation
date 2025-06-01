@extends('layouts.admin.app')

@section('content')
    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Create Travel Companies</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Create Travel Companies</li>
            </ul>
        </div>

        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Create Travel Companies</h5>
                    </div>
                    <div class="card-body">
                        <form class="row gy-3" action="{{ route('admin.travel-companies.store') }}" method="POST">
                            @csrf
                            <div class="col-md-6">
                                <label class="form-label">Company Name</span></label>
                                <div class="icon-field">
                                    <span class="icon">
                                        <iconify-icon icon="f7:house-alt-fill"></iconify-icon>
                                    </span>
                                    <input type="text" name="company_name"
                                        class="form-control @error('company_name') is-invalid @enderror"
                                        placeholder="Enter Company Name" value="{{ old('company_name') }}">
                                    @error('company_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email  <span class="text-danger">*</span></label>
                                <div class="icon-field">
                                    <span class="icon">
                                        <iconify-icon icon="mage:email"></iconify-icon>
                                    </span>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email"
                                        value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <div class="icon-field">
                                    <span class="icon">
                                        <iconify-icon icon="solar:phone-calling-linear"></iconify-icon>
                                    </span>
                                    <input type="text" name="contact_number"
                                        class="form-control @error('contact_number') is-invalid @enderror"
                                        placeholder="+1 (555) 000-0000" value="{{ old('contact_number') }}">
                                    @error('contact_number')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Address</label>
                                <div class="icon-field">
                                    <span class="icon">
                                        <iconify-icon icon="f7:map"></iconify-icon>
                                    </span>
                                    <input type="text" name="address"
                                        class="form-control @error('address') is-invalid @enderror"
                                        placeholder="Enter Company address" value="{{ old('address') }}">
                                    @error('address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary-600" type="submit">Save Company</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
