@extends('parent.layouts.master')


@section('title')
    Classhub | Refund Request
@endsection


@section('page_style')

@endsection

@section('content')

    <!-- starts : main container -->
    <div class="main-container">

        <!-- starts: request refund  -->
        <div class="container p-t-32 request-refund">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">

                    <!-- starts : top section -->
                    <div class="top-section">
                        <div class="title fs-30 fw-5 p-l-0">Refund request</div>
                        <div class="sub-title fw-5 p-t-5">
                            {{ $booking->lesson->name }}
                            (Booking Code: {{ \App\Helpers\ClassHubHelper::getbookingCode($booking) }})
                        </div>
                        <div class="p-t-20">Use the box below to let the teacher know the classes you are requesting a
                            refund for and for what reason
                        </div>
                    </div>
                    <!-- end : top section -->

                    <!-- starts: Payment Terms -->
                    <div class="refund-form list-a-class p-t-24">
                        <form class="m-form m-form--label-align-left- m-form--state-"
                              action="{{ route('parent.post.refund.request') }}" id="m_form" method="post">
                            {!! csrf_field() !!}
                            {!! Form::hidden('booking_id', $booking->id) !!}
                            <div class="m-portlet m-0 m-portlet--full-height payment-terms ">
                                <!--begin: Form Wizard-->
                                <div class="m-wizard__form">
                                    <!--
                                        1) Use m-form--label-align-left class to alight the form input lables to the right
                                        2) Use m-form--state class to highlight input control borders on form validation
                                        -->
                                    <!--begin: Form Body -->
                                    <div class="m-portlet__body p-t-50">

                                        <!-- starts : Choose class(es) -->
                                        <div class="form-group m-form__group">
                                            <!--begin: Dropdown-->
                                            <div class="m-dropdown m-dropdown--arrow c-dd-menu "
                                                 m-dropdown-toggle="click">
                                                <a href="javascript:void(0)" id="selected-classes"
                                                   class="m-dropdown__toggle btn dropdown-toggle">Choose class(es)</a>
                                                <div class="m-dropdown__wrapper">
                                                    <div class="m-dropdown__inner">
                                                        <div class="m-dropdown__body">
                                                            <div class="m-dropdown__content">
                                                                <div class="m-portlet__body">
                                                                    <div class="list-options refund-select">
                                                                        <ul>
                                                                            @foreach($booking->classes as $index => $bookingClass)
                                                                                @if($bookingClass->class->is_refundable &&
                                                                                               $bookingClass->is_refundable)
                                                                                    <li style="padding-bottom: 10px">
                                                                                        <input class="class-name-select"
                                                                                               type="checkbox"
                                                                                               name="classes[]"
                                                                                               value="{{ $bookingClass->lesson_class_id }}"
                                                                                               data-class-name="Class {{ $index+1 }}"
                                                                                        >
                                                                                        Class {{ $index+1 }}:
                                                                                        {{ $bookingClass->class->day }}
                                                                                        {{ \Carbon\Carbon::parse($bookingClass->class->date)->format('d M Y') }}
                                                                                        (
                                                                                        {{ \Carbon\Carbon::parse($bookingClass->class->start_time)->format('H:i')}}
                                                                                        -
                                                                                        {{ \Carbon\Carbon::parse($bookingClass->class->end_time)->format('H:i') }}
                                                                                        )
                                                                                    </li>
                                                                                @endif
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end: Dropdown-->
                                        </div>
                                        <!-- end : Choose class(es) -->

                                        <!-- starts : Extra information -->
                                        <div class="form-group m-form__group p-t-12">
                                            <textarea rows="6" class="form-control m-input" name="message"
                                                      required></textarea>
                                            <span class="m-form__help fs-13">Max 500 characters</span>
                                        </div>
                                        <!-- end : Extra information -->

                                        <!-- starts : Send request button -->
                                        <div class="text-right">
                                            <button class="btn btn-primary shadow-v4 refund-request-btn"
                                                    type="submit"><span
                                                    class="btn__text">Send request</span></button>
                                        </div>
                                        <!-- end : Send request button -->

                                    </div>
                                    <!--end: Form Body-->
                                </div>
                                <!--end: Form Wizard-->
                            </div>
                        </form>
                    </div>
                    <!-- end: Payment Terms -->

                </div>
            </div>
        </div>
        <!-- end: bookings sections -->

        @include('common.need-help')


    </div>
    <!-- end : main container -->

    @include('common.send-message-modal')

@endsection

@section('page_scripts')

    <script type="text/javascript">
        // Prevent dropdown from hiding on click event
        $('div.refund-select').on('click', function (e) {
            e.stopPropagation()
        })

        var selectedClasses = []

        $(function () {
            $('button.refund-request-btn').on('click', function (e) {
                $(resultModal).modal('show')
                var form = $(this).parents('form')
                console.log($(form).serialize())
                e.preventDefault()

                $.ajax({
                    type: 'POST',
                    url: $(form).attr('action'),
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        if (data.status) {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))

                            setTimeout(function () {
                                window.location = data.redirect_url
                            }, 3000)
                        } else {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    },
                    error: function (data) {
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    }
                })
                return false
            })

            $('input.class-name-select').on('click', function () {
                className = $(this).data('class-name');
                if ($(this).is(':checked') && selectedClasses.indexOf(className) === -1) {
                    selectedClasses.push(className)
                } else {
                    selectedClasses = selectedClasses.filter(item => {
                        return item !== className
                    })
                }
                console.log(selectedClasses)
                $('a#selected-classes').html(selectedClasses.join(', '))
            })
        })

    </script>
@endsection
