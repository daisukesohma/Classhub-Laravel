<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class StripeAccountError extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;
    
    public $user;
    
    public $uploadLink;
    
    public $personDetails;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $uploadLink, $personDetails)
    {
        $this->user = $user;
        
        $this->uploadLink = $uploadLink;
        
        $this->personDetails = $personDetails;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Notification from Classhub: Update your Stripe account')
            ->view('system-emails.stripe-error')->sendgrid(['personalizations' => [],]);
    }
}
