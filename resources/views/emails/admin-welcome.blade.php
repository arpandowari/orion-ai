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
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
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
        .credentials {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #3b82f6;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #3b82f6;
            color: white;
            text-decoration: none;
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
            <h1>Welcome to ORION AI!</h1>
        </div>
        <div class="content">
            <h2>Hello {{ $admin->name }},</h2>
            <p>Your admin account has been created successfully. You can now access the ORION AI admin panel.</p>
            
            <div class="credentials">
                <h3>Your Login Credentials:</h3>
                <p><strong>Email:</strong> {{ $admin->email }}</p>
                <p><strong>Password:</strong> {{ $password }}</p>
            </div>

            <p><strong>Important:</strong> Please change your password after your first login for security purposes.</p>

            <a href="{{ $loginUrl }}" class="button">Login to Admin Panel</a>

            <p>If you have any questions, please contact the system administrator.</p>
        </div>
        <div class="footer">
            <p>&copy; 2025 ORION AI. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
