<?php

namespace App\Mail;

use App\Lesson;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class RefundGrantAdminToParent extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;

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
    public function __construct($parent, $educator, $booking, $classes, $amount, $unsubscribeEmail)
    {
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
        return $this->subject('Your Refund request has been processed on Classhub')
            ->view('system-emails.refund-grant-admin-parent')->sendgrid(['personalizations' => [],]);
    }
}
