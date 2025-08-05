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
        
        <!-- Language Switcher Item -->
        @if( Route::is('home'))
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
    
    {{--<!-- Desktop Menu (unchanged) -->--}}
    {{--<ul class="m-menu__nav m-menu__nav--submenu-arrow desktop-menu">--}}
        {{--<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="click" data-redirect="true" aria-haspopup="true">--}}
            {{--<a href="{{route('about')}}" class="m-nav__link">--}}
                {{--<span class="m-nav__link-text">--}}
                    {{--About--}}
                {{--</span>--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="click" aria-haspopup="true">--}}
            {{--<a  href="#" class="m-menu__link m-menu__toggle">--}}
                {{--<span class="m-menu__item-here"></span>--}}
                {{--<span class="m-menu__link-text">--}}
					{{--Dashboard--}}
				{{--</span>--}}
                {{--<i class="m-menu__hor-arrow la la-angle-down"></i>--}}
                {{--<i class="m-menu__ver-arrow la la-angle-right"></i>--}}
            {{--</a>--}}
            {{--<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">--}}
                {{--<span class="m-menu__arrow m-menu__arrow--adjust"></span>--}}
                {{--<ul class="m-menu__subnav">--}}
                    {{--<li class="m-menu__item ">--}}
                        {{--<a href="/" class="m-menu__link">--}}
                        {{--<span class="m-nav__link-text">--}}
                            {{--Live Coin Watch--}}
                        {{--</span>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="m-menu__item ">--}}
                        {{--<a href="/coingeckomarketsindex" class="m-menu__link">--}}
                        {{--<span class="m-nav__link-text">--}}
                           {{--Coingecko--}}
                        {{--</span>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="m-menu__item ">--}}
                        {{--<a href="/coinmarketcalindex" class="m-menu__link">--}}
                        {{--<span class="m-nav__link-text">--}}
                           {{--Coin market Cal--}}
                        {{--</span>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--</li>--}}
    {{--</ul>--}}
    
    @if(Route::is('home'))
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
</div>
<!-- END: Horizontal Menu -->