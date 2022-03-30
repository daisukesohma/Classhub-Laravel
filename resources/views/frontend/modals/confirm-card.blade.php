<!--begin:: pause-class Modal-->
<div class="modal fade c-modal v1 cancel-class" id="confirm-card-modal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">
						&times;
					</span>
                </button>
            </div>
            <div class="modal-body text-center p-r-35 p-l-35 p-t-0 p-b-15">

                <div class="title fs-23 fw-5">Confirm payment using this Card?</div>
                <div class="title fs-23 fw-5" style="margin-top: 30px">**** **** **** <span id="last4"></span></div>
                <div class="title  fw-5" style="margin-top: 30px">
                    <input type="text" name="card_student_name" class="form-control m-input"
                           placeholder="Student Name">
                </div>

                <div class="two-buttons p-b-25">
                    <div class="row">
                        <div class=" text-center" style="float: left;">
                            <a class="btn btn-secondary btn-text-red shadow-v4" data-dismiss="modal"
                               href="javascript:void(0);"><span class="btn__text v1 fw-6">No</span></a>
                        </div>
                        <div class=" text-center" style="float: right">
                            <a class="btn btn-sm btn-primary v2 shadow-v4 pay-card-btn" href="javascript:void(0);"
                               data-toggle="modal" data-target="#result-modal"
                               data-dismiss="modal"><span class="btn__text v1 fw-6">Yes</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end:: pause-class Modal-->
