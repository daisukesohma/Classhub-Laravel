@extends('educator.layouts.master')
@section('title')
    Classhub | Re-Upload Video
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
                                    <div class="title">Please re-upload your video</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Steps Section-->

                        <!--begin: Form Wizard Form-->

                    <!-- starts: Class Details -->
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

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                        <span class="text-primary">*</span>Re-upload "{{ $class->video_name }}" Video:
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
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step -->

                            </div>
                            <!--end: Form Body -->
                        </div>
                    </div>
                    <!-- end: Class Details -->


                </div>
            </div>
        </div>
    </div>

    @include('educator.modals.complete-profile-payment')

    @include('common.type2-account-live')

@endsection

@section('page_scripts')

    <script src="{{ asset('educator/assets/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.jscroll.min.js') }}"></script>
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <script src="{{ asset('js/show-more.js') }}" type="text/javascript"></script>
    {{--<script src="{{ asset('js/dropzone.js') }}" type="text/javascript"></script>--}}

    <script type="text/javascript">

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

                $(resultModal).find('div.modal-body').html(`<div class="">Uploading video, Please wait...</div>`)
                $(resultModal).modal('show')

                var formData = new FormData();
                var videoFile = fileInput.files[0]
                formData.append('video', videoFile)
                formData.append('_token', '{{csrf_token()}}')
                formData.append('id', '{{ $class->id }}')

                $.ajax({
                    url: '{{ route('vimeo.re-upload') }}',
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
                                window.location = '{{ route('educator.pre-recorded') }}'

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
        })

    </script>


@endsection
