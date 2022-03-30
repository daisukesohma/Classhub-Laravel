<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">
        Refund Request - {{ \Carbon\Carbon::parse($refundRequest->refund_requested_at)->format('d/m/Y') }}
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">
												&times;
											</span>
    </button>
</div>
<div class="modal-body">
    <ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
        <li class="nav-item m-tabs__item">
            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#refund-details"
               role="tab">
                Details
            </a>
        </li>
        <li class="nav-item m-tabs__item">
            <a class="nav-link m-tabs__link" data-toggle="tab" href="#message-log"
               role="tab">
                Message Logs
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="refund-details" role="tabpanel">
            <div class="form-group m-form__group">
                <label style="color: #58595B;">
                    <strong>Requested by:</strong>
                </label>
                <p class="form-control-static">
                    {{ optional($refundRequest->booking)->user->name }}
                </p>
            </div>
            <div class="form-group m-form__group">
                <label style="color: #58595B;">
                    <strong>Class:</strong>
                </label>
                <p class="form-control-static">
                    {{ optional($refundRequest->booking)->lesson->name }}
                </p>
            </div>
            <div class="form-group m-form__group">
                <label style="color: #58595B;">
                    <strong>Teacher:</strong>
                </label>
                <p class="form-control-static">
                    {{ optional($refundRequest->booking->lesson)->user->name }}
                </p>
            </div>
            <div class="form-group m-form__group">
                <label style="color: #58595B;">
                    <strong>Refund Request Reason:</strong>
                </label>
                <p class="form-control-static">
                    {{ $refundRequest->request_reason }}
                </p>
            </div>
            <div class="form-group m-form__group">
                <label style="color: #58595B;">
                    <strong>Teacher Refusal Reason:</strong>
                </label>
                <p class="form-control-static">
                    {{ $refundRequest->decline_reason }}
                </p>
            </div>
        </div>
        <div class="tab-pane" id="message-log" role="tabpanel">
            @foreach($chat->messages as $message)
                <div class="refund-message">
                <span class="{{ $message->sender_id == $parentId ? 'refundee-log' : 'host-log' }}">
                    {{ $message->sender_id == $parentId ? 'Refundee' : 'Teacher' }}:
                </span>
                    <span class="message-log">{!! $message->text !!} </span>
                </div>
            @endforeach
            <div class="form-group m-form__group text-right">
                                            <textarea class="form-control m-input m-input--air" id="exampleTextarea"
                                                      rows="3" placeholder="Message both parties here..."
                                                      name="chat-message"></textarea>
                <button type="button" class="btn btn-secondary chat-send-btn"
                        data-parent-id="{{ $parentId }}"
                        data-tutor-id="{{ $tutorId }}"
                        style=" margin-top: 20px;">
                    Send Message
                </button>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary decline-btn" data-dismiss="modal"
                data-booking-id="{{ $refundRequest->booking_id }}"
                data-class-id="{{ $refundRequest->lesson_class_id }}">
            Decline Refund
        </button>
        <button type="button" class="btn btn-primary grant-btn" data-dismiss="modal"
                data-booking-id="{{ $refundRequest->booking_id }}"
                data-class-id="{{ $refundRequest->lesson_class_id }}">
            Grant Refund
        </button>

    </div>
</div>

<script type="text/javascript">

    $('body').on('click', 'button.chat-send-btn', function () {

        var _this = $(this)
        var message = $('textarea[name="chat-message"]').val()

        if (message.length > 0) {
            $.ajax({
                type: 'POST',
                url: '{{ route('chat.send.message') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    text: message,
                    recipient_id: $(_this).data('parent-id'),
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data)
                    if (data.status) {
                        $('textarea[name="chat-message"]').val('')
                    } else {
                        $('div#msg-error').html(data.messages.join('<br>'))
                    }
                },
                error: function (data) {
                    $('div#msg-error').html(data.messages.join('<br>'))
                }
            })

            $.ajax({
                type: 'POST',
                url: '{{ route('chat.send.message') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    text: message,
                    recipient_id: $(_this).data('tutor-id'),
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data)
                    if (data.status) {
                        $('textarea[name="chat-message"]').val('')
                    } else {
                        $('div#msg-error').append(data.messages.join('<br>'))
                    }
                },
                error: function (data) {
                    $('div#msg-error').append(data.messages.join('<br>'))
                }
            })
        }
    })


</script>
