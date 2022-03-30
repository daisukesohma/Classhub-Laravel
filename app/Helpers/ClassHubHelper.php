<?php

namespace App\Helpers;


use App\Booking;
use App\Category;
use App\Image;
use App\User;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class ClassHubHelper
{
    
    public static function validateData(array $data, array $rules)
    {
        $validator = Validator::make($data, $rules);
        
        if ($validator->fails()) {
            return [
                'status' => false,
                'validation_error' => true,
                'messages' => self::processValidationMessage($validator->messages()->toArray())
            ];
        }
        
        return true;
    }
    
    public static function processValidationMessage($messages)
    {
        $validationMessages = [];
        
        foreach ($messages as $key => $values) {
            foreach ($values as $key => $value)
                array_push($validationMessages, $value);
        }
        return $validationMessages;
    }
    
    
    public static function sortLessonDates()
    {
        $startDates = [];
        $endDates = [];
        
        foreach (request()->lesson_dates[request()->class_type] as $dates) {
            if ($dates['start']) {
                array_push($startDates, $dates['start']);
                array_push($endDates, $dates['end']);
            }
        }
        
        usort($startDates, function ($date1, $date2) {
            return strtotime($date1) - strtotime($date2);
        });
        
        usort($endDates, function ($date1, $date2) {
            return strtotime($date1) - strtotime($date2);
        });
        
        return [
            'start' => $startDates,
            'end' => $endDates
        ];
    }
    
    public static function centToEuro($cents)
    {
        return $cents / 100;
    }
    
    public static function roundCents($cents)
    {
        return (int)round($cents);
    }
    
    public static function ratings($ratings)
    {
        if ($ratings->isEmpty())
            return ['count' => 0];
        
        $totalScore = $ratings->sum('score');
        $count = $ratings->count();
        
        // Round to 0.5 times
        $score = $count ? round(($totalScore / $count) * 2) / 2 : 0;
        
        return [
            'rating' => [
                $score >= 1 ? 'full' : ($score >= 0.5 && $score < 1 ? 'half' : 'empty'),
                $score >= 2 ? 'full' : ($score >= 1.5 && $score < 2 ? 'half' : 'empty'),
                $score >= 3 ? 'full' : ($score >= 2.5 && $score < 3 ? 'half' : 'empty'),
                $score >= 4 ? 'full' : ($score >= 3.5 && $score < 4 ? 'half' : 'empty'),
                $score >= 5 ? 'full' : ($score >= 4.5 && $score < 5 ? 'half' : 'empty'),
            ],
            'count' => $count
        ];
    }
    
    public static function excerpt($content, $numWords = 45, $readMoreBtn = true, $htmlTags = true)
    {
        $content = $htmlTags ? nl2br($content) : strip_tags($content);
        $wordsArray = explode(' ', $content);
        
        if (str_word_count($content) > $numWords) {
            $hide = '...';
            $show = implode(' ', array_slice($wordsArray, 0, $numWords, true));
            
            if ($readMoreBtn) {
                $hide = '<span class="text-exposed-hide">...</span>
                    <a href="javascript:;" class="read-more-btn text-exposed-hide">Read more</a>
                    <span class="text-exposed-show" style="display: none; font-weight: inherit;">' .
                    implode(' ', array_slice($wordsArray, $numWords, null, true)) .
                    '</span><a href="javascript:;" class="read-less-btn text-exposed-show" style="display: none;">&nbsp;Read Less</a>';
            }
            
            $content = $show . $hide;
        }
        
        return $content;
    }
    
    public static function charsExcerpt($content, $numChars = 160, $readMoreBtn = true, $htmlTags = true)
    {
        $content = $htmlTags ? nl2br($content) : strip_tags($content);
        $wordsArray = explode(' ', $content);
        
        if (strlen($content) > $numChars) {
            $hide = '...';
            $show = '<span>' . trim(substr($content, 0, $numChars)) . '</span>';
            
            if ($readMoreBtn) {
                $hide = '<span class="text-exposed-hide">...</span>
                    <a href="javascript:;" class="read-more-btn text-exposed-hide">Read more</a>
                    <span class="text-exposed-show" style="display: none;margin-left: -5px; font-weight: inherit;">' . trim(substr($content, $numChars)) .
                    '</span><a href="javascript:;" class="read-less-btn text-exposed-show" style="display: none;">&nbsp;Read Less</a>';
            }
            
            $content = $show . $hide;
        }
        
        return $content;
    }
    
    public static function lessonTypePriceText($lesson)
    {
        if ($lesson->type === 'single')
            return 'per class';
        
        if ($lesson->type === 'group')
            return 'per group of classes';
        
        if ($lesson->type === 'term')
            return 'per term';
    }
    
    
    public static function classFullExceptionMessage($class)
    {
        $start = Carbon::parse($class->start_time)->format('h:i a');
        $end = Carbon::parse($class->end_time)->format('h:i a');
        $date = Carbon::parse($class->date)->format('d/m/Y');
        
        return "Oops! Class on $date at $start - $end is not available at the moment";
    }
    
    public static function uniqueCode()
    {
        $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        
        return substr(str_shuffle($string), 0, 4);
    }
    
    public static function lessonStatusHtml($status)
    {
        $status = ucwords($status);
        switch ($status) {
            case 'Active':
            case 'Live':
                $status = $status === 'Active' ? 'Live' : $status;
                return "<span class='m-badge  m-badge--success m-badge--wide'>$status</span>";
                break;
            case 'Draft':
                return "<span class='m-badge  m-badge--danger m-badge--wide'>Unfinished</span>";
                break;
            case 'Paused':
            case 'Cancelled':
            case 'Expired':
                return "<span class='m-badge  m-badge--danger m-badge--wide'>$status</span>";
                break;
        }
    }
    
    public static function generateRandomPassword()
    {
        $string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        
        return substr(str_shuffle($string), 0, 10);
    }
    
    
    /**
     * Convert array to rows and columns Grid (Matrix)
     * @param $array
     * @param int $cols
     * @return array
     */
    public static function arrayToGrid($array, $cols = 3)
    {
        $gridItems = [];
        if (count($array)) {
            $grid = self::itemsPerCol($array, $cols);
            $index = 0;
            foreach ($grid as $col => $numRows) {
                for ($row = 0; $row < $numRows; $row++) {
                    $gridItems[$col][$row] = $array[$index];
                    $index++;
                }
            }
        }
        return $gridItems;
    }
    
    public static function itemsPerCol($items, $col)
    {
        $colRows = [];
        $numItems = count($items);
        $colsLeft = $col;
        for ($i = 0; $i < $col; $i++) {
            $colRows[$i] = (int)ceil($numItems / $colsLeft);
            $numItems -= $colRows[$i];
            $colsLeft--;
        }
        return $colRows;
    }
    
    public static function getbookingCode($booking)
    {
        switch ($booking->id) {
            case $booking->id < 10 :
                $number = '000' . $booking->id;
                break;
            case $booking->id < 100 :
                $number = '00' . $booking->id;
                break;
            case $booking->id < 1000 :
                $number = '0' . $booking->id;
                break;
            default:
                $number = $booking->id;
                break;
        }
        
        return $booking->code . $number;
        
    }
    
    public static function categoryDropdown()
    {
        $categories = Category::all();
        $selectCategories = [];
        foreach ($categories as $category) {
            if ($category->subCategories->count()) {
                foreach ($category->subCategories as $subCategory) {
                    $selectCategories[$category->type][$category->name][$subCategory->id] = $subCategory->name;
                }
            } else {
                $selectCategories[$category->type][$category->id] = $category->name;
            }
        }
        return $selectCategories;
    }
    
    public static function getImagePath($image = null, $id = null)
    {
        try {
            if (!$image && !$id)
                return false;
            
            $image = $image ? $image : Image::findOrFail($id);
            return Storage::disk('public')->exists($image->path) ? Storage::url($image->path) : false;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    public static function slug($str)
    {
        $str = strtolower(trim($str));
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = preg_replace('/-+/', "-", $str);
        return $str;
    }
    
    
    public static function getInitials($string)
    {
        $names = explode(' ', $string);
        
        if (count($names) >= 2) {
            $initials = substr($names[0], 0, 1) .
                substr($names[count($names) - 1], 0, 1);
        } else {
            $initials = substr($names[0], 0, 1) .
                substr($names[0], 1, 1);
        }
        
        return strtoupper($initials);
    }
    
    public static function getSubjectDisplayName($subject, $allSubjects)
    {
        try {
            $subjectIds = $allSubjects->pluck('id')->toArray();
            if (!$subject->parent_id) {
                $children = false;
                $subCategories = $subject->subCategories->pluck('id')->toArray();
                foreach ($subCategories as $subCategory) {
                    if (in_array($subCategory, $subjectIds)) {
                        $children = true;
                        break;
                    }
                }
                
                if (!$children) {
                    return $subject->name;
                } else {
                    return false;
                }
            } else {
                return Category::getDisplayName($subject->id);
            }
        } catch (\Exception $e) {
            return false;
        }
    }
    
    public static function custom_copy($src, $dst)
    {
        
        // open the source directory
        $dir = opendir($src);
        
        // Make the destination directory if not exist
        mkdir($dst);
        
        // Loop through the files in source directory
        while ($file = readdir($dir)) {
            
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    
                    // Recursively calling custom copy function
                    // for sub directory
                    custom_copy($src . '/' . $file, $dst . '/' . $file);
                    
                } else {
                    try {
                        dump($src . '/' . $file, $dst . '/' . $file);
                        copy($src . '/' . $file, $dst . '/' . $file);
                    } catch (\Exception $e) {
                        dump('Copy error: ', $e->getMessage());
                    }
                    
                }
            }
        }
        
        closedir($dir);
    }
    
    public static function getFirstName($name)
    {
        $nameArr = explode(' ', $name);
        return $nameArr[0];
    }
    
    public static function getLastName($name)
    {
        $nameArr = explode(' ', $name);
        return $nameArr[count($nameArr) - 1];
    }
    
    public static function lessonPaginate($lessons, $perPage)
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        
        $lessons = $lessons->filter(function ($lesson) {
            
            $firstClass = $lesson->classes->first();
            $lastClass = $lesson->classes->last();
            $classStartAt = Carbon::parse($firstClass->date . ' ' . $firstClass->start_time);
            $classEndAt = Carbon::parse($lastClass->date . ' ' . $lastClass->start_time);
            
            if ($lesson->type == 'single') {
                $bookableClasses = $lesson->classes()->where('bookable', 1)->get();
                
                return $lesson->status == 'live' && $bookableClasses->isNotEmpty() && $classEndAt->isFuture();
            } else {
                return $lesson->status == 'live' && $lesson->bookable && $classStartAt->isFuture();
            }
        });
        
        $currentPageLessons = $lessons->slice(($currentPage - 1) * $perPage, $perPage)->all();
        
        $paginatedLessons = (new LengthAwarePaginator($currentPageLessons, $lessons->count(), $perPage))
            ->setPath(request()->url());
        
        return $paginatedLessons;
    }
    
    public static function liveClassCount($lessons)
    {
        
        $liveClasses = $lessons->filter(function ($lesson) {
            
            $firstClass = $lesson->classes->first();
            $lastClass = $lesson->classes->last();
            $classStartAt = Carbon::parse($firstClass->date . ' ' . $firstClass->start_time);
            $classEndAt = Carbon::parse($lastClass->date . ' ' . $lastClass->start_time);
            
            if ($lesson->type == 'single') {
                $bookableClasses = $lesson->classes()->where('bookable', 1)->get();
                return $lesson->status == 'live' && $bookableClasses->isNotEmpty() && $classEndAt->isFuture();
            } else {
                return $lesson->status == 'live' && $lesson->bookable && $classStartAt->isFuture();
            }
            
        });
        
        return $liveClasses->count();
    }
    
    public static function filterTutorsByAvailability($tutors, $from, $to)
    {
        $timeRange = [
            '7:00 AM', '8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM', 
            '3:00 PM', '4:00 PM', '5:00 PM', '6:00 PM', '7:00 PM', '8:00 PM', '9:00 PM', '10:00 PM'
        ];

        $from_index = array_search($from, $timeRange);
        $to_index = array_search($to, $timeRange);

        if ($from_index <= $to_index) {
            if ($from_index < 5) {
                if ($to_index <= 5) {
                    $tutors = $tutors->where('availability', 'like', '%morning%');
                } else if (5 < $to_index && $to_index <= 9) {
                    $tutors = $tutors->where(function($query) {
                        $query->where('availability', 'like', '%morning%')
                            ->orWhere('availability', 'like', '%afternoon%');
                    });
                } else if (9 < $to_index && $to_index <= 12) {
                    $tutors = $tutors->where(function($query) {
                        $query->where('availability', 'like', '%morning%')
                            ->orWhere('availability', 'like', '%afternoon%')
                            ->orWhere('availability', 'like', '%evening%');
                    });
                }
            } else if ( 5 <= $from_index && $from_index < 9) {
                if ($to_index <= 9) {
                    $tutors = $tutors->where('availability', 'like', '%afternoon%');
                } else if (9 < $to_index && $to_index <= 12) {
                    $tutors = $tutors->where(function($query) {
                        $query->where('availability', 'like', '%afternoon%')
                            ->orWhere('availability', 'like', '%evening%');
                    });
                } else if (12 < $to_index && $to_index <= 15) {
                    $tutors = $tutors->where(function($query) {
                        $query->where('availability', 'like', '%afternoon%')
                            ->orWhere('availability', 'like', '%evening%')
                            ->orWhere('availability', 'like', '%later%');
                    });
                }
            } else if ( 9 <= $from_index && $from_index < 12) {
                if ($to_index <= 12) {
                    $tutors = $tutors->where('availability', 'like', '%evening%');
                } else if (12 < $to_index && $to_index <= 15) {
                    $tutors = $tutors->where(function($query) {
                        $query->where('availability', 'like', '%evening%')
                            ->orWhere('availability', 'like', '%later%');
                    });
                }
            } else if ( 12 <= $from_index && $from_index <= 15) {
                if ($to_index <= 15) {
                    $tutors = $tutors->where('availability', 'like', '%later%');
                }
            }
        }

        return $tutors;
    }

    public static function getTopPerformerIds($categoryId)
    {
        $educators = User::whereHas('educator')
            ->where('is_online', 1)
            ->where('account_live', 1)
            ->whereHas('categories', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->get();

        $new_educators = [];
        foreach ($educators as $user) {
            $lessonIds = $user->lessonsWithTrashed(function ($query) use ($categoryId) {
                    $query->where('category_id', $categoryId);
                })
                ->whereHas('bookings')->pluck('id')->toArray();

            $bookings = Booking::whereIn('lesson_id', $lessonIds)
                ->whereDate('created_at', '>', Carbon::now()->subDays(90))
                ->withTrashed()
                ->get();
                
            $booking_no = count($bookings);

            if ($booking_no > 0) {
                array_push($new_educators, [
                    'id' => $user->id,
                    'booking_no' => $booking_no,
                ]);
            }
        }

        usort($new_educators, function ($a, $b) {
            return ($a['booking_no'] > $b['booking_no']) ? -1 : 1;
        });

        $top5Limit = ceil( count($new_educators) / 20 );
        $top5EducatorIds = array_column(array_slice($new_educators, 0, $top5Limit), 'id');

        return $top5EducatorIds;
    }
}
