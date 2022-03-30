@extends('frontend.layouts.master')

@section('title')
    Online {{--{{ $lesson->category->getParent()->name }} Lessons {{ $lesson->age_from }} to {{ $lesson->age_to }} Years Old | Classhub--}}
    {{ $lesson->name }} | Classhub
@endsection
@section('course_meta')
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Course",
      "name": "{{ $lesson->name }}",
      "description": "{{ $lesson->description }}",
      "provider": {
        "@type": "Organization",
        "name": "{{ $lesson->user->name }}",
        "sameAs": "{{ route('page.educator', $lesson->user->slug) }}"
      }
    }





    </script>
@endsection

@section('meta_tags')
    @if($lesson->images->first())
        <meta property="og:image" content="{{ route('home').Storage::url($lesson->images->first()->path) }}"/>
    @endif
    <meta name="description" content="{{ $lesson->description }}">
@endsection

@section('page_styles')
    <link href="{{ asset('css/daterangepicker.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="{{ asset('css/calendar.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="{{ asset('css/flatpickr.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <style type="text/css">
        .single-class {
            cursor: pointer;
        }

        .selected-class {
            background: #E74B65 !important;
            color: #fff !important;
        }

        li.non-bookable, li.non-bookable span {
            cursor: not-allowed;
        }

        .StripeElement {
            height: 40px;
            padding: 6px 12px 6px 28px;
        }

        .single-class-dates {
            cursor: pointer;
        }

        .class-times-menu li.single-class {
            padding-left: 30px;
        }

        li.single-class-dates > span.selected-date {
            width: 100%;
            cursor: pointer;
        }

        .active-date {
            border-top: 2px solid #E74B65;
            border-left: 2px solid #E74B65;
            border-right: 2px solid #E74B65;
        }

        .active-date ul.class-times-menu {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            display: block;
            z-index: 999 !important;
            border-bottom: 2px solid #E74B65;
            border-left: 2px solid #E74B65;
            border-right: 2px solid #E74B65;
            margin-left: -2px;
            margin-right: -2px;
        }

        .active-date ul.class-times-menu li {
            margin: 0 !important;
            z-index: 999 !important;
        }

    </style>

    @if($mobile)
        <style type="text/css">
            div#send-message-confirmation .modal-header {
                padding-bottom: 0 !important;
            }
        </style>
    @endif

@endsection

@section('content')

    <!-- starts : main container -->
    <div class="main-container advert p-t-0">

        <!-- starts: teacher profile -->
        <div class="preview-class ms">

            <!-- starts: tile + slider -->
            <div class="bg-color-01 shadow-v2" style="max-width: 1300px; margin: 0 auto;">
                <!-- starts: columns container -->
                <div class="containerr">
                    <div class="row m-0 lesson-banner">

                        <!-- starts: column right, bg-image -->
                        <div class="col-lg-8 col-lg-push-4 col-md-8 col-md-push-4 col-sm-6 col-sm-push-6"
                             style="padding-right: 0px; padding-left: 0px">
                            <!-- starts: Image slider -->
                            <div class="image-slider slider-all-controls controls-inside">
                                <ul class="slides">
                                    @foreach($lesson->images as $image)
                                        <li class="bg-image"
                                            style="background-image:url({{ Storage::url($image->path) }});">
                                            &nbsp;
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- End: Image -->
                            <div class="lesson-options">
                                <a href="javascript:void(0)" class=" icon-share copy-link"
                                   data-link="{{ route('page.lesson', $lesson->slug) }}"
                                   data-toggle="modal"
                                   data-target="{{  Auth::user() ? '#share-lesson-modal' : '#signup-modal' }}">
                                    <img class="share-icon" src="/img/icons/share-icon.png" height="17px"/>
                                    <span>Share</span>
                                </a>
                                <a href="javascript:void(0)" class=" like-btn" data-like="{{ $liked ? 1 : 0 }}">
                                    <i class="fa {{ $liked ? 'fa-heart' : 'fa-heart-o' }} tag-favourite"></i>
                                    <span>Save</span>
                                </a>
                            </div>
                        </div>
                        <!-- end: column right, bg-image -->

                        <!-- starts: column left -->
                        <div
                            class="col-lg-4 col-lg-pull-8 col-md-4 col-md-pull-8 p-b-20 p-b-sm-60 col-sm-6 col-sm-pull-6 shadow-v2 {{ $lesson->user->trusted ? 'trusted' : '' }}"
                            style="padding-right: 0px; padding-left: 0px">
                            <!-- starts: class tile -->
                            <div class="tile feature boxed">
                                <div class="row imgrow p-b-20 p-t-20">
                                    <div class="col-xs-6 col-md-6 col-lg-4 p-b-20 col-eq-height">
                                        <!-- starts: Image -->
                                        <div class="image image-circle tag-price profile-image-lesson"
                                             style="background-image: url({{ \App\Helpers\ClassHubHelper::getImagePath(null, $lesson->educator->photo) ?
            \App\Helpers\ClassHubHelper::getImagePath(null, $lesson->educator->photo) :
            asset('/img/profile-placeholder.jpg') }});">
                                        </div>
                                        <!-- End: Image -->
                                    </div>
                                    <div class="col-lg-1 p-b-20 col-eq-height"></div>
                                    <div class="col-xs-6 col-md-6 col-lg-7 p-b-20 col-eq-height"
                                         style="display: table;">
                                        <div style="display:table-cell; vertical-align: middle; word-break: break-word">
                                            <div class="fs-30 fw-6 uppercase  only-mobile"
                                                 style="font-size: 17px!important">{{ $lesson->name }}</div>
                                            <h5 class="m-b-0" style="margin-top: 30px">Provided by</h5>
                                            <a class="fw-6 fs-30"
                                               href="{{ route('page.educator', $lesson->user->slug) }}"
                                               style="color: #E74B65">{{ $lesson->user->name }}</a>

                                            <!-- starts: Rating -->
                                        @include('frontend.includes.rating', ['rating' => \App\Helpers\ClassHubHelper::ratings($lesson->ratings())])
                                        <!-- end: Rating -->
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 about-lesson-owner">
                                        <h5 class="m-b-0">About me</h5>
                                        <p class="lh-135 tutor-desc">
                                            {!! \App\Helpers\ClassHubHelper::excerpt($lesson->educator->bio) !!}
                                        </p>
                                    </div>
                                </div>

                                <a href="#class-dates"
                                   class="btn btn-primary m-0 float-right shadow-v4 price-btn">
      <span
          class="btn__text fs-25 fw-6">€{{ \App\Helpers\ClassHubHelper::centToEuro($lesson->price) }}
          <small
              class="fs-14"> {{ \App\Helpers\ClassHubHelper::lessonTypePriceText($lesson) }}</small></span>
                                </a>

                            </div>
                            <!-- end: class tile -->

                        </div>
                        <!-- end: column left -->
                    </div>
                </div>
                <!-- end: columns container -->


                <!-- starts: columns container -->
                <div class="container">

                    <!-- starts : description and availability -->
                    <div class="row des-avail p-t-42">

                        <!-- starts: description column left -->
                        <div class="col-md-4 description" style="z-index: 100 !important;">
                            <h1 class="fs-30 fw-6">{{ $lesson->name }}</h1>
                            <div class="subtitle p-b-10">
                                <span>  {{ $lesson->category->type === 'Grinds' ? $lesson->category->name.' - ' : '' }}</span>
                                <span class="fw-4">Pre-recorded classes</span>
                            </div>
                            <div class="info">
                                <h5 class="m-b-0">Description</h5>
                                {!! \App\Helpers\ClassHubHelper::charsExcerpt($lesson->description) !!}
                            </div>
                            <!-- starts : lists -->
                            <div class="lists v1">
                                <!-- start : 04 list -->
                                <div class="list v2">
                                    <h5 class="m-b-0">Suitable Ages</h5>
                                    <ul>
                                        <li class="ages">{{ $lesson->age_from }} - {{ $lesson->age_to }} years old</li>
                                    </ul>
                                </div>
                                <!-- end : 04 list -->
                            </div>
                            <!-- end : lists -->
                            <!-- starts : lists -->
                            <!-- start : 04 list -->
                          </div>
                          <div class="col-md-8 description" style="z-index: 100 !important;">
                            <div class="class-availability" id="class-dates">
                                <div class="form-group m-form__group" style="margin-top: 20px">
                                    <div id="lesson-videos">
                                        <div
                                            class="flex-vertical-center text-center p-r-35 p-l-35 p-t-34 p-b-34">
                                            <div class="spinner"></div>
                                            <br><br>
                                            <div class="text-center">Loading Videos, Please wait...</div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- end : 04 list -->
                        </div>
                        <!-- end: description column left -->

                    </div>

                    <!-- end : description and availability -->

                </div>
                <!-- end: columns container -->
            </div>
            <!-- emd: tile + slider -->


        </div>
        <!-- end: teacher profile -->


    </div>
    <!-- end : main container -->


    @include('frontend.modals.report-lesson')

    @include('frontend.modals.share-lesson')

    @include('frontend.modals.confirm-card')

    @include('common.send-message-modal')

    @include('frontend.modals.schedule-video-call', ['name' => $lesson->user->name])

    @include('common.send-message-success')

    @include('common.booking-confirmed', ['lesson' => $lesson])

