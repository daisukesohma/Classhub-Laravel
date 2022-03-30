<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authenticated user routes
Route::group(['middleware' => 'auth'], function () {
    
    // Book a class
    Route::post('lesson/book', ['as' => 'book.lesson', 'uses' => 'BookingController@store']);
    
    // Lesson
    Route::post('lessons/{id}', ['as' => 'lesson.update', 'uses' => 'LessonController@update']);
    
    Route::get('lessons/{id}', ['as' => 'lesson.retrieve', 'uses' => 'LessonController@retrieve']);
    
    Route::post('lessons/{id}/status', ['as' => 'lesson.update.status', 'uses' => 'LessonController@updateStatus']);
    
    // Chat and Messages
    Route::post('send/message', ['as' => 'chat.send.message', 'uses' => 'MessageController@store']);

    // Download chat file
    Route::get('download/message/{message_id}', ['as' => 'chat.download.message', 'uses' => 'MessageController@downloadMessage']);
    
    // Like and Unlike Educator
    Route::post('educators/{id}/like', ['as' => 'like.educator', 'uses' => 'EducatorController@like']);
    
    Route::post('educators/{id}/unlike', ['as' => 'unlike.educator', 'uses' => 'EducatorController@unlike']);
    
    // Like and unlike Class
    Route::post('lessons/{id}/like', ['as' => 'like.lesson', 'uses' => 'LessonController@like']);
    
    Route::post('lessons/{id}/unlike', ['as' => 'unlike.lesson', 'uses' => 'LessonController@unlike']);
    
    Route::get('test-payment', 'FrontPageController@testPayment');
    
    Route::post('test-payment', ['as' => 'stripe.payment', 'uses' => 'FrontPageController@processPayment']);
    
    Route::post('intercom/{id}/{status}', ['as' => 'intercom.update', 'uses' => 'UserController@intercomOptInOut']);
    
    Route::delete('account/{id}', ['as' => 'delete.account', 'uses' => 'UserController@deleteAccount']);
    
    Route::post('report-lesson/{id}', ['as' => 'report.lesson', 'uses' => 'LessonController@report']);
    
    Route::post('crc', ['as' => 'educator.crc.store', 'uses' => 'EducatorController@crcStore']);
    
    Route::post('schedule-call', ['as' => 'schedule.call', 'uses' => 'MessageController@scheduleCall']);
    
    Route::post('schedule-call-accept', ['as' => 'schedule.call.accept', 'uses' => 'MessageController@scheduleCallAccept']);
    
    Route::post('validate-profile-info', ['as' => 'post.validate.profile', 'uses' => 'UserController@validateProfileInfoAndSave']);
    
    Route::post('validate-payout-info', ['as' => 'post.validate.payout', 'uses' => 'StripeController@validateAllFields']);
    
    Route::post('send-email-intercom', ['as' => 'send.email.intercom', 'uses' => 'SocialController@sendEmailAndIntercom']);
    
    Route::get('recommended-tutors/{query_string?}', ['as' => 'recommended.tutors', 'uses' => 'FrontPageController@recommendedTutors']);
    
    Route::post('chat/{id}/messages', ['as' => 'chat.messages', 'uses' => 'ChatController@messages']);
    
    Route::get('twilio-token', ['as' => 'twilio.token', 'uses' => 'UserController@getTwilioToken']);
    
    Route::post('call-completed', ['as' => 'free-call.completed', 'uses' => 'FreeVideoCallController@completed']);
    
    Route::post('log-call-error', ['as' => 'log.video.error', 'uses' => 'FrontPageController@logVideoError']);
    
    Route::post('vimeo/upload', ['as' => 'vimeo.upload', 'uses' => 'VimeoController@upload']);

    Route::post('vimeo/re-upload', ['as' => 'vimeo.re-upload', 'uses' => 'VimeoController@reUpload']);

    Route::delete('vimeo/delete/{id}', ['as' => 'vimeo.delete', 'uses' => 'VimeoController@delete']);

    // Parent Dashboard Routes
    Route::group(['middleware' => 'user', 'prefix' => 'dashboard/parent'], function () {
        // Update account
        Route::post('update-account', ['as' => 'parent.update.account', 'uses' => 'UserController@updateAccount']);
        
        Route::get('/', ['as' => 'parent.dashboard', 'uses' => 'ParentPageController@index']);
        
        //Route::get('inbox', ['as' => 'parent.inbox', 'uses' => 'ParentPageController@inbox']);
        Route::get('inbox/{chat_id?}', ['as' => 'parent.inbox', 'uses' => 'ParentPageController@inbox']);
        
        
        Route::get('inbox/{id}/messages', ['as' => 'parent.inbox.message',
            'uses' => 'ParentPageController@messages']);
        
        Route::get('favourites', ['as' => 'parent.favourites', 'uses' => 'ParentPageController@favourites']);
        
        Route::get('today-classes', ['as' => 'parent.today.classes', 'uses' => 'ParentPageController@todayClasses']);
        
        Route::get('tutor-requests', ['as' => 'parent.tutor.requests', 'uses' => 'ParentPageController@tutorRequests']);
        
        Route::get('favourite/tutors', ['as' => 'parent.favourite.educators',
            'uses' => 'ParentPageController@favouriteEducators']);
        
        Route::get('favourite/classes', ['as' => 'parent.favourite.lessons',
            'uses' => 'ParentPageController@favouriteLessons']);
        
        Route::get('booking/{id}/refund-request', ['as' => 'parent.refund.request',
            'uses' => 'ParentPageController@refundRequest']);
        
        Route::post('booking/refund-request', ['as' => 'parent.post.refund.request',
            'uses' => 'BookingController@requestRefund']);
        
        Route::post('card/{id}/delete', ['as' => 'parent.delete.card',
            'uses' => 'StripeController@deleteCard']);
        
        Route::post('card/{id}/default', ['as' => 'parent.default.card',
            'uses' => 'StripeController@setDefaultCard']);
        
        Route::post('payment-method', ['as' => 'parent.add.card',
            'uses' => 'UserController@addCustomerCard']);
        
        Route::get('account-settings', ['as' => 'parent.account.settings',
            'uses' => 'ParentPageController@accountSettings']);
        
        Route::post('booking/{id}/send-receipt-parent', ['as' => 'parent.get.receipt',
            'uses' => 'BookingController@sendReceiptParent']);
        
        Route::post('lessons/{id}/rating', ['as' => 'parent.lesson.rating.store',
            'uses' => 'LessonRatingController@store']);
        
        Route::get('lessons/{id}/rating', ['as' => 'parent.lesson.rating',
            'uses' => 'LessonRatingController@retrieve']);
        
        Route::post('lesson/{lesson_id}/booking/{booking_id}/cancel',
            ['as' => 'parent.cancel.booking', 'uses' => 'BookingController@cancelBooking']);
        
        Route::post('subject/booking/reject', ['as' => 'subject.booking.reject',
            'uses' => 'BookingController@rejectSubjectBooking']);
    
        Route::delete('tutor-requests', ['as' => 'parent.tutor-request.delete',
            'uses' => 'ParentPageController@deleteTutorRequest']);
        
        Route::delete('tutor-requests-all', ['as' => 'parent.tutor-request.delete-all',
            'uses' => 'ParentPageController@deleteAllTutorRequest']);
    });
    
    // Educator Dashboard Routes
    Route::group(['middleware' => 'user', 'prefix' => 'dashboard/educator'], function () {
        
        Route::get('profile/create/{type?}', ['as' => 'educator.profile.create',
            'uses' => 'EducatorPageController@createProfile']);
        
        Route::get('lesson/create', ['as' => 'educator.lesson.create',
            'uses' => 'EducatorPageController@createLesson']);
        
        Route::get('lessons/{id}', ['as' => 'lesson.retrieve', 'uses' => 'LessonController@retrieve']);
        
        Route::get('lessons/{id}/details-modal', ['as' => 'lesson.details.modal',
            'uses' => 'LessonController@getLessonDetailsModal']);
        
        Route::get('subject/{id}/details-modal', ['as' => 'subject.details.modal',
            'uses' => 'LessonController@getSubjectDetailsModal']);
        
        Route::get('pre-recorded/{id}/details-modal', ['as' => 'pre-recorded.details.modal',
            'uses' => 'LessonController@getPreRecordedDetailsModal']);
        
        Route::post('profile', ['as' => 'educator.profile.store', 'uses' => 'EducatorController@store']);
        
        Route::post('profile/autosave', ['as' => 'educator.profile.autoSave', 'uses' => 'EducatorController@autoSave']);
        
        Route::post('profile/preview/{id?}', ['as' => 'educator.profile.preview',
            'uses' => 'EducatorController@previewProfile']);
        
        Route::post('lesson', ['as' => 'educator.lesson.store', 'uses' => 'LessonController@store']);
        
        Route::post('lesson/preview', ['as' => 'educator.lesson.preview',
            'uses' => 'LessonController@preview']);
        
        
        Route::post('category/add', ['as' => 'educator.category.add', 'uses' => 'EducatorController@addCategory']);

        Route::post('backlog/add', ['as' => 'educator.backlog.add', 'uses' => 'EducatorController@addBacklog']);
        
        Route::get('group-datetime-template', ['as' => 'group.datetime.template',
            'uses' => 'LessonController@getGroupDateTemplate']);
        
        Route::get('term-datetime-template', ['as' => 'term.datetime.template',
            'uses' => 'LessonController@getTermDateTemplate']);
        
        Route::get('gallery-images', ['as' => 'gallery.images', 'uses' => 'LessonController@getGalleryImages']);
        
        Route::get('stripe-fields', ['as' => 'get.stripe-fields', 'uses' => 'UserController@getStripeFields']);
        
        Route::post('call/dismiss', ['as' => 'schedule.call.dismiss', 'uses' => 'MessageController@scheduleCallDismiss']);
        
        Route::post('account-not-live', ['as' => 'educator.account.not-live', 'uses' => 'UserController@setAccountNotLive']);
        
        // Educator only
        Route::group(['middleware' => 'educator'], function () {
            
            Route::get('/', ['as' => 'educator.dashboard', 'uses' => 'EducatorPageController@index']);
            
            Route::get('classes', ['as' => 'educator.classes', 'uses' => 'EducatorPageController@classes']);
            
            Route::get('today-classes', ['as' => 'educator.today.classes', 'uses' => 'EducatorPageController@todayClasses']);
            
            Route::get('subjects', ['as' => 'educator.subjects', 'uses' => 'EducatorPageController@subjects']);
            
            Route::get('pre-recorded-classes', ['as' => 'educator.pre-recorded', 'uses' => 'EducatorPageController@preRecorded']);
            
            Route::get('stats', ['as' => 'educator.stats', 'uses' => 'EducatorPageController@statsReport']);
            
            Route::get('trusted', ['as' => 'educator.trusted', 'uses' => 'EducatorPageController@trusted']);
            
            Route::get('transactions', ['as' => 'educator.transactions', 'uses' => 'EducatorPageController@transactions']);
            
            Route::get('account-settings', ['as' => 'educator.account.settings',
                'uses' => 'EducatorPageController@accountSettings']);
            
            Route::get('lesson/{id}/edit', ['as' => 'educator.lesson.edit',
                'uses' => 'EducatorPageController@editLesson']);
            
            Route::post('lesson/{id}/update', ['as' => 'educator.lesson.update',
                'uses' => 'LessonController@update']);
            
            Route::post('lesson/draft', ['as' => 'educator.lesson.draft',
                'uses' => 'LessonController@draft']);
            
            Route::get('profile/stripe-setup', ['as' => 'educator.setup.stripe',
                'uses' => 'EducatorPageController@stripeSetup']);
            
            Route::get('profile/stripe-update', ['as' => 'educator.update.stripe',
                'uses' => 'EducatorPageController@stripeUpdate']);
            
            Route::post('stripe-account', ['as' => 'educator.stripe-account.store',
                'uses' => 'StripeController@setupAccount']);
            
            Route::post('stripe-account-update', ['as' => 'educator.stripe-account.update',
                'uses' => 'StripeController@updateAccount']);
            
            Route::post('stripe-account-type1-user', ['as' => 'educator.stripe-account.type1-user.store',
                'uses' => 'StripeAccountType1User@setupAccount']);
            
            Route::post('lessons/move-class/modal', ['as' => 'educator.move.class.modal',
                'uses' => 'LessonController@getMoveClassModal']);
            
            Route::post('lessons/move/class', ['as' => 'educator.move.class',
                'uses' => 'LessonController@moveClass']);
            
            Route::post('lessons/{id}/pause', ['as' => 'educator.lesson.pause',
                'uses' => 'LessonController@pause']);
            
            Route::post('lessons/{id}/live', ['as' => 'educator.lesson.live',
                'uses' => 'LessonController@live']);
            
            Route::post('lessons/{id}/cancel', ['as' => 'educator.lesson.cancel',
                'uses' => 'BookingController@cancelClasses']);
            
            Route::post('lessons/{id}/trash', ['as' => 'educator.lesson.trash',
                'uses' => 'LessonController@trash']);
            
            Route::post('refund-request/accept', ['as' => 'educator.accept.refund',
                'uses' => 'RefundRequestController@acceptByEducator']);
            
            Route::post('refund-request/reject', ['as' => 'educator.reject.refund',
                'uses' => 'RefundRequestController@rejectByEducator']);
            
            Route::get('message/{id}/class', ['as' => 'educator.message.class',
                'uses' => 'EducatorPageController@messageClass']);
            
            Route::get('stats', ['as' => 'educator.stats', 'uses' => 'EducatorPageController@statsReport']);
            
            Route::get('stats/all', ['as' => 'educator.stats-all', 'uses' => 'EducatorController@getAllStats']);
            
            Route::get('stats/earnings', ['as' => 'educator.stats-earning',
                'uses' => 'EducatorController@getEarningStats']);
            
            Route::get('stats/ad-views', ['as' => 'educator.stats-advert-view',
                'uses' => 'EducatorController@getAdvertViewStats']);
            
            Route::get('stats/booking-counts', ['as' => 'educator.stats-booking-count',
                'uses' => 'EducatorController@getLessonBookingStats']);
            
            Route::get('inbox/{chat_id?}', ['as' => 'educator.inbox', 'uses' => 'EducatorPageController@inbox']);
            
            Route::get('inbox/{id}/messages', ['as' => 'educator.inbox.message',
                'uses' => 'EducatorPageController@messages']);
            
            Route::get('monthly-stats', ['as' => 'page.download.monthly-stats',
                'uses' => 'EducatorController@downloadAllStats']);
            
            Route::get('gallery-images', ['as' => 'get.gallery-images',
                'uses' => 'LessonController@getGalleryImages']);
            
            Route::post('go-offline', ['as' => 'educator.go-offline',
                'uses' => 'EducatorController@goOffline']);
            
            Route::post('go-online', ['as' => 'educator.go-online',
                'uses' => 'EducatorController@goOnline']);
            
            Route::get('completed-payouts', ['as' => 'educator.comnpleted.payouts',
                'uses' => 'EducatorController@completedBookingPayouts']);
            
            Route::get('pending-payouts', ['as' => 'educator.pending.payouts',
                'uses' => 'EducatorController@pendingBookingPayouts']);
            
            Route::get('total-earning', ['as' => 'educator.total-earning',
                'uses' => 'EducatorController@earningPerBooking']);
            
            Route::post('upload/references', ['as' => 'educator.references.upload',
                'uses' => 'EducatorController@uploadReferences']);
            
            Route::get('profile/bank-account', ['as' => 'educator.change.bank-account',
                'uses' => 'EducatorPageController@changeBankAccount']);
            
            Route::post('profile/bank-account', ['as' => 'educator.update.bank-account',
                'uses' => 'StripeController@updateBankAccount']);
            
            Route::post('subject/lesson', ['as' => 'educator.subject.lesson',
                'uses' => 'LessonController@createSubjectLesson']);
            
            Route::get('job-board', ['as' => 'educator.job-board', 'uses' => 'EducatorPageController@jobBoard']);
            
            Route::post('job-board/applied', ['as' => 'educator.job-board.applied',
                'uses' => 'EducatorController@applyJobsBoard']);
            
            Route::get('pre-recorded/create', ['as' => 'educator.pre-recorded.create',
                'uses' => 'EducatorPageController@createPreRecordedLesson']);
    
            Route::post('pre-recorded', ['as' => 'educator.pre-recorded.store',
                'uses' => 'LessonController@createPreRecordedLesson']);
    
            Route::get('pre-recorded/upload/{id}', ['as' => 'educator.pre-recorded.upload',
                'uses' => 'LessonController@uploadVideo']);
    
            Route::post('pre-recorded/upload', ['as' => 'educator.pre-recorded.upload',
                'uses' => 'LessonController@uploadVideo']);
    
            Route::post('schedule-free-call', ['as' => 'schedule.free.call', 'uses' => 'FreeVideoCallController@store']);
            
            Route::get('upload-video/{id}', ['as' => 'educator.upload.error', 'uses' => 'EducatorPageController@reUploadVideo']);
            
            Route::get('extra-device-email', ['as' => 'educator.extra-device.email', 'uses' => 'EducatorController@extraDeviceEmail']);
    
        });
        
        
    });
    
    // Admin Dashboard Routes
    Route::group(['middleware' => 'admin', 'prefix' => 'dashboard/admin'], function () {
        
        Route::get('/', ['as' => 'admin.dashboard', 'uses' => 'AdminPageController@index']);
        
        Route::get('providers', ['as' => 'admin.educators', 'uses' => 'AdminPageController@educators']);
        
        Route::get('global-fees', ['as' => 'admin.global.fees', 'uses' => 'AdminPageController@globalFees']);
        
        Route::get('export-messages', ['as' => 'admin.export.messages', 'uses' => 'AdminPageController@exportMessages']);
        
        Route::post('export-messages', ['as' => 'admin.post.export.messages', 'uses' => 'AdminController@exportMessages']);
        
        Route::get('adverts', ['as' => 'admin.lessons', 'uses' => 'AdminPageController@lessons']);
        
        Route::get('reported-adverts', ['as' => 'admin.reported.lessons',
            'uses' => 'AdminPageController@reportedLessons']);
        
        Route::get('refunds', ['as' => 'admin.refunds', 'uses' => 'AdminPageController@refunds']);
        
        Route::get('settings', ['as' => 'admin.profile', 'uses' => 'AdminPageController@settings']);
        
        Route::get('category-banners', ['as' => 'admin.category.banner', 'uses' => 'AdminPageController@categoryBanner']);
        
        Route::post('category/{id}', ['as' => 'admin.update.category', 'uses' => 'AdminController@updateCategory']);
        
        Route::post('lessons/{id}/category', ['as' => 'lesson.update.category',
            'uses' => 'AdminController@updateLessonCategory']);
        
        Route::post('settings', ['as' => 'admin.settings', 'uses' => 'SettingController@store']);
        
        Route::post('educators/get/datatable', ['as' => 'admin.educators.datatable',
            'uses' => 'AdminController@getEducatorsDataTable']);
        
        Route::post('get/lessons/datatable', ['as' => 'admin.lessons.datatable',
            'uses' => 'AdminController@getLessonsDataTable']);
        
        Route::post('get/reported/lessons/datatable', ['as' => 'admin.reported.lessons.datatable',
            'uses' => 'AdminController@getReportedLessonsDataTable']);
        
        Route::post('get/refunds/datatable', ['as' => 'admin.refunds.datatable',
            'uses' => 'AdminController@getRefundsDatatable']);
        
        Route::post('educators/{id}/fees', ['as' => 'admin.update.educator.fees',
            'uses' => 'AdminController@updateEducatorFees']);
        
        Route::post('educators/{id}/references', ['as' => 'admin.update.educator.references',
            'uses' => 'AdminController@approveEducatorReferences']);
        
        Route::post('settings/homepage', ['as' => 'admin.homepage.setting.store',
            'uses' => 'AdminController@homepageSettings']);
        
        Route::delete('banner/{id}', ['as' => 'admin.banner.delete', 'uses' => 'AdminController@deleteBanner']);
        
        Route::delete('trusted-logo/{id}', ['as' => 'admin.trusted.logo.delete',
            'uses' => 'AdminController@deleteTrustedLogo']);
        
        Route::post('settings/faqs', ['as' => 'admin.faq.store', 'uses' => 'FAQController@store']);
        
        Route::get('faqs/{id}/edit', ['as' => 'admin.faq.edit', 'uses' => 'AdminPageController@editFAQ']);
        
        Route::post('faqs/{id}/update', ['as' => 'admin.faq.update', 'uses' => 'FAQController@update']);
        
        Route::delete('faqs/{id}', ['as' => 'admin.faq.delete', 'uses' => 'FAQController@delete']);
        
        Route::post('settings/testimonials', ['as' => 'admin.testimonial.store',
            'uses' => 'TestimonialController@store']);
        
        Route::delete('testimonials/{id}', ['as' => 'admin.testimonial.delete',
            'uses' => 'TestimonialController@delete']);
        
        Route::post('testimonials/sort', ['as' => 'admin.testimonial.sort', 'uses' => 'TestimonialController@sort']);
        
        Route::get('lessons/{id}/modal', ['as' => 'lesson.modal', 'uses' => 'AdminController@getEditLessonModal']);
        
        Route::get('refunds/{booking_id}/{class_id}/modal', ['as' => 'refund.modal',
            'uses' => 'AdminController@getRefundModal']);
        
        Route::get('educator-fees/{id}/modal', ['as' => 'educator.fees.modal',
            'uses' => 'AdminController@getEducatorFeesModal']);
        
        Route::get('educator-references/{id}/modal', ['as' => 'educator.references.modal',
            'uses' => 'AdminController@getEducatorReferencesModal']);
        
        Route::get('blogs', ['as' => 'admin.blogs', 'uses' => 'AdminPageController@blogs']);
        
        Route::post('posts/datatables', ['as' => 'admin.posts.datatable',
            'uses' => 'PostController@getPostsDatatable']);
        
        Route::get('posts/create', ['as' => 'admin.post.create', 'uses' => 'AdminPageController@createPost']);
        
        Route::get('posts/{id}/edit', ['as' => 'admin.post.edit', 'uses' => 'AdminPageController@editPost']);
        
        Route::post('posts', ['as' => 'admin.post.store', 'uses' => 'PostController@store']);
        
        Route::post('posts/{id}/update', ['as' => 'admin.post.update', 'uses' => 'PostController@update']);
        
        Route::delete('posts/{id}/trash', ['as' => 'admin.post.delete', 'uses' => 'PostController@trash']);
        
        Route::get('posts/{id}/duplicate', ['as' => 'admin.post.duplicate', 'uses' => 'PostController@duplicate']);
        
        Route::delete('posts/{id}/featured-image', ['as' => 'admin.featured.image.delete',
            'uses' => 'PostController@deleteImage']);
        
        Route::post('refund-request/grant', ['as' => 'admin.grant.refund',
            'uses' => 'RefundRequestController@acceptByAdmin']);
        
        Route::post('refund-request/decline', ['as' => 'admin.decline.refund',
            'uses' => 'RefundRequestController@rejectByAdmin']);
        
        Route::post('toggle-trusted', ['as' => 'admin.toggle.trusted',
            'uses' => 'AdminController@toggleTrusted']);
        
        Route::get('categories', ['as' => 'admin.categories',
            'uses' => 'AdminPageController@categories']);
        
        Route::post('get/categories', ['as' => 'admin.categories.datatable',
            'uses' => 'AdminController@getCategoriesDataTable']);
        
        Route::get('category/create', ['as' => 'admin.category.create',
            'uses' => 'AdminPageController@createCategory']);
        
        Route::get('category/edit/{id}', ['as' => 'admin.category.edit',
            'uses' => 'AdminPageController@editCategory']);
        
        Route::post('category', ['as' => 'admin.category.store', 'uses' => 'CategoryController@store']);
        
        Route::post('category/update/{id}', ['as' => 'admin.category.update',
            'uses' => 'CategoryController@update']);
        
        Route::delete('category/{id}', ['as' => 'admin.category.delete', 'uses' => 'CategoryController@trash']);

        Route::post('get/subcategories', ['as' => 'admin.category.subcategories', 'uses' => 
            'CategoryController@subcategories']);
        
        Route::get('get/earnings', ['as' => 'admin.get.earnings',
            'uses' => 'AdminController@getClasshubEarnings']);
    
        Route::get('student-stats', ['as' => 'export.students.data', 'uses' => 'AdminController@studentStats']);

        Route::get('tutor-stats', ['as' => 'export.tutors.data', 'uses' => 'AdminController@tutorStats']);
    });
    
});

