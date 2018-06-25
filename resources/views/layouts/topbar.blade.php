<!-- BEGIN: Topbar -->
<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
    <div class="m-stack__item m-topbar__nav-wrapper">
        <ul class="m-topbar__nav m-nav m-nav--inline">

            <li class="m-nav__item m-topbar__user-profile  m-dropdown m-dropdown--medium m-dropdown--arrow  m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" data-dropdown-toggle="click">
                <a href="#" class="m-nav__link m-dropdown__toggle">
                    <span class="m-topbar__userpic m--hide">
                        <img src="{{ url('assets/app/media/img/users/user4.jpg') }}" class="m--img-rounded m--marginless m--img-centered" alt=""/>
                    </span>
                    <span class="m-nav__link-icon m-topbar__usericon">
                        <span class="m-nav__link-icon-wrapper">
                            <i class="flaticon-user-ok"></i>
                        </span>
					</span>
                    <span class="m-topbar__username m--hide">
						Nick
					</span>
                </a>
                <div class="m-dropdown__wrapper">
                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                    <div class="m-dropdown__inner">
                        <div class="m-dropdown__header m--align-center">
                            <div class="m-card-user m-card-user--skin-light">
                                <div class="m-card-user__pic">
                                    @set($hash, Auth::user()->email)
                                    <img alt="" src="https://www.gravatar.com/avatar/{{$hash}}?d=mm&s=75" class="m--img-rounded m--marginless" height="75" width="75"  alt="image"/>
                                </div>
                                <div class="m-card-user__details">
                                   <span class="m-card-user__name m--font-weight-500">
                                        {{ Auth::user()->name }}
                                    </span>
                                    <a href="" class="m-card-user__email m--font-weight-300 m-link">
                                        {{ Auth::user()->email }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="m-dropdown__body">
                            <div class="m-dropdown__content">
                                <ul class="m-nav m-nav--skin-light">
                                    <li class="m-nav__section m--hide">
                                        <span class="m-nav__section-text">
                                            Section
                                        </span>
                                    </li>
                                    <li class="m-nav__item">
                                        <a href="{{ route('profile') }}" class="m-nav__link">
                                            <i class="m-nav__link-icon flaticon-profile-1"></i>
                                            <span class="m-nav__link-title">
                                                <span class="m-nav__link-wrap">
                                                    <span class="m-nav__link-text">
                                                        My Profile
                                                    </span>
                                                </span>
											</span>
                                        </a>
                                    </li>

                                    <li class="m-nav__separator m-nav__separator--fit"></li>
                                    <li class="m-nav__item">
                                        <a class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li id="m_quick_sidebar_toggle" class="m-nav__item">
                <a href="#" class="m-nav__link m-dropdown__toggle">
                    <span class="m-nav__link-icon m-nav__link-icon-alt">
                        <span class="m-nav__link-icon-wrapper">
                            <i class="flaticon-grid-menu"></i>
                        </span>
                    </span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- END: Topbar -->