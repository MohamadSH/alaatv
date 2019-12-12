<?php

namespace App\Http\Controllers\Web;

use App\City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $cities = City::orderBy("name");

        $cityIds = $request->get("ids");
        if (strcmp(gettype($cityIds), "string") == 0) {
            $cityIds = json_decode($cityIds);
        }
        if (isset($cityIds)) {
            $cities = $cities->whereIn("id", $cityIds);
        }

        $provinceIds = $request->get("provinces");
        if (strcmp(gettype($provinceIds), "string") == 0) {
            $provinceIds = json_decode($provinceIds);
        }
        if (isset($provinceIds)) {
            $cities = $cities->whereIn("province_id", $provinceIds);
        }

        return $cities->get();
    }
}
