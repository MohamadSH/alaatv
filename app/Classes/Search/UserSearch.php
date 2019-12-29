<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 11/10/2018
 * Time: 12:34 PM
 */

namespace App\Classes\Search;

use App\Classes\Search\{Filters\Tags, Tag\UserTagManagerViaApi};
use Illuminate\{Contracts\Pagination\LengthAwarePaginator, Database\Eloquent\Builder, Support\Facades\Cache};

class UserSearch extends SearchAbstract
{
    protected $model = "App\User";

    protected $pageName = 'userPage';

    protected $validFilters = [
        'firstName',
        'lastName',
        'mobile',
        'mobileVerified',
        'mobileNotVerified',
        'nationalCode',
        'mobileVerifiedCode',
        'mobileVerifiedAt',
        'phone',
        'email',
        'withoutEmail',
        'whatsapp',
        'skype',
        'userStatus',
        'lockProfile',
        'province',
        'withoutProvince',
        'city',
        'withoutCity',
        'address',
        'withAddress',
        'withoutAddress',
        'postalCode',
        'withoutPostalCode',
        'school',
        'withoutSchool',
        'major',
        'grade_id',
        'gender',
        'birthdate',
        'createdAtSince',
        'createdAtTill',
        'updatedAtSince',
        'updatedAtTill',
        'bio',
        'introducedBy',
        'bloodtype_id',
        'allergy',
        'medicalCondition',
        'diet',
        'techCode',
        'doesntHaveMajor',
        'hasRole',
        'hasCoupon',
        'doesntHaveCoupon',
        'hasTheseCoupon',
        'hasPaymentStatus',
        'hasOrderStatus',
        'hasOrderproductCheckoutStatus',
        'hasProduct',
        'doesntHaveOrder',
        'hasClosedOrder',
        'hasSeenSitePages',
    ];

    protected function apply(array $filters): LengthAwarePaginator
    {
        $this->pageNum = $this->setPageNum($filters);
        $key           = $this->makeCacheKey($filters);

        return Cache::tags(['user', 'user_search', 'search'])
            ->remember($key, $this->cacheTime, function () use ($filters) {
                $query = $this->applyDecoratorsFromFiltersArray($filters, $this->model->newQuery());

                return $this->getResults($query);
            });
    }

    protected function getResults(Builder $query)
    {
        $result = $query->orderBy("created_at", "desc")
            ->paginate($this->numberOfItemInEachPage, ['*'], $this->pageName, $this->pageNum);

        return $result;
    }

    /**
     * @param $decorator
     *
     * @return mixed
     */
    protected function setupDecorator($decorator)
    {
        $decorator = (new $decorator);
        if ($decorator instanceof Tags) {
            $decorator->setTagManager(new UserTagManagerViaApi());
        }

        return $decorator;
    }
}
