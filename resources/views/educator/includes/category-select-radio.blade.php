<div class="list-options category-select">
    @foreach(\App\Category::getAllCategories() as $key => $categories)
        <dl class="category-dropdown">

            <dt class="category-type">{{ $key }}</dt>
            <dd>
                <ul>
                    @foreach($categories as $parentCategory)
                        <li class="parent-category">

                            <span class="category-select-option"
                                  style="cursor: pointer;">{{ $parentCategory->name }}</span>

                            @if($parentCategory->name == 'Others')
                                <ul class="sub-category-list">
                                    @if(isset($otherCategory) && $otherCategory)
                                        <li class="category-sub" data-id="{!! $otherCategory->id !!}">
                                            <input type="{{$type}}"
                                                   name="{{$name}}"
                                                   value="{{ $otherCategory->id }}"
                                                   data-category-name="{!! \App\Category::getDisplayName($otherCategory->id) !!}">
                                            {{ $otherCategory->name }}
                                        </li>
                                    @endif
                                    <li class="category-sub" style="min-height: 50px"
                                        data-parent-category="{{ $parentCategory->name }}">
                                        <input type="radio" class="form-control" name="{{$name}}"
                                               data-parent-category="{{ $parentCategory->name }}"
                                               value="{{ $parentCategory->id }}">
                                        <input type="text" name="other_category"
                                               data-parent-category="{{ $parentCategory->name }}"
                                               class="form-control other-category">
                                    </li>
                                </ul>
                            @endif

                            @if($parentCategory->subCategories->count() && $parentCategory->name !== 'Others')

                                <ul class="sub-category-list">

                                    @foreach($parentCategory->subCategories as $subCategory)
                                        @if(\App\Category::getSubCategories($subCategory->id)->count())
                                            <li class="parent-category-sub cycle-category-sub">
                                                <span class="category-select-option">{!! $subCategory->name !!}</span>

                                                <ul class="cycle-category-list">
                                                    @foreach(\App\Category::getSubCategories($subCategory->id) as $cycle)
                                                        @if(\App\Category::getSubCategories($cycle->id)->count())
                                                            <li class="parent-category-sub level-category-sub">
                                                                <span class="category-select-option">{!! $cycle->name !!}</span>

                                                                <ul class="level-category-list">
                                                                    @foreach(\App\Category::getSubCategories($cycle->id) as $level)
                                                                        <li class="category-sub" data-id="{!! $level->id !!}">
                                                                            <input type="{!!$type!!}"
                                                                                name="{!!$name!!}"
                                                                                value="{!! $level->id !!}"
                                                                                data-category-name="{!! \App\Category::getDisplayName($level->id) !!}">
                                                                            {!! $level->name !!}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        @else
                                                            <li class="category-sub" data-id="{!! $cycle->id !!}">
                                                                <input type="{!!$type!!}"
                                                                    name="{!!$name!!}"
                                                                    value="{!! $cycle->id !!}"
                                                                    data-category-name="{!! \App\Category::getDisplayName($cycle->id) !!}" >
                                                                {!! $cycle->name !!}
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @else
                                            <li class="category-sub" data-id="{!! $subCategory->id !!}">
                                                <input type="{{$type}}"
                                                    name="{{$name}}"
                                                    value="{{ $subCategory->id }}"
                                                    data-category-name="{!! \App\Category::getDisplayName($subCategory->id) !!}">
                                                {{ $subCategory->name }}
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
            @if(isset($selected_category_id))
        var selected_category_id = {{ $selected_category_id }}
            @else
        var selected_category_id = ''
            @endif
        if (selected_category_id) {
            $('dl.category-dropdown ul.sub-category-list li[data-id]').each((index, li) => {
                if (parseInt(selected_category_id) == parseInt($(li).data('id'))) {
                    $(li).addClass('active');
                    $(li).children('input').prop('checked', true);
                    $(li).parents('li').addClass('active');
                    $(li).parents('ul').addClass('sub-category-show');
                }
            })
        } else {
            var tutorSubjects = {!! json_encode(Auth::user()->categories()->pluck('id')->toArray()) !!}

            $('dl.category-dropdown ul.sub-category-list li[data-id]').each((index, li) => {
                if (tutorSubjects.includes($(li).data('id'))) {
                    $(li).parents('ul').addClass('sub-category-show');
                }
            })
        }
    })
</script>
<style type="text/css">
    dl.category-dropdown ul, dl.category-dropdown li {
        list-style: none;
        padding-left: 20px;
    }

    dl.category-dropdown input {
        margin-bottom: 10px;
    }

    dl.category-dropdown ul.sub-category-list {
        background-color: #ffffff;
        display: none;
    }

    dl.category-dropdown ul.sub-category-show {
        display: block !important;
    }
</style>
