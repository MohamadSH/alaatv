<?php


namespace App\Classes;


interface TagSplitterInterface
{
    public function group(array $tags): TagsGroup;
}
