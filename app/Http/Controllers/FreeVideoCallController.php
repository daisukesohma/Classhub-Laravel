<?php

namespace App\Http\Controllers;

use App\FreeVideoCall;
use App\Helpers\ClassHubHelper;
use App\Jobs\SendEmailJob;
use App\Mail\FreeCallScheduled;
use App\Mail\VideoCallScheduled;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use PhpParser\Node\Stmt\Return_;

class FreeVideoCallController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validate = ClassHubHelper::validateData($request->all(), FreeVideoCall::VALIDATION_RULES);
            
            if (is_array($validate)){
                    return response()->json([
                        'status' => false,
                        'messages' => ['Please select a date and time for your free call']
                    ]);
            }
                //return response()->json($validate);
            
            $freeCalls = User::getFreeCalls($request->parent_id);
            
            if ($freeCalls->where('complete', 1)->count() >= 2) {
                return response()->json([
                    'status' => false,
                    'messages' => [Lang::get('messages.free-call.error')],
                ]);
            }
            
            $request->merge([
                'call_time' => Carbon::createFromFormat('d-m-Y H:i', $request->call_time),
                'complete' => 0,
                'reminder_sent' => 0
            ]);

            $meetingData = [
                'topic' => 'Free Video Call',
                'start_time' => $request->call_time,
                'duration' => 20,
            ];
            
            if ($freeCalls->where('complete', 0)->count() >= 2) {
                $videoCall = $freeCalls->first();
                
                if ($videoCall->meeting_link) {
                    (new ZoomMeetingController)->update($videoCall->meeting_link, $meetingData);
                } else {
                    $zoom_acct_id = (new EducatorController)->getZoomAccountId();
                    $meeting = (new ZoomMeetingController)->create($meetingData, $zoom_acct_id);

                    $request->merge([
                        'meeting_link' => $meeting['success'] ? $meeting['data']['join_url'] : null,
                    ]);
                }
                
                $videoCall->update($request->all());
            } else {
                $zoom_acct_id = (new EducatorController)->getZoomAccountId();
                $meeting = (new ZoomMeetingController)->create($meetingData, $zoom_acct_id);

                $request->merge([
                    'meeting_link' => $meeting['success'] ? $meeting['data']['join_url'] : null,
                ]);

                $videoCall = FreeVideoCall::create($request->all());
            }
            
            try {
                $parent = User::whereId($request->parent_id)->first();
                
                $job1 = new SendEmailJob(Auth::user()->email, new FreeCallScheduled(Auth::user(), $parent, $videoCall, Auth::user()->email));
                
                $job2 = new SendEmailJob($parent->email, new FreeCallScheduled($parent, Auth::user(), $videoCall, $parent->email));
                
                dispatch($job1);
                
                dispatch($job2);
                
            } catch (\Exception $e) {
            }
            
            
            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.free-call.success')],
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error')],
                'errors' => [$e->getMessage()],
                'trace' => [$e->getTrace()],
            ]);
        }
    }
    
    public function completed(Request $request)
    {
        try {
            $freeCall = FreeVideoCall::whereId($request->id)->firstOrFail();
            
            $freeCall->update(['complete' => 1]);
        } catch (\Exception $e) {
        
        }
    }

    public function zoomParticipantJoinedNotification(Request $request) {
        try {
            if ($request->event == 'meeting.participant_joined') {
                $payload = $request->payload;

                if ($payload['object']['topic'] == 'Free Video Call') {
                    $meetingId = $payload['object']['id'];

                    $response = (new ZoomMeetingController)->listMeetingParticipants($meetingId);
    
                    if ($response['success']) {
                        $participants = count($response['data']['participants']);
    
                        if ($participants >= 2) {
                            $freeCall = FreeVideoCall::where('meeting_link', 'like', '%'.$meetingId.'%')->firstOrFail();
                
                            $freeCall->update(['meeting_start' => Carbon::now()]);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
        
        }
    }

    public static function zoomMeetingCompleted()
    {
        try {
            $startTimeThreshold = Carbon::now()->subMinutes(20);

            $freeCalls = FreeVideoCall::whereNotNull('meeting_link')->whereTime('meeting_start', '<=', $startTimeThreshold)->get();
            
            foreach ($freeCalls as $freeCall) {
                $response = (new ZoomMeetingController)->updateMeetingStatus($freeCall->meeting_link, 'end');

                if ($response['success']) {
                    $delete = (new ZoomMeetingController)->delete($freeCall->meeting_link);

                    if ($delete['success']) {
                        $freeCall->update(['meeting_link' => null]);
                    }
                }
                $freeCall->update(['complete' => 1]);
            }
        } catch (\Exception $e) {
        
        }
    }
    
    public static function deleteOldZoomMeetings()
    {
        try {
            $freeCalls = FreeVideoCall::whereNotNull('meeting_link')->whereDate('created_at', '<=', Carbon::yesterday())->get();
            
            foreach ($freeCalls as $freeCall) {
                $response = (new ZoomMeetingController)->delete($freeCall->meeting_link);

                if ($response['success']) {
                    $freeCall->update([
                        'complete' => 1,
                        'meeting_link' => null
                    ]);
                }
            }
        } catch (\Exception $e) {
        
        }
    }
}
