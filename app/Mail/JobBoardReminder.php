<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class JobBoardReminder extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;
    
    
    public $recipient;
    
    public $jobBoardUrl;
    
    public $unsubscribeEmail;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($recipient, $jobBoardUrl, $unsubscribeEmail)
    {
        $this->recipient = $recipient;
        
        $this->jobBoardUrl = $jobBoardUrl . '?view_key=' . base64_encode($recipient->email);
        
        $this->unsubscribeEmail = $unsubscribeEmail;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Jobs Board Reminder')
            ->view('system-emails.job-board')->sendgrid(['personalizations' => [],]);
    }
}
