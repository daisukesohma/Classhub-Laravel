<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Educator;
use App\FreeVideoCall;
use App\Helpers\ClassHubHelper;
use App\Jobs\IntercomJob;
use App\Jobs\SendEmailJob;
use App\Lesson;
use App\Mail\AccountUpdate;
use App\Mail\DeleteAccount;
use App\Mail\FreeVideoCallReminder;
use App\Mail\VideoCallReminder;
use App\Mail\WelcomeEducator;
use App\Mail\WelcomeUser;
use App\Message;
use App\User;
use App\LessonClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Intercom\IntercomClient;
use Ixudra\Curl\Facades\Curl;
use Stripe\Stripe;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;
use Twilio\Jwt\Grants\VideoGrant;

class UserController extends Controller
{
    
    public function __construct()
    {
        //$this->middleware('guest')->except('store');
    }
    
    public function store(Request $request)
    {
        $validate = ClassHubHelper::validateData($request->all(), User::VALIDATION_RULES);
        
        // Return array of errors if not validated
        if (is_array($validate))
            return response()->json($validate);
        
        try {
            $request->merge(['password' => Hash::make($request->password)]);
            
            DB::beginTransaction();
            
            $user = User::create($request->all());
            
            DB::commit();
            
            Auth::login($user);
            
            if ($user->user_type == 'educator') {
                session()->put('user_mode', 'educator');
                $redirectUrl = route('educator.profile.create');
            } else {
                session()->put('user_mode', 'parent');
                $paths = explode('/', parse_url(url()->previous(), PHP_URL_PATH));
                $redirectUrl = in_array($paths[1], ['tutor', 'advert']) ?
                    url()->previous() : route('home');
            }
            
            
            if ($request->user_type == 'parent') {
                $job = new SendEmailJob($user->email, new WelcomeUser($user, $user->email));
                $this->dispatch($job);
            } else {
                $job = new SendEmailJob(Auth::user()->email, new WelcomeEducator(Auth::user(), Auth::user()->email));
                $this->dispatch($job);
            }
            
            // Intercom Data
            $customData = [
                'Educator' => $user->user_type == 'educator' ? true : false,
                'Bookings no' => $user->educator ? $user->educatorBookings()->count() : $user->bookings()->count(),
                'Impressions no' => $user->searchAppearances()->count(),
                'Views no' => $user->views()->count(),
                'Lessons no' => $user->lessons()->count(),
                'Stripe Connected' => false
            ];
            
            if ($request->user_type == 'educator') {
                $educatorData = [
                    'List Class' => $user->lessonsWithTrashed()->count() ? true : false,
                    'Profile Complete' => $user->educator ? true : false
                ];
                $customData = array_merge($customData, $educatorData);
            }
            
            $data = [
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'signed_up_at' => Carbon::parse($user->created_at)->getTimestamp(),
                'custom_attributes' => $customData,
                'unsubscribed_from_emails' => !$user->subscribe_intercom,
            ];
            
            $intercomJob = new IntercomJob($user, $data);
            
            $this->dispatch($intercomJob);
            
            if ($request->request_tutor) {
                return response()->json([
                    'status' => true,
                    'request_tutor' => 'form#request-tutor button',
                ]);
            }
            
            return response()->json([
                'status' => true,
                'redirect_url' => $redirectUrl
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()]
            ]);
        }
    }
    
    public function updateAccount(Request $request)
    {
        $validate = ClassHubHelper::validateData($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . Auth::user()->id
        ]);
        
        // Return array of errors if not validated
        if (is_array($validate))
            return response()->json($validate);
        
        try {
            
            DB::beginTransaction();
            
            Auth::user()->update($request->only(['name', 'email']));
            
            if ($request->password) {
                
                $validate = ClassHubHelper::validateData($request->all(), [
                    'current_password' => 'required',
                    'password' => 'required|min:6|confirmed'
                ]);
                
                // Return array of errors if not validated
                if (is_array($validate))
                    return response()->json($validate);
                
                if (Hash::check($request->current_password, Auth::user()->password) === false) {
                    return response()->json([
                        'status' => false,
                        'messages' => ['Incorrect current password'],
                    ]);
                }
                
                Auth::user()->update(['password' => bcrypt(request()->get('password'))]);
            }
            
            DB::commit();
            
            $job = new SendEmailJob(Auth::user()->email, new AccountUpdate(Auth::user(), Auth::user()->email));
            
            $this->dispatch($job);
            
            $data = [
                'user_id' => Auth::user()->id,
                'email' => $request->email,
                'unsubscribed_from_emails' => !Auth::user()->subscribe_intercom,
            ];
            
            $intercomJob = new IntercomJob(Auth::user(), $data);
            
            $this->dispatch($intercomJob);
            
            return response()->json([
                'status' => true,
                'messages' => [
                    Lang::get('messages.icon.ok'),
                    'Your changes have been successfully made'
                ],
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error')],
                'errors' => $e->getMessage()
            ]);
        }
    }
    
    public static function intercomOptInOut($id, $status)
    {
        try {
            $user = User::findOrFail($id);
            
            $user->update(['subscribe_intercom' => $status == 'subscribe']);
            
            $data = [
                'user_id' => Auth::user()->id,
                'email' => Auth::user()->email,
                'unsubscribed_from_emails' => $status !== 'subscribe',
            ];
            
            $intercomJob = new IntercomJob(Auth::user(), $data);
            
            dispatch($intercomJob);
            
            return response()->json([
                'status' => true,
                'messages' => [
                    Lang::get('messages.icon.ok'),
                    $status == 'subscribe' ? Lang::get('messages.subscribe') :
                        Lang::get('messages.unsubscribe')
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()]
            ]);
        }
    }
    
    public function addCustomerCard(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        
        try {
            if (!Auth::user()->stripe_cust_id) {
                StripeController::createCustomer();
            }
            
            $card = StripeController::saveCard($request);
            
            $job = new SendEmailJob(Auth::user()->email, new AccountUpdate(Auth::user(), Auth::user()->email));
            
            $this->dispatch($job);
            
            return response()->json([
                'status' => true,
                'messages' => [
                    Lang::get('messages.icon.ok'),
                    'Card ending ' . $card['last4'] . ' added successfully.'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.error'), $e->getMessage()]
            ]);
        }
    }
    
    public function deleteAccount($id)
    {
        try {
            $user = User::findOrFail($id);
            
            $email = $user->email;
            
            $name = $user->name;
            
            DB::beginTransaction();
            
            $user->update(['account_live' => 0, 'is_online' => 0]);
            
            if ($user->intercom_user_id) {
                $intercom = new IntercomClient(env('INTERCOM_TOKEN'));
                
                $intercom->users->deleteUser($user->intercom_user_id);
            }
            
            if ($user->stripe_acct_id) {
                StripeController::deleteAccount($user->stripe_acct_id);
            }
            
            Message::where('sender_id', $user->id)->delete();
            
            $bookingController = new BookingController();
            
            $bookings = $user->bookings;
            
            if ($bookings->count()) {
                foreach ($bookings as $booking) {
                    if ($booking->lesson->type !== 'pre_recorded') {
                        $bookingController->cancelBooking($booking->lesson_id, $booking->id);
                    }
                }
            }
            
            if ($user->educator) {
                
                $educator = $user->educator;

                if ($educator->zoom_acct_id) {
                    (new ZoomMeetingController)->deleteUser($educator->zoom_acct_id);
                }
                
                Storage::disk('public')->delete(ClassHubHelper::getImagePath(null, $educator->photo));
                Storage::disk('public')->delete(ClassHubHelper::getImagePath(null, $educator->government_id));
                
                $references = @unserialize($educator->references);
                
                if (is_array($references)) {
                    foreach ($references as $referenceId) {
                        Storage::disk('public')->delete(ClassHubHelper::getImagePath(null, $referenceId));
                    }
                }
                
                $lessons = $user->lessons;
                
                foreach ($lessons as $lesson) {
                    
                    if ($lesson->type !== 'pre_recorded') {
                        $bookingController->cancelClasses($lesson->id);
                        
                        $lesson->classes()->update(['status' => 'cancelled']);
                        
                        $lesson->update(['status' => 'cancelled']);
                        
                        $lesson->delete();
                    }
                }
            }
            
            
            $job = new SendEmailJob($email, new DeleteAccount($name, $email));
            
            $this->dispatch($job);
            
            if (!Auth::user()->is_admin)
                Auth::logout();
            
            $user->update([
                'email' => 'anon-' . Carbon::now()->getTimestamp() . '@classhub.ie',
                'name' => 'Anonymous',
            ]);
            
            $user->delete();
            
            DB::commit();
            
            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.icon.ok'), Lang::get('messages.delete', ['name' => 'Account'])]
            ]);
            
        } catch (\Exception $e) {
            
            if (!Auth::user()->is_admin)
                Auth::login(User::findOrFail($id));
            
            DB::rollBack();
            
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()]
            ]);
        }
    }
    
    public function getInboxUnreadCount()
    {
        if (!Auth::user()) {
            return response()->json([
                'status' => false,
                'unread' => 0,
            ]);
        }
        
        try {
            $inboxUnreadCount = 0;
            $chats = Auth::user()->chats();
            foreach ($chats as $chat) {
                $inboxUnreadCount += $chat->unread_count;
            }
            
            if ($inboxUnreadCount <= 0) {
                return response()->json([
                    'status' => false,
                    'unread' => 0,
                ]);
            }
            
            return response()->json([
                'status' => false,
                'unread' => $inboxUnreadCount,
            ]);;
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'unread' => 0,
            ]);
        }
    }
    
    public function getStripeFields(Request $request)
    {
        try {
            if ($request->type == 'individual') {
                $personFields = View::make('educator.includes.stripe-person-individual')->render();
                
                return response()->json([
                    'status' => true,
                    'person_fields' => $personFields
                ]);
            } else {
                $personFields = View::make('educator.includes.stripe-person-business')->render();
                $businessFields = View::make('educator.includes.stripe-business-fields')->render();
                
                return response()->json([
                    'status' => true,
                    'person_fields' => $personFields,
                    'business_fields' => $businessFields,
                ]);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    
    public function validateProfileInfoAndSave(Request $request)
    {
        try {
            
            if ($request->user_type == 1) {
                $rules = Educator::VALIDATION_RULES_1;
            } else {
                $rules = Educator::VALIDATION_RULES_2;
            }
            
            $validate = ClassHubHelper::validateData($request->all(), $rules);
            
            // Return array of errors if not validated
            if (is_array($validate)) {
                return response()->json([
                    'status' => false,
                    'validate' => false,
                    'stage' => 'validation'
                ]);
            }
            
            // check qualifications
            if ($request->user_type == 1) {
                $set = false;
                foreach ($request->qualifications as $qualification) {
                    if ($qualification['name']) {
                        $set = true;
                    }
                }
                
                if (!$set) {
                    return response()->json([
                        'status' => false,
                        'validate' => false,
                        'stage' => 'qualification'
                    ]);
                }
            }
            
            $educatorController = new EducatorController();
            
            return $educatorController->store($request);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'validate' => false,
                'stage' => 'exception'
            ]);
        }
    }
    
    public function setAccountNotLive()
    {
        try {
            Auth::user()->update(['account_live' => false]);
            return response()->json([
                'status' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
    
    public static function videoCallReminder()
    {
        try {
            $lessonIds = Message::where('booking_response', 1)
                ->whereNotNull('class_ids')
                ->pluck('lesson_id')
                ->toArray();
            
            $startTimeMaxThreshold = Carbon::now()->addMinutes(5);
            $startTimeMinThreshold = Carbon::now();
            
            $validLessonClasses = LessonClass::whereIn('lesson_id', $lessonIds)
                ->whereDate('date', Carbon::today())
                ->whereTime('start_time', '<=', $startTimeMaxThreshold)
                ->whereTime('start_time', '>=', $startTimeMinThreshold)
                ->get();
            
            
            foreach ($validLessonClasses as $validLessonClass) {
                $lesson = Lesson::findOrFail($validLessonClass->lesson_id);
                $videoCall = Message::where('lesson_id', $validLessonClass->lesson_id)->first();
                
                
                $video_call_time = Carbon::createFromFormat('Y-m-d H:i:s', $validLessonClass->date . " " . $validLessonClass->start_time);
                $videoCall->video_call_time = $video_call_time;
                $videoCall->save();
                
                if ($videoCall->sender_id == $lesson->user_id) {
                    $tutor = User::findOrFail($videoCall->sender_id);
                    $parent = User::findOrFail($videoCall->recipient_id);
                } else {
                    $parent = User::findOrFail($videoCall->sender_id);
                    $tutor = User::findOrFail($videoCall->recipient_id);
                }
                
                $booking = Booking::where('lesson_id', $lesson->id)->where('user_id', $parent->id)->first();
                
                // Send email to both Users
                $job1 = new SendEmailJob($parent->email, new VideoCallReminder($booking->student_name, $tutor->name,
                    $videoCall, $validLessonClass->id, $validLessonClass->meeting_link, $parent->email));
                
                $job2 = new SendEmailJob($tutor->email, new VideoCallReminder($tutor->name, $booking->student_name,
                    $videoCall, $validLessonClass->id, $validLessonClass->meeting_link, $tutor->email));
                
                dispatch($job1);
                
                dispatch($job2);
            }
        } catch (\Exception $e) {
        
        }
    }
    
    public static function freeVideoCallReminder()
    {
        try {
            $videoCalls = FreeVideoCall::where('complete', 0)->where('reminder_sent', 0)->get();
            
            foreach ($videoCalls as $videoCall) {
                $startTimeMinThreshold = Carbon::now();
                $startTimeMaxThreshold = Carbon::now()->addMinutes(5);
                $callTime = Carbon::parse($videoCall->call_time);
                
                if ($callTime->greaterThanOrEqualTo($startTimeMinThreshold) && $callTime->lessThanOrEqualTo($startTimeMaxThreshold)) {
                    $user1 = User::findOrFail($videoCall->educator_id);
                    $user2 = User::findOrFail($videoCall->parent_id);
                    $videoCall->update(['reminder_sent' => 1]);
                    
                    // Send email to both Users
                    $job1 = new SendEmailJob($user1->email, new FreeVideoCallReminder($user1, $user2,
                        $videoCall, $user1->email));
                    
                    $job2 = new SendEmailJob($user2->email, new FreeVideoCallReminder($user2, $user1,
                        $videoCall, $user2->email));
                    
                    dispatch($job1);
                    
                    dispatch($job2);
                    
                }
            }
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
        }
    }
    
    public function getTwilioToken(Request $request)
    {
        try {
            
            $twilioAccountSid = env('TWILIO_ACCOUNT_SID');
            $twilioApiKey = env('TWILIO_API_KEY');
            $twilioApiSecret = env('TWILIO_API_SECRET');
            
            // The specific Room we'll allow the user to access
            $roomName = $request->room;
            $callType = $request->call_type;
            $roomArr = explode('_', $roomName);
            $classId = $roomArr[count($roomArr) - 1];
            
            // A unique identifier for this user
            if ($callType === 'extra_device') {
                $identity = $request->mobile === 'true' ? Auth::user()->name . ' - Extra Device (Mobile)' : Auth::user()->name . ' - Extra Device';
            } else {
                $identity = $request->mobile === 'true' ? Auth::user()->name . ' (Mobile)' : Auth::user()->name;
            }
            
            
            // Create access token, which we will serialize and send to the client
            $token = new AccessToken(
                $twilioAccountSid,
                $twilioApiKey,
                $twilioApiSecret,
                14400,
                $identity
            );
            
            // Create Video grant
            $videoGrant = new VideoGrant();
            $videoGrant->setRoom($roomName);
            
            // Create Chat grant
            $chatGrant = new ChatGrant();
            $chatGrant->setServiceSid(env('TWILIO_CHAT_SERVICE_SID'));
            
            // Add grant to token
            $token->addGrant($videoGrant);
            $token->addGrant($chatGrant);
            
            // render token to string
            $token = $token->toJWT();
            
            return response()->json([
                'token' => $token,
                'identity' => $identity,
                'room' => $roomName,
                'user_id' => Auth::user()->id,
                'call_type' => $callType,
                'class_id' => $classId
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'token' => false,
                'message' => $e->getMessage()
            ]);
        }
        
    }
    
    public static function getVideoCallSchedule()
    {
        if (!Auth::user()) {
            return response()->json([
                'status' => false
            ]);
        }
        
        try {
            
            $schedule = User::videoCallSchedule();
            
            if (!$schedule) {
                return response()->json([
                    'status' => false
                ]);
            }
            
            $defaultPhoto = asset('img/icons/common/parents-burger-menu.png');
            
            $callerUser = User::findOrFail($schedule['caller_id']);
            $calleeUser = User::findOrFail($schedule['callee_id']);
            $callerPhotoUrl = !$callerUser->educator ? $defaultPhoto :
                ClassHubHelper::getImagePath(null, $callerUser->educator->photo);
            $calleePhotoUrl = !$calleeUser->educator ? $defaultPhoto :
                ClassHubHelper::getImagePath(null, $calleeUser->educator->photo);
            
            
            return response()->json([
                'status' => true,
                'lesson_name' => $schedule['lesson_name'],
                'schedule_id' => $schedule['schedule_id'],
                'lesson_id' => $schedule['lesson_id'],
                'class_id' => $schedule['class_id'],
                'is_scheduler' => $schedule['is_scheduler'],
                'room_name' => $schedule['room_name'],
                'meeting_link' => $schedule['meeting_link'],
                'caller_detail' => [
                    'id' => $callerUser->id,
                    'name' => $callerUser->name,
                    'email' => $callerUser->email,
                    'photo' => $callerPhotoUrl,
                ],
                'callee_detail' => [
                    'id' => $calleeUser->id,
                    'name' => $calleeUser->name,
                    'email' => $calleeUser->email,
                    'photo' => $calleePhotoUrl,
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'errors' => $e->getMessage()
            ]);
        }
    }
    
    
    public static function getFreeVideoCallSchedule($videoCall)
    {
        
        try {
            
            $schedule = [
                'schedule_id' => $videoCall->id,
                'caller_id' => $videoCall->educator_id,
                'callee_id' => $videoCall->parent_id !== Auth::user()->id ? $videoCall->parent_id : $videoCall->educator_id,
                'is_scheduler' => Auth::user()->educator,
                'lesson_name' => 'Free call schedule',
                'room_name' => 'free_video_call_' . $videoCall->id
            ];
            
            $callTime = Carbon::parse($videoCall->call_time);
            $startThreshold = Carbon::now()->subMinutes(10);
            $endThreshold = Carbon::parse($videoCall->call_time)->addMinutes(20);
            $errorMessage = '';
            
            if ($callTime->greaterThanOrEqualTo($startThreshold) || $callTime->lessThanOrEqualTo($endThreshold)) {
                $status = true;
            } else {
                $status = false;
                $errorMessage = 'Your call is schedule at ' . $callTime->format('d/M/Y h:i A') . '.
                    <br>Please come back later if its earlier or reschedule if its needed';
            }
            
            if ($videoCall->complete) {
                $status = false;
                $errorMessage = 'Call has been completed. Please schedule another free call';
            }
            
            
            $defaultPhoto = asset('img/icons/common/parents-burger-menu.png');
            
            $callerUser = User::findOrFail($schedule['caller_id']);
            $calleeUser = User::findOrFail($schedule['callee_id']);
            $callerPhotoUrl = !$callerUser->educator ? $defaultPhoto :
                ClassHubHelper::getImagePath(null, $callerUser->educator->photo);
            $calleePhotoUrl = !$calleeUser->educator ? $defaultPhoto :
                ClassHubHelper::getImagePath(null, $calleeUser->educator->photo);
            
            
            return response()->json([
                'status' => $status,
                'lesson_name' => $schedule['lesson_name'],
                'schedule_id' => $schedule['schedule_id'],
                'is_scheduler' => $schedule['is_scheduler'],
                'room_name' => $schedule['room_name'],
                'caller_detail' => [
                    'id' => $callerUser->id,
                    'name' => $callerUser->name,
                    'email' => $callerUser->email,
                    'photo' => $callerPhotoUrl,
                ],
                'callee_detail' => [
                    'id' => $calleeUser->id,
                    'name' => $calleeUser->name,
                    'email' => $calleeUser->email,
                    'photo' => $calleePhotoUrl,
                ],
                'error_message' => $errorMessage
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error_message' => $e->getMessage()
            ]);
        }
    }
    
}
