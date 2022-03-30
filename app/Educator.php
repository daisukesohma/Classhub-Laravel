<?php

namespace App;

use App\Helpers\ClassHubHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * App\Educator
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Educator onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Educator withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Educator withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $type
 * @property string|null $qualifications
 * @property int $student
 * @property string|null $college
 * @property string|null $year
 * @property string|null $subject
 * @property int $photo
 * @property string|null $billing_address
 * @property string|null $account_name
 * @property string|null $stripe_secret_key
 * @property string|null $stripe_publishable_key
 * @property string|null $vat
 * @property string|null $extra_info
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereBillingAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereCollege($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereExtraInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereQualifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereStripeAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereStripePublishableKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereStripeSecretKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereStudent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereYear($value)
 * @property int $is_student
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereIsStudent($value)
 * @property int $user_id
 * @property-read mixed $qualification
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereUserId($value)
 * @property string|null $dob
 * @property string $bio
 * @property string|null $billing_acct_name
 * @property string|null $iban
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereBillingAcctName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereIban($value)
 * @property-read \App\Image $avatar
 * @property float|null $provider_fee
 * @property float|null $customer_fee
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereCustomerFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereProviderFee($value)
 * @property string $teaching_types
 * @property string $government_id
 * @property string $references
 * @property int $references_approved
 * @property-read mixed $top_performer
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereGovernmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereReferences($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereReferencesApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educator whereTeachingTypes($value)
 */
class Educator extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id', 'type', 'user_type', 'dob', 'qualifications',
        'provider_fee', 'customer_fee', 'photo', 'intro_video', 'bio', 'teaching_types',
        'references', 'references_approved', 'base_price', 'online_class', 'availability',
        'setup_class_reminder', 'zoom_acct_id', 'updated_at'
    ];
    
    protected $primaryKey = 'user_id';
    
    const VALIDATION_RULES_1 = [
        'teaching_types' => 'required|array',
        'qualifications' => 'required|array',
        'availability' => 'required|array',
        'categories' => 'required|array',
        'base_price' => 'required|numeric',
        'areas' => 'required',
        'photo' => 'required',
        'bio' => 'required', //|max:500
        'code_ethics' => 'required'
    ];
    
    const VALIDATION_PREVIEW_RULES_1 = [
        'teaching_types' => 'required|array',
        'qualifications' => 'required|array',
        'availability' => 'required|array',
        'categories' => 'required|array',
        'base_price' => 'required|numeric',
        'areas' => 'required',
        'photo' => 'required',
        'bio' => 'required|max:500',
        'code_ethics' => 'required'
    ];
    
    const VALIDATION_RULES_2 = [
        'profile_day' => 'required|date_format:d',
        'profile_month' => 'required|date_format:m',
        'profile_year' => 'required|date_format:Y',
        'teaching_types' => 'required|array',
        'categories' => 'required|array',
        'photo' => 'required',
        'bio' => 'required|max:500',
        'code_ethics' => 'required'
    ];
    
    const VALIDATION_PREVIEW_RULES_2 = [
        'profile_day' => 'required|date_format:d',
        'profile_month' => 'required|date_format:m',
        'profile_year' => 'required|date_format:Y',
        'teaching_types' => 'required|array',
        'categories' => 'required|array',
        'photo' => 'required',
        'bio' => 'required|max:500',
    ];
    
    const TYPES = [
        'individual' => 'Individual',
        'company' => 'Business'
    ];
    
    const CURRENCIES = [
        'EUR' => 'Euro',
        'GBP' => 'British Pound',
    ];
    
    const COUNTRIES = [
        'IE' => 'Ireland',
        'AT' => 'Austria',
        'BE' => 'Belgium',
        'EE' => 'Estonia',
        'FI' => 'Finland',
        'FR' => 'France',
        'DE' => 'Germany',
        'GR' => 'Greece',
        'IT' => 'Italy',
        'LV' => 'Latvia',
        'LT' => 'Lithuania',
        'LU' => 'Luxembourg',
        'NL' => 'Netherlands',
        'PT' => 'Portugal',
        'SK' => 'Slovakia',
        'SI' => 'Slovenia',
        'ES' => 'Spain',
        'GB' => 'United Kingdom',
    ];
    
    const EXCEPT_FIELDS = ['categories', 'areas'];
    
    /*protected function setKeysForSaveQuery(Builder $query)
    {
        return $query->where('user_id', '=', $this->user_id)
                     ->where('user_id', '=', $this->user_id);
    }*/
    
    public function setQualificationsAttribute($value)
    {
        $this->attributes['qualifications'] = serialize($value === null ? [] : $value);
    }
    
    public function getQualificationsAttribute($value)
    {
        return @unserialize($value) !== false ? unserialize($value) : [];
    }
    
    public function setAvailabilityAttribute($value)
    {
        $this->attributes['availability'] = serialize($value === null ? [] : $value);
    }
    
    public function getAvailabilityAttribute($value)
    {
        return @unserialize($value) !== false ? unserialize($value) : [];
    }
    
    public function setTeachingTypesAttribute($value)
    {
        $teachingTypes = [];
        foreach ($value as $item) {
            $teachingTypes[$item] = $item;
        }
        
        $this->attributes['teaching_types'] = serialize($teachingTypes === null ? [] : $teachingTypes);
    }
    
    public function getTeachingTypesAttribute($value)
    {
        return @unserialize($value) !== false ? unserialize($value) : [];
    }
    
    public function setReferencesAttribute($value)
    {
        $this->attributes['references'] = serialize($value === null ? [] : $value);
    }
    
    public function getReferencesAttribute($value)
    {
        return @unserialize($value) !== false ? unserialize($value) : [null, null];
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function avatar()
    {
        return $this->belongsTo(Image::class, 'photo');
    }
    
    public static function getAllBookings()
    {
        $allBookings = Auth::user()->educatorBookings;
        
        return $allBookings;
    }
    
    public static function getViewCount($month)
    {
        $profileViews = EducatorView::where('user_id', Auth::user()->id)->get();
        
        $monthViews = $profileViews->filter(function ($item) use ($month) {
            return Carbon::parse($item->created_at)->format('Y-m') == $month;
        })->all();
        
        return count($monthViews);
    }
    
    public static function getLikeCount($month)
    {
        $likes = DB::table('liked_educators')->select()
            ->where('educator_id', Auth::user()->id)->get();
        
        $monthLikes = $likes->filter(function ($item) use ($month) {
            return Carbon::parse($item->created_at)->format('Y-m') == $month;
        })->all();
        
        return count($monthLikes);
    }
    
    public static function getRating($month)
    {
        $ratings = Auth::user()->ratings;
        $score = 0;
        
        $monthRatings = $ratings->filter(function ($item) use ($month, $score) {
            return Carbon::parse($item->created_at)->format('Y-m') == $month;
        })->all();
        
        if (count($monthRatings)) {
            foreach ($monthRatings as $monthRating) {
                $score += $monthRating->score;
            }
            $score = $score / count($monthRatings);
        }
        
        return $score;
    }
    
    public static function getSearchAppearances($month)
    {
        $searches = Auth::user()->searchAppearances;
        
        $monthSearches = $searches->filter(function ($item) use ($month) {
            return Carbon::parse($item->created_at)->format('Y-m') == $month;
        })->all();
        
        return count($monthSearches);
    }

    public function getTopPerformerAttribute()
    {
        return $this->hasMany(TopPerformer::class, 'educator_id')->count();
    }
}
