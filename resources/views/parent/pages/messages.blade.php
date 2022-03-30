@extends('parent.layouts.master')

@section('title')
    Classhub | Messages
@endsection

@section('page_styles')
    <link href="{{ asset('css/flatpickr.css') }}" rel="stylesheet" type="text/css" media="all"/>

    <style type="text/css">
        div.provider-receives-refund-request .m-messenger__message-text {
            color: #fff !important;
        }
    </style>
@endsection

@section('content')

    <!-- starts : main container -->
    <div class="main-container inbox">

        <!-- starts: inbox-chat sections -->
        <div class="container inbox-chat">

            <!-- starts : top bar -->
            <div class="topbar row nav">
                <div class="col-xs-5">
                    <div class="title">INBOX</div>
                </div>
                <div class="col-xs-7 text-right">
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
                    @include('parent.includes.chat-list', ['activeChatId' => $activeChat->id])
                </div>
                <div class="col-md-6 col-chat show">
                    @include('parent.includes.chat-message-list')
                </div>
            </div>
            <!-- end : columns -->

        </div>
        <!-- end: inbox-chat sections -->

    </div>
    <!-- end : main container -->

@endsection

@section('page_scripts')
    <script type="text/javascript" src="{{ asset('parent/js/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('parent/js/script.js') }}"></script>
    <script type="text/javascript" src="{{ asset('parent/js/custom.js') }}"></script>
    <script src="{{ asset('js/flatpickr.js') }}"></script>

    @include('common.send-message-script')

    <script type="text/javascript">
        $(function(){
            $('div.provider-receives-refund-request').parents('div.m-messenger__message--out')
                .addClass('provider-receives-refund-request')
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
