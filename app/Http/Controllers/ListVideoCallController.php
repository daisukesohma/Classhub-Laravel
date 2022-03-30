<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\LessonClass;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ListVideoCallController extends Controller
{
    public function index(Request $request)
    {
        $lessonIds = Lesson::whereHas('bookings')->pluck('id')->toArray();
        
        $classes = LessonClass::whereIn('lesson_id', $lessonIds)
            ->where('date', $request->date)->get();
        
        foreach ($classes as $class) {
            try {
                $lesson = Lesson::withTrashed()->find($class->lesson_id);
                $lessonClasses = $lesson->classes;
                $bookings = $lesson->bookings;
                $tutor = $lesson->user;
                
                $parents = [];
                
                foreach ($bookings as $booking) {
                    array_push($parents, User::find($booking->user_id));
                }
                
                dump($lesson->name);
                dump('Tutor : ' . $tutor->email);
                
                foreach ($parents as $parent) {
                    dump('Parent : ' . $parent->email);
                }
                foreach ($lessonClasses as $class) {
                    if ($class->date !== $request->date)
                        continue;
                    
                    dump('Class ID : ' . $class->id . ' - Time : ' .Carbon::parse($class->date).' '. Carbon::parse($class->start_time)->format('h:i a') . ' - ' . Carbon::parse($class->end_time)->format('h:i a'));
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
