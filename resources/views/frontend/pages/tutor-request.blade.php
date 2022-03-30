@extends('frontend.layouts.master')

@section('title')
    Request a Tutor | Classhub
@endsection

@section('meta_tags')
    <meta name="description" content="Request a tutor on Classhub and find the perfect tutor for your grinds">
@endsection

@section('page_styles')
@endsection

@section('content')

    <div class="main-container p-t-0">

        <!-- Starts : Request a Tutor page Hero Image -->
        <section class="image-bg hero-img trust-hero-img type-01 no-min-height">
            <!-- starts: Image slider -->
            <div class="image-slider slider-all-controls controls-inside">
                <ul class="slides">
                    <li class="bg-image"
                        style="background-image:url({{ asset('img/hero-images/tutor-request.jpg') }}); background-position: 59% 10%;">
                        &nbsp;
                    </li>
                </ul>
            </div>
            <!-- End: Image -->
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="box">
                            <h1>Find the best tutors available.</h1>
                            <p>Submit your tuition request and get responses from classhub tutors that have been
                                shortlisted specifically for you.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--  end : Request a Tutor Page Hero Image -->
        <!--  start : Request a Tutor Form -->
        <section class="tutor-request-section">
            <div class="container">
                <div class="row request-tutor-form">

                    <div class="col-md-6">
                        <form style="height: 100%;" id="request-tutor" type="POST"
                              action="{{ route('post.request.tutor') }}">
                            {!! csrf_field() !!}
                            <h5 class="label">Step 1. Choose your grind or activity</h5>
                            <div class="form-group m-form__group">
                                <!--begin: Dropdown-->
                                <div class="m-dropdown m-dropdown--arrow c-dd-menu" m-dropdown-toggle="click"
                                     style="display: block !important;">
                                    <a id="search-category-title" href="javascript:void(0)"
                                       style="display: block !important;"
                                       class="m-dropdown__toggle btn dropdown-toggle">All
                                        grinds / activities</a>
                                    <div class="m-dropdown__wrapper category-drop">
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__body homeCategorySearch">
                                                <div class="m-dropdown__content">
                                                    <div class="scrollable">

                                                        <!-- starts, list options -->
                                                    @include('educator.includes.category-select',
                                                        [
                                                            'name' => 'category',
                                                            'type' => 'radio',
                                                            'subjects' => isset($selectedSubjects) ? $selectedSubjects :
                                                                [isset($categoryId) ? $categoryId : null],
                                                        ])
                                                    <!-- end, list options -->

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Dropdown-->
                            </div>
                            <h5 class="label">Step 2. Where would you like your lessons?</h5>
                            <div class="form-group m-form__group row">
                                <!--begin: Radio Buttons-->
                                <div class="col-md-12">
                                    <div class="inputGroup">
                                        <input id="radio3" name="location" type="radio" value="Online" checked/>
                                        <label for="radio3">Online</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                  <span class="text-danger" style="font-size: 14px">Due to COVID-19 restrictions we are encouraging our community to use our online tuition feature</span>
                                </div>
                                <div class="col-md-12">
                                    <div class="inputGroup disabled-radio">
                                        <input id="radio1" name="location" type="radio" value="My Home" disabled/>
                                        <label for="radio1">My Home</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="inputGroup disabled-radio">
                                        <input id="radio2" name="location" type="radio" value="Tutor's Home" disabled/>
                                        <label for="radio2">Tutor's Home</label>
                                    </div>
                                </div>
                                <!--end: Radio Buttons-->
                            </div>

                            <div id="county-container" style="display: none">
                                <h5 class="label">Step 3. What area are you in?</h5>
                                <div class="form-group m-form__group">
                                    <!--begin: Dropdown-->
                                    <div class="m-dropdown m-dropdown--arrow c-dd-menu" m-dropdown-toggle="click">
                                        <a id="area-select-title" href="javascript:void(0)"
                                           class="m-dropdown__toggle btn dropdown-toggle">

                                        </a>
                                        <div class="m-dropdown__wrapper">
                                            <div class="m-dropdown__inner">
                                                <div class="m-dropdown__body p-0">
                                                    <div class="m-dropdown__content">
                                                        <input type="text" name="area" hidden>
                                                        <div class="list-menu">
                                                            <ul>
                                                                @php
                                                                    $areas = \App\Area::where('type', 'location')->get();
                                                                @endphp
                                                                @foreach( $areas as $area)
                                                                    <li><a class="area-select" area="{{ $area->id }}"
                                                                           href="javascript:void(0);">{{ $area->address }}</a>
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
                            </div>

                            <h5 class="label">Describe what you're looking for</h5>
                            <div class="tips" id="tips">
                                <div class="panel-group">
                                    <div class="panel panel-default">
                                        <a data-toggle="collapse" href="#collapse1" aria-expanded="false">
                                            <div class="panel-heading">
                                                <h4 class="panel-title"><i class="la la-pencil"></i> Some tips for
                                                    writing a
                                                    good request
                                                </h4>
                                            </div>
                                        </a>
                                        <div id="collapse1" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <p>In order for us to help find you the best tutor for you we need as
                                                    much
                                                    information as possible about the type of tutor and tuition.</p>
                                                <ul>
                                                    <li>Why are you looking for tuition? - Maybe there is a certain exam
                                                        coming up that you need help with or you are beginning
                                                        preparation
                                                        for an upcoming summer, winter or midterm test? Or mock exams?
                                                        It’s
                                                        good to add this information to your request.
                                                    </li>
                                                    <li>What is the outcome you achieve to get? Are you trying to reach
                                                        a
                                                        certain grade or is there a specific area that you need to focus
                                                        on?
                                                    </li>
                                                    <li>Add in the school year that's relevant to you, for example 2nd
                                                        year
                                                        or 6th year
                                                    </li>
                                                    <li>The days and times you are available for tuition</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group">
                                <!--begin: Message Box-->
                                {{--<textarea class="form-control" id="messageBox" name="message" rows="10"  data-html="true" data-toggle="popover" data-trigger="focus" title="<h4 class='panel-title'><i class='la la-pencil'></i> Some tips for
                                    writing a
                                    good request
                                </h4>" data-content="<p>In order for us to help find you the best tutor for you we need as
                                    much
                                    information as possible about the type of tutor and tuition.</p>
                                <ul>
                                    <li>Why are you looking for tuition? - Maybe there is a certain exam
                                        coming up that you need help with or you are beginning
                                        preparation
                                        for an upcoming summer, winter or midterm test? Or mock exams?
                                        It’s
                                        good to add this information to your request.
                                    </li>
                                    <li>What is the outcome you achieve to get? Are you trying to reach
                                        a
                                        certain grade or is there a specific area that you need to focus
                                        on?
                                    </li>
                                    <li>Add in the school year that's relevant to you, for example 2nd
                                        year
                                        or 6th year
                                    </li>
                                    <li>The days and times you are available for tuition</li>
                                </ul>" data-placement="right"></textarea>--}}
                                <textarea class="form-control" id="messageBox" name="message" rows="10"
                                          required></textarea>
                                <!--end: Message Box-->
                            </div>
                            <div class="form-group m-form__group">
                                <button id="submit-form" class="btn btn-primary text-center" style="width: 100%"
                                        type="submit">Submit Request
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div style="height: 100%;">
                            <div class="slideshow" id="slideshow">
                                <!-- Slideshow container -->
                                <div class="slideshow-container">

                                    <!-- Full-width slides/quotes -->
                                    <div class="mySlides">
                                        <h5 class="slide-label">How It Works!</h5>
                                        <img src="img/request-tutor-slides/search@2x.png" height="100px">
                                        <p>Its free to request a tutor on ClassHub and after you submit what you're
                                            looking
                                            for, we do the hard work for you and send your request to matching tutors.
                                            They
                                            will then get in touch with you by sending you a message to your ClassHub
                                            inbox.</p>
                                    </div>

                                    <div class="mySlides">
                                        <h5 class="slide-label">What Happens Next?</h5>
                                        <img src="img/request-tutor-slides/choose@2x.png" height="100px">
                                        <p>When the Tutors start responding to your request you can review their
                                            profiles,
                                            view their subjects and qualifications and ask as many questions as you
                                            like.
                                            You are in control when requesting a tutor on ClassHub.</p>
                                    </div>

                                    <div class="mySlides">
                                        <h5 class="slide-label">Found the right Tutor?</h5>
                                        <img src="img/request-tutor-slides/learn@2x.png" height="100px">
                                        <p>When you are happy that you have found the right tutor and have agreed the
                                            details of your lessons, the tutor will then create a booking specifically
                                            for
                                            you and send it to your Classhub Inbox for you to accept and pay for. When
                                            payment is made we automatically update your bookings area with your new
                                            lessons.</p>
                                    </div>
                                </div>
                                <!-- Dots/bullets/indicators -->
                                <div class="dot-container">
                                    <span class="dot" onclick="currentSlide(1)"></span>
                                    <span class="dot" onclick="currentSlide(2)"></span>
                                    <span class="dot" onclick="currentSlide(3)"></span>
                                </div>
                            </div>
                            <div class="only-desktop writing-tips">
                                <div class="tips-head">
                                    <h4 class='panel-title'><i class='la la-pencil'></i>
                                        Some tips for writing a good request
                                    </h4>
                                </div>
                                <div class="tips-body">
                                    <p>In order for us to help find you the best tutor for you we need as much
                                        information as possible about the type of tutor and tuition.</p>
                                    <ul>
                                        <li>
                                            Why are you looking for tuition? - Maybe there is a certain exam coming up
                                            that you need help with or you are beginning preparation for an upcoming
                                            summer, winter or midterm test? Or mock exams? It’s good to add this
                                            information to your request.
                                        </li>
                                        <li>
                                            What is the outcome you achieve to get? Are you trying to reach a certain
                                            grade or is there a specific area that you need to focus on?
                                        </li>
                                        <li>
                                            Add in the school year that's relevant to you, for example 2nd year or 6th
                                            year
                                        </li>
                                        <li>
                                            The days and times you are available for tuition
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @if(request()->get('category_id'))
        <?php
        $areaName = '';
        try {
            $areaName = \App\Area::findOrFail(request()->area_id)->address;
        } catch (\Exception $e) {
        }
        ?>
    @endif
@endsection

@section('page_scripts')

    <div class="modal fade c-modal overlay-share-this" id="request-success-modal"
         tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="padding-top: 30px;">
                {{--<div class="modal-header" class="p-b-0">
                    <button type="button" class="close"
                            data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">
                            &times;
                          </span>
                    </button>
                </div>--}}
                <div class="modal-body" style="padding-top: 0px;">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="tc p-t-0">
                                <h4>Thank you for requesting a tutor on Classhub…</h4>
                            </div>
                        </div>
                        <div class="col-lg-66 col-md-6">
                            <div class="tc p-t-0">
                                <img
                                    src="{{ asset('img/request-tutor-slides/request-modal-img.png') }}"
                                    alt="" style="padding-bottom:20px;">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <h5>What happens now?</h5>
                            <p>We will now get to work sending your request to the most suitable tutors that match
                                your request criteria and ask them to get in touch. We will notify you by email when
                                you have messages in your Classhub inbox from tutors responding. </p>
                        </div>
                        <div class="col-lg-12">
                            <h5>While that happens...</h5>
                            <p>In order to give yourself the best chance to find the best tutor as soon as possible,
                                have a look at the tutors we have online that match your criteria and send them a
                                message if they look like the right fit. </p>
                        </div>
                        <div class="col-lg-12 text-center">
                            <a href="#" class="btn btn-primary" id="tutors-link">View Tutors</a>
                        </div>
                        <div class="col-lg-12 text-center">
                                <span style="font-size: 12px;">If you need any help at any point you can email us at <a
                                        href="mailto:support@classhub.ie">support@classhub.ie</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--ends : fee structure modal -->
    </div>


    <script type="text/javascript">
        var tutorsLink;
        var categoryId;
        var successModal = $('div#request-success-modal');

        $(document).ready(function () {
            var areaId = "{{ $areaId ? $areaId : null }}";
            if (areaId == null || areaId == "") {
                areaId = $('a.area-select').attr('area');
            }
            handleAreaSelected(areaId);
            setupDropdownListeners();
        })

        function setupDropdownListeners() {
            $('a.area-select').on('click', function () {
                var areaId = $(this).attr('area');
                handleAreaSelected(areaId);
            })
        }

        $('dt.reset-category').on('click', function () {
            $('a#search-category-title').html('All grinds / activities')
            $('dl.category-dropdown input').attr('checked', false)
            $('a#search-category-title').click()
            $('li.parent-category').removeClass('active')
            $('li.category-sub').removeClass('active')
            $('ul.sub-category-list').removeClass('sub-category-show')
            categoryId = null;
            $('input[name="category"]').val(categoryId);
        })


        function handleAreaSelected(areaId) {
            var title = $('a.area-select[area="' + areaId + '"]').text();
            $('input[name="area"]').val(areaId);
            $('#area-select-title').text(title);
        }

        // Hack for search form not submitting caetgory on back button press
        $('#search-form').on('submit', function () {
            var requestString = $(this).serialize();
            if (requestString.indexOf('category_id') === -1) {
                $(this).append('<input type="hidden" name="category" value="' + categoryId ? categoryId : '' + '">');
            }
            return true
        })

        $('body').on('click', 'button#submit-form', function (e) {
            e.preventDefault()
            $(resultModal).modal('show')
            $.ajax({
                type: 'POST',
                url: '{{ route('post.request.tutor') }}',
                data: $('form#request-tutor').serialize(),
                dataType: 'json',
                success: function (data) {
                    if (data.status) {
                        tutorsLink = data.url
                        $(resultModal).modal('hide')
                        $(successModal).find('a#tutors-link').attr('href', data.url)
                        $(successModal).modal('show')

                        pushDataLayer()
                    } else {
                        if (data.signup_required) {
                            $(resultModal).modal('hide')
                            $('div#signup-modal').modal('show')
                            $('form#signup-form').append('<input type="hidden" name="request_tutor" value="1">')
                            $('form#login-form').append('<input type="hidden" name="request_tutor" value="1">')
                        } else {
                            $('form#signup-form #signup-btn').prop('disabled', false)
                            $('form#login-form #signup-btn').prop('disabled', false)
                            $('form#signup-form input[name="request_tutor"]').remove()
                            $('form#login-form input[name="request_tutor"]').remove()
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    }
                },
                error: function (data) {
                    console.log(data)
                    //$(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                }
            })
            return false;
        })

        function pushDataLayer() {
            const parentCategory = $(`input[value='${categoryId}']`).attr('data-parent-category');
            const subCategory = $(`input[value='${categoryId}']`).attr('data-sub-category');

            window.dataLayer.push({
                event: 'tutor_request',
                formName: 'Tutor Request Form',
                parentCategory,
                subCategory
            })
        }
    </script>


    <script>
        var slideIndex = 1;

        var myTimer;

        var slideshowContainer;

        window.addEventListener("load", function () {
            showSlides(slideIndex);
            myTimer = setInterval(function () {
                plusSlides(1)
            }, 4000);

            //COMMENT OUT THE LINE BELOW TO KEEP ARROWS PART OF MOUSEENTER PAUSE/RESUME
            slideshowContainer = document.getElementsByClassName('slideshow-inner')[0];

            //UNCOMMENT OUT THE LINE BELOW TO KEEP ARROWS PART OF MOUSEENTER PAUSE/RESUME
            // slideshowContainer = document.getElementsByClassName('slideshow-container')[0];

            slideshowContainer.addEventListener('mouseenter', pause)
            slideshowContainer.addEventListener('mouseleave', resume)
        })

        // NEXT AND PREVIOUS CONTROL
        function plusSlides(n) {
            clearInterval(myTimer);
            if (n < 0) {
                showSlides(slideIndex -= 1);
            } else {
                showSlides(slideIndex += 1);
            }

            //COMMENT OUT THE LINES BELOW TO KEEP ARROWS PART OF MOUSEENTER PAUSE/RESUME

            if (n === -1) {
                myTimer = setInterval(function () {
                    plusSlides(n + 2)
                }, 4000);
            } else {
                myTimer = setInterval(function () {
                    plusSlides(n + 1)
                }, 4000);
            }
        }

        //Controls the current slide and resets interval if needed
        function currentSlide(n) {
            clearInterval(myTimer);
            myTimer = setInterval(function () {
                plusSlides(n + 1)
            }, 4000);
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
        }

        pause = () => {
            clearInterval(myTimer);
        }

        resume = () => {
            clearInterval(myTimer);
            myTimer = setInterval(function () {
                plusSlides(slideIndex)
            }, 4000);
        }
    </script>
    <script>
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover();

            $(successModal).on('hidden.bs.modal', function (e) {
                window.location = tutorsLink
            })

            $('input[name="location"]').on('click', function () {
                if ($(this).val() === 'Online') {
                    $('div#county-container').css('display', 'none')
                } else {
                    $('div#county-container').css('display', 'block')
                }
            })
        });
    </script>
@endsection
