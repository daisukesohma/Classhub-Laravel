<?php

namespace App;

use App\Helpers\ClassHubHelper;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Intercom\IntercomClient;
use App\Jobs\SendEmailJob;
use App\Mail\WelcomeUser;

/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int $is_admin
 * @property string|null $provider
 * @property int|null $provider_id
 * @property string|null $remember
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Area[] $areas
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\EducatorRating[] $ratings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SubCategory[] $subCategories
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\EducatorView[] $views
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRemember($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\User withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $remember_token
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Category[] $categories
 * @property-read \App\Educator $educator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $likedEducators
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Lesson[] $likedLessons
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @property string|null $stripe_cust_id
 * @property string|null $stripe_acct_id
 * @property string|null $stripe_secret_key
 * @property string|null $stripe_publishable_key
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Card[] $cards
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStripeAcctId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStripeCustId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStripePublishableKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStripeSecretKey($value)
 * @property string $slug
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSlug($value)
 * @property-read mixed $firstname
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Lesson[] $lessons
 * @property-read mixed $lastname
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Booking[] $bookings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PasswordReset[] $passwordResets
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\EducatorSearch[] $searchAppearances
 * @property int $bank_account
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBankAccount($value)
 * @property string|null $intercom_user_id
 * @property int $trusted
 * @property int $subscribe_intercom
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ReportedLesson[] $reportedLessons
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIntercomUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSubscribeIntercom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTrusted($value)
 */
class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use Sluggable;
    use DispatchesJobs;
    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'email', 'password', 'is_admin', 'is_online', 'provider', 'provider_id', 'stripe_cust_id',
        'stripe_acct_id', 'bank_account', 'stripe_status', 'stripe_requirements', 'remember_token', 'intercom_user_id',
        'subscribe_intercom', 'trusted', 'user_type', 'account_live', 'last_login', 'active'
    ];
    
    const VALIDATION_RULES = [
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6'
    ];
    
    //protected $with = ['educator'];
    
    //protected $appends = ['firstname', 'lastname'];
    
    protected static $ignoreChangedAttributes = ['remember_token'];
    
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
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
        parent::boot();
        
        /*static::created(function ($user) {
            self::updateIntercom($user, true);
        });

        static::updated(function ($user) {
            self::updateIntercom($user, false);
        });*/
    }
    
    public function getFirstnameAttribute()
    {
        return explode(' ', $this->name)[0];
    }
    
    public function getLastnameAttribute()
    {
        $name = explode(' ', $this->name);
        
        return isset($name[1]) ? $name[1] : '';
    }
    
    public function getLocationsAttribute()
    {
        $locations = $this->areas->where('id', '!=', 1)->pluck('address')->toArray();
        
        if (empty($locations))
            return 'N/A';
        
        return implode(' - ', $locations);
    }
    
    public function cards()
    {
        return $this->hasMany(Card::class);
    }
    
    public function educator()
    {
        return $this->hasOne(Educator::class)->withTrashed();
    }
    
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
        //->where('status', '!=', 'draft');
    }
    
    public function lessonsWithTrashed()
    {
        return $this->hasMany(Lesson::class)->withTrashed();
        //->where('status', '!=', 'draft');
    }
    
    public function bookings()
    {
        return $this->hasMany(Booking::class)->withTrashed();
    }
    
    public function educatorBookings()
    {
        return $this->hasManyThrough(Booking::class, Lesson::class);
    }
    
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'educator_categories')
            ->withTrashed();
    }
    
    public function areas()
    {
        return $this->belongsToMany(Area::class, 'educator_areas');
    }
    
    public function ratings()
    {
        return $this->hasMany(LessonRating::class, 'educator_id');
    }
    
    public function views()
    {
        return $this->hasMany(EducatorView::class);
    }

    public function topPerformerCategories()
    {
        return $this->hasMany(TopPerformer::class, 'educator_id');
    }
    
    public function likedEducators()
    {
        return $this->belongsToMany(User::class, 'liked_educators', 'educator_id')
            ->withTimestamps();
    }
    
    public function likedLessons()
    {
        return $this->belongsToMany(Lesson::class, 'liked_lessons')
            ->withTimestamps();
    }
    
    public function reportedLessons()
    {
        return $this->hasMany(ReportedLesson::class, 'reported_by');
    }
    
    public function searchAppearances()
    {
        return $this->hasMany(EducatorSearch::class, 'educator_id');
    }
    
    public function chats()
    {
        return Chat::where('initiator_id', '=', $this->id)
            ->orWhere('participant_id', '=', $this->id)->
            orderBy('last_message_at', 'desc')->get();
    }
    
    public function passwordResets()
    {
        return $this->hasMany(PasswordReset::class);
    }
    
    public function jobBoards()
    {
        return $this->hasMany(JobBoard::class, 'educator_id');
    }
    
    public function jobsBoardCount()
    {
        return $this->jobBoards()->where('applied', 0)->count();
    }
    
    public static function updateIntercom(User $user, $created = false)
    {
        $customData = [];
        
        $customData = [
            'Educator' => $user->user_type == 'educator',
            'Bookings no' => $user->educator ? $user->educatorBookings()->count() : $user->bookings()->count(),
            'Impressions no' => $user->searchAppearances()->count(),
            'Views no' => $user->views()->count(),
            'Lessons no' => $user->lessons()->count(),
            'Stripe Connected' => $user->stripe_acct_id != null
        ];
        
        if ($user->user_type == 'educator') {
            $educatorData = [
                'List Class' => $user->lessonsWithTrashed()->count() ? true : false,
                'Profile Complete' => $user->educator ? true : false
            ];
            $customData = array_merge($customData, $educatorData);
        }
        
        $client = new IntercomClient(env('INTERCOM_TOKEN'));
        
        try {
            // create and update are the same
            $response = $client->users->create([
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'signed_up_at' => Carbon::parse($user->created_at)->getTimestamp(),
                'custom_attributes' => $customData,
                'unsubscribed_from_emails' => !$user->subscribe_intercom,
            ]);
            
            if ($created && isset($response->id)) {
                $user->update(['intercom_user_id' => $response->id]);
            }
        } catch (\Exception $e) {
        
        }
    }
    
    public static function videoCallSchedule()
    {
        try {
            $lessonIds = Message::where('video_call_response', 1)
                ->where('booking_response', 1)
                ->whereNotNull('class_ids')
                ->where(function ($query) {
                    $query->where('sender_id', Auth::user()->id)
                        ->orWhere('recipient_id', Auth::user()->id);
                })
                ->pluck('lesson_id')
                ->toArray();
            
            $startTimeThreshold = Carbon::now()->addMinutes(30);
            $endTimeThreshold = Carbon::now()->subMinutes(30);
            
            $lessonClass = LessonClass::whereIn('lesson_id', $lessonIds)
                ->whereDate('date', Carbon::today())
                ->whereTime('start_time', '<=', $startTimeThreshold)
                ->whereTime('end_time', '>=', $endTimeThreshold)
                ->orderBy('start_time', 'ASC')
                ->first();
            
            if (!$lessonClass) {
                return false;
            }
            
            $schedule = Message::where('lesson_id', $lessonClass->lesson_id)
                ->where('video_call_response', 1)
                ->where('booking_response', 1)
                ->where(function ($query) {
                    $query->where('sender_id', Auth::user()->id)
                        ->orWhere('recipient_id', Auth::user()->id);
                })->first();
            
            return [
                'schedule_id' => $schedule->id,
                'caller_id' => Auth::user()->id,
                'class_id' => $lessonClass->id,
                'lesson_id' => $lessonClass->lesson_id,
                'callee_id' => $schedule->sender_id !== Auth::user()->id ? $schedule->sender_id : $schedule->recipient_id,
                'is_scheduler' => Lesson::find($lessonClass->lesson_id)->user_id == Auth::user()->id,
                'lesson_name' => $lessonClass->lesson->name,
                'room_name' => $lessonClass->lesson->name . '_class_' . $lessonClass->id,
                'meeting_link' => $lessonClass->meeting_link,
            ];
        } catch (\Exception $e) {
            return false;
        }
    }
    
    
    public static function getFreeCalls($withId)
    {
        if (Auth::user()->educator) {
            $freeCalls = FreeVideoCall::where('educator_id', Auth::user()->id)
                ->where('parent_id', $withId)->orderBy('call_time', 'asc')->get();
        } else {
            $freeCalls = FreeVideoCall::where('parent_id', Auth::user()->id)
                ->where('educator_id', $withId)->orderBy('call_time', 'asc')->get();
        }
        
        return $freeCalls;
    }
    
    public static function todayCalls()
    {
        if (Auth::user()->educator) {
            $lessonIds = Lesson::whereHas('bookings')->where('user_id', Auth::user()->id)->pluck('id')->toArray();
        } else {
            $bookings = Booking::where('user_id', Auth::user()->id)->get();
            $lessonIds = [];
            foreach ($bookings as $booking) {
                $lesson = Lesson::where('id', $booking->lesson_id)->get();
                
                if ($lesson) {
                    array_push($lessonIds, $booking->lesson_id);
                }
                
            }
        }
        
        $classes = LessonClass::whereIn('lesson_id', $lessonIds)
            ->where('date', Carbon::now()->format('Y-m-d'))->get();
        
        return $classes;
    }
    
}
