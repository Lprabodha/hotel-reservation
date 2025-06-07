@extends('layouts.admin.app')

@section('content')
    <div class="dashboard-main-body">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Reservation - {{ $hotel->name }}</h5>
            </div>
            <div class="card-body">
                <div class="form-wizard">
                    <form action="{{ route('admin.reservation.update', $reservation->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-wizard-header overflow-x-auto scroll-sm pb-4 mb-4">
                            <ul class="list-unstyled form-wizard-list d-flex gap-3">
                                <li class="form-wizard-list__item active">
                                    <div class="form-wizard-list__line">
                                        <span class="count">1</span>
                                    </div>
                                    <span class="text text-xs fw-semibold">Select Rooms</span>
                                </li>
                                <li class="form-wizard-list__item">
                                    <div class="form-wizard-list__line">
                                        <span class="count">2</span>
                                    </div>
                                    <span class="text text-xs fw-semibold">Customer Info</span>
                                </li>
                                <li class="form-wizard-list__item">
                                    <div class="form-wizard-list__line">
                                        <span class="count">3</span>
                                    </div>
                                    <span class="text text-xs fw-semibold">Confirm</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Step 1 -->
                        <fieldset class="wizard-fieldset show">
                            <div class="row gy-3">
                                <div class="col-md-4">
                                    <label for="checkin" class="form-label">Check-In</label>
                                    <input type="date" id="checkin" name="checkin" class="form-control"
                                        value="{{ old('checkin', \Carbon\Carbon::parse($reservation->check_in_date)->format('Y-m-d')) }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="checkout" class="form-label">Check-Out</label>
                                    <input type="date" id="checkout" name="checkout" class="form-control"
                                        value="{{ old('checkout', \Carbon\Carbon::parse($reservation->check_out_date)->format('Y-m-d')) }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="guests" class="form-label">Guests</label>
                                    <input type="number" id="guests" name="guests" class="form-control"
                                        value="{{ old('guests', $reservation->guests) }}" min="1">
                                </div>
                                @if ($reservation->status === 'checkin')
                                    <div class="col-md-6">
                                        <label class="form-label">Extend Stay</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="add_one_night"
                                                id="addOneNight" value="1">
                                            <label class="form-check-label" for="addOneNight">
                                                Add One Extra Night (Current Check-Out:
                                                {{ \Carbon\Carbon::parse($reservation->check_out_date)->format('Y-m-d') }})
                                            </label>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-12 mt-2">
                                    <div id="filterError" class="alert alert-danger d-none text-center small"
                                        role="alert"></div>
                                </div>
                                <div class="col-12 mt-3">
                                    <button type="button" id="filterHotel" class="btn btn-outline-primary w-100">Check Room
                                        Availability</button>
                                </div>
                            </div>
                            <div class="row mt-4" id="roomList">
                                @foreach ($hotel->rooms as $room)
                                    <div class="col-md-4">
                                        <div class="card position-relative">
                                            <input class="form-check-input room-checkbox" type="checkbox" name="rooms[]"
                                                value="{{ $room->id }}"
                                                {{ in_array($room->id, $reservation->rooms->pluck('id')->toArray()) ? 'checked' : '' }}>
                                            <div class="card-body">
                                                <h6>{{ $room->room_type }}</h6>
                                                <p class="mb-0">Room #: {{ $room->room_number }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="text-end mt-4">
                                <button type="button" class="form-wizard-next-btn btn btn-primary">Next</button>
                            </div>
                        </fieldset>

                        <!-- Step 2 -->
                        <fieldset class="wizard-fieldset">
                            <div class="row gy-3">
                                <div class="col-md-6">
                                    <label class="form-label">Special Requests</label>
                                    <textarea name="special_requests" class="form-control" rows="3">{{ old('special_requests', $reservation->special_requests) }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Card Number</label>
                                    <input type="text" name="card_number" class="form-control"
                                        value="{{ old('card_number') }}" placeholder="Enter card number">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Card Expiration</label>
                                    <input type="text" name="card_expire_date" class="form-control"
                                        value="{{ old('card_expire_date') }}" placeholder="MM/YY">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">CVV</label>
                                    <input type="text" name="csv" class="form-control"
                                        value="{{ old('csv') }}" placeholder="CVV">
                                </div>
                            </div>
                            <div class="form-group d-flex justify-content-between mt-4">
                                <button type="button" class="form-wizard-previous-btn btn btn-secondary">Back</button>
                                <button type="button" class="form-wizard-next-btn btn btn-primary">Next</button>
                            </div>
                        </fieldset>

                        <!-- Step 3 -->
                        <fieldset class="wizard-fieldset">
                            <div class="text-center mb-4">
                                <h6 class="text-success">Review and Submit</h6>
                                <p class="text-muted">Make sure all data is correct before submission.</p>
                            </div>
                            <div class="text-end">
                                <button type="button" class="form-wizard-previous-btn btn btn-secondary">Back</button>
                                <button type="submit" class="form-wizard-submit btn btn-success">Update
                                    Reservation</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .room-checkbox {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
        }

        .card {
            position: relative;
        }

        .wizard-fieldset {
            display: none;
        }

        .wizard-fieldset.show {
            display: block;
        }

        #filterError {
            font-size: 0.85rem;
            padding: 10px;
            margin-top: 15px;
        }

        #filterError2 {
            font-size: 0.85rem;
            padding: 10px;
            margin-top: 15px;
        }

        .select2-container--bootstrap4 .select2-selection--single {
            height: calc(2.5rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            background-color: #fff;
            width: 100%;
        }

        .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
            line-height: 2.2rem;
            padding-left: 0;
        }

        .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
            height: calc(2.5rem + 2px);
            top: 0;
            right: 10px;
        }

        .form-wizard-list__item {
            width: 33.3% !important;
        }
    </style>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            $('#filterHotel').on('click', function() {
                let checkin = $('#checkin').val();
                let checkout = $('#checkout').val();
                let guests = $('#guests').val();
                let errorDiv = $('#filterError');

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
                        checkin: checkin,
                        checkout: checkout,
                        guests: guests
                    },
                    success: function(response) {
                        errorDiv.addClass('d-none').text('');
                        if (response.html.trim() === '') {
                            $('#roomList').html(
                                '<div class="alert alert-warning">No rooms available for your selection.</div>'
                                );
                        } else {
                            $('#roomList').html(response.html);
                        }
                    },
                    error: function(xhr) {
                        errorDiv.removeClass('d-none').text(
                            '❌ Something went wrong! Please try again.');
                    }
                });
            });

            $('.form-wizard-next-btn').on('click', function() {
                const currentFieldset = $(this).closest('fieldset');
                const nextFieldset = currentFieldset.next('fieldset');
                currentFieldset.removeClass('show');
                nextFieldset.addClass('show');
                updateProgressBar(nextFieldset.index());
            });

            $('.form-wizard-previous-btn').on('click', function() {
                const currentFieldset = $(this).closest('fieldset');
                const prevFieldset = currentFieldset.prev('fieldset');
                currentFieldset.removeClass('show');
                prevFieldset.addClass('show');
                updateProgressBar(prevFieldset.index());
            });

            function updateProgressBar(index) {
                $('.form-wizard-list__item').removeClass('active');
                $('.form-wizard-list__item').eq(index).addClass('active');
            }
        });
    </script>
@endsection
