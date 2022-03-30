<div class="list-chat">

    <div class="m-messenger m-messenger--message-arrow m-messenger--skin-light">

        <!-- starts : all messages -->
        <div class="m-messenger__messages">

            <div id="message-list-container">

                <!-- starts : message -->
                <!-- starts : repeat DOM day+data wise -->
                @foreach($messages as $date => $dateMessages)
                    <div class="daydate-wise">
                        <div class="date"><span>{{ \Carbon\Carbon::parse($date)->format('l, d F Y') }}</span></div>

                    @foreach($dateMessages as $message)
                        <!-- starts : message -->
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message
                                {{ $message->sender_id == Auth::user()->id
                                    ? 'm-messenger__message--out' : 'm-messenger__message--in'}}
                                {{ $message->booking_id || $message->status ? 'provider-receives-refund-request' : '' }}">
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__datetime">
                                            {{  \Carbon\Carbon::parse($message->created_at)->format('H:i') }}
                                        </div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-text">
                                                @if($message->booking_id)
                                                    <div class="refund-msg-box">
                                                        <div class="fw-5">Booking Code:
                                                            {{ \App\Helpers\ClassHubHelper::getbookingCode(\App\Booking::find($message->booking_id)) }}</div>
                                                        <div class="msg p-t-15"> {!! $message->text !!}</div>
                                                        <div class="class p-t-15">
                                                            {!! $message->class_list !!}
                                                        </div>
                                                        <div class="total">Total: €
                                                            {{  number_format(\App\Helpers\ClassHubHelper::centToEuro($message->total), 2) }}
                                                        </div>
                                                        @if(!$message->status && $message->sender_id != Auth::user()->id)
                                                            <div class="action-links text-right p-t-15 p-b-6">
                                                                <a href="javascript:void(0)"
                                                                   class="refund-request-accept"
                                                                   data-toggle="modal" data-target="#refund-accept"
                                                                   data-message-id="{{ $message->id }}"
                                                                   data-booking-id="{{$message->booking_id}}"
                                                                   data-classes-id="{{$message->class_ids}}">ACCEPT</a>
                                                                <a href="javascript:void(0)"
                                                                   class="refund-request-reject"
                                                                   data-toggle="modal" data-target="#refund-reject"
                                                                   data-message-id="{{ $message->id }}"
                                                                   data-booking-id="{{$message->booking_id}}"
                                                                   data-classes-id="{{$message->class_ids}}">REJECT</a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @elseif($message->type == 'booking')
                                                    @php
                                                        $educator = \App\User::find($message->sender_id);
                                                        $lesson = \App\Lesson::find($message->lesson_id);
                                                        $subject =  \App\Category::find($lesson->category_id);
                                                        $classes = \App\LessonClass::whereIn('id',explode(',', $message->class_ids) )->get();
                                                        $price = $lesson->price * $classes->count();
                                                        $subjectName = \App\Helpers\ClassHubHelper::getSubjectDisplayName($subject, $educator->categories)
                                                    @endphp
                                                    <div class="refund-msg-box">
                                                        <strong>Classhub Booking</strong>
                                                        <p style="margin: 10px 0">Provider - {{  $educator->name }}</p>
                                                        <p style="margin: 10px 0">Subject {{ $subjectName }}</p>
                                                        <hr>
                                                        @foreach($classes as $class)
                                                            <p style="margin: 10px 0">Date
                                                                - {{ \Carbon\Carbon::parse($class->date)->format('d/m/Y') }}</p>
                                                            <p style="margin: 10px 0">Time
                                                                - {{ \Carbon\Carbon::parse($class->start_time)->format('h:i A') }}
                                                                to {{ \Carbon\Carbon::parse($class->end_time)->format('h:i A') }}</p>
                                                            <hr>
                                                        @endforeach
                                                        <p>Price
                                                            €{{ \App\Helpers\ClassHubHelper::centToEuro($price) }}</p>

                                                        @if($message->text !== '-')
                                                            <strong>Message:</strong>
                                                            <p>{{ $message->text }}</p>
                                                        @endif
                                                        @if($message->booking_response == 1)
                                                            <p>Accepted</p>
                                                        @elseif($message->booking_response == 2)
                                                            <p>Rejected</p>
                                                        @elseif(Auth::user()->id !== $message->sender_id)
                                                            {{--<div class="action-links text-right p-t-15 p-b-6">
                                                                <a href="javascript:void(0)"
                                                                   class="booking-accept"
                                                                   data-toggle="modal"
                                                                   data-target="#payment-summary"
                                                                   data-message-id="{{ $message->id }}"
                                                                   data-lesson-id="{{$message->lesson_id}}"
                                                                   data-class-ids="{{$message->class_ids}}">ACCEPT</a>
                                                                <a href="javascript:void(0)"
                                                                   class="booking-reject"
                                                                   data-toggle="modal" data-target="#refund-reject"
                                                                   data-message-id="{{ $message->id }}"
                                                                   data-lesson-id="{{$message->lesson_id}}"
                                                                   data-class-ids="{{$message->class_ids}}">REJECT</a>
                                                            </div>--}}
                                                        @endif
                                                    </div>
                                                @else
                                                    {!! $message->text !!}
                                                    @if($message->video_call_time)
                                                        <div class="msg p-t-15">Date: <strong>{{
                                                        \Carbon\Carbon::parse($message->video_call_time)->format('jS
                                                         F Y')
                                                        }}</strong></div>
                                                        <div class="msg p-t-15">Time: <strong>{{
                                                        \Carbon\Carbon::parse($message->video_call_time)->format('h:i
                                                         A')
                                                         }}</strong></div>
                                                        @if($message->video_call_response == 0 && $message->sender_id
                                                         != Auth::user()->id)
                                                            <div class="action-links text-right p-t-15 p-b-6">
                                                                <a href="javascript:void(0)"
                                                                   class="schedule-call-accept accept-btn"
                                                                   data-id="{{ $message->id }}"
                                                                   data-recipient-id="{{ $message->sender_id }}"
                                                                   data-toggle="modal" data-target="#">Accept Time</a>
                                                                <a href="javascript:void(0)"
                                                                   class="schedule-call-reschedule"
                                                                   data-toggle="modal"
                                                                   data-id="{{ $message->id }}"
                                                                   data-recipient-id="{{ $message->sender_id }}"
                                                                   data-target="#video-call-rescheduler">Suggest a new
                                                                    time</a>
                                                            </div>
                                                        @endif

                                                        {{--@if($message->video_call_response == 1)
                                                            <div class="msg p-t-15">Response:
                                                                <strong>Video Call Scheduled</strong></div>
                                                        @endif--}}

                                                        @if($message->video_call_response == 2)
                                                            <div class="msg p-t-15">Response:
                                                                <strong>Rejected, Rescheduled Request Sent</strong>
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- end : repeat DOM day+data wise -->
                @endforeach

                <div class="daydate-wise" id="current-message-list">
                    <div class="date"><span>{{ \Carbon\Carbon::now()->format('l, d F Y') }}</span></div>
                </div>
            </div>
        </div>
        <!-- end : all messages -->

        <!-- starts : messenger__form -->
        <div class="m-messenger__form">
            <input type="text" name="chat-message" placeholder="Type a message here" class="m-messenger__form-input">
            <a class="btn btn-secondary btn-text-red shadow-v4 chat-send" href="javascript:void(0);"
               data-lesson-id="{{ optional($activeChat->lesson)->id }}"
               data-recipient-id="{{ $activeChat->chat_with->id }}">
                <span class="btn__text v1">SEND</span>
            </a>
        </div>

        <div class="col-12 text-right" style="padding: 20px">
            <a class="btn btn-primary btn-text-red shadow-v4 booking-modal" href="javascript:void(0);"
               data-toggle="modal" data-target="#subject-booking-modal"
               data-recipient-id="{{ $activeChat->chat_with->id }}">
                <span class="btn__text v1">Create a booking</span>
            </a>
        </div>
        <!-- end : messenger__form -->

    </div>
</div>

<!--begin::Modal-->
<div class="modal fade c-modal payment-summary" id="payment-summary" tabindex="-1" role="dialog"
     aria-labelledby="payment summary" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg1" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">
          &times;
        </span>
                </button>
            </div>
            <div class="modal-body">
                <!-- starts : payment summary -->
                <!-- end : payment summary -->
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->


@include('common.reschedule-video-call')

<script src="https://js.stripe.com/v3/"></script>


<script type="text/javascript">
    var messageId = false;
    var recipientId = false;

    $(function () {

        $('input.schedule-time-picker').flatpickr({
            enableTime: true,
            dateFormat: "d-m-Y H:i",
            minDate: "{!! date('d-m-Y H:i') !!}"
        })

        $('a.schedule-call-reschedule').on('click', function () {
            messageId = $(this).data('id')
            recipientId = $(this).data('recipient-id')
        })

        $('a.booking-modal').on('click', function () {
            $('input#recipient-id').val($(this).data('recipient-id'))
        })

    })


    $('body').on('click', 'a.schedule-call-btn', function () {
        $(resultModal).modal('show')
        $.ajax({
            type: 'POST',
            url: '{{ route('schedule.call') }}',
            data: {
                _token: '{{ csrf_token() }}',
                time: $('input[name="video_call_time"]').val(),
                message_id: messageId,
                text: 'Hi there, I would like to reschedule a video call for:',
                recipient_id: recipientId,
                video_call_response: 2
            },
            dataType: 'json',
            success: function (data) {
                if (data.status) {
                    $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    setTimeout(function () {
                        location.reload()
                    }, 2000)
                } else {
                    $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                }
            },
            error: function (data) {
                console.log(data)
                //$(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
            }
        })
    })

    $('body').on('click', 'a.accept-btn', function () {
        $(resultModal).modal('show')
        $.ajax({
            type: 'POST',
            url: '{{ route('schedule.call.accept') }}',
            data: {
                _token: '{{ csrf_token() }}',
                message_id: $(this).data('id'),
            },
            dataType: 'json',
            success: function (data) {
                if (data.status) {
                    $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    setTimeout(function () {
                        location.reload()
                    }, 2000)
                } else {
                    $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                }
            },
            error: function (data) {
                console.log(data)
                //$(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
            }
        })
    })


    $('body').on('click', 'a.booking-reject', function () {
        $(resultModal).modal('show')
        $.ajax({
            type: 'POST',
            url: '{{ route('subject.booking.reject') }}',
            data: {
                _token: '{{ csrf_token() }}',
                message_id: $(this).data('message-id'),
            },
            dataType: 'json',
            success: function (data) {
                console.log(data)
                if (data.status) {
                    $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    setTimeout(function () {
                        location.reload()
                    }, 2000)
                } else {
                    $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                }
            },
            error: function (data) {
                console.log(data)
            }
        })
    })

    $('body').on('click', 'a.booking-accept', function () {
        classIds = $(this).data('class-ids').toString()

        if (classIds.includes(',')) {
            classIds = classIds.split(',')
        } else {
            classIds = [classIds]
        }

        $.ajax({
            type: 'GET',
            url: '{{ route('booking.modal.payment.summary') }}',
            data: {
                _token: '{{ csrf_token() }}',
                lesson_id: $(this).data('lesson-id'),
                class_ids: classIds,
                message_id: $(this).data('message-id')
            },
            dataType: 'HTML',
            success: function (data) {
                $('div#payment-summary').find('div.modal-body').html(data)
            },
            error: function (data) {
                $('div#payment-summary').find('div.modal-body').html(data)
            }
        })
    })

</script>
