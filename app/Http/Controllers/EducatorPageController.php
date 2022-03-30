<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Category;
use App\Chat;
use App\Educator;
use App\Image;
use App\JobBoard;
use App\Lesson;
use App\LessonClass;
use App\Message;
use App\Setting;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Stripe\Account;
use Stripe\Charge;
use Stripe\HttpClient\CurlClient;
use Stripe\Stripe;

class EducatorPageController extends Controller
{
    
    public function index()
    {
        $bookings = Auth::user()->educatorBookings;
        
        $currentYearEarnAmount = Transaction::getEarningsAmount($bookings, 'year', date('Y'));
        
        $currentMonthEarnAmount = Transaction::getEarningsAmount($bookings, 'month', date('Y-m'));
        
        $adViews = Lesson::getViewCount(date('Y-m'));
        
        $numBookings = Booking::getBookings(date('Y-m'))->count();
        
        $lessons = Auth::user()->lessons;
        //()->withTrashed()->get();
        
        $drafts = $lessons->where('status', 'draft')->all();
        
        $draftHtml = null;
        
        if (count($drafts)) {
            $draftHtml = '<div style="text-align: left; margin-bottom: 20px"><h3>You have an unfinished class(es)</h3><ol style="margin-left:20px">';
            foreach ($drafts as $draft) {
                $draftHtml .= '<li id="draft-' . $draft->id . '">' . $draft->name . ' <a href="' . route('educator.lesson.edit', $draft->id) . '">(click here to finish / complete)</a>
                                    <button type="button" class="delete-draft"  data-url="' . route('educator.lesson.trash', $draft->id) . '">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </li>';
            }
            $draftHtml .= '</ol></div>';
        }
        
        return view('educator.pages.index', compact('lessons', 'currentYearEarnAmount',
            'currentMonthEarnAmount', 'adViews', 'numBookings', 'draftHtml'));
    }
    
    public function transactions()
    {
        //$bookings = Auth::user()->educatorBookings()->orderByDesc('created_at')->get();
        
        $start = Carbon::createFromFormat('Y', '2019');
        $now = Carbon::now();
        $years = [];
        
        while ($now->greaterThanOrEqualTo($start)) {
            $years[$now->format('Y')] = $now->format('Y');
            $now->subYear();
        }
        
        return view('educator.pages.transactions', compact('years'));
    }
    
    public function trusted()
    {
        return view('educator.pages.trusted');
    }
    
    public function statsReport()
    {
        $start = Carbon::parse(Auth::user()->educator->created_at)->startOfMonth();
        $now = Carbon::now()->endOfMonth();
        $months = [];
        
        while ($now->greaterThanOrEqualTo($start)) {
            $months[$now->format('Y-m')] = $now->format('F Y');
            $now->subMonth();
        }
        
        return view('educator.pages.stats', compact('months'));
    }
    
    public function createProfile(Request $request)
    {
        $educator = Auth::user()->educator;
        
        $subjects = Auth::user()->categories;
        
        $subjects = $subjects ? $subjects->map(function ($item) {
            if ($item->parent_id) {
                return Category::getDisplayName($item->id);
            }
        })->toArray() : [];
        
        $subjects = array_values(array_filter($subjects));
        
        if (!$request->user_type || ($request->user_type && $request->user_type == 1)) {
            $type = 1;
            return view('educator.pages.profile.create', compact('educator', 'subjects', 'type'));
        } else {
            $type = 2;
            return view('educator.pages.profile.create-default', compact('educator', 'subjects', 'type'));
        }
        
    }
    
    public function createLesson()
    {
        if (!Auth::user()->educator)
            return redirect()->route('educator.profile.create');
        
        if (Auth::user()->educator && !Auth::user()->stripe_acct_id)
            return redirect()->route('educator.setup.stripe');
        
        $mobile = !(new Agent())->isDesktop();
        
        if (Auth::user()->educator->user_type == 1) {
            $profilePayoutLessonCompleted = true;
        } else {
            $profilePayoutLessonCompleted = Auth::user()->stripe_acct_id && Auth::user()->lessons()->withTrashed()->count();
        }
        
        $images = Image::where('path', 'like', '%galleries%')->paginate(6);
        
        return view('educator.pages.lesson.create', compact('images', 'mobile', 'profilePayoutLessonCompleted'));
    }
    
