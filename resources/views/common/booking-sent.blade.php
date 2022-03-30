<div class="modal fade c-modal v1 profile-has-been-updated image-modals" id="booking-sent-modal"
     tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div
        class="modal-dialog modal-dialog-centered image-modals  {{ (new \Jenssegers\Agent\Agent())->isMobile() ? 'mobile-modal' : 'modal-lg' }}"
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
                                <h2 style="font-weight: bold">Your Booking has been sent...
                                </h2>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="float: right">
                            <div class="tc p-t-0">
                                <img
                                    src="{{ asset('img/popup-images/time.png') }}"
                                    alt="">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 text-left">
                        <div style="padding:0px 30px">
                            <h4 style="font-weight: bold">Here’s what happens next...</h4>
                            <p>The parent or student will now receive your booking in their ClassHub inbox. They can
                                either accept or reject it. If they accept it they will be prompted to make payment for
                                the booking. Once this has been done you will receive a notification email and we will
                                automatically update your dashboard with your new booking.
                            </p>
                            <p>
                              All ClassHub lessons are conducted using a ClassHub Zoom account, you don’t need to use your     personal account.  For tablet or smartphone access, just download the Zoom app; otherwise, simply click on the lesson link in your ClassHub messages and you’re off!
                            </p>
                            <p>To learn more about fees and payouts click <a target="_blank" href="{{ route('page.terms-conditions') }}">here.</a>
                            </p>
                            <p>To learn more about how online tuition works on ClassHub click <a target="_blank" href="{{ route('page.online-tuition') }}">here.</a>
                            </p>
                        </div>
                        <div class="p-t-15 text-center">
                            <p style="font-size: 12px;">
                                If you need any help at any point you can email us at
                                <a target="_blank" href="mailto:support@classhub.ie">support@classhub.ie</a></p>
                        </div>
                        <img src="/img/logo/powered-by-zoom.png" alt="powered by zoom" height="20px" style="display: block; margin: 20px auto" />
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
