<?php $mobile = !(new \Jenssegers\Agent\Agent())->isDesktop(); ?>
<?php $classCtr = 0 ?>

@for($i =0; $i < $weeks; $i++)
    <div class="m-accordion__item" style="z-index:{{$weeks-$i}}">
        <div
            {{ $mobile ? 'onclick="toggleTermClasses(obj)"' : '' }}
            class="m-accordion__item-head collapsed"
            role="tab"
            id="all-weeks_accordion_item_{{$i}}_head"
            data-toggle="collapse"
            href="#all-weeks_accordion_item_{{$i}}_body"
            aria-expanded="    false">
            <span
                class="m-accordion__item-title">Week {{ $i+1 }}</span>
        </div>
        <div
            class="m-accordion__item-body collapse"
            id="all-weeks_accordion_item_{{$i}}_body"
            class=" " role="tabpanel"
            aria-labelledby="all-weeks_accordion_item_{{$i}}_head"
            data-parent="#all-weeks_accordion">
            <div
                class="accordion__item-body-shadow">
                &nbsp;
            </div>
            <div
                class="m-accordion__item-content">

            @if($i > 0)
                <!-- starts : row 1 -->
                    <div class="form-group m-form__group row keep-the-same-days">
                        <div class="col-lg-auto col-form-label">
                            <div class="title">Keep the same days and times as week 1?</div>
                        </div>
                        <div class="col-12 col-lg-auto switch-right">
                            <span
                                class="m-switch m-switch--danger m-switch--icon switch-week">
                                <label>
                                    <input
                                        type="checkbox"
                                        class="same-week-switch"
                                        data-week="{{ $i  }}"
                                        name="">
                                    <span></span>
                                </label>
                            </span>
                        </div>
                    </div>
                    <!-- end : row 1 -->
            @endif

            <!-- starts : repeat set -->
                <div class="classes-days ">
                    <div>
                        <!-- starts : repeat dom -->
                        <div class="week-{{$i}}-classes">
                            @for($j = 0; $j < $classes; $j++)
                                <div class="row class-repeater-item"
                                     data-repeater-item>
                                    <div class="col-lg-6">
                                        <label
                                            class="col-form-label">
                                            <span class="text-primary">*</span>Class {{ $j+1 }} Start Time
                                        </label>
                                        <input type="{{ $mobile ? 'datetime-local' : 'text'  }}"
                                               class="form-control datetime-picker start-time-picker
                                                classStartTime class-start-date week-{{$i}}-class-{{$j}}-start week-{{$i}}-class-date"
                                               name="lesson_dates[term][{{ $classCtr }}][start]">

                                    </div>
                                    <div class="col-lg-6 two end-date-container">
                                        <label
                                            class="col-form-label">
                                            <span class="text-primary">*</span>Class {{ $j+1 }} End Time
                                        </label>
                                        <input type="{{ $mobile ? 'datetime-local' : 'text'  }}"
                                               class="form-control datetime-picker end-time-picker week-{{$i}}-class-{{$j}}-end week-{{$i}}-class-date
                                                classStartTime"
                                               name="lesson_dates[term][{{ $classCtr }}][end]">
                                    </div>
                                </div>
                                <?php $classCtr++ ?>
                            @endfor
                        </div>
                        <!-- end : repeat buttons -->
                    </div>
                </div>
                <!-- end : repeat set -->
            </div>
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
                minDate: "{!! date('d-m-Y H:i') !!}",
                onChange: function () {
                    updateTermStartEndDates()
                }
            })
        })

        function toggleTermClasses(obj) {
            if ($(obj).hasClass('collapsed')) {
                $(obj).removeClass('collapsed')
                $(obj).siblings('m-accordion__item-body').slideDown()
                $(obj).siblings('m-accordion__item-body').addClass('show')
            } else {
                $(obj).addClass('collapsed')
                $(obj).siblings('m-accordion__item-body').slideUp()
                $(obj).siblings('m-accordion__item-body').removeClass('show')
            }
        }
    </script>
@endif
