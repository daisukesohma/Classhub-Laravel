@extends('parent.layouts.master')


@section('title')
    Classhub | Inbox
@endsection


@section('page_styles')
    <link href="{{ asset('educator/assets/css/inbox/chat.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .kt-searchbar .input-group {
            display: flex;
        }

        .kt-searchbar .input-group .form-control {
            width: 80%;
        }

        .kt-chat__editor {
            margin-bottom: 0px;
        }

        .kt-chat .kt-chat__input .kt-chat__editor input {
            margin-bottom: 0px;
        }

        #kt_chat_content {
            margin-top: 20px;
        }

        @media (max-width: 900px) {
            .col-sm-1 {
                width: 15%;
                float: right;
            }

            #kt_chat_content {
                margin-top: 20px;
            }

            .booking-modal {
                padding: 5px !important;
            }

        }

        .inbox {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        .inbox #kt_chat_aside, .inbox #kt_chat_content {
            margin-top: 65px !important;

        }

        .col-sm-10 {
            width: 85%;
            display: inline-block;
        }

        .col-sm-1 {
            width: 15%;
            float: right;
        }

        div#intercom-container {
            display: none;
        }

        #booking-btn-container {
            display: none;
        }

        #intercom-frame, .intercom-lightweight-app{
            display: none !important;
        }

        .attachment-container i {
            cursor: pointer;
            -webkit-transition: color 200ms;
            transition: color 200ms;
        }

        .attachment-container > input {
            display: none;
        }

    </style>

    @if($mobile)
        <style type="text/css">
            #kt_chat_aside .kt-portlet__body {
                max-height: none !important;
                height: 80vh !important;
            }

            #kt_chat_content {
                display: none;
            }

            #kt_chat_content .kt-portlet__body {
                max-height: none !important;
                height: 60vh !important;
            }

            .kt-chat__pic {
                margin-right: 10px !important;
            }

            .kt-userpic.kt-userpic--sm img {
                min-width: 27px;
            }
        </style>

        @if($jobId || request()->chat_id)
            <style type="text/css">

                div#kt_chat_aside {
                    display: none;
                }

                div#kt_chat_content {
                    display: block;
                }
            </style>
        @endif
    @endif
@endsection

