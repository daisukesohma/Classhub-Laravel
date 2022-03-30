@extends('parent.layouts.master')


@section('title')
    Classhub | My Bookings
@endsection


@section('page_style')

@endsection

@section('content')

    <!-- starts : main container -->
    <div class="main-container footer-stay-btm" style="padding-top: 30px"> {{----}}

        <!-- starts: fav-tutors tiles container -->
        <div class="container fav-tutors">


            <!-- Starts: Tiles type 01 -->
            <div class="row title-type-01 fav-select-links show-link-select">
                <div class="col-sm-12">
                    <div class="title p-t-12">MY FAVOURITES TUTORS <i class="flaticon-black"></i></div>
                    @if($educators->count())
                        <a href="{{ route('parent.favourite.educators') }}" class="link-select link-01">See All</a>
                    @endif
                </div>
            </div>
            <!-- Starts: Tiles type 01 -->

            <!-- Starts: Tiles type 02 -->
            <div class="row tiles-type-02 fav-select show-fav checkbox-v1">
                @if( !$educators->count() )
                    <div class="emptyState">
                        <h4 class="text-center p-t-60 p-b-60">You have no favourite tutors</h4>
                    </div>
                @else
                    @foreach($educators as $educator)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="image-tile  col-eq-height {{ $educator->trusted ? 'trusted' : '' }}">
                                <!-- starts : fav + select -->
                                <div class="toggle-fav-select">
                                    <div class="fav"><i class="flaticon-black"></i></div>
                                    <div class="select">
                                        <label
                                            class="m-checkbox m-checkbox--air m-checkbox--solid m-checkbox--state-brand">
                                            <input type="checkbox">
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <!-- end : fav + select -->
                                <div class="profile-image-lesson"
                                     style="background-image: url({{ \App\Helpers\ClassHubHelper::getImagePath(null, $educator->educator->photo) }});">
                                </div>
                                <div class="tile-details tutor-details">
                                    <div class="name">{{ $educator->name }}</div>
                                    <div class="tutor-subjects color-02">
                                        {{ implode(', ', $educator->categories()->whereNull('parent_id')->pluck('name')->toArray()) }}
                                    </div>
                                    <!-- starts: Rating -->
                                @include('frontend.includes.rating', ['rating' => \App\Helpers\ClassHubHelper::ratings($educator->ratings)])
                                <!-- end: Rating -->
                                    <div class="text text-center fs-13 tutor-description">
                                        {{ \App\Helpers\ClassHubHelper::excerpt($educator->bio, 10, false, false) }}
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-6 details-section">
                                            <h5 class="detail-title">Classes:</h5>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6 details-section">
                                            <span
                                                class="detail-result">{{ $educator->lessons()->liveClass()->count()  }}</span>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6 details-section">
                                            <h5 class="detail-title">Base Price:</h5>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6 details-section">
                                            <span class="detail-result">€{{ $educator->base_price }} p/hr</span>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-6 details-section">
                                            <h5 class="detail-title">Location:</h5>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6 details-section" style="height: 60px;">
                                            <span class="detail-result">{{ $educator->locations}}</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <!-- End: Tiles type 02 -->

            <!-- Starts: bottom button -->
            @if($educators->count())
                <div class="row showmore p-t-72 p-b-22">
                    <div class="col-sm-12 text-center">
                        <a href="{{ route('parent.favourite.educators') }}" class="btn btn-primary shadow-v4">
                            <span class="btn__text">SEE ALL</span>
                        </a>
                    </div>
                </div>
        @endif
        <!-- End: bottom button -->

        </div>
        <!-- End:  fav-tutors tiles container -->


        <!-- starts: fav-classes tiles container -->
        <div class="container fav-classes">

            <!-- Starts: Tiles type 01 -->

            <div class="row title-type-01 fav-select-links show-link-select">
                <div class="col-sm-12">
                    <div class="title p-t-12">MY FAVOURITES CLASSES <i class="flaticon-black"></i></div>
                    @if($lessons->count())
                        <a href="{{ route('parent.favourite.lessons') }}" class="link-select link-01">See All</a>
                    @endif

                </div>
            </div>
            <!-- Starts: Tiles type 01 -->

            <!-- Starts: Tiles type 01 -->
            <div class="row tiles-type-01 fav-select show-fav checkbox-v1">
                @if(!$lessons->count())
                    <div class="emptyState">
                        <h4 class="text-center p-t-60 p-b-60">You have no favourite classes</h4>
                    </div>
                @else
                    @foreach($lessons as $lesson)
                    <!-- starts : tile 01 -->
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="image-tile outer-title col-eq-height" style="padding-top: 0">

                                <!-- starts : fav + select -->
                                <div class="toggle-fav-select">
                                    <div class="fav"><i class="flaticon-black"></i></div>
                                    <div class="select">
                                        <label
                                            class="m-checkbox m-checkbox--air m-checkbox--solid m-checkbox--state-brand">
                                            <input type="checkbox">
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <!-- end : fav + select -->

                                <a href="javascript:;">
                                    <img alt="Pic" class="product-thumb"
                                         src="{{ $lesson->images->count() ? Storage::url($lesson->images->first()->path)
                             : 'https://dummyimage.com/460x320/000/fff' }}"
                                         style="object-fit: cover; width: 100%; height: 190px"
                                    />
                                </a>

                                <div class="tile-details">
                                    <div class="location fw-4">
                                        {{ $lesson->location ? $lesson->location : $lesson->areas->first()->address }}
                                    </div>
                                    <div class="name fw-4">{{ $lesson->name }}</div>
                                    <div class="provideby">Provided by <b>{{ optional($lesson->user)->name }}</b></div>
                                    <!-- starts: Rating -->
                                @if(!$lesson->ratings()->isEmpty())
                                    @include('common.rating-v2',
                                        ['rating' => \App\Helpers\ClassHubHelper::ratings($lesson->ratings())])
                                @endif
                                <!-- end: Rating -->
                                    <!-- starts: price + button -->
                                    <div class="price">
                                        <!-- starts: button -->
                                        <a href="{{ route('page.lesson', $lesson->slug) }}" class="btn btn-primary">
                                            <span class="btn__text uppercase">book now</span>
                                        </a>
                                        <!-- end: button -->
                                        <div><strong><span>{{ $lesson->display_price }} </span></strong>
                                            {{ \App\Helpers\ClassHubHelper::lessonTypePriceText($lesson) }}
                                        </div>
                                    </div>
                                    <!-- end: price + button -->
                                </div>
                            </div>
                        </div>
                        <!-- end : tile 01 -->
                    @endforeach
                @endif


            </div>
            <!-- End: Tiles type 01 -->

            <!-- Starts: bottom button -->
            @if($lessons->count())
                <div class="row showmore p-t-72 p-b-22">
                    <div class="col-sm-12 text-center">
                        <a href="{{ route('parent.favourite.lessons') }}" class="btn btn-primary shadow-v4">
                            <span class="btn__text">SEE ALL</span>
                        </a>
                    </div>
                </div>
        @endif
        <!-- End: bottom button -->

        </div>
        <!-- End: fav-classes tiles container -->


    </div>
    <!-- end : main container -->


@endsection

@section('page_scripts')
    <script src="{{ asset('js/jquery-match-height-master/jquery.matchHeight-min.js') }}"></script>

    <script type="text/javascript">
        $(function () {
            $(".col-eq-height").matchHeight();
        })
    </script>

@endsection
