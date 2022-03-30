@extends('admin.layouts.master')

@section('title')
    Classhub | Add Post

@endsection

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title ">
                    Add Post
                </h3>
            </div>
        </div>
    </div>

    <div class="m-content">

        @include('messages.all')


        <div class="m-portlet m-portlet--full-height">


            {!! Form::open(['url' => route('admin.post.store'), 'method' => 'POST',
                'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
            <div class="m-portlet__body">
                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-md-2 col-sm-12 col-form-label">
                        Title
                    </label>
                    <div class="col-md-7 col-sm-12">
                        <input class="form-control m-input" type="text" name="title"
                               placeholder="Post Title"
                               required>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-md-2 col-sm-12 col-form-label">
                        Content
                    </label>
                    <div class="col-md-10 col-sm-12">
                        <textarea name="content" class="form-control m-input summernote"></textarea>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-md-2 col-sm-12 col-form-label">
                        Category
                    </label>
                    <div class="col-md-7 col-sm-12">
                        {!! Form::select('category_id', \App\Category::getParentCategories()->pluck('name', 'id'),
                            null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-md-2 col-sm-12 col-form-label">
                        Publish Date
                    </label>
                    <div class="col-md-7 col-sm-12">
                        <input type="date" class="form-control" name="published_at"
                               placeholder="Select date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-md-2 col-sm-12 col-form-label">
                        Featured Image
                    </label>
                    <div class="col-md-7 col-sm-12">
                        <div class="m-dropzone dropzone" action="{{ route('upload.image', 'featured-images') }}"
                             id="dropzone-one">
                            <div class="m-dropzone__msg dz-message needsclick">
                                <h3 class="m-dropzone__msg-title">
                                    Drop image files here or click to upload.
                                </h3>

                                <span
                                    class="m-dropzone__msg-desc"></span>                                                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-md-2 col-sm-12 col-form-label">
                        Metadata (SEO)
                    </label>

                    <div class="col-md-7 col-sm-12" id="data-repeater">
                        <!-- starts : repeat div -->
                        <div data-repeater-list="metadata"
                             class="repeater-item-container">

                            <div data-repeater-item
                                 class="form-group">
                                <input type="text" class="form-control "
                                       name="name" placeholder="Meta Name"><br>
                                <textarea type="text" class="form-control" rows="3"
                                          name="value" placeholder="Meta Value"></textarea>
                                <hr>

                            </div>
                        </div>
                        <!-- end : repeat div -->
                        <!-- starts : buttons -->
                        <div class="p-t-12 p-b-2">
                            <a data-repeater-delete href="javascript:;"
                               class="btn-sm btn btn-primary m-btn m-btn--icon data-repeater-delete">
                                                                 <span>
                                                                    <i class="la la-trash-o"></i>
                                                                    <span>Delete</span>
                                                                 </span>
                            </a>
                            <a data-repeater-create href="javascript:;"
                               class="btn-sm btn btn-primary m-btn m-btn--icon add-btn">
                                                                 <span>
                                                                    <i class="la la-plus"></i>
                                                                    <span>Add</span>
                                                                 </span>
                            </a>
                        </div>
                        <!-- end : buttons -->
                    </div>
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions">
                    <div class="row text-right">
                        <div class="col-md-7 col-sm-12">
                            <button type="reset"
                                    class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                                Cancel
                            </button>

                            <button type="submit"
                                    class="btn btn-brand m-btn m-btn--air m-btn--custom">
                                Create Post
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
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

        Dropzone.options.dropzoneOne = {
            addRemoveLinks: true,
            maxFiles: 1,
            acceptedFiles: 'image/*',
            removedfile: function (file) {
                console.log(file)
                var route = '{{ route('home') }}' + '/image/' + file.id + '/delete'

                $.ajax({
                    type: 'DELETE',
                    url: route,
                    data: {_token: '{{ csrf_token() }}'},
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                    },
                    error: function (data) {
                        console.log(data)
                    }
                });

                var _ref;
                return (_ref = file.previewElement) != null ?
                    _ref.parentNode.removeChild(file.previewElement) : void 0;
            },
            success: function (file, done) {
                if (done.error) {
                    alert(done.error)
                } else {
                    let formInput = Dropzone.createElement('<input type="hidden"  name="featured_image"  ' +
                        'value="' + done.id + '">');
                    file.previewElement.appendChild(formInput);
                    file.id = done.id;
                    file.path = done.path;
                }
            },
        }


        $(function () {

            $('div#data-repeater').repeater({
                initEmpty: false,
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    // Not working
                    $(this).slideUp(deleteElement);
                },
                isFirstItemUndeletable: true
            })

            $('a.data-repeater-delete').on('click', function () {
                if ($('div.repeater-item-container > div').length !== 1)
                    $('div.repeater-item-container > div:last').remove()
            })
        })

        $('.summernote').summernote({
            height: 400,
            callbacks: {
                onImageUpload: function (files) {
                    var formData = new FormData();
                    var url = '{{ route('upload.image', 'blogs') }}'
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
    </script>

@endsection