@endsection


@section('page_scripts')
    <script src="{{ asset('js/flatpickr.js') }}"></script>

    @if($lesson->type === 'pre_recorded')
        <script type="text/javascript">

            $(function () {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('lesson.videos') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        lesson_id: '{{ $lesson->id }}',
                        col_class: 6
                    },
                    dataType: 'html',
                    success: function (data) {
                        $('div#lesson-videos').html(data)
                    },
                    error: function (data) {
                        $('div#lesson-videos').html(data)
                    }
                })


                $('body').on('click', 'a.like-btn', function () {
                    var _this = $(this)
                    var liked = $(this).children('i').hasClass('fa-heart')
                    var route = liked ? '{{ route('unlike.lesson', $lesson->id) }}' :
                        '{{ route('like.lesson', $lesson->id) }}'

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
                                $('a.signup-modal')[1].click()
                            }
                        },
                        error: function (data) {
                            $('div.w1-modal-content').html(data.messages.join('<br>'))
                            $('a.modal-trigger-1')[0].click()
                        }

                    })
                })

                $('body').on('click', 'button.share-lesson-btn', function () {

                    $('div#share-lesson-modal').modal('hide')
                    $(resultModal).modal('show')

                    var id = $(this).data('lesson-id')
                    var route = $(this).data('share-route')

                    $.ajax({
                        type: 'POST',
                        url: route,
                        data: {
                            _token: '{{ csrf_token() }}',
                            share_email: $('input#share-email').val(),
                            lesson_id: id
                        },
                        dataType: 'json',
                        success: function (data) {
                            console.log(data)
                            if (data.status) {
                                $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                            } else {
                                $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                            }
                        },
                        error: function (data) {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    })
                })

            })

        </script>
    @endif


    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Course",
          "name": "{{ addslashes($lesson->name) }}",
          "description": "{{ addslashes($lesson->description) }}",
          "contentLocation": "Dublin",
          "provider": {
            "@type": "Organization",
            "name": "Classhub",
            "sameAs": "https://classhub.ie"
          }
        }





    </script>

@endsection
