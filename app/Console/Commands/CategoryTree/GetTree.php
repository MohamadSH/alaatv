<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 2/10/2019
 * Time: 10:58 AM
 */

namespace App\Console\Commands\CategoryTree;


interface GetTree
{
    public static function getTree(): array;
}