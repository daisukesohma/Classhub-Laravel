<!--begin:: Report Modal-->
<div class="modal fade c-modal overlay-share-this" id="report-lesson-modal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" class="p-b-0"><h4 class="text-center" style="font-weight: 300">Report this
                    class</h4>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
    					<span aria-hidden="true">
    						&times;
    					</span>
                </button>
            </div>
            <div class="modal-body" style="padding-top: 0px;">
                {!! Form::open(['url' => route('report.lesson', $lesson->id) , 'id' => 'reported-lesson-form']) !!}
                <div class="form-group p-t-0">
                    <label class="fw-3" for="email">Reason for report</label>
                    <textarea class="form-control" rows="7" id="report" name="reason" required></textarea>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-sm btn-primary shadow-v3 m-b-20 report-lesson-btn"
                            style="display: block; margin: 0 auto">
                        <span class="btn__text">Send Report</span>
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<!--end:: Report Modal-->
