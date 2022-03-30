<ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
    <li class="m-nav__item">
        <a href="{{ route('educator.dashboard') }}"
           class="m-nav__link {{ $page == 'overview' ? 'nav-active' : '' }}">
            <i class="m-nav__link-icon fa fa-eye"></i>
            <span class="m-nav__link-text">Overview</span>
        </a>
    </li>
    <li class="m-nav__item">
        <a href="{{ route('educator.classes') }}" class="m-nav__link {{ $page == 'my-classes' ? 'nav-active' : '' }}">
            <i class="m-nav__link-icon fa fa-book  "></i>
            <span class="m-nav__link-text">My Classes / Subjects / Pre-Recorded</span>
        </a>
    </li>
    <li class="m-nav__item">
        <a href="{{ route('educator.today.classes') }}" class="m-nav__link {{ $page == 'today-classes' ? 'nav-active' : '' }}">
            <i class="m-nav__link-icon fa fa-book  "></i>
            <span class="m-nav__link-text">Today's Classes</span>
        </a>
    </li>
    <li class="m-nav__item">
        <a href="{{ route('educator.stats') }}" class="m-nav__link {{ $page == 'my-stats' ? 'nav-active' : '' }}">
            <i class="m-nav__link-icon fa fa-signal  "></i>
            <span class="m-nav__link-text">My Stats</span>
        </a>
    </li>
    <li class="m-nav__item">
        <a href="{{ route('educator.transactions') }}"
           class="m-nav__link {{ $page == 'transactions' ? 'nav-active' : '' }}">
            <i class="m-nav__link-icon fa fa-euro  "></i>
            <span class="m-nav__link-text">Transactional History</span>
        </a>
    </li>
</ul>
<div class="share-this share-this-dash"
     style="display: inline-block; margin-top: 10px">
    <a href="javascript:void(0)"
       data-link="{{ route('page.educator', Auth::user()->slug) }}"
       data-toggle="modal" data-target="#share-profile-modal"
       class="link-01 copy-link"><img src="/img/icons/copy-icon.png" height="20px" style="padding-right: 20px"/>Share my
        profile</a>
</div>
{{--<div class="job-board-link"
     style="margin-top: 10px">
    <a href="{{ route('educator.job-board') }}" class="btn btn-primary job-board-button" style="width: 100%">Jobs Board
        @if(Auth::user()->jobsBoardCount())
            <span class="m-menu__link-badge"><span
                    class="m-badge m-badge--white">{{ Auth::user()->jobsBoardCount() }}</span></span>
        @endif
    </a>
</div>--}}
<!-- end: share link + overlay -->
