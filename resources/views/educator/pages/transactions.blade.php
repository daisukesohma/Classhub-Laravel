@extends('educator.layouts.master')

@section('title')
    Classhub | Educator Dashboard
@endsection

@section('page_styles')
    <style type="text/css">
        .lesson-class-name {
            width: 65%;
            display: inline-block;
        }

        .expand-arrow {
            float: right;
        }

        .class-date-row {
            margin-top: 20px;
        }

        #completed-payout-result {
            margin-top: 20px;
        }
        .copy-link:hover {
          border: none!important;
          background: none!important;
        }
    </style>

@endsection

@section('content')

    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        <div class="m-grid__item m-grid__item--fluid m-wrapper m-b-6">

            <div class="row col-12" style="margin-left:0px; margin-right:0px">

                <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12" style="margin: 0 auto;">
                    <div class="m-content page-dashboard initial-dash">

                        <div class="row title-share">
                            <div class="col-xl-6 col-lg-7 col-md-6 col-sm-12">
                                <h3 class="m-form__heading-title" style="padding-bottom: 20px">Your Tutor Dashboard</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 padding-mobile-none-lr col-eq-height">
                                <div class="row">
                                    <div class="col-lg-12 col-md-6 col-xs-ps-0">
                                        <!-- starts : Dashboard Nav  -->
                                        <div class="profile-side-nav">
                                            <div class="m-portlet">
                                                <div class="m-portlet__body">

                                                    @include('educator.includes.left-menu', ['page' => 'transactions'])

                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    {{--@if(!Auth::user()->trusted)
                                        <div class="col-lg-12 col-md-6 col-md-eq-height col-xs-ps-0">
                                            <!-- starts : Trusted Section  -->
                                            <div class="profile-side-nav">
                                                <div class="m-portlet trusted-box">
                                                    <div class="m-portlet__body">
                                                        <div class="row">
                                                            <div class="col-md-4 col-sm-3 col-xs-3">
                                                                <img class="trusted-shield"
                                                                     src="/img/trusted-by/list-a-class/batch.png"/>
                                                            </div>
                                                            <div class="col-md-8 col-sm-9 col-xs-9">
                                                                <h4>Become Trusted</h4>
                                                                <span class="subtitle">Click <a
                                                                        href="{{ route('educator.trusted') }}">here</a> to learn more</span>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                            <!-- end : Trusted Section  -->
                                            <!-- end : Dashboard Nav -->
                                        </div>
                                    @endif--}}
                                </div>

                            </div>
                            <div class="col-xl-9 col-lg-8 padding-mobile-none-lr">
                                <!--starts: Transactions -->
                                <div class="classes-table dashboard-right-table">

                                    <div class="row title-add-button">
                                        <div class="col-6">
                                            <h4 class="dashboard-header" style="margin: 0px">Transaction History</h4>
                                        </div>
                                    </div>

                                    <div>

                                        <ul class="nav nav-tabs  nav-tabs-line transaction-tabs" role="tablist">
                                            <li class="nav-item" style="width:32%">
                                                <a class="nav-link active" data-toggle="tab" href="#completed_payouts"
                                                   role="tab">Completed Payouts</a>
                                            </li>
                                            <li class="nav-item" style="width:32%">
                                                <a class="nav-link pending-tab" data-toggle="tab"
                                                   href="#upcoming_payouts"
                                                   role="tab">Upcoming Payouts</a>
                                            </li>
                                            <li class="nav-item" style="width:32%; display:flex;">
                                                <a class="nav-link earning-tab" data-toggle="tab" href="#earnings"
                                                   role="tab">Earnings</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="completed_payouts" role="tabpanel">
                                                <div class="form-group m-form__group row">
                                                    <div class="col-md-12">
                                                        <div class="col-md-5 col-xs-12" style="display: inline-block">
                                                            <label class="form-control-label">From : </label>
                                                            {!! Form::select('from_month', \App\Setting::MONTHS, date('m'), ['class' => 'form-control m-input']) !!}
                                                            {!! Form::select('from_year', $years, date('Y'), ['class' => 'form-control m-input']) !!}
                                                        </div>
                                                        <div class="col-md-5 col-xs-12" style="display: inline-block;">
                                                            <label class="form-control-label">To : </label>
                                                            {!! Form::select('to_month', \App\Setting::MONTHS, date('m'), ['class' => 'form-control m-input']) !!}
                                                            {!! Form::select('to_year', $years, date('Y'), ['class' => 'form-control m-input']) !!}
                                                        </div>
                                                        <div class="col-md-1 col-sm-6 col-xs-12"
                                                             style="display: inline-block;">
                                                            <button class="btn btn-brand filter-payout">Filter</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="completed-payout-result"></div>

                                            </div>
                                            <div class="tab-pane" id="upcoming_payouts" role="tabpanel">

                                                <div class="row">
                                                    <div class="col-md-12">

                                                    </div>
                                                </div>
                                                <div id="pending-payout-result"></div>
                                            </div>
                                            <div class="tab-pane" id="earnings" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                    </div>
                                                </div>
                                                <div id="earning-result"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--end: Transactions -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('educator.modals.share-profile')

