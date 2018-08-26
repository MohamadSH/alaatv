<?php

namespace App\Providers;


use App\{
    Adapter\AlaaSftpAdapter, Contentset, Contenttype, Product, Productfiletype, Traits\UserCommon, Verificationmessagestatus, Wallettype
};
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\{
    Auth, Config, Schema, Storage, Validator, View
};
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;
use League\Flysystem\Filesystem;

class AppServiceProvider extends ServiceProvider
{
    use UserCommon;
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Horizon::auth(function ($request) {
            if( Auth::check() && Auth::user()->hasRole("admin") ){
                return true;
            }
            else{
                return false;
            }
        });
        Schema::defaultStringLength(191);

        Storage::extend('sftp', function ($app, $config) {
            return new Filesystem(new AlaaSftpAdapter($config));
        });

        /**
         *  National code validation for registration form
         */
        Validator::extend('validate', function($attribute, $value, $parameters, $validator) {
            if(strcmp($parameters[0],"nationalCode")==0)
            {
                $flag = $this->validateNationalCode($value);
                return $flag;
            }
            return true;

        });

//        Validator::extend('without_spaces', function($attribute, $value  , $validator){
//            dd(preg_match('/^\S*$/u', $value));
//            return preg_match('/^\S*$/u', $value);
//        });

