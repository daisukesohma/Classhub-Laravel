<!-- starts: search-results tiles container -->
<div class="p-t-0 p-b-0">
    @if(count($lessons))
        <section class="p-t-0 p-b-0">

            <div class="container classes-tiles">

                <!-- Starts: Tiles type 01 -->
                <div class="row title-type-01">
                    <div class="col-sm-12">
                        <div class="title p-b-10" style="text-transform: uppercase">{{ $lessons->count() }} classes
                            available
                        </div>
                    </div>
                </div>
                <!-- Starts: Tiles type 01 -->

                <!-- Starts: Tiles type 01 -->
                <div class="row tiles-type-01 p-b-50">
                    <div class="show-more-container">

                        @include('frontend.includes.lessons', ['lessons' => $lessons])

                        @if($lessons->nextPageUrl())
                            <div class="row showmore p-t-55 show-more-button-container">
                                <div class="col-sm-12 text-center">
                                    <a class="btn btn-brand shadow-v4 show-more-button"
                                       href="{{ $lessons->nextPageUrl() }}"  style="padding: 0 40px;">
                                        <span class="btn__text">SHOW MORE</span>
                                    </a>
                                </div>
                            </div>
                        @endif

                        <div>
                            <!-- End: Tiles type 01 -->
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- End: Tiles type 02 -->
    @endif
</div>
<!-- End: search-results tiles container -->
