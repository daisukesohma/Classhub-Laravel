<div class="list-options category-select search-dropdown">
    <dl>
        <dt class="reset-category" style="cursor: pointer; padding-bottom: 10px">All grinds / activities</dt>
    </dl>
    @foreach(\App\Category::getAllCategories() as $key => $categories)
        <dl class="category-dropdown">

            <dt class="category-type">{!! $key !!}</dt>
            <dd>
                <ul>
                    @foreach($categories as $parentCategory)
                        <li class="parent-category" 
                            data-name="{!! trim($parentCategory->name) !!}" data-type="{!! $key !!}">
                            <span class="category-select-option">{!! $parentCategory->name !!}</span>

                            @if($parentCategory->name == 'Others')
                                <ul class="sub-category-list" >
                                    <li class="category-sub" data-id="{!! $parentCategory->id !!}">
                                        <input
                                            type="{!! $type !!}" name="{!!$name!!}"
                                            data-category-name="Others - Other categories"
                                            value="{!! $parentCategory->id !!}">
                                        Other categories
                                    </li>
                                </ul>
                            @endif

                            @if($parentCategory->subCategories->count() && $parentCategory->name !== 'Others')

                                <ul class="sub-category-list">

                                    @foreach($parentCategory->subCategories as $subCategory)

                                        @if(\App\Category::getSubCategories($subCategory->id)->count())
                                            <li class="parent-category-sub cycle-category-sub" data-type="{!! $key !!}">
                                                <span class="category-select-option">{!! $subCategory->name !!}</span>

                                                <ul class="cycle-category-list">
                                                    
                                                    @foreach(\App\Category::getSubCategories($subCategory->id) as $cycle)
                                                        
                                                        @if(\App\Category::getSubCategories($cycle->id)->count())
                                                            <li class="parent-category-sub level-category-sub" data-type="{!! $key !!}">
                                                                <span class="category-select-option">{!! $cycle->name !!}</span>

                                                                <ul class="level-category-list">
                                                                    @foreach(\App\Category::getSubCategories($cycle->id) as $level)
                                                                        <li class="category-sub" data-id="{!! $level->id !!}" 
                                                                            data-type="{!! $key !!}">
                                                                            <input
                                                                                type="{!!$type!!}"
                                                                                name="{!!$name!!}"
                                                                                value="{!! $level->id !!}"
                                                                                data-parent-id="{!! $cycle->id !!}"
                                                                                data-category-name="{!! \App\Category::getDisplayName($level->id) !!}"
                                                                            >
                                                                            {!! $level->name !!}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        @else
                                                            <li class="category-sub" data-id="{!! $cycle->id !!}" data-type="{!! $key !!}">
                                                                <input
                                                                    type="{!!$type!!}"
                                                                    name="{!!$name!!}"
                                                                    value="{!! $cycle->id !!}"
                                                                    data-category-name="{!! \App\Category::getDisplayName($cycle->id) !!}"
                                                                    data-parent-id="{!! $subCategory->id !!}"
                                                                >
                                                                {!! $cycle->name !!}
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @else
                                            <li class="category-sub" data-id="{!! $subCategory->id !!}" data-type="{!! $key !!}">
                                                <input
                                                    type="{!!$type!!}"
                                                    name="{!!$name!!}"
                                                    value="{!! $subCategory->id !!}"
                                                    data-category-name="{!! \App\Category::getDisplayName($subCategory->id) !!}"
                                                    data-parent-id="{!! $parentCategory->id !!}"
                                                >
                                                {!! $subCategory->name !!}
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </li>

                    @endforeach
                </ul>
            </dd>
        </dl>
    @endforeach
</div>
<script>
    $(function () {
            @if(isset($subjects))
        var subjects = {!! json_encode($subjects) !!}
            @else
        var subjects = []
            @endif
        $('dl.category-dropdown ul.sub-category-list li[data-id]').each((index, li) => {
            if (subjects.includes($(li).data('id'))) {
                $(li).addClass('active');
                $(li).children('input').prop('checked', true);
                $(li).parents('li').addClass('active');
                $(li).parents('ul').addClass('sub-category-show');
            }
        })
    })
</script>
<style type="text/css">
    dl.category-dropdown ul, dl.category-dropdown li {
        list-style: none;
        padding-left: 20px;
    }

    dl.category-dropdown ul.sub-category-list {
        background-color: #ffffff;
        display: none;
    }

    dl.category-dropdown li.parent-category-sub ul {
        display: none;
        padding-bottom: 0px !important;
    }

    dl.category-dropdown ul.sub-category-show {
        display: block !important;
    }
</style>
