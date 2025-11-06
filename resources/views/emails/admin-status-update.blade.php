<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registration Status Changed</title>
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
            background: #1e3a8a;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            background: #f8fafc;
            padding: 20px;
        }
        .info-box {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #3b82f6;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 15px;
            font-weight: bold;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Registration Status Changed</h2>
    </div>
    
    <div class="content">
        <p><strong>Admin Notification</strong></p>
        
        <div class="info-box">
            <p><strong>Student:</strong> {{ $registration->name }}</p>
            <p><strong>Email:</strong> {{ $registration->email }}</p>
            <p><strong>Course:</strong> {{ $registration->course->name }}</p>
            <p><strong>Status Changed:</strong> {{ ucfirst($oldStatus) }} → {{ ucfirst($newStatus) }}</p>
            <p><strong>Time:</strong> {{ now()->format('M d, Y H:i:s') }}</p>
        </div>
        
        <p>Student has been notified via email about this status change.</p>
    </div>
</body>
</html>
