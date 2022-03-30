<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Category;
use App\FAQCategory;
use App\Post;
use App\BookingClass;
use App\FAQ;
use App\Helpers\ClassHubHelper;
use App\Lesson;
use App\RefundRequest;
use App\ReportedLesson;
use App\Setting;
use App\Testimonial;
use App\User;
use Carbon\Carbon;
use function GuzzleHttp\Promise\all;
use Illuminate\Support\Facades\DB;

class AdminPageController extends Controller
{
    public function index()
    {
        $earnings = [0.00, 0.00, 0.00, 0.00, 0.00];
        $lessonCount = [Lesson::today(), Lesson::thisWeek(), Lesson::thisMonth()];
        $lessons = Lesson::liveClass()->orderBy('created_at', 'desc')->take(5)->get();
        $reportedLessons = ReportedLesson::with('lesson')->orderBy('created_at', 'desc')->take(5)->get();
        $refundRequestNum = RefundRequest::where('status', 'pending')->count();
        
        return view('admin.pages.index', compact('earnings', 'lessons', 'reportedLessons',
            'refundRequestNum', 'lessonCount'));
    }
    
    public function lessons()
    {
        return view('admin.pages.lessons');
    }
    
    public function reportedLessons()
    {
        return view('admin.pages.reported-lessons');
    }
    
    public function educators()
    {
        return view('admin.pages.educators');
    }
    
    public function globalFees()
    {
        return view('admin.pages.global-fees');
    }
    
    public function exportMessages()
    {
        $users = User::where('id', '!=', 1)->orderBy('name', 'asc')
            ->pluck('name', 'id')->toArray();
        
        $users = [ 0 => 'All Users'] +$users;
        
        return view('admin.pages.export-messages', compact('users'));
    }
    
    public function refunds()
    {
        return view('admin.pages.refunds');
    }
    
    public function createPost()
    {
        return view('admin.pages.blog.create');
    }
    
    public function editFAQ($id)
    {
        try {
            $faq = FAQ::findOrFail($id);
            
            if ($faq->type == 'parent') {
                $categories = FAQCategory::where('type', 'parent')->get();
            } else {
                $categories = FAQCategory::where('type', 'teacher')->get();
            }
            return view('admin.pages.setting-tabs.edit-faq', compact('faq', 'categories'));
            
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Post not found']);
        }
    }
    
    public function editPost($id)
    {
        try {
            $post = Post::findOrFail($id);
            return view('admin.pages.blog.edit', compact('post'));
            
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Post not found']);
        }
    }
    
    public function blogs()
    {
        return view('admin.pages.blog.index');
    }
    
    public function settings()
    {
        $parentFaqs = FAQ::parent()->get();
        $educatorFaqs = FAQ::educator()->get();
        
        $parentCategories = FAQCategory::where('type', 'parent')->get();
        $teacherCategories = FAQCategory::where('type', 'teacher')->get();
        
        $testimonialGrids = ClassHubHelper::arrayToGrid(Testimonial::orderBy('order',
            'asc')->get()->toArray());
        
        return view('admin.pages.settings', compact('parentFaqs', 'educatorFaqs',
            'testimonialGrids', 'parentCategories', 'teacherCategories'));
    }
    
    
    public function categoryBanner()
    {
        $categories = Category::getParentCategories();
        
        return view('admin.pages.category', compact('categories'));
    }
    
    public function categories()
    {
        return view('admin.pages.category.index');
    }
    
    public function createCategory()
    {
        return view('admin.pages.category.create');
    }
    
    public function editCategory($id)
    {
        try {
            $category = Category::findOrFail($id);
            
            return view('admin.pages.category.edit', compact('category'));
        } catch (\Exception $e) {
            return abort(404);
        }
    }
    
}
