<!-- BEGIN: Header -->
<header class="m-grid__item    m-header "  data-minimize-offset="200" data-minimize-mobile-offset="200" >
    <div class="m-container m-container--fluid m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">
            <!-- BEGIN: Brand -->
            <div class="m-stack__item m-brand ">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                        <a href="/" class="m-brand__logo-wrapper">
                            <img alt="" src="https://pngimg.com/uploads/bitcoin/bitcoin_PNG47.png"/>
                        </a>
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">
                        <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                        <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Responsive Header Menu Toggler -->
                        <a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->
                        {{--<!-- BEGIN: Topbar Toggler -->--}}
                        {{--<a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">--}}
                            {{--<i class="flaticon-more"></i>--}}
                        {{--</a>--}}
                        {{--<!-- BEGIN: Topbar Toggler -->--}}
                    </div>
                </div>
            </div>
            <!-- END: Brand -->
            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                <!-- BEGIN: Left Side Menu Items -->
                <div class="left-menu-container">
                    <div class="menu-item">
                        <a href="{{route('about')}}" class="menu-link">
                            <i class="la la-info-circle"></i>
                            <span data-lang-key="about">About</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="#" class="menu-link dropdown-toggle" data-toggle="dashboard-dropdown">
                            <i class="la la-dashboard"></i>
                            <span data-lang-key="dashboard">Dashboard</span>
                            <i class="la la-angle-down"></i>
                        </a>
                        <div class="dropdown-menu" id="dashboard-dropdown">
                            <a href="/" class="dropdown-item">
                                <i class="la la-chart-line"></i>
                                <span data-lang-key="live_coin_watch">Live Coin Watch</span>
                            </a>
                            <a href="/coingeckomarketsindex" class="dropdown-item">
                                <i class="la la-bitcoin"></i>
                                <span data-lang-key="coingecko">Coingecko</span>
                            </a>
                            <a href="/coinmarketcalindex" class="dropdown-item">
                                <i class="la la-calendar"></i>
                                <span data-lang-key="coin_market_cal">Coin Market Cal</span>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- END: Left Side Menu Items -->
                
                <!-- BEGIN: Tutorial Links Section (Right Side) -->
                <div class="tutorial-links-container desktop-tutorial-links">
                    <div class="tutorial-dropdown">
                        <button class="tutorial-dropdown-toggle" type="button" id="tutorialDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="la la-graduation-cap"></i>
                            <span data-lang-key="trading_tutorials">Trading Tutorials</span>
                            <i class="la la-angle-down dropdown-arrow"></i>
                        </button>
                        <div class="tutorial-dropdown-menu" aria-labelledby="tutorialDropdown">
                            <div class="dropdown-header">
                                <i class="la la-graduation-cap"></i>
                                <span data-lang-key="trading_tutorials">Trading Tutorials</span>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="https://www.binance.com/en/blog/ecosystem/crypto-trading-guide-for-beginners-421499824684903654" target="_blank" class="dropdown-item" title="Binance Trading Guide">
                                <i class="la la-chart-line"></i>
                                <span data-lang-key="binance_guide">Binance Guide</span>
                            </a>
                            <a href="https://academy.binance.com/en/articles/how-to-trade-cryptocurrency" target="_blank" class="dropdown-item" title="How to Trade Cryptocurrency">
                                <i class="la la-university"></i>
                                <span data-lang-key="crypto_trading">Crypto Trading</span>
                            </a>
                            <a href="https://www.coinbase.com/learn/crypto-basics" target="_blank" class="dropdown-item" title="Coinbase Learning">
                                <i class="la la-book"></i>
                                <span data-lang-key="crypto_basics">Crypto Basics</span>
                            </a>
                            <a href="https://www.investopedia.com/articles/forex/042015/why-cryptocurrency-trading-so-volatile.asp" target="_blank" class="dropdown-item" title="Investopedia Crypto Trading">
                                <i class="la la-chart-bar"></i>
                                <span data-lang-key="trading_strategy">Trading Strategy</span>
                            </a>
                            <a href="https://www.kraken.com/learn" target="_blank" class="dropdown-item" title="Kraken Learning Center">
                                <i class="la la-lightbulb"></i>
                                <span data-lang-key="learn_center">Learn Center</span>
                            </a>
                            <a href="https://www.tradingview.com/education/" target="_blank" class="dropdown-item" title="TradingView Education">
                                <i class="la la-chart-area"></i>
                                <span data-lang-key="chart_analysis">Chart Analysis</span>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- END: Tutorial Links Section -->
                
                @include('layouts.horizontal_menu')
                @include('layouts.topbar')
            </div>
        </div>
    </div>
</header>
<!-- END: Header -->

<script>
// Tutorial Dropdown Functionality
document.addEventListener('DOMContentLoaded', function() {
    const tutorialDropdown = document.getElementById('tutorialDropdown');
    const tutorialDropdownMenu = document.querySelector('.tutorial-dropdown-menu');
    
    if (tutorialDropdown && tutorialDropdownMenu) {
        let isOpen = false;
        
        // Toggle dropdown on button click
        tutorialDropdown.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleDropdown();
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!tutorialDropdown.contains(e.target) && !tutorialDropdownMenu.contains(e.target)) {
                closeDropdown();
            }
        });
        
        // Keyboard navigation
        tutorialDropdown.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleDropdown();
            } else if (e.key === 'Escape') {
                closeDropdown();
            }
        });
        
        // Close dropdown on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && isOpen) {
                closeDropdown();
            }
        });
        
        // Handle dropdown item clicks
        const dropdownItems = tutorialDropdownMenu.querySelectorAll('.dropdown-item');
        dropdownItems.forEach(item => {
            item.addEventListener('click', function(e) {
                // Allow the link to work normally
                // The dropdown will close automatically due to document click handler
            });
            
            // Keyboard navigation for dropdown items
            item.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
            });
        });
        
        function toggleDropdown() {
            if (isOpen) {
                closeDropdown();
            } else {
                openDropdown();
            }
        }
        
        function openDropdown() {
            isOpen = true;
            tutorialDropdown.setAttribute('aria-expanded', 'true');
            tutorialDropdownMenu.classList.add('show');
            
            // Focus first dropdown item for keyboard navigation
            const firstItem = tutorialDropdownMenu.querySelector('.dropdown-item');
            if (firstItem) {
                setTimeout(() => firstItem.focus(), 100);
            }
        }
        
        function closeDropdown() {
            isOpen = false;
            tutorialDropdown.setAttribute('aria-expanded', 'false');
            tutorialDropdownMenu.classList.remove('show');
        }
        
        // Hover effects for better UX
        let hoverTimeout;
        
        tutorialDropdown.addEventListener('mouseenter', function() {
            clearTimeout(hoverTimeout);
            if (!isOpen) {
                hoverTimeout = setTimeout(() => openDropdown(), 200);
            }
        });
        
        tutorialDropdownMenu.addEventListener('mouseenter', function() {
            clearTimeout(hoverTimeout);
        });
        
        tutorialDropdown.addEventListener('mouseleave', function() {
            hoverTimeout = setTimeout(() => {
                if (isOpen) {
                    closeDropdown();
                }
            }, 300);
        });
        
        tutorialDropdownMenu.addEventListener('mouseleave', function() {
            hoverTimeout = setTimeout(() => {
                if (isOpen) {
                    closeDropdown();
                }
            }, 300);
        });
    }
});
</script>