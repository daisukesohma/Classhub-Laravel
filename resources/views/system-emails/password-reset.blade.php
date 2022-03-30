<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title>Forgot Password</title>

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

        @media screen and (max-width: 600px) {
            table[class=container] {
                width: 95% !important;
            }

        }

        @media only screen and (max-device-width: 600px) {
            p {
                font-size: 25px !important;
                line-height: 150% !important;
                margin: 1em !important;
            }

            p span {
                font-size: 20px !important
            }

        }

        @media only screen and (max-device-width: 600px) {
            .social-profile img {
                width: 45px !important;
                height: 45px !important;
                padding-top: 15px !important;
            }

        }</style>
</head>
<body>
<!-- Wrapper/Container -->
<table cellpadding="0" width="100%" cellspacing="0" border="0" id="backgroundTable" class="bgBody"
       style="margin:60px 0px 0px 0px; padding:0;width:100% !important;line-height:100% !important;">
    <tr>
        <td>
            <table cellpadding="0" width="620" class="container" align="center" cellspacing="0" border="0"
                   bgcolor="#ffffff"
                   style="border-collapse:separate; border:1px solid #dddddd; border-top-left-radius:10px; border-top-right-radius:10px; -webkit-box-shadow:0 0 5px #d1d1d1;">
                <tr>
                    <td>

                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="620" class="container">
                            <tr>
                                <td class="movableContentContainer bgItem">
                                    <div class="movableContent">
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="620"
                                               bgcolor="#ffffff"
                                               style="border-collapse:separate;border:1px solid #E74B65;border-top-left-radius:10px;border-top-right-radius:10px;-webkit-box-shadow:0 3px 10px #e0e0e0;"
                                               class="container">
                                            <tr>
                                                <td width="200"> </td>
                                                <td width="200"> </td>
                                                <td width="200"> </td>
                                            </tr>
                                            <tr>
                                                <td width="100" valign="top"> </td>
                                                <td width="400" valign="top" align="center">
                                                    <div class="contentEditableContainer contentImageEditable">
                                                        <div class="contentEditable" align="center">
                                                            <img
                                                                src="{{ asset('system-emails/Classhub-Logo-400-x-116.png') }}"
                                                                width="170" alt="Logo">
                                                        </div>

                                                    </div>
                                                </td>
                                                <td width="100" valign="top"> </td>
                                            </tr>
                                            <tr>
                                                <td width="200"> </td>
                                                <td width="200"> </td>
                                                <td width="200"> </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="movableContent">
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="600"
                                               class="container">
                                            <tr>
                                                <td width="25"> </td>
                                                <td width="550" align="center" style="padding-top:30px;">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align="left">
                                                            <p style="margin:1em 2em;color:#555;font-family:'Open Sans', Arial, sans-serif;font-size:14px;line-height:25px;">
                                                                Hi {{ $user->name }},
                                                                <br>
                                                                <br>
                                                                Seems like you forgot your password for your Classhub
                                                                account.
                                                                Follow the link below to reset your password:
                                                                <br>
                                                                <br><span>
                                    <a target="_blank"
                                       href="{{ route('password.reset.link', [base64_encode($user->id), base64_encode($passwordReset->code)]) }}"
                                       style="text-decoration:none;color:#0188cb;">Click here to reset Password
                                        </a></span>
                                                                <br>
                                                                <br>
                                                                If you didn’t make this request then you can safely
                                                                ignore this email or <a
                                                                    href="mailto:support@classhub.ie"
                                                                    style="text-decoration:none;color:#E74B65;">contact
                                                                    support</a> if you have any questions.
                                                                <br>
                                                                <br>
                                                                Thanks,<br>
                                                                The Classhub Team

                                                            </p>
                                                            <hr style="height:1px; width:90%; border:none;background-color:#dddddd;">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="25"> </td>
                                            </tr>
                                            <tr>
                                                <td width="25"> </td>
                                                <td width="550" align="center">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align="left">


                                                            <p style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif; font-size:11px; padding-left:5px; line-height:140%;">
                                                                If you would like to view further information on our terms, policies and frequently asked questions, you can visit the following locations:<br><br>
                                                                customer support: <a href="mailto:support@classhub.ie" style="text-decoration:none; color: #E74B65;">support@classhub.ie</a><br>
                                                                Terms of Service: <a href="{{ route('page.terms-conditions') }}" target='_blank' style="text-decoration:none; color: #E74B65;">{{ route('page.terms-conditions') }}</a><br>
                                                                Frequently Asked Questions: <a href="{{ route('page.help') }}#tutors" target='_blank' style="text-decoration:none; color: #E74B65;">{{ route('page.help') }}#tutors</a>

                                                            </p>

                                                            <br>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="25"> </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <!-- Start FOOTER -->
                                    <div class="movableContent">
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="620"
                                               class="container" bgcolor="#F9F9FF">
                                            <tr>
                                                <td width="100%" colspan="2" style="padding-top:20px;">

                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="60%" height="70" style="padding-bottom:20px;">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align="center">


                                                            @include('system-emails.social-links')


                                                            <hr style="height:1px;width:500px;border:none;background-color:#ddd;">
                                                            <span
                                                                style="font-size:11px;color:#555;font-family:Helvetica, Arial, sans-serif;line-height:200%;">Copyright © Classhub, All rights reserved.
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
