<section class="hero-img type-01 home-hero home-hero-default">

    <div class="container" id="search" style="z-index: 99">

        <div class="image-bg">

            <div class="row">
                <div class="col-md-9">
                    <div class="box">
                        <h2>
                        {{ \App\Setting::get('heading') }}
                        </h2>
                        <h6>
                            {{ \App\Setting::get('sub_heading') }}
                        </h6>
                    </div>
                </div>
            </div>

            <div class="image-static background-image-holder" style="background-color: #7D948C">
                <img alt="image" class="background-image" src="/img/mobile-home/mobile-8.jpg"/>
            </div>

            @include('frontend.includes.search-bar')
        </div>


    </div>

    <div class="banner-slide image-slider"></div>

</section>
