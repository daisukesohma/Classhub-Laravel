<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class FreeVideoCallReminder extends Mailable
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
        
        \Log::info('Free Video call reminder email: ' . $this->unsubscribeEmail . ',
            Time : ' . Carbon::parse($this->videoCall->call_time)->format('d/m/Y h:i a').
            ', Sent at:'.Carbon::now()->format('d/m/Y h:i a'));
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Free Video call reminder')
            ->view('system-emails.free-video-call-reminder')->sendgrid(['personalizations' => [],]);
    }
}
