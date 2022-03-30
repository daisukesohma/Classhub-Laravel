<?php

namespace App\Http\Controllers;

use App\Area;
use App\Booking;
use App\BookingClass;
use App\Category;
use App\Educator;
use App\EducatorBacklog;
use App\TopPerformer;
use App\EducatorRating;
use App\EducatorView;
use App\Helpers\ClassHubHelper;
use App\JobBoard;
use App\Jobs\IntercomJob;
use App\Jobs\SendEmailJob;
use App\Lesson;
use App\LessonView;
use App\Mail\DeactivateEmail;
use App\Mail\DraftLessonReminder;
use App\Mail\EducatorSetupClassReminder;
use App\Mail\ExtraDeviceVideoCall;
use App\Mail\JobBoardReminder;
use App\Mail\Offline;
use App\Mail\Online;
use App\Mail\ProfileLive;
use App\Mail\ShareEducator;
use App\Mail\TrustedReminder;
use App\Mail\WeeklyStats;
use App\Message;
use App\RefundRequest;
use App\Transaction;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;


class EducatorController extends Controller
{

    public function store(Request $request)
    {
        if ($request->user_type == 1) {
            $validate = ClassHubHelper::validateData($request->all(), Educator::VALIDATION_RULES_1);
        } else {
            $validate = ClassHubHelper::validateData($request->all(), Educator::VALIDATION_RULES_2);
        }

        // Return array of errors if not validated
        if (is_array($validate)) {
            return response()->json($validate);
        }

        if ($request->user_type == 2) {
            $dob = Carbon::now();

            if ($request->profile_year && $request->profile_month && $request->profile_day) {
                $dob = Carbon::parse($request->profile_year . '-' . $request->profile_month . '-' . $request->profile_day);
            }

            if (Carbon::now()->diffInYears($dob, false) > -18) {
                return response()->json([
                    'status' => false,
                    'messages' => ['You must be at least 18 years of age to create profile']
                ]);
            }

            $request->merge([
                'dob' => $dob,
            ]);
        }

        try {
            $newProfile = false;

            DB::beginTransaction();

            $request->merge([
                'user_id' => Auth::user()->id,
                'availability' => $request->availability ? $request->availability : [],
                'online_class' => true //$request->online_class ? true : false,
            ]);

            if (Auth::user()->educator) {
                Auth::user()->educator->update($request->except(['categories', 'areas']));
            } else {
                $newProfile = true;
                if ($request->user_type == 2) {
                    Auth::user()->update(['account_live' => false]);
                }
                Educator::create($request->except(Educator::EXCEPT_FIELDS));
            }

            // Update user name and email
            if ($request->user_type == 1) {
                Auth::user()->update(['account_live' => true]);
            }

            $categories = $this->getCategoryIdsFromRequest($request);

            Auth::user()->categories()->sync($categories);

            Auth::user()->areas()->sync($request->areas);

            DB::commit();

            if ($newProfile && $request->user_type == 1) {
                $job = new SendEmailJob(Auth::user()->email, new ProfileLive(Auth::user(), Auth::user()->email));
                $this->dispatch($job);
            }

            // Intercom Data
            $customData = [
                'Educator' => true,
                'Educator Type' => Auth::user()->educator->user_type == 1 ? 'Type 1' : 'Type 2',
                'Bookings no' => Auth::user()->educator ? Auth::user()->educatorBookings()->count() : Auth::user()->bookings()->count(),
                'Impressions no' => Auth::user()->searchAppearances()->count(),
                'Views no' => Auth::user()->views()->count(),
                'Lessons no' => Auth::user()->lessons()->count(),
                'Stripe Connected' => Auth::user()->stripe_acct_id ? true : false,
                'List Class' => Auth::user()->lessonsWithTrashed()->count() ? true : false,
                'Profile Complete' => $request->user_type == 1 ? true : false
            ];

            $data = [
                'user_id' => Auth::user()->id,
                'email' => Auth::user()->email,
                'name' => Auth::user()->name,
                'custom_attributes' => $customData,
            ];

            $intercomJob = new IntercomJob(Auth::user(), $data);

            $this->dispatch($intercomJob);

            if ($request->user_type && $request->user_type == 1) {
                return response()->json([
                    'status' => true,
                    'messages' => !$newProfile ? [Lang::get('messages.icon.ok'), Lang::get('messages.update', ['name' => 'Your profile'])] : [],
                    'redirect_url' => Auth::user()->stripe_acct_id ? route('educator.dashboard')
                        : route('educator.lesson.create')
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'messages' => !$newProfile ? [Lang::get('messages.icon.ok'), Lang::get('messages.update', ['name' => 'Your profile'])] : [],
                    'redirect_url' => route('educator.lesson.create')
                ]);
            }

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'messages' => [\Lang::get('messages.error'), $e->getMessage()]
            ]);
        }
    }

    public function autoSave(Request $request)
    {

        try {
            DB::beginTransaction();

            $request->merge([
                'user_id' => Auth::user()->id,
                'availability' => $request->availability ? $request->availability : [],
                'user_type' => $request->user_type ? $request->user_type : 1
            ]);

            if (Auth::user()->educator) {
                Auth::user()->educator->update($request->except(['categories', 'areas']));
            } else {
                Educator::create($request->except(Educator::EXCEPT_FIELDS));
            }

            if ($request->categories) {
                $categories = $this->getCategoryIdsFromRequest($request);
                Auth::user()->categories()->sync($categories);
            }

            if ($request->areas) {
                Auth::user()->areas()->sync($request->areas);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    public function getCategoryIdsFromRequest($request)
    {
        $categories = [];
        foreach ($request->categories as $category) {
            $category = Category::findOrFail($category);

            if (!in_array($category->id, $categories))
                array_push($categories, $category->id);

        }

        return $categories;
    }

    public function previewProfile(Request $request, $userId = null)
    {
        if (!$userId) {
            if ($request->user_type == 1) {
                $validate = ClassHubHelper::validateData($request->all(), Educator::VALIDATION_PREVIEW_RULES_1);
            } else {
                $validate = ClassHubHelper::validateData($request->all(), Educator::VALIDATION_PREVIEW_RULES_2);
            }

            // Return array of errors if not validated
            if (is_array($validate))
                return response()->json($validate);
        }

        if ($userId && !Auth::user()->educator) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.profile.required')]
            ]);
        }

        try {
            $user = Auth::user();

            $profile = $userId ? $user->educator : new Educator($request->all());

            $photo = ClassHubHelper::getImagePath(null, $userId ? $user->educator->photo : $request->photo);

            $intro_video = $userId ? $user->educator->intro_video : $request->intro_video;

            $bio = $userId ? $user->educator->bio : $request->bio;

            $subjects = $userId ? $user->categories :
                Category::withTrashed()->whereIn('id', $request->categories)->get();

            $teachingTypes = $userId ? $user->educator->teaching_types : $request->teaching_types;

            $qualifications = $userId ? $user->educator->qualifications : $request->qualifications;

            $areas = $userId ? $user->areas : ($request->areas ?
                Area::whereIn('id', $request->areas)->get() : collect([]));

            $lessons = $userId ? Auth::user()->lessons : collect([]);

            $availability = $userId ? $user->educator->availability : ($request->availability ? $request->availability : []);

            if ($request->user_type == 1) {
                $view = View::make('educator.includes.preview-profile', compact('user', 'profile', 'photo',
                    'intro_video', 'bio', 'subjects', 'qualifications', 'areas', 'teachingTypes', 'lessons', 'availability'));
            } else {
                $view = View::make('educator.includes.preview-profile-default', compact('user', 'profile', 'photo',
                    'bio', 'subjects', 'qualifications', 'areas', 'teachingTypes', 'lessons'));
            }

            return response()->json([
                'status' => true,
                'profile' => $view->render(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [$e->getMessage()]
            ]);
        }
    }

    public function addView($userId)
    {
        try {
            EducatorView::create([
                'user_id' => $userId,
                'ip' => request()->getClientIp()
            ]);

            return response()->json([
                'status' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [\Lang::get('messages.error')],
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function like($educatorId)
    {
        if (!Auth::check())
            return response()->json([
                'status' => false,
                'messages' => [\Lang::get('messages.auth.required', ['text' => 'to add to Favourite'])]
            ]);

        try {
            Auth::user()->likedEducators()->attach($educatorId);

            return response()->json([
                'status' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [\Lang::get('messages.error')],
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function unlike($educatorId)
    {
        if (!Auth::check())
            return response()->json([
                'status' => false,
                'messages' => [\Lang::get('messages.auth.required', ['text' => 'to add to Favourite'])]
            ]);

        try {
            Auth::user()->likedEducators()->detach($educatorId);

            return response()->json([
                'status' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error')],
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function getReviews($id)
    {
        try {

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function addCategory(Request $request)
    {
        try {
            $category = Category::findOrFail($request->category_id);

            Auth::user()->categories()->attach($category->id);

            if ($category->parent_id &&
                !in_array($category->parent_id, Auth::user()->categories->pluck('id')->toArray())) {
                Auth::user()->categories()->attach($category->parent_id);
            }

            $categoryName = Category::getDisplayName($category->id);

            return response()->json([
                'status' => true,
                'messages' => [
                    Lang::get('messages.icon.ok'),
                    Lang::get('messages.category.added', ['name' => $categoryName])
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error')],
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function addBacklog(Request $request)
    {
        try {
            EducatorBacklog::create([
                'educator_id' => $request->educator_id,
                'category_id' => $request->category_id,
            ]);

            return response()->json([
                'status' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error')],
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function share(Request $request)
    {
        $validate = ClassHubHelper::validateData($request->all(), ['share_email' => 'required|email']);

        // Return array of errors if not validated
        if (is_array($validate))
            return response()->json($validate);

        $educator = null;

        try {
            $educator = User::findOrFail($request->educator_id);

            $job = new SendEmailJob($request->share_email, new ShareEducator($educator, $educator->email));

            $this->dispatch($job);

            return response()->json([
                'status' => true,
                'messages' => [
                    Lang::get('messages.icon.ok'),
                    Lang::get('messages.profile.share.success',
                        ['name' => $educator->id == Auth::user()->id ? 'Your' : $educator->name])
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.profile.share.error', ['name' => $educator->name])],
                'errors' => $e->getMessage()
            ]);
        }
    }


    public function getEarningStats(Request $request)
    {
        try {
            $dateFormat = $request->type == 'year' ? 'Y' : 'Y-m';

            $bookings = Educator::getAllBookings();

            $earningAmount = Transaction::getEarningsAmount($bookings, $request->type, $request->date);

            $date = Carbon::createFromFormat($dateFormat, $request->date);

            $view = View::make('educator.includes.earning-stat-row', [
                'earningAmount' => $earningAmount,
                'dateFormat' => $dateFormat,
                'date' => $date,
                'type' => $request->type
            ])->render();

            return response()->json([
                'status' => true,
                'html' => $view,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'html' => $e->getMessage(),
            ]);
        }
    }


    public function getAdvertViewStats(Request $request)
    {
        try {
            $dateFormat = 'Y-m';

            $adViews = Lesson::getViewCount($request->date);

            $date = Carbon::createFromFormat($dateFormat, $request->date);

            $view = View::make('educator.includes.advert-view-stat-row', [
                'adViews' => $adViews,
                'dateFormat' => $dateFormat,
                'date' => $date,
            ])->render();

            return response()->json([
                'status' => true,
                'html' => $view,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'html' => $e->getMessage(),
            ]);
        }
    }

    public function getLessonBookingStats(Request $request)
    {
        try {
            $dateFormat = 'Y-m';

            $numBookings = Booking::getBookings($request->date)->count();

            $date = Carbon::createFromFormat($dateFormat, $request->date);

            $view = View::make('educator.includes.booking-count-stat-row', [
                'numBookings' => $numBookings,
                'dateFormat' => $dateFormat,
                'date' => $date,
            ])->render();

            return response()->json([
                'status' => true,
                'html' => $view,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'html' => $e->getMessage(),
            ]);
        }
    }

    public function getAllStats(Request $request)
    {
        try {
            $date = $request->date;
            $bookings = Booking::getBookings($request->date);
            $numSearches = Educator::getSearchAppearances($request->date);
            $lessonViews = Lesson::getViewCount($request->date);
            $profileViews = Educator::getViewCount($request->date);
            $numLikes = Educator::getLikeCount($request->date);
            $numBookings = $bookings->count();
            $rating = Educator::getRating($request->date);

            $avgBookingAmount = Transaction::getBookingsAmount($bookings, 'month', $request->date);
            $avgEarningAmount = Transaction::getEarningsAmount($bookings, 'month', $request->date);
            $commissionAmount = Transaction::getCommissionAmount($bookings, 'month', $request->date);
            $stripeFee = Transaction::getStripeFee($bookings, 'month', $request->date);
            $serviceCharge = Transaction::getServiceCharge($bookings, 'month', $request->date);

            return View::make('educator.includes.all-stats',
                compact('numBookings', 'lessonViews', 'profileViews',
                    'numLikes', 'avgEarningAmount', 'avgBookingAmount', 'rating', 'numSearches',
                    'commissionAmount', 'stripeFee', 'serviceCharge', 'date'))->render();

        } catch (\Exception $e) {
            return '<p class="alert alert-danger">' . $e->getMessage() . '</p>';
        }
    }

    public function downloadAllStats(Request $request)
    {
        try {
            $educator = Auth::user();
            $numSearches = Educator::getSearchAppearances($request->date);
            $numBookings = Booking::getBookings($request->date)->count();
            $lessonViews = Lesson::getViewCount($request->date);
            $profileViews = Educator::getViewCount($request->date);
            $numLikes = Educator::getLikeCount($request->date);
            $rating = Educator::getRating($request->date);

            $bookings = Auth::user()->educatorBookings;

            $avgBookingAmount = Transaction::getBookingsAmount($bookings, 'month', $request->date);
            $avgEarningAmount = Transaction::getEarningsAmount($bookings, 'month', $request->date);
            $commissionAmount = Transaction::getCommissionAmount($bookings, 'month', $request->date);
            $stripeFee = Transaction::getStripeFee($bookings, 'month', $request->date);
            $serviceCharge = Transaction::getServiceCharge($bookings, 'month', $request->date);

            view()->share('educator', $educator);
            view()->share('numSearches', $numSearches);
            view()->share('numBookings', $numBookings);
            view()->share('lessonViews', $lessonViews);
            view()->share('profileViews', $profileViews);
            view()->share('numLikes', $numLikes);
            view()->share('rating', $rating);
            view()->share('avgBookingAmount', $avgBookingAmount);
            view()->share('avgEarningAmount', $avgEarningAmount);
            view()->share('commissionAmount', $commissionAmount);
            view()->share('stripeFee', $stripeFee);
            view()->share('serviceCharge', $serviceCharge);
            view()->share('name', Auth::user()->name);
            view()->share('month', Carbon::parse($request->date)->format('F, Y'));

            libxml_use_internal_errors(true);

            $pdf = PDF::loadView('pdf.monthly-stats');

            return $pdf->download('monthly-stats-' . $request->date . '.pdf');

        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public static function weeklyStats()
    {
        try {
            $weekStartAt = Carbon::now()->startOfWeek();
            $weekEndtAt = Carbon::now()->endOfWeek();
            $users = User::where('is_admin', 0)->get();

            foreach ($users as $user) {

                if ($user->educator) {

                    $stats = [];

                    $lessonIds = $user->lessons->pluck('id');
                    $bookings = Booking::whereIn('lesson_id', $lessonIds)
                        ->whereBetween('created_at', [$weekStartAt, $weekEndtAt])->get();

                    $numBookings = $bookings->count();

                    $lessonViews = LessonView::whereIn('lesson_id', $lessonIds)
                        ->whereBetween('created_at', [$weekStartAt, $weekEndtAt])->get()->count();

                    $profileViews = $user->views()->whereBetween('created_at',
                        [$weekStartAt, $weekEndtAt])->get()->count();

                    $numLikes = DB::table('liked_educators')->select()->where('educator_id', $user->id)
                        ->whereBetween('created_at', [$weekStartAt, $weekEndtAt])->get()->count();

                    $ratings = $user->ratings()->whereBetween('created_at', [$weekStartAt, $weekEndtAt])->get();
                    $score = 0;

                    if ($ratings->count()) {
                        foreach ($ratings as $rating) {
                            $score += $rating->score;
                        }
                        $score = $score / $ratings->count();
                    }

                    $numSearches = $user->searchAppearances()->whereBetween('created_at',
                        [$weekStartAt, $weekEndtAt])->get()->count();

                    $avgBookingAmount = Transaction::getBookingsAmount($bookings, 'month', null);
                    $avgEarningAmount = Transaction::getEarningsAmount($bookings, 'month', null);
                    $commissionAmount = Transaction::getCommissionAmount($bookings, 'month', null);

                    $stats['num_searches'] = $numSearches;
                    $stats['lesson_views'] = $lessonViews;
                    $stats['profile_views'] = $profileViews;
                    $stats['num_likes'] = $numLikes;
                    $stats['rating'] = $score;
                    $stats['num_bookings'] = $numBookings;
                    $stats['avg_booking_amount'] = $avgBookingAmount;
                    $stats['avg_earning_amount'] = $avgEarningAmount;
                    $stats['avg_commission_amount'] = $commissionAmount;

                    $job = new SendEmailJob($user->email, new WeeklyStats($user, $stats, $user->email));
                    dispatch($job);
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getTraceAsString());
        }
    }

    public function goOffline()
    {
        try {
            $bookings = Auth::user()->educatorBookings;

            // Check upcoming bookings
            if ($bookings->count()) {
                foreach ($bookings as $booking) {
                    if ($booking->status === 'cancelled' || $booking->lesson->status != 'live')
                        continue;

                    $lastClass = $booking->lesson->classes->last();
                    $classEndtAt = Carbon::parse($lastClass->date . ' ' . $lastClass->end_time);

                    // Live class or Refund request still can be made
                    if (!$lastClass->isPastClass) {
                        return response()->json([
                            'status' => false,
                            'messages' => ['Upcoming Booking',
                                $classEndtAt->format('d/m/Y H:i'), $lastClass->id]
                        ]);
                    }

                    if (Carbon::now()->lessThan($classEndtAt->addDay())) {
                        return response()->json([
                            'status' => false,
                            'messages' => ['Refundable',
                                $classEndtAt->format('d/m/Y H:i'), $lastClass->id]
                        ]);
                    }
                }
            }

            Auth::user()->update(['is_online' => 0]);

            $job = new SendEmailJob(Auth::user()->email, new Offline(Auth::user(), Auth::user()->email));

            dispatch($job);

            return response()->json([
                'status' => true
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [$e->getMessage()],
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function goOnline()
    {
        try {
            Auth::user()->update(['is_online' => 1]);

            $job = new SendEmailJob(Auth::user()->email, new Online(Auth::user(), Auth::user()->email));

            dispatch($job);

            return response()->json([
                'status' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [$e->getMessage()],
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function completedBookingPayouts(Request $request)
    {
        try {
            $start = Carbon::createFromFormat('m-Y', $request->from_month . '-' . $request->from_year)
                ->startOfMonth();
            $end = Carbon::createFromFormat('m-Y', $request->to_month . '-' . $request->to_year)
                ->endOfMonth();

            if ($start->greaterThan($end)) {
                return '<p>Please select From date less than To Date</p>';
            }

            $lessons = Auth::user()->lessonsWithTrashed()->whereHas('bookings')->get();

            $completedPayouts = [];

            $total = 0;

            $i = 0;

            $currencySymbol = "€";

            foreach ($lessons as $lesson) {

                $lessonTotal = 0;

                $completedPayouts[$i]['lesson_name'] = $lesson->name;
                $completedPayouts[$i]['type'] = $lesson->type;

                $j = 0;

                foreach ($lesson->classes as $class) {

                    $bookingClasses = BookingClass::setEagerLoads([])->where('lesson_class_id', $class->id)->get();

                    $completedPayouts[$i]['classes'][$j]['class_date'] =
                        Carbon::parse($class->date)->format('jS M Y');

                    $completedPayouts[$i]['classes'][$j]['start_time'] =
                        Carbon::parse($class->start_time)->format('H:i');

                    $completedPayouts[$i]['classes'][$j]['end_time'] =
                        Carbon::parse($class->end_time)->format('H:i');

                    $completedPayouts[$i]['classes'][$j]['class_id'] = $class->id;

                    $k = 0;

                    foreach ($bookingClasses as $bookingClass) {

                        if ($bookingClass->status === 'cancelled')
                            continue;


                        if ($bookingClass->transaction_id && $bookingClass->payout_amount) {

                            $transaction = Transaction::find($bookingClass->transaction_id);

                            $transactionData = json_decode($transaction['txn_details']);

                            $currencySymbol = "€";
                            if($transactionData->currency == "gbp"){
                              $currencySymbol = "£";
                            }

                            $payoutDate = Carbon::parse($transactionData->created);

                            if (!$payoutDate->greaterThanOrEqualTo($start) || !$payoutDate->lessThanOrEqualTo($end))
                                continue;

                            $booking = Booking::setEagerLoads([])->findOrFail($bookingClass->booking_id);

                            $estimateDate = Carbon::parse($transactionData->arrival_date)->format('jS M Y');

                            $lessonTotal += $bookingClass->payout_amount;

                            $completedPayouts[$i]['classes'][$j]['bookings'][$k] = [
                                'code' => ClassHubHelper::getbookingCode($booking),
                                'student' => $booking->student_name,
                                'class_id' => $bookingClass->lesson_class_id,
                                'start_time' => Carbon::parse($bookingClass->class->start_time)->format('H:i'),
                                'end_time' => Carbon::parse($bookingClass->class->end_time)->format('H:i'),
                                'amount' => $bookingClass->payout_amount,
                                'arrival_date' => $estimateDate,
                                'currency_symbol' => $currencySymbol,
                            ];
                        }
                        $k++;
                    }
                    $completedPayouts[$i]['currency_symbol'] = $currencySymbol;

                    $j++;
                }

                $completedPayouts[$i]['total'] = $lessonTotal;

                $total += $lessonTotal;

                $i++;
            }

            return View::make('educator.includes.completed-payout',
                compact('completedPayouts', 'total', 'currencySymbol'))->render();

        } catch (\Exception $e) {
            return '<p>' . $e->getMessage() . '</p>';
        }
    }

    public function pendingBookingPayouts(Request $request)
    {
        try {
            $lessons = Auth::user()->lessonsWithTrashed()->whereHas('bookings')->get();

            $pendingPayouts = [];

            $total = 0;

            $i = 0;

            foreach ($lessons as $lesson) {

                $lessonTotal = 0;

                $pendingPayouts[$i]['lesson_name'] = $lesson->name;
                $pendingPayouts[$i]['type'] = $lesson->type;

                $j = 0;

                foreach ($lesson->classes as $class) {

                    $bookingClasses = BookingClass::setEagerLoads([])->where('lesson_class_id', $class->id)->get();

                    $pendingPayouts[$i]['classes'][$j]['class_date'] =
                        Carbon::parse($class->date)->format('jS M Y');

                    $pendingPayouts[$i]['classes'][$j]['start_time'] =
                        Carbon::parse($class->start_time)->format('H:i');

                    $pendingPayouts[$i]['classes'][$j]['end_time'] =
                        Carbon::parse($class->end_time)->format('H:i');

                    $pendingPayouts[$i]['classes'][$j]['class_id'] = $class->id;

                    $k = 0;

                    foreach ($bookingClasses as $bookingClass) {

                        $booking = Booking::setEagerLoads([])->findOrFail($bookingClass->booking_id);

                        if ($bookingClass->status === 'cancelled')
                            continue;

                        $refundRequest = RefundRequest::where('booking_id', $booking->id)
                            ->where('lesson_class_id', $bookingClass->lesson_class_id)->first();

                        if ($refundRequest && ($refundRequest->has_been_payout || $refundRequest->in_progress)) {
                            continue;
                        }


                        if (!$bookingClass->transaction_id && !$bookingClass->payout_amount) {

                            $amountPayablePerClass = ClassHubHelper::roundCents(
                                ($booking->amount - $booking->application_fee) / $booking->classes->count());

                            $stripeFee = ClassHubHelper::roundCents($booking->stripe_fee / $booking->classes->count());

                            $amountPayablePerClass -= $stripeFee;

                            $lessonTotal += $amountPayablePerClass;

                            $pendingPayouts[$i]['classes'][$j]['bookings'][$k] = [
                                'code' => ClassHubHelper::getbookingCode($booking),
                                'student' => $booking->student_name,
                                'class_id' => $bookingClass->lesson_class_id,
                                'start_time' => Carbon::parse($bookingClass->class->start_time)->format('H:i'),
                                'end_time' => Carbon::parse($bookingClass->class->end_time)->format('H:i'),
                                'amount' => $amountPayablePerClass,
                            ];
                        }
                        $k++;

                    }

                    $j++;

                }

                $pendingPayouts[$i]['total'] = $lessonTotal;
                $total += $lessonTotal;

                $i++;
            }

            return View::make('educator.includes.pending-payout',
                compact('total', 'pendingPayouts', 'total'))->render();

        } catch (\Exception $e) {
            return '<p>' . $e->getMessage() . '</p>';
        }
    }

    public function earningPerBooking(Request $request)
    {
        try {
            $lessons = Auth::user()->lessonsWithTrashed()->whereHas('bookings')->get();

            $earnings = [];

            $total = 0;

            $i = 0;

            foreach ($lessons as $lesson) {

                $lessonTotal = 0;

                $earnings[$i]['lesson_name'] = $lesson->name;
                $earnings[$i]['type'] = $lesson->type;

                $j = 0;

                foreach ($lesson->classes as $class) {

                    $bookingClasses = BookingClass::setEagerLoads([])->where('lesson_class_id', $class->id)->get();

                    $earnings[$i]['classes'][$j]['class_date'] =
                        Carbon::parse($class->date)->format('jS M Y');

                    $earnings[$i]['classes'][$j]['start_time'] =
                        Carbon::parse($class->start_time)->format('H:i');

                    $earnings[$i]['classes'][$j]['end_time'] =
                        Carbon::parse($class->end_time)->format('H:i');

                    $earnings[$i]['classes'][$j]['class_id'] = $class->id;

                    $k = 0;

                    foreach ($bookingClasses as $bookingClass) {

                        $booking = Booking::setEagerLoads([])->findOrFail($bookingClass->booking_id);

                        if ($bookingClass->status === 'cancelled')
                            continue;

                        $refundRequest = RefundRequest::where('booking_id', $booking->id)
                            ->where('lesson_class_id', $bookingClass->lesson_class_id)->first();

                        if ($refundRequest && ($refundRequest->has_been_payout || $refundRequest->in_progress)) {
                            continue;
                        }


                        $amountPayablePerClass = ClassHubHelper::roundCents(
                            ($booking->amount - $booking->application_fee) / $booking->classes->count());

                        $stripeFee = ClassHubHelper::roundCents($booking->stripe_fee / $booking->classes->count());

                        $amountPayablePerClass -= $stripeFee;

                        $lessonTotal += $bookingClass->transaction_id && $bookingClass->payout_amount ?
                            $bookingClass->payout_amount : $amountPayablePerClass;

                        $earnings[$i]['classes'][$j]['bookings'][$k] = [
                            'code' => ClassHubHelper::getbookingCode($booking),
                            'student' => $booking->student_name,
                            'class_id' => $bookingClass->lesson_class_id,
                            'start_time' => Carbon::parse($bookingClass->class->start_time)->format('H:i'),
                            'end_time' => Carbon::parse($bookingClass->class->end_time)->format('H:i'),
                            'amount' => $amountPayablePerClass,
                        ];
                        $k++;

                    }

                    $j++;

                }

                $earnings[$i]['total'] = $lessonTotal;

                $total += $lessonTotal;

                $i++;
            }

            return View::make('educator.includes.earning-booking',
                compact('total', 'earnings'))->render();

        } catch (\Exception $e) {
            return '<p>' . $e->getMessage() . '</p>';
        }
    }

    public function uploadReferences(Request $request)
    {
        try {
            $educator = Auth::user()->educator;

            $references = [$request->reference1, $request->reference2];

            $educator->update(['references' => $references]);

            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.icon.ok'), 'Reference files upload successfully'],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()],
                'errors' => $e->getTrace()
            ]);
        }
    }

    public function applyJobsBoard(Request $request)
    {
        try {
            $message = Message::findOrFail($request->job_id);

            $message->update(['request_applied' => 1]);

            return response()->json([
                'status' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function crcStore(Request $request)
    {
        try {
            Auth::user()->update(['trusted' => 1]);

            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.icon.ok'), Lang::get('messages.crc.store')]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.error'), $e->getMessage()]
            ]);
        }
    }

    public static function draftLessonsReminder()
    {
        try {
            $lessons = Lesson::where('status', 'draft')->get();

            foreach ($lessons as $lesson) {
                $lastEditTime = Carbon::parse($lesson->updated_at);
                dump(Carbon::now()->diffInHours($lastEditTime, false));

                if (Carbon::now()->diffInHours($lastEditTime, false) <= -24 &&
                    Carbon::now()->diffInHours($lastEditTime, false) > -48) {
                    $sendReminder = true;
                } else if (Carbon::now()->diffInHours($lastEditTime, false) <= -72 &&
                    Carbon::now()->diffInHours($lastEditTime, false) > -96) {
                    $sendReminder = true;
                } else {
                    $sendReminder = false;
                }

                if ($sendReminder) {
                    $user = User::findOrFail($lesson->user_id);
                    $job = new SendEmailJob($user->email, new DraftLessonReminder($user, $lesson, $user->email));
                    dispatch($job);
                }
            }
        } catch (\Exception $e) {

        }
    }

    public static function setupClassReminder()
    {
        try {
            $users = User::whereHas('educator')->get();

            foreach ($users as $user) {
                $classes = $user->lessons()->withTrashed()->get();

                if (!$classes->count() && $user->educator) {
                    $educator = $user->educator;

                    if ($educator->user_type == 1) {
                        continue;
                    }

                    $createAt = Carbon::parse($educator->created_at);
                    $updatedAt = Carbon::parse($educator->updated_at);

                    DB::beginTransaction();

                    // Two hours after profile goes live
                    if (is_null($educator->setup_class_reminder)
                        && Carbon::now()->diffInHours($createAt, false) <= -2) {

                        $educator->update(['setup_class_reminder' => '2hrs']);
                        $sendReminder = true;

                    } // 48hrs after first notification
                    else if ($educator->setup_class_reminder == '2hrs'
                        && Carbon::now()->diffInHours($updatedAt, false) <= -48) {

                        $educator->update(['setup_class_reminder' => '48hrs']);
                        $sendReminder = true;

                    } // Every 7 days
                    else if (in_array($educator->setup_class_reminder, ['48hrs', '7days'])
                        && Carbon::now()->diffInDays($updatedAt, false) <= -7) {

                        $educator->update(['setup_class_reminder' => '7days', 'updated_at' => Carbon::now()]);
                        $sendReminder = true;

                    } else {
                        $sendReminder = false;
                    }

                    DB::commit();

                    if ($sendReminder) {
                        $job = new SendEmailJob($user->email, new EducatorSetupClassReminder($user));

                        dispatch($job);
                    }
                }
            }
        } catch (\Exception $e) {

        }
    }

    public static function trustedReminder()
    {
        try {
            $users = User::whereHas('educator')->get();

            foreach ($users as $user) {

                if (!$user->educator)
                    continue;

                $educator = $user->educator;
                $createAt = Carbon::parse($educator->created_at);

                if ((is_null($educator->references[0]) || is_null($educator->references[1])) &&
                    Carbon::now()->diffInHours($createAt, false) >= -72) {
                    $job = new SendEmailJob($user->email, new TrustedReminder($user));
                    dispatch($job);
                }
            }
        } catch (\Exception $e) {

        }
    }

    public static function jobsBoardReminder()
    {
        try {
            $jobsBoard = JobBoard::where('applied', 0)->get();

            if ($jobsBoard->count()) {

                $jobsBoard = $jobsBoard->groupBy('educator_id');

                foreach ($jobsBoard as $userId => $userJobBoards) {

                    foreach ($userJobBoards as $userJobBoard) {
                        $userJobBoard->update(['notified_at' => Carbon::now()]);
                    }

                    try {

                        $user = User::findOrFail($userId);

                        $job = new SendEmailJob($user->email,
                            new JobBoardReminder($user, route('educator.job-board'), $user->email));

                        dispatch($job);
                    } catch (\Exception $e) {
                    }
                }
            }

            /*$educators = User::whereHas('educator')->where('is_online', 1)
                ->where('account_live', 1)->get();


            foreach ($educators as $educator) {

                $job = new SendEmailJob($educator->email,
                    new JobBoardReminder($educator, route('educator.job-board'), $educator->email));

                dispatch($job);
            }*/
        } catch (\Exception $e) {
        }
    }

    public static function deleteOldTutorRequests()
    {
        try {
            $tutorRequests = JobBoard::all();

            foreach ($tutorRequests as $tutorRequest) {
                $requestedAt = Carbon::parse($tutorRequest->created_at);
                if (Carbon::now()->diffInDays($requestedAt) > 14) {
                    $tutorRequest->forceDelete();
                }
            }
        } catch (\Exception $e) {
        }
    }

    public static function deactivateTutorAccounts()
    {
        try {
            $tutors = User::where('active', 1)->whereHas('educator')->get();

            foreach ($tutors as $tutor) {

                if (is_null($tutor->last_login))
                    continue;

                $lastLoginDate = Carbon::parse($tutor->last_login);

                if (Carbon::now()->diffInMonths($lastLoginDate) > 4) {
                    try {

                        $tutor->update([
                            'is_online' => 0,
                            'active' => 0
                        ]);

                        // Send Email
                        $job = new SendEmailJob($tutor->email, new DeactivateEmail($tutor));
                        dispatch($job);
                    } catch (\Exception $e) {

                    }
                }
            }

        } catch (\Exception $e) {

        }
    }

    public function extraDeviceEmail(Request $request)
    {
        try {
            $job = new SendEmailJob(Auth::user()->email, new ExtraDeviceVideoCall(Auth::user(), Auth::user()->email, $request->class_id));

            $this->dispatch($job);

            return response()->json([
                'status' => true,
                'message' => 'Extra device join Link sent to your email, Please login with other Device and click on Join link',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'errors' => $e->getTrace()
            ]);
        }
    }

    public static function setTopPerformers()
    {
        try {
            DB::beginTransaction();

            TopPerformer::truncate();

            $categories = Category::withTrashed()->get();
    
            foreach ($categories as $category) {
                $topPerformerIds = ClassHubHelper::getTopPerformerIds($category->id);
    
                foreach ($topPerformerIds as $educator_id) {
                    TopPerformer::create([
                        'educator_id' => $educator_id,
                        'category_id' => $category->id,
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function getZoomAccountId() {
        try {
            $user = Auth::user();

            if ($user->educator->zoom_acct_id) {
                return $user->educator->zoom_acct_id;
            } else {
                $data = [
                    'email' => $user->email,
                    'first_name' => $user->name,
                    'last_name' => '',
                ];
        
                $response = (new ZoomMeetingController)->createUser($data);

                if ($response['success']) {
                    $user->educator->update(['zoom_acct_id' => $response['data']['id']]);
                    
                    return $response['data']['id'];
                }

                return null;
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return null;
        }
    }
}
