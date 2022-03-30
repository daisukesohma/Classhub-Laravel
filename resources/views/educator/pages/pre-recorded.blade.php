@extends('educator.layouts.master')

@section('title')
    Classhub | Educator Dashboard
@endsection


@section('page_style')
    <style>

        .copy-link:hover {
            border: none!important;
            background: none!important;
        }

    </style>

@endsection

@section('content')

    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        <div class="m-grid__item m-grid__item--fluid m-wrapper m-b-6">

            <div class="row col-12" style="margin-left:0px; margin-right:0px">

                <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12" style="margin: 0 auto;">
                    <div class="m-content page-dashboard initial-dash">

                        <div class="row title-share">
                            <div class="col-xl-6 col-lg-7 col-md-6 col-sm-12">
                                <h3 class="m-form__heading-title" style="padding-bottom: 20px">Your Tutor Dashboard</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 padding-mobile-none-lr col-eq-height">
                                <div class="row">
                                    <div class="col-lg-12 col-md-6 col-xs-ps-0">
                                        <!-- starts : Dashboard Nav  -->
                                        <div class="profile-side-nav">
                                            <div class="m-portlet">
                                                <div class="m-portlet__body">

                                                    @include('educator.includes.left-menu', ['page' => 'my-classes'])

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    @if(!Auth::user()->trusted)
                                        <div class="col-lg-12 col-md-6 col-md-eq-height col-xs-ps-0">
                                            <!-- starts : Trusted Section  -->
                                            <div class="profile-side-nav">
                                                <div class="m-portlet trusted-box">
                                                    <div class="m-portlet__body">
                                                        <div class="row">
                                                            <div class="col-md-4 col-sm-3 col-xs-3">
                                                                <img class="trusted-shield"
                                                                     src="/img/trusted-by/list-a-class/batch.png"/>
                                                            </div>
                                                            <div class="col-md-8 col-sm-9 col-xs-9">
                                                                <h4>Become Trusted</h4>
                                                                <span class="subtitle">Click <a
                                                                        href="{{ route('educator.trusted') }}">here</a> to learn more</span>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                            <!-- end : Trusted Section  -->
                                            <!-- end : Dashboard Nav -->
                                        </div>
                                    @endif
                                </div>

                            </div>
                            <div class="col-xl-9 col-lg-8 padding-mobile-none-lr col-eq-height">

                                <!--starts: classes Table -->
                            @include('educator.includes.pre-recorded-table')
                            <!--end: classes Table -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>




@endsection

