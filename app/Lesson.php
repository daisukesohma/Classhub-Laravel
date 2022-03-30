<?php

namespace App;

use App\Helpers\ClassHubHelper;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Intercom\IntercomClient;
use phpDocumentor\Reflection\Types\Self_;

/**
 * App\Lesson
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Area[] $areas
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Image[] $images
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\LessonTime[] $times
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\LessonView[] $views
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Lesson onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Lesson withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Lesson withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property int|null $sub_category
 * @property string $name
 * @property string $type
 * @property int $cost
 * @property string $start_date
 * @property string|null $end_date
 * @property int|null $location
 * @property int $age_from
 * @property int $age_to
 * @property string $description
 * @property int $bookable
 * @property int $max_no_bookings
 * @property int $no_bookings
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereAgeFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereAgeTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereBookable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereMaxNoBookings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereNoBookings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereSubCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereUserId($value)
 * @property int $category_id
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereCategoryId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\LessonTime[] $dates
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Booking[] $bookings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\LessonClass[] $classes
 * @property int $price
 * @property string|null $repeat_type
 * @property string|null $repeat_end_date
 * @property int|null $location_id
 * @property int $max_num_bookings
 * @property int $num_bookings
 * @property string $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereMaxNumBookings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereNumBookings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereRepeatEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereRepeatType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereStatus($value)
 * @property string $slug
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereSlug($value)
 * @property-read mixed $display_price
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson findSimilarSlugs($attribute, $config, $slug)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\LessonRating[] $ratings
 * @property-read \App\Category $category
 * @property-read \App\Educator|null $educator
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson thisMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson thisWeek()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson today()
 * @property-read mixed $lesson_type_price_text
 * @property int $num_weeks
 * @property-read mixed $can_delete
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lesson whereNumWeeks($value)
 */
class Lesson extends Model
{
    use SoftDeletes;
    use Sluggable;
    
    protected $fillable = [
        'user_id', 'category_id', 'name', 'type', 'num_weeks', 'price', 'start_date',
        'end_date', 'location', 'eircode', 'age_from', 'age_to', 'description', 'place', 'travel_to_tutor',
        'travel_to_student', 'repeat_type', 'max_num_bookings', 'num_bookings', 'bookable', 'status', 'video_password'
    ];
    
    protected $with = ['user', 'classes', 'images'];
    
    //protected $appends = ['display_price', 'lesson_type_price_text', 'can_delete'];
    
    const REPEAT_OPTION = [
        0 => 'No Repeat',
        'weekly' => 'Every Week'
    ];
    
    const AGE_FROM = [2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10,
        11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 16 => 16, 17 => 17, 18 => 18];
    
    const EXCEPT_FIELDS = ['num_classes', 'num_week_classes', 'images',
        'repeat_end_date', 'areas', 'lesson_dates'];
    
    const VALIDATION_RULES = [
        'category_id' => 'required|numeric',
        'name' => 'required',
        'class_type' => 'required',
        'price' => 'required|numeric',
        'description' => 'required', //|max:500
        'max_num_bookings' => 'required|numeric',
        'images' => 'required',
        /*'areas' => 'required',*/
        'lesson_dates' => 'required|array',
        'age_from' => 'required',
        'age_to' => 'required',
    ];
    
    const VALIDATION_RULES_PRE_RECORDED = [
        'category_id' => 'required|numeric',
        'name' => 'required',
        'price' => 'required|numeric',
        'description' => 'required',
        'images' => 'required',
        'age_from' => 'required',
        'age_to' => 'required',
        'videos' => 'required|array|min:1'
    ];
    
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['name'],
                'separator' => '-'
            ]
        ];
    }
    
    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        
        static::created(function ($lesson) {
            $customData = [
                'list_class' => Auth::user()->lessonsWithTrashed()->count() ? true : false,
            ];
            
            $client = new IntercomClient(env('INTERCOM_TOKEN'));
            
            // $client->users->create([
            //     'custom_attributes' => $customData,
            // ]);
        });
    }
    
    public function setPriceAttribute($price)
    {
        $this->attributes['price'] = $price * 100;
    }
    
    public function getDisplayPriceAttribute()
    {
        return '€' . round($this->price / 100, 2);
    }
    
    public function getLessonTypePriceTextAttribute()
    {
        return ClassHubHelper::lessonTypePriceText($this);
    }
    
    public function scopeLiveClass($query)
    {
        return $query->where('status', 'live')->where('bookable', 1);
    }
    
    public function scopeToday()
    {
        return Lesson::whereDate('created_at', Carbon::today()->toDateString())->get()->count();
    }
    
    public function scopeThisWeek()
    {
        return Lesson::whereBetween('created_at',
            [Carbon::now()->startOfWeek()->toDateString(),
                Carbon::now()->endOfWeek()->toDateString()]
        )->get()->count();
    }
    
    public function scopeThisMonth()
    {
        return Lesson::whereBetween('created_at',
            [Carbon::now()->startOfMonth()->toDateString(),
                Carbon::now()->endOfMonth()->toDateString()]
        )->get()->count();
    }
    
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
    
    public function educator()
    {
        return $this->belongsTo(Educator::class, 'user_id')->withTrashed();
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }
    
    public function areas()
    {
        return $this->belongsToMany(Area::class, 'lesson_areas');
    }
    
    public function classes()
    {
        return $this->hasMany(LessonClass::class)->orderBy('date', 'asc');
        //->withTrashed();
    }
    
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    
    public function images()
    {
        return $this->belongsToMany(Image::class, 'lesson_images');
    }
    
    public function views()
    {
        return $this->hasMany(LessonView::class);
    }
    
    public function ratings()
    {
        return LessonRating::where('lesson_id', $this->id)->get();
    }
    
    public function canPauseOrLive()
    {
        if (in_array($this->status, ['paused', 'live'])) {
            $class = $this->status == 'paused' ? 'play' : 'pause';
            $title = $this->status == 'paused' ? 'Unpause' : 'Pause';
            return [$title, $class];
        }
        
        return false;
    }
    
    public function canCancel()
    {
        if (!in_array($this->status, ['cancelled', 'expired']))
            return true;
        
        return false;
    }
    
    public function getCanDeleteAttribute()
    {
        if (!$this->bookings->count() || in_array($this->status, ['draft', 'cancelled', 'expired']))
            return true;
        
        return false;
    }
    
    
    public static function getViewCount($month)
    {
        $lessonIds = Auth::user()->lessons->pluck('id')->toArray();
        
        $lessonViews = LessonView::whereIn('lesson_id', $lessonIds)->get();
        
        $monthViews = $lessonViews->filter(function ($item) use ($month) {
            return Carbon::parse($item->created_at)->format('Y-m') == $month;
        })->all();
        
        return count($monthViews);
    }
    
    
}
