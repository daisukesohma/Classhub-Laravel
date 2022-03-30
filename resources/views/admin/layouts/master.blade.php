<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title> @section('title') @show</title>

    @if(env('APP_ENV') == 'development')
        <meta name="robots" content="noindex"/>
    @endif

    @yield('meta_description')

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script type="text/javascript">
        WebFont.load({
            google: {"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]},
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!--begin::Base Styles -->
    <!--begin::Page Vendors -->
    <link href="{{ asset('admin/css/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <!--end::Page Vendors -->
    <link href="{{ asset('admin/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admin/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admin/css/custom.css') }}" rel="stylesheet" type="text/css"/>
    <!--end::Base Styles -->
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}"/>
    <link href="{{ asset('admin/css/jquery-ui.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <!--end::Page Vendors -->
    <style>
        .media-portlet {
            padding: 0px !important;
            height: auto !important;
        }

        .testimonial {
            padding: 20px;
        }

        #animated-lines {
            width: 100% !important;
            height: 300px !important;
            overflow: hidden;
        }
    </style>
    @yield('page_styles')
</head>

<body
    class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile
        m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas
        m-footer--push m-aside--offcanvas-default">

<div class="m-grid m-grid--hor m-grid--root m-page">

    @include('admin.layouts.header')

    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

        @include('admin.layouts.menu')

        <div class="m-grid__item m-grid__item--fluid m-wrapper">

            @yield('content')

        </div>

    </div>

</div>

<script src="{{ asset('admin/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>
<script type="text/javascript">

    // Delete image from database and folder
    /*function deleteImage(obj, imageId, container) {
        var route = ' route('home') }}' + 'image/' + imageId + '/delete'
        console.log(obj, imageId, container)
        $.ajax({
            type: 'DELETE',
            url: route,
            data: {_token: '{{ csrf_token() }}'},
            dataType: 'json',
            success: function (data) {
                console.log(data)
                if (data.status) {
                    $(obj).parents(container).remove();
                } else {
                    //swal('Error', data.messages.join(', '), "error")
                }
            },
            error: function (data) {
                console.log(data)
                //swal('Error', data.messages.join(', '), "error")
            }
        });
    }*/

</script>

@yield('page_scripts')

@include('modals.modal-md')
</body>
</html>

