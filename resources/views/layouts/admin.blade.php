<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - ORION AI')</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
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

        :root {
            --primary: #1e3a8a;
            --secondary: #3b82f6;
            --accent: #60a5fa;
            --dark: #1e293b;
            --light: #f8fafc;
            --success: #10b981;
            --warning: #f59e0b;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--dark);
            background: var(--light);
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }

        .nav-menu {
            display: flex;
            gap: 1.5rem;
            list-style: none;
            align-items: center;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-menu a:hover {
            color: var(--accent);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        .admin-layout {
            display: flex;
            gap: 2rem;
            min-height: calc(100vh - 200px);
        }

        .sidebar {
            width: 250px;
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            max-height: calc(100vh - 120px);
            overflow-y: auto;
            position: sticky;
            top: 100px;
        }

        .sidebar-header {
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--light);
            margin-bottom: 1rem;
        }

        .sidebar-header h2 {
            color: var(--primary);
            font-size: 1.25rem;
            margin-bottom: 0.25rem;
        }

        .sidebar-header p {
            color: #64748b;
            font-size: 0.875rem;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: all 0.3s;
        }

        .sidebar-menu a:hover {
            background: var(--light);
            color: var(--secondary);
        }

        .sidebar-menu a.active {
            background: var(--secondary);
            color: white;
        }

        .sidebar-menu .icon {
            font-size: 1.25rem;
        }

        .sidebar-section {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 2px solid var(--light);
        }

        .sidebar-section-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 0.75rem;
            padding-left: 1rem;
        }

        .main-content {
            flex: 1;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--secondary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary);
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid var(--success);
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        footer {
            background: var(--dark);
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 4rem;
        }

        @media (max-width: 768px) {
            .admin-layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                position: relative;
                top: 0;
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
            min-width: 300px;
            max-width: 400px;
            padding: 1rem 1.5rem;
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
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .toast-message {
            font-size: 0.875rem;
            opacity: 0.95;
        }

        .toast-close {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.2s;
            padding: 0;
            width: 24px;
            height: 24px;
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

        @media (max-width: 768px) {
            .toast-container {
                right: 10px;
                left: 10px;
            }

            .toast {
                min-width: auto;
                max-width: none;
            }
        }

        /* Page Transition Loader */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.95);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            backdrop-filter: blur(5px);
        }

        .page-loader.active {
            display: flex;
        }

        .loader-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #e2e8f0;
            border-top-color: var(--secondary);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .loader-text {
            position: absolute;
            margin-top: 80px;
            color: var(--dark);
            font-weight: 600;
            font-size: 0.875rem;
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Page Transition Loader -->
    <div class="page-loader" id="pageLoader">
        <div>
            <div class="loader-spinner"></div>
            <div class="loader-text">Loading...</div>
        </div>
    </div>

    <div class="toast-container" id="toastContainer"></div>
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('admin.dashboard') }}" class="logo">ORION AI - Admin</a>
            <ul class="nav-menu">
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('admin.analytics') }}">Analytics</a></li>
                <li><a href="{{ route('admin.admins.index') }}">Admins</a></li>
                <li><a href="{{ route('admin.profile') }}">Profile</a></li>
                <li><a href="{{ route('home') }}" target="_blank">Website</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: white; cursor: pointer; font-weight: 500; font-size: 1rem;">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <main>
        <div class="container">
            <div class="admin-layout">
                <!-- Sidebar -->
                <aside class="sidebar">
                    <div class="sidebar-header">
                        <h2>Admin Panel</h2>
                        <p>{{ auth()->user()->name }}</p>
                    </div>

                    <ul class="sidebar-menu">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <span class="icon">📊</span>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.analytics') }}" class="{{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
                                <span class="icon">📈</span>
                                <span>Analytics</span>
                            </a>
                        </li>
                    </ul>

                    <div class="sidebar-section">
                        <div class="sidebar-section-title">Course Management</div>
                        <ul class="sidebar-menu">
                            <li>
                                <a href="{{ route('admin.courses.create') }}" class="{{ request()->routeIs('admin.courses.create') ? 'active' : '' }}">
                                    <span class="icon">➕</span>
                                    <span>Add Course</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.videos.create') }}" class="{{ request()->routeIs('admin.videos.create') ? 'active' : '' }}">
                                    <span class="icon">🎬</span>
                                    <span>Add Video</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="sidebar-section">
                        <div class="sidebar-section-title">Admin Management</div>
                        <ul class="sidebar-menu">
                            <li>
                                <a href="{{ route('admin.admins.index') }}" class="{{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                                    <span class="icon">👥</span>
                                    <span>Manage Admins</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.admins.create') }}" class="{{ request()->routeIs('admin.admins.create') ? 'active' : '' }}">
                                    <span class="icon">➕</span>
                                    <span>Add New Admin</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.profile') }}" class="{{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                                    <span class="icon">👤</span>
                                    <span>My Profile</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="sidebar-section">
                        <div class="sidebar-section-title">Navigation</div>
                        <ul class="sidebar-menu">
                            <li>
                                <a href="{{ route('home') }}" target="_blank">
                                    <span class="icon">🌐</span>
                                    <span>View Website</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('courses.index') }}" target="_blank">
                                    <span class="icon">📖</span>
                                    <span>View Courses</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </aside>

                <!-- Main Content -->
                <div class="main-content">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 ORION AI. All rights reserved.</p>
    </footer>

    <script>
        // Page Transition Loader
        const pageLoader = document.getElementById('pageLoader');

        // Show loader on page navigation
        document.addEventListener('DOMContentLoaded', function() {
            // Hide loader when page is fully loaded
            pageLoader.classList.remove('active');

            // Show loader when clicking links
            const links = document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not(.no-loader)');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Don't show loader for same page links
                    if (this.href === window.location.href) return;
                    
                    pageLoader.classList.add('active');
                });
            });

            // Show loader on form submissions
            const forms = document.querySelectorAll('form:not(.no-loader)');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    pageLoader.classList.add('active');
                });
            });

            // Hide loader if navigation is cancelled (back button, etc.)
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    pageLoader.classList.remove('active');
                }
            });
        });

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
    </script>

    @yield('scripts')
</body>
</html>
