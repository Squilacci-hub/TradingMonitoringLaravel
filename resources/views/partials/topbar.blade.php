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
            <span
                style="font-size: 10px; background: rgba(255,255,255,0.1); padding: 2px 6px; border-radius: 4px; color: var(--text-secondary);">CTRL+K</span>
        </div>
    </div>

    <div class="topbar-actions">
        <!-- Account Switcher Dropdown -->

        <!-- Account Switcher Dropdown -->
        <div class="account-selector" style="position: relative;">
            <div class="account-pill" onclick="document.getElementById('account-dropdown').classList.toggle('active')"
                style="display: flex; align-items: center; background: rgba(255,255,255,0.05); padding: 4px 12px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.1); margin-right: 15px; cursor: pointer;">
                <i class="fa-solid fa-wallet"
                    style="font-size: 12px; color: var(--accent-emerald); margin-right: 8px;"></i>
                <div style="display: flex; flex-direction: column; line-height: 1.1;">
                    <span style="font-size: 9px; color: var(--text-secondary); text-transform: uppercase;">Compte</span>
                    <span style="font-size: 11px; font-weight: 600; color: var(--text-primary);">
                        @php
                            $activeAccountId = session('active_account_id') ?? Auth::user()->tradingAccounts()->first()?->id;
                            $activeAccount = Auth::user()->tradingAccounts()->find($activeAccountId);
                        @endphp
                        {{ $activeAccount->name ?? 'Aucun compte' }}
                    </span>
                </div>
                <i class="fa-solid fa-chevron-down" style="font-size: 9px; margin-left: 8px; opacity: 0.5;"></i>
            </div>

            <div id="account-dropdown" class="dropdown-menu"
                style="display: none; position: absolute; top: 100%; right: 15px; background: #1c202e; border: 1px solid #2a2e39; border-radius: 4px; z-index: 1000; min-width: 180px; margin-top: 10px; box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
                <div
                    style="padding: 10px; font-size: 10px; color: var(--text-secondary); border-bottom: 1px solid #2a2e39;">
                    MES COMPTES</div>
                @foreach(Auth::user()->tradingAccounts as $account)
                    <a href="{{ route('accounts.select', $account->id) }}"
                        style="display: block; padding: 10px; color: white; text-decoration: none; font-size: 12px; border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <i class="fa-solid fa-circle {{ $account->id == $activeAccountId ? 'text-emerald' : '' }}"
                            style="font-size: 6px; margin-right: 8px; vertical-align: middle; color: {{ $account->id == $activeAccountId ? 'var(--accent-emerald)' : 'transparent' }}"></i>
                        {{ $account->name }}
                    </a>
                @endforeach
                <a href="{{ route('accounts.link') }}"
                    style="display: block; padding: 10px; color: var(--accent-emerald); text-decoration: none; font-size: 12px; border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <i class="fa-solid fa-link" style="margin-right: 8px;"></i> Associer Compte Réel (MT5)
                </a>
                <a href="{{ route('accounts.create') }}"
                    style="display: block; padding: 10px; color: var(--accent-blue); text-decoration: none; font-size: 12px;">
                    <i class="fa-solid fa-plus" style="margin-right: 8px;"></i> Créer un compte manuel
                </a>

            </div>
        </div>

        @if(isset($activeAccount) && $activeAccount->broker_login)
            <form action="{{ route('accounts.sync', $activeAccount->id) }}" method="POST" style="margin-right: 15px;">
                @csrf
                <button type="submit" class="action-btn" title="Synchroniser avec MT5"
                    style="color: var(--accent-emerald); background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2);">
                    <i class="fa-solid fa-rotate"></i>
                    <span style="font-size: 11px; margin-left: 5px; font-weight: 600;">SYNC</span>
                </button>
            </form>
        @endif

        <button class="action-btn" id="theme-toggle" title="Basculer le thème">
            <i class="fas fa-sun"></i>
        </button>

        <button class="action-btn"><i class="fa-regular fa-bell"></i></button>


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

<style>
    .dropdown-menu.active {
        display: block !important;
    }
</style>