@extends('layouts.app')

@section('content')
    <style>
        .reservation-page {
            font-family: 'Poppins', sans-serif;
            margin-top: 50px;
        }

        .page-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-title h1 {
            font-size: 32px;
            font-weight: 700;
            color: #2c3e50;
        }

        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 30px;
        }

        .hotel-card img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            object-fit: cover;
        }

        .hotel-info {
            margin-top: 15px;
        }

        .hotel-info h2 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .hotel-info p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }

        .rating {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .rating .stars {
            color: #f1c40f;
            margin-right: 10px;
        }

        .details-table {
            width: 100%;
            margin-top: 20px;
            font-size: 14px;
        }

        .details-table td {
            padding: 8px 0;
            vertical-align: top;
        }

        .details-table td:first-child {
            font-weight: 600;
            width: 40%;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .price-summary ul {
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 14px;
        }

        .price-summary ul li {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .price-summary ul li.total {
            font-weight: 700;
            font-size: 16px;
            color: #1abc9c;
        }

        .price-summary ul li span {
            font-weight: 600;
        }

        .form-style input,
        .form-style textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-style textarea {
            resize: vertical;
        }

        .form-style label {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
        }

        .payment-method ul {
            padding: 0;
            margin: 0 0 20px 0;
            list-style: none;
        }

        .payment-method ul li {
            margin-bottom: 10px;
        }

        .payment-method input[type="radio"] {
            margin-right: 10px;
        }

        .theme-btn {
            background: linear-gradient(to right, #f39c12, #f1c40f);
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            border-radius: 30px;
            width: 100%;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .theme-btn:hover {
            background: linear-gradient(to right, #e67e22, #f39c12);
        }

        input[type=checkbox]+label:before {
            margin-left: 290px;
        }

        /* Mobile adjustments */
        @media (max-width: 768px) {

            .col-lg-8,
            .col-lg-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .row {
                display: flex;
                flex-wrap: wrap;
            }

            .theme-btn {
                margin-top: 20px;
            }

            .details-table td {
                display: block;
                width: 100%;
                padding: 5px 0;
            }

            .details-table tr {
                display: block;
                margin-bottom: 10px;
                border-bottom: 1px solid #eee;
            }
        }

        .room-card {
            height: 180px;
        }

        .card-img {
            border-radius: 10px;
        }
    </style>

    <div class="container reservation-page">

        <div class="page-title">
            <h1>Reservation</h1>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <!-- Hotel Card -->
                {{-- @dd($hotel) --}}
                <div class="card hotel-card">
                    @if (!empty($hotel->images[0]))
                        <img src="{{ Storage::disk('s3')->url($hotel->images[0]) }}" class="card-img"
                            style="object-fit: cover; width: 100% !important; height: 400px !important;" alt="Hotel Image">
                    @else
                        <img src="{{ Vite::asset('resources/images/default-room.jpg') }}" class="card-img"
                            alt="Hotel image">
                    @endif
                    <div class="hotel-info">
                        <h2>{{ $hotel->name }}</h2>
                        <p>{{ $hotel->address }}</p>
                        <div class="rating">
                            <div class="stars">
                                @for ($i = 0; $i < $hotel->star_rating; $i++)
                                    ★
                                @endfor
                                @for ($i = $hotel->star_rating; $i < 5; $i++)
                                    ☆
                                @endfor
                            </div>
                            <div class="score">{{ $hotel->star_rating }} Stars Hotel</div>
                        </div>
                        <p>{{ $hotel->description }}</p>
                        <p>
                            {{ $hotel->services->pluck('name')->implode(' --- ') }}
                        </p>
                    </div>
                </div>

                <!-- Booking Details -->
                <div id="flash-message" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>
                <script>
                    const flashMessageData = {
                        success: @json(session('success')),
                        error: @json(session('error'))
                    };
                </script>

                <form action="{{ route('reservation.store') }}" method="POST">
                    @csrf
                    <div class="card">
                        <h3 class="section-title">Your Booking Details</h3>

                        <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
                            <div class="form-group mb-3" style="width: 30%">
                                <label for="checkin">Check-in Date</label>
                                <input type="date" class="form-control" name="checkin" required>
                            </div>

                            <div class="form-group mb-3" style="width: 30%">
                                <label for="checkout">Check-out Date</label>
                                <input type="date" class="form-control" name="checkout" required>
                            </div>

                            <div class="form-group mb-3" style="width: 15%">
                                <label for="guests">Number of Guests</label>
                                <input type="number" class="form-control" name="guests" min="1" required>
                            </div>
                            <div class="text-center" style="width: 15%">
                                <button type="button" class="btn btn-primary" id="check-availability-btn">List Available
                                    Rooms</button>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="special_requests">Special Requests</label>
                            <textarea class="form-control" name="special_requests" rows="2"></textarea>
                        </div>

                        {{-- Hidden fields --}}
                        <input type="hidden" name="customer_type" value="individual">
                        <input type="hidden" name="customer_email" value="{{ auth()->id() }}">
                        <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">

                        <div style="display: flex; justify-content: space-between; width: 100%;">
                            <div class="form-group mb-3" style="width: 45%;">
                                <label for="customer_name">Name</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                            </div>

                            <div class="form-group mb-3" style="width: 45%;">
                                <label for="customer_email">Email</label>
                                <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                            </div>
                        </div>

                        <div style="display: flex; justify-content: space-between; width: 100%;">
                            <div class="form-group mb-3" style="width: 30%;">
                                <label>Card Number</label>
                                <input type="text" name="card_number" class="form-control"
                                    placeholder="XXXX XXXX XXXX XXXX">
                            </div>
                            <div class="form-row mb-3" style="width: 30%;">
                                <div class="col">
                                    <label>Card Expiry</label>
                                    <input type="text" name="card_expire_date" class="form-control" placeholder="MM/YY">
                                </div>
                            </div>
                            <div class="form-row mb-3" style="width: 30%;">
                                <div class="col">
                                    <label>CVV</label>
                                    <input type="text" name="csv" class="form-control" placeholder="123">
                                </div>
                            </div>
                        </div>

                        <div id="selected-rooms"></div>

                        <div class="card">
                            <h3 class="section-title">Your Price Summary</h3>
                            <div class="price-summary">
                                <ul id="selected-room-list"></ul>
                                <li class="total">Final Price: <span id="final-price">$0.00</span></li>
                            </div>
                        </div>


                        <div class="text-center">
                            <button type="submit" class="theme-btn">Confirm Reservation</button>
                        </div>
                    </div>
                </form>

                <div class="row mb-4" id="available-rooms-container">
                    {{-- Rooms will be loaded here by js after the dates seleted --}}
                </div>
            </div>
        </div>
    </div>
    <script>
        const checkinInput = document.querySelector('input[name="checkin"]');
        const checkoutInput = document.querySelector('input[name="checkout"]');
        const guestsInput = document.querySelector('input[name="guests"]');
        const checkAvailabilityBtn = document.getElementById('check-availability-btn');

        const selectedRoomsInputContainer = document.getElementById('selected-rooms');
        const roomList = document.getElementById('selected-room-list');
        const finalPriceEl = document.getElementById('final-price');
        const roomsContainer = document.getElementById('available-rooms-container');

        function getNights() {
            const checkin = checkinInput.value;
            const checkout = checkoutInput.value;

            if (!checkin || !checkout) return 0;

            const start = new Date(checkin);
            const end = new Date(checkout);

            const diff = end - start;
            if (isNaN(diff) || diff <= 0) return 0;

            return Math.ceil(diff / (1000 * 60 * 60 * 24));
        }

        function updateSelectedRooms() {
            const nights = getNights();
            let totalPrice = 0;

            roomList.innerHTML = '';
            selectedRoomsInputContainer.innerHTML = '';

            document.querySelectorAll('.room-checkbox:checked').forEach(cb => {
                const id = cb.dataset.id;
                const name = cb.dataset.name;
                const price = parseFloat(cb.dataset.price);
                if (isNaN(price)) return;

                const subtotal = price * nights;

                const li = document.createElement('li');
                li.textContent = `${name} × ${nights} night(s): $${subtotal.toFixed(2)}`;
                roomList.appendChild(li);

                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'rooms[]';
                hidden.value = id;
                selectedRoomsInputContainer.appendChild(hidden);

                totalPrice += subtotal;
            });

            finalPriceEl.textContent = nights === 0 ?
                'Please select valid check-in and check-out dates.' :
                `$${totalPrice.toFixed(2)}`;
        }

        checkAvailabilityBtn.addEventListener('click', function() {
            const checkin = checkinInput.value;
            const checkout = checkoutInput.value;
            const guests = guestsInput.value;

            if (!checkin || !checkout || !guests) {
                showFlashMessage('error', 'Please enter check-in, check-out dates, and number of guests.');
                return;
            }

            fetch(`/check-availability?checkin=${checkin}&checkout=${checkout}&guests=${guests}`)
                .then(response => response.json())
                .then(data => {
                    roomsContainer.innerHTML = '';

                    if (!data.rooms || data.rooms.length === 0) {
                        showFlashMessage('error', 'No rooms available for selected dates and guests.');
                        return;
                    }

                    data.rooms.forEach(room => {
                        roomsContainer.innerHTML += `
                        <div class="col-md-6">
                            <div class="card room-card mb-3">
                                <div class="row no-gutters">
                                    <div class="col-md-5">
                                        <img src="${room.image}" class="card-img" style="object-fit: cover; width: 100%; height: 136px;" alt="Room Image">
                                    </div>
                                    <div class="col-md-7">
                                        <div class="card-body">
                                            <h5 class="card-title">Room ${room.room_number} - ${room.room_type}</h5>
                                            <p class="card-text">Price per night: $${room.price_per_night}</p>
                                            <div class="form-check">
                                                <input class="form-check-input room-checkbox" type="checkbox"
                                                    id="room-${room.id}"
                                                    data-id="${room.id}"
                                                    data-name="Room ${room.room_number} - ${room.room_type}"
                                                    data-price="${room.price_per_night}">
                                                <label class="form-check-label" for="room-${room.id}">
                                                    Select this room
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    });

                    document.querySelectorAll('.room-checkbox').forEach(cb => {
                        cb.addEventListener('change', updateSelectedRooms);
                    });

                    updateSelectedRooms();
                    showFlashMessage('success', 'Rooms loaded successfully.');
                })
                .catch(error => {
                    console.error('Error:', error);
                    showFlashMessage('error', 'Failed to fetch available rooms.');
                });
        });

        checkinInput.addEventListener('change', updateSelectedRooms);
        checkoutInput.addEventListener('change', updateSelectedRooms);

        document.querySelectorAll('.room-checkbox').forEach(cb => {
            cb.addEventListener('change', updateSelectedRooms);
        });
    </script>
    <script>
        function showFlashMessage(type, message) {
            const flash = document.getElementById('flash-message');
            if (!message) return;

            flash.innerHTML = `
            <div style="
                background-color: ${type === 'success' ? '#d4edda' : '#f8d7da'};
                color: ${type === 'success' ? '#155724' : '#721c24'};
                border: 1px solid ${type === 'success' ? '#c3e6cb' : '#f5c6cb'};
                padding: 12px 16px;
                margin-bottom: 10px;
                border-radius: 6px;
                min-width: 250px;
                font-family: sans-serif;
                box-shadow: 0 2px 6px rgba(0,0,0,0.1);
                transition: opacity 0.3s ease;
            ">
                ${message}
            </div>
        `;

            setTimeout(() => {
                flash.innerHTML = '';
            }, 4000);
        }

        window.addEventListener('DOMContentLoaded', () => {
            if (flashMessageData.success) {
                showFlashMessage('success', flashMessageData.success);
            } else if (flashMessageData.error) {
                showFlashMessage('error', flashMessageData.error);
            }
        });
    </script>
@endsection
