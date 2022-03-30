<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Vimeo\Exceptions\VimeoRequestException;
use Vimeo\Vimeo;

class VimeoTrimJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $uri;
    public $trim_start;
    public $trim_end;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($uri, $trim_start, $trim_end)
    {
        $this->uri = $uri;
        $this->trim_start = $trim_start;
        $this->trim_end = $trim_end;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $vimeo = new Vimeo(env('VIMEO_ID'), env('VIMEO_SECRET'), env('VIMEO_TOKEN'));

        try {
            $response = $vimeo->request($this->uri.'/cliptrim', [
                'trim_start' => $this->trim_start,
                'trim_end' => $this->trim_end
            ], 'POST');

            \Log::info($response);
        } catch (VimeoRequestException $e) {
            $exceptionContent = $e->getResponse()->getBody()->getContents();
            \Log::error($exceptionContent);
        }
    }
}
