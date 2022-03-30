<!-- starts : Step2 : Answer section -->
    <!-- starts : side nav -->
    <div class="col-md-3 question ">
        <div class="box">
            <div class="title">{{ $faq->category->name }}</div>
            <div class="sub-title">Articles in this section</div>
            <ul class="nav">
                @foreach($relatedFaqs as $item)
                    <li>
                        <a href="{{ route('page.help.single',
                                                                [$item->id, \App\Helpers\ClassHubHelper::slug($item->question)]) }}">
                            {{ $item->question }}</a>
                    </li>
                @endforeach
            </ul>
            <div class="btm-link text-right">
                <a class="link-01"
                   href="{{ route('page.help') }}?tab={{ $faq->type=='educator' ? 'tutor' : 'parent' }}">Go
                    back</a></div>
        </div>
    </div>
    <!-- end : side nav -->
<!-- end : Step2 : Answer section -->
