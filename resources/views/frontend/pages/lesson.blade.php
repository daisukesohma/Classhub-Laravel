@extends('frontend.layouts.master')

@section('title')
    Online  {{ $lesson->name }} | Classhub
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
    @if($lesson->type === 'pre_recorded')
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
                                            <div
                                                style="display:table-cell; vertical-align: middle; word-break: break-word">
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
                                    @if($lesson->type === 'pre_recorded')
                                        <span class="fw-4">Pre-recorded classes</span>
                                    @else
                                        <span
                                            class="fw-4">{{ $lesson->type == 'single' ? 'Single Class' : ucfirst($lesson->type).' of classes' }}</span>
                                    @endif
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
                                            <li class="ages">{{ $lesson->age_from }} - {{ $lesson->age_to }} years old
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- end : 04 list -->
                                </div>
                                <!-- end : lists -->
                                <!-- starts : lists -->
                                <!-- start : 04 list -->
                                <div class="class-availability" id="class-dates">
                                    @if ( $lesson->type === 'single' )
                                        <h5 class="p-b-0" style="margin-bottom: 0">Class Availability</h5>
                                        <span class="subtitle">Choose a date to see available times</span>
                                        <ul class="lesson-dates">
                                            @foreach($groupClasses as $key => $classes)
                                                <li class="term-dates single-class-dates">
                                                 <span
                                                     class="selected-date">{{ \Carbon\Carbon::parse($key)->format('l jS, F Y')
                                                     }}</span>

                                                    <ul class="class-times-menu">
                                                        @foreach($classes as $class)
                                                            <li class="term-dates single-class
                                                        {{  $class->is_bookable ? 'single-class-bookable' :
                                                        'non-bookable' }}"
                                                                data-id="{{ $class->id }}">
                                                            <span
                                                                class="date">{{ \Carbon\Carbon::parse($class->date)->format('l jS, F Y') }}</span>
                                                                <span class="time">
                                                {{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }}
                                                                    -
                                                                    {{ \Carbon\Carbon::parse($class->end_time)->format('H:i') }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <h5 class="p-b-0" style="margin-bottom: 0">How to view pre-recorded classes</h5>

                                        @if($lesson->type === 'pre_recorded')
                                            <span
                                                class="subtitle">Click ‘Buy now’ to purchase all pre-recorded classes, then view them by clicking on the one you want</span>
                                        @endif

                                    @endif

                                </div>
                                <!-- end : 04 list -->
                            </div>
                            <!-- end: description column left -->

                            <!-- starts: Availability column right -->
                            <div class="col-md-8 location-column" style="z-index: 99 !important;">

                                @if($lesson->place)
                                    @if($lesson->place == 'online')
                                        <div class="fs-30 fw-6" style="margin-bottom: 0">Online Classes</div>
                                        <div class="travel-icon">
                                            <img src="/img/icons/online-class.png"/>
                                        </div>

                                    @endif
                                @endif
                                @if($lesson->type === 'pre_recorded')
                                    <div class="fs-30 fw-6" style="margin-bottom: 0">My Videos</div>
                                    <br>
                                    <div class="form-group m-form__group" style="margin-top: 20px">
                                        @if(Auth::user())
                                            @if(in_array($lesson->id,Auth::user()->bookings->pluck('lesson_id')->toArray()))
                                                <div id="lesson-videos">
                                                    <div
                                                        class="flex-vertical-center text-center p-r-35 p-l-35 p-t-34 p-b-34">
                                                        <div class="spinner"></div>
                                                        <br><br>
                                                        <div class="text-center">Loading Videos, Please wait...</div>
                                                    </div>
                                                </div>
                                            @else
                                                @foreach($lesson->classes as $class)
                                                    <img src="/img/video-state-logged-in.png"
                                                         alt="logged in placeholder"
                                                         style="margin-bottom: 20px">
                                                @endforeach
                                            @endif

                                        @else
                                            <img src="/img/video-state-logged-out.png" alt="logged out placeholder"
                                                 style="margin-bottom: 20px">
                                        @endif
                                    </div>
                                @endif
                            </div>

                        </div>

                        <!-- end : description and availability -->
                        <div class="row" style="z-index: 99 !important;">
                            <div class="col-md-4 location-column">
                                <div class="contact-me" style="padding: 12px 0px 0px">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <a href="javascript:;"
                                               {{
                                                 Auth::user() ?
                                                 ' data-toggle=modal data-target=#send-message-modal data-recipient-id='.$lesson->user->id :
                                                 ' data-toggle=modal data-target=#login-modal'
                                               }}
                                               class="btn btn-primary shadow-v4 contact-btn {{ Auth::user() ? 'send-message-btn' : '' }}"
                                               style="white-space: inherit;">
                                                <span class="btn__text">Message me</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 location-column">
                                <!-- end : lists -->
                            @if($bookable)
                                <!-- starts : Book now button + Payment summary overlay -->
                                    <div class="modal-container">
                                        @if(!Auth::user() || (Auth::user() && !in_array($lesson->id,Auth::user()->bookings->pluck('lesson_id')->toArray())))
                                            <a href="javascript:void(0)" style="width:100%" class="btn btn-primary shadow-v4 m-t-12 p-l-64 p-r-64
                                        {{  Auth::user() ? 'book-now-btn' : 'greyBg'  }}"
                                               {{ !Auth::user() ? 'data-toggle=modal data-target=#login-modal' :
                                               'data-toggle=modal data-target=#payment-summary' }} id="cta-book">
                                                @if($lesson->type === 'pre_recorded')
                                                    <span class="btn__text">BUY NOW</span>
                                                @else
                                                    <span class="btn__text">BOOK NOW</span>
                                                @endif
                                            </a>
                                        @endif
                                    </div>
                                    <!-- end : Book now button + Payment summary overlay -->
                                @else
                                    <a href="#" style="width:100%"
                                       class="btn btn-primary shadow-v4 m-t-12 p-l-64 p-r-64 disabled greyBg">
                                        <span class="btn__text">BOOK NOW</span>
                                    </a>
                                @endif
                            <!-- starts: report class -->
                                @if(!in_array($lesson->id, $reportedLessons))
                                    <div class="report-this">
                                        <div class="modal-container">
                                            <a href="javascript:void(0)"
                                               data-toggle="modal"
                                               data-target="{{  Auth::user() ? '#report-lesson-modal' : '#login-modal' }}">
                                                Report this Class</a>
                                        </div>
                                    </div>
                            @endif
                            <!-- end: report class -->
                            </div>
                        </div>

                    </div>
                    <!-- end: columns container -->
                </div>
                <!-- emd: tile + slider -->


            </div>
            <!-- end: teacher profile -->

            <!-- starts: all related classes list -->
            <div class="container classes-tiles">

                <!-- Starts: Tiles type 01 -->
                @if($relatedLessons->count())
                    <div class="row title-type-01">
                        <div class="col-sm-12">
                            <div class="title">You may also like</div>
                        </div>
                    </div>
            @endif
            <!-- Starts: Tiles type 01 -->

                <!-- Starts: Tiles type 01 -->
                <div class="row tiles-type-01">

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
                </div>
                <!-- End: Tiles type 01 -->


            </div>
            <!-- end: all related classes list -->

        </div>
        <!-- end : main container -->
    @else
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
                                            <div
                                                style="display:table-cell; vertical-align: middle; word-break: break-word">
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
                            <div class="col-md-6 description" style="z-index: 100 !important;">
                                <h1 class="fs-30 fw-6">{{ $lesson->name }}</h1>
                                <div class="subtitle p-b-10">
                                    <span>  {{ $lesson->category->type === 'Grinds' ? $lesson->category->name.' - ' : '' }}</span>
                                    @if($lesson->type === 'pre_recorded')
                                        <span class="fw-4">Pre-recorded classes</span>
                                    @else
                                        <span
                                            class="fw-4">{{ $lesson->type == 'single' ? 'Single Class' : ucfirst($lesson->type).' of classes' }}</span>
                                    @endif
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
                                            <li class="ages">{{ $lesson->age_from }} - {{ $lesson->age_to }} years old
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- end : 04 list -->
                                </div>
                                <!-- end : lists -->
                                <!-- starts : lists -->
                                <!-- start : 04 list -->
                                <div class="class-availability" id="class-dates">
                                    @if ( $lesson->type === 'single' )
                                        <h5 class="p-b-0" style="margin-bottom: 0">Class Availability</h5>
                                        <span class="subtitle">Choose a date to see available times</span>
                                        <ul class="lesson-dates">
                                            @foreach($groupClasses as $key => $classes)
                                                <li class="term-dates single-class-dates">
                                                 <span
                                                     class="selected-date">{{ \Carbon\Carbon::parse($key)->format('l jS, F Y')
                                                     }}</span>

                                                    <ul class="class-times-menu">
                                                        @foreach($classes as $class)
                                                            <li class="term-dates single-class
                                                        {{  $class->is_bookable ? 'single-class-bookable' :
                                                        'non-bookable' }}"
                                                                data-id="{{ $class->id }}">
                                                            <span
                                                                class="date">{{ \Carbon\Carbon::parse($class->date)->format('l jS, F Y') }}</span>
                                                                <span class="time">
                                                {{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }}
                                                                    -
                                                                    {{ \Carbon\Carbon::parse($class->end_time)->format('H:i') }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>

                                    @endif

                                </div>
                                <!-- end : 04 list -->
                            </div>
                            <!-- end: description column left -->

                            <!-- starts: Availability column right -->
                            <div class="col-md-6 location-column" style="z-index: 99 !important;">

                                @if($lesson->place)

                                    @if($lesson->place == 'online')
                                        <div class="fs-30 fw-6" style="margin-bottom: 0">Online Classes</div>
                                        <div class="travel-icon">
                                            <img src="/img/icons/online-class.png"/>
                                        </div>
                                    @elseif($lesson->place == 'tutor')
                                        <div class="fs-30 fw-6" style="margin-bottom: 0">Location</div>
                                        <span class="subtitle"
                                              style="padding: 10px 0px">This class is located at: {{ $lesson->location }}</span>
                                        <!-- starts: map -->
                                        <div id="map" style="margin-right: 100px"></div>
                                        <!-- end: map -->
                                        @if($lesson->place == 'student')
                                            <div class="alternative-travel">
                                    <span class="subtitle">Alternatively, I can travel to:
                                        @if($lesson->user->areas->where('id',1)->first())
                                            <span style="color: #E74B65">All Dublin</span>
                                        @else
                                            <span style="color: #E74B65">{{ implode(' - ', $lesson->user->areas->where
                                            ('id', '!=', 1)->pluck('address')->toArray()) }}
                                                </span>
                                        @endif
                                    </span>
                                            </div>
                                        @endif

                                    @else
                                        <div class="fs-30 fw-6" style="margin-bottom: 0">Areas I cover</div>
                                        @if($lesson->areas->where('id',1)->first())
                                            <span> All Dublin</span>
                                        @else
                                            <span> {{ implode(' - ', $lesson->areas->where
                                            ('id', '!=', 1)->pluck('address')->toArray()) }}
                                                </span>
                                        @endif
                                        <br><span>I can travel to you. Feel free to contact me below.</span>
                                        <div class="travel-icon">
                                            <img src="/img/icons/car.png"/>
                                        </div>

                                    @endif
                                @else
                                    @if($lesson->travel_to_tutor)
                                        <div class="fs-30 fw-6" style="margin-bottom: 0">Location</div>
                                        <span class="subtitle"
                                              style="padding: 10px 0px">This class is located at: {{ $lesson->location }}</span>
                                        <!-- starts: map -->
                                        <div id="map" style="margin-right: 100px"></div>
                                        <!-- end: map -->
                                        @if($lesson->travel_to_student)
                                            <div class="alternative-travel">
                                    <span class="subtitle">Alternatively, I can travel to:
                                        @if($lesson->user->areas->where('id',1)->first())
                                            <span style="color: #E74B65">All Dublin</span>
                                        @else
                                            <span style="color: #E74B65">{{ implode(' - ', $lesson->user->areas->where
                                            ('id', '!=', 1)->pluck('address')->toArray()) }}
                                                </span>
                                        @endif
                                    </span>
                                            </div>
                                        @endif

                                    @else
                                        <div class="fs-30 fw-6" style="margin-bottom: 0">Areas I cover</div>
                                        @if($lesson->areas->where('id',1)->first())
                                            <span> All Dublin</span>
                                        @else
                                            <span> {{ implode(' - ', $lesson->areas->where
                                            ('id', '!=', 1)->pluck('address')->toArray()) }}
                                                </span>
                                        @endif
                                        <br><span>I can travel to you. Feel free to contact me below.</span>
                                        <div class="travel-icon">
                                            <img src="/img/icons/car.png"/>
                                        </div>

                                    @endif
                                @endif
                            </div>

                        </div>

                        <!-- end : description and availability -->
                        <div class="row" style="z-index: 99 !important;">
                            <div class="col-md-6 col-md-push-6 location-column">
                                <div class="contact-me" style="padding: 12px 0px 0px">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <a href="javascript:;"
                                               {{
                                                 Auth::user() ?
                                                 ' data-toggle=modal data-target=#send-message-modal data-recipient-id='.$lesson->user->id :
                                                 ' data-toggle=modal data-target=#login-modal'
                                               }}
                                               class="btn btn-primary shadow-v4 contact-btn {{ Auth::user() ? 'send-message-btn' : '' }}"
                                               style="white-space: inherit;">
                                                <span class="btn__text">Message me</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-md-pull-6 location-column">
                                <!-- end : lists -->
                            @if($bookable)
                                <!-- starts : Book now button + Payment summary overlay -->
                                    <div class="modal-container">
                                        <a href="javascript:void(0)" style="width:100%" class="btn btn-primary shadow-v4 m-t-12 p-l-64 p-r-64
                                        {{  Auth::user() ? 'book-now-btn' : 'greyBg'  }}"
                                           {{ !Auth::user() ? 'data-toggle=modal data-target=#login-modal' :
                                           'data-toggle=modal data-target=#payment-summary' }} id="cta-book">
                                            @if($lesson->type === 'pre_recorded')
                                                <span class="btn__text">BUY NOW</span>
                                            @else
                                                <span class="btn__text">BOOK NOW</span>
                                            @endif
                                        </a>
                                    </div>
                                    <!-- end : Book now button + Payment summary overlay -->
                                @else
                                    <a href="#" style="width:100%"
                                       class="btn btn-primary shadow-v4 m-t-12 p-l-64 p-r-64 disabled greyBg">
                                        <span class="btn__text">BOOK NOW</span>
                                    </a>
                                @endif
                            <!-- starts: report class -->
                                @if(!in_array($lesson->id, $reportedLessons))
                                    <div class="report-this">
                                        <div class="modal-container">
                                            <a href="javascript:void(0)"
                                               data-toggle="modal"
                                               data-target="{{  Auth::user() ? '#report-lesson-modal' : '#login-modal' }}">
                                                Report this Class</a>
                                        </div>
                                    </div>
                            @endif
                            <!-- end: report class -->
                            </div>
                        </div>

                    </div>
                    <!-- end: columns container -->
                </div>
                <!-- emd: tile + slider -->


            </div>
            <!-- end: teacher profile -->

            <!-- starts: all related classes list -->
            <div class="container classes-tiles">

                <!-- Starts: Tiles type 01 -->
                @if($relatedLessons->count())
                    <div class="row title-type-01">
                        <div class="col-sm-12">
                            <div class="title">You may also like</div>
                        </div>
                    </div>
            @endif
            <!-- Starts: Tiles type 01 -->

                <!-- Starts: Tiles type 01 -->
                <div class="row tiles-type-01">

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
                </div>
                <!-- End: Tiles type 01 -->


            </div>
            <!-- end: all related classes list -->

        </div>
        <!-- end : main container -->
    @endif

    <!-- starts: include overlay payment summary -->
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

    @include('frontend.modals.report-lesson')

    @include('frontend.modals.share-lesson')

    @include('frontend.modals.confirm-card')

    @include('common.send-message-modal')

    @include('frontend.modals.schedule-video-call', ['name' => $lesson->user->name])

    @include('common.send-message-success')

    @include('common.booking-confirmed', ['lesson' => $lesson])


@endsection


@section('page_scripts')
    <script src="https://player.vimeo.com/api/player.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
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
                        col_class: 12
                    },
                    dataType: 'html',
                    success: function (data) {
                        $('div#lesson-videos').html(data)
                        @if(Auth::user() && !in_array($lesson->id,Auth::user()->bookings->pluck('lesson_id')->toArray()))
                        initVideoPlayers()
                        @endif
                    },
                    error: function (data) {
                        $('div#lesson-videos').html(data)
                    }
                })
            })

            function initVideoPlayers() {
                var videoPlayers = []
                var iframes = document.querySelectorAll('div#lesson-videos iframe')

                iframes.forEach(iframe => {
                    let player = new Vimeo.Player(iframe)
                    videoPlayers.push(player)
                })

                videoPlayers.forEach(player => {
                    player.on('play', function () {
                        console.log('Video Played')
                    })

                    player.on('timeupdate', function (result) {
                        if (result.seconds > 30) {
                            player.pause().then(function () {
                                player.setCurrentTime(0)
                            })
                        }
                    })

                })

            }

        </script>
    @endif


    <script type="text/javascript">

        function initMap() {

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: {lat: -34.397, lng: 150.644}
            });

            var geocoder = new google.maps.Geocoder();
            var address = '{{ $lesson->location }}';
            var eirocode = '{{ $lesson->eircode }}';
            var image = '/img/classhub-marker.png';


            geocoder.geocode({
                //'address': address,
                'componentRestrictions': {'postalCode': eirocode, 'country': 'IE'}
            }, function (results, status) {
                if (status === 'OK') {
                    map.setCenter(results[0].geometry.location);

                    var marker = new google.maps.Marker({
                        map: map, icon: image,
                        position: results[0].geometry.location
                    });
                } else {
                    console.log('Geocode was not successful for the following reason: ' + status);
                }
            })
        }
    </script>

    <script type="text/javascript">

        var sendMessageModal = $('div#send-message-modal')
        var sendMessageSuccess = $('div#send-message-confirmation');

        // Class type
        var classType = '{{ $lesson->type }}'

        // Selected classes and dates for SINGLE class
        var selectedClasses = []

        $(function () {

            $('input.schedule-time-picker').flatpickr({
                enableTime: true,
                dateFormat: "d-m-Y H:i",
                minDate: "{!! date('d-m-Y H:i') !!}"
            })

            if (classType === 'single') {
                $('a#cta-book').addClass('disabled')
            }

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

            $('body').on('click', 'a.schedule-call-btn', function () {
                $(resultModal).modal('show')
                $.ajax({
                    type: 'POST',
                    url: '{{ route('schedule.call') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        time: $('input[name="video_call_time"]').val(),
                        text: 'Hi there, I would like to schedule a video call for:',
                        recipient_id: '{{ $lesson->user->id }}',
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

            // Handle class time select event for SINGLE class
            $('body').on('click', 'li.single-class-bookable', function () {
                if (classType === 'single') {
                    let classId = $(this).data('id')

                    // Add to selected class
                    if (selectedClasses.indexOf(classId) === -1) {
                        selectedClasses.push(classId)
                        $(this).addClass('selected-class')
                    } else {
                        $(this).removeClass('selected-class')
                        selectedClasses = selectedClasses.filter(function (item) {
                            return item !== classId
                        })
                    }

                    if (selectedClasses.length) {
                        $('a#cta-book').removeClass('disabled')
                    } else {
                        $('a#cta-book').addClass('disabled')
                    }

                    console.log(selectedClasses)
                }
            })

        }) // End Document ready

        // Lesson liked/unlike
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


        $('body').on('click', 'a.book-now-btn', function () {

            if (classType == 'single' && selectedClasses.length == 0) {
                $(resultModal).modal('show')
                $(resultModal).find('div.modal-body').html('Please select Class date and time')
                return false;
            }

            if ('{{ $lesson->user_id }}' == '{{ Auth::user() ? Auth::user()->id : 0 }}') {
                $(resultModal).modal('show')
                $(resultModal).find('div.modal-body').html('You are not allowed to book your class')
                return false;
            }

            console.log('book')

            $.ajax({
                type: 'GET',
                url: '{{ route('booking.modal.payment.summary') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    lesson_id: '{{$lesson->id}}',
                    class_ids: selectedClasses
                },
                dataType: 'HTML',
                success: function (data) {
                    $('div#payment-summary').modal('show');
                    $('div#payment-summary').find('div.modal-body').html(data)
                },
                error: function (data) {
                    $('div#payment-summary').modal('show');
                    $('div#payment-summary').find('div.modal-body').html(data)
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

        $('form#reported-lesson-form').on('submit', function (e) {

            $('div#report-lesson-modal').modal('hide')
            $(resultModal).modal('show')

            e.preventDefault()
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: 'json',
                success: function (data) {
                    console.log(data)
                    if (data.status) {
                        $('div#result-modal').find('div.modal-body').html(data.messages.join('<br>'))
                    } else {
                        $('div#result-modal').find('div.modal-body').html(data.messages.join('<br>'))
                    }
                },
                error: function (data) {
                    $('div#result-modal').find('div.modal-body').html(data.messages.join('<br>'))
                }
            })
        })

        $('div#share-lesson-modal').on('hidden.bs.modal', function () {
            $(this).find('div#result').html('')
            $(this).find('div#error').html('')
        })

        $(document).ready(function () {
            $("#result-modal").click(function () {
                $("#payment-summary").removeClass("show");
            });
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
            $('[data-toggle="popover"]').popover()

            $('li.single-class-dates > span.selected-date').on('click', function () {

                if ($(this).parents('li.single-class-dates').next().length == 0) {
                    $('ul.lesson-dates').animate({
                        scrollTop: $('ul.lesson-dates').prop('scrollHeight')
                    }, 'fast')
                }

                if ($(this).parents('li.single-class-dates').hasClass('active-date')) {
                    // $(this).removeClass('active-date')
                    $('li.single-class-dates').removeClass('active-date')

                } else {
                    $('li.single-class-dates').removeClass('active-date')
                    $(this).parents('li.single-class-dates').addClass('active-date')
                }
            })
        })

    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&callback=initMap"
            async defer></script>

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
