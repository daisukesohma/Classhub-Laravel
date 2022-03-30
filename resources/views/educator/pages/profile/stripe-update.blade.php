@extends('educator.layouts.master')

@section('title')
    Classhub | Update Payout Details
@endsection

@section('page_styles')
    <style type="text/css">
        .repeater-item {
            display: block;
            padding: 20px 0;
            border-bottom: 1px solid;
        }

        .address-field {
            margin-bottom: 15px !important;
        }

        .person-address {
            margin-bottom: 15px !important;
        }

        .list-a-class .bootstrap-select > .dropdown-toggle {
            padding-left: 0;
        }
    </style>
@endsection

@section('content')

    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body list-a-class">
        <!-- BEGIN: Left Aside -->
        <!-- END: Left Aside -->
        <div class="m-grid__item m-grid__item--fluid m-wrapper step3 list-a-class">
            <div class="row col-12">
                {{--<div class="col-lg-2 col-md-2"></div>--}}
                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12" style="margin: 0 auto">
                    <div class="m-content signup-form">

                        <!--Begin::Section-->
                        <div class="m-portlet m-portlet--full-height steps shadow-v1">
                            <!--begin: Portlet Head-->
                            <div class="m-portlet__head shadow-v1">
                                <div class="m-portlet__head-caption">
                                    <div class="title">Update Stripe Account</div>
                                </div>
                            </div>
                            <!--end: Portlet Head-->

                            <div class="requirments">
                                @if(count($requirements))
                                    <div class="alert alert-danger" style="border-radius: 0">Please update the following
                                        details
                                    </div>
                                    <ul style="list-style: disc;padding-left: 40px;">
                                        @foreach($requirements as $requirement)
                                            <li>{{ $requirement }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                        </div>
                        <!--end: Form Wizard Head -->

                        <!--begin: Payout Details Form-->
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                <h3 class="m-form__heading-title">Payout Details</h3>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-6">
                                <img class="stripe-logo-add"
                                     src="/img/stripe-logos/solid-dark/powered_by_stripe@3x.png"
                                     alt="powered by stripe badge"/>
                            </div>
                        </div>
                        {!! Form::open(['url' => route('educator.stripe-account.update'), 'enctype' => 'multipart/form-data',
                            'method' => 'post', 'class' => 'm-form m-form--label-align-left- m-form--state- payout-details',
                            'id' => 'stripe-form', 'autocomplete' => 'off']) !!}
                        <div class="m-portlet m-portlet--full-height">
                            <div class="m-wizard__form">
                                <!--
                                1) Use m-form--label-align-left class to alight the form input lables to the right
                                2) Use m-form--state class to highlight input control borders on form validation
                                -->
                                <!--begin: Form Body -->
                                <div class="m-portlet__body">
                                    <!--begin: Form Wizard Step 1-->
                                    <div class="row">
                                        <div class="col-xl-10 offset-xl-1 padding-mobile-none-lr">
                                            <div class="m-form__section m-form__section--first">
                                                {{--<div class="form-group m-form__group row">
                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                        <span class="text-primary">*</span>Account Type:
                                                    </label>
                                                    <div class="col-xl-8 col-lg-8">
                                                        {!! Form::select('account_type', \App\Educator::TYPES, $stripeAccount->business_type ,
                                                            [ 'title' => 'Individual or Business','required' => 'required', 'readonly' => 'readonly',
                                                            'class' => 'form-control m-bootstrap-select m_selectpicker']) !!}
                                                    </div>
                                                </div>--}}

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                        <span class="text-primary">*</span>Account Holder Name:
                                                    </label>
                                                    <div class="col-xl-8 col-lg-8">
                                                        {!! Form::text('account_holder_name', $stripeAccount->external_accounts->data[0]->account_holder_name ,
                                                            ['placeholder' => 'Account Holder Name', 'required' => 'required',
                                                            'class' => 'form-control m-input']) !!}
                                                    </div>
                                                </div>

                                                @if($stripeAccount->business_type == 'company' && in_array('company.phone', $stripeAccount->requirements->currently_due))
                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                            <span class="text-primary">*</span>Phone Number:
                                                        </label>
                                                        <div class="col-xl-3 col-lg-3">
                                                            {!! Form::select('country_code', \App\Setting::COUNTRY_CODES, '+353',
                                                                [ 'title' => 'Country Code','required' => 'required',
                                                                'class' => 'form-control m-input', 'size']) !!}
                                                        </div>
                                                        <div class="col-xl-5 col-lg-5">
                                                            {!! Form::text('business_phone_no', null,
                                                                ['placeholder' => 'E.g. 871234567', 'required' => 'required',
                                                                'class' => 'form-control m-input']) !!}
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                        <span class="text-primary">*</span>Country :
                                                    </label>
                                                    <div class="col-xl-8 col-lg-8">
                                                        {!! Form::select('country', \App\Educator::COUNTRIES, $stripeAccount->country,
                                                            [ 'title' => 'Country','required' => 'required',
                                                            'class' => 'form-control no-zindex m-bootstrap-select m_selectpicker']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                        <span class="text-primary">*</span>Currency:
                                                    </label>
                                                    <div class="col-xl-8 col-lg-8">
                                                        {!! Form::select('currency', \App\Educator::CURRENCIES, strtoupper($stripeAccount->default_currency),
                                                            [ 'title' => 'Currency','required' => 'required',
                                                            'class' => 'form-control no-zindex m-bootstrap-select m_selectpicker']) !!}
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                        <span class="text-primary">*</span>Industry:
                                                    </label>
                                                    <div class="col-xl-8 col-lg-8">
                                                        {!! Form::select('industry', \App\Setting::STRIPE_MCC, $stripeAccount->business_profile->mcc ? $stripeAccount->business_profile->mcc :  '8299',
                                                            [ 'title' => 'Industry','required' => 'required',
                                                            'class' => 'form-control no-zindex m-bootstrap-select m_selectpicker']) !!}
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" value="{{ $stripeAccount->business_type }}"
                                           name="account_type">

                                    <!--end: Form Wizard Step 1-->
                                </div>
                                <!--end: Form Body -->
                            </div>
                        </div>

                        @if($stripeAccount->business_type == 'individual' )
                            <div id="person-ajax-result">
                                <div class="individual-form">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                            <h3 class="m-form__heading-title">Person Details</h3>
                                        </div>
                                        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-6">
                                            <img class="stripe-logo-add"
                                                 src="/img/stripe-logos/solid-dark/powered_by_stripe@3x.png"
                                                 alt="powered by stripe badge"/>
                                        </div>
                                    </div>

                                    <div class="m-portlet m-portlet--full-height">
                                        <div
                                            class="col-lg-12  m-wizard__form padding-mobile-none-lr">
                                            <!--
                                            1) Use m-form--label-align-left class to alight the form input lables to the right
                                            2) Use m-form--state class to highlight input control borders on form validation
                                            -->
                                            <!--begin: Form Body -->
                                            <div class="m-portlet__body">
                                                <!--begin: Form Wizard Step 1-->
                                                <div class="row">
                                                    <div class="col-xl-10 offset-xl-1 padding-mobile-none-lr">
                                                        <div class="m-form__section m-form__section--first">

                                                            <div class="form-group m-form__group row">
                                                                <label class="col-xl-4 col-lg-4 col-form-label">
                                                                    <span class="text-primary">*</span>First Name:
                                                                </label>
                                                                <div class="col-xl-8 col-lg-8">
                                                                    {!! Form::text('first_name', $stripeAccount->individual->first_name,
                                                                        ['placeholder' => 'First Name', 'required' => 'required',
                                                                        'class' => 'form-control m-input']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-form__group row">
                                                                <label class="col-xl-4 col-lg-4 col-form-label">
                                                                    <span class="text-primary">*</span>Last Name:
                                                                </label>
                                                                <div class="col-xl-8 col-lg-8">
                                                                    {!! Form::text('last_name', $stripeAccount->individual->last_name,
                                                                        ['placeholder' => 'Last Name', 'required' => 'required',
                                                                        'class' => 'form-control m-input']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-form__group row">
                                                                <label class="col-xl-4 col-lg-4 col-form-label">
                                                                    <span class="text-primary">*</span>Email:
                                                                </label>
                                                                <div class="col-xl-8 col-lg-8">
                                                                    {!! Form::email('email', $stripeAccount->individual->email,
                                                                        ['placeholder' => 'Email', 'required' => 'required',
                                                                        'class' => 'form-control m-input']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-form__group row">
                                                                <label class="col-xl-4 col-lg-4 col-form-label">
                                                                    <span class="text-primary">*</span>DOB:
                                                                </label>
                                                                <div class="col-xl-2 col-lg-2 ">
                                                                    <div class="select-option">
                                                                        <i class="ti-angle-down"></i>
                                                                        <select title="Date" name="day" required>
                                                                            <option
                                                                                value="">
                                                                                Day
                                                                            </option>
                                                                            @for($i = 1; $i <= 31; $i++)
                                                                                <option
                                                                                    {{ $stripeAccount->individual->dob->day == $i ? 'selected' : '' }}
                                                                                    value="{{ $i }}">{{ $i < 10 ? '0'.$i : $i }}
                                                                                </option>
                                                                            @endfor

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-3 col-lg-3">
                                                                    <div class="select-option">
                                                                        <i class="ti-angle-down"></i>
                                                                        <select title="Month" name="month" required>
                                                                            <option
                                                                                value="" {{ !Auth::user()->educator->dob ? 'selected' : '' }}>
                                                                                Month
                                                                            </option>
                                                                            @for($m = 1; $m <= 12; $m++)
                                                                                <option
                                                                                    value="{{ $m < 10 ? '0'.$m : $m }}"
                                                                                    {{ $stripeAccount->individual->dob->month == $m ? 'selected' : ''  }}>
                                                                                    {{ $m < 10 ? '0'.$m : $m }}
                                                                                </option>
                                                                            @endfor
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-3 col-lg-3">
                                                                    <div class="select-option">
                                                                        <i class="ti-angle-down"></i>
                                                                        <select title="Year" name="year" required>
                                                                            <option
                                                                                value="" {{ !Auth::user()->educator->dob ? 'selected' : '' }}>
                                                                                Year
                                                                            </option>
                                                                            @for($y = date('Y'); $y >= 1900; $y--)
                                                                                <option value="{{ $y }}"
                                                                                    {{ $stripeAccount->individual->dob->year == $y ? 'selected' : '' }}>
                                                                                    {{ $y }}</option>
                                                                            @endfor
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-form__group row">
                                                                <label class="col-xl-4 col-lg-4 col-form-label">
                                                                    <span class="text-primary">*</span>Address:
                                                                </label>
                                                                <div class="col-xl-8 col-lg-8">
                                                                    <input type="text" name="line1"
                                                                           value="{{ $stripeAccount->individual->address->line1 }}"
                                                                           placeholder="Address Line 1"
                                                                           class="form-control m-input address-field"
                                                                           required>
                                                                    <input type="text" name="line2"
                                                                           value="{{ $stripeAccount->individual->address->line2 }}"
                                                                           placeholder="Addresss Line 2"
                                                                           class="form-control m-input address-field"
                                                                           required>
                                                                    <input type="text" name="city"
                                                                           value="{{ $stripeAccount->individual->address->city }}"
                                                                           placeholder="City"
                                                                           class="form-control m-input address-field"
                                                                           required>
                                                                    <input type="text" name="state"
                                                                           value="{{ $stripeAccount->individual->address->state }}"
                                                                           placeholder="County"
                                                                           class="form-control m-input address-field"
                                                                           required>
                                                                    <input type="text" name="postal_code"
                                                                           value="{{ $stripeAccount->individual->address->postal_code }}"
                                                                           id="individual-person-postal-code"
                                                                           placeholder="Eircode"
                                                                           class="form-control m-input address-field  postal-code-ac"
                                                                           required>
                                                                    <label>Don't know your Eircode? Click <a
                                                                            href="https://finder.eircode.ie/#/"
                                                                            target="_blank">here</a></label>
                                                                </div>
                                                            </div>

                                                            <div class="form-group m-form__group row">
                                                                <div class="col-12">
                                                                    ID Verification (Passport or Drivers License)
                                                                </div>
                                                            </div>

                                                            <div class="form-group m-form__group row">
                                                                <label class="col-xl-4 col-lg-4 col-form-label">
                                                                    Front Photo ID:
                                                                    <span class="m-badge m-badge--wide info-badge"
                                                                          data-toggle="m-popover" data-html="true"
                                                                          data-placement="bottom"
                                                                          data-content="
                                                                          <strong>Proof of Identity document requirements:</strong>
                                                                            <ul>
                                                                            <li>Documents must be uploaded in full color (i.e. no black-and-white scans)</li>
                                                                            <li>Documents must be clear and large enough to read</li>
                                                                            <li>Photocopies of identity documents are not acceptable</li>
                                                                            <li>Documents must be valid and not expired</li>
                                                                            <li>Complete documents must be uploaded. A complete document is defined as:
                                                                            <ul>
                                                                            <li>Both front and back of a driver’s license or identity card</li>
                                                                            <li>The entire personal information page of a passport</li>
                                                                            </ul>
                                                                            </ul>
                                                                        ">i</span>

                                                                </label>
                                                                <div class="col-xl-8 col-lg-8">
                                                                    {!! Form::file('front_photo',
                                                                        ['placeholder' => '',
                                                                          'class' => 'form-control m-input photoId', 'accept' => 'image/png, image/jpeg, image/jpg']) !!}
                                                                </div>

                                                                <label class="col-xl-4 col-lg-4 col-form-label">
                                                                    Back Photo ID:
                                                                    <span class="m-badge m-badge--wide info-badge"
                                                                          data-toggle="m-popover" data-html="true"
                                                                          data-placement="bottom"
                                                                          data-content="
                                                                          <strong>Proof of Identity document requirements:</strong>
                                                                            <ul>
                                                                            <li>Documents must be uploaded in full color (i.e. no black-and-white scans)</li>
                                                                            <li>Documents must be clear and large enough to read</li>
                                                                            <li>Photocopies of identity documents are not acceptable</li>
                                                                            <li>Documents must be valid and not expired</li>
                                                                            <li>Complete documents must be uploaded. A complete document is defined as:
                                                                            <ul>
                                                                            <li>Both front and back of a driver’s license or identity card</li>
                                                                            <li>The entire personal information page of a passport</li>
                                                                            </ul>
                                                                            </ul>
                                                                        ">i</span>
                                                                </label>
                                                                <div class="col-xl-8 col-lg-8">
                                                                    {!! Form::file('back_photo',
                                                                        ['placeholder' => '',
                                                                          'class' => 'form-control m-input photoId',
                                                                          'size' => '80', 'accept' => 'image/png, image/jpeg, image/jpg']) !!}
                                                                </div>
                                                            </div>

                                                            @if(in_array('verification.additional_document', $stripeAccount->individual->requirements->currently_due))
                                                                <div class="form-group m-form__group row">
                                                                    <div class="col-12">
                                                                        Proof of Address
                                                                        {{--@if(count($stripeAccount->individual->requirements->errors))
                                                                            (
                                                                            {{ $stripeAccount->individual->requirements->errors[0]->reason }}
                                                                            )
                                                                        @endif--}}
                                                                    </div>
                                                                </div>
                                                                <div class="form-group m-form__group row">
                                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                                        Front :
                                                                        <span class="m-badge m-badge--wide info-badge"
                                                                              data-toggle="m-popover" data-html="true"
                                                                              data-placement="bottom"
                                                                              data-content="
                                                                          <strong>Proof of Home Address document requirements:</strong>
                                                                            <ul>
                                                                            <li>Documents must be clear and large enough to read</li>
                                                                            <li>Documents must be dated within the past six months</li>
                                                                            <li>Complete documents must be uploaded. A complete document is defined as:
                                                                            <ul>
                                                                            <li>At least one full page of the document</li>
                                                                            <li>The full name and address of the individual are clearly stated and legible</li>
                                                                            </ul>
                                                                            <li>Documents can be uploaded in .png or .jpg format</li>
                                                                            </ul>
                                                                        ">i</span>

                                                                    </label>
                                                                    <div class="col-xl-8 col-lg-8">
                                                                        {!! Form::file('addl_front_photo',
                                                                            ['placeholder' => '',
                                                                              'class' => 'form-control m-input photoId', 'accept' => 'image/png, image/jpeg, image/jpg']) !!}
                                                                    </div>

                                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                                        Back:
                                                                        <span class="m-badge m-badge--wide info-badge"
                                                                              data-toggle="m-popover" data-html="true"
                                                                              data-placement="bottom"
                                                                              data-content="
                                                                          <strong>Proof of Home Address document requirements:</strong>
                                                                            <ul>
                                                                            <li>Documents must be clear and large enough to read</li>
                                                                            <li>Documents must be dated within the past six months</li>
                                                                            <li>Complete documents must be uploaded. A complete document is defined as:
                                                                            <ul>
                                                                            <li>At least one full page of the document</li>
                                                                            <li>The full name and address of the individual are clearly stated and legible</li>
                                                                            </ul>
                                                                            <li>Documents can be uploaded in .png or .jpg format</li>
                                                                            </ul>
                                                                        ">i</span>
                                                                    </label>
                                                                    <div class="col-xl-8 col-lg-8">
                                                                        {!! Form::file('addl_back_photo',
                                                                            ['placeholder' => '',
                                                                              'class' => 'form-control m-input photoId',
                                                                              'size' => '80', 'accept' => 'image/png, image/jpeg, image/jpg']) !!}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="form-group m-form__group row">

                                                            </div>

                                                            <div class="form-group m-form__group row">
                                                                <div class="alert alert-warning"
                                                                     style="background-color: #e74b65">
                                                                    Please note Stripe require scans of both front and
                                                                    back
                                                                    of ID documents. ID's should be in date and in
                                                                    colour
                                                                    and have all information clearly legible. Files need
                                                                    to
                                                                    be JPEGs or PNGs and be smaller than 5MB in size.
                                                                    Stripe
                                                                    is unable to verify PDF's
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        @endif


                        @if($stripeAccount->business_type == 'company' )
                            @foreach($persons as $person)
                                <div id="person-ajax-result">
                                    <div class="individual-form">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                                <h3 class="m-form__heading-title">Person Details</h3>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-6">
                                                <img class="stripe-logo-add"
                                                     src="/img/stripe-logos/solid-dark/powered_by_stripe@3x.png"
                                                     alt="powered by stripe badge"/>
                                            </div>
                                        </div>

                                        <div class="m-portlet m-portlet--full-height">
                                            <div
                                                class="col-lg-12  m-wizard__form padding-mobile-none-lr">
                                                <!--
                                                1) Use m-form--label-align-left class to alight the form input lables to the right
                                                2) Use m-form--state class to highlight input control borders on form validation
                                                -->
                                                <!--begin: Form Body -->
                                                <div class="m-portlet__body">
                                                    <!--begin: Form Wizard Step 1-->
                                                    <div class="row">
                                                        <div class="col-xl-10 offset-xl-1 padding-mobile-none-lr">
                                                            <div class="m-form__section m-form__section--first">

                                                                <div class="form-group m-form__group row">
                                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                                        <span class="text-primary">*</span>First Name:
                                                                    </label>
                                                                    <div class="col-xl-8 col-lg-8">
                                                                        {!! Form::text('persons['.$person->id.'][first_name]', $person->first_name,
                                                                            ['placeholder' => 'First Name', 'required' => 'required',
                                                                            'class' => 'form-control m-input']) !!}
                                                                    </div>
                                                                </div>
                                                                <div class="form-group m-form__group row">
                                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                                        <span class="text-primary">*</span>Last Name:
                                                                    </label>
                                                                    <div class="col-xl-8 col-lg-8">
                                                                        {!! Form::text('persons['.$person->id.'][last_name]', $person->last_name,
                                                                            ['placeholder' => 'Last Name', 'required' => 'required',
                                                                            'class' => 'form-control m-input']) !!}
                                                                    </div>
                                                                </div>
                                                                <div class="form-group m-form__group row">
                                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                                        <span class="text-primary">*</span>Email:
                                                                    </label>
                                                                    <div class="col-xl-8 col-lg-8">
                                                                        {!! Form::email('persons['.$person->id.'][email]', $person->email,
                                                                            ['placeholder' => 'Email', 'required' => 'required',
                                                                            'class' => 'form-control m-input']) !!}
                                                                    </div>
                                                                </div>

                                                                <div class="form-group m-form__group row">
                                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                                        <span class="text-primary">*</span>Job Title:
                                                                    </label>
                                                                    <div class="col-xl-8 col-lg-8">
                                                                        {!! Form::text('persons['.$person->id.'][title]', $person->relationship->title,
                                                                            ['placeholder' => 'Title', 'required' => 'required',
                                                                            'class' => 'form-control m-input']) !!}
                                                                    </div>
                                                                </div>
                                                                <div class="form-group m-form__group row">
                                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                                        <span class="text-primary">*</span>DOB:
                                                                    </label>
                                                                    <div class="col-xl-2 col-lg-2 ">
                                                                        <div class="select-option">
                                                                            <i class="ti-angle-down"></i>
                                                                            <select title="Date"
                                                                                    name="persons[{{$person->id}}][day]"
                                                                                    required>
                                                                                <option
                                                                                    value="">
                                                                                    Day
                                                                                </option>
                                                                                @for($i = 1; $i <= 31; $i++)
                                                                                    <option
                                                                                        {{ $person->dob->day == $i ? 'selected' : '' }}
                                                                                        value="{{ $i }}">{{ $i < 10 ? '0'.$i : $i }}
                                                                                    </option>
                                                                                @endfor

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-3 col-lg-3">
                                                                        <div class="select-option">
                                                                            <i class="ti-angle-down"></i>
                                                                            <select title="Month"
                                                                                    name="persons[{{$person->id}}][month]"
                                                                                    required>
                                                                                <option
                                                                                    value="" {{ !Auth::user()->educator->dob ? 'selected' : '' }}>
                                                                                    Month
                                                                                </option>
                                                                                @for($m = 1; $m <= 12; $m++)
                                                                                    <option
                                                                                        value="{{ $m < 10 ? '0'.$m : $m }}"
                                                                                        {{ $person->dob->month == $m ? 'selected' : ''  }}>
                                                                                        {{ $m < 10 ? '0'.$m : $m }}
                                                                                    </option>
                                                                                @endfor
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-3 col-lg-3">
                                                                        <div class="select-option">
                                                                            <i class="ti-angle-down"></i>
                                                                            <select title="Year"
                                                                                    name="persons[{{$person->id}}][year]"
                                                                                    required>
                                                                                <option
                                                                                    value="" {{ !Auth::user()->educator->dob ? 'selected' : '' }}>
                                                                                    Year
                                                                                </option>
                                                                                @for($y = date('Y'); $y >= 1900; $y--)
                                                                                    <option value="{{ $y }}"
                                                                                        {{ $person->dob->year == $y ? 'selected' : '' }}>
                                                                                        {{ $y }}</option>
                                                                                @endfor
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group m-form__group row">
                                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                                        <span class="text-primary">*</span>Address:
                                                                    </label>
                                                                    <div class="col-xl-8 col-lg-8">
                                                                        <input type="text"
                                                                               name="persons[{{$person->id}}][line1]"
                                                                               value="{{ $person->address->line1 }}"
                                                                               placeholder="Address Line 1"
                                                                               class="form-control m-input address-field"
                                                                               required>
                                                                        <input type="text"
                                                                               name="persons[{{$person->id}}][line2]"
                                                                               value="{{ $person->address->line2 }}"
                                                                               placeholder="Addresss Line 2"
                                                                               class="form-control m-input address-field"
                                                                               required>
                                                                        <input type="text"
                                                                               name="persons[{{$person->id}}][city]"
                                                                               value="{{ $person->address->city }}"
                                                                               placeholder="City"
                                                                               class="form-control m-input address-field"
                                                                               required>
                                                                        <input type="text"
                                                                               name="persons[{{$person->id}}][state]"
                                                                               value="{{ $person->address->state }}"
                                                                               placeholder="County"
                                                                               class="form-control m-input address-field"
                                                                               required>
                                                                        <input type="text"
                                                                               name="persons[{{$person->id}}][postal_code]"
                                                                               value="{{ $person->address->postal_code }}"
                                                                               id="individual-person-postal-code"
                                                                               placeholder="Eircode"
                                                                               class="form-control m-input address-field  postal-code-ac"
                                                                               required>
                                                                        <label>Don't know your Eircode? Click <a
                                                                                href="https://finder.eircode.ie/#/"
                                                                                target="_blank">here</a></label>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group m-form__group row">
                                                                    <div class="col-12">
                                                                        ID Verification (Passport or Drivers License)
                                                                    </div>
                                                                </div>

                                                                <div class="form-group m-form__group row">
                                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                                        Front Photo ID:
                                                                        <span class="m-badge m-badge--wide info-badge"
                                                                              data-toggle="m-popover" data-html="true"
                                                                              data-placement="bottom"
                                                                              data-content="
                                                                          <strong>Proof of Identity document requirements:</strong>
                                                                            <ul>
                                                                            <li>Documents must be uploaded in full color (i.e. no black-and-white scans)</li>
                                                                            <li>Documents must be clear and large enough to read</li>
                                                                            <li>Photocopies of identity documents are not acceptable</li>
                                                                            <li>Documents must be valid and not expired</li>
                                                                            <li>Complete documents must be uploaded. A complete document is defined as:
                                                                            <ul>
                                                                            <li>Both front and back of a driver’s license or identity card</li>
                                                                            <li>The entire personal information page of a passport</li>
                                                                            </ul>
                                                                            </ul>
                                                                        ">i</span>

                                                                    </label>
                                                                    <div class="col-xl-8 col-lg-8" >
                                                                        {!! Form::file('persons['.$person->id.'][front_photo]',
                                                                            ['placeholder' => '',
                                                                              'class' => 'form-control m-input photoId', 'accept' => 'image/png, image/jpeg, image/jpg']) !!}
                                                                    </div>

                                                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                                                        Back Photo ID:
                                                                        <span class="m-badge m-badge--wide info-badge"
                                                                              data-toggle="m-popover" data-html="true"
                                                                              data-placement="bottom"
                                                                              data-content="
                                                                          <strong>Proof of Identity document requirements:</strong>
                                                                            <ul>
                                                                            <li>Documents must be uploaded in full color (i.e. no black-and-white scans)</li>
                                                                            <li>Documents must be clear and large enough to read</li>
                                                                            <li>Photocopies of identity documents are not acceptable</li>
                                                                            <li>Documents must be valid and not expired</li>
                                                                            <li>Complete documents must be uploaded. A complete document is defined as:
                                                                            <ul>
                                                                            <li>Both front and back of a driver’s license or identity card</li>
                                                                            <li>The entire personal information page of a passport</li>
                                                                            </ul>
                                                                            </ul>
                                                                        ">i</span>
                                                                    </label>
                                                                    <div class="col-xl-8 col-lg-8">
                                                                        {!! Form::file('persons['.$person->id.'][back_photo]',
                                                                            ['placeholder' => '',
                                                                              'class' => 'form-control m-input photoId',
                                                                              'size' => '80', 'accept' => 'image/png, image/jpeg, image/jpg']) !!}
                                                                    </div>
                                                                </div>

                                                                @if(in_array('verification.additional_document', $person->requirements->currently_due))
                                                                    <div class="form-group m-form__group row" style="margin-top: 20px">
                                                                        <div class="col-12">
                                                                            Proof of Address
                                                                            {{--@if(count($person->requirements->errors))
                                                                                (
                                                                                {{ $person->requirements->errors[0]->reason }}
                                                                                )
                                                                            @endif--}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group m-form__group row" >
                                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                                            Front:
                                                                            <span
                                                                                class="m-badge m-badge--wide info-badge"
                                                                                data-toggle="m-popover" data-html="true"
                                                                                data-placement="bottom"
                                                                                data-content="
                                                                          <strong>Proof of Home Address document requirements:</strong>
                                                                            <ul>
                                                                            <li>Documents must be clear and large enough to read</li>
                                                                            <li>Documents must be dated within the past six months</li>
                                                                            <li>Complete documents must be uploaded. A complete document is defined as:
                                                                            <ul>
                                                                            <li>At least one full page of the document</li>
                                                                            <li>The full name and address of the individual are clearly stated and legible</li>
                                                                            </ul>
                                                                            <li>Documents can be uploaded in .png or .jpg format</li>
                                                                            </ul>
                                                                        ">i</span>

                                                                        </label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            {!! Form::file('persons['.$person->id.'][addl_front_photo]',
                                                                                ['placeholder' => '',
                                                                                  'class' => 'form-control m-input photoId', 'accept' => 'image/png, image/jpeg, image/jpg']) !!}
                                                                        </div>

                                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                                            Back:
                                                                            <span
                                                                                class="m-badge m-badge--wide info-badge"
                                                                                data-toggle="m-popover" data-html="true"
                                                                                data-placement="bottom"
                                                                                data-content="
                                                                          <strong>Proof of Home Address document requirements:</strong>
                                                                            <ul>
                                                                            <li>Documents must be clear and large enough to read</li>
                                                                            <li>Documents must be dated within the past six months</li>
                                                                            <li>Complete documents must be uploaded. A complete document is defined as:
                                                                            <ul>
                                                                            <li>At least one full page of the document</li>
                                                                            <li>The full name and address of the individual are clearly stated and legible</li>
                                                                            </ul>
                                                                            <li>Documents can be uploaded in .png or .jpg format</li>
                                                                            </ul>
                                                                        ">i</span>
                                                                        </label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            {!! Form::file('persons['.$person->id.'][addl_back_photo]',
                                                                                ['placeholder' => '',
                                                                                  'class' => 'form-control m-input photoId',
                                                                                  'size' => '80', 'accept' => 'image/png, image/jpeg, image/jpg']) !!}
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                <div class="form-group m-form__group row">

                                                                </div>

                                                                <div class="form-group m-form__group row">
                                                                    <div class="alert alert-warning"
                                                                         style="background-color: #e74b65">
                                                                        Please note Stripe require scans of both front
                                                                        and
                                                                        back
                                                                        of ID documents. ID's should be in date and in
                                                                        colour
                                                                        and have all information clearly legible. Files
                                                                        need
                                                                        to
                                                                        be JPEGs or PNGs and be smaller than 5MB in
                                                                        size.
                                                                        Stripe
                                                                        is unable to verify PDF's
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                        @endforeach
                    @endif

                    <!-- starts : save & continue -->
                        <div class="save-continue two-buttons">
                            <div class="row">
                                <div class="col-md-4 col-lg-6 col-sm-6 col-xs-12 text-left">
                                    {{--<a class="btn btn-secondary shadow-v4"
                                       href="{{ route('educator.profile.create') }}">
                                        <span class="btn__text icon-arrow-left">BACK</span>
                                    </a>--}}
                                </div>
                                <div class="col-md-8 col-lg-6 col-sm-6 col-xs-12">
                                    <button type="submit" id="submit" class="btn btn-primary shadow-v4">
                                        <span class="btn__text icon-arrow-right">SAVE & CONTINUE</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- end : save & continue -->

                    {!! Form::close() !!}
                    <!--end: Payout Details Form-->

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('educator.modals.complete-profile-payment')
    @include('common.stripe-loading')

    @if(Auth::user()->educator->user_type == 1)
        @include('common.type1-stripe-complete')
    @else
        @include('common.type2-stripe-complete')

    @endif

@endsection

@section('page_scripts')

    <script src="{{ asset('educator/assets/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places&type=regions">
    </script>
    <script src="https://js.stripe.com/v3/"></script>

    <script type="text/javascript">

        var stripeLoadingModal = $('div#stripe-loading-modal')
        var stripeCompleteModal = $('div#stripe-complete')

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


        $(function () {

            $('form#stripe-form').on('submit', function (e) {

                e.preventDefault()

                var formData = new FormData(document.getElementById('stripe-form'));
                var stripeErrorHeading = '<p><strong>The following is required to complete the setup of payments:</strong></p>';

                $(stripeLoadingModal).modal('show')

                $.ajax({
                    type: 'POST',
                    url: '{{ route('educator.stripe-account.update') }}',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'JSON',
                    success: function (data) {
                        $(stripeLoadingModal).modal('hide')
                        $(resultModal).modal('show')
                        $('button#submit').removeAttr('disabled')
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    },
                    error: function (data) {
                        $(stripeLoadingModal).modal('hide')
                        $(resultModal).modal('show')
                        $('button#submit').removeAttr('disabled')
                        $(resultModal).find('div.modal-body').html(stripeErrorHeading + data.messages.join('<br>'))
                    }
                });

                return false
            })
        })

    </script>

@endsection
