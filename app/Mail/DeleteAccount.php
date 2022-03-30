<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class DeleteAccount extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;

    public $name;
    
    public $unsubscribeEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $unsubscribeEmail)
    {
        $this->name = $name;
    
        $this->unsubscribeEmail = $unsubscribeEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Account deleted on Class Hub')
            ->view('system-emails.delete-account')->sendgrid(['personalizations' => [],]);
    }
}
