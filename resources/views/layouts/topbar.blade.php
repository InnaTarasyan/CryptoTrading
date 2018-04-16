<!-- BEGIN: Topbar -->
<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
    <div class="m-stack__item m-stack__item--middle m-dropdown m-dropdown--arrow m-dropdown--large m-dropdown--mobile-full-width m-dropdown--align-right m-dropdown--skin-light m-header-search m-header-search--expandable m-header-search--skin-light" id="m_quicksearch" data-search-type="default">
        <!--BEGIN: Search Form -->
        <form class="m-header-search__form">
            <div class="m-header-search__wrapper">
                <span class="m-header-search__icon-search" id="m_quicksearch_search">
                    <i class="flaticon-search"></i>
                </span>
                <span class="m-header-search__input-wrapper">
					<input autocomplete="off" type="text" name="q" class="m-header-search__input" value="" placeholder="Search..." id="m_quicksearch_input">
				</span>
                <span class="m-header-search__icon-close" id="m_quicksearch_close">
					<i class="la la-remove"></i>
				</span>
                <span class="m-header-search__icon-cancel" id="m_quicksearch_cancel">
					<i class="la la-remove"></i>
				</span>
            </div>
        </form>
        <!--END: Search Form -->
        <!--BEGIN: Search Results -->
        <div class="m-dropdown__wrapper">
            <div class="m-dropdown__arrow m-dropdown__arrow--center"></div>
            <div class="m-dropdown__inner">
                <div class="m-dropdown__body">
                    <div class="m-dropdown__scrollable m-scrollable" data-max-height="300" data-mobile-max-height="200">
                        <div class="m-dropdown__content m-list-search m-list-search--skin-light"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--BEGIN: END Results -->
    </div>
    <div class="m-stack__item m-topbar__nav-wrapper">
        <ul class="m-topbar__nav m-nav m-nav--inline">
            <li class="m-nav__item m-topbar__notifications m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center 	m-dropdown--mobile-full-width" data-dropdown-toggle="click" data-dropdown-persistent="true">
                <a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
                    <span class="m-nav__link-badge m-badge m-badge--dot m-badge--dot-small m-badge--danger"></span>
                    <span class="m-nav__link-icon">
                        <span class="m-nav__link-icon-wrapper">
                            <i class="flaticon-music-2"></i>
                        </span>
					</span>
                </a>
                <div class="m-dropdown__wrapper">
                    <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
                    <div class="m-dropdown__inner">
                        <div class="m-dropdown__header m--align-center">
                            <span class="m-dropdown__header-title">
                                9 New
                            </span>
                            <span class="m-dropdown__header-subtitle">
								User Notifications
							</span>
                        </div>
                        <div class="m-dropdown__body">
                            <div class="m-dropdown__content">
                                <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#topbar_notifications_notifications" role="tab">
                                            Alerts
                                        </a>
                                    </li>
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#topbar_notifications_events" role="tab">
                                            Events
                                        </a>
                                    </li>
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#topbar_notifications_logs" role="tab">
                                            Logs
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="topbar_notifications_notifications" role="tabpanel">
                                        <div class="m-scrollable" data-scrollable="true" data-max-height="250" data-mobile-max-height="200">
                                            <div class="m-list-timeline m-list-timeline--skin-light">
                                                <div class="m-list-timeline__items">
                                                    <div class="m-list-timeline__item">
                                                        <span class="m-list-timeline__badge -m-list-timeline__badge--state-success"></span>
                                                        <span class="m-list-timeline__text">
															12 new users registered
														</span>
                                                        <span class="m-list-timeline__time">
															Just now
														</span>
                                                    </div>
                                                    <div class="m-list-timeline__item">
                                                        <span class="m-list-timeline__badge"></span>
                                                        <span class="m-list-timeline__text">
                                                            System shutdown
                                                            <span class="m-badge m-badge--success m-badge--wide">
                                                                pending
                                                            </span>
														</span>
                                                        <span class="m-list-timeline__time">
															14 mins
														</span>
                                                    </div>
                                                    <div class="m-list-timeline__item">
                                                        <span class="m-list-timeline__badge"></span>
                                                        <span class="m-list-timeline__text">
															New invoice received
														</span>
                                                        <span class="m-list-timeline__time">
															20 mins
														</span>
                                                    </div>
                                                    <div class="m-list-timeline__item">
                                                        <span class="m-list-timeline__badge"></span>
                                                        <span class="m-list-timeline__text">
                                                            DB overloaded 80%
                                                            <span class="m-badge m-badge--info m-badge--wide">
                                                                settled
                                                            </span>
														</span>
                                                        <span class="m-list-timeline__time">
															1 hr
														</span>
                                                    </div>
                                                    <div class="m-list-timeline__item">
                                                        <span class="m-list-timeline__badge"></span>
                                                        <span class="m-list-timeline__text">
                                                            System error -
                                                            <a href="#" class="m-link">
                                                                Check
                                                             </a>
														</span>
                                                        <span class="m-list-timeline__time">
															2 hrs
														</span>
                                                    </div>
                                                    <div class="m-list-timeline__item m-list-timeline__item--read">
                                                        <span class="m-list-timeline__badge"></span>
                                                        <span href="" class="m-list-timeline__text">
                                                            New order received
                                                            <span class="m-badge m-badge--danger m-badge--wide">
                                                                urgent
                                                            </span>
														</span>
                                                        <span class="m-list-timeline__time">
															7 hrs
														</span>
                                                    </div>
                                                    <div class="m-list-timeline__item m-list-timeline__item--read">
                                                        <span class="m-list-timeline__badge"></span>
                                                        <span class="m-list-timeline__text">
															Production server down
														</span>
                                                        <span class="m-list-timeline__time">
															3 hrs
														</span>
                                                    </div>
                                                    <div class="m-list-timeline__item">
                                                        <span class="m-list-timeline__badge"></span>
                                                        <span class="m-list-timeline__text">
															Production server up
														</span>
                                                        <span class="m-list-timeline__time">
															5 hrs
														</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="topbar_notifications_events" role="tabpanel">
                                        <div class="m-scrollable" m-scrollabledata-scrollable="true" data-max-height="250" data-mobile-max-height="200">
                                            <div class="m-list-timeline m-list-timeline--skin-light">
                                                <div class="m-list-timeline__items">
                                                    <div class="m-list-timeline__item">
                                                        <span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
                                                        <a href="" class="m-list-timeline__text">
                                                            New order received
                                                        </a>
                                                        <span class="m-list-timeline__time">
															Just now
														</span>
                                                    </div>
                                                    <div class="m-list-timeline__item">
                                                        <span class="m-list-timeline__badge m-list-timeline__badge--state1-danger"></span>
                                                        <a href="" class="m-list-timeline__text">
                                                            New invoice received
                                                        </a>
                                                        <span class="m-list-timeline__time">
															20 mins
														</span>
                                                    </div>
                                                    <div class="m-list-timeline__item">
                                                        <span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
                                                        <a href="" class="m-list-timeline__text">
                                                            Production server up
                                                        </a>
                                                        <span class="m-list-timeline__time">
															5 hrs
														</span>
                                                    </div>
                                                    <div class="m-list-timeline__item">
                                                        <span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
                                                        <a href="" class="m-list-timeline__text">
                                                            New order received
                                                        </a>
                                                        <span class="m-list-timeline__time">
															7 hrs
														</span>
                                                    </div>
                                                    <div class="m-list-timeline__item">
                                                        <span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
                                                        <a href="" class="m-list-timeline__text">
                                                            System shutdown
                                                        </a>
                                                        <span class="m-list-timeline__time">
															11 mins
														</span>
                                                    </div>
                                                    <div class="m-list-timeline__item">
                                                        <span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
                                                        <a href="" class="m-list-timeline__text">
                                                            Production server down
                                                        </a>
                                                        <span class="m-list-timeline__time">
															3 hrs
														</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="topbar_notifications_logs" role="tabpanel">
                                        <div class="m-stack m-stack--ver m-stack--general" style="min-height: 180px;">
                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                <span class="">
                                                    All caught up!
                                                    <br>
                                                    No new logs.
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="m-nav__item m-topbar__quick-actions m-dropdown m-dropdown--skin-light m-dropdown--large m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push m-dropdown--mobile-full-width m-dropdown--skin-light"  data-dropdown-toggle="click">
                <a href="#" class="m-nav__link m-dropdown__toggle">
                    <span class="m-nav__link-badge m-badge m-badge--dot m-badge--info m--hide"></span>
                    <span class="m-nav__link-icon">
                        <span class="m-nav__link-icon-wrapper">
                            <i class="flaticon-share"></i>
                        </span>
					</span>
                </a>
                <div class="m-dropdown__wrapper">
                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                    <div class="m-dropdown__inner">
                        <div class="m-dropdown__header m--align-center">
                            <span class="m-dropdown__header-title">
                                Quick Actions
                            </span>
                            <span class="m-dropdown__header-subtitle">
								Shortcuts
							</span>
                        </div>
                        <div class="m-dropdown__body m-dropdown__body--paddingless">
                            <div class="m-dropdown__content">
                                <div class="m-scrollable" data-scrollable="false" data-max-height="380" data-mobile-max-height="200">
                                    <div class="m-nav-grid m-nav-grid--skin-light">
                                        <div class="m-nav-grid__row">
                                            <a href="#" class="m-nav-grid__item">
                                                <i class="m-nav-grid__icon flaticon-file"></i>
                                                <span class="m-nav-grid__text">
													Generate Report
												</span>
                                            </a>
                                            <a href="#" class="m-nav-grid__item">
                                                <i class="m-nav-grid__icon flaticon-time"></i>
                                                <span class="m-nav-grid__text">
													Add New Event
												</span>
                                            </a>
                                        </div>
                                        <div class="m-nav-grid__row">
                                            <a href="#" class="m-nav-grid__item">
                                                <i class="m-nav-grid__icon flaticon-folder"></i>
                                                <span class="m-nav-grid__text">
													Create New Task
												</span>
                                            </a>
                                            <a href="#" class="m-nav-grid__item">
                                                <i class="m-nav-grid__icon flaticon-clipboard"></i>
                                                <span class="m-nav-grid__text">
													Completed Tasks
												</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
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
                                    <img src="{{ url('assets/app/media/img/users/user4.jpg')}}" class="m--img-rounded m--marginless" alt=""/>
                                </div>
                                <div class="m-card-user__details">
                                   <span class="m-card-user__name m--font-weight-500">
                                        Mark Andre
                                    </span>
                                    <a href="" class="m-card-user__email m--font-weight-300 m-link">
                                        mark.andre@gmail.com
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
                                        <a href="profile.html" class="m-nav__link">
                                            <i class="m-nav__link-icon flaticon-profile-1"></i>
                                            <span class="m-nav__link-title">
                                                <span class="m-nav__link-wrap">
                                                    <span class="m-nav__link-text">
                                                        My Profile
                                                    </span>
                                                    <span class="m-nav__link-badge">
                                                        <span class="m-badge m-badge--success">
                                                            2
                                                        </span>
                                                    </span>
                                                </span>
											</span>
                                        </a>
                                    </li>
                                    <li class="m-nav__item">
                                        <a href="profile.html" class="m-nav__link">
                                            <i class="m-nav__link-icon flaticon-share"></i>
                                            <span class="m-nav__link-text">
												Activity
											</span>
                                        </a>
                                    </li>
                                    <li class="m-nav__item">
                                        <a href="profile.html" class="m-nav__link">
                                            <i class="m-nav__link-icon flaticon-chat-1"></i>
                                            <span class="m-nav__link-text">
												Messages
											</span>
                                        </a>
                                    </li>
                                    <li class="m-nav__separator m-nav__separator--fit"></li>
                                    <li class="m-nav__item">
                                        <a href="profile.html" class="m-nav__link">
                                            <i class="m-nav__link-icon flaticon-info"></i>
                                            <span class="m-nav__link-text">
												FAQ
											</span>
                                        </a>
                                    </li>
                                    <li class="m-nav__item">
                                        <a href="profile.html" class="m-nav__link">
                                            <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                            <span class="m-nav__link-text">
												Support
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