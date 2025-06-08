@extends('layouts.admin.app')

@section('content')
    @php
        $today = date('Y-m-d');
    @endphp

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
                                <!-- Hotel Selection -->
                                <div class="col-md-6">
                                    <label class="form-label">Select Hotel</label>
                                    <select name="hotel_id" id="hotelSelect" class="form-select" required>
                                        <option value="">-- Select a Hotel --</option>
                                        @foreach ($hotels as $hotel)
                                            <option value="{{ $hotel->id }}" data-location="{{ $hotel->location }}">
                                                {{ $hotel->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Location Auto-fill -->
                                <div class="col-md-6">
                                    <label class="form-label">Hotel Location</label>
                                    <input type="text" id="locationDisplay" class="form-control" readonly>
                                </div>

                                <!-- Check-in Date -->
                                <div class="col-md-6">
                                    <label class="form-label">Check-in Date</label>
                                    <input type="date" name="check_in_date" class="form-control" required
                                        min="{{ $today }}">
                                </div>

                                <!-- Check-out Date -->
                                <div class="col-md-6">
                                    <label class="form-label">Check-out Date</label>
                                    <input type="date" name="check_out_date" class="form-control" required
                                        min="{{ $today }}">
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="2"></textarea>
                                </div>

                                <!-- Submit Button -->
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hotelSelect = document.getElementById('hotelSelect');
            const locationDisplay = document.getElementById('locationDisplay');

            function updateLocation() {
                const selectedOption = hotelSelect.options[hotelSelect.selectedIndex];
                const location = selectedOption?.getAttribute('data-location') || '';
                locationDisplay.value = location;
            }

            if (hotelSelect && locationDisplay) {
                hotelSelect.addEventListener('change', updateLocation);

                // On page load, update location if hotel already selected
                updateLocation();
            }
        });
    </script>
@endsection
