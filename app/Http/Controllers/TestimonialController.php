<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestimonialRequest;
use App\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class TestimonialController extends Controller
{

    public function store(TestimonialRequest $request)
    {
        try {
            $request->merge(['order' => Testimonial::all()->count() + 1]);

            Testimonial::create($request->all());

            return redirect()->route('admin.settings', '?tab=testimonial')
                ->with(['success' => [Lang::get('messages.store', ['name' => 'Testimonial'])]]);
        } catch (\Exception $e) {
            return redirect()->route('admin.settings', '?tab=testimonial')
                ->withInput($request->all())
                ->withErrors([Lang::get('messages.error'), isset($e->errorInfo[2]) ?
                    $e->errorInfo[2] : $e->getMessage()]);
        }
    }


    public function sort(Request $request)
    {
        try {
            $order = 1;
            foreach ($request->testimonials as $id) {
                dump($id);
                $testimonial = Testimonial::findOrFail($id);
                $testimonial->update(['order' => $order]);
                $order++;
            }

            return response([
                'status' => true,
                'messages' => ['Sorted']
            ]);
        } catch (\Exception $e) {
            return response([
                'status' => false,
                'messages' => [isset($e->errorInfo[2]) ? $e->errorInfo[2] : $e->getMessage()]
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $testimonial = Testimonial::findOrFail($id);
            $testimonial->delete();
            return response([
                'status' => true,
                'messages' => [Lang::get('messages.delete', ['name' => 'Testimonial'])]
            ]);

        } catch (\Exception $e) {
            return response([
                'status' => false,
                'messages' => [isset($e->errorInfo[2]) ? $e->errorInfo[2] : $e->getMessage()]
            ]);
        }
    }
}
