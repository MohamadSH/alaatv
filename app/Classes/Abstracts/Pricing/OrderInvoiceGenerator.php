<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 12/23/2018
 * Time: 4:55 PM
 */

namespace App\Classes\Abstracts\Pricing;


use App\Order;

abstract class OrderInvoiceGenerator
{

    protected $order;

    /**
     * OrderInvoiceGenerator constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    abstract function generateInvoice():array ;
}