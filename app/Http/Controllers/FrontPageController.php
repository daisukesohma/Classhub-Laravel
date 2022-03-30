<?php

namespace App\Http\Controllers;

use App\Area;
use App\Category;
use App\Educator;
use App\EducatorSearch;
use App\EducatorView;
use App\Exports\EducatorTransaction;
use App\Exports\UserExport;
use App\FAQ;
use App\FAQCategory;
use App\FreeVideoCall;
use App\Helpers\ClassHubHelper;
use App\JobBoard;
use App\Jobs\IntercomJob;
use App\Jobs\SendEmailJob;
use App\Lesson;
use App\LessonClass;
use App\LessonView;
use App\Mail\ClasshubEnquiry;
use App\Mail\FreeCallScheduled;
use App\Message;
use App\Post;
use App\Setting;
use App\Testimonial;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Intercom\IntercomClient;
use Jenssegers\Agent\Agent;
use Maatwebsite\Excel\Facades\Excel;
use Stripe\Account;
use Stripe\Stripe;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use Vimeo\Vimeo;
use Illuminate\Support\Str;

class FrontPageController extends Controller
{
    
    public function home()
    {
        $agent = new Agent();
        $mobile = $agent->isMobile();
        $desktop = $agent->isDesktop();
        
        $perPage = $mobile ? 6 : 4;
        
        $grinds = Category::whereType('Grinds')->whereNull('parent_id')->paginate($perPage);
        $activities = Category::whereType('Activities')->whereNull('parent_id')->paginate($perPage);
        
        $trustedLogos = Setting::get('trusted_logos') ? @unserialize(Setting::get('trusted_logos')) : [];
        
        $topEducators = Educator::inRandomOrder(date('dmY'))
            ->whereHas('user', function ($query) {
                $query->where('is_online', 1)
                    ->where('account_live', 1);
            })
            ->paginate($perPage);
        
        $areaId = request('area_id');
        
        $posts = PostController::recentPosts(3);
        
        $bannerImages = @unserialize(Setting::get('banner_images'));
        $bannerImagePaths = [];
        if (is_array($bannerImages)) {
            foreach ($bannerImages as $id) {
                $path = ClassHubHelper::getImagePath(null, $id);
                
                if ($path)
                    array_push($bannerImagePaths, $path);
            }
        }
        
        return view('frontend.pages.index', compact('grinds', 'activities', 'trustedLogos',
            'topEducators', 'areaId', 'posts', 'bannerImagePaths', 'desktop'));
    }
    
    public function category($slug)
    {
        try {
            $category = Category::whereSlug($slug)->first();
            
            $selectedSubjects = [$category->id, $category->subCategories->first() ?
                $category->subCategories->first()->id : null];
            
            $categories = [$category->id];
            
            $categories = array_merge($categories, $category->subCategories->pluck('id')->toArray());
            
            $allLessons = Lesson::liveClass()->where('type', '!=', 'subject')->whereIn('category_id', $categories)->get();
            
            $lessons = ClassHubHelper::lessonPaginate($allLessons, 8);
            
            $areaId = 1;
            
            $subjectTutors = User::where('is_online', 1)
                ->where('account_live', 1)
                ->inRandomOrder(Carbon::now()->format('d-m-Y'))
                ->whereHas('categories', function ($query) use ($categories) {
                    $query->whereIn('category_id', $categories);
                })->paginate(4);
            
            $subjectTutors->appends(['category_id' => $category->id, 'area_id' => $areaId])->links();
            
            $relatedLessons = Lesson::liveClass()->where('type', '!=', 'subject')->inRandomOrder()
                ->whereHas('user', function ($query) {
                    $query->where('is_online', 1)
                        ->where('account_live', 1);
                    
                })
                ->where('bookable', true)
                ->where('end_date', '>=', Carbon::now())
                ->get();
            
            $topEducators = Educator::inRandomOrder(date('dmY'))
                ->whereHas('user', function ($query) {
                    $query->where('is_online', 1)
                        ->where('account_live', 1);
                })
                ->paginate(4);
            
            $relatedLessons = ClassHubHelper::lessonPaginate($relatedLessons, 4);
            
            if ($category->type == 'Grinds') {
                $title = $category->name . ' Grinds, Tutors & Classes In Dublin | Classhub';
                $description = 'Browse our Dublin ' . $category->name . ' Grinds & Classes and find your perfect '
                    . $category->name . ' tutor now. Check out reviews, and book & pay online with no hassle.';
            } else {
                $title = $category->name . ' Classes & Activities In Dublin | Classhub';
                $description = 'Browse Dublin ' . $category->name . ' Classes & Activities and find your perfect lessons now.
                Check out reviews, and book & pay online with no hassle.';
            }
            
            $itemList = [
                '@context' => 'http://schema.org',
                '@type' => 'ItemList',
                'name' => $title,
                'description' => $description,
                'url' => route('page.category', $category->slug),
            ];
            
            $itemListElements = [];
            
            $lessonCount = 0;
            
            foreach ($allLessons as $lesson) {
                
                $firstClass = $lesson->classes->first();
                $lastClass = $lesson->classes->last();
                $classStartAt = Carbon::parse($firstClass->date . ' ' . $firstClass->start_time);
                $classEndAt = Carbon::parse($lastClass->date . ' ' . $lastClass->start_time);
                $bookableClasses = $lesson->classes()->where('bookable', 1)->get();
                
                if ($lesson->type == 'single') {
                    if ($lesson->status != 'live' || $bookableClasses->isEmpty() || $classEndAt->isPast())
                        continue;
                }
                
                if ($lesson->type == 'term') {
                    if ($lesson->status != 'live' || !$lesson->bookable || $classStartAt->isPast()) {
                        continue;
                    }
                }
                
                array_push($itemListElements,
                    [
                        '@type' => 'Course',
                        'name' => addslashes($lesson->name),
                        'description' => addslashes($lesson->description),
                        'url' => route('page.lesson', $lesson->slug),
                        'contentLocation' => 'Dublin',
                        'position' => $lessonCount + 1,
                        'provider' => [
                            //'location' => addslashes($lesson->location),
                            'name' => $lesson->user->name,
                            'sameAs' => 'https://classhub.ie',
                            'url' => route('page.educator', $lesson->user->slug)
                        ]
                    ]
                );
                
                $lessonCount++;
                
                /*array_push($courseInstances,
                    [
                        '@type' => 'CourseInstance',
                        'startDate' => $lesson->start_date,
                        'endDate' => $lesson->end_date,
                        'location' => $lesson->location,
                        'offers' => [
                            '@type' => 'Offer',
                            'price' => ClassHubHelper::centToEuro($lesson->price),
                            'priceCurrency' => 'EUR'
                        ]
                    ]
                );*/
            }
            
            if ($lessonCount) {
                $itemList['itemListElement'] = $itemListElements;
                $itemList['numberOfItems'] = $lessonCount;
            } else {
                $itemList['@type'] = 'Course';
                $itemList['contentLocation'] = 'Dublin';
                /*$itemList['provider'] = [
                    '@type' => 'Organisation',
                    'name' => 'Classhub',
                    'sameAs' => 'https://classhub.ie',
                ];*/
            }
            
            $desktop = (new Agent())->isDesktop();
            
            return view('frontend.pages.category', compact('category', 'selectedSubjects', 'itemList',
                'lessons', 'areaId', 'relatedLessons', 'topEducators', 'subjectTutors', 'title', 'description', 'desktop'));
            
        } catch (\Exception $e) {
            abort(404);
        }
    }
    
