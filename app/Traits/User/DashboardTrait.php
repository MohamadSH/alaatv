<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2019-02-15
 * Time: 15:46
 */

namespace App\Traits\User;


use App\Collection\BlockCollection;

trait DashboardTrait
{
    /**
     *
     * @return \App\Collection\BlockCollection|null
     */
    public function getDashboardBlocks(): ?BlockCollection
    {
        return null;
    }

}