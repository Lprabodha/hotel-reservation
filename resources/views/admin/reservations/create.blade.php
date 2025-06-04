@extends('layouts.admin.app')

@section('content')
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

        <style>.select2-container--bootstrap4 .select2-selection--single {
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
    </style>

    </style>

    <div class="dashboard-main-body">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Add New Reservation - {{ $hotel->name }} - Hotel</h5>
            </div>
            <div class="card-body">
                <div class="form-wizard">
                    <form action="{{ route('admin.reservation.store') }}" method="POST">
                        @csrf
                        <div class="form-wizard-header overflow-x-auto scroll-sm pb-8 my-32">
                            <ul class="list-unstyled form-wizard-list d-flex gap-4">
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
                                    <span class="text text-xs fw-semibold">Add Customer Details</span>
                                </li>
                                <li class="form-wizard-list__item">
                                    <div class="form-wizard-list__line">
                                        <span class="count">3</span>
                                    </div>
                                    <span class="text text-xs fw-semibold">Completed</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Step 1 -->
                        <fieldset class="wizard-fieldset show">
                            <div class="row gy-4 align-items-end">
                                <div class="col-md-3">
                                    <label for="checkin" class="form-label">Check-In Date</label>
                                    <input type="date" id="checkin" value="{{ request('checkin') }}"
                                        class="form-control wizard-required">
                                </div>

                                <div class="col-md-3">
                                    <label for="checkout" class="form-label">Check-Out Date</label>
                                    <input type="date" id="checkout" value="{{ request('checkout') }}"
                                        class="form-control wizard-required">
                                </div>

                                <div class="col-md-3">
                                    <label for="guests" class="form-label">Guests</label>
                                    <input type="number" id="guests" class="form-control wizard-required"
                                        placeholder="Number of Guests" required min="1" max="50">
                                </div>

                                <div class="col-md-3 d-flex align-items-end">
                                    <button id="filterHotel" type="button" class="btn btn-primary w-100">Filter</button>
                                </div>

                                <div id="filterError" class="alert alert-danger d-none text-center small" role="alert">
                                </div>
                            </div>

                            <div class="mb-40 mt-5">
                                <div class="row gy-4" id="roomList">
                                    @forelse ($rooms as $room)
                                        <div class="col-xxl-3 col-sm-6">
                                            <div class="card radius-12 h-60">
                                                <div class="card-body py-16 px-24">
                                                    <div class="d-flex align-items-center gap-2 mb-12">
                                                        <iconify-icon icon="mdi:guest-room" class="text-xxl"></iconify-icon>
                                                        <h6 class="text-lg mb-0">Room Number - #{{ $room->room_number }}
                                                        </h6>

                                                        <div class="room-checkbox">
                                                            <input type="checkbox" id="room1" name="rooms[]"
                                                                value="{{ $room->id }}" class="form-check-input">
                                                        </div>
                                                    </div>
                                                    <p class="card-text text-muted mb-2">Room Type: {{ $room->room_type }}
                                                    </p>
                                                    <p class="card-text text-muted mb-2">Max Guests: {{ $room->occupancy }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="alert alert-primary" role="alert">
                                            The hotel can’t be found!
                                        </div>
                                    @endforelse
                                </div>

                                <div class="form-group text-end mt-4">
                                    <button type="button" id="nextBtn"
                                        class="form-wizard-next-btn btn btn-primary px-5">Next</button>
                                </div>
                            </div>
                        </fieldset>

                        <!-- Step 2 -->
                        <fieldset class="wizard-fieldset">

                            <div id="filterError2" class="alert alert-danger d-none text-center small" role="alert"></div>

                            <div class="row gy-3">
                                <div class="col-3">
                                    <label class="form-label">Customer Type * </label>
                                    <select id="customerType" class="form-control" name="customer_type">
                                        <option value="">-- Select --</option>
                                        <option value="individual">Individual Customer</option>
                                        <option value="travel_agency">Travel Agency</option>
                                    </select>
                                </div>
                                <div class="col-3 d-none" id="customerEmailDiv">
                                    <label class="form-label">Select Customer Email*</label>
                                    <select id="customerEmail" class="form-select" name="customer_email">
                                        <option value="">-- Select Customer --</option>
                                    </select>
                                </div>

                                <div class="col-3 d-none" id="travelAgencyDiv">
                                    <label class="form-label">Select Travel Agency*</label>
                                    <select id="travelAgency" class="form-select" name="travel_agency">
                                        <option value="">-- Select Travel Agency --</option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">Check In Date*</label>
                                    <input type="text" id="check_in_date" name="check_in_date" readonly
                                        class="form-control wizard-required">
                                </div>
                                <div class="col-3">
                                    <label class="form-label">Check Out Date*</label>
                                    <input type="text" name="check_out_date" id="check_out_date" readonly
                                        class="form-control wizard-required">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Special Requests</label>
                                    <textarea name="special_requests" class="form-control" rows="4" cols="50"
                                        placeholder="Enter a Special Requests..."></textarea>
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-label">Card Number</label>
                                    <input type="text" inputmode="numeric" maxlength="12"
                                        class="form-control wizard-required" placeholder="Enter Card Number"
                                        name="card_number">
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-label">Card Expiration(MM/YY)</label>
                                    <input type="text" maxlength="6" class="form-control wizard-required"
                                        placeholder="MM/YY" name="card_expire_date">
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-label">CVV Number</label>
                                    <input type="number" maxlength="5" class="form-control wizard-required"name="csv"
                                        placeholder="CVV Number">
                                </div>
                                <div class="form-group d-flex justify-content-end gap-3 mt-5">
                                    <button type="button"
                                        class="form-wizard-previous-btn btn btn-secondary px-5">Back</button>
                                    <button type="button" class="form-wizard-next-btn btn btn-primary px-5">Next</button>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="wizard-fieldset">
                            <div class="text-center mb-4">
                                <h6 class="text-md text-success">Reservation Added</h6>
                                <p class="text-muted mb-0">The reservation has been successfully added to the system. You
                                    can now manage or edit the booking if necessary.</p>

                            </div>
                            <div class="form-group d-flex justify-content-end gap-3 mt-5">
                                <button type="button"
                                    class="form-wizard-previous-btn btn btn-secondary px-5">Back</button>
                                <button type="submit" onclick="makeReservation()"
                                    class="form-wizard-submit btn btn-success px-5">Submit
                                    Reservation</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


    <script>
        const bookedDates = @json($bookedDates);

        document.addEventListener("DOMContentLoaded", function() {
            let currentStep = 0;
            const fieldsets = document.querySelectorAll(".wizard-fieldset");
            const nextBtns = document.querySelectorAll(".form-wizard-next-btn");
            const prevBtns = document.querySelectorAll(".form-wizard-previous-btn");
            const wizardError = document.getElementById('filterError');
            const wizardError2 = document.getElementById('filterError2');

            const checkInInput = document.getElementById('checkin');
            const checkOutInput = document.getElementById('checkout');
            const readonlyCheckin = document.getElementById('check_in_date');
            const readonlyCheckout = document.getElementById('check_out_date');

            const customerTypeSelect = document.getElementById('customerType');
            const customerEmailSelect = document.getElementById('customerEmail');
            const travelAgencySelect = document.getElementById('travelAgency');

            const cardNumberInput = document.querySelector('input[placeholder="Enter Card Number"]');
            const cardExpirationInput = document.querySelector('input[placeholder="MM/YY"]');
            const cvvInput = document.querySelector('input[placeholder="CVV Number"]');

            function showStep(index) {
                fieldsets.forEach((fieldset, i) => {
                    fieldset.classList.toggle("show", i === index);
                });
            }

            function isCardDetailsRequired(checkinDate) {
                const now = new Date();

                const today7pm = new Date();
                today7pm.setHours(19, 0, 0, 0);

                const tomorrow7pm = new Date(today7pm);
                tomorrow7pm.setDate(today7pm.getDate() + 1);

                const checkin = new Date(checkinDate);

                const nowDate = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                const checkinDateOnly = new Date(checkin.getFullYear(), checkin.getMonth(), checkin.getDate());

                const oneDay = 24 * 60 * 60 * 1000;
                const diffDays = Math.round((checkinDateOnly - nowDate) / oneDay);

                const isBetween7PMTodayAnd7PMTomorrow = now >= today7pm && now < tomorrow7pm;

                if (isBetween7PMTodayAnd7PMTomorrow && diffDays === 1) {
                    return true;
                }

                return false;
            }

            nextBtns.forEach((btn, index) => {
                btn.addEventListener("click", function(e) {
                    wizardError.classList.add('d-none');
                    wizardError.innerText = '';
                    wizardError2.classList.add('d-none');
                    wizardError2.innerText = '';

                    if (currentStep === 0) {
                        const checkin = checkInInput.value;
                        const checkout = checkOutInput.value;

                        if (!checkin || !checkout) {
                            e.preventDefault();
                            wizardError.classList.remove('d-none');
                            wizardError.innerText =
                                '❌ Please select both Check-In and Check-Out dates before proceeding!';
                            return;
                        }

                        if (checkin >= checkout) {
                            e.preventDefault();
                            wizardError.classList.remove('d-none');
                            wizardError.innerText = '❌ Check-Out Date must be after Check-In Date!';
                            return;
                        }

                        const selectedRooms = document.querySelectorAll(
                            'input[name="rooms[]"]:checked');
                        if (selectedRooms.length === 0) {
                            e.preventDefault();
                            wizardError.classList.remove('d-none');
                            wizardError.innerText =
                                '❌ Please select at least one Room before proceeding!';
                            return;
                        }

                        readonlyCheckin.value = checkin;
                        readonlyCheckout.value = checkout;
                    }

                    if (currentStep === 1) {
                        const customerType = customerTypeSelect.value;
                        const customerEmail = customerEmailSelect.value;
                        const travelAgency = travelAgencySelect.value;
                        const checkinDate = checkInInput.value;

                        if (customerType === '') {
                            e.preventDefault();
                            wizardError2.classList.remove('d-none');
                            wizardError2.innerText = '❌ Please select a Customer Type!';
                            return;
                        }

                        if (customerType === 'individual' && customerEmail === '') {
                            e.preventDefault();
                            wizardError2.classList.remove('d-none');
                            wizardError2.innerText =
                                '❌ Please select a Customer Email before proceeding!';
                            return;
                        }

                        if (customerType === 'travel_agency' && travelAgency === '') {
                            e.preventDefault();
                            wizardError2.classList.remove('d-none');
                            wizardError2.innerText =
                                '❌ Please select a Travel Agency before proceeding!';
                            return;
                        }

                        if (isCardDetailsRequired(checkinDate)) {
                            if (!cardNumberInput.value || !cardExpirationInput.value || !cvvInput
                                .value) {
                                e.preventDefault();
                                wizardError2.classList.remove('d-none');
                                wizardError2.innerText =
                                    '❌ Card details are required for reservations beyond today!';
                                return;
                            }
                        }
                    }

                    if (currentStep < fieldsets.length - 1) {
                        currentStep++;
                        showStep(currentStep);
                    }
                });
            });

            prevBtns.forEach(btn => {
                btn.addEventListener("click", function() {
                    if (currentStep > 0) {
                        currentStep--;
                        showStep(currentStep);
                    }
                });
            });

            showStep(currentStep); // Initialize to Step 1
        });


        document.addEventListener("DOMContentLoaded", function() {
            const checkin = document.getElementById('checkin');
            const checkout = document.getElementById('checkout');

            const today = new Date().toISOString().split('T')[0];
            checkin.setAttribute('min', today);
            checkout.setAttribute('min', today);

            checkin.addEventListener('change', function() {
                const checkinDate = this.value;
                checkout.setAttribute('min', checkinDate);
            });

            function disableBookedDates(input) {
                input.addEventListener('input', function() {
                    const selectedDate = this.value;
                    if (bookedDates.includes(selectedDate)) {
                        alert('This date is already booked. Please choose another date.');
                        this.value = '';
                    }
                });
            }

            disableBookedDates(checkin);
            disableBookedDates(checkout);
        });

        flatpickr("#checkin", {
            minDate: "today",
            disable: bookedDates
        });

        flatpickr("#checkout", {
            minDate: "today",
            disable: bookedDates
        });

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
                        console.error(xhr);
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const customerTypeSelect = document.getElementById('customerType');
            const customerEmailDiv = document.getElementById('customerEmailDiv');
            const travelAgencyDiv = document.getElementById('travelAgencyDiv');

            customerTypeSelect.addEventListener('change', function() {
                const value = this.value;

                customerEmailDiv.classList.add('d-none');
                travelAgencyDiv.classList.add('d-none');

                if (value === 'individual') {
                    customerEmailDiv.classList.remove('d-none');
                    travelAgencyDiv.classList.add('d-none');
                } else if (value === 'travel_agency') {
                    travelAgencyDiv.classList.remove('d-none');
                    customerEmailDiv.classList.add('d-none');
                }
            });
        });

        document.querySelector('input[name="card_number"]').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '').slice(0, 12); // Only digits, max 12
        });

        $(document).ready(function() {
            $('#customerType').on('change', function() {
                const type = $(this).val();

                if (type === 'individual') {
                    $.ajax({
                        url: '{{ route('admin.customers.list') }}',
                        method: 'GET',
                        success: function(data) {
                            let options = `<option value="">-- Select Customer --</option>`;
                            $.each(data.slice(0, 10), function(index, customer) {
                                options +=
                                    `<option value="${customer.id}">${customer.email}</option>`;
                            });
                            $('#customerEmail').html(options);
                            $('#customerEmailDiv').removeClass('d-none');
                            $('#travelAgencyDiv').addClass('d-none');
                        }
                    });
                }

                if (type === 'travel_agency') {
                    $.ajax({
                        url: '{{ route('admin.list.travel-companies') }}',
                        method: 'GET',
                        success: function(data) {
                            let options =
                                `<option value="">-- Select Travel Agency --</option>`;
                            $.each(data.slice(0, 10), function(index, company) {
                                options +=
                                    `<option value="${company.id}">${company.name}</option>`;
                            });
                            $('#travelAgency').html(options);
                            $('#travelAgencyDiv').removeClass('d-none');
                            $('#customerEmailDiv').addClass('d-none');
                        }
                    });
                }
            });
        });


        function makeReservation() {
            const formData = new FormData();

            const selectedRooms = Array.from(document.querySelectorAll('input[name="rooms[]"]:checked'))
                .map(room => room.value);

            const checkin = document.getElementById('checkin').value;
            const checkout = document.getElementById('checkout').value;
            const guests = document.getElementById('guests').value;

            const customerType = document.getElementById('customerType').value;
            const customerEmail = document.getElementById('customerEmail').value;
            const travelAgency = document.getElementById('travelAgency').value;
            const check_in_date = document.getElementById('check_in_date').value;
            const check_out_date = document.getElementById('check_out_date').value;
            const specialRequests = document.querySelector('textarea[name="special_requests"]').value;

            const cardNumber = document.querySelector('input[name="card_number"]').value;
            const cardExpireDate = document.querySelector('input[name="card_expire_date"]').value;
            const csv = document.querySelector('input[name="csv"]').value;

            formData.append('checkin', checkin);
            formData.append('checkout', checkout);
            formData.append('guests', guests);
            formData.append('customer_type', customerType);
            formData.append('customer_email', customerEmail);
            formData.append('travel_agency', travelAgency);
            formData.append('check_in_date', check_in_date);
            formData.append('check_out_date', check_out_date);
            formData.append('special_requests', specialRequests);
            formData.append('card_number', cardNumber);
            formData.append('card_expire_date', cardExpireDate);
            formData.append('csv', csv);

            selectedRooms.forEach((roomId, index) => {
                formData.append(`rooms[${index}]`, roomId);
            });

            const toast = new ToastMagic();

            fetch("{{ route('admin.reservation.store') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('Something went wrong');
                    }
                })
                .then(data => {
                    toast.success("Success!", "Reservation Created Successfully!");
                    window.location.href =
                        "{{ route('admin.reservation.index') }}";
                })
                .catch(error => {
                    toast.success("Error!", "Failed to create reservation. Please try again.");
                });
        }
    </script>
@endsection
