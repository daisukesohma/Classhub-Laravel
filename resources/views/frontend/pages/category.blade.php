@extends('frontend.layouts.master')

@section('title')
    {{ $title }}
@endsection

@section('meta_tags')
    <meta name="description" content="{{ $description }}">
@endsection

@section('content')

    @include('frontend.includes.category-banner')

    @include('frontend.pages.search.subject-tutors')

    <div class="container classes-tiles">

        <!-- Starts: Tiles type 01 -->

        @if( count($lessons) == 0 )
            {{--<div class="container">
                <div class="row title-type-01">
                    <div class="col-sm-12">
                        <div class="title color-02 p-t-50 p-b-50">No results matching your search were found</div>
                    </div>
                </div>
            </div>

            @include('frontend.pages.search.top-results', ['topEducators' => $topEducators])--}}
        @else
            <div class="row title-type-01">
                <div class="col-sm-12">
                    <div class="title p-b-10" style="text-transform: uppercase;">{{ $category->name }} classes</div>
                </div>
            </div>
            <div class="row tiles-type-01 p-b-50">
                <div class="show-more-container">

                    @include('frontend.includes.lessons', ['lessons' => $lessons])

                    @if($lessons->nextPageUrl())
                        <div class="row showmore p-t-55 show-more-button-container">
                            <div class="col-sm-12 text-center">
                                <a class="btn btn-primary shadow-v4 show-more-button"
                                   href="{{ $lessons->nextPageUrl().'&'.request()->getRequestUri() }}">
                                    <span class="btn__text">SHOW MORE</span>
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        @endif
    </div>

@endsection

@section('page_scripts')
    <script src="{{ asset('js/flexslider.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/show-more-related.js') }}"></script>
    <script src="{{ asset('js/show-more-featured.js') }}"></script>
    <script src="{{ asset('js/show-more-subject-tutors.js') }}"></script>

    <script type="text/javascript">
        $(function () {
            $('#search-category-title').text('{!!  $category->name !!}');
        })

        var data = '<?php  echo json_encode($itemList) ?>';

        var el = document.createElement('script');
        el.type = 'application/ld+json';
        el.text = data;
        document.querySelector('body').appendChild(el);
    </script>

@endsection
