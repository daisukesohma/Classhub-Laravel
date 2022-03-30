<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title>Payment receipt</title>


    <style type="text/css">


        body {
            width: 100% !important;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            margin: 0;
            padding: 0;
            background: #f7f7f7;
        }

        table td {
            border-collapse: collapse;
        }

        table {
            border-collapse: collapse;

        }

        /*MEDIA QUERIES*/
        @media screen and (max-width: 600px) {
            table[class="container"] {
                width: 95% !important;
            }
        }

        @media only screen and (max-device-width: 600px) {

            p {
                font-size: 22px !important;
                line-height: 150% !important;
                margin: 1em 1em !important;
            }

            h2 {
                font-size: 25px !important;
            }

            h4 {
                font-size: 18px !important;
            }

            h5 {
                font-size: 22px !important;
            }

            hr {

                width: 445px !important;
            }

            table.column-1-2 {
                float: none !important;
                margin-left: 25px !important;
                margin-top: 15px !important;
                width: 90% !important;

            }

            .pink-button a {
                padding-top: 30px !important;
                padding-bottom: 25px !important;
                font-size: 30px !important;
            }

            .small-pink-button a {
                width: 250px !important;
                padding-top: 15px !important;
                padding-bottom: 18px !important;
                font-size: 22px !important;

            }

            .social-profile img {
                width: 45px !important;
                height: 45px !important;
                padding-top: 15px !important;
            }

            span a {
                font-size: 18px !important;
            }
        }


    </style>


</head>
<body>
<!-- Wrapper/Container -->
<table cellpadding="0" width="100%" cellspacing="0" border="0" id="backgroundTable" class='bgBody'
       style="margin:60px 0px 0px 0px; padding:0;  width:100% !important; line-height: 100% !important;">
    <tr>
        <td>
            <table cellpadding="0" width="620" class="container" align="center" cellspacing="0" border="0"
                   bgcolor="#fff"
                   style="border-collapse:separate; border:1px solid #dddddd; border-top-left-radius:10px; border-top-right-radius:10px; -moz-box-shadow: 0 0 5px #d1d1d1; -webkit-box-shadow: 0 0 5px #d1d1d1; box-shadow: 0 0 5px #d1d1d1;">
                <tr>
                    <td>

                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="620" class="container">
                            <tr>
                                <td class='movableContentContainer bgItem'>
                                    <!-- Start LOGO SECTION -->
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="620"
                                               bgcolor="#ffffff" style="border-collapse:separate; border:1px solid #dddddd; border-top-left-radius:10px; border-top-right-radius:10px; -moz-box-shadow: 0 3px 10px #e0e0e0;