    public function editLesson(Request $request, $id)
    {
        if (!Auth::user()->educator)
            return redirect()->route('educator.profile.create');
        
        try {
            
            if ($request->has('restart')) {
                $type = 'restart';
            } else {
                $type = 'update';
            }
            
            $lesson = Lesson::withTrashed()->findOrFail($id);
            
            if ($lesson->user_id !== Auth::user()->id) {
                return abort(403);
            }
            
            // Adjust num weeks depends on classes
            if ($lesson->type === 'term') {
                $numClasses = $lesson->classes()->count();
                $numWeeks = $lesson->num_weeks;
                
                $classPerWeek = $numClasses / $numWeeks;
                
                // Do adjustment
                if (is_float($classPerWeek)) {
                    if ($classPerWeek < 1) {
                        $numWeeks = $numClasses;
                    } else {
                        $numWeeks = (int)floor($classPerWeek);
                    }
                    
                    $lesson->update(['num_weeks' => $numWeeks]);
                }
            }
            
            $category = Category::withTrashed()->findOrFail($lesson->category_id);
            $categoryParent = $category->parent_id ? $category->getParent() : null;
            $categoryName = Category::getDisplayName($category->id);
            
            $otherCategory = $categoryParent && $categoryParent->name == 'Others' ? $category : false;
            
            $images = Image::where('path', 'like', '%galleries%')->paginate(6);
            
            $mobile = !(new Agent())->isDesktop();
            
            return view('educator.pages.lesson.edit', compact('lesson', 'categoryName',
                'categoryParent', 'otherCategory', 'images', 'mobile', 'type'));
        } catch (\Exception $e) {
            return abort(404);
        }
    }
    
    public function createPreRecordedLesson()
    {
        if (Auth::user()->educator && !Auth::user()->stripe_acct_id)
            return redirect()->route('educator.setup.stripe');
        
        $mobile = !(new Agent())->isDesktop();
        
        $images = Image::where('path', 'like', '%galleries%')->paginate(6);
        
        return view('educator.pages.pre-recorded-lesson.create', compact('mobile', 'images'));
    }
    
    public function reUploadVideo(Request $request, $id)
    {
        try {
            $class = LessonClass::whereId($id)->firstOrFail();
            
            $mobile = !(new Agent())->isDesktop();
            
            return view('educator.pages.pre-recorded-lesson.re-upload', compact('mobile', 'class'));
            
        } catch (\Exception $e) {
            abort(404);
        }
    }
    
    
    public function stripeSetup()
    {
        $educator = Auth::user()->educator;
        if (!$educator)
            return redirect()->route('educator.profile.create');
        
        return view('educator.pages.profile.stripe-setup', compact('educator'));
    }
    
    public function stripeUpdate()
    {
        $educator = Auth::user()->educator;
        if (!$educator)
            return redirect()->route('educator.profile.create');
        
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        
        $stripeAccount = Account::retrieve(Auth::user()->stripe_acct_id, []);
        
        $persons = [];
        
        if ($stripeAccount->business_type === 'company') {
            $persons = Account::allPersons(Auth::user()->stripe_acct_id)->data;
        }
        
        $requirements = $this->getStripeRequirements($stripeAccount);
        
        return view('educator.pages.profile.stripe-update', compact('educator', 'stripeAccount', 'requirements', 'persons'));
    }
    
    public function getStripeRequirements($account)
    {
        if (!count($account->requirements->currently_due) && !count($account->requirements->past_due)) {
            return [];
        }
        
        // Get person requirements
        if ($account->business_type == 'individual') {
            $person = $account->individual;
            $stripeRequirements = array_unique(array_merge($person->requirements->currently_due, $person->requirements->past_due));
            $requirements = [];
            
            foreach ($stripeRequirements as $requirement) {
                $requirementArray = explode('.', $requirement);
                
                if ($requirementArray[count($requirementArray) - 1] === 'additional_document') {
                    array_push($requirements, 'Proof of Address');
                    
                } else {
                    if (isset(Setting::STRIPE_REQUIMENT_KEYS[$requirement]))
                        array_push($requirements, Setting::STRIPE_REQUIMENT_KEYS[$requirement]);
                }
            }
            
            if (in_array('business_profile.mcc', $account->requirements->currently_due)
                || in_array('business_profile.mcc', $account->requirements->past_due)) {
                array_push($requirements, Setting::STRIPE_REQUIMENT_KEYS['business_profile.mcc']);
            }
            
            return $requirements;
        }
        
        // Get person requirements
        if ($account->business_type == 'company') {
            $stripeRequirements = array_unique(array_merge($account->requirements->currently_due, $account->requirements->past_due));
            $requirements = [];
            
            foreach ($stripeRequirements as $requirement) {
                if (isset(Setting::STRIPE_REQUIMENT_KEYS[$requirement]))
                    array_push($requirements, Setting::STRIPE_REQUIMENT_KEYS[$requirement]);
                
                if (strpos($requirement, 'person') !== false) {
                    $requirementArray = explode('.', $requirement);
                    $personId = $requirementArray[0];
                    
                    $person = Account::retrievePerson(Auth::user()->stripe_acct_id, $personId);
                    
                    if ($requirementArray[count($requirementArray) - 1] === 'additional_document') {
                        array_push($requirements, $person->first_name . ' ' . $person->last_name . '  : ' . 'Proof of Address');
                        
                    } else {
                        $requirementName = ucwords(str_replace('_', ' ', $requirementArray[count($requirementArray) - 1]));
                        array_push($requirements, $person->first_name . ' ' . $person->last_name . '  : ' . $requirementName);
                    }
                }
            }
            
            return $requirements;
        }
        
        return [];
    }
    
