<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Password Reset OTP</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 40px 30px;
        }
        .otp-box {
            background: #f8f9fa;
            border: 2px dashed #667eea;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 30px 0;
        }
        .otp-code {
            font-size: 36px;
            font-weight: bold;
            color: #667eea;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
        }
        .warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .admin-badge {
            background: #dc3545;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            display: inline-block;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Admin Password Reset Request</h1>
        </div>
        
        <div class="content">
            <div class="admin-badge">ADMIN ACCESS</div>
            
            <p>Hello Administrator,</p>
            
            <p>We received a request to reset the password for your ORION AI admin account.</p>
            
            <p>Your One-Time Password (OTP) is:</p>
            
            <div class="otp-box">
                <div class="otp-code">{{ $otp }}</div>
                <p style="margin: 10px 0 0 0; color: #666; font-size: 14px;">Valid for 10 minutes</p>
            </div>
            
            <p>Enter this code on the password reset page to continue.</p>
            
            <div class="warning">
                <strong>⚠️ Critical Security Notice:</strong>
                <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                    <li><strong>NEVER share this OTP with anyone</strong></li>
                    <li>ORION AI staff will NEVER ask for your OTP</li>
                    <li>This code expires in 10 minutes</li>
                    <li>If you didn't request this, contact support immediately</li>
                </ul>
            </div>
            
            <p><strong>Important:</strong> If you didn't request a password reset, please secure your account immediately and contact the system administrator.</p>
            
            <p>Best regards,<br>
            <strong>ORION AI Security Team</strong></p>
        </div>
        
        <div class="footer">
            <p>This is an automated security message, please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} ORION AI. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
