@extends('educator.layouts.master')

@section('title')
    Classhub | Messages
@endsection

@section('page_styles')
    <link href="{{ asset('css/flatpickr.css') }}" rel="stylesheet" type="text/css" media="all"/>

    <style type="text/css">
        div.provider-receives-refund-request .refund-msg-box {
            color: #fff !important;
        }
    </style>
@endsection

@section('content')

    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body list-a-class">

        <div class="m-grid__item m-grid__item--fluid m-wrapper">

            <!-- starts : main container -->
            <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 supplier-inbox inbox" style="margin: 0 auto;">

                <!-- starts: inbox-chat sections -->
                <div class="m-content inbox-chat">

                    <!-- starts : top bar -->
                    <div class="topbar row nav">
                        <div class="col-4 col-md-5">
                            <div class="title">INBOX</div>
                        </div>
                        <div class="col-8 col-md-7 text-right">
                            <a href="javascript:toggleInbox('all');" class="link-all active">All</a>
                            <a href="javascript:toggleInbox('unread');" class="link-unread">Unread
                                @if($inboxUnreadCount)<span class="badge unread-counter">{{ $inboxUnreadCount }}</span>@endif
                            </a>
                        </div>
                    </div>

                    <div class="topbar row col-chat-mobile-nav">
                        <div class="col-xs-12">
                            {{--<a href="javascript:bankToMobileInboxList();" class="back-to-mobile-inbox-list">
                                <span class="badge"><i class="la la-angle-left"></i></span>
                                <strong class="fw-6">Jessica White</strong> - John's Art Class
                            </a>--}}
                        </div>
                    </div>
                    <!-- end : top bar -->

                    <!-- starts : columns -->
                    <div class="row">
                        <div class="col-md-6 col-inbox">
                            @include('educator.includes.chat-list', ['activeChatId' => $activeChat->id])
                        </div>
                        <div class="col-md-6 col-chat show">
                            @include('educator.includes.chat-message-list')
                        </div>
                    </div>
                    <!-- end : columns -->

                </div>
                <!-- end: inbox-chat sections -->

            </div>
            <!-- end : main container -->
        </div>
    </div>


    @include('educator.modals.confirm-refund-accept')
    @include('educator.modals.confirm-refund-reject')

@endsection

@section('page_scripts')
    <script type="text/javascript" src="{{ asset('parent/js/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('parent/js/script.js') }}"></script>
    <script type="text/javascript" src="{{ asset('parent/js/custom.js') }}"></script>
    <script src="{{ asset('js/flatpickr.js') }}"></script>

    @include('common.send-message-script')
@include('educator.modals.subject-booking')
    <script type="text/javascript">
        var messageId = ''
        var bookingId = ''
        var classIds = ''

        $(function () {

            $('body').on('click', 'a.accept-refund-btn', function () {
                $.ajax({
                    type: 'POST',
                    url: '{{  route('educator.accept.refund')}}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        message_id: messageId,
                        booking_id: bookingId,
                        class_ids: classIds
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        if (data.status) {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                            setTimeout(function () {
                                location.reload(true)
                            }, 3000)
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


            $('body').on('click', 'a.reject-refund-btn', function () {
                var reason = $('textarea[name="reject-reason"]').val()

                if (reason.length == 0) {
                    $(resultModal).find('div.modal-body').html('Please enter reject reason')
                } else {
                    $.ajax({
                        type: 'POST',
                        url: '{{  route('educator.reject.refund')}}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            message_id: messageId,
                            booking_id: bookingId,
                            class_ids: classIds,
                            reason: reason
                        },
                        dataType: 'json',
                        success: function (data) {
                            console.log(data)
                            if (data.status) {
                                $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                                setTimeout(function () {
                                    location.reload(true)
                                }, 3000)
                            } else {
                                $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                            }
                        },
                        error: function (data) {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    })

                }


                $(resultModal).modal('show')
            })

        })

        $('body').on('click', 'a.refund-request-accept , a.refund-request-reject', function () {
            messageId = $(this).data('message-id')
            bookingId = $(this).data('booking-id')
            classIds = $(this).data('classes-id')
        })

        $('div#result-modal').on('hidden.bs.modal', function () {
            $(resultModal).find('div.modal-body').html('<div class="spinner"></div>')
        })

        function toggleInbox(arg) {
            $('div.col-inbox').removeClass('col-md-6').addClass('col-md-12')

            if (arg == "all") {
                $('.inbox-chat').removeClass('show-inbox-unread-only');
                $('.fav-select').addClass('show-inbox-column-only');
                $('.link-unread').removeClass('active');
                $('.link-all').addClass('active');
                $('.list-inbox div').removeClass('active')
            }
            if (arg == "unread") {
                $('.inbox-chat').addClass('show-inbox-unread-only');
                $('.fav-select').removeClass('show-inbox-column-only');
                $('.link-unread').addClass('active');
                $('.link-all').removeClass('active');
                $('.inbox-chat .col-chat').removeClass('show')
            }
        }

    </script>
@endsection
