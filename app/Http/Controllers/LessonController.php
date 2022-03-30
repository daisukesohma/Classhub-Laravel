<?php

namespace App\Http\Controllers;

use App\Area;
use App\Booking;
use App\BookingClass;
use App\Category;
use App\Helpers\ClassHubHelper;
use App\Jobs\IntercomJob;
use App\Jobs\SendEmailJob;
use App\Lesson;
use App\LessonClass;
use App\LessonView;
use App\Mail\ClassBookUpExpired;
use App\Mail\LessonLive;
use App\Mail\MoveClassEducator;
use App\Mail\MoveClassParent;
use App\Mail\ShareLesson;
use App\Mail\VideoUploadError;
use App\Message;
use App\ReportedLesson;
use App\User;
use App\Image;
use Carbon\Carbon;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
use Vimeo\Vimeo;

class LessonController extends Controller
{
    
    public function store(Request $request)
    {
        $response = $this->validateLessonRequest($request);
        
        if ($response !== true) {
            return $response;
        }
        
        try {
            
            $lessonDates = ClassHubHelper::sortLessonDates();
            
            $request->merge([
                'user_id' => Auth::user()->id,
                'type' => $request->class_type,
                'start_date' => Carbon::parse($lessonDates['start'][0])->format('Y-m-d'),
                'end_date' => Carbon::parse($lessonDates['start'][count($lessonDates['start']) - 1])->format('Y-m-d'),
                'place' => $request->place
            ]);
            
            $type2AccountLive = Auth::user()->educator->user_type != 1 ?
                !Auth::user()->lessons()->withTrashed()->count() : false;
            
            DB::beginTransaction();
            
            $lesson = Lesson::create($request->except(Lesson::EXCEPT_FIELDS));
            
            $this->addLessonClasses($lesson, $lessonDates);
            
            $lesson->areas()->sync($request->areas);
            
            if ($request->images)
                $lesson->images()->sync($request->images);
            
            Auth::user()->update(['account_live' => true]);
            
            DB::commit();
            
            $job = new SendEmailJob(Auth::user()->email, new LessonLive(Auth::user(), $lesson, $type2AccountLive));
            
            $this->dispatch($job);
            
            // Intercom Data
            $data = [
                'user_id' => Auth::user()->id,
                'email' => Auth::user()->email,
                'name' => Auth::user()->name,
                'custom_attributes' => [
                    'Lessons no' => Auth::user()->lessons()->count(),
                    'List Class' => true,
                    'Profile Complete' => true
                ]
            ];
            
            $intercomJob = new IntercomJob(Auth::user(), $data);
            
            $this->dispatch($intercomJob);
            
            return response()->json([
                'status' => true,
                'redirect_url' => route('educator.classes'),
                'messages' => [
                    Lang::get('messages.icon.ok'),
                    Lang::get('messages.store', ['name' => $request->name])
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()],
                'errors' => [$e->getMessage()],
            ]);
        }
    }
    
