<?php

namespace App\PaymentModule\Wallet;

use App\PaymentModule\Wallet\Models\Wallet;

class WalletRepo
{
    /**
     * @param array $data
     *
     * @return array
     */
    public static function insertNewRow(array $data): array
    {
        return Wallet::insertGetId($data);
    }
}