    public function educatorProfile($slug)
    {
        try {
            $user = User::whereSlug($slug)->first();
            
            if (!$user->educator) // || ($user->educator && !$user->account_live))
                abort(404);
            
            if (!$user->account_live) {
                if (Auth::user() && Auth::user()->id == $user->id)
                    return redirect()->route('educator.dashboard');
                else
                    return redirect()->route('home');
            }
            
            // Profile view
            if ((Auth::user() && Auth::user()->id != $user->id) || !Auth::user())
                EducatorView::create(['user_id' => $user->id]);
            
            $liked = false;
            
            if (Auth::user()) {
                $likedEducators = Auth::user()->likedEducators->pluck('id')->toArray();
                $liked = in_array($user->id, $likedEducators) ? true : false;
            }
            
            $subjects = $user->categories;
            
            $lessons = $user->is_online ? $user->lessons()->where('status', 'live')
                ->where('type', '!=', 'subject')->get() : collect();
            
            $liveLessons = collect([]);
            
            if ($lessons->count()) {
                $liveLessons = $lessons->filter(function ($lesson) {
                    
                    if ($lesson->type === 'pre_recorded') {
                        return true;
                    }
                    
                    $firstClass = $lesson->classes->first();
                    $lastClass = $lesson->classes->last();
                    $classStartAt = Carbon::parse($firstClass->date . ' ' . $firstClass->start_time);
                    $classEndAt = Carbon::parse($lastClass->date . ' ' . $lastClass->start_time);
                    
                    if ($lesson->type == 'single') {
                        $bookableClasses = $lesson->classes()->where('bookable', 1)->get();
                        
                        return $lesson->status == 'live' && $bookableClasses->isNotEmpty() && $classEndAt->isFuture();
                    } else {
                        return $lesson->status == 'live' && $lesson->bookable && $classStartAt->isFuture();
                    }
                    
                });
            }
            
            $relatedLessons = Lesson::liveClass()->where('type', '!=', 'subject')->inRandomOrder(date('dmY'))
                ->whereHas('user', function ($query) {
                    $query->where('is_online', 1)
                        ->where('account_live', 1);
                })
                ->where('user_id', '!=', $user->id)->get();
            
            $relatedLessons = ClassHubHelper::lessonPaginate($relatedLessons, 4);
            
            // Intercom Data
            $data = [
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'custom_attributes' => [
                    'Views no' => $user->views()->count(),
                ]
            ];
            
            $intercomJob = new IntercomJob($user, $data);
            
            $this->dispatch($intercomJob);
            
            $mobile = !(new Agent())->isDesktop();
            
            if ($user->educator->user_type == 1) {
                return view('frontend.pages.profile', compact('user', 'liked',
                    'subjects', 'liveLessons', 'relatedLessons', 'mobile'));
            } else {
                return view('frontend.pages.profile-default', compact('user', 'liked',
                    'subjects', 'liveLessons', 'relatedLessons', 'mobile'));
            }
            
            
        } catch (\Exception $e) {
            return abort(404);
        }
    }
    
