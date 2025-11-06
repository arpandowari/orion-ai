<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8fafc;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .button {
            display: inline-block;
            padding: 15px 40px;
            background: #10b981;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin: 20px 0;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #64748b;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Verify Your Email Address</h1>
        </div>
        <div class="content">
            <h2>Hello {{ $admin->name }},</h2>
            <p>Please click the button below to verify your email address.</p>

            <center>
                <a href="{{ $verificationUrl }}" class="button">Verify Email Address</a>
            </center>

            <p>If you did not create an account, no further action is required.</p>

            <p style="margin-top: 30px; font-size: 12px; color: #64748b;">
                If you're having trouble clicking the button, copy and paste the URL below into your web browser:<br>
                <a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a>
            </p>
        </div>
        <div class="footer">
            <p>&copy; 2025 ORION AI. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
