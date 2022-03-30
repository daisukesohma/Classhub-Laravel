<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class ClasshubEnquiry extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;
    
    public $data;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
    
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Classhub Technologies Enquiry from ' . $this->data['name'])
            ->view('system-emails.classhub-enquiry')->sendgrid(['personalizations' => [],]);
    }
}
