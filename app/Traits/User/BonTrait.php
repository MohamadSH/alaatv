<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2019-02-15
 * Time: 16:30
 */

namespace App\Traits\User;


use App\Bon;
use App\User;
use App\Userbon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

trait BonTrait
{
    /**
     * returns user valid bons of the specified bons
     *
     * @param \app\Bon $bon
     * @param User     $user
     *
     * @return  \Illuminate\Database\Eloquent\Collection a collection of user valid bons of specified bon
     */
    public function userValidBons(Bon $bon)
    {
        $key = "user:userValidBons:" . $this->cacheKey() . "-" . (isset($bon) ? $bon->cacheKey() : "");

        return Cache::tags('bon')
                    ->remember($key, config("constants.CACHE_60"), function () use ($bon) {
                        return Userbon::where("user_id", $this->id)
                                      ->where("bon_id", $bon->id)
                                      ->where("userbonstatus_id", config("constants.USERBON_STATUS_ACTIVE"))
                                      ->whereColumn('totalNumber', '>', 'usedNumber')
                                      ->where(function ($query) {
                                          /** @var QueryBuilder $query */
                                          $query->whereNull("validSince")
                                                ->orwhere("validSince", "<", Carbon::now());
                                      })
                                      ->where(function ($query) {
                                          /** @var QueryBuilder $query */
                                          $query->whereNull("validUntil")
                                                ->orwhere("validUntil", ">", Carbon::now());
                                      })
                                      ->get();
                    });

    }

    /**
     * @param string $bonName
     *
     * @return int
     */
    public function userHasBon($bonName = null): int
    {
        if (is_null($bonName))
            $bonName = config("constants.BON1");
        $key = "user:userHasBon:" . $this->cacheKey() . "-" . $bonName;

        return Cache::tags('bon')
                    ->remember($key, config("constants.CACHE_60"), function () use ($bonName) {

                        $bon = Bon::all()
                                  ->where('name', $bonName)
                                  ->where('isEnable', '=', 1);
                        if ($bon->isEmpty())
                            return false;
                        /** @var Userbon $userbons */
                        $userbons = $this->userbons
                            ->where("bon_id", $bon->first()->id)
                            ->where("userbonstatus_id", config("constants.USERBON_STATUS_ACTIVE"));
                        $totalBonNumber = 0;
                        foreach ($userbons as $userbon) {
                            $totalBonNumber = $totalBonNumber + $userbon->validateBon();
                        }
                        return $totalBonNumber;

                    });

    }

    public function userbons()
    {
        return $this->hasMany('\App\Userbon');
    }
}