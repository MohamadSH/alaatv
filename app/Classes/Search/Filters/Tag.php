<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-09-04
 * Time: 15:30
 */

namespace App\Classes\Search\Filters;

use App\Classes\Search\Tag\ContentTagManagerViaApi;
use App\Classes\Search\TaggingInterface;
use Illuminate\Database\Eloquent\Builder;
use LogicException;

class Tag extends FilterAbstract
{
    protected $attribute = 'tags';
    protected $tagManager;

    public function apply(Builder $builder, $value, FilterCallback $callback): Builder
    {
        $this->isSetTagManager();

        if(!$this->validateTags($value, $callback))
            return $builder;

        $resultArray = $this->retriveTagable($value);

        $callback->success($builder,$resultArray);

        return $builder->whereIn('id',$resultArray);
    }

    /**
     * @param TaggingInterface $tagManager
     * @return Tag
     */
    public function setTagManager(TaggingInterface $tagManager)
    {
        $this->tagManager = $tagManager;
        return $this;
    }

    /**
     * @param $value
     * @param FilterCallback $callback
     * @return bool
     */
    private function validateTags($value, FilterCallback $callback): bool
    {
        if (!isset($value)) {
            $callback->err([
                "message" => $this->getValueShouldBeSetMessage()
            ]);
            return false;
        }
        if (!is_array($value)) {
            $callback->err([
                "message" => $this->getValueShouldBeArrayMessage()
            ]);
            return false;
        }
        return true;
    }

    private function isSetTagManager(): void
    {
        if (!isset($this->tagManager))
            throw new LogicException(get_class($this) . ' must have a $tagManager');
        if (!($this->tagManager instanceof TaggingInterface))
            throw new LogicException(get_class($this) . ' tagManager should be instance of TaggingInterface');
    }

    /**
     * @param $value
     * @return mixed
     */
    private function retriveTagable($value)
    {
        $tags = array_filter($value);
        [
            $numberOfResult,
            $resultArray
        ] = $this->tagManager->getTaggable($tags);
        return $resultArray;
    }


}