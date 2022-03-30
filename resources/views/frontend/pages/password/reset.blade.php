@extends('frontend.layouts.master')


@section('title')
    Classhub | My Bookings
@endsection


@section('page_style')

@endsection

@section('content')

    <!-- starts : main container -->
    <div class="main-container">

        <div class="container settings-form list-a-class">
            <div class="row">
                <div class="col-xs-12 col-md-8">

                    <div class="title fs-30 fw-5 p-t-15 p-b-25 p-l-0">Reset Password</div>

                    <!-- starts: account settings -->

                    <div class="m-portlet">
                        <div class="m-wizard__form">
                            <!--begin: Form Body -->
                            <div class="m-portlet__body">
                                <!--begin: Form Wizard Step 1-->
                                <div class="row">
                                    @include('messages.all')
                                    @if($expired)
                                        <div>Sorry!, Your password reset link is expired, Please request again <a
                                                href="{{ route('page.forgot.password') }}">from here</a>
                                        </div>

                                    @else
                                        {!! Form:: model(Auth::user(), ['url' => route('reset.password'),
                            'class'=> 'm-form m-form--label-align-left- m-form--state-', 'method' => 'post']) !!}
                                        {!! Form::hidden('reset_code', $passwordReset->code) !!}
                                        {!! Form::hidden('user_id', $passwordReset->user_id) !!}
                                        <div class="col-md-10">
                                            <div class="m-form__section m-form__section--first">

                                                <!-- starts : row 04 -->
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-4 col-lg-4 col-form-label">New Password</label>
                                                    <div class="col-xl-8 col-lg-8">
                                                        <input id="new-password" type="password" name="password"
                                                               class="form-control m-input"/>
                                                        <a href="javascript:void(0)" toggle="#new-password"
                                                           class="fa fa-eye fa-eye-slash toggle-password"></a>
                                                    </div>
                                                </div>
                                                <!-- end : row 04 -->

                                                <!-- starts : row 05 -->
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-4 col-lg-4 col-form-label">Confirm
                                                        Password</label>
                                                    <div class="col-xl-8 col-lg-8">
                                                        <input id="confirm-password" type="password"
                                                               name="password_confirmation"
                                                               class="form-control m-input"/>
                                                        <a href="javascript:void(0)" toggle="#confirm-password"
                                                           class="fa fa-eye fa-eye-slash toggle-password"></a>
                                                    </div>
                                                </div>
                                                <!-- end : row 05 -->


                                                <!-- starts : row 07 -->
                                                <div class="form-group m-form__group row p-t-7">
                                                    <label class="col-xl-4 col-lg-4 col-form-label">&nbsp;</label>
                                                    <div class="col-xl-8 col-lg-8">
                                                        <!-- starts : save & continue -->
                                                        <br><br>
                                                        <div class="col-md-6 text-right col-md-offset-6">
                                                            <button type="submit"
                                                                    class="update-account-btn btn btn-primary shadow-v4"
                                                            ><span
                                                                    class="btn__text">Reset Password</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <!-- end : save & continue -->
                                                </div>
                                            </div>
                                            <!-- end : row 07 -->

                                        </div>
                                </div>
                                {!! Form::close() !!}

                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end: account settings -->

                <!-- starts : bi need help  -->
                <!-- end : btm need help  -->

            </div>
        </div>
    </div>

    <!-- end : main container -->

@endsection

@section('page_scripts')

    <script type="text/javascript">

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

        })
    </script>

@endsection
