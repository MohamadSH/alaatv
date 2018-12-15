<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 11/10/2018
 * Time: 12:07 PM
 */

namespace App\Traits;

trait SearchCommon
{
    /**
     * Makes partial view for search query
     *
     * @param $query
     *
     * @return string
     */
    private function getPartialSearchFromIds($query, $layout)
    {
        $partialSearch = \Illuminate\Support\Facades\View::make($layout, ['items' => $query])
            ->render();
        return $partialSearch;
    }
}