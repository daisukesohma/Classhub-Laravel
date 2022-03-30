<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class CancelLessonEducatorToParent extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;

    public $educator;

    public $parent;

    public $lesson;

    public $lessonClasses;
    
    public $unsubscribeEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($parent, $lesson, $classes, $unsubscribeEmail)
    {
        $this->educator = Auth::user();

        $this->parent = $parent;

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
        return $this->subject('Your booking has been cancelled on Classhub')
            ->view('system-emails.cancel-lesson-educator-parent')->sendgrid(['personalizations' => [],]);
    }
}
