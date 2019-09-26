<?php

namespace App\Providers;

use Illuminate\Support\Facades\{Cache, Route};
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\{City,
    LiveDescription,
    Role,
    User,
    Order,
    Phone,
    Coupon,
    Wallet,
    Article,
    Contact,
    Content,
    Product,
    Userbon,
    Attribute,
    Slideshow,
    Assignment,
    Contentset,
    Mbtianswer,
    Permission,
    Userupload,
    Eventresult,
    Productfile,
    Attributeset,
    Consultation,
    Orderproduct,
    Productphoto,
    Attributegroup,
    Attributevalue,
    Websitesetting,
    Articlecategory,
    Employeetimesheet,
    Afterloginformcontrol};

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
     *
     */
    private function modelBinding()
    {
        Route::bind('user', function ($value) {
            $key = 'User:'.$value;

            return Cache::tags([
                'user',
                $key,
            ])
                ->remember($key, config('constants.CACHE_5'), function () use ($value) {
                    return User::where('id', $value)
                            ->first() ?? abort(404);
                });
        });
        Route::bind('assignment', function ($value) {
            $key = 'Assignment:'.$value;

            return Cache::tags([
                'assignment',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Assignment::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('consultation', function ($value) {
            $key = 'Consultation:'.$value;

            return Cache::tags([
                'consultation',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Consultation::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('order', function ($value) {
            $key = 'Order:'.$value;

            return Cache::tags([
                'order',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Order::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('product', function ($value) {
            $key = 'Product:'.$value;

            return Cache::tags([
                'product',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                $product = Product::where('id', $value)
                    ->first();
                if (!isset($product) || is_null($product)) {
                    abort(404);
                }
                if (!$product->relationLoaded('producttype')) {
                    $product->load('producttype');
                }
                if (!$product->relationLoaded('attributeset')) {
                    $product->load('attributeset');
                }
                if ($product->producttype_id == config('constants.PRODUCT_TYPE_SELECTABLE')) {
                    $product->load('children');
                }
                if (!$product->relationLoaded('bons')) {
                    $product->load('bons');
                }

                return $product;
            });
        });
        Route::bind('orderproduct', function ($value) {
            $key = 'Orderproduct:'.$value;

            return Cache::tags([
                'orderproduct',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Orderproduct::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('attributevalue', function ($value) {
            $key = 'Attributevalue:'.$value;

            return Cache::tags([
                'attributevalue',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Attributevalue::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('permission', function ($value) {
            $key = 'Permission:'.$value;

            return Cache::tags([
                'permissoin',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Permission::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('role', function ($value) {
            $key = 'Role:'.$value;

            return Cache::tags([
                'role',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Role::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('coupon', function ($value) {
            $key = 'Coupon:'.$value;

            return Cache::tags([
                'coupon',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Coupon::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('userupload', function ($value) {
            $key = 'Userupload:'.$value;

            return Cache::tags([
                'userupload',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Userupload::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('attribute', function ($value) {
            $key = 'Attribute:'.$value;

            return Cache::tags([
                'attribute',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Attribute::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('attributeset', function ($value) {
            $key = 'Attributeset:'.$value;

            return Cache::tags([
                'attributeset',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Attributeset::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('attributegroup', function ($value) {
            $key = 'Attributegroup:'.$value;

            return Cache::tags([
                'attributegroup',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Attributegroup::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('userbon', function ($value) {
            $key = 'Userbon:'.$value;

            return Cache::tags([
                'userbon',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Userbon::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('mbtianswer', function ($value) {
            $key = 'Mbtianswer:'.$value;

            return Cache::tags([
                'mbtianswer',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Mbtianswer::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('contact', function ($value) {
            $key = 'Contact:'.$value;

            return Cache::tags([
                'contact',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Contact::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('phone', function ($value) {
            $key = 'Phone:'.$value;

            return Cache::tags([
                'phone',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Phone::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('afterloginformcontrol', function ($value) {
            $key = 'Afterloginformcontrol:'.$value;

            return Cache::tags([
                'afterloginformcontrol',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Afterloginformcontrol::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('article', function ($value) {
            $key = 'Article:'.$value;

            return Cache::tags([
                'article',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Article::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('articlecategory', function ($value) {
            $key = 'Articlecategory:'.$value;

            return Cache::tags([
                'atriclecategory',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Articlecategory::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('slideshow', function ($value) {
            $key = 'Slideshow:'.$value;

            return Cache::tags([
                'slideshow',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Slideshow::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('websiteSetting', function ($value) {
            $key = 'Websitesetting:'.$value;

            return Cache::tags([
                'websiteSetting',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Websitesetting::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('productfile', function ($value) {
            $key = 'Productfile:'.$value;

            return Cache::tags([
                'productfile',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Productfile::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('city', function ($value) {
            $key = 'City:'.$value;

            return Cache::tags([
                'city',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return City::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        /*
                Route::bind('content', function($value){
                    $key = "Content:".$value;
                   return Cache::remember($key,config("constants.CACHE_60"),function () use ($value){
                       $c = Content::where('id', $value)->first();
                       if (isset($c)) {
                           if (!$c->relationLoaded('template'))
                               $c->load("template");
                           if (!$c->relationLoaded('contentsets'))
                               $c->load("contentsets");
                       }
                        return  $c ?? abort(404);
                    });

                });
        */
        Route::bind('c', function ($value) {
            $key = 'Content:'.$value;

            return Cache::tags([
                'content',
                $key,
            ])->remember($key, config('constants.CACHE_60'), function () use ($value) {
                $c = Content::where('id', $value)
                    ->first();
                if (isset($c)) {
                    if (!$c->relationLoaded('template')) {
                        $c->load('template');
                    }
                    if (!$c->relationLoaded('contentsets')) {
                        $c->load('contentsets');
                    }
                    if (!$c->relationLoaded('user')) {
                        $c->load('user');
                    }
                }

                return $c ?? abort(404);
            });
        });

        Route::bind('set', function ($value) {
            $key = 'Set:'.$value;

            return Cache::tags([
                'set',
                $key,
            ])->remember($key, config('constants.CACHE_60'), function () use ($value) {
                $set = Contentset::where('id', $value)
                    ->first();

                return $set ?? abort(404);
            });
        });

        Route::bind('employeetimesheet', function ($value) {
            $key = 'Employeetimesheet:'.$value;

            return Cache::tags([
                'employeetimesheet',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Employeetimesheet::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('productphoto', function ($value) {
            $key = 'Productphoto:'.$value;

            return Cache::tags([
                'productphoto',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Productphoto::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('wallet', function ($value) {
            $key = 'Wallet:'.$value;

            return Cache::tags([
                'wallet',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Wallet::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
        Route::bind('eventresult', function ($value) {
            $key = 'Eventresuly:'.$value;

            return Cache::tags([
                'eventresult',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return Eventresult::where('id', $value)
                        ->first() ?? abort(404);
            });
        });

        Route::bind('livedescription', function ($value) {
            $key = 'Livedescription:'.$value;

            return Cache::tags([
                'livedescription',
                $key,
            ])->remember($key, config('constants.CACHE_5'), function () use ($value) {
                return LiveDescription::where('id', $value)
                        ->first() ?? abort(404);
            });
        });
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
}
