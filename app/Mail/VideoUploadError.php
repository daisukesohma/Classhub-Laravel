<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class VideoUploadError extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;
    
    public $user;
    
    public $class;
    
    public $unsubscribeEmail;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $class, $unsubscribeEmail)
    {
        $this->user = $user;
        
        $this->class = $class;
        
        $this->unsubscribeEmail = $unsubscribeEmail;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Classhub: Please upload your video again')
            ->view('system-emails.video-upload-error')->sendgrid(['personalizations' => [],]);
    }
}
