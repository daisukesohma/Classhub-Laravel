<div class="modal fade c-modal overlay-share-this" id="tutor-type"
     tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered {{ (new \Jenssegers\Agent\Agent())->isMobile() ? 'mobile-modal' : '' }}" role="document">
        <div class="modal-content" style="padding-top: 30px;">
            <div class="modal-body" style="padding-top: 0px;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="float: left">
                            <div class="tc p-t-0" >
                                <img
                                    src="{{ asset('classhub-logo.png') }}"
                                    alt=""
                                    style="max-width: 120px; margin-bottom: 15px">
                            </div>
                            <div class="tc p-t-0">
                                <h3>What type of tutor are you? </h3>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="float: right">

                            <div class="tc p-t-0">
                                <img
                                    src="{{ asset('img/popup-images/classhub-popup-tutor-type.png') }}"
                                    alt="" style="padding-bottom:20px;">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 text-center">
                        <div class="p-t-15">
                            Do you want to give one to one grinds or lessons?
                        </div>
                        <div class="p-t-15 text-center">
                            <a href="{{ route('educator.profile.create') }}?user_type=1"
                               class="btn btn-primary shadow-v4 m-0">
                                <span class="btn__text">Click Here</span>
                            </a>
                        </div>

                        <div class="p-t-15">
                            Do you want to set up terms of classes with multiple dates and students?
                        </div>

                        <div class="p-t-15 text-center">
                            <a href="{{ route('educator.profile.create') }}?user_type=2"
                               class="btn btn-primary shadow-v4 m-0">
                                <span class="btn__text">Click Here</span>
                            </a>
                        </div>
                        <div class="p-t-15 text-center">
                            <p style="font-size: 12px;">If you are not sure please contact our educational advisor on <a
                                    href="mailto:support@classhub.ie">support@classhub.ie</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--ends : fee structure modal -->
</div>
