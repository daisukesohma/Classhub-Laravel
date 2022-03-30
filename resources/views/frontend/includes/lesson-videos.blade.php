@foreach($videos as $video)
    <?php
    $uriArr = explode('/', $video['body']['uri']);
    $id = $uriArr[count($uriArr) - 1];
    $imageUrl = $video['body']['pictures']['sizes'][count($video['body']['pictures']['sizes']) - 1]['link_with_play_button'];
    ?>
    <!-- starts : tile 01 -->
    <div class="col-xs-12 col-md-{{ $colClass }} col-lg-{{ $colClass }} col-sm-12" style="margin-bottom: 20px">
        <div class="embed-container">
            <iframe src="https://player.vimeo.com/video/{{$id}}?badge=0&amp;autopause=0"
                    frameborder="0" allow="autoplay; fullscreen" allowfullscreen
                    title="{{ $video['body']['name'] }}"></iframe>
        </div>
    </div>

    <!-- end : tile 01 -->
@endforeach
<style>
    .embed-container {
        position: relative;
        height: 100%;
        min-height: 300px;
        overflow: hidden;
        max-width: 100%;
    }

    .embed-container iframe,
    .embed-container object,
    .embed-container embed {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>
