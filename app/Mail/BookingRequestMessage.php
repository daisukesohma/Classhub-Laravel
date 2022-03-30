<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class BookingRequestMessage extends Mailable
{
    use Queueable, SerializesModels;

    use SendGrid;

    public $sender;

    public $recipient;

    public $messageContent;

    public $messageUrl;

    public $unsubscribeEmail;
    
    public $lesson;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sender, $recipient, $message, $messageUrl, $lesson, $unsubscribeEmail)
    {
        $this->sender = $sender;

        $this->recipient = $recipient;

        $this->messageContent = $message;

        $this->messageUrl = $messageUrl . '&view_key=' . base64_encode($recipient->email);
        
        $this->lesson = $lesson;

        $this->unsubscribeEmail = $unsubscribeEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('You received a booking request')
            ->view('system-emails.booking-request-message')->sendgrid(['personalizations' => [],]);
    }
}
