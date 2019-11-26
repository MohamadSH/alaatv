<?php

namespace App\Http\Controllers\Web;

use App\Attribute;
use App\Block;
use App\Classes\SEO\SeoDummyTags;
use App\Collection\BlockCollection;
use App\Product;
use App\Traits\MetaCommon;
use App\Traits\ProductCommon;
use App\Websitesetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use SEO;

class ProductLandingController extends Controller
{
    use ProductCommon;
    use MetaCommon;

    private $setting;

    public function __construct(Websitesetting $setting)
    {
        $this->setting  = $setting->setting;
    }


    /**
     * Products Special Landing Page
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function landing1(Request $request)
    {
        return redirect('/landing/6', 302);

        $url = $request->url();
        $this->generateSeoMetaTags(new SeoDummyTags('آلاء| جمع بندی نیم سال اول',
            'همایش ویژه دی ماه آلاء حمع بندی کنکور اساتید آلاء تست درسنامه تخفیف', $url,
            $url, route('image', [
                'category' => '11',
                'w'        => '100',
                'h'        => '100',
                'filename' => $this->setting->site->siteLogo,
            ]), '100', '100', null));

//        $productIds = config("constants.HAMAYESH_PRODUCT");
        $productIds = [276, 275, 272, 270, 269];
        $products   = Product::whereIn('id', $productIds)
            ->orderBy('order')
            ->where('enable', 1)
            ->get();
        $attribute  = Attribute::where('name', 'major')
            ->get()
            ->first();
        $withFilter = true;

        $landingProducts = collect();
        foreach ($products as $product) {
            $majors = [];
            if (isset($attribute)) {
                $majors = $product->attributevalues->where('attribute_id', $attribute->id)
                    ->pluck('name')
                    ->toArray();
            }

            $landingProducts->push([
                'product' => $product,
                'majors'  => $majors,
            ]);
        }

//        $costCollection = $this->makeCostCollection($products);
        $costCollection = null;

        return view('product.landing.landing1', compact('landingProducts', 'costCollection', 'withFilter'));
    }

    /**
     * Products Special Landing Page
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function landing2(Request $request)
    {
        return redirect()->route('web.landing.5', $request->all());

        $gheireHozoori = config('constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_ALLTOGHETHER');
        if (Input::has('utm_term')) {
            $utm_term = Input::get('utm_term');
            switch ($utm_term) {
                case '700':
                    $gheireHozoori = config('constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_ALLTOGHETHER');
                    break;
                case '260':
                    $gheireHozoori = config('constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_DEFAULT');
                    break;
                default:
                    break;
            }
        }

        $products = Product::whereIn('id', config('constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT'))
            ->orwhereIn('id',
                config('constants.ORDOO_HOZOORI_NOROOZ_97_PRODUCT'))
            ->orderBy('order')
            ->where('enable', 1)
            ->get();

        $landingProducts = collect();
        foreach ($products as $product) {
            $landingProducts->push(['product' => $product]);
        }
        $costCollection = $this->makeCostCollection($products);

        return view('product.landing.landing2',
            compact('landingProducts', 'costCollection', 'utm_term', 'gheireHozoori'));
    }

    /**
     * Products Special Landing Page
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function landing3(Request $request)
    {
        return redirect()->route('web.landing.5', $request->all());

        $url = $request->url();
        $this->generateSeoMetaTags(new SeoDummyTags('آلاء | همایش های طلایی کنکور 97',
            'وقتی همه کنکوری ها گیج و سرگردانند، شما مرور کنید. چالشی ترین نکات کنکوری در همایش های آلاء', $url, $url,
            route('image', [
                'category' => '11',
                'w'        => '100',
                'h'        => '100',
                'filename' => $this->setting->site->siteLogo,
            ]), '100', '100', null));

        return view('product.landing.landing3');
    }

    /**
     * Products Special Landing Page
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function landing4(Request $request)
    {
        return redirect()->route('web.landing.5', $request->all());

        $url = $request->url();
        $this->generateSeoMetaTags(new SeoDummyTags('آلاء | همایش های طلایی کنکور 97',
            'وقتی همه کنکوری ها گیج و سرگردانند، شما مرور کنید. چالشی ترین نکات کنکوری در همایش های آلاء', $url, $url,
            route('image', [
                'category' => '11',
                'w'        => '100',
                'h'        => '100',
                'filename' => $this->setting->site->siteLogo,
            ]), '100', '100', null));

        return view('product.landing.landing4');
    }

    /**
     * Products Special Landing Page
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function landing5(Request $request)
    {
        $url   = $request->url();
        $title = 'ضربه فنی کنکور نظام قدیم';
        SEO::setTitle($title);
        SEO::opengraph()
            ->setUrl($url);
        SEO::setCanonical($url);
        SEO::twitter()
            ->setSite('آلاء');
        SEO::setDescription('ضربه فنی کنکور نظام قدیم،رشته ریاضی، رشته تجربی،  رشته انسانی ، زیست، شیمی، فیزیک، زمین شناسی، عربی، ادبیات، شب امتحان، همایش، تحلیل کنکور، جزوه، تست، جمع بندی، طرح 5+1، ریاضیات رشته تجربی، ریاضیات رشته انسانی، ریاضیات رشته ریاضی، جزوه علوم پایه');
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

        /*$product_ids = [
            334,
            335,
            336,
            337,
            338,
            339,
            340,
            210,
            213,
            222
        ];*/
        $product_ids = [
            328,
            230,
            222,
            213,
            210,
            232,
            234,
            236,
            242,
            240,
            238,
        ];


