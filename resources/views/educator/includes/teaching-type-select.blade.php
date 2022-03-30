<?php $options = array_unique(array_merge($selected, \App\Setting::TEACHING_TYPES)); ?>
<div class="list-options category-select">
    <dl class="category-dropdown">
        <dd>
            <ul>
                @foreach($options as $key => $value)
                    <li class="parent-category teaching-type {{  in_array($key, $selected) ? 'active' : '' }}"
                        data-name="{{ $value }}">
                        <input {{ in_array($key, $selected) ? 'checked=checked' : '' }}
                               type="{{$type}}"
                               name="{{$name}}"
                               value="{{ $key }}"
                        >
                        <span class="other">{{ $key }}</span>
                    </li>
                @endforeach
            </ul>
        </dd>
    </dl>
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
