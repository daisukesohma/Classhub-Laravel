<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class TermClassReminder extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;
    
    public $toUser;
    
    public $educator;
    
    public $lesson;
    
    public $class;
    
    public $lessonImageUrl;
    
    public $unsubscribeEmail;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($toUser, $educator, $lesson, $class, $unsubscribeEmail)
    {
        $this->toUser = $toUser;
        
        $this->educator = $educator;
        
        $this->lesson = $lesson;
        
        $this->class = $class;
        
        $this->lessonImageUrl = $this->lesson->images->count() ? \Storage::url($this->lesson->images->first()->path) : '';
        
        $this->unsubscribeEmail = $unsubscribeEmail;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Class reminder from Classhub')
            ->view('system-emails.class-term-reminder')->sendgrid(['personalizations' => [],]);
    }
}
