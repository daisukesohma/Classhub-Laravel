<div class="rating ms p-t-12 p-b-12">
    @if($rating['count'])
        <i class="star {{ $rating['rating'][0] }}"></i>
        <i class="star {{ $rating['rating'][1] }}"></i>
        <i class="star {{ $rating['rating'][2] }}"></i>
        <i class="star {{ $rating['rating'][3] }}"></i>
        <i class="star {{ $rating['rating'][4] }}"></i>
        {{--<span class="count">{{ $user->rating['count'] }}</span>--}}
    @else
        
    @endif
</div>
