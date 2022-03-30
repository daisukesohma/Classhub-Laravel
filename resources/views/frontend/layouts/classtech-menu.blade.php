<header id="m_header" class="m-grid__item m-header global-header logout-header shadow-v2" m-minimize-offset="200"
        m-minimize-mobile-offset="200">
    <div class="m-container m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">
            <!-- BEGIN: Brand -->
            <div class="m-stack__item m-brand  m-brand--skin-light ">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo" style="width: 200px">
                        <a href="{{ route('home') }}" class="m-brand__logo-wrapper">
                            <img alt="" src="{{ asset('img/logo/classtech-white.png') }}" class="desktop-logo" style="height: 95px; width: auto!important"/>
                            <img alt="" src="{{ asset('img/logo/classtech-white.png') }}" style="height: 55px; width: auto!important"
                                 class="mobile-logo"/>

                        </a>
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">
                        <!-- BEGIN: Responsive Header Menu Toggler -->
                        <a href="class-tech-v2/#contact" class="request-tutor-link only-mobile">
                          <span class="btn btn-outline-primary">
                            Contact
                          </span>
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
                        <a href="#contact" class="m-menu__link  signup-modal get-started">
                    			<span class="m-menu__link-text btn btn-primary">
                    			     Contact Us
                    			</span>
                        </a>
                      </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
