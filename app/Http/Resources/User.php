<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class User
 *
 * @mixin \App\User
 * */
class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\User)) {
            return [];
        }

        $this->loadMissing('major' , 'grade' , 'gender' , 'wallets' , 'userstatus');

        return [
            'id'                 => $this->id,
            'first_name'         => $this->firstName,
            'last_name'          => $this->lastName,
            'full_name'          => $this->full_name,
            'name_slug'          => $this->when(isset($this->nameSlug) , $this->nameSlug),
            'mobile'             => $this->mobile,
            'mobile_verified_at' => $this->mobile_verified_at,
            'last_service_call'  => $this->when(isset($this->lastServiceCall) , $this->lastServiceCall),
            'national_code'      => $this->nationalCode,
            'lock_profile'       => $this->lockProfile,
            'photo'              => $this->photo,
            'province'           => $this->province ,
            'city'               => $this->city,
            'address'            => $this->address,
            'postal_code'        => $this->postalCode,
            'school'             => $this->school,
            'email'              => $this->email ,
            'bio'                => $this->when(isset($this->bio) , $this->bio),
//            'info'               => $this->info ,
            'major'              => $this->when(isset($this->major) , function (){return New Major($this->major) ; }),
            'grade'              => $this->when(isset($this->grade) , function (){return New Grade($this->grade) ; }),
            'gender'             => $this->when(isset($this->gender) , function (){return New  Gender($this->gender) ; }),
            'profile_completion'  => (int) $this->completion(),
            'wallets'             => Wallet::collection($this->whenLoaded('wallets')),
            'userstatus'         => $this->when(isset($this->userstatus_id) , function (){ return New Userstatus($this->userstatus);}),
            'created_at'         => $this->created_at ,
        ];
    }
}
