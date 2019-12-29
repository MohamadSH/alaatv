<?php

namespace App\Http\Resources;

use App\Traits\Content\Resource;
use Illuminate\Http\Request;

/**
 * Class Content
 *
 * @mixin \App\Content
 * */
class Content extends AlaaJsonResource
{
    use Resource;

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
        if (isset($this->redirectUrl)) {
            return [
                'id'           => $this->id,
                'redirect_url' => $this->redirectUrl,
            ];
        }

        $this->loadMissing('contenttype', 'section', 'user', 'set');

        if ($this->contenttype_id == config('constants.CONTENT_TYPE_ARTICLE')) {
            $body = $this->context;
        } else {
            $body = $this->description;
        }

        return [
            'id'                   => $this->id,
            'redirect_url'         => $this->when(isset($this->redirectUrl), $this->redirectUrl),
            'type'                 => $this->when(isset($this->contenttype_id), $this->getType()),
            'title'                => $this->when(isset($this->name), $this->name),
            'body'                 => $body,
            'tags'                 => $this->when(isset($this->tags), $this->getTag()),
            'file'                 => $this->when($this->hasFile(), $this->getContentFile()),
            'duration'             => $this->when(isset($this->duration), $this->duration),
            'photo'                => $this->when(isset($this->thumbnail), $this->thumbnail),
            'isFree'               => $this->isFree,
            'order'                => $this->order,
            'page_view'            => $this->when(isset($this->page_view), $this->page_view),
            'created_at'           => $this->when(isset($this->created_at), $this->created_at),
            'updated_at'           => $this->when(isset($this->updated_at), $this->updated_at),
            'url'                  => new Url($this),
            'previous_url'         => $this->when(!is_null($this->previous_content), $this->getUrl($this->previous_content)),
            'next_url'             => $this->when(!is_null($this->next_content), $this->getUrl($this->next_content)),
            'author'               => $this->when(isset($this->author_id), $this->getAuthor()),
            'set'                  => $this->when(isset($this->contentset_id), $this->getSetInContent()),
            'related_products'     => $this->when($this->related_products->isNotEmpty(), $this->getRelatedProducts()),
            'recommended_products' => $this->when($this->recommended_products->isNotEmpty(), $this->getRecommendedProducts()),
        ];
    }


    private function getType()
    {
//        return New Contenttype($this->contenttype);
        return $this->contenttype_id;
    }

    private function getTag()
    {
        return new Tag($this->tags);
    }

    private function getUrl($url)
    {
        return new Url($url);
    }

    private function getAuthor()
    {
        return new Author($this->user);
    }

    private function getSetInContent()
    {
        return new SetInContent($this->set);
    }

    private function getRelatedProducts()
    {
        return $this->related_products->isNotEmpty() ? $this->related_products : null;
    }

    /**
     * @return mixed
     */
    private function getRecommendedProducts()
    {
        return $this->recommended_products->isNotEmpty() ? $this->recommended_products : null;
    }
}
