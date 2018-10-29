<?php

namespace App\Console\Commands;

use App\Classes\Search\Tag\AuthorTagManagerViaApi;
use App\Classes\Search\TaggingInterface;
use App\Collection\ContentCollection;
use App\Traits\TaggableTrait;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorTagCommand extends Command
{
    private $tagging;
    use TaggableTrait;

    public function __construct(TaggingInterface $tagging)
    {
        parent::__construct();
        $this->tagging = $tagging;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alaaTv:seed:tag:author {author : The ID of the teacher}';

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
        if ($authorId > 0) {
            try {
                $user = User::findOrFail($authorId);
            } catch (ModelNotFoundException $exception) {
                $this->error($exception->getMessage());
                return;
            }
            if ($this->confirm('You have chosen ' . $user->getfullName() . '. Do you wish to continue?', true)) {
                $this->performTaggingTaskForAnAuthor($user);
            }
        } else {
            $this->performTaggingTaskForAllAuthors();
        }


    }

    /**
     * @param $user
     */
    private function performTaggingTaskForAnAuthor(User $user)
    {
        $userContents = $user->contents;
        if (count($userContents) == 0) {
            $this->error("user " . $user->getfullName() . " has no content.");

        } else {
            $this->sendTagsOfTaggableToApi($user, $this->tagging);
        }
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