    public function inbox(Request $request)
    {
        try {
            $jobId = $request->jobboard_id ? $request->jobboard_id : null;
            
            $allMessages = Message::where('recipient_id', Auth::user()->id)->get();
            $popup = $allMessages->count() && !$allMessages->where('read', 1)->count();
            
            $chat = null;
            
            if ($jobId) {
                $jobBoard = JobBoard::find($jobId);
                $jobBoard->update(['applied' => 1]);
                
                // Initiate chat
                $chat = Chat::chatExist($jobBoard->parent_id, Auth::user()->id);
                
                DB::beginTransaction();
                
                if (!$chat) {
                    $chat = Chat::create([
                        'lesson_id' => null,
                        'initiator_id' => $jobBoard->parent_id,
                        'participant_id' => Auth::user()->id,
                        'last_message_by' => $jobBoard->parent_id,
                        'last_message_text' => $jobBoard->message ? $jobBoard->message : '-',
                        'last_message_at' => Carbon::now()
                    ]);
                }
                
                $message = Message::create([
                    'chat_id' => $chat->id,
                    'sender_id' => $jobBoard->parent_id,
                    'recipient_id' => Auth::user()->id,
                    'type' => 'request_tutor',
                    'text' => '-',
                    'read' => 1,
                    'request_subject_id' => $jobBoard->subject_id,
                    'request_applied' => 1,
                    'request_tutor_detail' => $jobBoard->detail
                ]);
                
                DB::commit();
                
            }
            
            
            $chats = Auth::user()->chats();
            $activeChat = null;
            
            if ($chats->count()) {
                if ($chat) {
                    $activeChat = $chat;
                } else {
                    $activeChat = $request->chat_id ? $chats->where('id', $request->chat_id)->first() : $chats->first();
                }
                
                $chats = $chats->filter(function ($item) use ($activeChat) {
                    return $item->id != $activeChat->id;
                });
                
                MessageController::markReadMessages($activeChat);
            }
            
            
            $mobile = !(new Agent())->isDesktop();
            
            $messages = $activeChat ? $activeChat->messages->sortBy('created_at')->groupBy(function ($item) {
                return Carbon::parse($item->created_at)->format('d-m-Y');
            }) : collect();
            
            return view('educator.pages.inbox', compact('chats', 'activeChat', 'messages'
                , 'mobile', 'jobId', 'popup'));
        } catch (\Exception $e) {
            abort(404);
        }
    }
    
    public function messages($chatId)
    {
        $chats = Auth::user()->chats();
        
        $activeChat = $chats->where('id', $chatId)->first();
        
        MessageController::markReadMessages($activeChat);
        
        $mobile = !(new Agent())->isDesktop();
        
        $messages = $activeChat->messages->sortBy('created_at')->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('d-m-Y');
        });
        
        return view('educator.pages.messages', compact('chats', 'activeChat', 'messages', 'mobile'));
    }
    
    public function accountSettings()
    {
        return view('educator.pages.account-settings');
    }
    
    public function classes()
    {
        
        $lessons = Auth::user()->lessons()->get()->filter(function ($lesson) {
            return in_array($lesson->type, ['single', 'group', 'term']);
        });
        
        return view('educator.pages.classes', compact('lessons'));
    }
    
    public function subjects()
    {
        $mobile = !(new Agent())->isDesktop();
        
        
        $lessons = Lesson::whereHas('bookings')->where('user_id', Auth::user()->id)
            ->where('type', 'subject')->get()->groupBy('category_id');
        
        return view('educator.pages.subjects', compact('lessons', 'mobile'));
    }
    
    public function preRecorded()
    {
        $mobile = !(new Agent())->isDesktop();
        
        
        $lessons = Lesson::where('user_id', Auth::user()->id)
            ->where('type', 'pre_recorded')->get();
        
        return view('educator.pages.pre-recorded', compact('lessons', 'mobile'));
    }
    
    
    public function jobBoard()
    {
        try {
            
            $jobsBoard = Auth::user()->jobBoards()->orderBy('applied', 'asc')
                ->orderBy('created_at', 'desc')
                ->paginate(5);
            
            return view('educator.pages.job-board', compact('jobsBoard'));
        } catch (\Exception $e) {
            return abort(404);
        }
    }
    
    public function messageClass($id)
    {
        try {
            $lesson = Lesson::findOrFail($id);
            $bookings = $lesson->bookings;
            return view('educator.pages.message-class', compact('lesson', 'bookings'));
        } catch (\Exception $e) {
            return abort(404);
        }
    }
    
    public function changeBankAccount()
    {
        try {
            return view('educator.pages.profile.change-bank-account');
        } catch (\Exception $e) {
            return abort(404);
        }
    }
    
    
    public function todayClasses()
    {
        try {
            $classes = User::todayCalls();
            return view('educator.pages.today-classes', compact('classes'));
        } catch (\Exception $e) {
        
        }
    }
    
}
