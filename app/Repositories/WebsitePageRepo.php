<?php


namespace App\Repositories;

use App\Websitepage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class WebsitePageRepo
{
    /**
     * @param array $filters
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getWebsitePages(array $filters = []): Collection
    {
        $websitePages = Websitepage::query();
        self::filter($filters, $websitePages);
        return $websitePages->get();
    }

    /**
     * @param array $filters
     * @param       $websitePages
     */
    private static function filter(array $filters, Builder $websitePages): void
    {
        foreach ($filters as $key => $filter) {
            if (is_array($filter)) {
                $websitePages->WhereIn($key, $filter);
            } else {
                $websitePages->where($key, $filter);
            }
        }
    }
}
