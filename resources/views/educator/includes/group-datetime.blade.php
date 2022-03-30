<?php $mobile = !(new \Jenssegers\Agent\Agent())->isDesktop(); ?>


@for($i =0; $i < $classes; $i++)
    <div class="row class-repeater-item"
         data-repeater-item>
        <div class="col-lg-6">
            <label
                class="col-form-label">
                <span class="text-primary">*</span>Class {{ $i+1 }} Start Time
            </label>
            <input type="{{ $mobile ? 'datetime-local' : 'text'  }}"
                   class="form-control datetime-picker start-time-picker"
                   name="lesson_dates[group][{{$i}}][start]">
        </div>
        <div class="col-lg-6 two end-date-container">
            <label
                class="col-form-label">
                <span class="text-primary">*</span>Class {{ $i+1 }} End Time
            </label>
            <input type="{{ $mobile ? 'datetime-local' : 'text'  }}"
                   class="form-control datetime-picker end-time-picker"
                   name="lesson_dates[group][{{$i}}][end]">
        </div>
    </div>
@endfor
@if(!$mobile)
    <script type="text/javascript">
        $(function () {
            $('input.datetime-picker').flatpickr({
                enableTime: true,
                dateFormat: "d-m-Y H:i",
                time_24hr: true,
                minDate: "{!! date('d-m-Y H:i') !!}"
            })
        })
    </script>
@endif
