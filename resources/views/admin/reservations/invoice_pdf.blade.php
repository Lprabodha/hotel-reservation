<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $reservation->confirmation_number }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 30px;
        }

        .header, .footer {
            margin-bottom: 20px;
        }

        .logo {
            height: 50px;
        }

        .company-details {
            text-align: right;
        }

        .invoice-title {
            font-size: 22px;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }

        .summary-table td {
            border: none;
            padding: 4px;
        }

        .summary-table tr td:first-child {
            width: 70%;
        }

        .footer-note {
            font-size: 10px;
            margin-top: 40px;
            text-align: center;
        }

    </style>
</head>
<body>
    {{-- Header --}}
    <div class="header d-flex justify-content-between">
        <table style="width: 100%; border: none;">
            <tr style="border: none;">
                <td style="border: none;">
                    <img src="{{ Vite::asset('resources/images/logo.png') }}" class="logo" alt="Click2 Checkin">
                </td>
                <td class="company-details" style="border: none; text-align: right;">
                    <strong>Click2Checkin Hotel</strong><br>
                    Galle Road, Colombo, Sri Lanka<br>
                    Email: info@click2checkin.com<br>
                    Phone: +94 77 4778 784
                </td>
            </tr>
        </table>
    </div>

    <div class="invoice-title">Invoice: #{{ $reservation->confirmation_number }}</div>
    <p><strong>Date Issued:</strong> {{ \Carbon\Carbon::now()->format('Y-m-d') }}</p>
    <p><strong>Status:</strong> {{ ucfirst($reservation->status) }}</p>

    {{-- Guest & Reservation Details --}}
    <div class="section-title">Guest Information</div>
    <table>
        <tr>
            <th>Name</th>
            <td>{{ $reservation->user->type === 'travel_agency' ? $reservation->user->company_name : $reservation->user->name }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>{{ $reservation->user->address ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{ $reservation->user->phone_number ?? 'N/A' }}</td>
        </tr>
    </table>

    <div class="section-title">Reservation Details</div>
    <table>
        <tr>
            <th>Check-In Date</th>
            <td>{{ $reservation->check_in_date }}</td>
        </tr>
        <tr>
            <th>Check-Out Date</th>
            <td>{{ $reservation->check_out_date }}</td>
        </tr>
    </table>

    {{-- Room Details --}}
    <div class="section-title">Room Information</div>
    <table>
        <thead>
            <tr>
                <th>Room ID</th>
                <th>Guests</th>
                <th>Room Type</th>
                <th>Price (LKR)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservationRooms as $room)
                <tr>
                    <td>{{ $room['id'] }}</td>
                    <td>{{ $room['occupancy'] }}</td>
                    <td>{{ $room['room_type'] }}</td>
                    <td class="text-right">{{ number_format($room['price'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Extra Services --}}
    @if ($bill && $bill->services->count() > 0)
        <div class="section-title">Extra Services</div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Service</th>
                    <th>Charge (LKR)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bill->services as $index => $service)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $service->name }}</td>
                        <td class="text-right">{{ number_format($service->pivot->charge, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- Summary --}}
    <div class="section-title">Billing Summary</div>
    <table class="summary-table">
        <tr>
            <td>Room Charges:</td>
            <td class="text-right">LKR {{ number_format($bill->room_charges ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td>Extra Charges:</td>
            <td class="text-right">LKR {{ number_format($bill->extra_charges ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td>Discount:</td>
            <td class="text-right">LKR {{ number_format($bill->discount ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td>Tax:</td>
            <td class="text-right">LKR {{ number_format($bill->taxes ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Total Amount:</strong></td>
            <td class="text-right"><strong>LKR {{ number_format($bill->total_amount ?? $reservation->total_price, 2) }}</strong></td>
        </tr>
    </table>

    {{-- Footer --}}
    <div class="footer-note">
        Thank you for your stay with us. If you have any questions, please contact info@click2checkin.com
    </div>
</body>
</html>
