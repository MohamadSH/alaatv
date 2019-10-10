<?php

namespace App\Console\Commands;

use App\Content;
use App\Contentset;
use Illuminate\Console\Command;

class FixOldContentsLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alaaTv:fix:oldContents:links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $contentsets = Contentset::where('id' , '<=' , 87)->get();
        $contentsetCount = $contentsets->count();
        if($this->confirm("$contentsetCount sets found , Do you want to continue ?", true)) {
            $contentSetBar = $this->output->createProgressBar($contentsetCount);
                foreach ($contentsets as $contentset) {
                    $contents = $contentset->contents;
                    $this->info('Processing '. $contents->count() .' contents...');
                    $this->info("\n\n");
                    /** @var Content $content */
                    foreach ($contents as $content) {
                            if ($content->contenttype_id != config('constants.CONTENT_TYPE_VIDEO')) {
                                continue;
                            }

                            $videos = json_decode($content->getOriginal('file'));
                            foreach ($videos as $video) {
                                if(!isset($video->url)){
                                    $this->info('content ' . $content->id . ' doesnt have video url.');
                                    $this->info("\n");
                                    continue;
                                }

                                if(!isset($video->res)){
                                    $this->info('content ' . $content->id . ' doesnt have video res.');
                                    $this->info("\n");
                                    continue;
                                }

                                $link = $video->url;
                                $res = $video->res;
                                if (strpos($link, '/media/') !== false) {
                                    if ($res == '720p' && strpos($link, '/HD_720p/') === false) {
                                        $splitted = explode('/media/', $link);
                                        $subPath = '/media/HD_720p/' . $splitted[1];
                                        $video->url = $splitted[0] . $subPath;
                                        $video->fileName = $subPath;
                                    } elseif ($res == '480p' && strpos($link, '/hq/') === false) {
                                        $splitted = explode('/media/', $link);
                                        $subPath = '/media/hq/' . $splitted[1];
                                        $video->url = $splitted[0] . $subPath;
                                        $video->fileName = $subPath;
                                    } elseif ($res == '240p' && strpos($link, '/240p/') === false) {
                                        $splitted = explode('/media/', $link);
                                        $subPath = '/media/240p/' . $splitted[1];
                                        $video->url = $splitted[0] . $subPath;
                                        $video->fileName = $subPath;
                                    }
                                }
                            }

                            $content->setRawAttributes(['file' => json_encode($videos)]);
                            if (!$content->update()) {
                                $this->info('content ' . $content->id . ' could not be updated.');
                                $this->info("\n");
                            }

                    }
                    $contentSetBar->advance();
                    $this->info("\n");
                }
                $contentSetBar->finish();

            $this->info('Command Finished!');
            $this->info("\n\n");
        }
    }
}