@endsection

@section('page_scripts')

    <script src="{{  asset('js/custom.js') }}"></script>
    <script src="{{ asset('educator/assets/js/bootstrap-select.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        var loading = '<div class="text-center"><div class="spinner"></div></div>'

        $(function () {
            completedPayouts()

            //pendingPayouts()

            //totalEarning()

            $('body').on('click', 'button.filter-payout', function () {
                $('div#completed-payout-result').html(`${loading}`)

                $.ajax({
                    type: 'GET',
                    url: '{{ route('educator.comnpleted.payouts') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        from_month: $('select[name="from_month"]').val(),
                        from_year: $('select[name="from_year"]').val(),
                        to_month: $('select[name="to_month"]').val(),
                        to_year: $('select[name="to_year"]').val(),
                    },
                    dataType: 'html',
                    success: function (data) {
                        setTimeout(function () {
                            $('div#completed-payout-result').html(data)
                        }, 2000)
                    },
                    error: function (data) {
                        $('div#completed-payout-result').html(data)
                    }
                })
            })

            $('a.pending-tab').on('click', function () {
                var value = $('div#pending-payout-result').html()

                if (!value) {
                    $('div#pending-payout-result').html(`${loading}`)
                    pendingPayouts()
                }
            })

            $('a.earning-tab').on('click', function () {
                var value = $('div#earning-result').html()

                if (!value) {
                    $('div#earning-result').html(`${loading}`)
                    totalEarning()
                }
            })
        })

        function completedPayouts() {
            $('div#completed-payout-result').html(`${loading}`)

            $.ajax({
                type: 'GET',
                url: '{{ route('educator.comnpleted.payouts') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    from_month: '{{ date('m') }}',
                    from_year: '{{ date('Y') }}',
                    to_month: '{{ date('m') }}',
                    to_year: '{{ date('Y') }}',
                },
                dataType: 'html',
                success: function (data) {
                    setTimeout(function () {
                        $('div#completed-payout-result').html(data)
                    }, 2000)
                },
                error: function (data) {
                    $('div#completed-payout-result').html(data)
                }
            })

        }

        function pendingPayouts() {
            $.ajax({
                type: 'GET',
                url: '{{ route('educator.pending.payouts') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                dataType: 'html',
                success: function (data) {
                    setTimeout(function () {
                        $('div#pending-payout-result').html(data)
                    }, 2000)
                },
                error: function (data) {
                    $('div#pending-payout-result').html(data)
                }
            })

        }

        function totalEarning() {
            $.ajax({
                type: 'GET',
                url: '{{ route('educator.total-earning') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                dataType: 'html',
                success: function (data) {
                    setTimeout(function () {
                        $('div#earning-result').html(data)
                    }, 2000)
                },
                error: function (data) {
                    $('div#earning-result').html(data)
                }
            })
        }

    </script>

@endsection
