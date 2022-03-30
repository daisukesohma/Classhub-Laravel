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

    <!--Begin::Section-->
        <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
            <div class="m-portlet__head">
                <div class="m-portlet__head-tools">
                    <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary"
                        role="tablist">
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link {{ !request()->get('tab')  ? 'active': '' }}"
                               data-toggle="tab"
                               href="#m_user_profile_tab_1" role="tab">
                                <i class="flaticon-share m--hide"></i>
                                Update Homepage
                            </a>

                        </li>
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link {{ request()->get('tab') == 'faq' ? 'active': '' }}"
                               data-toggle="tab" href="#faq" role="tab">
                                FAQ
                            </a>

                        </li>
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link {{ request()->get('tab') == 'testimonial' ? 'active': '' }}"
                               data-toggle="tab" href="#testimonials" role="tab">
                                Testimonials
                            </a>

                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                @include('admin.pages.setting-tabs.homepage')
                @include('admin.pages.setting-tabs.faq')
                @include('admin.pages.setting-tabs.testimonial')
            </div>
        </div>
        <!--End::Section-->
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
                    let formInput = Dropzone.createElement('<input type="hidden"  name="banner_images[]"  ' +
                        'value="' + done.id + '">');
                    file.previewElement.appendChild(formInput);
                    file.id = done.id;
                    file.path = done.path;
                }
            },
        }

        Dropzone.options.dropzoneTwo = {
            addRemoveLinks: true,
            acceptedFiles: 'image/*',
            removedfile: function (file) {
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
                    let formInput = Dropzone.createElement('<input type="hidden"  name="trusted_logos[]"  ' +
                        'value="' + done.id + '">');
                    file.previewElement.appendChild(formInput);
                    file.id = done.id;
                    file.path = done.path;
                }
            },
        }

        Dropzone.options.dropzoneThree = {
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
                    let formInput = Dropzone.createElement('<input type="hidden"  name="educator_image"  ' +
                        'value="' + done.id + '">');
                    file.previewElement.appendChild(formInput);
                    file.id = done.id;
                    file.path = done.path;
                }
            },
        }

        $(function () {

            // Delete Banner Image
            $('body').on('click', 'a.delete-banner', function () {
                var _this = $(this)

                swal({
                    title: 'Are you sure you want to delete Banner Image?',
                    type: 'warning',
                    showCancelButton: !0,
                    confirmButtonText: 'Yes, delete',
                    cancelButtonText: 'No, cancel',
                    reverseButtons: !0
                })
                    .then(function (e) {
                        if (e.value) {
                            $.ajax({
                                type: 'DELETE',
                                url: $(_this).data('route'),
                                data: {_token: '{{ csrf_token() }}'},
                                dataType: 'JSON',
                                success: function (data) {
                                    console.log(data)
                                    if (data.status) {
                                        $(_this).parents('div.banner-image').remove()
                                        swal('Banner image deleted', '', "success")
                                    } else {
                                        swal('Error', data.messages.join(), "error")
                                    }
                                },
                                error: function (data) {
                                    swal('Error', data.messages.join(), "error")
                                }
                            })
                        } else {
                            "cancel" === e.dismiss
                        }
                    })
            })


            // Delete Trusted Logo
            $('body').on('click', 'button.delete-trusted-logo', function () {
                var _this = $(this)

                swal({
                    title: 'Are you sure you want to delete this Logo?',
                    type: 'warning',
                    showCancelButton: !0,
                    confirmButtonText: 'Yes, delete',
                    cancelButtonText: 'No, cancel',
                    reverseButtons: !0
                })
                    .then(function (e) {
                        if (e.value) {
                            $.ajax({
                                type: 'DELETE',
                                url: $(_this).data('route'),
                                data: {_token: '{{ csrf_token() }}'},
                                dataType: 'JSON',
                                success: function (data) {
                                    console.log(data)
                                    if (data.status) {
                                        $(_this).parents('a.logo').remove()
                                        swal('Logo Deleted', '', "success")
                                    } else {
                                        swal('Error', data.messages.join(), "error")
                                    }
                                },
                                error: function (data) {
                                    swal('Error', data.messages.join(), "error")
                                }
                            })
                        } else {
                            "cancel" === e.dismiss
                        }
                    })
            })

            // Delete FAQ
            $('body').on('click', 'a.delete-faq', function () {
                var _this = $(this)

                swal({
                    title: 'Are you sure you want to delete this FAQ?',
                    type: 'warning',
                    showCancelButton: !0,
                    confirmButtonText: 'Yes, delete',
                    cancelButtonText: 'No, cancel',
                    reverseButtons: !0
                })
                    .then(function (e) {
                        if (e.value) {
                            $.ajax({
                                type: 'DELETE',
                                url: $(_this).data('route'),
                                data: {_token: '{{ csrf_token() }}'},
                                dataType: 'JSON',
                                success: function (data) {
                                    console.log(data)
                                    if (data.status) {
                                        $(_this).parents('div.m-accordion__item').remove();
                                        swal('FAQ Deleted', '', "success")
                                    } else {
                                        swal('Error', data.messages.join(), "error")
                                    }
                                },
                                error: function (data) {
                                    swal('Error', data.messages.join(), "error")
                                }
                            })
                        } else {
                            "cancel" === e.dismiss
                        }
                    })
            })


            // Sort testimonial
            $('div.testimonial-sortable').on('sortstop', function (event, ui) {
                let dataString = $('form#testimonial-sort-form').serialize()
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.testimonial.sort') }}',
                    data: dataString,
                    dataType: 'JSON',
                    success: function (data) {
                        console.log(data)
                    },
                    error: function (data) {
                        console.log(data)
                    }
                });
            });

            // Delete Testimonial
            $('body').on('click', 'a.delete-testimonial', function () {
                var _this = $(this)

                swal({
                    title: 'Are you sure you want to delete this Testimonial?',
                    type: 'warning',
                    showCancelButton: !0,
                    confirmButtonText: 'Yes, delete',
                    cancelButtonText: 'No, cancel',
                    reverseButtons: !0
                })
                    .then(function (e) {
                        if (e.value) {
                            $.ajax({
                                type: 'DELETE',
                                url: $(_this).data('route'),
                                data: {_token: '{{ csrf_token() }}'},
                                dataType: 'JSON',
                                success: function (data) {
                                    console.log(data)
                                    if (data.status) {
                                        $(_this).parents('div.testimonial-container').remove();
                                        swal('Testimonial Deleted', '', "success")
                                    } else {
                                        swal('Error', data.messages.join(), "error")
                                    }
                                },
                                error: function (data) {
                                    swal('Error', data.messages.join(), "error")
                                }
                            })
                        } else {
                            "cancel" === e.dismiss
                        }
                    })
            })

        })

        $('.summernote1').summernote({
            height: 400,
            callbacks: {
                onImageUpload: function (files) {
                    var formData = new FormData();
                    var url = '{{ route('upload.image', 'faqs') }}'
                    formData.append('file', files[0])
                    swal({
                        title: 'Uploading image, Please wait..',
                        icon: 'info',
                        buttons: false,
                    })

                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'JSON',
                        success: function (data) {
                            console.log(data)
                            setTimeout(function () {
                                swal.close()
                            }, 1000)
                            $('.summernote1').summernote('insertImage', data.storage_path, data.title);
                        },
                        error: function (data) {
                            swal({
                                title: 'Error while uploading image',
                                icon: 'error',
                                buttons: false,
                            })
                        }
                    })
                }
            }
        })

        $('.summernote2').summernote({
            height: 400,
            callbacks: {
                onImageUpload: function (files) {
                    var formData = new FormData();
                    var url = '{{ route('upload.image', 'faqs') }}'
                    formData.append('file', files[0])

                    swal({
                        title: 'Uploading image, Please wait..',
                        icon: 'info',
                        buttons: false,
                    })

                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'JSON',
                        success: function (data) {
                            console.log(data)
                            setTimeout(function () {
                                swal.close()
                            }, 1000)
                            $('.summernote2').summernote('insertImage', data.storage_path, data.title);
                        },
                        error: function (data) {
                            swal({
                                title: 'Error while uploading image',
                                icon: 'error',
                                buttons: false,
                            })
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

