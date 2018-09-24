<?php

namespace App\Console\Commands;

use App\Classes\Search\Tag\AuthorTagManagerViaApi;
use App\Collection\ContentCollection;
use App\Collection\UserCollection;
use App\Content;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class AuthorTagCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alaaTv:seed:author:tag {author : The ID of the teacher}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add Tags for an Author';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $authorId = (int)$this->argument('author');
        if($authorId > 0){
            try {
                $user = User::findOrFail($authorId);
            } catch (ModelNotFoundException $exception){
                $this->error($exception->getMessage());
                return;
            }
            if ($this->confirm('You have chosen '.$user->getfullName().'. Do you wish to continue?',true)) {
                $this->performTaggingTaskForAnAuthor($user);
            }
        }else{
            $this->performTaggingTaskForAllAuthors();
        }


    }

    /**
     * @param $user
     */
    private function performTaggingTaskForAnAuthor(User $user)
    {

        $userContents = $user->contents ;

        if(count($userContents) == 0){
            $this->error("user ".$user->getfullName()." has no content.");

        }else{
            $tags = $this->mergeContentTags($userContents);
            (new AuthorTagManagerViaApi())->setTags($user->id, $tags );
        }
    }

    /**
     * @param $userContents
     * @return array
     */
    private function mergeContentTags(ContentCollection $userContents): array
    {
        $tags = [];
        foreach ($userContents as $content) {
//            if($content->id == 7971)
//                dd($content->tags->tags);
            $tags = array_merge($tags, $content->tags->tags);
        }
        $tags = array_values(array_unique($tags));
        return $tags;
    }

    private function performTaggingTaskForAllAuthors(): void
    {
        $users = User::getTeachers();
        $bar = $this->output->createProgressBar($users->count());
        foreach ($users as $user) {
            $this->performTaggingTaskForAnAuthor($user);
            $bar->advance();
        }
        $bar->finish();
        $this->info("");
    }
}
