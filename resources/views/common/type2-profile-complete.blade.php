<div class="modal fade c-modal v1 profile-has-been-updated image-modals" id="type2-profile-complete"
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
                                <h2 style="font-weight: bold">Step one of your profile is complete.
                                </h2>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="float: right">

                            <div class="tc p-t-0">
                                <img
                                    src="{{ asset('img/popup-images/profile-2-created.png') }}"
                                    alt="">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 text-left">
                        <div style="padding:0px 30px">
                          <h4 style="font-weight: bold">Here’s what's left to do...
                          </h4>
                            <ol class="account-live-list">
                                <li>Add your payout details so you can start accepting payments. We use Stripe for all
                                    our payments so your information is completely safe.
                                </li>
                                <li>Add your personal details so that Stripe can verify you and continue to make
                                    payments hassle free
                                </li>
                                <li>Create your class and set it live, you can be adventurous with creating a class by
                                    adding as much detail and information as you like, you can choose the location,
                                    price, time, dates and pictures. Your students will love it!
                                </li>
                            </ol>
                        </div>
                        <div class="p-t-15 text-center">
                            <a href="{{ route('educator.setup.stripe') }}" class="btn btn-primary shadow-v4"
                               style="padding: 10px 40px" id="profile-complete-continue">
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
