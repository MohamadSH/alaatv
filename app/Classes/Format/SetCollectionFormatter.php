<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-11-02
 * Time: 18:03
 */

namespace App\Classes\Format;

use App\Collection\SetCollection;

interface SetCollectionFormatter
{
    /**
     * @param  SetCollection  $sets
     *
     * @return \Illuminate\Support\Collection
     */
    public function format(SetCollection $sets);
}