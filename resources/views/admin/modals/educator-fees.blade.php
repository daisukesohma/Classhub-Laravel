<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">
        Provider Settings
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">
												&times;
											</span>
    </button>
</div>
<div class="modal-body">
    <form name="fees-form" id="provider-fees-form">
        {!! csrf_field() !!}
        <h6>Fees</h6>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="recipient-name" class="col-form-label">
                    Provider Fees (%):
                </label>
            </div>
            <div class="col-md-6">
                <input id="providerFees" type="text" class="form-control"
                       value="{{ $educator->provider_fee ? $educator->provider_fee : \App\Setting::get('provider_fee') }}"
                       name="provider_fee">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="recipient-name" class="col-form-label">
                    Customer Fees (%):
                </label>
            </div>
            <div class="col-md-6">
                <input id="customerFees" type="text" class="form-control"
                       value="{{ $educator->customer_fee ? $educator->customer_fee : \App\Setting::get('customer_fee') }}"
                       name="customer_fee">
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">
        Cancel
    </button>
    <button type="button" class="btn btn-primary update-fees"
            data-route="{{ route('admin.update.educator.fees', $educator->user_id) }}">
        Save Changes
    </button>
</div>
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
                        maxboostedstep: 10,
                        postfix: '%'
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
                            maxboostedstep: 10,
                            postfix: '%'
                        }
                    )
            }
        }

        BootstrapTouchspin.init()
    })
</script>
