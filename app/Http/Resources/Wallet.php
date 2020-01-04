<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

/**
 * Class Wallet
 *
 * @mixin \App\Wallet
 * */
class Wallet extends AlaaJsonResourceWithPagination
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\Wallet)) {
            return [];
        }

        $this->loadMissing('walletType');

        return [
            'wallettype_id' => $this->when(isset($this->wallettype_id), function () {
                return new Wallettype($this->walletType);
            }),
            'balance'       => $this->balance,
        ];
    }
}
