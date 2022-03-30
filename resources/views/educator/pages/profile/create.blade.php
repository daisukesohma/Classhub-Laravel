@extends('educator.layouts.master')

@section('title')
    Classhub | Educator Profile
@endsection

@section('page_styles')
    <style type="text/css">
        span.other {
            display: inline-block;
        }

        input.other-input {
            margin: -25px 0 0 0;
            width: 70%;
            display: inline-block;
            padding: 0 10px !important;
            cursor: text;
            opacity: 1;
        }
    </style>
@endsection

@section('content')

    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body list-a-class">

        <div class="m-grid__item m-grid__item--fluid m-wrapper step1">
            <div class=" col-12">
                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12" style="margin: 0 auto">
                    <div class="m-content signup-form">

                        <!--Begin::Steps Section-->
                        <div class="m-portlet m-portlet--full-height steps shadow-v1">
                            <!--begin: Portlet Head-->
                            <div class="m-portlet__head shadow-v1">
                                <div class="m-portlet__head-caption">
                                    <div class="title">Set up your Profile</div>
                                </div>
                            </div>
                            <!--end: Portlet Head-->
                            <!--begin: Form Wizard-->
                            <div class="m-wizard m-wizard--2 m-wizard--brand" id="m_wizard">
                                <!--begin: Form Wizard Head -->
                                <div class="m-wizard__head m-portlet__padding-x">
                                    <!--begin: Form Wizard Progress -->
                                    <div class="m-wizard__progress">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="100"
                                                 aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <!--end: Form Wizard Progress -->
                                    <!--begin: Form Wizard Nav -->
                                    <div class="m-wizard__nav">
                                        <div class="m-wizard__steps">

                                            <div class="m-wizard__step m-wizard__step--current"
                                                 m-wizard-target="m_wizard_form_step_0">
                                                <a href="{{ route('educator.profile.create') }}"
                                                   class="m-wizard__step-number"><span><i
                                                            class="fa fa-circle"></i></span></a>
                                                <div class="m-wizard__step-info">
                                                    <div class="m-wizard__step-title">
                                                        Set up your profile
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_1">
                                                <a href="{{ route('educator.setup.stripe') }}"
                                                   class="m-wizard__step-number"><span></span></a>
                                                <div class="m-wizard__step-info">
                                                    <div class="m-wizard__step-title">
                                                        Get paid
                                                    </div>
                                                </div>
                                            </div>

                                            {{--<div class="m-wizard__step" m-wizard-target="m_wizard_form_step_2">
                                                <a href="{{ route('educator.lesson.create') }}"
                                                   class="m-wizard__step-number"><span></span></a>
                                                <div class="m-wizard__step-info">
                                                    <div class="m-wizard__step-title">
                                                        Tell us about your class
                                                    </div>
                                                </div>
                                            </div>--}}

                                        </div>
                                    </div>
                                    <!--end: Form Wizard Nav -->
                                </div>
                            </div>
                        </div>
                        <!--end::Steps Section-->

                        <!-- starts: Basic Details -->
                        {!! Form::model(Auth::user()->educator, ['url' => route('educator.profile.store'),
                        'method' => 'post', 'id' => 'profile-form', 'class' => 'm-form m-form--label-align-left- m-form--state-']) !!}
                        {{ Form::hidden('user_type', $type) }}
                        {{ Form::hidden('redirect_url', request()->redirect_url) }}
                        <h3 class="m-form__heading-title">Profile Information</h3>
                        <div class="m-portlet m-portlet--full-height">
                            <div class="m-wizard__form">
                                <!--
                                1) Use m-form--label-align-left class to alight the form input lables to the right
                                2) Use m-form--state class to highlight input control borders on form validation
                              -->
                                <!--begin: Form Body -->
                                <div class="m-portlet__body padding-mobile-none-lr">
                                    <!--begin: Form Wizard Step 1-->
                                    <div class="row">
                                        <div class="col-xl-10 offset-xl-1 padding-mobile-none-lr">
                                            <div class="m-form__section m-form__section--first">
                                                <!-- starts :Profile setup -->

                                                <!-- starts :What best describes you? -->
                                                <div class="form-group m-form__group row">

                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                        <span class="text-primary">*</span>
                                                        What best describes you?
                                                        <span class="m-badge m-badge--wide info-badge"
                                                              data-toggle="m-popover" data-html="true"
                                                              data-placement="bottom"
                                                              data-content="Choose the teaching type that suits you best, you can also type in your own preferred term if you like. This will appear on your profile">i</span>
                                                    </label>

                                                    <div class="col-xl-8 col-lg-8">
                                                        <!--begin: Dropdown-->
                                                        <div class="m-dropdown m-dropdown--arrow c-dd-menu"
                                                             m-dropdown-toggle="click">
                                                            <a href="javascript:void(0)" id="teaching-types-placeholder"
                                                               class="m-dropdown__toggle btn dropdown-toggle">
                                                                {{ Auth::user()->educator ? implode(', ', Auth::user()->educator->teaching_types) : 'Choose your teaching type' }}
                                                            </a>
                                                            <div class="m-dropdown__wrapper">
                                                                <div
                                                                    class="m-dropdown__inner taughtSubjects teaching-type-select">
                                                                    <div class="m-dropdown__body">
                                                                        <div class="m-dropdown__content">
                                                                            <div class="m-scrollable"
                                                                                 data-scrollable="true"
                                                                                 data-max-height="250">
                                                                                <!-- starts, list options -->
                                                                                @include('educator.includes.teaching-type-select',
                                                                                [
                                                                                'name' => 'teaching_types[]',
                                                                                'type' => 'checkbox',
                                                                                'selected' => optional($educator)->teaching_types ?
                                                                                $educator->teaching_types : [],
                                                                                ])
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--end: Dropdown-->
                                                    </div>

                                                </div>
                                                <!-- end : What best describes you? -->

                                                <!-- starts : Qualifications & Experience  -->
                                                <div class="form-group  m-form__group row" id="qualification-repeater">

                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                        <span class="text-primary">*</span>
                                                        Qualifications & Experience
                                                        <span
                                                            class="m-badge m-badge--brand m-badge--wide info-badge"
                                                            data-toggle="m-popover" data-html="true"
                                                            data-placement="bottom"
                                                            data-content="List all your formal qualifications and experience">i</span>
                                                    </label>

                                                    <div class="col-xl-8 col-lg-8">
                                                        <!-- starts : repeat div -->
                                                        <div data-repeater-list="qualifications"
                                                             class="col-lg-12 repeater-item-container">

                                                            @if(optional(Auth::user()->educator)->qualifications)
                                                                @foreach(Auth::user()->educator->qualifications as $key => $value)
                                                                    @if($value['name'])
                                                                        <div data-repeater-item
                                                                             class="form-group m-form__group row align-items-center">
                                                                            <input type="text"
                                                                                   class="form-control m-input"
                                                                                   name="qualifications[{{$key}}][name]"
                                                                                   value="{{ $value['name'] }}"
                                                                                   placeholder="B.A in Digital Media">

                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            @endif

                                                            <div data-repeater-item
                                                                 class="form-group m-form__group row align-items-center">
                                                                <input type="text" class="form-control m-input"
                                                                       name="name" placeholder="B.A in Digital Media">

                                                            </div>
                                                        </div>
                                                        <!-- end : repeat div -->
                                                        <!-- starts : buttons -->
                                                        <div class="p-t-12 p-b-2">
                                                            <a data-repeater-delete href="javascript:;"
                                                               class="btn-sm btn btn-primary m-btn m-btn--icon data-repeater-delete">
                                                                <span>
                                                                  <i class="la la-trash-o"></i>
                                                                  <span>Delete</span>
                                                                </span>
                                                            </a>
                                                            <a data-repeater-create href="javascript:;"
                                                               class="btn-sm btn btn-primary m-btn m-btn--icon add-btn">
                                                              <span>
                                                                <i class="la la-plus"></i>
                                                                <span>Add</span>
                                                              </span>
                                                            </a>
                                                        </div>
                                                        <!-- end : buttons -->
                                                    </div>
                                                </div>
                                                <!-- end : Qualifications & Experience  -->

                                                <!-- starts : Subjects you teach -->
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                        <span class="text-primary">*</span>
                                                        Subjects you teach
                                                        <span class="m-badge m-badge--brand m-badge--wide info-badge"
                                                              data-toggle="m-popover" data-html="true"
                                                              data-placement="bottom"
                                                              data-content="We want to help you share your knowledge. The more subjects you tick the busier you will be. If you enjoy teaching then all your skills can be shared at some level. From Computer programming, to Bollywood dancing, to Script writing. Teachers invariably have multiple skills. So broaden your teaching horizons and showcase all you can do – even the unexpected. ">i</span>
                                                    </label>
                                                    <div class="col-xl-8 col-lg-8 choose-subjects">
                                                        <!--begin: Dropdown-->
                                                        <!--begin: Dropdown-->
                                                        <div class="m-dropdown m-dropdown--arrow c-dd-menu"
                                                             m-dropdown-toggle="click">
                                                            <a href="javascript:void(0)" id="subjects-placeholder"
                                                               class="m-dropdown__toggle btn dropdown-toggle">
                                                                {{  $subjects ? implode(', ', $subjects) : 'Choose the subjects you teach' }}
                                                            </a>
                                                            <div class="m-dropdown__wrapper">
                                                                <div
                                                                    class="m-dropdown__inner taughtSubjects multiple-select">
                                                                    <div class="m-dropdown__body">
                                                                        <div class="m-dropdown__content">
                                                                            <div class="m-scrollable"
                                                                                 data-scrollable="true"
                                                                                 data-max-height="400">
                                                                                <!-- starts, list options -->
                                                                                @include('educator.includes.category-select',
                                                                                [
                                                                                'name' => 'categories[]',
                                                                                'type' => 'checkbox',
                                                                                'subjects' => optional(Auth::user()->categories())->pluck('id')->toArray(),
                                                                                ])
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--end: Dropdown-->
                                                    </div>
                                                </div>
                                                <!-- end : Subjects you teach -->

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                        <span class="text-primary">*</span>
                                                        Price/hr
                                                    </label>
                                                    <div class="col-xl-8 col-lg-8">
                                                        <div class="input-group m-input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">€</span>
                                                            </div>
                                                            {!! Form::number('base_price', null, ['required' => 'required', 'placeholder' => 'E.g. 50', 'class' => 'form-control m-input', 'min' => 1, 'step' => 1]) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <img src="/img/logo/powered-by-zoom.png" alt="powered by zoom" height="20px" />

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-12 col-lg-12 col-form-label">
                                                        <span class="text-primary">*</span>
                                                        Available preferences<br>
                                                        <small>Tick the boxes in the chart that suits your
                                                            availability
                                                        </small>
                                                    </label>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <div class="col-xl-12 col-lg-12">
                                                        <table class="availability-calendar"
                                                               style="width: 100%; text-align: center">
                                                            <thead>
                                                            <tr>
                                                                <th><strong>&nbsp;</strong></th>
                                                                <th><strong>Mon</strong></th>
                                                                <th><strong>Tue</strong></th>
                                                                <th><strong>Wed</strong></th>
                                                                <th><strong>Thu</strong></th>
                                                                <th><strong>Fri</strong></th>
                                                                <th><strong>Sat</strong></th>
                                                                <th><strong>Sun</strong></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td class="availability-time">
                                                                    <strong>Morning</strong><br>Pre 12
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['mon']['morning']) ? 'checked' : '' }}
                                                                               name="availability[mon][morning]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['tue']['morning']) ? 'checked' : '' }}
                                                                               name="availability[tue][morning]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['wed']['morning']) ? 'checked' : '' }}
                                                                               name="availability[wed][morning]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['thu']['morning']) ? 'checked' : '' }}
                                                                               name="availability[thu][morning]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['fri']['morning']) ? 'checked' : '' }}
                                                                               name="availability[fri][morning]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['sat']['morning']) ? 'checked' : '' }}
                                                                               name="availability[sat][morning]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['sun']['morning']) ? 'checked' : '' }}
                                                                               name="availability[sun][morning]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="availability-time"><strong>Afternoon</strong><br>12
                                                                    - 4pm
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['mon']['afternoon']) ? 'checked' : '' }}
                                                                               name="availability[mon][afternoon]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['tue']['afternoon']) ? 'checked' : '' }}
                                                                               name="availability[tue][afternoon]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['wed']['afternoon']) ? 'checked' : '' }}
                                                                               name="availability[wed][afternoon]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['thu']['afternoon']) ? 'checked' : '' }}
                                                                               name="availability[thu][afternoon]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['fri']['afternoon']) ? 'checked' : '' }}
                                                                               name="availability[fri][afternoon]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['sat']['afternoon']) ? 'checked' : '' }}
                                                                               name="availability[sat][afternoon]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['sun']['afternoon']) ? 'checked' : '' }}
                                                                               name="availability[sun][afternoon]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="availability-time">
                                                                    <strong>Evening</strong><br>4 - 7pm
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['mon']['evening']) ? 'checked' : '' }}
                                                                               name="availability[mon][evening]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['tue']['evening']) ? 'checked' : '' }}
                                                                               name="availability[tue][evening]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['wed']['evening']) ? 'checked' : '' }}
                                                                               name="availability[wed][evening]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['thu']['evening']) ? 'checked' : '' }}
                                                                               name="availability[thu][evening]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['fri']['evening']) ? 'checked' : '' }}
                                                                               name="availability[fri][evening]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['sat']['evening']) ? 'checked' : '' }}
                                                                               name="availability[sat][evening]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['sun']['evening']) ? 'checked' : '' }}
                                                                               name="availability[sun][evening]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="availability-time"><strong>Late</strong><br>7
                                                                    - 10pm
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['mon']['late']) ? 'checked' : '' }}
                                                                               name="availability[mon][late]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['tue']['late']) ? 'checked' : '' }}
                                                                               name="availability[tue][late]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['wed']['late']) ? 'checked' : '' }}
                                                                               name="availability[wed][late]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['thu']['late']) ? 'checked' : '' }}
                                                                               name="availability[thu][late]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['fri']['late']) ? 'checked' : '' }}
                                                                               name="availability[fri][late]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['sat']['late']) ? 'checked' : '' }}
                                                                               name="availability[sat][late]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox"
                                                                               {{ Auth::user()->educator && isset(Auth::user()->educator->availability['sun']['late']) ? 'checked' : '' }}
                                                                               name="availability[sun][late]">
                                                                        <span class="availability-check"></span>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <!-- starts : Areas you cover -->
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                        <span class="text-primary">*</span>
                                                        Areas you cover
                                                        <span
                                                            class="m-badge m-badge--brand m-badge--wide info-badge"
                                                            data-toggle="m-popover" data-html="true"
                                                            data-placement="bottom"
                                                            data-content="Don’t restrict yourself – if you can click multiple locations. Your clients will live all over the city so start a conversation and fine tune details as you go along">i</span>
                                                    </label>
                                                    <div class="col-xl-8 col-lg-8 area-dropdown" id="area-dropdown">
                                                        {!! Form::select('areas[]', \App\Area::where('type', 'location')->pluck('address', 'id'),
                                                        optional(Auth::user())->areas()->pluck('area_id')->toArray(),
                                                        ['title' => 'Choose the areas you cover', 'required' => 'required', 'multiple' => 'true',
                                                        'class' => 'form-control form-control--fixed m-bootstrap-select m_selectpicker',
                                                         'data-dropup-auto' => 'false', 'size' => 'false', 'required' => 'required']) !!}
                                                    </div>
                                                </div>
                                                <!-- end : Areas you cover -->

                                                <!-- starts: References row -->
                                            {{--<div class="form-group m-form__group row photo-bio references">

                                                <label class="col-form-label col-lg-4">
                                                    <span class="text-primary">*</span>
                                                    References:
                                                    <span class="m-badge m-badge--wide info-badge"
                                                          data-toggle="m-popover" data-html="true"
                                                          data-placement="bottom"
                                                          data-content="Simply add two references with contact details that you may have, if you are new to tutoring then character references will do">i</span>
                                                </label>

                                                <div class="col-lg-8">
                                                    <div class="row">

                                                        <div class="col-lg-6">
                                                            <div class="m-dropzone dropzone"
                                                                 action="{{ route('upload.image', 'references') }}"
                                                                 id="dropzone-ref1">
                                                                @if(optional($educator)->references && isset($educator->references[0]))
                                                                    <div
                                                                        class="dz-preview dz-processing dz-image-preview dz-complete photo-ref-container1">
                                                                        <div class="dz-image">
                                                                            <img style="height: 120px"
                                                                                 src="{{ \App\Helpers\ClassHubHelper::getImagePath(null, $educator->references[0]) }}"
                                                                                 data-dz-thumbnail=""/>
                                                                            <div class="file-placeholder">
                                                                                <i class="fa fa-file-text"></i>
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
                                                                                     href="{{ \App\Helpers\ClassHubHelper::getImagePath(null, $educator->references[0]) }}">View File</a>
                                                                                </span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="dz-progress">
                                                                              <span class="dz-upload"
                                                                                    data-dz-uploadprogress=""
                                                                                    style="width: 100%;">

                                                                            </span>
                                                                        </div>
                                                                        <a class="dz-remove remove-photo"
                                                                           href="javascript:;"
                                                                           onclick="$(this).parents('.photo-ref-container1').remove()">Remove
                                                                            File</a>
                                                                        <input name="references[]"
                                                                               value="{{ $educator->references[0] }}"
                                                                               type="hidden">
                                                                    </div>
                                                                @else
                                                                    <div
                                                                        class="m-dropzone__msg dz-message needsclick">
                                                                        <div class="m-dropzone__msg-title">Drop your
                                                                            first references file
                                                                            here or click to upload.
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class="m-dropzone dropzone"
                                                                 action="{{ route('upload.image', 'references') }}"
                                                                 id="dropzone-ref2">
                                                                @if(optional($educator)->references && isset($educator->references[1]))
                                                                    <div
                                                                        class="dz-preview dz-processing dz-image-preview dz-complete photo-ref-container2">
                                                                        <div class="dz-image">
                                                                            <img style="height: 120px"
                                                                                 src="{{ \App\Helpers\ClassHubHelper::getImagePath(null, $educator->references[1]) }}"
                                                                                 data-dz-thumbnail=""/>
                                                                            <div class="file-placeholder">
                                                                                <i class="fa fa-file-text"></i>
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
                                                                                   href="{{ \App\Helpers\ClassHubHelper::getImagePath(null, $educator->references[1]) }}">View Photo</a>
                                                                              </span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="dz-progress">
                                                                            <span class="dz-upload"
                                                                                  data-dz-uploadprogress=""
                                                                                  style="width: 100%;">

                                                                          </span>
                                                                        </div>
                                                                        <a class="dz-remove remove-photo"
                                                                           href="javascript:;"
                                                                           onclick="$(this).parents('.photo-ref-container2').remove()">Remove
                                                                            File</a>
                                                                        <input name="references[]"
                                                                               value="{{ $educator->references[1] }}"
                                                                               type="hidden">
                                                                    </div>
                                                                @else
                                                                    <div
                                                                        class="m-dropzone__msg dz-message needsclick">
                                                                        <div class="m-dropzone__msg-title">Drop
                                                                            second references file
                                                                            here or click to upload.
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>--}}
                                            <!-- end: References row -->

                                                <!-- starts: Profile Photo -->
                                                <div class="form-group m-form__group row">

                                                    <label class="col-form-label col-lg-4 col-sm-12">
                                                        <span class="text-primary">*</span>
                                                        Profile Photo:
                                                        <span class="m-badge m-badge--wide info-badge"
                                                              data-toggle="m-popover" data-html="true"
                                                              data-placement="bottom"
                                                              data-content="If you look friendly, trustworthy and professional, then people will be more likely to book you. So make sure your pic is properly lit, clear and recent. It doesn’t need to be professional (a selfie will do).  Just choose a neutral background, make sure you’re looking directly at the camera. And show the world how warm, likeable and competent you are.">i</span>
                                                    </label>

                                                    <div class="col-lg-8 col-md-12 col-sm-12">

                                                        <div class="m-dropzone dropzone"
                                                             action="{{ route('upload.image', 'photos') }}"
                                                             id="dropzone-one">
                                                            @if(optional($educator)->photo)

                                                                <div
                                                                    class="dz-preview dz-processing dz-image-preview dz-complete photo-container">
                                                                    <div class="dz-image">
                                                                        <img style="height: 120px"
                                                                             src="{{ \App\Helpers\ClassHubHelper::getImagePath(null, $educator->photo) }}"
                                                                             data-dz-thumbnail=""/>
                                                                        <div class="file-placeholder">
                                                                            <i class="fa fa-file-text"></i>
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

                                                                                 href="{{ \App\Helpers\ClassHubHelper::getImagePath(null, $educator->photo) }}">View Photo</a>
                                                                            </span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="dz-progress">
                                                                          <span class="dz-upload"
                                                                                data-dz-uploadprogress=""
                                                                                style="width: 100%;">

                                                                        </span>
                                                                    </div>
                                                                    <a class="dz-remove remove-photo"
                                                                       href="javascript:;"
                                                                       onclick="$(this).parents('.photo-container').remove()">Remove
                                                                        Photo</a>
                                                                    <input name="photo" value="{{ $educator->photo }}"
                                                                           type="hidden">
                                                                </div>

                                                            @else
                                                                <div class="m-dropzone__msg dz-message needsclick">
                                                                    <div class="m-dropzone__msg-title">Drag photo here
                                                                        or click to upload.
                                                                    </div>
                                                                </div>

                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- end: Profile Photo -->

                                                <!-- starts: Profile Photo -->
                                                <div class="form-group m-form__group row">

                                                    <label class="col-form-label col-lg-4 col-sm-12">
                                                        Video Intro:
                                                        <span class="m-badge m-badge--wide info-badge"
                                                              data-toggle="m-popover" data-html="true"
                                                              data-placement="bottom"
                                                              data-content="Tell the world who you are in 30 seconds or less. This video will appear on your profile and give you the opportunity to sell yourself.">i</span>
                                                    </label>

                                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                                        <div class="m-dropzone dropzone"
                                                            action="for_purpose_of_using_dropzone"
                                                            id="dropzone-video">
                                                            <div class="m-dropzone__msg dz-message needsclick">
                                                                @if(optional($educator)->intro_video)
                                                                    <h4>You already have a video</h4>
                                                                    {{ Form::hidden('intro_video', $educator->intro_video) }}
                                                                    <div class="dz-default dz-message">
                                                                        <span>Drop files here to upload</span>
                                                                    </div>
                                                                @else
                                                                    <h4>Drop a video file here</h4>
                                                                    <div class="m-dropzone__msg-title">
                                                                        Must be no more than 30 seconds long
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- end: Profile Video -->

                                                <!-- starts: Profile Bio -->
                                                <div class="form-group m-form__group row">

                                                    <label class="col-form-label col-lg-4 col-sm-12">
                                                        <span class="text-primary">*</span>
                                                        Profile Bio:
                                                        <span class="m-badge m-badge--wide info-badge"
                                                              data-toggle="m-popover" data-html="true"
                                                              data-placement="bottom"
                                                              data-content="Remember that a parent will have more than one choice. Keep your bio short and engaging. Think about it as a job application – you want them to click and make an enquiry so it’s not all about skills it’s equally about what it will be like for their children to work with you.">i</span>
                                                    </label>

                                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                                        <div class="m-typeahead">
                                                            {!! Form::textarea('bio', null, ['class' => 'form-control m-input',
                                                            'rows' => 3, 'placeholder' => 'Tell us a bit about you']) !!}
                                                            <span class="m-form__help">Max 500 characters</span>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- end: Profile Bio -->


                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Form Wizard Step 1-->


                                </div>
                                <!--end: Form Body -->
                            </div>
                        </div>
                        <!-- end: Profile information -->


                        <!-- starts: Code of Conduct & Child Protection Policies -->
                        <div class="m-portlet m-portlet--full-height payment-terms">
                            <!--begin: Form Wizard-->
                            <div class="m-wizard__form">
                                <!--
                                1) Use m-form--label-align-left class to alight the form input lables to the right
                                2) Use m-form--state class to highlight input control borders on form validation
                              -->
                                <!--begin: Form Body -->
                                <div class="m-portlet__body padding-mobile-none-lr">

                                    <div class="row">
                                        <div class="col-xl-10 offset-xl-1">
                                            <div class="m-form__section m-form__section--first">
                                                <!-- starts : row 1 -->
                                                <div class="form-group m-form__group row">
                                                    <div
                                                        class="col-xl-9 col-lg-9 col-xs-12 col-form-label terms-text p-b-0">
                                                        <div class="title">Classhub's Code of Ethics
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-9 col-lg-9 col-form-label terms-text">
                                                        <div class="sub-title">All providers must review and accept to
                                                            continue. <br class="hide-below-md">See <a
                                                                href="javascript:void(0);" data-toggle="modal"
                                                                data-target="#accept-declaration-policies">code of
                                                                ethics</a>?
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 text-right terms-toggle">
                                                        <span class="m-switch m-switch--danger m-switch--icon">
                                                          <label>
                                                            <input type="checkbox" name="code_ethics" required
                                                                   id="child-protection-terms">
                                                            <span></span>
                                                          </label>
                                                        </span>
                                                    </div>
                                                </div>
                                                <!-- end : row 1 -->
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!--end: Form Body-->
                            </div>
                            <!--end: Form Wizard-->
                        </div>
                        <!-- end: Code of Conduct & Child Protection Policies -->

                        <!-- starts : button preview profile -->
                        <div class="preview-profile">
                            <a class="btn btn-secondary shadow-v4 " href="javascript:void(0);"
                               id="preview-profile-btn"><span
                                    class="btn__text icon-preview">Preview Profile</span></a>
                        </div>
                        <!-- end : button preview profile -->

                        <!-- starts : save & continue -->
                        <div class="save-continue ">
                            <a href="javascript:;" class="btn btn-primary shadow-v4" id="submit-form">
                                <span class="btn__text icon-arrow-right">SAVE & CONTINUE</span></a>
                        </div>
                        <!-- end : save & continue -->


                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('educator.modals.trusted.crc-check')
    @include('educator.modals.trusted.see-benefits-verified-badge')
    @include('educator.modals.trusted.see-what-checking')
    @include('educator.modals.trusted.accept-declaration-policies')
    @include('educator.modals.complete-profile-payment')

