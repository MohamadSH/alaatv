<?php

namespace App\Classes;

use Illuminate\Support\Collection;

interface TagsGroupContracts
{
    /**
     * @return array
     */
    public function getTagsArray(): array;

    /**
     * @return Collection
     */
    public function getTagsGroup(): Collection;

    /**
     * @return int
     */
    public function getNumberOfTotalTags(): int;
}
