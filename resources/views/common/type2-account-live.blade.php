<div class="modal fade c-modal v1 profile-has-been-updated image-modals" id="type2-account-live"
     tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div
        class="modal-dialog modal-dialog-centered {{ (new \Jenssegers\Agent\Agent())->isMobile() ? 'mobile-modal' : 'modal-lg' }}"
        role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">
						&times;
					</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="float: left">
                            <div class="tc p-t-0 modal-title">
                                <h2 style="font-weight: bold">Your profile and classes are now live!
                                </h2>
                                <br>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="float: right">

                            <div class="tc p-t-0">
                                <img src="{{ asset('img/popup-images/profile-live.png') }}" alt="profile live success graphic">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 text-left">
                        <div style="padding:0px 30px">
                            <h4 style="font-weight: bold">Here’s what happens next...</h4>
                            <ol class="account-live-list">
                                <li>Your profile and classes are now visible on classhub.
                                </li>
                                <li>You will be able to receive bookings from parents and students.
                                </li>
                                <li>Everytime a booking is made we will send you a notification email that outlines the
                                    booking details.

                                </li>
                                <li>We automatically update your dashboard with the new booking date and student name.

                                </li>
                                <li>
                                    We will remind you of this booking 24 hours before it begins with a notification
                                    email.

                                </li>
                            </ol>
                        </div>
                        <div class="p-t-15 text-center">
                            <a href="{{ route('educator.dashboard') }}" class="btn btn-primary shadow-v4"
                               style="padding: 10px 40px">Go to Dashboard
                            </a>
                        </div>
                        <div class="p-t-15 text-center">
                            <p style="font-size: 12px;">
                                If you need any help at any point you can email us at
                                <a
                                    href="mailto:support@classhub.ie">support@classhub.ie</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--ends : fee structure modal -->
</div>
<style type="text/css">
    .account-live-list li {
        padding-left: 20px;
        padding-bottom: 10px;
    }
</style>
