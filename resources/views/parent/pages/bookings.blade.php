@extends('parent.layouts.master')


@section('title')
    Classhub | My Bookings
@endsection


@section('page_style')

@endsection

@section('content')

    <!-- starts : main container -->
    <div class="main-container display-table footer-stay-btm" style="padding-top: 30px"> {{----}}

    <!-- starts: bookings sections -->
        <div class="container booking-sections">
            <div class="row">
                @if( count($currentBookings) == 0 && count($pastBookings) == 0 )
                    <div class="col-md-12 text-center p-t-60 p-b-60 emptyState">
                        <i class="fa fa-inbox p-b-20"></i>
                        <h4>You have no bookings. Return here after you make a booking to view it.</h4>
                    </div>
                @else
                    <div class="col-md-6">
                        <div class="current-bookings">
                            <div class="heading uppercase">CURRENT BOOKINGS & PURCHASED VIDEOS</div>
                            <!-- accordion starts -->
                            <ul class="accordion accordion-1 ">
                                @foreach($currentBookings as $booking)
                                    <li class="list">
                                        <div class="title">
                                            <div class="profile-image-booked" style="background-image: url({{
                                    \App\Helpers\ClassHubHelper::getImagePath(null, optional($booking->lesson->user->educator)->photo)
                                    }});">
                                            </div>
                                            <div class="titles">
                                                <div class="name">{{ optional($booking)->lesson->user->name }}</div>
                                                <div class="class">{{ optional($booking)->lesson->name }}</div>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <div class="list-content">
                                                <table class="table">
                                                    <tbody>
                                                    <tr>
                                                        <td>Booking Code:</td>
                                                        <td>{{ \App\Helpers\ClassHubHelper::getbookingCode($booking) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Student Name</td>
                                                        <td>{{ $booking->student_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Class Name</td>
                                                        <td>
                                                            @if($booking->lesson->type === 'pre_recorded')
                                                                <a style="font-weight: bold"
                                                                   href="{{ route('page.pre-recorded.lesson', $booking->lesson->slug) }}">View
                                                                    Video class of </a>
                                                                "{{ optional($booking)->lesson->name }}"
                                                            @else
                                                                {{ optional($booking)->lesson->name }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @if(optional($booking)->lesson->type !== 'subject' && optional($booking)->lesson->type !== 'pre_recorded' )
                                                        <tr>
                                                            <td>Location</td>
                                                            <td>{{ optional($booking)->lesson->location }}</td>
                                                        </tr>
                                                    @endif
                                                    {{--<tr>
                                                        <td>Date</td>
                                                        <td>12 - 12 - 2018</td>
                                                    </tr>--}}
                                                    <tr>
                                                        <td>Dates & times</td>
                                                        <td>
                                                            <dl>
                                                                {{--<dt>Mo 01 April 2019 - Tue 23 April 2019</dt>--}}

                                                                @if($booking->lesson->type === 'pre_recorded')
                                                                    <dd>{{ $booking->lesson->classes->count() }}
                                                                        Pre-recorded class(es)
                                                                    </dd>
                                                                @else
                                                                    @foreach($booking->classes as $index => $bookingClass)
                                                                        @if(($bookingClass->class) && !$bookingClass->class->is_past_class &&
                                                                            $bookingClass->status !== 'cancelled')
                                                                            <dd>
                                                                                Class {{ $index+1 }}:
                                                                                {{ $bookingClass->class->day }}
                                                                                {{ \Carbon\Carbon::parse($bookingClass->class->date)->format('d M Y') }}
                                                                                (
                                                                                {{ \Carbon\Carbon::parse($bookingClass->class->start_time)->format('H:i')}}
                                                                                -
                                                                                {{ \Carbon\Carbon::parse($bookingClass->class->end_time)->format('H:i') }}
                                                                                )
                                                                            </dd>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </dl>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Price</td>
                                                        <td>
                                                            € {{ number_format(\App\Helpers\ClassHubHelper::centToEuro($booking->amount), 2) }}</td>
                                                    </tr>

                                                    <tr class="show-above-639">
                                                        <td>Actions</td>
                                                        <td class="links">
                                                            <a href="javascript:;" class="send-message-btn"
                                                               data-lesson-id="{{ $booking->lesson_id }}"
                                                               data-recipient-id="{{ $booking->lesson->user_id }}"
                                                               data-toggle="modal"
                                                               data-target="#send-message-modal">Message</a>
                                                            @if($booking->status !== 'cancelled')
                                                                <a href="javascript:void(0)" class="get-receipt-btn"
                                                                   data-route="{{ route('parent.get.receipt',$booking->id) }}">Get
                                                                    Receipt</a>
                                                                @if($booking->lesson->type !== 'pre_recorded')
                                                                    <a href="javascript:void(0)" data-toggle="modal"
                                                                       data-target="#cancel-booking"
                                                                       class="set-booking-route"
                                                                       data-route="{{ route('parent.cancel.booking',[$booking->lesson_id, $booking->id]) }}">
                                                                        Cancel Class</a>
                                                                @endif
                                                            @endif
                                                            @if($booking->lesson->type === 'pre_recorded')
                                                                <a href="{{ route('page.pre-recorded.lesson', $booking->lesson->slug) }}">View
                                                                    Video Classes</a>
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    <tr class="show-below-640">
                                                        <td colspan="2" class="links">
                                                            <div class="p-b-6">Actions</div>
                                                            <a href="javascript:;" class="send-message-btn"
                                                               data-lesson-id="{{ $booking->lesson_id }}"
                                                               data-recipient-id="{{ $booking->lesson->user_id }}"
                                                               data-toggle="modal"
                                                               data-target="#send-message-modal">Message</a>
                                                            @if($booking->status !== 'cancelled')
                                                                <a href="javascript:void(0)" class="get-receipt-btn"
                                                                   data-route="{{ route('parent.get.receipt',$booking->id) }}">Get
                                                                    Receipt</a>

                                                                @if($booking->lesson->type !== 'pre_recorded')
                                                                    <a href="javascript:void(0)" data-toggle="modal"
                                                                       data-target="#cancel-booking"
                                                                       class="set-booking-route"
                                                                       data-route="{{ route('parent.cancel.booking',[$booking->lesson_id, $booking->id]) }}">
                                                                        Cancel Class</a>
                                                                @endif
                                                            @endif
                                                            @if($booking->lesson->type === 'pre_recorded')
                                                                <a href="{{ route('page.pre-recorded.lesson', $booking->lesson->slug) }}">View
                                                                    Video Classes</a>
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <!-- accordion end -->
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="past-bookings">
                            <div class="heading uppercase">PAST BOOKINGS</div>
                            <!-- accordion starts -->
                            <ul class="accordion accordion-1 ">
                                @foreach($pastBookings as $booking)
                                    <li class="list">
                                        <div class="title">
                                            <div class="profile-image-booked" style="background-image: url({{
                                      \App\Helpers\ClassHubHelper::getImagePath(null, optional($booking->lesson->user->educator)->photo)
                                      }});">
                                            </div>
                                            <div class="titles">
                                                <div class="name">{{ optional($booking)->lesson->user->name }}</div>
                                                <div class="class">{{ optional($booking)->lesson->name }}</div>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <div class="list-content">
                                                <table class="table">
                                                    <tbody>
                                                    <tr>
                                                        <td>Booking Code:</td>
                                                        <td>{{ \App\Helpers\ClassHubHelper::getbookingCode($booking) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Student Name</td>
                                                        <td>{{ $booking->student_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Class Name</td>
                                                        <td>{{ optional($booking)->lesson->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Location</td>
                                                        <td>{{ optional($booking)->lesson->location }}</td>
                                                    </tr>
                                                    {{--<tr>
                                                        <td>Date</td>
                                                        <td>12 - 12 - 2018</td>
                                                    </tr>--}}
                                                    <tr>
                                                        <td>Dates & times</td>
                                                        <td>
                                                            <dl>

                                                                @if($booking->lesson->type === 'pre_recorded')
                                                                    <dd>{{ $booking->lesson->classes->count() }}
                                                                        Pre-recorded class(es)
                                                                    </dd>
                                                                @else
                                                                    @foreach($booking->classes as $index => $bookingClass)
                                                                        @if($bookingClass->class && $bookingClass->is_past_booking)

                                                                            <dd>
                                                                                Class {{ $index+1 }}:
                                                                                {{ $bookingClass->class->day }}
                                                                                {{ \Carbon\Carbon::parse($bookingClass->class->date)->format('d M Y') }}
                                                                                (
                                                                                {{ \Carbon\Carbon::parse($bookingClass->class->start_time)->format('H:i')}}
                                                                                -
                                                                                {{ \Carbon\Carbon::parse($bookingClass->class->end_time)->format('H:i') }}
                                                                                )
                                                                            </dd>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </dl>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Price</td>
                                                        <td>
                                                            € {{ number_format(\App\Helpers\ClassHubHelper::centToEuro($booking->amount), 2) }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                                <!-- starts : past booking, btm actions variation 02 -->
                                                <table class="table">
                                                    <tbody>
                                                    <tr>
                                                        <td>Actions</td>
                                                        <td class="links">
                                                            @if($booking->status !== 'cancelled')
                                                                <a href="javascript:void(0)" data-toggle="modal"
                                                                   data-target="#rate-me-modal" class="rating-btn"
                                                                   data-lesson-id="{{ $booking->lesson_id }}"
                                                                   data-route="{{ route('parent.lesson.rating',$booking->lesson_id) }}"
                                                                >Rate Me</a>
                                                                <a href="javascript:void(0)" class="get-receipt-btn"
                                                                   data-route="{{ route('parent.get.receipt',$booking->id) }}">Get
                                                                    Receipt</a>
                                                                @if($booking->lesson->type !== 'pre_recorded')
                                                                    <a href="{{ route('parent.refund.request', $booking->id) }}">Request
                                                                        Refund</a>
                                                                @endif
                                                            @endif

                                                            @if(optional($booking->lesson->user)->is_online)
                                                                <a href="javascript:;" class="send-message-btn"
                                                                   data-lesson-id="{{ $booking->lesson_id }}"
                                                                   data-recipient-id="{{ $booking->lesson->user_id }}"
                                                                   data-toggle="modal"
                                                                   data-target="#send-message-modal">Message</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <!-- end : past booking, btm actions variation 02 -->
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <!-- accordion end -->
                        </div>

                    </div>
                @endif
            </div>
        </div>
        <!-- end: bookings sections -->

        <!-- starts: See my favourites -->
        <div class="container">
            <div class="p-t-34 text-right">
                <a class="link-01" href="{{ route('parent.favourites') }}">See my favourites</a>
            </div>
        </div>
        <!-- end: See my favourites -->

    </div>
    <!-- end : main container -->


    @include('common.send-message-modal')

    @include('parent.modals.rate-me')

    @include('parent.modals.get-receipt')

    @include('parent.modals.cancel-booking')

@endsection

@section('page_scripts')

    <script type="text/javascript">

        var cancelBookingRoute = ''

        var sendMessageModal = $('div#send-message-modal')

        $(function () {

            $('a.send-message-btn').on('click', function () {
                var lessonId = $(this).data('lesson-id')
                var recipientId = $(this).data('recipient-id')
                $('a.chat-send-btn').attr('data-lesson-id', lessonId)
                $('a.chat-send-btn').attr('data-recipient-id', recipientId)
            })

            $('a.set-booking-route').on('click', function () {
                cancelBookingRoute = $(this).data('route')
            })

            $(sendMessageModal).on('hidden.bs.modal', function (e) {
                console.log('hidden')
                $(this).find('a.chat-send-btn').attr('data-lesson-id', '')
                $(this).find('a.chat-send-btn').attr('data-recipient-id', '')
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


            $('body').on('click', 'a.rating-btn', function () {
                var route = $(this).data('route')

                $.ajax({
                    type: 'GET',
                    url: route,
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: 'html',
                    success: function (data) {
                        $('div#rate-me-modal').find('div.modal-body').html(data)
                    },
                    error: function (data) {
                        $('div#rate-me-modal').find('div.modal-body').html(data)
                    }
                })
            })

            $('body').on('submit', 'form#rate-me-form', function (e) {

                $('div#rate-me-modal').modal('hide')
                $(resultModal).modal('show')

                e.preventDefault()

                var route = $(this).attr('action')

                $.ajax({
                    type: 'POST',
                    url: route,
                    data: $(this).serialize(),
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


            $('body').on('click', 'a.get-receipt-btn', function () {
                var route = $(this).data('route')

                $.ajax({
                    type: 'POST',
                    url: route,
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        if (data.status) {
                            $('span#receipt-email').html('{{ Auth::user()->email }}')
                            $('div#get-receipt').modal('show')
                        } else {
                            $(resultModal).modal('show')
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    },
                    error: function (data) {
                        $(resultModal).modal('show')
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    }
                })
            })

            $('body').on('click', 'a.cancel-booking-btn', function () {
                $(resultModal).modal('show')
                $.ajax({
                    type: 'POST',
                    url: cancelBookingRoute,
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)

                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))

                        setTimeout(function () {
                            location.reload()
                        }, 5000)
                    },
                    error: function (data) {
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    }
                })
            })


            $('div#result-modal').on('hidden.bs.modal', function () {
                $(resultModal).find('div.modal-body').html('<div class="spinner"></div>')
            })

        })
    </script>

@endsection
