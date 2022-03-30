@extends('frontend.layouts.master')

@section('title')
    Classhub | Help
@endsection


@section('content')

    <div class="main-container page-help p-t-0">

        <!-- starts: hero section -->
        <!-- Starts : Help Page - Hero Image -->
        <section class="image-bg hero-img type-01 no-min-height">
            <div class="background-image-holder">
                <img alt="image" class="background-image" src="img/hero-images/help.jpg"/>
            </div>
            <span class="gradient-layer type-01"></span>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="box">
                            <h3>Everything you need to know to get started and make the most of your Classhub
                                account</h3>
                            <div class="buttons row">
                                <div class="col-xs-6">
                                    <a class="btn btn-primary display-block btn-parent"
                                       href="javascript:toggleHelp('parent');"><span
                                            class="btn__text">For Parents</span></a>
                                </div>
                                <div class="col-xs-6">
                                    <a class="btn btn-primary btn-transparent display-block btn-teacher"
                                       href="javascript:toggleHelp('teacher');"><span
                                            class="btn__text">For Teachers</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end of container-->
        </section>
        <!-- end : Help Page - Image -->
        <!-- end: hero section -->

        <div class="container">

            <!-- starts : parent faq's -->
            <div class="faqs parents active">

                <div class="row m-0">
                    <div class="col-md-12">

                        <div class="main-title">Some frequently asked questions from our parents</div>
                        <!--start of accordion-->
                        <ul class="accordion accordion-1 one-open">
                            @foreach($parentFaqs as $faq)
                                <li class="list">
                                    <div class="title">{{ $faq->question }}</div>
                                    <div class="content">{!! $faq->answer !!}</div>
                                </li>
                            @endforeach
                        </ul>
                        <!--end of accordion-->

                    </div>
                </div>

                <!-- Starts: bottom button -->
                <div class="row action-button p-t-28">
                    <div class="col-sm-12 text-center">
                        <a href="{{ route('page.home') }}" class="btn btn-primary shadow-v4">
                            <span class="btn__text">BOOK A CLASS</span>
                        </a>
                    </div>
                </div>
                <!-- End: bottom button -->

            </div>
            <!-- end : parent faq's -->

            <!-- starts : teachers faq's -->
            <div class="faqs teachers">

                <div class="row m-0">
                    <div class="col-md-12">

                        <div class="main-title">Some frequently asked questions from our teachers</div>
                        <!--start of accordion-->
                        <ul class="accordion accordion-1 one-open">
                            @foreach($teacherFaqs as $faq)
                                <li class="list">
                                    <div class="title">{{ $faq->question }}</div>
                                    <div class="content">{!! $faq->answer !!}</div>
                                </li>
                            @endforeach
                        </ul>
                        <!--end of accordion-->

                    </div>
                </div>

                <!-- Starts: bottom button -->
                <div class="row action-button p-t-28">
                    <div class="col-sm-12 text-center">
                        <a href="{{ Auth::user() ? route('educator.profile.create') : 'javascript:;' }}"
                           {{ !Auth::user() ? 'data-toggle=modal data-target=#login-modal' : '' }}
                           class="btn btn-primary shadow-v4">
                            <span class="btn__text">LIST A CLASS</span>
                        </a>
                    </div>
                </div>
                <!-- End: bottom button -->

            </div>
            <!-- end : teachers faq's -->

        </div>

        <!-- starts : btm need help  -->
    @include('common.need-help')
    <!-- end : btm need help  -->

    </div>

@endsection

@section('page_scripts')

    <script type="text/javascript">
        function toggleHelp(arg) {
            if (arg == "parent") {
                $('.hero-img .btn-teacher').addClass('btn-transparent');
                $('.hero-img .btn-parent').removeClass('btn-transparent');
                $('.faqs.teachers').removeClass('active');
                $('.faqs.parents').addClass('active');
            }
            if (arg == "teacher") {
                $('.hero-img .btn-parent').addClass('btn-transparent');
                $('.hero-img .btn-teacher').removeClass('btn-transparent');
                $('.faqs.parents').removeClass('active');
                $('.faqs.teachers').addClass('active');
            }
        }
    </script>

@endsection
