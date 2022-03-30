@extends('frontend.layouts.master')

@section('title')
    Help | Classhub
@endsection

@section('meta_tags')
    <meta name="description"
          content="Everything you need to know to get started and make the most of your Classhub account.">
@endsection

@section('content')

    <div class="main-container p-t-0 page-help">

        <!-- Starts : How it works Hero Image -->
        <section class="image-bg hero-img type-01 no-min-height">
        <!-- <div class="background-image-holder">
                <img alt="image" class="background-image" src="{{ asset('img/hero-images/help.jpg') }}"/>
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
                    <div class="col-xs-9 col-md-8">
                        <div class="box">
                            <h3>Everything you need to know to get started and make the most of your Classhub
                                account</h3>
                        </div>
                    </div>
                </div>
            </div>
            <!--end of container-->
        </section>
        <!-- end : How it works Hero Image -->


        <!-- starts: tabs -->
        <section class="help-tabs">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="tabs">

                            <!-- starts : Nav tabs -->
                            <ul class="row nav nav-tabs m-0" role="tablist">
                                <li role="presentation" class="col-md-6 tab-discover {{ !request()->get('tab') ||
                                request()->get('tab') == 'parent' ? 'active' : '' }}">
                                    <a class="hover-pink" href="#parents" aria-controls="discover" role="tab"
                                       data-toggle="tab">For parents
                                        & students
                                        <br>
                                        <span style="font-size: 13px;">Click here to learn more</span>
                                    </a>
                                </li>
                                <li role="presentation" class="col-md-6 tab-bediscover text-right {{ request()->get('tab') &&
                                request()->get('tab') == 'tutor' ? 'active' : '' }}">
                                    <a class="hover-pink" href="#tutors" aria-controls="bediscover" role="tab"
                                       data-toggle="tab">For tutors
                                        & activity providers
                                        <br>
                                        <span style="font-size: 13px;">Click here to learn more</span>
                                    </a>
                                </li>
                            </ul>
                            <!-- end : Nav tabs -->

                            <!-- starts : Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane {{ !request()->get('tab') ||
                                request()->get('tab') == 'parent' ? 'active' : '' }}" id="parents">
                                    <!-- starts: tabs section -->
                                    <!-- starts : parents section -->
                                    <div class="parents">

                                        @include('frontend.pages.help.help-user',
                                        ['categories' => $parentCategories, 'faqs' => $parentFaqs])

                                    </div>
                                    <!-- end : parents section -->
                                    <!-- end: tabs section -->
                                </div>
                                <div role="tabpanel" class="tab-pane {{ request()->get('tab') &&
                                request()->get('tab') == 'tutor' ? 'active' : '' }}" id="tutors">
                                    <!-- starts: tabs section -->

                                    <!-- starts : Discovery section -->
                                    <div class="tutors">

                                        @include('frontend.pages.help.help-user',
                                        ['categories' => $educatorCategories, 'faqs' => $educatorFaqs])
                                    </div>
                                    <!-- end : Discovery section -->

                                    <!-- end: tabs section -->
                                </div>
                            </div>
                            <!-- end : Tab panes -->

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end: tabs -->

        <!-- Starts: bottom button -->
        <div class="row showmore p-b-22">
            <div class="col-sm-12 text-center">
                <a href="{{ Auth::user() ? route('educator.lesson.create') : 'javascript:;' }}"
                   {{ !Auth::user() ? 'data-toggle=modal data-target=#login-modal' : '' }}
                   class="btn btn-primary shadow-v4 m-0">
                    <span class="btn__text">LIST A CLASS</span>
                </a>
            </div>
        </div>
        <!-- End: bottom button -->


    </div>

@endsection

@section('page_scripts')
    <script src="{{ asset('js/flexslider.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
