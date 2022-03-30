<?php

namespace App\Http\Controllers;

use App\Booking;
use App\BookingClass;
use App\Category;
use App\Chat;
use App\Educator;
use App\Helpers\ClassHubHelper;
use App\Image;
use App\JobBoard;
use App\Lesson;
use App\Message;
use App\RefundRequest;
use App\ReportedLesson;
use App\Setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    
    public function getEditLessonModal($id)
    {
        try {
            $lesson = Lesson::with('user')->findOrFail($id);
            
            return View::make('admin.modals.edit-advert', compact('lesson'));
            
        } catch (\Exception $e) {
            return '<p class="">' . Lang::get('messages.error') . '</p>';
        }
    }
    
    public function getRefundModal($bookingId, $class_id)
    {
        try {
            $refundRequest = RefundRequest::with('booking')->where([
                ['booking_id', '=', $bookingId],
                ['lesson_class_id', '=', $class_id]
            ])->first();
            
            $booking = Booking::findOrFail($bookingId);
            $parentId = $booking->user_id;
            $tutorId = $booking->lesson->user_id;
            
            $chat = Chat::chatExist($parentId, $tutorId);
            
            return View::make('admin.modals.refund', compact('refundRequest', 'chat', 'parentId', 'tutorId'));
            
        } catch (\Exception $e) {
            return '<p class="">' . Lang::get('messages.error') . '<br>' . $e->getMessage() . '</p>';
        }
    }
    
    public function getEducatorFeesModal($id)
    {
        try {
            $educator = User::findOrFail($id)->educator;
            
            return View::make('admin.modals.educator-fees', compact('educator'));
            
        } catch (\Exception $e) {
            return '<p class="">' . Lang::get('messages.error') . '</p>';
        }
    }
    
    public function getEducatorReferencesModal($id)
    {
        try {
            $educator = User::findOrFail($id)->educator;
            
            return View::make('admin.modals.references', compact('educator'));
            
        } catch (\Exception $e) {
            dd($e->getMessage());
            return '<p class="">' . Lang::get('messages.error') . '</p>';
        }
    }
    
    public function updateLessonCategory(Request $request, $id)
    {
        try {
            $user = Lesson::findOrFail($id);
            $categories = $user->user->categories->pluck('id')->toArray();
            
            DB::beginTransaction();
            
            $user->update(['category_id' => $request->category_id]);
            
            if (!in_array($request->category_id, $categories)) {
                array_push($categories, $request->category_id);
                $user->user->categories()->sync($categories);
            }
            
            DB::commit();
            
            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.update', ['name' => 'Advert'])]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.error'), $e->getMessage()]
            ]);
        }
    }
    
    public function updateEducatorFees(Request $request, $id)
    {
        try {
            $educator = Educator::findOrFail($id);
            $educator->update($request->all());
            
            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.update', ['name' => 'Provider fees'])]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()]
            ]);
        }
    }
    
    public function approveEducatorReferences($id)
    {
        try {
            $educator = Educator::findOrFail($id);
            $educator->update(['references_approved' => 1]);
            
            return response()->json([
                'status' => true,
                'messages' => ['References approved successfully']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()]
            ]);
        }
    }
    
    public function homepageSettings(Request $request)
    {
        try {
            DB::beginTransaction();
            
            Setting::updateOrCreate(['name' => 'heading'], ['value' => $request->heading]);
            
            Setting::updateOrCreate(['name' => 'sub_heading'], ['value' => $request->sub_heading]);
            
            Setting::updateOrCreate(['name' => 'banner_images'], ['value' => $request->banner_images ?
                serialize($request->banner_images) : serialize([])]);
            
            Setting::updateOrCreate(['name' => 'banner_overlay'], ['value' => $request->banner_overlay]);
            
            DB::commit();
            
            return redirect()->route('admin.settings')
                ->with(['success' => [Lang::get('messages.update', ['name' => 'Homepage Settings '])]]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('admin.settings')
                ->withInput($request->all())
                ->withErrors([Lang::get('messages.error'), isset($e->errorInfo[2]) ?
                    $e->errorInfo[2] : $e->getTraceAsString()]);
        }
    }
    
    public function deleteBanner($id)
    {
        try {
            $banner = Image::findOrFail($id);
            
            DB::beginTransaction();
            
            Storage::disk('public')->delete($banner->path);
            
            $banner->delete();
            
            $bannerSetting = Setting::where('name', 'banner_images')->first();
            
            if ($bannerSetting) {
                $bannerImages = @unserialize($bannerSetting->value);
                
                if (is_array($bannerImages)) {
                    $bannerImages = array_filter($bannerImages, function ($id) use ($banner) {
                        return $id != $banner->id;
                    });
                    $bannerSetting->update(['value' => serialize($bannerImages)]);
                } else {
                    $bannerSetting->update(['value' => serialize([])]);
                }
                
            } else {
                $bannerSetting->update(['value' => serialize([])]);
            }
            
            DB::commit();
            
            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.delete', ['name' => 'Banner Image'])]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()]
            ]);
        }
    }
    
    public function deleteTrustedLogo($id)
    {
        try {
            $trustedLogos = @unserialize(Setting::get('trusted_logos'));
            
            $trustedLogos = array_filter($trustedLogos, function ($logo) use ($id) {
                return $logo !== $id;
            });
            
            $logo = Image::findOrFail($id);
            
            DB::beginTransaction();
            
            Storage::disk('public')->delete($logo->path);
            
            $logo->delete();
            
            Setting::updateOrCreate(['name' => 'trusted_logos'], ['value' => serialize($trustedLogos)]);
            
            DB::commit();
            
            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.delete', ['name' => 'Trusted Logo '])]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()]
            ]);
        }
    }
    
    public function toggleTrusted(Request $request)
    {
        try {
            $user = User::findOrFail($request->user_id);
            
            if ($user->trusted) {
                $user->update(['trusted' => 0]);
                $message = 'Provider removed from trusted';
            } else {
                $user->update(['trusted' => 1]);
                $message = 'Provider added to trusted';
            }
            
            return response()->json([
                'status' => true,
                'messages' => [$message]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()]
            ]);
        }
    }
    
    public function updateCategory(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            
            $category->update($request->all());
            
            return response()->json([
                'status' => true,
                'category' => Category::findOrFail($id)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [$e->getMessage()]
            ]);
        }
    }
    
    public function getEducatorsDataTable(Request $request)
    {
        if ($request->input('search.value')) {
            $users = User::with('lessons', "educator")->whereHas('educator')
                                                      ->where('name', 'LIKE', '%'.$request->input('search.value').'%')
                                                      ->orderBy('created_at', 'desc')->take(50)->get();
        } else {
            $users = User::with('lessons', "educator")->whereHas('educator')->orderBy('created_at', 'desc')->take($request->length);
        }
        
        $total = $users->count();
        
        return DataTables::of($users)
            ->editColumn('classes', function ($user) {
                return $user->lessons->where('status', 'live')->count();
            })
            ->editColumn('date_joined', function ($user) {
                return Carbon::parse($user->created_at)->format('jS F Y');
            })
            ->editColumn('actions', function ($user) {
                $referenceUpload = $user->educator->references[0] && $user->educator->references[0] &&
                !$user->educator->references_approved ? 'new-references' : '';
                $trustedTitle = $user->trusted ? 'Remove from Trusted' : 'Add to Trusted';
                $trustedIcon = $user->trusted ? 'la-toggle-on' : 'la-toggle-off';
                
                $actions = '<a href="' . route('page.educator', $user->slug) . '"  target="_blank"
                            class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon 
                            m-btn--icon-only m-btn--pill" title="View"><i class="la la-eye"></i></a>
                            <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon
                             m-btn--icon-only m-btn--pill edit-fees" title="Provider Settings" data-toggle="modal" 
                             data-target="#fees" data-route="' . route('educator.fees.modal', $user->id) . '">
                             <i class="la la-money"></i></a>
                             <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon 
                             m-btn--icon-only m-btn--pill references ' . $referenceUpload . '" title="References" data-toggle="modal"
                             data-target="#references" data-route="' . route('educator.references.modal', $user->id) . '">
                             <i class="la la-slideshare"></i></a>
                             <a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon 
                             m-btn--icon-only m-btn--pill trusted" title="' . $trustedTitle . '" data-user-id="' . $user->id . '">
                             <i class="la ' . $trustedIcon . '"></i></a>
                             <a href="#" id="deleteAccount" class="delete-account m-portlet__nav-link btn 
                             m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" 
                             data-route="' . route('delete.account', $user->id) . '"
                             title="Delete Account"><i class="la la-close"></i></a>';
                return $actions;
            })
            ->rawColumns(['actions'])
            ->setTotalRecords($total)
            ->make(true);
    }
    
    
    public function getLessonsDataTable(Request $request)
    {
        if ($request->input('search.value')) {
            $lessons = Lesson::where('slug', '!=', null)->orderBy('created_at', 'desc')->get();
        } else {
            $lessons = Lesson::where('slug', '!=', null)->orderBy('created_at', 'desc')->take($request->length);
        }
        
        $total = $lessons->count();
        
        return DataTables::of($lessons)
            ->editColumn('educator', function ($lesson) {
                return optional($lesson->user)->name;
            })
            ->editColumn('created_at', function ($lesson) {
                return Carbon::parse($lesson->created_at)->format('jS F Y');
            })
            ->editColumn('status', function ($lesson) {
                return ClassHubHelper::lessonStatusHtml($lesson->status);
            })
            ->editColumn('actions', function ($lesson) {
                $actions = '<a href="' . route('page.lesson', $lesson->slug) . '"  target="_blank"
                            class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon 
                            m-btn--icon-only m-btn--pill" title="View">
                            <i class="la la-eye"></i></a>';
                if ($result = $lesson->canPauseOrLive()) {
                    $actions .= '<a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-brand 
                            m-btn--icon m-btn--icon-only m-btn--pill update-status" 
                            data-route="' . route('lesson.update.status', $lesson->id) . '"
                             title="' . $result[0] . ' Advert">
                            <i class="la la-' . $result[1] . '"></i></a>';
                }
                
                $actions .= '<a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-brand
                            m-btn--icon m-btn--icon-only m-btn--pill edit-lesson" title="Edit Advert" 
                            data-route="' . route('lesson.modal', $lesson->id) . '"
                            data-toggle="modal" data-target="#edit-advert">
                            <i class="la la-pencil"></i></a>';
                return $actions;
            })
            ->rawColumns(['status', 'actions'])
            ->setTotalRecords($total)
            ->make(true);
    }
    
    
    public function getReportedLessonsDataTable(Request $request)
    {
        if ($request->input('search.value')) {
            $reportedLessons = ReportedLesson::orderBy('created_at', 'desc')->get();
        } else {
            $reportedLessons = ReportedLesson::orderBy('created_at', 'desc')->take($request->length);
        }
        
        $total = $reportedLessons->count();
        
        return DataTables::of($reportedLessons)
            ->editColumn('name', function ($reportedLesson) {
                return optional($reportedLesson)->lesson->name;
            })
            ->editColumn('educator', function ($reportedLesson) {
                return optional($reportedLesson)->lesson->user->name;
            })
            ->editColumn('created_at', function ($reportedLesson) {
                return Carbon::parse($reportedLesson->created_at)->format('jS F Y');
            })
            ->editColumn('actions', function ($reportedLesson) {
                $actions = '<a href="' . route('page.lesson', $reportedLesson->lesson->slug) . '"  target="_blank"
                            class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon 
                            m-btn--icon-only m-btn--pill" title="View">
                            <i class="la la-eye"></i></a>';
                if ($result = $reportedLesson->lesson->canPauseOrLive()) {
                    $actions .= '<a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-brand 
                            m-btn--icon m-btn--icon-only m-btn--pill update-status" 
                            data-route="' . route('lesson.update.status', $reportedLesson->lesson_id) . '"
                             title="' . $result[0] . ' Advert">
                            <i class="la la-' . $result[1] . '"></i></a>';
                }
                
                if ($reportedLesson->lesson->canCancel()) {
                    $actions .= '<a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-brand
                            m-btn--icon m-btn--icon-only m-btn--pill cancel-lesson" title="Close Advert" 
                            data-route="' . route('lesson.update.status', $reportedLesson->lesson_id) . '">
                            <i class="la la-close"></i></a>';
                } else {
                    $actions .= '<span class="m-badge  m-badge--danger m-badge--wide">Cancelled</span>';
                }
                
                return $actions;
            })
            ->rawColumns(['actions'])
            ->setTotalRecords($total)
            ->make(true);
    }
    
    public function getRefundsDataTable(Request $request)
    {
        if ($request->input('search.value')) {
            $refundRequests = RefundRequest::with('booking')->orderBy('created_at', 'desc')->get();
        } else {
            $refundRequests = RefundRequest::with('booking')->orderBy('created_at', 'desc')->take($request->length);
        }
        
        $total = $refundRequests->count();
        
        return DataTables::of($refundRequests)
            ->addColumn('date', function ($refundRequest) {
                return Carbon::parse($refundRequest->created_at)->format('jS F Y');
            })
            ->addColumn('requested_by', function ($refundRequest) {
                return optional($refundRequest->booking)->user->name;
            })
            ->addColumn('class', function ($refundRequest) {
                return $refundRequest->booking->lesson->name;
            })
            ->addColumn('educator', function ($refundRequest) {
                return optional($refundRequest->booking->lesson)->user->name;
            })
            ->addColumn('amount', function ($refundRequest) {
                $amount = number_format(ClassHubHelper::centToEuro($refundRequest->amount), 2);
                return $amount;
            })
            ->editColumn('actions', function ($refundRequest) {
                
                if ($refundRequest->status == 'pending' && $refundRequest->dispute) {
                    $actions = '<a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-brand
                            m-btn--icon m-btn--icon-only m-btn--pill edit-refund" title="Edit Advert" 
                            data-route="' . route('refund.modal', [$refundRequest->booking_id,
                            $refundRequest->lesson_class_id]) . '"
                            data-toggle="modal" data-target="#refund-modal">
                            <i class="la la-pencil"></i></a>';
                } else {
                    $class = $refundRequest->status === 'granted' ? 'success' : 'danger';
                    $actions = '<span class="m-badge  m-badge--' . $class . ' m-badge--wide">'
                        . ucwords($refundRequest->status) . '</span>';
                }
                
                return $actions;
            })
            ->rawColumns(['actions'])
            ->setTotalRecords($total)
            ->make(true);
    }
    
    public function getCategoriesDataTable(Request $request)
    {
        if ($request->input('search.value')) {
            $categories = Category::all();
        } else {
            $categories = Category::whereNull('parent_id')->take($request->length);
        }
        
        $total = $categories->count();
        
        return DataTables::of($categories)
            ->editColumn('sub_categories', function ($category) {
                $subCategories = '';
                foreach ($category->subCategories as $subCategory) {
                    $preview = $subCategory->subCategories->count() ? '' : 
                        '<a href="' . route('page.search') . '?tutor_name=&category_id=' . $subCategory->id . '&area_id=1"  target="_blank"
                        class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon
                        m-btn--icon-only m-btn--pill" title="View">
                        <i class="la la-eye"></i></a>';

                    $subCategories .= '<li>' . $subCategory->name . '&nbsp;&nbsp;&nbsp;' . 
                            $preview . 
                            '<a href="' . route('admin.category.edit', $subCategory->id) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand
                            m-btn--icon m-btn--icon-only m-btn--pill edit-lesson" title="Edit Category" >
                            <i class="la la-pencil"></i></a>
                            <a href="#" id="delete-category" class="delete-category m-portlet__nav-link btn
                             m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                             data-route="' . route('admin.category.delete', $subCategory->id) . '"
                             title="Delete Category"><i class="la la-close"></i></a>
                             </li>';
                }
                return $subCategories;
            })
            ->editColumn('cycle', function ($category) {
                $cycleHTML = '';
                foreach ($category->getCycles() as $key => $groupedCycles) {
                    $cycleHTML .= '<div>' . $key . '</div>';
                    foreach ($groupedCycles as $cycle) {
                        $preview = $cycle->subCategories->count() ? '' : 
                            '<a href="' . route('page.search') . '?tutor_name=&category_id=' . $cycle->id . '&area_id=1"  target="_blank"
                            class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon
                            m-btn--icon-only m-btn--pill" title="View">
                            <i class="la la-eye"></i></a>';

                        $cycleHTML .= '<li style="margin-left: 1rem;">' . $cycle->name . '&nbsp;&nbsp;&nbsp;' . 
                                $preview . 
                                '<a href="' . route('admin.category.edit', $cycle->id) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand
                                m-btn--icon m-btn--icon-only m-btn--pill edit-lesson" title="Edit Category" >
                                <i class="la la-pencil"></i></a>
                                <a href="#" id="delete-category" class="delete-category m-portlet__nav-link btn
                                m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                data-route="' . route('admin.category.delete', $cycle->id) . '"
                                title="Delete Category"><i class="la la-close"></i></a>
                                </li>';
                    }
                }
                return $cycleHTML;
            })
            ->editColumn('level', function ($category) {
                $levelHTML = '';
                foreach ($category->getLevels() as $key => $groupedLevels) {
                    $levelHTML .= '<div>' . $key . '</div>';
                    foreach ($groupedLevels as $level) {
                        $preview = $level->subCategories->count() ? '' : 
                            '<a href="' . route('page.search') . '?tutor_name=&category_id=' . $level->id . '&area_id=1"  target="_blank"
                            class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon
                            m-btn--icon-only m-btn--pill" title="View">
                            <i class="la la-eye"></i></a>';

                        $levelHTML .= '<li style="margin-left: 1rem;">' . $level->name . '&nbsp;&nbsp;&nbsp;' . 
                                $preview . 
                                '<a href="' . route('admin.category.edit', $level->id) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand
                                m-btn--icon m-btn--icon-only m-btn--pill edit-lesson" title="Edit Category" >
                                <i class="la la-pencil"></i></a>
                                <a href="#" id="delete-category" class="delete-category m-portlet__nav-link btn
                                m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                data-route="' . route('admin.category.delete', $level->id) . '"
                                title="Delete Category"><i class="la la-close"></i></a>
                                </li>';
                    }
                }
                return $levelHTML;
            })
            ->editColumn('created_at', function ($category) {
                return Carbon::parse($category->created_at)->format('jS F Y');
            })
            ->editColumn('actions', function ($category) {
                $actions = '<a href="' . route('page.category', $category->slug) . '"  target="_blank"
                            class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon
                            m-btn--icon-only m-btn--pill" title="View">
                            <i class="la la-eye"></i></a>
                            <a href="' . route('admin.category.edit', $category->id) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand
                            m-btn--icon m-btn--icon-only m-btn--pill edit-lesson" title="Edit Category" >
                            <i class="la la-pencil"></i></a>
                            <a href="#" id="delete-category" class="delete-category m-portlet__nav-link btn
                             m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                             data-route="' . route('admin.category.delete', $category->id) . '"
                             title="Delete Category"><i class="la la-close"></i></a>';
                return $actions;
            })
            ->rawColumns(['sub_categories', 'cycle', 'level', 'actions'])
            ->setTotalRecords($total)
            ->make(true);
    }
    
    public function getClasshubEarnings()
    {
        try {
            $bookings = Booking::with('classes')->get();
            
            $bookingIds = $bookings->pluck('id')->toArray();
            
            $refundRequests = RefundRequest::whereIn('booking_id', $bookingIds)->get();
            
            $day = $week = $month = $year = $all = 0;
            
            $today = Carbon::now();
            
            $weekStart = Carbon::now()->startOfWeek();
            $weekEnd = Carbon::now()->endOfWeek();
            
            $monthStart = Carbon::now()->startOfMonth();
            $monthEnd = Carbon::now()->endOfMonth();
            
            $yearStart = Carbon::now()->startOfYear();
            $yearEnd = Carbon::now()->endOfYear();
            
            foreach ($bookings as $booking) {
                
                $bookingDate = Carbon::parse($booking->created_at);
                
                if ($booking->status == 'cancellled')
                    continue;
                
                $bookingClassCount = 0;
                
                foreach ($booking->classes as $bookingClass) {
                    
                    if ($bookingClass->status === 'cancelled')
                        continue;
                    
                    $refundRequest = $refundRequests->where('booking_id', $booking->id)
                        ->where('lesson_class_id', $bookingClass->class->id)->first();
                    
                    if ($refundRequest && ($refundRequest->has_been_payout || $refundRequest->in_progress)) {
                        continue;
                    }
                    
                    $bookingClassCount++;
                }
                
                $singleClassPrice = ClassHubHelper::roundCents(($booking->amount - $booking->service_fee)
                    / $booking->classes->count());
                
                $totalClassPrice = ClassHubHelper::roundCents($singleClassPrice * $bookingClassCount);
                
                $tutorFeeAmt = ClassHubHelper::roundCents(($booking->provider_fee_percent / 100) * $totalClassPrice);
                
                $tutorVatAmt = ClassHubHelper::roundCents($tutorFeeAmt * StripeController::VAT_PERCENT);
                
                $commission = $tutorFeeAmt + $tutorVatAmt; // - $booking->stripe_fee;
                
                if ($bookingDate->diffInDays($today) == 0)
                    $day += $commission;
                
                if ($bookingDate->lessThan($weekEnd) && $bookingDate->greaterThan($weekStart))
                    $week += $commission;
                
                if ($bookingDate->lessThan($monthEnd) && $bookingDate->greaterThan($monthStart))
                    $month += $commission;
                
                if ($bookingDate->lessThan($yearEnd) && $bookingDate->greaterThan($yearStart))
                    $year += $commission;
                
                $all += $commission;
            }
            
            $earnings = [$day / 100, $week / 100, $month / 100, $year / 100, $all / 100];
            
            return response()->json([
                'status' => true,
                'earnings' => $earnings
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    
    public function exportMessages(Request $request)
    {
        try {
            
            $user = $request->user_id ? User::withTrashed()->findOrFail($request->user_id) : null;
            $fileName = $user ? $user->name . '-' . Carbon::now()->getTimestamp() . '.csv' :
                'all-users-' . Carbon::now()->getTimestamp() . '.csv';
            
            if ($request->date_from && $request->date_to) {
                $dateFrom = Carbon::parse($request->date_from);
                $dateTo = Carbon::parse($request->date_to);
                
                if ($dateFrom->greaterThan($dateTo)) {
                    return redirect()->back()->withErrors(['Date from should be less than Date To']);
                }
            }
            
            if ($request->message_type != 'request_tutor') {
                $query = Message::orderByDesc('created_at');
                
                if ($request->user_id) {
                    $query = Message::where(function ($query) use ($request) {
                        $query->where('sender_id', $request->user_id)
                            ->orWhere('recipient_id', $request->user_id);
                    });
                }
                
                if ($request->message_type !== 'all') {
                    $query = $query->where('type', $request->message_type);
                }
                
                if ($request->date_from) {
                    $dateFrom = Carbon::parse($request->date_from);
                    $query->whereDate('created_at', '>=', $dateFrom);
                }
                
                if ($request->date_to) {
                    $dateTo = Carbon::parse($request->date_to);
                    $query->whereDate('created_at', '<=', $dateTo);
                }
                
                $allMessages = $query->get()->groupBy('chat_id');
                
                if (!$allMessages->count()) {
                    return redirect()->back()->withErrors(['No Message found']);
                }
                
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="' . $fileName . '"');
                $fp = fopen('php://output', 'wb');
                
                fputcsv($fp, ['Sender', 'Recipient', 'type', 'Message', 'Booking Response', 'Refund Request Response', 'Message Date']);
                
                if ($user) {
                    
                    foreach ($allMessages as $key => $messages) {
                        $chat = Chat::findOrFail($key);
                        
                        $otherUser = $chat->initiator_id !== $user->id ? User::withTrashed()->findOrFail($chat->initiator_id) : User::findOrFail($chat->participant_id);
                        foreach ($messages as $message) {
                            if ($message->type != 'request_tutor') {
                                fputcsv($fp, [
                                    $message->sender_id == $user->id ? $user->name : $otherUser->name,
                                    $message->recipient_id == $user->id ? $user->name : $otherUser->name,
                                    strtoupper(str_replace('_', ' ', $message->type)),
                                    $message->text == '-' ? '' : $message->text,
                                    is_null($message->booking_response) ? '' : ($message->booking_response == 1 ? 'Booking Accepted' : 'Booking Rejected'),
                                    $message->status,
                                    Carbon::parse($message->created_at)->format('d/m/Y h:i A')
                                ]);
                            }
                        }
                        
                        fputcsv($fp, ['']);
                    }
                } else {
                    foreach ($allMessages as $key => $messages) {
                        foreach ($messages as $message) {
                            if ($message->type != 'request_tutor') {
                                fputcsv($fp, [
                                    User::withTrashed()->findOrFail($message->sender_id)->name,
                                    User::withTrashed()->findOrFail($message->recipient_id)->name,
                                    strtoupper(str_replace('_', ' ', $message->type)),
                                    $message->text == '-' ? '' : $message->text,
                                    is_null($message->booking_response) ? '' : ($message->booking_response == 1 ? 'Booking Accepted' : 'Booking Rejected'),
                                    $message->status,
                                    Carbon::parse($message->created_at)->format('d/m/Y h:i A')
                                ]);
                            }
                        }
                        
                        fputcsv($fp, ['']);
                    }
                }
                
                fclose($fp);
                
            } else {
                
                $query = JobBoard::orderByDesc('created_at');
                
                if ($request->user_id) {
                    $query = JobBoard::where(function ($query) use ($request) {
                        $query->where('educator_id', $request->user_id)
                            ->orWhere('parent_id', $request->user_id);
                    });
                }
                
                if ($request->date_from) {
                    $dateFrom = Carbon::parse($request->date_from);
                    $query->whereDate('created_at', '>=', $dateFrom);
                }
                
                if ($request->date_to) {
                    $dateTo = Carbon::parse($request->date_to);
                    $query->whereDate('created_at', '<=', $dateTo);
                }
                
                $messages = $query->get();
                
                if (!$messages->count()) {
                    return redirect()->back()->withErrors(['No Message found']);
                }
                
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="' . $fileName . '"');
                $fp = fopen('php://output', 'wb');
                
                fputcsv($fp, ['Sender', 'Educator', 'Message', 'Request Details', 'Request Date']);
                foreach ($messages as $key => $message) {
                    
                    $educator = User::withTrashed()->findOrFail($message->educator_id);
                    
                    fputcsv($fp, [
                        User::withTrashed()->findOrFail($message->parent_id)->name,
                        $educator->name,
                        $message->message,
                        implode(', ', @unserialize($message->detail)),
                        Carbon::parse($message->created_at)->format('d/m/Y h:i A')
                    ]);
                    
                    fputcsv($fp, ['']);
                }
                
                fclose($fp);
                
            }
            
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()])->withInput($request->all());
        }
    }

    public function studentStats() {
        $this->userStats('student');
    }

    public function tutorStats() {
        $this->userStats('tutor');
    }

    public function userStats($userType)
    {
        try {
            if ($userType == 'tutor') {
                $users = User::where('is_admin', 0)
                    ->has('educator')->get();
            } else {
                $users = User::where('is_admin', 0)
                    ->doesntHave('educator')->get();
            }
            
            $data = [];
            
            foreach ($users as $user) {
                $userData = [];
                
                if ($userType == 'tutor') {
                    $lessonIds = $user->lessonsWithTrashed()->whereHas('bookings')->pluck('id')->toArray();

                    $bookings = Booking::whereIn('lesson_id', $lessonIds)->whereDate('created_at', '>=', Carbon::parse('2020-09-01'))
                        //->where('status', 'completed')
                        ->get()
                        ->sortBy('created_at');
                } else {
                    $bookings = $user->bookings()->whereDate('created_at', '>=', Carbon::parse('2020-09-01'))
                        //->where('status', 'completed')
                        ->get()
                        ->sortBy('created_at');
                }
                
                array_push($userData, $user->id);
                array_push($userData, $user->name);
                array_push($userData, Carbon::parse($user->created_at)->format('d/m/Y'));
                
                $bookings = $bookings->groupBy(function ($booking) {
                    return Carbon::parse($booking->created_at)->format('Y-m');
                })->all();
                
                
                if (count($bookings)) {
                    $monthlyBookingData = [];
                    $allTransactionsData = [];
                    $total = 0;
                    
                    foreach ($bookings as $month => $monthlyBookings) {
                        $totalTransactions = count($monthlyBookings);
                        $totalMonthlyAmount = 0;
                        
                        foreach ($monthlyBookings as $booking) {
                            if($booking->amount == $booking->refunded_amount){
                                continue;
                            }
                            
                            $totalMonthlyAmount += $booking->amount - $booking->refunded_amount;
                            
                            array_push(
                                $allTransactionsData,
                                Carbon::parse($booking->created_at)->format('jS F, Y') . ' : ' .
                                ' Booking Code - ' . ClassHubHelper::getbookingCode($booking) .
                                ', Amount - €' . ClassHubHelper::centToEuro($booking->amount - $booking->refunded_amount)
                            );
                            
                        }
    
                        $total += $totalMonthlyAmount;
    
                        array_push($monthlyBookingData,
                            Carbon::parse($month)->format('F Y') .
                            ' : Transactions - ' . $totalTransactions .
                            ', Amount - €' . ClassHubHelper::centToEuro($totalMonthlyAmount)
                        );
                    }
                    
                    array_push($allTransactionsData, 'Total - €' . ClassHubHelper::centToEuro($total));
                    array_push($monthlyBookingData, 'Total - €' . ClassHubHelper::centToEuro($total));
                    array_push($userData, implode(PHP_EOL, $monthlyBookingData));
                    array_push($userData, implode(PHP_EOL, $allTransactionsData));
                }
                
                array_push($data, $userData);
            }
            
            
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $userType . 's-stats.csv"');
            $fp = fopen('php://output', 'wb');
            
            fputcsv($fp, ['ID', 'Name', 'Signup Date', 'Monthly Completed Transactions', 'All Completed Transactions']);
            
            foreach ($data as $row) {
                fputcsv($fp, $row);
            }
            
            fclose($fp);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

}

