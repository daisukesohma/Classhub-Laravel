<!-- starts : teacher profile -->
<div class="profile-teacher {{ $user->trusted ? 'trusted' : '' }}">
    <div class="row">
        <!-- starts: column left -->
        <div class="col-lg-4 col-md-12 col-eq-height">
            <div class="profile feature shadow-v1 boxed">
                <div class="row" style="margin-bottom: 30px">
                    <div class="col-md-6" style="padding: 0 10px">
                        <div class="title fw-6 fs-30 text-sm-center" style="padding-left: 0">{{ $user->name }}</div>
                        <!-- starts: Rating -->
                    @include('frontend.includes.rating',
                    ['rating' => \App\Helpers\ClassHubHelper::ratings($user->ratings)])
                    <!-- end: Rating -->
                        <!-- starts: See reviews link + overlay -->
                        <div class="see-reviews text-sm-center">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#see-reviews"
                               class="link-01">See
                                reviews</a>
                        </div>
                        <!-- end: See reviews link + overlay -->

                    </div>

                    <div class="col-md-6" style="padding: 0 10px">
                        <!-- starts: Image -->
                        <div class="image">
                            <div class="profile-page-image"
                                 style="background-image: url({{ $photo ? $photo : asset('/img/profile-placeholder.jpg') }});">
                            </div>
                        </div>
                        <!-- End: Image -->
                    </div>
                </div>
                @if($user->educator->top_performer)
                    <div class="top-performer-profile">
                        <hr class="top-performer-line">
                        <div class="badge-outline-primary top-performer-badge">Top Performer</div>
                    </div>
                @endif
                <div class="row" style="margin-top: 50px">
                    <div class="col-md-6">
                        <!-- starts: price button -->
                        <a
                            class="btn btn-primary shadow-v4 contact-btn"
                            href="javascript:;" style="line-height: 35px"><span
                                class="btn__text v1 fw-6">{{ optional($user->educator)->base_price  ? '€'.$user->educator->base_price.' per hour' : 'Book Now'}}</span>
                        </a>
                        <!-- end: price button -->
                    </div>
                    <div class="col-md-6">
                        <!-- starts: share link + overlay -->
                        <div class="share-this">
                            <a href="javascript:;" class="link-01 btn icon-share copy-link" style="line-height: 26px">
                                <img class="share-icon" src="/img/icons/share-icon.png" height="17px"/>
                                <span>Share</span>
                            </a>
                        </div>
                        <!-- end: share link + overlay -->
                    </div>
                </div>

                <!-- About me -->
                <div class="row about-me" style="padding-top: 30px;">
                    <div class="col-md-12">
                        <h5 class="text-left m-b-0 fw-700 sub-heading">About Me</h5>
                        <p class="lh-135 text-left m-b-0">
                            {!! \App\Helpers\ClassHubHelper::excerpt($bio) !!}
                        </p>
                    </div>
                </div>
                <!-- end: About me -->
                <hr class="red-line">
                <!-- Teaching Type -->
                <div class="row teaching-type">
                    <div class="col-md-12">
                        <h5 class="text-left m-b-0 fw-700 sub-heading">Teaching Type</h5>
                        <ul class="text-left">
                            @foreach($teachingTypes as $teachingType)
                                <li>{{ $teachingType }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- end: Teaching Type -->


                <!-- Qualifications & Experience -->
                <div class="row teaching-type">
                    <div class="col-md-12">
                        <h5 class="text-left m-b-0 fw-700 sub-heading">Qualifications & Experience</h5>
                        <ul class="text-left">
                            @foreach($qualifications as $qualification)
                                @if(!empty($qualification['name']))
                                    <li>{{ $qualification['name'] }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- end: Qualifications & Experience -->

                <a href="javascript:;" class="profile-like-btn">
                    <i class="fa fa-heart-o tag-favourite"></i>
                </a>

            </div>
        </div>
        <!-- end: column left -->
        <!-- starts: column left -->
        <div class="col-lg-8 col-md-12 col-eq-height profile-desc">
            <div class="about feature shadow-v1 boxed cast-shadow-light " style="height: 100%">
                <!-- Starts: Tiles type 01 -->
                @if($intro_video)
                    <div class="row title-type-01">
                        <div class="col-sm-12">
                            <div class="title fs-30 fw-6" style="margin-bottom: 20px; margin-top: 29px">
                                Meet the Tutor
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div style="padding:55% 0 0 0;position:relative;">
                                <iframe 
                                    src="https://player.vimeo.com/video/{{$intro_video}}?badge=0&autopause=0&title=0&byline=0&portrait=0" 
                                    frameborder="0" 
                                    allow="autoplay; fullscreen; picture-in-picture" 
                                    allowfullscreen 
                                    style="position:absolute;top:0;left:0;width:100%;height:100%;" 
                                >
                                </iframe>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row title-type-01">
                    <div class="col-sm-12">
                        <div class="title fs-30 fw-6" style="margin-bottom: 20px">
                            My Availability
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <table class="availability-display" style="width: 100%; text-align: center">
                            <thead>
                            <tr style="height: 50px">
                                <th><strong>&nbsp;</strong></th>
                                <th style="text-align: center"><h5 class="sub-heading" style="margin-bottom: 0px">Pre
                                        12pm</h5></th>
                                <th style="text-align: center"><h5 class="sub-heading" style="margin-bottom: 0px">12 -
                                        4pm</h5></th>
                                <th style="text-align: center"><h5 class="sub-heading" style="margin-bottom: 0px">4 -
                                        7pm</h5></th>
                                <th style="text-align: center"><h5 class="sub-heading" style="margin-bottom: 0px">7 -
                                        10pm</h5></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td style="padding: 15px 2px"><h5 class="sub-heading" style="margin-bottom: 0px">
                                        Mon</h5></td>
                                @if (isset($availability['mon']['morning']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                                @if (isset($availability['mon']['afternoon']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                                @if (isset($availability['mon']['evening']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                                @if (isset($availability['mon']['late']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                            <tr>
                                <td style="padding: 15px 2px"><h5 class="sub-heading" style="margin-bottom: 0px">
                                        Tue</h5></td>
                                @if (isset($availability['tue']['morning']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                                @if (isset($availability['tue']['afternoon']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                                @if (isset($availability['tue']['evening']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                                @if (isset($availability['tue']['late']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                            <tr>
                                <td style="padding: 15px 2px"><h5 class="sub-heading" style="margin-bottom: 0px">
                                        Wed</h5></td>
                                @if (isset($availability['wed']['morning']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                                @if (isset($availability['wed']['afternoon']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                                @if (isset($availability['wed']['evening']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                                @if (isset($availability['wed']['late']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                            <tr>
                                <td style="padding: 15px 2px"><h5 class="sub-heading" style="margin-bottom: 0px">
                                        Thu</h5></td>
                                @if (isset($availability['thu']['morning']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                                @if (isset($availability['thu']['afternoon']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                                @if (isset($availability['thu']['evening']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                                @if (isset($availability['thu']['late']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                            <tr>
                                <td style="padding: 15px 2px"><h5 class="sub-heading" style="margin-bottom: 0px">
                                        Fri</h5></td>
                                @if (isset($availability['fri']['morning']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                                @if (isset($availability['fri']['afternoon']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                                @if (isset($availability['fri']['evening']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                                @if (isset($availability['fri']['late']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                            <tr>
                                <td style="padding: 15px 2px"><h5 class="sub-heading" style="margin-bottom: 0px">
                                        Sat</h5></td>
                                @if (isset($availability['sat']['morning']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                                @if (isset($availability['sat']['afternoon']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                                @if (isset($availability['sat']['evening']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                                @if (isset($availability['sat']['late']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                            <tr>
                                <td style="padding: 15px 2px"><h5 class="sub-heading" style="margin-bottom: 0px">
                                        Sun</h5></td>
                                @if (isset($availability['sun']['morning']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                                @if (isset($availability['sun']['afternoon']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                                @if (isset($availability['sun']['evening']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                                @if (isset($availability['sun']['late']))
                                    <td><img src="/img/icons/check-success.png" height="30px"/></td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row title-type-01">
                    <div class="col-sm-6">
                        <div class="title fs-30 fw-6" style="margin-bottom: 20px">
                            My Subjects
                        </div>
                        <ul class="text-left">
                            @foreach($subjects as $subject)
                                @php $displayName = \App\Helpers\ClassHubHelper::getSubjectDisplayName($subject, $subjects)  @endphp
                                @if($displayName)
                                    <li>
                                        <label>
                                            {{--<span
                                              class="m-checkbox m-checkbox--air  m-checkbox--state-brand" style="margin-bottom: 16px">
                                              <input type="radio" name="subject"
                                              value="{{ $displayName }}">
                                              <span></span>
                                            </span>--}}
                                            <span class="subject-name">{{ $displayName }}</span>
                                        </label>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <div class="title fs-30 fw-6" style="margin-bottom: 20px">
                            Make a booking
                        </div>
                        <div class="row title-type-01">
                            <div class="col-xs-12 col-md-12">
                                <a href="javascript:;"
                                   class="btn btn-primary shadow-v4 contact-btn"
                                   style="white-space: inherit; line-height: 35px; margin-bottom: 20px">
                                    <span class="btn__text">Message me</span>
                                </a>
                            </div>
                            @if(env('APP_ENV') !== 'production')
                                <div class="col-xs-12 col-md-12">
                                    <a href="javascript:void(0);"
                                       class="btn btn-primary shadow-v4 contact-btn video-call-btn"
                                       style="white-space: inherit; width: 100%; line-height: 35px;">
                                        <span class="btn__text">Video call</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Starts: Tiles type 01 -->
            </div>
        </div>
        <!-- end: column left -->
    </div>
    <div class="col-md-12">
        <div class="container classes-tiles" style="margin-top: 30px; padding-left: 0px">
            <div class="title-type-01">
                <div class="title" style="color: #FFF">My other classes (4)</div>
            </div>
            <!-- Starts: Tiles type 01 -->
            <!-- Starts: Tiles type 01 -->
            <div class="row tiles-type-01">

                <div class="col-lg-3 col-md-12 col-sm-12">
                    <a href="#" style="text-decoration: none!important">

                        <div class="image-tile outer-title col-eq-height tutor-lesson-cards my-classes">

                            <img alt="Pic" class="product-thumb"
                                 src="/img/placeholder.jpg"
                                 style="object-fit: cover; width: 100%; height: 190px; max-width: 100%"
                            />

                            <div class="tile-details">
                                <div class="row">
                                    <div class="col-md-12 p-t-0">
                                        <h5 class="fw-7 lesson-name m-b-0">Example Class 1</h5>
                                        <div class="location fw-4 color-01-a">
                                            Classes address here
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-7 col-md-12 p-t-0">
                                        <p class="students"><strong>Students:</strong>
                                            0
                                        </p>
                                        <p class="class-type"><strong>Type:</strong>
                                            Term
                                        </p>
                                    </div>
                                    <div class="col-lg-5 col-md-12 col-sm-12 p-t-0">
                                        <!-- starts: price -->
                                        <div class="price">
                                            <div class="color-02-a text-center text-sm-left">
                                                <strong><span>€0 </span></strong>
                                                per class
                                            </div>
                                        </div>
                                        <!-- end: price -->
                                    </div>
                                </div>

                            </div>

                        </div>

                    </a>
                </div>
                <div class="col-lg-3 col-md-12 col-sm-12">
                    <a href="#" style="text-decoration: none!important">

                        <div class="image-tile outer-title col-eq-height tutor-lesson-cards my-classes">

                            <img alt="Pic" class="product-thumb"
                                 src="/img/placeholder.jpg"
                                 style="object-fit: cover; width: 100%; height: 190px; max-width: 100%"
                            />

                            <div class="tile-details">
                                <div class="row">
                                    <div class="col-md-12 p-t-0">
                                        <h5 class="fw-7 lesson-name m-b-0">Example Class 2</h5>
                                        <div class="location fw-4 color-01-a">
                                            Classes address here
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-7 col-md-12 p-t-0">
                                        <p class="students"><strong>Students:</strong>
                                            0
                                        </p>
                                        <p class="class-type"><strong>Type:</strong>
                                            Term
                                        </p>
                                    </div>
                                    <div class="col-lg-5 col-md-12 col-sm-12 p-t-0">
                                        <!-- starts: price -->
                                        <div class="price">
                                            <div class="color-02-a text-center text-sm-left">
                                                <strong><span>€0 </span></strong>
                                                per class
                                            </div>
                                        </div>
                                        <!-- end: price -->
                                    </div>
                                </div>

                            </div>

                        </div>

                    </a>
                </div>
                <div class="col-lg-3 col-md-12 col-sm-12">
                    <a href="#" style="text-decoration: none!important">

                        <div class="image-tile outer-title col-eq-height tutor-lesson-cards my-classes">

                            <img alt="Pic" class="product-thumb"
                                 src="/img/placeholder.jpg"
                                 style="object-fit: cover; width: 100%; height: 190px; max-width: 100%"
                            />

                            <div class="tile-details">
                                <div class="row">
                                    <div class="col-md-12 p-t-0">
                                        <h5 class="fw-7 lesson-name m-b-0">Example Class 3</h5>
                                        <div class="location fw-4 color-01-a">
                                            Classes address here
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-7 col-md-12 p-t-0">
                                        <p class="students"><strong>Students:</strong>
                                            0
                                        </p>
                                        <p class="class-type"><strong>Type:</strong>
                                            Term
                                        </p>
                                    </div>
                                    <div class="col-lg-5 col-md-12 col-sm-12 p-t-0">
                                        <!-- starts: price -->
                                        <div class="price">
                                            <div class="color-02-a text-center text-sm-left">
                                                <strong><span>€0 </span></strong>
                                                per class
                                            </div>
                                        </div>
                                        <!-- end: price -->
                                    </div>
                                </div>

                            </div>

                        </div>

                    </a>
                </div>
                <div class="col-lg-3 col-md-12 col-sm-12">
                    <a href="#" style="text-decoration: none!important">

                        <div class="image-tile outer-title col-eq-height tutor-lesson-cards my-classes">

                            <img alt="Pic" class="product-thumb"
                                 src="/img/placeholder.jpg"
                                 style="object-fit: cover; width: 100%; height: 190px; max-width: 100%"
                            />

                            <div class="tile-details">
                                <div class="row">
                                    <div class="col-md-12 p-t-0">
                                        <h5 class="fw-7 lesson-name m-b-0">Example Class 4</h5>
                                        <div class="location fw-4 color-01-a">
                                            Classes address here
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-7 col-md-12 p-t-0">
                                        <p class="students"><strong>Students:</strong>
                                            0
                                        </p>
                                        <p class="class-type"><strong>Type:</strong>
                                            Term
                                        </p>
                                    </div>
                                    <div class="col-lg-5 col-md-12 col-sm-12 p-t-0">
                                        <!-- starts: price -->
                                        <div class="price">
                                            <div class="color-02-a text-center text-sm-left">
                                                <strong><span>€0 </span></strong>
                                                per class
                                            </div>
                                        </div>
                                        <!-- end: price -->
                                    </div>
                                </div>

                            </div>

                        </div>

                    </a>
                </div>

            </div>
            <!-- End: Tiles type 01 -->
        </div>
    </div>
</div>
<!-- end : teacher profile -->
<style type="text/css">
    .sub-heading {
        font-size: 16px;
        line-height: 24px;
        font-weight: 600;
    }
</style>
