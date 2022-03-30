<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\LessonRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class LessonRatingController extends Controller
{

    public function store(Request $request, $lessonId)
    {
        $validator = Validator::make($request->all(), ['rating' => 'required', 'comment' => 'required']);

        if ($validator->fails())
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.rating.error')]
            ]);

        try {
            $lesson = Lesson::findOrFail($lessonId);

            LessonRating::create([
                'educator_id' => $lesson->user_id,
                'parent_id' => Auth::user()->id,
                'lesson_id' => $lesson->id,
                'score' => $request->rating,
                'comment' => $request->comment
            ]);

            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.icon.ok'), Lang::get('messages.rating.success')]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.error'), $e->getMessage()]
            ]);
        }
    }

    public function retrieve($lessonId)
    {
        try {
            $lesson = Lesson::findOrFail($lessonId);
            $rating = LessonRating::where('lesson_id', $lessonId)
                ->where('parent_id', Auth::user()->id)->first();

            $view = View::make('parent.includes.rating', ['rating' => $rating, 'lesson' => $lesson]);

            return $view->render();
        } catch (\Exception $e) {
            $view = View::make('parent.includes.rating', ['rating' => false, 'lesson' => $lesson]);

            return $view->render();
        }
    }

}
