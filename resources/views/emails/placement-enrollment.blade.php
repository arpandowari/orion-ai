<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white; padding: 20px; text-align: center; }
        .content { background: #f8fafc; padding: 20px; }
        .detail { margin-bottom: 10px; }
        .detail strong { color: #1e3a8a; }
        .footer { text-align: center; padding: 20px; color: #64748b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Placement Series Enrollment</h1>
        </div>
        <div class="content">
            <h2>Enrollment Details</h2>
            <div class="detail"><strong>Email:</strong> {{ $enrollment->email }}</div>
            <div class="detail"><strong>Phone:</strong> {{ $enrollment->phone }}</div>
            <div class="detail"><strong>Amount:</strong> ₹{{ number_format($enrollment->amount, 2) }}</div>
            <div class="detail"><strong>Enrollment Date:</strong> {{ $enrollment->created_at->format('M d, Y H:i') }}</div>
            
            <p style="margin-top: 20px;">
                <a href="{{ route('admin.dashboard') }}" style="background: #3b82f6; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">View in Dashboard</a>
            </p>
        </div>
        <div class="footer">
            <p>&copy; 2025 ORION AI. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
