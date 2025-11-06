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
            <h1>New Course Registration</h1>
        </div>
        <div class="content">
            <h2>Student Details</h2>
            <div class="detail"><strong>Name:</strong> {{ $registration->name }}</div>
            <div class="detail"><strong>Email:</strong> {{ $registration->email }}</div>
            <div class="detail"><strong>Course:</strong> {{ $registration->course->name }}</div>
            <div class="detail"><strong>CGPA:</strong> {{ $registration->cgpa ?? 'N/A' }}</div>
            <div class="detail"><strong>Expected CTC:</strong> {{ $registration->expected_ctc ? '₹' . number_format($registration->expected_ctc, 2) . ' LPA' : 'N/A' }}</div>
            <div class="detail"><strong>Registration Date:</strong> {{ $registration->created_at->format('M d, Y H:i') }}</div>
            
            <h3>Documents</h3>
            <p>Resume and marksheet have been uploaded. Please check the admin dashboard to download them.</p>
            
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
