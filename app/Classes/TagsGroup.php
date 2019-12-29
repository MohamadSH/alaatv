<?php


namespace App\Classes;


use Illuminate\Support\Collection;

class TagsGroup implements TagsGroupContracts
{
    /**
     * @var array
     */
    protected $tagsArray;

    /**
     * @var Collection
     */
    protected $tagsGroup;
    /**
     * @var int
     */
    protected $numberOfTotalTags;

    /**
     * TagsGroup constructor.
     *
     * @param array $tags
     */
    public function __construct(array $tags)
    {
        $this->tagsArray = $tags;

        $this->init();
    }

    private function init(): void
    {
        $tagsSplitter            = app(TagSplitter::class);
        $this->tagsGroup         = $tagsSplitter->group($this->tagsArray);
        $this->numberOfTotalTags = count($this->tagsArray);
    }

    /**
     * @return array
     */
    public function getTagsArray(): array
    {
        return $this->tagsArray ?? [];
    }

    /**
     * @return Collection
     */
    public function getTagsGroup(): Collection
    {
        return $this->tagsGroup ?? collect();
    }

    /**
     * @return int
     */
    public function getNumberOfTotalTags(): int
    {
        return $this->numberOfTotalTags;
    }
}
