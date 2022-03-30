<!--begin::Modal-->
<div class="modal fade c-modal payment-summary login" id="login-modal" tabindex="-1" role="dialog"
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
                <div class="list-a-class login-c">

                    <div class="text-center fs-23 title p-l-0">Log in to your account</div>

                    <!-- starts : login-with-goo-fb -->
                    <div class="login-with-goo-fb">

                        <button class="facebook social-login" data-href="{{ route('social.redirect', 'facebook') }}">
                            <i class="ti-facebook"></i>
                            Log in with Facebook
                        </button>

                        <button class="google social-login" data-href="{{ route('social.redirect', 'google') }}"
                                id="google-oauth-login">
                            <img src="{{  asset('img/logo/google.png') }}"/>
                            Log in with Google
                        </button>

                    </div>
                    <!-- end : login-with-goo-fb -->

                    <div class="or m-b-14"><span><i>or</i></span></div>

                    <!-- starts : login form -->
                    <div class="payment-form login-form">

                        {!! Form::open(['url' => route('user.login'), 'id' => 'login-form',
                            'class' => 'm-form m-form--label-align-left- m-form--state-',
                            'autocomplete' => 'off']) !!}

                        @if(Route::currentRouteName() !== 'home' || Route::currentRouteName() !== 'password.reset.link')
                            <input type="hidden" name="redirect_url"
                                   value="{{ request('redirect_url') ? request('redirect_url')  : url()->current() }}">
                        @endif

                    <!--begin: Form Wizard-->
                        <div class="m-wizard__form login-inputs">
                            <!--
                                1) Use m-form--label-align-left class to alight the form input lables to the right
                                2) Use m-form--state class to highlight input control borders on form validation
                                -->
                            <!--begin: Form Body -->
                            <div class="m-portlet__body">

                                <!-- starts : row : Email -->
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12">
                                        <input type="text" name="email" class="form-control m-input"
                                               placeholder="Email" autocomplete="off" id="user-email"
                                               style="height: 50px; margin-bottom: 0px" autofocus/>
                                    </div>
                                </div>
                                <!-- end : row : Email -->

                                <!-- starts : row : Password Number -->
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12">
                                        <input type="password" name="password" class="form-control m-input"
                                               placeholder="Password" autocomplete="off" style="height: 50px">
                                    </div>
                                </div>
                                <!-- end : row : Password Number -->

                                <!-- starts : row : remember + forgot pwd -->
                                <div class="form-group m-form__group row fs-13 remember">
                                    <div class="col-xs-5">
                                        <label class="fs-13">Remember me <input type="checkbox"
                                                                                name="remember"/></label>
                                    </div>
                                    <div class="col-xs-7 text-right">
                                        <a href="javascript:void(0);" class="forgot-password" data-dismiss="modal"
                                           data-toggle="modal"
                                           data-target="#forgot-password">Forgot your password?</a>
                                    </div>
                                </div>
                                <!-- end : row : remember + forgot pwd -->

                                <!-- starts : Confirm and pay button -->
                                <div class="text-center">
                                    <button class="btn btn-primary shadow-v4" type="submit" id="login-btn">
                                        <span class="btn__text">Log in</span></button>
                                </div>

                                <div class="row modal-errors" id="login-errors">

                                </div>

                                <!-- end : Confirm and pay button -->

                                <div class="fs-14 text-center">
                                    Don’t have an account? <a href="javascript:void(0);" data-dismiss="modal"
                                                              class="signup-modal"
                                                              data-toggle="modal" data-target="#signup-modal">Sign up
                                        Free</a>.
                                    <div class="p-t-7"><a href="{{ route('page.privacy-cookie') }}">Privacy Policy</a>.
                                    </div>
                                </div>

                            </div>
                            <!--end: Form Body-->
                        </div>
                        <!--end: Form Wizard-->

                        {!! Form::close() !!}

                    </div>
                    <!-- end : login form -->


                </div>
                <!-- end : login content -->

            </div>

        </div>
    </div>
</div>
<!--end::Modal-->

<!-- starts: including forgot-password modal -->
@include('frontend.modals.forgot-password')
<!-- end: including forgot-password modal -->

<script type="text/javascript">
    var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

    if (!iOS) {
        $('input#user-email').prop('readonly', true)

        $('input#user-email').on('focus', function () {
            $(this).val('')
            $(this).prop('readonly', false)
        })
    }
</script>
