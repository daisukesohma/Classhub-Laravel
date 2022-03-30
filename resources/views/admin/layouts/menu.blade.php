<button class="m-aside-left-close  m-aside-left-close--skin-light " id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-light ">
    <!-- BEGIN: Aside Menu -->
    <div
        id="m_ver_menu"
        class="m-aside-menu  m-aside-menu--skin-light m-aside-menu--submenu-skin-light "
        m-menu-vertical="1"
        m-menu-scrollable="0" m-menu-dropdown-timeout="500"
    >
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="{{ route('admin.dashboard') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-shapes"></i>
                    <span class="m-menu__link-text">
										Overview
									</span>
                </a>
            </li>
            <li class="m-menu__section ">
                <h4 class="m-menu__section-text">
                    Users
                </h4>
                <i class="m-menu__section-icon flaticon-more-v3"></i>
            </li>
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="{{ route('admin.educators') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-profile"></i>
                    <span class="m-menu__link-text">
										Providers
									</span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="{{ route('admin.global.fees') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-coins"></i>
                    <span class="m-menu__link-text">
										Global Fees
									</span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="{{ route('admin.export.messages') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-chat"></i>
                    <span class="m-menu__link-text">
										Export Messages
									</span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="{{ route('export.students.data') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-users"></i>
                    <span class="m-menu__link-text">
										Export Students Data
									</span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="{{ route('export.tutors.data') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-users"></i>
                    <span class="m-menu__link-text">
										Export Tutors Data
									</span>
                </a>
            </li>
            <li class="m-menu__section ">
                <h4 class="m-menu__section-text">
                    Adverts
                </h4>
                <i class="m-menu__section-icon flaticon-more-v3"></i>
            </li>
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="{{ route('admin.lessons') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-folder-1"></i>
                    <span class="m-menu__link-text">
										View Adverts
									</span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="{{ route('admin.reported.lessons') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-warning-sign"></i>
                    <span class="m-menu__link-text">
										Reported Adverts
									</span>
                </a>
            </li>
            <li class="m-menu__section ">
                <h4 class="m-menu__section-text">
                    Refunds
                </h4>
                <i class="m-menu__section-icon flaticon-more-v3"></i>
            </li>
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="{{ route('admin.refunds') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-business"></i>
                    <span class="m-menu__link-text">
										Manage Refunds
									</span>
                </a>
            </li>
            <li class="m-menu__section ">
                <h4 class="m-menu__section-text">
                    Frontend Settings
                </h4>
                <i class="m-menu__section-icon flaticon-more-v3"></i>
            </li>
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="{{ route('admin.profile') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-profile-1"></i>
                    <span class="m-menu__link-text">
										Edit Frontend Settings
									</span>
                </a>
            </li>

            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="{{ route('admin.categories') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-profile-1"></i>
                    <span class="m-menu__link-text">
										Categories
									</span>
                </a>
            </li>

            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="{{ route('admin.category.banner') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-profile-1"></i>
                    <span class="m-menu__link-text">
										Category Banners
									</span>
                </a>
            </li>

            <li class="m-menu__section ">
                <h4 class="m-menu__section-text">
                    Blog Management
                </h4>
                <i class="m-menu__section-icon flaticon-more-v3"></i>
            </li>
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="{{ route('admin.blogs') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-list"></i>
                    <span class="m-menu__link-text">
										Blog Posts
									</span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="{{ route('admin.post.create') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-add"></i>
                    <span class="m-menu__link-text">
										New Post
									</span>
                </a>
            </li>
            <li class="m-menu__section ">
                <hr/>
                <i class="m-menu__section-icon flaticon-more-v3"></i>
            </li>
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="{{ route('user.logout') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-logout"></i>
                    <span class="m-menu__link-text">
										Log Out
									</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>
