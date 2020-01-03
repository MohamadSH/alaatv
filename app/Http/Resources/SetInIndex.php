<?php

namespace App\Http\Resources;

use App\Contentset;
use Illuminate\Http\Request;

class SetInIndex extends AlaaJsonResourceWithPagination
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
            'id'             => $this->id,
            'redirect_url'   => $this->when(isset($this->redirectUrl), $this->redirectUrl),
            'title'          => $this->when(isset($this->name), $this->name),
            'short_title'    => $this->when(isset($this->shortName), $this->shortName),
            'photo'          => $this->when(isset($this->photo), $this->photo),
            'url'            => $this->when($this->hasUrl(), $this->hasUrl() ? new UrlForSet($this) : null),
            'contents_count' => $this->activeContents->count(),
            'author'         => $this->when(isset($this->author), $this->getAuthor()),
            'contents'       => null,
            'created_at'     => $this->when(isset($this->created_at), $this->created_at),
            'updated_at'     => $this->when(isset($this->updated_at), $this->updated_at),
        ];
    }

    private function hasUrl()
    {
        return isset($this->show_url) || isset($this->api_url_v2);
    }

    private function getAuthor()
    {
        return new Author($this->author);
    }

    private function getTags()
    {
        return new Tag($this->tags);
    }
}
