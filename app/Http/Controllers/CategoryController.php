<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class CategoryController extends Controller
{
    public function store(CategoryRequest $request)
    {
        try {
            if ($request->subcategory_id)
                $request->merge([
                    'parent_id' => $request->subcategory_id,
                ]);
            
            if ($request->cycle_id)
                $request->merge([
                    'parent_id' => $request->cycle_id,
                ]);

            Category::create($request->all());
            
            return redirect()->route('admin.categories')
                ->with(['success' => [Lang::get('messages.store', ['name' => 'Category'])]]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput($request->all())->withErrors([$e->getMessage()]);
        }
    }
    
    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            
            if (!$request->has('banner')) {
                $request->merge([
                    'banner' => null
                ]);
            }
            
            $category->update($request->all());
            
            return redirect()->route('admin.categories')
                ->with(['success' => [Lang::get('messages.update', ['name' => 'Category'])]]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput($request->all())->withErrors([$e->getMessage()]);
        }
    }
    
    public function trash($id)
    {
        try {
            
            $category = Category::findOrFail($id);
            
            $category->delete();
            
            if(!$category->parent_id)
                $category->subCategories()->delete();
            
            return response()->json([
                'status' => true,
                'messages' => [\Lang::get('messages.delete', ['name' => 'Category'])]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [\Lang::get('messages.error')],
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function subcategories(Request $request)
    {
        try {
            
            $category = Category::findOrFail($request->category_id);
            
            return response()->json([
                'status' => true,
                'subcategories' => $category->subCategories()->count() ? 
                    $category->subCategories()->pluck('name', 'id') : false
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [\Lang::get('messages.error')],
                'errors' => $e->getMessage()
            ]);
        }
    }
    
    public static function isEducatorCategory($categoryId)
    {
        $categories = Auth::user()->categories()->pluck('id')->toArray();
        
        return in_array($categoryId, $categories);
    }
}
