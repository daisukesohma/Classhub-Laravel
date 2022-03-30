@extends('frontend.layouts.master')

@section('title')
    Classhub | Help
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
                    <li class="bg-image" style="background-image:url({{ asset('img/hero-images/slider/after-school-classes-in-dublin.jpg') }});">&nbsp;</li>
                    <li class="bg-image" style="background-image:url({{ asset('img/hero-images/slider/after-school-tutors-in-dublin.jpg') }});">&nbsp;</li>
                    <li class="bg-image" style="background-image:url({{ asset('img/hero-images/slider/children-grinds-in-dublin.jpg') }});">&nbsp;</li>
                    <li class="bg-image" style="background-image:url({{ asset('img/hero-images/slider/dance-ballet-tutors.jpg') }});">&nbsp;</li>
                    <li class="bg-image" style="background-image:url({{ asset('img/hero-images/slider/dancing-lessons-for-children.jpg') }});">&nbsp;</li>
                    <li class="bg-image" style="background-image:url({{ asset('img/hero-images/slider/italian-language-tutors.jpg') }});">&nbsp;</li>
                    <li class="bg-image" style="background-image:url({{ asset('img/hero-images/slider/maths-tutor-in-dublin.jpg') }});">&nbsp;</li>
                </ul>
            </div>
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
                                <li role="presentation"
                                    class="col-md-6 tab-discover {{ $faq->type == 'parent' ? 'active' : '' }}">
                                    <a class="hover-pink" href="{{ route('page.help') }}?tab=parents" aria-controls="discover" role="tab"
                                    >For parents
                                        & students</a>
                                </li>
                                <li role="presentation"
                                    class="col-md-6 tab-bediscover text-right {{ $faq->type == 'educator' ? 'active' : '' }}">
                                    <a class="hover-pink" href="{{ route('page.help') }}?tab=tutor" aria-controls="bediscover" role="tab"
                                    >For tutors
                                        & activity providers
                                        <br>
                                        <span>Click here to learn more</span>
                                    </a>
                                </li>
                            </ul>
                            <!-- end : Nav tabs -->

                            <!-- starts : Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active">
                                    <!-- starts: tabs section -->
                                    <!-- starts : parents section -->
                                    <div class="parents">
                                        <div class="row answers" style="display: block !important;">


                                        @include('frontend.pages.help.help-related',
                                        ['relatedFaqs' => $relatedFaqs, 'faq' => $faq])

                                        <!-- starts : main col -->
                                            <div class="col-md-9 answer">
                                                <div class="box">

                                                    <!-- starts : Mobile questions menu -->
                                                    <div class="question show-below-md">
                                                        <div class="dmenu">

                                                            <div class="dmenu-head">
                                                                <div class="title">{{ $faq->category->name }}</div>
                                                                <div class="sub-title">Articles in this section</div>
                                                                <i class="la la-angle-down"></i>
                                                                <i class="la la-close"></i>
                                                            </div>

                                                            <ul class="nav">
                                                                @foreach($relatedFaqs as $item)
                                                                    <li>
                                                                        <a href="{{ route('page.help.single',
                                                                [$item->id, \App\Helpers\ClassHubHelper::slug($item->question)]) }}">
                                                                            {{ $item->question }}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="btm-link text-right">
                                                                <a class="link-01"
                                                                   href="{{ route('page.help') }}?tab={{ $faq->type=='educator' ? 'tutor' : 'parent' }}">Go
                                                                    back</a></div>
                                                        </div>
                                                    </div>
                                                    <!-- end : Mobile questions menu -->

                                                    <div class="tab-content">

                                                        <!-- starts : answer-01 -->
                                                        <div role="tabpanel" class="tab-pane active" id="answer-01">
                                                            <div class="title">{!! $faq->question !!}</div>
                                                            <p>{!! $faq->answer !!}</p>
                                                        </div>
                                                        <!-- end : answer-01 -->
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- end : main col -->
                                        </div>

                                    </div>
                                    <!-- end : parents section -->
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
                <a href="{{ route('home') }}" class="btn btn-primary shadow-v4 m-0">
                    <span class="btn__text">BOOK A CLASS</span>
                </a>
            </div>
        </div>
        <!-- End: bottom button -->

    </div>

@endsection

@section('page_scripts')
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
