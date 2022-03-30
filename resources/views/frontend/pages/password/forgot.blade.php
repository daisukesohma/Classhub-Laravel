@extends('frontend.layouts.master')

@section('title')
    Classhub | Forgot Password
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

                    <!-- starts : Forgot your password -->
                    <!-- starts : top section -->
                    <div class="top-section">
                        <div class="title fs-30 fw-5 p-l-0">Forgot your password?</div>
                        <div class="p-t-20">Don’t worry. Resetting your password is easy, Just tell us the email address
                            you registered with Classhub.
                        </div>
                    </div>
                    <!-- end : top section -->

                    <!-- starts: Forgot your password -->
                    <div class="refund-form list-a-class p-t-24">
                        {!! Form::open(['url' => route('send.password.reset-code'), 'method' => 'post',
                        'class' => 'm-form m-form--label-align-left- m-form--state-']) !!}
                        <div class="m-portlet m-0 m-portlet--full-height payment-terms ">
                            <!--begin: Form Wizard-->
                            <div class="m-wizard__form">
                                <!--
                                    1) Use m-form--label-align-left class to alight the form input lables to the right
                                    2) Use m-form--state class to highlight input control borders on form validation
                                    -->
                                <!--begin: Form Body -->
                                <div class="m-portlet__body p-t-50">

                                    <!-- starts : email text box -->
                                    <div class="form-group m-form__group">
                                        <input type="email" class="form-control m-input p-tb-9" required
                                               placeholder="Email address" name="email"/>
                                    </div>
                                    <!-- end : email text box -->

                                    <!-- starts : Send  button -->
                                    <div class="text-right p-t-24 p-b-10">
                                        <button type="submit" class="btn btn-primary min-width-200 shadow-v4"
                                        ><span
                                                class="btn__text">Send</span></button>
                                    </div>
                                    <!-- end : Send  button -->

                                    <div class="results">
                                        @include('messages.all')
                                    </div>

                                </div>
                                <!--end: Form Body-->
                            </div>
                            <!--end: Form Wizard-->
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <!-- end: Forgot your password -->

                    <!-- end: Forgot your password -->

                </div>
            </div>
        </div>
        <!-- end: bookings sections -->

    </div>
    <!-- end : main container -->


@endsection


@section('page_scripts')
@endsection

