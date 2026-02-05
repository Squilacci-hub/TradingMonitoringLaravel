<header class="topbar">
    <div style="display: flex; align-items: center;">
        <div class="breadcrumbs">
            <i class="fa-solid fa-cube" style="color: var(--accent-blue); margin-right: 10px;"></i>
            <span style="font-weight: 500; font-size: 14px;">Workspace</span>
            <i class="fa-solid fa-chevron-right" style="font-size: 8px; margin: 0 10px; opacity: 0.5;"></i>
            <span class="current" style="color: var(--text-primary); font-weight: 600;">@yield('title', 'Page')</span>
        </div>

        <!-- Global Search -->
        <div class="search-bar">
            <i class="fa-solid fa-magnifying-glass" style="color: var(--text-secondary);"></i>
            <input type="text" class="search-input" placeholder="Search ticker (e.g. BTCUSD)...">
            <span style="font-size: 10px; background: rgba(255,255,255,0.1); padding: 2px 6px; border-radius: 4px; color: var(--text-secondary);">CTRL+K</span>
        </div>
    </div>
    
    <div class="topbar-actions">
        <button class="action-btn"><i class="fa-regular fa-bell"></i></button>
        <button class="action-btn"><i class="fa-solid fa-inbox"></i></button>
        
        <div class="user-profile-pill">
            <div class="user-avatar"></div>
            <div style="display: flex; flex-direction: column; line-height: 1.2;">
                <span style="font-size: 12px; font-weight: 600;">{{ Auth::user()->name }}</span>
                <span style="font-size: 10px; color: var(--accent-emerald);">TRADER</span>
            </div>
            <i class="fa-solid fa-caret-down" style="font-size: 10px; margin-left: 4px; opacity: 0.5;"></i>
        </div>
    </div>
</header>