@endsection

@section('page_scripts')

    <script src="{{ asset('educator/assets/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/moment.js') }}" type="text/javascript"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places&type=regions">
    </script>
    {{--<script src="{{ asset('js/dropzone.js') }}" type="text/javascript"></script>--}}
    <!-- starts : modal preview profile -->

    @include('common.type1-account-live')


    <div class="modal fade c-modal preview-profile-modal" id="preview-profile" tabindex="-1"
         role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered container p-0" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">
                        &times;
                      </span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <!-- starts: teacher profile -->

                    <!-- end: teacher profile -->
                </div>
            </div>
        </div>
    </div>

    {{--@if(!request('user_type') && !Auth::user()->educator)
        @include('educator.modals.tutor-type')
        <script type="text/javascript">
            $(function () {
                $('div#tutor-type').modal('show')
            })
        </script>
    @endif--}}

    <!-- end : modal preview profile -->
    <script type="text/javascript">
        var educator = parseInt({{ Auth::user()->educator ? 1 : 0 }});
        var profileFilledIn = false;
        var profileAjax = false;
        var redirectUrl = '{{ request()->redirect_url ?  request()->redirect_url : 'false'}}';
        var continueUrl = '{{ route('educator.dashboard') }}'
        var modalSubmit = $('div#step1_saveContinue');
        var accountLive = $('div#type1-account-live');
        var modalPreview = $('div#preview-profile');
        var selectedTeachingTypes = []
        var stripe = Stripe('{{ env('STRIPE_PUBLIC_KEY') }}')


        @if(Auth::user()->educator)
        @foreach(Auth::user()->educator->teaching_types as $type)
        selectedTeachingTypes.push('{{ $type }}')
        @endforeach
        @endif

        $(function () {
            $(".category-sub").click(function () {
                $(this).toggleClass('active');
            });
        });

        $(function () {

            $('#qualification-repeater').repeater({
                initEmpty: false,
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    // Not working
                    $(this).slideUp(deleteElement);
                },
                isFirstItemUndeletable: true
            })

            $('a.data-repeater-delete').on('click', function () {
                if ($('div.repeater-item-container > div').length !== 1)
                    $('div.repeater-item-container > div:last').remove()
            })

            $('select#student-select').on('change', function () {
                if ($(this).val() == 1) {
                    $('div.student-menu').css('display', 'block')
                } else {
                    $('div.student-menu').css('display', 'none')
                }
            })


            // Preview profile
            $('a#preview-profile-btn').on('click', function () {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('educator.profile.preview') }}',
                    data: $('form#profile-form').serialize(),
                    dataType: 'json',
                    success: function (data) {
                        if (data.status) {
                            $(modalPreview).find('div.modal-body')
                                .html(data.profile)
                            $(modalPreview).modal('show')

                        } else {
                            $(modalPreview).modal('hide')
                            $(resultModal).find('div.modal-body')
                                .html(data.messages.join('<br>'))
                            $(resultModal).modal('show')
                        }
                    },
                    error: function (data) {
                        $(modalPreview).modal('hide')
                        $(resultModal).find('div.modal-body')
                            .html(data.messages.join('<br>'))
                        $(resultModal).modal('show')
                    }
                })
            })

            $('body').on('click', 'a.read-more-btn', function () {
                $(this).siblings('.text-exposed-hide').hide();
                $(this).siblings('.text-exposed-show').show();
                $(this).hide();
            })

            // Submit form
            $('a#submit-form').on('click', function (e) {
                e.preventDefault()

                var _this = $(this)

                $(_this).prop('disabled', true)

                if (!$('input#child-protection-terms').is(':checked')) {
                    $(resultModal).modal('show')
                    $(resultModal).find('div.modal-body').html(`You have to agree Classhub’s Code of
                    Conduct & Child Protection Policies`)
                    $(_this).prop('disabled', false)

                } else {

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('educator.profile.store') }}',
                        data: $('form#profile-form').serialize(),
                        dataType: 'JSON',
                        success: function (data) {
                            if (data.status) {
                                $(_this).prop('disabled', false)
                                continueUrl = redirectUrl !== 'false' ? redirectUrl : data.redirect_url;

                                @if(!Auth::user()->educator)
                                $(accountLive).modal('show')
                                $(accountLive).find('a#account-live-continue').attr('href', continueUrl)
                                @else
                                $(resultModal).modal('show')
                                $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                                setTimeout(function () {
                                    window.location = redirectUrl !== 'false' ? redirectUrl : data.redirect_url

                                }, 3000)
                                @endif
                            } else {
                                $(_this).prop('disabled', false)
                                $(resultModal).modal('show')
                                $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                            }
                        },
                        error: function (data) {
                            $(_this).prop('disabled', false)
                            $(resultModal).modal('show')
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    })
                }

                return false
            })

            $(accountLive).on('hidden.bs.modal', function () {
                window.location = continueUrl
            })

            $('input[name="day"]').on('keyup', function () {
                var val = parseInt($(this).val())

                if (isNaN(val) && $(this).val() !== '') {
                    $(this).val(1)
                }

                if (val > 31) {
                    $(this).val(31)
                }

                leapYearAdjustment()
            })

            $('input[name="month"]').on('keyup', function () {
                var val = parseInt($(this).val())

                if (isNaN(val) && $(this).val() !== '') {
                    $(this).val(1)
                }

                if (val > 12) {
                    $(this).val(12)
                }

                leapYearAdjustment()
            })

            $('input[name="year"]').on('keyup', function () {

                if ($(this).val().length > 4) {
                    $(this).val($(this).val().substr(0, 4))
                }

                var year = parseInt('{{ date('Y') }}')
                var val = parseInt($(this).val())

                if (isNaN(val) && $(this).val() !== '') {
                    $(this).val(1900)
                }

                if (val > year && $(this).val().length == 4) {
                    $(this).val(year)
                }

                leapYearAdjustment()
            })

            $('input[name="year"]').on('blur', function () {
                var val = parseInt($(this).val())

                if (isNaN(val) && $(this).val() !== '') {
                    $(this).val(1900)
                }

                if (val < 1900) {
                    $(this).val(1900)
                }
            })

            function leapYearAdjustment() {
                var year = parseInt($('input[name="year"]').val())
                var month = parseInt($('input[name="month"]').val())
                var day = parseInt($('input[name="day"]').val())

                if (!isNaN(year)) {
                    if ((0 == year % 4) && (0 != year % 100) || (0 == year % 400)) {

                        if (!isNaN(day) && !isNaN(month) && month == 2 && day > 29) {
                            $('input[name="day"]').val(29)

                        }
                    } else {
                        if (!isNaN(day) && !isNaN(month) && month == 2 && day > 28) {
                            $('input[name="day"]').val(28)
                        }
                    }
                }
            }


            $('form#crc-form').on('submit', function (e) {
                e.preventDefault()

                $('div#crc-check').modal('hide')
                $(resultModal).modal('show')

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: 'JSON',
                    success: function (data) {
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

                return false
            })
        })

        // Video Uploading Features : Start
        function uploadVideo(fileInput, videoDuration) {

            console.log('Duration', parseInt(videoDuration))

            if (parseInt(videoDuration) > 3600) {
                $(fileInput).val('')
                $(resultModal).find('div.modal-body').html(`<div class="">Maximum duration of video should be 60mins</div>`)
                $(resultModal).modal('show')
                return false;
            }

            if (fileInput.size * 0.000001 > 512) {
                $(fileInput).val('')
                $(resultModal).find('div.modal-body').html(`<div class="">Maximum size of video should be 512MB</div>`)
                $(resultModal).modal('show')
                return false;
            }

            $(resultModal).find('div.modal-body').html(`<div class="">Uploading video, Please wait...</div>`)
            $(resultModal).modal('show')

            var formData = new FormData();
            var videoFile = fileInput
            formData.append('video', videoFile)
            formData.append('_token', '{{csrf_token()}}')
            if (parseInt(videoDuration) > 90) {
                formData.append('trim', 90)
            }

            $.ajax({
                url: '{{ route('vimeo.upload') }}',
                data: formData,
                type: 'POST',
                contentType: false,
                processData: false,
                timeout: 0,
                success: function (data) {
                    $(fileInput).val('')
                    if (data.status) {
                        $(resultModal).find('div.modal-body').html(`<div class="">${data.message}</div>`)

                        setTimeout(function () {
                            $(resultModal).modal('hide')
                            $('div#dropzone-video div.m-dropzone__msg').html(`
                                <div class="dz-filename"><span>${fileInput.name}</span></div>
                                <a class="dz-remove" href="javascript:;" onclick="removeVideo(this)" data-url="${data.delete_url}">Remove video</a>
                                <input type="hidden" name="intro_video" value="${data.id}">
                            `)
                        }, 2000)

                        autoSaveProfile()
                    } else {
                        $(resultModal).find('div.modal-body').html(`<div class="">${data.message}</div>`)
                    }
                },
                error: function (data) {
                    $(fileInput).val('')
                    $(resultModal).find('div.modal-body').html(`<div class="">${data.message}</div>`)
                }
            });
        }

        function checkVideoDuration(fileInput) {
            window.URL = window.URL || window.webkitURL;
            var video = document.createElement('video');
            video.preload = 'metadata'

            video.onloadedmetadata = function () {
                window.URL.revokeObjectURL(video.src)
                uploadVideo(fileInput, video.duration)
            }

            video.src = URL.createObjectURL(fileInput)
        }

        function removeVideo(element) {
            $(element).parent('div.m-dropzone__msg').html(`
                <h4>Drop a video file here</h4>
                <div class="m-dropzone__msg-title">
                    Must be no more than 30 seconds long
                </div>
            `)
        }
        // Video Uploading Features : End

        Dropzone.options.dropzoneOne = {
            addRemoveLinks: true,
            maxFiles: 1,
            acceptedFiles: 'image/*',
            removedfile: function (file) {
                var route = '{{ route('home') }}' + '/image/' + file.id + '/delete'

                $.ajax({
                    type: 'DELETE',
                    url: route,
                    data: {_token: '{{ csrf_token() }}'},
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                    },
                    error: function (data) {
                        console.log(data)
                    }
                });

                var _ref;
                return (_ref = file.previewElement) != null ?
                    _ref.parentNode.removeChild(file.previewElement) : void 0;
            },
            success: function (file, done) {
                if (done.error) {
                    alert(done.error)
                } else {
                    let formInput = Dropzone.createElement('<input type="hidden"  name="photo"  ' +
                        'value="' + done.id + '">');
                    file.previewElement.appendChild(formInput);
                    file.id = done.id;
                    file.path = done.path;
                }

                autoSaveProfile()
            },
        }

        Dropzone.options.dropzoneVideo = {
            autoProcessQueue: false,
            addRemoveLinks: true,
            maxFiles: 1,
            acceptedFiles: 'video/*',
            dictRemoveFile: 'Remove Video',
            addedfile: function (file) {
                checkVideoDuration(file)
            }
        }

        Dropzone.options.dropzoneRef1 = {
            addRemoveLinks: true,
            dictRemoveFile: 'Remove File',
            maxFiles: 1,
            removedfile: function (file) {
                var route = '{{ route('home') }}' + '/image/' + file.id + '/delete'

                $.ajax({
                    type: 'DELETE',
                    url: route,
                    data: {_token: '{{ csrf_token() }}'},
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                    },
                    error: function (data) {
                        console.log(data)
                    }
                });

                var _ref;
                return (_ref = file.previewElement) != null ?
                    _ref.parentNode.removeChild(file.previewElement) : void 0;
            },
            success: function (file, done) {
                if (done.error) {
                    alert(done.error)
                } else {
                    let formInput = Dropzone.createElement('<input type="hidden"  name="references[]"  ' +
                        'value="' + done.id + '">');
                    file.previewElement.appendChild(formInput);
                    file.id = done.id;
                    file.path = done.path;
                }
            },
        }

        Dropzone.options.dropzoneRef2 = {
            addRemoveLinks: true,
            dictRemoveFile: 'Remove File',
            maxFiles: 1,
            removedfile: function (file) {
                var route = '{{ route('home') }}' + '/image/' + file.id + '/delete'

                $.ajax({
                    type: 'DELETE',
                    url: route,
                    data: {_token: '{{ csrf_token() }}'},
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                    },
                    error: function (data) {
                        console.log(data)
                    }
                });

                var _ref;
                return (_ref = file.previewElement) != null ?
                    _ref.parentNode.removeChild(file.previewElement) : void 0;
            },
            success: function (file, done) {
                if (done.error) {
                    alert(done.error)
                } else {
                    let formInput = Dropzone.createElement('<input type="hidden"  name="references[]"  ' +
                        'value="' + done.id + '">');
                    file.previewElement.appendChild(formInput);
                    file.id = done.id;
                    file.path = done.path;
                }
            },
        }


        $('div.teaching-type-select div.category-select li.parent-category').on('click', function (e) {

            if ($(this).find('input').val() == 'Other') {
                if (!$(this).hasClass('active')) {
                    $(this).addClass('active')
                    $(this).find('input[type=checkbox]').prop('checked', true)
                    $(this).find('span.other').html(`<input type="text" class="other-input form-control"
                        placeholder="Enter your teaching type here" name="teaching_types[]"/>`)
                    $('input.other-input').focus()
                } else {

                }
            } else {
                $(this).toggleClass('active')
                let name = $(this).data('name')
                if ($(this).hasClass('active')) {
                    if (selectedTeachingTypes.indexOf(name) === -1) {
                        selectedTeachingTypes.push(name)
                    }
                    $(this).find('input').prop('checked', true)
                } else {
                    selectedTeachingTypes = selectedTeachingTypes.filter(item => {
                        return item !== name
                    })
                    $(this).find('input').prop('checked', false)
                }
            }

            if (selectedTeachingTypes.length) {
                $('a#teaching-types-placeholder').html(selectedTeachingTypes.join(', '))
            } else {
                $('a#teaching-types-placeholder').html('Choose your teaching type')
            }

            console.log(selectedTeachingTypes)

            autoSaveProfile()

        })

        $('body').on('keyup', 'input.other-input', function (e) {
            parent = $(this).parents('li.parent-category');
            if (!$(this).val().length) {
                $(parent).removeClass('active')
                $(parent).find('span.other').html('Other')
                $(parent).find('input[type=checkbox]').val('Other').prop('checked', false)

                if (selectedTeachingTypes.length) {
                    $('a#teaching-types-placeholder').html(selectedTeachingTypes.join(', '))
                } else {
                    $('a#teaching-types-placeholder').html('Choose your teaching type')
                }
            } else {

                //if (e.keyCode == 13 || e.which == 13) {
                $('a#teaching-types-placeholder').html(selectedTeachingTypes.join(', '))
                $('a#teaching-types-placeholder').append(', ' + $(this).val())
                //}

                $(parent).addClass('active')
                $(parent).find('input[type=checkbox]').val($(this).val()).prop('checked', false)
            }
            console.log(selectedTeachingTypes)

            autoSaveProfile()
        })

        $('div#area-dropdown > select').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
            if (clickedIndex == 0 && isSelected) {
                console.log(clickedIndex)
                //$(this).selectpicker('selectAll')
                //$(this).selectpicker('toggle')
                //$('div#area-dropdown > div').removeClass('show')
                //$('div#area-dropdown  div.dropdown-menu').removeClass('show')
            }

            if (clickedIndex == 0 && !isSelected) {
                $(this).selectpicker('deselectAll')
            }

            autoSaveProfile()
        })

        function initAutoCompleteFields() {
            var autocompletes = []

            $('input.postal-code-ac').each(function (index) {
                let input = document.getElementById($(this).attr('id'))
                let autocomplete = new google.maps.places.Autocomplete(input)
                autocomplete.inputId = $(this).attr('id')
                autocomplete.setComponentRestrictions({'country': ['ie']})
                autocomplete.addListener('place_changed', placeChanged)
                autocompletes.push(autocomplete)
            })
        }

        initAutoCompleteFields();

        function placeChanged() {

            let addressField = $(`input#${this.inputId}`)

            place = this.getPlace()

            console.log(place.address_components);

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

        function pushDataLayer() {
            qe = 0;
            $('div.repeater-item-container input').each(function () {
                if ($(this).val()) {
                    qe = 1;
                }
            })

            window.dataLayer.push({
                event: 'list_class_step_1',
                formLocation: 'List class step 1',
                formName: 'Profile Setup Form',
                teachingType: $('a#teaching-types-placeholder').html().trim(),
                qualificationAndExperience: qe,
                subjectTeach: $('a#subjects-placeholder').html().trim(),
                areasCover: $('div#area-dropdown div.filter-option-inner').html().trim()
            })
        }

        // We might get rid of these custom codes later
        // Custom Code Start
        // var maths_ids = {!! json_encode( \App\Category::getSubCategoryIdsFromName('Maths') ) !!}

        // $('div.taughtSubjects div.category-select li.category-sub').on('click', function (e) {
        //     if ($(this).children('input').prop('checked')) {
        //         let category_id = $(this).children('input').val();

        //         if (maths_ids.includes(category_id)) {
        //             var categoryName = $(this).children('input').data('category-name')

        //             subjectTeaches = subjectTeaches.filter(item => item !== categoryName)
        //             $('a#subjects-placeholder').html(subjectTeaches.join(', '))
        //             $(this).addClass('active') //If we add 'active' class here the bootstrap removes it later
        //                                         // so the item remains inactivated
        //                                         // so funny
        //             $(this).children('input').prop('checked', false)

        //             $(resultModal).modal('show')
        //             $(resultModal).find('div.modal-body').html(`<div class="text-left px-3 pb-4">
        //                 <p>Due to the high signup rate in Maths tutors.
        //                 Classhub are not currently accepting new Maths tutors on to the platform.</p>

        //                 <p>This is to give every tutor a fair  chance at being
        //                 selected from the results given when a user
        //                 searches for Maths.</p>

        //                 <p>We will inform you via email as soon as a Maths
        //                 position becomes available.</p></div>`)

        //             $.ajax({
        //                 type: 'POST',
        //                 url: '{{ route('educator.backlog.add') }}',
        //                 data: {
        //                     _token: '{{ csrf_token() }}',
        //                     educator_id: '{{ Auth::user()->id }}',
        //                     category_id
        //                 },
        //                 dataType: 'json',
        //                 success: function (data) {
        //                     console.log(data)
        //                 },
        //                 error: function (data) {
        //                     console.log(data)
        //                 }
        //             });
        //         }
        //     }
        // })
        // Custom Code End

    </script>

    <script type="text/javascript">

        $(function () {

            var errorMessage = 'You need to complete your profile information in order to be set up as a tutor.' +
                ' Do you want to exit the tutor setup process?';

            var link = '{{ route('home') }}'

            $('body').on('keyup change', 'form#profile-form input, form#profile-form textarea, form#profile-form select,' +
                'form#profile-form file, input#child-protection-terms',

                function () {

                    autoSaveProfile();
                })

            $('body').on('click ', 'div.m-brand__logo a, div#m_header_menu li.m-menu__item a, ' +
                'div.m-dropdown__wrapper li.m-nav__item a:not(".logout")', function () {

                if (!educator && !profileFilledIn) {
                    $('div#complete-profile-payment div.modal-body').html(`
                                <p>${errorMessage}</p>
                                <p><a href="${link}">YES</a></p>
                                <p><a href="javascript:;" data-dismiss="modal">NO</a></p>
                            `)

                    $('div#complete-profile-payment').modal('show')

                    return false;
                } else {
                    return true;
                }
            })
        })


        function autoSaveProfile() {
            if (profileAjax && profileAjax.readyState != 4) {
                profileAjax.abort()
            }
            // Autosave profile
            profileAjax = $.ajax({
                type: 'POST',
                url: '{{ route('post.validate.profile') }}',
                data: $('form#profile-form').serialize(),
                dataType: 'json',
                success: function (data) {

                    if (data.status) {
                        profileFilledIn = true;
                        educator = true;
                    } else {
                        profileFilledIn = false;
                        errorMessage = 'You need to complete your profile information in order to be set up as a tutor.' +
                            ' Do you want to exit the tutor setup process?'
                        link = '{{ route('home') }}'
                    }

                    console.log(data)
                },
                error: function (data) {
                    console.log(data)
                }
            });
        }

    </script>
@endsection
