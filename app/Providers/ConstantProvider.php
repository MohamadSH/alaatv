<?php

namespace App\Providers;

use App\{Block,
    Classes\Format\webBlockCollectionFormatter,
    Classes\Format\webSetCollectionFormatter,
    Contenttype,
    Product,
    Productfiletype,
    Wallettype};
use Illuminate\{Database\QueryException, Support\Facades\Config, Support\Facades\View, Support\ServiceProvider};

class ConstantProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //try catch For migration
        try {

            $myBone = \App\Bon::where("name", Config::get("constants.BON1"))
                              ->get();
            if ($myBone->isNotEmpty()) {
                $bonName = $myBone->first()->displayName;
                view()->share('bonName', $bonName);
            }

            //================ORDER STATUSES CONSTANTS
            $orderstatuses = \App\Orderstatus::all();
            if ($orderstatuses->where("name", "open")
                              ->isNotEmpty())
                Config::set("constants.ORDER_STATUS_OPEN", $orderstatuses->where("name", "open")
                                                                         ->first()->id); // id = 1
            if ($orderstatuses->where("name", "closed")
                              ->isNotEmpty())
                Config::set("constants.ORDER_STATUS_CLOSED", $orderstatuses->where("name", "closed")
                                                                           ->first()->id); // id = 2
            if ($orderstatuses->where("name", "canceled")
                              ->isNotEmpty())
                Config::set("constants.ORDER_STATUS_CANCELED", $orderstatuses->where("name", "canceled")
                                                                             ->first()->id); // id = 3
            if ($orderstatuses->where("name", "openByAdmin")
                              ->isNotEmpty())
                Config::set("constants.ORDER_STATUS_OPEN_BY_ADMIN", $orderstatuses->where("name", "openByAdmin")
                                                                                  ->first()->id); // id = 4
            if ($orderstatuses->where("name", "posted")
                              ->isNotEmpty())
                Config::set("constants.ORDER_STATUS_POSTED", $orderstatuses->where("name", "posted")
                                                                           ->first()->id); // id = 5
            if ($orderstatuses->where("name", "refunded")
                              ->isNotEmpty())
                Config::set("constants.ORDER_STATUS_REFUNDED", $orderstatuses->where("name", "refunded")
                                                                             ->first()->id); // id = 6
            if ($orderstatuses->where("name", "readyToPost")
                              ->isNotEmpty())
                Config::set("constants.ORDER_STATUS_READY_TO_POST", $orderstatuses->where("name", "readyToPost")
                                                                                  ->first()->id); // id = 7
            if ($orderstatuses->where("name", "openDonate")
                              ->isNotEmpty())
                Config::set("constants.ORDER_STATUS_OPEN_DONATE", $orderstatuses->where("name", "openDonate")
                                                                                ->first()->id); // id = 8
            if ($orderstatuses->where("name", "pending")
                              ->isNotEmpty())
                Config::set("constants.ORDER_STATUS_PENDING", $orderstatuses->where("name", "pending")
                                                                            ->first()->id); // id = 9

            //=================TRANSACTION STATUSES CONSTANTS
            $transactionstatuses = \App\Transactionstatus::all();
            if ($transactionstatuses->where("name", "transferredToPay")
                                    ->isNotEmpty())
                Config::set("constants.TRANSACTION_STATUS_TRANSFERRED_TO_PAY", $transactionstatuses->where("name", "transferredToPay")
                                                                                                   ->first()->id); // id = 1
            if ($transactionstatuses->where("name", "unsuccessful")
                                    ->isNotEmpty())
                Config::set("constants.TRANSACTION_STATUS_UNSUCCESSFUL", $transactionstatuses->where("name", "unsuccessful")
                                                                                             ->first()->id); // id = 2
            if ($transactionstatuses->where("name", "successful")
                                    ->isNotEmpty())
                Config::set("constants.TRANSACTION_STATUS_SUCCESSFUL", $transactionstatuses->where("name", "successful")
                                                                                           ->first()->id);// id = 3
            if ($transactionstatuses->where("name", "pending")
                                    ->isNotEmpty())
                Config::set("constants.TRANSACTION_STATUS_PENDING", $transactionstatuses->where("name", "pending")
                                                                                        ->first()->id);// id = 4
            if ($transactionstatuses->where("name", "archivedSuccessful")
                                    ->isNotEmpty())
                Config::set("constants.TRANSACTION_STATUS_ARCHIVED_SUCCESSFUL", $transactionstatuses->where("name", "archivedSuccessful")
                                                                                                    ->first()->id);// id = 5
            if ($transactionstatuses->where("name", "unpaid")
                                    ->isNotEmpty())
                Config::set("constants.TRANSACTION_STATUS_UNPAID", $transactionstatuses->where("name", "unpaid")
                                                                                       ->first()->id);// id = 6
            if ($transactionstatuses->where("name", "suspended")
                                    ->isNotEmpty())
                Config::set("constants.TRANSACTION_STATUS_SUSPENDED", $transactionstatuses->where("name", "suspended")
                                                                                          ->first()->id);// id = 7

            //=================PAYMENT METHODS CONSTANTS
            $paymentmethods = \App\Paymentmethod::all();
            if ($paymentmethods->where("name", "online")
                               ->isNotEmpty())
                Config::set("constants.PAYMENT_METHOD_ONLINE", $paymentmethods->where("name", "online")
                                                                              ->first()->id); // id = 1
            if ($paymentmethods->where("name", "ATM")
                               ->isNotEmpty())
                Config::set("constants.PAYMENT_METHOD_ATM", $paymentmethods->where("name", "ATM")
                                                                           ->first()->id); // id = 2
            if ($paymentmethods->where("name", "POS")
                               ->isNotEmpty())
                Config::set("constants.PAYMENT_METHOD_POS", $paymentmethods->where("name", "POS")
                                                                           ->first()->id);// id = 3
            if ($paymentmethods->where("name", "paycheck")
                               ->isNotEmpty())
                Config::set("constants.PAYMENT_METHOD_PAYCHECK", $paymentmethods->where("name", "paycheck")
                                                                                ->first()->id);// id = 4
            if ($paymentmethods->where("name", "wallet")
                               ->isNotEmpty())
                Config::set("constants.PAYMENT_METHOD_WALLET", $paymentmethods->where("name", "wallet")
                                                                              ->first()->id);// id = 5

            //=====================PAYMENT STATUSES CONSTANTS
            $paymentstatuses = \App\Paymentstatus::all();
            if ($paymentstatuses->where("name", "unpaid")
                                ->isNotEmpty())
                Config::set("constants.PAYMENT_STATUS_UNPAID", $paymentstatuses->where("name", "unpaid")
                                                                               ->first()->id);// id = 1
            if ($paymentstatuses->where("name", "indebted")
                                ->isNotEmpty())
                Config::set("constants.PAYMENT_STATUS_INDEBTED", $paymentstatuses->where("name", "indebted")
                                                                                 ->first()->id);// id = 2
            if ($paymentstatuses->where("name", "paid")
                                ->isNotEmpty())
                Config::set("constants.PAYMENT_STATUS_PAID", $paymentstatuses->where("name", "paid")
                                                                             ->first()->id);// id = 3

            //======================USER BON STATUSES CONSTANTS
            $userbonstatuses = \App\Userbonstatus::all();
            if ($userbonstatuses->where("name", "active")
                                ->isNotEmpty())
                Config::set("constants.USERBON_STATUS_ACTIVE", $userbonstatuses->where("name", "active")
                                                                               ->first()->id);// id = 1
            if ($userbonstatuses->where("name", "expired")
                                ->isNotEmpty())
                Config::set("constants.USERBON_STATUS_EXPIRED", $userbonstatuses->where("name", "expired")
                                                                                ->first()->id);// id = 2
            if ($userbonstatuses->where("name", "used")
                                ->isNotEmpty())
                Config::set("constants.USERBON_STATUS_USED", $userbonstatuses->where("name", "used")
                                                                             ->first()->id);// id = 3

            //======================PRODUCT TYPES CONSTANTS
            $producttypes = \App\Producttype::all();
            if ($producttypes->where("name", "simple")
                             ->isNotEmpty())
                Config::set("constants.PRODUCT_TYPE_SIMPLE", $producttypes->where("name", "simple")
                                                                          ->first()->id);// id = 1
            if ($producttypes->where("name", "configurable")
                             ->isNotEmpty())
                Config::set("constants.PRODUCT_TYPE_CONFIGURABLE", $producttypes->where("name", "configurable")
                                                                                ->first()->id);// id = 2
            if ($producttypes->where("name", "selectable")
                             ->isNotEmpty())
                Config::set("constants.PRODUCT_TYPE_SELECTABLE", $producttypes->where("name", "selectable")
                                                                              ->first()->id);// id = 3
            //======================ROLE CONSTANTS
            $roles = \App\Role::all();
            if ($roles->where("name", "employee")
                      ->isNotEmpty())
                Config::set("constants.ROLE_EMPLOYEE", $roles->where("name", "employee")
                                                             ->first()->id);
            if ($roles->where("name", "teacher")
                      ->isNotEmpty())
                Config::set("constants.ROLE_TEACHER", $roles->where("name", "teacher")
                                                            ->first()->id);
            //======================CONTROLS CONSTANTS
            $controls = \App\Attributecontrol::all();
            if ($controls->where("name", "select")
                         ->isNotEmpty())
                Config::set("constants.CONTROL_SELECT", $controls->where("name", "select")
                                                                 ->first()->id);
            if ($controls->where("name", "groupedCheckbox")
                         ->isNotEmpty())
                Config::set("constants.CONTROL_GROUPED_CHECKBOX", $controls->where("name", "groupedCheckbox")
                                                                           ->first()->id);
            if ($controls->where("name", "switch")
                         ->isNotEmpty())
                Config::set("constants.CONTROL_SWITCH", $controls->where("name", "switch")
                                                                 ->first()->id);
            //======================ORDERPRODUCT TYPES CONSTANTS
            $orderproducttypes = \App\Orderproducttype::all();
            if ($orderproducttypes->where("name", "default")
                                  ->isNotEmpty())
                Config::set("constants.ORDER_PRODUCT_TYPE_DEFAULT", $orderproducttypes->where("name", "default")
                                                                                      ->first()->id);
            if ($orderproducttypes->where("name", "gift")
                                  ->isNotEmpty())
                Config::set("constants.ORDER_PRODUCT_GIFT", $orderproducttypes->where("name", "gift")
                                                                              ->first()->id);
            //                //=============================ORDERPRODUCT INTERRELATIONS
            $orderproducInterrelations = \App\Orderproductinterrelation::all();
            if ($orderproducInterrelations->where("name", "parent-child")
                                          ->isNotEmpty())
                Config::set("constants.ORDER_PRODUCT_INTERRELATION_PARENT_CHILD", $orderproducInterrelations->where("name", "parent-child")
                                                                                                            ->first()->id);
            //                //=============================TRANSACTION INTERRELATIONS
            $transactionInterrelations = \App\Transactioninterraltion::all();
            if ($transactionInterrelations->where("name", "parent-child")
                                          ->isNotEmpty())
                Config::set("constants.TRANSACTION_INTERRELATION_PARENT_CHILD", $transactionInterrelations->where("name", "parent-child")
                                                                                                          ->first()->id);
            //                //=============================PRODUCT INTERRELATIONS
            $productInterrelations = \App\Productinterrelation::all();
            if ($productInterrelations->where("name", "gift")
                                      ->isNotEmpty())
                Config::set("constants.PRODUCT_INTERRELATION_GIFT", $productInterrelations->where("name", "gift")
                                                                                          ->first()->id);
            //                //=============================DISCOUNT TYPES
            $discounttypes = \App\Discounttype::all();
            if ($discounttypes->where("name", "percentage")
                              ->isNotEmpty())
                Config::set("constants.DISCOUNT_TYPE_PERCENTAGE", $discounttypes->where("name", "percentage")
                                                                                ->first()->id);
            if ($discounttypes->where("name", "cost")
                              ->isNotEmpty())
                Config::set("constants.DISCOUNT_TYPE_COST", $discounttypes->where("name", "cost")
                                                                          ->first()->id);
            //                =============================DISCOUNT TYPES
            $discounttypes = \App\Discounttype::all();
            if ($discounttypes->where("name", "percentage")
                              ->isNotEmpty())
                Config::set("constants.DISCOUNT_TYPE_PERCENTAGE", $discounttypes->where("name", "percentage")
                                                                                ->first()->id);
            if ($discounttypes->where("name", "cost")
                              ->isNotEmpty())
                Config::set("constants.DISCOUNT_TYPE_COST", $discounttypes->where("name", "cost")
                                                                          ->first()->id);
            //                =============================PRODUCT FILE TYPES

            $productfiletypes = Productfiletype::all();
            if ($productfiletypes->where("name", "video")
                                 ->isNotEmpty())
                Config::set("constants.PRODUCT_FILE_TYPE_VIDEO", $productfiletypes->where("name", "video")
                                                                                  ->first()->id);
            if ($productfiletypes->where("name", "pamphlet")
                                 ->isNotEmpty())
                Config::set("constants.PRODUCT_FILE_TYPE_PAMPHLET", $productfiletypes->where("name", "pamphlet")
                                                                                     ->first()->id);

            //                =============================CONTENT TYPES

            $contenttypes = Contenttype::all();
            if ($contenttypes->where("name", "pamphlet")
                             ->isNotEmpty())
                Config::set("constants.CONTENT_TYPE_PAMPHLET", $contenttypes->where("name", "pamphlet")
                                                                            ->first()->id);
            if ($contenttypes->where("name", "video")
                             ->isNotEmpty())
                Config::set("constants.CONTENT_TYPE_VIDEO", $contenttypes->where("name", "video")
                                                                         ->first()->id);

            //                =============================WALLET TYPES

            $wallettypes = Wallettype::all();
            if ($wallettypes->where("name", "main")
                            ->isNotEmpty())
                Config::set("constants.WALLET_TYPE_MAIN", $wallettypes->where("name", "main")
                                                                      ->first()->id);
            if ($wallettypes->where("name", "gift")
                            ->isNotEmpty())
                Config::set("constants.WALLET_TYPE_GIFT", $wallettypes->where("name", "gift")
                                                                      ->first()->id);


            $donateProduct = Product::whereIn("id", config("constants.DONATE_PRODUCT"))
                                    ->first();
            if (isset($donateProduct))
                Config::set("constants.DONATE_PRODUCT_COST", $donateProduct->basePrice);

            /**
             *  lessons
             */

            $sections = (new webBlockCollectionFormatter(new webSetCollectionFormatter()))->format(Block::getBlocks());

            View::share('sections', $sections);

        }
        catch (QueryException $e) {
            throw new $e;
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