        //try catch For migration
        try {

            if(Schema::hasTable('bons')) {
                $myBone = \App\Bon::where("name",Config::get("constants.BON1"))->get();
                if($myBone->isNotEmpty())
                {
                    $bonName =$myBone->first()->displayName;
                    view()->share('bonName', $bonName);
                }
            }

            //================ORDER STATUSES CONSTANTS
            if (Schema::hasTable('orderstatuses')) {
                $orderstatuses = \App\Orderstatus::all();
                if ($orderstatuses->where("name", "open")->isNotEmpty())
                    Config::set("constants.ORDER_STATUS_OPEN", $orderstatuses->where("name", "open")->first()->id); // id = 1
                if ($orderstatuses->where("name", "closed")->isNotEmpty())
                    Config::set("constants.ORDER_STATUS_CLOSED", $orderstatuses->where("name", "closed")->first()->id); // id = 2
                if ($orderstatuses->where("name", "canceled")->isNotEmpty())
                    Config::set("constants.ORDER_STATUS_CANCELED", $orderstatuses->where("name", "canceled")->first()->id); // id = 3
                if ($orderstatuses->where("name", "openByAdmin")->isNotEmpty())
                    Config::set("constants.ORDER_STATUS_OPEN_BY_ADMIN", $orderstatuses->where("name", "openByAdmin")->first()->id); // id = 4
                if ($orderstatuses->where("name", "posted")->isNotEmpty())
                    Config::set("constants.ORDER_STATUS_POSTED", $orderstatuses->where("name", "posted")->first()->id); // id = 5
                if ($orderstatuses->where("name", "refunded")->isNotEmpty())
                    Config::set("constants.ORDER_STATUS_REFUNDED", $orderstatuses->where("name", "refunded")->first()->id); // id = 6
                if ($orderstatuses->where("name", "readyToPost")->isNotEmpty())
                    Config::set("constants.ORDER_STATUS_READY_TO_POST", $orderstatuses->where("name", "readyToPost")->first()->id); // id = 7
                if ($orderstatuses->where("name", "openDonate")->isNotEmpty())
                    Config::set("constants.ORDER_STATUS_OPEN_DONATE", $orderstatuses->where("name", "openDonate")->first()->id); // id = 8
                if ($orderstatuses->where("name", "pending")->isNotEmpty())
                    Config::set("constants.ORDER_STATUS_PENDING", $orderstatuses->where("name", "pending")->first()->id); // id = 9
            }

            //=================TRANSACTION STATUSES CONSTANTS
            if (Schema::hasTable('transactionstatuses')) {
                $transactionstatuses = \App\Transactionstatus::all();
                if ($transactionstatuses->where("name", "transferredToPay")->isNotEmpty())
                    Config::set("constants.TRANSACTION_STATUS_TRANSFERRED_TO_PAY", $transactionstatuses->where("name", "transferredToPay")->first()->id); // id = 1
                if ($transactionstatuses->where("name", "unsuccessful")->isNotEmpty())
                    Config::set("constants.TRANSACTION_STATUS_UNSUCCESSFUL", $transactionstatuses->where("name", "unsuccessful")->first()->id); // id = 2
                if ($transactionstatuses->where("name", "successful")->isNotEmpty())
                    Config::set("constants.TRANSACTION_STATUS_SUCCESSFUL", $transactionstatuses->where("name", "successful")->first()->id);// id = 3
                if ($transactionstatuses->where("name", "pending")->isNotEmpty())
                    Config::set("constants.TRANSACTION_STATUS_PENDING", $transactionstatuses->where("name", "pending")->first()->id);// id = 4
                if ($transactionstatuses->where("name", "archivedSuccessful")->isNotEmpty())
                    Config::set("constants.TRANSACTION_STATUS_ARCHIVED_SUCCESSFUL", $transactionstatuses->where("name", "archivedSuccessful")->first()->id);// id = 5
                if ($transactionstatuses->where("name", "unpaid")->isNotEmpty())
                    Config::set("constants.TRANSACTION_STATUS_UNPAID", $transactionstatuses->where("name", "unpaid")->first()->id);// id = 6
                if ($transactionstatuses->where("name", "suspended")->isNotEmpty())
                    Config::set("constants.TRANSACTION_STATUS_SUSPENDED", $transactionstatuses->where("name", "suspended")->first()->id);// id = 7
            }

            //=================PAYMENT METHODS CONSTANTS
            if (Schema::hasTable('paymentmethods')) {
                $paymentmethods = \App\Paymentmethod::all();
                if ($paymentmethods->where("name", "online")->isNotEmpty())
                    Config::set("constants.PAYMENT_METHOD_ONLINE", $paymentmethods->where("name", "online")->first()->id); // id = 1
                if ($paymentmethods->where("name", "ATM")->isNotEmpty())
                    Config::set("constants.PAYMENT_METHOD_ATM", $paymentmethods->where("name", "ATM")->first()->id); // id = 2
                if ($paymentmethods->where("name", "POS")->isNotEmpty())
                    Config::set("constants.PAYMENT_METHOD_POS", $paymentmethods->where("name", "POS")->first()->id);// id = 3
                if ($paymentmethods->where("name", "paycheck")->isNotEmpty())
                    Config::set("constants.PAYMENT_METHOD_PAYCHECK", $paymentmethods->where("name", "paycheck")->first()->id);// id = 4
                if ($paymentmethods->where("name", "wallet")->isNotEmpty())
                    Config::set("constants.PAYMENT_METHOD_WALLET", $paymentmethods->where("name", "wallet")->first()->id);// id = 5
            }

            //=====================PAYMENT STATUSES CONSTANTS
            if (Schema::hasTable('paymentstatuses')) {
                $paymentstatuses = \App\Paymentstatus::all();
                if ($paymentstatuses->where("name", "unpaid")->isNotEmpty())
                    Config::set("constants.PAYMENT_STATUS_UNPAID", $paymentstatuses->where("name", "unpaid")->first()->id);// id = 1
                if ($paymentstatuses->where("name", "indebted")->isNotEmpty())
                    Config::set("constants.PAYMENT_STATUS_INDEBTED", $paymentstatuses->where("name", "indebted")->first()->id);// id = 2
                if ($paymentstatuses->where("name", "paid")->isNotEmpty())
                    Config::set("constants.PAYMENT_STATUS_PAID", $paymentstatuses->where("name", "paid")->first()->id);// id = 3
            }

            //======================USER BON STATUSES CONSTANTS
            if (Schema::hasTable('userbonstatuses')) {
                $userbonstatuses = \App\Userbonstatus::all();
                if ($userbonstatuses->where("name", "active")->isNotEmpty())
                    Config::set("constants.USERBON_STATUS_ACTIVE", $userbonstatuses->where("name", "active")->first()->id);// id = 1
                if ($userbonstatuses->where("name", "expired")->isNotEmpty())
                    Config::set("constants.USERBON_STATUS_EXPIRED", $userbonstatuses->where("name", "expired")->first()->id);// id = 2
                if ($userbonstatuses->where("name", "used")->isNotEmpty())
                    Config::set("constants.USERBON_STATUS_USED", $userbonstatuses->where("name", "used")->first()->id);// id = 3
            }

            //======================PRODUCT TYPES CONSTANTS
            if (Schema::hasTable('producttypes')) {
                $producttypes = \App\Producttype::all();
                if ($producttypes->where("name", "simple")->isNotEmpty())
                    Config::set("constants.PRODUCT_TYPE_SIMPLE", $producttypes->where("name", "simple")->first()->id);// id = 1
                if ($producttypes->where("name", "configurable")->isNotEmpty())
                    Config::set("constants.PRODUCT_TYPE_CONFIGURABLE", $producttypes->where("name", "configurable")->first()->id);// id = 2
                if ($producttypes->where("name", "selectable")->isNotEmpty())
                    Config::set("constants.PRODUCT_TYPE_SELECTABLE", $producttypes->where("name", "selectable")->first()->id);// id = 3
            }
            //======================ROLE CONSTANTS
            if (Schema::hasTable('roles')) {
                $roles = \App\Role::all();
                if ($roles->where("name", "employee")->isNotEmpty())
                    Config::set("constants.ROLE_EMPLOYEE", $roles->where("name", "employee")->first()->id);
            }
            //======================CONTROLS CONSTANTS
            if (Schema::hasTable('attributecontrols')) {
                $controls = \App\Attributecontrol::all();
                if ($controls->where("name", "select")->isNotEmpty())
                    Config::set("constants.CONTROL_SELECT", $controls->where("name", "select")->first()->id);
                if ($controls->where("name", "groupedCheckbox")->isNotEmpty())
                    Config::set("constants.CONTROL_GROUPED_CHECKBOX", $controls->where("name", "groupedCheckbox")->first()->id);
                if ($controls->where("name", "switch")->isNotEmpty())
                    Config::set("constants.CONTROL_SWITCH", $controls->where("name", "switch")->first()->id);
            }
            //======================ORDERPRODUCT TYPES CONSTANTS
            if (Schema::hasTable('orderproducttypes'))
            {
                $orderproducttypes = \App\Orderproducttype::all();
                if($orderproducttypes->where("name" , "default")->isNotEmpty())
                    Config::set("constants.ORDER_PRODUCT_TYPE_DEFAULT" , $orderproducttypes->where("name" , "default")->first()->id);
                if($orderproducttypes->where("name" , "gift")->isNotEmpty())
                    Config::set("constants.ORDER_PRODUCT_GIFT" , $orderproducttypes->where("name" , "gift")->first()->id);
            }
//                //=============================ORDERPRODUCT INTERRELATIONS
            if (Schema::hasTable('orderproductinterrelations'))
            {
                $orderproducInterrelations = \App\Orderproductinterrelation::all();
                if($orderproducInterrelations->where("name" , "parent-child")->isNotEmpty())
                    Config::set("constants.ORDER_PRODUCT_INTERRELATION_PARENT_CHILD" , $orderproducInterrelations->where("name" , "parent-child")->first()->id);
            }
//                //=============================TRANSACTION INTERRELATIONS
            if (Schema::hasTable('transactioninterraltions'))
            {
                $transactionInterrelations = \App\Transactioninterraltion::all();
                if($transactionInterrelations->where("name" , "parent-child")->isNotEmpty())
                    Config::set("constants.TRANSACTION_INTERRELATION_PARENT_CHILD" , $transactionInterrelations->where("name" , "parent-child")->first()->id);
            }
//                //=============================PRODUCT INTERRELATIONS
            if (Schema::hasTable('productinterrelations'))
            {
                $productInterrelations = \App\Productinterrelation::all();
                if($productInterrelations->where("name" , "gift")->isNotEmpty())
                    Config::set("constants.PRODUCT_INTERRELATION_GIFT" , $productInterrelations->where("name" , "gift")->first()->id);
            }
//                //=============================DISCOUNT TYPES
            if (Schema::hasTable('discounttypes'))
            {
                $discounttypes = \App\Discounttype::all();
                if($discounttypes->where("name" , "percentage")->isNotEmpty())
                    Config::set("constants.DISCOUNT_TYPE_PERCENTAGE" , $discounttypes->where("name" , "percentage")->first()->id);
                if($discounttypes->where("name" , "cost")->isNotEmpty())
                    Config::set("constants.DISCOUNT_TYPE_COST" , $discounttypes->where("name" , "cost")->first()->id);
            }
//                =============================DISCOUNT TYPES
            if (Schema::hasTable('discounttypes'))
            {
                $discounttypes = \App\Discounttype::all();
                if($discounttypes->where("name" , "percentage")->isNotEmpty())
                    Config::set("constants.DISCOUNT_TYPE_PERCENTAGE" , $discounttypes->where("name" , "percentage")->first()->id);
                if($discounttypes->where("name" , "cost")->isNotEmpty())
                    Config::set("constants.DISCOUNT_TYPE_COST" , $discounttypes->where("name" , "cost")->first()->id);
            }
//                =============================PRODUCT FILE TYPES
            if (Schema::hasTable('productfiletypes'))
            {
                $productfiletypes = Productfiletype::all();
                if($productfiletypes->where("name" , "video")->isNotEmpty())
                    Config::set("constants.PRODUCT_FILE_TYPE_VIDEO" , $productfiletypes->where("name" , "video")->first()->id);
                if($productfiletypes->where("name" , "pamphlet")->isNotEmpty())
                    Config::set("constants.PRODUCT_FILE_TYPE_PAMPHLET" , $productfiletypes->where("name" , "pamphlet")->first()->id);
            }
//                =============================CONTENT TYPES
            if (Schema::hasTable('contenttypes'))
            {
                $contenttypes = Contenttype::all();
                if($contenttypes->where("name" , "pamphlet")->isNotEmpty())
                    Config::set("constants.CONTENT_TYPE_PAMPHLET" , $contenttypes->where("name" , "pamphlet")->first()->id);
                if($contenttypes->where("name" , "video")->isNotEmpty())
                    Config::set("constants.CONTENT_TYPE_VIDEO" , $contenttypes->where("name" , "video")->first()->id);
            }
//                =============================WALLET TYPES
            if (Schema::hasTable('wallettypes'))
            {
                $wallettypes = Wallettype::all();
                if($wallettypes->where("name" , "main")->isNotEmpty())
                    Config::set("constants.WALLET_TYPE_MAIN" , $wallettypes->where("name" , "main")->first()->id);
                if($wallettypes->where("name" , "gift")->isNotEmpty())
                    Config::set("constants.WALLET_TYPE_GIFT" , $wallettypes->where("name" , "gift")->first()->id);
            }
//                =============================VERIFICATION MESSAGE STATUSES
            if (Schema::hasTable('verificationmessagestatuses'))
            {
                $verificationmessagestatuses = Verificationmessagestatus::all();
                if($verificationmessagestatuses->where("name" , "sent")->isNotEmpty())
                    Config::set("constants.VERIFICATION_MESSAGE_STATUS_SENT" , $verificationmessagestatuses->where("name" , "sent")->first()->id);
                if($verificationmessagestatuses->where("name" , "successful")->isNotEmpty())
                    Config::set("constants.VERIFICATION_MESSAGE_STATUS_SUCCESSFUL" , $verificationmessagestatuses->where("name" , "successful")->first()->id);
                if($verificationmessagestatuses->where("name" , "notDelivered")->isNotEmpty())
                    Config::set("constants.VERIFICATION_MESSAGE_STATUS_NOT_DELIVERED" , $verificationmessagestatuses->where("name" , "notDelivered")->first()->id);
                if($verificationmessagestatuses->where("name" , "expired")->isNotEmpty())
                    Config::set("constants.VERIFICATION_MESSAGE_STATUS_EXPIRED" , $verificationmessagestatuses->where("name" , "expired")->first()->id);
            }

            if(Schema::hasTable('products'))
            {
                $donateProduct = Product::whereIn("id" , config("constants.DONATE_PRODUCT"))
                                            ->first();
                if(isset($donateProduct))
                    Config::set("constants.DONATE_PRODUCT_COST" , $donateProduct->basePrice);

            }

            /**
             *  lessons
             */
            $contentsetArary = [
                195 , 170 , 37 , 179 , 187 ,183,189,186,188,180,191,114,112,137,121,175,50,152,
                194 , 193 , 171 , 178 , 182 , 169 , 170 , 192,
                185 , 190 , 153 , 172 , 137 , 177 , 173 , 170 , 168 , 184 , 174,
                163 , 157 , 159 , 160 , 162 , 164 , 155 , 158
            ];

            $contentsets = Contentset::whereIn("id" , $contentsetArary)->get();
            $contentsets->load('contents');
            $sectionArray = [
                "konkoor" ,
                "dahom" ,
                "yazdahom"
            ];
            $sections = collect();
            foreach ($sectionArray as $section)
            {
                switch ($section)
                {
                    case "konkoor" :
                        $lessons = collect([
                            [
                                "displayName" => "زیست کنکور" ,
                                "author" => "ابوالفضل جعفری",
                                "pic" => $contentsets->where("id" , 195)->first()->photo,
                                "content_id"=>($contentsets->where("id" , 195)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 195)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "آرایه های ادبی" ,
                                "author" => "هامون سبطی",
                                "pic" => $contentsets->where("id" , 170)->first()->photo,
                                "content_id"=>($contentsets->where("id" , 170)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 170)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "مشاوره" ,
                                "author" => "محمد علی امینی راد",
                                "pic" => $contentsets->where("id" , 37)->first()->photo,
                                "content_id"=>($contentsets->where("id" , 37)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 37)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ] ,
                            [
                                "displayName" => "شیمی شب کنکور" ,
                                "author" => "مهدی صنیعی تهرانی",
                                "pic" => $contentsets->where("id" , 179)->first()->photo,
                                "content_id"=>($contentsets->where("id" , 179)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 179)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "نکته و تست فیزیک" ,
                                "author" => "پیمان طلوعی",
                                "pic" => $contentsets->where("id" , 187)->first()->photo,
                                "content_id"=>($contentsets->where("id" , 187)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 187)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "فیزیک 4 - کنکور" ,
                                "author" => "حمید فدایی فرد",
                                "pic" => $contentsets->where("id" , 183)->first()->photo,
                                "content_id"=>($contentsets->where("id" , 183)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 183)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "نکته و تست ریاضی تجربی" ,
                                "author" => "مهدی امینی راد",
                                "pic" => $contentsets->where("id" , 189)->first()->photo,
                                "content_id"=>($contentsets->where("id" , 189)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 189)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "ریاضی تجربی کنکور" ,
                                "author" => "محمد امین نباحته",
                                "pic" => $contentsets->where("id" , 186)->first()->photo,
                                "content_id"=>($contentsets->where("id" , 186)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 186)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "نکته و تست دیفرانسیل کنکور" ,
                                "author" => "محمد صادق ثابتی",
                                "pic" => $contentsets->where("id" , 188)->first()->photo,
                                "content_id"=>($contentsets->where("id" , 188)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 188)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "هندسه تحلیل کنکور" ,
                                "author" => "محمد صادق ثابتی",
                                "pic" => $contentsets->where("id" , 180)->first()->photo,
                                "content_id"=>($contentsets->where("id" , 180)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 180)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "فلسفه و منطق کنکور" ,
                                "author" => "سید حسام الدین جلالی",
                                "pic" => $contentsets->where("id" , 191)->first()->photo,
                                "content_id"=>($contentsets->where("id" , 191)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 191)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "تحلیلی کنکور" ,
                                "author" => "رضا شامیزاده",
                                "pic" => $contentsets->where("id" , 114)->first()->photo,
                                "content_id"=>($contentsets->where("id" , 114)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 114)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "گسسته کنکور" ,
                                "author" => "رضا شامیزاده",
                                "pic" => $contentsets->where("id" , 112)->first()->photo,
                                "content_id"=>($contentsets->where("id" , 112)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 112)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "هندسه پایه کنکور" ,
                                "author" => "وحید کبریایی",
                                "pic" => $contentsets->where("id" , 137)->first()->photo,
                                "content_id"=>($contentsets->where("id" , 137)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 137)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "ریاضی تجربی کنکور" ,
                                "author" => "محمد رضا حسینی فرد",
                                "pic" => $contentsets->where("id" , 121)->first()->photo,
                                "content_id"=>($contentsets->where("id" , 121)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 121)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "عربی کنکور" ,
                                "author" => "محسن آهویی",
                                "pic" => $contentsets->where("id" , 175)->first()->photo,
                                "content_id"=>($contentsets->where("id" , 175)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 175)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "زیست کنکور" ,
                                "author" => "محمد پازوکی",
                                "pic" => $contentsets->where("id" , 50)->first()->photo,
                                "content_id"=>($contentsets->where("id" , 50)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 50)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "آمار و مدلسازی کنکور" ,
                                "author" => "مهدی امینی راد",
                                "pic" => $contentsets->where("id" , 152)->first()->photo,
                                "content_id"=>($contentsets->where("id" , 152)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 152)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                        ]);
                        $sections->push(
                            [
                                "name"=>$section,
                                "displayName" => "کلاس های کنکور نظام قدیم آلاء",
                                "lessons" => $lessons ,
                                "tags" => [
                                    "کنکور"
                                ],
                                'ads' => [
                                    //SEBTI
//                                        'https://cdn.sanatisharif.ir/upload/ads/SMALL-SLIDE-1.jpg' => 'https://sanatisharif.ir/landing/4?utm_source=sanatisharif&utm_medium=banner&utm_campaign=khordad_sale&utm_content=small-slide-1-1',
                                ],
                                'class' =>'konkoor'
                            ]
                        );
                        break;
                    case "yazdahom" :
                        $lessons = collect([
                            [
                                "displayName" => "زیست یازدهم" ,
                                "author" => "عباس راستی بروجنی",
                                "pic" => $contentsets->where("id" , 194)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 194)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 194)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "فیزیک یازدهم" ,
                                "author" => "پیمان طلوعی",
                                "pic" => $contentsets->where("id" , 193)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 193)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 193)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "حسابان یازدهم" ,
                                "author" => "محمد صادق ثابتی",
                                "pic" => $contentsets->where("id" , 171)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 171)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 171)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "حسابان یازدهم" ,
                                "author" => "محمد رضا مقصودی",
                                "pic" => $contentsets->where("id" , 178)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 178)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 178)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "شیمی یازدهم" ,
                                "author" => "مهدی صنیعی تهرانی",
                                "pic" => $contentsets->where("id" , 182)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 182)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 182)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "ریاضی تجربی یازدهم" ,
                                "author" => "علی صدری",
                                "pic" => $contentsets->where("id" , 169)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 169)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 169)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "آرایه های ادبی" ,
                                "author" => "هامون سبطی",
                                "pic" => $contentsets->where("id" , 170)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 170)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 170)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "عربی یازدهم" ,
                                "author" => "ناصر حشمتی",
                                "pic" => $contentsets->where("id" , 192)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 192)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 192)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                        ]);
                        $sections->push(
                            [
                                "name"=>$section,
                                "displayName" => "مقطع یازدهم",
                                "lessons" => $lessons ,
                                "tags" => [
                                    "یازدهم"
                                ],
                                'ads' => [
                                    //ZIST GIAHI
//                                        'https://cdn.sanatisharif.ir/upload/ads/SMALL-SLIDE-2.jpg' => 'https://sanatisharif.ir/landing/4?utm_source=sanatisharif&utm_medium=banner&utm_campaign=khordad_sale&utm_content=small-slide-2',
                                ],
                                'class' =>'yazdahom'
                            ]
                        );
                        break;
                    case "dahom" :
                        $lessons = collect([
                            [
                                "displayName" => "متن خوانی عربی دهم" ,
                                "author" => "مهدی ناصر شریعت",
                                "pic" => $contentsets->where("id" , 185)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 185)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 185)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "ریاضی دهم" ,
                                "author" => "مهدی امینی راد",
                                "pic" => $contentsets->where("id" , 190)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 190)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 190)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "ریاضی دهم" ,
                                "author" => "محمد جواد نایب کبیر",
                                "pic" => $contentsets->where("id" , 153)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 153)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 153)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "شیمی دهم" ,
                                "author" => "حامد پویان نظر",
                                "pic" => $contentsets->where("id" , 172)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 172)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 172)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "هندسه 1 (دهم)" ,
                                "author" => "وحید کبریایی",
                                "pic" => $contentsets->where("id" , 137)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 137)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 137)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "زیست 1 (دهم)" ,
                                "author" => "جلال موقاری",
                                "pic" => $contentsets->where("id" , 177)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 177)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 177)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "فیزیک دهم" ,
                                "author" => "فرشید داداشی",
                                "pic" => $contentsets->where("id" , 173)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 173)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 173)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "آرایه های ادبی" ,
                                "author" => "هامون سبطی",
                                "pic" => $contentsets->where("id" , 170)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 170)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 170)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "زبان انگلیسی" ,
                                "author" => "علی اکبر عزتی",
                                "pic" => $contentsets->where("id" , 168)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 168)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 168)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "ریاضی و آمار دهم" ,
                                "author" => "مهدی امینی راد",
                                "pic" => $contentsets->where("id" , 184)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 184)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 184)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "عربی" ,
                                "author" => "ناصر حشمتی",
                                "pic" => $contentsets->where("id" , 174)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 174)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 174)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                        ]);
                        $sections->push(
                            [
                                "name"=>$section,
                                "displayName" => "مقطع دهم",
                                "lessons" => $lessons ,
                                "tags" => [
                                    "دهم"
                                ],
                                'ads' => [
                                    //DINI KAGHAZI
//                                        'https://cdn.sanatisharif.ir/upload/ads/SMALL-SLIDE-3.jpg' => 'https://sanatisharif.ir/landing/4?utm_source=sanatisharif&utm_medium=banner&utm_campaign=khordad_sale&utm_content=small-slide-3',
                                ],
                                'class' =>'dahom'
                            ]
                        );
                        break;
                    case "hamayesh" :
                        $lessons = collect([
                            [
                                "displayName" => "ریاضی انسانی" ,
                                "author" => "خسرو محمد زاده",
                                "pic" => $contentsets->where("id" , 163)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 163)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 163)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "گسسته" ,
                                "author" => "سروش معینی",
                                "pic" => $contentsets->where("id" , 157)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 157)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 157)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "فیزیک" ,
                                "author" => "نادریان",
                                "pic" => $contentsets->where("id" , 159)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 159)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 159)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "زیست شناسی" ,
                                "author" => "مسعود حدادی",
                                "pic" => $contentsets->where("id" , 160)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 160)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 160)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "دیفرانسیل" ,
                                "author" => "سیروس نصیری",
                                "pic" => $contentsets->where("id" , 162)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 162)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 162)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "ریاضی تجربی" ,
                                "author" => "سیروس نصیری",
                                "pic" => $contentsets->where("id" , 164)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 164)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 164)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "عربی" ,
                                "author" => "عمار تاج بخش",
                                "pic" => $contentsets->where("id" , 155)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 155)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 155)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                            [
                                "displayName" => "شیمی" ,
                                "author" => "محمد حسین انوشه",
                                "pic" => $contentsets->where("id" , 158)->first()->photo,
                                "content_id"=> ($contentsets->where("id" , 158)->first()->contents->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty())?$contentsets->where("id" , 158)->first()->contents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id:0
                            ],
                        ]);
                        $sections->push(
                            [
                                "name"=>$section,
                                "displayName" => "همایش و جمع بندی",
                                "lessons" => $lessons ,
                                "tags" => [
                                    "همایش"
                                ],
                                'ads' => [
                                    //DINI KAGHAZI
//                                        'https://cdn.sanatisharif.ir/upload/ads/SMALL-SLIDE-1.jpg' => 'https://sanatisharif.ir/landing/4?utm_source=sanatisharif&utm_medium=banner&utm_campaign=khordad_sale&utm_content=small-slide-1-1',
                                ],
                                'class' =>'hamayesh'
                            ]
                        );
                        break;
                    default:
                        break ;
                }
            }

            View::share('sections',$sections);

        } catch (QueryException $e) {
            return false;
        }

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

         if ($this->app->environment() !== 'production') {
             $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
             $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
         }
    }
}
