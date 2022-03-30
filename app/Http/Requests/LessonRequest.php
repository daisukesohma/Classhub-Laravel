<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'name' => 'required',
            'type' => 'required',
            'price' => 'required|numeric',
            'lesson_dates' => 'required|array',
            'age_from' => 'required|numeric',
            'age_to' => 'required|numeric',
            'description' => 'required',
            'max_num_bookings' => 'required|numeric|min:1',
            'areas' => 'required',
        ];
    }
}
