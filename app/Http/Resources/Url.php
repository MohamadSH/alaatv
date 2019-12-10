<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Url extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        if(!isset($this->url) || !isset($this->api_url_v2)){
            return [];
        }

        return [
            'web' => $this->when(isset($this->url) , $this->url),
            'api' => $this->when(isset($this->api_url_v2) , $this->api_url_v2)
        ];
    }
}
