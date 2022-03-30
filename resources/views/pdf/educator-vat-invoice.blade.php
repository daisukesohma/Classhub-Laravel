<!doctype html>
<html lang="en">
<head>
    <title>VAT Receipt {{ \App\Helpers\ClassHubHelper::getbookingCode($booking) }}</title>
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
                <div class="receipt-head">
                    <img class="logo" src="{{  public_path('pdf/img/classhub-logo.png') }}" height="40px"/>
                    <h5 class="receipt-title" style="font-size: 13px">Your Vat Invoice from Classhub</h5>
                    <p class="receipt-subtitle mb-xs-0" style="font-size: 10px; line-height: 12px!important;">
                        Classhub Ltd.<br/>
                        Talent Garden, Claremont Ave,<br/>
                        Glasnevin, Dublin, D11 YNR2<br>
                        VAT ID - 03578987KH
                    </p>
                </div>
                <hr class="solid" style="margin-bottom: 0px;">
                <div class="receipt-body" style="margin-top: 0px;">
                    <div class="row">
                        <div class="col-12">
                            <h5 style="margin-top: 1px; font-size: 12px">Name : {{ $educator->name }}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h5 style="margin-top: 1px; font-size: 12px">Date of Class
                                : {{ \Carbon\Carbon::parse($class->date)->format('D, M j, Y') }}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h5 style="margin-top: 1px;font-size: 12px">Student Name: {{ $booking->student_name }}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h5 style="margin-top: 1px;font-size: 12px">Confirmation Code
                                : {{ \App\Helpers\ClassHubHelper::getbookingCode($booking) }}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h5 style="margin-top: 1px;font-size: 12px">Class Name: {{ $lesson->name }}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h5 style="margin-top: 1px;font-size: 12px">VAT Rate : 23%</h5>
                        </div>
                    </div>
                    <hr class="solid">
                    <h5 style="font-size: 12px">Classhub Fee for Use of Online Platform</h5>
                    <div class="row" style="width: 100%; display: block!important" >
                        <div class="col-6" style="width: 50%!important; display: inline-block;" >
                            <h5 class="receipt-subtitle" style="font-size: 12px;">Net Classhub Fee</h5>
                        </div>
                        <div class="col-6" style="width: 40%!important; display: inline-block;" >
                            <h5 class="receipt-subtitle" style="font-size: 12px; text-align: right!important;">
                                € {{ number_format(\App\Helpers\ClassHubHelper::centToEuro($baseServiceFee), 2) }}</h5>
                        </div>
                    </div>
                    <div class="row" style="width: 100%; display: block!important" >
                        <div style="width: 50%!important; display: inline-block;" >
                            <h5 class="receipt-subtitle" style="font-size: 12px;">VAT @ 23%</h5>
                        </div>
                        <div style="width: 40%!important; display: inline-block;" >
                            <h5 class="receipt-subtitle" style="font-size: 12px; text-align: right!important;">
                                € {{ number_format(\App\Helpers\ClassHubHelper::centToEuro($vatServiceFee),2) }}</h5>
                        </div>
                    </div>
                    <hr class="solid">
                    <div class="row" style="width: 100%; display: block!important" >
                        <div style="width: 50%!important; display: inline-block;" >
                            <h5 style="font-size: 12px">Total Classhub Fee</h5>
                        </div>
                        <div style="width: 40%!important; display: inline-block;" >
                            <h5 class="receipt-subtitle" style="font-size: 12px; text-align: right">
                                € {{ number_format(\App\Helpers\ClassHubHelper::centToEuro($serviceCharge),2) }}*</h5>
                        </div>
                    </div>
                    <hr class="solid">
                    <div class="row">
                        <div class="col-12">
                            <h6 style="font-size: 12px">Cancellations/Refunds/payments/Payouts</h6>
                            <p style="font-size: 10px">
                                For information on cancellation and refund, please see
                                <a href="{{ route('page.terms-conditions') }}#cancellation">Email us at support@classhub.ie
                                    Policy</a>
                            </p>
                            <span style="font-size: 10px">Have a question?</span><br/>
                            <p style="margin-bottom: 0px; font-size: 12px"><a href="mailto:support@classhub.ie" class="">Email us
                                    at support@classhub.ie</a></p>
                        </div>
                    </div>
                </div>
            </section>
            <section style="padding: 0px 15px; font-size: 10px">
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
