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
        if(!isset($this->url) || !isset($this->api_url)){
            return [];
        }

        return [
            'web' => $this->when(isset($this->url) , $this->url),
            'api' => [
                'v1' => $this->when(isset($this->api_url_v1) , $this->api_url_v1),
                'v2' => $this->when(isset($this->api_url_v2) , $this->api_url_v2),
            ]
        ];
    }
}
