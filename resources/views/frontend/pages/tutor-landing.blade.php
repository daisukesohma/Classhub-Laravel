@extends('frontend.layouts.master')

@section('title')
    Become A Tutor | Classhub
@endsection

@section('meta_tags')
    <meta name="description"
          content="Become a tutor or advertise your classes - Sign up now, share your skills, and get paid online easily - you'll be ready for bookings in 5 minutes.">
@endsection

@section('content')

    <div class="main-container p-t-0 page-how-it-works">

        <!-- Starts : How it works Hero Image -->
        <section class="image-bg hero-img type-01 no-min-height">
        <!-- <div class="background-image-holder">
                <img alt="image" class="background-image" src="{{ asset('img/hero-images/how-it-works-2.jpg') }}"/>
            </div>
            <span class="gradient-layer type-02"></span> -->
            <!-- starts: Image slider -->
            <div class="image-slider slider-all-controls controls-inside">
                <ul class="slides">
                    <li class="bg-image sm-bg-position"
                        style="background-image:url({{ asset('img/hero-images/help.jpg') }});">
                        &nbsp;
                    </li>
                </ul>
            </div>
            <!-- End: Image -->
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="dark-box">
                            <h2>START TUTORING QUICKLY AND EASILY WITH CLASSHUB</h2>
                            <h5>Welcome to ClassHub: an online platform which aims to give tutors and after school
                                activity providers a safe, secure and convenient place to promote their services. If you
                                want to be part of our exciting launch in Dublin - Join us today by signing up
                                below!</h5>
                            @if(!Auth::user())
                                <a href="javascript:;" data-toggle="modal" data-target="#signup-modal"
                                   class="m-menu__link  signup-modal">
                    					<span class="m-menu__link-text btn btn-primary">
                    						SIGN UP FOR FREE
                    					</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!--end of container-->
        </section>
        <!-- end : How it works Hero Image -->

        <section style="padding-top: 30px; padding-bottom: 70px;">
            <!-- starts : benefits section -->
            <div class="benefits">
                <div class="container">
                    <div class="row box m-0">
                        <div class="col-xs-12">
                            <div class="title fs-23 fw-4 uppercase sm-center-text md-center-text">The Benefits to
                                teaching with Classhub
                            </div>
                            <div class="row" style="padding-top: 100px">
                                <!-- starts : column 01 -->
                                <div class="col-md-4">
                                    <div class="tutor-landing-icon-img"><img class="img-sm-center img-md-center"
                                                                             src="{{ asset('img/icons/search-plus.png') }}">
                                    </div>
                                    <h5 class="sm-center-text md-center-text">Simple to be found</h5>
                                    <p class="benefit-paragraph sm-center-text md-center-text">It’s quick and easy to
                                        list the classes you teach, and get booked up and paid online.</p>
                                </div>
                                <!-- end : column 01 -->
                                <!-- starts : column 02 -->
                                <div class="col-md-4 icon-02">
                                    <div class="tutor-landing-icon-img"><img class="img-sm-center img-md-center"
                                                                             src="{{ asset('img/icons/wand.png') }}">
                                    </div>
                                    <h5 class="sm-center-text md-center-text">More control</h5>
                                    <p class="benefit-paragraph sm-center-text md-center-text">You choose to when and
                                        how you teach to fit in with your life, and you engage directly with your
                                        students.</p>
                                </div>
                                <!-- end : column 02 -->
                                <!-- starts : column 03 -->
                                <div class="col-md-4 icon-03">
                                    <div class="tutor-landing-icon-img"><img class="img-sm-center img-md-center"
                                                                             src="{{ asset('img/icons/check-circle.png') }}">
                                    </div>
                                    <h5 class="sm-center-text md-center-text">Designed to change lives</h5>
                                    <p class="benefit-paragraph sm-center-text md-center-text">Build confidence, boost
                                        brains and help create well rounded, happy, curious young people.</p>
                                </div>
                                <!-- end : column 03 -->
                            </div>
                        </div>

                        <div class="row showmore p-b-60">
                            <div class="col-sm-12 text-center">
                                @if(Auth::user() && Auth::user()->user_type == 'educator')
                                    <a href="{{ route('educator.lesson.create') }}"
                                       class="btn btn-primary shadow-v4 m-0">
                                        <span class="btn__text">LIST YOUR CLASS</span>
                                    </a>
                                @else
                                    <a href="#" data-toggle="modal" data-target="#signup-modal"
                                       class="btn btn-primary shadow-v4 m-0">
                                        <span class="btn__text">LIST YOUR CLASS</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End: top-activities tiles container -->
        </section>
        <div class="container">
            <h4 class="text-center text-primary fw-6">The 3 step sign up process</h4>
            <div class="tab-content">
                <div role="tabpanel"
                     class="tab-pane active">
                    <!-- starts: tabs section -->
                    <!-- starts : Discovery section -->
                    <div class="discovery">

                        <!-- Starts : lists -->
                        <div class="lists" style="padding-top: 100px">

                            <!-- starts: list 01 -->
                            <div class="row list" style="padding-bottom: 80px;">
                                <div class="col-xs-12 list-content">
                                    <h4 class="fw-6">1. Set up your profile</h4>
                                    <div class="row">
                                        <!-- starts, img div -->
                                        <div class="col-xs-12 col-md-4">
                                            <img
                                                src="{{ asset('img/how-it-works/bediscover/school.png') }}"
                                                alt="">
                                        </div>
                                        <!-- end, img div -->
                                        <!-- starts, img div -->
                                        <div class="col-xs-12 col-md-8">
                                            <div class="box content bg-white fs-19">
                                                We just need some of your basic info, a little insight to what you teach
                                                and at what level, and a nice photo just to give your profile a friendly
                                                face.
                                            </div>
                                        </div>
                                        <!-- end, img div -->
                                    </div>
                                </div>
                            </div>
                            <!-- end: list 01 -->

                            <!-- starts: list 02 -->
                            <div class="row list" style="padding-bottom: 80px">
                                <div class="col-xs-12 list-content">
                                    <h4 class="fw-6">2. Tell us how to pay you</h4>
                                    <div class="row">
                                        <!-- starts, img div -->
                                        <div class="col-xs-12 col-md-4">
                                            <img
                                                src="{{ asset('img/how-it-works/bediscover/calendar-attach.png') }}"
                                                alt="">
                                        </div>
                                        <!-- end, img div -->
                                        <!-- starts, img div -->
                                        <div class="col-xs-12 col-md-8">
                                            <div class="box content bg-white fs-19">
                                                In order to set up a class, we need to know how to pay you for your hard
                                                work! We will never request any bank details to take money from
                                                you...just the details we need to send you your earnings.
                                            </div>
                                        </div>
                                        <!-- end, img div -->
                                    </div>
                                </div>
                            </div>
                            <!-- end: list 02 -->

                            <!-- starts: list 03 -->
                            <div class="row list" style="padding-bottom: 150px">
                                <div class="col-xs-12 list-content">
                                    <h4 class="fw-6">3. Start teaching!</h4>
                                    <div class="row">
                                        <!-- starts, img div -->
                                        <div class="col-xs-12 col-md-4">
                                            <img
                                                src="{{ asset('img/how-it-works/bediscover/start-teaching.png') }}"
                                                alt="">
                                        </div>
                                        <!-- end, img div -->
                                        <!-- starts, img div -->
                                        <div class="col-xs-12 col-md-8">
                                            <div class="box content bg-white fs-19">
                                                Now your profile is good to go! You can go ahead and list your class.
                                                Once a class is listed, it will be bookable by anyone and you’ll be able
                                                to manage these bookings from your Classhub Dashboard.
                                            </div>
                                        </div>
                                        <!-- end, img div -->
                                    </div>
                                </div>
                            </div>
                            <!-- end: list 03 -->

                        </div>
                        <!-- End : lists -->

                    </div>
                    <!-- end : Discovery section -->
                    <!-- end: tabs section -->
                </div>
            </div>
        </div>
        <div class="container testimonials">
            <h4 class="sm-center-text">Testimonial</h4>
            <div class="testimonial-box">
                <div class="row">
                    <div class="col-lg-4 col-md-5 col-sm-12">
                        <div class="testimonial-photo" style="background-image: url(img/users/user1.jpg);">
                            <!-- Photo is set as background image so it fits any size -->
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7 col-sm-12">
                        <div class="testimonial-content">
                            <h4 class="testimonial-name text-primary sm-center-text">Gabriela Rivas</h4>
                            <p class="teacher-type sm-center-text">Arts & Crafts teacher</p>
                            <p class="testimonial sm-center-text">“ClassHub is really convenient and easy to use! Not
                                only has the process helped guide me on how best to structure my classes during the
                                week, but it has taken the stress off of the practical side of pupil bookings and
                                payments. Their search engine also allows people to connect with me, taking the pressure
                                off of finding students. I can now focus on my passion and put my time and skills to
                                good use preparing a fun and interesting class, instead if worrying about all those
                                technical details!”</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="bg-white">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <h4 class="text-center">SO…WHAT ARE YOU WAITING FOR?</h4>
                    <p class="text-center" style="margin: 40px 0px">The sign up process couldn’t be easier, and its
                        completely free! <br>List your class and open up a new world of bookings today.</p>
                    <div class="cta">
                        @if( Auth::user() && Auth::user()->user_type == 'educator')
                            <a href="{{ route('educator.lesson.create') }}"
                               class="m-menu__link  signup-modal button-center" style="width: 100%">
                          <span class="m-menu__link-text btn btn-primary" style="width: 50%">
                            LIST YOUR CLASS
                          </span>
                            </a>
                        @else
                            <a href="javascript:;" data-toggle="modal" data-target="#signup-modal"
                               class="m-menu__link  signup-modal button-center" style="width: 100%">
                          <span class="m-menu__link-text btn btn-primary" style="width: 50%">
                            LIST YOUR CLASS
                          </span>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </section>
    </div>

