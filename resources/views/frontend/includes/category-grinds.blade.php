<!-- starts: find-a-tutor tiles container -->
<div class="container find-a-tutor">

    <!-- Starts: Tiles type 01 -->
    <div class="row title-type-01">
        <div class="col-sm-12">
            <h1 class="title p-b-10">EXPLORE INSPIRING ACTIVITIES BEYOND THE CLASSROOM</h1>
            <div class="sub-title">Connect with expert teachers to help your child achieve their goals</div>
        </div>
    </div>
    <!-- Starts: Tiles type 01 -->

    <!-- Starts: Tiles type 01 -->
    <div class="row tiles-type-01 carousel">

        <div class="show-more-grinds-container">

            <!-- starts : tile 01 -->
            @foreach($grinds as $category)
                <div class="col-xs-6 col-md-3 carousel-cell">
                    <div class="image-tile outer-title">
                        <a href="{{ route('page.category',  $category->slug) }}" style="color: #000">
                            <img alt="Pic" class="product-thumb tile-img-bg"
                                 style="background-image:url({{ $category->banner ? Storage::url
                                 ($category->bannerPhoto->path)  : '' }})"
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=">
                            <div class="tile-details">
                                <div class="name">{{ $category->name }}</div>
                            </div>
                        </a>
                    </div>
                </div>

            @endforeach
        <!-- end : tile 01 -->

            <!-- End: Tiles type 01 -->
            @if($grinds->nextPageUrl())
                <div class="row showmore p-t-55 p-b-22 show-more-grinds-button-container">
                    <div class="col-sm-12 text-center">
                        <a href="{{ $grinds->nextPageUrl() }}"
                           class="btn btn-primary shadow-v4 show-more-grinds-button">
                            <span class="btn__text">LOAD MORE</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>


</div>
<!-- End: find-a-tutor tiles container -->
