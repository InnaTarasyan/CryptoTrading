<!-- Mobile Navigation Overlay -->
<div class="mobile-nav-overlay" id="mobileNavOverlay"></div>

<!-- Mobile Navigation Panel -->
<div class="mobile-nav-panel" id="mobileNavPanel">
    <!-- Mobile Nav Header -->
    <div class="mobile-nav-header">
        <h3 class="mobile-nav-title">Menu</h3>
        <button class="mobile-nav-close" id="mobileNavClose" aria-label="Close menu">
            <i class="la la-times"></i>
        </button>
    </div>

    <!-- Mobile Nav Content -->
    <div class="mobile-nav-content">
        <!-- Main Navigation Section -->
        <div class="mobile-nav-section">
            <div class="mobile-nav-section-title">Navigation</div>
            
            <!-- About Item -->
            <div class="mobile-nav-item">
                <a href="{{route('about')}}" class="mobile-nav-link">
                    <div class="mobile-nav-icon">
                        <i class="la la-info-circle"></i>
                    </div>
                    <span class="mobile-nav-text" data-lang-key="about">About</span>
                </a>
            </div>
            
            <!-- Dashboard Item -->
            <div class="mobile-nav-item">
                <button class="mobile-nav-link mobile-nav-toggle" data-toggle="dashboard-submenu">
                    <div class="mobile-nav-icon">
                        <i class="la la-dashboard"></i>
                    </div>
                    <span class="mobile-nav-text" data-lang-key="dashboard">Dashboard</span>
                    <i class="mobile-nav-arrow la la-angle-down"></i>
                </button>
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
                    <div class="mobile-submenu-item">
                        <a href="/cryptocomparecoinsindex" class="mobile-submenu-link">
                            <i class="la la-exchange"></i>
                            <span data-lang-key="cryptocompare">CryptoCompare</span>
                        </a>
                    </div>
                    <div class="mobile-submenu-item">
                        <a href="/coinmpredictions" class="mobile-submenu-link">
                            <i class="la la-chart-bar"></i>
                            <span data-lang-key="coin_predictions">Coin Predictions</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tutorials Section -->
        <div class="mobile-nav-section">
            <div class="mobile-nav-section-title">Trading Tutorials</div>
            
            <div class="mobile-nav-item">
                <a href="https://www.binance.com/en/blog/ecosystem/crypto-trading-guide-for-beginners-421499824684903654" target="_blank" class="mobile-nav-link">
                    <div class="mobile-nav-icon">
                        <i class="la la-chart-line"></i>
                    </div>
                    <span class="mobile-nav-text" data-lang-key="binance_guide">Binance Guide</span>
                </a>
            </div>
            
            <div class="mobile-nav-item">
                <a href="https://academy.binance.com/en/articles/how-to-trade-cryptocurrency" target="_blank" class="mobile-nav-link">
                    <div class="mobile-nav-icon">
                        <i class="la la-university"></i>
                    </div>
                    <span class="mobile-nav-text" data-lang-key="crypto_trading">Crypto Trading</span>
                </a>
            </div>
            
            <div class="mobile-nav-item">
                <a href="https://www.coinbase.com/learn/crypto-basics" target="_blank" class="mobile-nav-link">
                    <div class="mobile-nav-icon">
                        <i class="la la-book"></i>
                    </div>
                    <span class="mobile-nav-text" data-lang-key="crypto_basics">Crypto Basics</span>
                </a>
            </div>
            
            <div class="mobile-nav-item">
                <a href="https://www.investopedia.com/articles/forex/042015/why-cryptocurrency-trading-so-volatile.asp" target="_blank" class="mobile-nav-link">
                    <div class="mobile-nav-icon">
                        <i class="la la-chart-bar"></i>
                    </div>
                    <span class="mobile-nav-text" data-lang-key="trading_strategy">Trading Strategy</span>
                </a>
            </div>
            
            <div class="mobile-nav-item">
                <a href="https://www.kraken.com/learn" target="_blank" class="mobile-nav-link">
                    <div class="mobile-nav-icon">
                        <i class="la la-lightbulb"></i>
                    </div>
                    <span class="mobile-nav-text" data-lang-key="learn_center">Learn Center</span>
                </a>
            </div>
            
            <div class="mobile-nav-item">
                <a href="https://www.tradingview.com/education/" target="_blank" class="mobile-nav-link">
                    <div class="mobile-nav-icon">
                        <i class="la la-chart-area"></i>
                    </div>
                    <span class="mobile-nav-text" data-lang-key="chart_analysis">Chart Analysis</span>
                </a>
            </div>
        </div>

        <!-- Language Section (if on home/main page) -->
        @if(Route::is('home') || Route::is('main'))
        <div class="mobile-nav-section">
            <div class="mobile-nav-section-title">Language</div>
            
            <div class="mobile-nav-item">
                <button class="mobile-nav-link mobile-nav-toggle" data-toggle="language-submenu">
                    <div class="mobile-nav-icon">
                        <i class="la la-globe"></i>
                    </div>
                    <span class="mobile-nav-text" data-lang-key="language">Select Language</span>
                    <i class="mobile-nav-arrow la la-angle-down"></i>
                </button>
                <div class="mobile-submenu" id="language-submenu">
                    <div class="mobile-submenu-item" data-lang="en" data-flag="us">
                        <button class="mobile-submenu-link language-option-mobile">
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
                        </button>
                    </div>
                    <div class="mobile-submenu-item" data-lang="ru" data-flag="ru">
                        <button class="mobile-submenu-link language-option-mobile">
                            <span class="flag-icon">
                                <svg width="20" height="15" viewBox="0 0 20 15" fill="none">
                                    <rect width="20" height="15" fill="#FFFFFF"/>
                                    <rect y="5" width="20" height="5" fill="#0052CC"/>
                                    <rect y="10" width="20" height="5" fill="#DC2626"/>
                                </svg>
                            </span>
                            <span>Русский</span>
                        </button>
                    </div>
                    <div class="mobile-submenu-item" data-lang="hy" data-flag="am">
                        <button class="mobile-submenu-link language-option-mobile">
                            <span class="flag-icon">
                                <svg width="20" height="15" viewBox="0 0 20 15" fill="none">
                                    <rect width="20" height="5" fill="#0052CC"/>
                                    <rect y="5" width="20" height="5" fill="#FFD700"/>
                                    <rect y="10" width="20" height="5" fill="#DC2626"/>
                                </svg>
                            </span>
                            <span>Հայերեն</span>
                        </button>
                    </div>
                    <div class="mobile-submenu-item" data-lang="fi" data-flag="fi">
                        <button class="mobile-submenu-link language-option-mobile">
                            <span class="flag-icon">
                                <svg width="20" height="15" viewBox="0 0 20 15" fill="none">
                                    <rect width="20" height="15" fill="#FFFFFF"/>
                                    <rect width="3" height="15" fill="#0052CC"/>
                                    <rect y="5" width="20" height="3" fill="#0052CC"/>
                                </svg>
                            </span>
                            <span>Suomi</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Mobile Auth Section -->
    <div class="mobile-auth-section">
        <div class="mobile-auth-buttons">
            @guest
                <a href="{{ route('login') }}" class="mobile-auth-btn secondary">
                    <i class="la la-sign-in"></i>
                    <span>Login</span>
                </a>
                <a href="{{ route('register') }}" class="mobile-auth-btn primary">
                    <i class="la la-user-plus"></i>
                    <span>Register</span>
                </a>
            @else
                <a href="{{ route('account.index') }}" class="mobile-auth-btn secondary">
                    <i class="la la-user"></i>
                    <span>My Account</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="mobile-auth-btn danger">
                        <i class="la la-sign-out"></i>
                        <span>Logout</span>
                    </button>
                </form>
            @endguest
        </div>
    </div>
