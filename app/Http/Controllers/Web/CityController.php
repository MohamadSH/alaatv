<?php

namespace App\Http\Controllers\Web;

use App\City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::orderBy("name");
        
        $cityIds = Input::get("ids");
        if (strcmp(gettype($cityIds), "string") == 0) {
            $cityIds = json_decode($cityIds);
        }
        if (isset($cityIds)) {
            $cities = $cities->whereIn("id", $cityIds);
        }
        
        $provinceIds = Input::get("provinces");
        if (strcmp(gettype($provinceIds), "string") == 0) {
            $provinceIds = json_decode($provinceIds);
        }
        if (isset($provinceIds)) {
            $cities = $cities->whereIn("province_id", $provinceIds);
        }
        
        return $cities->get();
    }
}
