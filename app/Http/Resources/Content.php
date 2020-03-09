<?php

namespace App\Http\Resources;

use App\Traits\Content\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class Content
 *
 * @mixin \App\Content
 * */
class Content extends AlaaJsonResourceWithPagination
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

        $this->loadMissing('contenttype', 'section', 'user', 'set');

        return [
            'id'               => $this->id,
            'redirect_url'     => $this->when(isset($this->redirectUrl), $this->redirectUrl),
            'type'             => $this->when(isset($this->contenttype_id), function () {
                return $this->getType();
            }),
            'title'            => $this->when(isset($this->name), $this->name),
            'body'             => $this->getContentBody(),
            'tags'             => $this->when(isset($this->tags), function () {
                return $this->getTag();
            }),
            'file'             => $this->when($this->hasFile(), $this->getContentFile()),
            'duration'         => $this->when(isset($this->duration), $this->duration),
            'photo'            => $this->when(isset($this->thumbnail), $this->thumbnail),
            'is_free'           => $this->isFree,
            'order'            => $this->order,
            'page_view'        => $this->when(isset($this->page_view), $this->page_view),
            'created_at'       => $this->when(isset($this->created_at), function () {
                return optional($this->created_at)->toDateTimeString();
            }),
            'updated_at'       => $this->when(isset($this->updated_at), function () {
                return optional($this->updated_at)->toDateTimeString();
            }),
            'url'              => $this->getUrl($this),
            'previous_url'     => $this->when(!is_null($this->previous_content), function () {
                return $this->getUrl($this->previous_content);
            }),
            'next_url'         => $this->when(!is_null($this->next_content), function () {
                return $this->getUrl($this->next_content);
            }),
            'author'           => $this->when(isset($this->author_id), function () {
                return $this->getAuthor();
            }),
            'set'              => $this->when(isset($this->contentset_id), function () {
                return $this->getSetInContent();
            }),
            'related_product' => $this->getRelatedProducts(),
            'can_see' =>  $this->when(isset($this->canSeeContent) , isset($this->canSeeContent)?$this->canSeeContent:null),
//            'recommended_products' => $this->when($this->recommended_products->isNotEmpty(), $this->getRecommendedProducts()),
            'source'           => $this->when($this->sources->isNotEmpty(), function () {
                return $this->sources->isNotEmpty() ? Source::collection($this->sources) : null;
            }),

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

    private function getUrl($content)
    {
        return new Url($content);
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
        if(!$this->isFree){
            $relatedProduct = new ProductInBlockWithoutPagination(optional($this->activeProducts())->first());
        }else{
            $relatedProduct = optional($this->related_products)->first();
        }
        return $relatedProduct;
    }

    /**
     * @return mixed
     */
    private function getRecommendedProducts()
    {
        return $this->recommended_products->isNotEmpty() ? $this->recommended_products : null;
    }

    /**
     * @return string|null
     */
    private function getContentBody()
    {
        if ($this->isArticle()) {
            $body = $this->context;
        } else {
            $body = $this->description;
        }
        return $body;
    }
}
