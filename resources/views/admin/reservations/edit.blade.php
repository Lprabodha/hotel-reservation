@extends('layouts.admin.app')

@section('content')
    <div class="dashboard-main-body">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Reservation - {{ $hotel->name }}</h5>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>There were some problems with your input:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.reservation.update', $reservation->id) }}" method="POST"
                    class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="id" value="{{ $reservation->id }}">
                    <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                    <input type="hidden" name="status" value="{{ $reservation->status }}">

                    <ul class="nav nav-pills mb-4" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#step1" type="button">1.
                                Select Rooms</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#step2" type="button">2.
                                Customer Info</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#step3" type="button">3.
                                Confirm</button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Step 1 -->
                        <div class="tab-pane fade show active" id="step1">
                            <div class="row gy-3">
                                <div class="col-md-4">
                                    <label class="form-label">Check-In</label>
                                    <input type="date" name="checkin" id="checkin"
                                        class="form-control @error('checkin') is-invalid @enderror"
                                        value="{{ old('checkin', \Carbon\Carbon::parse($reservation->check_in_date)->format('Y-m-d')) }}"
                                        required>
                                    @error('checkin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Check-Out</label>
                                    <input type="date" name="checkout" id="checkout"
                                        class="form-control @error('checkout') is-invalid @enderror"
                                        value="{{ old('checkout', \Carbon\Carbon::parse($reservation->check_out_date)->format('Y-m-d')) }}"
                                        required>
                                    @error('checkout')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Guests</label>
                                    <input type="number" name="guests" id="guests" min="1"
                                        class="form-control @error('guests') is-invalid @enderror"
                                        value="{{ old('guests', $reservation->guests) }}" required>
                                    @error('guests')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @if ($reservation->status === 'checkin')
                                    <div class="col-md-6">
                                        <div class="form-check mt-4">
                                            <input class="form-check-input" type="checkbox" name="add_one_night"
                                                value="1">
                                            <label class="form-check-label">Add One Extra Night (Current Check-Out:
                                                {{ $reservation->check_out_date->format('Y-m-d') }})</label>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-12">
                                    <div id="filterError" class="alert alert-danger d-none text-center small"></div>
                                </div>
                                <div class="col-12 mt-2">
                                    <button type="button" id="filterHotel" class="btn btn-outline-primary w-100">Check Room
                                        Availability</button>
                                </div>
                            </div>

                            <div class="row mt-4" id="roomList">
                                @foreach ($hotel->rooms as $room)
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rooms[]"
                                                        value="{{ $room->id }}" id="room{{ $room->id }}"
                                                        {{ in_array($room->id, old('rooms', $reservation->rooms->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="room{{ $room->id }}">
                                                        <strong>{{ $room->room_type }}</strong> - Room
                                                        #{{ $room->room_number }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('rooms')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Step 2 -->
                        <div class="tab-pane fade" id="step2">
                            <div class="row gy-3">
                                <div class="col-md-6">
                                    <label class="form-label">Special Requests</label>
                                    <textarea name="special_requests" class="form-control">{{ old('special_requests', $reservation->special_requests) }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Card Number</label>
                                    <input type="text" name="card_number" class="form-control"
                                        value="{{ old('card_number') }}" pattern="\d{16}" title="Must be 16 digits">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Card Expiration (MM/YY)</label>
                                    <input type="text" name="card_expire_date" class="form-control"
                                        value="{{ old('card_expire_date') }}" pattern="^(0[1-9]|1[0-2])\/?([0-9]{2})$"
                                        title="Format MM/YY">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">CVV</label>
                                    <input type="text" name="csv" class="form-control"
                                        value="{{ old('csv') }}" pattern="\d{3}" title="Must be 3 digits">
                                </div>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="tab-pane fade" id="step3">
                            <div class="text-center mb-4">
                                <h6 class="text-success">Review and Submit</h6>
                                <p class="text-muted">Please verify all fields before submission.</p>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-success">Update Reservation</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        $('#filterHotel').click(function() {
            const checkin = $('#checkin').val();
            const checkout = $('#checkout').val();
            const guests = $('#guests').val();
            const errorDiv = $('#filterError');

            errorDiv.addClass('d-none').text('');

            if (!checkin || !checkout || !guests) {
                errorDiv.removeClass('d-none').text('❌ Please fill in all fields before filtering!');
                return;
            }

            if (checkin >= checkout) {
                errorDiv.removeClass('d-none').text('❌ Check-Out Date must be after Check-In Date!');
                return;
            }

            $.ajax({
                url: '{{ route('admin.room-filter') }}',
                type: 'GET',
                data: {
                    checkin,
                    checkout,
                    guests
                },
                success: function(response) {
                    $('#roomList').html(response.html);
                },
                error: function() {
                    errorDiv.removeClass('d-none').text(
                        '❌ Something went wrong! Please try again.');
                }
            });
        });
    </script>
@endsection
