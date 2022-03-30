<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title>New booking request</title>


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

            h3 {
                font-size: 18px !important;
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

        }


    </style>


</head>
<body>
<!-- Wrapper/Container -->
<table cellpadding="0" width="100%" cellspacing="0" border="0" id="backgroundTable" class='bgBody'
       style="margin:60px 0px 0px 0px;
            padding:0;
            width:100% !important;
            line-height: 100% !important;">
    <tr>
        <td>
            <table cellpadding="0" width="620" class="container" align="center" cellspacing="0" border="0"
                   bgcolor="#ffffff"
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

                                            <tr height="25">
                                                <td width="450">&nbsp;</td>

                                            </tr>

                                            <tr>


                                                <td width="400" valign="top" align="left">
                                                    <div class="contentEditableContainer contentImageEditable">
                                                        <div class="contentEditable" align="left" ;
                                                             style="padding-left:62px; line-height:200%;">
                                                            <h2 style="font-family:Open Sans, Arial, sans-serif; color:#fff!important; font-weight:600;">
                                                                Your tutor has sent you a booking to accept
                                                            </h2>
                                                        </div>

                                                    </div>
                                                </td>


                                                <td width="200" valign="top" align="center">
                                                    <div class="contentEditableContainer contentImageEditable">
                                                        <div class="contentEditable" align='center'>
                                                        <!--  <img
                                                                src="{{ asset('system-emails/envelop120x90.png') }}"
                                                                width="100" height="75" alt='profile picture'
                                                                data-default="placeholder"/> -->
                                                        </div>

                                                    </div>
                                                </td>


                                            </tr>


                                            <tr height="10">
                                                <td width="450">&nbsp;</td>

                                            </tr>
                                        </table>
                                    </div>

                                    <!-- end HEADER / TITLE Pink SECTION -->

                                    <!-- Start BOLD paragraph section -->
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
                                                                Hi {{ $recipient->name }},
                                                                <br/>
                                                                <br/>
                                                                You have received a booking request
                                                                from {{ $sender->name }}
                                                            </p>

                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="25">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </div>

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
                                                             style="padding-top:10px; line-height:10%;">
                                                            <p style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-weight:600;">
                                                                {{ $lesson->name }}
                                                            </p>

                                                            @foreach($lesson->classes as $class)
                                                                <h5 style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-weight:400;">
                                                                    {{ $class->day }}
                                                                    , {{  \Carbon\Carbon::parse($class->date)->format('M d, Y') }}
                                                                    &nbsp; - &nbsp;
                                                                    {{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }}
                                                                    -
                                                                    {{ \Carbon\Carbon::parse($class->end_time)->format('H:i') }}</h5>
                                                            @endforeach
                                                        </div>

                                                    </div>
                                                </td>

                                                <td width="10%">&nbsp;</td>

                                            </tr>

                                        </table>
                                    </div>

                                    <!-- end Class Details SECTION -->

                                    <!-- Start BOLD paragraph section -->
                                    <div class='movableContent' style="margin-top: 20px">
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="600"
                                               class="container">

                                            <!--Start SEE MESSAGE button-->
                                            <tr>
                                                <td width="20">&nbsp;</td>
                                                <td width="550" align="left"
                                                    style="padding-top:px; padding-bottom:20px;">
                                                    <table cellpadding="0" cellspacing="0" border="0" align="center"
                                                           width="500" height="46">
                                                        <tr>
                                                            <td width="20">&nbsp;</td>
                                                            <td style="font-family:Open Sans, Arial, sans-serif; font-size: 18px; vertical-align: top; background-color: #E74B65; border-radius: 100px; text-align: center;">

                                                                <div class="pink-button">
                                                                    <a href="{{ $messageUrl }}" target="_blank"
                                                                       style="display: inline-block; width:500px; color: #ffffff; background-color: #E74B65; border: solid 1px #E74B65; border-radius: 100px; box-sizing:border-box; cursor: pointer; text-decoration: none; font-family:Open Sans, Arial, sans-serif; font-size: 18px; font-weight: 600; margin:0; padding-top: 15px; padding-bottom:15px;">Click
                                                                        here to accept it</a>

                                                                </div>

                                                            </td>
                                                            <td width="20">&nbsp;</td>


                                                        </tr>

                                                    </table>
                                                </td>
                                                <td width="20">&nbsp;</td>
                                            </tr><!--End SEE MESSAGE button-->

                                            <tr>
                                                <td width="25">&nbsp;</td>
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
                                                <td width="25">&nbsp;</td>
                                            </tr>


                                            <tr>
                                                <td width="25">&nbsp;</td>
                                                <td width="550" align="center">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='left'>
                                                            <p style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:14px; line-height:25px;">
                                                                If you would like to view further information on our terms, policies and frequently asked questions, you can visit the following locations:<br><br>
                                                                Customer support: <a href="mailto:support@classhub.ie" style="text-decoration:none; color: #E74B65;">support@classhub.ie</a><br>
                                                                Terms of Service: <a href="{{ route('page.terms-conditions') }}" target='_blank' style="text-decoration:none; color: #E74B65;">{{ route('page.terms-conditions') }}</a><br>
                                                                Frequently Asked Questions: <a href="{{ route('page.help') }}#parents" target='_blank' style="text-decoration:none; color: #E74B65;">{{ route('page.help') }}#parents</a>

                                                            </p>
                                                        </div>
                                                    </div>

                                                </td>
                                                <td width="25">&nbsp;</td>
                                            </tr>

                                        </table>


                                    </div>

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
