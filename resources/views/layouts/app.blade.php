<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ORION AI - Learn & Grow')</title>
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
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            padding: 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(30,58,138,0.1);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }

        .logo {
            font-size: 1.75rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
            letter-spacing: -0.5px;
            transition: all 0.3s;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .nav-menu {
            display: flex;
            gap: 0.5rem;
            list-style: none;
            align-items: center;
        }

        .nav-menu li {
            position: relative;
        }

        .nav-menu a, .nav-menu button {
            color: var(--dark);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9375rem;
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            transition: all 0.3s;
            display: inline-block;
            position: relative;
            background: none;
            border: none;
            cursor: pointer;
        }

        .nav-menu a:hover, .nav-menu button:hover {
            background: rgba(59,130,246,0.1);
            color: var(--secondary);
            transform: translateY(-2px);
        }

        .nav-menu a.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(59,130,246,0.3);
        }

        .nav-menu a.active:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59,130,246,0.4);
        }

        .nav-btn-login {
            background: transparent;
            color: var(--secondary);
            border: 2px solid var(--secondary);
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .nav-btn-login:hover {
            background: var(--secondary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59,130,246,0.3);
        }

        .nav-btn-logout {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            transition: all 0.3s;
        }

        .nav-btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239,68,68,0.3);
        }

        .nav-badge {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--accent) 100%);
            color: white;
            padding: 0.25rem 0.625rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 700;
            margin-left: 0.5rem;
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            z-index: 1001;
        }

        .hamburger {
            width: 28px;
            height: 20px;
            position: relative;
            transform: rotate(0deg);
            transition: 0.5s ease-in-out;
        }

        .hamburger span {
            display: block;
            position: absolute;
            height: 3px;
            width: 100%;
            background: var(--primary);
            border-radius: 3px;
            opacity: 1;
            left: 0;
            transform: rotate(0deg);
            transition: 0.25s ease-in-out;
        }

        .hamburger span:nth-child(1) {
            top: 0px;
        }

        .hamburger span:nth-child(2) {
            top: 8px;
        }

        .hamburger span:nth-child(3) {
            top: 16px;
        }

        .mobile-menu-toggle.active .hamburger span:nth-child(1) {
            top: 8px;
            transform: rotate(135deg);
        }

        .mobile-menu-toggle.active .hamburger span:nth-child(2) {
            opacity: 0;
            left: -60px;
        }

        .mobile-menu-toggle.active .hamburger span:nth-child(3) {
            top: 8px;
            transform: rotate(-135deg);
        }

        @media (max-width: 968px) {
            .nav-container {
                padding: 0 1.5rem;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .nav-menu {
                position: fixed;
                top: 70px;
                right: -100%;
                width: 300px;
                height: calc(100vh - 70px);
                background: white;
                flex-direction: column;
                padding: 2rem 0;
                box-shadow: -5px 0 20px rgba(0,0,0,0.1);
                transition: right 0.3s ease-in-out;
                overflow-y: auto;
                gap: 0;
            }

            .nav-menu.active {
                right: 0;
            }

            .nav-menu li {
                width: 100%;
            }

            .nav-menu a, .nav-menu button {
                width: 100%;
                text-align: left;
                padding: 1rem 2rem;
                border-radius: 0;
                justify-content: flex-start;
            }

            .nav-menu a.active {
                border-left: 4px solid var(--secondary);
            }

            .nav-menu form {
                width: 100%;
            }

            .nav-btn-login, .nav-btn-logout {
                width: calc(100% - 4rem);
                margin: 0 2rem;
                text-align: center;
            }

            .logo {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .nav-container {
                padding: 0 1rem;
                height: 60px;
            }

            .logo {
                font-size: 1.25rem;
            }

            .nav-menu {
                top: 60px;
                height: calc(100vh - 60px);
                width: 100%;
            }

            .container {
                padding: 1rem;
            }
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            width: 100%;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1.5rem 1rem;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 1rem;
            }
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
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .btn-outline {
            background: transparent;
            color: var(--secondary);
            border: 2px solid var(--secondary);
        }

        .btn-outline:hover {
            background: var(--secondary);
            color: white;
        }

        footer {
            background: var(--dark);
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 4rem;
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
            <a href="{{ route('home') }}" class="logo">ORION AI</a>
            
            <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle menu">
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>

            <ul class="nav-menu" id="navMenu">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('placement.index') }}" class="{{ request()->routeIs('placement.*') ? 'active' : '' }}">Placement Series</a></li>
                <li><a href="{{ route('courses.index') }}" class="{{ request()->routeIs('courses.*') ? 'active' : '' }}">Courses</a></li>
                @auth
                    @if(auth()->user()->is_admin)
                        <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">Admin<span class="nav-badge">Panel</span></a></li>
                    @endif
                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline; margin: 0;">
                            @csrf
                            <button type="submit" class="nav-btn-logout">Logout</button>
                        </form>
                    </li>
                @elseif(session('student_id'))
                    <li><a href="{{ route('student.dashboard') }}" class="{{ request()->routeIs('student.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                    <li><a href="{{ route('student.profile') }}" class="{{ request()->routeIs('student.profile') ? 'active' : '' }}">My Profile</a></li>
                    <li>
                        <form method="POST" action="{{ route('student.logout') }}" style="display: inline; margin: 0;">
                            @csrf
                            <button type="submit" class="nav-btn-logout">Logout</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="nav-btn-login">Login</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    <main>
        @yield('content')
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

        // Mobile Menu Toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const navMenu = document.getElementById('navMenu');

        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function() {
                this.classList.toggle('active');
                navMenu.classList.toggle('active');
            });

            // Close menu when clicking on a link
            const navLinks = navMenu.querySelectorAll('a');
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenuToggle.classList.remove('active');
                    navMenu.classList.remove('active');
                });
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                const isClickInside = navMenu.contains(event.target) || mobileMenuToggle.contains(event.target);
                if (!isClickInside && navMenu.classList.contains('active')) {
                    mobileMenuToggle.classList.remove('active');
                    navMenu.classList.remove('active');
                }
            });
        }
    </script>

    @yield('scripts')
</body>
</html>
