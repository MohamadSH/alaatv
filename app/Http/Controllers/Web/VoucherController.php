<?php

namespace App\Http\Controllers\Web;

use App\Gender;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\InsertVoucherRequest;
use App\Major;
use App\Order;
use App\Product;
use App\Traits\RequestCommon;
use App\Websitesetting;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Jenssegers\Agent\Agent;
use SEO;

class VoucherController extends Controller
{
    private $setting;

    public function __construct(Agent $agent, Websitesetting $setting)
    {
        $this->setting = $setting->setting;
        $authException = $this->getAuthExceptionArray($agent);
        $this->callMiddlewares($authException);
    }

    /**
     * @param Agent $agent
     *
     * @return array
     */
    private function getAuthExceptionArray(Agent $agent): array
    {
        $authException = ['show'];

        return $authException;
    }

    /**
     * @param array $authException
     */
    private function callMiddlewares(array $authException): void
    {
        $this->middleware('auth', ['except' => $authException]);
        $this->middleware('permission:' . config('constants.LIST_USER_ACCESS') . "|" . config('constants.GET_BOOK_SELL_REPORT') . "|" . config('constants.GET_USER_REPORT'),
            ['only' => 'index']);
        $this->middleware('permission:' . config('constants.INSERT_USER_ACCESS'), ['only' => 'create']);
        $this->middleware('permission:' . config('constants.REMOVE_USER_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:' . config('constants.SHOW_USER_ACCESS'), ['only' => 'edit']);
    }

    /**
     * Submit user request for voucher request
     *
     * @param Request $request
     *
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function voucherRequest(Request $request)
    {
        return redirect(route('web.index'), Response::HTTP_FOUND);

        $url   = $request->url();
        $title = "آلاء| درخواست اینترنت آسیاتک";
        SEO::setTitle($title);
        SEO::opengraph()
            ->setUrl($url);
        SEO::setCanonical($url);
        SEO::twitter()
            ->setSite("آلاء");
        SEO::setDescription($this->setting->site->seo->homepage->metaDescription);
        SEO::opengraph()
            ->addImage(route('image', [
                'category' => '11',
                'w'        => '100',
                'h'        => '100',
                'filename' => $this->setting->site->siteLogo,
            ]), [
                'height' => 100,
                'width'  => 100,
            ]);

        $user        = $request->user();
        $genders     = Gender::pluck('name', 'id')
            ->prepend("انتخاب کنید");
        $majors      = Major::pluck('name', 'id')
            ->prepend("انتخاب کنید");
        $sideBarMode = "closed";

        $asiatechProduct   = config("constants.ASIATECH_FREE_ADSL");
        $nowDateTime       = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now('Asia/Tehran'));
        $userHasRegistered = false;

        $asitechPendingOrders     = Order::whereHas("orderproducts", function ($q) use ($asiatechProduct) {
            $q->where("product_id", $asiatechProduct);
        })
            ->where("orderstatus_id", config("constants.ORDER_STATUS_PENDING"))
            ->where("paymentstatus_id",
                config("constants.PAYMENT_STATUS_PAID"))
            ->orderBy("completed_at")
            ->get();
        $userAsitechPendingOrders = $asitechPendingOrders->where("user_id", $user->id);
        $rank                     = 0;
        if ($userAsitechPendingOrders->isNotEmpty()) {
            $rank = $userAsitechPendingOrders->keys()
                    ->first() + 1;

            $userHasRegistered = true;
        } else {
            $asitechApprovedOrders = $user->orders()
                ->whereHas("orderproducts", function ($q) use ($asiatechProduct) {
                    $q->where("product_id", $asiatechProduct);
                })
                ->where("orderstatus_id", config("constants.ORDER_STATUS_CLOSED"))
                ->where("paymentstatus_id",
                    config("constants.PAYMENT_STATUS_PAID"))
                ->orderBy("completed_at")
                ->get();
            if ($asitechApprovedOrders->isNotEmpty()) {
                $userVoucher = $user->productvouchers->where("expirationdatetime", ">", $nowDateTime)
                    ->where("product_id", $asiatechProduct)
                    ->first();

                $userHasRegistered = true;
            }
        }
        $mobileVerificationCode = $user->getMobileVerificationCode();

        return view("user.submitVoucherRequest",
            compact("user", "genders", "majors", "sideBarMode", "userHasRegistered", "rank", "userVoucher",
                "mobileVerificationCode"));
    }

    /**
     * Submit user request for voucher request
     *
     * @param InsertVoucherRequest InsertVoucherRequest
     *
     * @return Response
     * @throws FileNotFoundException
     */
    public function submitVoucherRequest(InsertVoucherRequest $request)
    {
        $asiatechProduct = config("constants.ASIATECH_FREE_ADSL");
        $user            = $request->user();
        $nowDateTime     = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now('Asia/Tehran'));
        $vouchers        = $user->productvouchers->where("expirationdatetime", ">", $nowDateTime)
            ->where("product_id", $asiatechProduct);
        if ($vouchers->isNotEmpty()) {
            session()->put("error", "شما برای اینترنت رایگان ثبت نام کرده اید");

            return redirect()->back();
        }

        $updateRequest = new EditUserRequest();
        RequestCommon::convertRequestToAjax($updateRequest);
        $updateRequest->offsetSet("postalCode", $request->get("postalCode"));
        $updateRequest->offsetSet("email", $request->get("email"));
        $updateRequest->offsetSet("gender_id", $request->get("gender_id"));
        $updateRequest->offsetSet("province", $request->get("province"));
        $updateRequest->offsetSet("city", $request->get("city"));
        $updateRequest->offsetSet("address", $request->get("address"));
        if ($user->hasVerifiedMobile()) {
            $updateRequest->offsetSet("mobileNumberVerification", 1);
        }
        $birthdate = Carbon::parse($request->get("birthdate"))
            ->setTimezone("Asia/Tehran")
            ->format('Y-m-d');
        $updateRequest->offsetSet("birthdate", $birthdate);
        $updateRequest->offsetSet("school", $request->get("school"));
        $updateRequest->offsetSet("major_id", $request->get("major_id"));
        $updateRequest->offsetSet("introducedBy", $request->get("introducedBy"));
        $response          = $this->update($updateRequest, $user);
        $completionColumns = [
            "firstName",
            "lastName",
            "mobile",
            "nationalCode",
            "province",
            "city",
            "address",
            "postalCode",
            "gender_id",
            "birthdate",
            "school",
            "major_id",
            "introducedBy",
            "mobile_verified_at",
            "photo",
        ];
        if ($response->getStatusCode() != Response::HTTP_OK) {
            return $this->sessionPutAndRedirectBack("مشکل غیر منتظره ای در ذخیره اطلاعات شما پیش آمد . لطفا مجددا اقدام نمایید");
        }
        if ($user->completion("custom", $completionColumns) < 100) {
            return $this->sessionPutAndRedirectBack("اطلاعات شما ذخیره شد اما برای ثبت درخواست اینترنت رایگان آسیاتک کامل نمی باشند . لطفا اطلاعات خود را تکمیل نمایید.");
        }
        $asiatechOrder                    = new Order();
        $asiatechOrder->orderstatus_id    = config("constants.ORDER_STATUS_PENDING");
        $asiatechOrder->paymentstatus_id  = config("constants.PAYMENT_STATUS_PAID");
        $asiatechOrder->cost              = 0;
        $asiatechOrder->costwithoutcoupon = 0;
        $asiatechOrder->user_id           = $user->id;
        $asiatechOrder->completed_at      = Carbon::now()
            ->setTimezone("Asia/Tehran");

        if (!$asiatechOrder->save()) {
            return $this->sessionPutAndRedirectBack("خطا در ثبت سفارش اینترنت رایگان. لطفا بعدا اقدام نمایید");
        }

        $request->offsetSet("cost", 0);
        $request->offsetSet("orderId_bhrk", $asiatechOrder->id);
        $product = Product::where("id", $asiatechProduct)
            ->first();
        if (!isset($product)) {
            return $this->sessionPutAndRedirectBack("محصول اینترنت آسیاتک یافت نشد");
        }

        $orderController = new OrderController();
        $response        = $orderController->addOrderproduct($request, $product);
        $responseStatus  = $response->getStatusCode();
        $result          = json_decode($response->getContent());
        if ($responseStatus != Response::HTTP_OK) {
            return $this->sessionPutAndRedirectBack("خطا در ثبت محصول اینرنت رایگان آسیاتک");
        }
        $user->lockHisProfile();
        $user->update();

        return redirect()->back();
    }

    /**
     * @param $message
     *
     * @return RedirectResponse
     */
    private function sessionPutAndRedirectBack($message)
    {
        session()->put("error", $message);
        return redirect()->back();
    }

}
