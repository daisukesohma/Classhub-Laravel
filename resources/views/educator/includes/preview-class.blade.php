<!-- starts: teacher profile -->
<div class="preview-class ms">
    <!-- starts: tile + slider -->
    <div class="bg-color-01 shadow-v2" style="max-width: 1300px; margin: 0 auto; padding: 10px">
        <!-- starts: columns container -->
        <div class="containerr">
            <div class="row m-0">

                <!-- starts: column right, bg-image -->
                <div class="col-lg-8 col-lg-push-4 col-md-8 col-md-push-4 col-sm-6 col-sm-push-6 col-eq-height"
                     style="padding-right: 0px; padding-left: 0px">
                    <!-- starts: Image slider -->
                    <div class="image-slider slider-all-controls controls-inside">
                        <ul class="slides">
                            @foreach($images as $image)
                                <li class="bg-image"
                                    style="background-image:url('{{ \App\Helpers\ClassHubHelper::getImagePath($image) }}')">
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- End: Image -->
                    <div class="lesson-options">
                        <a href="#" class=" icon-share copy-link">
                            <img class="share-icon" src="/img/icons/share-icon.png" height="17px"/>
                            <span>Share</span>
                        </a>
                        <a href="#" class=" like-btn">
                            <i class="fa fa-heart tag-favourite"></i>
                            <span>Save</span>
                        </a>
                    </div>
                </div>
                <!-- end: column right, bg-image -->

                <!-- starts: column left -->
                <div
                    class="col-lg-4 col-lg-pull-8 col-md-4 col-md-pull-8 p-b-20 col-sm-6 col-sm-pull-6 col-eq-height shadow-v2 {{ $lesson->user->trusted ? 'trusted' : '' }}"
                    style="padding-right: 0px; padding-left: 0px">
                    <!-- starts: class tile -->
                    <div class="tile feature boxed">

                        <div class="row imgrow p-b-20 p-t-20">
                            <div class="col-xs-12 col-md-12 col-lg-6 col-eq-height p-b-20">
                                <!-- starts: Image -->
                                <div class="image image-circle tag-price profile-image-lesson"
                                     style="background-image: url({{ \App\Helpers\ClassHubHelper::getImagePath(null, $lesson->educator->photo) ?
                            \App\Helpers\ClassHubHelper::getImagePath(null, $lesson->educator->photo) :
                            asset('/img/profile-placeholder.jpg') }});">
                                </div>
                                <!-- End: Image -->
                            </div>
                            <div class="col-xs-12 col-md-12 col-lg-6 col-eq-height p-b-20">
                                <div class="xs-vertical-center">
                                    <div class="p-t-12">Provided by</div>
                                    <a class="fw-6 link-01 fs-23"
                                       href="#">{{ Auth::user()->name }}</a>

                                    <!-- starts: Rating -->
                                @if(!Auth::user()->ratings->isEmpty())
                                    @include('frontend.includes.rating',
                                    ['rating' => \App\Helpers\ClassHubHelper::ratings(Auth::user()->ratings)])
                                @endif
                                <!-- end: Rating -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 about-lesson-owner">
                                <h5>About Me</h5>
                                <p class="lh-135">
                                    {!! \App\Helpers\ClassHubHelper::excerpt($lesson->educator->bio) !!}
                                </p>
                            </div>
                        </div>

                        <a href="#availabilityCalendar"
                           class="btn btn-primary btn-sm m-0 float-right shadow-v4 price-btn">
