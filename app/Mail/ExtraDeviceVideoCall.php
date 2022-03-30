<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class ExtraDeviceVideoCall extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;
    
    public $user;
    
    public $classId;
    
    public $unsubscribeEmail;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $unsubscribeEmail, $classId)
    {
        $this->user = $user;
        
        $this->classId = $classId;
        
        $this->unsubscribeEmail = $unsubscribeEmail;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Classhub: Add extra device on Video call')
            ->view('system-emails.extra-device-video-call')->sendgrid(['personalizations' => [],]);
    }
}
