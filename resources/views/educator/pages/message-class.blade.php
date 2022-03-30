@extends('educator.layouts.master')

@section('title')
    Classhub | Message Class
@endsection


@section('page_style')


@endsection

@section('content')

    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop
     m-body p-b-34 message-entire-class">
        <div class="m-grid__item m-grid__item--fluid m-wrapper m-b-6">

            <div class="row col-12">

                <div class="col-lg-6  col-md-6 col-sm-12 col-xs-12" style="margin: 0 auto;">

                    <div class="m-content">

                        <!-- starts : top section -->
                        <div class="top-section">
                            <div class="title fs-30 fw-5 p-l-0">Message Class</div>
                            <div class="sub-title fw-5 p-t-5">{{ $lesson->name }}</div>
                            <div class="p-t-20">Use the box below to send your message</div>
                        </div>
                        <!-- end : top section -->

                        <!-- starts: Payment Terms -->
                        <div class="refund-form list-a-class p-t-24">
                            <form class="m-form m-form--label-align-left- m-form--state-" id="m_form">
                                <div class="m-portlet m-0 m-portlet--full-height payment-terms ">
                                    <!--begin: Form Wizard-->
                                    <div class="m-wizard__form">
                                        <!--
                                            1) Use m-form--label-align-left class to alight the form input lables to the right
                                            2) Use m-form--state class to highlight input control borders on form validation
                                            -->
                                        <!--begin: Form Body -->
                                        <div class="m-portlet__body">

                                            <!-- starts : Choose class(es) -->
                                            <div class="form-group m-form__group">
                                                <!--begin: to list-->
                                                <div class="to-list">

                                                    <div class="fw-5">To:</div>

                                                @foreach($bookings as $booking)
                                                    <!-- starts : email 01 -->
                                                        <div
                                                            class="alert alert-info m-alert--outline alert-dismissible fade show"
                                                            role="alert">
                                                            <button type="button" class="close" data-dismiss="alert"
                                                                    aria-label="Close"></button>
                                                            <input type="hidden" class="recipient" name="recipients[]"
                                                                   value="{{ $booking->user_id }}">
                                                            {{ $booking->user->name }}
                                                        </div>
                                                @endforeach
                                                <!-- end : email 01 -->
                                                </div>
                                                <!--end: to list-->
                                            </div>
                                            <!-- end : Choose class(es) -->

                                            <!-- starts : Extra information -->
                                            <div class="form-group m-form__group p-t-12">
                                                <textarea rows="6" class="form-control m-input"
                                                          name="chat-message"></textarea>
                                                <span class="m-form__help fs-13">Max 500 characters</span>
                                            </div>
                                            <!-- end : Extra information -->

                                            <!-- starts : Send request button -->
                                            <div class="text-right">

                                                <a class="btn btn-primary v1 shadow-v4 chat-send-btn"
                                                   href="javascript:void(0);" data-lesson-id="{{ $lesson->id }}"><span
                                                        class="btn__text">Send</span></a>
                                            </div>
                                            <!-- end : Send request button -->

                                            <div id="chat-results" class="text-left"></div>

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
        </div>
    </div>

@endsection

@section('page_scripts')

    <script type="text/javascript">

        $(function () {

            $('body').on('click', 'a.chat-send-btn', function () {

                var message = $('textarea[name="chat-message"]').val()
                var lessonId = $(this).data('lesson-id')
                $(resultModal).find('div.modal-body').html('')
                $(resultModal).modal('show')

                if (message.length > 0 && $('input.recipient').length != 0) {
                    $('input.recipient').each(function () {
                        var _this = $(this)

                        $.ajax({
                            type: 'POST',
                            url: '{{ route('chat.send.message') }}',
                            data: {
                                _token: '{{ csrf_token() }}',
                                text: message,
                                lesson_id: lessonId,
                                recipient_id: $(_this).val(),
                                type: 'class'
                            },
                            dataType: 'json',
                            success: function (data) {
                                console.log(data)
                                if (data.status) {
                                    $('textarea[name=chat-message]').val('')
                                    $(resultModal).find('div.modal-body').append(`<p>${data.messages.join('<br>')}</p>`)
                                } else {
                                    $(resultModal).find('div.modal-body').append(`<p>${data.messages.join('<br>')}</p>`)
                                }
                            },
                            error: function (data) {
                                $(resultModal).find('div.modal-body').append(`<p>${data.messages.join('<br>')}</p>`)
                            }
                        })

                    })
                } else {
                    $(resultModal).find('div.modal-body').append(`<p>Select Student and enter Message</p>`)
                }
            })


        })

    </script>
@endsection