    public function lessonPage($slug)
    {
        try {
            $lesson = Lesson::whereSlug($slug)->firstOrFail();
            
            if ($lesson->status !== 'live') {
                abort(404);
            }
            
            $videos = [];
            
            // Lesson view
            LessonView::create(['lesson_id' => $lesson->id, 'user_id' => Auth::user() ? Auth::user()->id : null]);
            
            if ($lesson->type === 'pre_recorded') {
                $bookable = true;
            } else if ($lesson->type === 'single') {
                $bookableClasses = $lesson->classes()->where('bookable', 1)->get();
                $lastClass = $lesson->classes->last();
                $classEndAt = Carbon::parse($lastClass->date . ' ' . $lastClass->start_time);
                $bookable = $lesson->status == 'live' && $bookableClasses->isNotEmpty() && $classEndAt->isFuture() ? 1 : 0;
            } else {
                $firstClass = $lesson->classes->first();
                $classStartAt = Carbon::parse($firstClass->date . ' ' . $firstClass->start_time);
                $bookable = $lesson->status == 'live' && $lesson->bookable && $classStartAt->isFuture() ? 1 : 0;
            }
            
            if (!$bookable) {
                return abort(404);
            }
            
            
            $liked = false;
            
            $reportedLessons = Auth::user() ? Auth::user()->reportedLessons()->pluck('lesson_id')->toArray() : [];
            
            if (Auth::user()) {
                $likedLessons = Auth::user()->likedLessons->pluck('id')->toArray();
                $liked = in_array($lesson->id, $likedLessons) ? true : false;
            }
            
            $groupClasses = $lesson->classes->filter(function ($class) {
                return Carbon::now()->lessThan(Carbon::parse($class->date . ' ' . $class->end_time));
            })->groupBy('date');
            
            $relatedLessons = Lesson::liveClass()->where('type', '!=', 'subject')->inRandomOrder(date('dmY'))
                ->where('id', '!=', $lesson->id)
                ->where('category_id', $lesson->category_id)
                ->whereHas('user', function ($query) {
                    $query->where('is_online', 1)
                        ->where('account_live', 1);
                })->get();
            
            if (!$relatedLessons->count()) {
                $relatedLessons = Lesson::liveClass()->inRandomOrder(date('dmY'))
                    ->where('id', '!=', $lesson->id)
                    ->whereHas('areas', function ($query) use ($lesson) {
                        $query->whereIn('id', $lesson->areas->pluck('id')->toArray());
                    })
                    ->whereHas('user', function ($query) {
                        $query->where('is_online', 1)
                            ->where('account_live', 1);
                    })->get();
            }
            
            $relatedLessons = ClassHubHelper::lessonPaginate($relatedLessons, 4);
            
            $mobile = !(new Agent())->isDesktop();
            
            return view('frontend.pages.lesson', compact('lesson', 'groupClasses', 'bookable',
                'liked', 'relatedLessons', 'reportedLessons', 'mobile'));
            
        } catch (\Exception $e) {
            return abort(404);
        }
    }
    
    public function preRecordedLessonPage($slug)
    {
        try {
            
            if (!Auth::user()) {
                return abort(404);
            }
            
            $user = Auth::user();
            $lesson = Lesson::whereSlug($slug)->firstOrFail();
            $bookings = $user->bookings->pluck('lesson_id')->toArray();
            
            if ($lesson->status !== 'live') {
                abort(404);
            }
            
            if (!in_array($lesson->id, $bookings) && $user->id !== $lesson->user_id) {
                return abort(404);
            }
            
            $liked = false;
            
            if (Auth::user()) {
                $likedLessons = Auth::user()->likedLessons->pluck('id')->toArray();
                $liked = in_array($lesson->id, $likedLessons) ? true : false;
            }
            
            $mobile = !(new Agent())->isDesktop();
            
            return view('frontend.pages.pre-recorded-lesson', compact('lesson', 'mobile', 'liked'));
            
        } catch (\Exception $e) {
            return abort(404);
        }
    }
    
    public function blog(Request $request)
    {
        $posts = Post::whereDate('published_at', '<=', Carbon::now()->format('Y-m-d'))
            ->paginate(6, ['*'], 'page', $request->page ? $request->page : 1);
        
        return view('frontend.pages.blog.index', compact('posts'));
    }
    
    public function blogPost($slug)
    {
        try {
            $post = Post::whereSlug($slug)->first();
            
            return view('frontend.pages.blog.post-single', compact('post'));
        } catch (\Exception $e) {
            return abort(404);
        }
    }
    
    public function blogArchive(Request $request, $date)
    {
        $posts = Post::whereYear('published_at', '=', Carbon::parse($date)->format('Y'))
            ->whereMonth('published_at', '=', Carbon::parse($date)->format('m'))
            ->paginate(6, ['*'], 'page', $request->page ? $request->page : 1);
        
        return view('frontend.pages.blog.posts-archive', compact('posts'));
    }
    
    public function blogCategory(Request $request, $slug)
    {
        try {
            $category = Category::whereSlug($slug)->first();
            
            $posts = Post::whereDate('published_at', '<=', Carbon::now()->format('Y-m-d'))
                ->where('category_id', $category->id)
                ->paginate(6, ['*'], 'page', $request->page ? $request->page : 1);
            
            return view('frontend.pages.blog.posts-category', compact('posts'));
        } catch (\Exception $e) {
            return collect([]);
        }
    }
    
    public function about()
    {
        return view('frontend.pages.about');
    }
    
    public function classtech()
    {
        return view('frontend.pages.class-tech');
    }
    
    public function classtechtwo()
    {
        return view('frontend.pages.class-tech-v2');
    }
    
    public function business()
    {
        return view('frontend.pages.class-tech-v2');
    }
    
    public function onlineTuition()
    {
        return view('frontend.pages.online-tuition');
    }
    
    public function terms()
    {
        return view('frontend.pages.terms');
    }
    
    public function privacy()
    {
        return view('frontend.pages.privacy');
    }
    
    public function tipsTricks()
    {
        return view('frontend.pages.tips-tricks');
    }
    
    public function howItWorks()
    {
        $testimonials = Testimonial::inRandomOrder()->take(3)->get();
        
        return view('frontend.pages.how-it-works', compact('testimonials'));
    }
    
    public function tutorLanding()
    {
        return view('frontend.pages.tutor-landing');
    }
    
    public function trust()
    {
        return view('frontend.pages.trust');
    }
    
    public function tutorRequest()
    {
        return view('frontend.pages.tutor-request');
    }
    