// Frontend Routes

Route::get('/', function () {
    /*if (Auth::user()) {
        if (Auth::user()->user_type == 'educator') {
            $type = \App\Setting::TEST_CASES[rand(0,4)];
            return view('frontend.pages.tutor-landing');
        } else {
            $controller = new \App\Http\Controllers\FrontPageController();
            return $controller->home();
        }
    } else {
        return view('frontend.pages.tutor-landing');
    }*/
    
    $controller = new \App\Http\Controllers\FrontPageController();
    return $controller->home();
})->name('home');

Route::get('/home', ['as' => 'page.home', 'uses' => 'FrontPageController@home']);

Route::post('signup', ['as' => 'user.signup', 'uses' => 'UserController@store']);

Route::post('login', ['as' => 'user.login', 'uses' => 'AuthController@login']);

Route::get('logout', ['as' => 'user.logout', 'uses' => 'AuthController@logout']);

Route::post('inbox-unread-count', ['as' => 'user.inbox.unread', 'uses' => 'UserController@getInboxUnreadCount']);

Route::post('video-schedule', ['as' => 'user.video.schedule', 'uses' => 'UserController@getVideoCallSchedule']);

Route::get('video-call/{class_id?}', ['as' => 'page.video-call', 'uses' => 'FrontPageController@videoCall']);

