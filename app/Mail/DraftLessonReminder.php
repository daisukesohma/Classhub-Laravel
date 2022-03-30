<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class DraftLessonReminder extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;
    
    public $user;
    
    public $lesson;
    
    public $unsubscribeEmail;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $lesson, $unsubscribeEmail)
    {
        $this->user = $user;
        
        $this->lesson = $lesson;
    
        $this->unsubscribeEmail = $unsubscribeEmail;
    
        \Log::info('Draft lesson email: ' . $this->unsubscribeEmail . ', Lesson ID : ' . $this->lesson->id);
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('You have unfinished class')
            ->view('system-emails.draft-lesson-reminder')->sendgrid(['personalizations' => [],]);
    }
}
