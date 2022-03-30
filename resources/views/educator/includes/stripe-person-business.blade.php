<div class="company-form">

    <h3 class="m-form__heading-title">Director(s) Details</h3>

    <div id="person-repeater">

        <div class="repeater-item-container" data-repeater-list="persons">

            <div class="m-portlet m-portlet--full-height repeater-item" data-repeater-item>
                <div
                    class="col-lg-12  m-wizard__form">
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
                                            <span class="text-primary">*</span>Job Title:
                                        </label>
                                        <div class="col-xl-8 col-lg-8">
                                            {!! Form::text('title', null,
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
                                                <select title="Date" name="day" required>
                                                    <option value="" {{ !Auth::user()->educator->dob ? 'selected': '' }}>
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
                                                    <option value="" {{ !Auth::user()->educator->dob ? 'selected' : '' }}>
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
                                                    <option value="" {{ !Auth::user()->educator->dob ? 'selected' : '' }}>
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
                                                ['placeholder' => 'Phone Number', 'required' => 'required',
                                                'class' => 'form-control m-input']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                            <span class="text-primary">*</span>Owner:
                                        </label>
                                        <div class="col-xl-8 col-lg-8">
                                            {!! Form::select('owner', ['yes' => 'Yes', 'no' => 'No'], 'yes',
                                                [ 'title' => 'Individual or Business','required' => 'required',
                                                'class' => 'form-control o']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                            <span class="text-primary">*</span>Percent Own
                                            (%):
                                        </label>
                                        <div class="col-xl-8 col-lg-8">
                                            {!! Form::number('percent_owned', null,
                                                ['placeholder' => '25', 'required' => 'required',
                                                'class' => 'form-control m-input']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                            <span class="text-primary">*</span>Address:
                                        </label>
                                        <div class="col-xl-8 col-lg-8">
                                            <input type="text" name="line1" placeholder="Address Line 1"
                                                   class="form-control m-input address-field" required>
                                            <input type="text" name="line2" placeholder="Addresss Line 2"
                                                   class="form-control m-input address-field" required>
                                            <input type="text" name="city" placeholder="City"
                                                   class="form-control m-input address-field" required>
                                            <input type="text" name="state" placeholder="County"
                                                   class="form-control m-input address-field" required>
                                            <input type="text" name="postal_code" id="postal-code-0"
                                                   placeholder="Eircode"
                                                   class="form-control m-input address-field  postal-code-ac"
                                                   required>
                                            <label>Don't know your Eircode? Click <a
                                                    href="https://finder.eircode.ie/#/" target="_blank">here</a></label>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                            <span class="text-primary">*</span>Front Photo
                                            ID:
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
                                        <div class="col-xl-8 col-lg-8 photo-id-front">
                                            {!! Form::file('front_photo',
                                                ['placeholder' => '', 'required' => 'required',
                                                  'class' => 'form-control m-input photoId', 'accept' => 'image/png, image/jpeg, image/jpg']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                            <span class="text-primary">*</span>Back Photo
                                            ID:
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
                                        <div class="col-xl-8 col-lg-8 photo-id-back">
                                            {!! Form::file('back_photo',
                                                ['placeholder' => '', 'required' => 'required',
                                                  'class' => 'form-control m-input photoId', 'accept' => 'image/png, image/jpeg, image/jpg']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <div class="alert alert-warning" style="background-color: #e74b65;">
                                            Please note Stripe require scans of both front and back
                                            of ID documents. ID's should be in date and in colour
                                            and have all information clearly legible. Files need to
                                            be JPEGs or PNGs and be smaller than 5MB in size. Stripe
                                            is unable to verify PDF's
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="col-xl-10 offset-xl-1 text-right"
                                 style="margin-top: 20px">
                                <a data-repeater-delete href="javascript:;"
                                   class="btn-sm btn btn-primary m-btn m-btn--icon data-repeater-delete">
                                                                 <span>
                                                                    <i class="la la-trash-o"></i>
                                                                    <span>Delete</span>
                                                                 </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="p-t-12 p-b-2 repeater-action" style="margin-bottom: 10px">
            <a data-repeater-create href="javascript:;"
               class="btn-sm btn btn-primary m-btn m-btn--icon add-btn">
                                                                 <span>
                                                                    <i class="la la-plus"></i>
                                                                    <span>Add More Director</span>
                                                                 </span>
            </a>
        </div>
    </div>

</div>
