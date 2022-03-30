<!--begin::Modal-->
<div class="modal fade c-modal payment-summary login sign-up" id="signup-user-type" tabindex="-1" role="dialog"
     aria-labelledby="payment summary" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg1" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <button style="visibility: hidden" type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">
						&times;
					</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- starts : login content -->
                <div class="list-a-class login-c sign-up-c">

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

                                <!-- starts : row : user type -->
                                <h5 class="text-center">I am a:</h5>
                                <div class="center-align">
                                    <a class="user-label user-type-btn" href="{{ route('parent.dashboard') }}"
                                       data-user-type="parent">Parent /
                                        Student<br><br>Click
                                        Here
                                    </a>
                                    <a class="user-label user-type-btn btn-active"
                                       href="{{ route('educator.profile.create') }}" data-user-type="educator">
                                        Teacher / Instructor<br><br>Click
                                        Here
                                    </a>
                                </div>
                            </div>
                            <!-- end : row : user type -->
                        </div>
                        <!--end: Form Body-->
                        {!! Form::close() !!}
                    </div>
                </div>
                <!-- end : sign-up form -->

            </div>
            <!-- end : sign-up content -->

        </div>

    </div>
</div>
<!--end::Modal-->
<style type="text/css">
    .user-type-btn {
        width: 50%;
        display: inline-block;
    }

    .btn-active {
        background-color: #E74B65;
        color: #FFF !important;
    }
</style>
<script type="text/javascript">
    $('a.user-type-btn').on('click', function (e) {
        e.preventDefault()
        var link = $(this).attr('href')
        var userType = $(this).data('user-type');

        $.ajax({
            type: 'POST',
            url: '{{ route('send.email.intercom') }}',
            data: {_token: '{{ csrf_token() }}', user_type: userType},
            success: function (data) {
                window.location = link
            },
            error: function (data) {
            }
        })
    })
</script>
