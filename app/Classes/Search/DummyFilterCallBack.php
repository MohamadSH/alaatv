<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-09-11
 * Time: 10:16
 */

namespace App\Classes\Search;

use App\Classes\Search\Filters\FilterCallback;
use Illuminate\Database\Eloquent\Builder;

class DummyFilterCallBack implements FilterCallback
{
    /**
     * @param array $err [ "status" => integer, "message" => string , "data" => mix]
     *
     * @return void
     */
    public function err(array $err): void
    {

    }

    public function success(Builder &$builder, &$data)
    {

    }
}
