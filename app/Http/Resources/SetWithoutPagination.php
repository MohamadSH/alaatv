<?php

namespace App\Http\Resources;

use App\Contentset;
use Illuminate\Http\Request;

/**
 * Class Set
 *
 * @mixin Contentset
 * */
class SetWithoutPagination extends AlaaJsonResourceWithoutPagination
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

        $activeContents = $this->getActiveContents2();

        return [
            'id'             => $this->id,
            'redirect_url'   => $this->when(isset($this->redirectUrl), $this->redirectUrl),
            'title'          => $this->when(isset($this->name), $this->name),
            'short_title'    => $this->when(isset($this->shortName), $this->shortName),
            'photo'          => $this->when(isset($this->photo), $this->photo),
//            'tags'                  => $this->when(isset($this->tags), $this->getTags()),
            'contents_count' => $this->activeContents->count(),
            'url'            => $this->when($this->hasUrl(), function () {
                return $this->hasUrl() ? new UrlForSet($this) : null;
            }),
            'author'         => $this->when(isset($this->author), function () {
                return $this->getAuthor();
            }),
            'contents'       => $this->when($activeContents->isNotEmpty(), function () use ($activeContents) {
                return $activeContents->isNotEmpty() ? ContentInSetWithoutPagination::collection($activeContents) : null;
            }),
            'created_at'     => $this->when(isset($this->created_at), function () {
                return $this->created_at->toDateTimeString();
            }),
            'updated_at'     => $this->when(isset($this->updated_at), function () {
                return $this->updated_at->toDateTimeString();
            }),
            'source'         => $this->when($this->sources->isNotEmpty(), function () {
                return $this->sources->isNotEmpty() ? Source::collection($this->sources) : null;
            }),
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
