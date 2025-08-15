<!-- BEGIN: Horizontal Menu -->
<button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-light " id="m_aside_header_menu_mobile_close_btn">
    <i class="la la-close"></i>
</button>
<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-light m-aside-header-menu-mobile--submenu-skin-light "  >
    <!-- Mobile Menu (new structure) - Moved to top -->
    <div class="mobile-menu-container">
        <!-- About Item -->
        <div class="mobile-menu-item">
            <a href="{{route('about')}}" class="mobile-menu-link">
                <div class="mobile-menu-icon">
                    <i class="la la-info-circle"></i>
                </div>
                <span class="mobile-menu-text" data-lang-key="about">About</span>
            </a>
        </div>

        <!-- Dashboard Item -->
        <div class="mobile-menu-item">
            <div class="mobile-menu-link mobile-menu-toggle" data-toggle="dashboard-submenu">
                <div class="mobile-menu-icon">
                    <i class="la la-dashboard"></i>
                </div>
                <span class="mobile-menu-text" data-lang-key="dashboard">Dashboard</span>
                <i class="mobile-menu-arrow la la-angle-down"></i>
            </div>
            <div class="mobile-submenu" id="dashboard-submenu">
                <div class="mobile-submenu-item">
                    <a href="/" class="mobile-submenu-link">
                        <i class="la la-chart-line"></i>
                        <span data-lang-key="live_coin_watch">Live Coin Watch</span>
                    </a>
                </div>
                <div class="mobile-submenu-item">
                    <a href="/coingeckomarketsindex" class="mobile-submenu-link">
                        <i class="la la-bitcoin"></i>
                        <span data-lang-key="coingecko">Coingecko</span>
                    </a>
                </div>
                <div class="mobile-submenu-item">
                    <a href="/coinmarketcalindex" class="mobile-submenu-link">
                        <i class="la la-calendar"></i>
                        <span data-lang-key="coin_market_cal">Coin Market Cal</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Auth Links (Mobile) -->
        @guest
            <div class="mobile-menu-item">
                <a href="{{ route('login') }}" class="mobile-menu-link">
                    <div class="mobile-menu-icon"><i class="la la-sign-in"></i></div>
                    <span class="mobile-menu-text">Login</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('register') }}" class="mobile-menu-link">
                    <div class="mobile-menu-icon"><i class="la la-user-plus"></i></div>
                    <span class="mobile-menu-text">Register</span>
                </a>
            </div>
        @else
            <div class="mobile-menu-item">
                <a href="{{ route('account.index') }}" class="mobile-menu-link">
                    <div class="mobile-menu-icon"><i class="la la-user"></i></div>
                    <span class="mobile-menu-text">My Account</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="mobile-menu-link btn btn-link p-0">
                        <div class="mobile-menu-icon"><i class="la la-sign-out"></i></div>
                        <span class="mobile-menu-text">Logout</span>
                    </button>
                </form>
            </div>
        @endguest

        <!-- Language Switcher Item -->
        @if( Route::is('home') || Route::is('main'))
        <div class="mobile-menu-item">
            <div class="mobile-menu-link mobile-menu-toggle" data-toggle="language-submenu">
                <div class="mobile-menu-icon">
                    <i class="la la-globe"></i>
                </div>
                <span class="mobile-menu-text" data-lang-key="language">Language</span>
                <i class="mobile-menu-arrow la la-angle-down"></i>
            </div>
            <div class="mobile-submenu" id="language-submenu">
                <div class="mobile-submenu-item" data-lang="en" data-flag="us">
                    <div class="mobile-submenu-link language-option-mobile">
                        <span class="flag-icon">
                            <svg width="20" height="15" viewBox="0 0 20 15" fill="none">
                                <rect width="20" height="15" fill="#1E40AF"/>
                                <rect width="20" height="3" fill="#FFFFFF"/>
                                <rect y="6" width="20" height="3" fill="#FFFFFF"/>
                                <rect y="12" width="20" height="3" fill="#FFFFFF"/>
                                <rect width="10" height="8" fill="#DC2626"/>
                                <g fill="#FFFFFF">
                                    <polygon points="2,1 2.5,2.5 4,2 3.5,3.5 5,4 3.5,4.5 4,6 2.5,5.5 2,7 1.5,5.5 0,6 0.5,4.5 -1,4 0.5,3.5"/>
                                </g>
                            </svg>
                        </span>
                        <span>English</span>
                    </div>
                </div>
                <div class="mobile-submenu-item" data-lang="ru" data-flag="ru">
                    <div class="mobile-submenu-link language-option-mobile">
                        <span class="flag-icon">
                            <svg width="20" height="15" viewBox="0 0 20 15" fill="none">
                                <rect width="20" height="15" fill="#FFFFFF"/>
                                <rect y="5" width="20" height="5" fill="#0052CC"/>
                                <rect y="10" width="20" height="5" fill="#DC2626"/>
                            </svg>
                        </span>
                        <span>Русский</span>
                    </div>
                </div>
                <div class="mobile-submenu-item" data-lang="hy" data-flag="am">
                    <div class="mobile-submenu-link language-option-mobile">
                        <span class="flag-icon">
                            <svg width="20" height="15" viewBox="0 0 20 15" fill="none">
                                <rect width="20" height="5" fill="#0052CC"/>
                                <rect y="5" width="20" height="5" fill="#FFD700"/>
                                <rect y="10" width="20" height="5" fill="#DC2626"/>
                            </svg>
                        </span>
                        <span>Հայերեն</span>
                    </div>
                </div>
                <div class="mobile-submenu-item" data-lang="fi" data-flag="fi">
                    <div class="mobile-submenu-link language-option-mobile">
                        <span class="flag-icon">
                            <svg width="20" height="15" viewBox="0 0 20 15" fill="none">
                                <rect width="20" height="15" fill="#FFFFFF"/>
                                <rect width="3" height="15" fill="#0052CC"/>
                                <rect y="5" width="20" height="3" fill="#0052CC"/>
                            </svg>
                        </span>
                        <span>Suomi</span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    @if(Route::is('home') || Route::is('main'))
        <!-- Desktop Language Switcher (unchanged) -->
        <div class="language-switcher-container desktop-language-switcher">
            <div class="language-switcher" id="languageSwitcher">
                <button class="language-switcher-btn" id="currentLanguageBtn" aria-label="Select Language" type="button">
            <span class="flag-icon" id="currentFlag">
                <svg width="20" height="15" viewBox="0 0 20 15" fill="none">
                    <rect width="20" height="15" fill="#1E40AF"/>
                    <rect width="20" height="3" fill="#FFFFFF"/>
                    <rect y="6" width="20" height="3" fill="#FFFFFF"/>
                    <rect y="12" width="20" height="3" fill="#FFFFFF"/>
                    <rect width="10" height="8" fill="#DC2626"/>
                    <g fill="#FFFFFF">
                        <polygon points="2,1 2.5,2.5 4,2 3.5,3.5 5,4 3.5,4.5 4,6 2.5,5.5 2,7 1.5,5.5 0,6 0.5,4.5 -1,4 0.5,3.5"/>
                    </g>
                </svg>
            </span>
                    <span class="language-name" id="currentLanguage">English</span>
                    <svg class="dropdown-arrow" width="12" height="12" viewBox="0 0 12 12" fill="none">
                        <path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                <div class="language-dropdown" id="languageDropdown">
                    <div class="language-option" data-lang="en" data-flag="us">
                <span class="flag-icon">
                    <svg width="20" height="15" viewBox="0 0 20 15" fill="none">
                        <rect width="20" height="15" fill="#1E40AF"/>
                        <rect width="20" height="3" fill="#FFFFFF"/>
                        <rect y="6" width="20" height="3" fill="#FFFFFF"/>
                        <rect y="12" width="20" height="3" fill="#FFFFFF"/>
                        <rect width="10" height="8" fill="#DC2626"/>
                        <g fill="#FFFFFF">
                            <polygon points="2,1 2.5,2.5 4,2 3.5,3.5 5,4 3.5,4.5 4,6 2.5,5.5 2,7 1.5,5.5 0,6 0.5,4.5 -1,4 0.5,3.5"/>
                        </g>
                    </svg>
                </span>
                        <span class="language-name">English</span>
                    </div>

                    <div class="language-option" data-lang="ru" data-flag="ru">
                <span class="flag-icon">
                    <svg width="20" height="15" viewBox="0 0 20 15" fill="none">
                        <rect width="20" height="15" fill="#FFFFFF"/>
                        <rect y="5" width="20" height="5" fill="#0052CC"/>
                        <rect y="10" width="20" height="5" fill="#DC2626"/>
                    </svg>
                </span>
                        <span class="language-name">Русский</span>
                    </div>

                    <div class="language-option" data-lang="hy" data-flag="am">
                <span class="flag-icon">
                    <svg width="20" height="15" viewBox="0 0 20 15" fill="none">
                        <rect width="20" height="5" fill="#0052CC"/>
                        <rect y="5" width="20" height="5" fill="#FFD700"/>
                        <rect y="10" width="20" height="5" fill="#DC2626"/>
                    </svg>
                </span>
                        <span class="language-name">Հայերեն</span>
                    </div>

                    <div class="language-option" data-lang="fi" data-flag="fi">
                <span class="flag-icon">
                    <svg width="20" height="15" viewBox="0 0 20 15" fill="none">
                        <rect width="20" height="15" fill="#FFFFFF"/>
                        <rect width="3" height="15" fill="#0052CC"/>
                        <rect y="5" width="20" height="3" fill="#0052CC"/>
                    </svg>
                </span>
                        <span class="language-name">Suomi</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Desktop Auth Links -->
    <div class="desktop-auth-links" style="margin-left:auto; display:flex; gap:12px; align-items:center;">
        @guest
            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Login</a>
            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
        @else
            <a href="{{ route('account.index') }}" class="btn btn-outline-secondary btn-sm">My Account</a>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">Logout</button>
            </form>
        @endguest
    </div>
</div>
<!-- END: Horizontal Menu -->