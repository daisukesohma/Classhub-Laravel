<div class="modal fade c-modal v1" id="trusted" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content trusted-modal">
            <div class="modal-header">
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                            					<span aria-hidden="true">
                            						&times;
                            					</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 0px 15px 20px 15px">
                <div class="row title-add-button">
                    <div class="col-lg-1 col-md-2 col-sm-4"><img class="img-sm-center"
                                                                 src="/img/icons/trust/verified.png"/></div>
                    <div class="col-lg-10 col-md-10 col-sm-8">
                        <h4 class="bold sm-center-text">Become Trusted</h4>
                        <h5 class="sm-center-text xs-pb-30"
                            style="font-family:Open Sans, Arial, sans-serif; color: #1F323D; opacity: .57; font-weight: 300; font-size: 19px">
                            There are two options to achieving the trusted status on classhub</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <br>
                        <p class="center-xs">
                            <strong>Option 1</strong> : Classhub offers to reimburse any teacher or activity provider to
                            the value of €30 for a copy of a valid and recent identity check that has been carried out
                            on them. Identity checks are provided by many organisations including
                            <a target="_blank" href="http://www.checkback.ie/">www.checkback.ie</a>. Once you have
                            received your identity check send a copy to <a
                                href="mailto:trust@classhub.ie">trust@classhub.ie</a> and we will upgrade your profile.
                        </p>
                        <br>
                        <p class="center-xs">
                            <strong>Option 2</strong> : Provide classhub with two references, these references should
                            be from previous tutoring clients or if you are new to tutoring they should be character
                            references. You can upload your references
                            <a href="javascript:;" data-target="#reference-upload" data-toggle="modal"
                               data-dismiss="modal">
                                here</a> or email them to
                            <a href="mailto:trust@classhub.ie">trust@classhub.ie.</a> All references will need to
                            include the referee’s name and contact details so that they can be verified. Once they have
                            been approved classhub will upgrade your profile.
                        </p>
                    </div>
                    <div class="col-md-5 col-sm-12">
                        <img src="/img/icons/trust/non-trusted-profile.png" alt="Non trusted profile badge"/>
                    </div>
                    <div class="col-md-1 col-sm-12">
                        <img class="img-sm-center right-trusted-arrow" src="/img/icons/trust/arrow-right.png"
                             alt="right arrow" style="position: absolute; top: 50%"/>
                    </div>
                    <div class="col-md-5 col-sm-12">
                        <img src="/img/icons/trust/trusted-profile.png" alt="trusted profile badge"/>
                    </div>

                    <div class="col-md-11">
                        <a class="sm-center-text" href="javascript:void(0);" data-toggle="modal"
                           data-target="#trusted">See benefits of having a trusted badge on Classhub</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('educator.modals.trusted.upload-reference')
