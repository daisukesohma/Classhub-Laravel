<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class TrustedReminder extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;
    
    public $user;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
        
        \Log::info('Trusted reminder email: ' . $this->user->email);
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Would you like to become trusted on Classhub?')
            ->view('system-emails.trusted')->sendgrid(['personalizations' => [],]);
    }
}
