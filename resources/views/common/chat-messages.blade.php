<div class="kt-chat">

    <div class="kt-portlet kt-portlet--head-lg kt-portlet--last">
        <div class="kt-portlet__head">
            <div class="kt-chat__head ">
                <div class="kt_chat__left">
                    <i class="fa fa-arrow-left" id="back-btn"></i>
                </div>
                <div class="kt-chat__center">

                    <div class="kt-chat__pic">
                        @if($activeChat->chat_with->educator)

                            <span class="kt-userpic kt-userpic--sm kt-userpic--circle"
                                  data-toggle="kt-tooltip"
                                  data-placement="right" title="Milano Esco"
                                  data-original-title="Tooltip title">
                                                    <img
                                                        src="{{ \App\Helpers\ClassHubHelper::getImagePath(null, optional($activeChat->chat_with->educator)->photo) }}"
                                                        alt="image">
                                                  </span>
                        @else
                            <span
                                class="kt-userpic kt-userpic--circle kt-userpic--danger">

														        <span>{{ \App\Helpers\ClassHubHelper::getInitials(optional($activeChat->chat_with)->name) }}</span>
													        </span>
                        @endif
                    </div>
                    <div class="kt-chat__label">
                        <a href="#"
                           class="kt-chat__title">{{ optional($activeChat->chat_with)->name }}</a>
                        {{--<span class="kt-chat__status">
                            <span class="kt-badge kt-badge--dot kt-badge--success"></span> Active
                          </span>--}}
                    </div>
                </div>
                @if(Auth::user()->educator)
                    <div class="kt-chat__right mobile-only" id="booking-btn-container">
                        <a href="#" class="btn btn-primary booking-modal"
                           data-toggle="modal"
                           data-target="#subject-booking-modal"
                           data-recipient-id="{{ $activeChat->chat_with->id }}">Create
                            Booking</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="kt-scroll kt-scroll--pull" data-mobile-height="300"
                 id="chat-messages-box">
                <div class="kt-chat__messages">
                    @foreach($messages as $date => $dateMessages)
                        @foreach($dateMessages as $message)
                            <?php
                            if ($message->type == 'request_tutor' || $message->type == 'booking_video_call') {
                                continue;
                            }
                            ?>

                            <div
                                class="kt-chat__message {{ $message->type == 'message' || $message->type == 'file' ? '' : 'tutor-request' }}
                                {{ $message->sender_id == Auth::user()->id ? 'kt-chat__message--right' : '' }}">
                                <div
                                    class="kt-chat__text {{ $message->sender_id == Auth::user()->id ? 'kt-bg-light-brand' : 'kt-bg-light-success' }}">
                                    @if($message->type == 'message')
                                        <p>{!! $message->text !!}</p>
                                    @endif

                                    @if($message->type == 'file')
                                        <p>
                                            <a href="{{ route('chat.download.message', $message->id) }}" target="_blank" style="color: #212121;">
                                                <i id="button-send-file" class="fa fa-paperclip" style="color: #212121; font-size: 20px;"></i>
                                                {!! $message->text !!}
                                            </a>
                                        </p>
                                    @endif

                                    @if($message->type == 'refund_request')
                                        <div class="refund-msg-box">
                                            <div class="fw-5">Booking Code:
                                                {{ \App\Helpers\ClassHubHelper::getbookingCode(\App\Booking::find($message->booking_id)) }}</div>
                                            <div
                                                class="msg p-t-15"> {!! $message->text !!}</div>
                                            <div class="class p-t-15">
                                                {!! $message->class_list !!}
                                            </div>
                                            <div class="total">Total: €
                                                {{  number_format(\App\Helpers\ClassHubHelper::centToEuro($message->total), 2) }}
                                            </div>
                                            @if(!$message->status && $message->sender_id != Auth::user()->id)
                                                <div
                                                    class="action-links text-right p-t-15 p-b-6">
                                                    <a href="javascript:void(0)"
                                                       class="refund-request-accept btn btn-primary"
                                                       data-toggle="modal"
                                                       data-target="#refund-accept"
                                                       data-message-id="{{ $message->id }}"
                                                       data-booking-id="{{$message->booking_id}}"
                                                       data-classes-id="{{$message->class_ids}}">ACCEPT</a>
                                                    <a href="javascript:void(0)"
                                                       class="refund-request-reject btn btn-primary"
                                                       data-toggle="modal"
                                                       data-target="#refund-reject"
                                                       data-message-id="{{ $message->id }}"
                                                       data-booking-id="{{$message->booking_id}}"
                                                       data-classes-id="{{$message->class_ids}}">REJECT</a>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    @if($message->type == 'video_call')
                                        <p>{!! $message->text !!}</p>

                                        <div class="msg p-t-15">Date:
                                            <strong>
                                                {{  \Carbon\Carbon::parse($message->video_call_time)->format('jS F Y') }}
                                            </strong>
                                        </div>
                                        <div class="msg p-t-15">Time:
                                            <strong>
                                                {{ \Carbon\Carbon::parse($message->video_call_time)->format('h:i A') }}
                                            </strong>
                                        </div>
                                        @if($message->video_call_response == 0 && $message->sender_id
                                         != Auth::user()->id)
                                            <div
                                                class="action-links text-right p-t-15 p-b-6">
                                                <a href="javascript:void(0)"
                                                   class="schedule-call-accept accept-btn btn btn-primary"
                                                   data-id="{{ $message->id }}"
                                                   data-recipient-id="{{ $message->sender_id }}"
                                                   data-toggle="modal" data-target="#">Accept
                                                    Time</a>
                                                <a href="javascript:void(0)"
                                                   class="schedule-call-reschedule btn btn-primary"
                                                   data-toggle="modal"
                                                   data-id="{{ $message->id }}"
                                                   data-recipient-id="{{ $message->sender_id }}"
                                                   data-target="#video-call-rescheduler">Suggest
                                                    a new
                                                    time</a>
                                            </div>
                                        @endif

                                        @if($message->video_call_response == 1)
                                            <div class="msg p-t-15">Response:
                                                <strong>Video Call Scheduled</strong></div>
                                        @endif

                                        @if($message->video_call_response == 2)
                                            <div class="msg p-t-15">Response:
                                                <strong>Rejected, Rescheduled Request
                                                    Sent</strong>
                                            </div>
                                        @endif
                                    @endif

                                    @if($message->type == 'booking')
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
                                            <p style="margin: 10px 0">Provider
                                                - {{  $educator->name }}</p>
                                            <p style="margin: 10px 0">
                                                Subject {{ $subjectName }}</p>
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
                                                <div
                                                    class="action-links text-right p-t-15 p-b-6">
                                                    <a href="javascript:void(0)"
                                                       class="booking-accept btn btn-primary"
                                                       data-toggle="modal"
                                                       data-target="#payment-summary"
                                                       data-message-id="{{ $message->id }}"
                                                       data-lesson-id="{{$message->lesson_id}}"
                                                       data-class-ids="{{$message->class_ids}}">ACCEPT</a>
                                                    <a href="javascript:void(0)"
                                                       class="booking-reject btn btn-primary"
                                                       data-toggle="modal"
                                                       data-target="#refund-reject"
                                                       data-message-id="{{ $message->id }}"
                                                       data-lesson-id="{{$message->lesson_id}}"
                                                       data-class-ids="{{$message->class_ids}}">REJECT</a>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    @if($message->type == 'request_tutor' && $message->request_applied == 0)
                                        <h5>Request by Parent</h5>
                                        {!! $message->request_tutor_detail !!}
                                        <li><strong>Message : </strong>
                                            {!! $message->text !!}
                                        </li>
                                    @endif
                                    <span class="kt-chat__datetime">
                                                                    {{  \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}
                                                                </span>
                                </div>
                            </div>
                        @endforeach
                    @endforeach

                </div>
            </div>
        </div>
        <div class="kt-portlet__foot mobile-only">
            <div class="kt-chat__input">
                <div class="row d-flex">
                    <div class="col-md-11 col-sm-10 d-flex justify-content-between">
                        <div class="kt_chat__actions attachment-container">
                            <label for="file-input">
                                <i class="fa fa-paperclip" style="color: #E74B65"></i>
                            </label>
                            <input type="file" name="attachment" id="file-input">
                        </div>
                        <div class="kt-chat__editor m-l-14" style="flex: 1;">
                            <input style="height: 40px; width: 90%" name="chat-message"
                                   placeholder="Type here...">
                            {{--<div class="kt_chat__tools">
                                <a href="#"><i class="fa fa-camera"></i></a>
                            </div>--}}
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-2">
                        <div class="kt-chat__toolbar">
                            <div class="kt_chat__actions">
                                <a href="#"
                                   data-lesson-id="{{ optional($activeChat->lesson)->id }}"
                                   class="chat-send"
                                   data-recipient-id="{{ $activeChat->chat_with->id }}"><i
                                        class="fa fa-telegram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(Auth::user()->educator)
                <div class="row" style="align-items: flex-end; justify-content: flex-end">
                    <div class="col-lg-3 col-md-5 text-right " style=" margin: 10px 0;">
                        <a href="#" class="btn btn-primary schedule-free-call"
                        data-toggle="modal"
                        data-target="#schedule-free-call"
                        data-educator-id="{{ Auth::user()->id }}"
                        data-parent-id="{{ $activeChat->chat_with->id }}"
                        style="width: 100%">Schedule Free Call</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
