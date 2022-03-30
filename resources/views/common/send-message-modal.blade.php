<!--begin::Modal-->
<div class="modal fade c-modal" id="send-message-modal" tabindex="-1"
     role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">
						&times;
					</span>
                </button>
            </div>
            <div class="modal-body" style="padding-top: 0">
                <p>Send Message</p>
                <div class="form-group m-form__group p-t-12">
                    <textarea rows="6" name="chat-message" class="form-control m-input"></textarea>
                </div>

                <div class="text-right">
                    <div id="chat-result" style="font-size: 14px; float: left"></div>
                    <a class="btn btn-secondary btn-text-red shadow-v4 chat-send-btn"
                       href="javascript:void(0);"
                       data-dismiss="modal"
                       data-lesson-id="" data-recipient-id="">
                        <span class="btn__text v1">SEND</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->
