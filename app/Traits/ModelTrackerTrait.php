<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-11-07
 * Time: 14:33
 */

namespace App\Traits;


trait ModelTrackerTrait
{
    /**
     *
     * @param $value
     *
     * @return mixed
     */
    public function getPage_viewAttribute($value){
        return json_decode($value);
    }

    public function getPageViewAttribute(){
        return $this->page_view->page_views;
    }

}