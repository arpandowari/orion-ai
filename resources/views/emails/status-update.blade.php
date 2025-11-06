<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Status Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
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
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            margin: 10px 5px;
        }
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        .status-contacted {
            background: #dbeafe;
            color: #1e40af;
        }
        .status-verified {
            background: #d1fae5;
            color: #065f46;
        }
        .info-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #3b82f6;
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
    <div class="header">
        <h1>ORION AI</h1>
        <p>Registration Status Update</p>
    </div>
    
    <div class="content">
        <h2>Hello {{ $registration->name }},</h2>
        
        <p>Your registration status has been updated.</p>
        
        <div class="info-box">
            <p><strong>Course:</strong> {{ $registration->course->name }}</p>
            <p><strong>Previous Status:</strong> <span class="status-badge status-{{ $oldStatus }}">{{ ucfirst($oldStatus) }}</span></p>
            <p><strong>New Status:</strong> <span class="status-badge status-{{ $newStatus }}">{{ ucfirst($newStatus) }}</span></p>
        </div>
        
        @if($newStatus == 'contacted')
            <p>Our team has reached out to you. Please check your email and phone for further communication.</p>
        @elseif($newStatus == 'verified')
            <p>Congratulations! Your registration has been verified. You will receive course access details shortly.</p>
        @else
            <p>Your registration is currently being processed. We will update you soon.</p>
        @endif
        
        <p>If you have any questions, please don't hesitate to contact us.</p>
        
        <p>Best regards,<br>
        <strong>ORION AI Team</strong></p>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} ORION AI. All rights reserved.</p>
        <p>This is an automated email. Please do not reply to this message.</p>
    </div>
</body>
</html>
