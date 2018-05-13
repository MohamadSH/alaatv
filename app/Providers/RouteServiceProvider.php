<?php

namespace App\Providers;

use App\Afterloginformcontrol;
use App\Article;
use App\Articlecategory;
use App\Assignment;
use App\Attribute;
use App\Attributegroup;
use App\Attributeset;
use App\Attributevalue;
use App\City;
use App\Consultation;
use App\Contact;
use App\Coupon;
use App\Educationalcontent;
use App\Employeetimesheet;
use App\File;
use App\Mbtianswer;
use App\Order;
use App\Orderproduct;
use App\Permission;
use App\Phone;
use App\Product;
use App\Productfile;
use App\Productphoto;
use App\Role;
use App\Slideshow;
use App\User;
use App\Userbon;
use App\Userupload;
use App\Verificationmessage;
use App\Wallet;
use App\Websitesetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     *
     */
    private function modelBinding(){
        Route::bind('user', function( $value){
            $key = "User:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return User::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('assignment', function ($value){
            $key = "Assignment:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Assignment::where('id', $value)->first() ?? abort(404);
            });


        });
        Route::bind('consultation', function($value){
            $key = "Consultation:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Consultation::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('order', function($value){
            $key = "Order:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Order::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('product', function($value){
            $key = "Product:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                $product =  Product::where('id', $value)->first() ;
                if(!isset($product) || is_null($product)){
                    abort(404);
                }
               if (!$product->relationLoaded('producttype'))
                    $product->load('producttype');
               if (!$product->relationLoaded('attributeset'))
                    $product->load('attributeset');
               if($product->producttype_id == Config::get("constants.PRODUCT_TYPE_SELECTABLE"))
                   $product->load('children');
               if (!$product->relationLoaded('bons'))
                   $product->load('bons');
               return $product;
            });

        });
        Route::bind('orderproduct', function($value){
            $key = "Orderproduct:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Orderproduct::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('attributevalue', function($value){
            $key = "Attributevalue:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Attributevalue::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('permission', function($value){
            $key = "Permission:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Permission::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('role', function($value){
            $key = "Role:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Role::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('coupon', function($value){
            $key = "Coupon:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Coupon::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('userupload', function($value){
            $key = "Userupload:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Userupload::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('verificationmessage', function($value){
            $key = "Verificationmessage:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Verificationmessage::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('attribute', function($value){
            $key = "Attribute:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Attribute::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('attributeset', function($value){
            $key = "Attributeset:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Attributeset::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('attributegroup', function($value){
            $key = "Attributegroup:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Attributegroup::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('userbon', function($value){
            $key = "Userbon:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Userbon::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('mbtianswer', function($value){
            $key = "Mbtianswer:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Mbtianswer::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('contact', function($value){
            $key = "Contact:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Contact::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('phone', function($value){
            $key = "Phone:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Phone::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('afterloginformcontrol', function($value){
            $key = "Afterloginformcontrol:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Afterloginformcontrol::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('article', function($value){
            $key = "Article:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Article::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('articlecategory', function($value){
            $key = "Articlecategory:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Articlecategory::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('slideshow', function($value){
            $key = "Slideshow:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Slideshow::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('websiteSetting', function($value){
            $key = "Websitesetting:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Websitesetting::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('productfile', function($value){
            $key = "Productfile:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Productfile::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('city', function($value){
            $key = "City:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return City::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind('educationalContent', function($value){
            $key = "Educationalcontent:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_60"),function () use ($value){
               $c = Educationalcontent::where('id', $value)->first();
               if (isset($c)) {
                   if (!$c->relationLoaded('template'))
                       $c->load("template");
                   if (!$c->relationLoaded('contentsets'))
                       $c->load("contentsets");
                   if (!$c->relationLoaded('files'))
                       $c->load("files");
               }
                return  $c ?? abort(404);
            });

        });
        Route::bind('c', function($value){
            $key = "Educationalcontent:".$value;
            return Cache::remember($key,Config::get("constants.CACHE_60"),function () use ($value){
                $c = Educationalcontent::where('id', $value)->first();
                if (isset($c)) {
                    if (!$c->relationLoaded('template'))
                        $c->load("template");
                    if (!$c->relationLoaded('contentsets'))
                        $c->load("contentsets");
                    if (!$c->relationLoaded('files'))
                        $c->load("files");
                }
                return  $c ?? abort(404);
            });

        });
        Route::bind('file', function($value){
            $key = "File:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return File::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind("employeetimesheet", function($value){
            $key = "Employeetimesheet:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Employeetimesheet::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind("productphoto", function($value){
            $key = "Productphoto:".$value;
           return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Productphoto::where('id', $value)->first() ?? abort(404);
            });

        });
        Route::bind("wallet", function($value){
            $key = "Wallet:".$value;
            return Cache::remember($key,Config::get("constants.CACHE_5"),function () use ($value){
                return Wallet::where('id', $value)->first() ?? abort(404);
            });

        });
    }

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
        $this->modelBinding();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {

        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {

        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
