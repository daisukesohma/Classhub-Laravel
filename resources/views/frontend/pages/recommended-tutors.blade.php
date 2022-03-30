@extends('frontend.layouts.master')

@section('title')
    Classhub | Recomnended Tutors
@endsection

@section('content')

    <!-- Starts : Search Page, default search bar -->
    <section class="hero-img type-02 home-hero search-hero">

        <div class="container" style="z-index: 99">

            <div class="image-bg">

                <div class="row">
                    <div class="col-md-8">
                        <div class="box">
                            <h2>View Recommended Tutors Below</h2>
                        </div>
                    </div>
                </div>

                <div class="image-static background-image-holder"
                     style="background: url('/img/hero-images/female-tutor.jpg')">
                    <img alt="image" class="background-image" src="/img/hero-images/female-tutor.jpg"/>
                </div>

            </div>

            @include('frontend.includes.search-bar')

        </div>

        <div class="banner-slide image-slider"></div>

        <!--end of container-->
    </section>
    <!-- End : Search Page, default search bar -->

    <!-- starts: search-results tiles container -->
    <div class="container search-results" id="recommended-tutors">


        <!-- Starts: Tiles type 01 -->
        <div class="row title-type-01">
            <div class="col-sm-12">
                <div class="title p-b-10">RECOMMENDED TUTORS</div>
                {{--<div class="sub-title">Check out some of the most popular classes in your area</div>--}}
            </div>
        </div>
        <!-- Starts: Tiles type 01 -->


        <!-- Starts: Tiles type 02 -->
        <div class="row tiles-type-02 p-b-50">
            <div class="show-more-subject-tutors-container">
                <!-- starts : tile 01 -->
                @foreach($tutors as $user)

                    <div class="col-xs-12 col-md-3 col-sm-6">
                        <a href="{{ route('page.educator', $user->slug)  }}">

                            <div class="image-tile  col-eq-height {{ $user->trusted ? 'trusted' : '' }}">
                                <div class="profile-image-lesson"
                                     style="background-image: url({{  \App\Helpers\ClassHubHelper::getImagePath(null, $user->educator->photo) }});">
                                    <div class="price">
                                        @if($user->educator->base_price)
                                            <div class="price-dot">
                                                <span>€{{ $user->educator->base_price }}</span>
                                            </div>
                                            <span class="tutor-subjects color-02"> /hr</span>
                                        @else
                                            <div class="price-dot book-now-dot">
                                                <span>Book now</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="tile-details tutor-details" style="padding-bottom: 0px">

                                    <!-- starts: Rating -->
                                @include('frontend.includes.rating', ['rating' => \App\Helpers\ClassHubHelper::ratings($user->ratings)])
                                <!-- end: Rating -->
                                    <div class="name">{{ $user->name }}</div>
                                    <div class="tutor-subjects color-02">
                                        {{ implode(' - ', $user->educator->teaching_types) }}
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <?php
                                        $count = $user->lessons()->where('status', 'live')->where('type', '!=', 'subject')->get()
                                            ->filter(function ($lesson) {
                                                $firstClass = $lesson->classes->first();
                                                $lastClass = $lesson->classes->last();
                                                $classStartAt = \Carbon\Carbon::parse($firstClass->date . ' ' . $firstClass->start_time);
                                                $classEndAt = \Carbon\Carbon::parse($lastClass->date . ' ' . $lastClass->start_time);

                                                if ($lesson->type == 'single') {
                                                    $bookableClasses = $lesson->classes()->where('bookable', 1)->get();

                                                    return $lesson->status == 'live' && $bookableClasses->isNotEmpty() && $classEndAt->isFuture();
                                                } else {
                                                    return $lesson->status == 'live' && $lesson->bookable && $classStartAt->isFuture();
                                                }

                                            })->count();

                                        ?>
                                        @if($count)
                                            <div class="col-md-12 col-sm-12 col-xs-12 details-section">
                                                <h5 class="detail-title"
                                                    style="">Classes: </h5>
                                                <div class="text-left">{{ $count }}</div>
                                            </div>
                                        @endif
                                        <div class="col-md-12 col-sm-12 col-xs-12 details-section">
                                            <h5 class="detail-title"
                                                style="">Areas I Cover:</h5>
                                            <div class="text-left">{{ $user->locations}}</div>
                                        </div>
                                        {{--@if(isset($subjectName) && $subjectName)--}}
                                        <div class="col-md-12 col-sm-12 col-xs-12 details-section">
                                            <h5 class="detail-title">Subjects:</h5>
                                            <ul class="text-left">
                                                @foreach($user->categories as $subject)
                                                    @php $displayName = \App\Helpers\ClassHubHelper::getSubjectDisplayName($subject, $user->categories)  @endphp
                                                    @if($displayName)
                                                        <li>{{ $displayName }}</li>
                                                    @endif
                                                @endforeach
                                                {{--<li>{{ $subjectName }}</li>--}}
                                            </ul>
                                        </div>
                                        {{--@endif--}}
                                    </div>
                                </div>
                            </div>

                        </a>
                    </div>

                @endforeach
            <!-- end : tile 01 -->

                @if($tutors->nextPageUrl())
                    <div class="row showmore p-t-55 show-more-subject-tutors-button-container"
                         id="subject-tutors-more-link">
                        <div class="col-sm-12 text-center">
                            <a class="btn btn-primary shadow-v4 show-more-subject-tutors-button"
                               href="{{ $tutors->nextPageUrl() }}">
                                <span class="btn__text">SHOW MORE</span>
                            </a>
                        </div>
                    </div>
                @endif


            </div>
        </div>
        <!-- End: Tiles type 02 -->

    </div>
    <!-- End: search-results tiles container -->

@endsection

@section('page_scripts')
    <script src="{{ asset('js/flexslider.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/show-more-related.js') }}"></script>
    <script src="{{ asset('js/show-more-featured.js') }}"></script>
    <script src="{{ asset('js/show-more-subject-tutors.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            var fadeShow = $(".banner-slide").fadeShow({
                correctRatio: false,
                shuffle: false,
                speed: 5000,
                images: [
                    '{{ asset('img/hero-images/slider/after-school-classes-in-dublin.jpg') }}',
                    '{{ asset('img/hero-images/slider/after-school-tutors-in-dublin.jpg') }}',
                    '{{ asset('img/hero-images/slider/children-grinds-in-dublin.jpg') }}',
                    '{{ asset('img/hero-images/slider/dance-ballet-tutors.jpg') }}',
                    '{{ asset('img/hero-images/slider/dancing-lessons-for-children.jpg') }}',
                    '{{ asset('img/hero-images/slider/italian-language-tutors.jpg') }}',
                    '{{ asset('img/hero-images/slider/maths-tutor-in-dublin.jpg') }}'
                ]
            });
        });
    </script>
@endsection
