<div class="modal fade c-modal v1 profile-has-been-updated image-modals" id="booking-confirmed-modal"
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

                                <h2 style="font-weight: bold">
                                    @if($lesson && $lesson->type === 'pre_recorded')
                                        Your video purchase is confirmed...
                                    @else
                                        Your video booking is confirmed...
                                    @endif

                                </h2>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="float: right">
                            <div class="tc p-t-0">
                                <img
                                    src="{{ asset('img/popup-images/booking-confirmed.png') }}"
                                    alt="">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 text-left">
                        <div style="padding:0px 30px">
                            <h4 style="font-weight: bold">Here’s what happens next... </h4>
                            <ol class="account-live-list">
                                @if($lesson && $lesson->type === 'pre_recorded')
                                    <li>We have updated your “Current Bookings and Purchased Videos” area with your
                                        purchase.
                                    </li>
                                    <li>We have sent you a confirmation email and receipt.</li>
                                    <li>You can contact your tutor by messaging them from their profile, your booking area or from you ClassHub inbox.
                                    </li>
                                    <li>You will need to be logged into your ClassHub account to access your online lesson.  Five minutes before your lesson begins, you will see a pop-up message asking you to join the online lesson.  Simply click ‘Join’ and you’re ready to go.
                                    </li>
                                @else
                                    <li>We have updated your “Current Bookings” area with your
                                        new booking.
                                    </li>
                                    <li>We have sent you a confirmation email and receipt.</li>
                                    <li>You can contact your tutor by messaging them from their profile, your booking area or from you ClassHub inbox.
                                    </li>
                                    <li>You will need to be logged into your ClassHub account to access your online lesson.  Five minutes before your lesson begins, you will see a pop-up message asking you to join the online lesson.  Simply click ‘Join’ and you’re ready to go.</li>
                                    <li>To learn more about how your ClassHub online lesson works, click
                                        <a
                                            target="_blank" href="{{ route('page.online-tuition') }}">here.</a></li>
                                    <li>All ClassHub lessons are conducted using a ClassHub Zoom account, you don’t need to use a personal account.  For tablet or smartphone access, just download the Zoom app; otherwise, simply click on the lesson link in your ClassHub messages and you’re off!
                                    </li>
                                @endif

                            </ol>

                        </div>
                        <div class="p-t-15 text-center">
                            <a href="{{ route('parent.dashboard') }}" class="btn btn-primary shadow-v4"
                               style="padding: 10px 40px">
                                Continue
                            </a>
                        </div>
                        <div class="p-t-15 text-center">
                            <img src="/img/logo/powered-by-zoom.png" alt="powered by zoom" height="20px" style="display: block; margin: 0 auto" />
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
