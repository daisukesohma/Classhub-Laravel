@extends('frontend.layouts.master')

@section('title')
    Classhub | Search
@endsection

@section('page_styles')
    <link href="{{ asset('css/jquery.timepicker.min.css') }}" rel="stylesheet"/>

    @if(!$desktop)
        <style type="text/css">
            .title-type-01 .title, .sub-title, .hero-img .box h2 {
                text-align: center;
            }
            @media (max-width: 700px) {
                .image-bg {
                    padding-top: 50px !important;
                }
                .hero-search .m-form .m-form__group {
                    padding-bottom: 0;
                    margin-bottom: -5px;
                }
            }
        </style>
    @endif
@endsection

@section('content')

    @include('frontend.includes.search-banner')
    @if($tutorOnly)
        @include('frontend.pages.search.tutor-results', compact('tutorResults'))
    @else
        @include('frontend.pages.search.subject-tutors')
        @include('frontend.pages.search.results')
    @endif

    @if(count($lessons) == 0 && !$tutorOnly)
        @include('frontend.pages.search.top-results', ['topEducators' => $topEducators])
    @elseif(!$tutorOnly)
        @include('frontend.pages.search.related-results')
    @endif
    @if(!$desktop)
        @include('frontend.pages.search.search-bar')
    @endif

@endsection

@section('page_scripts')
    <script src="{{ asset('js/flexslider.min.js') }}"></script>
    <script src="{{ asset('js/jquery.timepicker.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/show-more-related.js') }}"></script>
    <script src="{{ asset('js/show-more-featured.js') }}"></script>
    <script src="{{ asset('js/show-more-subject-tutors.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            var fadeShow = $(".banner-slide").fadeShow({
                correctRatio: false,
                shuffle: false,
                speed: 5000,
                images: [
                    '{{ asset('img/hero-images/slider/after-school-classes-in-dublin.jpg') }}',
                    '{{ asset('img/hero-images/slider/after-school-tutors-in-dublin.jpg') }}',
                    '{{ asset('img/hero-images/slider/children-grinds-in-dublin.jpg') }}',
                    '{{ asset('img/hero-images/slider/dance-ballet-tutors.jpg') }}',
                    '{{ asset('img/hero-images/slider/dancing-lessons-for-children.jpg') }}',
                    '{{ asset('img/hero-images/slider/italian-language-tutors.jpg') }}',
                    '{{ asset('img/hero-images/slider/maths-tutor-in-dublin.jpg') }}'
                ]
            });
        });
    </script>
@endsection
