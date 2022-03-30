<?php

namespace App\Http\Controllers;

use App\Booking;
use App\JobBoard;
use App\Lesson;
use App\LessonClass;
use App\LessonRating;
use App\Message;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;

class ParentPageController extends Controller
{
    public function index()
    {
        $bookings = Auth::user()->bookings;
        
        $currentBookings = collect();
        $pastBookings = collect();
        
        foreach ($bookings as $booking) {
            if ($booking->lesson->type === 'pre_recorded') {
                $currentBookings->add($booking);
                continue;
            }
            
            $current = false;
            $past = $booking->status == 'cancelled';
            
            if ($booking->status !== 'cancelled') {
                foreach ($booking->classes as $bookingClass) {
                    $class = $bookingClass->class;
                    if (($class && $class->is_past_class) || $bookingClass->status == 'cancelled') {
                        $past = true;
                    } else {
                        $current = true;
                    }
                    
                }
            }
            
            if ($current) $currentBookings->add($booking);
            if ($past) $pastBookings->add($booking);
        }
        
        
        return view('parent.pages.bookings', compact('bookings', 'currentBookings', 'pastBookings'));
    }
    
    public function inbox(Request $request)
    {
        try {
            $chats = Auth::user()->chats();
            
            $chats = $chats->filter(function ($chat) {
                if ($chat->messages()->where('type', '!=', 'request_tutor')->get()->count()) {
                    return true;
                } else {
                    $messages = $chat->messages()->where('type', 'request_tutor')->get();
                    $tutorReply = false;
                    foreach ($messages as $message) {
                        if ($message->sender_id != Auth::user()->id) {
                            $tutorReply = true;
                        }
                    }
                    
                    return $tutorReply;
                }
            });
            
            $activeChat = null;
            
            if ($chats->count()) {
                $activeChat = $request->chat_id ? $chats->where('id', $request->chat_id)->first() : $chats->first();
                
                $chats = $chats->filter(function ($item) use ($activeChat) {
                    return $item->id != $activeChat->id;
                });
                
                MessageController::markReadMessages($activeChat);
            }
            
            $jobId = $request->jobboard_id ? $request->jobboard_id : null;
            
            $mobile = !(new Agent())->isDesktop();
            
            $messages = $activeChat ? $activeChat->messages->sortBy('created_at')->groupBy(function ($item) {
                return Carbon::parse($item->created_at)->format('d-m-Y');
            }) : collect();
            
            $bookingConfirmationMessage = 'You\'re booking has been accepted';
            
            return view('parent.pages.inbox', compact('chats', 'activeChat', 'messages',
                'mobile', 'jobId', 'bookingConfirmationMessage'));
        } catch (\Exception $e) {
            abort(404);
        }
    }
    
    public function messages($chatId)
    {
        $chats = Auth::user()->chats();
        
        $activeChat = $chats->where('id', $chatId)->first();
        
        MessageController::markReadMessages($activeChat);
        
        $messages = $activeChat->messages->sortBy('created_at')->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('d-m-Y');
        });
        
        return view('parent.pages.messages', compact('chats', 'activeChat', 'messages'));
    }
    
    public function favourites()
    {
        $educators = Auth::user()->likedEducators()->take(8)->get();
        $lessons = Auth::user()->likedLessons()->take(8)->get();
        
        return view('parent.pages.favourites.all', compact('educators', 'lessons'));
    }
    
    public function favouriteEducators()
    {
        $educators = Auth::user()->likedEducators;
        
        $mobile = !(new Agent())->isDesktop();
        
        return view('parent.pages.favourites.educators', compact('educators', 'mobile'));
    }
    
    public function favouriteLessons()
    {
        $lessons = Auth::user()->likedLessons;
        
        $mobile = !(new Agent())->isDesktop();
        
        return view('parent.pages.favourites.lessons', compact('lessons', 'mobile'));
    }
    
    public function refundRequest($bookingId)
    {
        try {
            $booking = Booking::findOrFail($bookingId);
            
            return view('parent.pages.refund-request', compact('booking'));
        } catch (\Exception $e) {
            return abort(404);
        }
    }
    
    public function accountSettings()
    {
        $cards = Auth::user()->cards;
        
        return view('parent.pages.account-settings', compact('cards'));
    }
    
    public function todayClasses()
    {
        try {
            $classes = User::todayCalls();
            return view('parent.pages.today-classes', compact('classes'));
        } catch (\Exception $e) {
        
        }
    }
    
    public function tutorRequests()
    {
        try {
            $groupTutorRequests = JobBoard::where('parent_id', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy('group_id');
            return view('parent.pages.tutor-requests', compact('groupTutorRequests'));
        } catch (\Exception $e) {
        
        }
    }
    
    public function deleteTutorRequest(Request $request)
    {
        try {
            
            if ($request->group_id) {
                JobBoard::where('parent_id', Auth::user()->id)
                    ->where('group_id', $request->group_id)
                    ->forceDelete();
            } else {
                JobBoard::find($request->id)->forceDelete();
            }
            
            return response()->json([
                'status' => true,
                'messages' => ['Tutor request deleted successfully']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => ['Something went wrong', $e->getMessage()]
            ]);
        }
    }
    
    public function deleteAllTutorRequest(Request $request)
    {
        try {
            
            JobBoard::where('parent_id', Auth::user()->id)->forceDelete();
            
            return response()->json([
                'status' => true,
                'messages' => ['Tutor requests deleted successfully']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => ['Something went wrong', $e->getMessage()]
            ]);
        }
    }
    
}