@section('content')

    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body" style="display: unset;">

        <div class="m-grid__item m-grid__item--fluid m-wrapper">

            @if( !$chats->count() && !$activeChat)
                <div class="emptyState text-center p-t-60 p-b-60">
                    <i class="fa fa-envelope-open-o p-b-20"></i>
                    <h4>You have no messages yet</h4>
                </div>
            @else

            <!--Begin:: App Aside-->
                <div class="row col-12 inbox" style="margin-top: 20px">
                    <div class="col-md-4">


                        <div class="kt-grid__item kt-app__toggle kt-app__aside kt-app__aside--lg kt-app__aside--fit"
                             id="kt_chat_aside">

                            <!--begin::Portlet-->
                            <div class="kt-portlet kt-portlet--last">
                                <div class="kt-portlet__body">
                                    <div class="kt-searchbar">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1"
                                                        class="kt-svg-icon">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                           fill-rule="evenodd">
                                                          <rect id="bound" x="0" y="0" width="24" height="24"/>
                                                          <path
                                                              d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                                                              id="Path-2" fill="#000000" fill-rule="nonzero"
                                                              opacity="0.3"/>
                                                          <path
                                                              d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                                                              id="Path" fill="#000000" fill-rule="nonzero"/>
                                                        </g>
                                                      </svg>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Search"
                                                   id="search-chat"
                                                   aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <div class="kt-widget kt-widget--users kt-mt-20">
                                        <div class="kt-scroll kt-scroll--pull">
                                            <div class="kt-widget__items">

                                                <div class="kt-widget__item">
                                                    @if($activeChat->chat_with->educator)
                                                        <a href="{{ route('page.educator', $activeChat->chat_with->slug) }}">
                                                        <span class="kt-userpic kt-userpic--circle">
                                                                <img
                                                                    src="{{ \App\Helpers\ClassHubHelper::getImagePath(null, optional($activeChat->chat_with->educator)->photo) }}"
                                                                    alt="image">
                                                              </span>
                                                        </a>
                                                    @else
                                                    <a href="{{ route('page.educator', $activeChat->chat_with->slug) }}">
                                                        <span
                                                            class="kt-userpic kt-userpic--circle kt-userpic--danger">

                    														        <span>{{ \App\Helpers\ClassHubHelper::getInitials(optional($activeChat->chat_with)->name) }}</span>
                    													        </span>
                                                    </a>
                                                    @endif
                                                    <div class="kt-widget__info">
                                                        <div class="kt-widget__section">
                                                            <a href="{{  !Auth::user()->educator ?
                                                                  route('parent.inbox', '?chat_id='.$activeChat->id)
                                                                  : route('educator.inbox', '?chat_id='.$activeChat->id) }}"
                                                               data-name="{{ optional($activeChat->chat_with)->name }}"
                                                               data-url="{{ route('chat.messages', $activeChat->id) }}"
                                                               class="kt-widget__username username">{{ optional($activeChat->chat_with)->name }}
                                                                @if($activeChat->last_message_text !== '-')
                                                                    <span
                                                                        class="kt-widget__desc">
                                                                {{ strlen(strip_tags($activeChat->last_message_text)) > 30 ? substr(strip_tags($activeChat->last_message_text), 0, 30).'...'
                                                                : strip_tags($activeChat->last_message_text) }}</span>
                                                                @endif

                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="kt-widget__action">
                                                        <a href="{{  !Auth::user()->educator ?
                                                                  route('parent.inbox', '?chat_id='.$activeChat->id)
                                                                  : route('educator.inbox', '?chat_id='.$activeChat->id) }}"
                                                           data-name="{{ optional($activeChat->chat_with)->name }}"
                                                           data-url="{{ route('chat.messages', $activeChat->id) }}"
                                                           class="kt-widget__username username">
                                                            <span
                                                                class="kt-widget__date">{{ \Carbon\Carbon::parse($activeChat->last_message_at)->diffForHumans() }}</span>
                                                            @if($activeChat->unread_count  > 0 )
                                                                <span
                                                                    class="kt-badge kt-badge--danger kt-font-bold">{{ $activeChat->unread_count }}</span>
                                                            @endif
                                                        </a>
                                                    </div>
                                                </div>

                                                @foreach($chats as $chat)

                                                    <div class="kt-widget__item">
                                                        @if($chat->chat_with->educator)
                                                            <a href="{{ route('page.educator', $chat->chat_with->slug) }}">

                                                            <span class="kt-userpic kt-userpic--circle">
                                                                <img
                                                                    src="{{ \App\Helpers\ClassHubHelper::getImagePath(null, optional($chat->chat_with->educator)->photo) }}"
                                                                    alt="image">
                                                              </span>
                                                            </a>
                                                        @else
                                                            <span
                                                                class="kt-userpic kt-userpic--circle kt-userpic--danger">

														        <span>{{ \App\Helpers\ClassHubHelper::getInitials(optional($chat->chat_with)->name) }}</span>
													        </span>
                                                        @endif
                                                        <div class="kt-widget__info">
                                                            <div class="kt-widget__section">
                                                                <a href="{{  !Auth::user()->educator ?
                                                                  route('parent.inbox', '?chat_id='.$chat->id)
                                                                  : route('educator.inbox', '?chat_id='.$chat->id) }}"
                                                                   data-name="{{ optional($chat->chat_with)->name }}"
                                                                   data-url="{{ route('chat.messages', $chat->id) }}"
                                                                   class="kt-widget__username username">{{ optional($chat->chat_with)->name }}
                                                                    @if($chat->last_message_text !== '-')

                                                                        <span
                                                                            class="kt-widget__desc">
                                                                {{ strlen(strip_tags($chat->last_message_text)) > 30 ? substr(strip_tags($chat->last_message_text), 0, 30).'...'
                                                                : strip_tags($chat->last_message_text) }}</span>
                                                                    @endif

                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="kt-widget__action">
                                                            <a href="{{  !Auth::user()->educator ?
                                                                  route('parent.inbox', '?chat_id='.$chat->id)
                                                                  : route('educator.inbox', '?chat_id='.$chat->id) }}"
                                                               data-name="{{ optional($chat->chat_with)->name }}"
                                                               data-url="{{ route('chat.messages', $chat->id) }}"
                                                               class="kt-widget__username username">
                                                            <span
                                                                class="kt-widget__date">{{ \Carbon\Carbon::parse($chat->last_message_at)->diffForHumans() }}</span>
                                                                @if($chat->unread_count  > 0 )
                                                                    <span
                                                                        class="kt-badge kt-badge--danger kt-font-bold">{{ $chat->unread_count }}</span>
                                                                @endif
                                                            </a>
                                                        </div>
                                                    </div>

                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--end::Portlet-->
                        </div>

                    </div>
                    <div class="col-md-8">

                        <!--Begin:: App Content-->
                        <div class="kt-grid__item kt-grid__item--fluid kt-app__content" id="kt_chat_content">
                            <div class="kt-chat">
                                <div class="kt-portlet kt-portlet--head-lg kt-portlet--last">
                                    <div class="kt-portlet__head">
                                        <div class="kt-chat__head ">
                                            @if($mobile)
                                                <div class="kt_chat__left">
                                                    <i class="fa fa-arrow-left" id="back-btn"></i>
                                                </div>
                                            @endif
                                            <div class="kt-chat__center">
                                                <div class="kt-chat__pic">
                                                    @if($activeChat->chat_with->educator)
                                                    <a href="{{ route('page.educator', $activeChat->chat_with->slug) }}">
                                                        <span class="kt-userpic kt-userpic--sm kt-userpic--circle"
                                                              data-toggle="kt-tooltip"
                                                              data-placement="right" title="Milano Esco"
                                                              data-original-title="Tooltip title">
                                                        <img
                                                            src="{{ \App\Helpers\ClassHubHelper::getImagePath(null, optional($activeChat->chat_with->educator)->photo) }}"
                                                            alt="image">
                                                      </span>
                                                    </a>
                                                    @else
                                                      <a href="{{ route('page.educator', $activeChat->chat_with->slug) }}">
                                                        <span
                                                            class="kt-userpic kt-userpic--circle kt-userpic--danger">

                      														        <span>{{ \App\Helpers\ClassHubHelper::getInitials(optional($activeChat->chat_with)->name) }}</span>
                      													        </span>
                                                      </a>
                                                    @endif
                                                </div>
                                                <div class="kt-chat__label">
                                                    <a href="{{ route('page.educator', $activeChat->chat_with->slug) }}"
                                                       class="kt-chat__title">{{ optional($activeChat->chat_with)->name }}</a>
                                                    {{--<span class="kt-chat__status">
                                                        <span class="kt-badge kt-badge--dot kt-badge--success"></span> Active
                                                      </span>--}}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="kt-portlet__body">
                                        <div class="kt-scroll kt-scroll--pull" data-mobile-height="300"
                                             id="chat-messages-box">
                                            <div class="kt-chat__messages">
                                                @foreach($messages as $date => $dateMessages)
                                                    @foreach($dateMessages as $message)
                                                        <?php
                                                        if ($message->type == 'request_tutor' || strpos($message->text, $bookingConfirmationMessage) || $message->type == 'booking_video_call') {
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
                                                                        @if($message->video_call_response != null)
                                                                          <p style="margin: 10px 0">Online Tuition</p>
                                                                        @endif
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
                                                                                   class="booking-accept btn btn-primary "
                                                                                   data-toggle="modal"
                                                                                   data-target="#payment-summary"
                                                                                   data-message-id="{{ $message->id }}"
                                                                                   data-lesson-id="{{$message->lesson_id}}"
                                                                                   data-class-ids="{{$message->class_ids}}">ACCEPT</a>
                                                                                <a href="javascript:void(0)"
                                                                                   class="booking-reject btn btn-primary"
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
                                    @if($mobile)
                                        <div class="kt-portlet__foot mobile-only">
                                            <div class="kt-chat__input">
                                                <div class="row">
                                                    <div class="col-sm-10 d-flex justify-content-between">
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
                                                    <div class="col-sm-1">
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
                                        </div>
                                    @else
                                        <div class="kt-portlet__foot desktop-only">
                                            <div class="kt-chat__input">
                                                <div class="row">
                                                    <div class="col-lg-11 col-md-11 d-flex justify-content-between">
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
                                                    <div class="col-lg-1 col-md-1">
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
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!--End:: App Content-->
                    </div>
                </div>
                <!--End:: App Aside-->

            @endif
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

    @include('educator.modals.confirm-refund-accept')
    @include('educator.modals.confirm-refund-reject')
    @include('common.reschedule-video-call')
    @include('educator.modals.subject-booking')
    @include('common.booking-rejected')
    @include('common.booking-confirmed', ['lesson' =>  false])

@endsection

@section('page_scripts')
    <script type="text/javascript" src="{{ asset('parent/js/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('parent/js/script.js') }}"></script>
    <script type="text/javascript" src="{{ asset('parent/js/custom.js') }}"></script>
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <script src="https://js.stripe.com/v3/"></script>

    @include('common.send-message-script')

    <script type="text/javascript">
        var recipientId = false;
        var messageId = ''
        var bookingId = ''
        var classIds = ''
        var bookingRejectedModal = $('div#booking-rejected-modal')

        var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

        if (iOS) {
            $('footer.global-footer').css('display', 'none')
        }


        $(function () {

            $('input.schedule-time-picker').flatpickr({
                enableTime: true,
                dateFormat: "d-m-Y H:i",
                minDate: "{!! date('d-m-Y H:i') !!}"
            })
        })


        $('body').on('click', 'a.schedule-call-reschedule', function () {
            messageId = $(this).data('id')
            recipientId = $(this).data('recipient-id')
        })

        $('body').on('click', 'a.booking-modal', function () {
            $('input#recipient-id').val($(this).data('recipient-id'))
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
                        $(bookingRejectedModal).modal('show')

                    } else {
                        $(resultModal).modal('show')
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    }
                },
                error: function (data) {
                    $(resultModal).modal('show')
                    $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    console.log(data)
                }
            })
        })

        $(bookingRejectedModal).on('hidden.bs.modal', function () {
            window.location.reload()
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


        $('body').on('click', 'a.accept-refund-btn', function () {
            $.ajax({
                type: 'POST',
                url: '{{  route('educator.accept.refund')}}',
                data: {
                    _token: '{{ csrf_token() }}',
                    message_id: messageId,
                    booking_id: bookingId,
                    class_ids: classIds
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data)
                    if (data.status) {
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        setTimeout(function () {
                            location.reload(true)
                        }, 3000)
                    } else {
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    }
                },
                error: function (data) {
                    $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                }
            })

            $(resultModal).modal('show')
        })


        $('body').on('click', 'a.reject-refund-btn', function () {
            var reason = $('textarea[name="reject-reason"]').val()

            if (reason.length == 0) {
                $(resultModal).find('div.modal-body').html('Please enter reject reason')
            } else {
                $.ajax({
                    type: 'POST',
                    url: '{{  route('educator.reject.refund')}}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        message_id: messageId,
                        booking_id: bookingId,
                        class_ids: classIds,
                        reason: reason
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        if (data.status) {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                            setTimeout(function () {
                                location.reload(true)
                            }, 3000)
                        } else {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    },
                    error: function (data) {
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    }
                })

            }


            $(resultModal).modal('show')
        })


        $('body').on('click', 'a.refund-request-accept , a.refund-request-reject', function () {
            messageId = $(this).data('message-id')
            bookingId = $(this).data('booking-id')
            classIds = $(this).data('classes-id')
        })

        $('div#result-modal').on('hidden.bs.modal', function () {
            $(resultModal).find('div.modal-body').html('<div class="spinner"></div>')
        })

        $('body').on('keyup', 'input#search-chat', function () {

            let searchKey = $(this).val().toLowerCase();


            if (!searchKey) {
                $('a.username').parents('div.kt-widget__item').css('display', '-webkit-box')
                $('a.username').parents('div.kt-widget__item').css('display', '-ms-flexbox')
                return;
            }

            $('a.username').each(function () {
                if (!$(this).data('name').toLowerCase().includes(searchKey)) {
                    $(this).parents('div.kt-widget__item').css('display', 'none')
                }
            })

        })

    </script>



    <script>
        var element = document.getElementById("chat-messages-box");
        element.scrollTop = element.scrollHeight;

        function updateScroll() {
            var element = document.getElementById("chat-messages-box");
            element.scrollTop = element.scrollHeight;
        }
    </script>

    @if($mobile)

        <script type="text/javascript">

            $('body').on('click', 'a.username', function (evt) {

                evt.preventDefault()

                $('div#kt_chat_aside').css('display', 'none')
                $('div#kt_chat_content').html('<div class="col-12 text-center"><div class="spinner"></div></div>')
                $('div#kt_chat_content').css('display', 'block')

                url = $(this).data('url')

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        if (data.status) {
                            $('div#kt_chat_content').html(data.messages)
                            updateScroll()
                        } else {
                            $('div#kt_chat_content').html(data.error)
                        }
                    },
                    error: function (data) {
                    }
                })

            })

            $('body').on('click', 'i#back-btn', function (evt) {
                $('div#kt_chat_aside').css('display', 'block')
                $('div#kt_chat_content').css('display', 'none')
            })

        </script>

    @endif


@endsection
