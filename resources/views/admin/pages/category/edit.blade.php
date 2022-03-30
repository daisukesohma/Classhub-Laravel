@extends('admin.layouts.master')

@section('title')
    Classhub | Edit Category

@endsection

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title ">
                    Edit Category
                </h3>
            </div>
        </div>
    </div>

    <div class="m-content">

        @include('messages.all')


        <div class="m-portlet m-portlet--full-height">


            {!! Form::model( $category, ['url' => route('admin.category.update', $category->id), 'method' => 'POST',
                'class' => 'm-form m-form--fit m-form--label-align-right']) !!}

            <div class="m-portlet__body">
                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-md-2 col-sm-12 col-form-label">
                        Category Name
                    </label>
                    <div class="col-md-7 col-sm-12">
                        {!! Form::text('name', null, ['class' => 'form-control m-input',
                         'required' => 'required', 'placeholder' => 'Category Name']) !!}
                    </div>
                </div>

                <!-- @if($category->parent_id)
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-md-2 col-sm-12 col-form-label">
                            Parent Category
                        </label>
                        <div class="col-md-7 col-sm-12">
                            {!! Form::select('parent_id', \App\Category::getParentCategories()->pluck('name', 'id'),
                                null, ['class' => 'form-control', 'placeholder' => 'Select Category']) !!}
                        </div>
                    </div>
                @endif -->

                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-md-2 col-sm-12 col-form-label">
                        Category Type
                    </label>
                    <div class="col-md-7 col-sm-12">
                        {!! Form::select('type', ['Grinds' => 'Grinds', 'Activities' => 'Activities'],
                            null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-md-2 col-sm-12 col-form-label">
                        Category Banner
                    </label>
                    <div class="col-md-7 col-sm-12">
                        <div class="m-dropzone dropzone" action="{{ route('upload.image', 'category-banners') }}"
                             id="dropzone-one">
                            @if( $category->banner)
                                <div class="dz-preview dz-processing dz-image-preview dz-complete banner-image">
                                    <div class="dz-image">
                                        <img style="height: 120px"
                                             src="{{ Storage::url($category->bannerPhoto->path) }}"
                                             data-dz-thumbnail=""/>
                                        <div class="file-placeholder">
                                            <i class="fa fa-file-text"></i>
                                        </div>
                                    </div>
                                    <div class="dz-details">
                                        <div class="dz-size">
                                            <span data-dz-size=""><strong></strong></span>
                                        </div>
                                        <div class="dz-filename">
                                <span data-dz-name="">
                                    <a target="_blank" style="cursor:pointer;"
                                       href="{{ Storage::url($category->bannerPhoto->path) }}">View Image</a>
                                </span>
                                        </div>
                                    </div>

                                    <div class="dz-progress">
                            <span class="dz-upload" data-dz-uploadprogress=""
                                  style="width: 100%;">

                            </span>
                                    </div>
                                    <a class="dz-remove delete-banner" href="javascript:;"
                                       data-dz-remove=""
                                    >Remove Banner</a>
                                    <input name="banner" value="{{ $category->banner }}" type="hidden">
                                </div>

                            @else
                                <div class="m-dropzone__msg dz-message needsclick">
                                    <h3 class="m-dropzone__msg-title">
                                        Drop image files here or click to upload.
                                    </h3>

                                    <span
                                        class="m-dropzone__msg-desc"></span>                                                                    </span>
                                </div>
                            @endif
                        </div>
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
                                    class="btn btn-success btn-brand m-btn m-btn--air m-btn--custom">
                                Update Category
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
                    let formInput = Dropzone.createElement('<input type="hidden"  name="banner"  ' +
                        'value="' + done.id + '">');
                    file.previewElement.appendChild(formInput);
                    file.id = done.id;
                    file.path = done.path;
                }
            },
        }

        $('body').on('click', 'a.delete-banner', function () {
            $(this).parents('.banner-image').remove()
        })
    </script>

@endsection

