<div class="title fs-23 fw-5 p-l-0">Move class to different day & time</div>
<div class="fw-5 p-t-4">{{ $lesson->user->name }} - {{ $lesson->name }}</div>
<div class="fw-5 p-t-4">Student:  {{ $booking->student_name }}</div>
{!! Form::open(['url' => route('educator.move.class'), 'id' => 'move-class-form']) !!}
<input type="hidden" name="booking_id" value="{{ $booking->id }}">
<div class="row p-t-30">
    <div class="col-lg-12 ">
        <label class="col-form-label">
            <span class="text-primary">*</span>Select Class to Move
        </label>
        <!--begin: Dropdown-->
        <select name="class_to_move" class="form-control form-control--fixed  m_selectpicker">
            @foreach($booking->classes as $bookingClass)
                    <option value="{{ $bookingClass->class->id }}">
                        {{ $bookingClass->class->day }}
                        {{ \Carbon\Carbon::parse($bookingClass->class->date)->format('d M Y') }}
                        ({{ \Carbon\Carbon::parse($bookingClass->class->start_time)->format('H:i')}} -
                        {{ \Carbon\Carbon::parse($bookingClass->class->end_time)->format('H:i') }})
                    </option>
            @endforeach
        </select>
        <!--end: Dropdown-->
    </div>
</div>

<div class="row p-t-30">
    <div class="col-lg-12">
        <label class="col-form-label">
            <span class="text-primary">*</span>New Class Start Time
        </label>
        <!--begin: Dropdown-->
        <input type="{{ $mobile ? 'datetime-local' : 'text'  }}"
               class="form-control m-input datetime-picker"
               name="start_time"
               required
               min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
        <!--end: Dropdown-->
    </div>
</div>

<div class="row p-t-20">
    <div class="col-lg-12">
        <label class="col-form-label">
            <span class="text-primary">*</span>New Class End Time
        </label>
        <!--begin: Dropdown-->
        <input type="{{ $mobile ? 'datetime-local' : 'text'  }}"
               class="form-control m-input datetime-picker"
               name="end_time"
               required
               min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
        <!--end: Dropdown-->
    </div>
</div>

<div class="p-b-25 text-right p-t-46">
    <a class="btn btn-secondary btn-text-red shadow-v4" data-dismiss="modal" href="javascript:void(0);"><span
            class="btn__text v1 fw-6">Cancel</span></a>
    <a class="btn btn-sm btn-primary v2 shadow-v4 m-l-40 move-class-btn" href="javascript:void(0);"
       data-dismiss="modal" data-toggle="modal" data-target="#result-modal"><span
            class="btn__text v1 fw-6">Done</span></a>
</div>
{!! Form::close() !!}
<link href="{{ asset('css/flatpickr.css') }}" rel="stylesheet" type="text/css" media="all"/>
<script src="{{ asset('js/flatpickr.js') }}"></script>

@if(!$mobile)
    <script type="text/javascript">
        $('input.datetime-picker').flatpickr({
            enableTime: true,
            static: true,
            dateFormat: "d-m-Y H:i",
            time_24hr: true,
            minDate: "{!! date('d-m-Y H:i') !!}",
        })

    </script>
@endif


