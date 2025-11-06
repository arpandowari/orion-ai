<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ORION AI</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Hide scrollbars but keep functionality */
        * {
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
        }

        *::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f5f7fa;
            color: #2d3748;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 100%);
            padding: 0;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .user-info h4 {
            color: white;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .user-info p {
            color: rgba(255,255,255,0.7);
            font-size: 0.75rem;
        }

        .sidebar-nav {
            padding: 1.5rem 0;
        }

        .nav-section {
            margin-bottom: 2rem;
        }

        .nav-title {
            padding: 0 1.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: rgba(255,255,255,0.5);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.75rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .nav-item.active {
            background: rgba(255,255,255,0.15);
            color: white;
            border-left: 3px solid #60a5fa;
        }

        .nav-icon {
            width: 20px;
            margin-right: 0.75rem;
            font-size: 1.25rem;
        }

        .nav-badge {
            margin-left: auto;
            background: rgba(255,255,255,0.2);
            padding: 0.125rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }

        .topbar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar-title h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e3a8a;
        }

        .topbar-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn {
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: #1e3a8a;
            color: white;
        }

        .btn-primary:hover {
            background: #1e40af;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(30,58,138,0.3);
        }

        .btn-success {
            background: #10b981;
            color: white;
        }

        .btn-success:hover {
            background: #059669;
        }

        /* Content Area */
        .content-area {
            padding: 2rem;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: all 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .stat-title {
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 500;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .stat-icon.blue {
            background: #dbeafe;
            color: #1e40af;
        }

        .stat-icon.green {
            background: #d1fae5;
            color: #059669;
        }

        .stat-icon.purple {
            background: #e9d5ff;
            color: #7c3aed;
        }

        .stat-icon.orange {
            background: #fed7aa;
            color: #ea580c;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
        }

        /* Tabs */
        .tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2rem;
            background: white;
            padding: 0.5rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .tab {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            background: none;
        }

        .tab:hover {
            background: #f1f5f9;
            color: #1e3a8a;
        }

        .tab.active {
            background: #1e3a8a;
            color: white;
        }

        /* Content Card */
        .content-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1e293b;
        }

        .search-box {
            padding: 0.625rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.875rem;
            width: 300px;
        }

        .search-box:focus {
            outline: none;
            border-color: #1e3a8a;
        }

        /* Table */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f8fafc;
        }

        th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        td {
            padding: 1rem 1.5rem;
            border-top: 1px solid #e2e8f0;
            font-size: 0.875rem;
        }

        tr:hover {
            background: #f8fafc;
        }

        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
            border-radius: 6px;
        }

        .btn-edit {
            background: #3b82f6;
            color: white;
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .btn-view {
            background: #8b5cf6;
            color: white;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s;
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            width: 90%;
            max-width: 700px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: slideUp 0.3s;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-header {
            padding: 2rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            color: #1e3a8a;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 2rem;
            color: #64748b;
            cursor: pointer;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .modal-close:hover {
            background: #f1f5f9;
            color: #1e3a8a;
        }

        .modal-body {
            padding: 2rem;
        }

        .detail-group {
            margin-bottom: 1.5rem;
        }

        .detail-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .detail-value {
            font-size: 1rem;
            color: #1e293b;
            padding: 0.75rem;
            background: #f8fafc;
            border-radius: 8px;
        }

        .student-name-link {
            color: #1e3a8a;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
        }

        .student-name-link:hover {
            color: #2563eb;
            text-decoration: underline;
        }

        .btn-lock {
            background: #ef4444;
            color: white;
        }

        .btn-lock:hover {
            background: #dc2626;
        }

        /* Toggle Switch */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ef4444;
            transition: 0.3s;
            border-radius: 26px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.3s;
            border-radius: 50%;
        }

        input:checked + .toggle-slider {
            background-color: #10b981;
        }

        input:checked + .toggle-slider:before {
            transform: translateX(24px);
        }

        .toggle-slider:hover {
            box-shadow: 0 0 8px rgba(0,0,0,0.2);
        }

        .toggle-label {
            display: inline-block;
            margin-left: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            vertical-align: middle;
        }

        .toggle-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .search-box {
                width: 100%;
            }
        }
        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toast {
            min-width: 350px;
            max-width: 450px;
            padding: 1.25rem 1.75rem;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slideIn 0.3s ease-out;
            position: relative;
            overflow: hidden;
        }

        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }

        .toast.hiding {
            animation: slideOut 0.3s ease-out forwards;
        }

        .toast-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .toast-error {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .toast-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .toast-info {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }

        .toast-icon {
            font-size: 1.75rem;
            flex-shrink: 0;
        }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-weight: 700;
            font-size: 1.125rem;
            margin-bottom: 0.25rem;
        }

        .toast-message {
            font-size: 0.9375rem;
            opacity: 0.95;
        }

        .toast-close {
            background: none;
            border: none;
            color: white;
            font-size: 1.75rem;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.2s;
            padding: 0;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toast-close:hover {
            opacity: 1;
        }

        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 4px;
            background: rgba(255,255,255,0.3);
            animation: progress 5s linear forwards;
        }

        @keyframes progress {
            from {
                width: 100%;
            }
            to {
                width: 0%;
            }
        }
    </style>
