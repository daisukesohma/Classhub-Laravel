@extends('admin.layouts.master')

@section('title')
    Classhub | Export Messages

@endsection

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title ">
                    Export Messages
                </h3>
            </div>
        </div>
    </div>

    <div class="m-content">

        @include('messages.all')


        <div class="m-portlet m-portlet--full-height">


            {!! Form::open(['url' => route('admin.post.export.messages'), 'method' => 'POST',
                'class' => 'm-form m-form--fit m-form--label-align-right']) !!}

            <div class="m-portlet__body">
                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-md-2 col-sm-12 col-form-label">
                        User
                    </label>
                    <div class="col-md-7 col-sm-12">
                        {!! Form::select('user_id', $users,
                            null, ['class' => 'form-control', 'placeholder' => 'Select User', 'required' => 'required']) !!}
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-md-2 col-sm-12 col-form-label">
                        Message Type
                    </label>
                    <div class="col-md-7 col-sm-12">
                        {!! Form::select('message_type', \App\Setting::MESSAGE_TYPES,
                           null, ['class' => 'form-control', 'placeholder' => 'Select Message Type', 'required' => 'required']) !!}

                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-md-2 col-sm-12 col-form-label">
                        Date From
                    </label>
                    <div class="col-md-7 col-sm-12">
                        {!! Form::date('date_from', null, ['class' => 'form-control']) !!}

                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-md-2 col-sm-12 col-form-label">
                        Date To
                    </label>
                    <div class="col-md-7 col-sm-12">
                        {!! Form::date('date_to', null, ['class' => 'form-control']) !!}

                    </div>
                </div>

            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions">
                    <div class="row text-right">
                        <div class="col-md-7 col-sm-12">
                            <button type="submit"
                                    class="btn btn-success btn-brand m-btn m-btn--air m-btn--custom">
                                Export CSV
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection


@section('page_scripts')

    <!--begin::Page Vendors -->
    <script src="{{  asset('admin/js/jquery-ui.bundle.js') }}" type="text/javascript"></script>
    <!--end::Page Vendors -->

    <script type="text/javascript">

    </script>

@endsection