Route::get('free-video-call/{id}', ['as' => 'page.free-video-call', 'uses' => 'FrontPageController@freeVideoCall']);

Route::get('forgot-password', ['as' => 'page.forgot.password',
    'uses' => 'PasswordResetController@forgotPasswordPage']);

Route::get('password-reset-email-sent', ['as' => 'page.reset.password.sent',
    'uses' => 'PasswordResetController@resetPasswordSentPage']);

Route::post('send-password-reset-code', ['as' => 'send.password.reset-code',
    'uses' => 'PasswordResetController@sendResetCodeEmail']);

Route::get('password-reset/{user_id}/{code}', ['as' => 'password.reset.link',
    'uses' => 'PasswordResetController@resetPasswordPage']);

Route::post('reset-password', ['as' => 'reset.password', 'uses' => 'PasswordResetController@resetPassword']);

Route::get('social/redirect/{provider}/{user_type?}', ['as' => 'social.redirect', 'uses' => 'SocialController@redirect']);

Route::get('social/callback/{provider}', ['as' => 'social.callback', 'uses' => 'SocialController@callback']);

Route::post('image/{folder}/upload', ['as' => 'upload.image', 'uses' => 'ImageController@upload']);

Route::delete('image/{id}/delete', ['as' => 'delete.image', 'uses' => 'ImageController@delete']);

