@if( count($relatedLessons) > 0)
    <!-- starts: classes tiles container -->
    <section class=" p-t-0 p-b-0">

        <div class="container classes-tiles">

            <!-- Starts: Tiles type 01 -->
            <div class="row title-type-01">
                <div class="col-sm-12">
                    <div class="title">YOU MAY ALSO LIKE</div>
                </div>
            </div>
            <!-- Starts: Tiles type 01 -->

            <!-- Starts: Tiles type 01 -->
            <div class="row tiles-type-01 p-b-50">
                <div class="show-more-related-container">

                    @include('frontend.includes.lessons', ['lessons' => $relatedLessons])

                    {{--@if($relatedLessons->nextPageUrl())
                        <div class="row showmore p-t-55 show-more-related-button-container">
                            <div class="col-sm-12 text-center">
                                <a class="btn btn-primary shadow-v4 show-more-related-button"
                                   href="{{ $relatedLessons->nextPageUrl() }}">
                                    <span class="btn__text">SHOW MORE</span>
                                </a>
                            </div>
                        </div>
                    @endif--}}

                    <div>
                        <!-- End: Tiles type 01 -->
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- End: classes tiles container -->
@endif
