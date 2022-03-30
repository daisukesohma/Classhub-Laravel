<header id="m_header" class="m-grid__item m-header global-header provider-header shadow-v2">
    <div class="m-container m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">
            <!-- BEGIN: Brand -->
            <div class="m-stack__item m-brand  m-brand--skin-light ">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                        <a href="{{  route('home')  }}"
                           class="m-brand__logo-wrapper">
                            <img alt="" src="{{ asset('classhub-logo.png') }}" height="35px" class="desktop-logo"/>
                            <img alt="" src="{{ asset('classhub-logo-mobile.png') }}" height="35px"
                                 class="mobile-logo"/>
                        </a>
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">
                        <a href="{{ route('educator.job-board') }}"
                           class="request-tutor-link only-mobile">
                        <span class="btn btn-outline-primary">
                          Job Board
                        </span>
                        </a>
                        <!-- BEGIN: Left Aside Minimize Toggle -->
                        <!-- END -->
                        <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                        <!-- END -->
                        <!-- BEGIN: Responsive Header Menu Toggler -->
                        <a id="m_aside_header_menu_mobile_toggle" href="javascript:;"
                           class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                            <p>MENU</p>
                        </a>
                    {{--<span class="m-menu__link-badge m--visible-tablet-and-mobile-inline-block"><span
                            class="m-badge m-badge--brand m-badge--wide">1</span></span>--}}
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
                            <a href="{{  route('educator.dashboard')  }}"
                               class="m-menu__link">
											<span class="m-menu__link-text">
												My Dashboard
											</span>
                            </a>
                        </li>
                        <li class="m-menu__item m-menu__item--rel" m-menu-link-redirect="1" aria-haspopup="true">
                            <a href="{{  route('educator.inbox')  }}" class="m-menu__link">
											<span class="m-menu__link-text">
												Inbox
											</span>
                                <span class="m-menu__link-badge unread-counter">

                                    @if($inboxUnreadCount)

                                        <span
                                            class="m-badge m-badge--brand m-badge--wide top-margin "
                                            style="margin-top: 15px;">
                                            {{ $inboxUnreadCount }}
                                        </span>
                                    @endif

                                    </span>
                            </a>
                        </li>
                        <li class="m-menu__item m-menu__item--rel only-mobile" m-menu-link-redirect="1"
                            aria-haspopup="true">
                            <a href="{{  route('educator.account.settings')  }}"
                               class="m-menu__link">
											<span class="m-menu__link-text">
												Account Settings
											</span>
                            </a>
                        </li>
                        <!-- <li class="m-menu__item m-menu__item--rel only-mobile" m-menu-link-redirect="1"
                            aria-haspopup="true">
                            <a href="#" class="m-menu__link">
											<span class="m-menu__link-text">
												Refer an activity provider
											</span>
                            </a>
                        </li> -->

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


                        <li class="m-menu__item m-menu__item--rel" m-menu-link-redirect="1" aria-haspopup="true">
                            <a href="{{ route('page.online-tuition') }}" class="m-menu__link">
								<span class="m-menu__link-text">
									Online Tuition
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

                        {{--<li class="m-menu__item m-menu__item--rel" m-menu-link-redirect="1" aria-haspopup="true">
                            <a href="{{ route('parent.dashboard') }}?switch=parent"
                               {{ !Auth::user() ? 'data-toggle=modal data-target=#login-modal' : '' }}
                               class="m-menu__link">
                                  <span class="m-menu__link-text" style="color: #e74b65">
                  									Go to Parent Profile
                  								</span>
                            </a>
                        </li>--}}

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

                            <li class="m-menu__item m-menu__item--rel job-board" m-menu-link-redirect="1"
                                aria-haspopup="true">
                                <a href="{{ route('educator.job-board') }}" class="m-menu__link start-teaching"
                                   style="padding: 0 5px">
                                <span class="m-menu__link-text btn btn-secondary">
                                    Jobs Board
                                </span>
                                    @if(Auth::user()->jobsBoardCount())
                                        <span
                                            class="m-badge m-badge--brand m-badge--wide top-margin "
                                            style="margin-top: 15px;">
                                        {{ Auth::user()->jobsBoardCount() }}
                                    </span>
                                    @endif
                                </a>
                            </li>


                            <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img m-dropdown m-dropdown--align-right"
                                m-dropdown-toggle="click">
                                <a href="javascript:void(0);" class="m-nav__link m-dropdown__toggle welcome-tab">
                                    {{--<span class="m-header__topbar-welcome m-hidden-mobile">Welcome {{
                                    \App\Helpers\ClassHubHelper::getFirstName(Auth::user()->name) }}
                                        !</span>--}}
                                    <span class="m-topbar__userpic">
                                        <img height="50" width="50"
                                             class="tile-img-bg m--img-rounded m--marginless m--img-centered"
                                             alt="image"
                                             src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII="
                                             style="background-image:url({{
                                                         Storage::disk('public')->exists( $user->educator ? optional($user->educator->avatar)->path : '') ?
                                                         Storage::url(optional($user->educator)->avatar->path) :
                                                         asset('img/icons/common/parents-burger-menu.png') }})">
                                    </span>
                                    <span class="m-topbar__username m--hide">{{ $user->name  }}</span>
                                </a>

                                <div class="m-dropdown__wrapper">
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav">

                                                    <li class="m-nav__item">
                                                        <a href="{{  route('educator.account.settings')  }}"
                                                           class="m-nav__link">
																		<span class="m-nav__link-text drop-nav">
																			Account Settings
																		</span>
                                                        </a>
                                                    </li>

                                                    <li class="m-nav__item">
                                                        <a href="{{ route('page.about-us') }}" class="m-nav__link">
																		<span class="m-nav__link-text drop-nav">
																			About us
																		</span>
                                                        </a>
                                                    </li>

                                                    <li class="m-nav__item">
                                                        <a href="{{ route('page.how-it-works') }}" class="m-nav__link">
																		<span class="m-nav__link-text drop-nav">
																			How it works
																		</span>
                                                        </a>
                                                    </li>


                                                    <li class="m-nav__item">
                                                        <a href="{{ route('page.trust') }}" class="m-nav__link">
                                                            <span class="m-nav__link-text drop-nav">
                                                                Trust
                                                            </span>
                                                        </a>
                                                    </li>

                                                    <li class="m-nav__item">
                                                        <a href="{{ route('page.tips-tricks') }}" class="m-nav__link">
                      																		<span
                                                                                                class="m-nav__link-text drop-nav">
                      																			Tips for Tutors
                      																		</span>
                                                        </a>
                                                    </li>

                                                    {{--<li class="m-nav__item">
                                                        <a href="{{ route('parent.dashboard') }}?switch=parent"
                                                           class="m-nav__link">
                                                            <span class="m-nav__link-text drop-nav">
                                                                Go to Parent Profile
                                                            </span>
                                                        </a>
                                                    </li>--}}

                                                    <li class="m-nav__item">
                                                        <a href="{{ route('user.logout') }}" class="m-nav__link logout">
                      																		<span
                                                                                                class="m-nav__link-text drop-nav">
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
<style type="text/css">
    @media all and (max-width: 1200px) {
        .pre-recorded-menu {
            display: none;
        }
    }

</style>
