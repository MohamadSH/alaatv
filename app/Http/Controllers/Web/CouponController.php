<?php

namespace App\Http\Controllers\Web;

use App\Coupon;
use App\Product;
use Carbon\Carbon;
use App\Coupontype;
use Illuminate\Http\Response;
use App\Http\Requests\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\EditCouponRequest;
use App\Http\Requests\InsertCouponRequest;

class CouponController extends Controller
{
    protected $response;
    
    function __construct()
    {
        $this->response = new Response();
        
        $this->middleware('permission:'.Config::get('constants.LIST_COUPON_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:'.Config::get('constants.INSERT_COUPON_ACCESS'),
            ['only' => 'create', 'store', 'generateRandomCoupon']);
        $this->middleware('permission:'.Config::get('constants.REMOVE_COUPON_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:'.Config::get('constants.SHOW_COUPON_ACCESS'), ['only' => 'edit']);
    }
    
    public function index()
    {
        $coupons = Coupon::all()
            ->sortByDesc("created_at");
        
        return view("coupon.index", compact('coupons'));
    }
    
    public function edit($coupon)
    {
        $limitStatus        = [
            0 => 'نامحدود',
            1 => 'محدود',
        ];
        $defaultLimitStatus = isset($coupon->usageLimit) ? 1 : 0;
        
        $products       = Product::pluck('name', 'id')
            ->toArray();
        $couponProducts = $coupon->products->pluck('id')
            ->toArray();
        $coupontype     = Coupontype::pluck('displayName', 'id');

        if (isset($coupon->validSince)) {
            $validSinceDate = Carbon::parse($coupon->validSince)
                ->format('Y-m-d');
            $validSinceTime = Carbon::parse($coupon->validSince)
                ->format('H:i');
        }

        if (isset($coupon->validUntil)) {
            $validUntilDate = Carbon::parse($coupon->validUntil)
                ->format('Y-m-d');
            $validUntilTime = Carbon::parse($coupon->validUntil)
                ->format('H:i');
        }
        
        return view('coupon.edit',
            compact('coupon', 'limitStatus', 'defaultLimitStatus', 'coupontype', 'products', 'couponProducts',
                'validSinceDate', 'validSinceTime',
                'validUntilDate', 'validUntilTime'));
    }
    
    public function update(EditCouponRequest $request, $coupon)
    {
        $coupon->fill($request->all());
    
        $coupon->validSince = $this->setValidSince($request);
        $coupon->validUntil = $this->getValidUntil($request);

        if ($request->get('limitStatus') === 0) {
            $coupon->usageLimit = null;
        }
        
        $coupon->discount = preg_replace('/\s+/', '', $coupon->discount);
        if (strlen($coupon->discount) == 0) {
            $coupon->discount = 0;
        }
    
        $coupon->enable = $request->has("enable") ? 1 : 0;
        
        $coupon->maxCost = preg_replace('/\s+/', '', $coupon->maxCost);
        if (strlen($coupon->maxCost) == 0) {
            $coupon->maxCost = null;
        }
        
        if ($coupon->update()) {
            $coupon->products()
                ->sync($request->get('products', []));
            session()->put("success", "اطلاعات کپن با موفقیت اصلاح شد");
        }
        else {
            session()->put("error", "خطای پایگاه داده.");
        }
        
        return redirect()->back();
    }
    
    public function destroy($coupon)
    {
        $coupon->delete();
        
        return redirect()->back();
    }
    
    /**
     * This method was made temporarily for a period of time in Dey 1398
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function generateRandomCoupon(Request $request)
    {
        try {
            $coupons = Coupon::all();
            
            do {
                $code = rand(10000, 99999);
            } while ($coupons->where("code", $code)
                ->isNotEmpty());
            
            $request->offsetSet("code", $code);
            if ($request->has("products") && !empty($request->gat("products"))) {
                $request->offsetSet("coupontype_id", 2);
            }
            else {
                $request->offsetSet("coupontype_id", 1);
            }
            
            if ($request->has("validSinceDate")) {
                $request->offsetSet("validSinceEnable", true);
                $request->offsetSet("validSince", $request->get("validSinceDate"));
                if ($request->has("validSinceTime")) {
                    $request->offsetSet("sinceTime", $request->get("validSinceTime"));
                }
            }
            
            if ($request->has("validTillDate")) {
                $request->offsetSet("validUntilEnable", true);
                $request->offsetSet("validUntil", $request->get("validTillDate"));
                if ($request->has("validTillTime")) {
                    $request->offsetSet("untilTime", $request->get("validTillTime"));
                }
            }
            
            $storeCouponRequest = new \App\Http\Requests\InsertCouponRequest();
            $storeCouponRequest->merge($request->all());
            $response = $this->store($storeCouponRequest);
            
            return $response;
        } catch (\Exception    $e) {
            $message = "unexpected error";
            
            return $this->response->setStatusCode(503)
                ->setContent([
                    "message" => $message,
                    "error"   => $e->getMessage(),
                    "line"    => $e->getLine(),
                    "file"    => $e->getFile(),
                ]);
        }
    }
    
    public function store(InsertCouponRequest $request)
    {
        $coupon = new Coupon();
        $coupon->fill($request->all());
        $coupon->validSince = $this->setValidSince($request);
    
        $coupon->validUntil = $this->getValidUntil($request);
        
        if ($request->get('limitStatus') === 0) {
            $coupon->usageLimit = null;
        }
        $coupon->discount = preg_replace('/\s+/', '', $coupon->discount);
        if (strlen($coupon->discount) == 0) {
            $coupon->discount = 0;
        }
    
        $coupon->enable = $request->has("enable") ? 1 : 0;
        
        $coupon->maxCost = preg_replace('/\s+/', '', $coupon->maxCost);
        if (strlen($coupon->maxCost) == 0) {
            $coupon->maxCost = null;
        }
    
        if (!$coupon->save()) {
            return $this->response->setStatusCode(503)
                ->setContent(["message" => "خطا در درج کد"]);
        }
        $coupon->products()
            ->sync($request->get('products', []));
    
        return $this->response->setStatusCode(200)
            ->setContent(["message" => "کد تخفیف با موفقیت درج شد", "id" => $coupon->id, "code" => $coupon->code]);
    }
    
    private function getValidUntil(EditCouponRequest $request)
    {
        if (!$request->has("validUntilEnable") || !$request->has("validUntil") || strlen($request->get("validUntil")) <= 0) {
            return null;
        }
        
        $validUntil = Carbon::parse($request->get("validUntil"))
            ->format('Y-m-d');
        $untilTime  = $request->get("untilTime");
        $untilTime  = strlen($untilTime) > 0 ? Carbon::parse($untilTime)
            ->format('H:i:s') : "00:00:00";
        
        return $validUntil." ".$untilTime;
    }
    
    private function setValidSince(EditCouponRequest $request)
    {
        if (!$request->has("validSinceEnable") || !$request->has("validSince") || strlen($request->get("validSince")) <= 0) {
            return null;
        }
        
        $validSince = Carbon::parse($request->get("validSince"))
            ->format('Y-m-d');
        $sinceTime  = $request->get("sinceTime");
        $sinceTime  = strlen($sinceTime) > 0 ? Carbon::parse($sinceTime)
            ->format('H:i:s') : "00:00:00";
        
        return $validSince." ".$sinceTime;
    }
}
