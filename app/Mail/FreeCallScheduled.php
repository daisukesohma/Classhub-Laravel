<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class FreeCallScheduled extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;
    
    public $user;
    
    public $with;
    
    public $videoCall;
    
    public $unsubscribeEmail;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $with, $videoCall, $unsubscribeEmail)
    {
        $this->user = $user;
        
        $this->with = $with;
        
        $this->videoCall = $videoCall;
        
        $this->unsubscribeEmail = $unsubscribeEmail;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Free Video Call Scheduled')
            ->view('system-emails.free-video-call-scheduled')->sendgrid(['personalizations' => [],]);
    }
}
