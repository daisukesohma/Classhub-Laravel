<?php

namespace App\Mail;

use App\Category;
use App\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class ShareLesson extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;

    public $lesson;

    public $educator;

    public $photoUrl;

    public $lessonUrl;

    public $lessonImageUrl;

    public $categoryName;
    
    public $unsubscribeEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($lesson, $educator, $unsubscribeEmail)
    {
        $this->lesson = $lesson;

        $this->educator = $educator;

        $this->photoUrl = Storage::url(Image::find($this->educator->educator->photo)->path);

        $this->lessonImageUrl = $this->lesson->images->count() ? Storage::url($lesson->images->first()->path) : '';

        $this->lessonUrl = route('page.lesson', $this->lesson->slug);

        $category = Category::withTrashed()->findOrFail($this->lesson->category_id);

        $this->categoryName = $category->parent_id ? Category::withTrashed()->findOrFail($category->parent_id)->name : $category->name;
    
        $this->unsubscribeEmail = $unsubscribeEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Check out Class on Classhub')
            ->view('system-emails.share-lesson')->sendgrid(['personalizations' => [],]);
    }
}
