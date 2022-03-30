@extends('frontend.layouts.master')

@section('title')
    Classhub | Our Blog
@endsection

@section('page_styles')

@endsection

@section('content')
    <!-- starts : main container -->
    <div class="main-container p-t-0 blog-page footer-stay-btm">

        <!-- Starts : Blog Page Hero Image -->
        <section class="image-bg hero-img blog-hero-img type-02 no-min-height">
            <!-- <div class="background-image-holder">
                <img alt="image" class="background-image" src="{{ asset('img/hero-images/blog.jpg') }}"/>
            </div> -->
            <!-- starts: Image slider -->
            <div class="image-slider slider-all-controls controls-inside">
                <ul class="slides">
                    <li class="bg-image" style="background-image:url({{ asset('img/hero-images/slider/after-school-classes-in-dublin.jpg') }});">&nbsp;</li>
                    <li class="bg-image" style="background-image:url({{ asset('img/hero-images/slider/after-school-tutors-in-dublin.jpg') }});">&nbsp;</li>
                    <li class="bg-image" style="background-image:url({{ asset('img/hero-images/slider/children-grinds-in-dublin.jpg') }});">&nbsp;</li>
                    <li class="bg-image" style="background-image:url({{ asset('img/hero-images/slider/dance-ballet-tutors.jpg') }});">&nbsp;</li>
                    <li class="bg-image" style="background-image:url({{ asset('img/hero-images/slider/dancing-lessons-for-children.jpg') }});">&nbsp;</li>
                    <li class="bg-image" style="background-image:url({{ asset('img/hero-images/slider/italian-language-tutors.jpg') }});">&nbsp;</li>
                    <li class="bg-image" style="background-image:url({{ asset('img/hero-images/slider/maths-tutor-in-dublin.jpg') }});">&nbsp;</li>
                </ul>
            </div>
            <!-- End: Image -->
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="box">
                            <h1>Our blog</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!--end of container-->
        </section>
        <!-- end : Blog Page Hero Image -->


        <!-- starts : Blog content columns -->
        <div class="columns container">
            <div class="row">

                <!-- starts : blog left column -->
                <div class="col-md-8 blog-left">

                    <div class="row tiles-type-01 blog-tiles">

                        <div class="show-more-container">

                            @foreach($posts as $post)
                                @include('frontend.pages.blog.post')
                            @endforeach

                            @if($posts->nextPageUrl())
                                <div class="row showmore p-t-55 show-more-button-container">
                                    <div class="col-sm-12 text-center">
                                        <a class="btn btn-primary shadow-v4 show-more-button"
                                           href="{{ $posts->nextPageUrl() }}">
                                            <span class="btn__text">SEE MORE</span>
                                        </a>
                                    </div>
                                </div>
                            @endif

                        </div>

                    </div>
                    <!-- end : blog left column -->
                </div>

                <!-- starts : blog right, side bar column -->
                <div class="col-md-4 blog-right">
                    @include('frontend.pages.blog.sidebar')
                </div>
                <!-- end : blog right, side bar column -->

            </div>
        </div>

        <!-- end : Blog content columns -->

    </div>
    <!-- end : main container -->
@endsection


@section('page_scripts')
    <script src="{{ asset('js/flexslider.min.js') }}"></script>
@endsection
