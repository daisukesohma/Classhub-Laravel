@extends('admin.layouts.master')

@section('title')
    Classhub | Add Category

@endsection

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title ">
                    Add Category
                </h3>
            </div>
        </div>
    </div>

    <div class="m-content">

        @include('messages.all')


        <div class="m-portlet m-portlet--full-height">


            {!! Form::open(['url' => route('admin.category.store'), 'method' => 'POST',
                'class' => 'm-form m-form--fit m-form--label-align-right']) !!}

            <div class="m-portlet__body">
              <div class="form-group m-form__group m--margin-top-10">
                  <div class="alert m-alert m-alert--default" role="alert">
                    When adding a category, you will also need to add a subcategory to be able to list and search classes within the category. You can turn a category into a subcategory by assigning it a Parent Category.
                  </div>
              </div>
                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-md-2 col-sm-12 col-form-label">
                        Category Name
                    </label>
                    <div class="col-md-7 col-sm-12">
                        <input class="form-control m-input" type="text" name="name"
                               placeholder="Category Name"
                               required>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-md-2 col-sm-12 col-form-label">
                        Parent Category
                    </label>
                    <div class="col-md-7 col-sm-12">
                        {!! Form::select('parent_id', \App\Category::getParentCategories()->pluck('name', 'id'),
                            null, ['class' => 'form-control', 'placeholder' => 'Select Category']) !!}
                    </div>
                </div>

                <div class="form-group m-form__group row subcategory-section" style="display: none;">
                    <label for="example-text-input" class="col-md-2 col-sm-12 col-form-label">
                        Subcategory
                    </label>
                    <div class="col-md-7 col-sm-12">
                        {!! Form::select('subcategory_id', [],
                            null, ['class' => 'form-control', 'placeholder' => 'Select Subcategory']) !!}
                    </div>
                </div>

                <div class="form-group m-form__group row cycle-section" style="display: none;">
                    <label for="example-text-input" class="col-md-2 col-sm-12 col-form-label">
                        Cycle
                    </label>
                    <div class="col-md-7 col-sm-12">
                        {!! Form::select('cycle_id', [],
                            null, ['class' => 'form-control', 'placeholder' => 'Select Cycle']) !!}
                    </div>
                </div>

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
                                Add Category
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

        $('select[name="parent_id"]').on('change', function() {
            if (this.value) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.category.subcategories') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        category_id: this.value,
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.subcategories) {
                            $('.subcategory-section').show()
                            $('select[name="subcategory_id"]').find('option').remove()
                            $('select[name="subcategory_id"]').append('<option value="">Select Subcategory</option>')

                            let categories = data.subcategories
                            for (const key in categories) {
                                if (Object.hasOwnProperty.call(categories, key)) {
                                    const name = categories[key]
                                    $('select[name="subcategory_id"]').append(`<option value="${key}">${name}</option>`)
                                }
                            }
                        } else {
                            $('.subcategory-section').hide()
                            $('.cycle-section').hide()
                        }
                    },
                    error: function (data) {
                        console.log(data)
                    }
                });
            } else {
                $('.subcategory-section').hide()
            }
        });

        $('select[name="subcategory_id"]').on('change', function() {
            if (this.value) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.category.subcategories') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        category_id: this.value,
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.subcategories) {
                            $('.cycle-section').show()
                            $('select[name="cycle_id"]').find('option').remove()
                            $('select[name="cycle_id"]').append('<option value="">Select Cycle</option>')

                            let categories = data.subcategories
                            for (const key in categories) {
                                if (Object.hasOwnProperty.call(categories, key)) {
                                    const name = categories[key]
                                    $('select[name="cycle_id"]').append(`<option value="${key}">${name}</option>`)
                                }
                            }
                        } else {
                            $('.cycle-section').hide()
                        }
                    },
                    error: function (data) {
                        console.log(data)
                    }
                });
            } else {
                $('.cycle-section').hide()
            }
        });
    </script>

@endsection
