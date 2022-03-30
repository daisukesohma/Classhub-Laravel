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
                            <h3 style="text-align: left; font-weight: normal; color: #FFF!important">Update Industry/MCC</h3>
                            <h5 class=""
                                style="font-family:Open Sans, Arial, sans-serif; font-weight: 300; font-size: 19px;color: #FFF!important;">
                                We need you to update Industry/MCC of your account for our payment partners Stripe.</h5>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 20px">
                        @include('messages.all')

                        <div class="col-md-12">
                            <form action="{{ route('post.stripe.update.mcc') }}" method="post"
                                  enctype="multipart/form-data">
                                <input type="hidden" value="{{ csrf_token() }}" name="_token">
                                <input type="hidden" value="{{ $accountId }}" name="stripe_acct_id">
                                <div class="form-group m-form__group row">
                                    <label class="col-12">
                                        <span class="text-primary">*</span>Industry:
                                    </label>
                                    <div class="col-12">
                                        {!! Form::select('industry', \App\Setting::STRIPE_MCC, null,
                                            [ 'title' => 'Industry','required' => 'required',
                                            'class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <button type="submit" class="btn btn-primary">Update</button>
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
