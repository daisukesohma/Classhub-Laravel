<!-- starts : teacher profile -->
<div class="profile-teacher {{ $user->trusted ? 'trusted' : '' }}">
    <div class="row">
        <!-- starts: column left -->
        <div class="col-lg-4 col-md-12 col-eq-height">
            <div class="profile feature shadow-v1 boxed  text-center">
                <div class="row">
                    <div class="col-md-6">
                        <!-- starts: Image -->
                        <div class="image">
                            <div class="profile-page-image"
                                 style="background-image: url({{ $photo ? $photo : asset('/img/profile-placeholder.jpg') }});">
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
                    {{--<div class="see-reviews">
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#see-reviews"
                           class="link-01">See
                            reviews</a>
                    </div>--}}
                    <!-- end: See reviews link + overlay -->
                        <!-- starts: share link + overlay -->
                        <div class="share-this">
                            <a href="javascript:;" class="link-01 icon-share copy-link"
                               data-link="{{ route('page.educator', $user->slug) }}"
                               data-toggle="modal"
                               data-target="{{  Auth::user() ? '#share-profile-modal' : '#login-modal' }}">
                                <img class="share-icon" src="/img/icons/share-icon.png" height="17px"/>
                                <span>Share</span>
                            </a>
                        </div>
                        <!-- end: share link + overlay -->
                    </div>
                </div>

                <div class="row contact-btns" style="margin-top: 20px">

                    <div class="col-xs-12 col-md-6">
                        <a href="javascript:;"
                           class="btn btn-primary shadow-v4 contact-btn"
                           style="white-space: inherit; line-height: 35px">
                            <span class="btn__text">Message me</span>
                        </a>
                    </div>

                    @if(env('APP_ENV') !== 'production')
                        <div class="col-xs-12 col-md-6">
                            <a href="javascript:void(0);"
                               class="btn btn-primary shadow-v4 contact-btn "
                               style="white-space: inherit; width: 100%; line-height: 35px">
                                <span class="btn__text">Video call</span>
                            </a>
                        </div>
                    @endif

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

                <!-- Areas I cover -->
                <div class="row teaching-type">
                    <div class="col-md-12">
                        <h5 class="text-left m-b-0 fw-700 sub-heading">Areas I Cover</h5>
                        <ul class="text-left">
                            @foreach($areas as $area)
                                <li>{{ $area->address }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- end: Areas I cover -->

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

                <div class="row teaching-type">
                    <div class="col-md-12">
                        <h5 class="text-left m-b-0 fw-700 sub-heading">Subjects</h5>
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

                <a href="javascript:;" class="profile-like-btn">
                    <i class="fa fa-heart-o tag-favourite"></i>
                </a>

            </div>
        </div>
        <!-- end: column left -->
        <!-- starts: column left -->
        <div class="col-lg-8 col-md-12 col-eq-height profile-desc">
            <div class="about feature shadow-v1 boxed cast-shadow-light ">
                <!-- Starts: Tiles type 01 -->
                <div class="row title-type-01">
                    <div class="col-sm-12">
                        <div class="title">{{ strtoupper($user->firstname) }}’S CLASSES (4)
                        </div>
                    </div>
                </div>
                <!-- Starts: Tiles type 01 -->
                <!-- Starts: Tiles type 01 -->
                <div class="row tiles-type-01">

                    <div class="col-lg-6 col-md-12 col-sm-12">
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
                    <div class="col-lg-6 col-md-12 col-sm-12">
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
                    <div class="col-lg-6 col-md-12 col-sm-12">
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
                    <div class="col-lg-6 col-md-12 col-sm-12">
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
        <!-- end: column left -->
    </div>
</div>
<!-- end : teacher profile -->
<style type="text/css">
    .sub-heading {
        font-size: 16px;
        line-height: 24px;
        font-weight: 600;
    }

    .lesson-name {
        font-weight: 600;
    }
</style>

