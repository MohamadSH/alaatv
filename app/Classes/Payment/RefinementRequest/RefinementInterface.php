<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/8/2019
 * Time: 1:17 PM
 */

namespace App\Classes\Payment\RefinementRequest;


use App\Order;
use App\User;

interface RefinementInterface
{
    public function getOrderCost($book_in): int;

    public function getDonateCost($book_in): int;

    public function getUser($book_in): User;

    public function getOrder($book_in): Order;

    public function getStatusCode($book_in): int;

    public function getMessage($book_in): int;
}