<div class="modal fade c-modal v1 profile-has-been-updated" id="inbox-first-visit-modal"
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
                                <h2 style="font-weight: bold">Reply to messages and create bookings...
                                </h2>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="float: right">
                            <div class="tc p-t-0">
                                <img
                                    src="{{ asset('img/popup-images/message-tutorial.png') }}"
                                    alt="">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 text-left">
                        <div style="padding:0px 30px">
                            <h3 style="font-weight: bold">Here’s what you need to know... </h3>
                            <p>You can reply to any parent or student from your inbox by entering your
                                message and clicking on the send button <i class="fa fa-telegram"mstyle="color: #E74B65;"></i></p>
                            <p>To create a booking, simply click on  <a href="javascript:;" style="padding: 5px 10px" class="btn btn-primary booking-modal">Create Booking</a></p>
                            <p>For Online Tuition you must click the toggle
                              <span class="m-switch m-switch--danger m-switch--icon" style="vertical-align: middle;">
                                <label class="fs-14">
                                    <input type="checkbox" checked/>
                                    <span style="float: right"></span>
                                </label>
                            </span></p>
                            <p>When you click on "create booking" you need to do a few things</p>
                            <ol class="account-live-list">
                                <li>- Choose your subject</li>
                                <li>- Select a date and time that both parties have agreed on</li>
                                <li>- Add a message if needed
                                </li>
                                <li>- Press send
                                </li>
                            </ol>
                            <p>After you press send the parent or student will be notified of your booking and be
                                prompted to make payment.</p>
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
        padding-left: 0;
        padding-bottom: 10px;
        margin-left: 15px;
    }
</style>
