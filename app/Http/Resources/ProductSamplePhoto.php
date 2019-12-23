<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class ProductSamplePhoto extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title'         => $this->when(isset($this->title) && strlen($this->title)>0  ,  $this->title ),
            'photo'           => $this->when(isset($this->url) && strlen($this->url)>0  ,  $this->url ) ,
        ];
    }
}
