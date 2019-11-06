<?php


namespace App\Classes;


use Illuminate\Support\Collection;

interface TagSplitterInterface
{
    public function group(array $tags): Collection;
}
