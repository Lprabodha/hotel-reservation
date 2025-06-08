<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reservation Invoice - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 650px;
            margin: 30px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.05);
        }

        h1 {
            font-size: 24px;
            color: #0044cc;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: #555555;
            line-height: 1.6;
        }

        .invoice-details {
            margin: 20px 0;
            padding: 15px;
            background-color: #f4f8ff;
            border-radius: 6px;
        }

        .invoice-details p {
            margin: 5px 0;
            font-size: 15px;
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
        <h1>Reservation Invoice</h1>

        <p>Dear {{ $mailData['name'] }},</p>

        <p>We are pleased to inform you that your payment for the reservation has been successfully completed. Here’s a
            summary of your reservation details and invoice information:</p>

        <div class="invoice-details">
            <h3>Invoice Summary:</h3>
            <p><strong>Reservation ID:</strong> {{ $mailData['reservation_id'] }}</p>
            <p><strong>Invoice Number:</strong> {{ $mailData['invoice_number'] }}</p>
            <p><strong>Check-in Date:</strong> {{ $mailData['check_in_date'] }}</p>
            <p><strong>Check-out Date:</strong> {{ $mailData['check_out_date'] }}</p>
            <p><strong>Hotel Name:</strong> {{ $mailData['hotel_name'] }}</p>
            <p><strong>Hotel Address:</strong> {{ $mailData['hotel_location'] }}</p>
            <p><strong>Total Amount Paid:</strong> LKR {{ number_format($mailData['total_amount'], 2) }}</p>
            <p><strong>Payment Method:</strong> {{ ucfirst($mailData['payment_method']) }}</p>
        </div>

        <p style="text-align: center;">
            <a href="{{ $mailData['reservation_url'] }}" class="button">View Reservation Details</a>
        </p>

        <p>If you have any questions or require assistance, feel free to reach out to our support team. Thank you for
            choosing us. We look forward to hosting you!</p>

        <div class="contact">
            <p><strong>Contact Us:</strong></p>
            <p>Email: <a href="mailto:support@click2checkin.com">support@click2checkin.com</a></p>
        </div>

        <div class="footer">
            <p>Best Regards,<br>The {{ config('app.name') }} Team</p>
        </div>
    </div>
</body>

</html>