Route::get('cookie', ['as' => 'cookie', 'uses' => 'FrontendController@setAcceptCookie']);

Route::get('how-it-works', ['as' => 'page.how-it-works', 'uses' => 'FrontPageController@howItWorks']);

Route::get('become-a-tutor', ['as' => 'page.lp1', 'uses' => 'FrontPageController@tutorLanding']);

Route::get('terms-and-conditions', ['as' => 'page.terms-conditions', 'uses' => 'FrontPageController@terms']);

Route::get('tips-and-tricks', ['as' => 'page.tips-tricks', 'uses' => 'FrontPageController@tipsTricks']);

Route::get('payment-terms', ['as' => 'page.payment-terms', 'uses' => 'FrontPageController@paymentTerms']);

Route::get('privacy-and-cookie-policy', ['as' => 'page.privacy-cookie', 'uses' => 'FrontPageController@privacy']);

Route::get('about-us', ['as' => 'page.about-us', 'uses' => 'FrontPageController@about']);

Route::get('class-tech', ['as' => 'page.class-tech', 'uses' => 'FrontPageController@classtech']);


Route::get('class-tech-v2', ['as' => 'page.class-tech-v2', 'uses' => 'FrontPageController@classtechtwo']);

Route::get('business', ['as' => 'page.business', 'uses' => 'FrontPageController@business']);

