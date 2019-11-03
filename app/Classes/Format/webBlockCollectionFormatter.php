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
use Illuminate\Support\Facades\Cache;

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
     * @param  BlockCollection  $blocks
     *
     * @return \Illuminate\Support\Collection
     */
    public function format(BlockCollection $blocks)
    {
        $sections = collect();

        /*//TODO:: fix some bugs!!
        //FastCGI sent in stderr: "PHP message: PHP Fatal error:  Allowed memory size of
        $user = auth()->user();
        if(isset($user))
            auth()->logout();*/

        foreach ($blocks as $block) {
            $sections->push($this->blockFormatter($block));
        }

        /*if(isset($user))
            auth()->login($user,true);
        */
        return $sections;
    }

    /**
     * @param  Block  $block
     *
     * @return array
     */
    private function blockFormatter(Block $block): array
    {
        return Cache::tags(['block' , 'block_',$block->id])
            ->remember('formatBlock:'.$block->id, config('constants.CACHE_600'), function () use ($block) {
                $section = [
                    "name"            => $block->class,
                    "displayName"     => $block->title,
                    "descriptiveName" => $block->title,
                    "lessons"         => $this->setFormatter->format($block->sets),
                    "tags"            => $block->tags,
                    'ads'             => [

                    ],
                    'class'           => $block->class,
                    'url'             => $block->url,
                ];

                return $section;
            });

    }
}
