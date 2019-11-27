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
            return [];
        }

        $file                   = $this->file;
        $videoFileCollection    = $file->get('video');
        $pamphletFileCollection = $file->get('pamphlet');
        return [
            'id'             => $this->id,
            'redirectUrl'    => $this->redirectUrl,
            'contenttype_id' => $this->contenttype_id,
            'section_id'     => $this->section_id,
            'name'           => $this->name,
            'description'    => $this->description,
            'tags'           => $this->tags,
            'context'        => $this->context,
            'file'           => [
                'video'    => isset($videoFileCollection) ? VideoFile::collection($videoFileCollection) : null,
                'pamphlet' => isset($pamphletFileCollection) ? PamphletFile::collection($pamphletFileCollection) : null,
            ],
            'duration'       => $this->duration,
            'thumbnail'      => $this->thumbnail,
            'isFree'         => $this->isFree,
            'order'          => $this->order,
            'page_view'      => $this->page_view,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
            'url'            => [
                'previous' => [
                    'web' => $this->previous_url,
                    'api' => $this->previous_api_url,
                ],
                'current'  => [
                    'web' => $this->url,
                    'api' => $this->api_url,
                ],
                'next'     => [
                    'web' => $this->next_url,
                    'api' => $this->next_api_url,
                ],
            ],
            'author'         => new Author($this->author),
            'set'            => new Set($this->set),
        ];
    }
}