    public function help()
    {
        try {
            $parentFaqs = FAQ::parent()->get()->groupBy('category_id');
            $educatorFaqs = FAQ::educator()->get()->groupBy('category_id');
            
            $parentCategories = FAQCategory::where('type', 'parent')->get();
            
            $educatorCategories = FAQCategory::where('type', 'teacher')->get();
            
            return view('frontend.pages.help.index', compact('parentFaqs', 'educatorFaqs',
                'parentCategories', 'educatorCategories'));
        } catch (\Exception $e) {
            return abort(404);
        }
    }
    
    public function helpSingle($id, $slug)
    {
        try {
            $faq = FAQ::findOrFail($id);
            $relatedFaqs = FAQ::where('category_id', $faq->category->id)
                ->where('type', $faq->type)
                ->where('id', '!=', $faq->id)->get();
            
            return view('frontend.pages.help.help-single', compact('faq', 'relatedFaqs'));
        } catch (\Exception $e) {
            return abort(404);
        }
        
    }
    
    public function requestTutor(Request $request)
    {
        try {
            $areaId = $request->get('area_id');
            $categoryId = $request->get('category_id');
            $selectedSubjects = [];
            return view('frontend.pages.tutor-request',
                compact('categoryId', 'selectedSubjects', 'areaId'));
        } catch (\Exception $e) {
            return abort(404);
        }
    }
    
    public function processTutorRequest(Request $request)
    {
        if (!Auth::user()) {
            return response()->json([
                'status' => false,
                'signup_required' => true,
            ]);
        }
        
        try {
            $validator = ClassHubHelper::validateData($request->all(), [
                'category' => 'required',
                'area' => 'required',
            ]);
            
            if (is_array($validator)) {
                return response()->json($validator);
            }
            
            // Check for personal info
            if ($request->message) {
                
                $personalInfo = false;
                
                foreach (Message::FILTER_PATTERNS as $pattern) {
                    $result = preg_match('/' . $pattern . '/im', $request->message);
                    
                    if ($result) $personalInfo = true;
                }
                
                if ($personalInfo) {
                    return response()->json([
                        'status' => false,
                        'personal_info' => true,
                        'time' => Carbon::now()->diffForHumans(),
                        'messages' => ['Classhub does not allow personal details to be shared on its platform']
                    ]);
                }
            }
            //Start: Grace Period
            $category = Category::find($request->category);
            $parentCategoryIds = Category::getParentCategoryIds($category->parent_id);
            $tutors = User::inRandomOrder(Carbon::now()->format('d-m-Y'))
                ->where('id', '!=', Auth::user()->id)
                ->whereHas('categories', function ($query) use ($request, $parentCategoryIds) {
                    $query->where('category_id', $request->category);
                    foreach ($parentCategoryIds as $parentId) {
                        $query->orwhere('category_id', $parentId);
                    }
                })
                ->wherehas('areas', function ($query) use ($request) {
                    if ($request->location !== 'Online') {
                        if ($request->area == 1) {
                            $query->whereIn('area_id', [1, 2, 3, 4]);
                        } else {
                            $query->where('area_id', $request->area);
                        }
                    }
                })
                ->where('is_online', 1)
                ->where('account_live', 1)
                ->get();
            //End: Grace Period

            // Start: Grace Period Passed
            // $tutors = User::inRandomOrder(Carbon::now()->format('d-m-Y'))
            //     ->where('id', '!=', Auth::user()->id)
            //     ->whereHas('categories', function ($query) use ($request) {
            //         $query->where('category_id', $request->category);
            //     })
            //     ->wherehas('areas', function ($query) use ($request) {
            //         if ($request->location !== 'Online') {
            //             if ($request->area == 1) {
            //                 $query->whereIn('area_id', [1, 2, 3, 4]);
            //             } else {
            //                 $query->where('area_id', $request->area);
            //             }
            //         }
            //     })
            //     ->where('is_online', 1)
            //     ->where('account_live', 1)
            //     ->get();
            // End: Grace Period Passed
            $request->merge([
                'parent_id' => Auth::user()->id,
                'subject_id' => $request->category,
                'group_id' => Str::uuid()->toString(),
            ]);
            
            if ($tutors->count()) {
                $messageController = new MessageController();
                
                $categoryName = ClassHubHelper::getSubjectDisplayName(Category::find($request->category), Category::all());
                $areaName = Area::find($request->area)->address;
                
                foreach ($tutors as $tutor) {
                    
                    $request->merge([
                        'educator_id' => $tutor->id,
                        'detail' => serialize([
                            'location' => $areaName,
                            'preference' => $request->location
                        ])
                    ]);
                    
                    JobBoard::create($request->all());
                    
                    /*$messageRequest = new Request();
                    $messageRequest->setMethod('POST');

                    $messageRequest->request->replace([
                        '_token' => csrf_token(),
                        'recipient_id' => $tutor->id,
                        'type' => 'request_tutor',
                        'text' => $request->message ? $request->message : '-',
                        'read' => true,
                        'request_subject_id' => $request->category,
                        'request_tutor_detail' => serialize([
                            'location' => $areaName,
                            'preference' => $request->location
                        ])
                    ]);
                    $response = json_decode($messageController->store($messageRequest, false)->getContent());*/
                }
                
                $tutorIds = implode(',', $tutors->pluck('id')->toArray());
                
                return response()->json([
                    'status' => true,
                    'url' => route('recommended.tutors', '?category_id=' . $request->category
                        . '&area_id=' . $request->area . '&tutors=' . base64_encode($tutorIds) . '#recommended-tutors')
                ]);
            }
            
            return response()->json([
                'status' => false,
                'messages' => ['Sorry, No tutor match your criteria']
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [$e->getMessage()]
            ]);
        }
    }
    
