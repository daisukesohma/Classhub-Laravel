@extends('parent.layouts.master')


@section('title')
    Classhub | Account Settings
@endsection


@section('page_styles')
    <style type="text/css">
        span.card-brand {
            padding: 2px 4px;
            background-color: #000;
            color: #fff;
            font-size: 10px;
            font-weight: bold;
            border: none;
            vertical-align: middle;
        }
    </style>
@endsection

@section('content')

    <!-- starts : main container -->
    <div class="main-container" style="padding-top: 30px">

        <div class="container settings-form list-a-class">
            <div class="row">
                <div class="col-xs-12 padding-mobile-none-lr">

                    <div class="title fs-30 fw-5 p-t-15 p-b-25 p-l-0">ACCOUNT SETTINGS</div>

                    <!-- starts: account settings -->
                    {!! Form:: model(Auth::user(), ['url' => route('parent.update.account'),
                        'class'=> 'm-form m-form--label-align-left- m-form--state-', 'method' => 'post']) !!}
                    <div class="m-portlet">
                        <div class="m-wizard__form">
                            <!--begin: Form Body -->
                            <div class="m-portlet__body">
                                <!--begin: Form Wizard Step 1-->
                                <div class="row">
                                    <div class="col-md-12 padding-mobile-none-lr">
                                        <div class="m-form__section m-form__section--first">

                                            <!-- starts : row 01 -->
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-4 col-lg-4 col-form-label padding-mobile-none-lr">Full Name</label>
                                                <div class="col-xl-8 col-lg-8 padding-mobile-none-lr">
                                                    {!! Form::text('name', null, ['class' => 'form-control m-input',
                                                    'placeholder' => 'John White', 'required' => 'required']) !!}
                                                </div>
                                            </div>
                                            <!-- end : row 01 -->

                                            <!-- starts : row 02 -->
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-4 col-lg-4 col-form-label padding-mobile-none-lr">Email</label>
                                                <div class="col-xl-8 col-lg-8 padding-mobile-none-lr">
                                                    <input type="text" name="email" class="form-control m-input"
                                                           required value="{{ Auth::user()->email }}"
                                                           placeholder="john@gmail.com"/>
                                                </div>
                                            </div>
                                            <!-- end : row 02 -->

                                            <!-- starts : row 03 -->
                                            <div class="form-group m-form__group row padding-mobile-none-lr">
                                                <label class="col-xl-4 col-lg-4 col-form-label">Current
                                                    Password</label>
                                                <div class="col-xl-8 col-lg-8 padding-mobile-none-lr">
                                                    <input id="current-password" type="password" name="current_password"
                                                           class="form-control m-input"/>
                                                    <a href="javascript:void(0)" toggle="#current-password"
                                                       class="fa fa-eye fa-eye-slash toggle-password"></a>
                                                </div>
                                            </div>
                                            <!-- end : row 03 -->

                                            <!-- starts : row 04 -->
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-4 col-lg-4 col-form-label padding-mobile-none-lr">New Password</label>
                                                <div class="col-xl-8 col-lg-8 padding-mobile-none-lr">
                                                    <input id="new-password" type="password" name="password"
                                                           class="form-control m-input"/>
                                                    <a href="javascript:void(0)" toggle="#new-password"
                                                       class="fa fa-eye fa-eye-slash toggle-password"></a>
                                                </div>
                                            </div>
                                            <!-- end : row 04 -->

                                            <!-- starts : row 05 -->
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-4 col-lg-4 col-form-label padding-mobile-none-lr">Confirm
                                                    Password</label>
                                                <div class="col-xl-8 col-lg-8 padding-mobile-none-lr">
                                                    <input id="confirm-password" type="password"
                                                           name="password_confirmation"
                                                           class="form-control m-input"/>
                                                    <a href="javascript:void(0)" toggle="#confirm-password"
                                                       class="fa fa-eye fa-eye-slash toggle-password"></a>
                                                </div>
                                            </div>
                                            <!-- end : row 05 -->

                                            <!-- starts : row 06 -->
                                            <div class="form-group m-form__group row text-links">
                                                <label class="col-xl-4 col-lg-4 col-form-label padding-mobile-none-lr">&nbsp;</label>
                                                <div class="col-xl-8 col-lg-8 p-t-6 padding-mobile-none-lr">
                                                    <div class="row m-0">
                                                        <div class="col-xs-7 col-md-6">
                                                            <a class="link-01"
                                                               href="{{ route('page.forgot.password') }}">Forgot
                                                                your password?</a>
                                                        </div>
                                                        <div class="col-xs-5 col-md-6 text-right">
                                                            <a class="link-01" href="javascript:void(0)"
                                                               data-toggle="modal" data-target="#delete-account-modal">Delete
                                                                account</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end : row 06 -->

                                            <!-- starts : row 07 -->
                                            <div class="form-group m-form__group row p-t-7">
                                                <label class="col-xl-4 col-lg-4 col-form-label">&nbsp;</label>
                                                <div class="col-xl-8 col-lg-8">
                                                    <!-- starts : save & continue -->
                                                    <div class="two-buttons">
                                                        <div class="row m-l-0">
                                                            <div class="col-md-6 col-sm-12" style="margin-top: 10px">
                                                                <a class="btn btn-secondary btn-text-red shadow-v4"
                                                                   href="javascript:void(0);"><span
                                                                        class="btn__text v2">Cancel</span></a>
                                                            </div>
                                                            <div class="col-md-6 col-sm-12 text-right" style="margin-top: 10px; margin-left: 10px">
                                                                <button type="submit"
                                                                        class="btn btn-secondary btn-text-red shadow-v4" style="background-color: #E74B65 !important;"
                                                                ><span
                                                                        class="btn__text" style="color: #fff !important;">Save Changes</span></button>
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

                    <div class="biling-card-table">

                        <div class="title">Billing</div>

                        <table class="table">
                            <tbody>
                            @foreach(Auth::user()->cards as $card)
                                <tr id="{{ $card->card_id }}">
                                    <td style="background:none;padding-left: 0">
                                        <span class="card-brand">{{ strtoupper($card->brand) }}</span> Card
                                        Ending: {{ $card->last4 }}
                                    </td>
                                    <td class="links">
                                        <a href="javascript:void(0)" data-card-id="{{ $card->card_id }}"
                                           data-toggle="modal" data-target="#confirm-delete-card-modal"
                                           data-route="{{ route('parent.delete.card', $card->card_id) }}"
                                           class="delete-card-confirm">Delete</a>

                                        @if(!$card->is_default)
                                            <a href="javascript:void(0)" data-card-id="{{ $card->card_id }}"
                                               data-route="{{ route('parent.default.card', $card->card_id) }}"
                                               data-toggle="modal" data-target="#result-modal"
                                               class="set-default-card">Set as
                                                default</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <a class="btn shadow-v4 m-t-32" href="javascript:void(0);"
                           data-toggle="modal" data-target="#add-card-modal"><span
                                class="btn__text" style="color: #fff">Add New Card</span></a>

                    </div>

                    <!-- starts : bi need help  -->
                    <!-- end : btm need help  -->

                </div>
            </div>
        </div>

    </div>
    <!-- end : main container -->

    @include('parent.modals.confirm-delete-card')

    @include('parent.modals.add-card')

    @include('parent.modals.confirm-opt')

    @include('parent.modals.confirm-delete-account')

