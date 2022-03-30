<?php

namespace App\Mail;

use App\Testimonial;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class WelcomeUser extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;
    
    public $user;
    
    public $testimonials;
    
    public $unsubscribeEmail;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $unsubscribeEmail)
    {
        $this->user = $user;
        
        $this->testimonials = Testimonial::inRandomOrder()->take(3)->get();
        
        $this->unsubscribeEmail = $unsubscribeEmail;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Welcome to Classhub')
            ->view('system-emails.welcome-user')->sendgrid(['personalizations' => [],]);
    }
}
