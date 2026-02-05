<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TradeMaster Terminal | @yield('title', 'Dashboard')</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Roboto+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- App Scripts & Styles -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/dashboard.css', 'resources/js/app.js'])
</head>
<body>
    <div class="app-container">
        <!-- Sidebar Navigation -->
        <nav class="sidebar">
            <div class="brand-icon">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            
            <a href="{{ url('/') }}" class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                <div class="nav-icon"><i class="fa-solid fa-chart-line"></i></div>
                <span class="nav-label">Dashboard</span>
            </a>
            
            <a href="{{ url('/journal') }}" class="nav-item {{ Request::is('journal') ? 'active' : '' }}">
                <div class="nav-icon"><i class="fa-solid fa-book"></i></div>
                <span class="nav-label">Journal</span>
            </a>
            
            <a href="{{ url('/strategies') }}" class="nav-item {{ Request::is('strategies') ? 'active' : '' }}">
                <div class="nav-icon"><i class="fa-solid fa-chess-knight"></i></div>
                <span class="nav-label">Strategies</span>
            </a>
            
            <a href="#" class="nav-item">
                <div class="nav-icon"><i class="fa-solid fa-calendar"></i></div>
                <span class="nav-label">Calendar</span>
            </a>
            
            <a href="#" class="nav-item" style="margin-top: auto;">
                <div class="nav-icon"><i class="fa-solid fa-gear"></i></div>
                <span class="nav-label">Settings</span>
            </a>
        </nav>

        <!-- Main Workspace -->
        <div class="main-wrapper">
            <!-- Top Header -->
            <header class="topbar">
                <div class="breadcrumbs">
                    <i class="fa-solid fa-house" style="margin-right: 8px;"></i>
                    <span>App</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i>
                    <span class="current">@yield('title', 'Page')</span>
                </div>
                
                <div class="user-menu">
                    <button class="btn-icon"><i class="fa-regular fa-bell"></i></button>
                    <div style="width: 32px; height: 32px; background: #2a2e39; border-radius: 50%;"></div>
                </div>
            </header>

            <!-- Dynamic Content -->
            <main class="content-area">
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Page Specific Scripts -->
    @yield('scripts')
</body>
</html>
