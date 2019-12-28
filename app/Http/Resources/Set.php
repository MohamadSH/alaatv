<?php

namespace App\Http\Resources;

use App\Contentset;
use Illuminate\Http\Request;

/**
 * Class Set
 *
 * @mixin Contentset
 * */
class Set extends AlaaJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof Contentset)) {
            return [];
        }
        if (isset($this->redirectUrl)) {
            return [
                'id'           => $this->id,
                'redirect_url' => $this->redirectUrl,
            ];
        }

        return [
            'id'                    => $this->id,
            'redirect_url'          => $this->when(isset($this->redirectUrl), $this->redirectUrl),
            'title'                 => $this->when(isset($this->name), $this->name),
            'short_title'           => $this->when(isset($this->shortName), $this->shortName),
            'photo'                 => $this->when(isset($this->photo), $this->photo),
            'tags'                  => $this->when(isset($this->tags), $this->getTags()),
            'contents_count'        => $this->contents_count,
            'active_contents_count' => $this->activeContents->count(),
            'url'                   => $this->when($this->hasUrl(), $this->hasUrl() ? new UrlForSet($this) : null),
            'author'                => $this->when(isset($this->author), $this->getAuthor()),
            'created_at'            => $this->when(isset($this->created_at), $this->created_at),
            'updated_at'            => $this->when(isset($this->updated_at), $this->updated_at),
        ];
    }

    private function hasUrl()
    {
        return isset($this->show_url) || isset($this->api_url_v2);
    }

    private function getTags()
    {
        return new Tag($this->tags);
    }

    private function getAuthor()
    {
        return new Author($this->author);
    }
}
