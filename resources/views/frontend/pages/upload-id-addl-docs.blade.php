@extends('frontend.layouts.master')

@section('title')
    Classhub | Upload Documents
@endsection


@section('content')

    <div class="container  privacy">

        <div class="box shadow-v4">

            <!-- starts : top section -->
            <div class="  p-b-24" style="min-height: 400px">

                <div class="modal-body" style="padding: 0px 45px 25px 45px">
                    <div class="row"
                         style="background: #E74B65; color: #FFF!important; padding: 20px; margin: 0px -45px">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h3 style="text-align: left; font-weight: normal; color: #FFF!important">Additional
                                Documents Upload</h3>
                            <h5 class=""
                                style="font-family:Open Sans, Arial, sans-serif; font-weight: 300; font-size: 19px;color: #FFF!important;">
                                Please note Stripe require scans of both front and back of Additional Documents.
                                ID's should be in date and in colour and have all information clearly
                                legible. Files need to be JPEGs or PNGs and be smaller than 5MB in size.
                                Stripe is unable to verify PDF.</h5>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 20px">
                        @include('messages.all')

                        <div class="col-md-12">
                            <form action="{{ route('post.stripe.upload.addl.documents') }}" method="post"
                                  enctype="multipart/form-data">
                                <input type="hidden" value="{{ csrf_token() }}" name="_token">
                                <input type="hidden" value="{{ $accountId }}" name="stripe_acct_id">
                                <input type="hidden" value="{{ $personId }}" name="person_id">
                                <div class="form-group m-form__group row">
                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                        <span class="text-primary">*</span>First Name:
                                    </label>
                                    <div class="col-xl-8 col-lg-8">
                                        {!! Form::text('first_name', '',
                                            ['placeholder' => 'First Name', 'required' => 'required',
                                            'class' => 'form-control m-input']) !!}
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                        <span class="text-primary">*</span>Last Name:
                                    </label>
                                    <div class="col-xl-8 col-lg-8">
                                        {!! Form::text('last_name', '',
                                            ['placeholder' => 'Last Name', 'required' => 'required',
                                            'class' => 'form-control m-input']) !!}
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-xl-4 col-lg-4 col-form-label">
                                        <span class="text-primary">*</span>DOB:
                                    </label>
                                    <div class="col-xl-2 col-lg-2 ">
                                        <div class="select-option">
                                            <select title="Date" name="day" required>
                                                <option value=""> Day</option>
                                                @for($i = 1; $i <= 31; $i++)
                                                    <option value="{{ $i }}">{{ $i < 10 ? '0'.$i : $i }}</option>
                                                @endfor

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3">
                                        <div class="select-option">
                                            <select title="Month" name="month" required>
                                                <option> Month</option>
                                                @for($m = 1; $m <= 12; $m++)
                                                    <option value="{{ $m < 10 ? '0'.$m : $m }}">
                                                        {{ $m < 10 ? '0'.$m : $m }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-2">
                                        <div class="select-option">
                                            <select title="Year" name="year" required>
                                                <option> Year</option>
                                                @for($y = date('Y'); $y >= 1900; $y--)
                                                    <option value="{{ $y }}">
                                                        {{ $y }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                @if($docs == 'front-back' || $docs == 'front')
                                    <div class="form-group m-form__group row" style="margin-top: 50px">
                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                            <span class="text-primary">*</span>Front Photo ID:
                                        </label>
                                        <div class="col-xl-6 col-lg-6">
                                            <input type="file" class="m-input photoId" name="front_photo"
                                                   style="padding-top: 10px"/>
                                        </div>
                                    </div>
                                @endif
                                @if($docs == 'front-back' || $docs == 'back')
                                    <div class="form-group m-form__group row">
                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                            <span class="text-primary">*</span>Back Photo ID:
                                        </label>
                                        <div class="col-xl-6 col-lg-6">
                                            <input type="file" class="m-input photoId" name="back_photo"
                                                   style="padding-top: 10px"/>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-foot">
                                    <button type="submit" class="btn btn-primary">Update Account</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end : top section -->

        </div>

    </div>

@endsection

@section('page_scripts')

@endsection
