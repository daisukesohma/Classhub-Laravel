<div class="modal fade c-modal v1 cancel-class move-class" id="subject-booking-modal" tabindex="-1" role="dialog"
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

                <div class="title fs-23 fw-5 p-l-0 text-center">Create a booking</div>
                <label class="col-form-label p-t-10 text-center">Choose a date and time from the calendar below</label>
                {!! Form::open(['url' => route('educator.move.class'), 'id' => 'subject-booking-form', 'novalidate' => 'novalidate']) !!}

                {!! Form::hidden('class_type', 'subject') !!}
                {!! Form::hidden('recipient_id', null, ['id' => 'recipient-id']) !!}

                <div class="form-group m-form__group" style="margin-top: 20px">
                    <select name="category_id" class="form-control" required>
                        @foreach(Auth::user()->categories as $category)
                            @if(\App\Helpers\ClassHubHelper::getSubjectDisplayName($category, Auth::user()->categories)
                            && $category->parent_id)
                                <option value="{{ $category->id }}">
                                    {{\App\Helpers\ClassHubHelper::getSubjectDisplayName($category, Auth::user()->categories) }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <!-- starts : Class Time -->
                <div
                    class="form-group m-form__group two-selectboxes class-time"
                    id="m_repeater_1">
                    <div id="single-class-repeater"
                         class="class-repeater-container">

                        <div
                            data-repeater-list="lesson_dates[subject]"
                            class="data-repeater-list">
                            <!-- starts : repeat dom -->

                            <div class="row class-repeater-item"
                                 data-repeater-item>
                                <div class="col-lg-6">
                                    <label
                                        class="col-form-label">
                                                                                        <span
                                                                                            class="text-primary">*</span>Class
                                        Start Time
                                    </label>
                                    <input
                                        type="{{ $mobile ? 'datetime-local' : 'text'  }}"
                                        class="form-control datetime-picker start-time-picker"
                                        name="[start]" style="box-shadow: none">
                                </div>
                                <div
                                    class="col-lg-6 two end-date-container">
                                    <label
                                        class="col-form-label">
                                                                                            <span
                                                                                                class="text-primary">*</span>Class
                                        End Time
                                    </label>
                                    <input
                                        type="{{ $mobile ? 'datetime-local' : 'text'  }}"
                                        class="form-control datetime-picker end-time-picker"
                                        name="[end]" style="box-shadow: none">
                                </div>
                            </div>
                        </div>
                        <!-- end : repeat dom -->
                        <!-- starts : repeat buttons -->
                        <div class="row p-t-20">
                            <div data-repeater-delete
                                 class="col-4 col-sm-12 col-md-4 mobile-no-padding">
                                <button type="button"
                                        class="btn-sm btn btn-primary m-btn m-btn--icon data-repeater-delete subject-booking-repeater">
                                    <span>                                      <i class="la la-trash-o"></i> <span> Delete</span>                                     </span>
                                </button>
                            </div>
                            <div data-repeater-create
                                 class="col-8 text-right col-sm-12 col-md-8 mobile-no-padding">
                                <button id="addClassDate"
                                        type="button"
                                        class="btn-sm btn btn-primary m-btn m-btn--icon add-btn subject-booking-repeater">
                                    <span><i class="la la-plus"></i><span>Add another class</span></span>
                                </button>
                            </div>
                        </div>
                        <!-- end : repeat buttons -->

                    </div>
                </div>

                <div class="form-group m-form__group">
                    <div class="input-group m-input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="border:1px solid #88929A">€</span>
                        </div>
                        <input type="number" step="0.01" placeholder="E.g. 50" name="base_price"
                               required value="{{ optional(Auth::user()->educator)->base_price }}"
                               class="form-control m-input">
                    </div>
                </div>
                <div class="form-group m-form__group">
                    <p>Please note, all ClassHub lessons are conducted using a ClassHub Zoom account.</p>
                    <img src="/img/logo/powered-by-zoom.png" alt="powered by zoom" height="20px" />
                </div>

                <div class="form-group m-form__group">
                    {!! Form::textarea('message', null, ['class' => 'form-control m-input', 'rows' => 2,
                     'placeholder' => 'Add a message']) !!}
                </div>


                <div class="form-group m-form__group">
                    {!! Form::submit('Send', ['class' => 'btn btn-primary btn-text-red shadow-v4 booking-modal', 'rows' => 3,
                     'id' => 'submit-booking']) !!}
                </div>


            </div>
        </div>
    </div>
</div>

<!-- end : Class Time -->

{!! Form::close() !!}

@include('common.booking-sent')

<link href="{{ asset('css/flatpickr.css') }}" rel="stylesheet" type="text/css" media="all"/>
<script src="{{ asset('js/flatpickr.js') }}"></script>

<script type="text/javascript">
    var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
    var bookingSent = $('div#booking-sent-modal')

    $(function () {
        $('div#single-class-repeater').repeater({
            initEmpty: false,
            show: function () {
                $(this).slideDown()

                $(this).find('input.start-time-picker').flatpickr({
                    static: true,
                    enableTime: true,
                    dateFormat: "d-m-Y H:i",
                    time_24hr: true,
                    minDate: "{!! date('d-m-Y H:i') !!}",
                })

                $(this).find('input.end-time-picker').flatpickr({
                    static: true,
                    enableTime: true,
                    dateFormat: "d-m-Y H:i",
                    time_24hr: true,
                    minDate: "{!! date('d-m-Y H:i') !!}",
                })
            },
            hide: function (deleteElement) {
                // Not working
                $(this).slideUp(deleteElement);
            },
            isFirstItemUndeletable: true
        })

        $('.data-repeater-delete').on('click', function () {
            console.log('delete')
            const parent = $(this).parents('div.class-repeater-container');
            if ($(parent).find('div.data-repeater-list > div').length !== 1)
                $(parent).find('div.data-repeater-list > div:last').remove()
        })


        if (iOS) {
            $('input#submit-booking').on('click', function (e) {
                e.preventDefault()
                $('div#subject-booking-modal').modal('hide')
                $(resultModal).modal('show')

                var formData = $('form#subject-booking-form').serializeArray()

                $.ajax({
                    type: 'POST',
                    url: '{{ route('educator.subject.lesson') }}',
                    data: formData,
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.status) {
                            $(resultModal).modal('hide')
                            $(bookingSent).modal('show')
                        } else {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                            $(resultModal).modal('show')
                        }

                    },
                    error: function (data) {
                        console.log(data)
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        $(resultModal).modal('show')
                    }
                });

                return false
            });
        } else {
            $('form#subject-booking-form').on('submit', function (e) {
                e.preventDefault()
                $('div#subject-booking-modal').modal('hide')
                $(resultModal).modal('show')

                $.ajax({
                    type: 'POST',
                    url: '{{ route('educator.subject.lesson') }}',
                    data: $(this).serialize(),
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.status) {
                          setTimeout(() => {
                              $(resultModal).modal('hide')
                              $(bookingSent).modal('show')
                          }, 400)
                        } else {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                            $(resultModal).modal('show')
                        }

                    },
                    error: function (data) {
                        console.log(data)
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        $(resultModal).modal('show')
                    }
                });

                return false
            });
        }

        $(bookingSent).on('hidden.bs.modal', function () {
            window.location.reload()
        })

        @if(!$mobile)

        var minScheduleDate = new Date();
        minScheduleDate.setMinutes(minScheduleDate.getMinutes() + 5);

        var defaultEndSchduleDate = new Date(minScheduleDate);
        defaultEndSchduleDate.setMinutes(defaultEndSchduleDate.getMinutes() + 60);

        $('input.start-time-picker').flatpickr({
            static: true,
            enableTime: true,
            dateFormat: "d-m-Y H:i",
            time_24hr: true,
            minDate: minScheduleDate,
            defaultDate: minScheduleDate
        })

        $('input.end-time-picker').flatpickr({
            static: true,
            enableTime: true,
            dateFormat: "d-m-Y H:i",
            time_24hr: true,
            minDate: minScheduleDate,
            defaultDate: defaultEndSchduleDate
        })

        /*$('body').on('change', 'input.start-time-picker', function () {
            var parentDiv = $(this).parents('.class-repeater-item')[0]
            var startDate = $(this).val();
            var endDate = moment(startDate, 'DD-MM-YYYY HH:mm')
            endDate.add(60, 'minutes')

            var endDateInput = $(parentDiv).find('input.end-time-picker')

            $(endDateInput).val()
            $(endDateInput).flatpickr({
                static: true,
                enableTime: true,
                dateFormat: "d-m-Y H:i",
                time_24hr: true,
                minDate: endDate.toDate(),
                defaultDate: endDate.toDate()
            })
        })*/

        @else

        $('body').on('change', 'input.start-time-picker', function () {
            var parentDiv = $(this).parent('div')
            var startDate = $(this).val();
            var endDateInput = $(parentDiv).siblings('div').find('input.end-time-picker')
            $(endDateInput).val(startDate)
        })
        @endif
    })
</script>
