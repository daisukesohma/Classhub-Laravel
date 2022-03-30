<div class="company-form">

    <div class="form-group m-form__group row" style="padding-top:22px">
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

    <div class="form-group m-form__group row" style="padding-top:22px">
        <label class="col-xl-4 col-lg-4 col-form-label">
            <span class="text-primary">*</span>Address:
        </label>
        <div class="col-xl-8 col-lg-8">
            <input type="text" name="line1" placeholder="Address Line 1"
                   class="form-control m-input address-field" required>
            <input type="text" name="line2"
                   placeholder="Addresss Line 2"
                   class="form-control m-input address-field" required>
            <input type="text" name="city" placeholder="City"
                   class="form-control m-input address-field" required>
            <input type="text" name="state" placeholder="County"
                   class="form-control m-input address-field" required>
            <input type="text" name="postal_code"
                   id="individual-postal-code"
                   placeholder="Eircode"
                   class="form-control m-input address-field postal-code-ac"
                   required>
            <label>Don't know your Eircode? Click <a
                    href="https://finder.eircode.ie/#/" target="_blank">here</a></label>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label class="col-xl-4 col-lg-4 col-form-label">
            <span class="text-primary">*</span>Business Name:
        </label>
        <div class="col-xl-8 col-lg-8">
            <input type="text" name="business_name"
                   placeholder="Business Name"
                   class="form-control m-input" required/>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label class="col-xl-4 col-lg-4 col-form-label">
            <span class="text-primary">*</span>Business Tax Number:
        </label>
        <div class="col-xl-8 col-lg-8">
            <input type="text" name="business_tax_id"
                   placeholder="Business Tax Number"
                   class="form-control m-input" required/>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label class="col-xl-4 col-lg-4 col-form-label">
            <span class="text-primary">*</span>Business VAT Number:
        </label>
        <div class="col-xl-8 col-lg-8">
            <input type="text" name="business_vat_id"
                   placeholder="Business VAT Number"
                   class="form-control m-input" required/>
        </div>
    </div>
</div>
