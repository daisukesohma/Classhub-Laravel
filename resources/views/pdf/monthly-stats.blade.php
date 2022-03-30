<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title>Monthly stats report</title>
    <style type="text/css">
        .stats-report .lists .list {
            padding: 25px 16px 21px 16px;
            font-weight: 600;
            font-family: 'Montserrat', 'Raleway', "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 16px;
            line-height: 1.18;
            color: #212529;
            text-align: left;
        }

        table {
            font-weight: 600;
            font-family: 'Montserrat', 'Raleway', "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 17px;
            color: #212529;
        }

        .stats-report .lists {
            padding-top: 20px;
            width: 100%;
        }

        .col-lg-6 {
            flex: 0 0 30%;
            max-width: 50%;
        }

        .stats-report .lists .list .number, .stats-report .lists .list .number i {
            font-size: 30px;
            color: #E74B65;
            font-weight: 500;
            padding-top: 14px;
        }

        img {
            margin-right: 20px;
        }
    </style>
</head>
<body class="stats-report">

<div class="lists row" id="educator-stats">
    <table style="width: 100%">
        <tbody>

        <tr>
            <td style="text-align: center">
                <img
                    src="{{ public_path('system-emails/Classhub-Logo-400-x-116.png') }}"
                    width="170" height="49" alt='Logo'
                    data-default="placeholder"/>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td style="background-color: rgb(231, 75, 101); padding: 10px 20px">
                <h2 style="font-family:Open Sans, Arial, sans-serif; color:#fff; font-weight:600; padding-left:0; line-height:100%;">
                    Hi {{ $name }}
                </h2>
                <h4 style="color: #fff">Your monthly stats for the month of {{ $month }}</h4>
            </td>
        </tr>
        </tbody>

    </table>
    <table style="width: 100%">
        <tbody>

        <tr>
            <td>
                <!-- starts : list 01 -->
                <div class="col-lg-6">
                    <div class="list">
                        Times profile appeared in search

                        <div class="number">
                            <img
                                src="{{ public_path('system-emails/search-icon.png') }}"
                                width="25" height="25" alt="facebook">
                            {{ $numSearches }}</div>

                    </div>
                </div>
                <!-- end : list 01 -->
            </td>

            <td>
                <!-- starts : list 01 -->
                <div class="col-lg-6">
                    <div class="list">
                        Times profile was viewed
                        <div class="number"><img
                                src="{{ public_path('system-emails/view-icon.png') }}"
                                width="37" height="25" alt="facebook"> {{ $profileViews }}</div>
                    </div>
                </div>
                <!-- end : list 01 -->

            </td>
        </tr>

        <tr>
            <td>
                <!-- starts : list 01 -->
                <div class="col-lg-6">
                    <div class="list">
                        Times adverts were viewed
                        <div class="number"><img
                                src="{{ public_path('system-emails/ad-icon.png') }}"
                                width="25" height="25" alt="facebook"> {{ $lessonViews }}</div>
                    </div>
                </div>
                <!-- end : list 01 -->
            </td>
            <td>
                <!-- starts : list 01 -->
                <div class="col-lg-6">
                    <div class="list">
                        Times added to favourites
                        <div class="number"><img
                                src="{{ public_path('system-emails/favourite-icon.png') }}"
                                width="25" height="25" alt="facebook"> {{ $numLikes }}</div>
                    </div>
                </div>
                <!-- end : list 01 -->
            </td>
        </tr>
        <tr>
            <td>
                <!-- starts : list 01 -->
                <div class="col-lg-6">
                    <div class="list">
                        Average rating
                        <div class="number"><img
                                src="{{ public_path('system-emails/rating-icon.png') }}"
                                width="25" height="25" alt="facebook"> {{ $rating }}</div>
                    </div>
                </div>
                <!-- end : list 01 -->
            </td>
            <td>
                <!-- starts : list 01 -->
                <div class="col-lg-6">
                    <div class="list">
                        Total bookings
                        <div class="number"><img
                                src="{{ public_path('system-emails/booking_icon-1.png') }}"
                                width="25" height="25" alt="facebook"> {{ $numBookings }}</div>
                    </div>
                </div>
                <!-- end : list 01 -->
            </td>
        </tr>
        <tr>
            <td><!-- starts : list 01 -->
                <div class="col-lg-6">
                    <div class="list">
                        Monthly Sales
                        <div class="number">
                            <span class="euro">€</span>
                            {{ number_format(\App\Helpers\ClassHubHelper::centToEuro($avgBookingAmount), 2) }}</div>
                    </div>
                </div>
                <!-- end : list 01 -->
            </td>
            <td>
                <!-- starts : list 01 -->
                <div class="col-lg-6">
                    <div class="list">
                        Monthly Total Earnings
                        <div class="number">
                            <span class="euro">€</span>
                            {{ number_format(\App\Helpers\ClassHubHelper::centToEuro($avgEarningAmount), 2) }}</div>
                    </div>
                </div>
                <!-- end : list 01 -->
            </td>
        </tr>
        <tr>
            <td>
                <div class="col-lg-6">
                    <div class="list">
                        ClassHub Commissions Received
                        <div class="number">
                            <span class="euro">€</span>
                            {{ number_format(\App\Helpers\ClassHubHelper::centToEuro($commissionAmount), 2) }}</div>
                    </div>
                </div>
            </td>

            <td>
                <!-- starts : list 01 -->
            {{--<div class="col-lg-6">
                <div class="list">
                    Stripe Fees
                    <div class="number">
                        <span class="euro">€</span>
                        {{ number_format(\App\Helpers\ClassHubHelper::centToEuro($stripeFee), 2) }}</div>
                </div>
            </div>--}}
            <!-- end : list 01 -->
            </td>
        </tr>
        {{--<tr>
            <td>
                <div class="col-lg-6">
                    <div class="list">
                        Customer Service Charges
                        <div class="number"><i class="fa fa-euro"></i>
                            {{ number_format(\App\Helpers\ClassHubHelper::centToEuro($serviceCharge), 2) }}</div>
                    </div>
                </div>
            </td>

            <td>

            </td>
        </tr>--}}
        </tbody>

    </table>
</div>

</body>
</html>
