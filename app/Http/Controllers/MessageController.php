<?php

namespace App\Http\Controllers;

use App\Category;
use App\Chat;
use App\Helpers\ClassHubHelper;
use App\Jobs\SendEmailJob;
use App\Lesson;
use App\Mail\InboxMessage;
use App\Mail\VideoCallScheduled;
use App\Mail\BookingRequestMessage;
use App\Message;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    
    public function store(Request $request, $email = true)
    {
        if (!Auth::check())
            return response()->json([
                'status' => false,
                'messages' => [\Lang::get('messages.auth.required', ['text' => 'to send Messages'])]
            ]);
        
        if (Auth::user()->id == $request->recipient_id) {
            return response()->json([
                'status' => false,
                'messages' => ['You\'re not allowed to send message to yourself']
            ]);
        }

        if ($request->type == 'file') {
            $validate = ClassHubHelper::validateData($request->all(), ['file' => 'required|mimes:doc,pdf,docx,jpeg,jpg,png|max:102400']); //|max:100
        } else {
            $validate = ClassHubHelper::validateData($request->all(), ['text' => 'required']); //|max:500
        }
        
        // Return array of errors if not validated
        if (is_array($validate))
            return response()->json($validate);
        
        if ($request->type != 'file') {
            // Check for personal info
            $personalInfo = false;
            
            foreach (Message::FILTER_PATTERNS as $pattern) {
                $result = preg_match('/' . $pattern . '/im', $request->text);
                
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
        
        try {
            /*if ($request->lesson_id)
                $chat = Chat::lessonChatExist(Auth::user()->id, $request->recipient_id, $request->lesson_id);
            else*/
            
            $chat = Chat::chatExist(Auth::user()->id, $request->recipient_id);
            
            DB::beginTransaction();
            
            if (!$chat)
                $chat = Chat::find($this->initiateChat($request)->id);

            $text = $request->text;
            $path = null;
            
            if ($request->type == 'file') {
                $file = $request->file('file');

                $text = $file->getClientOriginalName();

                $path = str_replace('public/', '', $file->store('public/uploads/chat/' . $chat->id));
            }
            
            $message = Message::create([
                'chat_id' => $chat->id,
                'sender_id' => Auth::user()->id,
                'recipient_id' => $request->recipient_id,
                'type' => $request->type ? $request->type : 'message',
                'text' => $text,
                'path' => $path,
                'read' => $request->read ? $request->read : false,
                'booking_id' => $request->booking_id ? $request->booking_id : null,
                'lesson_id' => $request->lesson_id ? $request->lesson_id : null,
                'class_ids' => $request->class_ids ? $request->class_ids : null,
                'status' => $request->status ? $request->status : null,
                'request_subject_id' => $request->request_subject_id ? $request->request_subject_id : null,
                'request_tutor_detail' => $request->request_tutor_detail ? $request->request_tutor_detail : null,
                'video_call_response' => $request->video_call_response ? $request->video_call_response : null,
                'booking_response' => $request->booking_response ? $request->booking_response : null
            ]);
            
            DB::commit();
            
            $sender = Auth::user();
            $recipient = User::find($request->recipient_id);
            $url = $recipient->educator ? route('educator.inbox', '?chat_id=' . $chat->id)
                : route('parent.inbox', '?chat_id=' . $chat->id);
            
            if ($email) {
                if ($message->type == "booking") {
                    $lesson = Lesson::findOrFail($request->lesson_id);
                    $job = new SendEmailJob($recipient->email, new BookingRequestMessage($sender, $recipient,
                        $message->text, $url, $lesson, $recipient->email));
                } else {
                    if (!$message->text || $message->text === '-') {
                        $job = null;
                    } else {
                        $job = new SendEmailJob($recipient->email, new InboxMessage($sender, $recipient,
                            $message->text, $url, $recipient->email));
                    }
                    
                }
                
                if ($job) {
                    $this->dispatch($job);
                }
            }
            
            // Update chat
            $this->updateChat($chat, $message);
            
            return response()->json([
                'status' => true,
                'chat_id' => $chat->id,
                'chat_message' => $message,
                'time' => Carbon::parse($message->created_at)->diffForHumans(),
                'messages' => [$request->type ? '' : Lang::get('messages.icon.ok'),
                    Lang::get('messages.chat.sent', ['name' => $recipient->name])]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error')],
                'errors' => $e->getTrace()
            ]);
        }
    }
    
    public function initiateChat($request)
    {
        return Chat::create([
            'lesson_id' => $request->lesson_id ? $request->lesson_id : null,
            'initiator_id' => Auth::user()->id,
            'participant_id' => $request->recipient_id,
            'last_message_text' => $request->text,
            'last_message_by' => Auth::user()->id,
            'last_message_at' => Carbon::now()
        ]);
    }
    
    public function updateChat($chat, $message)
    {
        $initiatorUnreadCount = $chat->initiator_unread_count;
        $participantUnreadCount = $chat->participant_unread_count;
        
        if (!$message->read) {
            if (Auth::user()->id == $chat->initiator_id)
                $participantUnreadCount += 1;
            else
                $initiatorUnreadCount += 1;
            
            $chat->update([
                'initiator_unread_count' => $initiatorUnreadCount,
                'participant_unread_count' => $participantUnreadCount,
                'last_message_text' => $message->text,
                'last_message_by' => Auth::user()->id,
                'last_message_at' => $message->created_at
            ]);
        }
    }
    
    public function scheduleCall(Request $request)
    {
        if (Auth::user()->id == $request->recipient_id) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), 'Schedule video call not allowed']
            ]);
        }
        
        if (!$request->time) {
            return response()->json([
                'status' => false,
                'messages' => ['Please select date and time']
            ]);
        }
        
        // Check whether video call schedule exist
        $scheduleTime = Carbon::createFromFormat('d-m-Y H:i', $request->time);
        
        $scheduleExist = false;
        $scheduleWithRecipientExist = false;
        $scheduleWithRecipient = null;
        
        $recipientVideoCalls = Message::where(function ($query) use ($request) {
            $query->where('recipient_id', $request->recipient_id)
                ->orWhere('sender_id', $request->recipient_id);
        })
            ->whereNotNull('video_call_time')
            ->where(function ($query) {
                $query->where('video_call_response', '!=', 2)
                    ->orWhereNull('video_call_response');
            })->get();
        
        /*$senderVideoCalls = Message::where(function ($query) {
            $query->where('recipient_id', Auth::user()->id)
                ->orWhere('sender_id', Auth::user()->id);
        })
            ->whereNotNull('video_call_time')
            ->where(function ($query) {
                $query->where('video_call_response', '!=', 2)
                    ->orWhereNull('video_call_response');
            })->get();*/
        
        foreach ($recipientVideoCalls as $videoCall) {
            $callTime = Carbon::parse($videoCall->video_call_time);
            if ($callTime->diffInMinutes($scheduleTime) <= 60) {
                $scheduleExist = true;
                if ($videoCall->sender_id == Auth::user()->id) {
                    $scheduleWithRecipientExist = true;
                    $scheduleWithRecipient = $videoCall;
                    continue;
                }
            }
        }
        
        /*foreach ($senderVideoCalls as $videoCall) {
            $callTime = Carbon::parse($videoCall->video_call_time);
            if ($callTime->diffInMinutes($scheduleTime) <= 60) {
                $scheduleExist = true;
                continue;
            }
        }*/
        
        if ($scheduleExist) {
            
            if ($scheduleWithRecipientExist) {
                
                $modalContent = \View::make('frontend.modals.schedule-another',
                    compact('scheduleWithRecipient'))->render();
                
                return response()->json([
                    'status' => false,
                    'messages' => [$modalContent]
                ]);
            }
            
            return response()->json([
                'status' => false,
                'messages' => ['This time is unavailable. Please choose another time']
            ]);
        }
        
        try {
            
            $chat = Chat::chatExist(Auth::user()->id, $request->recipient_id);
            
            DB::beginTransaction();
            
            if (!$chat)
                $chat = Chat::find($this->initiateChat($request)->id);
            
            $message = Message::create([
                'chat_id' => $chat->id,
                'sender_id' => Auth::user()->id,
                'recipient_id' => $request->recipient_id,
                'type' => 'video_call',
                'video_call_time' => $scheduleTime,
                'text' => $request->text,
            ]);
            
            if ($request->message_id) {
                $message = Message::findOrFail($request->message_id);
                
                $message->update([
                    'video_call_response' => $request->video_call_response ? $request->video_call_response : 0
                ]);
            }
            
            // Update chat
            $this->updateChat($chat, $message);
            
            DB::commit();
            
            $sender = Auth::user();
            $recipient = User::find($request->recipient_id);
            $url = $recipient->educator ? route('educator.inbox', $chat->id)
                : route('parent.inbox', $chat->id);
            
            $job = new SendEmailJob($recipient->email, new InboxMessage($sender, $recipient, $request->text, $url, $recipient->email));
            $this->dispatch($job);
            
            if ($request->video_call_response) {
                $job = new SendEmailJob($sender->email, new InboxMessage($recipient, $sender, $request->text, $url, $sender->email));
                $this->dispatch($job);
            }
            
            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.icon.ok'), 'Video Call Request Sent']
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()],
                'errors' => $e->getTraceAsString()
            ]);
        }
    }
    
    public function scheduleCallAccept(Request $request)
    {
        try {
            
            $message = Message::findOrFail($request->message_id);
            
            $message->update(['video_call_response' => 1, 'text' => 'Video Call Scheduled for:']);
            
            $user1 = User::findOrFail($message->sender_id);
            $user2 = User::findOrFail($message->recipient_id);
            
            $link1 = null;
            $link2 = null;
            
            if ($user1->educator) {
                $link1 = route('page.educator', $user1->slug);
            }
            
            if ($user2->educator) {
                $link2 = route('page.educator', $user2->slug);
            }
            
            // Send email to both Users
            $job1 = new SendEmailJob($user1->email, new VideoCallScheduled($user1, $user2,
                $message, $link2 ? $link2 : $link1, $user1->email));
            
            $job2 = new SendEmailJob($user2->email, new VideoCallScheduled($user2, $user1,
                $message, $link1 ? $link1 : $link2, $user2->email));
            
            dispatch($job1);
            
            dispatch($job2);
            
            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.icon.ok'), 'Video call accepted']
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()],
                'errors' => $e->getTraceAsString()
            ]);
        }
    }
    
    public function scheduleCallDismiss(Request $request)
    {
        try {
            
            $message = Message::findOrFail($request->message_id);
            
            $message->update(['video_call_response' => 4]);
            
            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.icon.ok'), 'Video call dismiss']
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()],
                'errors' => $e->getTraceAsString()
            ]);
        }
    }
    
    public static function markReadMessages($chat)
    {
        try {
            DB::beginTransaction();
            
            $readCount = 0;
            foreach ($chat->messages as $message) {
                if (!$message->read && $message->recipient_id == Auth::user()->id) {
                    $message->update(['read' => 1]);
                    $readCount++;
                }
            }
            
            if ($chat->initiator_id == Auth::user()->id) {
                $unread = ($chat->initiator_unread_count - $readCount) < 0 ? 0
                    : ($chat->initiator_unread_count - $readCount);
                $chat->update(['initiator_unread_count' => $unread]);
            }
            
            if ($chat->participant_id == Auth::user()->id) {
                $unread = ($chat->participant_unread_count - $readCount) < 0 ? 0
                    : ($chat->participant_unread_count - $readCount);
                $chat->update(['participant_unread_count' => $unread]);
            }
            
            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollBack();
        }
        
    }

    public function downloadMessage($messageId)
    {
        if (!Auth::check())
            return response()->json([
                'status' => false,
                'messages' => [\Lang::get('messages.auth.required', ['text' => 'to send Messages'])]
            ]);

        try {
            $message = Message::find($messageId);

            if ($message->type == 'file' && $message->file_deleted == 0) {
                return response()->download(
                    Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix() . $message->path, $message->text
                );

            } else {
                return response()->json([
                    'status' => false,
                    'messages' => [Lang::get('messages.error')]
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error')]
            ]);
        }
    }

    public function deleteOldChatFiles()
    {
        try {
            $messages = Message::where('type', 'file')
                ->where('file_deleted', '0')
                ->get();
            
            foreach ($messages as $message) {
                $createdAt = Carbon::parse($message->created_at);
                if (Carbon::now()->diffInDays($createdAt) > 14) {
                    $message->update(['file_deleted' => '1']);
                    Storage::disk('public')->delete($message->path);
                }
            }
        } catch (\Exception $e) {
            
        }
    }
}
