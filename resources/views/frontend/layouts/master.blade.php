<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title> @section('title') @show</title>
    @yield('course_meta')
    @if(env('APP_ENV') == 'development')
        <meta name="robots" content="noindex"/>
    @endif

    @include('common.tracking')

    @yield('meta_tags')

    <meta name="viewport" content="width=device-width, initial-scale = 1.0, maximum-scale=1.0, user-scalable=no"/>
    <link href="{{ asset('assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/demo/default/base/style.bundle.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" media="all"/>
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('css/themify-icons.css') }}" rel="stylesheet" media="all"/>
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" media="all"/>
    <link href="{{ asset('css/flexslider.css') }}" rel="stylesheet" media="all"/>
    <link href="{{ asset('css/lightbox.min.css') }}" rel="stylesheet" media="all"/>
    <link href="{{ asset('css/ytplayer.css') }}" rel="stylesheet" media="all"/>
    <link href="{{ asset('css/theme-red.css') }}" rel="stylesheet" media="all"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600,700" rel="stylesheet">
    <link href="{{ asset('css/font-montserrat.css') }}" rel="stylesheet">
    <link href="{{ asset('css/calendar.css') }}" rel="stylesheet" media="all"/>
    <link href="{{ asset('js/flickity/flickity.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/jquery.fadeshow-0.1.1.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/custom.css?v=8') }}" rel="stylesheet" media="all"/>

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}"/>

    @yield('page_styles')

    <style>
        input.bookable {
            color: #fff !important;
        }

        .foundry_modal {
            min-height: 150px;
        }

        .product-thumb {
            height: 250px;
            width: auto;
            object-fit: cover;
        }

        @media (max-width: 500px) {
            .product-thumb {
                height: auto;
            }
        }

        div.modal-errors div {
            background-color: #E74B65;
            padding: 10px 20px;
            border-radius: 3px;
            margin: 5px;
            color: #ffffff;
        }

        a.hover-pink:hover {
            background-color: #E74B65 !important;
        }
    </style>

</head>


<body class="m-header--fixed">

<!-- End Google Tag Manager (noscript) -->
@if(Route::currentRouteName() == 'page.business')
    @include('frontend.layouts.classtech-menu')
@elseif(Auth::user() && Auth::user()->educator && !session()->get('user_mode') == 'parent')
    @include('educator.layouts.menu')

@elseif(Auth::user() && Auth::user()->parent && request()->route()->getName() == 'home')
    @include('parent.layouts.home-menu')

@elseif(!Auth::user() && request()->route()->getName() == 'home')
    @include('frontend.layouts.home-menu')
@else
    @include($menu)
@endif

<div class="main-container p-b-0">

    @yield('content')

    {{--@yield('footer')--}}

    @include('common.footer')

</div>


@include('frontend.modals.login')
@include('frontend.modals.signup')
@include('common.result-modal')

<script src="{{ asset('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery-match-height-master/jquery.matchHeight-min.js') }}"></script>
{{--<script src="{{ asset('js/scripts.js') }}"></script>--}}
<script src="{{ asset('js/jquery.jscroll.min.js') }}"></script>
<script src="{{ asset('js/show-more.js') }}"></script>
<script src="{{ asset('js/jquery.fadeshow-0.1.2.min.js') }}"></script>
@if(request('login_modal'))
<script type="text/javascript">
    $(function(){
        var isLoggedIn = parseInt({{ Auth::user() ? 1 : 0 }})
        var redirectUrl = '{{ request('redirect_url')  ? request('redirect_url')  : 0 }}'
        if(!isLoggedIn) {
            $('div#login-modal').modal('show')
        }

        if(isLoggedIn && redirectUrl){
            window.location = redirectUrl
        }
    })
</script>
@endif
@if(session('new_user'))
    @php Session::forget('new_user') @endphp
    @include('frontend.modals.signup-user-type')

    <script type="text/javascript">
        $(function () {
            $('div#signup-user-type').modal('show')
        })
    </script>