        $products = Cache::remember('landing-5-products', config('constants.CACHE_600'),
            function () use ($product_ids) {
                return Product::whereIn('id', $product_ids)
                    ->orderBy('order')
                    ->enable()
                    ->get();
            });

//        $costCollection = $this->makeCostCollection($products);

        /*$reshteIdArray = [
            334 => 'riazi',
            335 => 'riazi',
            336 => 'riazi',
            337 => 'riazi',
            340 => 'tajrobi',
            338 => 'tajrobi',
            339 => 'tajrobi',
            222 => 'tajrobi',
            210 => 'tajrobi',
            213 => 'tajrobi',
        ];*/
        $reshteIdArray = [
            242 => 'riazi',
            240 => 'tajrobi',
            238 => 'riazi tajrobi ensani',
            236 => 'riazi tajrobi ensani',
            230 => 'riazi tajrobi',
            234 => 'tajrobi',
            232 => 'riazi tajrobi',
            222 => 'ensani',
            210 => 'riazi tajrobi ensani',
            213 => 'tajrobi',
            328 => 'tajrobi',
        ];

        $productsDataForView = [];
        foreach ($products as $key => $value) {
            $priceWithDiscount = 0;
//            $price = $costCollection[$value->id]["cost"];
            $price = null;
//            if ($costCollection[$value->id]["costForCustomer"] > 0) {
//                $priceWithDiscount = $costCollection[$value->id]["costForCustomer"];
//            } elseif ($costCollection[$value->id]["productDiscount"] + $costCollection[$value->id]["bonDiscount"] > 0) {
//                if (Auth::check())
//                    $priceWithDiscount = (1 - ($costCollection[$value->id]["bonDiscount"] / 100)) * ((1 - ($costCollection[$value->id]["productDiscount"] / 100)) * $costCollection[$value->id]["cost"]);
//                elseif (isset($costCollection[$value->id]["cost"]))
//                    $priceWithDiscount = (1 - ($costCollection[$value->id]["productDiscount"] / 100)) * $costCollection[$value->id]["cost"];
//            }

            $productsDataForView[] = [
                'id'                => $value->id,
                'type'              => $reshteIdArray[$value->id],
                'price'             => $value->price,
                'priceWithDiscount' => $priceWithDiscount,
                'image'             => $value->photo.'?w=350&h=350',
                'name'              => $value->name,
                'link'              => action('Web\ProductController@show', $value->id)
                //                'link'              => null,
            ];
        }

        $products = $productsDataForView;

