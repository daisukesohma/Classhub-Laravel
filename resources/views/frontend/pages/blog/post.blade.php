<div class="col-xs-12 col-md-6 col-sm-6">
    <a href="{{ route('page.blog.post',$post->slug) }}" style="color:#333;">

        <div class="image-tile outer-title col-eq-height blog-card">
            @if( $post->featured_image)
                <img alt="Pic" class="product-thumb" src="{{  \App\Helpers\ClassHubHelper::getImagePath($post->image) }}">
            @endif
            <div class="tile-details">
                <div class="title">{{ $post->title }}</div>
                <div class="date">{{ \Carbon\Carbon::parse($post->published_at)->format('F jS, Y') }}</div>
                <div class="text">
                    {!!  \App\Helpers\ClassHubHelper::excerpt($post->content, 10, false, false) !!}

                </div>
                <div class="link text-right">
                    <a href="{{ route('page.blog.post',$post->slug) }}">Read more <i class="la la-angle-right"></i></a>
                </div>
            </div>
        </div>
    </a>

</div>
