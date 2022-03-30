<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class VideoCallScheduled extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;
    
    public $user;
    
    public $with;
    
    public $videoCall;
    
    public $link;
    
    public $unsubscribeEmail;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $with, $videoCall, $link, $unsubscribeEmail)
    {
        $this->user = $user;
        
        $this->with = $with;
        
        $this->videoCall = $videoCall;
        
        $this->link = $link;
    
        $this->unsubscribeEmail = $unsubscribeEmail;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Video Call Scheduled')
            ->view('system-emails.video-call-scheduled')->sendgrid(['personalizations' => [],]);
    }
}
