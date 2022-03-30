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
        .col-xs-6 {
          width: 50%;
          display: inline-block;
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
        <div class="content">
            <section id="receipt">
                <div class="row text-center">
                    <img class="logo" src="{{  public_path('pdf/img/classhub-logo.png') }}" height="40px"/>
                </div>
                <div class="row text-center">
                    <h5 class="receipt-title" style="font-weight: 500; font-size: 12px">Your receipt from Classhub</h5>
                </div>
                <div class="row text-center">
                    <span
                        class="receipt-subtitle" style="font-size: 12px">Receipt ID: {{ \App\Helpers\ClassHubHelper::getbookingCode($booking) }}
                        -
                        {{ \Carbon\Carbon::parse($booking->created_at)->format('M j, Y') }}</span>
                </div>
                <hr style="color: #000000; margin-bottom: 5px">
                <div class="receipt-body">
                    <div class="row">
                        <div class="col-xs-6">
                            <h5 style="font-size: 12px; font-weight: 600">{{ $lesson->name }} Class with
                            <a href="{{ route('page.educator', $educator->slug) }}" style="color: #e74a65; font-size: 12px;">{{ $educator->name }}</span></h5>
                        </div>
                        {{--<div class="col-xs-6">
                            <img class="round-profile" alt="Image" src="img/female-17.jpg"/>
                        </div>--}}
                    </div>
                    <h5 class="receipt-subtitle" style="font-size: 12px;">
                        @foreach($classes as $class)
                            {{ $class->day }}
                            ,
                            {{  \Carbon\Carbon::parse($class->date)->format('M d, Y') }}
                            ->
                            {{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }}
                            <br>
                        @endforeach
                    </h5>
                    <h6 class="mb0 receipt-address">{{ $lesson->location }}</h6>
                    <h6 class="mb0 confirmation-code">Confirmation
                        Code: {{ \App\Helpers\ClassHubHelper::getbookingCode($booking) }}</h6>
                    <hr class="dashed">
                    <h5>Price</h5>
                    <div class="row">
                        <div class="col-xs-6">
                            <h5 class="receipt-subtitle" style="font-size: 12px;">{{ count($classes) }}
                                class(es) {{ $lesson->type }}</h5>
                        </div>
                        <div class="col-xs-6">
                            <h5 class="receipt-subtitle" style="font-size: 12px; text-align: right">
                                € {{ number_format(\App\Helpers\ClassHubHelper::centToEuro($booking->amount - $booking->service_fee), 2) }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <h5 class="receipt-subtitle" style="font-size: 12px;">
                                {{ $booking->customer_fee_percent }}
                                % Service fee</h5>
                        </div>
                        <div class="col-xs-6">
                            <h5 class="receipt-subtitle" style="font-size: 12px; text-align: right">
                                € {{ number_format(\App\Helpers\ClassHubHelper::centToEuro( $booking->service_fee), 2) }}
                            </h5>
                        </div>
                    </div>
                    <hr class="dashed">
                    <h5>Payment</h5>
                    <div class="row">
                        <div class="col-xs-6">
                            <h5 class="receipt-subtitle"
                                style="font-size: 12px;">{{ $transaction->payment_method_details->card->brand }}
                                ****{{ $transaction->payment_method_details->card->last4 }}</h5>
                        </div>
                        <div class="col-xs-6">
                            <h5 class="receipt-subtitle" style="font-size: 12px; text-align: right">
                                € {{ number_format(\App\Helpers\ClassHubHelper::centToEuro( $booking->amount), 2) }}

                            </h5>
                        </div>
                        <div class="col-xs-12">
                            <h6 class="mb0 confirmation-code">{{ \Carbon\Carbon::parse($booking->created_at)->format('D, M d, Y - H:i T') }}</h6>
                        </div>
                        <br>

                    </div>
                    <hr class="solid">
                    <div class="row">
                        <div class="col-xs-6">
                            <h5>Amount paid (EUR)</h5>
                        </div>
                        <div class="col-xs-6">
                            <h5 class="receipt-subtitle" style="font-size: 14px; text-align: right">
                                € {{ number_format(\App\Helpers\ClassHubHelper::centToEuro( $booking->amount), 2) }}
                            </h5>
                        </div>
                    </div>
                    <hr class="solid">
                </div>
                <div class="receipt-footer">
                    <div class="row">
                        <div class="col-xs-4">
                            <a href="{{ route('home') }}">Explore Classhub</a>
                        </div>
                        <div class="col-xs-8 text-right">
                            <a href="{{ route('page.educator', $educator->slug) }}">Book another class with
                                {{ $educator->name }}</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h6>Cancellations / Refunds / Payments</h6>
                            <p>
                                For information on cancellations, payments and refunds, please see <a
                                    href="{{ route('page.terms-conditions') }}#cancellation">Read Cancellations /
                                    Refunds / Payments
                                    Policy</a>
                            </p>
                            <span>Have a question?</span><br/>
                            <p style="margin-bottom: 0px">Visit <a href="mailto:support@classhub.ie">support@classhub.ie</a></p>
                        </div>
                    </div>
                </div>
            </section>
            <section style="padding: 0px 30px;">
                <h5 class="mb-xs-0" style="font-size: 15px">Stripe Ltd.</h5>
                <p style="font-size: 12px;
							line-height: 16px;
							color: #58595B;">
                    Stripe is a limited payment collection agent of your client
                    and complies with the <a href="https://www.itgovernance.eu/en-ie/what-is-the-pci-dss-ie">Payment Card Industry Data
                        Security Standards</a> (PCI DSS)....................
                </p>
                <p style="font-size: 12px;
							line-height: 16px;
							color: #58595B;">
                    Payment processed by Stripe Ltd,
                    <br>
                    1 Grand Canal Street Lower, Grand Canal Dock,
                    <br>
                    Dublin, D02 H210
                </p>
            </section>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
</body>
</html>
