<nav class="sidebar">
    <div class="brand-wrapper">
        <div class="brand-icon">
            <i class="fa-brands fa-hive"></i>
        </div>
        <div class="brand-text">
            <span>TRADEMASTER</span>
            <span class="brand-sub">TERMINAL PRO</span>
        </div>
    </div>
    
    <a href="{{ url('/') }}" class="nav-item {{ Request::is('/') ? 'active' : '' }}">
        <div class="nav-icon"><i class="fa-solid fa-chart-line"></i></div>
        <span class="nav-label">Dashboard</span>
    </a>
    
    <a href="{{ url('/journal') }}" class="nav-item {{ Request::is('journal') ? 'active' : '' }}">
        <div class="nav-icon"><i class="fa-solid fa-book-journal-whills"></i></div>
        <span class="nav-label">Journal</span>
    </a>
    
    <a href="{{ url('/strategies') }}" class="nav-item {{ Request::is('strategies') ? 'active' : '' }}">
        <div class="nav-icon"><i class="fa-solid fa-chess-knight"></i></div>
        <span class="nav-label">Strategies</span>
    </a>
    
    <a href="#" class="nav-item">
        <div class="nav-icon"><i class="fa-solid fa-calendar-days"></i></div>
        <span class="nav-label">Calendar</span>
    </a>

    <a href="#" class="nav-item">
        <div class="nav-icon"><i class="fa-solid fa-newspaper"></i></div>
        <span class="nav-label">News Feed</span>
    </a>
    
    <a href="#" class="nav-item" style="margin-top: auto;">
        <div class="nav-icon"><i class="fa-solid fa-gear"></i></div>
        <span class="nav-label">Settings</span>
    </a>

    <!-- Logout -->
    <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
        @csrf
        <button type="submit" class="nav-item" style="background: none; border: none; cursor: pointer; color: inherit; font-family: inherit; width: 100%; text-align: left;">
            <div class="nav-icon"><i class="fa-solid fa-right-from-bracket" style="color: var(--accent-crimson);"></i></div>
            <span class="nav-label" style="color: var(--accent-crimson);">Logout</span>
        </button>
    </form>
</nav>
