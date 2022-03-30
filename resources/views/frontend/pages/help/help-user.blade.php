<!-- starts : Step1 : Faq's section -->
<div class="row all-faqs">
    <!-- starts : side nav -->
    <div class="col-md-3 sidenav hide-below-md">
        <div class="box">
            <ul>
                @foreach($categories as $category)
                    <li>
                        <a href="#sec-{{ $category->id }}"
                           style="background: url('{{ Storage::url($category->icon_path) }}') no-repeat; background-size:25px ">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <!-- end : side nav -->
    <!-- starts : main col -->
    <div class="col-md-9 main">
        <div class="box">
            <!-- starts : section 01 -->
            @foreach($faqs as $index => $items)
                <dl id="sec-{{ $index }}">
                    <dt>{{ \App\FAQCategory::findOrFail($index)->name }}</dt>
                    @foreach($items as $item)
                        <dd><a href="{{ route('page.help.single',
                                                                [$item->id, \App\Helpers\ClassHubHelper::slug($item->question)]) }}">
                                {{ $item->question }}</a></dd>
                    @endforeach
                </dl>
        @endforeach
        <!-- end : section 01 -->
        </div>
    </div>
    <!-- end : main col -->
</div>
<!-- end : Step1 : Faq's section -->
