<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title>Failed ID</title>


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
                                               bgcolor="#ffffff"
                                               style="border-collapse:separate; border:1px solid #dddddd; border-top-left-radius:10px; border-top-right-radius:10px; -moz-box-shadow: 0 3px 10px #e0e0e0; -webkit-box-shadow: 0 3px 10px #e0e0e0; box-shadow: 0 3px 10px #efefef;"
                                               class="container">
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

                                    <!-- Start HEADER / TITLE PINK SECTION -->
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="620"
                                               style="border-collapse:separate;" class="container">

                                            <tr>


                                                <td width="400" valign="top" align="left" bgcolor="#E74B65">
                                                    <div class="contentEditableContainer contentImageEditable">
                                                        <div class="contentEditable" align="left" ;
                                                             style="padding-left:62px; line-height:150%;">
                                                            <h2 style="font-family:Open Sans, Arial, sans-serif; color:#fff; font-weight:600; padding-top: 10px">
                                                                Hi, we need your assistance
                                                            </h2>
                                                        </div>

                                                    </div>
                                                </td>


                                                <td width="195" valign="top" align="center" bgcolor="#FFFFFF"
                                                    style="border: 3px solid #E74B65">
                                                    <div class="contentEditableContainer contentImageEditable">
                                                        <div class="contentEditable" align='center'>
                                                            <img src="{{  asset('img/book-icon.png') }}" width="80"
                                                                 height="80"
                                                                 alt='profile picture' data-default="placeholder"/>
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
                                                <td width="550" align="center" style="padding-bottom:0px;">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='left'>
                                                            <p style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:14px; line-height:140%;">
                                                                Hi {{ $user->name }},
                                                                <br/>
                                                                <br/>
                                                                Unfortunately we were unable to verify some of your
                                                                documents you recently uploaded on to Classhub.
                                                                <br>
                                                                This sometimes happens when the information is blurred,
                                                                obscured, or can't be read easily.
                                                                <br>
                                                                Please login to Classhub again and try updating your
                                                                documents. To do this, please click on the button below.
                                                                <br>
                                                                <br>
                                                                To upload these please click on the link below
                                                            </p>


                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="25">&nbsp;</td>
                                            </tr>

                                            <!--Start SEE PROFILE button-->
                                            <tr>
                                                <td width="20">&nbsp;</td>
                                                <td width="550" align="left"
                                                    style="padding-top:15px; padding-bottom:20px;">
                                                    <table cellpadding="0" cellspacing="0" border="0" align="center"
                                                           width="500" height="46">
                                                        <tr>
                                                            <td width="20">&nbsp;</td>
                                                            <td style="font-family:Open Sans, Arial, sans-serif; font-size: 18px; vertical-align: top; background-color: #E74B65; border-radius: 100px; text-align: center;">

                                                                <div class="pink-button"><a href="{{ $uploadLink }}"
                                                                                            target="_blank"
                                                                                            style="display: inline-block; width:500px; color: #ffffff; background-color: #E74B65; border: solid 1px #E74B65; border-radius: 100px; box-sizing:border-box; cursor: pointer; text-decoration: none; font-family:Open Sans, Arial, sans-serif; font-size: 15px; line-height: 18px; font-weight: 600; margin:0; padding-top: 15px;padding-bottom:15px;">Click here to re-upload your ID</a>

                                                                </div>

                                                            </td>
                                                            <td width="20">&nbsp;</td>


                                                        </tr>

                                                    </table>
                                                </td>
                                                <td width="20">&nbsp;</td>
                                            </tr><!--End SEE PROFILE button-->

                                            <!--hr-->
                                            <tr>
                                                <td width="20">&nbsp;</td>
                                                <td width="550" align="left" style="padding-bottom:20px;">
                                                    <table cellpadding="0" cellspacing="0" border="0" align="center"
                                                           width="500" height="">
                                                        <tr>
                                                            <td width="20">&nbsp;</td>
                                                            <td>

                                                                <hr style="height:1px; width: 500px; border:none; background-color:#ddd;">
                                                                <span
                                                                    style="font-family:Open Sans, Arial, sans-serif; font-size: 11px;">If you need help with anything please don't hesitate to <a
                                                                        href="mailto:support@classhub.ie"
                                                                        style="color: #E74B65">contact us</a> or visit our <a
                                                                        href="{{ route('page.help') }}"
                                                                        style="color: #E74B65">help</a> page.</span>
                                                            </td>
                                                            <td width="20">&nbsp;</td>

                                                        </tr>

                                                    </table>
                                                </td>
                                                <td width="20">&nbsp;</td>
                                            </tr><!--End <hr> -->

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
                                                                style="font-size:11px;color:#555;font-family:Helvetica, Arial, sans-serif;line-height:100%;">Copyright &copy; Classhub, All rights reserved.
											</span>

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
