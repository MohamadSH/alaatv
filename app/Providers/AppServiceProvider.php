<?php

namespace App\Providers;


use App\Websitesetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        /**
         *  National code validation for registration form
         */
        Validator::extend('validate', function($attribute, $value, $parameters, $validator) {
            if(strcmp($parameters[0],"nationalCode")==0)
            {
                $flag = false;
                if (!preg_match('/^[0-9]{10}$/', $value))
                    $flag = false;

                for ($i = 0; $i < 10; $i++)
                    if (preg_match('/^' . $i . '{10}$/', $value))
                        $flag = false;

                for ($i = 0, $sum = 0; $i < 9; $i++)
                    $sum += ((10 - $i) * intval(substr($value, $i, 1)));

                $ret = $sum % 11;
                $parity = intval(substr($value, 9, 1));
                if (($ret < 2 && $ret == $parity) || ($ret >= 2 && $ret == 11 - $parity))
                    $flag = true;

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
            if(Schema::hasTable('websitesettings')) {
                $setting = Websitesetting::where("version" , 1)->get()->first();
                $wSetting = json_decode($setting->setting);
                view()->share('wSetting', $wSetting);
                view()->share('setting', $setting);
                if(isset($wSetting->site->name))
                    Config::set("constants.SITE_NAME" , $wSetting->site->name);
            }

            if(Schema::hasTable('bons')) {
                $myBone = \App\Bon::where("name",Config::get("constants.BON1"))->get();
                if($myBone->isNotEmpty())
                {
                    $bonName =$myBone->first()->displayName;
                    view()->share('bonName', $bonName);
                }
            }

            if(Schema::hasTable('orderstatuses')) {
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
                    if ($orderstatuses->where("name", "proceeding")->isNotEmpty())
                        Config::set("constants.ORDER_STATUS_PROCEEDING", $orderstatuses->where("name", "proceeding")->first()->id); // id = 8
                    if ($orderstatuses->where("name", "done")->isNotEmpty())
                        Config::set("constants.ORDER_STATUS_DONE", $orderstatuses->where("name", "done")->first()->id); // id = 9
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
                //                //=============================DISCOUNT TYPES
                if (Schema::hasTable('discounttypes'))
                {
                    $discounttypes = \App\Discounttype::all();
                    if($discounttypes->where("name" , "percentage")->isNotEmpty())
                        Config::set("constants.DISCOUNT_TYPE_PERCENTAGE" , $discounttypes->where("name" , "percentage")->first()->id);
                    if($discounttypes->where("name" , "cost")->isNotEmpty())
                        Config::set("constants.DISCOUNT_TYPE_COST" , $discounttypes->where("name" , "cost")->first()->id);
                }

            }


//            if(Schema::hasTable('products')) {
//                $sideBarProducts = Product::recentProducts(8)->get();
//                view()->share('sideBarProducts', $sideBarProducts);
//            }

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
        //
    }
}
