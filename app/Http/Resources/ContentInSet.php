<?php

namespace App\Http\Resources;

use App\Traits\Content\Resource;
use Illuminate\Http\Request;

/**
 * Class Content
 *
 * @mixin \App\Content
 * */
class ContentInSet extends AlaaJsonResourceWithPagination
{
    use Resource;

    function __construct(\App\Content $model)
    {
        parent::__construct($model);
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\Content)) {
            return [];
        }

        $this->loadMissing('contenttype', 'section', 'user', 'set');

        return [
            'id'           => $this->id,
            'redirect_url' => $this->when(isset($this->redirectUrl), $this->redirectUrl),
            'type'         => $this->when(isset($this->contenttype_id), $this->getType()),
            'section'      => $this->when(isset($this->section_id), function () {
                return New Section($this->section);
            }),
            'title'        => $this->when(isset($this->name), $this->name),
            'duration'     => $this->when(isset($this->duration), $this->duration),
            'photo'        => $this->when(isset($this->thumbnail), $this->thumbnail),
            'isFree'       => $this->isFree,
            'updated_at'       => $this->when(isset($this->updated_at), function () {
                return $this->updated_at;
            }),
            'order'        => $this->order,
            'url'          => new Url($this),
        ];
    }

    private function getType()
    {
//        return New Contenttype($this->contenttype);
        return $this->contenttype_id;
    }
}
