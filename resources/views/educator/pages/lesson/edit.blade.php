@extends('educator.layouts.master')

@section('title')
    Classhub | Edit Class
@endsection

@section('page_styles')
    <link href="{{ asset('css/flatpickr.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <style type="text/css">
        .other-category {
            opacity: 1 !important;
            cursor: pointer !important;
            display: inline-block;
            width: 60% !important;
            padding: 5px 10px !important;
        }

        .show-more-button-container {
            width: 100%;
            padding: 0;
        }
    </style>
@endsection

@section('content')

    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body list-a-class">

        <div class="m-grid__item m-grid__item--fluid m-wrapper step2">
            <div class="row col-12" style="margin: 0 auto">
                {{--<div class="col-lg-2 col-md-2"></div>--}}
                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12" style="margin: 0 auto">
                    <div class="m-content signup-form">

                        <!--Begin::Steps Section-->
                        <div class="m-portlet m-portlet--full-height steps " style="padding-bottom: 0">
                            <!--begin: Portlet Head-->
                            <div class="m-portlet__head ">
                                <div class="m-portlet__head-caption">
                                    <div class="title">Edit Class</div>
                                </div>
                            </div>
                            <!--end: Portlet Head-->
                        </div>
                        <!--end::Steps Section-->

                        <!--begin: Form Wizard Form-->
                    {!! Form::model( $lesson,  ['url' => $type == 'update' ? route('educator.lesson.update', $lesson->id) : route('educator.lesson.store'),
                        'method' => 'post', 'id' => 'lesson-form',
                        'class' => 'm-form m-form--label-align-left- m-form--state- class-type']) !!}

                    <!-- starts: Class Type -->
                        <h3 class="m-form__heading-title">What’s your class type?</h3>
                        <div class="m-portlet m-portlet--full-height">
                            <div class="m-wizard__form classes-options show-classes-options">

                                <!-- starts: one to one or group choice body -->
                                <div class="m-portlet__body one-or-group">
                                    <div class="row">
                                        <div class="col-xl-10 offset-xl-1">
                                            <!-- starts: one to one or group choice -->
                                            <div class="row">
                                                <div class="col-lg one class-size-select" id="lesson-type-one">
                                                    <label
                                                        class="m-option {{ $lesson->max_num_bookings == 1 ? 'selected' : '' }}">
																	<span class="m-option__control">
																		<span
                                                                            class="m-radio m-radio--brand m-radio--check-bold">
																			<input type="radio" id="oneToOneCheck"
                                                                                   {{ $lesson->max_num_bookings == 1 ? 'checked' : '' }}
                                                                                   class="lesson-type"
                                                                                   name="lesson_type" value="1">
																			<span></span>
																		</span>
																	</span>
                                                        <span class="title">One-to-one</span>
                                                        <span class="help">
																		<span
                                                                            class="m-badge m-badge--brand m-badge--wide info-badge"
                                                                            data-toggle="m-popover" data-html="true"
                                                                            data-placement="bottom"
                                                                            data-content="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.">i</span>
																	</span>
                                                    </label>
                                                </div>
                                                <div class="col-lg-1 or text-center" id="or">
                                                    or
                                                </div>
                                                <div class="col-lg two class-size-select" id="lesson-type-two">
                                                    <label
                                                        class="m-option {{ $lesson->max_num_bookings > 1 ||
                                                        $lesson->max_num_bookings == 0 ?
                                                        'selected' : '' }}">
																	<span class="m-option__control">
																		<span
                                                                            class="m-radio m-radio--brand m-radio--check-bold">
																			<input type="radio" id="groupCheck"
                                                                                   {{ $lesson->max_num_bookings > 1 ? 'checked' : '' }}
                                                                                   class="lesson-type"
                                                                                   name="lesson_type" value="2">
																			<span></span>
																		</span>
																	</span>
                                                        <span class="title">Group of students</span>
                                                        <span class="help">
																		<span
                                                                            class="m-badge m-badge--brand m-badge--wide info-badge"
                                                                            data-toggle="m-popover" data-html="true"
                                                                            data-placement="bottom"
                                                                            data-content="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.">i</span>
																	</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- end: one to one or group choice -->
                                        </div>
                                    </div>
                                </div>
                                <!-- end: one to one or group choice body -->

                                <div class="list-of-choices">
                                    <div class="choices-shadow">&nbsp;</div>
                                    <div class="m-portlet__body choices">
                                        <div class="row">
                                            <div class="col-xl-10 offset-xl-1">

                                                <!--begin::Section-->
                                                <div class="m-accordion m-accordion--default" id="m_accordion_1"
                                                     role="tablist">

                                                    <!--begin::accordion Item 01-->
                                                    <div class="m-accordion__item" id="single">
                                                        <!-- starts : accordion head -->
                                                        <div class="m-accordion__item-head class-type-select collapsed"
                                                             role="tab"
                                                             id="m_accordion_1_item_1_head" data-toggle="collapse"
                                                             href="#m_accordion_1_item_1_body"
                                                             aria-expanded="    false">
                                                            <label class="m-option">
																			<span class="m-option__control">
																				<span
                                                                                    class="m-radio m-radio--brand m-radio--check-bold">
																					<input type="radio"
                                                                                           class="class-type"
                                                                                           {{ $lesson->type === 'single' ? 'checked' : '' }}
                                                                                           id="singleClass"
                                                                                           name="class_type"
                                                                                           value="single">
																					<span></span>
																				</span>
																			</span>
                                                                <span class="title">Single classes</span>
                                                                <span class="help">
																				<span
                                                                                    class="m-badge m-badge--brand m-badge--wide info-badge"
                                                                                    data-toggle="m-popover"
                                                                                    data-html="true"
                                                                                    data-placement="bottom"
                                                                                    data-content="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.">i</span>
																			</span>
                                                            </label>
                                                        </div>
                                                        <!-- end : accordion head -->
                                                        <!-- starts : accordion body -->
                                                        <div
                                                            class="m-accordion__item-body collapse {{ $lesson->type === 'single' ? 'show' : '' }}"
                                                            id="m_accordion_1_item_1_body" class=" " role="tabpanel"
                                                            aria-labelledby="m_accordion_1_item_1_head"
                                                            data-parent="#m_accordion_1">
                                                            <div class="accordion__item-body-shadow">&nbsp;</div>
                                                            <div class="m-accordion__item-content">

                                                                <!--begin::Form-->
                                                                {{--<form
                                                                    class="m-form m-form--fit m-form--label-align-right">--}}
                                                                <div class="m-portlet__body">

                                                                    <div class="form-group m-form__group">
                                                                        <label for="exampleInputEmail1">
                                                                            <span class="text-primary">*</span>Choose
                                                                            class days & times
                                                                            <span
                                                                                class="m-badge m-badge--brand m-badge--wide info-badge"
                                                                                data-toggle="m-popover"
                                                                                data-html="true"
                                                                                data-placement="bottom"
                                                                                data-content="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.">i</span>
                                                                        </label>
                                                                    </div>

                                                                    <!-- starts : Class Time -->
                                                                    <div
                                                                        class="form-group m-form__group two-selectboxes class-time"
                                                                        id="m_repeater_1">
                                                                        <div id="single-class-repeater"
                                                                             class="class-repeater-container">

                                                                            <div
                                                                                data-repeater-list="lesson_dates[single]"
                                                                                class="data-repeater-list">
                                                                                <!-- starts : repeat dom -->
                                                                                @if($lesson->type == 'single' && !request()->has('restart'))
                                                                                    @foreach($lesson->classes as $index => $class)
                                                                                        <div
                                                                                            class="row class-repeater-item"
                                                                                            data-repeater-item="">
                                                                                            <div class="col-lg-6">
                                                                                                <label
                                                                                                    class="col-form-label">
                                                                                                    <span
                                                                                                        class="text-primary">*</span>Class
                                                                                                    Start Time
                                                                                                </label>
                                                                                                <input
                                                                                                    type="text"
                                                                                                    class="form-control datetime-picker start-time-picker"
                                                                                                    name="lesson_dates[single][{{ $index }}][start]"
                                                                                                    value="{{ \Carbon\Carbon::parse($class->date)->format('d-m-Y').' '.
                                                                                                \Carbon\Carbon::parse($class->start_time)->format('H:i') }}">
                                                                                            </div>
                                                                                            <div class="col-lg-6 two">
                                                                                                <label
                                                                                                    class="col-form-label">
                                                                                                    <span
                                                                                                        class="text-primary">*</span>Class
                                                                                                    End Time
                                                                                                </label>
                                                                                                <input
                                                                                                    type="text"
                                                                                                    class="form-control datetime-picker start-time-picker"
                                                                                                    name="lesson_dates[single][{{ $index }}][end]"
                                                                                                    value="{{ \Carbon\Carbon::parse($class->date)->format('d-m-Y').' '.
                                                                                                \Carbon\Carbon::parse($class->end_time)->format('H:i') }}">
                                                                                            </div>
                                                                                        </div>

                                                                                    @endforeach
                                                                                @endif

                                                                                <div class="row class-repeater-item"
                                                                                     data-repeater-item>
                                                                                    <div class="col-lg-6">
                                                                                        <label
                                                                                            class="col-form-label">
                                                                                            <span
                                                                                                class="text-primary">*</span>Class
                                                                                            Start Time
                                                                                        </label>
                                                                                        <input type="text"
                                                                                               class="form-control datetime-picker start-time-picker"
                                                                                               name="[start]">
                                                                                    </div>
                                                                                    <div class="col-lg-6 two">
                                                                                        <label
                                                                                            class="col-form-label">
                                                                                            <span
                                                                                                class="text-primary">*</span>Class
                                                                                            End Time
                                                                                        </label>
                                                                                        <input type="text"
                                                                                               class="form-control datetime-picker end-time-picker"
                                                                                               name="[end]">
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                            <!-- end : repeat dom -->
                                                                            <!-- starts : repeat buttons -->
                                                                            <div class="row p-t-20">
                                                                                <div data-repeater-delete
                                                                                     class="col-4">
                                                                                    <button type="button"
                                                                                            class="btn-sm btn btn-primary m-btn m-btn--icon data-repeater-delete">
                                                                                        <span><i
                                                                                                class="la la-trash-o"></i><span>Delete</span></span>
                                                                                    </button>
                                                                                </div>
                                                                                <div data-repeater-create
                                                                                     class="col-8 text-right">
                                                                                    <button type="button"
                                                                                            class="btn-sm btn btn-primary m-btn m-btn--icon add-btn">
                                                                                        <span><i class="la la-plus"></i><span>Add another class</span></span>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                            <!-- end : repeat buttons -->

                                                                        </div>
                                                                    </div>
                                                                    <!-- end : Class Time -->

                                                                    <!-- starts : Class Repeat -->
                                                                    <div
                                                                        class="form-group m-form__group two-selectboxes">

                                                                        <div class="row">
                                                                            <div class="col-lg-6">
                                                                                <label
                                                                                    class="col-form-label">Repeat</label>
                                                                                <!--begin: Dropdown-->
                                                                            {!! Form::select('repeat_type', \App\Lesson::REPEAT_OPTION, null,
                                                                             ['class' => 'form-control m-bootstrap-select m_selectpicker',
                                                                             'id' => 'repeat-type']) !!}

                                                                            <!--end: Dropdown-->
                                                                            </div>
                                                                            <div class="col-lg-6 two" id="end-repeat"
                                                                                {{ $lesson->repeat_type ? 'style="display: block"': 'style="display: none"' }}>
                                                                                <label class="col-form-label">
                                                                                    End Repeat
                                                                                </label>
                                                                                <input type="text"
                                                                                       class="form-control datetime-picker start-time-picker"
                                                                                       name="repeat_end_date"
                                                                                       value="{{ $lesson->repeat_type ? \Carbon\Carbon::parse($lesson->end_date)->format('d-m-Y') : '' }}"
                                                                                >
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <!-- end : Class Repeat -->

                                                                </div>
                                                            {{--</form>--}}
                                                            <!-- end, form -->

                                                            </div>
                                                        </div>
                                                        <!-- end : accordion body -->
                                                    </div>
                                                    <!--end::accordion Item 01-->

                                                    <!--begin::accordion Item 03-->
                                                    <div class="m-accordion__item" id="term">
                                                        <!-- starts : accordion head -->
                                                        <div class="m-accordion__item-head class-type-select collapsed"
                                                             role="tab"
                                                             id="m_accordion_1_item_3_head" data-toggle="collapse"
                                                             href="#m_accordion_1_item_3_body"
                                                             aria-expanded="    false">
                                                            <label class="m-option">
																			<span class="m-option__control">
																				<span
                                                                                    class="m-radio m-radio--brand m-radio--check-bold">
																					<input type="radio"
                                                                                           class="class-type"
                                                                                           {{ $lesson->type === 'term' ? 'checked' : '' }}

                                                                                           id="TermOfClasses"
                                                                                           name="class_type"
                                                                                           value="term">
																					<span></span>
																				</span>
																			</span>
                                                                <span class="title">Term of classes</span>
                                                                <span class="help">
																				<span
                                                                                    class="m-badge m-badge--brand m-badge--wide info-badge"
                                                                                    data-toggle="m-popover"
                                                                                    data-html="true"
                                                                                    data-placement="bottom"
                                                                                    data-content="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.">i</span>
																			</span>
                                                            </label>
                                                        </div>
                                                        <!-- end : accordion head -->
                                                        <!-- starts : accordion body -->
                                                        <div
                                                            class="m-accordion__item-body collapse term-of-classes {{ $lesson->type === 'term' ? 'show' : '' }}"
                                                            id="m_accordion_1_item_3_body" class=" " role="tabpanel"
                                                            aria-labelledby="m_accordion_1_item_3_head"
                                                            data-parent="#m_accordion_1">
                                                            <div class="accordion__item-body-shadow">&nbsp;</div>
                                                            <div class="m-accordion__item-content">

                                                                <!--begin::Form-->
                                                                <div class="m-portlet__body">

                                                                    <!-- starts : How long is your term -->
                                                                    <div
                                                                        class="form-group m-form__group two-selectboxes">

                                                                        <div class="row">
                                                                            <div class="col-lg-6">
                                                                                <label class="col-form-label"><span
                                                                                        class="text-primary">*</span>How
                                                                                    many weeks in your term?</label>
                                                                                <!--begin: Dropdown-->
                                                                                <div class="col-lg-12">
                                                                                    <input type="number"
                                                                                           id="num-weeks"
                                                                                           min="1"
                                                                                           name="num_weeks"
                                                                                           class="form-control m-input"
                                                                                           placeholder="E.g. 4"
                                                                                           value="{{ $lesson->type=='term' ?$lesson->num_weeks : '' }}">
                                                                                </div>
                                                                                <!--end: Dropdown-->
                                                                            </div>
                                                                            <div class="col-lg-6 two">
                                                                                <label class="col-form-label"><span
                                                                                        class="text-primary">*</span>How
                                                                                    many classes per week are in your
                                                                                    term</label>
                                                                                <!--begin: Dropdown-->
                                                                                <div class="col-lg-12">
                                                                                    <input type="number"
                                                                                           id="term-class-num"
                                                                                           min="1"
                                                                                           class="form-control m-input"
                                                                                           placeholder="E.g. 2"
                                                                                           value="{{ $lesson->type=='term' ? $lesson->classes()->count()/$lesson->num_weeks : '' }}">
                                                                                </div>
                                                                                <!--end: Dropdown-->
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <!-- end : How long is your term -->

                                                                    <!-- starts : all weeks -->
                                                                    <div class="all-weeks">

                                                                        <!-- starts : accordion -->
                                                                        <div class="m-accordion m-accordion--default"
                                                                             id="term-classes" role="tablist">
                                                                            @if($lesson->type == 'term'  && !request()->has('restart'))
                                                                                <?php $classCtr = 0; $classes = $lesson->classes->toArray() ?>
                                                                                @for($i =0; $i < $lesson->num_weeks; $i++)
                                                                                    <div class="m-accordion__item">
                                                                                        <div
                                                                                            class="m-accordion__item-head  collapsed"
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

                                                                                                <!-- starts : repeat set -->
                                                                                                <div
                                                                                                    class="classes-days">
                                                                                                    <div>
                                                                                                        <!-- starts : repeat dom -->
                                                                                                        <div
                                                                                                            data-repeater-list="">
                                                                                                            @for($j = 0; $j < (count($classes)/$lesson->num_weeks); $j++)
                                                                                                                @if(isset($classes[$classCtr]['start_time']))
                                                                                                                    <div
                                                                                                                        class="row class-repeater-item"
                                                                                                                        data-repeater-item>
                                                                                                                        <div
                                                                                                                            class="col-lg-6">
                                                                                                                            <label
                                                                                                                                class="col-form-label">
                                                                                                                            <span
                                                                                                                                class="text-primary">*</span>Class {{ $j+1 }}
                                                                                                                                Start
                                                                                                                                Time
                                                                                                                            </label>
                                                                                                                            <input
                                                                                                                                type="text"
                                                                                                                                class="form-control datetime-picker start-time-picker
                                                                                                                               week-{{$i}}-class-{{$j}}-start week-{{$i}}-class-date classStartTime"
                                                                                                                                name="lesson_dates[term][{{ $classCtr }}][start]"
                                                                                                                                value="{{ \Carbon\Carbon::parse($classes[$classCtr]['date'])->format('d-m-Y').' '.
                                                                                                \Carbon\Carbon::parse($classes[$classCtr]['start_time'])->format('H:i') }}">
                                                                                                                        </div>
                                                                                                                        <div
                                                                                                                            class="col-lg-6 two">
                                                                                                                            <label
                                                                                                                                class="col-form-label">
                                                                                                                            <span
                                                                                                                                class="text-primary">*</span>Class {{ $j+1 }}
                                                                                                                                End
                                                                                                                                Time
                                                                                                                            </label>
                                                                                                                            <input
                                                                                                                                type="text"
                                                                                                                                class="form-control datetime-picker end-time-picker
                                                                                                                               week-{{$i}}-class-{{$j}}-end week-{{$i}}-class-date classStartTime"
                                                                                                                                name="lesson_dates[term][{{ $classCtr }}][end]"
                                                                                                                                value="{{ \Carbon\Carbon::parse($classes[$classCtr]['date'])->format('d-m-Y').' '.
                                                                                                \Carbon\Carbon::parse($classes[$classCtr]['end_time'])->format('H:i') }}">
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                @endif
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
                                                                            @endif

                                                                        </div>
                                                                        <!-- end : accordion -->

                                                                    </div>
                                                                    <!-- end : all weeks -->

                                                                    <!-- starts : btm notes-->
                                                                    <div class="starts">
                                                                        <span>Your term starts on:</span>
                                                                        <span
                                                                            id="term-start">{{ \Carbon\Carbon::parse($lesson->start_date)->format('d/m/Y') }}</span>
                                                                    </div>
                                                                    <div class="finish">
                                                                        <span>Your term finishes on:</span>
                                                                        <span
                                                                            id="term-end">{{ \Carbon\Carbon::parse($lesson->end_date)->format('d/m/Y') }}</span>
                                                                    </div>
                                                                </div>
                                                                <!-- end : btm notes -->

                                                            </div>
                                                            <!-- end, form -->


                                                        </div>
                                                    </div>
                                                    <!-- end : accordion body -->
                                                </div>
                                                <!--end::accordion Item 03-->

                                            </div>
                                            <!--end::Section-->

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end: Class Type -->


                        <!-- starts: Class Details -->
                        <h3 class="m-form__heading-title">Class Details</h3>
                        <div class="m-portlet m-portlet--full-height">
                            <div class="m-wizard__form">
                                <!--
                                    1) Use m-form--label-align-left class to alight the form input lables to the right
                                    2) Use m-form--state class to highlight input control borders on form validation
                                    -->
                                <!--begin: Form Body -->
                                <div class="m-portlet__body">

                                    <!--begin: Form Wizard Step -->
                                    <div class="row">
                                        <div class="col-xl-10 offset-xl-1">
                                            <div class="m-form__section m-form__section--first">

                                                <!-- starts : Category -->
                                                <div class="form-group m-form__group row tophelp no-mobile">
                                                    <div class="col-xl-4 col-lg-4"></div>
                                                    <div class="col-xl-8 col-lg-8">
																	<span class="m-form__help">
																		Choose the category that best describes your class
																	</span>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                        <span class="text-primary">*</span>Category
                                                    </label>
                                                    <div class="col-xl-8 col-lg-8 choose-subjects">
                                                        <span class="m-form__help only-mobile">Choose the category that best describes your class</span>
                                                        <!--begin: Dropdown-->
                                                        <div class="m-dropdown m-dropdown--arrow c-dd-menu"
                                                             m-dropdown-toggle="click">
                                                            <a href="javascript:void(0)"
                                                               class="m-dropdown__toggle btn dropdown-toggle"
                                                               id="category-placeholder">{{ $categoryName  }}</a>

                                                            <div class="m-dropdown__wrapper">
                                                                <div
                                                                    class="m-dropdown__inner taughtSubjects single-select">
                                                                    <div class="m-dropdown__body">
                                                                        <div class="m-dropdown__content">
                                                                            <div class="m-scrollable"
                                                                                 data-scrollable="true"
                                                                                 data-max-height="420">

                                                                                <!-- starts, list options -->
                                                                            @include('educator.includes.category-select-radio',
                                                                                [
                                                                                    'name' => 'category_id',
                                                                                    'type' => 'radio',
                                                                                    'subjects' => [],
                                                                                    'others' => $otherCategory,
                                                                                    'selected_category_id' => $lesson->category_id,
                                                                                    'selected_parent_category_id' => $categoryParent->id
                                                                                ])
                                                                            <!-- end, list options -->

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--end: Dropdown-->
                                                    </div>
                                                </div>
                                                <!-- end : Category -->

                                                <!-- starts: Class Name -->
                                                <div class="form-group m-form__group row tophelp no-mobile">
                                                    <div class="col-xl-4 col-lg-4"></div>
                                                    <div class="col-xl-8 col-lg-8">
																	<span class="m-form__help">
																		What will it be called in your advert?
																	</span>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                        <span class="text-primary">*</span>Class Name:
                                                    </label>
                                                    <div class="col-xl-8 col-lg-8">
																	<span class="m-form__help only-mobile">
																		What will it be called in your advert?
																	</span>
                                                        <input type="text" class="form-control m-input" name="name"
                                                               required value="{{ $lesson->name }}"
                                                               placeholder="E.g. Guitar Lessons">
                                                    </div>
                                                </div>
                                                <!-- end: Class Name -->

                                                <!-- starts: Price row -->
                                                <div class="form-group m-form__group row class-price">
                                                    <label class="col-xl-4 col-lg-4 col-form-label price-label">
                                                        <span class="text-primary">*</span>Price:
                                                    </label>
                                                    <div class="col-xl-8 col-lg-8">
                                                        <div class="input-group m-input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">€</span>
                                                            </div>
                                                            <input type="text" placeholder="50" name="price" required
                                                                   value="{{ \App\Helpers\ClassHubHelper::centToEuro($lesson->price) }}"
                                                                   class="form-control m-input">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end: Price row -->

                                                <!-- starts: Class Size row -->
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                        <span class="text-primary">*</span>Class Size:
                                                    </label>

                                                    <div class="col-xl-8 col-lg-8">
                                                        <select name="max_num_bookings"
                                                                class="form-control m-bootstrap-select m_selectpicker"
                                                                style="z-index: 21">
                                                            @for($i = 1; $i <= 100 ; $i++)
                                                                @if($lesson->max_num_bookings == $i)
                                                                    <option selected value="{{ $i }}">{{ $i }}</option>
                                                                @else
                                                                    <option value="{{ $i }}">{{ $i }}</option>

                                                                @endif
                                                            @endfor
                                                        </select>
                                                        {{--{!! Form::select('max_num_bookings', \App\Setting::CLASS_SIZE, null,
                                                            ['class' => 'form-control m-bootstrap-select m_selectpicker',
                                                            'style' => 'z-index: 21', 'data-display' => 'static', 'data-dropup-auto' => 'false']) !!}--}}
                                                    </div>
                                                </div>
                                                <!-- end: Class Size row -->

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                        <span class="text-primary">*</span>
                                                        Online
                                                    </label>
                                                    <div class="col-xl-8 col-lg-8">
                                                        <span class="m-switch m-switch--danger m-switch--icon">
                                                            <label class="fs-14">
                                                                <input type="radio" name="place"
                                                                       value="online" {{ $lesson->place == 'online' ? 'checked' : '' }}/>
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                        <span
                                                            style="display: inline-block;    vertical-align: top;    margin-top: 10px;">Is this online?</span>
                                                    </div>
                                                </div>


                                                <!-- starts: Areas Covered row -->
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                        <span class="text-primary">*</span>I travel to you:<span
                                                            class="m-badge m-badge--brand m-badge--wide info-badge"
                                                            data-toggle="m-popover" data-html="true"
                                                            data-placement="bottom"
                                                            data-content="Don’t restrict yourself – if you can click multiple locations. Your clients will live all over the city so start a conversation and fine tune details as you go along">i</span>
                                                    </label>
                                                    <div class="col-xl-8 col-lg-2">
                                                        <span class="m-switch m-switch--danger m-switch--icon">
                                                            <label class="fs-14">
                                                                <input type="radio" name="place"
                                                                       value="student" {{ $lesson->place == 'student' ? 'checked' : '' }}/>
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                        <span
                                                            style="display: inline-block;    vertical-align: top;    margin-top: 10px;">You travel to your student</span>

                                                    </div>
                                                    <div class="col-12">
                                                        <div class="col-xl-8 col-lg-8 travel-student"
                                                             style="float: right; display: {{ $lesson->place == 'student' ? 'block' : 'none' }};">
                                                            <div class="m-typeahead" id="area-dropdown"
                                                                 style="margin-bottom:10px ">
                                                                {!! Form::select('areas[]', \App\Area::where('type', 'location')->pluck('address', 'id'),
                                                                optional(Auth::user())->areas()->pluck('area_id')->toArray(),
                                                                ['title' => 'Choose the areas you cover', 'multiple' => 'true',
                                                                'class' => 'form-control form-control--fixed m-bootstrap-select m_selectpicker']) !!}

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end: Areas Covered row -->

                                                <!-- starts: Areas Covered row -->
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                        <span class="text-primary">*</span>You travel to me:
                                                    </label>
                                                    <div class="col-xl-8 col-lg-8">
                                                        <span class="m-switch m-switch--danger m-switch--icon">
                                                            <label class="fs-14">
                                                                <input type="radio" name="place"
                                                                       value="tutor" {{ $lesson->place == 'tutor' ? 'checked' : '' }}/>
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                        <span
                                                            style="display: inline-block;    vertical-align: top;    margin-top: 10px;">Student have to travel to you</span>

                                                    </div>
                                                    <div class="col-12">
                                                        <div class="col-xl-8 col-lg-8 travel-teacher"
                                                             style="float: right; display: {{ $lesson->place == 'tutor' ? 'block' : 'none' }};">
                                                            <div class="m-typeahead">
                                                                <input class="form-control m-input" type="text"
                                                                       name="eircode" id="eircode"
                                                                       value="{{ $lesson->eircode }}"
                                                                       placeholder="Enter EIRCODE "><br>
                                                                <label>Don't know your Eircode? Click <a
                                                                        href="https://finder.eircode.ie/#/"
                                                                        target="_blank">here</a></label>
                                                                <br>
                                                                <br>
                                                                <input class="form-control m-input" type="text"
                                                                       name="location" id="location"
                                                                       value="{{ $lesson->location }}"
                                                                       placeholder="Enter Address here">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end: Areas Covered row -->

                                            <!-- starts: Image Gallery row -->
                                            <div class="form-group m-form__group row photo-bio">
                                                <label class="col-form-label col-lg-4 col-sm-12">
                                                    <span class="text-primary">*</span>Featured Image:<span
                                                        class="m-badge m-badge--brand m-badge--wide info-badge"
                                                        data-toggle="m-popover" data-html="true"
                                                        data-placement="bottom" data-content="
        Pictures can say a lot about what you do. We’d love you to share some of your own pictures but if you can’t then click and drag from our image gallery.
        ">i</span>
                                                </label>
                                                <div class="col-lg-8 col-md-8 col-sm-12">
                                                    <div class="m-dropzone dropzone"
                                                         action="{{ route('upload.image', 'class-images') }}"
                                                         id="dropzone-one">
                                                        <div class="m-dropzone__msg dz-message needsclick">
                                                            @if($lesson->images)
                                                                @foreach($lesson->images as $image)
                                                                    <div
                                                                        class="dz-preview dz-processing dz-image-preview dz-complete"
                                                                        id="image-{{ $image->id }}">
                                                                        <div class="dz-image">
                                                                            <img style="height: 120px"
                                                                                 src="{{ Storage::url($image->path) }}"
                                                                                 data-dz-thumbnail=""/>
                                                                            <div class="file-placeholder"><i
                                                                                    class="fa fa-file-text"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dz-details">
                                                                            <div class="dz-size">
                                                                                    <span
                                                                                        data-dz-size=""><strong></strong></span>
                                                                            </div>
                                                                            <div class="dz-filename">
                                                                                    <span data-dz-name="">
                                                                                        <a target="_blank"
                                                                                           style="cursor:pointer;"
                                                                                           href="{{ Storage::url($image->path) }}">View Image</a>
                                                                                    </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dz-progress">
                                                                                <span class="dz-upload"
                                                                                      data-dz-uploadprogress=""
                                                                                      style="width: 100%;"></span>
                                                                        </div>
                                                                        <a class="dz-remove remove-selected-photo"
                                                                           data-id="{{ $image->id }}"
                                                                           href="javascript:;">
                                                                            Remove Image</a>
                                                                        <input name="images[]"
                                                                               value="{{ $image->id }}"
                                                                               type="hidden"/>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div class="m-dropzone__msg-title">Drag photos here
                                                                    or click to upload.
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <a href="javascript:void(0);" class="clickto-upload"
                                                       id="gallery-image-btn"
                                                       data-toggle="modal" data-target="#image-gallery-upload">Click
                                                        here to select an image from our gallery</a>

                                                </div>
                                            </div>
                                            <!-- end: Image Gallery row -->

                                            <!-- starts: Class Description row -->
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-4 col-lg-4 col-form-label">
                                                    <span class="text-primary">*</span>Class Description:<span
                                                        class="m-badge m-badge--brand m-badge--wide info-badge"
                                                        data-toggle="m-popover" data-html="true"
                                                        data-placement="bottom" data-content="
																		<p>This is your chance to tell everyone how talented
																		 you are. And make you stand out from the crowd. So don’t hold back.
																		  Along with a headline that says what you teach (i.e. German Tutor )
																		  bring your listing to life with words that say a little more about you.
																		   Like experienced, enthusiastic, passionate, etc. All relevant experience
																		   is worth including, and a little bit on how you like to teach is a great idea too.
																		   Check out our other teachers bios for inspiration.</p>
																	">i</span>
                                                </label>
                                                <div class="col-xl-8 col-lg-8">
                                                            <textarea rows="3" class="form-control m-input"
                                                                      name="description" required
                                                                      placeholder="This is your chance to tell everyone how talented you are. And make you stand out from the crowd.">{{ $lesson->description }}</textarea>
                                                    <span class="m-form__help">Max 500 characters</span>
                                                </div>
                                            </div>
                                            <!-- end: Class Description row -->

                                            <!-- starts: Suitable Ages row -->
                                            <div class="form-group m-form__group row two-selectboxes">
                                                <label class="col-xl-4 col-lg-4 col-form-label">
                                                    <span class="text-primary">*</span>Suitable Ages:<span
                                                        class="m-badge m-badge--brand m-badge--wide info-badge"
                                                        data-toggle="m-popover" data-html="true"
                                                        data-placement="bottom"
                                                        data-content="You supply specific times and how many people can book into your class.">i</span>
                                                </label>
                                                <div class="col-xl-8 col-lg-8">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            {!! Form::select('age_from',  \App\Lesson::AGE_FROM, $lesson->age_from,
                                                                ['class' => 'form-control form-control--fixed m-bootstrap-select m_selectpicker',
                                                                'placeholder' => 'From', 'required' => 'required']) !!}

                                                        </div>
                                                        <div class="col-lg-6 two student-menu">
                                                            {!! Form::select('age_to',  \App\Lesson::AGE_FROM + ['18+' => '18+'], $lesson->age_to,
                                                                ['class' => 'form-control form-control--fixed m-bootstrap-select m_selectpicker',
                                                                'placeholder' => 'To', 'required' => 'required']) !!}

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end: Suitable Ages row -->


                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step -->

                            </div>
                            <!--end: Form Body -->
                        </div>
                    </div>
                    <!-- end: Class Details -->

                    <!-- starts : save & continue -->

                    <div class="save-continue two-buttons">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 text-left">

                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                <button type="submit" class="btn btn-primary shadow-v4"
                                        id="submit-form">
                                  <span
                                      class="btn__text icon-arrow-right">{{ $type == 'update' ? 'UPDATE' : 'RESTART' }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- end : save & continue -->

                {!! Form::close() !!}


                <!--begin::image-gallery Modal-->
                    <div class="modal fade c-modal v1  image-gallery list-a-class checkbox-v1"
                         id="image-gallery-upload" tabindex="-1"
                         role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5>Select images from our Gallery</h5><br>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">
                                                &times;
                                            </span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- starts : choose images -->
                                    <div class="choose-images">
                                        <div class="m-scrollable" data-scrollable="true" data-max-height="400"
                                             data-scrollbar-shown="true">
                                            <div class="m-portlet__body">
                                                <div class="m-form__section m-form__section--first">
                                                    <div class="form-group m-form__group">
                                                        <div class="row" id="gallery-images">
                                                            <div class="show-more-container row">

                                                                @foreach($images as $image)
                                                                    <div class="col-6 col-md-4 img">
                                                                        <label class="m-option">
                                                                                    <span
                                                                                        class="m-checkbox m-checkbox--air m-checkbox--solid m-checkbox--state-brand">
                                                                                        <input type="radio"
                                                                                               name="gallery_images[]"
                                                                                               value="{{ $image->id }}"
                                                                                               data-name=" {{ $image->title }}"
                                                                                               data-src="{{ App\Helpers\ClassHubHelper::getImagePath($image)  }}">
                                                                                        <span></span>
                                                                                    </span>
                                                                            <img alt="Pic"
                                                                                 class="product-thumb lazy"
                                                                                 src="{{ route('home') }}{{ Storage::url($image->path) }}"/>
                                                                        </label>
                                                                    </div>
                                                                @endforeach

                                                                @if($images->nextPageUrl())
                                                                    <div
                                                                        class="row showmore p-t-55 show-more-button-container">
                                                                        <div class="col-sm-12 col-12 text-center">
                                                                            <a class="btn btn-primary shadow-v4 show-more-button"
                                                                               href="{{ $images->nextPageUrl().'&'.request()->getRequestUri() }}">
                                                                                    <span
                                                                                        class="btn__text">LOAD MORE</span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end : choose images -->

                                    <!-- starts : upload image -->
                                    <div class="upload-button text-center">
                                        <a class="btn btn-primary v1 shadow-v4 select-images"
                                           href="javascript:void(0);">
                                            <span class="btn__text">Select Image</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::image-gallery Modal-->

                    <!-- starts : modal preview Class -->
                    <div class="modal fade preview-class-modal" id="previewClass" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog container" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <!-- starts: preview class -->
                                <?php //include('preview/preview-class.php'); ?>
                                <!-- end: preview class -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end : modal preview Class -->


                </div>
            </div>
        </div>
    </div>
    </div>

@endsection

@section('page_scripts')

    <script src="{{ asset('educator/assets/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.jscroll.min.js') }}"></script>
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <script src="{{ asset('js/show-more.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/dropzone.js') }}" type="text/javascript"></script>

    <script type="text/javascript">

        var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        var modalGallery = $('div#image-gallery-upload')
        var selectedImages = []
        var autoComplete;

        function initAutoComplete() {
            let input = document.getElementById('eircode')
            autoComplete = new google.maps.places.Autocomplete(input, {componentRestrictions: {'country': ['ie']}})
            autoComplete.addListener('place_changed', placeChanged)
        }

        function placeChanged() {
            place = autoComplete.getPlace()
            let addressField = $('input#eircode')
            var postalCode = null;

            place.address_components.forEach(function (address_component) {
                let type = address_component.types[0];
                if (type == "postal_code") {
                    postalCode = address_component.long_name;
                    $(addressField).val(address_component.long_name);
                }
            });

            if (postalCode == null) {
                $(addressField).val('');
            }
        }

        Dropzone.options.dropzoneOne = {
            addRemoveLinks: true,
            maxFiles: 1,
            acceptedFiles: 'image/*',
            dictRemoveFile: 'Remove Image',
            init: function () {
                var prevFile

                this.on('addedfile', function () {
                    if (typeof prevFile !== "undefined") {
                        this.removeFile(prevFile)
                    }
                });

                this.on('success', function (file) {
                    prevFile = file
                });
            },

            success: function (file, done) {
                if (done.error) {
                    alert(done.error)
                } else {
                    if ($('div#dropzone-one').find('div.dz-preview').length > 1) {
                        $('div#dropzone-one').find('div.dz-preview:first').remove()
                    }
                    let formInput = Dropzone.createElement('<input type="hidden"  name="images[]"  ' +
                        'value="' + done.id + '">');
                    file.previewElement.appendChild(formInput);
                    file.id = done.id;
                    file.path = done.path;
                }
            },
        }

        $('body').on('click', '.select-images', function () {
            $('div#gallery-images input[type="radio"]').each(function () {
                if ($(this).is(':checked')) {
                    let id = $(this).val()
                    let url = $(this).data('src')

                    $('div#dropzone-one').html(`
                              <div class="dz-preview dz-processing dz-image-preview dz-complete" id="image-${id}">
                              <div class="dz-image">
                              <img style="object-fit: cover; width: 120px; height: 120px;" src="${url}"  data-dz-thumbnail=""/>
                              </div>
                              <div class="dz-details">
                              <div class="dz-size">
                              <span data-dz-size=""><strong></strong></span>
                              </div>
                              <div class="dz-filename">
                              <span data-dz-name="">
                              <a target="_blank" style="cursor:pointer;" href="${url}">View Image</a>
                              </span>
                              </div>
                              </div>
                              <div class="dz-progress">
                              <span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span>
                              </div>
                              <a class="dz-remove remove-selected-photo" data-id="${id}" href="javascript:;">
                              Remove Image</a>
                              <input name="images[]" value="${id}" type="hidden" />
                              </div>`)
                }
            })

            $(modalGallery).modal('hide')
        })

        function updateTermStartEndDates() {
            var classDates = [];
            format = 'DD-MM-YYYY HH:mm';

            @if($mobile)
                format = 'YYYY-MM-DDTHH:mm'
            @endif

            // Fill term start and end
            $('div#term-classes input.class-start-date').each(function () {
                date = $(this).val()
                date = moment(date, format)
                if (classDates.indexOf(date) === -1 && date.isValid()) {
                    classDates.push(date)
                }
            })

            console.log(classDates)

            $('span#term-start').html(moment.min(classDates).format('DD/MM/YYYY'))
            $('span#term-end').html(moment.max(classDates).format('DD/MM/YYYY'))
        }

        $('body').on('change', 'input.same-week-switch', function () {

            weekNo = $(this).data('week')

            if ($(this).is(':checked')) {

                format = 'DD-MM-YYYY HH:mm';

                @if($mobile)
                    format = 'YYYY-MM-DDTHH:mm'
                @endif

                $('input.week-0-class-date').each(function (index) {
                    date = moment($(this).val(), format)
                    if (date.isValid()) {
                        newDate = date.add(7 * weekNo, 'days')
                        console.log(weekNo, index)
                        console.log(newDate.format(format))

                        if (index % 2 == 0) {
                            classNo = index / 2
                            $(`div.week-${weekNo}-classes`).find(`input.week-${weekNo}-class-${classNo}-start`)
                                .val(newDate.format(format))
                        } else {
                            classNo = (index - 1) / 2
                            $(`div.week-${weekNo}-classes`).find(`input.week-${weekNo}-class-${classNo}-end`)
                                .val(newDate.format(format))
                        }
                    }
                })
            } else {
                $(`div.week-${weekNo}-classes input.week-${weekNo}-class-date`).val('')
            }

            updateTermStartEndDates()
        })

        @if(!$mobile)
        $('body').on('change', 'input.flatpickr-input', function () {
            updateTermStartEndDates()
        })

        $('input.start-time-picker').flatpickr({
            enableTime: true,
            dateFormat: "d-m-Y H:i",
            time_24hr: true,
            minDate: "{!! date('d-m-Y H:i') !!}",
        })

        $('input.date-picker').flatpickr({
            enableTime: true,
            dateFormat: "d-m-Y H:i",
            time_24hr: true,
            minDate: "{!! date('d-m-Y') !!}"
        })

        $('body').on('change', 'input.start-time-picker', function () {
            var parentDiv = $(this).parent('div')
            var startDate = $(this).val();
            var endDateInput = $(parentDiv).siblings('div').find('input.end-time-picker')
            $(endDateInput).val()
            $(endDateInput).flatpickr({
                enableTime: true,
                dateFormat: "d-m-Y H:i",
                time_24hr: true,
                minDate: "{!! date('d-m-Y H:i') !!}",
                defaultDate: startDate
            })
        })

        @else

        $('body').on('change', 'input[type="datetime-local"]', function () {
            updateTermStartEndDates()
        })

        $('body').on('change', 'input.start-time-picker', function () {
            var parentDiv = $(this).parent('div')
            var startDate = $(this).val();
            var endDateInput = $(parentDiv).siblings('div').find('input.end-time-picker')
            $(endDateInput).val(startDate)
        })
        @endif


        $(function () {

            // Lesson type toggle
            $('body').on('click', 'div.class-size-select', function () {
                $('div.list-of-choices').show()
                let type = parseInt($('input[name="lesson_type"]:checked').val());

                console.log(type)

                if (type == 1) {

                    $('div#lesson-type-two').remove();
                    $('div#or').remove();

                    $('select[name="max_num_bookings"]').selectpicker('val', 1);
                    $('select[name="max_num_bookings"] > option').each(function () {
                        if (parseInt($(this).val()) != 1) {
                            $(this).prop('disabled', true)
                        }
                    });

                    $('select[name="max_num_bookings"]').prop('disabled', true);
                    $('select[name="max_num_bookings"]').selectpicker('refresh');

                    $('#oneToOneCheck').closest('.m-option').addClass('selected');
                    $('#groupCheck').closest('.m-option').removeClass('selected');
                    $('#oneToOneCheck').closest('.classes-options').addClass('show-classes-options');
                }

                if (type == 2) {

                    $('div#lesson-type-one').remove();
                    $('div#or').remove();

                    $('select[name="max_num_bookings"] > option').each(function () {
                        if (parseInt($(this).val()) != 1) {
                            $(this).prop('disabled', false)
                        }
                    });

                    $('select[name="max_num_bookings"]').prop('disabled', false);
                    $('select[name="max_num_bookings"]').selectpicker('refresh');

                    $('#oneToOneCheck').closest('.m-option').removeClass('selected');
                    $('#groupCheck').closest('.m-option').addClass('selected');
                    $('#groupCheck').closest('.classes-options').addClass('show-classes-options');
                }
            })
            // Class type toggle
            $('div.class-type-select').on('click', function () {
                $('div.class-type-select input.class-type').attr('checked', false)
                $(this).find('input.class-type').attr('checked', true)
                let type = $(this).find('input.class-type').val()

                if (type == 'single') {
                    $('label.price-label').html('<span class="text-primary">*</span>Price per single class')
                    $('div#group').remove()
                    $('div#term').remove()
                }
                if (type == 'group') {
                    $('label.price-label').html('<span class="text-primary">*</span>Price per group  of classes')
                    $('div#single').remove()
                    $('div#term').remove()
                }
                if (type == 'term') {
                    $('label.price-label').html('<span class="text-primary">*</span>Price per term of classes')
                    $('div#single').remove()
                    $('div#group').remove()
                }
            })

            $('div#single-class-repeater').repeater({
                initEmpty: false,
                show: function () {
                    $(this).slideDown()

                    $(this).find('input.datetime-picker').flatpickr({
                        enableTime: true,
                        dateFormat: "d-m-Y H:i",
                        minDate: "{!! date('d-m-Y H:i') !!}"
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

            $('input#group-class-num').on('keyup', function (e) {
                e.preventDefault()

                var _this = $(this)
                $.ajax({
                    type: 'GET',
                    url: '{{ route('group.datetime.template') }}',
                    data: {_token: '{{ csrf_token() }}', 'classes': $(_this).val()},
                    dataType: 'HTML',
                    success: function (data) {
                        $('div#group-classes').html(data)
                    },
                    error: function (data) {
                        $('div#group-classes').html(data)
                    }
                });

                return false
            })

            $('input#term-class-num, input#num-weeks').on('keyup change', function (e) {
                e.preventDefault()

                if ($('input#term-class-num').val() >= 1 && $('input#num-weeks').val() >= 1) {
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('term.datetime.template') }}',
                        data: {
                            _token: '{{ csrf_token() }}', 'weeks': $('input#num-weeks').val(),
                            'classes': $('input#term-class-num').val()
                        },
                        dataType: 'HTML',
                        success: function (data) {
                            $('div#term-classes').html(data)
                        },
                        error: function (data) {
                            $('div#group-classes').html(data)
                        }
                    });
                }

                return false
            })

            $('body').on('click', 'a.remove-selected-photo', function () {
                var id = $(this).data('id')
                $(this).parents(`div#image-${id}`).remove()

                selectedImages = selectedImages.filter(item => {
                    return item !== id
                })

                $('div#dropzone-one').html(`
                    <div class="m-dropzone__msg dz-message needsclick">
                        <div class="m-dropzone__msg-title">Drag photos here or click to upload.
                        </div>
                    </div>
                `)
            })

            $('body').on('click', 'a.auto-add-category', function () {
                var categoryId = $(this).data('id')

                $.ajax({
                    type: 'POST',
                    url: '{{ route('educator.category.add') }}',
                    data: {_token: '{{ csrf_token() }}', category_id: categoryId},
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.status) {
                            console.log(data)
                            $(resultModal).find('div.modal-body').html(data.messages)
                        }
                    },
                    error: function (data) {
                        $(resultModal).find('div.modal-body').html(data.messages)
                    }
                });
            })

            if (iOS) {

                $('button#submit-form').on('click', function (e) {
                    e.preventDefault()

                    $(resultModal).modal('show')

                    var formData = $('form#lesson-form').serializeArray()
                    let type = $('input[name="lesson_type"]:checked').val()
                    if (type == 1) {
                        console.log('one to one')
                        formData.push({name: 'max_num_bookings', value: 1})
                    }

                    $.ajax({
                        type: 'POST',
                        url: $('form#lesson-form').attr('action'),
                        data: formData,
                        dataType: 'JSON',
                        success: function (data) {
                            if (data.status) {
                                $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))

                                setTimeout(function () {
                                    window.location = data.redirect_url
                                }, 3000)
                            }

                            if (data.status == false && data.category_error) {
                                console.log(data)
                                $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                            } else {
                                $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                            }
                        },
                        error: function (data) {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    });

                    return false
                })

            } else {

                $('form#lesson-form').on('submit', function (e) {
                    e.preventDefault()

                    $(resultModal).modal('show')

                    var formData = $('form#lesson-form').serializeArray()
                    let type = $('input[name="lesson_type"]:checked').val()
                    if (type == 1) {
                        console.log('one to one')
                        formData.push({name: 'max_num_bookings', value: 1})
                    }

                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: formData,
                        dataType: 'JSON',
                        success: function (data) {
                            if (data.status) {
                                $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))

                                setTimeout(function () {
                                    window.location = data.redirect_url
                                }, 3000)
                            }

                            if (data.status == false && data.category_error) {
                                console.log(data)
                                $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                            } else {
                                $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                            }
                        },
                        error: function (data) {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    });

                    return false
                })
            }


        })

        $('select#repeat-type').on('change', function () {
            if ($(this).val() == 'weekly') {
                $('div#end-repeat').css('display', 'block')
            } else {
                $('div#end-repeat').css('display', 'none')
            }
        })

        $('a.preview-class-btn').on('click', function () {
            var formData = $('form#lesson-form').serializeArray()
            let type = $('input[name="lesson_type"]:checked').val()
            if (type == 1) {
                console.log('one to one')
                formData.push({name: 'max_num_bookings', value: 1})
            }

            $.ajax({
                type: 'POST',
                url: '{{ route('educator.lesson.preview') }}',
                data: formData,
                dataType: 'HTML',
                success: function (data) {
                    $('div#preview-class').find('div.modal-body').html(data)
                },
                error: function (data) {
                    $('div#preview-class').find('div.modal-body').html(data)
                }
            });
        })

        $('body').on('keyup', 'input.other-category', function (e) {
            parent = $(this).parents('li.parent-category');
            if (!$(this).val().length) {
                $('a#category-placeholder').html('Choose a Category')
            } else {
                $('a#category-placeholder').html($(this).data('parent-category') + ' - ' + $(this).val())
            }
        })

        $('body').on('change', 'input[name="place"]', function () {
            $('div.travel-student').css('display', 'none')
            $('div.travel-teacher').css('display', 'none')
            if ($(this).val() == 'student') {
                $('div.travel-student').css('display', 'block')
            }
            if ($(this).val() == 'tutor') {
                $('div.travel-teacher').css('display', 'block')
            }
        })

        $(function () {
            $('.jscroll-inner').addClass('row');

            $('select[name="age_from"]').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
                var ageFrom = parseInt($('select[name="age_from"]').val())
                var ageTo = parseInt($('select[name="age_to"]').val())
                console.log(ageFrom)
                console.log(ageTo)
                if (ageFrom) {
                    $('select[name="age_to"] > option').each(function () {
                        if ($(this).val() !== '18+' && parseInt($(this).val()) <= ageFrom) {
                            console.log($(this).val())
                            $(this).prop('disabled', true)
                        } else {
                            $(this).prop('disabled', false)
                        }
                    })
                    $('select[name="age_to"]').selectpicker('refresh')

                    if (ageFrom == 18) {
                        $('select[name="age_to"]').selectpicker('val', '18+')
                    }

                    if (ageFrom <= ageTo) {
                        $('select[name="age_to"]').selectpicker('val', ageFrom + 1)
                    }
                }
            })

        });

    </script>

    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places&type=regions&callback=initAutoComplete">
    </script>

@endsection
