<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome to Click2Clickin - {{ config('app.name') }}</title>
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
            color: #333333;
        }

        p {
            font-size: 16px;
            color: #555555;
            line-height: 1.5;
        }

        a.button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background-color: #4F46E5;
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
        <h1>{{ $mailData['title'] ?? 'Welcome!' }}</h1>
        <p>Hi {{ $mailData['name'] ?? 'there' }},</p>
        <p>Welcome to <strong>Click2Clickin</strong>! We’re excited to have you join us.</p>
        <p>You can now start browsing available hotels and make your first reservation easily.</p>

        <p style="text-align: center;">
            <a href="{{ $mailData['login_url'] }}" class="button">Make a Reservation</a>
        </p>

        <div class="contact">
            <p>Need help? Contact us anytime:</p>
            <p><strong>Email:</strong> <a href="mailto:service@click2checkin.com">service@click2checkin.com</a></p>
        </div>

        <div class="footer">
            <p>Thank you,<br>The {{ config('app.name') }} Team</p>
        </div>
    </div>
</body>

</html>
