<?php

namespace App\Http\Controllers;

use App\FAQ;
use App\FAQCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class FAQController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            if ($request->category_id == 'new') {
                $validator = \Validator::make($request->all(), ['new_category' => 'required', 'new_category_icon' => 'required']);
                
                if ($validator->fails()) {
                    return redirect()->route('admin.settings', 'tab=faq')
                        ->withInput($request->all())
                        ->withErrors($validator->messages());
                }
                
                $path = str_replace('public/', '', $request->file('new_category_icon')
                    ->store('public/uploads/' . 'category-icons'));
                
                $category = FAQCategory::create([
                    'name' => $request->new_category,
                    'icon_path' => $path,
                    'type' => $request->type == 'educator' ? 'teacher' : 'parent'
                ]);
                
                $request->merge([
                    'category_id' => $category->id
                ]);
            }
            
            $validator = \Validator::make($request->all(), FAQ::VALIDATION_RULES);
            
            if ($validator->fails()) {
                return redirect()->route('admin.settings', 'tab=faq')
                    ->withInput($request->all())
                    ->withErrors($validator->messages());
            }
            
            FAQ::create($request->all());
            
            DB::commit();
            
            return redirect()->route('admin.settings', 'tab=faq')
                ->with(['success' => [Lang::get('messages.store', ['name' => 'FAQ'])]]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('admin.settings', 'tab=faq')
                ->withInput($request->all())
                ->withErrors([Lang::get('messages.error'), isset($e->errorInfo[2]) ?
                    $e->errorInfo[2] : $e->getMessage()]);
        }
    }
    
    public function update(Request $request, $id)
    {
        try {
            $faq = FAQ::findOrFail($id);
            
            DB::beginTransaction();
            
            if ($request->category_id == 'new') {
                $validator = \Validator::make($request->all(), ['new_category' => 'required', 'new_category_icon' => 'required']);
                
                if ($validator->fails()) {
                    return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors($validator->messages());
                }
                
                $path = str_replace('public/', '', $request->file('new_category_icon')
                    ->store('public/uploads/' . 'category-icons'));
                
                $category = FAQCategory::create([
                    'name' => $request->new_category,
                    'icon_path' => $path,
                    'type' => $request->type == 'educator' ? 'teacher' : 'parent'
                ]);
                
                $request->merge([
                    'category_id' => $category->id
                ]);
            }
            
            $validator = \Validator::make($request->all(), FAQ::VALIDATION_RULES);
            
            if ($validator->fails()) {
                return redirect()->back()
                    ->withInput($request->all())
                    ->withErrors($validator->messages());
            }
            
            $faq->update($request->all());
            
            DB::commit();
            
            return redirect()->route('admin.settings', 'tab=faq')
                ->with(['success' => [Lang::get('messages.store', ['name' => 'FAQ'])]]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors([Lang::get('messages.error'), isset($e->errorInfo[2]) ?
                    $e->errorInfo[2] : $e->getMessage()]);
        }
    }
    
    public function delete($id)
    {
        try {
            $faq = FAQ::findOrFail($id);
            $faq->delete();
            return response([
                'status' => true,
                'messages' => [Lang::get('messages.delete', ['name' => 'FAQ'])]
            ]);
            
        } catch (\Exception $e) {
            return response([
                'status' => false,
                'messages' => [isset($e->errorInfo[2]) ? $e->errorInfo[2] : $e->getMessage()]
            ]);
        }
    }
}
