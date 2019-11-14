<?php

namespace App\Console\Commands;

use App\Content;
use App\Jobs\InsertContentToSatra;
use Illuminate\Console\Command;

class InsertContentsToSatraCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alaaTv:insert:contents:to:satra';

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
        $contents = Content::query()
                            ->where('contenttype_id' , config('constants.CONTENT_TYPE_VIDEO'))
                            ->whereNull('redirectUrl')
                            ->active()
                            ->get();

        $contentsCount = $contents->count();

        if ($this->confirm('Found '.$contentsCount.' contents, Would you like to continue ?', true)) {

            $bar = $this->output->createProgressBar($contentsCount);
            foreach ($contents as $content) {
                dispatch(new InsertContentToSatra($content));
                $bar->advance();
            }

            $bar->finish();
        }
    }
}
