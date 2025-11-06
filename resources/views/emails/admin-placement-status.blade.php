<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Placement Status Changed</title>
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
    </style>
</head>
<body>
    <div class="header">
        <h2>Placement Status Changed</h2>
    </div>
    
    <div class="content">
        <p><strong>Admin Notification</strong></p>
        
        <div class="info-box">
            <p><strong>Email:</strong> {{ $placement->email }}</p>
            <p><strong>Phone:</strong> {{ $placement->phone }}</p>
            <p><strong>Amount:</strong> ₹{{ number_format($placement->amount, 2) }}</p>
            <p><strong>Status Changed:</strong> {{ ucfirst($oldStatus) }} → {{ ucfirst($newStatus) }}</p>
            <p><strong>Time:</strong> {{ now()->format('M d, Y H:i:s') }}</p>
        </div>
        
        <p>Student has been notified via email about this status change.</p>
    </div>
</body>
</html>
