<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title>Welcome to ClassHub - email after teacher sets up profile</title>


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

        @media only screen and (max-device-width: 800px) {

            p {
                font-size: 22px !important;
                line-height: 150% !important;
                margin: 1em 1em !important;
            }

            h1 {
                font-size: 35px !important;
                line-height: 170% !important;
                text-align: center!important;
            }

            h2 {
                font-size: 25px !important;
                line-height: 130% !important;
                text-align: center!important;
            }

            h3 {
                font-size: 22px !important;
                line-height: 130% !important;
                text-align: center!important;
            }

            h4 {
                font-size: 18px !important;
            }

            h5 {
                font-size: 22px !important;
                margin-left: 1.5em !important;
                margin-right: 1.5em !important;

            }

            .pink-button a {
                padding-top: 30px !important;
                padding-bottom: 25px !important;
                font-size: 30px !important;
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

                                    <!-- Start HEADER / TITLE SECTION -->
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="620"
                                               bgcolor="#FFF" style="border-collapse:separate;" class="container">
                                            <tr height="50">
                                                <td width="200">&nbsp;</td>
                                                <td width="200">&nbsp;</td>
                                                <td width="200">&nbsp;</td>
                                            </tr>


                                            <tr>
                                                <td width="50" valign="top">&nbsp;</td>
                                                <td width="500" valign="top" align="center">
                                                    <div class="contentEditableContainer contentImageEditable">
                                                        <div class="contentEditable" align='center'>
                                                            <h1 style="font-family:Open Sans, Arial, sans-serif; color:#555; font-weight:600; line-height: 170%!important">
                                                                Welcome, {{ $user->name }}!
                                                            </h1>
                                                            <h3 style="font-family:Open Sans, Arial, sans-serif; color:#555; font-weight:400;">
                                                                And thank you for completing your profile.</h3>
                                                        </div>

                                                    </div>
                                                </td>
                                                <td width="50" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td width="50" valign="top">&nbsp;</td>
                                                <td width="500" valign="top" align="center">
                                                    <div class="contentEditableContainer contentImageEditable">
                                                        <div class="contentEditable" align='center'>
                                                            <img
                                                                src="{{ asset('system-emails/online-video-tutoring.png') }}"
                                                                width="265" height="265" alt='Online Video Tutoring'
                                                                data-default="placeholder"/>
                                                        </div>

                                                    </div>
                                                </td>
                                                <td width="50" valign="top">&nbsp;</td>
                                            </tr>

                                        </table>
                                    </div>

                                    <!-- end HEADER / TITLE SECTION -->
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="600"
                                               class="container">

                                            <tr>
                                                <td width="25">&nbsp;</td>
                                                <td width="550" align="center" style="padding-top:30px;">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='center'>
                                                            <p style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:14px; line-height:150%;">
                                                                ClassHub makes it easy for you to share your knowledge
                                                                and pass on skills for life, in a way that suits you.

                                                            </p>

                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="25">&nbsp;</td>
                                            </tr>

                                        </table>

                                    </div>
                                    <!-- Start quick guide SECTION -->
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="620"
                                               style="border-collapse:separate;" class="container">

                                            <tr>

                                                <td width="10%">&nbsp;</td>


                                                <td width="80%" valign="top" align="center" bgcolor="#F9F9FF"
                                                    style="border:1px solid #EFEFEF; border-radius:6px;">

                                                    <div class="contentEditableContainer contentImageEditable">
                                                        <div class="contentEditable" align="center" ;
                                                             style="line-height:10%;">
                                                            <p style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-size:16px; font-weight:600; line-height:100%; padding-top:10px;">
                                                                Here’s a quick guide to help you start tutoring
                                                            </p>
                                                            <hr align=""
                                                                style="height:1px; width: 400px; border:none; background-color:#ddd;">



                                                            <p style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-size:16px; font-weight:600; padding-top:10px; line-height:1%;">
                                                                List for free
                                                            </p>
                                                            <h5 style="font-family:Open Sans, Arial, sans-serif; margin-left:4em; margin-right:4em; color:#555555; font-size:14px; font-weight:400; line-height:150%;">
                                                                Its quick, easy and free to list the subjects you teach.
                                                            </h5>

                                                            <p style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-size:16px; font-weight:600; padding-top:10px; line-height:1%;">
                                                                Control availability
                                                            </p>
                                                            <h5 style="font-family:Open Sans, Arial, sans-serif; margin-left:4em; margin-right:4em; color:#555555; font-size:14px; font-weight:400; line-height:150%;">
                                                                You can choose when, where and how you teach. Customise your availability to suit you.
                                                            </h5>

                                                            <p style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-size:16px; font-weight:600; padding-top:10px; line-height:1%;">
                                                                Start earning
                                                            </p>
                                                            <h5 style="font-family:Open Sans, Arial, sans-serif; margin-left:4em; margin-right:4em; color:#555555; font-size:14px; font-weight:400; line-height:150%;">
                                                                Make sure you have completed your payout details in order for you to create bookings and for STRIPE to be able to payout to you.
                                                            </h5>

                                                            <p style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-size:16px; font-weight:600; padding-top:10px; line-height:1%;">
                                                                Check your jobs board
                                                            </p>
                                                            <h5 style="font-family:Open Sans, Arial, sans-serif; margin-left:4em; margin-right:4em; color:#555555; font-size:14px; font-weight:400; line-height:150%;">
                                                                Once your profile is complete make sure to check your jobs board regularly. Parents will post tutor requests here. You can message  parents or schedule a free video call with them in order to  agree on everything before creating a  booking.
                                                            </h5>

                                                            <p style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-size:16px; font-weight:600; padding-top:10px; line-height:1%;">
                                                                Online tuition & Pre-recorded videos
                                                            </p>
                                                            <h5 style="font-family:Open Sans, Arial, sans-serif; margin-left:4em; margin-right:4em; color:#555555; font-size:14px; font-weight:400; line-height:150%;">
                                                                Our online classroom, powered by Zoom, has all the tools you need for an engaging and beneficial tuition experience.
                                                            </h5>

                                                            <p style="font-family:Open Sans, Arial, sans-serif; color:#555555; font-size:16px; font-weight:600; padding-top:10px; line-height:1%;">
                                                                Share
                                                            </p>
                                                            <h5 style="font-family:Open Sans, Arial, sans-serif; margin-left:4em; margin-right:4em; color:#555555; font-size:14px; font-weight:400; line-height:150%;">
                                                                Share your profile with your family, friends and colleagues by email, on Facebook or Whatsapp.  Let them know you are open for business!
                                                            </h5>

                                                        </div>

                                                    </div>

                                                </td>

                                                <td width="10%">&nbsp;</td>

                                            </tr>

                                        </table>
                                    </div>

                                    <!-- end quick guide SECTION -->
                                    <!-- start button section-->
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="600"
                                               class="container">

                                            <tr>
                                                <td width="25">&nbsp;</td>
                                                <td width="550" align="center" style="padding-top:10px;">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='center'>
                                                            <p style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:16px; line-height:150%; font-weight:600;">
                                                                That’s it! Why not give it a try now?

                                                            </p>

                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="25">&nbsp;</td>
                                            </tr>
                                            <!-- GET STARTED button-->
                                            <tr>
                                                <td width="20">&nbsp;</td>
                                                <td width="550" align="left"
                                                    style="padding-top:10px; padding-bottom:20px;">
                                                    <table cellpadding="0" cellspacing="0" border="0" align="center"
                                                           width="500" height="46">
                                                        <tr>
                                                            <td width="20">&nbsp;</td>
                                                            <td style="font-family:Open Sans, Arial, sans-serif; font-size: 18px; vertical-align: top; background-color: #E74B65; border-radius: 100px; text-align: center;">

                                                                <div class="pink-button"><a
                                                                        href="{{ route('educator.lesson.create') }}"
                                                                        target="_blank"
                                                                        style="display: inline-block; width:500px; color: #ffffff; background-color: #E74B65; border: solid 1px #E74B65; border-radius: 100px; box-sizing:border-box; cursor: pointer; text-decoration: none; font-family:Open Sans, Arial, sans-serif; font-size: 18px; font-weight: 600; margin:0; padding-top: 15px; padding-bottom:15px;">
                                                                        GET STARTED</a>

                                                                </div>

                                                            </td>
                                                            <td width="20">&nbsp;</td>

                                                        </tr>

                                                    </table>
                                                </td>
                                                <td width="20">&nbsp;</td>
                                            </tr>
                                            <!--End GET STARTED button-->

                                        </table>

                                    </div>
                                    <hr style="height:1px; width: 500px; border:none; background-color:#ddd;">

                                    <!-- end button section -->


                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="600"
                                               class="container">

                                            <tr>
                                                <td width="25">&nbsp;</td>
                                                <td width="550" align="left" style="padding-top:0px;">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='left'>

                                                            <p style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:11px; padding-left:5px; line-height:140%;">



                                                                If you would like to view further information on our terms, policies and frequently asked questions, you can visit the following locations:<br><br>
                                                                Customer support: <a href="mailto:support@classhub.ie" style="text-decoration:none; color: #E74B65;">support@classhub.ie</a><br>
                                                                Terms of Service: <a href="{{ route('page.terms-conditions') }}" target='_blank' style="text-decoration:none; color: #E74B65;">{{ route('page.terms-conditions') }}</a><br>
                                                                Frequently Asked Questions: <a href="{{ route('page.help') }}#tutors" target='_blank' style="text-decoration:none; color: #E74B65;">{{ route('page.help') }}#tutors</a>




                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="25">&nbsp;</td>
                                            </tr>

                                        </table>

                                    </div>

                                    {{--<hr style="height:1px; width: 500px; border:none; background-color:#ddd;">

                                    <!-- start TESTIMONIALS section-->
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="620"
                                               class="container">

                                            <tr>
                                                <td width="25">&nbsp;</td>
                                                <td width="" align="center" style="padding-top:0px;">
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='center'>
                                                            <p style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:16px; line-height:150%; font-weight:600;">
                                                                Here’s what other say

                                                            </p>

                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="25">&nbsp;</td>
                                            </tr>


                                        </table>

                                    </div>--}}
                                    <!-- end TESTIMONIALS TITLE section -->

                                    <!-- start TESTIMONIALS section-->
                                    {{--<div class='movableContent' style="max-width: 620px; margin: 0 auto;">
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="100%"
                                               class="container" style="border-collapse: collapse;">

                                            <tr>

                                                <td>

                                                    @foreach($testimonials as $testimonial)
                                                        <table class="column-1-2-3" width="160" align="left"
                                                               style="border-collapse: collapse; margin-left:60px;"
                                                               cellspacing="0" cellpadding="0" border="0">
                                                            <tr>

                                                                <td width="160" valign="top" align="left">
                                                                    <div
                                                                        class="contentEditableContainer contentImageEditable">
                                                                        <div class="contentEditable" align='center'
                                                                             style="background-color:#F9F9FF; border:1px solid #EFEFEF; border-radius:6px;">

                                                                            <img
                                                                                src="{{ \App\Helpers\ClassHubHelper::getImagePath(null, $testimonial->educator_image) }}"
                                                                                width="150" height="60"
                                                                                alt='profile picture'
                                                                                data-default="placeholder"
                                                                                style="padding-top:10px; border-bottom:2px solid #E74B65;"/>

                                                                            <p style="margin-left:6px; margin-right:6px; color:#555; font-family:Open Sans, Arial, sans-serif;
					                  		font-size:11px; line-height:150%;">
                                                                                “{{ $testimonial->content }}”

                                                                            </p>

                                                                            <h5 style="font-family:Open Sans, Arial, sans-serif; font-size:14px; color:#E74B65;">
                                                                                {{ $testimonial->name }}
                                                                                <br>

                                                                                <span
                                                                                    style="font-size:11px; color:#555;">
                                              {{ $testimonial->for }}
                                                </span>
                                                                            </h5>

                                                                        </div>

                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>

                                                    @endforeach

                                                </td>
                                            </tr>

                                        </table>

                                    </div>
                                    <br>
                                    <hr style="height:1px; width: 500px; border:none; background-color:#ddd;">--}}
                                    <!-- end TESTIMONIALS section -->


                                    <!-- start Thank you section-->
                                    <div class='movableContent'>
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="620"
                                               class="container">

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


                                        </table>

                                    </div>

                                    <!-- end thank you section -->


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


                                                            <hr style="height:1px;
        width: 500px;
         border:none;
         background-color:#ddd;">

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
