<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title>Would you like to become trusted?</title>
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
                font-size: 18px !important;
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
    <td>
        <table cellpadding="0" width="620" class="container" align="center" cellspacing="0" border="0"
               style="margin-bottom: 30px">
            <tr>
                <td>

                    <table cellpadding="0" cellspacing="0" border="0" align="center" width="600" class="container">
                        <tr>
                            <td width="100" valign="top">&nbsp;</td>
                            <td width="400" valign="top" align="center">
                                <div class="contentEditableContainer contentImageEditable">
                                    <div class="contentEditable" align='center'>
                                        <img
                                            src="{{ asset('system-emails/Classhub-Logo-400-x-116.png') }}"
                                            width="170" height01="49" alt='Logo' data-default="placeholder"/>
                                    </div>

                                </div>
                            </td>
                            <td width="100" valign="top">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <tr>
            <td>
                <table cellpadding="0" width="600" class="container" align="center" cellspacing="0" border="4"
                       bgcolor="#fff"
                       style="border-top-left-radius:10px; border-top-right-radius:10px; -moz-box-shadow: 0 0 5px #d1d1d1; -webkit-box-shadow: 0 0 5px #d1d1d1; box-shadow: 0 0 5px #d1d1d1; border: 4px solid #E7AB4B; border-radius: 20px; margin-bottom: 100px">
                    <tr>
                        <td>

                            <table cellpadding="0" cellspacing="0" border="0" align="left" width="600"
                                   class="container">
                                <tr>
                                    <td class='movableContentContainer bgItem'>
                                        <!-- Start LOGO SECTION -->
                                        <div class='movableContent'>
                                            <table cellpadding="0" cellspacing="0" border="0" align="center"
                                                   width="600" bgcolor="#ffffff" style="border-collapse:separate;"
                                                   class="container">
                                                <tr height="10">
                                                    <td width="200">&nbsp;</td>
                                                    <td width="200">&nbsp;</td>
                                                    <td width="200">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td width="15%" valign="middle" align="left">
                                                        <div class="contentEditableContainer contentImageEditable">
                                                            <div class="contentEditable" align='left'
                                                                 style="margin-left: 30%">
                                                                <img src="{{  asset('system-emails/badge.png') }}"
                                                                     width="50" height01="49"
                                                                     alt='Logo' data-default="placeholder"/>
                                                            </div>

                                                        </div>
                                                    </td>
                                                    <td width="500" valign="top">
                                                        <h2 style="font-family:Open Sans, Arial, sans-serif; font-size: 30px">
                                                            Become Trusted</h2>
                                                    </td>
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
                                            <table cellpadding="0" cellspacing="0" border="0" align="center"
                                                   width="600" class="container">

                                                <tr>
                                                    <td width="25">&nbsp;</td>
                                                    <td width="550" align="center" style="padding-top:30px;">
                                                        <div class="contentEditableContainer contentTextEditable">
                                                            <div class="contentEditable" align='left'>
                                                                <h2 style="font-family:Open Sans, Arial, sans-serif;">
                                                                    Hi {{ $user->name }},</h2>
                                                                <h3 style="font-family:Open Sans, Arial, sans-serif;">
                                                                    Would you like to have a trusted profile on Classhub?</h3>

                                                                <p style="color:#555; font-family:Open Sans, Arial, sans-serif;
															font-size:14px; line-height:150%;">
                                                                    Having a Trusted status on Classhub means parents
                                                                    and students will have greater confidence in
                                                                    considering you as the right fit for their tuition
                                                                    requirements. You can obtain trusted status by
                                                                    submitting 2 recent references which we can
                                                                    authenticate. You can submit the references by
                                                                    logging into your account and going to your tutor
                                                                    dashboard. Once there, click on the “Become Trusted”
                                                                    area and you will be prompted to upload your
                                                                    references.
                                                                    <br><br>
                                                                    Kind Regards,<br>
                                                                    The Classhub Team.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td width="25">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td width="25"></td>
                                                    <td width="550" align="center" style="padding-top:30px;">
                                                        <img src="{{  asset('system-emails/non-trusted-profile.png') }}"
                                                             width="200"
                                                             height01="49" alt='Logo' data-default="placeholder"/>
                                                        <img src="{{  asset('system-emails/arrow-right.png') }}"
                                                             width="50" height01="50"
                                                             alt='Logo' data-default="placeholder"
                                                             style="margin-bottom: 100px"/>
                                                        <img src="{{  asset('system-emails/trusted-profile.png') }}"
                                                             width="200" height01="49"
                                                             alt='Logo' data-default="placeholder"/>
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
                                                    <td width="25">&nbsp;</td>
                                                    <td width="550" align="left"
                                                        style="padding-top:10px; padding-bottom:20px;">
                                                        <table cellpadding="0" cellspacing="0" border="0" align="center"
                                                               width="300" height="46">
                                                            <tr>
                                                                <td width="20">&nbsp;</td>
                                                                <td style="font-family:Open Sans, Arial, sans-serif; font-size: 18px; vertical-align: top; background-color: #E74B65; border-radius: 10px; text-align: center;">

                                                                    <div class="pink-button"><a
                                                                            href=" {{ route('home') }}"
                                                                            target="_blank"
                                                                            style="display: inline-block; color: #ffffff; background-color: #E74B65; border: solid 1px #E74B65; border-radius: 10px; box-sizing:border-box; cursor: pointer; text-decoration: none; font-family:Open Sans, Arial, sans-serif; font-size: 18px; font-weight: 600; margin:0; padding-top: 15px; padding-bottom:15px;">
                                                                            Become Trusted
                                                                        </a>

                                                                    </div>

                                                                </td>
                                                                <td width="25">&nbsp;</td>

                                                            </tr>

                                                            <tr>
                                                                <td width="25">&nbsp;</td>
                                                                <td width="" align="center" style="padding-bottom:px;">
                                                                    <div
                                                                        class="contentEditableContainer contentTextEditable">
                                                                        <div class="contentEditable" align='left'>

                                                                            <hr style="height:1px; width: 500px; border:none; background-color:#ddd;">
                                                                            <p style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif; font-size:14px; padding-left:5px; line-height:140%;">
                                                                                If you would like to view further
                                                                                information on our terms, policies and
                                                                                frequently asked questions, you can
                                                                                visit the following locations:<br><br>
                                                                                customer support: <a
                                                                                    href="mailto:support@classhub.ie"
                                                                                    style="text-decoration:none; color: #E74B65;">support@classhub.ie</a><br>
                                                                                Terms of Service: <a
                                                                                    href="{{ route('page.terms-conditions') }}"
                                                                                    target='_blank'
                                                                                    style="text-decoration:none; color: #E74B65;">{{ route('page.terms-conditions') }}</a><br>
                                                                                Frequently Asked Questions: <a
                                                                                    href="{{ route('page.help') }}#tutors"
                                                                                    target='_blank'
                                                                                    style="text-decoration:none; color: #E74B65;">{{ route('page.help') }}
                                                                                    #tutors</a>

                                                                            </p>

                                                                            <br>

                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td width="25">&nbsp;</td>
                                                            </tr>

                                                        </table>
                                                    </td>
                                                    <td width="20">&nbsp;</td>
                                                </tr><!--End GET STARTED button-->

                                            </table>

                                        </div>
                                        <!-- end button section -->

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
