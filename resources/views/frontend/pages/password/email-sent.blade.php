@extends('frontend.layouts.master')

@section('title')
    Classhub | Password Reset Email Sent
@endsection

@section('page_styles')

@endsection

@section('content')



    <!-- starts : main container -->
    <div class="main-container">

        <!-- starts: request refund  -->
        <div class="container p-t-32 request-refund forgot-password p-b-34">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">

                    <!-- starts : top section -->
                    <div class="top-section">
                        <div class="title fs-30 fw-5 p-l-0">Check your email</div>
                    </div>
                    <!-- end : top section -->

                    <!-- starts: Check your email -->
                    <div class="refund-form list-a-class p-t-24">
                        <form class="m-form m-form--label-align-left- m-form--state-" id="m_form">
                            <div class="m-portlet m-0 m-portlet--full-height payment-terms">
                                <!--begin: Form Wizard-->
                                <div class="m-wizard__form">
                                    <!--
                                        1) Use m-form--label-align-left class to alight the form input lables to the right
                                        2) Use m-form--state class to highlight input control borders on form validation
                                        -->
                                    <!--begin: Form Body -->
                                    <div class="m-portlet__body p-tb-32 p-lr-42">

                                        <div>We have sent a reset password email to <strong
                                                class="fw-6">{{ $email }}</strong> Please click the link in the email
                                            to reset your password.
                                        </div>
                                        <div class="p-t-27">Didn’t receive the email yet?</div>
                                        <div>Please check your spam folder, or <a
                                                href="{{ route('page.forgot.password') }}">resend</a>
                                            the email.
                                        </div>
                                        <div class="p-t-20 fs-13">Classhub Reset Password links stay valid for 24 hours
                                            or until you send another reset password email.
                                        </div>

                                    </div>
                                    <!--end: Form Body-->
                                </div>
                                <!--end: Form Wizard-->
                            </div>
                        </form>
                    </div>
                    <!-- end: Check your email -->
                </div>
            </div>
        </div>
        <!-- end: bookings sections -->

    </div>
    <!-- end : main container -->


@endsection


@section('page_scripts')
@endsection