Route::get('online-tuition', ['as' => 'page.online-tuition', 'uses' => 'FrontPageController@onlineTuition']);

Route::get('help', ['as' => 'page.help', 'uses' => 'FrontPageController@help']);

Route::get('help/{id}/{slug}', ['as' => 'page.help.single', 'uses' => 'FrontPageController@helpSingle']);

Route::get('trust', ['as' => 'page.trust', 'uses' => 'FrontPageController@trust']);

Route::get('tutor-request', ['as' => 'page.tutor-request', 'uses' => 'FrontPageController@tutorRequest']);

Route::get('faq', ['as' => 'page.faq', 'uses' => 'FrontPageController@faq']);

Route::get('category/{slug}', ['as' => 'page.category', 'uses' => 'FrontPageController@category']);

Route::get('search/{query_string?}', ['as' => 'page.search', 'uses' => 'FrontPageController@search']);

Route::get('blog', ['as' => 'page.blog', 'uses' => 'FrontPageController@blog']);

Route::get('blog/{slug}', ['as' => 'page.blog.post', 'uses' => 'FrontPageController@blogPost']);

Route::get('blog/archive/{date}', ['as' => 'page.blog.archive', 'uses' => 'FrontPageController@blogArchive']);

Route::get('blog/category/{slug}', ['as' => 'page.blog.category', 'uses' => 'FrontPageController@blogCategory']);

