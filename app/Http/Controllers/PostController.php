<?php

namespace App\Http\Controllers;

use App\Category;
use App\Image;
use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class PostController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Post::VALIDATION_RULES);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->messages());
        }

        try {
            Post::create($request->all());

            return redirect()->route('admin.blogs')->with(['success' => ['Post added successfully.']]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput($request->all())->withErrors([$e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), Post::VALIDATION_RULES);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->messages());
        }

        try {
            $post = Post::findOrFail($id);

            $post->update($request->all());

            return redirect()->route('admin.blogs')->with(['success' => ['Post updated successfully.']]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withInput($request->all())->withErrors([$e->getMessage()]);
        }
    }

    public function trash($id)
    {
        try {
            $post = Post::findOrFail($id);

            $post->delete();

            return response()->json([
                'status' => true,
                'messages' => ['Post has been deleted.']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()]
            ]);
        }
    }

    public function duplicate($id)
    {
        try {
            $post = Post::findOrFail($id);

            $newPost = $post->replicate(['id']);

            $newPost->title = $post->title . ' copy';

            $newPost->save();

            return redirect()->back()->with(['success' => ['Post duplicated successfully']]);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }


    public function deleteImage($id)
    {
        try {
            $post = Post::findOrFail($id);

            $image = Image::findOrFail($post->featured_image);

            DB::beginTransaction();

            Storage::disk('public')->delete($image->path);

            $image->delete();

            $post->update(['featured_image' => null]);

            DB::commit();

            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.delete', ['name' => 'Featured Image'])]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()]
            ]);
        }
    }


    public function getPostsDatatable()
    {
        $posts = Post::all();

        return DataTables::of($posts)
            ->editColumn('category', function ($post) {
                return $post->category->name;
            })
            ->editColumn('published_at', function ($post) {
                return Carbon::parse($post->published_at)->format('jS F Y');
            })
            ->editColumn('actions', function ($post) {
                $actions = '<a href="' . route('page.blog.post', $post->slug) . '"  target="_blank"
                            class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon 
                            m-btn--icon-only m-btn--pill" title="View">
                            <i class="la la-eye"></i></a>
                            <a href="' . route('admin.post.edit', $post->id) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand
                            m-btn--icon m-btn--icon-only m-btn--pill " title="Edit Post">
                            <i class="la la-pencil"></i></a> 
                            <a href="' . route('admin.post.duplicate', $post->id) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand
                            m-btn--icon m-btn--icon-only m-btn--pill " title="Duplicate Post">
                            <i class="la la-copy"></i></a> 
                            <a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-brand
                            m-btn--icon m-btn--icon-only m-btn--pill delete-post" title="Delete Post"
                            data-route="' . route('admin.post.delete', $post->id) . '">
                            <i class="la la-trash"></i></a>';

                return $actions;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function recentPosts($num = 4)
    {
        try {
            return Post::whereDate('published_at', '<=', Carbon::now()->format('Y-m-d'))
                ->take($num)->get();
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    public static function archiveLists()
    {
        try {
            $archiveLists = Post::orderBy('published_at', 'desc')->get()
                ->groupBy(function ($post) {
                    return Carbon::parse($post->published_at)->format('Y-m');
                })->keys()->toArray();

            return $archiveLists;
        } catch (\Exception $e) {
            return [];
        }
    }

    public static function categoryLists()
    {
        try {
            $categories = Category::whereHas('posts')->get();
            return $categories;
        } catch (\Exception $e) {
            return collect([]);
        }
    }

}