-webkit-box-shadow: 0 3px 10px #e0e0e0;
box-shadow: 0 3px 10px #efefef;" class="container">
                                            <tr height="10">
                                                <td width="200">&nbsp;</td>
                                                <td width="200">&nbsp;</td>
                                                <td width="200">&nbsp;</td>
                                            </tr>


                                            <tr>
                                                <td width="100" valign="top">&nbsp;</td>
                                                <td width="420" valign="top" align="center">
                                                    <div class="contentEditableContainer contentImageEditable">
                                                        <div class="contentEditable" align='center'>
                                                            <img
                                                                src="{{ asset('system-emails/Classhub-Logo-400-x-116.png') }}"
                                                                width="170" height="49" alt='Logo'
                                                                data-default="placeholder"/>
                                                        </div>

                                                    </div>
                                                </td>
                                                <td width="100" valign="top">&nbsp;</td>
                                            </tr>


                                            <tr height="10">
                                                <td width="200">&nbsp;</td>
                                                <td width="200">&nbsp;</td>
                                                <td width="200">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <!-- end LOGO SECTION -->

                                    <!-- Start HEADER / TITLE PINK SECTION -->
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="620"
                                               bgcolor="#E74B65" style="border-collapse:separate;" class="container">

                                            <tr>
                                                <td width="40">&nbsp;</td>
                                                <td width="40">&nbsp;</td>
                                                <td width="40">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td width="40">&nbsp;</td>
                                                <td width="40">&nbsp;</td>
                                                <td width="40">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td width="40" valign="top"></td>
                                                <td width="540" valign="top" align="left">
                                                    <div class="contentEditableContainer contentImageEditable">
                                                        <div class="contentEditable" align="left">
                                                            {{--<h2 style="font-family:Open Sans, Arial, sans-serif; color:#fff; font-weight:600; padding-left:px; line-height:100%;">
                                                                Payment is confirmed.
                                                            </h2>--}}
                                                            <h5 style="font-family:Open Sans, Arial, sans-serif; color:#fff !important; font-weight:400; line-height:150%;">
                                                                Your payout relating to the class details below is on
                                                                it’s way to your bank account. Please allow 2-3 working
                                                                days for funds to arrive.</h5>

                                                        </div>

                                                    </div>
                                                </td>


                                            </tr>

                                            <tr>
                                                <td width="40">&nbsp;</td>
                                                <td width="40">&nbsp;</td>
                                                <td width="40">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td width="40">&nbsp;</td>
                                                <td width="40">&nbsp;</td>
                                                <td width="40">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <!-- end HEADER / TITLE Pink SECTION -->


                                    <!-- Start "Receipt from Classhub" / booking codesection -->
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="620"
                                               class="container">

                                            <tr>
                                                <td width="30"></td>
                                                <td width="560" align="left" style="padding-top:30px;">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='left'>
                                                            <div id="booking-code">

                                                                <p style="color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:14px; font-weight:600; line-height:30%">
                                                                    Booking
                                                                    code: {{ \App\Helpers\ClassHubHelper::getbookingCode($booking) }}
                                                                    &nbsp;&nbsp;Class #{{ $class->id }}
                                                                    <br/>

                                                                </p>

                                                                <p style="color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:14px; font-weight:600; line-height:30%">
                                                                    Stripe Booking
                                                                    Reference: {{ $transactionId }}
                                                                    <br/>

                                                                </p>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="30"></td>
                                            </tr>

                                        </table>

                                    </div>    <!-- end "Receipt from Classhub" / booking codesection-->

                                    <!-- Start Class(es) Details SECTION -->

                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="100%"
                                               style="border-collapse:separate;" class="container">


                                            <tr> <!-- main tr -->
                                                <td> <!-- main td -->

                                                    <!-- start LEFT COLUMN -->
                                                    <table class="column-1-2" width="305" align="left"
                                                           style="border-collapse: collapse; margin-left:30px;"
                                                           cellspacing="0" cellpadding="0" border="0">
                                                        <tr>
                                                            <td width="50%" valign="top" align="left" bgcolor="ffffff"
                                                                style="border:1px solid #555555; border-radius:15px;">
                                                                <div
                                                                    class="contentEditableContainer contentImageEditable">
                                                                    <div class="contentEditable" align="left" ;
                                                                         style="padding-left:px;">
                                                                        <p style="margin: 2em 2em 1em 1.5em; color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:12px; line-height:20px; font-weight:600;">
                                                                            Booking for {{ $booking->student_name }}
                                                                            <br>
                                                                            Class: {{ $lesson->name }}
                                                                        </p>
                                                                        <hr style="border-top: 1px dashed #dddddd">
                                                                        <p style="margin: 1em 2em 1em 1.5em; color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:12px; line-height:20px;">
                                                                            {{ $class->day }}
                                                                            ,
                                                                            {{  \Carbon\Carbon::parse($class->date)->format('D, M d, Y') }}
                                                                            &nbsp; &nbsp; - &nbsp;&nbsp;
                                                                            {{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }}
                                                                            -
                                                                            {{ \Carbon\Carbon::parse($class->end_time)->format('H:i') }}
                                                                            <br>
                                                                        </p>
                                                                        <hr style="border-top: 1px dashed #dddddd">

                                                                    </div>

                                                                </div>

                                                                <!-- Satrt two columns for name, address , total classes -->
                                                                <div class='movableContent'>
                                                                    <table cellpadding="0" cellspacing="0" border="0"
                                                                           align="left" width=""
                                                                           style="border-collapse:separate;"
                                                                           class="container">


                                                                        <tr>


                                                                            <td width="" valign="top" align="left">
                                                                                <div
                                                                                    class="contentEditableContainer contentImageEditable">
                                                                                    <div class="contentEditable"
                                                                                         align="left" ;
                                                                                         style="padding-left:px; line-height:;">
                                                                                        <p style="margin: 0em 2em 0em 1.5em; color:#555; font-family:Open Sans, Arial, sans-serif;
                                                                    font-size:12px; font-weight:600; line-height:20px;">
                                                                                            {{ $parent->name }}
                                                                                            <br>
                                                                                            {{--<span
                                                                                                style="font-weight:400;">Dublin, Ireland</span>--}}

                                                                                        </p>

                                                                                    </div>

                                                                                </div>
                                                                            </td>


                                                                            <td width="" valign="top" align="center">
                                                                                <div
                                                                                    class="contentEditableContainer contentImageEditable">
                                                                                    <div class="contentEditable"
                                                                                         align='center'>
                                                                                        <p style="margin: 0em 2em 0em 4em; color:#555; font-family:Open Sans, Arial, sans-serif;
                                                                    font-size:12px; font-weight:600; line-height:20px;">
                                                                                            1 class(es) total</p>

                                                                                    </div>

                                                                                </div>
                                                                            </td>

                                                                        </tr>

                                                                    </table>
                                                                </div>

                                                                <!--  End two columns for name, address , total classes -->

                                                                <!-- start Send message Button -->
                                                                <div class='movableContent'>
                                                                    <table cellpadding="0" cellspacing="0" border="0"
                                                                           align="right" width=""
                                                                           style="border-collapse:separate;"
                                                                           class="container">


                                                                        <tr>
                                                                            <td width="" valign="top">
                                                                                <div
                                                                                    class="contentEditableContainer contentImageEditable">
                                                                                    <div class="contentEditable"
                                                                                         align='center'
                                                                                         style="margin-top:1em; margin-bottom:1.2em; margin-right:1.5em;">


                                                                                        <div class="small-pink-button">
                                                                                            <a href="{{ route('educator.inbox') }}"
                                                                                               target="_blank"
                                                                                               style="display: inline-block; width:150px; height:px; color: #ffffff; background-color: #E74B65; border: solid 1px #E74B65; border-radius: 100px; box-sizing:border-box; cursor: pointer; text-decoration: none; font-family:Open Sans, Arial, sans-serif; font-size: 12px; font-weight: 600; margin:0; padding-top: 6px; padding-bottom:6px">Send
                                                                                                a message</a>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </td>
                                                                        </tr>

                                                                    </table>
                                                                </div>
                                                                <!-- end Send maessage button -->
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- end LEFT COLUMN -->


                                                    <!-- START RIGHT COLUMN-->

                                                    <table class="column-1-2" width="250" align="left"
                                                           style="border-collapse: collapse; margin-left:5px;"
                                                           cellspacing="0" cellpadding="0" border="0">
                                                        <tr>
                                                            <td width="" valign="top" align="center" bgcolor="ffffff"
                                                                style="border:1px solid #555555; border-radius:15px;">
                                                                <div
                                                                    class="contentEditableContainer contentImageEditable">
                                                                    <div class="contentEditable" align='left'>
                                                                        <p style="margin: 2em 0em 1em 1em; color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:12px; line-height:20px; font-weight:600;">
                                                                            Payout
                                                                        </p>
                                                                    </div>

                                                                </div>


                                                                <!-- Satrt two columns for individual prices and total prices inside RIGHT COLUMN-->
                                                                <div class='movableContent'>
                                                                    <table cellpadding="0" cellspacing="0" border="0"
                                                                           align="left" width=""
                                                                           style="border-collapse:separate;"
                                                                           class="container">

                                                                        <tr>
                                                                            <td width="" valign="top" align="left">
                                                                                <div
                                                                                    class="contentEditableContainer contentImageEditable">
                                                                                    <div class="contentEditable"
                                                                                         align="left" ;
                                                                                         style="padding-left:px; line-height:;">
                                                                                        <p style="margin: 0em 1em 0em 1em; color:#555; font-family:Open Sans, Arial, sans-serif;
                                                                    font-size:12px; line-height:20px;">
                                                                                            € {{ number_format(\App\Helpers\ClassHubHelper::centToEuro($singleClassAmount), 2) }}
                                                                                            x 1 class(es)
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>

                                                                    <table cellpadding="0" cellspacing="0" border="0"
                                                                           align="right" width=""
                                                                           style="border-collapse:separate;"
                                                                           class="container">
                                                                        <tr>
                                                                            <td width="" valign="top" align="right">
                                                                                <div
                                                                                    class="contentEditableContainer contentImageEditable">
                                                                                    <div class="contentEditable"
                                                                                         align='right'>
                                                                                        <p style="margin: 0em 1em 0em 0em; color:#555555; font-family:Open Sans, Arial, sans-serif;
                                                                    font-size:12px; line-height:20px; text-align:right;">
                                                                                            € {{ number_format(\App\Helpers\ClassHubHelper::centToEuro($singleClassAmount), 2) }}</p>

                                                                                    </div>

                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>

                                                                </div>
                                                                <div class='movableContent'>
                                                                    <table cellpadding="0" cellspacing="0" border="0"
                                                                           align="left" width=""
                                                                           style="border-collapse:separate;"
                                                                           class="container">

                                                                        <tr>
                                                                            <td width="" valign="top" align="left">
                                                                                <div
                                                                                    class="contentEditableContainer contentImageEditable">
                                                                                    <div class="contentEditable"
                                                                                         align="left" ;
                                                                                         style="padding-left:px; line-height:;">
                                                                                        <p style="margin: 0em 1em 0em 1em; color:#555; font-family:Open Sans, Arial, sans-serif;
                                                                    font-size:12px; line-height:20px;">
                                                                                            Service Fee <a
                                                                                                href="{{ route('page.terms-conditions') }}#fees"
                                                                                                style="text-decoration:none; color: #E74B65;">(learn
                                                                                                more)</a>

                                                                                    </div>

                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>

                                                                    <table cellpadding="0" cellspacing="0" border="0"
                                                                           align="right" width=""
                                                                           style="border-collapse:separate;"
                                                                           class="container">
                                                                        <tr>
                                                                            <td width="" valign="top" align="right">
                                                                                <div
                                                                                    class="contentEditableContainer contentImageEditable">
                                                                                    <div class="contentEditable"
                                                                                         align='right'>
                                                                                        <p style="margin: 0em 1em 0em 0em; color:#555555; font-family:Open Sans, Arial, sans-serif;
                                                                    font-size:12px; line-height:20px; text-align:right;">
                                                                                            -€ {{ \App\Helpers\ClassHubHelper::centToEuro($serviceCharge) }}</p>
                                                                                    </div>

                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>

                                                                </div>

                                                                <!---start hr -->
                                                                <div class='movableContent'>

                                                                    <table cellpadding="0" cellspacing="0" border="0"
                                                                           align="center" width=""
                                                                           style="border-collapse:separate;"
                                                                           class="container">

                                                                        <tr>
                                                                            <td width="" valign="top" align="center">
                                                                                <div
                                                                                    class="contentEditableContainer contentImageEditable">
                                                                                    <div class="contentEditable"
                                                                                         align="center"
                                                                                         style="padding-left:px; line-height:;">

                                                                                        <hr style="width: 230px; border-top: 1px dashed #dddddd">

                                                                                    </div>

                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <!-- end hr -->
                                                                <div class='movableContent'>

                                                                    <table cellpadding="0" cellspacing="0" border="0"
                                                                           align="left" width=""
                                                                           style="border-collapse:separate;"
                                                                           class="container">

                                                                        <tr>
                                                                            <td width="" valign="top" align="left">
                                                                                <div
                                                                                    class="contentEditableContainer contentImageEditable">
                                                                                    <div class="contentEditable"
                                                                                         align="left" ;
                                                                                         style="padding-left:px; line-height:;">
                                                                                        <p style="margin: 0em 1em 0em 1em; color:#555; font-family:Open Sans, Arial, sans-serif;
                                                                    font-size:12px; line-height:20px; font-weight:600;">
                                                                                            Payment

                                                                                    </div>

                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>

                                                                    <table cellpadding="0" cellspacing="0" border="0"
                                                                           align="right" width=""
                                                                           style="border-collapse:separate;"
                                                                           class="container">
                                                                        <tr>
                                                                            <td width="" valign="top" align="right">
                                                                                <div
                                                                                    class="contentEditableContainer contentImageEditable">
                                                                                    <div class="contentEditable"
                                                                                         align='right'>
                                                                                        <p style="margin: 0em 1em 0em 0em; color:#555555; font-family:Open Sans, Arial, sans-serif;
                                                                    font-size:12px; line-height:20px; text-align:right; font-weight:600;">
                                                                                            € {{ \App\Helpers\ClassHubHelper::centToEuro($payoutAmount) }}
                                                                                            <span
                                                                                                style="color:#E74B65;">*</span>
                                                                                        </p>


                                                                                    </div>

                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>


                                                                </div>
                                                                <!---start VAT invoice -->
                                                                <div class='movableContent'>

                                                                    <table cellpadding="0" cellspacing="0" border="0"
                                                                           align="left" width=""
                                                                           style="border-collapse:separate;"
                                                                           class="container">

                                                                        <tr>
                                                                            <td width="" valign="top" align="left">
                                                                                <div
                                                                                    class="contentEditableContainer contentImageEditable">
                                                                                    <div class="contentEditable"
                                                                                         align="left"
                                                                                         style="padding-left:px; line-height:;">
                                                                                        <hr style="width: 230px; border-top: 1px dashed #dddddd">

                                                                                        <p style="margin: 0em 1em 0em 1em; color:#555555; font-family:Open Sans, Arial, sans-serif;
                                                                    font-size:12px; line-height:20px;">

                                                                                            <span
                                                                                                style="color:#E74B65;">*</span>Includes
                                                                                            applicable VAT charges. <a
                                                                                                href="{{ route('educator.download.vat-receipt', [$booking->id, $class->id]) }}"
                                                                                                style="text-decoration:none; color: #E74B65;">Go
                                                                                                to VAT invoice</a>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <!-- end VAT invoice -->


                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- END RIGHT COLUMN-->
                                                    <!--  End two columns for individual prices and total prices inside right column -->


                                                <td> <!-- main td -->
                                            </tr>  <!--main tr-->


                                        </table>
                                    </div>

                                    <!-- end Receipt Details SECTION -->

                                    <div class='movableContent'>

                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="100%"
                                               class="container" style="border-collapse: collapse;">
                                            <tr>
                                                <td>

                                                    <table cellpadding="0" cellspacing="0" border="0" align="left"
                                                           width="" style="border-collapse:separate; margin-top:10px;"
                                                           class="container">


                                                        <tr>

                                                            <td width="30">&nbsp;</td>

                                                            <td width="560" valign="top" align="">
                                                                <div
                                                                    class="contentEditableContainer contentImageEditable">
                                                                    <div class="contentEditable" align="left" ;>
                                                                        <div class="list-another-class"
                                                                             style="text-align:left;">
                                                                            <p style="color:#555; font-family:Open Sans, Arial, sans-serif;
                                                                    font-size:12px; line-height:20px;">

                                                                                <a href="{{ route('educator.lesson.create') }}"
                                                                                   target='_blank'
                                                                                   style="color: #E74B65;">List another
                                                                                    class</a>
                                                                            </p>
                                                                            <p style="color:#555; font-family:Open Sans, Arial, sans-serif;
                                                                    font-size:12px; line-height:20px;">
                                                                                For more information on Fees and
                                                                                Payouts, please see <a
                                                                                    href="{{ route('page.terms-conditions') }}#fees">Fees
                                                                                    and Payouts
                                                                                    policy.</a>
                                                                            </p>
                                                                        </div>


                                                                    </div>

                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>


                                                </td>
                                            </tr>
                                        </table>

                                    </div>


                                    <!-- Start "3rd paragraph / button / thank you" section-->
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="600"
                                               class="container">

                                            <tr>
                                                <td width="30">&nbsp;</td>
                                                <td width="560" align="center">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='left'>
                                                            <p style="color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:12px;line-height:140%;">


                                                                For information on cancellation and refund, please see

                                                                <a href="{{ route('page.terms-conditions') }}#cancellation"
                                                                   target='_blank'
                                                                   style="text-decoration:none; color: #E74B65;">Cancellation
                                                                    &amp; Refunds policy</a> or visit our <a
                                                                    href="{{ route('page.help') }}"
                                                                    target='_blank'
                                                                    style="text-decoration:none; color: #E74B65;">help</a>
                                                                page.
                                                            </p>


                                                            <hr style="height:1px; width: 560px; border:none; background-color:#ddd;">
                                                            <p style="margin: 1em 0em; color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:14px;line-height:140%;">
                                                                We make it easy for you to get in touch directly with
                                                                the parent. Visit your Classhub dashboard to view and
                                                                manage all your bookings.
                                                            </p>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="30">&nbsp;</td>
                                            </tr>


                                            <!--Start GO TO MY DASHBOARD button-->
                                            <tr>
                                                <td width="30">&nbsp;</td>
                                                <td width="560" align="left">
                                                    <table cellpadding="0" cellspacing="0" border="0" align="center"
                                                           width="560" height="">
                                                        <tr>
                                                            <td style="font-family:Open Sans, Arial, sans-serif; font-size: 18px; vertical-align: top; background-color: #E74B65; border-radius: 100px; text-align: center;">

                                                                <div class="pink-button"><a
                                                                        href="{{ route('educator.dashboard') }}"
                                                                        target="_blank"
                                                                        style="display: inline-block; width:500px; height:px; color: #ffffff; background-color: #E74B65; border: solid 1px #E74B65; border-radius: 100px; box-sizing:border-box; cursor: pointer; text-decoration: none; font-family:Open Sans, Arial, sans-serif; font-size: 18px; font-weight: 600; margin:0; padding-top: 15px; padding-bottom:15px">GO
                                                                        TO MY DASHBOARD</a>
                                                                </div>


                                                            </td>

                                                        </tr>

                                                    </table>

                                                </td>
                                                <td width="30">&nbsp;</td>
                                            </tr><!--End GO TO MY DASHBOARD button-->

                                            <tr>
                                                <td width="30">&nbsp;</td>
                                                <td width="560" align="center" style="padding-top:20px;">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='left'>

                                                            <p style="color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:14px; line-height:140%;">


                                                                Thanks,<br>
                                                                The Classhub Team
                                                            </p>


                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="30">&nbsp;</td>
                                            </tr>


                                            <tr>
                                                <td width="30">&nbsp;</td>
                                                <td width="560" align="center" style="padding-bottom:px;">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='left'>

                                                            <hr style="height:1px; width: 560px; border:none; background-color:#ddd;">
                                                            <p style="color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:12px; line-height:140%;">

                                                                If you need help with anything please don’t hesitate to
                                                                <a href="mailto:support@classhub.ie"
                                                                   style="text-decoration:none; color: #E74B65;">contact
                                                                    us</a>.
                                                            </p>

                                                            <br>

                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="30">&nbsp;</td>
                                            </tr>

                                        </table>

                                    </div>
                                    <!-- END "3rd paragraph / button / thank you" section-->


                                    <!-- Start FOOTER -->
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="620"
                                               class="container" bgcolor="#F9F9FF">
                                            <tr>
                                                <td width="100%" colspan="2" style="padding-top:20px;">

                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="60%" height="70" valign="center"
                                                    style="padding-bottom:20px;">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='center'>

                                                            @include('system-emails.social-links')

                                                            <hr style="height:1px; width: 500px; border:none; background-color:#dddddd;">

                                                            <span
                                                                style="font-size:11px;color:#555;font-family:Helvetica, Arial, sans-serif;line-height:200%;">Copyright &copy; Classhub, All rights reserved.
											</span>
                                                            <br>
                                                            {{--<span
                                                                style="font-size:11px;color:#181818;font-family:Helvetica, Arial, sans-serif;line-height:200%;">
											<a target="_blank"
                                               href="{{ route('page.unsubscribe', base64_encode($unsubscribeEmail)) }}"
                                               style="color:#0188cb;">Unsubscribe</a>
                                                            </span>--}}

                                                        </div>
                                                    </div>
                                                </td>


                                            </tr>
                                        </table>
                                    </div>
                                    <!-- END FOOTER -->


                                </td>
                            </tr>
                        </table>


                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
<!-- End of wrapper table -->
</body>
</html>
