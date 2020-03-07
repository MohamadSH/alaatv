<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IntroVideoOfProduct extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = $this->resource;
        return [
            'intro' =>  [
                'video' => $this->when(isset($resource->intro_video) , function () use ($resource){
                    return $resource->intro_video??null;
                }),
                'photo' => $this->when(isset($resource->intro_video_thumbnail) , function () use ($resource){
                    return $resource->intro_video_thumbnail??null;
                }),
            ]
        ];
    }
}
