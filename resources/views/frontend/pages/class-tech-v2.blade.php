@extends('frontend.layouts.master')

@section('title')
    Classhub | Class Tech
@endsection


@section('content')

    <div class="main-container p-t-0 aboutus">

        <!-- starts: hero section -->
        <!-- Starts : About Us Page Hero Image -->
        <section id="about-heading" class="hero-img type-01 no-min-height">
            <div class="image-slider slider-all-controls controls-inside">
                <ul class="slides">
                    <li class="bg-image"
                        style="background-image:url({{ asset('img/online-call-image.png') }});">
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
            <div class="container" style="color: #FFF">
                <div class="row">
                    <div class="col-md-7">
                        <h2>Speed up your transition to online teaching.</h2>
                        <p style="font-size: 20px; color: #FFF">
                            The relevance of remote engagement in
                            education has grown rapidly due to changing
                            conditions in markets. Classhub
                            Technologies powerful tools make it easy to
                            set your company up for remote teaching
                            success.
                        </p>
                        <a href="business/#contact" class="btn btn-primary">Contact Us</a>

                    </div>
                </div>
            </div>
            <!--end of container-->
        </section>
        <!-- end : About Us Page Hero Image -->
        <!-- end: hero section -->

        <!-- starts: title -->
        <div class="row">
            <div class="col-md-12 fs-23 text-center p-t-60 p-b-60 bg-primary aboutHero" style="font-weight: 500;">
                <div class="container">
                    The internet is setting the stage for lifelong learning. It’s a place where
                    students can give free rein to their curiosity and natural love of learning. In
                    school, students are passive imitators. Online, they are active creators.
                </div>
            </div>
        </div>
        <!-- end: title -->

        <!-- starts: left sqare section -->
        <section class="space-md">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h3>Next generation remote teaching features</h3>
                        <p>Connect and engage remotely with smart experiences that are flexible, simple to use, secure
                            and scalable.</p>
                    </div>
                    <div class="col-md-3">
                        <div class="feature-card">
                            <div class="flip-card-inner">
                                <div class="flip-card-front">
                                    <div class="icon-image">
                                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title/>
                                            <g data-name="Layer 2" id="Layer_2">
                                                <path
                                                    d="M20,4H4V14.76L1.38,20H22.62L20,14.76ZM14,18H10V17h4Zm4-4H15.87a3.94,3.94,0,0,0-1.48-2.2,3,3,0,1,0-4.78,0A3.94,3.94,0,0,0,8.13,14H6V6H18Z"
                                                    fill="#e74b65"/>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="tile-details team-details" style="padding-bottom: 0px">
                                        <div class="team-name">Crystal clear Audio and Video</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="feature-card">
                            <div class="flip-card-inner">
                                <div class="flip-card-front">
                                    <div class="icon-image">
                                        <svg enable-background="new 0 0 500 500" version="1.1" viewBox="0 0 500 500"
                                             xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink"><path clip-rule="evenodd"
                                                                                              d="M36.992,326.039c0,20.079,16.262,36.34,36.34,36.34h54.513v56.062  c0,10.087,8.181,18.168,18.172,18.168c5.092,0,9.714-2.095,12.989-5.448l68.78-68.781h199.881c20.078,0,36.34-16.261,36.34-36.34  V98.902c0-20.079-16.262-36.341-36.34-36.341H73.333c-20.079,0-36.34,16.262-36.34,36.341V326.039z M146.018,221.557  c0-12.536,10.177-22.713,22.713-22.713c12.536,0,22.713,10.177,22.713,22.713c0,12.537-10.177,22.713-22.713,22.713  C156.194,244.27,146.018,234.093,146.018,221.557z M227.787,221.557c0-12.536,10.177-22.713,22.713-22.713  c12.537,0,22.715,10.177,22.715,22.713c0,12.537-10.178,22.713-22.715,22.713C237.964,244.27,227.787,234.093,227.787,221.557z   M309.556,221.557c0-12.536,10.176-22.713,22.715-22.713c12.537,0,22.711,10.177,22.711,22.713  c0,12.537-10.174,22.713-22.711,22.713C319.731,244.27,309.556,234.093,309.556,221.557z"
                                                                                              fill="#e74b65"/></svg>
                                    </div>
                                    <div class="tile-details team-details" style="padding-bottom: 0px">
                                        <div class="team-name">Realtime messaging and email notifications</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="feature-card">
                            <div class="flip-card-inner">
                                <div class="flip-card-front">
                                    <div class="icon-image">
                                        <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 0h48v48H0V0z" fill="none"/>
                                            <path
                                                d="M40 36c2.2 0 3.98-1.8 3.98-4L44 12c0-2.22-1.8-4-4-4H8c-2.22 0-4 1.78-4 4v20c0 2.2 1.78 4 4 4H0v4h48v-4h-8zm-14-7.06v-4.38c-5.56 0-9.22 1.7-12 5.44 1.12-5.34 4.22-10.66 12-11.74V14l8 7.46-8 7.48z"
                                                fill="#e74b65"/>
                                        </svg>
                                    </div>
                                    <div class="tile-details team-details" style="padding-bottom: 0px">
                                        <div class="team-name">Screen and file sharing</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="feature-card">
                            <div class="flip-card-inner">
                                <div class="flip-card-front">
                                    <div class="icon-image">
                                        <svg version="1.1" viewBox="0 0 99.999995 99.999995"
                                             xmlns="http://www.w3.org/2000/svg"
                                             xmlns:cc="http://creativecommons.org/ns#"
                                             xmlns:dc="http://purl.org/dc/elements/1.1/"
                                             xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
                                             xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                                             xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                                             xmlns:svg="http://www.w3.org/2000/svg">
                                            <defs id="defs4">
                                                <filter id="filter4510" style="color-interpolation-filters:sRGB">
                                                    <feFlood flood-color="rgb(0,0,0)" flood-opacity="0.470588"
                                                             id="feFlood4512" result="flood"/>
                                                    <feComposite id="feComposite4514" in="flood" in2="SourceGraphic"
                                                                 operator="in" result="composite1"/>
                                                    <feGaussianBlur id="feGaussianBlur4516" in="composite1"
                                                                    result="blur" stdDeviation="5"/>
                                                    <feOffset dx="0" dy="4.7" id="feOffset4518" result="offset"/>
                                                    <feComposite id="feComposite4520" in="SourceGraphic" in2="offset"
                                                                 operator="over" result="composite2"/>
                                                </filter>
                                                <filter id="filter5064" style="color-interpolation-filters:sRGB">
                                                    <feFlood flood-color="rgb(206,242,245)" flood-opacity="0.835294"
                                                             id="feFlood5066" result="flood"/>
                                                    <feComposite id="feComposite5068" in="flood" in2="SourceGraphic"
                                                                 operator="out" result="composite1"/>
                                                    <feGaussianBlur id="feGaussianBlur5070" in="composite1"
                                                                    result="blur" stdDeviation="5.9"/>
                                                    <feOffset dx="0" dy="-8.1" id="feOffset5072" result="offset"/>
                                                    <feComposite id="feComposite5074" in="offset" in2="SourceGraphic"
                                                                 operator="atop" result="composite2"/>
                                                </filter>
                                                <filter id="filter5364" style="color-interpolation-filters:sRGB">
                                                    <feFlood flood-color="rgb(0,0,0)" flood-opacity="0.835294"
                                                             id="feFlood5366" result="flood"/>
                                                    <feComposite id="feComposite5368" in="flood" in2="SourceGraphic"
                                                                 operator="in" result="composite1"/>
                                                    <feGaussianBlur id="feGaussianBlur5370" in="composite1"
                                                                    result="blur" stdDeviation="5"/>
                                                    <feOffset dx="0" dy="4.2" id="feOffset5372" result="offset"/>
                                                    <feComposite id="feComposite5374" in="SourceGraphic" in2="offset"
                                                                 operator="over" result="fbSourceGraphic"/>
                                                    <feColorMatrix id="feColorMatrix5592" in="fbSourceGraphic"
                                                                   result="fbSourceGraphicAlpha"
                                                                   values="0 0 0 -1 0 0 0 0 -1 0 0 0 0 -1 0 0 0 0 1 0"/>
                                                    <feFlood flood-color="rgb(254,255,189)" flood-opacity="1"
                                                             id="feFlood5594" in="fbSourceGraphic" result="flood"/>
                                                    <feComposite id="feComposite5596" in="flood" in2="fbSourceGraphic"
                                                                 operator="out" result="composite1"/>
                                                    <feGaussianBlur id="feGaussianBlur5598" in="composite1"
                                                                    result="blur" stdDeviation="7.6"/>
                                                    <feOffset dx="0" dy="-8.1" id="feOffset5600" result="offset"/>
                                                    <feComposite id="feComposite5602" in="offset" in2="fbSourceGraphic"
                                                                 operator="atop" result="composite2"/>
                                                </filter>
                                                <filter id="filter4400" style="color-interpolation-filters:sRGB">
                                                    <feFlood flood-color="rgb(0,0,0)" flood-opacity="0.470588"
                                                             id="feFlood4402" result="flood"/>
                                                    <feComposite id="feComposite4404" in="flood" in2="SourceGraphic"
                                                                 operator="in" result="composite1"/>
                                                    <feGaussianBlur id="feGaussianBlur4406" in="composite1"
                                                                    result="blur" stdDeviation="5"/>
                                                    <feOffset dx="0" dy="5" id="feOffset4408" result="offset"/>
                                                    <feComposite id="feComposite4410" in="SourceGraphic" in2="offset"
                                                                 operator="over" result="fbSourceGraphic"/>
                                                    <feColorMatrix id="feColorMatrix4640" in="fbSourceGraphic"
                                                                   result="fbSourceGraphicAlpha"
                                                                   values="0 0 0 -1 0 0 0 0 -1 0 0 0 0 -1 0 0 0 0 1 0"/>
                                                    <feFlood flood-color="rgb(255,253,180)" flood-opacity="1"
                                                             id="feFlood4642" in="fbSourceGraphic" result="flood"/>
                                                    <feComposite id="feComposite4644" in="flood" in2="fbSourceGraphic"
                                                                 operator="out" result="composite1"/>
                                                    <feGaussianBlur id="feGaussianBlur4646" in="composite1"
                                                                    result="blur" stdDeviation="5"/>
                                                    <feOffset dx="0" dy="-5" id="feOffset4648" result="offset"/>
                                                    <feComposite id="feComposite4650" in="offset" in2="fbSourceGraphic"
                                                                 operator="atop" result="composite2"/>
                                                </filter>
                                                <filter id="filter4678" style="color-interpolation-filters:sRGB">
                                                    <feFlood flood-color="rgb(255,253,180)" flood-opacity="1"
                                                             id="feFlood4680" result="flood"/>
                                                    <feComposite id="feComposite4682" in="flood" in2="SourceGraphic"
                                                                 operator="out" result="composite1"/>
                                                    <feGaussianBlur id="feGaussianBlur4684" in="composite1"
                                                                    result="blur" stdDeviation="5"/>
                                                    <feOffset dx="0" dy="-7" id="feOffset4686" result="offset"/>
                                                    <feComposite id="feComposite4688" in="offset" in2="SourceGraphic"
                                                                 operator="atop" result="composite2"/>
                                                </filter>
                                                <filter id="filter5045" style="color-interpolation-filters:sRGB">
                                                    <feFlood flood-color="rgb(255,250,175)" flood-opacity="1"
                                                             id="feFlood5047" result="flood"/>
                                                    <feComposite id="feComposite5049" in="flood" in2="SourceGraphic"
                                                                 operator="out" result="composite1"/>
                                                    <feGaussianBlur id="feGaussianBlur5051" in="composite1"
                                                                    result="blur" stdDeviation="5"/>
                                                    <feOffset dx="0" dy="-6" id="feOffset5053" result="offset"/>
                                                    <feComposite id="feComposite5055" in="offset" in2="SourceGraphic"
                                                                 operator="atop" result="composite2"/>
                                                </filter>
                                                <filter id="filter4607" style="color-interpolation-filters:sRGB;">
                                                    <feFlood flood-color="rgb(255,247,180)" flood-opacity="1"
                                                             id="feFlood4609" result="flood"/>
                                                    <feComposite id="feComposite4611" in="flood" in2="SourceGraphic"
                                                                 operator="out" result="composite1"/>
                                                    <feGaussianBlur id="feGaussianBlur4613" in="composite1"
                                                                    result="blur" stdDeviation="5"/>
                                                    <feOffset dx="0" dy="-6" id="feOffset4615" result="offset"/>
                                                    <feComposite id="feComposite4617" in="offset" in2="SourceGraphic"
                                                                 operator="atop" result="composite2"/>
                                                </filter>
                                                <filter id="filter4507" style="color-interpolation-filters:sRGB;">
                                                    <feFlood flood-color="rgb(255,249,199)" flood-opacity="1"
                                                             id="feFlood4509" result="flood"/>
                                                    <feComposite id="feComposite4511" in="flood" in2="SourceGraphic"
                                                                 operator="out" result="composite1"/>
                                                    <feGaussianBlur id="feGaussianBlur4513" in="composite1"
                                                                    result="blur" stdDeviation="3"/>
                                                    <feOffset dx="0" dy="-2.60417" id="feOffset4515" result="offset"/>
                                                    <feComposite id="feComposite4517" in="offset" in2="SourceGraphic"
                                                                 operator="atop" result="fbSourceGraphic"/>
                                                    <feColorMatrix id="feColorMatrix4687" in="fbSourceGraphic"
                                                                   result="fbSourceGraphicAlpha"
                                                                   values="0 0 0 -1 0 0 0 0 -1 0 0 0 0 -1 0 0 0 0 1 0"/>
                                                    <feFlood flood-color="rgb(255,244,153)" flood-opacity="1"
                                                             id="feFlood4689" in="fbSourceGraphic" result="flood"/>
                                                    <feComposite id="feComposite4691" in="flood" in2="fbSourceGraphic"
                                                                 operator="out" result="composite1"/>
                                                    <feGaussianBlur id="feGaussianBlur4693" in="composite1"
                                                                    result="blur" stdDeviation="3.4"/>
                                                    <feOffset dx="0" dy="-3.9" id="feOffset4695" result="offset"/>
                                                    <feComposite id="feComposite4697" in="offset" in2="fbSourceGraphic"
                                                                 operator="atop" result="composite2"/>
                                                </filter>
                                            </defs>
                                            <g id="layer3" style="display:inline" transform="translate(0,-99.999988)">
                                                <path
                                                    d="M 20 0 C 8.9199688 0 0 8.9199688 0 20 L 0 80 C 0 91.080024 8.9199688 100 20 100 L 80 100 C 91.080024 100 100 91.080024 100 80 L 100 20 C 100 8.9199688 91.080024 0 80 0 L 20 0 z M 34.5 18.736328 L 36.25 18.736328 C 37.70425 18.736328 38.875 19.907078 38.875 21.361328 L 38.875 26.738281 C 38.875 28.192531 37.70425 29.363281 36.25 29.363281 L 34.5 29.363281 C 33.04575 29.363281 31.875 28.192531 31.875 26.738281 L 31.875 21.361328 C 31.875 19.907078 33.04575 18.736328 34.5 18.736328 z M 64.5 18.736328 L 66.25 18.736328 C 67.70425 18.736328 68.875 19.907078 68.875 21.361328 L 68.875 26.738281 C 68.875 28.192531 67.70425 29.363281 66.25 29.363281 L 64.5 29.363281 C 63.04575 29.363281 61.875 28.192531 61.875 26.738281 L 61.875 21.361328 C 61.875 19.907078 63.04575 18.736328 64.5 18.736328 z M 21.283203 25.712891 L 28.445312 25.712891 L 28.445312 26.738281 C 28.445312 30.033098 31.205193 32.792969 34.5 32.792969 L 36.25 32.792969 C 39.544807 32.792969 42.304688 30.033098 42.304688 26.738281 L 42.304688 25.712891 L 58.445312 25.712891 L 58.445312 26.738281 C 58.445312 30.033098 61.205193 32.792969 64.5 32.792969 L 66.25 32.792969 C 69.544807 32.792969 72.304688 30.033098 72.304688 26.738281 L 72.304688 25.712891 L 78.716797 25.712891 C 82.354764 25.712891 85.400391 28.758524 85.400391 32.396484 L 85.400391 74.580078 C 85.400391 78.218045 82.354764 81.263672 78.716797 81.263672 L 21.283203 81.263672 C 17.645236 81.263672 14.599609 78.218045 14.599609 74.580078 L 14.599609 32.396484 C 14.599609 28.758524 17.645236 25.712891 21.283203 25.712891 z M 22.150391 43.488281 L 22.150391 73.712891 L 77.849609 73.712891 L 77.849609 43.488281 L 22.150391 43.488281 z M 28.466797 51.619141 L 38.365234 51.619141 L 38.365234 57.982422 L 28.466797 57.982422 L 28.466797 51.619141 z M 45.050781 51.619141 L 54.949219 51.619141 L 54.949219 57.982422 L 45.050781 57.982422 L 45.050781 51.619141 z M 61.466797 51.619141 L 71.365234 51.619141 L 71.365234 57.982422 L 61.466797 57.982422 L 61.466797 51.619141 z M 28.466797 61.619141 L 38.365234 61.619141 L 38.365234 67.982422 L 28.466797 67.982422 L 28.466797 61.619141 z M 45.050781 61.619141 L 54.949219 61.619141 L 54.949219 67.982422 L 45.050781 67.982422 L 45.050781 61.619141 z M 61.466797 61.619141 L 71.365234 61.619141 L 71.365234 67.982422 L 61.466797 67.982422 L 61.466797 61.619141 z "
                                                    id="rect4208"
                                                    style="opacity:1;fill:#e74b65;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:3.79999995;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1"
                                                    transform="translate(0,99.999988)"/>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="tile-details team-details" style="padding-bottom: 0px">
                                        <div class="team-name">Scheduling tools</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- starts: left sqare section -->
        <section class="image-square bg-white left">
            <div class="col-md-6 image">
                <div class="background-image-holder" style="background: url('/img/online-class-image.jpg')">
                    <img alt="image" class="background-image" src="{{  asset('/img/online-class-image.jpg') }}"/>
                </div>
            </div>
            <div class="col-md-6 col-md-offset-1 content">
                <h4>We provide your own ClassHub powered site.</h4>
                <p class="mb0">
                    We deliver an integrated and engaging
                    e-learning experience that feels like you’re there
                    in person. Leverage the power of classhub’s
                    tools and excellent core technology. Enroll
                    learners and start teaching using our easy to
                    implement yet powerful features. ClassHub puts
                    you in the virtual classroom with your students
                    allowing you to continue teaching, working
                    together and supporting each other.
                </p>
            </div>
        </section>
        <!-- end: left sqare section -->

        <section class="space-md">
            <div class="container">
                <div class="row" style="margin-bottom: 50px">
                    <div class="col-sm-12 text-center">
                        <h3>Fast Start Bundle for schools and tutor academies</h3>
                        <p>Our bundle has all the essential tools and services you need to move teaching online.</p>
                    </div>
                </div>
                <div class="row" style="padding: 0px 50px">
                    <div class="col-md-6 col-sm-12 text-sm-center">
                        <div class="row" style="margin-bottom: 50px; padding-right: 20px">
                            <div class="col-md-2 col-sm-12 text-sm-center">
                                <svg height="50px" version="1.1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink"><title/>
                                    <desc/>
                                    <g fill="none" fill-rule="evenodd"
                                       id="Action-/-48---Action,-dashboard,-speed,-monitor,-activity-icon" stroke="none"
                                       stroke-linecap="round" stroke-linejoin="round" stroke-width="1">
                                        <path
                                            d="M6,12 C6,8.75580986 8.25154063,6 12,6 C12.5412837,6 13.0513539,6.0574637 13.5279384,6.16556377 M17.9354618,11.0597012 C17.9782484,11.3669806 18,11.6811313 18,12"
                                            id="Shape" stroke="#e74b65" stroke-width="2"/>
                                        <path
                                            d="M10.5857864,13.4142136 C9.80473785,12.633165 9.80473785,11.366835 10.5857864,10.5857864 C11.366835,9.80473785 12.633165,9.80473785 13.4142136,10.5857864 C14.1952621,11.366835 14.1952621,12.633165 13.4142136,13.4142136 C12.633165,14.1952621 11.366835,14.1952621 10.5857864,13.4142136 Z"
                                            id="Path" stroke="#e74b65" stroke-width="2"/>
                                        <line id="Path" stroke="#e74b65" stroke-width="2"
                                              transform="translate(15.519866, 8.500893) rotate(-1.340192) translate(-15.519866, -8.500893) "
                                              x1="14.0050753" x2="17.0346572" y1="9.96497162" y2="7.0368145"/>
                                        <path
                                            d="M12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 C6.4771525,22 2,17.5228475 2,12 C2,6.4771525 6.4771525,2 12,2 Z"
                                            id="Path" stroke="#e74b65" stroke-width="2"/>
                                    </g>
                                </svg>
                            </div>
                            <div class="col-md-10 col-sm-12 text-left text-sm-center">
                                <h5>Fast track implementation</h5>
                                <p>We will help you set up your portal
                                    in no time and provide a free
                                    training session to your teachers
                                    and administrators.
                                </p>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 50px; padding-right: 20px">
                            <div class="col-md-2 col-sm-12 text-sm-center">
                                <svg height="50px" id="Layer_1_1_" style="enable-background:new 0 0 16 16;"
                                     version="1.1" viewBox="0 0 16 16" xml:space="preserve"
                                     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path
                                        d="M7.5,0C6.291,0,5.282,0.859,5.05,2H0v1h5.05c0.232,1.141,1.24,2,2.45,2s2.218-0.859,2.45-2H16V2H9.95  C9.718,0.859,8.709,0,7.5,0z"
                                        fill="#e74b65"/>
                                    <path
                                        d="M12.5,6c-1.209,0-2.218,0.859-2.45,2H0v1h10.05c0.232,1.141,1.24,2,2.45,2s2.218-0.859,2.45-2H16V8h-1.05  C14.718,6.859,13.709,6,12.5,6z"
                                        fill="#e74b65"/>
                                    <path
                                        d="M5.5,11c-1.209,0-2.218,0.859-2.45,2H0v1h3.05c0.232,1.141,1.24,2,2.45,2s2.218-0.859,2.45-2H16v-1H7.95  C7.718,11.859,6.709,11,5.5,11z"
                                        fill="#e74b65"/></svg>
                            </div>
                            <div class="col-md-10 col-sm-12 text-left text-sm-center">
                                <h5>Customization package</h5>
                                <p>We will take care of customizing your
                                    portal with a custom color scheme,
                                    images, and add your school logo.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 text-left text-sm-center">
                        <div class="row" style="margin-bottom: 50px;">
                            <div class="col-md-2 col-sm-12 text-sm-center">
                                <svg height="50px" id="Layer_1" style="enable-background:new 0 0 50 50;" version="1.1"
                                     viewBox="0 0 50 50" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink"><style type="text/css">
                                        .st0 {
                                            fill: #e74b65;
                                        }

                                        .st1 {
                                            fill: #e74b65;
                                        }

                                        .st2 {
                                            fill: #FFFFFF;
                                        }
                                    </style>
                                    <g>
                                        <g>
                                            <path class="st0"
                                                  d="M44.7,16l-5.2-8.9c-0.4-0.6-1.1-1-1.8-1h-35C1.8,6.1,1,6.9,1,7.8v18.5c0,1,0.8,1.7,1.7,1.7h35    c0.7,0,1.4-0.4,1.8-1l5.2-8.9C45.1,17.5,45.1,16.7,44.7,16z M38.6,19.1c-1.1,0-2-0.9-2-2s0.9-2,2-2c1.1,0,2,0.9,2,2    S39.7,19.1,38.6,19.1z"/>
                                        </g>
                                        <g>
                                            <path class="st1"
                                                  d="M28.9,43.9c-0.3,0-0.7,0-1-0.1c-1.3-0.2-2.5-0.8-3.3-1.8c-1.3-1.6-1.7-4.2-1-6.5c0.7-1.9,2.1-3.6,4-4.5    c1.4-0.7,3.1-1.1,5.2-1.1c0.8,0,1.6,0,2.4,0c0.9,0,1.7,0.1,2.5,0c2.1-0.1,4.1-0.5,6.1-1.2c0.9-0.4,2-0.8,2.6-1.8    c0.8-1.2,0.9-3.1,0.2-4.7c-0.6-1.4-1.7-2.5-3.2-3.2c-1.4-0.6-3-0.8-4.5-0.9c-0.5,0-1-0.5-0.9-1c0-0.5,0.5-1,1-0.9    c1.7,0.1,3.5,0.3,5.2,1c1.9,0.9,3.4,2.4,4.2,4.2c0.9,2.2,0.8,4.8-0.4,6.6c-0.9,1.4-2.4,2.1-3.5,2.5c-2.2,0.8-4.4,1.3-6.7,1.3    c-0.9,0-1.8,0-2.7,0c-0.8,0-1.5-0.1-2.3,0c-1.8,0-3.2,0.3-4.4,0.9c-1.4,0.7-2.5,2-3,3.4c-0.5,1.6-0.3,3.5,0.6,4.6    c0.6,0.8,1.5,1,2.1,1.1c1.9,0.3,3.9-0.7,5.2-2.5c0.3-0.4,0.9-0.6,1.4-0.3s0.6,0.9,0.3,1.4C33.5,42.6,31.2,43.9,28.9,43.9z"/>
                                        </g>
                                        <g>
                                            <path class="st2" d="M7.8,14.6v1.9H11v1.1H7.8v2.9H6.6v-7.1h4.7l0,1.1H7.8z"/>
                                            <path class="st2"
                                                  d="M18.4,15.8c0,1.2-0.5,1.9-1.5,2.2l1.9,2.6h-1.5l-1.7-2.4H14v2.4h-1.2v-7.1h2.6c1.1,0,1.9,0.2,2.3,0.5    C18.2,14.4,18.4,15,18.4,15.8z M16.8,16.8c0.2-0.2,0.4-0.5,0.4-1c0-0.5-0.1-0.8-0.4-1c-0.3-0.2-0.7-0.3-1.3-0.3H14v2.5h1.5    C16.1,17.1,16.6,17,16.8,16.8z"/>
                                            <path class="st2"
                                                  d="M25.1,13.5v1.1h-3.8v1.9h3.4v1.1h-3.4v1.9h3.9v1.1h-5.1v-7.1H25.1z"/>
                                            <path class="st2"
                                                  d="M31.8,13.5v1.1H28v1.9h3.4v1.1H28v1.9h3.9v1.1h-5.1v-7.1H31.8z"/>
                                        </g>
                                    </g></svg>
                            </div>
                            <div class="col-md-10 col-sm-12 text-left text-sm-center">
                                <h5>30-Day free trial</h5>
                                <p>Get access to all our powerful features
                                    such as scheduling tools, email
                                    notifications, Screen / file sharing, crystal
                                    clear audio and video and more.
                                </p>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 50px;">
                            <div class="col-md-2 col-sm-12 text-sm-center">
                                <svg height="50px" id="Layer_1" style="enable-background:new 0 0 1024 1024;"
                                     version="1.1" viewBox="0 0 1024 1024" xml:space="preserve"
                                     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path
                                        d="M911.9,349.6c-21.7-53.5-53.6-101.6-94.8-142.8c-41.2-41.2-89.2-73.1-142.8-94.8  C622.7,91.1,568,80.5,512,80.5s-110.7,10.6-162.4,31.6c-53.5,21.7-101.6,53.6-142.8,94.8c-41.2,41.2-73.1,89.2-94.8,142.8  C91.1,401.3,80.5,456,80.5,512c0,56,10.6,110.7,31.6,162.4c21.7,53.5,53.6,101.6,94.8,142.8c41.2,41.2,89.2,73.1,142.8,94.8  c51.7,21,106.3,31.6,162.4,31.6s110.7-10.6,162.4-31.6c53.5-21.7,101.6-53.6,142.8-94.8c41.2-41.2,73.1-89.2,94.8-142.8  c21-51.7,31.6-106.3,31.6-162.4C943.5,456,932.9,401.3,911.9,349.6z M532,756h-40v-60h40V756z M636.5,488.9  c-12.1,21-29.4,38.8-50.2,51.3l-0.7,0.4c-1.1,0.6-2.3,1.1-3.5,1.9c-31.3,19-50,52.5-50,88.5h-40c0-25,6.6-49.7,19.1-71.4  c12.1-21,29.4-38.7,50.2-51.2c1.5-0.9,3.1-1.8,4.6-2.6c31.1-19,49.7-52,49.7-88.4c0-57.1-46.5-103.7-103.6-103.7  S408.4,360,408.4,417h-40c0-79,64.4-143.4,143.6-143.4s143.6,64.5,143.6,143.7C655.6,442.4,649,467.2,636.5,488.9z"
                                        id="XMLID_120_" fill="#e74b65"/>
                                    <g id="XMLID_1_"/>
                                    <g id="XMLID_2_"/>
                                    <g id="XMLID_3_"/>
                                    <g id="XMLID_4_"/>
                                    <g id="XMLID_5_"/></svg>
                            </div>
                            <div class="col-md-10 col-sm-12 text-left text-sm-center">
                                <h5>Technical support</h5>
                                <p>Premium support is included during the
                                    30-day free trial so you receive full support
                                    with anything you need.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white">
            <div class="container">
                <!--end of row-->
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h3>GET A QUOTE</h3>
                        <p>Contact us today and set your company up for remote teaching success</p>
                    </div>
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">
                        <div class="pricing-table pt-2 emphasis text-center">
                            <ul style="margin-top: 30px">
                                <li>
                                    <strong>Fast track</strong> implementation and onboarding
                                </li>
                                <li>
                                    <strong>30-Day</strong> free trial
                                </li>
                                <li>
                                    <strong>Customization</strong> package
                                </li>
                                <li>
                                    <strong>Premium</strong> support
                                </li>
                                <li>
                                    <strong>Next generation</strong> remote teaching tools
                                </li>
                                <li>
                                    <strong>Integrated</strong> ecommerce
                                </li>
                                <li>
                                    <strong>Scheduling</strong> tools
                                </li>
                                <li>
                                    <strong>Fully responsive</strong> design works on all devices
                                </li>
                                <li>
                                    <strong>Beautiful</strong> modern easy to use interface
                                </li>
                            </ul>

                            <a class="btn btn-white btn-lg" href="business/#contact">Get a Quote</a>
                        </div>
                        <!--end of pricing table-->
                    </div>

                </div>
                <!--end of row-->
            </div>
            <!--end of container-->
        </section>


        <section id="contact">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-5">
                        <h4 class="uppercase">Get In Touch</h4>
                        <p>
                            Contact us using our contact form and a member of our team will respond shortly!
                        </p>
                        <hr>
                        <p>
                            Classhub Technologies <br>
                            Drumcondra Business Centre, <br>
                            118 Dromcondra Rd Upper, <br>
                            Dublin 9. <br>
                            D09 W9H0 <br>
                            Ireland

                        </p>
                    </div>
                    <div class="col-sm-6 col-md-5 col-md-offset-1">
                        <form class="form-email" action="{{ route('post.ch.enquiry') }}" id="ch-enquiry">
                            {!! csrf_field() !!}
                            <input type="text" required class="validate-required field-error" name="name"
                                   placeholder="Your Name">
                            <input type="text" required class="validate-required validate-email field-error"
                                   name="email" placeholder="Email Address">
                            <textarea required class="validate-required field-error contact-form-textarea"
                                      name="message" rows="4" placeholder="Message"></textarea>
                            <button type="submit" id="business-contact" class="btn">Send Message</button>
                        </form>

                        <div id="response" class="col-12">
                        </div>
                    </div>
                </div>
                <!--end of row-->
            </div>
            <!--end of container-->
        </section>
        <?php
        /*if (isset($_POST['submit'])) {
            $to = "conor@mosaic.ie"; // this is your Email address
            $from = $_POST['email']; // this is the sender's Email address
            $name = $_POST['name'];
            $subject = "Classhub Tech Form Submission";
            $message = $name . " wrote the following:" . "\n\n" . $_POST['message'];

            $headers = "From:" . $from;
            $headers2 = "From:" . $to;

            echo "Mail Sent. Thank you, we will contact you shortly.";
            // You can also use header('Location: thank_you.php'); to redirect to another page.
            // You cannot use header and echo together. It's one or the other.
        }*/
        ?>

    </div>


@endsection

@section('page_scripts')
    <script type="text/javascript">
        $(function () {

            $('form#ch-enquiry').on('submit', function (evt) {
                evt.preventDefault();
                $('div#response').html(``);
                var _this = $(this);

                $(this).find('button[type="submit"]').prop('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: '{{ route('post.ch.enquiry') }}',
                    data: $(this).serialize(),
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.status) {
                            $('div#response').html(`<div class="alert alert-success">${data.messages.join('<br>')}</div>`)
                        } else {
                            $('div#response').html(`<div class="alert alert-danger">${data.messages.join('<br>')}</div>`)
                        }

                        $(_this).find('button[type="submit"]').prop('disabled', false);
                    },
                    error: function (data) {
                        $('div#response').html(`<div class="alert alert-danger">${data.messages.join('<br>')}</div>`)
                        $(_this).find('button[type="submit"]').prop('disabled', false);
                    }
                })

                return false;
            })
        })
    </script>
@endsection
