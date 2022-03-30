<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class ClassBookUpExpired extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;
    
    public $educator;
    
    public $lesson;
    
    public $class;
    
    public $unsubscribeEmail;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($educator, $lesson, $class = null)
    {
        $this->educator = $educator;
    
        $this->lesson = $lesson;
    
        $this->class = $class;
    
        $this->unsubscribeEmail = $educator->email;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Class fully booked or expired on Classhub')
            ->view('system-emails.booked-up-educator')->sendgrid(['personalizations' => [],]);
    }
}
