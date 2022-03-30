<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class LessonLive extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;
    
    public $educator;
    
    public $lesson;
    
    public $lessonImageUrl;
    
    public $type2AccountLive;
    
    public $unsubscribeEmail;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($educator, $lesson, $type2AccountLive = false)
    {
        $this->educator = $educator;
        
        $this->lesson = $lesson;
        
        $this->lessonImageUrl = $this->lesson->images->count() ? \Storage::url($this->lesson->images->first()->path) : '';
        
        $this->type2AccountLive = $type2AccountLive;
        
        $this->unsubscribeEmail = $educator->email;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Class set up successful on Classhub')
            ->view('system-emails.class-live')->sendgrid(['personalizations' => [],]);
    }
}
