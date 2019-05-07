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
        $result = new BlockCollection();
        $blocks = [
            'products' => $this->makeBlockForUserProducts(),
            'favored'  => $this->makeBlockForUserFavored(),
        
        ];
        foreach ($blocks as $block) {
            if (isset($block)) {
                $result->add($block);
            }
        }
        
        return $result;
    }
    
    /**
     * @return \App\Block
     */
    private function makeBlockForUserProducts(): ?Block
    {
        $products = $this->products();
        if ($products->count() > 0) {
            return Block::getDummyBlock(false, trans('profile.My Products'), $products);
        }
        
        return null;
    }
    
    /**
     * @return \App\Block
     */
    private function makeBlockForUserFavored(): ?Block
    {
        $favored = [
            'content' => $this->favoredContent,
            'set'     => $this->favoredSet,
            'product' => $this->favoredProduct,
        ];
        if ($favored['product']->count() > 0 || $favored['set']->count() > 0 || $favored['content']->count() > 0) {
            return Block::getDummyBlock(false, trans('profile.Favored'), $favored['product'], $favored['set'],
                $favored['content']);
        }
        
        return null;
    }
}