<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-11-02
 * Time: 17:40
 */

namespace App\Classes\Format;

use App\Block;
use App\Collection\BlockCollection;
use Illuminate\Support\Facades\Log;

class webBlockCollectionFormatter implements BlockCollectionFormatter
{
    /**
     * @var SetCollectionFormatter
     */
    private $setFormatter;

    public function __construct(SetCollectionFormatter $formatter)
    {
        $this->setFormatter = $formatter;
    }

    /**
     * @param BlockCollection $blocks
     *
     * @return \Illuminate\Support\Collection
     */
    public function format(BlockCollection $blocks)
    {
        Log::error('webBlockCollectionFormatter format 1');
        $sections = collect();
        foreach ($blocks as $block) {
            Log::error('begin format block id :'.$block->id);
            $section = $this->blockFormatter($block);
            Log::error('end format block id: '.$block->id);
            $sections->push($section);
            Log::error('insert block id:'.$block->id);
        }

        Log::error('webBlockCollectionFormatter format 2');
        return $sections;
    }

    /**
     * @param Block $block
     *
     * @return array
     */
    private function blockFormatter(Block $block): array
    {
        $section = [
            "name" => $block->class,
            "displayName" => $block->title,
            "descriptiveName" => $block->title,
            "lessons" => $this->setFormatter->format($block->sets),
            "tags" => $block->tags,
            'ads' => [

            ],
            'class' => $block->class,
            'url' => $block->url,
        ];

        return $section;
    }
}