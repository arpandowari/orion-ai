<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - ORION AI</title>
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

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
        }

        /* Chart Container */
        .chart-container {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .chart-title h2 {
            color: #1e3a8a;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .chart-title p {
            color: #64748b;
            font-size: 0.875rem;
        }

        .chart-legend {
            display: flex;
            gap: 1.5rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .legend-dot.blue {
            background: #3b82f6;
        }

        .legend-dot.green {
            background: #10b981;
        }

        .legend-text {
            font-size: 0.875rem;
            color: #64748b;
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
        }
    </style>
</head>
<body>
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
                <a href="{{ route('admin.dashboard') }}" class="nav-item">
                    <span class="nav-icon">&#9776;</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.analytics') }}" class="nav-item active">
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
                <h1>Analytics Overview</h1>
            </div>
            <div class="topbar-actions">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                    ← Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Total Registrations</div>
                        <div class="stat-icon blue">&#9787;</div>
                    </div>
                    <div class="stat-value">{{ $registrations->count() }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Total Placements</div>
                        <div class="stat-icon green">&#9733;</div>
                    </div>
                    <div class="stat-value">{{ $placements->count() }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">This Week (Registrations)</div>
                        <div class="stat-icon blue">&#128197;</div>
                    </div>
                    <div class="stat-value">{{ $registrations->where('created_at', '>=', now()->subDays(7))->count() }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">This Week (Placements)</div>
                        <div class="stat-icon green">&#128197;</div>
                    </div>
                    <div class="stat-value">{{ $placements->where('created_at', '>=', now()->subDays(7))->count() }}</div>
                </div>
            </div>

            <!-- Analytics Chart -->
            <div class="chart-container">
                <div class="chart-header">
                    <div class="chart-title">
                        <h2>7-Day Trend Analysis</h2>
                        <p>Registrations and enrollments over the last 7 days</p>
                    </div>
                    <div class="chart-legend">
                        <div class="legend-item">
                            <div class="legend-dot blue"></div>
                            <span class="legend-text">Course Registrations</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-dot green"></div>
                            <span class="legend-text">Placement Enrollments</span>
                        </div>
                    </div>
                </div>
                <canvas id="analyticsChart" style="max-height: 400px;"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Analytics Chart
        window.addEventListener('load', function() {
            const ctx = document.getElementById('analyticsChart');
            if (!ctx) {
                console.error('Analytics chart canvas not found');
                return;
            }

            if (typeof Chart === 'undefined') {
                console.error('Chart.js not loaded');
                return;
            }

            console.log('Initializing analytics chart...');
            
            // Get last 7 days
            const last7Days = [];
            const registrationData = [];
            const placementData = [];
            
            const registrations = {!! $registrations->toJson() !!};
            const placements = {!! $placements->toJson() !!};
            
            for (let i = 6; i >= 0; i--) {
                const date = new Date();
                date.setDate(date.getDate() - i);
                last7Days.push(date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
                
                // Count registrations for this date
                const regCount = registrations.filter(reg => {
                    const regDate = new Date(reg.created_at);
                    return regDate.toDateString() === date.toDateString();
                }).length;
                registrationData.push(regCount);
                
                // Count placements for this date
                const placeCount = placements.filter(place => {
                    const placeDate = new Date(place.created_at);
                    return placeDate.toDateString() === date.toDateString();
                }).length;
                placementData.push(placeCount);
            }

            try {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: last7Days,
                        datasets: [
                            {
                                label: 'Course Registrations',
                                data: registrationData,
                                borderColor: '#3b82f6',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 5,
                                pointHoverRadius: 7,
                                pointBackgroundColor: '#3b82f6',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2
                            },
                            {
                                label: 'Placement Enrollments',
                                data: placementData,
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 5,
                                pointHoverRadius: 7,
                                pointBackgroundColor: '#10b981',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                borderRadius: 8,
                                titleFont: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 13
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    font: {
                                        size: 12
                                    },
                                    color: '#64748b'
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)',
                                    drawBorder: false
                                }
                            },
                            x: {
                                ticks: {
                                    font: {
                                        size: 12
                                    },
                                    color: '#64748b'
                                },
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
                console.log('Analytics chart initialized successfully');
            } catch (error) {
                console.error('Error initializing chart:', error);
            }
        });
    </script>
</body>
</html>
