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

    <link href="{{ asset('educator/css/theme-red.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('educator/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('educator/assets/css/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('educator/assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('educator/assets/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('educator/css/multiple-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('educator/css/picker.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600,700" rel="stylesheet">
    <link href="{{ asset('educator/css/font-montserrat.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" media="all">
    <link href="{{ asset('css/themify-icons.css') }}" href="css/themify-icons.css" rel="stylesheet" type="text/css"
          media="all"/>
    <link href="{{ asset('educator/css/mobileSelect.css') }}" rel="stylesheet">
    <link href="{{ asset('educator/css/custom-dash2.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('educator/css/custom-dash.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="{{ asset('educator/css/custom.css') }}" rel="stylesheet" type="text/css" media="all"/>

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}"/>

    <style>
        ::-webkit-scrollbar {
            display: none;
        }

        .mobile-modal {
            margin-top: 20px !important;
        }

        .mobile-modal .modal-header {
            padding-bottom: 5px !important;
        }

        .mobile-modal .modal-body {
            padding: 0 0 25px 0 !important;
        }
    </style>


    @yield('page_styles')

</head>

<body class="m-page--fluid m--skin- m-content--skin-light
 m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push
  m-aside--offcanvas-default m-header--fixed">


<div class="m-grid m-grid--hor m-grid--root m-page">

    @include('educator.layouts.menu')

    @yield('content')

    @include('common.footer')

</div>

@include('modals.modal-response')

@include('common.result-modal')


<script src="{{ asset('educator/assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('educator/assets/demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery-match-height-master/jquery.matchHeight-min.js') }}"></script>
<script src="{{ asset('js/exif.js') }}"></script>
<script src="{{ asset('js/jquery.lazy.min.js') }}"></script>
<script src="{{ asset('js/jquery.lazy.plugins.min.js') }}"></script>

{{--<script src="{{ asset('educator/js/bootstrap.min.js') }}"></script>--}}
<script type="text/javascript">
    // Global response modal variable
        @if(isset($subjects))
    var subjectTeaches =
        {!! json_encode($subjects) !!}
        @else
    var subjectTeaches = []
        @endif

    var modalResponse = $('div#modal-response')
    var resultModal = $('div#result-modal')


    // Prevent dropdown from hiding on click event
    $('div.category-select').on('click', function (e) {
        e.stopPropagation()
    })

    $('div.student-info').on('click', function (e) {
        e.stopPropagation()
    })

    $('div.category-select li.parent-category > span').on('click', function (e) {
        var parent = $(this).parents('li.parent-category');
        $(parent).children('ul').toggleClass('sub-category-show')
    })

    $('div.category-select li.parent-category-sub > span').on('click', function (e) {
        var parent = $(this).closest('li.parent-category-sub');
        $(parent).children('ul').toggleClass('sub-category-show')
    })

    // Multiple subjects select
    $('div.multiple-select div.category-select li.category-sub').on('click', function (e) {
        var categoryName = $(this).children('input').data('category-name')

        if ($(this).hasClass('active')) {
            subjectTeaches = subjectTeaches.filter(item => item !== categoryName)
            $('a#subjects-placeholder').html(subjectTeaches.join(', '))
            $(this).find('input').prop('checked', false)
            $(this).parents('li').removeClass('active')
        } else {
            subjectTeaches.push(categoryName)
            $('a#subjects-placeholder').html(subjectTeaches.join(', '))
            $(this).find('input').prop('checked', true)
        }
        console.log(subjectTeaches)

        autoSaveProfile()
    })

    $('div.single-select div.category-select li.category-sub').on('click', function (e) {
        // Reset selected
        $('div.single-select ul.sub-category-show').removeClass('sub-category-show')
        $('div.single-select li.parent-category').removeClass('active')
        $('div.single-select li.parent-category-sub').removeClass('active')
        $('div.single-select li.category-sub').removeClass('active')
        $('div.single-select input').prop('checked', false)

        // Set selected
        $(this).addClass('active')
        $(this).find('input').prop('checked', true)
        $(this).parents('li').addClass('active')
        $(this).parents('ul').addClass('sub-category-show')

        var categoryName = $(this).children('input').data('category-name')
        $('a#category-placeholder').html(categoryName)

        // if (parentCategory !== 'Others') {
        //     $('a#category-placeholder')[0].click()
        // }
    })

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

    $(resultModal).on('hidden.bs.modal', function (e) {
        $(this).find('div.modal-body').html('<div class="spinner"></div>')
    })

    function copyLink(str) {
        $('body').append(`<textarea  id="link">${str}</textarea>`)
        $('textarea#link').select()
        document.execCommand('copy')
        $('textarea#link').remove()
    }

    $(function () {
        $('.col-eq-height').matchHeight()
        $('.copy-link').on('click', function () {
            copyLink($(this).data('link'))
        })

    })

</script>


@yield('page_scripts')

{{--<script src="{{ asset('educator/js/scripts.js') }}"></script>--}}

@include('common.chat')
@include('common.cookie-pro-script')
@include('common.inbox-unread-counter')
@include('common.video-call')

</body>
</html>