@endsection

@section('page_scripts')
    <script src="{{ asset('js/flexslider.min.js') }}"></script>

    <script type="text/javascript">
        $(function () {
            $('.tab-bediscover a').on('click', function (e) {
                $('.benefits').hide();
            })

            $('.tab-discover a').on('click', function (e) {
                $('.benefits').show();
            })

            $('.tab-bediscover a').on('click', function (e) {
                $('.earning-suggested').show();
            })

            $('.tab-discover a').on('click', function (e) {
                $('.earning-suggested').hide();
            })

            $('input#price, input#num-class, input#num-pupil').on('keyup', function () {
                var price = $('input#price').val();
                var numClass = $('input#num-class').val();
                var numStudent = $('input#num-pupil').val();

                if (!isNaN(price) && !isNaN(numClass) && !isNaN(numStudent)) {

                    var total = parseFloat((((price * numClass) * numStudent) * 4));
                    total = total - (total * 0.1476)

                    $('span#earning-total').html(new Intl.NumberFormat('en-GB', {
                        style: 'currency',
                        currency: 'EUR'
                    }).format(total))
                } else {
                    $('span#earning-total').html('0.00')
                }
            })
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

    @if(request()->has('tutor'))
        <script type="text/javascript">
            $('.tab-bediscover a').click()
            $('.benefits').hide();
            $('.earning-suggested').show();

            console.log('click')
        </script>
    @endif

@endsection
