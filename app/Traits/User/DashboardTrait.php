<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2019-02-15
 * Time: 15:46
 */

namespace App\Traits\User;


use App\Block;
use App\Collection\BlockCollection;

trait DashboardTrait
{
    use AssetTrait;

    /**
     *
     * @return \App\Collection\BlockCollection|null
     */
    public function getDashboardBlocks(): ?BlockCollection
    {
        $blocks = $this->makeBlockForUserProducts();
        return isset($blocks) ? (new BlockCollection())->add($this->makeBlockForUserProducts()) : null;
    }

    /**
     * @return \App\Block
     */
    private function makeBlockForUserProducts(): ?Block
    {
        $products = $this->products();
        if ($products->count() > 0)
            return Block::getDummyBlock(false, 'محصولات من', $products);
        return null;
    }


}