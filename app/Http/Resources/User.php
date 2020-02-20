<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

/**
 * Class User
 *
 * @mixin \App\User
 * */
class User extends AlaaJsonResourceWithPagination
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
        if (!($this->resource instanceof \App\User)) {
            return [];
        }

        $this->loadMissing('major', 'grade', 'gender', 'wallets', 'userstatus');

        return [
            'id'                 => $this->id,
            'first_name'         => $this->when(isset($this->firstName), $this->firstName),
            'last_name'          => $this->when(isset($this->lastName), $this->lastName),
            'name_slug'          => $this->when(isset($this->nameSlug), $this->nameSlug),
            'mobile'             => $this->when(isset($this->mobile), $this->mobile),
            'mobile_verified_at' => $this->when(isset($this->mobile_verified_at), $this->mobile_verified_at),
            'last_service_call'  => $this->when(isset($this->lastServiceCall), $this->lastServiceCall),
            'national_code'      => $this->when(isset($this->nationalCode), $this->nationalCode),
            'photo'              => $this->when(isset($this->photo), $this->photo),
            'province'           => $this->when(isset($this->province), $this->province),
            'city'               => $this->when(isset($this->city), $this->city),
            'address'            => $this->when(isset($this->address), $this->address),
            'postal_code'        => $this->when(isset($this->postalCode), $this->postalCode),
            'school'             => $this->when(isset($this->school), $this->school),
            'email'              => $this->when(isset($this->email), $this->email),
            'bio'                => $this->when(isset($this->bio), $this->bio),
//            'info'               => $this->info ,
            'major'              => $this->when(isset($this->major), function () {
                return New Major($this->major);
            }),
            'grade'              => $this->when(isset($this->grade), function () {
                return New Grade($this->grade);
            }),
            'gender'             => $this->when(isset($this->gender), function () {
                return New  Gender($this->gender);
            }),
            'profile_completion' => (int)$this->completion(),
            'wallet_balance'     => $this->getTotalWalletBalance(),
            'updated_at'         => $this->when(isset($this->updated_at), function () {
                return $this->updated_at->toDateTimeString();
            }),
            'created_at'         => $this->when(isset($this->created_at), function () {
                return $this->created_at->toDateTimeString();
            }),
        ];
    }
}
