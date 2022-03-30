<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class PasswordResetCode extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;

    public $passwordReset;

    public $user;

    public $messageUrl;
    
    public $unsubscribeEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($passwordReset, $unsubscribeEmail)
    {
        $this->passwordReset = $passwordReset;
        
        $this->user = User::findOrFail($passwordReset->user_id);
    
        $this->unsubscribeEmail = $unsubscribeEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reset password on Class Hub')
            ->view('system-emails.password-reset')->sendgrid(['personalizations' => [],]);
    }
}
