@extends('frontend.layouts.master')

@section('title')
    Trust | Classhub
@endsection

@section('meta_tags')
    <meta name="description" content="Trust & safety is of paramount importance to us and all of the students, parents,
     tutors & providers who are part of our community. Visit to find out more.">
@endsection

@section('page_styles')
    <style type="text/css">
        .trusted-nav-item.no-arrow:before {
            content: none;
        }
    </style>
@endsection

@section('content')

    <div class="main-container p-t-0 page-trust">

        <!-- Starts : trust page Hero Image -->
        <section class="image-bg hero-img trust-hero-img type-01 no-min-height">
        <!-- <div class="background-image-holder">
                <img alt="image" class="background-image" src="{{ asset('img/hero-images/trust.jpg') }}"/>
            </div> -->
            <!-- starts: Image slider -->
            <div class="image-slider slider-all-controls controls-inside">
                <ul class="slides">
                    <li class="bg-image"
                        style="background-image:url({{ asset('img/hero-images/trust.jpg') }}); background-position: 59% 10%;">
                        &nbsp;
                    </li>
                </ul>
            </div>
            <!-- End: Image -->
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="box">
                            <h1>Trust on Classhub</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!--end of container-->
        </section>
        <!-- end : trust Page Hero Image -->

        <!-- starts : trust columns -->
        <div class="trust-columns">
            <div class="container">
                <div class="row">
                    <!-- starts : side nav -->
                    <div class="col-md-3 sidenav hide-below-md">
                        <div class="box">
                            <ul>
                                <li><a href="http://design.classhub.ie/trust#sec-02" class="icon-01">Accepting tutors
                                        and activity providers on to the site</a></li>
                                <li><a href="http://design.classhub.ie/trust#sec-03" class="icon-06">Ratings and
                                        reviews</a></li>
                                <li><a href="http://design.classhub.ie/trust#sec-05" class="icon-08">Tutor and activity
                                        provider qualifications</a></li>
                                <li><a href="http://design.classhub.ie/trust#sec-06" class="icon-09">Make contact</a>
                                </li>
                                <li><a href="http://design.classhub.ie/trust#sec-07" class="icon-07">Classhub code of
                                        ethics</a></li>
                                <li><a href="http://design.classhub.ie/trust#sec-08" class="icon-02">Requesting a valid
                                        government ID</a></li>
                                <div class="trusted-nav">
                                    <li class="trusted-nav-item no-arrow">
                                        <a href="http://design.classhub.ie/trust#sec-09" class="icon-11">Identity
                                            checks</a>
                                    </li>
                                    <li class="trusted-nav-item m-b-20" style="padding-left: 35px">or</li>
                                    <li class="trusted-nav-item no-arrow">
                                        <a href="http://design.classhub.ie/trust#sec-10" class="icon-11">References</a>
                                    </li>
                                </div>
                                <li><a href="http://design.classhub.ie/trust#sec-11" class="icon-12">Summary</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- end : side nav -->
                    <!-- starts : main col -->
                    <div class="col-md-9 main">
                        <div class="box">

                            <!-- starts : section 01 -->
                            <dl id="sec-01">
                                <dt class="icon-01">Trust on Classhub</dt>
                                <dd>
                                    <p>Classhub was created with the aim of connecting an enthusiastic community of
                                        tutors and activity providers with parents and students in order to encourage
                                        hidden talents to flourish and create confident and determined achievers.</p>
                                    <p>Classhub isn’t an agency - we’re a marketplace. Our aim is to provide every
                                        parent and student, who visits our platform, with all of the information they
                                        need on the tutors and activity providers who list classes on our site, so they
                                        can quickly and easily determine who is best placed to help them achieve their
                                        learning or activity goals.</p>
                                    <p>Trust and safety is of paramount importance to us and all of the students,
                                        parents, tutors and activity providers who are part of our community. That’s why
                                        we seek to be completely transparent about what we do and what we don’t and the
                                        steps we take as a platform to provide the highest levels of trust and security,
                                        and what you can do to help provide a safe learning environment.</p>
                                </dd>
                            </dl>
                            <!-- end : section 01 -->

                            <!-- starts : section 02 -->
                            <dl id="sec-02">
                                <dt class="icon-02">Accepting tutors and activity providers on to the site</dt>
                                <dd>
                                    <p>We require every tutor and activity provider to complete a full profile - which
                                        includes adding a bio, their qualifications, a photo of themselves, their
                                        teaching preferences and the areas they cover - before their class can go live
                                        on the site. Classhub check each profile and use our best endeavours to ensure
                                        that tutors and class providers only offer subjects and after school activities
                                        they have suitable qualifications and backgrounds to teach, at a rate we deem to
                                        be fair and reasonable.</p>
                                </dd>
                            </dl>
                            <!-- end : section 02 -->

                            <!-- starts : section 03 -->
                            <dl id="sec-03">
                                <dt class="icon-03">Ratings & Reviews</dt>
                                <dd>
                                    <p>All ratings are from verified users who have booked and received tuition or
                                        participated in an after school activity through the classhub platform.</p>
                                </dd>
                            </dl>
                            <!-- end : section 03 -->


                            <!-- starts : section 05 -->
                            <dl id="sec-05">
                                <dt class="icon-05">Tutor and activity provider qualifications</dt>
                                <dd>
                                    <p>We are not able to ask every Tutor or activity provider for proof of their
                                        qualifications, instead, we recommend that parents and students request to see
                                        any certificates they believe are relevant to the activity or tuition that they
                                        will be receiving at their first session. We also encourage parents and students
                                        to arrange to make contact with the tutor or activity provider through our
                                        messaging and video call service, and ask any questions you may have before
                                        making a booking with them.</p>
                                </dd>
                            </dl>
                            <!-- end : section 05 -->

                            <!-- starts : section 06 -->
                            <dl id="sec-06">
                                <dt class="icon-06">Make Contact</dt>
                                <dd>
                                    <p>We also encourage parents and students to make contact with the tutor or activity
                                        provider through our messaging and video call service, and ask any questions you
                                        may have before making a booking with them. This is a free service provided by
                                        Classhub to ensure both Parents and Tutors are completely satisfied before
                                        making a booking.</p>
                                </dd>
                            </dl>
                            <!-- end : section 06 -->

                            <!-- starts : section 07 -->
                            <dl id="sec-07">
                                <dt class="icon-07">Classhub code of ethics</dt>
                                <dd>
                                    <p>EWe also make it mandatory for all teachers, tutors and providers to review and
                                        accept the classhub code of ethics when creating a profile</p>
                                </dd>
                            </dl>
                            <!-- end : section 07 -->

                            <!-- starts : section 08 -->
                            <dl id="sec-08">
                                <dt class="icon-08">Requesting a valid government ID</dt>
                                <dd>
                                    <p>Every tutor and activity provider is required to upload a copy of a valid
                                        government ID document (ie passport or driving licence), that is in colour and
                                        in date. This is then automatically verified by Stripe, our payment processor.
                                        This also happens before they can set a class live.</p>
                                </dd>
                            </dl>
                            <!-- end : section 08 -->

                            <!-- starts : section 09 -->
                            <dl id="sec-09">
                                <dt class="icon-11">Identity checks</dt>
                                <dd>
                                    <p>
                                        Tutors and activity providers have the option to provide a recent ID check from
                                        any relevant background checking organisation, we suggest using checkback.ie and
                                        heavily encourage all our providers to verify their profile. To make it easy, we
                                        also agree to pay for it up to the value of €30.
                                    </p>
                                    <p>If you see this symbol <img class="verified"
                                                                   src="{{ asset('img/icons/trust/verified.png') }}"/>
                                        it means that the profile is verified, if a profile does not have this
                                        it’s not necessarily a bad thing as it can take up to a week for an account to
                                        be verified, so maybe check back at another time or ask the tutor or activity
                                        provider why.</p>
                                </dd>
                            </dl>
                            <!-- end : section 09 -->

                            <!-- starts : section 10 -->
                            <dl id="sec-10">
                                <dt class="icon-11">References</dt>
                                <dd>
                                    <p>
                                        We encourage every new tutor and activity provider to submit two positive
                                        references after they sign up to Classhub. These references must have a contact
                                        number or email for the provider of these references. All references are
                                        authenticated by Classhub and if they check out, we upgrade your profile to
                                        trusted status.
                                    </p>
                                </dd>
                            </dl>
                            <!-- end : section 10 -->

                            <!-- starts : section 12 -->
                            <dl id="sec-11">
                                <dt class="icon-12">Summary</dt>
                                <dd>
                                    <p>We hope these details make it very clear how we approach the subject of trust
                                        but, of course, if you’ve any further questions don’t hesitate to drop us a line
                                        at <a href="mailto:support@classhub.ie">support@classhub.ie</a></p>
                                </dd>
                            </dl>
                            <!-- end : section 12 -->

                        </div>
                    </div>
                    <!-- starts : main col -->
                </div>
            </div>
        </div>
        <!-- end : trust columns -->

    </div>

@endsection

@section('page_scripts')
    <script src="{{ asset('js/flexslider.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