        return view('product.landing.landing5', compact('products'));
    }

    /**
     * Products Special Landing Page
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function landing6(Request $request)
    {
        return redirect()->route('web.landing.9', $request->all());

        $url = $request->url();
        $this->generateSeoMetaTags(new SeoDummyTags('آلاء| جمع بندی نیم سال اول',
            'همایش ویژه دی ماه آلاء حمع بندی کنکور اساتید آلاء تست درسنامه تخفیف', $url,
            $url, route('image', [
                'category' => '11',
                'w'        => '100',
                'h'        => '100',
                'filename' => $this->setting->site->siteLogo,
            ]), '100', '100', null));

        $producIds = [
            271,
            270,
            269,
            268,
            267,
            266,
            265,
        ];

        $productIds = $producIds;
//        $productIds = config("constants.HAMAYESH_PRODUCT");
        $products = Cache::remember('landing-5-products', config('constants.CACHE_600'),
            function () use ($product_ids) {
                return Product::whereIn('id', $product_ids)
                    ->orderBy('order')
                    ->enable()
                    ->get();
            });

        $attribute  = Attribute::where('name', 'major')
            ->get()
            ->first();
        $withFilter = true;

        $landingProducts = collect();
        foreach ($products as $product) {
            $majors = [];
            if (isset($attribute)) {
                $majors = $product->attributevalues->where('attribute_id', $attribute->id)
                    ->pluck('name')
                    ->toArray();
            }

            $landingProducts->push([
                'product' => $product,
                'majors'  => $majors,
            ]);
        }

        $costCollection = $this->makeCostCollection($products);

        return view('product.landing.landing1', compact('landingProducts', 'costCollection', 'withFilter'));
    }

    /**
     * Products Special Landing Page
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function landing7(Request $request)
    {
        return redirect()->route('web.landing.9', $request->all());
        $url = $request->url();
        $this->generateSeoMetaTags(new SeoDummyTags('از پایه تا کنکور با آلاء',
            'از پایه تا کنکور با همایش های دانلودی آلا', $url,
            $url, route('image', [
                'category' => '11',
                'w'        => '100',
                'h'        => '100',
                'filename' => $this->setting->site->siteLogo,
            ]), '100', '100', null));

        $blocks        = new BlockCollection();
        $blocksIdArray = [16, 7, 10, 6];
        foreach ($blocksIdArray as $blockId) {
            $block = Block::find($blockId);
            if (isset($block)) {
                $blocks->push($block);
            }
        }

        return view('product.landing.landing7', compact('landingProducts', 'costCollection', 'withFilter', 'blocks'));
    }

    /**
     * Products Special Landing Page
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function landing8(Request $request)
    {
        $url = $request->url();
        $this->generateSeoMetaTags(new SeoDummyTags('همایش های دانلودی آلاء',
            'همایش های دانلودی آلاء، 80% کنکور', $url,
            $url, route('image', [
                'category' => '11',
                'w'        => '100',
                'h'        => '100',
                'filename' => $this->setting->site->siteLogo,
            ]), '100', '100', null));

        $producIds = [
            298,
            302,
            306,
            308,
            312,
            316,
            318,
            322,
            326,
            328,
            342,
            294
        ];

        $productHoures = [
            294 => [
                'name' => 'الماس عربی',
                'url' => action('Web\ProductController@show', 294),
                'hours' => 2
            ],
            298 => [
                'name' => 'همایش عربی',
                'url' => action('Web\ProductController@show', 298),
                'hours' => 5
            ],
            342 => [
                'name' => 'همایش ادبیات',
                'url' => action('Web\ProductController@show', 342),
                'hours' => 10
            ],
            302 => [
                'name' => 'همایش دین و زندگی',
                'url' => action('Web\ProductController@show', 302),
                'hours' => 12
            ],
            308 => [
                'name' => 'همایش زبان انگلیسی',
                'url' => action('Web\ProductController@show', 308),
                'hours' => 12
            ],
            326 => [
                'name' => 'همایش زیست',
                'url' => action('Web\ProductController@show', 326),
                'hours' => 23
            ],
            318 => [
                'name' => 'همایش 45 تست کنکور ریاضی',
                'url' => action('Web\ProductController@show', 318),
                'hours' => 30
            ],
            328 => [
                'name' => 'همایش ریاضی تجربی(آقای نباخته)',
                'url' => action('Web\ProductController@show', 328),
                'hours' => 11
            ],
            316 => [
                'name' => 'همایش ریاضی تجربی(آقای امینی)',
                'url' => action('Web\ProductController@show', 316),
                'hours' => 15
            ],
            322 => [
                'name' => 'همایش ریاضی تجربی(آقای ثابتی)',
                'url' => action('Web\ProductController@show', 322),
                'hours' => 18
            ],
            306 => [
                'name' => 'همایش فیزیک',
                'url' => action('Web\ProductController@show', 306),
                'hours' => 16
            ],
            312 => [
                'name' => 'همایش شیمی',
                'url' => action('Web\ProductController@show', 312),
                'hours' => 18
            ],
        ];


        $productIds = $producIds;
//        $productIds = config("constants.HAMAYESH_PRODUCT");
        [$products, $landingProducts] = Cache::remember('landing-8-products', config('constants.CACHE_600'),
            static function () use ($productIds) {
                $products  = Product::whereIn('id', $productIds)
                    ->orderBy('order')
                    ->enable()
                    ->get();
                $attribute = Attribute::where('name', 'major')
                    ->get()
                    ->first();

                $landingProducts = collect();
                foreach ($products as $product) {
                    $majors = [];
                    if (isset($attribute)) {
                        $majors = $product->attributevalues->where('attribute_id', $attribute->id)
                            ->pluck('name')
                            ->toArray();
                    }

                    $landingProducts->push([
                        'product' => $product,
                        'majors'  => $majors,
                    ]);
                }
                return [$products, $landingProducts];
            });

        $withFilter = true;

        $costCollection = $this->makeCostCollection($products);

        return view('product.landing.landing8', compact('landingProducts', 'costCollection', 'withFilter', 'productHoures'));
    }

    /**
     * Products Special Landing Page
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function landing9(Request $request)
    {
        $url = $request->url();
        $this->generateSeoMetaTags(new SeoDummyTags('همایش های تفتان آلاء',
            'جمع بندی دروس پایه کنکور', $url,
            $url, route('image', [
                'category' => '11',
                'w'        => '100',
                'h'        => '100',
                'filename' => $this->setting->site->siteLogo,
            ]), '100', '100', null));

        $blocks        = new BlockCollection();
        $blocksIdArray = [10];
        foreach ($blocksIdArray as $blockId) {
            $block = Block::find($blockId);
            if (isset($block)) {
                $blocks->push($block);
            }
        }

        return view('product.landing.landing9', compact('blocks'));
    }

    /**
     * Products Special Landing Page
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function landing10(Request $request)
    {
        $url = $request->url();
        $this->generateSeoMetaTags(new SeoDummyTags('همایش های گدار آلاء',
            'جمع بندی نیم سال اول پایه دوازدهم', $url,
            $url, route('image', [
                'category' => '11',
                'w'        => '100',
                'h'        => '100',
                'filename' => $this->setting->site->siteLogo,
            ]), '100', '100', null));

        $productIds = [
            373,
            375,
            377,
            379,
            381,
            383,
            385,
            387,
            389,
        ];

        $productHoures = [
            373 => [
                'name' => 'همایش فیزیک گدار',
                'url' => route('product.show' , 373),
                'hours' => 11
            ],
            381 => [
                'name' => 'همایش هندسه گدار',
                'url' => route('product.show' , 381),
                'hours' => 8
            ],
            375 => [
                'name' => 'همایش ریاضی انسانی گدار',
                'url' => route('product.show' , 375),
                'hours' => 6
            ],
            377 => [
                'name' => 'همایش ریاضی تجربی گدار',
                'url' => route('product.show' , 377),
                'hours' => 10
            ],
            385 => [
                'name' => 'همایش ریاضی تجربی گدار',
                'url' => route('product.show' , 385),
                'hours' => 0
            ],
            379 => [
                'name' => 'همایش گسسته گدار',
                'url' => route('product.show' , 379),
                'hours' => 0
            ],
            383 => [
                'name' => 'همایش حسابان گدار',
                'url' => route('product.show' , 383),
                'hours' => 0
            ],
            387 => [
                'name' => 'همایش شیمی گدار',
                'url' => route('product.show' , 387),
                'hours' => 0
            ],
            389 => [
                'name' => 'همایش زیست شناسی گدار',
                'url' => route('product.show' , 389),
                'hours' => 0
            ]
        ];


        [$products, $landingProducts] = Cache::remember('landing-8-products', config('constants.CACHE_600'),
            static function () use ($productIds) {
                $products  = Product::whereIn('id', $productIds)
                    ->orderBy('order')
                    ->enable()
                    ->get();
                $attribute = Attribute::where('name', 'major')
                    ->get()
                    ->first();

                $landingProducts = collect();
                foreach ($products as $product) {
                    $majors = [];
                    if (isset($attribute)) {
                        $majors = $product->attributevalues->where('attribute_id', $attribute->id)
                            ->pluck('name')
                            ->toArray();
                    }

                    $landingProducts->push([
                        'product' => $product,
                        'majors'  => $majors,
                    ]);
                }
                return [$products, $landingProducts];
            });

        $withFilter = true;

        $costCollection = $this->makeCostCollection($products);

        return view('product.landing.landing11', compact('landingProducts', 'costCollection', 'withFilter', 'productHoures'));
    }
}