    public function recommendedTutors(Request $request)
    {
        try {
            $tutorIds = explode(',', base64_decode($request->tutors));
            
            $tutors = User::inRandomOrder(date('d-m-Y'))->whereIn('id', $tutorIds)
                ->paginate(8)->appends('tutors', $request->tutors);
            
            $categoryId = $request->category_id;
            $areaId = $request->area_id;
            
            return view('frontend.pages.recommended-tutors', compact('tutors', 'areaId', 'categoryId'));
            
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    
    public function search(Request $request)
    {
        try {
            $tutorName = $request->get('tutor_name');
            $areaId = $request->get('area_id');
            $categoryId = $request->get('category_id');
            $filter = array(
                'price_sort' => $request->get('price_sort'), 
                'price_from' => $request->get('price_from'), 
                'price_to' => $request->get('price_to'), 
                'tutor_level' => $request->get('tutor_level'), 
                'from' => $request->get('from'), 
                'to' => $request->get('to'), 
            );
            $selectedSubjects = [];
            $searchableCategoryIds = [];
            $subjectTutors = collect([]);
            $subjectName = '';
            $desktop = (new Agent())->isDesktop();
            $isUpmostCategory = false;
            $showJuniorAndLeavingCert = false;
            
            $tutorOnly = !$categoryId && $areaId == 1 ? true : false;
            
            if ($tutorOnly) {
                $tutorResults = User::with('educator')
                    ->inRandomOrder(Carbon::now()->format('d-m-Y'))
                    ->whereHas('educator')
                    ->where('is_online', 1)
                    ->where('account_live', 1)
                    //->where('bank_account', 1)
                    ->where('name', 'like', '%' . $tutorName . '%')
                    ->paginate(4);
                
                $tutorResults->appends(['tutor_name' => $tutorName, 'area_id' => 1])->links();
                
                // Search appearance for Tutor
                foreach ($tutorResults as $tutor) {
                    EducatorSearch::create(['educator_id' => $tutor->id]);
                    
                    // Intercom Data
                    $data = [
                        'user_id' => $tutor->id,
                        'email' => $tutor->email,
                        'name' => $tutor->name,
                        'custom_attributes' => [
                            'Impressions no' => $tutor->searchAppearances()->count(),
                        ]
                    ];
                    
                    $intercomJob = new IntercomJob($tutor, $data);
                    
                    $this->dispatch($intercomJob);
                }
                
                $lessons = collect();
                
                return view('frontend.pages.search.index', compact('tutorName', 'areaId', 'selectedSubjects',
                    'tutorOnly', 'tutorResults', 'lessons', 'subjectTutors', 'desktop'));
            }
            
            
            if ($categoryId) {
                $category = Category::find($categoryId);
                if ($category->name == 'Others') {
                    $searchableCategoryIds = $category->subCategories->pluck('id')->toArray();
                    $selectedSubjects = [$categoryId];
                    $subjectName = 'Others - ' . $category->name;
                } else {
                    $searchableCategoryIds = [$categoryId];
                    $selectedSubjects = [$categoryId, $category->parent_id];
                    $subjectName = Category::getDisplayName($category->id);
                }
                
                //Start: Grace Period
                $parentCategoryIds = Category::getParentCategoryIds($category->parent_id);

                $subjectTutors = User::where('is_online', 1)
                    ->where('account_live', 1)
                    ->whereHas('categories', function ($query) use ($categoryId, $parentCategoryIds) {
                        $query->where('category_id', $categoryId);
                        foreach ($parentCategoryIds as $parentId) {
                            $query->orwhere('category_id', $parentId);
                        }
                    })
                    ->join('educators', 'educators.user_id', '=', 'users.id')
                    ->leftJoin('top_performers', function ($join) use ($categoryId) {
                        $join->on('users.id', '=', 'top_performers.educator_id');
                        $join->where('top_performers.category_id', $categoryId);
                    })
                    ->selectRaw('users.*, top_performers.category_id');
                //End: Grace Period

                // Start: Grace Period Passed
                // $subjectTutors = User::where('is_online', 1)
                //     ->where('account_live', 1)
                //     ->whereHas('categories', function ($query) use ($categoryId) {
                //         $query->where('category_id', $categoryId);
                //     })
                //     ->join('educators', 'educators.user_id', '=', 'users.id')
                //     ->leftJoin('top_performers', function ($join) use ($categoryId) {
                //         $join->on('users.id', '=', 'top_performers.educator_id');
                //         $join->where('top_performers.category_id', $categoryId);
                //     })
                //     ->selectRaw('users.*, top_performers.category_id');
                // End: Grace Period Passed
                
                if (isset($filter['price_sort']) && ($filter['price_sort'] == 'asc' || $filter['price_sort'] == 'desc')) {
                    $subjectTutors = $subjectTutors->orderBy('base_price', $filter['price_sort']);
                }

                if (isset($filter['price_from']) && isset($filter['price_to'])) {
                    $subjectTutors = $subjectTutors->where('base_price', '>=', $filter['price_from'])
                        ->where('base_price', '<=', $filter['price_to']);
                }

                if (isset($filter['from']) && isset($filter['to'])) {
                    $subjectTutors = ClassHubHelper::filterTutorsByAvailability($subjectTutors, $filter['from'], $filter['to']);
                }

                if (isset($filter['tutor_level'])) {
                    if ($filter['tutor_level'] == 'trusted') {
                        $subjectTutors = $subjectTutors->where('trusted', 1);
                    } else if ($filter['tutor_level'] == 'top') {
                        $subjectTutors = $subjectTutors->whereNotNull('top_performers.category_id');
                    }
                }

                $subjectTutors = $subjectTutors->orderby('top_performers.category_id', 'desc')->orderby('trusted', 'desc');

                if ($areaId) {
                    $subjectTutors = $subjectTutors->whereHas('areas', function ($query) use ($areaId) {
                        if ($areaId == 1) {
                            $query->whereIn('area_id', [1, 2, 3, 4]);
                        } else {
                            $query->where('area_id', $areaId);
                        }
                    });
                }
                
                $subjectTutors = $subjectTutors->paginate(9);               
                
                $subjectTutors->appends([
                    'tutor_name' => $tutorName, 
                    'category_id' => $categoryId,
                    'area_id' => $areaId,
                    'price_sort' => $filter['price_sort'], 
                    'price_from' => $filter['price_from'], 
                    'price_to' => $filter['price_to'], 
                    'tutor_level' => $filter['tutor_level'], 
                    'from' => $filter['from'], 
                    'to' => $filter['to']
                ])->links();
                
                if (!$category->parent_id) {
                    $isUpmostCategory = true;
                    $subCategoryIds = explode(',', $category->getSubCategoryIds());
                    $unitedCategoryNames = '';
                    foreach ($subCategoryIds as $subCategoryId) {
                        $subCategory = Category::find($subCategoryId);
                        $unitedCategoryNames = $unitedCategoryNames . ',' . $subCategory->name;
                    }
                    
                    if (strpos($unitedCategoryNames, 'Junior Cert') !== false && strpos($unitedCategoryNames, 'Leaving Cert') !== false) {
                        $showJuniorAndLeavingCert = true;
                    }
                }
            }
            
            // Area only filter
            if ($areaId && !$categoryId) {
                
                $subjectTutors = User::where('is_online', 1)
                    ->where('account_live', 1)
                    ->inRandomOrder(Carbon::now()->format('d-m-Y'))
                    ->whereHas('areas', function ($query) use ($areaId) {
                        if ($areaId == 1) {
                            $query->whereIn('area_id', [1, 2, 3, 4]);
                        } else {
                            $query->where('area_id', $areaId);
                        }
                    });
                
                if ($categoryId) {
                    $category = Category::find($categoryId);
                    if ($category->name == 'Others') {
                        $searchableCategoryIds = $category->subCategories->pluck('id')->toArray();
                        $selectedSubjects = [$categoryId];
                        $subjectName = 'Others - ' . $category->name;
                    } else {
                        $searchableCategoryIds = [$categoryId];
                        $selectedSubjects = [$categoryId, $category->parent_id];
                        $subjectName = Category::getDisplayName($category->id);
                    }
                    
                    $subjectTutors = $subjectTutors->whereHas('categories', function ($query) use ($categoryId) {
                        $query->where('category_id', $categoryId);
                    });
                }
                
                $subjectTutors = $subjectTutors->paginate(4);
                
                $subjectTutors->appends(['tutor_name' => $tutorName, 'category_id' => $categoryId,
                    'area_id' => $areaId])->links();
                
            }
            
            $lessonQuery = Lesson::with(['category', 'areas'])->liveClass()
                ->where('type', '!=', 'subject')
                //->whereDate('end_date', '>=', Carbon::today()->toDateString())
                ->whereHas('user', function ($query) {
                    $query->where('is_online', 1)
                        ->where('account_live', 1);
                });
            
            if (!empty($searchableCategoryIds)) {
                $lessonQuery->whereIn('category_id', $searchableCategoryIds);
            }
            
            if ($tutorName) {
                $lessonQuery->whereHas('user', function ($query) use ($tutorName) {
                    $query->where('name', 'like', '%' . $tutorName . '%')
                        ->where('is_online', 1)
                        ->where('account_live', 1);
                });
            }
            
            if ($areaId != 1) {
                $lessonQuery->whereHas('areas', function ($query) use ($areaId) {
                    $query->where('area_id', $areaId);
                });
            }
            
            $lessonIdsQuery = clone $lessonQuery;
            
            $lessons = $lessonQuery->get();
            
            $lessons = ClassHubHelper::lessonPaginate($lessons, 8);
            
            $lessons->appends(['category_id' => $categoryId, 'area_id' => $areaId])->links();
            
            $lessonIds = $lessonIdsQuery->pluck('id')->toArray();
            $classesCount = $lessonQuery->count();
            
            $relatedLessons = Lesson::liveClass()->whereNotIn('id', $lessonIds)
                ->whereHas('user', function ($query) {
                    $query->where('is_online', 1)
                        ->where('account_live', 1);
                })
                ->where('bookable', 1)
                //->where('end_date', '>=', Carbon::now())
                ->get();
            
            $topEducators = Educator::inRandomOrder(Carbon::now()->format('d-m-Y'))
                ->whereHas('user', function ($query) {
                    $query->where('is_online', 1)
                        ->where('account_live', 1);
                })
                ->paginate(4);
            
            
            // Search appearance for Tutor
            foreach ($lessons as $lesson) {
                EducatorSearch::create(['educator_id' => $lesson->user_id]);
            }
            
            $tutorResults = collect();
            
            $relatedLessons = ClassHubHelper::lessonPaginate($relatedLessons, 4);
            
            return view('frontend.pages.search.index', compact('lessons', 'showJuniorAndLeavingCert',
                'classesCount', 'relatedLessons', 'topEducators', 'tutorName', 'areaId', 'selectedSubjects',
                'categoryId', 'filter', 'tutorOnly', 'tutorResults', 'subjectTutors', 'subjectName', 'desktop', 
                'isUpmostCategory'));
            
        } catch (\Exception $e) {
            return abort(404);
        }
    }
    
    public function getSearchableCategoryIds(Request $request)
    {
        $categoryType = request('category_type');
        $categorySlug = request('category_slug');
        $categoryId = request('category_id');
        
        $categoryQuery = Category::query();
        
        if ($categoryType) {
            $categoryQuery->whereType($categoryType);
        }
        if ($categorySlug) {
            $category = Category::whereSlug($categorySlug)->firstOrFail();
            $categoryQuery->whereParentId($category->id);
        }
        if ($categoryId) {
            $categoryQuery->whereId($categoryId);
        }
        
        return $categoryQuery->pluck('id')->toArray();
    }
    
    public function uploadDocuments($account, $person, $docs)
    {
        try {
            //$account = base64_encode('acct_1FezeJJt6l3DiHs8');
            //$person = base64_encode('acct_1FezeJJt6l3DiHs8');
            $accountId = base64_decode($account);
            $personId = base64_decode($person);
            
            return view('frontend.pages.upload-id-docs', compact('accountId', 'personId', 'docs'));
        } catch (\Exception $e) {
            abort(404);
        }
    }
    
    public function uploadAddlDocuments($account, $person, $docs)
    {
        try {
            //$account = base64_encode('acct_1FezeJJt6l3DiHs8');
            //$person = base64_encode('acct_1FezeJJt6l3DiHs8');
            $accountId = base64_decode($account);
            $personId = base64_decode($person);
            
            return view('frontend.pages.upload-id-addl-docs', compact('accountId', 'personId', 'docs'));
        } catch (\Exception $e) {
            abort(404);
        }
    }
    
    public function updateStripeMcc($account)
    {
        try {
            $accountId = base64_decode($account);
            
            return view('frontend.pages.update-mcc', compact('accountId'));
        } catch (\Exception $e) {
            abort(404);
        }
    }
    
    public function unsubscribe($email)
    {
        $email = base64_decode($email);
        
        try {
            $user = User::whereEmail($email)->firstOrFail();
            
            
            // create and update are the same
            $data = [
                'user_id' => $user->id,
                'email' => $user->email,
                'unsubscribed_from_emails' => true,
            ];
            
            $intercomjob = new IntercomJob($user, $data);
            
            $this->dispatch($intercomjob);
            
            return view('frontend.pages.unsubscribe', compact('email'));
        } catch (\Exception $e) {
            return view('frontend.pages.unsubscribe', compact('email'));
        }
    }
    
    public function videoCall(Request $request, $classId = null)
    {
        
        $loginRequired = !Auth::user() ? true : false;
        $callData = !Auth::user() ? [] : User::todayCalls();
        $callExist = false;
        $mobile = (new Agent())->isMobile();
        
        if ($loginRequired) {
            return view('frontend.pages.video-call', compact('loginRequired', 'callExist', 'callData', 'mobile'));
        } else {
            $classes = User::todayCalls();
            
            if (!$classId) {
                if (Auth::user()->educator)
                    return redirect()->route('educator.today.classes');
                else
                    return redirect()->route('parent.today.classes');
            }
            
            $callExist = in_array($classId, $classes->pluck('id')->toArray());
            
            if (!$callExist) {
                return view('frontend.pages.video-call', compact('loginRequired', 'callExist', 'callData', 'mobile'));
            }
            
            $class = $classes->where('id', $classId)->first();
            
            $lesson = Lesson::find($class->lesson_id);
            
            if (($request->call_type && $request->call_type === 'extra_device')
                && $lesson->user_id !== Auth::user()->id) {
                abort(404);
            }
            
            $callData = [
                'schedule_id' => $class->id,
                'caller_id' => Auth::user()->id,
                'lesson_id' => $class->lesson_id,
                'callee_id' => 1,
                'is_scheduler' => $lesson->user_id === Auth::user()->id,
                'lesson_name' => $lesson->name,
                'room_name' => $lesson->name . '_class_' . $class->id
            ];
            
            return view('frontend.pages.video-call', compact('loginRequired', 'callExist', 'callData', 'mobile'));
        }
    }
    
    public function freeVideoCall($id)
    {
        $loginUrl = route('home') . '/?login_modal=true&redirect_url='
            . route('page.free-video-call', $id);;
        
        try {
            $errorMessage = false;
            $videoCall = FreeVideoCall::whereId($id)->firstOrFail();
            $loginRequired = !Auth::user() ? true : false;
            $callData = null;
            $mobile = (new Agent())->isMobile();
            
            if ($loginRequired) {
                $errorMessage = 'Please login below to join video call';
                
                return view('frontend.pages.free-video-call', compact('loginRequired', 'loginUrl',
                    'errorMessage', 'callData', 'mobile', 'videoCall'));
            }
            
            $callData = json_decode(UserController::getFreeVideoCallSchedule($videoCall)->getContent());
            
            if (!$callData->status) {
                $errorMessage = $callData->error_message;
                $callData = null;
            }
            
            return view('frontend.pages.free-video-call', compact('loginRequired', 'loginUrl',
                'errorMessage', 'callData', 'mobile', 'videoCall'));
            
        } catch (\Exception $e) {
            $loginRequired = !Auth::user() ? true : false;
            $errorMessage = 'Video call schedule not found';
            $mobile = (new Agent())->isMobile();
            $callData = null;
            return view('frontend.pages.free-video-call', compact('callData', 'loginRequired', 'loginUrl',
                'errorMessage', 'mobile'));
        }
        
    }
    
    public function earningCalculator(Request $request)
    {
        $classFeeAmt = ClassHubHelper::roundCents($request->total * 100);
        
        $serviceFeeAmt = ClassHubHelper::roundCents(Setting::get('customer_fee') / 100 * $classFeeAmt);
        
        list($applicationFee) = StripeController::getBookingFees(null, $classFeeAmt, $serviceFeeAmt, 'IE');
        
        $monthlyEarning = ($classFeeAmt - $applicationFee) * 4; // Assuming 4 weeks per month
        
        return $monthlyEarning / 100;
    }
    
    
    public function test()
    {
        /*foreach (\Storage::files('public/uploads/banner') as $file) {
            dump($file);
        }*/
    }
    
    public function stripeTopup()
    {
        return view('frontend.pages.test-payment');
    }
    
    public function export()
    {
        return Excel::download(new EducatorTransaction(), 'export.xlsx');
    }
    
    
    public function updateBankAccount()
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            
            $users = User::whereNotNull('stripe_acct_id')->get();
            
            foreach ($users as $user) {
                try {
                    $account = Account::retrieve($user->stripe_acct_id);
                    
                    $externalAccounts = $account['external_accounts']['data'];
                    
                    foreach ($externalAccounts as $externalAccount) {
                        if ($externalAccount['object'] == 'bank_account') {
                            $user->update(['bank_account' => $externalAccount['id']]);
                        }
                    }
                } catch (\Exception $e) {
                    dump($user->id);
                    dump($e->getMessage());
                }
            }
        } catch (\Exception $e) {
            dump($e->getMessage());
        }
    }
    