Route::get('tutor/{slug}', ['as' => 'page.educator', 'uses' => 'FrontPageController@educatorProfile']);

Route::get('advert/{slug}', ['as' => 'page.lesson', 'uses' => 'FrontPageController@lessonPage']);

Route::get('pre-recorded-class/{slug}', ['as' => 'page.pre-recorded.lesson', 'uses' => 'FrontPageController@preRecordedLessonPage']);

Route::get('booking/modal/payment-summary', ['as' => 'booking.modal.payment.summary',
    'uses' => 'BookingController@getPaymentSummary']);

Route::post('educators/{id}/share', ['as' => 'share.educator', 'uses' => 'EducatorController@share']);

Route::post('lessons/{id}/share', ['as' => 'share.lesson', 'uses' => 'LessonController@share']);

Route::get('reviews', ['as' => 'educator.reviews', 'uses' => 'EducatorController@getReviews']);

Route::get('unsubscribe/{email}', ['as' => 'page.unsubscribe', 'uses' => 'FrontPageController@unsubscribe']);

Route::get('earning-calculator', ['as' => 'earning.calculator', 'uses' => 'FrontPageController@earningCalculator']);

Route::get('download/parent-receipt-pdf/{booking_id}', ['as' => 'parent.download.receipt', 'uses' => 'BookingController@parentReceiptPDF']);

