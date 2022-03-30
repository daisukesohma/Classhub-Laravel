<!-- starts : hero image search form -->
<label class="text-center search-label only-desktop">What can our tutors and grinds help you with today?</label>
<label class="text-center search-label only-mobile">Online tutors and grinds that deliver results</label>
<div class="hero-search list-a-class">
    <div class="search-box">
        <!--begin::Form-->
        {{ Form::open(['url' => route('page.search'), 'method' => 'GET', 'class' => 'm-form', 'id' => 'search-form']) }}

        <div class="m-portlet__body">
            <div class="m-form__section m-form__section--first">

                <div class="m-stack m-stack--ver m-stack--general">

                    <!--starts : column, Grinds / Activities-->
                    <div class="m-stack__item">
                        <div class="form-group m-form__group">
                            <label class="text-center search-label label-sm only-mobile">What can our tutors and grinds help you with today?</label>
                            <!--begin: Dropdown-->
                            <div class="m-dropdown m-dropdown--arrow c-dd-menu" m-dropdown-toggle="click"
                                 style="display: block !important;">
                                <a id="search-category-title" href="javascript:void(0)"
                                   style="display: block !important;"
                                   class="m-dropdown__toggle btn dropdown-toggle">Choose your subject</a>
                                <div class="m-dropdown__wrapper category-drop">
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__body homeCategorySearch">
                                            <div class="m-dropdown__content">
                                                <div class="scrollable">

                                                    <!-- starts, list options -->
                                                @include('educator.includes.category-select',
                                                    [
                                                        'name' => 'category_id',
                                                        'type' => 'radio',
                                                        'subjects' => isset($selectedSubjects) ? $selectedSubjects :
                                                            [isset($categoryId) ? $categoryId : null],
                                                    ])
                                                <!-- end, list options -->

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end: Dropdown-->
                        </div>
                    </div>
                    <!--end : column, Grinds / Activities-->

                    <!--starts : column, start button-->
                    <div class="m-stack__item">
                        <div class="form-group m-form__group">
                            <div>
                                <button type="submit" class="btn btn-primary m-0">
                                    <span class="btn__text">SEARCH</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!--end : column,start button-->

                </div>

            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
<!-- end : hero image search form -->
@if(request()->get('category_id'))
    <?php
    $categoryName = '';
    $areaName = '';
    try {
        $category = \App\Category::findOrFail(request()->category_id);
        $categoryName = \App\Helpers\ClassHubHelper::getSubjectDisplayName($category, collect([]));
        $areaName = \App\Area::findOrFail(request()->area_id)->address;
    } catch (\Exception $e) {
    }
    ?>

    <script type="text/javascript">
        window.dataLayer.push({
            event: 'selectionMade',
            selectedTeacher: '{{ request()->tutor_name }}',
            selectedCategory: '{!! $categoryName !!}',
            selectedArea: '{!! $areaName !!}'
        })

        $input = $('input[value="{!! request()->category_id !!}"]')
        $input.prop('checked', true)
        $input.parents('li').addClass('active');
        $input.parents('ul').addClass('sub-category-show');

        var text = $('input[name="category_id"]:checked').attr('data-category-name');
        $('#search-category-title').text(text);

    </script>
@endif

<script type="text/javascript">

    var categoryId;

    $(document).ready(function () {
        var areaId = "{{ $areaId ? $areaId : null }}";
        if (areaId == null || areaId == "") {
            areaId = $('a.area-select').attr('area_id');
        }
        handleAreaSelected(areaId);
        setupDropdownListeners();
    })

    function setupDropdownListeners() {
        $('a.area-select').on('click', function () {
            var areaId = $(this).attr('area_id');
            handleAreaSelected(areaId);
        })
    }

    function handleAreaSelected(areaId) {
        var title = $('a.area-select[area_id="' + areaId + '"]').text();

        $('input[name="area_id"]').val(areaId);
        $('#area-select-title').text(title);
    }

    // Hack for search form not submitting caetgory on back button press
    $('#search-form').on('submit', function () {
        var requestString = $(this).serialize();

        if (requestString.indexOf('category_id') === -1) {
            $(this).append('<input type="hidden" name="category_id" value="' + categoryId ? categoryId : '' + '">');
        }

        return true
    })


</script>
