<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2019-04-26
 * Time: 04:14
 */

namespace App\Classes\Repository;

use App\Content;

interface ContentRepositoryInterface
{
    public function getContentById($contentId): Content;
}