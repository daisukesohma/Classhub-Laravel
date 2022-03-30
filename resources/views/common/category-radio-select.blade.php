<div class="list-options category-select">
    @foreach(\App\Category::getAllCategories() as $key => $categories)
        <dl class="category-dropdown">

            <dt class="category-type">{{ $key }}</dt>
            <dd>
                <ul>
                    @foreach($categories as $parentCategory)
                        <li class="parent-category">
                            <span style="cursor: pointer;">{{ $parentCategory->name }}</span>
                            @if($parentCategory->subCategories->count())
                                <ul class="sub-category-list">
                                    @foreach($parentCategory->subCategories as $subCategory)
                                        <li class="category-sub">
                                            <input {{ in_array($subCategory->id, $subjects) ? 'checked' : '' }}
                                                   type="radio"
                                                   name="{{$name}}"
                                                   value="{{ $subCategory->id }}">
                                            {{ $subCategory->name }}
                                        </li>
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
        display: block;
    }
</style>
