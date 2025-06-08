@extends('layouts.admin.app')

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Reservation Request</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Reservation Request</li>
            </ul>
        </div>

        <div class="card">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('store.request.reservations') }}" method="POST">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-6">
                                    <label class="form-label">Check in date</label>
                                    <input type="date" name="check_in_date" class="form-control" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Check out date</label>
                                    <input type="date" name="check_out_date" class="form-control" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" cols="30" rows="2"></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary-600">Submit Request</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
