@extends('frontend.layouts.master')

@section('title')
    How It Works | Classhub
@endsection

@section('meta_tags')
    <meta name="description" content="Whether you’re a parent looking for online ideas, or a teacher looking to list your talents online, we’ve made it really simple to start connecting.">
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
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="box">
                            <h2 style="margin: 80px 0; ">HOW IT ALL WORKS FOR YOU</h2>
                        </div>
                    </div>
                </div>
            </div>
            <!--end of container-->
        </section>
        <!-- end : How it works Hero Image -->


        <!-- starts: tabs -->
        <section class="bg-color-01 shadow-v2 p-tb-60">
          <div class="row">
                    <div class="col-xs-12">
                        <div class="tabs">
                          <div class="container">
                            <!-- starts : Nav tabs -->
                            <ul class="row nav nav-tabs m-0" role="tablist">
                                <li role="presentation" class="col-xs-6 tab-discover
                                    {{ Auth::user() && Auth::user()->educator ? '' : 'active' }}">
                                    <a href="#discover" aria-controls="discover" role="tab"
                                       data-toggle="tab">PARENTS
                                        <br>
                                        <span style="font-size: 13px;">Click here to learn more</span>
                                    </a>
                                </li>
                                <li role="presentation" class="col-xs-6 tab-bediscover text-right
                                      {{ Auth::user() && Auth::user()->educator ? 'active' : '' }}">
                                    <a href="#bediscover" aria-controls="bediscover" role="tab" data-toggle="tab">
                                        TUTORS
                                        <br>
                                        <span style="font-size: 13px;">Click here to learn more</span>
                                    </a>
                                </li>
                            </ul>
                            <!-- end : Nav tabs -->
                          </div>
                            <!-- starts : Tab panes -->
                          <div class="tab-content">
                                <div role="tabpanel"
                                     class="tab-pane {{ Auth::user() && Auth::user()->educator ? '' : 'active' }}"
                                     id="discover">
                                     <div class="container">
                                    <!-- starts: tabs section -->
                                      <h4 class="color-02" style="margin-top: 40px">Find talented teachers and awesome after school activities near you</h4>
                                    </div>
                                    <section class="space-sm background-grey">
                                      <div class="container">
                                        <div class="row v-align-children">
                                          <div class="col-md-6 col-sm-12">
                                            <h4>Search</h4>
                                            <p>
                                              Simply enter your subject / activity and your location then click search, you will automatically see a list of matching tutor profiles, from here you can browse and message the tutors that you like.
                                            </p>
                                          </div>
                                          <div class="col-md-4 col-md-offset-2 col-sm-12 mb-xs-24">
                                            <img alt="Screenshot" src="/img/illustrations/illustrations-10.png">
                                          </div>
                                        </div>
                                        <!--end of row-->
                                      </div>
                                      <!--end of container-->
                                    </section>
                                    <section class="background-white space-sm">
                                      <div class="container">
                                        <div class="row v-align-children">
                                          <div class="col-md-6 col-md-push-6 col-sm-12">
                                            <h4>Request a Tutor</h4>
                                            <p>
                                              It’s simple and free to request a tutor on ClassHub, after you submit what you're looking for, we do the hard work and send your request to matching tutors. They will then get in touch with you by sending you a message to your ClassHub inbox.
                                            </p>
                                          </div>
                                          <div class="col-md-6 col-md-pull-6 col-sm-12 mb-xs-24">
                                            <img alt="Screenshot" src="/img/illustrations/illustrations-01.png">
                                          </div>
                                        </div>
                                        <!--end of row-->
                                      </div>
                                      <!--end of container-->
                                    </section>
                                    <section class="space-sm background-grey">
                                      <div class="container">
                                        <div class="row v-align-children">
                                          <div class="col-md-6 col-sm-12">
                                            <h4>Message</h4>
                                            <p>
                                              The ClassHub messenger works for both you and the tutor, whether you request a tutor or find a tutor by searching, all correspondence goes through your ClassHub inbox. So keep an eye out for your message alerts by email.
                                            </p>
                                          </div>
                                          <div class="col-md-4 col-md-offset-2 col-sm-12 mb-xs-24">
                                            <img alt="Screenshot" src="/img/illustrations/illustrations-09.png">
                                          </div>
                                        </div>
                                        <!--end of row-->
                                      </div>
                                      <!--end of container-->
                                    </section>
                                    <section class="background-white space-md">
                                      <div class="container">
                                        <div class="row v-align-children">
                                          <div class="col-md-6 col-md-push-6 col-sm-12">
                                            <h4>Online tutoring & pre-recorded classes on Classhub</h4>
                                            <p>
                                              Online learning allows you to access the most suitable tutor for you regardless of location, and to learn from the comfort of your own home.
                                              Once you and your tutor have agreed on a date and time, your tutor will make a booking and schedule a Zoom lesson for you.  You’ll be asked to confirm and pay for the booking in advance of the lesson.
                                            </p>
                                            <p>
                                              All ClassHub lessons are conducted using a ClassHub Zoom account, so you don’t need to use your personal account.  For tablet or smartphone access, just download the Zoom app; otherwise, simply click on the lesson link in your ClassHub messages and you’re off!
                                            </p>
                                            <p>
                                              Some tutors also offer their own pre-recorded lessons.  These allow students to access content when they need it and to reference it as often as they want.
                                            </p>
                                            <img src="/img/logo/powered-by-zoom.png" alt="powered by zoom" height="20px" />
                                          </div>
                                          <div class="col-md-6 col-md-pull-6 col-sm-12 mb-xs-24">
                                            <img alt="Screenshot" src="/img/illustrations/illustrations-11.png">
                                          </div>
                                        </div>
                                        <!--end of row-->
                                      </div>
                                      <!--end of container-->
                                    </section>
                                    <section class="space-sm background-grey">
                                      <div class="container">
                                        <div class="row v-align-children">
                                          <div class="col-md-6 col-sm-12">
                                            <h4>Accept your booking</h4>
                                            <p>
                                              Once you have agreed the details of your lessons with your tutor they will create a booking for you and send it to your Classhub Inbox for you to accept and pay.
                                            </p>
                                          </div>
                                          <div class="col-md-4 col-md-offset-2 col-sm-12 mb-xs-24">
                                            <img alt="Screenshot" src="/img/illustrations/illustrations-08.png">
                                          </div>
                                        </div>
                                        <!--end of row-->
                                      </div>
                                      <!--end of container-->
                                    </section>
                                    <section class="background-white space-sm">
                                      <div class="container">
                                        <div class="row v-align-children">
                                          <div class="col-md-6 col-md-push-5 col-sm-12">
                                            <h4>Pay</h4>
                                            <p>
                                              We use stripe one of the worlds safest online payment portals. Once you pay we automatically send you a confirmation email with receipt and update your bookings area with your new lessons. Payouts to tutors are not processed until 24 hours after a class has taken place.
                                            </p>
                                          </div>
                                          <div class="col-md-6 col-md-pull-6 col-sm-12 mb-xs-24">
                                            <img alt="Screenshot" src="/img/illustrations/illustrations-13.png">
                                          </div>
                                        </div>
                                        <!--end of row-->
                                      </div>
                                      <!--end of container-->
                                    </section>
                                    <!-- end: tabs section -->
                                </div>
                                <div role="tabpanel"
                                     class="tab-pane {{ Auth::user() && Auth::user()->educator ? 'active' : '' }}"
                                     id="bediscover">
                                    <!-- starts: tabs section -->
                                    <div class="container">
                                   <!-- starts: tabs section -->
                                     <h4 class="color-02" style="margin-top: 40px">Share your skills, choose how you teach</h4>
                                   </div>
                                   <section class="space-sm background-grey">
                                     <div class="container">
                                       <div class="row v-align-children">
                                         <div class="col-md-6 col-sm-12">
                                           <h4>Set up your profile</h4>
                                           <p>
                                             Setting up your profile is easy. There a few sections you’ll need to fill in before your profile can go live.. Just follow the steps. Feel free to reach out for help at any stage along the way if you get stuck!
                                           </p>
                                         </div>
                                         <div class="col-md-4 col-md-offset-2 col-sm-12 mb-xs-24">
                                           <img alt="Screenshot" src="/img/illustrations/illustrations-05.png">
                                         </div>
                                       </div>
                                       <!--end of row-->
                                     </div>
                                     <!--end of container-->
                                   </section>
                                   <section class="background-white space-sm">
                                     <div class="container">
                                       <div class="row v-align-children">
                                         <div class="col-md-6 col-md-push-6 col-sm-12">
                                           <h4>Jobs Board</h4>
                                           <p>
                                             You can check your jobs board for available tutoring jobs in your area by heading to the “jobs board” tab in your tutor dashboard. If there are any students you think you can help send them a message to offer your services. Make sure and give them plenty of information about your experience and availability to help them make a decision. We recommend checking here regularly as new jobs come through all the time.
                                           </p>
                                         </div>
                                         <div class="col-md-6 col-md-pull-6 col-sm-12 mb-xs-24">
                                           <img alt="Screenshot" src="/img/illustrations/illustrations-15.png">
                                         </div>
                                       </div>
                                       <!--end of row-->
                                     </div>
                                     <!--end of container-->
                                   </section>
                                   <section class="space-sm background-grey">
                                     <div class="container">
                                       <div class="row v-align-children">
                                         <div class="col-md-6 col-sm-12">
                                           <h4>Message</h4>
                                           <p>
                                             Once your profile is live, prospective students and parents will be able message you when they come across your profile if they are interested in arranging a booking with you. You can access your messages through our internal messaging system and we’ll notify you when you receive a new message by email.
                                           </p>
                                         </div>
                                         <div class="col-md-4 col-md-offset-2 col-sm-12 mb-xs-24">
                                           <img alt="Screenshot" src="/img/illustrations/illustrations-09.png">
                                         </div>
                                       </div>
                                       <!--end of row-->
                                     </div>
                                     <!--end of container-->
                                   </section>
                                   <section class="background-white space-md">
                                     <div class="container">
                                       <div class="row v-align-children">
                                         <div class="col-md-6 col-md-push-6 col-sm-12">
                                           <h4>Online tutoring & pre-recorded classes on ClassHub</h4>
                                           <p>
                                              Online learning allows you to access the most suitable tutor for you regardless of location, and to learn from the comfort of your own home.
                                              Once you and your tutor have agreed on a date and time, your tutor will make a booking and schedule a Zoom lesson for you.  You’ll be asked to confirm and pay for the booking in advance of the lesson.
                                            </p>
                                            <p>
                                              All ClassHub lessons are conducted using a ClassHub Zoom account, so you don’t need to use your personal account.  For tablet or smartphone access, just download the Zoom app; otherwise, simply click on the lesson link in your ClassHub messages and you’re off!
                                            </p>
                                            <p>
                                              Some tutors also offer their own pre-recorded lessons.  These allow students to access content when they need it and to reference it as often as they want.
                                           </p>
                                           <img src="/img/logo/powered-by-zoom.png" alt="powered by zoom" height="20px" />
                                         </div>
                                         <div class="col-md-6 col-md-pull-6 col-sm-12 mb-xs-24">
                                           <img alt="Screenshot" src="/img/illustrations/illustrations-16.png">
                                         </div>
                                       </div>
                                       <!--end of row-->
                                     </div>
                                     <!--end of container-->
                                   </section>
                                   <section class="space-sm background-grey">
                                     <div class="container">
                                       <div class="row v-align-children">
                                         <div class="col-md-6 col-sm-12">
                                           <h4>Create a booking</h4>
                                           <p>
                                             Once you’ve agreed a time, date and place with the prospective parent/student, you’ll use the “create booking” in your message inbox. Fill in the details and then hit “send”. Your booking will be sent to the parent/student to confirm and pay. We’ll also notify them by email to confirm the booking.
                                           </p>
                                         </div>
                                         <div class="col-md-4 col-md-offset-2 col-sm-12 mb-xs-24">
                                           <img alt="Screenshot" src="/img/illustrations/illustrations-04.png">
                                         </div>
                                       </div>
                                       <!--end of row-->
                                     </div>
                                     <!--end of container-->
                                   </section>
                                   <section class="background-white space-sm">
                                     <div class="container">
                                       <div class="row v-align-children">
                                         <div class="col-md-6 col-md-push-6 col-sm-12">
                                           <h4>Get Paid</h4>
                                           <p>
                                             We use stripe one of the world’s safest online payment portals. Once your customer has paid, we automatically send you a confirmation email and update your classes/subjects and transactional history areas in your dashboard with your new bookings. Payouts to tutors are not processed until 24 hours after a class has taken place and normally arrive in a tutors nominated bank account within 10 working days.
                                           </p>
                                         </div>
                                        <div class="col-md-6 col-md-pull-6 col-sm-12 mb-xs-24">
                                           <img alt="Screenshot" src="/img/illustrations/illustrations-07.png">
                                         </div>
                                       </div>
                                       <!--end of row-->
                                     </div>
                                     <!--end of container-->
                                   </section>

                                    <!-- end: tabs section -->
                                </div>
                            </div>
                            <!-- end : Tab panes -->

                        </div>
                    </div>
                </div>
        </section>
        <!-- end: tabs -->


        <!-- starts : benefits section -->
        <div class="benefits">
            <div class="container">
                <div class="row box m-0">
                    <div class="col-xs-12">
                        <div class="title fs-30">Benefits</div>
                        <div class="subtitle">The quick and easy way to find local experts</div>
                        <div class="row">
                            <!-- starts : column 01 -->
                            <div class="col-md-4">
                                <div class="icon-img"><img src="{{ asset('img/how-it-works/benefits/search.png') }}">
                                </div>
                                <p>Browse 100s of after school <br class="m--show"> classes</p>
                            </div>
                            <!-- end : column 01 -->
                            <!-- starts : column 02 -->
                            <div class="col-md-4 icon-02">
                                <div class="icon-img"><img src="{{ asset('img/how-it-works/benefits/wand.png') }}">
                                </div>
                                <p>Book online instantly</p>
                            </div>
                            <!-- end : column 02 -->
                            <!-- starts : column 03 -->
                            <div class="col-md-4 icon-03">
                                <div class="icon-img"><img src="{{ asset('img/how-it-works/benefits/lock.png') }}">
                                </div>
                                <p>Secure and immediate <br class="m--show"> payment</p>
                            </div>
                            <!-- end : column 03 -->
                        </div>
                    </div>


                    <div class="row showmore p-b-22">
                        <div class="col-sm-12 text-center">
                            <a href="{{ route('home') }}" class="btn btn-primary shadow-v4 m-0">
                                <span class="btn__text">FIND A LOCAL CLASS</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- end : benefits section -->


        <!-- starts : earning-suggested sections -->
        <div class="earning-suggested" id="earning-suggested">
            <div class="container">
                <div class="box">

                    <div class="row m-0">
                        <!-- starts : earning calc -->
                        <div class="col-md-6 earning-calc">
                            <div class="title fs-30 fw-5">Earning calculator <span class="info-badge"
                                                                                   data-toggle="popover"
                                                                                   data-placement="top" data-html="true"
                                                                                   data-content="Use the below calculator to estimate your earnings">i</span>
                            </div>
                            <div class="subtitle">Find out what you could earn per month</div>
                            <div class="box-inner">

                                <div
                                    class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body list-a-class">
                                    <div class="m-grid__item m-grid__item--fluid">

                                        <form class="m-form m-form--label-align-left- m-form--state-" id="m_form">
                                            <!--begin: Form Wizard-->
                                            <div class="m-wizard__form">
                                                <!--
                                                    1) Use m-form--label-align-left class to alight the form input lables to the right
                                                    2) Use m-form--state class to highlight input control borders on form validation
                                                    -->
                                                <!--begin: Form Body -->
                                                <div class="m-portlet__body">

                                                    <!-- starts : Cost per class -->
                                                    <div class="form-group m-form__group row p-b-4">
                                                        <div class="col-lg-12">
                                                            <label class="col-form-label">Cost per class</label>
                                                            <div>
                                                                <input type="number" class="form-control m-input"
                                                                       id="price" placeholder="E.g. €50">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end : Cost per class -->

                                                    <!-- starts : quantity per class -->
                                                    <div class="form-group m-form__group row p-t-0">

                                                        <div class="col-xs-6">
                                                            <label class="col-form-label">Classes per week</label>
                                                            <!--begin: Dropdown-->
                                                            <div>
                                                                <input type="number" class="form-control m-input"
                                                                       id="num-class" placeholder="E.g. 3">
                                                            </div>
                                                            <!--end: Dropdown-->
                                                        </div>

                                                        <div class="col-xs-6">
                                                            <label class="col-form-label">Pupils per class</label>
                                                            <!--begin: Dropdown-->
                                                            <div>
                                                                <input type="number" class="form-control m-input"
                                                                       id="num-pupil" placeholder="E.g. 2">
                                                            </div>
                                                            <!--end: Dropdown-->
                                                        </div>

                                                    </div>
                                                    <!-- end : quantity per class -->

                                                    <!-- starts : Cost per class -->
                                                    <div class="form-group m-form__group row p-t-3">
                                                        <div class="col-lg-12 text-right">
                                                            <div class="amount"><span class="fs-30 fw-5">
                                                                    <span id="earning-total">€ 0</span> per month</span>
                                                                <span class="info-badge" data-toggle="popover"
                                                                      data-placement="top" data-html="true"
                                                                      data-content="These estimates are net of Classhub fees. See fee structure below">&nbsp;</span>
                                                            </div>
                                                            <div class="tc p-t-10">These estimates are net of Classhub
                                                                fees. See fee structure <a href="javascript:void(0)"
                                                                                           data-toggle="modal"
                                                                                           data-target="#feeStructure">here</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end : Cost per class -->


                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>

                            </div>
                            <div class="notes fs-10">Earnings from these works are liable for income tax. Read the
                                guidelines for the evaluation of income tax <a
                                    href="https://www.revenue.ie/en/self-assessment-and-self-employment/guide-to-self-assessment/index.aspx">here</a>.
                            </div>
                        </div>
                        <!-- end : earning calc -->
                        <!-- starts : suggested rates -->
                        <div class="col-md-6 suggested-rates">
                            <div class="title fs-30 fw-5">Suggested rates <span class="info-badge" data-toggle="popover"
                                                                                data-placement="top" data-html="true"
                                                                                data-content="These rates are from research conducted by Classhub Ltd in the Irish and Dublin market">i</span>
                            </div>
                            <div class="subtitle">Check the average hourly cost for tutoring</div>
                            <div class="box-inner">

                                <table class="table m-0 head">
                                    <thead>
                                    <tr>
                                        <th>Grinds / Activities</th>
                                        <th>Cost per single class <span class="info-badge" data-toggle="popover"
                                                                        data-placement="top" data-html="true"
                                                                        data-content="These rates are based on one hour classes">i</span>
                                        </th>
                                    </tr>
                                    </thead>
                                </table>

                                <hr>

                                <div class="table-scroll">
                                    <div class="scroll-height">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <td>Primary School Subjects</td>
                                                <td>€35</td>
                                            </tr>
                                            <tr>
                                                <td>Junior Cert Subjects</td>
                                                <td>€45</td>
                                            </tr>
                                            <tr>
                                                <td>Leaving Cert Subjects</td>
                                                <td>€50</td>
                                            </tr>
                                            <tr>
                                                <td>Irish Dancing Lessons</td>
                                                <td>€40</td>
                                            </tr>
                                            <tr>
                                                <td>Music Lessons</td>
                                                <td>€30</td>
                                            </tr>
                                            <tr>
                                                <td>Arts & Crafts Lessons</td>
                                                <td>€60</td>
                                            </tr>
                                            <tr>
                                                <td>Primary School Subjects</td>
                                                <td>€35</td>
                                            </tr>
                                            <tr>
                                                <td>Junior Cert Subjects</td>
                                                <td>€45</td>
                                            </tr>
                                            <tr>
                                                <td>Leaving Cert Subjects</td>
                                                <td>€50</td>
                                            </tr>
                                            <tr>
                                                <td>Irish Dancing Lessons</td>
                                                <td>€40</td>
                                            </tr>
                                            <tr>
                                                <td>Music Lessons</td>
                                                <td>€30</td>
                                            </tr>
                                            <tr>
                                                <td>Arts & Crafts Lessons</td>
                                                <td>€60</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- end : suggested rates -->
                    </div>

                    <!-- Starts: bottom button -->
                    <div class="row showmore p-t-50 p-b-22">
                        <div class="col-sm-12 text-center">
                            <a href="{{ Auth::user() ? route('educator.profile.create') : 'javascript:;' }}"
                               {{ !Auth::user() ? 'data-toggle=modal data-target=#login-modal' : '' }}
                               class="btn btn-primary shadow-v4 m-0">
                                <span class="btn__text">LIST A CLASS</span>
                            </a>
                        </div>
                    </div>
                    <!-- End: bottom button -->

                </div>
            </div>
        </div>
        <!-- end : earning-suggested sections -->


        <!-- starts: top-activities tiles container -->
    {{--<div class="container testimonials-howitworks">

          <!-- Starts: Tiles type 01 -->
          <div class="row title-type-01">
              <div class="col-sm-12">
                  <div class="title p-b-10">Testimonials</div>
              </div>
          </div>
          <!-- Starts: Tiles type 01 -->

          <!-- Starts: Tiles type 02 -->
        {{--  <div class="row tiles-type-02 v2">

          @foreach($testimonials as $testimonial)
              <!-- starts : tile 01 -->
                  <div class="col-md-4">
                      <div class="image-tile col-eq-height">
                          <img alt="image" class="product-thumb"
                               src="{{ \App\Helpers\ClassHubHelper::getImagePath(null, $testimonial->educator_image) }}">
                          <div class="tile-details">
                              <hr>
                              <!-- starts: Rating -->
                          {{--<div class="rating v2">
                              <i class="star full"></i>
                              <i class="star full"></i>
                              <i class="star full"></i>
                              <i class="star half"></i>
                              <i class="star empty"></i>
                          </div>--}}{{--

                          @include('common.rating-v2', ['rating' => \App\Helpers\ClassHubHelper::ratings(
                              collect([new \App\LessonRating(['educator_id' => 0, 'parent_id' => 0 , 'lesson_id' => 0, 'score' => $testimonial->rating])])
                          )])
                          <!-- end: Rating -->
                              <div class="text">
                                  {{ $testimonial->content }}
                              </div>
                              <div class="name color-02">{{ $testimonial->name }}</div>
                              <div class="class">{{ $testimonial->for }}</div>
                          </div>
                      </div>
                  </div>
                  <!-- end : tile 01 -->
              @endforeach

          </div>
          <!-- End: Tiles type 02 -->

          <!-- Starts: bottom button -->--}}
    {{--<div class="row showmore p-t-55 p-b-22">
        <div class="col-sm-12 text-center">
            <a href="{{ route('home') }}" class="btn btn-primary shadow-v4 m-0">
                <span class="btn__text">BOOK A CLASS</span>
            </a>
        </div>
    </div>--}}
    <!-- End: bottom button -->

    </div>
    <!-- End: top-activities tiles container -->
    <!--starts : fee structure modal -->
    <!--starts : fee structure modal -->
    <div class="modal fade c-modal overlay-share-this" id="feeStructure"
         tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" class="p-b-0"><h5 class="m-0">How much
                        does it cost to list my class / activity?</h5>
                    <button type="button" class="close"
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
    <!--ends : fee structure modal -->
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
