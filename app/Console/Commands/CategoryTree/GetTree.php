<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 2/10/2019
 * Time: 10:58 AM
 */

namespace App\Console\Commands\CategoryTree;


abstract class GetTree
{
    abstract function getTree(): array;

    protected function treeToLernitoJson(array $tree) {
        $return = array();
        array_walk_recursive($array, function($a) use (&$return) { $return[] = $a; });
        return $return;

//        $lernitoJsonTree = [];
//        $counter = 0;
//        foreach ($tree as $item) {
//            if (isset($item['children']) && count($item['children'])>0) {
//                $lernitoJsonTreeItem = [
//                    '_id' => $counter,
//                    'label' => $item['name'],
//                ];
//                $this->treeToLernitoJson($item['children']);
//            } else {
//
//            }
//        }
    }
}