<div class="tab-pane {{ request()->get('tab') == 'faq' ? 'active': '' }}" id="faq">
    <div class="m-portlet__body">
        <div class="row">
            <div class="col-xl-3 col-sm-12">
                <div class="m-tabs" data-tabs="true" data-tabs-contents="#m_sections">
                    <ul class="m-nav m-nav--active-bg m-nav--active-bg-padding-lg m-nav--font-lg m-nav--font-bold m--margin-bottom-20 m--margin-top-10"
                        id="m_nav" role="tablist">
                        <li class="m-nav__item">
                            <a class="m-nav__link m-tabs__item m-tabs__item--active" data-tab-target="#parents-faq"
                               href="#">
														<span class="m-nav__link-text">
															Parents
														</span>
                            </a>
                        </li>
                        <li class="m-nav__item">
                            <a class="m-nav__link m-tabs__item" data-tab-target="#teacher-faq" href="#">
														<span class="m-nav__link-text">
															Teachers
														</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="m-tabs-content" id="m_sections">
                    <!--begin::Section 1-->
                    <div class="m-tabs-content__item m-tabs-content__item--active"
                         id="parents-faq">
                        <h4 class="m--font-bold m--margin-top-15 m--margin-bottom-20">
                            Parents
                        </h4>
                        <div class="m-accordion m-accordion--default m-accordion--padding-lg"
                             id="m_section_1_content">
                            <!--begin::Item-->
                            @foreach($parentFaqs as $index => $faq)
                                <div class="m-accordion__item">
                                    <div class="m-accordion__item-head {{ $index == 0 ? 'collapsed-' : 'collapsed' }}"
                                         role="tab"
                                         id="m_section_1_content_{{$faq->id}}_head" data-toggle="collapse"
                                         href="#m_section_1_content_{{$faq->id}}_body">
															<span class="m-accordion__item-title">
																{{ $faq->question }}
															</span>
                                        <a href="{{ route('admin.faq.edit', $faq->id) }}"
                                           class=" m-portlet__nav-link btn btn-info m-btn
                                                    m-btn--icon m-btn--icon-only m-btn--pill">
                                            <i class="la la-edit"></i>
                                        </a>
                                        <a href="javascript:;" data-id="{{ $faq->id }}"
                                           data-route="{{ route('admin.faq.delete', $faq->id) }}"
                                           class="delete-faq m-portlet__nav-link btn btn-danger m-btn
                                                    m-btn--icon m-btn--icon-only m-btn--pill">
                                            <i class="la la-close"></i>
                                        </a>
                                        <span class="m-accordion__item-mode"></span>
                                    </div>
                                    <div class="m-accordion__item-body collapse {{ $index == 0 ? 'show' : '' }}"
                                         id="m_section_1_content_{{$faq->id}}_body" role="tabpanel"
                                         aria-labelledby="m_section_1_content_{{$faq->id}}_head"
                                         data-parent="#m_section_1_content">
                                        <div class="m-accordion__item-content">
                                            <p>{!!  $faq->answer !!}</p>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                        <!--end::Item-->
                            <div class="m-portlet m-portlet--rounded" style="margin: 5% 0%">
                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <h3 class="m-portlet__head-text">
                                                Add FAQ
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-portlet__body">
                                    {!! Form::open(['url' => route('admin.faq.store'), 'method' => 'post',
                                        'enctype' => 'multipart/form-data']) !!}

                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input"
                                               class="col-md-2 col-form-label">
                                            User
                                        </label>
                                        <div class="col-md-9 col-sm-12">
                                            <select class="form-control" name="type">
                                                <option value="parent">Parent</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">
                                            Category
                                        </label>
                                        <div class="col-md-9 col-sm-12">
                                    <span
                                        class="m-form__help">Select an existing Category or create a new one.</span>                                                    </span>
                                            <select class="form-control userFaqSelect" name="category_id"
                                                    id="parent-category">
                                                @foreach($parentCategories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                                <option value="new">Add New Category</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div id="new-category-parent" style="display: {{ $parentCategories->count() == 0 ? 'block' : 'none' }};">
                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input"
                                                   class="col-md-2 col-form-label">
                                                Add New Category
                                            </label>
                                            <div class="col-md-9 col-sm-12">
                                                <input class="form-control m-input" type="text" name="new_category"
                                                       placeholder="Create a new category">
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input"
                                                   class="col-md-2 col-form-label">
                                                Category Icon
                                            </label>
                                            <div class="col-md-9 col-sm-12">
                                                <input class="form-control m-input" type="file" name="new_category_icon"
                                                       placeholder="Category Icon">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input"
                                               class="col-md-2 col-form-label">
                                            Question
                                        </label>
                                        <div class="col-md-9 col-sm-12">
                                            <input class="form-control m-input" type="text"
                                                   name="question" value="">
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input"
                                               class="col-md-2 col-form-label">
                                            Answer
                                        </label>
                                        <div class="col-md-9 col-sm-12">
                                            <textarea class="summernote1" id="answer" name="answer"></textarea>
                                        </div>
                                    </div>

                                    <div class="m-form__actions">
                                        <div class="row">
                                            <div class="col-md-7 col-sm-12">
                                                <button type="submit"
                                                        class="btn btn-brand m-btn m-btn--air m-btn--custom">
                                                    Add FAQ
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--begin::Section 1-->
                    <!--begin::Section 2-->
                    <div class="m-tabs-content__item" id="teacher-faq">
                        <h4 class="m--font-bold m--margin-top-15 m--margin-bottom-20">
                            Teachers
                        </h4>
                        <div class="m-accordion m-accordion--default m-accordion--padding-lg"
                             id="m_section_2_content">
                            <!--begin::Item-->
                            <div class="m-accordion m-accordion--default m-accordion--padding-lg"
                                 id="m_section_2_content">
                                <!--begin::Item-->
                                @foreach($educatorFaqs as $index => $faq)
                                    <div class="m-accordion__item">
                                        <div
                                            class="m-accordion__item-head {{ $index == 0 ? 'collapsed-' : 'collapsed' }}"
                                            role="tab"
                                            id="m_section_2_content_{{$faq->id}}_head" data-toggle="collapse"
                                            href="#m_section_2_content_{{$faq->id}}_body">
															<span class="m-accordion__item-title">
																{{ $faq->question }}
															</span>
                                            <a href="{{ route('admin.faq.edit', $faq->id) }}"
                                               class=" m-portlet__nav-link btn btn-info m-btn
                                                    m-btn--icon m-btn--icon-only m-btn--pill">
                                                <i class="la la-edit"></i>
                                            </a>
                                            <a href="javascript:;" data-id="{{ $faq->id }}"
                                               data-route="{{ route('admin.faq.delete', $faq->id) }}"
                                               class="delete-faq m-portlet__nav-link btn btn-danger m-btn
                                                    m-btn--icon m-btn--icon-only m-btn--pill">
                                                <i class="la la-close"></i>
                                            </a>
                                            <span class="m-accordion__item-mode"></span>
                                        </div>
                                        <div class="m-accordion__item-body collapse {{ $index == 0 ? 'show' : '' }}"
                                             id="m_section_2_content_{{$faq->id}}_body" role="tabpanel"
                                             aria-labelledby="m_section_2_content_{{$faq->id}}_head"
                                             data-parent="#m_section_2_content">
                                            <div class="m-accordion__item-content">
                                                <p>{!!  $faq->answer !!}</p>
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                            <!--end::Item-->
                            </div>
                            <!--end::Item-->

                            <div class="m-portlet m-portlet--rounded" style="margin: 5% 0%">
                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <h3 class="m-portlet__head-text">
                                                Add FAQ
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-portlet__body">
                                    {!! Form::open(['url' => route('admin.faq.store'), 'method' => 'post',
                                        'enctype' => 'multipart/form-data']) !!}

                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input"
                                               class="col-md-2 col-form-label">
                                            User
                                        </label>
                                        <div class="col-md-9 col-sm-12">
                                            <select class="form-control" name="type">
                                                <option value="educator">Teachers</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">
                                            Category
                                        </label>
                                        <div class="col-md-9 col-sm-12">
                                    <span
                                        class="m-form__help">Select an existing Category or create a new one.</span>                                                    </span>
                                            <select class="form-control userFaqSelect" name="category_id"
                                                    id="teacher-category">
                                                @foreach($teacherCategories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                                <option value="new">Add New Category</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div id="new-category-teacher" style="display: {{ $teacherCategories->count() == 0 ? 'block' : 'none' }};">
                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input"
                                                   class="col-md-2 col-form-label">
                                                Add New Category
                                            </label>
                                            <div class="col-md-9 col-sm-12">
                                                <input class="form-control m-input" type="text" name="new_category"
                                                       placeholder="Create a new category">
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input"
                                                   class="col-md-2 col-form-label">
                                                Category Icon
                                            </label>
                                            <div class="col-md-9 col-sm-12">
                                                <input class="form-control m-input" type="file" name="new_category_icon"
                                                       placeholder="Category Icon">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input"
                                               class="col-md-2 col-form-label">
                                            Question
                                        </label>
                                        <div class="col-md-9 col-sm-12">
                                            <input class="form-control m-input" type="text"
                                                   name="question" value="">
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input"
                                               class="col-md-2 col-form-label">
                                            Answer
                                        </label>
                                        <div class="col-md-9 col-sm-12">
                                            <textarea class="summernote2" id="answer" name="answer"></textarea>
                                        </div>
                                    </div>

                                    <div class="m-form__actions">
                                        <div class="row">
                                            <div class="col-md-7 col-sm-12">
                                                <button type="submit"
                                                        class="btn btn-brand m-btn m-btn--air m-btn--custom">
                                                    Add FAQ
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--begin::Section 2-->
                </div>
            </div>
        </div>
    </div>
</div>
