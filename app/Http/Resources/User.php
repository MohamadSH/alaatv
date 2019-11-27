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

        $user = $request->user();

        return [
            'id'                => $this->id,
            'firstName'         => $this->firstName,
            'lastName'          => $this->lastName,
            'full_name'         => $this->full_name,
            'nameSlug'          => $this->nameSlug,
            'mobile'            => $this->mobile,
            'email_verified_at' => $this->email_verified_at,
            'mobile_verified_at'=> $this->mobile_verified_at,
            'lastServiceCall'   => $this->lastServiceCall,
            'whatsapp'          => $this->whatsapp,
            'skype'             => $this->skype,
            'nationalCode'      => $this->nationalCode,
            'lockProfile'       => $this->lockProfile,
            'photo'             => $this->photo,
            'province'          => $this->province ,
            'city'              => $this->city,
            'address'           => $this->address,
            'postalCode'        => $this->postalCode,
            'school'            => $this->school,
            'created_at'        => $this->created_at ,
            'updated_at'        => $this->updated_at ,
            'email'             => $this->email ,
            'bio'               => $this->bio,
            'introducedBy'      => $this->introducedBy,
            'bloodtype_id'      => $this->bloodtype_id,
            'allergy'           => $this->allergy ,
            'medicalCondition'  => $this->medicalCondition ,
            'diet'              => $this->diet,
            'info'              => $this->info ,
            'userstatus'        => $this->userstatus,
            'roles'             => $this->roles,
            'totalBonNumber'    => $this->total_bon_number,
            'editLink'          => $this->when( isset($user) && $user->can(config('constants.EDIT_USER_ACCESS')), 'edit_link') ,
            'removeLnk'         => $this->when( isset($user) && $user->can(config('constants.REMOVE_USER_ACCESS')), 'remove_lnk') ,
        ];
    }
}
