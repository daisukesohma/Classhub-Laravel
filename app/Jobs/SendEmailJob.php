<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $recipientEmail;
    
    protected $emailNotification;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($recipientEmail, $emailNotification)
    {
        $this->recipientEmail = $recipientEmail;
        $this->emailNotification = $emailNotification;
    }
    
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->recipientEmail)->send($this->emailNotification);
    }
}
