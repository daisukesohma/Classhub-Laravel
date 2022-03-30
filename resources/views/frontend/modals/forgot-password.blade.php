<!--begin:: password-reset-conformation Modal-->
<div class="modal fade c-modal v1 forgot-password" id="forgot-password" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">
						&times;
					</span>
                </button>
            </div>
            <div class="modal-body p-lr-42 p-tb-32">

                <div class="title fs-23 fw-5">Forgot your password?</div>
                <div class="p-t-15">Don’t worry. Resetting your password is easy, Just tell us the email address you
                    registered with Classhub.
                </div>

                <!-- starts: Forgot your password -->
                <div class="refund-form list-a-class">
                    {!! Form::open(['url' => route('send.password.reset-code'), 'method' => 'post',
                        'class' => 'm-form m-form--label-align-left- m-form--state-', 'id' => 'forgot-password-form']) !!}

                    {!! Form::hidden('modal_redirect', 1) !!}
                    <div class="m-portlet m-0 m-portlet--full-height payment-terms ">
                        <!--begin: Form Wizard-->
                        <div class="m-wizard__form">
                            <!--
                                1) Use m-form--label-align-left class to alight the form input lables to the right
                                2) Use m-form--state class to highlight input control borders on form validation
                                -->
                            <!--begin: Form Body -->
                            <div class="m-portlet__body">

                                <!-- starts : email text box -->
                                <div class="form-group p-t-24 m-form__group">
                                    <input type="email" class="form-control m-input p-tb-9" required
                                           name="email"
                                           placeholder="Email address"/>
                                </div>
                                <!-- end : email text box -->

                                <!-- starts : Send  button -->
                                <div class="text-right p-b-10 p-t-12">
                                    <button type="submit" class="btn shadow-v4"><span
                                            class="btn__text">Send</span></button>
                                </div>
                                <!-- end : Send  button -->

                                <div class="row modal-errors" id="forgot-password-errors">

                                </div>

                            </div>
                            <!--end: Form Body-->
                        </div>
                        <!--end: Form Wizard-->
                    </div>

                    {!! Form::close() !!}
                </div>
                <!-- end: Forgot your password -->

            </div>
        </div>
    </div>
</div>
<!--end:: password-reset-conformation Modal-->

<!-- starts: including forgot-password modal -->
@include('frontend.modals.password-email-sent')
<!-- end: including forgot-password modal -->
