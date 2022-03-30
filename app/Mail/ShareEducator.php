<?php

namespace App\Mail;

use App\Category;
use App\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class ShareEducator extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;

    public $educator;

    public $photoUrl;

    public $profileUrl;

    public $categories;
    
    public $unsubscribeEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($educator, $unsubscribeEmail)
    {
        $this->educator = $educator;

        $this->photoUrl = Storage::url(Image::find($this->educator->educator->photo)->path);

        $this->profileUrl = route('page.educator', $this->educator->slug);

        $categories = $educator->categories->pluck('id');

        $this->categories = Category::withTrashed()->whereIn('id', $categories)->whereNull('parent_id')
            ->pluck('name')->all();
    
        $this->unsubscribeEmail = $unsubscribeEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Check out Tutor profile on Classhub')
            ->view('system-emails.share-profile')->sendgrid(['personalizations' => [],]);
    }
}
