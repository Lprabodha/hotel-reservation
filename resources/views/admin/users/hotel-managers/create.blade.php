@extends('layouts.admin.app')

@section('content')
    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Create Hotel Managers</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Create Hotel Managers</li>
            </ul>
        </div>

        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Create Hotel Managers</h5>
                    </div>

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card-body">
                        <form class="row gy-3" action="{{ route('admin.managers.store') }}" method="POST">
                            @csrf

                            {{-- Name --}}
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <div class="icon-field">
                                    <span class="icon">
                                        <iconify-icon icon="mdi:account" class="text-lg"></iconify-icon>
                                    </span>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror" placeholder="Enter Name"
                                        value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <div class="icon-field">
                                    <span class="icon">
                                        <iconify-icon icon="ic:baseline-email" class="text-lg"></iconify-icon>
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

                            {{-- Hotel --}}
                            <div class="col-md-12">
                                <label class="form-label">Hotel <span class="text-danger">*</span></label>
                                <div class="icon-field">
                                    <span class="icon">
                                        <iconify-icon icon="mdi:hotel" class="text-lg"></iconify-icon>
                                    </span>
                                    <select name="hotel_id" class="form-control @error('hotel_id') is-invalid @enderror">
                                        <option value="" selected disabled>Select Hotel</option>
                                        @foreach (DB::table('hotels')->where('active', 1)->whereNull('deleted_at')->get() as $hotel)
                                            <option value="{{ $hotel->id }}"
                                                {{ old('hotel_id') == $hotel->id ? 'selected' : '' }}>
                                                {{ $hotel->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('hotel_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="col-md-12">
                                <button class="btn btn-primary-600" type="submit">Save Hotel Manager</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