    public function sendChEnquiry(Request $request)
    {
        $validate = ClassHubHelper::validateData(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'message' => 'required'
            ]
        );
        
        if (is_array($validate))
            return response()->json($validate);
        
        try {
            $job = new SendEmailJob('mark@classhub.ie', new ClasshubEnquiry($request->all()));
            
            $this->dispatch($job);
            
            return response()->json([
                'status' => true,
                'messages' => ['Thanks for your submission, we will be in touch shortly']
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [$e->getMessage()],
                'errors' => $e->getTrace()
            ]);
        }
    }
    
    public function logVideoException(Request $request)
    {
        try {
            \Log::info('Video call exception: ');
            \Log::info('Channel: ' . $request->channel_name);
            \Log::info('Code: ' . $request->code);
            \Log::info('Message: ' . $request->msg);
            \Log::info('UID: ' . $request->uid);
        } catch (\Exception $e) {
        }
        
    }
    
    public function logVideoError(Request $request)
    {
        try {
            \Log::info('Video call log: ' . $request->user . ' : ' . $request->message);
        } catch (\Exception $e) {
        }
        
    }
    
    public function updateMessageType()
    {
        try {
            $messages = Message::all();
            
            foreach ($messages as $message) {
                if ($message->video_call_time) {
                    $message->update(['type' => 'video_call']);
                }
                
                if ($message->booking_id) {
                    $message->update(['type' => 'refund_request']);
                }
            }
            
        } catch (\Exception $e) {
        
        }
    }
    
    public function twilioTest()
    {
        $twilioAccountSid = env('TWILIO_ACCOUNT_SID');
        $twilioApiKey = env('TWILIO_API_KEY');
        $twilioApiSecret = env('TWILIO_API_SECRET');
        
        // A unique identifier for this user
        $identity = "alice";
        
        // The specific Room we'll allow the user to access
        $roomName = 'DailyStandup';
        
        // Create access token, which we will serialize and send to the client
        $token = new AccessToken($twilioAccountSid, $twilioApiKey, $twilioApiSecret, 3600, $identity);
        
        // Create Video grant
        $videoGrant = new VideoGrant();
        $videoGrant->setRoom($roomName);
        
        // Add grant to token
        $token->addGrant($videoGrant);
        
        // render token to string
        $token = $token->toJWT();
        
        return view('frontend.pages.twilio', compact('token'));
    }
    
    public function getAllIntercomUsers(Request $request, $page)
    {
        try {
            $client = new IntercomClient(env('INTERCOM_TOKEN'));
            
            
            $result = $client->users->getUsers(['page' => $page]);
            $intercomUsers = $result->users;
            
            dump($intercomUsers);
            
            foreach ($intercomUsers as $intercomUser) {
                $user = User::where('email', $intercomUser->email)->first();
                
                dump($intercomUser->email . ' => ' . $user);
                
                if ($user && is_null($user->last_login)) {
                    dump($user->id);
                    $lastLogin = $intercomUser->last_request_at ? Carbon::parse($intercomUser->last_request_at)
                        : Carbon::parse($intercomUser->updated_at);
                    
                    try {
                        $user->update(['last_login' => $lastLogin]);
                    } catch (\Exception $e) {
                        dump($e->getMessage());
                    }
                }
            }
            
        } catch (\Exception $e) {
            dump($e->getMessage());
        }
    }
    
    public function cronTest()
    {
        try {
            UserController::freeVideoCallReminder();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    
    function lastSevenDayClasses()
    {
        $startDay = Carbon::now()->subDays(2);
        $endDay = Carbon::now()->subDays(1);
        
        $sevenDaysClasses = LessonClass::where('date', '>=', $startDay)
            ->where('date', '<=', $endDay)->get()->groupBy('lesson_id');
        
        foreach ($sevenDaysClasses as $key => $classes) {
            try {
                $lesson = Lesson::withTrashed()->find($key);
                
                dump($lesson->name);
                foreach ($classes as $class) {
                    //if(Carbon::parse($class->end_time)->diffInMinutes(Carbon::parse($class->start_time)) <= 30){
                    dump('Time : ' . Carbon::parse($class->start_time)->format('d/m/y h:i a') . ' - ' . Carbon::parse($class->end_time)->format('d/m/y h:i a'));
                    dump('------------------------------------------------------');
                    //}
                    
                }
                dump('++++++++++++++++++++++++++++++++++++++++++++++++');
                
            } catch (\Exception $exception) {
                dump($exception->getMessage());
            }
        }
    }
    
    
}
