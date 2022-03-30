@extends('educator.layouts.master')
@section('title')
    Classhub | Create Pre-Recorded Class
@endsection

@section('page_styles')
    <link href="{{ asset('css/calendar.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="{{ asset('css/flatpickr.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <style type="text/css">
        .other-category {
            opacity: 1 !important;
            cursor: pointer !important;
            display: inline-block;
            width: 60% !important;
            padding: 5px 10px !important;
        }

        .show-more-button-container {
            width: 100%;
            padding: 0;
        }

        .preview-error {
            padding: 20px 0px;
            text-align: center;
            font-size: 23px;
            line-height: 40px;
        }

        .delete-video, .delete-video * {
            color: #e74b65 !important;
            cursor: pointer;
        }

        @media (max-width: 500px) {
            .preview-error {
                font-size: 15px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body list-a-class">

        <div class="m-grid__item m-grid__item--fluid m-wrapper visible step2">
            <div class="row col-12" style="margin: 0 auto">
                {{--<div class="col-lg-2 col-md-2"></div>--}}
                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12" style="margin: 0 auto">
                    <div class="m-content signup-form">

                        <!--Begin::Steps Section-->
                        <div class="m-portlet steps" style="padding: 0">
                            <!--begin: Portlet Head-->
                            <div class="m-portlet__head shadow-v1">
                                <div class="m-portlet__head-caption">
                                    <div class="title">Upload your video(s) and start selling</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Steps Section-->

                        <!--begin: Form Wizard Form-->
                    {!! Form::open( ['url' => route('educator.pre-recorded.store'),
                    'method' => 'post', 'id' => 'lesson-form',
                    'class' => 'm-form m-form--label-align-left- m-form--state- class-type']) !!}

                    {!! Form::hidden('class_type', 'pre_recorded') !!}
                    {!! Form::hidden('status', 'in_progress') !!}

                    <!-- starts: Class Details -->
                        <h3 class="m-form__heading-title">Video Details</h3>
                        <div class="m-portlet m-portlet--full-height">
                            <div class="m-wizard__form">
                                <!--
                                1) Use m-form--label-align-left class to alight the form input lables to the right
                                2) Use m-form--state class to highlight input control borders on form validation
                              -->
                                <!--begin: Form Body -->
                                <div class="m-portlet__body">

                                    <!--begin: Form Wizard Step -->
                                    <div class="row">
                                        <div class="col-xl-10 offset-xl-1 padding-mobile-none-lr">
                                            <div class="m-form__section m-form__section--first">

                                                <!-- starts : Category -->
                                                <div class="form-group m-form__group row tophelp no-mobile">
                                                    <div class="col-xl-4 col-lg-4"></div>
                                                    <div class="col-xl-8 col-lg-8">
                                                      <span class="m-form__help">
                                                        Choose the category that best describes your video
                                                      </span>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                        <span class="text-primary">*</span>Category
                                                    </label>
                                                    <div class="col-xl-8 col-lg-8 choose-subjects">
                                                        <span class="m-form__help only-mobile">Choose the category that best describes your class</span>
                                                        <!--begin: Dropdown-->
                                                        <div class="m-dropdown m-dropdown--arrow c-dd-menu"
                                                             m-dropdown-toggle="click">
                                                            <a href="javascript:void(0)"
                                                               class="m-dropdown__toggle btn dropdown-toggle"
                                                               id="category-placeholder">Choose
                                                                a Category</a>

                                                            <div class="m-dropdown__wrapper">
                                                                <div
                                                                    class="m-dropdown__inner taughtSubjects single-select">
                                                                    <div class="m-dropdown__body">
                                                                        <div class="m-dropdown__content">
                                                                            <div class="m-scrollable"
                                                                                 data-scrollable="true"
                                                                                 data-max-height="420">

                                                                                <!-- starts, list options -->
                                                                            @include('educator.includes.category-select-radio',
                                                                            [
                                                                            'name' => 'category_id',
                                                                            'type' => 'radio',
                                                                            'subjects' => [],
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
                                                <!-- end : Category -->

                                                <!-- starts: Class Name -->
                                                <div class="form-group m-form__group row tophelp no-mobile">
                                                    <div class="col-xl-4 col-lg-4"></div>
                                                    <div class="col-xl-8 col-lg-8">
                                                        <span class="m-form__help">
                                                          What will it be called in your advert?
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                        <span class="text-primary">*</span>Video Name:
                                                    </label>
                                                    <div class="col-xl-8 col-lg-8">
                                                        <span class="m-form__help only-mobile">
                                                          What will it be called in your advert?
                                                        </span>
                                                        <input type="text" class="form-control m-input" name="name"
                                                               required
                                                               placeholder="E.g. Guitar Lessons">
                                                    </div>
                                                </div>
                                                <!-- end: Class Name -->

                                                <!-- starts: Price row -->
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-4 col-lg-4 col-form-label price-label">
                                                        <span class="text-primary">*</span>Price:
                                                    </label>
                                                    <div class="col-xl-8 col-lg-8">
                                                        <div class="input-group m-input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">€</span>
                                                            </div>
                                                            <input type="text" placeholder="E.g. 50" name="price"
                                                                   required
                                                                   class="form-control m-input">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end: Price row -->

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                        <span class="text-primary">*</span>Upload Pre-recorded Video(s):
                                                    </label>
                                                    <div class="col-xl-8 col-lg-8">
                                                        <input type="file" name="video" class="form-control"
                                                               accept="video/*"/>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-4 col-lg-4 col-form-label">&nbsp;</label>
                                                    <div class="col-xl-8 col-lg-8" id="uploaded-videos"></div>
                                                </div>

                                            </div>
                                            <!-- end: Areas Covered row -->

                                            <!-- starts: Image Gallery row -->
                                            <div class="form-group m-form__group row photo-bio">
                                                <label class="col-form-label col-lg-4 col-sm-12">
                                                    <span class="text-primary">*</span>Featured Image:<span
                                                        class="m-badge m-badge--brand m-badge--wide info-badge"
                                                        data-toggle="m-popover" data-html="true"
                                                        data-placement="bottom" data-content="
        Pictures can say a lot about what you do. We’d love you to share some of your own pictures but if you can’t then click and drag from our image gallery.
        ">i</span>
                                                </label>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <div class="m-dropzone dropzone"
                                                         action="{{ route('upload.image', 'class-images') }}"
                                                         id="dropzone-one">
                                                        <div class="m-dropzone__msg dz-message needsclick">
                                                            <div class="m-dropzone__msg-title">Drag photos here
                                                                or click to upload.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="javascript:void(0);" class="clickto-upload"
                                                       data-toggle="modal" data-target="#image-gallery-upload"
                                                       id="gallery-image-btn">Click
                                                        here to select an image from our gallery</a>

                                                </div>
                                            </div>
                                            <!-- end: Image Gallery row -->

                                            <!-- starts: Class Description row -->
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-4 col-lg-4 col-form-label">
                                                    <span class="text-primary">*</span>Video Description:<span
                                                        class="m-badge m-badge--brand m-badge--wide info-badge"
                                                        data-toggle="m-popover" data-html="true"
                                                        data-placement="bottom" data-content="
                                                          <p>This is your chance to tell everyone how
                                                            talented you are. And make you stand out
                                                            from the crowd. So don’t hold back.
                                                            Along with a headline that says what you
                                                            teach (i.e. German Tutor ) bring your listing
                                                            to life with words that say a little more
                                                            about you. Like experienced, enthusiastic,
                                                            passionate, etc. All relevant experience is
                                                            worth including, and a little bit on how you
                                                            like to teach is a great idea too. Check out
                                                            our other teachers bios for inspiration</p>
                                                            ">i</span>
                                                </label>
                                                <div class="col-xl-8 col-lg-8">
                                                    <textarea rows="3" class="form-control m-input"
                                                              name="description" required
                                                              placeholder="This is your chance to tell everyone how talented you are. And make you stand out from the crowd."></textarea>
                                                    <span class="m-form__help">Max 500 characters</span>
                                                </div>
                                            </div>
                                            <!-- end: Class Description row -->

                                            <!-- starts: Suitable Ages row -->
                                            <div class="form-group m-form__group row two-selectboxes">
                                                <label class="col-xl-4 col-lg-4 col-form-label">
                                                    <span class="text-primary">*</span>Suitable Ages:<span
                                                        class="m-badge m-badge--brand m-badge--wide info-badge"
                                                        data-toggle="m-popover" data-html="true"
                                                        data-placement="bottom"
                                                        data-content="You supply specific times and how many people can book into your class.">i</span>
                                                </label>
                                                <div class="col-xl-8 col-lg-8">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                            {!! Form::select('age_from',  \App\Lesson::AGE_FROM, null,
                                                            ['class' => 'form-control form-control--fixed m-bootstrap-select m_selectpicker',
                                                            'placeholder' => 'From', 'required' => 'required']) !!}

                                                        </div>
                                                        <div
                                                            class="col-lg-6 col-md-6 col-sm-6 col-xs-6 two student-menu">
                                                            {!! Form::select('age_to',  \App\Lesson::AGE_FROM + ['18+' => '18+'], null,
                                                            ['class' => 'form-control form-control--fixed m-bootstrap-select m_selectpicker',
                                                            'placeholder' => 'To', 'required' => 'required']) !!}

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end: Suitable Ages row -->


                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step -->

                            </div>
                            <!--end: Form Body -->
                        </div>
                    </div>
                    <!-- end: Class Details -->


                    <!-- starts : button preview Class -->
                {{--<div class="preview-profile">
                    <a class="btn btn-secondary shadow-v4 preview-class-btn" href="javascript:void(0);"
                       data-toggle="modal"
                       data-target="#preview-class"><span
                            class="btn__text icon-preview">Preview Class</span></a>
                </div>--}}
                <!-- end : button preview Class -->

                    <!-- starts : save & continue -->
                    <div class="save-continue two-buttons">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 text-left">

                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                <button type="submit" class="btn btn-primary shadow-v4"
                                        id="submit-form">
                                  <span
                                      class="btn__text icon-arrow-right">SAVE & CONTINUE</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- end : save & continue -->

                {!! Form::close() !!}



                <!-- starts : modal preview Class -->
                @include('educator.modals.preview-class')
                <!-- end : modal preview Class -->


                </div>
            </div>
        </div>
    </div>

    @include('educator.modals.complete-profile-payment')

    @include('common.type2-account-live')

@endsection

@section('page_scripts')

    <!--begin::image-gallery Modal-->
    <div class="modal fade c-modal v1  image-gallery list-a-class checkbox-v1"
         id="image-gallery-upload" tabindex="-1"
         role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="position: fixed;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Select images from our Gallery</h5><br>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">
                                      &times;
                                    </span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- starts : choose images -->
                    <div class="choose-images">
                        <div class="m-scrollable" data-scrollable="true" data-max-height="400"
                             data-scrollbar-shown="true">
                            <div class="m-portlet__body">
                                <div class="m-form__section m-form__section--first">
                                    <div class="form-group m-form__group">
                                        <div class="row" id="gallery-images">
                                            <div class="show-more-container row">

                                                @foreach($images as $image)
                                                    <div class="col-6 col-md-4 img">
                                                        <label class="m-option">
                                                                              <span
                                                                                  class="m-checkbox m-checkbox--air m-checkbox--solid m-checkbox--state-brand">
                                                                              <input type="radio"
                                                                                     name="gallery_images[]"
                                                                                     value="{{ $image->id }}"
                                                                                     data-name=" {{ $image->title }}"
                                                                                     data-src="{{ App\Helpers\ClassHubHelper::getImagePath($image)  }}">
                                                                              <span style="position: inherit"></span>
                                                                            </span>
                                                            <img alt="Pic"
                                                                 class="product-thumb lazy"
                                                                 src="{{ route('home') }}{{ Storage::url($image->path) }}"/>
                                                        </label>
                                                    </div>
                                                @endforeach

                                                @if($images->nextPageUrl())
                                                    <div
                                                        class="row showmore p-t-55 show-more-button-container">
                                                        <div class="col-sm-12 col-12 text-center">
                                                            <a class="btn btn-primary shadow-v4 show-more-button"
                                                               href="{{ $images->nextPageUrl().'&'.request()->getRequestUri() }}">
                                                                              <span
                                                                                  class="btn__text">LOAD MORE</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end : choose images -->

                    <!-- starts : upload image -->
                    <div class="upload-button text-center">
                        <a class="btn btn-primary v1 shadow-v4 select-images"
                           href="javascript:void(0);">
                            <span class="btn__text">Select Image</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::image-gallery Modal-->

    <script src="{{ asset('educator/assets/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.jscroll.min.js') }}"></script>
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <script src="{{ asset('js/show-more.js') }}" type="text/javascript"></script>
    {{--<script src="{{ asset('js/dropzone.js') }}" type="text/javascript"></script>--}}

    <script type="text/javascript">

        var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        var modalGallery = $('div#image-gallery-upload')
        var selectedImages = []

        Dropzone.options.dropzoneOne = {
            addRemoveLinks: true,
            maxFiles: 1,
            acceptedFiles: 'image/*',
            dictRemoveFile: 'Remove Image',
            init: function () {
                var prevFile

                this.on('addedfile', function () {
                    if (typeof prevFile !== "undefined") {
                        this.removeFile(prevFile)
                        console.log(prevFile)
                    }
                });

                this.on('success', function (file) {
                    prevFile = file
                });
            },

            success: function (file, done) {
                if (done.error) {
                    alert(done.error)
                } else {
                    if($('div#dropzone-one').find('div.dz-preview').length > 1){
                        $('div#dropzone-one').find('div.dz-preview:first').remove()
                    }
                    let formInput = Dropzone.createElement('<input type="hidden"  name="images[]"  ' +
                        'value="' + done.id + '">');
                    file.previewElement.appendChild(formInput);
                    file.id = done.id;
                    file.path = done.path;
                }
            },
        }

        $('body').on('click', '.select-images', function () {

            $('div#gallery-images input[type="radio"]').each(function () {
                if ($(this).is(':checked')) {
                    let id = $(this).val()
                    let url = $(this).data('src')

                    $('div#dropzone-one').html(`
                              <div class="dz-preview dz-processing dz-image-preview dz-complete" id="image-${id}">
                              <div class="dz-image">
                              <img style="object-fit: cover; width: 120px; height: 120px;" src="${url}"  data-dz-thumbnail=""/>
                              </div>
                              <div class="dz-details">
                              <div class="dz-size">
                              <span data-dz-size=""><strong></strong></span>
                              </div>
                              <div class="dz-filename">
                              <span data-dz-name="">
                              <a target="_blank" style="cursor:pointer;" href="${url}">View Image</a>
                              </span>
                              </div>
                              </div>
                              <div class="dz-progress">
                              <span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span>
                              </div>
                              <a class="dz-remove remove-selected-photo" data-id="${id}" href="javascript:;">
                              Remove Image</a>
                              <input name="images[]" value="${id}" type="hidden" />
                              </div>`)
                }
            })

            $(modalGallery).modal('hide')
        })

        $(function () {

            $('input[name="video"]').on('change', function () {

                if (!$(this)[0].files[0])
                    return;

                checkVideoDuration($(this)[0])
            })

            function uploadVideo(fileInput, videoDuration) {

                console.log('Duration', parseInt(videoDuration))

                if (parseInt(videoDuration) > 3600) {
                    $(fileInput).val('')
                    $(resultModal).find('div.modal-body').html(`<div class="">Maximum duration of video should be 60mins</div>`)
                    $(resultModal).modal('show')
                    return false;
                }

                if (fileInput.files[0].size * 0.000001 > 512) {
                    $(fileInput).val('')
                    $(resultModal).find('div.modal-body').html(`<div class="">Maximum size of video should be 512MB</div>`)
                    $(resultModal).modal('show')
                    return false;
                }

                $(resultModal).find('div.modal-body').html(`<div class="">Uploading video, Please wait...</div>`)
                $(resultModal).modal('show')

                var formData = new FormData();
                var videoFile = fileInput.files[0]
                formData.append('video', videoFile)
                formData.append('_token', '{{csrf_token()}}')

                $.ajax({
                    url: '{{ route('vimeo.upload') }}',
                    data: formData,
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    timeout: 0,
                    success: function (data) {
                        $(fileInput).val('')
                        if (data.status) {
                            $(resultModal).find('div.modal-body').html(`<div class="">${data.message}</div>`)

                            setTimeout(function () {
                                $(resultModal).modal('hide')
                                $('div#uploaded-videos').append(`
                                    <div class="uploaded-video" style="margin-bottom:10px">
                                        <div class="input-group m-input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text delete-video" data-url="${data.delete_url}"><i class="fa fa-trash"></i></span>
                                            </div>
                                            <input type="text" class="form-control m-input" readonly name="videos[${data.id}]" value="${data.name}"
                                            style="border-top-left-radius:0;border-bottom-left-radius:0" />
                                        </div>
                                    </div>
                                `)
                            }, 2000)
                        } else {
                            $(resultModal).find('div.modal-body').html(`<div class="">${data.message}</div>`)
                        }
                    },
                    error: function (data) {
                        $(fileInput).val('')
                        $(resultModal).find('div.modal-body').html(`<div class="">${data.message}</div>`)
                    }
                });
            }

            function checkVideoDuration(fileInput) {

                window.URL = window.URL || window.webkitURL;
                var video = document.createElement('video');
                video.preload = 'metadata'

                video.onloadedmetadata = function () {
                    window.URL.revokeObjectURL(video.src)
                    console.log(video.duration)
                    uploadVideo(fileInput, video.duration)
                }

                video.src = URL.createObjectURL(fileInput.files[0])
            }

            $('body').on('click', 'span.delete-video', function () {
                $(this).parents('div.uploaded-video').remove()
                var deleteUrl = $(this).data('url');

                $.ajax({
                    url: deleteUrl,
                    data: {_token: '{{ csrf_token() }}'},
                    type: 'DELETE',
                    success: function (data) {
                        console.log(data)
                    },
                    error: function (data) {
                        console.log(data)
                    }
                });
            })

            $('input[name="age_from"]').on('change', function () {
                var ageFrom = parseInt($(this).val());

                alert(ageFrom)

                if (ageFrom) {
                    $('input[name="age_to"]').each(function () {
                        if ($(this).val() <= ageFrom) {
                            $(this).attr('disable', 'disable')
                        }
                    })
                }

            })

            $('body').on('click', 'a.remove-selected-photo', function () {
                var id = $(this).data('id')
                $(this).parents(`div#image-${id}`).remove()

                selectedImages = selectedImages.filter(item => {
                    return item !== id
                })

                $('div#dropzone-one').html(`
                    <div class="m-dropzone__msg dz-message needsclick">
                        <div class="m-dropzone__msg-title">Drag photos here or click to upload.
                        </div>
                    </div>
                `)
            })

            $('body').on('click', 'a.auto-add-category', function () {
                var categoryId = $(this).data('id')

                $.ajax({
                    type: 'POST',
                    url: '{{ route('educator.category.add') }}',
                    data: {_token: '{{ csrf_token() }}', category_id: categoryId},
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.status) {
                            console.log(data)
                            $(resultModal).find('div.modal-body').html(data.messages)
                        }
                    },
                    error: function (data) {
                        $(resultModal).find('div.modal-body').html(data.messages)
                    }
                });
            })

            if (iOS) {

                $('button#submit-form').on('click', function (e) {
                    e.preventDefault()

                    $(resultModal).modal('show')

                    var formData = $('form#lesson-form').serializeArray()
                    let type = $('input[name="lesson_type"]:checked').val()
                    if (type == 1) {
                        console.log('one to one')
                        formData.push({name: 'max_num_bookings', value: 1})
                    }

                    $.ajax({
                        type: 'POST',
                        url: $('form#lesson-form').attr('action'),
                        data: formData,
                        dataType: 'JSON',
                        success: function (data) {
                            if (data.status) {
                                $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                                setTimeout(function () {
                                    window.location = data.redirect_url
                                }, 5000)
                            }

                            if (data.status == false && data.category_error) {
                                console.log(data)
                                $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                            } else {
                                $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                            }
                        },
                        error: function (data) {
                            console.log(data)
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    });

                    return false
                })

            } else {

                $('form#lesson-form').on('submit', function (e) {
                    e.preventDefault()

                    $(resultModal).modal('show')

                    var formData = $('form#lesson-form').serializeArray()
                    let type = $('input[name="lesson_type"]:checked').val()
                    if (type == 1) {
                        console.log('one to one')
                        formData.push({name: 'max_num_bookings', value: 1,})
                    }

                    //pushDataLayer();

                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: formData,
                        dataType: 'JSON',
                        success: function (data) {
                            if (data.status) {
                                window.onbeforeunload = null

                                $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                                setTimeout(function () {
                                    window.location = data.redirect_url
                                }, 5000)
                            }

                            if (data.status == false && data.category_error) {
                                console.log(data)
                                $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                            } else {
                                $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                            }
                        },
                        error: function (data) {
                            console.log(data)
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    });

                    return false
                })
            }
        })

        $('a.preview-class-btn').on('click', function () {
            var formData = $('form#lesson-form').serializeArray()
            let type = $('input[name="lesson_type"]:checked').val()
            if (type == 1) {
                console.log('one to one')
                formData.push({name: 'max_num_bookings', value: 1})
            }

            $.ajax({
                type: 'POST',
                url: '{{ route('educator.lesson.preview') }}',
                data: formData,
                dataType: 'HTML',
                success: function (data) {
                    $('div#preview-class').find('div.modal-body').html(data)
                },
                error: function (data) {
                    $('div#preview-class').find('div.modal-body').html(data)
                }
            });
        })

        $('body').on('keyup', 'input.other-category', function (e) {
            parent = $(this).parents('li.parent-category');
            if (!$(this).val().length) {
                $('a#category-placeholder').html('Choose a Category')
            } else {
                $('a#category-placeholder').html($(this).data('parent-category') + ' - ' + $(this).val())
            }
        })

        $(function () {
            $('.jscroll-inner').addClass('row');

            $('select[name="age_from"]').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
                var ageFrom = parseInt($('select[name="age_from"]').val())
                var ageTo = parseInt($('select[name="age_to"]').val())
                console.log(ageFrom)
                console.log(ageTo)
                if (ageFrom) {
                    $('select[name="age_to"] > option').each(function () {
                        if ($(this).val() !== '18+' && parseInt($(this).val()) <= ageFrom) {
                            console.log($(this).val())
                            $(this).prop('disabled', true)
                        } else {
                            $(this).prop('disabled', false)
                        }
                    })
                    $('select[name="age_to"]').selectpicker('refresh')

                    if (ageFrom == 18) {
                        $('select[name="age_to"]').selectpicker('val', '18+')
                    }

                    if (ageFrom <= ageTo) {
                        $('select[name="age_to"]').selectpicker('val', ageFrom + 1)
                    }
                }
            })

        });

    </script>


@endsection
