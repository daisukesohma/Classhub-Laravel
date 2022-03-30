@extends('frontend.layouts.master')

@section('title')
    Classhub | {{ $user->name }}
@endsection

@section('meta_tags')
    @if(\App\Helpers\ClassHubHelper::getImagePath(null, $user->educator->photo))
        <meta property="og:image"
              content="{{ route('home').\App\Helpers\ClassHubHelper::getImagePath(null, $user->educator->photo) }}"/>
    @endif
@endsection

@section('page_styles')
    <link href="{{ asset('css/flatpickr.css') }}" rel="stylesheet" type="text/css" media="all"/>

    <style type="text/css">
        .main-container {
            padding: 55px 0 0 0!important;
        }
    </style>

    @if($mobile)
        <style type="text/css">
            div#send-message-confirmation .modal-header{
                padding-bottom: 0 !important;
            }
        </style>
    @endif
@endsection

@section('content')

    <!-- starts: columns container -->
    <div class="container">
        <!-- starts : teacher profile -->
        <div class="profile-teacher {{ $user->trusted ? 'trusted' : '' }}">
            <div class="row">
                <!-- starts: column left -->
                <div class="col-lg-4 col-md-5">
                    <div class="profile feature shadow-v1 boxed  text-center">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- starts: Image -->
                                <div class="image">
                                    <div class="profile-page-image"
                                         style="background-image: url({{ \App\Helpers\ClassHubHelper::getImagePath(null, $user->educator->photo) ?
                                               \App\Helpers\ClassHubHelper::getImagePath(null, $user->educator->photo) :
                                               asset('/img/profile-placeholder.jpg') }});">
                                    </div>
                                </div>
                                <!-- End: Image -->
                            </div>
                            <div class="col-md-6">
                                <div class="title">{{ $user->name }}</div>
                                <!-- starts: Rating -->
                            @include('frontend.includes.rating',
                            ['rating' => \App\Helpers\ClassHubHelper::ratings($user->ratings)])
                            <!-- end: Rating -->
                                <!-- starts: See reviews link + overlay -->
                                <div class="see-reviews">
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#see-reviews"
                                       class="link-01">See
                                        reviews</a>
                                </div>
                                <!-- end: See reviews link + overlay -->
                                <!-- starts: share link + overlay -->
                                <div class="share-this">
                                    <a href="javascript:;" class="link-01 icon-share copy-link"
                                       data-link="{{ route('page.educator', $user->slug) }}"
                                       data-toggle="modal"
                                       data-target="{{  Auth::user() ? '#share-profile-modal' : '#signup-modal' }}">
                                        <img class="share-icon" src="/img/icons/share-icon.png" height="17px"/>
                                        <span>Share</span>
                                    </a>
                                </div>
                                <!-- end: share link + overlay -->
                            </div>
                        </div>

                        <!-- starts : Contact me for a chat -->
                        <div class="row contact-btns">
                            <div class="col-xs-12 col-md-6">
                                <a href="javascript:;"
                                   {{
                                       Auth::user() ?
                                       ' data-toggle=modal data-target=#send-message-modal data-recipient-id='.$user->id :
                                       ' data-toggle=modal data-target=#login-modal'
                                       }}
                                   class="btn btn-primary shadow-v4 contact-btn {{ Auth::user() ? 'send-message-btn' : '' }}"
                                   style="white-space: inherit;">
                                    <span class="btn__text">Message me</span>
                                </a>
                            </div>
                        </div>
                        <!-- end : Contact me for a chat -->
                        <!-- About me -->
                        <div class="row about-me">
                            <div class="col-md-12">
                                <h5 class="text-left m-b-0 m-t-sm-20">About Me</h5>
                                <p class="lh-135 text-left m-b-0">
                                    {!! \App\Helpers\ClassHubHelper::excerpt($user->educator->bio) !!}
                                </p>
                            </div>
                        </div>
                        <!-- end: About me -->
                        <hr class="red-line">
                        <!-- Teaching Type -->
                        <div class="row teaching-type">
                            <div class="col-md-12">
                                <h5 class="text-left m-b-0">Teaching Type</h5>
                                <ul class="text-left">
                                    @foreach($user->educator->teaching_types as $teachingType)
                                        <li>{{ $teachingType }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- end: Teaching Type -->

                        <!-- Areas I cover -->
                        <div class="row teaching-type">
                            <div class="col-md-12">
                                <h5 class="text-left m-b-0">Areas I Cover</h5>
                                <ul class="text-left">
                                    @foreach($user->areas as $area)
                                        <li>{{ $area->address }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- end: Areas I cover -->

                        <!-- Qualifications & Experience -->
                        <div class="row teaching-type">
                            <div class="col-md-12">
                                <h5 class="text-left m-b-0">Qualifications & Experience</h5>
                                <ul class="text-left">
                                    @foreach($user->educator->qualifications as $qualification)
                                        @if(!empty($qualification['name']))
                                            <li>{{ $qualification['name'] }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- end: Qualifications & Experience -->

                        <!-- Subjects -->
                        <div class="row teaching-type">
                            <div class="col-md-12">
                                <h5 class="text-left m-b-0">Subjects</h5>
                                <ul class="text-left">
                                    @foreach($subjects as $subject)
                                        @php $displayName = \App\Helpers\ClassHubHelper::getSubjectDisplayName($subject, $subjects)  @endphp
                                        @if($displayName)
                                            <li>{{ $displayName }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- end: Subjects -->
                        <a href="javascript:;" class="profile-like-btn"
                           data-like="{{ $liked ? 1 : 0 }}" {{  Auth::user() ? '' : '#login-modal' }}>
                            <i class="fa {{ $liked ? 'fa-heart' : 'fa-heart-o' }} tag-favourite"></i>
                        </a>

                    </div>
                </div>
                <!-- end: column left -->
                <!-- starts: column left -->
                <div class="col-lg-8 col-md-7">
                    <div class="about feature shadow-v1 boxed cast-shadow-light ">
                        <!-- Starts: Tiles type 01 -->
                        <div class="row title-type-01">
                            <div class="col-sm-12">
                                <div class="title">
                                    {{ strtoupper($user->firstname) }}’S CLASSES ({{ $liveLessons->count() }})
                                </div>
                            </div>
                        </div>
                        <!-- Starts: Tiles type 01 -->
                        <!-- Starts: Tiles type 01 -->
                        <div class="row tiles-type-01">

                            @include('frontend.includes.profile-lessons-default', ['lessons' => $liveLessons])

                        </div>
                        <!-- End: Tiles type 01 -->
                    </div>
                </div>
                <!-- end: column left -->
            </div>
        </div>
        <br class="clear"/>
        <!-- end : teacher profile -->
    </div>
    <!-- end: columns container -->

    <!-- starts: all related classes list -->
    <div class="container classes-tiles you-may-like">

        <!-- Starts: Tiles type 01 -->
      <!--   @if($relatedLessons->count())
            <div class="row title-type-01">
                <div class="col-sm-12">
                    <div class="title">YOU MAY ALSO LIKE</div>
                </div>
            </div>
    @endif -->
    <!-- Starts: Tiles type 01 -->

        <!-- Starts: Tiles type 01 -->
        <!--<div class="row tiles-type-01 ">
            <div class="show-more-container">
                @include('frontend.includes.lessons', ['lessons' => $relatedLessons])

                @if($relatedLessons->nextPageUrl())
                    <div class="row showmore p-t-55 show-more-button-container">
                        <div class="col-sm-12 text-center">
                            <a class="btn btn-primary shadow-v4 show-more-button"
                               href="{{ $relatedLessons->nextPageUrl() }}">
                                <span class="btn__text">SHOW MORE</span>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div> -->
        <!-- End: Tiles type 01 -->

        <!-- End: bottom button -->

    </div>
    <!-- end: all related classes list -->

    @include('frontend.modals.share-profile')

    @include('frontend.modals.reviews')

    @include('common.send-message-modal')

    @include('frontend.modals.schedule-video-call', ['name' => $user->name])

    @include('common.send-message-success')

@endsection

@section('page_scripts')

    <script src="{{ asset('js/flatpickr.js') }}"></script>

    <script type="text/javascript">

        var sendMessageModal = $('div#send-message-modal')
        var sendMessageSuccess = $('div#send-message-confirmation');

        // Lesson liked/unlike
        $('body').on('click', 'a.profile-like-btn', function () {
            var _this = $(this)
            var liked = $(this).children('i').hasClass('fa-heart')
            var route = liked ? '{{ route('unlike.educator', $user->id) }}' :
                '{{ route('like.educator', $user->id) }}'

            console.log(liked, route)

            $.ajax({
                type: 'POST',
                url: route,
                data: {_token: '{{ csrf_token() }}'},
                dataType: 'JSON',
                success: function (data) {
                    if (data.status) {
                        if (liked) {
                            $(_this).attr('data-like', 0).children('i')
                                .removeClass('fa-heart').addClass('fa-heart-o')
                        } else {
                            $(_this).attr('data-like', 1).children('i')
                                .removeClass('fa-heart-o').addClass('fa-heart')
                        }
                    } else {
                        $('.signup-modal')[1].click()
                    }
                },
                error: function (data) {
                    $('div.w1-modal-content').html(data.messages)
                    $('a.modal-trigger-1')[0].click()
                }
            })
        })

        $(function () {

            $('input.schedule-time-picker').flatpickr({
                enableTime: true,
                dateFormat: "d-m-Y H:i",
                minDate: "{!! date('d-m-Y H:i') !!}"
            })


            $('body').on('click', 'button.share-profile-btn', function () {
                var route = $(this).data('share-route')
                var educatorId = $(this).data('educator-id')
                $.ajax({
                    type: 'POST',
                    url: route,
                    data: {
                        _token: '{{ csrf_token() }}',
                        share_email: $('input[name="share_email"]').val(),
                        educator_id: educatorId
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        if (data.status) {
                            $('div#result').html(data.messages.join('<br>'))
                        } else {
                            $('div#error').html(data.messages.join('<br>'))
                        }
                    },
                    error: function (data) {
                        $('div#error').html(data.messages.join('<br>'))
                    }
                })
            })

            $('a.send-message-btn').on('click', function () {
                var recipientId = $(this).data('recipient-id')
                $('a.chat-send-btn').attr('data-recipient-id', recipientId)
            })

            $('body').on('click', 'a.chat-send-btn', function () {
                var _this = $(this)
                var message = $(sendMessageModal).find('textarea[name="chat-message"]').val()

                if (message.length > 0) {
                    $(resultModal).modal('show')
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('chat.send.message') }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            text: message,
                            lesson_id: $(_this).data('lesson-id'),
                            recipient_id: $(_this).data('recipient-id'),
                        },
                        dataType: 'json',
                        success: function (data) {
                            console.log(data)
                            if (data.status) {
                                console.log('success')
                                $(resultModal).modal('hide')
                                $(sendMessageSuccess).modal('show')
                            } else {
                                $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                            }
                        },
                        error: function (data) {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    })
                }
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
                    text: 'Hi there, I would like to schedule a video call for:',
                    recipient_id: '{{ $user->id }}',
                },
                dataType: 'json',
                success: function (data) {
                    if (data.status) {
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
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

        $(sendMessageModal).on('hidden.bs.modal', function (e) {
            $(this).find('textarea[name="chat-message"]').val('')
        })

        $('div#share-profile-modal').on('hidden.bs.modal', function () {
            $(this).find('div#result').html('')
            $(this).find('div#error').html('')
        })
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        $(function () {
            $('[data-toggle="popover"]').popover()
        })
        $("html").on("mouseup", function (e) {
            var l = $(e.target);
            if (l[0].className.indexOf("popover") == -1) {
                $(".popover").each(function () {
                    $(this).popover("hide");
                });
            }
        });
    </script>


@endsection
