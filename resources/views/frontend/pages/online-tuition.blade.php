@extends('frontend.layouts.master')

@section('title')
    Classhub | Online Tuition
@endsection


@section('content')

    <div class="main-container p-t-0 p-b-0 aboutus">

      <!-- Starts : Online Tuition Hero Image -->
      <!--<section id="about-heading" class="background-white hero-img type-01 no-min-height">
          <div class="container">
              <div class="row">
                  <div class="col-md-6">
                    <h2 style="margin-top: 50px">HOW ONLINE TUITION WORKS ON CLASSHUB</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                  </div>
                  <div class="col-md-5 col-md-offset-1">
                    <img alt="about banner" src="/img/online-tuition/video-call-foreground.png" height="350px">
                  </div>
              </div>
          </div>
      </section> -->
      <section class="image-bg hero-img type-01 no-min-height">
      <!-- <div class="background-image-holder">
              <img alt="image" class="background-image" src="{{ asset('img/hero-images/how-it-works-2.jpg') }}"/>
          </div>
          <span class="gradient-layer type-02"></span> -->
          <!-- starts: Image slider -->
          <div class="image-slider slider-all-controls controls-inside">
              <ul class="slides">
                  <li class="bg-image"
                      style="background-image:url({{ asset('img/online-tuition/video-call-banner.jpg') }});">
                      &nbsp;
                  </li>
              </ul>
          </div>
          <!-- End: Image -->
          <div class="container">
              <div class="row">
                  <div class="col-md-8">
                      <div class="box">
                          <h2 style="margin: 100px 0; ">HOW ONLINE TUITION WORKS ON CLASSHUB</h2>
                          <h5></h5>
                      </div>
                  </div>
              </div>
          </div>
          <!--end of container-->
      </section>
      <!-- end : Online Tuition Hero Image -->

      <!-- starts: title -->
      <div class="container text-type-2 shadow-v4">
          <div class="row">
              <div class="col-md-6" style="padding: 2% 3% 3%">
                  <h4>Achieve higher grades with ClassHub online tutors</h4>
                  <p>
                    Online learning allows you access the most suitable tutor for you regardless of location, and learn from the comfort of your own home.
                    <br><br>
                    Some tutors/grinds also offer their own pre-recorded lessons.  With pre-recorded classes, students can access content when they need it and as return to reference it as often as they want.
                  </p>
                  <img src="/img/logo/powered-by-zoom.png" alt="powered by zoom" height="20px" />

              </div>
              <div class="col-md-5 col-md-offset-1">
                <img src="img/online-tuition/higher-grades-image.jpg" alt="video call">
              </div>
          </div>
      </div>
      <!-- end: title -->
      <section class="background-grey">
        <div class="container">
          <h4 class="text-center">A Powerful Learning Experience</h4>
          <div class="row">
            <div class="col-md-3 col-sm-12 text-sm-center">
              <div class="row" style="margin-bottom: 50px">
                <div class="col-md-2 col-sm-12 text-sm-center">
                  <img src="img/online-tuition/1-1.png" alt="1 to 1 learning icon">
                </div>
                <div class="col-md-10 col-sm-12 text-left text-sm-center">
                  <h5>1 -to 1 Learning</h5>
                  <p>See and speak to your tutor live through your webcam</p>
                </div>
              </div>
              <div class="row" style="margin-bottom: 50px">
                <div class="col-md-2 col-sm-12 text-left text-sm-center">
                  <img src="img/online-tuition/screen-share.png" alt="screen sharing icon">
                </div>
                <div class="col-md-10 col-sm-12 text-left text-sm-center">
                  <h5>Screen Sharing</h5>
                  <p>Share screens in realtime and keep up to date with work</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-12 text-center">
              <img src="img/online-tuition/video-call-screen.png" alt="video call screen">
              <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-1 col-sm-12 text-left text-sm-center">
                  <img src="img/online-tuition/recorded-icon.png" alt="recorded class icon">
                </div>
                <div class="col-md-6 col-sm-12 text-left text-sm-center">
                  <h5>Pre-Recorded Classes</h5>
                  <p>Market, sell, and deliver your own pre-recorded courses and classes.</p>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-12 text-left text-sm-center">
              <div class="row" style="margin-bottom: 50px">
                <div class="col-md-2 col-sm-12 text-left text-sm-center">
                  <img src="img/online-tuition/document.png" alt="Shared Documents icon">
                </div>
                <div class="col-md-10 col-sm-12 text-left text-sm-center">
                  <h5>Shared Documents</h5>
                  <p>Share past papers, essays or documents with each other</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2 col-sm-12 text-sm-center">
                  <img src="img/online-tuition/chat.png" alt="chat icon">
                </div>
                <div class="col-md-10 col-sm-12 text-left text-sm-center">
                  <h5>Instant Chat</h5>
                  <p>Type answers and questions to each other live on screen</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 col-sm-12 text-left text-sm-center">
                  <img src="/img/logo/powered-by-zoom.png" alt="powered by zoom" height="20px" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="space-sm background-grey">
        <div class="container">
          <div class="row v-align-children">
            <div class="col-md-6 col-sm-12">
              <h4>Search or Request a Tutor.</h4>
              <p>
                On Classhub you have options when looking for your perfect online tutor or activity. From the homepage you can search tutors by subject, activity and location or you can request a tutor which will send your request to all the tutors that match your search criteria
              </p>
            </div>
            <div class="col-md-4 col-md-offset-2 col-sm-12 mb-xs-24">
              <img alt="Screenshot" src="/img/online-tuition/illustrations-02.png">
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
              <h4>Message Tutors and agree lessons</h4>
              <p>
                After you message your tutor and once you have agreed a time with your tutor, they will make a booking for you. You'll be asked to confirm and pay for this booking.
              </p>
            </div>
            <div class="col-md-6 col-md-pull-6 col-sm-12 mb-xs-24">
              <img alt="Screenshot" src="/img/online-tuition/illustrations-08.png">
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
              <h4>Bookings and Payments for Online Lessons</h4>
              <p>
                Once your payment is made we automatically send you a confirmation email with receipt and update your bookings area with your new lessons.
              </p>
            </div>
            <div class="col-md-4 col-md-offset-2 col-sm-12 mb-xs-24">
              <img alt="Screenshot" src="/img/online-tuition/illustrations-09.png">
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
              <h4>Getting into your ClassHub lesson</h4>
              <p>
                When your ClassHub lesson is about to start, you will receive a pop-up message, asking you to join the lesson via Zoom.  Simply click ‘Join’ and you’re in!
              </p>
              <p>
                Note: we recommend joining 2-3 minutes before your class starts, so that you can check microphone, video and any other relevant material you intend to use.
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
    </div>


@endsection

@section('page_scripts')
    <script src="{{ asset('js/flexslider.min.js') }}"></script>
@endsection
