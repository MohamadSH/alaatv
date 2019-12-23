<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UrlForSet extends JsonResource
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
        return [
            'web' => $this->when(isset($this->show_url) , $this->show_url),
            'api' => $this->when(isset($this->api_url_v2) , $this->api_url_v2)
        ];
    }}
