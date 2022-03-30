<?php

return [

    'error' => 'Something went wrong, please try again',
    'login.error' => 'Incorrect Email or Password',
    'auth.required' => 'Please login or signup :text',
    'email.not_found' => 'We coudn\'t find an account associated with your email :email',
    'validation.error' => 'Mandatory fields are not complete.<br>Please review your inputs',

    'icon.ok' => '<div class="icon-ok" style="text-align: center;padding: 10px 0 20px 0;">
                            <i class="flaticon-like fs-52 color-02"></i></div>',

    'store' => ':name added successfully',
    'update' => ':name updated successfully',
    'delete' => ':name deleted successfully',

    'store.pre-recorded' => ':name added successfully. Your videos are being processed. You will get an email notification when your class goes LIVE',
    'update.pre-recorded' => ':name updated successfully. Your videos are being processed. You will get an email notification when your class goes LIVE',


    'booking.success' => 'Congratulations! Your booking is confirmed (Confirmation Code: :code)',
    'booking.error' => 'Sorry, this class is no longer available. You have not been charged.',

    'repeat_end.required' => 'Repeat end date is required for repeatable Classes',

    'setting.404' => 'Setting :name not found',
    'setting.update' => 'Settings updated successfully',

    'lesson.date.required' => 'Please select a valid Class date and time',
    'lesson.past.date' => 'Past dates/times are not allowed',
    'lesson.reported' => 'Class reported successfully',

    'profile.share.success' => ':name profile Shared Successfully.',
    'profile.share.error' => 'Sorry! Unable to share Tutor :name profile.',

    'lesson.share.success' => ':name Shared Successfully.',
    'lesson.share.error' => 'Sorry! Unable to share Class :name.',
    'lesson.paused' => 'Your class has been Paused',
    'lesson.live' => 'Your class has been set Live',
    'lesson.cancelled' => 'Your class(es) are cancelled successfully.',
    'lesson.deleted' => 'Your class has been Deleted',
    'lesson.delete.error' => 'Your class can\'t be deleted at the moment. Please cancel class and try again.',
    'lesson.booking.exist' => 'One or more class already has bookings.',

    'class.move.success' => 'Student moved to new class/date successfully.',

    'password.reset.success' => 'Password reset successfully. Please login with your new password',

    'profile.required' => 'Please setup your profile',

    'rating.error' => 'Please choose your rating for the Class(es).',
    'rating.success' => 'Thank You.',

    'refund.accept' => 'This refund is in progress',
    'refund.accept.exist' => 'This refund request has already been processed',
    'refund.reject.tutor' => 'You rejected the refund request. This request has now been sent to Classhub.',
    'refund.decline.admin' => 'Refund request declined.',
    'refund.grant.admin' => 'Refund request granted.',
    'refund.reject' => ':name has rejected the refund request. Your request has now been sent to Classhub.',
    'refund.request.success' => 'Refund request sent successfully.',

    'chat.sent' => 'Message successfully sent to :name',

    'subscribe' => 'Subscribed successfully',
    'unsubscribe' => 'Email unsubscribed',

    'crc.store' => 'CRC submitted successfully',

    'stripe-account.store' => 'Bank account added successfully',
    'profile.store' => 'Your account is now live',

    '12hr.error' => '. Cancellation is allowed only within 12hrs before class start time.
    You may request for a refund instead after the class',

    'category.missing' => '<div class="category-error">
                            <strong class="fw-5">:name</strong> doesn’t seem to be part of the subjects you teach on your initial profile set up.</div>
                                    <div class="p-t-30">You can go into <strong class="fw-5">Account Settings</strong>, Edit Profile and update the subjects you teach or we can do it for you automatically</div>
                                    <div class="row p-t-34">
                                        <div class="col-12 text-center">
                                            <a class="auto-add-category" href="javascript:void(0);"
                                            data-id=":category_id">Do it for me</a>
                                        </div>
                                    </div>',
    'category.added' => '<div class="p-t-15"><strong class="fw-5">:name</strong>  has been added to your profile</div>',

    'free-call.success' => 'Free video call scheduled successfully',
    'free-call.error' => 'You have already made the maximum 2 free video calls with this user',
];
