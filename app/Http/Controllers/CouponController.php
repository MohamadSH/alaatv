<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Coupontype;
use App\Http\Requests\EditCouponRequest;
use App\Http\Requests\InsertCouponRequest;
use App\Product;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class CouponController extends Controller
{
    protected $helper ;
    protected $response ;

    function __construct()
    {
        $this->helper = new Helper();
        $this->response = new Response();

        $this->middleware('permission:'.Config::get('constants.LIST_COUPON_ACCESS'),['only'=>'index']);
        $this->middleware('permission:'.Config::get('constants.INSERT_COUPON_ACCESS'),['only'=>'create']);
        $this->middleware('permission:'.Config::get('constants.REMOVE_COUPON_ACCESS'),['only'=>'destroy']);
        $this->middleware('permission:'.Config::get('constants.SHOW_COUPON_ACCESS'),['only'=>'edit']);
    }

    public function index()
    {
        $coupons = Coupon::all()->sortByDesc("created_at");
        return view("coupon.index", compact('coupons' ));
    }

    public function show(){

    }

    public function create(){

    }

    public function store(InsertCouponRequest $request){
        $coupon = new Coupon();
        $coupon->fill($request->all());
        if($request->has("validSinceEnable")) {
            if ($request->has("validSince") && strlen($request->get("validSince")) > 0) {
                $validSince = Carbon::parse($request->get("validSince"))->format('Y-m-d');
                $sinceTime = $request->get("sinceTime");
                if (strlen($sinceTime) > 0) $sinceTime = Carbon::parse($sinceTime)->format('H:i:s');
                else $sinceTime = "00:00:00";

                $validSince = $validSince . " " . $sinceTime;
                $coupon->validSince = $validSince;
            } else {
                $coupon->validSince = null;
            }
        }
        else{
                $coupon->validSince = null;
        }


        if($request->has("validUntilEnable")) {
                if($request->has("validUntil")  && strlen($request->get("validUntil")) > 0) {
                $validUntil = Carbon::parse($request->get("validUntil"))->format('Y-m-d');
                $untilTime = $request->get("untilTime");
                if (strlen($untilTime) > 0) $untilTime = Carbon::parse($untilTime)->format('H:i:s');
                else $untilTime = "00:00:00";

                $validUntil = $validUntil . " " . $untilTime;
                $coupon->validUntil = $validUntil;
                }
                else{
                    $coupon->validUntil = null;
                }
        }
        else{
            $coupon->validUntil = null;
        }

        if ($request->get('limitStatus') == 0){
            $coupon->usageLimit = null;
        }
        $coupon->discount =  preg_replace('/\s+/', '', $coupon->discount);
        if(strlen($coupon->discount) == 0) $coupon->discount = 0;

        if($request->has("enable")) $coupon->enable = 1;
        else $coupon->enable = 0;

        $coupon->maxCost =  preg_replace('/\s+/', '', $coupon->maxCost);
        if(strlen($coupon->maxCost) == 0) $coupon->maxCost = null;

        if ($coupon->save()) {
            $coupon->products()->sync($request->get('products', []));
            return $this->response->setStatusCode(200)->setContent(["id"=>$coupon->id]);
        }
        else{
            return $this->response->setStatusCode(503);
        }
    }

    public function edit($coupon)
    {
        $limitStatus = [
            0 => 'نامحدود',
            1 => 'محدود'
        ];
        if (isset($coupon->usageLimit)) {
            $defaultLimitStatus = 1;
        } else {
            $defaultLimitStatus = 0;
        }

        $products = Product::pluck('name', 'id')->toArray();
        $couponProducts = $coupon->products->pluck('id')->toArray();
        $coupontype = Coupontype::pluck('displayName', 'id');

        if (isset($coupon->validSince)) {
            $validSinceDate = Carbon::parse($coupon->validSince)->format('Y-m-d');
            $validSinceTime = Carbon::parse($coupon->validSince)->format('H:i');
        }
        if (isset($coupon->validUntil))
        {
            $validUntilDate = Carbon::parse($coupon->validUntil)->format('Y-m-d');
            $validUntilTime = Carbon::parse($coupon->validUntil)->format('H:i');
        }

        return view('coupon.edit', compact('coupon', 'limitStatus', 'defaultLimitStatus', 'coupontype', 'products' , 'couponProducts' , 'validSinceDate' , 'validSinceTime' , 'validUntilDate' , 'validUntilTime'));
    }

    public function update(EditCouponRequest $request, $coupon)
    {
        $coupon->fill($request->all());

        if($request->has("validSinceEnable")) {
            if ($request->has("validSince") && strlen($request->get("validSince")) > 0) {
                $validSince = Carbon::parse($request->get("validSince"))->format('Y-m-d');
                $sinceTime = $request->get("sinceTime");
                if (strlen($sinceTime) > 0) $sinceTime = Carbon::parse($sinceTime)->format('H:i:s');
                else $sinceTime = "00:00:00";

                $validSince = $validSince . " " . $sinceTime;
                $coupon->validSince = $validSince;
            } else {
                $coupon->validSince = null;
            }
        }else{
            $coupon->validSince = null;
        }

        if($request->has("validUntilEnable")) {
            if ($request->has("validUntil") && strlen($request->get("validUntil")) > 0) {
                $validUntil = Carbon::parse($request->get("validUntil"))->format('Y-m-d');
                $untilTime = $request->get("untilTime");
                if (strlen($untilTime) > 0) $untilTime = Carbon::parse($untilTime)->format('H:i:s');
                else $untilTime = "00:00:00";

                $validUntil = $validUntil . " " . $untilTime;
                $coupon->validUntil = $validUntil;
            } else {
                $coupon->validUntil = null;
            }
        }else{
            $coupon->validUntil = null;
        }

        if ($request->get('limitStatus') == 0){
            $coupon->usageLimit = null;
        }

        $coupon->discount =  preg_replace('/\s+/', '', $coupon->discount);
        if(strlen($coupon->discount) == 0) $coupon->discount = 0;

        if($request->has("enable")) $coupon->enable = 1;
        else $coupon->enable = 0;

        $coupon->maxCost =  preg_replace('/\s+/', '', $coupon->maxCost);
        if(strlen($coupon->maxCost) == 0) $coupon->maxCost = null;

        if ($coupon->update()) {
            $coupon->products()->sync($request->get('products', []));
            session()->put("success", "اطلاعات کپن با موفقیت اصلاح شد");
        } else {
            session()->put("error", "خطای پایگاه داده.");
        }
        return redirect()->back();
    }

    public function destroy($coupon){
        $coupon->delete();
        return redirect()->back() ;
    }
}
