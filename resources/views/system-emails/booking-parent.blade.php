<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <meta content="telephone=no" name="format-detection">
    <title>Booking confirmation for parent + receipt</title>


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
                                                            <h2 style="font-family:Open Sans, Arial, sans-serif; color:#fff; font-weight:600; line-height:100%;">
                                                                @if($lesson->type === 'pre_recorded')
                                                                    Your video purchase is confirmed
                                                                @else
                                                                    Your booking is confirmed.
                                                                @endif
                                                            </h2>
                                                            <h4 style="font-family:Open Sans, Arial, sans-serif; color:#fff; font-weight:600; line-height:100%;">
                                                                Student Name: {{ $booking->student_name }}
                                                            </h4>
                                                            <h4 style="font-family:Open Sans, Arial, sans-serif; color:#ffffff!important; font-weight:400; line-height:150%;">
                                                                Confirmation
                                                                Code: {{  \App\Helpers\ClassHubHelper::getbookingCode($booking) }}
                                                            </h4>
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

                                    <!-- Start IMAGE SECTION -->
                                    @if($lesson->type !== 'subject')
                                        <div class='movableContent'>
                                            <table cellpadding="0" cellspacing="0" border="0" align="center" width="620"
                                                   style="border-collapse:separate;" class="container">
                                                <tr>
                                                    <td width="620" valign="top" align="left">
                                                        <div class="contentEditableContainer contentImageEditable">
                                                            <div class="contentEditable" align="left"
                                                                 style="background: url('{{ url($lessonImageUrl)}}'); background-size: cover; background-repeat: no-repeat; width: 620px; height: 213px;
                                                                     background-position: center; ">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                @endif
                                <!-- end IMAGE SECTION -->
                                    <!-- Start "Receipt from Classhub" / Receipt ID section -->
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="620"
                                               class="container">
                                            <tr>
                                                <td width="30"></td>
                                                <td width="560" align="left" style="padding-top:30px;">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='left'>
                                                            <p style="color:#555; font-family:Open Sans, Arial, sans-serif; font-size:14px; font-weight:600; line-height:50%">
                                                                Your receipt from ClassHub
                                                            </p>
                                                            <div id="booking-code">
                                                                <p style="color:#555; font-family:Open Sans, Arial, sans-serif; font-size:14px; font-weight:600; line-height:30%">
                                                                    Receipt
                                                                    ID: {{ \App\Helpers\ClassHubHelper::getbookingCode($booking) }}
                                                                    -
                                                                    {{ \Carbon\Carbon::parse($booking->created_at)->format('M d, Y') }}
                                                                    <br/>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="30"></td>
                                            </tr>
                                            <tr>
                                                <td width="30"></td>
                                                <td width="560" align="left" style="padding-top:0px;">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='right'>
                                                            <p style="color:#555; font-family:Open Sans, Arial, sans-serif; font-size:12px; line-height:20px;">
                                                                <a href="{{ route('parent.download.receipt', $booking->id) }}"
                                                                   target='_blank' style="color: #E74B65;">Download
                                                                    receipt (PDF)</a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="30"></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <!-- end "Receipt from Classhub" / booking codesection-->

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
                                                                <div class='movableContent'>
                                                                    <table cellpadding="0" cellspacing="0" border="0"
                                                                           align="left" width="70%"
                                                                           style="border-collapse:separate;"
                                                                           class="container">
                                                                        <tr>
                                                                            <td width="" valign="top" align="left">
                                                                                <div
                                                                                    class="contentEditableContainer contentImageEditable">
                                                                                    <div class="contentEditable"
                                                                                         align="left"
                                                                                         style="padding-left:px; line-height:;">
                                                                                        <p style="margin: 2em 2em 1em 1.5em; color:#555; font-family:Open Sans, Arial, sans-serif;
                              font-size:12px; line-height:20px; font-weight:600;">
                                                                                            {{ $lesson->name }} with
                                                                                            <br>
                                                                                            <a href="{{ route('page.educator', $educator->slug) }}"
                                                                                               target='_blank'
                                                                                               style="color: #E74B65; text-decoration:none; font-weight:600;">{{ $educator->firstname }}</a>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td width="" valign="top" align="center">
                                                                                <div
                                                                                    class="contentEditableContainer contentImageEditable">
                                                                                    <div class="contentEditable"
                                                                                         align='right'
                                                                                         style="margin-top:20px; width:50px; height:50px; border-radius: 100px; background: url('{{ url($photoUrl) }}'); background-size: cover; background-repeat: no-repeat; background-position: center;"></div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <hr style="border-top: 1px dashed #dddddd">
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
                                                                                         align="left">
                                                                                        <p style="margin: 1em 2em 1em 1.5em; color:#555; font-family:Open Sans, Arial, sans-serif; font-size:12px; line-height:20px;">
                                                                                            @foreach($classes as $class)
                                                                                                {{ $class->day }},
                                                                                                {{  \Carbon\Carbon::parse($class->date)->format('M d, Y') }}
                                                                                                <br>
                                                                                            @endforeach
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td width="" valign="top" align="center">
                                                                                <div
                                                                                    class="contentEditableContainer contentImageEditable">
                                                                                    <div class="contentEditable"
                                                                                         align='right'
                                                                                         style="margin-top:10px;">
                                                                                        <p style="margin: 1em 2em 1em 1.5em; color:#555; font-family:Open Sans, Arial, sans-serif; font-size:12px; line-height:20px;">
                                                                                            @if($lesson->type === 'pre_recorded')
                                                                                                {{ $booking->lesson->classes->count() }}
                                                                                                Pre-recorded class(es)
                                                                                            @else

                                                                                                @foreach($classes as $class)
                                                                                                    {{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }}
                                                                                                    -
                                                                                                    {{ \Carbon\Carbon::parse($class->end_time)->format('H:i') }}
                                                                                                    <br>
                                                                                                @endforeach
                                                                                            @endif
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
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
                                                                                         align="left"
                                                                                         style="padding-bottom:27px;">
                                                                                        <p style="margin: 0em 2em 0em 1.5em; color:#555; font-family:Open Sans, Arial, sans-serif; font-size:12px;line-height:20px;">
                                                                                            {{ $lesson->location }}
                                                                                            <br>
                                                                                            Confirmation
                                                                                            Code: {{ \App\Helpers\ClassHubHelper::getbookingCode($booking) }}
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <!--  End two columns for name, address , total classes -->
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
                                                                        <p style="margin: 2em 0em 1em 1em; color:#555; font-family:Open Sans, Arial, sans-serif; font-size:12px; line-height:20px; font-weight:600;">
                                                                            Price
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
                                                                                         align="left">
                                                                                        <p style="margin: 0em 1em 0em 1em; color:#555; font-family:Open Sans, Arial, sans-serif;
                              font-size:12px; line-height:20px;">
                                                                                            {{ count($classes) }}
                                                                                            class(es) {{ $lesson->type }}
                                                                                        </p>
                                                                                        <p style="margin: 0em 1em 0em 1em; color:#555; font-family:Open Sans, Arial, sans-serif; font-size:12px; line-height:20px;">
                                                                                            {{ $booking->customer_fee_percent }}
                                                                                            %
                                                                                            Service fee
                                                                                        </p>
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
                                                                                            € {{ number_format(\App\Helpers\ClassHubHelper::centToEuro($booking->amount - $booking->service_fee), 2) }}
                                                                                        </p>
                                                                                        <p style="margin: 0em 1em 0em 0em; color:#555555; font-family:Open Sans, Arial, sans-serif;
                              font-size:12px; line-height:20px; text-align:right;">
                                                                                            € {{ number_format(\App\Helpers\ClassHubHelper::centToEuro( $booking->service_fee), 2) }}
                                                                                        </p>
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
                                                                                         align="center">
                                                                                        <hr style="width:230px; border-top: 1px dashed #dddddd">
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
                                                                                         align="left">
                                                                                        <p style="margin: 0em 1em 0em 1em; color:#555; font-family:Open Sans, Arial, sans-serif; font-size:12px; line-height:20px; font-weight:600;">
                                                                                            Payment
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <!---start VISA card -->
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
                                                                                         align="left">
                                                                                        <p style="margin: 1em 1em 0em 1em; color:#555; font-family:Open Sans, Arial, sans-serif; font-size:12px; line-height:20px;">
                                                                                            {{ $transaction->payment_method_details->card->brand }}
                                                                                            ****{{ $transaction->payment_method_details->card->last4 }}
                                                                                            <br>
                                                                                            {{ \Carbon\Carbon::parse($booking->created_at)->format('D, M d, Y - H:i T') }}
                                                                                        </p>
                                                                                        <br>
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
                                                                                        <p style="margin: 1em 1em 0em 0em; color:#555555; font-family:Open Sans, Arial, sans-serif; font-size:12px; line-height:20px; text-align:right;">
                                                                                            € {{ number_format(\App\Helpers\ClassHubHelper::centToEuro($transaction->amount), 2) }}
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <!-- end VISA card -->
                                                                <hr style="width: 230px; border-top: 1px dashed #dddddd">
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
                                                                                         style="padding-bottom:10px;">
                                                                                        <p style="margin: 0em 1em 0em 1em; color:#555; font-family:Open Sans, Arial, sans-serif;
                              font-size:12px; line-height:20px; font-weight:600;">
                                                                                            Payment
                                                                                        </p>
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
                                                                                        <p style="margin: 0em 1em 0em 0em; color:#555555; font-family:Open Sans, Arial, sans-serif; font-size:12px; line-height:20px; text-align:right;">
                                                                                            € {{ number_format(\App\Helpers\ClassHubHelper::centToEuro($transaction->amount), 2) }}
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- END RIGHT COLUMN-->
                                                    <!--  End two columns for individual prices and total prices inside right column -->
                                                </td> <!-- main td -->
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
                                                                            <p style="color:#555; font-family:Open Sans, Arial, sans-serif; font-size:12px; line-height:20px;">
                                                                                <a href="{{ route('page.educator', $educator->slug) }}"
                                                                                   target='_blank'
                                                                                   style="color: #E74B65;">Book another
                                                                                    class with {{ $educator->name }}</a>
                                                                            </p>
                                                                            @if($lesson->type !== 'pre_recorded')
                                                                                <p style="color:#555; font-family:Open Sans, Arial, sans-serif; font-size:12px; line-height:20px;">
                                                                                    <a href="{{ route('parent.dashboard') }}"
                                                                                       target='_blank'
                                                                                       style="color: #E74B65;">Cancel
                                                                                        class</a>
                                                                                </p>
                                                                            @endif
                                                                            <p style="color:#555; font-family:Open Sans, Arial, sans-serif; font-size:12px; line-height:20px;">
                                                                                <a href="{{ route('parent.dashboard') }}"
                                                                                   target='_blank'
                                                                                   style="color: #E74B65;">Request
                                                                                    refund</a>
                                                                            </p>
                                                                            <p style="color:#555; font-family:Open Sans, Arial, sans-serif; font-size:12px; line-height:20px;">
                                                                                <a href="{{ route('page.online-tuition') }}"
                                                                                   target='_blank'
                                                                                   style="color: #E74B65;">Learn more
                                                                                    about how online tuition works on
                                                                                    ClassHub</a>
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
                                                                If you would like to view further information on our
                                                                terms, policies and frequently asked questions, you can
                                                                visit the following locations:<br><br>
                                                                Customer support: <a href="mailto:support@classhub.ie"
                                                                                     style="text-decoration:none; color: #E74B65;">support@classhub.ie</a><br>
                                                                Terms of Service: <a
                                                                    href="{{ route('page.terms-conditions') }}"
                                                                    target='_blank'
                                                                    style="text-decoration:none; color: #E74B65;">{{ route('page.terms-conditions') }}</a><br>
                                                                Frequently Asked Questions: <a
                                                                    href="{{ route('page.help') }}#parents"
                                                                    target='_blank'
                                                                    style="text-decoration:none; color: #E74B65;">{{ route('page.help') }}
                                                                    #parents</a>

                                                            </p>

                                                            <p style="color:#555; font-family:Open Sans, Arial, sans-serif;
        font-size:12px;line-height:140%; font-weight:600;">
                                                                Payment processed by Stripe Ltd,
                                                                <br>
                                                                <span style="font-weight:400;">
          1 Grand Canal Street Lower, Grand Canal Dock,
          <br>
          Dublin, D02 H210
        </span>
                                                            </p>

                                                            <hr style="height:1px; width: 560px; border:none; background-color:#ddd;">
                                                            <p style="margin: 1em 0em; color:#555; font-family:Open Sans, Arial, sans-serif;
      font-size:14px;line-height:140%;">


                                                                We make it easy for you to get in touch directly with
                                                                the tutor. To view and manage all your classes
                                                                visit My Bookings.
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
                                                                        href="{{ route('parent.dashboard') }}"
                                                                        target="_blank"
                                                                        style="display: inline-block; width:500px; height:px; color: #ffffff; background-color: #E74B65; border: solid 1px #E74B65; border-radius: 100px; box-sizing:border-box; cursor: pointer; text-decoration: none; font-family:Open Sans, Arial, sans-serif; font-size: 18px; font-weight: 600; margin:0; padding-top: 15px; padding-bottom:15px">
                                                                        @if($lesson->type === 'pre_recorded')
                                                                            VIEW VIDEO
                                                                        @else
                                                                            GO TO MY BOOKINGS
                                                                        @endif</a>
                                                                </div>


                                                            </td>

                                                        </tr>

                                                    </table>

                                                </td>
                                                <td width="30">&nbsp;</td>
                                            </tr><!--End GO TO MY DASHBOARD button-->

                                            <tr>
                                                <td width="30">&nbsp;</td>
                                                <td width="550" align="center" style="padding-top:20px;">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='left'>

                                                            <p style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:14px; line-height:140%; display: inline-block; width: 45%;">

                                                                Thanks,<br>
                                                                The ClassHub Team
                                                            </p>

                                                            <img src="{{ asset('system-emails/powered-by-zoom.png') }}" alt="powered by zoom" height="20px" style="display: inline-block; float: right; " />


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
                                                                style="font-size:11px;color:#555;font-family:Helvetica, Arial, sans-serif;line-height:200%;">Copyright &copy; ClassHub, All rights reserved.
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