@section('page_scripts')

    <script src="{{  asset('js/custom.js') }}"></script>

    @include('educator.modals.share-profile')

    @include('common.send-message-modal')

    @include('educator.modals.confirm-lesson-delete')

    @include('educator.modals.confirm-lesson-cancel')

    @include('educator.modals.confirm-lesson-live')

    @include('educator.modals.confirm-lesson-pause')

    @include('educator.modals.subject-booking')

    <div class="modal fade c-modal visit-class" id="visit-class-modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        					<span aria-hidden="true">
        						&times;
        					</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade c-modal v1 cancel-class move-class" id="move-class-modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
        					<span aria-hidden="true">
        						&times;
        					</span>
                    </button>
                </div>
                <div class="modal-body p-r-35 p-l-35 p-t-0 p-b-15">

                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        var pauseRoute = ''

        var liveRoute = ''

        var cancelRoute = ''

        var deleteRoute = ''

        var sendMessageModal = $('div#send-message-modal')

        $(function () {

            $('body').on('click', 'i.stat-earning', function () {
                var date = $(this).data('value')
                var type = $(this).data('type')

                $.ajax({
                    type: 'GET',
                    url: '{{ route('educator.stats-earning') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        date: date,
                        type: type
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.status) {
                            if (type == 'year') {
                                $('tr#year-earning').html(data.html)
                            }

                            if (type == 'month') {
                                $('tr#month-earning').html(data.html)
                            }
                        } else {
                            $(resultModal).find('div.modal-body').html(data.html)
                            $(resultModal).modal('show')
                        }
                    },
                    error: function (data) {
                        $(resultModal).find('div.modal-body').html(data.html)
                        $(resultModal).modal('show')
                    }
                })

            })

            $('body').on('click', 'i.stat-ad-view', function () {
                var date = $(this).data('value')

                $.ajax({
                    type: 'GET',
                    url: '{{ route('educator.stats-advert-view') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        date: date,
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.status) {
                            $('tr#ads-view').html(data.html)
                        } else {
                            $(resultModal).find('div.modal-body').html(data.html)
                            $(resultModal).modal('show')
                        }
                    },
                    error: function (data) {
                        $(resultModal).find('div.modal-body').html(data.html)
                        $(resultModal).modal('show')
                    }
                })

            })

            $('body').on('click', 'i.stat-booking', function () {
                var date = $(this).data('value')

                $.ajax({
                    type: 'GET',
                    url: '{{ route('educator.stats-booking-count') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        date: date,
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.status) {
                            $('tr#booking-count').html(data.html)
                        } else {
                            $(resultModal).find('div.modal-body').html(data.html)
                            $(resultModal).modal('show')
                        }
                    },
                    error: function (data) {
                        $(resultModal).find('div.modal-body').html(data.html)
                        $(resultModal).modal('show')
                    }
                })

            })


            $('button.share-profile-btn').on('click', function () {
                $('div#share-profile-modal').modal('hide')
                $(resultModal).modal('show')
                var id = $(this).data('id')
                var route = $(this).data('share-route')

                $.ajax({
                    type: 'POST',
                    url: route,
                    data: {
                        _token: '{{ csrf_token() }}',
                        share_email: $('input[name="share_email"]').val(),
                        educator_id: id
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        if (data.status) {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        } else {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    },
                    error: function (data) {
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    }
                })
            })


            $('body').on('click', 'a.visit-class-btn', function (e) {
                var route = $(this).data('route')

                $.ajax({
                    type: 'GET',
                    url: route,
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: 'html',
                    success: function (data) {
                        $('div#visit-class-modal').find('div.modal-body').html(data)
                    },
                    error: function (data) {
                        $('div#visit-class-modal').find('div.modal-body').html(data)
                    }
                })
            })


            $('body').on('click', 'a.move-class-modal-btn', function (e) {
                var route = $(this).data('route')
                var bookingId = $(this).data('booking-id')
                var parentId = $(this).data('parent-id')

                $.ajax({
                    type: 'POST',
                    url: route,
                    data: {
                        booking_id: bookingId,
                        parent_id: parentId,
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: 'html',
                    success: function (data) {
                        $('div#move-class-modal').find('div.modal-body').html(data)
                    },
                    error: function (data) {
                        $('div#move-class-modal').find('div.modal-body').html(data)
                    }
                })
            })

            $('body').on('click', 'a.message-user-btn', function () {
                $('a.chat-send-btn').attr('data-lesson-id', $(this).data('lesson-id'))
                $('a.chat-send-btn').attr('data-recipient-id', $(this).data('recipient-id'))
            })

            $('body').on('click', 'a.chat-send-btn', function () {

                var _this = $(this)
                var message = $(sendMessageModal).find('textarea[name="chat-message"]').val()

                if (message.length > 0) {
                    $(resultModal).modal('show')

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('chat.send.message') }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            text: message,
                            lesson_id: $(_this).data('lesson-id'),
                            recipient_id: $(_this).data('recipient-id'),
                        },
                        dataType: 'json',
                        success: function (data) {
                            console.log(data)
                            if (data.status) {
                                $(sendMessageModal).find('textarea[name="chat-message"]').val('')
                                $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                            } else {
                                $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                            }
                        },
                        error: function (data) {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    })
                }
            })


            $('body').on('click', 'a.move-class-btn', function () {
                var form = $(this).parents('form#move-class-form')

                $.ajax({
                    type: 'POST',
                    url: $(form).attr('action'),
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        if (data.status) {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        } else {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    },
                    error: function (data) {
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    }
                })

                $(resultModal).modal('show')
            })


            $('body').on('click', 'a.pause-class-btn', function () {
                $.ajax({
                    type: 'POST',
                    url: pauseRoute,
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        if (data.status) {
                            document.location.reload()
                            $(`tr#lesson-${data.id} > td:eq(1)`).attr('class', 'paused').html('Paused')
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        } else {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    },
                    error: function (data) {
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    }
                })

                $(resultModal).modal('show')
            })

            $('body').on('click', 'a.live-class-btn', function () {

                $.ajax({
                    type: 'POST',
                    url: liveRoute,
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        if (data.status) {
                            document.location.reload()
                            $(`tr#lesson-${data.id} > td:eq(1)`).attr('class', 'live').html('Live')
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        } else {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    },
                    error: function (data) {
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    }
                })

                $(resultModal).modal('show')
            })

            $('body').on('click', 'a.cancel-class-btn', function () {

                $.ajax({
                    type: 'POST',
                    url: cancelRoute,
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        if (data.status) {
                            document.location.reload()
                            $(`tr#lesson-${data.id} > td:eq(1)`).attr('class', 'cancelled').html('Cancelled')
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        } else {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    },
                    error: function (data) {
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    }
                })

                $(resultModal).modal('show')
            })

            $('body').on('click', 'a.delete-class-btn', function () {

                $.ajax({
                    type: 'POST',
                    url: deleteRoute,
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        if (data.status) {
                            document.location.reload()

                            $(`tr#lesson-${data.id} > td:eq(1)`).attr('class', 'cancelled').html('Deleted')
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        } else {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    },
                    error: function (data) {
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    }
                })

                $(resultModal).modal('show')
            })


        })


        $('body').on('click', 'a.pause-set-route-btn', function () {
            pauseRoute = $(this).data('route')
        })

        $('body').on('click', 'a.live-set-route-btn', function () {
            liveRoute = $(this).data('route')
        })

        $('body').on('click', 'a.cancel-set-route-btn', function () {
            cancelRoute = $(this).data('route')
        })

        $('body').on('click', 'a.delete-set-route-btn', function () {
            deleteRoute = $(this).data('route')
        })

        $('body').on('click', '#visit-class-modal .table.data tbody td:first-child', function (e) {
            if ($(this).parent().hasClass('active')) {
                $(this).parent().removeClass('active');
            } else {
                $('#visitClass .table.data tbody tr').removeClass('active');
                $(this).parent().addClass('active');
            }
        });

        $(resultModal).on('hidden.bs.modal', function (e) {
            $(this).find('div.modal-body').html('<div class="spinner"></div>')
        })

    </script>
@endsection
