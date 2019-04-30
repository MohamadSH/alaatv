<?php

namespace App\PaymentModule\Wallet;

class WalletRepo
{
    /**
     * @param array $data
     * @return array
     */
    public static function insertNewRow(array $data): array
    {
        return \App\PaymentModule\Wallet\Models\Wallet::insertGetId($data);
    }
}