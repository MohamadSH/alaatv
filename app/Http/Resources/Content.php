<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Content
 *
 * @mixin \App\Content
 * */
class Content extends JsonResource
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
        if (!($this->resource instanceof \App\Content)) {
            return [
            
            ];
        }
        $file                   = $this->file;
        $videoFileCollection    = $file->get('video');
        $pamphletFileCollection = $file->get('pamphlet');
        return [
            'id'             => $this->id,
            'contenttype_id' => $this->contenttype_id,
            'name'           => $this->name,
            'description'    => $this->description,
            'tags'           => $this->tags,
            'context'        => $this->context,
            'file'           => [
                'video'    => isset($videoFileCollection) ? VideoFile::collection($videoFileCollection) : null,
                'pamphlet' => isset($pamphletFileCollection) ? PamphletFile::collection($pamphletFileCollection)
                    : null,
            ],
            'duration'       => $this->duration,
            'photo'          => $this->thumbnail,
            'isFree'         => $this->isFree,
            'order'          => $this->order,
            'page_view'      => $this->page_view,
            'url'            => [
                'previous' => [
                    'web' => $this->previousUrl,
                    'api' => $this->previousApiUrl,
                ],
                'current'  => [
                    'web' => $this->url,
                    'api' => $this->apiUrl,
                ],
                'next'     => [
                    'web' => $this->nextUrl,
                    'api' => $this->nextApiUrl,
                ],
            ],
            'author'         => new User($this->author),
            'set'            => new Set($this->whenLoaded('set')),
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
        ];
    }
}
