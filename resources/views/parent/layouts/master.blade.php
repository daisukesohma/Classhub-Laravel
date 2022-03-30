<!doctype html>
<html lang="en">
<head>


    <meta charset="utf-8">
    <title> @section('title') @show</title>

    @if(env('APP_ENV') == 'development')
        <meta name="robots" content="noindex"/>
    @endif

    @yield('meta_description')

    <meta name="viewport" content="width=device-width, initial-scale = 1.0, maximum-scale=1.0, user-scalable=no"/>

    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]},
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>

    @include('common.tracking')

    <link href="{{ asset('parent/assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('parent/assets/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('parent/css/select2.min.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="{{ asset('parent/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" media="all">
    <link href="{{ asset('parent/css/themify-icons.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="{{ asset('parent/css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="{{ asset('parent/css/flexslider.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="{{ asset('parent/css/lightbox.min.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="{{ asset('parent/css/ytplayer.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="{{ asset('parent/css/theme-red.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/brands.css"
          integrity="sha384-QT2Z8ljl3UupqMtQNmPyhSPO/d5qbrzWmFxJqmY7tqoTuT2YrQLEqzvVOP2cT5XW" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600,700" rel="stylesheet">
    <link href="{{ asset('parent/css/font-montserrat.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('parent/css/calendar.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="{{ asset('parent/css/custom.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="{{ asset('parent/css/custom-dash.css') }}" rel="stylesheet" type="text/css" media="all"/>

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" media="all"/>

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}"/>

    @yield('page_styles')

</head>

<body>


{{--@yield('nav-main')--}}


@include('parent.layouts.menu')



@yield('content')

{{--@yield('footer')--}}

@include('common.footer')

@include('modals.modal-response')

@include('common.result-modal')

<script src="{{ asset('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery-match-height-master/jquery.matchHeight-min.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}"></script>


<script type="text/javascript">
    var modalResponse = $('div#modal-response');
    var resultModal = $('div#result-modal');

    $(function () {
        $(".col-eq-height").matchHeight();
    })

    $(resultModal).on('hidden.bs.modal', function (e) {
        $(this).find('div.modal-body').html('<div class="spinner"></div>')
    })

    $('.modal').on('hidden.bs.modal', function (e) {
        $('.modal-backdrop.show').remove()
    })


</script>

@yield('page_scripts')

@include('common.chat')
@include('common.cookie-pro-script')
@include('common.inbox-unread-counter')
@include('common.video-call')

</body>
</html>
