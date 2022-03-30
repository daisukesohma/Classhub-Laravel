<!-- starts: latest-articles tiles container -->
<section class="latest-articles">
    <div class="container">

        <!-- Starts: Tiles type 01 -->
        <div class="row title-type-01">
            <div class="col-sm-12">
                <div class="title p-t-0 p-b-10">THE LATEST FROM OUR BLOG</div>
            </div>
        </div>
        <!-- Starts: Tiles type 01 -->

        <!-- Starts: Tiles type 01 -->
        <div class="row tiles-type-01 blog-tiles carousel"
             data-flickity='{ "prevNextButtons": false, "pageDots": false, "groupCells": true, "groupCells": 1,
              "cellAlign": "left", "contain": true, "freeScroll": false, "freeScrollFriction": 0 , "adaptiveHeight" : true}'>

        @foreach($posts as $post)
            <!-- starts : tile 01 -->
                <div class="col-xs-10 col-md-4 col-sm-6 carousel-cell  ">
                    <a href="{{ route('page.blog.post', $post->slug) }}" style="color: #333;">

                        <div class="image-tile outer-title col-eq-height">
                            @if( $post->featured_image)
                                <img alt="Pic" class="product-thumb"
                                     src="{{  \App\Helpers\ClassHubHelper::getImagePath($post->image) }}">
                            @endif
                            <div class="tile-details">
                                <div class="title">{{ $post->title }}</div>
                                <div
                                    class="date">{{ \Carbon\Carbon::parse($post->published_at)->format('F jS, Y') }}</div>
                                <div class="text">
                                    {!!  \App\Helpers\ClassHubHelper::excerpt($post->content, 10, false, false) !!}
                                </div>
                                <div class="link text-right">
                                    <a href="{{ route('page.blog.post', $post->slug) }}">Read more <i
                                            class="la la-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>
                <!-- end : tile 01 -->
            @endforeach

        </div>
        <!-- End: Tiles type 01 -->

        <!-- Starts: bottom button -->
        <div class="row showmore p-t-55 p-b-22">
            <div class="col-sm-12 text-center">
                <a href="{{ route('page.blog') }}" class="btn btn-primary shadow-v4">
                    <span class="btn__text">READ ALL ARTICLES</span>
                </a>
            </div>
        </div>
        <!-- End: bottom button -->

    </div>
</section>
<!-- End: latest-articles tiles container -->
