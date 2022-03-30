<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title>Extra Device Video call</title>


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
            .pink-button {
              font-size: 14px
            }
        }

        @media only screen and (max-device-width: 600px) {

            p {
                font-size: 16px !important;
                line-height: 150% !important;
            }

            h2 {
                font-size: 20px !important;
            }

            h3 {
                font-size: 22px !important;
                line-height: 130% !important;
            }

            h4 {
                font-size: 18px !important;
            }

            h5 {
                font-size: 22px !important;
                margin-left: 1.5em !important;
                margin-right: 1.5em !important;

            }

            .pink-button {
                width: 100% !important;
            }

            .pink-button a {
                padding-top: 30px !important;
                padding-bottom: 25px !important;
                font-size: 14px !important;
            }

            table.column-1-2-3 {
                float: none !important;
                margin-left: 25px !important;
                margin-top: 15px !important;
                width: 90% !important;

            }

            table.column-1-2-3 img {
                width: 240px !important;
                height: 96px !important;
                padding-top: 25px !important;
            }

            table.column-1-2-3 span {
                font-size: 18px !important;
                line-height: 200% !important;
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
       style="margin:60px 0px 0px 0px;
	padding:0;
	width:100% !important;
	line-height: 100% !important;">
    <tr>
        <td>
            <table cellpadding="0" width="620" class="container" align="center" cellspacing="0" border="0"
                   bgcolor="#fff"
                   style="border-top-left-radius:10px; border-top-right-radius:10px; -moz-box-shadow: 0 0 5px #d1d1d1; -webkit-box-shadow: 0 0 5px #d1d1d1; box-shadow: 0 0 5px #d1d1d1;">
                <tr>
                    <td>

                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="620" class="container">
                            <tr>
                                <td class='movableContentContainer bgItem'>
                                    <!-- Start LOGO SECTION -->
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="620"
                                               bgcolor="#ffffff" style="border-collapse:separate;" class="container">
                                            <tr height="10">
                                                <td width="200">&nbsp;</td>
                                                <td width="200">&nbsp;</td>
                                                <td width="200">&nbsp;</td>
                                            </tr>


                                            <tr>
                                                <td width="100" valign="top">&nbsp;</td>
                                                <td width="400" valign="top" align="center">
                                                    <div class="contentEditableContainer contentImageEditable">
                                                        <div class="contentEditable" align='center'>
                                                            <img
                                                                src="{{ asset('system-emails/Classhub-Logo-400-x-116.png') }}"
                                                                width="170" height01="49" alt='Logo'
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
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="600"
                                               class="container">

                                            <tr>
                                                <td width="25">&nbsp;</td>
                                                <td width="550" align="center" style="padding-top:30px;">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='left'>
                                                            <h2 style="font-family:Open Sans, Arial, sans-serif;">Hi
                                                                {{ $user->name }},</h2>
                                                            <p style="color:#555; font-family:Open Sans, Arial, sans-serif;
															font-size:14px; line-height:150%;">
                                                                Please click on the link below to join your video call with another device
                                                                <br><br>
                                                                Have a great day,<br>
                                                                The Classhub Team.

                                                            </p>

                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="25">&nbsp;</td>
                                            </tr>

                                        </table>

                                    </div>
                                    <!-- start button section-->
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="600"
                                               class="container">
                                            <!-- GET STARTED button-->
                                            <tr>
                                                <td width="20">&nbsp;</td>
                                                <td width="550" align="left"
                                                    style="padding-top:10px; padding-bottom:20px;">
                                                    <table cellpadding="0" cellspacing="0" border="0" align="center"
                                                           width="300" height="46">
                                                        <tr>
                                                            <td width="20">&nbsp;</td>
                                                            <td style="font-family:Open Sans, Arial, sans-serif; font-size: 18px; vertical-align: top; background-color: #E74B65; border-radius: 10px; text-align: center;">

                                                                <div class="pink-button"><a href="{{ route('page.video-call', $classId) }}?call_type=extra_device" target="_blank"
                                                                                            style="display: inline-block; color: #ffffff; background-color: #E74B65; border: solid 1px #E74B65; border-radius: 10px; box-sizing:border-box; cursor: pointer; text-decoration: none; font-family:Open Sans, Arial, sans-serif; font-size: 18px; font-weight: 600; margin:0; padding-top: 15px; padding-bottom:15px;">
                                                                      Join with Extra Device
                                                                    </a>

                                                                </div>

                                                            </td>
                                                            <td width="20">&nbsp;</td>

                                                        </tr>

                                                    </table>
                                                </td>
                                                <td width="20">&nbsp;</td>
                                            </tr><!--End GET STARTED button-->

                                        </table>

                                    </div>
                                    <!-- end button section -->

                                    <!-- start Thank you section-->
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="620"
                                               class="container">

                                            <tr>
                                                <td width="25">&nbsp;</td>
                                                <td width="" align="center" style="padding-top:0px;">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='center'>
                                                            <a href="#" style="margin: 1em 1em 3em; color:#555; font-family:Open Sans, Arial, sans-serif;
													font-size:14px; line-height:25px; text-align:center">
                                                                Need help accessing your call?
                                                            </a>
                                                            <br><br>
                                                            {{--<span
                                                                style="font-size:11px;color:#181818;font-family:Helvetica, Arial, sans-serif;line-height:200%;">
													<a target="_blank"
                                                       href="{{ route('page.unsubscribe', base64_encode($unsubscribeEmail)) }}"
                                                       style="color:#0188cb;">Unsubscribe</a>
                                                            </span>--}}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="25">&nbsp;</td>
                                            </tr>


                                        </table>

                                    </div>

                                    <!-- end thank you section -->

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
