<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Arr;

class AlaaAnonymousResourceCollection extends ResourceCollection
{
    /**
     * The name of the resource being collected.
     *
     * @var string
     */
    public $collects;

    private $toResponse = false;

    /**
     * Create a new anonymous resource collection.
     *
     * @param mixed  $resource
     * @param string $collects
     *
     * @return void
     */
    public function __construct($resource, $collects)
    {
        $this->collects = $collects;

        parent::__construct($resource);
    }

    /**
     * Transform the resource into a JSON array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        if ($this->toResponse) {
            return [
                'data' => $this->collection,
                'meta' => [
                    'count' => $this->count(),
                ],
            ];
        }
        $paginate = [];
        if ($this->resource instanceof AbstractPaginator) {
            if ($this->preserveAllQueryParameters) {
                $this->resource->appends($request->query());
            } else if (!is_null($this->queryParameters)) {
                $this->resource->appends($this->queryParameters);
            }
            $paginate = $this->paginationInformation($request);
        }
        return array_merge([
            'data' => $this->collection,
        ], $paginate);
    }

    /**
     * Add the pagination information to the response.
     *
     * @param Request $request
     *
     * @return array
     */
    protected function paginationInformation($request)
    {
        $paginated = $this->resource->toArray();

        return [
            'links' => $this->paginationLinks($paginated),
            'meta'  => array_merge([
                'count' => $this->count(),
            ], $this->meta($paginated)),
        ];
    }

    /**
     * Get the pagination links for the response.
     *
     * @param array $paginated
     *
     * @return array
     */
    protected function paginationLinks($paginated)
    {
        return [
            'first' => $paginated['first_page_url'] ?? null,
            'last'  => $paginated['last_page_url'] ?? null,
            'prev'  => $paginated['prev_page_url'] ?? null,
            'next'  => $paginated['next_page_url'] ?? null,
        ];
    }

    /**
     * Gather the meta data for the response.
     *
     * @param array $paginated
     *
     * @return array
     */
    protected function meta($paginated)
    {
        return Arr::except($paginated, [
            'data',
            'first_page_url',
            'last_page_url',
            'prev_page_url',
            'next_page_url',
        ]);
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function toResponse($request)
    {
        $this->toResponse = true;
        return parent::toResponse($request);
    }
}
