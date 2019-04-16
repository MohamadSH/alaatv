<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-11-02
 * Time: 17:37
 */

namespace App\Classes\Format;

use App\Collection\BlockCollection;

interface BlockCollectionFormatter
{
    /**
     * @param BlockCollection $blocks
     *
     * @return \Illuminate\Support\Collection
     */
    public function format(BlockCollection $blocks);
}