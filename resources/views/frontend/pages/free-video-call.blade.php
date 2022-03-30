@extends('frontend.layouts.master')

@section('title')
    Classhub | Free Video Call
@endsection

@section('page_styles')
    <link rel="stylesheet" href="{{ asset('css/video-call.css') }}" media="all">
    <style>
        header, footer {
            display: none !important;
        }

        .m-header--fixed .main-container {
            padding-top: 0px;
        }

        #intercom-container, .intercom-lightweight-app {
            display: none;
        }

        .login-required {
            display: flex;
            flex-direction: column;
            align-content: center;
            height: 100vh;
            justify-content: center;
        }

        .login-required div {
            margin: 20px 0;
        }

        .login-btn {
            padding: 10px !important;
            font-weight: bold !important;
            font-size: 25px !important;
            border-radius: 6px;
        }

        .login-btn:hover {
            border-color: #e74a65 !important;
            background-color: #ffffff !important;
            color: #e74a65 !important;
        }

        .show.fade {
            opacity: 0.8 !important;
        }
    </style>
    @if($mobile)
        <style type="text/css">
            #chat-container {
                height: 90vh !important;
            }

            #message-container {
                min-height: 70vh !important;
                max-height: 70vh !important;
            }
        </style>
    @else
        <style type="text/css">
            #message-container {
                min-height: 80vh !important;
                max-height: 80vh !important;
            }
        </style>
    @endif
@endsection

