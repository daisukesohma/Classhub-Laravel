<header id="m_header" class="m-grid__item m-header global-header parent-header shadow-v2" m-minimize-offset="200"
        m-minimize-mobile-offset="200">
    <div class="m-container m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">
            <!-- BEGIN: Brand -->
            <div class="m-stack__item m-brand  m-brand--skin-light ">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                        <a href="{{ route('home') }}" class="m-brand__logo-wrapper">
                            <img alt="" src="{{ asset('classhub-logo.png') }}" height="35px" class="desktop-logo"/>
                            <img alt="" src="{{ asset('classhub-logo-mobile.png') }}" height="35px"
                                 class="mobile-logo"/>
                        </a>
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">
                        <a href="{{  route('request.tutor')  }}" class="request-tutor-link only-mobile">
                        <span class="btn btn-outline-primary">
                          Request a Tutor
                        </span>
                        </a>
                        <a id="m_aside_header_menu_mobile_toggle" href="javascript:;"
                           class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                            <p>MENU</p>
                        </a>
                    {{--<span class="m-menu__link-badge only-mobile"><span class="m-badge m-badge--brand m-badge--wide">1</span></span>--}}
                    <!-- END -->
                    </div>
                </div>
            </div>
            <!-- END: Brand -->
            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                <!-- BEGIN: Horizontal Menu -->
                <div id="m_header_menu"
                     class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-light m-aside-header-menu-mobile--submenu-skin-light ">
                    <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
                        <li class="m-menu__item m-menu__item--rel" m-menu-link-redirect="1" aria-haspopup="true">
                            <a href="{{ route('parent.account.settings') }}" class="m-menu__link only-mobile">
								<span class="m-menu__link-text">
									My account
								</span>
                            </a>
                        </li>
                        <li class="m-menu__item m-menu__item--rel" m-menu-link-redirect="1" aria-haspopup="true">
                            <a href="{{ route('parent.inbox') }}" class="m-menu__link">
								<span class="m-menu__link-text">
									Inbox
								</span>
                                @if($inboxUnreadCount)
                                    <span class="m-menu__link-badge unread-counter">
                                        <span
                                            class="m-badge m-badge--brand m-badge--wide top-margin "
                                            style="margin-top: 15px;">
                                            {{ $inboxUnreadCount }}
                                        </span>
                                    </span>
                                @endif
                            </a>
                        </li>
                        <li class="m-menu__item m-menu__item--rel" m-menu-link-redirect="1" aria-haspopup="true">
                            <a href="{{ route('parent.dashboard') }}" class="m-menu__link">
              								<span class="m-menu__link-text">
              									My Bookings
              								</span>
                            </a>
                        </li>
                        <li class="m-menu__item m-menu__item--rel" m-menu-link-redirect="1" aria-haspopup="true">
                            <a href="{{ route('parent.today.classes') }}" class="m-menu__link">
              								<span class="m-menu__link-text">
              									Today's Classes
              								</span>
                            </a>
                        </li>
                        <li class="m-menu__item m-menu__item--rel" m-menu-link-redirect="1" aria-haspopup="true">
                            <a href="{{ route('parent.tutor.requests') }}" class="m-menu__link">
              								<span class="m-menu__link-text">
                                                Tutor Requests
              								</span>
                            </a>
                        </li>
                        <li class="m-menu__item m-menu__item--rel" m-menu-link-redirect="1" aria-haspopup="true">
                            <a href="{{ route('page.online-tuition') }}" class="m-menu__link">
								<span class="m-menu__link-text">
									Online Tuition
								</span>
                            </a>
                        </li>
                        <li class="m-menu__item m-menu__item--rel request-a-tutor-btn" m-menu-link-redirect="1"
                            aria-haspopup="true">
                            <a href="{{ route('request.tutor') }}" class="m-menu__link start-teaching">
              								<span class="m-menu__link-text btn btn-secondary">
              									Request a Tutor
              								</span>
                            </a>
                        </li>
                        @if(!Auth::user()->educator)
                            {{--<li class="m-menu__item m-menu__item--rel" m-menu-link-redirect="1" aria-haspopup="true">
                                <a href="{{ route('educator.lesson.create') }}" class="m-menu__link start-teaching">
								<span class="m-menu__link-text btn btn-secondary">
									List a Class
								</span>
                                </a>
                            </li>--}}
                        @endif

                        <li class="m-menu__item m-menu__item--rel only-mobile" m-menu-link-redirect="1"
                            aria-haspopup="true">
                            <a href="{{ route('page.about-us') }}" class="m-menu__link">
								<span class="m-menu__link-text">
									About us
								</span>
                            </a>
                        </li>
                        <li class="m-menu__item m-menu__item--rel only-mobile" m-menu-link-redirect="1"
                            aria-haspopup="true">
                            <a href="{{ route('page.how-it-works') }}" class="m-menu__link">
								<span class="m-menu__link-text">
									How it works
								</span>
                            </a>
                        </li>



                        <li class="m-menu__item m-menu__item--rel only-mobile" m-menu-link-redirect="1"
                            aria-haspopup="true">
                            <a href="{{ route('page.trust') }}" class="m-menu__link">
								<span class="m-menu__link-text">
									Trust
								</span>
                            </a>
                        </li>
                        <li class="m-menu__item m-menu__item--rel only-mobile" m-menu-link-redirect="1"
                            aria-haspopup="true">
                            <a href="{{ route('page.tips-tricks') }}" class="m-menu__link">
																		<span class="m-menu__link-text">
																			Tips for Tutors
																		</span>
                            </a>
                        </li>

                        @if(Auth::user()->educator)
                            {{--<li class="m-menu__item m-menu__item--rel only-mobile" m-menu-link-redirect="1"
                                aria-haspopup="true">
                                <a href="{{ route('educator.dashboard') }}?switch=tutor" class="m-menu__link">
								<span class="m-menu__link-text">
									Go to Tutor Profile
								</span>
                                </a>
                            </li>--}}
                        @endif
                        <li class="m-menu__item m-menu__item--rel only-mobile" m-menu-link-redirect="1"
                            aria-haspopup="true">
                            <a href="{{ route('user.logout') }}" class="m-menu__link">
								<span class="m-menu__link-text">
									Logout
								</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- END: Horizontal Menu -->                                <!-- BEGIN: Topbar -->
                <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">
                            <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img m-dropdown m-dropdown--align-right"
                                m-dropdown-toggle="click">
                                <a href="#" class="m-nav__link m-dropdown__toggle welcome-tab">
                                    <span
                                        class="m-header__topbar-welcome m-hidden-mobile">Welcome {{ \App\Helpers\ClassHubHelper::getFirstName(Auth::user()->name) }}
                                        !</span>
                                    <span class="m-topbar__username">
                										<img height="100"
                                                             src="{{ asset('img/icons/common/video-pic.png') }}"/>
                									</span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav">

                                                    <li class="m-nav__item">
                                                        <a href="{{ route('parent.account.settings') }}"
                                                           class="m-nav__link">
																		<span class="m-nav__link-text">
																			Account Settings
																		</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="{{ route('parent.today.classes') }}" class="m-nav__link">
																		<span class="m-nav__link-text">
																			Today's Classes
																		</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="{{ route('parent.tutor.requests') }}" class="m-nav__link">
																		<span class="m-nav__link-text">
																			Tutor Requests
																		</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="{{ route('parent.favourites') }}" class="m-nav__link">
																		<span class="m-nav__link-text">
																			My Favourites
																		</span>
                                                        </a>
                                                    </li>

                                                    <li class="m-nav__item">
                                                        <a href="{{ route('page.about-us') }}" class="m-nav__link">
																		<span class="m-nav__link-text">
																			About us
																		</span>
                                                        </a>
                                                    </li>

                                                    <li class="m-nav__item">
                                                        <a href="{{ route('page.how-it-works') }}" class="m-nav__link">
																		<span class="m-nav__link-text">
																			How it works
																		</span>
                                                        </a>
                                                    </li>

                                                    <li class="m-nav__item">
                                                        <a href="{{ route('page.trust') }}" class="m-nav__link">
																		<span class="m-nav__link-text">
																			Trust
																		</span>
                                                        </a>
                                                    </li>

                                                    <li class="m-nav__item">
                                                        <a href="{{ route('page.tips-tricks') }}" class="m-nav__link">
																		<span class="m-nav__link-text">
																			Tips for Tutors
																		</span>
                                                        </a>
                                                    </li>

                                                    @if(Auth::user()->educator)

                                                        {{--<li class="m-nav__item">
                                                            <a href="{{ route('educator.dashboard') }}?switch=tutor"
                                                               class="m-nav__link">
																		<span class="m-nav__link-text">
                                                                            Go to Tutor Profile
																		</span>
                                                            </a>
                                                        </li>--}}
                                                    @endif
                                                    <li class="m-nav__item">
                                                        <a href="{{ route('user.logout') }}" class="m-nav__link">
																		<span class="m-nav__link-text">
																			Logout
																		</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </li>
                        </ul>
                    </div>
                </div>
                <!-- END: Topbar -->
            </div>
        </div>
    </div>
</header>