</div>

<script>
// Mobile Navigation JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mobileNavOverlay = document.getElementById('mobileNavOverlay');
    const mobileNavPanel = document.getElementById('mobileNavPanel');
    const mobileNavClose = document.getElementById('mobileNavClose');
    const body = document.body;

    // Open mobile navigation
    function openMobileNav() {
        mobileNavOverlay.classList.add('active');
        mobileNavPanel.classList.add('active');
        mobileMenuToggle.classList.add('active');
        body.style.overflow = 'hidden';
        
        // Focus management
        setTimeout(() => {
            mobileNavClose.focus();
        }, 300);
    }

    // Close mobile navigation
    function closeMobileNav() {
        mobileNavOverlay.classList.remove('active');
        mobileNavPanel.classList.remove('active');
        mobileMenuToggle.classList.remove('active');
        body.style.overflow = '';
        
        // Close all submenus
        const activeSubmenus = document.querySelectorAll('.mobile-submenu.active');
        activeSubmenus.forEach(submenu => {
            submenu.classList.remove('active');
        });
        
        const activeToggles = document.querySelectorAll('.mobile-nav-link.active');
        activeToggles.forEach(toggle => {
            toggle.classList.remove('active');
        });
    }

    // Event listeners
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            openMobileNav();
        });
    }

    if (mobileNavClose) {
        mobileNavClose.addEventListener('click', closeMobileNav);
    }

    if (mobileNavOverlay) {
        mobileNavOverlay.addEventListener('click', closeMobileNav);
    }

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileNavPanel.classList.contains('active')) {
            closeMobileNav();
        }
    });

    // Mobile submenu toggles - Fixed implementation
    const mobileNavToggles = document.querySelectorAll('.mobile-nav-toggle');
    mobileNavToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const targetId = this.getAttribute('data-toggle');
            const targetSubmenu = document.getElementById(targetId);
            
            if (targetSubmenu) {
                const isActive = targetSubmenu.classList.contains('active');
                
                // Close all other submenus first
                const allSubmenus = document.querySelectorAll('.mobile-submenu');
                allSubmenus.forEach(submenu => {
                    if (submenu !== targetSubmenu) {
                        submenu.classList.remove('active');
                    }
                });
                
                const allToggles = document.querySelectorAll('.mobile-nav-toggle');
                allToggles.forEach(toggleBtn => {
                    if (toggleBtn !== this) {
                        toggleBtn.classList.remove('active');
                    }
                });
                
                // Toggle current submenu
                if (!isActive) {
                    targetSubmenu.classList.add('active');
                    this.classList.add('active');
                } else {
                    targetSubmenu.classList.remove('active');
                    this.classList.remove('active');
                }
            }
        });
    });

    // Language switcher functionality for mobile
    const languageOptions = document.querySelectorAll('.language-option-mobile');
    languageOptions.forEach(option => {
        option.addEventListener('click', function() {
            const lang = this.closest('.mobile-submenu-item').getAttribute('data-lang');
            const flag = this.closest('.mobile-submenu-item').getAttribute('data-flag');
            
            // Update current language display
            const currentLanguageBtn = document.getElementById('currentLanguageBtn');
            const currentLanguage = document.getElementById('currentLanguage');
            const currentFlag = document.getElementById('currentFlag');
            
            if (currentLanguageBtn && currentLanguage && currentFlag) {
                // Update the text
                const langText = this.querySelector('span:last-child').textContent;
                currentLanguage.textContent = langText;
                
                // Update the flag
                const flagSvg = this.querySelector('.flag-icon svg').outerHTML;
                currentFlag.innerHTML = flagSvg;
                
                // Close mobile nav
                closeMobileNav();
                
                // Here you would typically make an AJAX call to update the language
                // For now, we'll just show a success message
                console.log('Language changed to:', lang);
            }
        });
    });

    // Prevent body scroll when mobile nav is open
    mobileNavPanel.addEventListener('touchmove', function(e) {
        e.preventDefault();
    }, { passive: false });

    // Close mobile nav when clicking on a link (except submenu toggles)
    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link:not(.mobile-nav-toggle)');
    mobileNavLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Don't close if it's a submenu toggle
            if (!this.classList.contains('mobile-nav-toggle')) {
                closeMobileNav();
            }
        });
    });
});
</script> 