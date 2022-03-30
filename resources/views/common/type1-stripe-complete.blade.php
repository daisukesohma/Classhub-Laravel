<div class="modal fade c-modal v1 profile-has-been-updated image-modals" id="stripe-complete"
     tabindex="-1" role="dialog"
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
                            <div class="tc p-t-0 modal-title-100-t">
                                <h2 style="font-weight: bold">Thank you for adding your bank details and uploading your
                                    ID.
                                </h2>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="float: right">
                            <div class="tc p-t-0">
                                <img
                                    src="{{ asset('img/popup-images/bank-details.png') }}"
                                    alt="">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 text-left">
                        <div style="padding:0px 30px">
                            <h4 style="font-weight: bold">Here’s what happens next..
                            </h4>
                            <ol class="account-live-list">
                                <li>You will now be able to receive bookings and payments for tuition.
                                </li>
                                <li>Make sure to check your jobs board regularly. Parents will post tutor requests here.
                                    You can reach out directly to parents and message each other back and forth to agree
                                    on everything. You can also schedule a free video call with them to chat through any
                                    questions or specific areas they might want to cover.
                                </li>
                                <li>Everytime a parent or student messages you about tuition, we will send you an email
                                    notification.
                                </li>
                                <li>Message back and forth to ask any questions and agree the time and location of your
                                    lesson. Keep the messages on the site as we’ll step in if you need any help.

                                </li>
                                <li>Once you are both happy, you can create a booking from your classhub inbox and send
                                    it to the parents inbox.
                                </li>
                                <li>The parent will be asked to confirm the lesson by entering their payment details.
                                </li>
                                <li>Once payment is made we will automatically update your dashboard with your new
                                    booking. This will include the class name, date, time and student name.
                                </li>
                                <li>Familiarise yourself with our built in online tuition feature and how to upload
                                    pre-recorded videos. You have all the tools you need for engaging and beneficial
                                    tuition experiences.
                                </li>
                            </ol>
                        </div>
                        <div class="p-t-15 text-center">
                            <a href="{{ route('educator.lesson.create') }}" class="btn btn-primary shadow-v4"
                               style="padding: 10px 40px" id="stripe-complete-continue">
                                Continue
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
