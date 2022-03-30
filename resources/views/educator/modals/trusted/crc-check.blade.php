<!--begin::Modal-->
<div class="modal fade c-modal payment-summary crc-check" id="crc-check" tabindex="-1" role="dialog"
     aria-labelledby="payment summary" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg1" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">
						&times;
					</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- starts : payment summary -->
                <div class="list-a-class">

                    <div class="top-section">
                        <div class="title p-l-0">CRC check</div>
                        <div class="sub-title">Provided by Experien</div>
                    </div>

                    <!-- starts : payment form -->
                    <div class="payment-form">

                        @if(Auth::user()->trusted)

                            <div class="alert alert-success" style="margin-top: 20px">CRC already submitted</div>
                        @else

                            {!! Form::open(['url' => route('educator.crc.store'),
                             'class' => 'm-form m-form--label-align-left- m-form--state-', 'id' => 'crc-form']) !!}
                        <!--begin: Form Wizard-->
                            <div class="m-wizard__form">
                                <!--
                                    1) Use m-form--label-align-left class to alight the form input lables to the right
                                    2) Use m-form--state class to highlight input control borders on form validation
                                    -->
                                <!--begin: Form Body -->
                                <div class="m-portlet__body">

                                    <!-- starts : row : Full Name -->
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control m-input" placeholder="Full Name"
                                                   name="name" required>
                                        </div>
                                    </div>
                                    <!-- end : row : Full Name -->

                                    <!-- starts : row : Address Line 1 -->
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control m-input" placeholder="Address Line 1"
                                                   name="address_1" required>
                                        </div>
                                    </div>
                                    <!-- end : row : Address Line 1 -->

                                    <!-- starts : row : Address Line 2 -->
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control m-input" placeholder="Address Line 2"
                                                   name="address_2" required>
                                        </div>
                                    </div>
                                    <!-- end : row : Address Line 2 -->

                                    <!-- starts : row : Phone Number -->
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control m-input" placeholder="Phone Number"
                                                   name="phone_no" required>
                                        </div>
                                    </div>
                                    <!-- end : row : Phone Number -->

                                    <!-- starts : row : D.O.B -->
                                    <div class="form-group m-form__group row two-selectboxes">
                                        <div class="col-lg-3 m-form__group-sub fw-5 p-t-12">
                                            D.O.B
                                        </div>
                                        <div class="col-lg-3 m-form__group-sub two">
                                            <div class="select-option">
                                                <i class="ti-angle-down"></i>
                                                <select title="Date" name="day" required>
                                                    <option value="">
                                                        Day
                                                    </option>
                                                    @for($i = 1; $i <= 31; $i++)
                                                        <option value="{{ $i }}">{{ $i < 10 ? '0'.$i : $i }}</option>
                                                    @endfor

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 m-form__group-sub two">
                                            <div class="select-option">
                                                <i class="ti-angle-down"></i>
                                                <select title="Month" name="month" required>
                                                    <option value="">
                                                        Month
                                                    </option>
                                                    @for($m = 1; $m <= 12; $m++)
                                                        <option value="{{ $m < 10 ? '0'.$m : $m }}">
                                                        {{ $m < 10 ? '0'.$m : $m }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 m-form__group-sub two">
                                            <div class="select-option">
                                                <i class="ti-angle-down"></i>
                                                <select title="Year" name="year" required>
                                                    <option value="">
                                                        Year
                                                    </option>
                                                    @for($y = date('Y'); $y >=  1900; $y--)
                                                        <option value="{{ $y }}">{{ $y }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- starts : row : D.O.B -->

                                    <!-- starts : agree check -->
                                    <div class="form-group m-form__group row agree">
                                        <div class="col-md-10 col-form-label">
                                            <div class="fs-14">I agree to the CRC check with Experian. Read more about
                                                the CRC check <a href="{{ route('page.trust') }}"
                                                                 target="_blank">here</a>.
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-right">
                                            <span class="m-switch m-switch--danger m-switch--icon">
                                                <label>
                                                    <input type="checkbox" name="" required id="">
                                                    <span></span>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- end : agree check -->

                                    <!-- starts : Confirm and pay button -->
                                    <div class="text-center p-t-15">
                                        <button type="submit" class="btn btn-primary v3 shadow-v4"><span
                                                class="btn__text">SUBMIT</span></button>
                                    </div>
                                    <!-- end : Confirm and pay button -->

                                </div>
                                <!--end: Form Body-->
                            </div>
                            <!--end: Form Wizard-->
                            {!! Form::close() !!}
                        @endif
                    </div>
                    <!-- end : payment form -->

                </div>
                <!-- end : payment summary -->
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->
