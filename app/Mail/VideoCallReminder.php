<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class VideoCallReminder extends Mailable
{
    use Queueable, SerializesModels;

    use SendGrid;

    public $toName;

    public $withName;

    public $videoCall;
    
    public $classId;

    public $meetingLink;

    public $unsubscribeEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($toName, $withName, $videoCall, $classId, $meetingLink, $unsubscribeEmail)
    {
        $this->toName = $toName;

        $this->withName = $withName;

        $this->videoCall = $videoCall;
        
        $this->classId = $classId;

        $this->meetingLink = $meetingLink;

        $this->unsubscribeEmail = $unsubscribeEmail;

        \Log::info('Video call reminder email: ' . $this->unsubscribeEmail . ', Time : ' . $this->videoCall->video_call_time);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Online Tuition Reminder')
            ->view('system-emails.video-call-reminder')->sendgrid(['personalizations' => [],]);
    }
}