</head>
<body>
    <div class="toast-container" id="toastContainer"></div>
    
    <!-- Student Details Modal -->
    <div id="studentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Student Details</h2>
                <button class="modal-close" onclick="closeStudentModal()">&times;</button>
            </div>
            <div class="modal-body" id="studentDetailsContent">
                <p style="text-align: center; color: #64748b;">Loading...</p>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">ORION AI</div>
            <div class="sidebar-user">
                <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                <div class="user-info">
                    <h4>{{ auth()->user()->name }}</h4>
                    <p>Administrator</p>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-title">Main Menu</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-item active">
                    <span class="nav-icon">&#9776;</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.analytics') }}" class="nav-item">
                    <span class="nav-icon">&#128200;</span>
                    <span>Analytics</span>
                </a>
                <a href="{{ route('admin.courses.create') }}" class="nav-item">
                    <span class="nav-icon">+</span>
                    <span>Add Course</span>
                </a>
                <a href="{{ route('admin.videos.create') }}" class="nav-item">
                    <span class="nav-icon">&#9658;</span>
                    <span>Add Video</span>
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-title">Quick Stats</div>
                <div class="nav-item no-loader" onclick="switchTab('courses'); return false;">
                    <span class="nav-icon">&#9776;</span>
                    <span>Courses</span>
                    <span class="nav-badge">{{ $courses->count() }}</span>
                </div>
                <div class="nav-item no-loader" onclick="switchTab('videos'); return false;">
                    <span class="nav-icon">&#9658;</span>
                    <span>Videos</span>
                    <span class="nav-badge">{{ $totalVideos }}</span>
                </div>
                <div class="nav-item no-loader" onclick="switchTab('registrations'); return false;">
                    <span class="nav-icon">&#9787;</span>
                    <span>Students</span>
                    <span class="nav-badge">{{ $registrations->count() }}</span>
                </div>
                <div class="nav-item no-loader" onclick="switchTab('placements'); return false;">
                    <span class="nav-icon">&#9733;</span>
                    <span>Placements</span>
                    <span class="nav-badge">{{ $placements->count() }}</span>
                </div>
            </div>

            <div class="nav-section">
                <div class="nav-title">Admin Management</div>
                <a href="{{ route('admin.admins.index') }}" class="nav-item">
                    <span class="nav-icon">&#128101;</span>
                    <span>Manage Admins</span>
                </a>
                <a href="{{ route('admin.admins.create') }}" class="nav-item">
                    <span class="nav-icon">&#10133;</span>
                    <span>Add New Admin</span>
                </a>
                <a href="{{ route('admin.profile') }}" class="nav-item">
                    <span class="nav-icon">&#128100;</span>
                    <span>My Profile</span>
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-title">External</div>
                <a href="{{ route('home') }}" target="_blank" class="nav-item">
                    <span class="nav-icon">&#127760;</span>
                    <span>View Website</span>
                </a>
                <a href="{{ route('courses.index') }}" target="_blank" class="nav-item">
                    <span class="nav-icon">&#128214;</span>
                    <span>View Courses</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="nav-item" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                        <span class="nav-icon">&#10006;</span>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-title">
                <h1>Dashboard Overview</h1>
            </div>
            <div class="topbar-actions">
                <a href="{{ route('admin.courses.create') }}" class="btn btn-success">
                    + New Course
                </a>
                <a href="{{ route('admin.videos.create') }}" class="btn btn-primary">
                    + New Video
                </a>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Total Courses</div>
                        <div class="stat-icon blue">&#9776;</div>
                    </div>
                    <div class="stat-value">{{ $courses->count() }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Total Videos</div>
                        <div class="stat-icon green">&#9658;</div>
                    </div>
                    <div class="stat-value">{{ $totalVideos }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Registrations</div>
                        <div class="stat-icon purple">&#9787;</div>
                    </div>
                    <div class="stat-value">{{ $registrations->count() }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Placements</div>
                        <div class="stat-icon orange">&#9733;</div>
                    </div>
                    <div class="stat-value">{{ $placements->count() }}</div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="tabs">
                <button class="tab active no-loader" onclick="switchTab('courses', this)">&#9776; Courses</button>
                <button class="tab no-loader" onclick="switchTab('videos', this)">&#9658; Videos</button>
                <button class="tab no-loader" onclick="switchTab('registrations', this)">&#9787; Registrations</button>
                <button class="tab no-loader" onclick="switchTab('placements', this)">&#9733; Placements</button>
            </div>

            <!-- Courses Tab -->
            <div id="courses" class="tab-content active">
                <div class="content-card">
                    <div class="card-header">
                        <h2 class="card-title">All Courses</h2>
                        <input type="text" class="search-box" placeholder="Search courses..." onkeyup="searchTable(this, 'coursesTable')">
                    </div>
                    <div class="table-container">
                        <table id="coursesTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Course Name</th>
                                    <th>Videos</th>
                                    <th>Students</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($courses as $course)
                                    <tr>
                                        <td>#{{ $course->id }}</td>
                                        <td><strong>{{ $course->name }}</strong></td>
                                        <td>{{ $course->videos->count() }} videos</td>
                                        <td>{{ $course->registrations->count() }} students</td>
                                        <td>
                                            <span class="badge {{ $course->is_active ? 'badge-success' : 'badge-danger' }}">
                                                {{ $course->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                                <a href="{{ route('admin.courses.videos', $course->id) }}" class="btn btn-sm btn-view">Videos</a>
                                                <form method="POST" action="{{ route('admin.courses.destroy', $course->id) }}" style="display: inline;" onsubmit="return confirm('Delete this course?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-delete">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding: 3rem; color: #64748b;">No courses yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Videos Tab -->
            <div id="videos" class="tab-content">
                <div class="content-card">
                    <div class="card-header">
                        <h2 class="card-title">All Videos</h2>
                        <input type="text" class="search-box" placeholder="Search videos..." onkeyup="searchTable(this, 'videosTable')">
                    </div>
                    <div class="table-container">
                        <table id="videosTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Video Title</th>
                                    <th>Course</th>
                                    <th>Order</th>
                                    <th>Access</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($allVideos as $video)
                                    <tr>
                                        <td>#{{ $video->id }}</td>
                                        <td><strong>{{ $video->title }}</strong></td>
                                        <td>{{ $video->course->name }}</td>
                                        <td>{{ $video->order }}</td>
                                        <td>
                                            <span class="badge {{ $video->is_free ? 'badge-success' : 'badge-warning' }}">
                                                {{ $video->is_free ? 'Free' : 'Locked' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('admin.videos.edit', $video->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                                <form method="POST" action="{{ route('admin.videos.destroy', $video->id) }}" style="display: inline;" onsubmit="return confirm('Delete this video?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-delete">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding: 3rem; color: #64748b;">No videos yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Registrations Tab -->
            <div id="registrations" class="tab-content">
                <div class="content-card">
                    <div class="card-header">
                        <h2 class="card-title">Student Registrations</h2>
                        <input type="text" class="search-box" placeholder="Search students..." onkeyup="searchTable(this, 'registrationsTable')">
                    </div>
                    <div class="table-container">
                        <table id="registrationsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Course</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($registrations as $reg)
                                    <tr>
                                        <td>#{{ $reg->id }}</td>
                                        <td>
                                            <a href="#" class="student-name-link" onclick="showStudentDetails({{ $reg->id }}); return false;">
                                                {{ $reg->name }}
                                            </a>
                                        </td>
                                        <td>{{ $reg->email }}</td>
                                        <td>{{ $reg->course->name }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.updateRegistrationStatus', $reg->id) }}" style="display: inline;">
                                                @csrf
                                                <select name="status" onchange="this.form.submit()" class="badge badge-{{ $reg->status == 'verified' ? 'success' : ($reg->status == 'contacted' ? 'info' : 'warning') }}" style="border: none; cursor: pointer;">
                                                    <option value="pending" {{ $reg->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="contacted" {{ $reg->status == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                                    <option value="verified" {{ $reg->status == 'verified' ? 'selected' : '' }}>Verified</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('admin.downloadFile', ['type' => 'resume', 'id' => $reg->id]) }}" class="btn btn-sm btn-view">Resume</a>
                                                <a href="{{ route('admin.downloadFile', ['type' => 'marksheet', 'id' => $reg->id]) }}" class="btn btn-sm btn-view">Marksheet</a>
                                                <div class="toggle-container">
                                                    <form method="POST" action="{{ route('admin.toggleCourseLock', $reg->id) }}" id="toggleForm{{ $reg->id }}" style="display: inline;">
                                                        @csrf
                                                        <label class="toggle-switch">
                                                            <input type="checkbox" 
                                                                   {{ $reg->course_unlocked ? 'checked' : '' }} 
                                                                   onchange="if(confirm('{{ $reg->course_unlocked ? 'Lock' : 'Unlock' }} course for {{ $reg->name }}?')) { this.form.submit(); } else { this.checked = !this.checked; }">
                                                            <span class="toggle-slider"></span>
                                                        </label>
                                                    </form>
                                                    <span class="toggle-label">{{ $reg->course_unlocked ? 'Unlocked' : 'Locked' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding: 3rem; color: #64748b;">No registrations yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Placements Tab -->
            <div id="placements" class="tab-content">
                <div class="content-card">
                    <div class="card-header">
                        <h2 class="card-title">Placement Enrollments</h2>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($placements as $placement)
                                    <tr>
                                        <td>#{{ $placement->id }}</td>
                                        <td>{{ $placement->email }}</td>
                                        <td>{{ $placement->phone }}</td>
                                        <td><strong>₹{{ number_format($placement->amount, 2) }}</strong></td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.updatePlacementStatus', $placement->id) }}" style="display: inline;">
                                                @csrf
                                                <select name="status" onchange="this.form.submit()" class="badge badge-{{ $placement->status == 'completed' ? 'success' : ($placement->status == 'enrolled' ? 'info' : ($placement->status == 'contacted' ? 'warning' : 'danger')) }}" style="border: none; cursor: pointer;">
                                                    <option value="pending" {{ $placement->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="contacted" {{ $placement->status == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                                    <option value="enrolled" {{ $placement->status == 'enrolled' ? 'selected' : '' }}>Enrolled</option>
                                                    <option value="completed" {{ $placement->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>{{ $placement->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding: 3rem; color: #64748b;">No placement enrollments yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Dashboard loaded successfully');
            console.log('Courses tab:', document.getElementById('courses'));
            console.log('Videos tab:', document.getElementById('videos'));
            console.log('Registrations tab:', document.getElementById('registrations'));
            console.log('Placements tab:', document.getElementById('placements'));
        });

        function switchTab(tabName, element) {
            console.log('Switching to tab:', tabName);
            
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.tab').forEach(btn => {
                btn.classList.remove('active');
            });

            // Show selected tab
            const selectedTab = document.getElementById(tabName);
            if (selectedTab) {
                selectedTab.classList.add('active');
                console.log('Tab activated:', tabName);
            } else {
                console.error('Tab not found:', tabName);
            }
            
            // Activate the clicked tab button
            if (element) {
                element.classList.add('active');
            } else {
                // If called from sidebar, activate the corresponding tab button
                const tabButtons = document.querySelectorAll('.tab');
                tabButtons.forEach(btn => {
                    const btnText = btn.textContent.toLowerCase();
                    if (btnText.includes(tabName)) {
                        btn.classList.add('active');
                    }
                });
            }
            
            return false; // Prevent any default action
        }

        function searchTable(input, tableId) {
            const filter = input.value.toUpperCase();
            const table = document.getElementById(tableId);
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                let found = false;
                const td = tr[i].getElementsByTagName('td');
                
                for (let j = 0; j < td.length; j++) {
                    if (td[j]) {
                        const txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }
                
                tr[i].style.display = found ? '' : 'none';
            }
        }

        // Toast Notification System
        function showToast(message, type = 'success', title = null) {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            
            const icons = {
                success: '&#10003;',
                error: '&#10005;',
                warning: '&#9888;',
                info: '&#9432;'
            };

            const titles = {
                success: title || 'Success',
                error: title || 'Error',
                warning: title || 'Warning',
                info: title || 'Info'
            };

            toast.innerHTML = `
                <div class="toast-icon">${icons[type]}</div>
                <div class="toast-content">
                    <div class="toast-title">${titles[type]}</div>
                    <div class="toast-message">${message}</div>
                </div>
                <button class="toast-close" onclick="closeToast(this)">&times;</button>
                <div class="toast-progress"></div>
            `;

            container.appendChild(toast);

            // Auto remove after 5 seconds
            setTimeout(() => {
                closeToast(toast.querySelector('.toast-close'));
            }, 5000);
        }

        function closeToast(button) {
            const toast = button.closest('.toast');
            toast.classList.add('hiding');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }

        // Show Laravel session messages as toasts
        @if(session('success'))
            showToast("{{ session('success') }}", 'success');
        @endif

        @if(session('error'))
            showToast("{{ session('error') }}", 'error');
        @endif

        @if($errors->any())
            @foreach($errors->all() as $error)
                showToast("{{ $error }}", 'error');
            @endforeach
        @endif

        // Student Details Modal
        const registrationsData = {!! $registrations->toJson() !!};

        function showStudentDetails(id) {
            const student = registrationsData.find(s => s.id === id);
            if (!student) {
                showToast('Student not found', 'error');
                return;
            }

            const internships = Array.isArray(student.internship_experience) 
                ? student.internship_experience 
                : (student.internship_experience ? JSON.parse(student.internship_experience) : []);

            const internshipHTML = internships.length > 0 
                ? internships.map((int, idx) => `
                    <div style="background: white; padding: 1rem; border-radius: 8px; margin-bottom: 0.5rem; border-left: 3px solid #3b82f6;">
                        <strong>Internship ${idx + 1}:</strong><br>
                        <strong>Company:</strong> ${int.company || 'N/A'}<br>
                        <strong>Role:</strong> ${int.role || 'N/A'}<br>
                        <strong>Duration:</strong> ${int.duration || 'N/A'}
                    </div>
                `).join('')
                : '<p style="color: #64748b;">No internship experience</p>';

            const content = `
                <div class="detail-group">
                    <div class="detail-label">Full Name</div>
                    <div class="detail-value"><strong>${student.name}</strong></div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Email Address</div>
                    <div class="detail-value">${student.email}</div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Course Enrolled</div>
                    <div class="detail-value">${student.course.name}</div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">CGPA</div>
                    <div class="detail-value">${student.cgpa || 'Not provided'}</div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Education Details</div>
                    <div class="detail-value">${student.education_details || 'Not provided'}</div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Internship Experience</div>
                    <div class="detail-value">${internshipHTML}</div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Extracurricular Activities</div>
                    <div class="detail-value">${student.extracurricular_activities || 'Not provided'}</div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Career Goal</div>
                    <div class="detail-value">${student.goal || 'Not provided'}</div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Suitable Role</div>
                    <div class="detail-value">${student.suitable_role || 'Not provided'}</div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Expected CTC</div>
                    <div class="detail-value">₹${student.expected_ctc ? parseFloat(student.expected_ctc).toLocaleString('en-IN') : 'Not provided'}</div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Registration Status</div>
                    <div class="detail-value">
                        <span class="badge badge-${student.status === 'verified' ? 'success' : (student.status === 'contacted' ? 'info' : 'warning')}">
                            ${student.status.toUpperCase()}
                        </span>
                    </div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Course Access</div>
                    <div class="detail-value">
                        <span class="badge badge-${student.course_unlocked ? 'success' : 'danger'}">
                            ${student.course_unlocked ? '✓ Unlocked' : '✗ Locked'}
                        </span>
                    </div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Registration Date</div>
                    <div class="detail-value">${new Date(student.created_at).toLocaleString('en-US', { 
                        year: 'numeric', 
                        month: 'long', 
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    })}</div>
                </div>
            `;

            document.getElementById('studentDetailsContent').innerHTML = content;
            document.getElementById('studentModal').classList.add('active');
        }

        function closeStudentModal() {
            document.getElementById('studentModal').classList.remove('active');
        }

        // Close modal when clicking outside
        document.getElementById('studentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeStudentModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeStudentModal();
            }
        });

    </script>
</body>
</html>
