@extends('educator.layouts.master')

@section('title')
    Classhub | Payout Details
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
                                    <div class="title">Get Paid</div>
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
                                                 aria-valuemin="0" aria-valuemax="100"
                                                 style="{{ Auth::user()->educator->user_type == 2 ? 'width: 50%;' : 'width:100%' }}"></div>
                                        </div>
                                    </div>
                                    <!--end: Form Wizard Progress -->
                                    <!--begin: Form Wizard Nav -->
                                    <div class="m-wizard__nav">
                                        <div class="m-wizard__steps">
                                            <div class="m-wizard__step m-wizard__step--done">
                                                <a href="{{ route('educator.profile.create') }}"
                                                   class="m-wizard__step-number"><span><i
                                                            class="fa fa-circle"></i></span></a>
                                                <div class="m-wizard__step-info">
                                                    <div class="m-wizard__step-title">Set up your profile</div>
                                                </div>
                                            </div>
                                            <div class="m-wizard__step m-wizard__step--current"
                                                 m-wizard-target="m_wizard_form_step_1">
                                                <a href="{{ route('educator.setup.stripe') }}"
                                                   class="m-wizard__step-number"><span><i
                                                            class="fa fa-circle"></i></span></a>
                                                <div class="m-wizard__step-info">
                                                    <div class="m-wizard__step-title">Get Paid</div>
                                                </div>
                                            </div>
                                            @if(Auth::user()->educator->user_type == 2)
                                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_2">
                                                    <a href="{{ route('educator.lesson.create') }}"
                                                       class="m-wizard__step-number"><span></span></a>
                                                    <div class="m-wizard__step-info">
                                                        <div class="m-wizard__step-title">Tell us about your class</div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <!--end: Form Wizard Nav -->
                                </div>
                            </div>

                        </div>
                        <!--end: Form Wizard Head -->
                        @if(Auth::user()->stripe_acct_id && Auth::user()->bank_account)
                            <div class="m-portlet m-portlet--full-height">
                                <div class="alert">
                                    You have already added Bank Account. Click <a
                                        href="{{ route('educator.change.bank-account') }}">here </a> to change Bank
                                    Account
                                </div>
                            </div>
                        @else

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
                            {!! Form::open(['url' => route('educator.stripe-account.store'), 'enctype' => 'multipart/form-data',
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
                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                            <span class="text-primary">*</span>Account Type:
                                                        </label>
                                                        <div class="col-xl-8 col-lg-8">
                                                            {!! Form::select('account_type', \App\Educator::TYPES, Auth::user()->educator ? Auth::user()->educator->type : null ,
                                                                [ 'title' => 'Individual or Business','required' => 'required',
                                                                'class' => 'form-control m-bootstrap-select m_selectpicker']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                            <span class="text-primary">*</span>Account Holder Name:
                                                        </label>
                                                        <div class="col-xl-8 col-lg-8">
                                                            {!! Form::text('account_holder_name', Auth::user()->name,
                                                                ['placeholder' => 'Account Holder Name', 'required' => 'required',
                                                                'class' => 'form-control m-input']) !!}
                                                        </div>
                                                    </div>

                                                    <div id="business-ajax-result">

                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                            <span class="text-primary">*</span>IBAN:
                                                        </label>
                                                        <div class="col-xl-8 col-lg-8">
                                                            {!! Form::text('account_number', null,
                                                                ['placeholder' => 'IBAN', 'required' => 'required',
                                                                'class' => 'form-control m-input', 'style' => 'text-transform:uppercase']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                            <span class="text-primary">*</span>Country :
                                                        </label>
                                                        <div class="col-xl-8 col-lg-8">
                                                            {!! Form::select('country', \App\Educator::COUNTRIES, null,
                                                                [ 'title' => 'Country','required' => 'required',
                                                                'class' => 'form-control no-zindex m-bootstrap-select m_selectpicker']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                            <span class="text-primary">*</span>Currency:
                                                        </label>
                                                        <div class="col-xl-8 col-lg-8">
                                                            {!! Form::select('currency', \App\Educator::CURRENCIES, null,
                                                                [ 'title' => 'Currency','required' => 'required',
                                                                'class' => 'form-control no-zindex m-bootstrap-select m_selectpicker']) !!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                            <span class="text-primary">*</span>Industry:
                                                        </label>
                                                        <div class="col-xl-8 col-lg-8">
                                                            {!! Form::select('industry', \App\Setting::STRIPE_MCC, '8299',
                                                                [ 'title' => 'Industry','required' => 'required',
                                                                'class' => 'form-control no-zindex m-bootstrap-select m_selectpicker']) !!}
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" value="{{ Auth::user()->educator->type }}"
                                               name="account_holder_type">
                                        <input type="hidden" name="stripe_token">

                                        <!--end: Form Wizard Step 1-->
                                    </div>
                                    <!--end: Form Body -->
                                </div>
                            </div>

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
                                                                    {!! Form::text('first_name', \App\Helpers\ClassHubHelper::getFirstName(Auth::user()->name),
                                                                        ['placeholder' => 'First Name', 'required' => 'required',
                                                                        'class' => 'form-control m-input']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-form__group row">
                                                                <label class="col-xl-4 col-lg-4 col-form-label">
                                                                    <span class="text-primary">*</span>Last Name:
                                                                </label>
                                                                <div class="col-xl-8 col-lg-8">
                                                                    {!! Form::text('last_name', \App\Helpers\ClassHubHelper::getLastName(Auth::user()->name),
                                                                        ['placeholder' => 'Last Name', 'required' => 'required',
                                                                        'class' => 'form-control m-input']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-form__group row">
                                                                <label class="col-xl-4 col-lg-4 col-form-label">
                                                                    <span class="text-primary">*</span>Email:
                                                                </label>
                                                                <div class="col-xl-8 col-lg-8">
                                                                    {!! Form::email('email', Auth::user()->email,
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
                                                                                value="" {{ !Auth::user()->educator->dob ? 'selected': '' }}>
                                                                                Day
                                                                            </option>
                                                                            @for($i = 1; $i <= 31; $i++)
                                                                                <option
                                                                                    {{ Auth::user()->educator->dob && \Carbon\Carbon::parse(Auth::user()->educator->dob)->format('d') == $i ? 'selected' : '' }}
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
                                                                                    {{ Auth::user()->educator->dob && \Carbon\Carbon::parse(Auth::user()->educator->dob)->format('m') == $m ? 'selected' : ''  }}>
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
                                                                                    {{ Auth::user()->educator->dob && \Carbon\Carbon::parse(Auth::user()->educator->dob)->format('Y') == $y ? 'selected' : '' }}>
                                                                                    {{ $y }}</option>
                                                                            @endfor
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
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
                                                                    {!! Form::text('phone_no', null,
                                                                        ['placeholder' => 'E.g. 871234567', 'required' => 'required',
                                                                        'class' => 'form-control m-input']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-form__group row">
                                                                <label class="col-xl-4 col-lg-4 col-form-label">
                                                                    <span class="text-primary">*</span>Address:
                                                                </label>
                                                                <div class="col-xl-8 col-lg-8">
                                                                    <input type="text" name="line1"
                                                                           placeholder="Address Line 1"
                                                                           class="form-control m-input address-field"
                                                                           required>
                                                                    <input type="text" name="line2"
                                                                           placeholder="Addresss Line 2"
                                                                           class="form-control m-input address-field"
                                                                           required>
                                                                    <input type="text" name="city"
                                                                           placeholder="City"
                                                                           class="form-control m-input address-field"
                                                                           required>
                                                                    <input type="text" name="state" placeholder="County"
                                                                           class="form-control m-input address-field"
                                                                           required>
                                                                    <input type="text" name="postal_code"
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
                                                                <label class="col-xl-4 col-lg-4 col-form-label">
                                                                    <span class="text-primary">*</span>Front Photo ID:
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
                                                                        ['placeholder' => '', 'required' => 'required',
                                                                          'class' => 'form-control m-input photoId', 'accept' => 'image/png, image/jpeg, image/jpg']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-form__group row">
                                                                <label class="col-xl-4 col-lg-4 col-form-label">
                                                                    <span class="text-primary">*</span>Back Photo ID:
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
                                                                        ['placeholder' => '', 'required' => 'required',
                                                                          'class' => 'form-control m-input photoId',
                                                                          'size' => '80', 'accept' => 'image/png, image/jpeg, image/jpg']) !!}
                                                                </div>
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

                            <!-- starts: Payment Terms -->
                            {{--<div class="m-portlet m-portlet--full-height payment-terms">
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
                                                            class="col-xl-9 col-lg-9 col-xs-12 col-form-label terms-text">
                                                            <div class="title">Payment Terms</div>
                                                        </div>
                                                        <div class="col-xl-9 col-lg-9 col-form-label terms-text">
                                                            <div class="sub-title">I have read and accept Class Hub's
                                                                Payment terms. <br class="hide-below-md">See full
                                                                <a target="_blank"
                                                                   href="{{ route('page.terms-conditions') }}">Payment
                                                                    Terms</a>?
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-3 text-right terms-toggle">
                                                  <span class="m-switch m-switch--danger m-switch--icon">
                                                    <label>
                                                      <input type="checkbox" name="payment_terms" required
                                                             id="payment-terms">
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
                            </div>--}}
                        <!-- end: Payment Terms -->

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
                        @endif

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

        var stripe = Stripe('{{ env('STRIPE_PUBLIC_KEY') }}')
        var payoutCompleted = parseInt({{ Auth::user()->stripe_acct_id ? 1 : 0 }});
        var payoutFilledIn = parseInt({{ Auth::user()->stripe_acct_id ? 1 : 0 }});
        var personFilledIn = parseInt({{ Auth::user()->stripe_acct_id ? 1 : 0 }});
        var terms = false;
        var validateAjax = false;
        var redirectUrl = '{{ request()->redirect_url ?  request()->redirect_url : 'false'}}';
        var stripeLoadingModal = $('div#stripe-loading-modal')
        var stripeCompleteModal = $('div#stripe-complete')
        var continueUrl = '{{ route('educator.lesson.create') }}'

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

            $('select[name="account_type"]').on('change', function () {

                $('input[name="account_holder_type"]').val($(this).val())

                $.ajax({
                    type: 'GET',
                    url: '{{ route('get.stripe-fields') }}',
                    data: {_token: '{{ csrf_token() }}', 'type': $('select[name="account_type"]').val()},
                    dataType: 'JSON',
                    success: function (data) {

                        if (data.status) {

                            $('div#person-ajax-result').html(data.person_fields)

                            initAutoCompleteFields()

                            if ($('select[name="account_type"]').val() == 'individual') {
                                $('div#business-ajax-result').html('')
                                validateData();

                            } else {
                                $('div#business-ajax-result').html(data.business_fields)

                                initAutoCompleteFields()

                                $('#person-repeater').repeater({
                                    initEmpty: false,
                                    isFirstItemUndeletable: true,
                                    show: function () {
                                        $(this).slideDown();

                                        $('div.repeater-item').each(function (i) {
                                            let addressField = $(this).find('input.postal-code-ac')
                                            $(addressField).attr('id', `postal-code-${i}`)
                                        })
                                        validateData();
                                        initAutoCompleteFields()
                                    },
                                    hide: function (deleteElement) {
                                        $(this).slideUp(deleteElement);
                                        validateData();
                                    },
                                })

                                validateData();
                            }
                        } else {
                            console.log(data)
                        }
                    },
                    error: function (data) {
                        console.log(data)
                    }
                });

            })

            /*$('button#submit').on('click', function () {
                if (!$('input#payment-terms').is(':checked')) {
                    console.log('not agreed')
                    $(resultModal).find('div.modal-body').html(`You have to accept Class Hub's Payment terms`)
                    $(resultModal).modal('show')
                    return
                }
            })*/

            $('form#stripe-form').on('submit', function (e) {

                e.preventDefault()

                var stripeErrorHeading = '<p><strong>The following is required to complete the setup of payments:</strong></p>';

                $('button#submit').attr('disabled', true)

                var accountType = $('input[name="account_holder_type"]').val();
                var accountHolderName = $('input[name="account_holder_name"]').val();
                var accountNumber = $('input[name="account_number"]').val().toString().toUpperCase();
                var country = $('select[name="country"]').val();
                var currency = $('select[name="currency"]').val();

                var error = '';

                if (!accountNumber) {
                    error += '<p>Bank account number(IBAN) field is required</p>';
                }
                if (!country) {
                    error += '<p>Country field is required</p>';
                }
                if (!currency) {
                    error += '<p>Currency field is required</p>';
                }

                if (error) {
                    $(resultModal).modal('show')
                    $(resultModal).find('div.modal-body').html(stripeErrorHeading + error)
                    return;
                    $('button#submit').attr('disabled', false)
                }

                stripe.createToken('bank_account', {
                        country: country,
                        currency: currency,
                        account_number: accountNumber,
                        account_holder_name: accountHolderName,
                        account_holder_type: accountType,
                    })
                    .then(function (result) {

                        if (result.token) {

                            $('input[name="stripe_token"]').val(result.token.id);

                            var formData = new FormData(document.getElementById('stripe-form'));

                            console.log(formData)

                            $(stripeLoadingModal).modal('show')

                            $.ajax({
                                type: 'POST',
                                url: '{{ route('educator.stripe-account.store') }}',
                                data: formData,
                                contentType: false,
                                processData: false,
                                dataType: 'JSON',
                                success: function (data) {
                                    $(stripeLoadingModal).modal('hide')
                                    if (data.status) {
                                        continueUrl = redirectUrl !== 'false' ? redirectUrl : data.redirect_url;
                                        $(stripeCompleteModal).modal('show')
                                        $(stripeCompleteModal).find('a#stripe-complete-continue').attr('href', continueUrl)

                                        /* setTimeout(function () {
                                             window.location = redirectUrl !== 'false' ? redirectUrl : data.redirect_url
                                         }, 3000)*/
                                    }
                                    else {
                                        $(resultModal).modal('show')
                                        $('button#submit').removeAttr('disabled')
                                        $(resultModal).find('div.modal-body').html(stripeErrorHeading + data.messages.join('<br>'))
                                    }
                                },
                                error: function (data) {
                                    $(stripeLoadingModal).modal('hide')
                                    $(resultModal).modal('show')
                                    $('button#submit').removeAttr('disabled')
                                    $(resultModal).find('div.modal-body').html(stripeErrorHeading + data.messages.join('<br>'))
                                }
                            });

                        } else {
                            $(stripeLoadingModal).modal('hide')
                            $(resultModal).modal('show')
                            $('button#submit').removeAttr('disabled')
                            $(resultModal).find('div.modal-body').html(stripeErrorHeading + result.error.message)
                        }
                    }).catch(error => alert(error.message));

                return false
            })
        })

        $(stripeCompleteModal).on('hidden.bs.modal', function () {
            window.location = continueUrl;
        })

        function pushDataLayer() {
            window.dataLayer.push({
                event: 'list_class_step_2',
                formLocation: 'List class step 2',
                formName: 'Stripe Setup Form',
                accountType: $('select[name="account_type"]').val().trim(),
                country: $('select[name="country"]').val().trim(),
                currency: $('select[name="currency"]').val().trim(),
            })
        }

    </script>

    <script type="text/javascript">

        $(function () {

            $('body').on('keyup change', 'form#stripe-form input, form#stripe-form textarea, form#stripe-form select,' +
                'form#stripe-form file, input#payment-terms',

                function () {

                    // Autosave stripe
                    if (!payoutCompleted) {

                        validateData()
                    }
                })

            $('body').on('click ', 'div.m-brand__logo a, div#m_header_menu li.m-menu__item a, ' +
                'div.m-dropdown__wrapper li.m-nav__item a:not(".logout")', function () {

                if (!payoutCompleted && (!personFilledIn || !payoutFilledIn || !terms)) {

                    link = $(this).attr('href')
                    errorMessage = 'You have not completed the payout details or person details to start ' +
                        'taking payments on Classhub. Are you sure you want to exit?'

                    $('div#complete-profile-payment div.modal-body').html(`
                                <p>${errorMessage}</p>
                                <p><a href="${link}">YES</a></p>
                                <p><a href="javascript:;" data-dismiss="modal">NO</a></p>
                            `);

                    $('div#complete-profile-payment').modal('show')

                    return false;
                } else {
                    return true;
                }
            })
        })

        function validateData() {

            if (validateAjax && validateAjax.readyState != 4) {
                validateAjax.abort()
            }

            var formData = new FormData(document.getElementById('stripe-form'));

            personFilledIn = false;
            payoutFilledIn = false;
            terms = false;

            validateAjax = $.ajax({
                type: 'POST',
                url: '{{ route('post.validate.payout') }}',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    if (data.status) {
                        personFilledIn = true;
                        payoutFilledIn = true;
                        terms = true;
                    } else {
                        personFilledIn = data.person;
                        payoutFilledIn = data.payout;
                        terms = data.payment_terms;
                    }
                    console.log(data)
                },
                error: function (data) {
                    console.log(data)
                }
            })
        }

    </script>

@endsection
