<header id="m_header" class="m-grid__item m-header global-header transparent logout-header shadow-v2 mobile-fixed home-menu" m-minimize-offset="200"
        m-minimize-mobile-offset="200">
    <div class="m-container m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">
            <!-- BEGIN: Brand -->
            <div class="m-stack__item m-brand  m-brand--skin-light mobile-transparent">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                        <a href="{{ route('home') }}" class="m-brand__logo-wrapper">
                            <img alt="" class="only-desktop" src="{{ asset('classhub-logo.png') }}" height="35px"/>
                            <img alt="" class="only-mobile not-scrolled" src="{{ asset('classhub-logo-light-mobile.png') }}" height="35px"/>
                            <img alt="" class="only-mobile scrolled-logo" src="{{ asset('classhub-logo-mobile.png') }}" height="35px"/>
                        </a>
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">
                      <a href="{{  route('request.tutor') }}" class="request-tutor-link only-mobile">
                        <span class="btn btn-outline-primary">
                          Request a Tutor
                        </span>
                      </a>
                        <!-- BEGIN: Responsive Header Menu Toggler -->
                        <a id="m_aside_header_menu_mobile_toggle" href="javascript:;"
                           class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                            <p>MENU</p>

                        </a>
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
                            <a href="{{ route('page.how-it-works') }}" class="m-menu__link">
								<span class="m-menu__link-text">
									How it works
								</span>
                            </a>
                        </li>

                        @if(Auth::user())
                            <li class="m-menu__item m-menu__item--rel " m-menu-link-redirect="1"
                                aria-haspopup="true">
                                <a href="{{ route('user.logout') }}" class="m-menu__link">
								<span class="m-menu__link-text">
									Logout
								</span>
                                </a>
                            </li>
                        @else
                            <li class="m-menu__item m-menu__item--rel modal-container login-menu" m-menu-link-redirect="1"
                                aria-haspopup="true">
                                <a href="javascript:;" data-toggle="modal" data-target="#signup-modal"
                                   class="m-menu__link login-modal">
                              <span class="m-menu__link-text">
                                     Start teaching
                              </span>
                                </a>
                            </li>
                            <li class="m-menu__item m-menu__item--rel modal-container login-menu" m-menu-link-redirect="1"
                                aria-haspopup="true">
                                <a href="javascript:;" data-toggle="modal" data-target="#login-modal"
                                   class="m-menu__link login-modal">
        								      <span class="m-menu__link-text">
									                   Log In
								              </span>
                                </a>
                            </li>
                            <li class="m-menu__item m-menu__item--rel only-desktop" m-menu-link-redirect="1"
                                aria-haspopup="true">
                                <a href="{{  route('request.tutor')  }}"
                                   class="m-menu__link  signup-modal">
                    								<span class="m-menu__link-text btn btn-primary icon-btn">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M21 21L16.514 16.506L21 21ZM19 10.5C19 12.7543 18.1045 14.9163 16.5104 16.5104C14.9163 18.1045 12.7543 19 10.5 19C8.24566 19 6.08365 18.1045 4.48959 16.5104C2.89553 14.9163 2 12.7543 2 10.5C2 8.24566 2.89553 6.08365 4.48959 4.48959C6.08365 2.89553 8.24566 2 10.5 2C12.7543 2 14.9163 2.89553 16.5104 4.48959C18.1045 6.08365 19 8.24566 19 10.5V10.5Z" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                      Request a Tutor
                    								</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
