@extends('educator.layouts.master')

@section('title')
    Classhub | Account Settings
@endsection

@section('page_styles')

@endsection

@section('content')

    <div
        class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body settings-form list-a-class">
        <div class="m-grid__item m-grid__item--fluid m-wrapper">

            <div class="row col-12 padding-mobile-none-lr">
                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 padding-mobile-none-lr" style="margin: 0 auto;">

                    <div class="m-content account-settings">

                        <div class="title fs-30 fw-5 p-t-15 p-b-25 p-l-0">ACCOUNT SETTINGS</div>

                        <div class="row">
                            <div class="col-xl-3 col-lg-4 padding-mobile-none-lr">

                                <!-- starts : account settings-form  -->
                                <div class="profile-side-nav">
                                    <div class="m-portlet">
                                        <div class="m-portlet__body">
                                            <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
                                                <li class="m-nav__item">
                                                    <a href="{{ route('educator.profile.create') }}?user_type=1"
                                                       class="m-nav__link">
                                                        <i class="m-nav__link-icon fa fa-cog"></i>
                                                        <span class="m-nav__link-text">Edit Profile</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="javascript:void(0);" data-toggle="modal"
                                                       id="preview-profile-btn"
                                                       data-target="#preview-profile" class="m-nav__link">
                                                        <i class="m-nav__link-icon fa fa-eye"></i>
                                                        <span
                                                            class="m-nav__link-text">Preview Profile</span>

                                                    </a>
                                                </li>
                                                @if(Auth::user()->is_online)
                                                    <li class="m-nav__item">
                                                        <a href="javascript:void(0);" data-toggle="modal"
                                                           id="go-offline-btn"
                                                           data-target="#go-offline" class="m-nav__link">
                                                            <i class="m-nav__link-icon fa fa-eye"></i>
                                                            <span
                                                                class="m-nav__link-text">Go Offline<br>
                                                            <span
                                                                class="m-nav__link-subtitle">Your profile is <span
                                                                    class="color-02">online</span></span></span>

                                                        </a>
                                                    </li>
                                                @else
                                                    <li class="m-nav__item">
                                                        <a href="javascript:void(0);"
                                                           class="m-nav__link color-02 go-online-btn">
                                                            <i class="m-nav__link-icon fa fa-eye-slash  go-online-icon"></i>
                                                            <span
                                                                class="m-nav__link-text go-online-icon">Go Online<br>
                                                            <span
                                                                class="m-nav__link-subtitle"
                                                                style="color: #1F323D!important">Your profile is <span
                                                                    class="color-02">offline</span></span></span>

                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>


                                        </div>
                                    </div>

                                </div>
                                <!-- end : account settings-form -->

                            </div>

                            <div class="col-xl-9 col-lg-8 padding-mobile-none-lr">

                                <!-- starts: account settings -->
                                {!! Form:: model(Auth::user(), ['url' => route('parent.update.account'),
                         'class'=> 'm-form m-form--label-align-left- m-form--state-', 'method' => 'post']) !!}

                                {!! Form::hidden('name', Auth::user()->name) !!}
                                <div class="m-portlet">
                                    <div class="m-wizard__form">
                                        <!--
                                        1) Use m-form--label-align-left class to alight the form input lables to the right
                                        2) Use m-form--state class to highlight input control borders on form validation
                                        -->
                                        <!--begin: Form Body -->
                                        <div class="m-portlet__body">
                                            <!--begin: Form Wizard Step 1-->
                                            <div class="row">
                                                <div class="col-md-12 padding-mobile-none-lr">
                                                    <div class="m-form__section m-form__section--first">

                                                        <!-- starts : row 01 -->
                                                        <!-- <div class="form-group m-form__group row">
                                                            <label class="col-xl-4 col-lg-4 col-form-label">Full Name</label>
                                                            <div class="col-xl-8 col-lg-8">
                                                                <input type="text" class="form-control m-input" placeholder="John White" />
                                                            </div>
                                                        </div> -->
                                                        <!-- end : row 01 -->

                                                        <!-- starts : row 02 -->
                                                        <div class="form-group m-form__group row">
                                                            <label
                                                                class="col-xl-4 col-lg-4 col-form-label padding-mobile-none-lr">Email</label>
                                                            <div class="col-xl-8 col-lg-8 padding-mobile-none-lr">
                                                                <input type="text" class="form-control m-input"
                                                                       value="{{ Auth::user()->email }}"
                                                                       placeholder="john@gmail.com" name="email"/>
                                                            </div>
                                                        </div>
                                                        <!-- end : row 02 -->

                                                        <!-- starts : row 03 -->
                                                        <div class="form-group m-form__group row">
                                                            <label
                                                                class="col-xl-4 col-lg-4 col-form-label padding-mobile-none-lr">Current
                                                                Password</label>
                                                            <div class="col-xl-8 col-lg-8 padding-mobile-none-lr">
                                                                <input id="current-password" type="password"
                                                                       name="current_password"
                                                                       class="form-control m-input"/>
                                                                <a href="javascript:void(0)"
                                                                   toggle="#current-password"
                                                                   class="fa fa-eye fa-eye-slash toggle-password"></a>
                                                            </div>
                                                        </div>
                                                        <!-- end : row 03 -->

                                                        <!-- starts : row 04 -->
                                                        <div class="form-group m-form__group row">
                                                            <label
                                                                class="col-xl-4 col-lg-4 col-form-label padding-mobile-none-lr">New
                                                                Password</label>
                                                            <div class="col-xl-8 col-lg-8 padding-mobile-none-lr">
                                                                <input id="new-password" type="password"
                                                                       name="password"
                                                                       class="form-control m-input"/>
                                                                <a href="javascript:void(0)" toggle="#new-password"
                                                                   class="fa fa-eye fa-eye-slash toggle-password"></a>
                                                            </div>
                                                        </div>
                                                        <!-- end : row 04 -->

                                                        <!-- starts : row 05 -->
                                                        <div class="form-group m-form__group row">
                                                            <label
                                                                class="col-xl-4 col-lg-4 col-form-label padding-mobile-none-lr">Confirm
                                                                Password</label>
                                                            <div class="col-xl-8 col-lg-8 padding-mobile-none-lr">
                                                                <input id="confirm-password" type="password"
                                                                       name="password_confirmation"
                                                                       class="form-control m-input"/>
                                                                <a href="javascript:void(0)"
                                                                   toggle="#confirm-password"
                                                                   class="fa fa-eye fa-eye-slash toggle-password"></a>
                                                            </div>
                                                        </div>
                                                        <!-- end : row 05 -->

                                                        <!-- starts : row 06 -->
                                                        <div class="form-group m-form__group row text-links">
                                                            <label
                                                                class="col-xl-4 col-lg-4 col-form-label padding-mobile-none-lr">&nbsp;</label>
                                                            <div class="col-xl-8 col-lg-8 p-t-6 padding-mobile-none-lr">
                                                                <div class="row m-0">
                                                                    <div class="col-7">
                                                                        <a class="link-01"
                                                                           href="{{ route('page.forgot.password') }}">Forgot
                                                                            your
                                                                            password?</a>
                                                                    </div>
                                                                    <div class="col-5 text-right">
                                                                        <a class="link-01" href="javascript:void(0)"
                                                                           data-toggle="modal"
                                                                           data-target="#delete-account-modal">Delete
                                                                            account</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end : row 06 -->

                                                        <!-- starts : row 07 -->
                                                        <div class="form-group m-form__group row p-t-7">
                                                            <label
                                                                class="col-xl-4 col-md-12 col-lg-12 col-form-label">&nbsp;</label>
                                                            <div class="col-xl-8 col-lg-12">
                                                                <!-- starts : save & continue -->
                                                                <div class="two-buttons">
                                                                    <div class="row m-l-0">
                                                                        <div class="col-sm-12 col-lg-6 col-md-6" style="margin-top: 10px">
                                                                            <a class="btn btn-secondary btn-text-red shadow-v4"
                                                                               href="javascript:void(0);"><span
                                                                                    class="btn__text v2">Cancel</span></a>
                                                                        </div>
                                                                        <div
                                                                            class="col-sm-12 col-lg-6 col-md-6" style="margin-top: 10px">
                                                                            <a class="btn btn-secondary btn-text-red shadow-v4" style="background-color: #E74B65 !important;"
                                                                               href="javascript:void(0);"><span
                                                                                    class="btn__text" style="color:#fff !important;">Save Changes</span></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- end : save & continue -->
                                                            </div>
                                                        </div>
                                                        <!-- end : row 07 -->

                                                        <!-- starts : row 08 -->
                                                        <div class="form-group m-form__group row p-t-7">
                                                            <div class="col-xs-12 eamil-opt fs-13">
                                                                Email marketing? <a href="javascript:;"
                                                                                    data-route="{{ route('intercom.update', [Auth::user()->id, 'subscribe']) }}"
                                                                                    class="opt-in"
                                                                                    data-toggle="modal"
                                                                                    data-target="#opt-confirm-modal">Opt
                                                                    in</a> | <a href="javascript:;"
                                                                                data-route="{{ route('intercom.update', [Auth::user()->id, 'unsubscribe']) }}"
                                                                                class="opt-out"
                                                                                data-toggle="modal"
                                                                                data-target="#opt-confirm-modal">Opt
                                                                    out</a>
                                                            </div>
                                                        </div>
                                                        <!-- end : row 08 -->

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                            <!-- end: account settings -->

                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- starts : modal preview profile -->
    <div class="modal fade c-modal preview-profile-modal" id="preview-profile" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered container p-0" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <!-- starts: teacher profile -->

                    <!-- end: teacher profile -->
                </div>
            </div>
        </div>
    </div>
    <!-- end : modal preview profile -->

    <!--begin:: Go Offline Modal-->
    <div class="modal fade c-modal v1" id="go-offline" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="title fs-23 fw-5 text-center" style="width: 100%">Are you
                        sure?
                    </div>
                    <button type="button" class="close " data-dismiss="modal"
                            aria-label="Close">
                            					<span aria-hidden="true">
                            						&times;
                            					</span>
                    </button>
                </div>
                <div class="modal-body text-center" style="padding: 55px 45px 20px 45px">

                    <div class="p-t-7">Your profile and classes will be hidden from all
                        Classhub users. As a result, you will be unable to take
                        any new bookings until you go ‘Online’.
                    </div>

                    <div class="two-buttons p-b-25 p-t-55" style="margin-top: 50px">
                        <div class="row">
                            <div class="col-6 text-center">
                                <a class="btn btn-secondary btn-text-red shadow-v4 go-offline-btn"
                                   href="javascript:void(0);"
                                   data-dismiss="modal"><span
                                        class="btn__text v1 fw-6 ">Yes</span>
                                </a>
                            </div>
                            <div class="col-6 text-center">
                                <a class="btn btn-sm btn-primary v2 shadow-v4 "
                                   data-dismiss="modal"
                                   href="javascript:void(0);"><span
                                        class="btn__text v1 fw-6">No</span></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--end:: go Offline Modal-->
    <!--begin:: Unable To Go Offline Modal-->
    <div class="modal fade c-modal v1" id="go-offline-error" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="title fs-23 fw-5 text-center color-02" style="width: 100%">
                        You can’t go offline with future bookings
                    </div>
                    <button type="button" class="close " data-dismiss="modal"
                            aria-label="Close">
                            					<span aria-hidden="true">
                            						&times;
                            					</span>
                    </button>
                </div>
                <div class="modal-body text-center" style="padding: 55px 45px">

                    <div class="p-t-7">To go offline, you must have no upcoming bookings
                        to fulfill. Please carry out or refund your bookings to
                        go offline.
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--end:: Unable to go Offline Modal-->
    <!--begin:: You are now Offline Modal-->
    <div class="modal fade c-modal v1" id="go-offline-success" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="title fs-23 fw-5 text-center color-02" style="width: 100%">You
                        are now offline!
                    </div>
                    <button type="button" class="close " data-dismiss="modal"
                            aria-label="Close">
                            					<span aria-hidden="true">
                            						&times;
                            					</span>
                    </button>
                </div>
                <div class="modal-body text-center" style="padding: 25px 45px">
                    <i class="flaticon-like fs-52 color-02"></i>
                    <div class="p-t-20">Your profile and classes are now hidden from all
                        Classhub users. As a result, you will be unable to take
                        any new bookings until you go ‘Online’.
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--end:: You are now Offline Modal-->
    <!--begin:: You are now Online Modal-->
    <div class="modal fade c-modal v1" id="go-online-success" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="title fs-23 fw-5 text-center color-02" style="width: 100%">You
                        are now online!
                    </div>
                    <button type="button" class="close " data-dismiss="modal"
                            aria-label="Close">
                            					<span aria-hidden="true">
                            						&times;
                            					</span>
                    </button>
                </div>
                <div class="modal-body text-center" style="padding: 25px 45px">
                    <i class="flaticon-like fs-52 color-02"></i>
                    <div class="p-t-20">Your profile and classes are now visible to all
                        Classhub users. As a result, you will be able to take
                        new bookings.
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--end:: You are now Online Modal-->

    @include('educator.modals.confirm-opt')

    @include('educator.modals.confirm-delete-account')

