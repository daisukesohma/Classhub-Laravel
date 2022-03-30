@extends('admin.layouts.master')

@section('title')
    Classhub | Global Fees
@endsection

@section('content')

    <div class="m-content">
        <!--Begin::Section-->
        <div class="row">
            <div class="col-md-12">
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Global Fees
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body ">
                        <!--begin: Datatable -->
                        <form id="fees-form">
                            {{ csrf_field() }}
                            <h6>Fees</h6>
                            <div class="form-group m-form__group m--margin-top-10">
                                <div class="alert m-alert m-alert--default" role="alert">
                                    The fees set up here will apply to all future and existing providers unless set
                                    otherwise for a single provider in the <i class="la la-money"></i> section of the
                                    <a href="{{ route('admin.educators') }}">Providers list.</a>
                                </div>
                            </div>
                            <div class="row col-md-6">
                                <div class="form-group row ">
                                    <div class="col-md-6">
                                        <label for="recipient-name" class="col-form-label">
                                            Provider Fees (%):
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="providerFees"
                                               value="{{ \App\Setting::get('provider_fee') }}"
                                               name="settings[provider_fee]" placeholder="Select fee" type="text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="recipient-name" class="col-form-label">
                                            Customer Fees (%):
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="customerFees"
                                               value="{{ \App\Setting::get('customer_fee') }}"
                                               name="settings[customer_fee]" placeholder="Select fee" type="text">
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions" style="padding:30px">
                            <button type="button" class="btn btn-primary edit-fees">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End::Section-->
    </div>

@endsection


@section('page_scripts')

    <script type="text/javascript">

        $(function () {

            var BootstrapTouchspin = {
                init: function () {
                    $("#providerFees").TouchSpin({
                            buttondown_class: "btn btn-secondary",
                            buttonup_class: "btn btn-secondary",
                            min: 0,
                            max: 100,
                            step: 0.01,
                            decimals: 2,
                            boostat: 5,
                            maxboostedstep: 10
                        }
                    ),
                        $("#customerFees").TouchSpin({
                                buttondown_class: "btn btn-secondary",
                                buttonup_class: "btn btn-secondary",
                                min: 0,
                                max: 100,
                                step: 0.01,
                                decimals: 2,
                                boostat: 5,
                                maxboostedstep: 10
                            }
                        )
                }
            }

            BootstrapTouchspin.init()


            // Update Lesson Category
            $('body').on('click', 'button.edit-fees', function () {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.settings') }}',
                    data: $('form#fees-form').serialize(),
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.status) {
                            swal('Success', data.messages.join(), "success")
                        } else {
                            swal('Error', data.messages.join(), "error")
                        }
                    },
                    error: function (data) {
                        swal('Error', data.messages.join(), "error")

                    }
                })
            })
        })


    </script>
@endsection