    public function createSubjectLesson(Request $request)
    {
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
        
        $lessonDates = ClassHubHelper::sortLessonDates();
        
        if (empty($lessonDates['start']) || empty($lessonDates['end'])) {
            return response()->json([
                'status' => false,
                'messages' => ['Please enter class dates and times'],
            ]);
        }
        
        if (!$request->category_id) {
            return response()->json([
                'status' => false,
                'messages' => ['Please select subject'],
            ]);
        }
        
        if (!$request->base_price) {
            return response()->json([
                'status' => false,
                'messages' => ['Please add your price per hour to create a booking.
                            <p><a href="' . route('educator.profile.create') . '?user_type=1&redirect_url=' . url()->previous() . '">
                            Add price per hour</a> </p>'],
            ]);
        }
        
        if (!Auth::user()->stripe_acct_id && !Auth::user()->bank_account) {
            return response()->json([
                'status' => false,
                'messages' => ['Please add payout details and person details to create a booking.
                            <p><a href="' . route('educator.setup.stripe') . '?&redirect_url=' . url()->previous() . '">
                            Add these now</a> </p>'],
            ]);
        }
        
        try {
            
            $request->merge([
                'user_id' => Auth::user()->id,
                'name' => ClassHubHelper::getSubjectDisplayName(Category::find($request->category_id), Auth::user()->categories),
                'type' => $request->class_type,
                'start_date' => Carbon::parse($lessonDates['start'][0])->format('Y-m-d'),
                'end_date' => Carbon::parse($lessonDates['start'][count($lessonDates['start']) - 1])->format('Y-m-d'),
                'travel_to_tutor' => $request->has('travel_to_tutor') ? 1 : 0,
                'travel_to_student' => $request->has('travel_to_student') ? 1 : 0,
                'price' => $request->base_price,
                'max_num_bookings' => 1
            ]);
            
            DB::beginTransaction();
            
            $lesson = Lesson::create($request->except(Lesson::EXCEPT_FIELDS));
            
            $lessonClasses = [];

            $zoom_acct_id = (new EducatorController)->getZoomAccountId();
            
            foreach ($lessonDates['start'] as $index => $date) {
                $meetingData = [
                    'topic' => $lesson->name,
                    'agenda' => $request->message,
                    'start_time' => $date,
                    'duration' => Carbon::parse($lessonDates['end'][$index])->diffInMinutes(Carbon::parse($date)),
                ];

                $meeting = (new ZoomMeetingController)->create($meetingData, $zoom_acct_id);
                
                $lessonClass = LessonClass::create([
                    'lesson_id' => $lesson->id,
                    'date' => Carbon::parse($date)->format('Y-m-d'),
                    'day' => Carbon::parse($date)->shortEnglishDayOfWeek,
                    'start_time' => Carbon::parse($date)->format('H:i:s'),
                    'end_time' => Carbon::parse($lessonDates['end'][$index])->format('H:i:s'),
                    'meeting_link' => $meeting['success'] ? $meeting['data']['join_url'] : null,
                ]);
                array_push($lessonClasses, $lessonClass->id);
            }
            
            $messageController = new MessageController();
            $messageRequest = new Request();
            $messageRequest->setMethod('POST');
            
            $messageRequest->request->replace([
                '_token' => csrf_token(),
                'recipient_id' => $request->recipient_id,
                'type' => 'booking',
                'text' => $request->message ? $request->message : '-',
                'lesson_id' => $lesson->id,
                "video_call_response" => 1, // $request->has('online_tuition') ? 1 : null,
                'class_ids' => implode(',', $lessonClasses)
            ]);
            
            $response = json_decode($messageController->store($messageRequest, true)->getContent());
            
            
            DB::commit();
            
            return response()->json([
                'status' => true,
                'lesson' => $lesson
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()],
                'errors' => [$e->getMessage()],
            ]);
        }
    }
    
    public function createPreRecordedLesson(Request $request)
    {
        $response = $this->validateLessonRequest($request);
        
        if ($response !== true) {
            return $response;
        }
        
        try {
            
            $request->merge([
                'user_id' => Auth::user()->id,
                'type' => $request->class_type,
                'start_date' => Carbon::now()->format('Y-m-d'),
                'end_date' => Carbon::now()->format('Y-m-d'),
                'max_num_bookings' => 9999999,
                'status' => $request->status
            ]);
            
            DB::beginTransaction();
            
            $lesson = Lesson::create($request->except(Lesson::EXCEPT_FIELDS));
            
            $this->addLessonVideos($request, $lesson);
            
            $lesson->areas()->sync(Area::all()->pluck('id'));
            
            if ($request->images)
                $lesson->images()->sync($request->images);
            
            Auth::user()->update(['account_live' => true]);
            
            DB::commit();
            
            
            // Intercom Data
            $data = [
                'user_id' => Auth::user()->id,
                'email' => Auth::user()->email,
                'name' => Auth::user()->name,
                'custom_attributes' => [
                    'Lessons no' => Auth::user()->lessons()->count(),
                    'List Class' => true,
                    'Profile Complete' => true
                ]
            ];
            
            $intercomJob = new IntercomJob(Auth::user(), $data);
            
            $this->dispatch($intercomJob);
            
            return response()->json([
                'status' => true,
                'redirect_url' => route('educator.pre-recorded'),
                'messages' => [
                    Lang::get('messages.icon.ok'),
                    Lang::get('messages.store.pre-recorded', ['name' => $request->name])
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()],
                'errors' => $e->getTrace(),
            ]);
        }
    }
    
    public function update(Request $request, $id)
    {
        // If lesson has booking
        $lesson = Lesson::findOrFail($id);
        
        if ($lesson->bookings()->where('status', 'completed')->get()->count())
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), Lang::get('messages.lesson.booking.exist')]
            ]);
        
        $response = $this->validateLessonRequest($request);
        
        if ($response !== true) {
            return $response;
        }
        
        try {
            
            $lessonDates = ClassHubHelper::sortLessonDates();
            
            $request->merge([
                'user_id' => Auth::user()->id,
                'type' => $request->class_type,
                'start_date' => Carbon::parse($lessonDates['start'][0])->format('Y-m-d'),
                'end_date' => Carbon::parse($lessonDates['start'][count($lessonDates['start']) - 1])->format('Y-m-d'),
                'status' => 'live',
                'travel_to_tutor' => $request->has('travel_to_tutor') ? 1 : 0,
                'travel_to_student' => $request->has('travel_to_student') ? 1 : 0,
                'bookable' => 1
            ]);
            
            DB::beginTransaction();
            
            $lesson = Lesson::findOrFail($id);
            
            $lesson->update($request->except(Lesson::EXCEPT_FIELDS));
            
            // Delete existing classes
            //DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $lesson->classes()->delete();
            
            $this->addLessonClasses($lesson, $lessonDates);
            
            $lesson->areas()->sync($request->areas);
            
            if ($request->images)
                $lesson->images()->sync($request->images);
            
            DB::commit();
            
            $job = new SendEmailJob(Auth::user()->email, new LessonLive(Auth::user(), $lesson));
            
            $this->dispatch($job);
            
            return response()->json([
                'status' => true,
                'redirect_url' => route('educator.classes'),
                'messages' => [
                    Lang::get('messages.icon.ok'),
                    Lang::get('messages.update', ['name' => $request->name])
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::info('Update Lesson error message:', $e->getMessage());
            \Log::info('Update Lesson error:', $e->getTraceAsString());
            
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error')],
                'errors' => [$e->getMessage()],
            ]);
        }
    }
    
    public function validateLessonRequest($request)
    {
        $rules = $request->class_type === 'pre_recorded' ? Lesson::VALIDATION_RULES_PRE_RECORDED : Lesson::VALIDATION_RULES;
        
        $validate = ClassHubHelper::validateData($request->all(), $rules);
        
        // Return array of errors if not validated
        if (is_array($validate))
            return response()->json($validate);
        
        // Provider select Other category
        $category = Category::findOrFail($request->category_id);
        
        if ($category->name === 'Others') {
            if (empty($request->other_category)) {
                return response()->json([
                    'status' => false,
                    'messages' => ['Please enter other category name']
                ]);
            }
            
            $otherCategory = Category::create([
                'name' => $request->other_category,
                'type' => 'Activities',
                'parent_id' => $category->id,
            ]);
            
            Auth::user()->categories()->attach($otherCategory->id);
            
            $request->merge([
                'category_id' => $otherCategory->id,
            ]);
        }
        
        if (!CategoryController::isEducatorCategory($request->category_id)) {
            
            $category = Category::findOrFail($request->category_id);
            
            $categoryName = Category::getDisplayName($category->id);
            
            return response()->json([
                'status' => false,
                'category_error' => true,
                'messages' => [Lang::get('messages.category.missing',
                    ['name' => $categoryName, 'category_id' => $category->id])]
            ]);
        }
        
        
        if ($request->class_type === 'pre_recorded') {
            return true;
            // Validation for Pre recorded class end here
        }
        
        if ($request->class_type === 'single' && $request->repeat_type && !$request->repeat_end_date) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.repeat_end.required')],
            ]);
        }
        
        if ($request->place == 'student' && empty($request->areas)) {
            return response()->json([
                'status' => false,
                'messages' => ['Please select Areas you cover'],
            ]);
        }
        
        if ($request->place == 'tutor' && (!$request->location || !$request->eircode)) {
            return response()->json([
                'status' => false,
                'messages' => ['Please enter your class EIRCODE and Address'],
            ]);
        }
        
        if (empty($request->lesson_dates[$request->class_type][0]['start'])) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.lesson.date.required')],
            ]);
        }
        
        // Sort dates
        $lessonDates = ClassHubHelper::sortLessonDates();
        
        if (empty($lessonDates['start']))
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.lesson.date.required')],
            ]);
        
        // Check if past date exist
        $pastDates = [];
        foreach ($lessonDates['start'] as $date) {
            if (Carbon::parse($date)->isPast()) {
                array_push($pastDates, Carbon::parse($date)->format('d/m/Y'));
            }
        }
        
        if (!empty($pastDates)) {
            return response()->json([
                'status' => false,
                'messages' => array_merge([Lang::get('messages.lesson.past.date')], $pastDates),
            ]);
        }
        
        return true;
    }
    
    public function addLessonClasses($lesson, $lessonDates)
    {
        $lessonClasses = [];
        
        foreach ($lessonDates['start'] as $index => $date) {
            array_push($lessonClasses, [
                'lesson_id' => $lesson->id,
                'date' => Carbon::parse($date)->format('Y-m-d'),
                'day' => Carbon::parse($date)->shortEnglishDayOfWeek,
                'start_time' => Carbon::parse($date)->format('H:i:s'),
                'end_time' => Carbon::parse($lessonDates['end'][$index])->format('H:i:s'),
            ]);
            
            // Single Class type and Repeatable
            if (request()->class_type === 'single' && request()->repeat_type) {
                $endDate = Carbon::parse(request()->repeat_end_date);
                $nextDate = Carbon::parse($date)->addWeek();
                
                while ($nextDate->lessThanOrEqualTo($endDate)) {
                    array_push($lessonClasses, [
                        'lesson_id' => $lesson->id,
                        'date' => Carbon::parse($nextDate)->format('Y-m-d'),
                        'day' => Carbon::parse($nextDate)->shortEnglishDayOfWeek,
                        'start_time' => Carbon::parse($date)->format('H:i:s'),
                        'end_time' => Carbon::parse($lessonDates['end'][$index])->format('H:i:s'),
                    ]);
                    
                    $nextDate->addWeek();
                }
            }
        }
        
        return LessonClass::insert($lessonClasses);
    }
    
    public function addLessonVideos($request, $lesson)
    {
        $lessonClasses = [];
        
        foreach ($request->videos as $key => $value) {
            array_push($lessonClasses, [
                'lesson_id' => $lesson->id,
                'date' => Carbon::now()->format('Y-m-d'),
                'day' => Carbon::now()->shortEnglishDayOfWeek,
                'start_time' => Carbon::now()->format('H:i:s'),
                'end_time' => Carbon::now()->format('H:i:s'),
                'video_name' => $value,
                'video_id' => $key,
            ]);
        }
        
        return LessonClass::insert($lessonClasses);
    }
    
    public function draft(Request $request)
    {
        if (!$request->name) {
            return;
        }
        
        try {
            // Provider select Other category
            $category = Category::findOrFail($request->category_id);
            
            if ($category->name === 'Others' && !empty($request->other_category)) {
                
                $otherCategory = Category::create([
                    'name' => $request->other_category,
                    'type' => 'Activities',
                    'parent_id' => $category->id,
                ]);
                
                Auth::user()->categories()->attach($otherCategory->id);
                
                $request->merge([
                    'category_id' => $otherCategory->id,
                ]);
            }
            
            
            if (!CategoryController::isEducatorCategory($request->category_id)) {
                $category = Category::findOrFail($request->category_id);
                
                Auth::user()->categories()->attach($category->id);
                
                if ($category->parent_id) {
                    Auth::user()->categories()->attach($category->parent_id);
                }
            }
            
            // Sort dates
            $lessonDates = [];
            
            if (!empty($request->lesson_dates[$request->class_type][0]['start']))
                ClassHubHelper::sortLessonDates();
            
            $request->merge([
                'user_id' => Auth::user()->id,
                'type' => $request->class_type,
                'start_date' => isset($lessonDates['start'][0]) ?
                    Carbon::parse($lessonDates['start'][0])->format('Y-m-d') : null,
                'end_date' => isset($lessonDates['start'][0]) ?
                    Carbon::parse($lessonDates['start'][count($lessonDates['start']) - 1])->format('Y-m-d') : null,
                'travel_to_tutor' => $request->has('travel_to_tutor') ? 1 : 0,
                'travel_to_student' => $request->has('travel_to_student') ? 1 : 0,
                'status' => 'draft'
            ]);
            
            $lesson = Lesson::create($request->except(Lesson::EXCEPT_FIELDS));
            
            if ($request->areas)
                $lesson->areas()->sync($request->areas);
            
            if (!empty($lessonDates))
                $this->addLessonClasses($lesson, $lessonDates);
            
            if ($request->images)
                $lesson->images()->sync($request->images);
            
        } catch (\Exception $e) {
            \Log::info('Draft Error : ' . $e->getMessage());
        }
    }
    
    
    public function preview(Request $request)
    {
        $validate = ClassHubHelper::validateData($request->all(), Lesson::VALIDATION_RULES);
        
        // Return array of errors if not validated
        if (is_array($validate))
            return '<div class="preview-error">' . implode('<br>', $validate['messages']) . '</div>';
        
        if ($request->class_type === 'single' && $request->repeat_type && !$request->repeat_end_date)
            return '<div class="preview-error">' . Lang::get('messages.repeat_end.required') . '</div>';
        
        if ($request->travel_to_tutor && (!$request->location || !$request->eircode)) {
            return '<div class="preview-error">Please enter your class EIRCODE and Address</div>';
            
        }
        
        // Sort dates
        $lessonDates = ClassHubHelper::sortLessonDates();
        
        if (empty($lessonDates['start']))
            return '<div class="preview-error">' . Lang::get('messages.lesson.date.required') . '</div>';
        
        try {
            
            $request->merge([
                'user_id' => Auth::user()->id,
                'type' => $request->class_type,
                'start_date' => Carbon::parse($lessonDates['start'][0])->format('Y-m-d'),
                'end_date' => $request->repeat_type ? Carbon::parse($request->repeat_end_date)->format('Y-m-d') :
                    Carbon::parse($lessonDates['start'][count($lessonDates['start']) - 1])->format('Y-m-d'),
            ]);
            
            $lesson = new Lesson($request->except(Lesson::EXCEPT_FIELDS));
            
            $lessonClasses = $this->getPreviewLessonClasses($lessonDates);
            
            $groupClasses = $lessonClasses->groupBy('date');
            
            $areas = $request->areas ? Area::whereIn('id', $request->areas)->get() : collect();
            
            $images = Image::whereIn('id', $request->images)->get();
            
            return View::make('educator.includes.preview-class',
                compact('lesson', 'lessonClasses', 'lessonDates', 'areas', 'images', 'groupClasses'))->render();
            
        } catch (\Exception $e) {
            return '<div class="preview-error">' . Lang::get('messages.error') . '<br>' . $e->getMessage() . '</div>';
        }
    }
    
    
    public function getPreviewLessonClasses($lessonDates)
    {
        $lessonClasses = collect();
        
        foreach ($lessonDates['start'] as $index => $date) {
            $lessonClasses->add(new LessonClass([
                'lesson_id' => 1,
                'date' => Carbon::parse($date)->format('Y-m-d'),
                'day' => Carbon::parse($date)->shortEnglishDayOfWeek,
                'start_time' => Carbon::parse($date)->format('H:i:s'),
                'end_time' => Carbon::parse($lessonDates['end'][$index])->format('H:i:s'),
            ]));
            
            // Single Class type and Repeatable
            
            if (request()->class_type === 'single' && request()->repeat_type) {
                $endDate = Carbon::parse(request()->repeat_end_date);
                $nextDate = Carbon::parse($date)->addWeek();
                
                while ($nextDate->lessThanOrEqualTo($endDate)) {
                    $lessonClasses->add(new LessonClass([
                        'lesson_id' => 1,
                        'date' => Carbon::parse($nextDate)->format('Y-m-d'),
                        'day' => Carbon::parse($nextDate)->shortEnglishDayOfWeek,
                        'start_time' => Carbon::parse($date)->format('H:i:s'),
                        'end_time' => Carbon::parse($lessonDates['end'][$index])->format('H:i:s'),
                    ]));
                    
                    $nextDate->addWeek();
                }
            }
        }
        
        return $lessonClasses;
    }
    
    public function getGroupDateTemplate(Request $request)
    {
        try {
            return View::make('educator.includes.group-datetime',
                ['classes' => $request->classes])->render();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function getTermDateTemplate(Request $request)
    {
        try {
            return View::make('educator.includes.term-datetime',
                ['weeks' => $request->weeks, 'classes' => $request->classes])->render();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    
    public function updateStatus(Request $request, $lessonId)
    {
        try {
            $lesson = Lesson::findOrFail($lessonId);
            
            if ($lesson->status === 'cancelled') {
                return response()->json([
                    'status' => false,
                    'messages' => ['Cancelled class are not allowed to change status'],
                ]);
            }
            
            $lesson->update(['status' => $request->status]);
            
            if ($request->status == 'cancelled') {
                $bookingController = new BookingController();
                
                $bookingController->cancelClasses($lessonId);
            }
            
            return response()->json([
                'status' => true,
                'messages' => ['Advert ' . strtoupper($request->status) . ' successfully']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [\Lang::get('messages.error')],
                'errors' => $e->getMessage()
            ]);
        }
    }
    
    public function retrieve($id)
    {
        try {
            $lesson = Lesson::findOrFail($id);
            
            return response()->json([
                'status' => true,
                'data' => ['lesson' => $lesson]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error')]
            ]);
        }
    }
    
    public function moveClass(Request $request)
    {
        $result = ClassHubHelper::validateData($request->all(), [
            'booking_id' => 'required|numeric',
            'class_to_move' => 'required|numeric',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
        
        if (is_array($result))
            return response()->json($result);
        
        try {
            $class = LessonClass::findOrFail($request->class_to_move);
            
            if (Carbon::parse($class->date . ' ' . $class->start_time)->isPast()) {
                return response()->json([
                    'status' => false,
                    'messages' => ['You are not allowed to move class which is already started']
                ]);
            }
            
            $lesson = Lesson::findOrFail($class->lesson_id);
            $booking = Booking::findOrFail($request->booking_id);
            
            DB::beginTransaction();

            $meetingData = [
                'topic' => $lesson->name,
                'agenda' => $request->message,
                'start_time' => $request->start_time,
                'duration' => Carbon::parse($request->end_time)->diffInMinutes(Carbon::parse($request->start_time)),
            ];

            $zoom_acct_id = (new EducatorController)->getZoomAccountId();
            $meeting = (new ZoomMeetingController)->create($meetingData, $zoom_acct_id);

            $newClass = LessonClass::create([
                'lesson_id' => $class->lesson_id,
                'date' => Carbon::parse($request->start_time)->format('Y-m-d'),
                'day' => Carbon::parse($request->start_time)->shortEnglishDayOfWeek,
                'start_time' => Carbon::parse($request->start_time)->format('H:i:s'),
                'end_time' => Carbon::parse($request->end_time)->format('H:i:s'),
                'num_bookings' => 1,
                'bookable' => $lesson->max_num_bookings == 1 ? 0 : 1,
                'meeting_link' => $meeting['success'] ? $meeting['data']['join_url'] : null,
            ]);
            
            $bookingClass = $booking->classes()->where('lesson_class_id', $class->id)->first();
            
            $bookingClass->forceDelete();
            
            BookingClass::create([
                'booking_id' => $booking->id,
                'lesson_class_id' => $newClass->id,
                'status' => 'completed'
            ]);
            
            $parent = User::findOrFail($booking->user_id);
            $educator = User::findOrFail($lesson->user_id);
            
            DB::commit();
            
            $job1 = new SendEmailJob($parent->email, new MoveClassParent($parent, $educator, $lesson, $class, $newClass));
            $job2 = new SendEmailJob($educator->email, new MoveClassEducator($educator, $lesson, $class, $newClass));
            
            $this->dispatch($job1);
            $this->dispatch($job2);
            
            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.icon.ok'), Lang::get('messages.class.move.success')]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()]
            ]);
        }
    }
    
    public function pause($id)
    {
        try {
            $lesson = Lesson::findOrFail($id);
            
            if ($lesson->bookings()->where('status', 'completed')->get()->count())
                return response()->json([
                    'status' => false,
                    'messages' => [Lang::get('messages.error'), Lang::get('messages.lesson.booking.exist')]
                ]);
            
            DB::beginTransaction();
            
            $lesson->update(['status' => 'paused']);
            
            $classes = $lesson->classes;
            
            foreach ($classes as $class) {
                if ($class->status == 'live')
                    $class->update(['status' => 'paused']);
            }
            
            DB::commit();
            
            return response()->json([
                'status' => true,
                'id' => $id,
                'messages' => [Lang::get('messages.icon.ok'), Lang::get('messages.lesson.paused')]
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
    
    public function live($id)
    {
        try {
            $lesson = Lesson::findOrFail($id);
            
            DB::beginTransaction();
            
            $lesson->update(['status' => 'live']);
            
            $classes = $lesson->classes;
            
            foreach ($classes as $class) {
                if ($class->status == 'paused')
                    $class->update(['status' => 'live']);
            }
            
            DB::commit();
            
            return response()->json([
                'status' => true,
                'id' => $id,
                'messages' => [Lang::get('messages.icon.ok'), Lang::get('messages.lesson.live')]
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
    
    
    public function trash($id)
    {
        try {
            
            $lesson = Lesson::findOrFail($id);
            
            if ($lesson->type === 'pre_recorded') {
                return $this->deletePrerecordedClass($lesson);
            }
            
            $deleteable = $lesson->can_delete;
            
            // Check if there is Lesson classes which can't be deleted just to make sure
            if (!$lesson->can_delete) {
                $classes = $lesson->classes;
                
                foreach ($classes as $class) {
                    if (!$class->can_delete) {
                        $deleteable = false;
                        break;
                    }
                }
            }
            
            if ($deleteable) {
                $lesson->delete();
                
                return response()->json([
                    'status' => true,
                    'id' => $id,
                    'messages' => [Lang::get('messages.icon.ok'), Lang::get('messages.lesson.deleted')]
                ]);
            }
            
            return response()->json([
                'status' => false,
                'id' => $id,
                'messages' => [Lang::get('messages.lesson.delete.error')]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [\Lang::get('messages.error')],
                'errors' => $e->getMessage()
            ]);
        }
    }
    
    public function deletePrerecordedClass($lesson)
    {
        try {
            
            if ($lesson->bookings->count()) {
                return response()->json([
                    'status' => false,
                    'id' => $lesson->id,
                    'messages' => [Lang::get('messages.lesson.delete.error')]
                ]);
            }
            
            $lesson->delete();
            
            $vimeo = new Vimeo(env('VIMEO_ID'), env('VIMEO_SECRET'), env('VIMEO_TOKEN'));
            
            foreach ($lesson->classes as $class) {
                try {
                    $vimeo->request('/videos/' . $class->video_id, [], 'DELETE');
                    
                } catch (\Exception $e) {
                }
            }
            
            return response()->json([
                'status' => true,
                'id' => $lesson->id,
                'messages' => [Lang::get('messages.icon.ok'), Lang::get('messages.lesson.deleted')]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [\Lang::get('messages.error')],
                'errors' => $e->getMessage()
            ]);
        }
    }
    
    
    public function addView($lessonId)
    {
        try {
            LessonView::create([
                'lesson_id' => $lessonId,
                'user_id' => Auth::check() ? Auth::user()->id : null,
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
    
    public function report($lessonId)
    {
        try {
            ReportedLesson::create([
                'lesson_id' => $lessonId,
                'reported_by' => Auth::user()->id,
                'reason' => request()->reason
            ]);
            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.icon.ok'), Lang::get('messages.lesson.reported')]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [\Lang::get('messages.error')],
                'errors' => $e->getMessage()
            ]);
        }
    }
    
    public function like($lessionId)
    {
        try {
            Auth::user()->likedLessons()->attach($lessionId);
            
            return response()->json([
                'status' => true,
                'class' => 'fa-heart'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [\Lang::get('messages.error')],
                'errors' => $e->getMessage()
            ]);
        }
    }
    
    public function unlike($lessonId)
    {
        try {
            Auth::user()->likedLessons()->detach($lessonId);
            
            return response()->json([
                'status' => true,
                'class' => 'fa-heart-o'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [\Lang::get('messages.error')],
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
            $lesson = Lesson::findOrFail($request->lesson_id);
            
            $educator = User::findOrFail($lesson->user_id);
            
            $job = new SendEmailJob($request->share_email, new ShareLesson($lesson, $educator, $educator->email));
            
            $this->dispatch($job);
            
            return response()->json([
                'status' => true,
                'messages' => [
                    Lang::get('messages.icon.ok'),
                    Lang::get('messages.lesson.share.success', ['name' => $lesson->name])
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.lesson.share.error', ['name' => $lesson->name])],
                'errors' => $e->getMessage()
            ]);
        }
    }
    
    public function getLessonDetailsModal($id)
    {
        try {
            $lesson = Lesson::withTrashed()->findOrFail($id);
            
            $bookings = $lesson->bookings;
            
            $view = View::make('educator.modals.class-details',
                ['lesson' => $lesson, 'bookings' => $bookings])->render();
            return $view;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function getSubjectDetailsModal($id)
    {
        try {
            $mobile = !(new Agent())->isDesktop();
            
            $lessons = Lesson::with('bookings')->whereHas('bookings')->where('user_id', Auth::user()->id)
                ->where('type', 'subject')->where('category_id', $id)->get();
            
            $view = View::make('educator.modals.subject-details',
                ['lessons' => $lessons, 'mobile' => $mobile])->render();
            return $view;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function getPreRecordedDetailsModal($id)
    {
        try {
            $lesson = Lesson::withTrashed()->findOrFail($id);
            
            $bookings = $lesson->bookings;
            
            $view = View::make('educator.modals.pre-recorded-details',
                ['lesson' => $lesson, 'bookings' => $bookings])->render();
            return $view;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    
    public function getMoveClassModal(Request $request)
    {
        try {
            $booking = Booking::findOrFail($request->booking_id);
            $lesson = Lesson::withTrashed()->findOrFail($booking->lesson_id);
            $parent = User::findOrFail($request->parent_id);
            
            $mobile = !(new Agent())->isDesktop();
            
            $view = View::make('educator.modals.move-class', compact('parent', 'lesson',
                'booking', 'mobile'))->render();
            
            return $view;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function getGalleryImages()
    {
        try {
            $images = Image::where('path', 'like', '%galleries%')->paginate(6);
            return View::make('educator.includes.image-gallery', compact('images'))->render();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    public static function moveToExpired()
    {
        try {
            $lessons = Lesson::whereIn('status', ['live', 'paused'])->get();
            
            foreach ($lessons as $lesson) {
                
                if ($lesson->type === 'pre_recorded')
                    continue;
                
                $lastClass = $lesson->classes->last();
                $classEndAt = Carbon::parse($lastClass->date . ' ' . $lastClass->end_time);
                
                if ($classEndAt->isPast()) {
                    
                    $lesson->update([
                        'bookable' => 0,
                        'status' => 'expired'
                    ]);
                    
                    if ($lesson->user->educator->user_type == 1) {
                        continue;
                    }
                    
                    $job = new SendEmailJob($lesson->user->email, new ClassBookUpExpired($lesson->user, $lesson));
                    
                    dispatch($job);
                }
            }
        } catch (\Exception $e) {
        
        }
    }

    public static function deleteOldZoomMeetings()
    {
        try {
            $lessons = Lesson::whereNotNull('meeting_link')->whereIn('status', ['expired', 'cancelled'])->get();
            
            foreach ($lessons as $lesson) {
                foreach ($lesson->classes as $class) {
                    $response = (new ZoomMeetingController)->delete($class->meeting_link);

                    if ($response['success']) {
                        $class->update(['meeting_link' => null]);
                    }
                }
            }
        } catch (\Exception $e) {
        
        }
    }
    
    public static function checkVideoTranscodingStatus()
    {
        try {
            $vimeo = new Vimeo(env('VIMEO_ID'), env('VIMEO_SECRET'), env('VIMEO_TOKEN'));
            
            $preRecordedLessons = Lesson::where('type', 'pre_recorded')
                ->where('status', 'in_progress')->get();
            
            foreach ($preRecordedLessons as $lesson) {
                $totalClasses = $lesson->classes->count();
                $completeClasses = 0;
                
                
                foreach ($lesson->classes as $class) {
                    if ($class->video_status === 'error') {
                        \Log::info('Video transcode error: ' . $class->id);
                        $job = new SendEmailJob($lesson->user->email, new VideoUploadError($lesson->user, $class, $lesson->user->email));
                        dispatch($job);
                    }
                    
                    if ($class->video_status === 'complete') {
                        $completeClasses++;
                    }
                    
                    if ($class->video_status === 'in_progress') {
                        
                        try {
                            $uri = '/videos/' . $class->video_id;
                            
                            $response = $vimeo->request($uri . '?field=link');
                            $status = $response['body']['transcode']['status'];
                            $class->update(['video_status' => $status]);
                            
                            if ($status === 'complete') {
                                $completeClasses++;
                            }
                            
                        } catch (\Exception $e) {
                        }
                    }
                }
                
                if ($totalClasses === $completeClasses) {
                    // Send Lesson live email
                    try {
                        // new password on live
                        $user = User::withTrashed()->where('id', $lesson->user_id)->where('is_online', 1)->firstOrFail();
                        
                        $lesson->update(['status' => 'live']);
                        
                        $job = new SendEmailJob($user->email, new LessonLive($user, $lesson, false));
                        dispatch($job);
                    } catch (\Exception $e) {
                        \Log::error('Video class live error: ' . $e->getMessage());
                    }
                }
            }
            
        } catch (\Exception $e) {
            \Log::error('Video error: ' . $e->getMessage());
        }
    }
    
    public function getLessonVideos(Request $request)
    {
        try {
            $lesson = Lesson::whereId($request->lesson_id)->first();
            $colClass = $request->col_class;
            $videos = [];
            
            $vimeo = new Vimeo(env('VIMEO_ID'), env('VIMEO_SECRET'), env('VIMEO_TOKEN'));
            foreach ($lesson->classes as $class) {
                $video = $vimeo->request('/videos/' . $class->video_id);
                array_push($videos, $video);
            }
            
            return View::make('frontend.includes.lesson-videos', compact('videos', 'colClass'));
        } catch (\Exception $e) {
            return '<div class="alert alert-danger">Something went wrong. Please try again later.<br/>Error: ' . $e->getMessage() . '</div>';
        }
    }
    
    
}