@section('content')
    <div class="video-call-page p-b-20">

        <div class="col-12">
            @if($loginRequired)
                <div class="row status-info login-required" id="video-call-info">
                    <div class="logo-container">
                        <img src="{{ asset('classhub-logo-light.png') }}"/>
                    </div>
                    <div><h3 style="width: 100%; color: #fff; font-weight: bold">{!! $errorMessage !!}</h3></div>
                    <div class="btn-container">
                        <a class="m-menu__link  btn-outline-primary login-btn"
                           href="{{ $loginUrl }}" style="width: auto !important;">Login</a>
                    </div>
                </div>
            @elseif($errorMessage)
                <div class="emptyState text-center p-t-60 p-b-40" style="min-height: 65vh">
                    <i class="fa fa-video-camera p-b-20"></i>
                    <h4>{!! $errorMessage !!}</h4>
                </div>
            @else
                <div class="row status-info" id="video-call-info">Connecting...</div>
                <div class="" style=" margin: 0 72px">

                    <div id="control-buttons" style="display: none;">
                        <button type="button"
                                class="video-buttons btn-icon btn-danger endCallBtn bmd-btn-fab mx-3"
                                id="button-toggle-audio" data-container="body" data-toggle="m-tooltip"
                                data-placement="top" data-original-title="Mute call">
                            <span><i class="la la-microphone-slash"></i></span>
                        </button>
                        <button type="button"
                                class="video-buttons btn-icon btn-danger endCallBtn bmd-btn-fab mx-3"
                                id="button-toggle-video" data-container="body" data-toggle="m-tooltip"
                                data-placement="top" data-original-title="Turn off camera">
                            <span><i class="la la-eye-slash"></i><span class="hide-mob"></span></span>
                        </button>
                        <button type="button"
                                class="video-buttons btn-icon btn-danger endCallBtn bmd-btn-fab mx-3"
                                id="button-leave-room" data-container="body" data-toggle="m-tooltip"
                                data-placement="top" data-original-title="Leave call">
                            <span><i class="la la-ban"></i></span>
                        </button>

                        <button type="button" class="video-buttons btn-icon btn-danger  bmd-btn-fab mx-3"
                                id="button-share-screen" data-container="body" data-toggle="m-tooltip"
                                data-placement="top" data-original-title="Share your screen">
                                        <span><i class="la la-clone"></i>
                                            <span id="share-screen-text">

                                            </span>
                                        </span>
                        </button>
                        <button type="button" class="video-buttons btn-icon active btn-danger  bmd-btn-fab mx-3"
                                id="button-stop-share-screen" style="display: none;" data-container="body"
                                data-toggle="m-tooltip" data-placement="top"
                                data-original-title="Stop sharing your screen">
                            <span><i class="la la-clone"></i></span>
                        </button>
                        <button type="button"
                                class="video-buttons btn-icon btn-danger endCallBtn bmd-btn-fab mx-3"
                                id="button-full-screen" data-container="body" data-toggle="m-tooltip"
                                data-placement="top" data-original-title="Fullscreen (You)">
                            <span><i class="la la-expand"></i></span>
                        </button>
                    </div>

                    <div class="p-t-10 p-b-10 text-center"
                         id="video-call-container">

                        <div id="participants">

                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-t-10 p-b-10 chat" id="chat-container"
                         style="width: 0px;">
                        <span class="toggle-btn" onclick="closeChat()"><i class="la la-close close-chatbox"></i>
                                                <span class="side-box-title">MESSAGES</span>
                        </span>
                        <div class="">
                            <div class="messages" id="message-container">
                                <div id="chat-connect-status">Connecting...</div>
                            </div>
                            <div class="messages message-typing">
                                <div class="message message-in" id="typing-container" style="display: none">
                                    <div class="typing typing-1"></div>
                                    <div class="typing typing-2"></div>
                                    <div class="typing typing-3"></div>
                                </div>
                            </div>
                            <div class="input">
                                <div class="attachment-container">
                                    <label for="file-input">
                                        <i
                                            class="fa fa-paperclip" style="color: #E74B65; font-size: 30px;"></i>
                                    </label>
                                    <input type="file" name="attachment" id="file-input">
                                </div>

                                <input id="chat-message-input"
                                       placeholder="Type your message here!" type="text"/>
                                <i id="button-send-message"
                                   class="fa fa-paper-plane" style="color: #E74B65; font-size: 30px;"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-t-10 p-b-10 chat" id="screens-container"
                         style="width: 0px">
                        <span class="toggle-btn" onclick="closeScreens()"><i class="la la-close close-screens"></i>
                            <span class="side-box-title"
                                  style="padding: 10px;    float: left;    vertical-align: middle;">SHARE SCREENS</span>
                        </span>
                        <div class="">
                            <div class="messages" id="user-screens">
                                <div id="screen-preview-container" style="display: none">
                                    <div class="row status-info">YOUR SCREEN</div>
                                    <video id="screen-preview"></video>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="left-controls">
                        <button type="button" class="btn-danger  bmd-btn-fab mx-3 screens-toggle"
                                id="button-toggle-screens" onclick="openScreens()">
                            <span id="screen-notification-counter" class="screen-notification-counter">0</span>
                            <span><i class="fa fa-laptop"></i></span>
                        </button>
                    </div>

                    <div class="right-controls">
                        <button type="button" class="btn-danger  bmd-btn-fab mx-3 chat-toggle"
                                id="button-toggle-chat" onclick="openChat()">
                            <span id="video-notification-counter" class="video-notification-counter">0</span>
                            <span><i class="la la-commenting"></i></span>
                        </button>
                    </div>
                </div>

            @endif
        </div>
    </div>
    <div id="modals">
        <div class="modal fade c-modal" id="select-mic" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="select-mic-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    </div>
                    <div class="modal-body" style="padding-top: 0">
                        <p>Microphone</p>
                        <div class="form-group m-form__group p-t-12">
                            <select style="width: 100%"></select>

                            <div class="" style="width: 100%; text-align: center">

                                <svg focusable="false" viewBox="0 0 100 100" aria-hidden="true" height="100" width="100"
                                     style="margin: 10px 0">
                                    <defs>
                                        <clipPath id="level-indicator">
                                            <rect x="0" y="100" width="100" height="100"/>
                                        </clipPath>
                                    </defs>
                                    <path fill="rgb(220, 220, 220)"
                                          d="m52 38v14c0 9.757-8.242 18-18 18h-8c-9.757 0-18-8.243-18-18v-14h-8v14c0 14.094 11.906 26 26 26v14h-17v8h42v-8h-17v-14c14.094 0 26-11.906 26-26v-14h-8z"></path>
                                    <path fill="rgb(220, 220, 220)"
                                          d="m26 64h8c5.714 0 10.788-4.483 11.804-10h-11.887v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h11.887c-1.016-5.517-6.09-10-11.804-10h-8c-6.393 0-12 5.607-12 12v40c0 6.393 5.607 12 12 12z"></path>
                                    <path fill="#080" clip-path="url(#level-indicator)"
                                          d="m52 38v14c0 9.757-8.242 18-18 18h-8c-9.757 0-18-8.243-18-18v-14h-8v14c0 14.094 11.906 26 26 26v14h-17v8h42v-8h-17v-14c14.094 0 26-11.906 26-26v-14h-8z"></path>
                                    <path fill="#080" clip-path="url(#level-indicator)"
                                          d="m26 64h8c5.714 0 10.788-4.483 11.804-10h-11.887v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h11.887c-1.016-5.517-6.09-10-11.804-10h-8c-6.393 0-12 5.607-12 12v40c0 6.393 5.607 12 12 12z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="text-right modal-footer">
                            <button type="button" class="btn btn-secondary btn-text-red shadow-v4 chat-send-btn"
                            >
                                <span class="btn__text v1">APPLY</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade c-modal" id="select-camera" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="select-camera-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    </div>
                    <div class="modal-body" style="padding-top: 0">
                        <p>Camera</p>
                        <div class="form-group m-form__group p-t-12">
                            <select style="width: 100%"></select>

                            <div class="" style="width: 100%; text-align: center">
                                <video autoplay muted playsInline style="margin: 10px 0; width: 60%"></video>
                            </div>
                        </div>

                        <div class="text-right modal-footer">
                            <button type="button" class="btn btn-secondary btn-text-red shadow-v4 chat-send-btn"
                            >
                                <span class="btn__text v1">APPLY</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade c-modal" id="show-error" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="show-error-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    </div>
                    <div class="modal-body">
                        <h5 class="modal-title" id="show-error-label">Error</h5>
                        <div class="alert alert-warning" role="alert">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_scripts')

    @if($callData)
        <script>

            /* Open and close chat box */
            function openChat() {
                document.getElementById("chat-container").style.width = "350px";
                document.getElementById("button-toggle-chat").setAttribute("onClick", "javascript: closeChat();");
                document.getElementById("message-container").style.visibility = "visible";
                $('#video-notification-counter').html(0)
                $('#video-notification-counter').hide()
            }

            function closeChat() {
                document.getElementById("message-container").style.visibility = "hidden";
                document.getElementById("chat-container").style.width = "0px";
                document.getElementById("button-toggle-chat").setAttribute("onClick", "javascript: openChat();");
            }

            /* Open and close screens box */
            function openScreens() {
                document.getElementById("screens-container").style.width = "350px";
                document.getElementById("button-toggle-screens").setAttribute("onClick", "javascript: closeScreens();");
                document.getElementById("user-screens").style.visibility = "visible";
                $('#screen-notification-counter').html(0)
                $('#screen-notification-counter').hide()
            }

            function closeScreens() {
                document.getElementById("user-screens").style.visibility = "hidden";
                document.getElementById("screens-container").style.width = "0px";
                document.getElementById("button-toggle-screens").setAttribute("onClick", "javascript: openScreens();");
            }

            /* Toggle video icons on click */
            $('#button-toggle-audio').on('click', function () {
                var childSpan = $(this).find('i');
                if (childSpan.hasClass('la-microphone-slash')) {
                    childSpan.removeClass('la-microphone-slash');
                    childSpan.addClass('la-microphone');

                    $('#button-toggle-audio').tooltip('hide')
                        .attr('data-original-title', "Unmute call")
                        .tooltip('fixTitle');
                }
                else if (childSpan.hasClass('la-microphone')) {
                    childSpan.removeClass('la-microphone');
                    childSpan.addClass('la-microphone-slash');

                    $('#button-toggle-audio').tooltip('hide')
                        .attr('data-original-title', "Mute call")
                        .tooltip('fixTitle');
                }
                $('#button-toggle-audio').toggleClass('active');
            });

            $('#button-toggle-video').on('click', function () {
                var childSpan = $(this).find('i');
                if (childSpan.hasClass('la-eye-slash')) {
                    childSpan.removeClass('la-eye-slash');
                    childSpan.addClass('la-eye');
                    $('#button-toggle-video').tooltip('hide')
                        .attr('data-original-title', "Turn on camera")
                        .tooltip('fixTitle');
                }
                else if (childSpan.hasClass('la-eye')) {
                    childSpan.removeClass('la-eye');
                    childSpan.addClass('la-eye-slash');
                    $('#button-toggle-video').tooltip('hide')
                        .attr('data-original-title', "Turn off camera")
                        .tooltip('fixTitle');
                }
                $('#button-toggle-video').toggleClass('active');
            });

            /* Open and close bottom bar */

            var i = null;
            $("body").mousemove(function () {
                clearTimeout(i);
                document.getElementById("control-buttons").style.height = "100px";
                i = setTimeout(function () {
                    document.getElementById("control-buttons").style.height = "0px";
                }, 10000);
            }).mouseleave(function () {
                clearTimeout(i);
                document.getElementById("control-buttons").style.height = "0px";
            });

            // Network details toggle
            $('body').on('click', 'i.show-network-details', function () {
                parent = $(this).parent('div');

                if ($(this).hasClass('fa-eye')) {
                    $(this).removeClass('fa-eye');
                    $(this).addClass('fa-eye-slash');
                    $(parent).next().fadeIn(500);
                } else {
                    $(this).removeClass('fa-eye-slash');
                    $(this).addClass('fa-eye');
                    $(parent).next().fadeOut(500);
                }
            })

            // Network details toggle
            $('body').on('click', 'i.hide-network-details', function () {
                parent = $(this).parents('div.network-stats');
                $(parent).fadeOut(500);
            })

        </script>

        <script type="text/javascript" src="{{ asset('js/jquery-throttle.js') }}"></script>

        <script type="text/javascript">
            // Global variable
            var roomName = '{{ $callData->room_name }}';
            var callType = 'free_call'
            var callDuration = 1;
            const MILLLISECONDS_IN_MINUTE = 60000

            function updateCallDuration() {
                console.log('Call duration', callDuration)

                if (callDuration >= 20) {
                    callCompleted();

                    setTimeout(function () {
                        window.location = '{{ route('home') }}'
                    }, 5000)
                }

                callDuration++;
            }

            function callCompleted() {
                $(resultModal).modal('show')
                $(resultModal).find('div.modal-body').html(`<div class="">Your free call duration of 20 minutes is now up.<br> You will be redirected to the homepage in a moment.</div>`)

                $.ajax({
                    url: '{{ route('free-call.completed') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: '{{ $videoCall->id }}'
                    },
                    type: 'POST',
                    success: function (data) {

                    },
                    error: function (data) {
                    }
                });
            }

            function logCallError(user, message) {
                $.ajax({
                    url: '{{ route('log.video.error') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        user: user,
                        message: message
                    },
                    type: 'POST',
                    success: function (data) {
                    },
                    error: function (data) {
                    }
                });
            }
        </script>
        <script type="text/javascript" src="{{ asset('twilio/index.js') }}"></script>
    @endif
@endsection