@endsection

@section('page_scripts')

    <script type="text/javascript">

        var modalPreview = $('div#preview-profile');
        var emailOptRoute = ''

        $(function () {

            $('.toggle-password').click(function () {
                $(this).toggleClass('fa-eye-slash');
                var input = $($(this).attr('toggle'));
                if (input.attr('type') == 'password') {
                    input.attr('type', 'text');
                } else {
                    input.attr('type', 'password');
                }
            });

            $('a.opt-in, a.opt-out').on('click', function (e) {
                emailOptRoute = $(this).data('route')
            })

            $('a.update-account-btn').on('click', function (e) {
                $(resultModal).modal('show')

                e.preventDefault()

                var form = $(this).parents('form')
                console.log($(form).serialize())

                $.ajax({
                    type: 'POST',
                    url: $(form).attr('action'),
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        if (data.status) {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))

                        } else {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    },
                    error: function (data) {
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    }
                })
                return false
            })

            $('a.delete-account-btn').on('click', function (e) {
                $(resultModal).modal('show')
                $(resultModal).find('div.modal-body')
                    .append('<p>Deleting account.. Please do not close or reload page</p>')

                $('div#delete-account-modal').modal('hide')

                e.preventDefault()
                $.ajax({
                    type: 'DELETE',
                    url: '{{ route('delete.account', Auth::user()->id) }}',
                    data: {_token: '{{ csrf_token() }}'},
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        if (data.status) {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))

                            setTimeout(function () {
                                window.location = '{{ route('home') }}'
                            }, 2000)
                        } else {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    },
                    error: function (data) {
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    }
                })
                return false
            })

            $('a.intercom-opt').on('click', function (e) {
                $('div#opt-confirm-modal').modal('hide')
                $(resultModal).modal('show')
                $.ajax({
                    type: 'POST',
                    url: emailOptRoute,
                    data: {_token: '{{ csrf_token() }}'},
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        if (data.status) {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        } else {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    },
                    error: function (data) {
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    }
                })
                return false
            })


            $('a#preview-profile-btn').on('click', function () {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('educator.profile.preview', Auth::user()->id) }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_type: '{{ Auth::user()->educator->user_type ? Auth::user()->educator->user_type : 2 }}'
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.status) {
                            $(modalPreview).find('div.modal-body')
                                .html(data.profile)
                        } else {
                            $(modalPreview).modal('hide')
                            $(modalResponse).find('div.modal-body')
                                .html(data.messages.join('<br>'))

                            $('a#modal-response-trigger')[0].click();
                        }
                    },
                    error: function (data) {
                        $(modalPreview).modal('hide')
                        $(modalResponse).find('div.modal-body')
                            .html(data.messages.join('<br>'))

                        $('a#modal-response-trigger')[0].click();
                    }
                })
            })

            $('a.go-offline-btn').on('click', function (e) {
                $('div#go-offline').modal('hide')

                $.ajax({
                    type: 'POST',
                    url: '{{ route('educator.go-offline') }}',
                    data: {_token: '{{ csrf_token() }}'},
                    dataType: 'json',
                    success: function (data) {
                        if (data.status) {
                            $('div#go-offline-success').modal('show')

                            setTimeout(function () {
                                window.location = '{{ route('educator.account.settings') }}'
                            }, 2000)
                        } else {
                            $('div#go-offline-error').modal('show')
                        }
                    },
                    error: function (data) {
                        $('div#go-offline-error').modal('show')
                    }
                })
                return false
            })


            $('a.go-online-btn').on('click', function (e) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('educator.go-online') }}',
                    data: {_token: '{{ csrf_token() }}'},
                    dataType: 'json',
                    success: function (data) {
                        if (data.status) {
                            $('div#go-online-success').modal('show')

                            setTimeout(function () {
                                window.location = '{{ route('educator.account.settings') }}'
                            }, 2000)
                        } else {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                            $(resultModal).modal('show')
                        }
                    },
                    error: function (data) {
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        $(resultModal).modal('show')
                    }
                })
                return false
            })


        })


    </script>
@endsection