Route::get('download/educator-receipt-pdf/{booking_id}/class/{class_id}', ['as' => 'educator.download.receipt', 'uses' => 'BookingController@educatorReceiptPDF']);

Route::get('download/educator-vat-receipt-pdf/{booking_id}/class/{class_id}', ['as' => 'educator.download.vat-receipt', 'uses' => 'BookingController@educatorVatReceiptPDF']);

Route::get('stripe/upload-documents/account/{account_id}/person/{person_id}/{docs?}', ['as' => 'stripe.upload.documents', 'uses' => 'FrontPageController@uploadDocuments']);

Route::get('stripe/upload-addl-documents/account/{account_id}/person/{person_id}/{docs?}', ['as' => 'stripe.upload.addl.documents', 'uses' => 'FrontPageController@uploadAddlDocuments']);

Route::get('stripe/update-mcc-stripe/account/{account_id}', ['as' => 'stripe.update.mcc', 'uses' => 'FrontPageController@updateStripeMcc']);

Route::post('stripe/upload-documents', ['as' => 'post.stripe.upload.documents', 'uses' => 'StripeController@reUploadDocuments']);

Route::post('stripe/upload-addl-documents', ['as' => 'post.stripe.upload.addl.documents', 'uses' => 'StripeController@uploadAddlDocuments']);

