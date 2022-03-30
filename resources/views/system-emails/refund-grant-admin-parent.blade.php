<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title>Refund request by parent - email for teacher</title>


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

            h5 {
                font-size: 20px !important;

            }

            .social-profile img {

                width: 45px !important;
                height: 45px !important;
                padding-top: 15px !important;
            }

            .pink-button a {
                padding-top: 30px !important;
                padding-bottom: 25px !important;
                font-size: 30px !important;
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
       style="margin:60px 0px 0px 0px; padding:0; width:100% !important; line-height: 100% !important;">
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
                                               bgcolor="#ffffff" style="border-collapse:separate; border:1px solid #E74B65; border-top-left-radius:10px; border-top-right-radius:10px; -moz-box-shadow: 0 3px 10px #e0e0e0;
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


                                    <!-- Start "Hi" section -->
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="600"
                                               class="container">

                                            <tr>
                                                <td width="25">&nbsp;</td>
                                                <td width="550" align="center" style="padding-top:30px;">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='left'>
                                                            <p style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:14px; line-height:140%;">
                                                                Hi {{ $parent->name }},
                                                                <br/>
                                                                <br/>
                                                                A refund of
                                                                €{{ \App\Helpers\ClassHubHelper::centToEuro($amount) }}
                                                                has been issued to you for {{ $educator->firstname }}
                                                                ’s {{ $lesson->name }}
                                                                Class made with {{ $educator->firstname }}. While this refund is
                                                                immediate on our part,
                                                                your bank can take more time to process the refund which
                                                                is out of our control.
                                                                <br>
                                                                <br>

                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="25">&nbsp;</td>
                                            </tr>

                                        </table>

                                    </div>    <!-- end "Hi" section-->

                                    <!-- Start Class Details SECTION -->
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="620"
                                               style="border-collapse:separate;" class="container">

                                            <tr>

                                                <td width="10%">&nbsp;</td>


                                                <td width="80%" valign="top" align="center" bgcolor="#F9F9FF"
                                                    style="border:1px solid #EFEFEF; border-radius:6px;">


                                                    <div class="contentEditableContainer contentImageEditable">
                                                        <div class="contentEditable" align="center" ;
                                                             style="line-height:120%;">
                                                            <p style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-weight:600; line-height:; padding-top:10px;">
                                                                {{ $educator->firstname }}’s {{ $lesson->name }}
                                                                Class Cancellation
                                                            </p>

                                                            @foreach($lessonClasses as $class)
                                                                <h5 style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-weight:400;">
                                                                    {{ $class->day }}
                                                                    , {{  \Carbon\Carbon::parse($class->date)->format('M d, Y') }}
                                                                    &nbsp; - &nbsp;
                                                                    {{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }}
                                                                    -
                                                                    {{ \Carbon\Carbon::parse($class->end_time)->format('H:i') }}</h5>
                                                            @endforeach
                                                            <hr align=""
                                                                style="height:1px; width: 250px; border:none; background-color:#ddd;">

                                                            <p style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-weight:600;">
                                                                Amount requested: &nbsp; &nbsp;
                                                                €{{ \App\Helpers\ClassHubHelper::centToEuro($amount) }}
                                                        </div>

                                                    </div>

                                                </td>

                                                <td width="10%">&nbsp;</td>

                                            </tr>

                                        </table>
                                    </div>

                                    <!-- end Class Details SECTION -->

                                    <!-- Start "3rd paragraph / button / thank you" section-->
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="600"
                                               class="container">


                                            <tr>
                                                <td width="25">&nbsp;</td>
                                                <td width="550" align="center" style="padding-top:20px;">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='left'>
                                                            <p style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:14px; line-height:25px;">
                                                                For more information on cancellation and refunds, please
                                                                see

                                                                <a href="{{ route('page.terms-conditions') }}#fees"
                                                                   target='_blank'
                                                                   style="text-decoration:none; color: #E74B65;">Cancellation
                                                                    &amp; Refunds Policy</a> or visit our

                                                                <a href="{{ route('page.help') }}" target='_blank'
                                                                   style="text-decoration:none; color: #E74B65;">help</a>
                                                                page.


                                                                <br>
                                                                <br>
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
                                                <td width="550" align="center">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='left'>
                                                            <hr style="height:1px; width: 500px; border:none; background-color:#ddd;">


                                                            <p style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:11px; padding-left:5px; line-height:25px;">If you need help with
                                                                anything please don’t hesitate to <a
                                                                    href="mailto:support@classhub.ie"
                                                                    style="text-decoration:none; color: #E74B65;">contact
                                                                    us</a>.
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
