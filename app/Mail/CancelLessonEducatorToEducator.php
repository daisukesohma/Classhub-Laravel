<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class CancelLessonEducatorToEducator extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;

    public $educator;

    public $lesson;

    public $lessonClasses;
    
    public $unsubscribeEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($educator, $lesson, $classes, $unsubscribeEmail)
    {
        $this->educator = $educator;

        $this->lesson = $lesson;

        $this->lessonClasses = $lesson->classes->whereIn('id', $classes)->all();
    
        $this->unsubscribeEmail = $unsubscribeEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your class has been cancelled on Classhub')
            ->view('system-emails.cancel-lesson-educator-educator')->sendgrid(['personalizations' => [],]);
    }
}
