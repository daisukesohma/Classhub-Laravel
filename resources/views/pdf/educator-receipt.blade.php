<!doctype html>
<html lang="en">
<head>
    <title>Receipt {{ \App\Helpers\ClassHubHelper::getbookingCode($booking) }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale = 1.0, maximum-scale=1.0, user-scalable=no"/>
    <link href="{{  public_path('pdf/css/theme-red.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
    <link href="{{  public_path('pdf/css/font-montserrat.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="{{  public_path('pdf/css/custom.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <style type="text/css">
        @page {
            margin: 0px;
        }

        body {
            margin: 0px;
            font-family: 'Montserrat', 'Raleway', "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-weight: 700;
        }

        .main-container {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .text-center {
            text-align: center;
        }

        .logo {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .receipt-header img {
            margin: 0 auto;
            display: block;
        }
    </style>
</head>
<body>
<div class="main-container">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <section id="receipt">
                <div class="row text-center">
                    <img class="logo" src="{{  public_path('pdf/img/classhub-logo.png') }}" height="40px"/>
                </div>
                <div class="row text-center">
                    <h5 class="receipt-title" style="font-weight: 500">Your receipt from Classhub</h5>
                </div>
                <div class="row text-center">
                    <span
                        class="receipt-subtitle">Receipt ID: {{ \App\Helpers\ClassHubHelper::getbookingCode($booking) }}
                        -
                        {{ \Carbon\Carbon::parse($booking->created_at)->format('M j, Y') }}</span>
                </div>
                <hr style="color: #000000">
                <div class="receipt-body">
                    <div class="row">
                        <div class="col-12">
                            <h5 style="margin-top: 10px;">Bookings for {{ $parent->name }}</h5>
                        </div>
                    </div>
                    <h5 style="margin-top: 10px;">Class: piano</h5>
                    <h5 class="receipt-subtitle" style="font-size: 14px;">
                        {{ $class->day }}
                        ,
                        {{  \Carbon\Carbon::parse($class->date)->format('M d, Y') }}
                        ->
                        {{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }}
                        -
                        {{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }}
                    </h5>
                    <hr class="mb24 mb-xs-0 mt-xs-24 dashed">
                    <div class="row">
                        <div class="col-6">
                            <h5 style="font-size: 12px;">{{ $parent->name }}</h5>
                        </div>
                        <div class="col-6">
                            <h5 style="font-size: 12px; text-align: right">1 class(es) total</h5>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('educator.inbox') }}" class="btn">Send a message</a>
                        </div>
                    </div>
                    <hr class="mb24 mb-xs-8 mt-xs-8 dashed">
                    <h5>Payout</h5>
                    <div class="row">
                        <div class="col-6">
                            <h5 class="receipt-subtitle" style="font-size: 14px;">
                                € {{ \App\Helpers\ClassHubHelper::centToEuro($singleClassAmount) }} x 1 class(es)</h5>
                        </div>
                        <div class="col-6">
                            <h5 class="receipt-subtitle" style="font-size: 14px; text-align: right">
                                € {{ \App\Helpers\ClassHubHelper::centToEuro($singleClassAmount) }}</h5>
                        </div>
                        <div class="col-8">
                            <h5 class="receipt-subtitle" style="font-size: 14px;">Service Fee <a
                                    href="{{ route('page.terms-conditions') }}#fees">Learn More</a></h5>
                        </div>
                        <div class="col-4">
                            <h5 class="receipt-subtitle" style="font-size: 14px; text-align: right">-
                                € {{ \App\Helpers\ClassHubHelper::centToEuro($serviceCharge) }}</h5>
                        </div>
                    </div>
                    <hr class="solid">
                    <div class="row">
                        <div class="col-8">
                            <h5>Total</h5>
                        </div>
                        <div class="col-4">
                            <h5 class="receipt-subtitle" style="font-size: 14px; text-align: right">
                                € {{ \App\Helpers\ClassHubHelper::centToEuro($payoutAmount) }}*</h5>
                        </div>
                    </div>
                    <hr class="solid">
                    <small>*Includes applicable VAT charges. <a
                            href="{{ route('educator.download.vat-receipt', [$booking->id, $class->id]) }}">Go to VAT
                            invoice.</a></small>
                </div>
                <div class="receipt-footer">
                    <div class="row">
                        <div class="col-12">
                            <a href="{{ route('educator.lesson.create') }}">List another class</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h6>Cancellations / Refunds / Payments</h6>
                            <p>
                                For information on cancellation and refund, please see
                                <a href="{{ route('page.terms-conditions') }}#cancellation">Read Cancellations / Refunds /
                                    Payments
                                    Policy</a>
                            </p>
                            <span>Have a question?</span><br/>
                            <p style="margin-bottom: 0px">Visit <a href="mailto:support@classhub.ie" class="btn">Email
                                    support</a></p>
                        </div>
                    </div>
                </div>
            </section>
            <section style="padding: 0px 30px;">
                <div class="text-center">
                    <a style="text-decoration: underline" href="{{ route('home') }}">www.classhub.ie</a>
                </div>
            </section>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
</body>
</html>
