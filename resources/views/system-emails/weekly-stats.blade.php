<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title>Weekly stats report</title>


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
                font-size: 20px !important;

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
                                                <td width="80">&nbsp;</td>
                                                <td width="80">&nbsp;</td>
                                                <td width="80">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td width="80">&nbsp;</td>
                                                <td width="80">&nbsp;</td>
                                                <td width="80">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td width="80" valign="top"></td>
                                                <td width="600" valign="top" align="left">
                                                    <div class="contentEditableContainer contentImageEditable">
                                                        <div class="contentEditable" align="left">
                                                            <h2 style="font-family:Open Sans, Arial, sans-serif; color:#fff; font-weight:600; padding-left:px; line-height:100%;">
                                                                Hi {{ $educator->firstname }}
                                                            </h2>
                                                            <h5 style="font-family:Open Sans, Arial, sans-serif; color:#fff; font-weight:400;">
                                                                It’s been a week full of potential.</h5>

                                                        </div>

                                                    </div>
                                                </td>

                                                <td width="80" valign="top"></td>
                                            </tr>

                                            <tr>
                                                <td width="80">&nbsp;</td>
                                                <td width="80">&nbsp;</td>
                                                <td width="80">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td width="80">&nbsp;</td>
                                                <td width="80">&nbsp;</td>
                                                <td width="80">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <!-- end HEADER / TITLE Pink SECTION -->

                                    <!-- Start "Stats title" section -->
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="600"
                                               class="container">

                                            <tr>
                                                <td width="25">&nbsp;</td>
                                                <td width="550" align="center" style="padding-top:20px;">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='left'>
                                                            <p style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:16px; line-height:140%; font-weight:600;">
                                                                Your Classhub presence by numbers

                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="25">&nbsp;</td>
                                            </tr>

                                        </table>

                                    </div>    <!-- end "Stats title" section-->

                                    <!-- Start STATS SECTION -->
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="620"
                                               style="border-collapse:separate;" class="container">

                                            <!-- 1st row -->
                                            <tr>
                                                <td width="50%" valign="top" align="center" bgcolor="#F9F9FF"
                                                    style="border:1px solid #EFEFEF;">
                                                    <div class="contentEditableContainer contentImageEditable">
                                                        <div class="contentEditable" align="center" ;
                                                             style="padding-top:10px; line-height:150%;">
                                                            <h1 style="font-family:Open Sans, Arial, sans-serif; color:#555555;font-weight:600;">
                                                                {{ $numSearches }}&nbsp; <img
                                                                    src="{{ asset('system-emails/search-icon.png') }}"
                                                                    width="25" height="25" alt="facebook">
                                                            </h1>
                                                            <h5 style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-weight:400;">
                                                                Times profile appeared in search</h5>
                                                        </div>

                                                    </div>
                                                </td>

                                                <td width="50%" valign="top" align="center" bgcolor="#ffffff"
                                                    style="border:1px solid #EFEFEF;">
                                                    <div class="contentEditableContainer contentImageEditable">
                                                        <div class="contentEditable" align="center" ;
                                                             style="padding-top:10px; line-height:150%;">
                                                            <h1 style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-weight:600;">
                                                                {{ $profileViews }}&nbsp; <img
                                                                    src="{{ asset('system-emails/view-icon.png') }}"
                                                                    width="37" height="25" alt="facebook">
                                                            </h1>
                                                            <h5 style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-weight:400;">
                                                                Times profile was viewed</h5>
                                                        </div>

                                                    </div>
                                                </td>

                                            </tr>
                                            <!-- end 1st row -->

                                            <!-- 2nd row -->
                                            <tr>
                                                <td width="50%" valign="top" align="center" bgcolor="#ffffff"
                                                    style="border:1px solid #EFEFEF;">
                                                    <div class="contentEditableContainer contentImageEditable">
                                                        <div class="contentEditable" align="center" ;
                                                             style="padding-top:10px; line-height:150%;">
                                                            <h1 style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-weight:600;">
                                                                {{ $lessonViews }}&nbsp; <img
                                                                    src="{{  asset('system-emails/ad-icon.png') }}"
                                                                    width="33" height="25" alt="facebook">
                                                            </h1>
                                                            <h5 style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-weight:400;">
                                                                Times classes were viewed</h5>
                                                        </div>

                                                    </div>
                                                </td>

                                                <td width="50%" valign="top" align="center" bgcolor="#F9F9FF"
                                                    style="border:1px solid #EFEFEF;">
                                                    <div class="contentEditableContainer contentImageEditable">
                                                        <div class="contentEditable" align="center" ;
                                                             style="padding-top:10px; line-height:150%;">
                                                            <h1 style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-weight:600;">
                                                                {{ $numLikes }}&nbsp; <img
                                                                    src="{{ asset('system-emails/favourite-icon.png') }}"
                                                                    width="26" height="25" alt="facebook">
                                                            </h1>
                                                            <h5 style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-weight:400;">
                                                                Times profile was added to favourites</h5>
                                                        </div>

                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- end 2nd row -->

                                            <!-- 3rd row -->
                                            <tr>
                                                <td width="50%" valign="top" align="center" bgcolor="#F9F9FF"
                                                    style="border:1px solid #EFEFEF;">
                                                    <div class="contentEditableContainer contentImageEditable">
                                                        <div class="contentEditable" align="center" ;
                                                             style="padding-top:10px; line-height:150%;">
                                                            <h1 style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-weight:600;">
                                                                {{ $rating }}&nbsp; <img
                                                                    src="{{ asset('system-emails/rating-icon.png') }}"
                                                                    width="25" height="25" alt="rating">
                                                            </h1>
                                                            <h5 style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-weight:400;">
                                                                Average rating</h5>
                                                        </div>

                                                    </div>
                                                </td>

                                                <td width="50%" valign="top" align="center" bgcolor="#ffffff"
                                                    style="border:1px solid #EFEFEF;">
                                                    <div class="contentEditableContainer contentImageEditable">
                                                        <div class="contentEditable" align="center" ;
                                                             style="padding-top:10px; line-height:150%;">
                                                            <h1 style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-weight:600;">
                                                                {{ $numBookings }}&nbsp; <img
                                                                    src="{{ asset('system-emails/booking_icon-1.png') }}"
                                                                    width="25" height="25" alt="facebook">
                                                            </h1>
                                                            <h5 style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-weight:400;">
                                                                Total bookings</h5>
                                                        </div>

                                                    </div>
                                                </td>

                                            </tr>
                                            <!-- end 3rd row -->

                                            <!-- 4th row -->
                                            <tr>
                                                <td width="50%" valign="top" align="center" bgcolor="#FFFFFF"
                                                    style="border:1px solid #EFEFEF;">
                                                    <div class="contentEditableContainer contentImageEditable">
                                                        <div class="contentEditable" align="center" ;
                                                             style="padding-top:10px; line-height:150%;">
                                                            <h1 style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-weight:600;">
                                                                € {{ \App\Helpers\ClassHubHelper::centToEuro($avgBookingAmount) }}
                                                            </h1>
                                                            <h5 style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-weight:400;">
                                                                Weekly Sales
                                                            </h5>
                                                        </div>

                                                    </div>
                                                </td>

                                                <td width="50%" valign="top" align="center" bgcolor="#F9F9FF"
                                                    style="border:1px solid #EFEFEF;">
                                                    <div class="contentEditableContainer contentImageEditable">
                                                        <div class="contentEditable" align="center" ;
                                                             style="padding-top:10px; line-height:150%;">
                                                            <h1 style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-weight:600;">
                                                                € {{ \App\Helpers\ClassHubHelper::centToEuro($avgEarningAmount) }}
                                                            </h1>
                                                            <h5 style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-weight:400;">
                                                                Weekly Total Earnings</h5>
                                                        </div>

                                                    </div>
                                                </td>

                                            </tr>
                                            <!-- end 4th row -->

                                            <!-- 5th row -->
                                            <tr>
                                                <td width="50%" valign="top" align="center" bgcolor="#F9F9FF"
                                                    style="border:1px solid #EFEFEF;">
                                                    <div class="contentEditableContainer contentImageEditable">
                                                        <div class="contentEditable" align="center" ;
                                                             style="padding-top:10px; line-height:150%;">
                                                            <h1 style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-weight:600;">
                                                                € {{ \App\Helpers\ClassHubHelper::centToEuro($avgCommissionAmount) }}
                                                            </h1>
                                                            <h5 style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-weight:400;">
                                                                ClassHub Commissions Received
                                                            </h5>
                                                        </div>

                                                    </div>
                                                </td>

                                                <td width="50%" valign="top" align="center" bgcolor="#FFFFFF"
                                                    style="border:1px solid #EFEFEF;">
                                                    &nbsp;
                                                </td>

                                            </tr>
                                            <!-- end 5th row -->

                                        </table>
                                    </div>

                                    <!-- end STATS SECTION -->


                                    <!-- Start "3rd paragraph / button / thank you" section-->
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="600"
                                               class="container">

                                            <tr>
                                                <td width="25">&nbsp;</td>
                                                <td width="550" align="center" style="padding-top:20px;">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='left'>

                                                            <hr style="height:1px; width: 500px; border:none; background-color:#ddd;">
                                                            <p style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:14px; line-height:25px; font-weight:600;">
                                                                We make it easy for you to make the most of Classhub

                                                            </p>
                                                            <p style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:14px; line-height:25px;">
                                                                We’ve put together some handy tips to help you improve
                                                                your profile, get
                                                                noticed and get booked.

                                                            </p>

                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="25">&nbsp;</td>
                                            </tr>

                                            <!--Start Book class button-->
                                            <tr>
                                                <td width="20">&nbsp;</td>
                                                <td width="550" align="left">
                                                    <table cellpadding="0" cellspacing="0" border="0" align="center"
                                                           width="500" height="">
                                                        <tr>
                                                            <td style="font-family:Open Sans, Arial, sans-serif; font-size: 18px; vertical-align: top; background-color: #E74B65; border-radius:100px; text-align: center;">

                                                                <div class="pink-button"><a
                                                                        href="{{ route('educator.dashboard') }}"
                                                                        target="_blank"
                                                                        style="display: inline-block; width:400px; height:px; color: #ffffff; background-color: #E74B65; border: solid 1px #E74B65; border-radius: 100px; box-sizing:border-box; cursor: pointer; text-decoration: none; font-family:Open Sans, Arial, sans-serif; font-size: 18px; font-weight: 600; margin:0; padding-top: 15px; padding-bottom:15px">GO
                                                                        TO MY DASHBOARD</a>
                                                                </div>


                                                            </td>

                                                        </tr>

                                                    </table>

                                                </td>
                                                <td width="20">&nbsp;</td>
                                            </tr><!--End Book class button-->

                                            <tr>
                                                <td width="25">&nbsp;</td>
                                                <td width="550" align="center" style="padding-top:20px;">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='left'>

                                                            <p style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:14px; line-height:140%;">

                                                                Thanks,<br>
                                                                The Classhub Team
                                                            </p>


                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="25">&nbsp;</td>
                                            </tr>


                                            <tr>
                                                <td width="25">&nbsp;</td>
                                                <td width="550" align="center" style="padding-bottom:px;">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='left'>

                                                            <hr style="height:1px; width: 500px; border:none; background-color:#ddd;">
                                                            <p style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:11px; padding-left:5px; line-height:140%;">

                                                                If you need help with anything please don’t hesitate to
                                                                <a href="mailto:support@classhub.ie"
                                                                   style="text-decoration:none; color: #E74B65;">contact
                                                                    us</a> or visit our <a
                                                                    href="{{ route('page.help') }}"
                                                                    style="text-decoration:none; color: #E74B65;">help</a>
                                                                page.
                                                            </p>

                                                            <br>

                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="25">&nbsp;</td>
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
