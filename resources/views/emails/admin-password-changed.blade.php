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
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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
        .alert {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
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
            <h1>Password Changed</h1>
        </div>
        <div class="content">
            <h2>Hello {{ $admin->name }},</h2>
            <p>Your password has been changed successfully.</p>
            
            <div class="alert">
                <strong>⚠️ Security Notice:</strong> If you did not request this password change, please contact the system administrator immediately.
            </div>

            <p><strong>Changed on:</strong> {{ now()->format('F d, Y \a\t h:i A') }}</p>

            <p>If you have any concerns about your account security, please contact us immediately.</p>
        </div>
        <div class="footer">
            <p>&copy; 2025 ORION AI. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
