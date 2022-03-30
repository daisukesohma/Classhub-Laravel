<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Intercom\IntercomClient;

class IntercomJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $user;
    
    public $data;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $data)
    {
        $this->user = $user;
        
        $this->data = $data;
    }
    
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new IntercomClient(env('INTERCOM_TOKEN'));
        
        try {
            $intercomUser = $client->users->create($this->data);
            
            if (isset($intercomUser->id)) {
                $this->user->update(['intercom_user_id' => $intercomUser->id]);
            }
        } catch (\Exception $e) {
            $exceptionContent = $e->getResponse()->getBody()->getContents();
            \Log::error($exceptionContent);
        }
    }
}