@endsection

@section('page_scripts')


    <script type="text/javascript">

        var cardId = ''
        var deleteCardRoute = ''
        var defaultCardRoute = ''
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


            $('button.update-account-btn').on('click', function (e) {
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

            $('a.delete-card-confirm').on('click', function () {
                cardId = $(this).data('card-id')
                deleteCardRoute = $(this).data('route')
            })

            $('a.set-default-card').on('click', function () {
                $(resultModal).modal('show')
                cardId = $(this).data('card-id')
                defaultCardRoute = $(this).data('route')
                $.ajax({
                    type: 'POST',
                    url: defaultCardRoute,
                    data: {_token: '{{ csrf_token() }}'},
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        if (data.status) {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                            setTimeout(function () {
                                location.reload()
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


            $('a.delete-card-btn').on('click', function (e) {
                $('div#confirm-delete-card-modal').modal('hide')
                $(resultModal).modal('show')

                $.ajax({
                    type: 'POST',
                    url: deleteCardRoute,
                    data: {_token: '{{ csrf_token() }}'},
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        if (data.status) {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                            setTimeout(function () {
                                location.reload()
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

            $('a.delete-account-btn').on('click', function (e) {
                $(resultModal).modal('show')
                $(resultModal).find('div.modal-body')
                    .append('<p>Deleteing account.. Please do not close or reload page</p>')

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


        })
    </script>

@endsection
