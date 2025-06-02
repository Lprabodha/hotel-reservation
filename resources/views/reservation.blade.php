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
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
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

    /* Mobile adjustments */
    @media (max-width: 768px) {
        .col-lg-8, .col-lg-4 {
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
</style>

<div class="container reservation-page">

    <!-- Reservation Page Title -->
    <div class="page-title">
        <h1>Reservation</h1>
    </div>

    <div class="row">
        <div class="col-lg-8">

            <!-- Hotel Card -->
            <div class="card hotel-card">
                <img src="{{ asset('assets/images/hotel.jpg') }}" alt="Hotel Image">
                <div class="hotel-info">
                    <h2>7Seasons Apartments Budapest</h2>
                    <p>1061 Budapest, Király utca 8., Hungary</p>
                    <div class="rating">
                        <div class="stars">★★★★★</div>
                        <div class="score">8.8 Excellent · 11,267 reviews</div>
                    </div>
                    <p>Excellent Location — 9.7</p>
                    <p>Free Wifi · Airport Shuttle · Parking</p>
                </div>
            </div>

            <!-- Booking Details -->
            <div class="card">
                <h3 class="section-title">Your Booking Details</h3>
                <table class="details-table">
                    <tr>
                        <td>Check-in</td>
                        <td>Sat, Jun 14, 2025 — 3:00 PM</td>
                    </tr>
                    <tr>
                        <td>Check-out</td>
                        <td>Sun, Jun 15, 2025 — Until 11:00 AM</td>
                    </tr>
                    <tr>
                        <td>Total length of stay</td>
                        <td>1 night</td>
                    </tr>
                    <tr>
                        <td>You selected</td>
                        <td>2 rooms for 2 adults</td>
                    </tr>
                    <tr>
                        <td>Room Type</td>
                        <td>2 × Deluxe Studio</td>
                    </tr>
                </table>
                <a href="#" style="font-size: 14px; color: #007bff; text-decoration: underline; margin-top: 10px; display: inline-block;">Change your selection</a>
            </div>

            <!-- Price Summary -->
            <div class="card">
                <h3 class="section-title">Your Price Summary</h3>
                <div class="price-summary">
                    <ul>
                        <li>Original price <span>US$703.22</span></li>
                        <li>Getaway Deal <span>– US$140.64</span></li>
                        <li class="total">Final Price <span>US$562.58</span></li>
                    </ul>
                </div>
            </div>

        </div>

        <!-- Right Section — Billing and Payment -->
        <div class="col-lg-4">
            <!-- Billing Address Form -->
            <div class="card">
                <h3 class="section-title">Billing Address</h3>
                <div class="contact-form form-style">
                    <div class="row">
                        <div class="col-12">
                            <label>Email Address</label>
                            <input type="email" placeholder="Your email" name="email">
                        </div>
                        <div class="col-12">
                            <label>Phone No.</label>
                            <input type="text" placeholder="Your phone number" name="phone">
                        </div>
                        <div class="col-12">
                            <label>Special Requests</label>
                            <textarea name="special_requests" placeholder="Any special requirements or preferences?"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="card">
                <h3 class="section-title">Payment Method</h3>
                <div class="payment-method">
                    <ul>
                        <li>
                            <input type="radio" id="card" name="payment" checked>
                            <label for="card">Payment By Card</label>
                        </li>
                        <li>
                            <input type="radio" id="cash" name="payment">
                            <label for="cash">Cash On Delivery</label>
                        </li>
                    </ul>
                </div>

                <!-- Card Details Form -->
                <div class="contact-form form-style">
                    <div class="row">
                        <div class="col-12">
                            <label>Card Holder Name</label>
                            <input type="text" placeholder="Name on Card" name="card_holder">
                        </div>
                        <div class="col-12">
                            <label>Card Number</label>
                            <input type="text" placeholder="XXXX XXXX XXXX XXXX" name="card_number">
                        </div>
                        <div class="col-6">
                            <label>CVV</label>
                            <input type="text" placeholder="CVV" name="cvv">
                        </div>
                        <div class="col-6">
                            <label>Expire Date</label>
                            <input type="text" placeholder="MM/YY" name="expiry_date">
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="theme-btn">Place Order</button>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- end right col -->

    </div> <!-- end row -->
</div> <!-- end container -->

@endsection
