<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Thank You for Your Reservation - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.05);
        }

        h1 {
            font-size: 24px;
            color: #0044cc;
        }

        p {
            font-size: 16px;
            color: #555555;
            line-height: 1.6;
        }

        .reservation-details {
            margin: 20px 0;
            padding: 15px;
            background-color: #e6f0ff;
            border-radius: 6px;
        }

        .reservation-details p {
            margin: 5px 0;
        }

        a.button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background-color: #0044cc;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #999999;
            text-align: center;
        }

        .contact {
            margin-top: 20px;
            font-size: 15px;
            color: #555555;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <h1>{{ $mailData['title'] }}</h1>
        <p>Dear {{ $mailData['name'] }},</p>

        <p>Thank you for booking with <strong>Click2Clickin</strong>! We’re delighted to confirm your reservation and
            look forward to welcoming you. Below you will find the details of your booking for your convenience.</p>

        <div class="reservation-details">
            <h3>Reservation Summary:</h3>
            <p><strong>Reservation ID:</strong> {{ $mailData['reservation_id'] }}</p>
            <p><strong>Check-in Date:</strong> {{ $mailData['date'] }}</p>
            <p><strong>Check-in Time:</strong> {{ $mailData['time'] }}</p>
            <p><strong>Hotel Name:</strong> {{ $mailData['hotel_name'] }}</p>
            <p><strong>Hotel Address:</strong> {{ $mailData['hotel_location'] }}</p>
            <p><strong>Booking Location:</strong> {{ $mailData['location'] }}</p>
        </div>

        <p style="text-align: center;">
            <a href="{{ $mailData['reservation_url'] }}" class="button">View Reservation Details</a>
        </p>

        <p>Should you require any changes or have questions about your reservation, our team is here to assist you. We
            wish you a pleasant and memorable stay with us.</p>

        <div class="contact">
            <p><strong>Contact Us:</strong></p>
            <p>Email: <a href="mailto:service@click2checkin.com">service@click2checkin.com</a></p>
        </div>

        <div class="footer">
            <p>Thank you,<br>The {{ config('app.name') }} Team</p>
        </div>
    </div>
</body>

</html>
