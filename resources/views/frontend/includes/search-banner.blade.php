<!-- Starts : Search Page, default search bar -->
<section class="hero-img type-02 home-hero search-hero" style="{{ !$desktop ? 'min-height:0' : '' }}">

    <div class="container" style="z-index: 99">

        <div class="image-bg" style=" {{ !$desktop ? 'height:20vh' : '' }}">

            <div class="row">
                <div class="col-md-8">
                    <div class="box">
                        @if (count($lessons) || ($tutorOnly && count($tutorResults)) || (count($subjectTutors)) )
                            <h2>Find your perfect {{ $isUpmostCategory ? $subjectName : '' }} tutor that fits your schedule</h2>
                            @if ($showJuniorAndLeavingCert)
                                <h3>
                                    <span>Junior Cert & Leaving Cert</span>
                                </h3>
                            @endif
                        @else
                            <div>
                                <h2>No results matching your search were found</h2>
                                <h6 class="fw-5"></h6>
                                <h6></h6>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="image-static background-image-holder"
                 style="background: url('/img/hero-images/female-tutor.jpg'); {{ !$desktop ? 'margin-top:0' : '' }}">
                <img alt="image" class="background-image" src="/img/hero-images/female-tutor.jpg"/>
            </div>

        </div>

        @if($desktop)
            @include('frontend.includes.search-bar')
        @endif

    </div>

    <div class="banner-slide image-slider"></div>

    <!--end of container-->
</section>
<!-- End : Search Page, default search bar -->
