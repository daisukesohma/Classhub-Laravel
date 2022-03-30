@extends('frontend.layouts.master')

@section('title')
    Classhub | {{ $post->title }}
@endsection

@section('meta_tags')
    @foreach($post->metadata as $index => $metadata)
        @if($metadata['name'])
            <meta name="{{ $metadata['name'] }}" content="{{ $metadata['value'] }}">
        @endif
    @endforeach
    @if($post->featured_image)
        <meta property="og:image" content="{{ route('home').Storage::url($post->image->path) }}"/>
    @endif
@endsection

@section('page_styles')

@endsection

@section('content')
    <!-- starts : main container -->
    <div class="main-container p-t-0 blog-page">

        <!-- Starts : Blog Page Hero Image -->
        <section class="image-bg hero-img blog-hero-img type-02">
            <!-- <div class="background-image-holder">
                <img alt="image" class="background-image" src="{{ asset('img/hero-images/blog.jpg') }}"
                    style="width: 100%; object-fit: cover"/>
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
                    <!-- starts : blog article -->
                    <div class="blog-article">

                        <!-- starts: article image -->
                        @if( $post->featured_image && Storage::disk('public')->exists($post->image->path))
                            <div class="article-image shadow-v2">
                                <img src="{{  Storage::url($post->image->path) }}" style="width: 100%; object-fit: cover"/>
                            </div>
                    @endif
                    <!-- end: article image -->

                        <!-- starts: article content -->
                        <div class="article-content shadow-v2 m-t-32 bg-color-01">
                            <h3>{{ $post->title }}</h3>
                            <div>{!! $post->content !!}</div>
                        </div>
                        <!-- end: article content -->

                        <!-- starts: article content -->
                        <div class="article-share shadow-v2 m-t-32 bg-color-01">
                            <div class="row">
                                <div class="col-xs-6 color-02">Share this story:</div>
                                <div class="col-xs-6 icons">
                                    <ul class="tags list-inline social-list">
                                        {{--<li>
                                            <a href="javascript:void(0);">
                                                <i class="ti-instagram"></i>
                                            </a>
                                        </li>--}}
                                        <li>
                                            <a target="_blank"
                                               href="{{ \App\Setting::TWITTER_SHARE_URL }}?text={{ $post->title }}&url={{ route('page.blog.post', $post->slug) }}">
                                                <i class="ti-twitter-alt"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a target="_blank"
                                               href="{{ \App\Setting::FACEBOOK_SHARE_URL.env('FACEBOOK_APP_ID').'&href='.
                                       urlencode(route('page.blog.post', $post->slug)).
                                       '&display=page&redirect_uri='.urlencode(route('page.blog.post', $post->slug)) }}">
                                                <i class="ti-facebook"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- end: article content -->

                    </div>
                    <!-- end : blog article -->
                </div>
                <!-- end : blog left column -->

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
