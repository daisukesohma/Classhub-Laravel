<!--begin::Modal-->
<div class="modal fade c-modal payment-summary login sign-up" id="signup-modal" tabindex="-1" role="dialog"
     aria-labelledby="payment summary" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg1" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">
						&times;
					</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- starts : login content -->
                <div class="list-a-class login-c sign-up-c">

                    <div class="text-center fs-23 title p-l-0">Sign Up</div>

                    <!-- starts : login-with-goo-fb -->
                    <div class="login-with-goo-fb">

                        <button class="facebook social-login" data-href="{{ route('social.redirect', 'facebook') }}">
                            <i class="ti-facebook"></i>
                            Log in with Facebook
                        </button>

                        <button class="google social-login" data-href="{{ route('social.redirect', 'google') }}"
                                id="google-oauth-signup">
                            <img src="{{  asset('img/logo/google.png') }}"/>
                            Log in with Google
                        </button>

                    </div>
                    <!-- end : login-with-goo-fb -->

                    <div class="or m-b-14"><span><i>or</i></span></div>

                    <!-- starts : sign-up form -->
                    <div class="payment-form sign-up-form">

                    {!! Form::open(['url' => route('user.signup') , 'id' => 'signup-form',
                        'class' => 'm-form m-form--label-align-left- m-form--state-']) !!}

                    <!--begin: Form Wizard-->
                        <div class="m-wizard__form">
                            <!--
                                1) Use m-form--label-align-left class to alight the form input lables to the right
                                2) Use m-form--state class to highlight input control borders on form validation
                                -->
                            <!--begin: Form Body -->
                            <div class="m-portlet__body">

                                <!-- starts : row : Full name -->
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12">
                                        <input type="text" name="name" class="form-control m-input" required
                                               placeholder="Full Name" autocomplete="off" autofocus/>
                                    </div>
                                </div>
                                <!-- end : row : Full name -->

                                <!-- starts : row : Email -->
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12">
                                        <input type="email" name="email" class="form-control m-input" required
                                               placeholder="Email" autocomplete="off" style=" margin-bottom: 0px">
                                    </div>
                                </div>
                                <!-- end : row : Email -->

                                <!-- starts : row : Password Number -->
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12">
                                        <input type="password" name="password" class="form-control m-input" required
                                               placeholder="Password" value="">
                                    </div>
                                </div>
                                <!-- end : row : Password Number -->
                            </div>

                            <!-- starts : email opt -->
                            <div class="box shadow-v4 fs-14 m-t-7">

                                <!-- starts : opt -->
                                <div class="opt">
                                    To make sure you get the emails you want from us, plus news about classes and
                                    activities in your area, please confirm you’re happy to hear from us.
                                    <div class="text-center p-tb-32" data-toggle="buttons">
                                        <label class="btn active">
                                            <input type="radio" value="1" name="subscribe_intercom" required checked>
                                            Allow
                                        </label>
                                        <label class="btn">
                                            <input type="radio" value="0" name="subscribe_intercom" required>
                                            Don’t Allow
                                        </label>
                                    </div>
                                </div>
                                <!-- end : opt -->

                                <hr>

                                <!-- starts : t&c -->
                                <div class="tc">
                                    Which user type are you?
                                    <div class="form-group m-form__group row p-t-12 m-0">
                                        <div class="col-xs-12 p-0">
                                                <span class="m-switch m-switch--danger m-switch--icon">
                                                    <label class="fs-14">Parent
                                                        <input id="parentuser" type="radio" name="user_type" value="parent" required/>
                                                        <span></span>
                                                    </label>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row m-0">
                                        <div class="col-xs-12 p-0">
                                                <span class="m-switch m-switch--danger m-switch--icon">
                                                    <label class="fs-14" for="teacheruser">Teacher / Instructor
                                                        <input id="teacheruser" type="radio" name="user_type" value="educator" required/>
                                                        <span></span>
                                                    </label>
                                                </span>
                                        </div>
                                    </div>
                                    <hr>
                                    Please read and accept our T&Cs to continue using the service.
                                    <div class="form-group m-form__group row p-t-12 m-0">
                                        <div class="col-xs-12 p-0">
                                                <span class="m-switch m-switch--danger m-switch--icon">
                                                    <label class="fs-14"><a href="{{ route('page.terms-conditions') }}"
                                                                            target="_blank">Terms & Conditions</a>
                                                        <input type="checkbox" required/>
                                                        <span></span>
                                                    </label>
                                                </span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row m-0">
                                        <div class="col-xs-12 p-0">
                                                <span class="m-switch m-switch--danger m-switch--icon">
                                                    <label class="fs-14"><a href="{{ route('page.privacy-cookie') }}"
                                                                            target="_blank">Privacy Policy</a>
                                                        <input type="checkbox" required/>
                                                        <span></span>
                                                    </label>
                                                </span>
                                        </div>
                                    </div>

                                </div>
                                <!-- end : t&c -->

                            </div>
                            <!-- end : email opt -->

                            <!-- starts : Confirm and pay button -->
                            <div class="text-center p-t-34">
                                <button type="submit" class="btn btn-primary shadow-v4"
                                        id="signup-btn"><span
                                        class="btn__text">Create Account</span></button>
                            </div>

                            <div class="row modal-errors" id="signup-errors">
                            </div>

                            <!-- end : Confirm and pay button -->

                            <div class="fs-14 text-center">
                                <a href="javascript:void(0);" data-dismiss="modal" data-toggle="modal"
                                   data-target="#login-modal" class="login-modal">Log in to existing account</a>.
                            </div>

                        </div>
                        <!--end: Form Body-->
                    </div>
                    <!--end: Form Wizard-->
                    {!! Form::close() !!}
                </div>
                <!-- end : sign-up form -->

            </div>
            <!-- end : sign-up content -->

        </div>

    </div>
</div>
<!--end::Modal-->
