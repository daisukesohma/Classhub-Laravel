<?php

namespace App\Mail;

use App\Lesson;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class RefundRejectOr72hrToParent extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;

    public $name;
    
    public $parent;

    public $educator;

    public $booking;

    public $lesson;

    public $lessonClasses;

    public $amount;
    
    public $unsubscribeEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $parent, $educator, $booking, $classes, $amount, $unsubscribeEmail)
    {
        $this->name = $name;
        
        $this->parent = $parent;

        $this->educator = $educator;

        $this->booking = $booking;

        $this->lesson = Lesson::findOrFail($booking->lesson_id);

        $this->lessonClasses = $this->lesson->classes->whereIn('id', $classes)->all();

        $this->amount = $amount;
    
        $this->unsubscribeEmail = $unsubscribeEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Refund request status on Classhub')
            ->view('system-emails.refund-rejected-72hr-parent')->sendgrid(['personalizations' => [],]);
    }
}
