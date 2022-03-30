<div class="modal fade c-modal v1 profile-has-been-updated" id="type1-account-live"
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
                                <h2 style="font-weight: bold">Your profile is now live!
                                </h2>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="float: right">
                            <div class="tc p-t-0">
                                <img
                                    src="{{ asset('img/popup-images/profile-live.png') }}"
                                    alt="">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 text-left">
                        <div style="padding:0px 30px">
                          <h4 style="font-weight: bold">Here’s what happens next...</h4>
                            <ol class="account-live-list">
                                <li>Your profile is now visible on classhub.</li>
                                <li>You will be able to receive requests for tuition from parents and students.</li>
                                <li>Everytime a message is sent to you by a parent or student we will send you a
                                    notification email to tell you that you have a message in your classhub inbox.
                                </li>
                                <li>In order for you to receive payments you will need to add your payout details on the
                                    next step.
                                </li>
                            </ol>
                        </div>
                        <div class="p-t-15 text-center">
                            <a href="{{ route('educator.setup.stripe') }}" class="btn btn-primary shadow-v4"
                               style="padding: 10px 40px" id="account-live-continue">
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
