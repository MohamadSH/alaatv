<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Product
 *
 * @mixin \App\Product
 * */
class Child extends JsonResource
{
    function __construct(\App\Product $model)
    {
        parent::__construct($model);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\Product)) {
            return [];
        }

        if (isset($this->redirectUrl)) {
            return [
                'id'           => $this->id,
                'redirect_url' => $this->redirectUrl,
            ];
        }

        $this->loadMissing('children');

        return [
            'id'            => $this->id,
            'redirect_url'  => $this->when(isset($this->redirectUrl) , $this->redirectUrl),
            'name'          => $this->when(isset($this->name) , $this->name),
            'price'         => $this->price,
            'intro_video'   => $this->when(isset($this->introVideo) , $this->introVideo),
            'url'           => new Url($this),
            'photo'         => $this->when(isset($this->photo) , $this->photo),
            'gift'          => $this->when($this->gift->isNotEmpty() , function (){ return Gift::collection($this->gift) ; }) , //It is not a relationship
//            'sets'          => $this->when($this->sets->isNotEmpty() , function (){ return ProductSet::collection($this->sets); }), //It is not a relationship
            'attributes'    => [
                'info' =>  $this->when(!empty($this->info_attributes) , $this->info_attributes),
                'extra' => $this->when(!empty($this->extra_attributes) , $this->extra_attributes),
            ],
            'children'      => $this->when($this->children->isNotEmpty() , function () {return Child::collection($this->children);}),
        ];
    }
}
