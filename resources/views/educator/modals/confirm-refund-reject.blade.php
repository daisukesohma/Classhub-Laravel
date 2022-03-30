<!--begin:: pause-class Modal-->
<div class="modal fade c-modal v1 cancel-class pause-class" id="refund-reject" tabindex="-1" role="dialog"
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

                <div class="title fs-23 fw-5">Reject refund?</div>
                <div class="p-t-7">Please enter Reject reason <span style="color: #a92222">*</span></div>
                <div class="p-t-7"><textarea name="reject-reason" class="form-control" required></textarea></div>

                <div class="two-buttons p-b-25">
                    <div class="row">
                        <div class="col-6 text-center">
                            <a class="btn btn-secondary btn-text-red shadow-v4" data-dismiss="modal"
                               href="javascript:void(0);"><span class="btn__text v1 fw-6">No</span></a>
                        </div>
                        <div class="col-6 text-center">
                            <a class="btn btn-sm btn-primary v2 shadow-v4 reject-refund-btn" href="javascript:void(0);"
                               data-toggle="modal" data-target="#confirmation"
                               data-route=""
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
