<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class EducatorSetupClassReminder extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;
    
    public $educator;
    
    public $unsubscribeEmail;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($educator)
    {
        $this->educator = $educator;
        
        $this->unsubscribeEmail = $educator->email;
        
        \Log::info('Setup class reminder email: ' . $this->unsubscribeEmail);
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Setup Class reminder on Classhub')
            ->view('system-emails.educator-setup-class-reminder')->sendgrid(['personalizations' => [],]);
    }
}
