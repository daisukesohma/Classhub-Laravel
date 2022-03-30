@extends('educator.layouts.master')

@section('title')
    Classhub | Change Bank Account
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
                                    <div class="title">Change Bank Account</div>
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
                                                 aria-valuemin="0" aria-valuemax="100" style="width: 50%;"></div>
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
                                            <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_2">
                                                <a href="{{ route('educator.lesson.create') }}"
                                                   class="m-wizard__step-number"><span></span></a>
                                                <div class="m-wizard__step-info">
                                                    <div class="m-wizard__step-title">Tell us about your class</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Form Wizard Nav -->
                                </div>
                            </div>

                        </div>
                        <!--end: Form Wizard Head -->
                        <!--begin: Payout Details Form-->
                        <div class="row">
                            <div class="col-md-3 col-lg-3">
                                <h3 class="m-form__heading-title">Bank Details</h3>
                            </div>
                            <div class="col-md-8">
                                <img class="stripe-logo-change"
                                     src="/img/stripe-logos/solid-dark/powered_by_stripe@3x.png"
                                     alt="powered by stripe badge" height="40px"/>
                            </div>
                        </div>
                        {!! Form::open(['url' => route('educator.update.bank-account'), 'enctype' => 'multipart/form-data',
                            'method' => 'post', 'class' => 'm-form m-form--label-align-left- m-form--state- payout-details',
                            'id' => 'bank-account-form', 'autocomplete' => 'off']) !!}
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

                        <!-- starts : save & continue -->
                        <div class="save-continue two-buttons">
                            <div class="row">
                                <div class="col-md-4 col-lg-6 col-sm-6 col-xs-12 text-left">
                                </div>
                                <div class="col-md-8 col-lg-6 col-sm-6 col-xs-12">
                                    <button type="submit" id="submit" class="btn btn-primary shadow-v4">
                                        <span class="btn__text">SUBMIT</span>
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

@endsection

@section('page_scripts')

    <script src="{{ asset('educator/assets/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="https://js.stripe.com/v3/"></script>

    <script type="text/javascript">

        var stripe = Stripe('{{ env('STRIPE_PUBLIC_KEY') }}')

        $(function () {

            $('form#bank-account-form').on('submit', function (e) {

                console.log('submit');

                e.preventDefault()

                var accountType = $('input[name="account_holder_type"]').val();
                var accountHolderName = $('input[name="account_holder_name"]').val();
                var accountNumber = $('input[name="account_number"]').val().toString().toUpperCase();
                var country = $('select[name="country"]').val();
                var currency = $('select[name="currency"]').val();

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

                            var formData = new FormData(document.getElementById('bank-account-form'));

                            console.log(formData)

                            $(resultModal).find('div.modal-body').append(`
                            <p style="margin-top: 1rem;">Update Bank Account, Please wait...</p>`)

                            $(resultModal).modal('show')

                            $.ajax({
                                type: 'POST',
                                url: '{{ route('educator.update.bank-account') }}',
                                data: formData,
                                contentType: false,
                                processData: false,
                                dataType: 'JSON',
                                success: function (data) {
                                    if (data.status) {
                                        $(resultModal).find('div.modal-body').html(data.messages)

                                        setTimeout(function () {
                                            window.location = '{{ route('educator.lesson.create') }}'
                                        }, 3000)
                                    }
                                    else {
                                        $('button#submit').removeAttr('disabled')
                                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                                    }
                                },
                                error: function (data) {
                                    $('button#submit').removeAttr('disabled')
                                    $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                                }
                            });

                        } else {
                            $(resultModal).modal('show')
                            $('button#submit').removeAttr('disabled')
                            $(resultModal).find('div.modal-body').html(result.error.message)
                        }
                    }).catch(error => alert(error.message));

                return false
            })
        })

    </script>


@endsection
