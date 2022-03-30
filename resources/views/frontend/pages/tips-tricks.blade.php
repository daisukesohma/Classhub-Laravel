@extends('frontend.layouts.master')

@section('title')
    Tips & Tricks | Classhub
@endsection

@section('meta_tags')
    <meta name="description"
          content="Some handy tips to help you improve your online profile, get noticed and make the most of Classhub.">
@endsection


@section('content')

    <div class="main-container page-tips-tricks p-t-0">

        <!-- Starts : Tips page Hero Image -->
        <section class="image-bg hero-img type-01 no-min-height">
        <!-- <div class="background-image-holder">
                <img alt="image" class="background-image" src="{{ asset('img/hero-images/tips.jpg') }}"/>
            </div> -->
            <!-- starts: Image slider -->
            <div class="image-slider slider-all-controls controls-inside">
                <ul class="slides">
                    <li class="bg-image"
                        style="background-image:url({{ asset('img/hero-images/slider/after-school-classes-in-dublin.jpg') }});">
                        &nbsp;
                    </li>
                    <li class="bg-image"
                        style="background-image:url({{ asset('img/hero-images/slider/after-school-tutors-in-dublin.jpg') }});">
                        &nbsp;
                    </li>
                    <li class="bg-image"
                        style="background-image:url({{ asset('img/hero-images/slider/children-grinds-in-dublin.jpg') }});">
                        &nbsp;
                    </li>
                    <li class="bg-image"
                        style="background-image:url({{ asset('img/hero-images/slider/dance-ballet-tutors.jpg') }});">
                        &nbsp;
                    </li>
                    <li class="bg-image"
                        style="background-image:url({{ asset('img/hero-images/slider/dancing-lessons-for-children.jpg') }});">
                        &nbsp;
                    </li>
                    <li class="bg-image"
                        style="background-image:url({{ asset('img/hero-images/slider/italian-language-tutors.jpg') }});">
                        &nbsp;
                    </li>
                    <li class="bg-image"
                        style="background-image:url({{ asset('img/hero-images/slider/maths-tutor-in-dublin.jpg') }});">
                        &nbsp;
                    </li>
                </ul>
            </div>
            <!-- End: Image -->
            <span class="gradient-layer type-01"></span>
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="box">
                            <h1>A QUICK LESSON FROM US</h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end : Tips page Hero Image -->

        <div class="tips-top-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="title fs-30 fw-5">Tips on making the most of Classhub</div>
                        <div class="content">Whether you’re an excited first timer, all shiny and brand new to the world
                            of tutoring, or a seasoned pro looking for new ways to maximise your earning potential,
                            Classhub is for you. Below we’ve put together some handy tips to help you improve your
                            profile and get noticed. We have also added an earnings calculator with some suggested rates
                            to help you understand your earning potential.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="mobile-earning-calc">
            @include('frontend.includes.earning-calculator')
        </div>


        <div class="columns-with-sidebar">
            <div class="container">
                <div class="row columns">

                    <div class="col-md-8 leftbar">
                        <!-- starts: columns, left -->
                        <div class="title fs-30 fw-5">Creating an eye catching profile</div>

                        <!-- starts : description list -->
                        <div class="lists">

                            <!-- starts : list 01 -->
                            <dl>
                                <dt>Pick the right pic</dt>
                                <dd>Your profile is much more likely to be viewed by having a pic. So that little square
                                    is actually a hugely important way to make a good impression. You don’t need to pay
                                    a professional photographer. Just think about a few elements that can help you look
                                    likeable, professional and trustworthy. Don’t have a distracting background or wear
                                    distracting clothes, don’t make it hard for people to actually see your face (i.e.
                                    don’t be waving from a nearby mountain peak) and try to go for natural - if you’re
                                    not comfortable smiling, think approachability and warmth rather than a toothy grin.
                                </dd>
                            </dl>
                            <!-- end : list 01 -->

                            <!-- starts : list 02 -->
                            <dl>
                                <dt>Your bio - all about you</dt>
                                <dd>This is the chance to tell your story. And like any good story, hook your audience
                                    in with a strong opening statement. What sets you apart? Why do you love teaching?
                                    How do you like to teach. Don’t be afraid to inject some personality. Even when
                                    you’re telling about your experience, where and what you’ve taught, your successes.
                                    People like to work with people, after all. So include your hobbies and interests.
                                    It all helps you stand out and present yourself to parents as someone their kids
                                    will like to learn from. If you haven’t taught before then talk about relevant
                                    volunteering experiences in teaching or mentoring. And watch out for grammar and
                                    spelling errors.
                                </dd>
                            </dl>
                            <!-- end : list 02 -->

                            <!-- starts : list 03 -->
                            <dl>
                                <dt>Give as much availability as you can</dt>
                                <dd>We believe that availability is a very important factor for parents when
                                     choosing a tutor so we encourage all tutors and activity providers to have a
                                    long think about what time can you really make available to tutoring and add
                                    these to your availability chart when setting up your profile. We all know that
                                    life can be busy and plans can change so the more you are available to tutor
                                    the more interest you will get by parents.
                                </dd>
                            </dl>
                            <!-- end : list 03 -->

                            <!-- starts : list 04 -->
                            <dl>
                                <dt>Get ratings and reviews</dt>
                                <dd>Ratings and reviews from parents and pupils are a great way to boost your
                                    profile and build up trust, credibility and reputation - all so important in the
                                    world of teaching. So don’t be shy in asking happy parents and inspired
                                    students to rate and review you after your lessons.
                                </dd>
                            </dl>
                            <!-- end : list 04 -->

                            <!-- starts : list 05 -->
                            <dl>
                                <dt>Communication is key</dt>
                                <dd>You’ll find that parents always tend to ask questions before they book. So replying
                                    quickly (and helpfully) to their queries is hugely important. It helps them make an
                                    informed decision about who they are going to book. And shows that you are the sort
                                    of helpful, easy to deal with, ‘on it’ type that they want to be booking.
                                </dd>
                            </dl>
                            <!-- end : list 05 -->

                            <!-- starts : list 04 -->
                            <dl>
                                <dt>Share your profile and build awareness</dt>
                                <dd>When your profile is live you can grow your business instantly on ClassHub.
                                    You can share your profile on Facebook, WhatsApp and by email to all your
                                    contacts, the ClassHub sharing feature allows you share a professionally
                                    designed template that when clicked by one of your contacts will bring them
                                    straight to your profile.
                                </dd>
                            </dl>
                            <!-- end : list 04 -->

                            <!-- starts : list 05 -->
                            <dl>
                                <dt>Setting your prices</dt>
                                <dd>If you’re new to this world, then it can be tricky to know how much you should be
                                    charging. Thankfully help is at hand. When you list your class, our Earnings
                                    Calculator* will help you to set the right price for your level of experience and
                                    the type of class you offer.
                                    <small class="fs-13">*Based on research conducted in the Irish and Dublin market
                                        2018
                                    </small>
                                </dd>
                            </dl>
                            <!-- end : list 05 -->

                            <!-- starts : list 06 -->
                            <dl>
                                <dt>Refund policy</dt>
                                <dd>Click <a href="{{ route('page.terms-conditions') }}">here</a> to see more details
                                    about refunds.
                                </dd>
                            </dl>
                            <!-- end : list 06 -->

                        </div>
                        <!-- end : description list -->
                        <!-- end: columns, left -->
                    </div>

                    <div class="col-md-4 rightbar" id="sidebar">

                        <!-- Starts: Tiles type 01 -->

                    @include('frontend.includes.earning-calculator')

                    <!-- end: columns, right -->
                    </div>

                </div>
            </div>
        </div>


        <section class="tips-tricks book-list-easy">
            <div class="container">
                <div class="row box">

                    <!-- starts : final a local class -->
                    <div class="col-md-6 col-sm-12 box-sub find-class col-eq-height">
                        <!-- starts : title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="title">Get more out of teaching</div>
                                <div class="sub-title">Classhub makes it easy for you to share your knowledge and pass
                                    on skills for life, in a way that suits you.
                                </div>
                            </div>
                        </div>
                        <!-- end : title -->
                        <!-- starts : title -->
                        <div class="row content">
                            <div class="col-sm-12">
                                <!-- starts : list 01 -->
                                <dl>
                                    <dt>More simple to be found</dt>
                                    <dd>It’s quick and easy to list the subjects and classes you teach, and get booked up and paid online.
                                    </dd>
                                </dl>
                                <!-- end : list 01 -->
                                <!-- starts : list 02 -->
                                <dl>
                                    <dt>More control</dt>
                                    <dd>You choose your own availability and how you teach to fit in with your life, and you engage directly with your students.
                                    </dd>
                                </dl>
                                <!-- end : list 02 -->
                                <!-- starts : list 03 -->
                                <dl>
                                    <dt>Designed to change lives</dt>
                                    <dd>Build confidence, boost brains and help create well rounded, happy, curious
                                        young people.
                                    </dd>
                                </dl>
                                <!-- end : list 03 -->
                                <!-- starts : list 04 -->
                                <dl>
                                    <dt>Start smart</dt>
                                    <dd>View your ‘Listing My Class’ checklist before you begin and make sure you make
                                        the right impression.
                                    </dd>
                                </dl>
                                <!-- end : list 04 -->
                            </div>
                        </div>
                        <!-- end : title -->
                        <!-- Starts: bottom button -->
                        <div class="row class-button">
                            <div class="col-sm-12 text-center">
                                <a href="{{ Auth::user() ? route('educator.profile.create') : 'javascript:;' }}"
                                   {{ !Auth::user() ? 'data-toggle=modal data-target=#login-modal' : '' }}
                                   class="btn btn-primary">
                                    <span class="btn__text">LIST A CLASS</span>
                                </a>
                            </div>
                        </div>
                        <!-- End: bottom button -->
                    </div>
                    <!-- end : final a local class -->

                    <!-- starts : List your local class -->
                    <div class="col-md-6 col-sm-12 box-sub list-class col-eq-height">
                        <!-- starts : title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="title">Setting up a Profile</div>
                                <ul class="checklist">
                                    <li class="checklist-item row">
                                        <div class="col-md-1 col-xs-2">
                                            <img class="checklist-check" src="/img/icons/check.png" height="20px"/>
                                        </div>
                                        <div class="col-md-11 col-xs-10">
                                            High resolution profile pic, looking friendly, trustworthy and
                                            professional
                                        </div>
                                    </li>
                                    <li class="checklist-item row">
                                        <div class="col-md-1 col-xs-2">
                                            <img class="checklist-check" src="/img/icons/check.png" height="20px"/>
                                        </div>
                                        <div class="col-md-11 col-xs-10">
                                            An engaging and interesting bio, with bags of personality
                                        </div>
                                    </li>
                                    <li class="checklist-item row">
                                        <div class="col-md-1 col-xs-2">
                                            <img class="checklist-check" src="/img/icons/check.png" height="20px"/>
                                        </div>
                                        <div class="col-md-11 col-xs-10">
                                            Add as many subjects to your profile that you feel comfortable with and have experience in.
                                        </div>
                                    </li>
                                    <li class="checklist-item row">
                                        <div class="col-md-1 col-xs-2">
                                            <img class="checklist-check" src="/img/icons/check.png" height="20px"/>
                                        </div>
                                        <div class="col-md-11 col-xs-10">
                                            Past pupil or parent testimonials/reviews/recommendations
                                        </div>
                                    </li>
                                    <li class="checklist-item row">
                                        <div class="col-md-1 col-xs-2">
                                            <img class="checklist-check" src="/img/icons/check.png" height="20px"/>
                                        </div>
                                        <div class="col-md-11 col-xs-10">
                                            All my relevant skills, experience and qualifications
                                        </div>
                                    </li>
                                    <li class="checklist-item row">
                                        <div class="col-md-1 col-xs-2">
                                            <img class="checklist-check" src="/img/icons/check.png" height="20px"/>
                                        </div>
                                        <div class="col-md-11 col-xs-10">
                                            My (flexible) availability
                                        </div>
                                    </li>
                                    <li class="checklist-item row">
                                        <div class="col-md-1 col-xs-2">
                                            <img class="checklist-check" src="/img/icons/check.png" height="20px"/>
                                        </div>
                                        <div class="col-md-11 col-xs-10">
                                            My price - set for my level of experience and type of class I
                                            teach
                                        </div>
                                    </li>
                                    <li class="checklist-item row">
                                        <div class="col-md-1 col-xs-2">
                                            <img class="checklist-check" src="/img/icons/check.png" height="20px"/>
                                        </div>
                                        <div class="col-md-11 col-xs-10">
                                            I’m ready to respond to any enquiries about my class, quickly and
                                            helpfully
                                        </div>
                                    </li>
                                    <li class="checklist-item row">
                                        <div class="col-md-1 col-xs-2">
                                            <img class="checklist-check" src="/img/icons/check.png" height="20px"/>
                                        </div>
                                        <div class="col-md-11 col-xs-10">
                                            All grammar, punctuation and spelling checked
                                        </div>
                                    </li>
                                    <li class="checklist-item row">
                                        <div class="col-md-1 col-xs-2">
                                            <img class="checklist-check" src="/img/icons/check.png" height="20px"/>
                                        </div>
                                        <div class="col-md-11 col-xs-10">
                                            I’ve asked a friend for feedback
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- end : title -->


                    </div>
                    <!-- end : List your local class -->

                </div>
            </div>
        </section>


        <div class="tips-btm-section columns-with-sidebar">
            <div class="container">

                <div class="row">
                    <div class="col-xs-12">
                        <div class="title fs-30 fw-5">Some things to consider before you list</div>
                    </div>
                </div>


                <div class="row">

                    <div class="col-md-5">
                        <!-- starts : description list -->
                        <div class="lists">

                            <!-- starts : list 01 -->
                            <dl>
                                <dt>Transparency creates trust</dt>
                                <dd>It sounds a bit obvious but making sure your profile information is accurate, honest
                                    and true will help you establish great relationships with parents from the off. It
                                    means pupils get the experience they want, and you get repeat bookings and rave
                                    reviews.
                                </dd>
                            </dl>
                            <!-- end : list 01 -->

                            <!-- starts : list 02 -->
                            <dl>
                                <dt>One hub, one way to get paid</dt>
                                <dd>To make sure we can pay you as quickly and efficiently as possible, we manage all
                                    payments through our own website, and so no other payment methods are possible.
                                </dd>
                            </dl>
                            <!-- end : list 02 -->

                        </div>
                        <!-- end : description list -->
                    </div>

                    <div class="col-md-5 col-md-offset-2">
                        <!-- starts : description list -->
                        <div class="lists">

                            <!-- starts : list 01 -->
                            <dl>
                                <dt>Here to help you deal with the unexpected</dt>
                                <dd>Our friendly members of staff are on hand to support you, and we will get back to
                                    your email within 24hrs. So if there’s a problem, or you find yourself wondering why
                                    the bookings aren’t coming in thick and fast, please get in touch and we can help.
                                </dd>
                            </dl>
                            <!-- end : list 01 -->

                        </div>
                        <!-- end : description list -->
                    </div>

                </div>


            </div>
        </div>

        <!--starts : fee structure modal -->
        <div class="modal fade c-modal overlay-share-this" id="classCheckList" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true" style="color:#000">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" class="p-b-0"><h4>Listing a Class Checklist</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">
                        &times;
                      </span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding-top: 0px;">
                        <ul class="checklist">
                            <li class="checklist-item">High resolution profile pic, looking friendly, trustworthy and
                                professional
                            </li>
                            <li class="checklist-item">An engaging and interesting bio, with bags of personality</li>
                            <li class="checklist-item">A detailed description of my classes, including anything that
                                will make them stand out, plus photos
                            </li>
                            <li class="checklist-item">Past pupil or parent testimonials/reviews/recommendations</li>
                            <li class="checklist-item">All my relevant skills, experience and qualifications</li>
                            <li class="checklist-item">My (flexible) availability</li>
                            <li class="checklist-item">My price - set for my level of experience and type of class I
                                teach
                            </li>
                            <li class="checklist-item">I’m ready to respond to any enquiries about my class, quickly and
                                helpfully
                            </li>
                            <li class="checklist-item">All grammar, punctuation and spelling checked</li>
                            <li class="checklist-item">I’ve asked a friend for feedback</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--ends : fee structure modal -->


        <!--starts : fee structure modal -->
        <div class="modal fade c-modal overlay-share-this" id="feeStructure"
             tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" class="p-b-0"><h5 class="m-0">How much
                            does it cost to list my class / activity?</h5>
                        <button type="button" class="close "
                                data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">
                        &times;
                      </span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding-top: 0px;">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="tc p-t-0">
                                    To help the Classhub platform operate and run
                                    smoothly, we charge a commission rate on all
                                    class and activity fees. This is deducted before
                                    making a pay-out to you.<br><br>

                                    Additionally, Classhub applies a small service
                                    charge to parents and students when they book
                                    and pay for a class on the platform. This helps
                                    us to process payments and pay-outs efficiently.<br><br>

                                    Signing up for Classhub and listing a class is
                                    completely free. Once you receive payment for a
                                    class, we deduct a commission rate of 12% plus
                                    VAT on the class or activity fee that you have
                                    set.<br><br>

                                    Classhub applies a 3% service charge to parents
                                    and students when they book and pay for a class
                                    on the platform. This service fee is inclusive
                                    of VAT.<br><br>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <img
                                            src="{{ asset('img/fee-structure/clashub_parent_fee_structure_example.jpg') }}"
                                            alt="" style="padding-bottom:20px;">
                                    </div>
                                    <div class="col-sm-6">
                                        <img
                                            src="{{ asset('img/fee-structure/clashub_tutor_fee_example02.png') }}"
                                            alt="" style="padding-bottom:20px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--ends : fee structure modal -->
        </div>


        @endsection

        @section('page_scripts')
            <script src="{{ asset('js/flexslider.min.js') }}"></script>
@endsection
