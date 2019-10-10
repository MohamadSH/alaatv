<?php

namespace App\Jobs;

use App\Content;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;

class RemoveContentPamphletFiles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $content;

    /**
     * Create a new job instance.
     *
     * @param Content $content
     */
    public function __construct(Content $content)
    {
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $CDNDisk = config('constants.DISK19_CLOUD');
        foreach ($this->content->getPamphlets() as $pamphlet){
            $path = basename($pamphlet->link);
            if(Storage::disk($CDNDisk)->exists($path)) {
                Storage::disk($CDNDisk)->delete($path);
            }
        }
    }
}
