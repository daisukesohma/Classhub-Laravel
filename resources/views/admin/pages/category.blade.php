@extends('admin.layouts.master')

@section('title')
    Classhub | Category Banners

@endsection

@section('page_styles')
    <style type="text/css">
        .categories {
            max-height: 600px;
            overflow-y: auto;
            background: #f7f8fa
        }

        .m-nav.m-nav--active-bg .m-nav__item > .m-nav__link.m-tabs__item--active {
            background: #ffffff !important;
        }
    </style>
@endsection

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title ">
                    Category Banners
                </h3>

            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">

        <div class="m-portlet m-portlet--full-height ">

            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xl-3 col-sm-12">
                        <div class="m-tabs" data-tabs="true" data-tabs-contents="#m_sections">
                            <ul class="m-nav m-nav--active-bg m-nav--active-bg-padding-lg m-nav--font-lg
                                m-nav--font-bold m--margin-bottom-20 m--margin-top-10 categories"
                                id="m_nav" role="tablist">
                                @foreach($categories as $category)
                                    <li class="m-nav__item">
                                        <a class="m-nav__link m-tabs__item category-item"
                                           data-tab-target="#category-{{ $category->id }}"
                                           data-route="{{ route('admin.update.category',$category->id) }}"
                                           data-name="{{ $category->name }}"
                                           data-banner-path="{{ route('home').Storage::url(optional($category->bannerPhoto)->path) }}"
                                           href="javascript:;">
														<span class="m-nav__link-text">
															{{ $category->name }}
														</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-9">
                        <div class="m-tabs-content" id="m_sections">
                            <!--begin::Section 1-->
                            <div class="" id="category-edit">
                                <div class="tab-pane active" id="m_user_profile_tab_1">
                                    {!! Form::open(['url' => '', 'method' => 'POST', 'id' => 'category-form',
                                        'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
                                    <div class="m-portlet__body">
                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input" class="col-md-3 col-sm-12 col-form-label">
                                                Name
                                            </label>
                                            <div class="col-md-7 col-sm-12">
                                                <input class="form-control m-input" type="text" name="name"
                                                       id="name">
                                            </div>
                                        </div>

                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input" class="col-md-3 col-sm-12 col-form-label">
                                                Current Banner URL
                                            </label>
                                            <div class="col-md-7 col-sm-12">
                                                <a href="#" target="blank" id="banner-path"></a>
                                            </div>
                                        </div>

                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input" class="col-md-3 col-sm-12 col-form-label">
                                                Banner Image
                                            </label>
                                            <div class="col-md-7 col-sm-12">
                                                <div class="m-dropzone dropzone"
                                                     action="{{ route('upload.image', 'category-banners') }}"
                                                     id="dropzone-one">
                                                    <div class="m-dropzone__msg dz-message needsclick">
                                                        <h3 class="m-dropzone__msg-title">
                                                            Drop image file here or click to upload.
                                                        </h3>
                                                        <span class="m-dropzone__msg-desc">For best results, upload image size: 1980 x 990px</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-portlet__foot m-portlet__foot--fit">
                                        <div class="m-form__actions">
                                            <div class="row">
                                                <div class="col-md-7 col-sm-12 text-right">
                                                    <button type="submit"
                                                            class="btn btn-brand m-btn m-btn--air m-btn--custom">
                                                        Update Category
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection


@section('page_scripts')

    <script src="{{  asset('admin/js/jquery-ui.bundle.js') }}" type="text/javascript"></script>
    <script src="{{  asset('admin/js/dropzone.js') }}" type="text/javascript"></script>
    <script type="text/javascript">

        $(function () {

            $('body').on('click', 'a.category-item', function () {
                $('form#category-form').attr('action', $(this).data('route'))
                $('input#name').val($(this).data('name'))
                if ($(this).attr('data-banner-path')) {
                    $('a#banner-path').html($(this).attr('data-banner-path'))
                    $('a#banner-path').attr('href', $(this).attr('data-banner-path'))
                } else {
                    $('a#banner-path').html('')
                    $('a#banner-path').attr('href', '#')
                }
                // $('div.dz-complete').remove()
            })

        })

        Dropzone.options.dropzoneOne = {
            addRemoveLinks: true,
            maxFiles: 1,
            acceptedFiles: 'image/*',
            params: {thumbs: true},
            removedfile: function (file) {
                console.log(file)

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

        // Delete FAQ
        $('body').on('submit', 'form#category-form', function (e) {
            e.preventDefault();
            var url = $(this).attr('action')

            if (url == '{{ route('home') }}') {
                swal('Error', 'Please select Category', "error")

            } else {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: $(this).serialize(),
                    dataType: 'JSON',
                    success: function (data) {
                        console.log(data)
                        if (data.status) {
                            $('a.m-tabs__item--active span').html(data.category.name);
                            $('a.m-tabs__item--active').attr('data-banner-path', data.category.banner_photo.path);
                            swal('Category updated successfully', '', "success")
                        } else {
                            swal('Error', data.messages.join(), "error")
                        }
                    },
                    error: function (data) {
                        swal('Error', data.messages.join(), "error")
                    }
                })
            }
            return false;
        })

    </script>

@endsection
