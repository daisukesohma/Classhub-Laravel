<div class="modal fade c-modal v1" id="schedule-free-call" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header p-b-0">
                <h5 class="text-center" style="width: 100%">Schedule Free Video Call</h5>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">
						&times;
					</span>
                </button>
            </div>
            <div class="modal-body text-center p-lr-42 p-tb-0">
                <p class="alert alert-warning" style="background-color: #e74b65">You can schedule 20 minutes free video call and maximum two(2) free call with each parents</p>
                <p>Please choose a date and time:</p>
                <div class="row" style="padding-top: 30px">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <input type="hidden" name="educator_id" id="educator-id">
                        <input type="hidden" name="parent_id" id="parent-id">
                        <input
                            type="text"
                            class="form-control schedule-time-picker"
                            placeholder="Date / Time"
                            name="call_time" id="free-call-time">

                        <div class="col-12" style="margin-top: 20px"><a class="btn btn-sm btn-primary v2 shadow-v4 schedule-free-call-btn" href="javascript:void
                                (0);" data-dismiss="modal"
                            ><span class="btn__text v1 fw-6">Schedule Free Call</span>
                            </a></div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </div>
    </div>
</div>