Route::post('stripe/update-mcc-stripe', ['as' => 'post.stripe.update.mcc', 'uses' => 'StripeController@updateMcc']);

Route::post('stripe/account-updated/web-hook', 'StripeController@accountUpdatedWebHook');

Route::get('request-a-tutor', ['as' => 'request.tutor', 'uses' => 'FrontPageController@requestTutor']);

Route::post('request-a-tutor', ['as' => 'post.request.tutor', 'uses' => 'FrontPageController@processTutorRequest']);

Route::post('ch-enquiry', ['as' => 'post.ch.enquiry', 'uses' => 'FrontPageController@sendChEnquiry']);

Route::post('lesson-videos', ['as' => 'lesson.videos', 'uses' => 'LessonController@getLessonVideos']);

Route::post('video/log/exception', ['as' => 'video.log.exception', 'uses' => 'FrontPageController@logVideoException']);
Route::post('video/log/error', ['as' => 'video.log.error', 'uses' => 'FrontPageController@logVideoError']);

Route::post('free-video-call/zoom-participant-joined-notification', 'FreeVideoCallController@zoomParticipantJoinedNotification');

// Redirects
Route::redirect('/landing-page', '/become-a-tutor', 301);

Route::get('update-message-type', 'FrontPageController@updateMessageType');

# TEST
Route::get('twilio-test', 'FrontPageController@twilioTest');
Route::get('jobs', 'EducatorController@jobsBoardReminder');
Route::get('stripe-topup', ['as' => 'stripe.test-payment', 'uses' => 'FrontPageController@stripeTopup']);
Route::get('update-bank-account', ['as' => 'update.bank-account', 'uses' => 'FrontPageController@updateBankAccount']);
Route::post('process-topup', ['as' => 'stripe.post.topup', 'uses' => 'StripeController@stripeTopup']);
Route::get('payout-test', ['as' => 'stripe.payout.test', 'uses' => 'StripeController@testPayout']);
Route::get('class-reminder-test', ['as' => 'class.reminder.test', 'uses' => 'BookingController@classReminder']);
Route::get('intercom-users/{page}', ['as' => 'intercom.users', 'uses' => 'FrontPageController@getAllIntercomUsers']);
Route::get('vimeo-test', ['as' => 'vimeo.test', 'uses' => 'FrontPageController@vimeoTest']);
Route::get('deactivate-test', ['as' => 'deactivate.test', 'uses' => 'FrontPageController@deactivateTest']);
Route::get('tutor-request-test', ['as' => 'tutor.request.test', 'uses' => 'FrontPageController@deleteJobBoard']);
Route::get('cron-test', ['as' => 'cron.test', 'uses' => 'EducatorController@setTopPerformers']);
Route::get('week-class', ['as' => 'week.class', 'uses' => 'FrontPageController@lastSevenDayClasses']);
Route::get('day-class', ['as' => 'day.class', 'uses' => 'ListVideoCallController@index']);

if (env('APP_ENV') !== 'production') {
    Route::get('run-test/{num?}', 'TestController@run');
    Route::get('run-cron/{program?}', 'FrontPageController@cron');
}