<span
    class="btn__text fs-25 fw-6">€{{ \App\Helpers\ClassHubHelper::centToEuro($lesson->price) }}
    <small
        class="p-l-14 fs-14"> {{ \App\Helpers\ClassHubHelper::lessonTypePriceText($lesson) }}</small></span>
                        </a>

                    </div>
                    <!-- end: class tile -->

                </div>
                <!-- end: column left -->
            </div>
        </div>
        <!-- end: columns container -->


        <!-- starts: columns container -->
        <div class="containerr">

            <!-- starts : description and availability -->
            <div class="row des-avail p-t-42">

                <!-- starts: description column left -->
                <div class="col-md-6 description">
                    <div class="fs-30 fw-4 uppercase">{{ $lesson->name }}</div>
                    <div class="subtitle p-b-10">
                        {{ $lesson->category->type === 'Grinds' ? $lesson->category->name : '' }}
                    </div>
                    <div class="info">
                        <h5>Description</h5>
                        {!! \App\Helpers\ClassHubHelper::excerpt($lesson->description) !!}
                    </div>
                    <!-- starts : lists -->
                    <div class="lists v1">
                        <!-- start : 04 list -->
                        <div class="list v2">
                            <h5>Suitable Ages</h5>
                            <ul>
                                <li class="ages">{{ $lesson->age_from }} - {{ $lesson->age_to }} years old</li>
                            </ul>
                        </div>
                        <!-- end : 04 list -->
                    </div>
                    <!-- end : lists -->
                    <!-- starts : lists -->
                    <!-- start : 04 list -->
                    <div class="class-availability">
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
                                                <li class="term-dates {{ $lesson->type == 'single' ? 'single-class' : '' }}
                                                {{ $lesson->type == 'single' && $class->bookable ? 'single-class-bookable' :
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
                            <h5 class="p-b-0" style="margin-bottom: 0">Class Schedule</h5>
                            <span
                                class="subtitle">Click ‘Book now’ to purchase a place in this {{ $lesson->type }}
                                of classes</span>
                            <div class="form-group m-form__group" style="margin-top: 20px">
                                <!--begin: Dropdown-->
                                <div class="m-dropdown m-dropdown--arrow c-dd-menu" m-dropdown-toggle="click"
                                     style="display: block !important;">
                                    <a id="" href="javascript:void(0)"
                                       style="display: block !important;"
                                       class="m-dropdown__toggle btn dropdown-toggle">See all classes in
                                        this {{ ucfirst($lesson->type) }}</a>
                                    <div class="m-dropdown__wrapper " style="z-index: 999 !important;">
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__body ">
                                                <div class="m-dropdown__content">
                                                    <div class="scrollable">
                                                        <ul class="lesson-dates term-classes"
                                                            style="margin: 0; height: auto">
                                                            @foreach($lessonClasses as $class)
                                                                <li class="term-dates"
                                                                    data-id="{{ $class->id }}">
                                                                            <span class="date">
                                                                                {{ \Carbon\Carbon::parse($class->date)->format('l jS, F Y') }}
                                                                            </span>
                                                                    <span class="time">
                                                                            {{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }}
                                                                        -
                                                                        {{ \Carbon\Carbon::parse($class->end_time)->format('H:i') }}
                                                                        </span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Dropdown-->
                            </div>

                        @endif

                    </div>

                </div>
                <!-- end: description column left -->

                <!-- starts: Availability column right -->
                <div class="col-md-6 location-column">
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
                <div class="col-md-6 location-column">

                    <!-- end : lists -->
                    <!-- starts : Book now button + Payment summary overlay -->
                    <div class="modal-container">
                        <a href="#" style="width:100%"
                           class="btn btn-primary shadow-v4 m-t-12 p-l-64 p-r-64 book-now-btn" id="cta-book">
                            <span class="btn__text">BOOK NOW</span>
                        </a>

                    </div>
                    <!-- starts: report class -->
                    <div class="report-this">
                        <div class="modal-container">
                            <a href="#">Report
                                this Class</a>
                        </div>
                    </div>
                    <!-- end: report class -->


                </div>
                <div class="col-md-6 location-column">

                    <div class="contact-me" style="padding-top: 12px">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <a href="#"

                                   class="btn btn-primary shadow-v4 contact-btn "
                                   style="white-space: inherit;">
                                    <span class="btn__text">Message me</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end: columns container -->
    </div>
    <!-- emd: tile + slider -->


</div>
<!-- end: teacher profile -->

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
            //'address' : address,
            'componentRestrictions':  { 'postalCode': eirocode, 'country': 'IE'}
        }, function (results, status) {
            if (status === 'OK') {
                map.setCenter(results[0].geometry.location);

                var marker = new google.maps.Marker({
                    map: map, icon: image,
                    position: results[0].geometry.location
                });
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        })
    }

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
        $('[data-toggle="popover"]').popover()

        $('li.single-class-dates > span.selected-date').on('click', function () {
            console.log(this)
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
