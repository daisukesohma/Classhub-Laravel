<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta name="x-apple-disable-message-reformatting">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="telephone=no" name="format-detection">
  <title>Job Boards Reminder</title>


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

                <!-- end LOGO SECTION -->

                <!-- Start HEADER / TITLE PINK SECTION -->
                <div class='movableContent'>
                  <table cellpadding="0" cellspacing="0" border="0" align="center" width="620" style="border-collapse:separate;" class="container">
                    <tr height="25">
                      <td width="450">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="300" valign="top" align="left">
                        <div class="contentEditableContainer contentImageEditable">
                          <div class="contentEditable" align="left" ;
                          style="padding-left:62px; line-height:200%;">
                          <h2 style="font-family:Open Sans, Arial, sans-serif; color:#000!important; font-weight:600;">
                            Check your jobs board, reply to messages and create bookings...
                          </h2>
                        </div>

                      </div>
                    </td>
                    <td width="300" valign="top" align="center">
                      <div class="contentEditableContainer contentImageEditable">
                        <div class="contentEditable" align='center'>
                          <img
                          src="{{ asset('system-emails/message-tutorial.png') }}"
                          width="200" alt='job mail image'
                          data-default="placeholder"/>
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
                  <td width="550" align="center">
                    <div class="contentEditableContainer contentTextEditable">
                      <div class="contentEditable" align='left'>
                        <p style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif; font-size:14px; line-height:140%;">
                          Hi {{ $recipient->name }},
                          <br/>
                          <br/>
                          You can check the job board for tutoring opportunities
                          whenever you like by heading to the "Jobs Board " tab in
                          your tutor dashboard while logged in to your account.
                          <br>
                          <br>
                          If there are any students you think you are able to
                          help, send them a message to offer your services. Make
                          sure that you give them plenty of information to help
                          them make a decision - let them know how, when and where
                          you can help them.
                        </p>

                      </div>
                    </div>
                  </td>
                  <td width="25">&nbsp;</td>
                </tr>
                <tr>
                  <td width="25">&nbsp;</td>
                  <td width="550" align="center" style="padding-top:30px;">
                    <div class="contentEditableContainer contentTextEditable">
                      <div class="contentEditable" align='left'>
                        <h4 style="margin: 1em 2em; color:#000; font-family:Open Sans, Arial, sans-serif; font-size:18px; line-height:140%;">Here's how you do it...</h4>
                        <p style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif; font-size:14px; line-height:140%;">You can reply to any parent or student from your inbox by entering your
                            message and clicking on the send button <img src="{{ asset('system-emails/send-icon.png') }}" height="30px" style="vertical-align: middle">
                        </p>
                        <p style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif; font-size:14px; line-height:140%;">To create a booking, simply click on  <img src="{{ asset('system-emails/booking-button.png') }}" height="30px" style="vertical-align: middle"></p>
                        <p style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif; font-size:14px; line-height:140%;">When you click on "create booking" you need to do a few things</p>
                        <ol class="account-live-list" style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif; font-size:14px; line-height:140%;">
                            <li>Choose your subject</li>
                            <li>Select a date and time that both parties have agreed on</li>
                            <li>Add a message if needed
                            </li>
                            <li>Press send
                            </li>
                        </ol>
                        <p style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif; font-size:14px; line-height:140%;">After you press send the parent or student will be notified of your booking and be
                            prompted to make payment.</p>
                      </div>
                    </div>
                  </td>
                  <td width="25">&nbsp;</td>
                </tr>


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
                        <a href="{{ $jobBoardUrl }}" target="_blank"
                        style="display: inline-block; width:500px; color: #ffffff; background-color: #E74B65; border: solid 1px #E74B65; border-radius: 100px; box-sizing:border-box; cursor: pointer; text-decoration: none; font-family:Open Sans, Arial, sans-serif; font-size: 18px; font-weight: 600; margin:0; padding-top: 15px; padding-bottom:15px;">View
                        Jobs Board</a>

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
              <td width="550" align="center" style="padding-top:px;">
                <div class="contentEditableContainer contentTextEditable">
                  <div class="contentEditable" align='left'>
                    <p style="margin: 1em 2em; color:#555; font-family:Open Sans, Arial, sans-serif;
                    font-size:14px; line-height:25px;">

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
                  us</a> or visit our <a
                  href="{{ route('page.help') }}" target='_blank'
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