@endif
<script type="text/javascript">

    var resultModal = $('div#result-modal');
    var recipientId = null;

    $(function () {

        $('body').on('click', 'a.read-more-btn', function () {
            $(this).siblings('.text-exposed-hide').hide();
            $(this).siblings('.text-exposed-show').show();
            $(this).hide();
        })

        $('body').on('click', 'a.read-less-btn', function () {
            $(this).siblings('.text-exposed-hide').show();
            $(this).siblings('.text-exposed-show').hide();
            $(this).hide();
        })

        $(".col-eq-height").matchHeight();

        // Prevent dropdown from hiding on click event
        $('div.category-select li.parent-category').on('click', function (e) {
            e.stopPropagation()
        })

        $('dt.reset-category').on('click', function () {
            $('a#search-category-title').html('All grinds / activities')
            $('dl.category-dropdown input').attr('checked', false)
            $('a#search-category-title').click()
            $('li.parent-category').removeClass('active')
            $('li.category-sub').removeClass('active')
            $('ul.sub-category-list').removeClass('sub-category-show')
        })

        $('div.category-select li.parent-category > span').on('click', function (e) {
            $(this).parents('.parent-category').toggleClass('active')
            $(this).siblings('ul').toggleClass('sub-category-show')
        })

        $('div.category-select li.parent-category-sub > span').on('click', function (e) {
            $(this).closest('.parent-category-sub').toggleClass('active')
            $(this).siblings('ul').toggleClass('sub-category-show')
        })

        $('div.category-select li.category-sub').on('click', function (e) {
            // Reset selected
            $('div.category-select ul.sub-category-show').removeClass('sub-category-show')
            $('div.category-select li.parent-category').removeClass('active')
            $('div.category-select li.parent-category-sub').removeClass('active')
            $('div.category-select li.category-sub').removeClass('active')
            $('div.category-select input').prop('checked', false)

            // Set selected
            $(this).addClass('active')
            $(this).find('input').prop('checked', true)
            $(this).parents('li').addClass('active')
            $(this).parents('ul').addClass('sub-category-show')

            var categoryName = $(this).children('input').data('category-name')
            $('a#search-category-title').html(categoryName)
            $('a#search-category-title')[0].click();
            $('div.m-dropdown__dropoff').remove();
        })

        $('button.social-login').on('click', function () {
            window.location = $(this).data('href')
        })

        $('form#login-form').on('submit', function (evt) {
            evt.preventDefault();
            $('div#login-modal div#login-errors').html('')
            $('button#login-btn').prop('disabled', true)

            $.ajax({
                type: 'POST',
                url: '{{ route('user.login') }}',
                data: $('form#login-form').serialize(),
                success: function (data) {
                    console.log(data)
                    if (data.status) {
                        $('li.login-menu').css('visibility', 'hidden')
                        if (data.request_tutor) {
                            $('div#login-modal').modal('hide')
                            $(data.request_tutor).click()
                        } else {
                            window.location = data.redirect_url
                        }
                    } else {
                        $('div#login-modal div#login-errors').html('<div>' + data.messages.join('<br>') + '</div>')
                        $('button#login-btn').prop('disabled', false)
                    }
                },
                error: function (data) {
                    $('div#login-modal div#login-errors').html('<div>' + data.messages.join('<br>') + '</div>')
                    $('button#login-btn').prop('disabled', false)
                }
            })

        })

        $('form#signup-form').on('submit', function (evt) {
            evt.preventDefault();
            $('div#signup-modal div#login-errors').html('')
            $('button#signup-btn').prop('disabled', true)

            $.ajax({
                type: 'POST',
                url: '{{ route('user.signup') }}',
                data: $('form#signup-form').serialize(),
                success: function (data) {
                    if (data.status) {
                        $('li.login-menu').css('visibility', 'hidden')
                        if (data.request_tutor) {
                            $('div#signup-modal').modal('hide')
                            $(data.request_tutor).click()
                        } else {
                            window.location = data.redirect_url
                        }
                    } else {
                        $('div#signup-modal div#signup-errors').html('<div>' + data.messages.join('<br>') + '</div>')
                        $('button#signup-btn').prop('disabled', false)
                    }
                },
                error: function (data) {
                    $('div#signup-modal div#signup-errors').html('<div>' + data.messages.join('<br>') + '</div>')
                    $('button#signup-btn').prop('disabled', false)
                }
            })

        })

        $('form#forgot-password-form').on('submit', function (evt) {
            evt.preventDefault();

            console.log('{{ route('send.password.reset-code') }}')

            $.ajax({
                type: 'POST',
                url: '{{ route('send.password.reset-code') }}',
                data: $('form#forgot-password-form').serialize(),
                success: function (data) {
                    if (data.status) {
                        $('div#forgot-password button.close').click()
                        $('strong#sent-reset-email').html(data.email)
                        $('div#sent-reset-password-email').modal('show')

                    } else {
                        $('div#forgot-password div#forgot-password-errors').html('<div>' + data.messages.join('<br>') + '</div>')
                    }
                },
                error: function (data) {
                    $('div#forgot-password div#forgot-password-errors').html('<div>' + data.messages.join('<br>') + '</div>')
                }
            })

        })


    })

    $('body').on('click', 'a.login-modal, a.signup-modal, a.forgot-password', function () {
        $('div.modal-errors').html('')
    })


    $(resultModal).on('hidden.bs.modal', function (e) {
        $(this).find('div.modal-body').html('<div class="spinner"></div>')
    })

    function copyLink(str) {
        $('body').append(`<textarea id="link">${str}</textarea>`)
        $('textarea#link').select()
        document.execCommand('copy')
        $('textarea#link').remove()
    }

    $(function () {
        $('.col-eq-height').matchHeight()
        $('.copy-link').on('click', function () {
            copyLink($(this).data('link'))
        })

        $('a.area-select').on('click', function () {
            $('div.m-dropdown__dropoff').remove();
        })
    })

    $(document).ready(function () {
        // Transition effect for navbar
        $('body').scroll(function () {
            // checks if window is scrolled more than 500px, adds/removes solid class
            if ($(this).scrollTop() > 55) {

                $('.mobile-transparent').addClass('scrolled');
            } else {
                $('.mobile-transparent').removeClass('scrolled');
            }
        });
    });


    $('body').on('click', 'button#new-schedule-btn', function () {
        recipientId = $(this).data('recipient-id')
        console.log(recipientId)
    })
</script>

@yield('page_scripts')

@include('common.chat')
@include('common.cookie-pro-script')
@include('common.inbox-unread-counter')
@include('frontend.modals.new-video-call-scheduler')
@include('common.video-call')
{{--@include('common.twilio-video-call')--}}

</body>
</html>
