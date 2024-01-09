<!-- BEGIN: Horizontal Menu -->
<button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-light " id="m_aside_header_menu_mobile_close_btn">
    <i class="la la-close"></i>
</button>
<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-light m-aside-header-menu-mobile--submenu-skin-light "  >
    <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="click" data-redirect="true" aria-haspopup="true">
            <a href="{{route('about')}}" class="m-nav__link">
                <span class="m-nav__link-text">
                    About
                </span>
            </a>
        </li>
        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="click" aria-haspopup="true">
            <a  href="#" class="m-menu__link m-menu__toggle">
                <span class="m-menu__item-here"></span>
                <span class="m-menu__link-text">
					Dashboard
				</span>
                <i class="m-menu__hor-arrow la la-angle-down"></i>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                <ul class="m-menu__subnav">
                    <li class="m-menu__item ">
                        <a href="/" class="m-menu__link">
                        <span class="m-nav__link-text">
                            Live Coin Watch
                        </span>
                        </a>
                    </li>
                    <li class="m-menu__item ">
                        <a href="/coingeckoindex" class="m-menu__link">
                        <span class="m-nav__link-text">
                           Coingecko
                        </span>
                        </a>
                    </li>
                    <li class="m-menu__item ">
                        <a href="/coinmarketcalindex" class="m-menu__link">
                        <span class="m-nav__link-text">
                           Coin market Cal
                        </span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

    </ul>
</div>
<!-- END: Horizontal Menu -->