<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class MoveClassEducator extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;
    
    public $educator;
    
    public $lesson;
    
    public $oldClass;
    
    public $newClass;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($educator, $lesson, $oldClass, $newClass)
    {
        $this->educator = $educator;
        
        $this->lesson = $lesson;
        
        $this->oldClass = $oldClass;
        
        $this->newClass = $newClass;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your class has been moved')
            ->view('system-emails.move-class-educator')->sendgrid(['personalizations' => [],]);
    }
}
