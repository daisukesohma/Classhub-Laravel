<!-- Starts : Search Page, default search bar -->
<section class="hero-img type-02 home-hero search-hero">

    <div class="container" style="z-index: 99">

        <div class="image-bg">

            <div class="row">
                <div class="col-md-8">
                    <div class="box">
                        <h1>Online {{ $category->name }} Classes In Dublin</h1>
                    </div>
                </div>
            </div>

            <div class="image-static background-image-holder"
                 style="background: url({{ $category->banner ? \App\Helpers\ClassHubHelper::getImagePath($category->bannerPhoto) : '' }})">
                <img alt="image" class="background-image"
                     src="{{ $category->banner ? \App\Helpers\ClassHubHelper::getImagePath($category->bannerPhoto) : '' }}"/>
            </div>
            <!-- End: Image -->


        </div>

        @include('frontend.includes.search-bar')

    </div>

    <div class="image-slider background-image-holder"
         style="background: url({{ $category->banner ? \App\Helpers\ClassHubHelper::getImagePath($category->bannerPhoto) : '' }})">
        <img alt="image" class="background-image"
             src="{{ $category->banner ? \App\Helpers\ClassHubHelper::getImagePath($category->bannerPhoto) : '' }}"/>
    </div>
    <!-- End: Image -->

    <!--end of container-->
</section>
<!-- End : Search Page, default search bar -->
