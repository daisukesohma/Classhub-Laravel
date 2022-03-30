@extends('admin.layouts.master')

@section('title')
    Classhub | Front End Website

@endsection

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title ">
                    Front End Website
                </h3>

            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">

        @include('messages.all')
        <div class="m-portlet m-portlet--rounded" style="margin: 5% 0%">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Edit FAQ
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                {!! Form::model($faq, ['url' => route('admin.faq.update', $faq->id), 'method' => 'post',
                    'enctype' => 'multipart/form-data']) !!}

                <div class="form-group m-form__group row">
                    <label for="example-text-input"
                           class="col-md-2 col-form-label">
                        User
                    </label>
                    <div class="col-md-9 col-sm-12">
                        <select class="form-control" name="type">
                            <option value="{{ $faq->type }}">{{ $faq->type == 'educator' ? 'Teacher' : 'Parent' }}</option>
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
                            @foreach($categories as $category)
                                @if($category->id == $faq->category_id)
                                    <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                @else
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endif
                            @endforeach
                            <option value="new">Add New Category</option>
                        </select>

                    </div>
                </div>
                <div id="new-category-teacher"
                     style="display: {{ $categories->count() == 0 ? 'block' : 'none' }};">
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
                               name="question" value="{{ $faq->question }}">
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label for="example-text-input"
                           class="col-md-2 col-form-label">
                        Answer
                    </label>
                    <div class="col-md-9 col-sm-12">
                        <textarea class="summernote" id="answer" name="answer">{{ $faq->answer }}</textarea>
                    </div>
                </div>

                <div class="m-form__actions">
                    <div class="row">
                        <div class="col-md-7 col-sm-12">
                            <button type="submit"
                                    class="btn btn-brand m-btn m-btn--air m-btn--custom">
                                Update FAQ
                            </button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>

    </div>

@endsection

@section('page_scripts')

    <!--begin::Page Vendors -->
    <script src="{{  asset('admin/js/jquery-ui.bundle.js') }}" type="text/javascript"></script>
    <!--end::Page Vendors -->
    <!--begin::Page Snippets -->
    <script src="{{  asset('admin/js/dropzone.js') }}" type="text/javascript"></script>
    <script src="{{  asset('admin/js/draggable.js') }}" type="text/javascript"></script>
    <script src="{{  asset('admin/js/summernote.js') }}" type="text/javascript"></script>
    <!--end::Page Snippets -->

    <script type="text/javascript">


        $('.summernote').summernote({
            height: 400,
            callbacks: {
                onImageUpload: function (files) {
                    var formData = new FormData();
                    var url = '{{ route('upload.image', 'faqs') }}'
                    formData.append('file', files[0])

                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'JSON',
                        success: function (data) {
                            console.log(data)
                            $('.summernote').summernote('insertImage', data.storage_path, data.title);
                        },
                        error: function (data) {
                        }
                    })
                }
            }
        })

        $("#parent-category").change(function () {
            if ($(this).val() == "new") {
                $("#new-category-parent").show();
            } else {
                $("#new-category-parent").hide();
            }
        });

        $("#teacher-category").change(function () {
            if ($(this).val() == "new") {
                $("#new-category-teacher").show();
            } else {
                $("#new-category-teacher").hide();
            }
        });
    </script>

@endsection


