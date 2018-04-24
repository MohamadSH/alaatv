@extends("app")

@section("headPageLevelPlugin")
    <link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/extraCSS/bootstrap-carousel.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/icheck/skins/allExtra.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/cubeportfolio/css/cubeportfolio.css" rel="stylesheet" type="text/css" />
@endsection

@section("headPageLevelStyle")
    <link rel="stylesheet" href="{{ mix('/css/page_level_style_all.css') }}">
    <link href="/assets/pages/css/portfolio-rtl.min.css" rel="stylesheet" type="text/css" />
    <style>
        .cbp-popup-lightbox-counter{
            direction: ltr;
        }
    </style>
@endsection

@section("metadata")
    @parent
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@section("pageBar")
@show

@if(isset($descriptionIframe) && $descriptionIframe)
@section("sidebar")
@endsection
@endif

@section("content")
    @include("systemMessage.flash")

        @if(!isset($descriptionIframe) || !$descriptionIframe)
            @if(isset($isLive) && $isLive !== false)
                <div class="row">
                    <div class="col-md-12">
                            <div class="portlet light profile">
                            <div class="portlet-title">
                                <div class="caption">
                                    @if($isLive == 0)
                                    <span class="caption-subject bold font-green uppercase"><img src="/img/extra/live-rs.png" height="50px"></span>
                                    <span class="caption-helper">پخش زنده</span>
                                    @elseif($isLive > 0 )
                                        <span class="caption-helper">پخش زنده هنوز شروع نشده است</span>
                                    @else
                                        <span class="caption-helper">باز پخش آخرین جلسه</span>
                                    @endif
                                </div>
                                @if(Auth::check() && $isLive <= 0)
                                <div class="actions">
                                    <a href="/download?fileName=8f81bfae-d7de-410d-abb1-9d475fb25bbb" class="btn btn-lg yellow ">
                                        <i class="fa fa-download"></i> دانلود جزوه این جلسه </a>
                                </div>
                                @endif
                            </div>
                            <div class="portlet-body">
                                <div class="clearfix text-center">
                                    @if(Auth::check())
                                        @if($isLive <= 0)
                                            <div  class="chooseServer clearfix">
                                                <h3 class="font-blue bold">
                                                    لطفا برای تماشا @if($isLive == 0)ی پخش زنده@endif یکی از گزینه های زیر را انتخاب نمایید
                                                </h3>
                                                <p>
                                                    <button type="button" class="btn purple btn-lg chooseServerButton" id="nationalServer">سرور داخلی</button>
                                                    <button type="button" class="btn red btn-lg chooseServerButton" id="youtubeServer">یوتیوب(نیاز به قندشکن😉)</button>
                                                </p>
                                            </div>
                                            <iframe frameborder="0" allowfullscreen id="liveFrame" src="" width="100%" height="500"></iframe>
                                        @elseif($isLive > 0 )
                                            <h3>جلسه چهارم بخش زنده اطلاع داده خواهد شد  </h3>
                                        @endif
                                            <button type="button" onclick="$('html, body').animate({scrollTop: $('#replayPrevious').offset().top}, 2000);" class="btn dark btn">تماشای جلسات دیگر</button>
                                            <button type="button" onclick="$('html, body').animate({scrollTop: $('#attributesPortlet').offset().top}, 2000);" class="btn blue btn">دانلود جزوات</button>
                                    @else
                                        <h4>برای تماشا وارد شوید</h4>
                                        <a class="btn green btn-lg" href="{{route("login")}}">ورود</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN Portlet PORTLET-->
                    <div class="portlet light profile">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject bold font-green uppercase"> {{ $product->name }} </span>
                            </div>
                        </div>
                        <div class="portlet-body " id="attributesPortlet">
                            <div class="row">
                                {!! Form::open(['method' => 'POST','action' => ['OrderproductController@store'] ]) !!}
                                    <div class="col-md-4" >
                                        <ul class="list-unstyled profile-nav">
                                            <li>
                                                <img  src="{{ route('image', ['category'=>'4','w'=>'338' , 'h'=>'338' ,  'filename' =>  $product->image ]) }}"    alt="عکس محصول@if(isset($product->name[0])) {{$product->name}} @endif"  class="img-responsive pic-bordered" style="width: 100%"  />
                                            </li>
                                            @if($product->enable)
                                            @if($product->isFree)
                                                <li>
                                                    <li style="text-align: center;">
                                                        <a class="bg-blue bg-font-blue" href="javascript:;">رایگان</a>
                                                    </li>
                                                </li>
                                            @else
                                                @if(!$product->bons->where("name" , Config::get("constants.BON1"))->where("isEnable" , 1)->isEmpty()
                                                    && $product->bons->where("name" , Config::get("constants.BON1"))->first()->pivot->bonPlus>0)
                                                    @if(!session()->has("adminOrder_id"))
                                                        {{--<li style="text-align: center;"><a class="bg-red-flamingo bg-font-red-flamingo" href="javascript:;"><i class="fa fa-plus-circle" aria-hidden="true"></i>{{$product->bons->where("name" , "alaa")->first()->pivot->bonPlus}} {{$product->bons->where("name" , "alaa")->first()->displayName}} به {{Session::get("customer_firstName")}} {{Session::get("customer_lastName")}}</a> </li>--}}
                                                        {{--@else--}}
                                                        <li style="text-align: center;"><a class="bg-red-flamingo bg-font-red-flamingo" href="javascript:;"><i class="fa fa-plus-circle" aria-hidden="true"></i>{{$product->bons->where("name" , Config::get("constants.BON1"))->first()->pivot->bonPlus}} {{$product->bons->where("name" ,Config::get("constants.BON1"))->first()->displayName}}</a> </li>
                                                    @endif
                                                @endif

                                                <li >
                                                    <a href="javascript:;" > قیمت
                                                        <span class="bg-green" style="width: 53%;height: 100%; text-align: center;" id="price" value="{{$product->basePrice}}">@if($product->basePrice == 0) پس از انتخاب محصول @else {{number_format($product->basePrice)}}تومان @endif</span>
                                                    </a>
                                                </li>
                                                @if(Auth::check())
                                                    @if(!$product->bons->where("name" , Config::get("constants.BON1"))->where("isEnable" , 1)->isEmpty())
                                                        @if(session()->has("adminOrder_id"))
                                                            <li>
                                                                <a href="javascript:;">{{$product->bons->where("name" , Config::get("constants.BON1"))->first()->displayName}} {{Session::get("customer_firstName")}} {{Session::get("customer_lastName")}}<span class="bg-grey-salsa bg-font-grey-salsa" style="width: 53%;height: 100% ;text-align: center">
                                                                {{ \App\User::where("id" , Session::get("customer_id"))->first()->userHasBon(Config::get("constants.BON1"))  }}
                                                                </span>
                                                                </a>
                                                            </li>
                                                        @elseif(Auth::user()->userHasBon(Config::get("constants.BON1")) > 0)
                                                            <li>
                                                                <a href="javascript:;">{{$product->bons->where("name" , Config::get("constants.BON1"))->first()->displayName}} شما<span class="bg-grey-salsa bg-font-grey-salsa" style="width: 53%;height: 100% ;text-align: center">
                                                                {{ Auth::user()->userHasBon(Config::get("constants.BON1"))  }}
                                                                </span>
                                                                </a>
                                                            </li>
                                                        @endif
                                                    @endif
                                                @endif
                                                <li>
                                                    <a href="javascript:;" > تخفیف
                                                        <span class="bg-yellow-gold" id="discount"  style="width: 53%;height: 100% ;text-align: center">
                                                                    {{--{{number_format( ($discount/100) * $cost)}}تومان--}}
                                                            </span>
                                                    </a>
                                                </li>
                                                @if(Auth::check() && $product->bons->where("name" , Config::get("constants.BON1"))->where("pivot.discount",">","0")->where("isEnable" , 1)->isEmpty())
                                                    <li style="text-align: center;"><a class="bg-yellow bg-font-yellow" href="javascript:;">این محصول تخفیف بن ندارد</a> </li>
                                                {{--@elseif(!Auth::check())--}}
                                                    {{--<li style="text-align: center;"><a class="bg-yellow bg-font-yellow" href="{{route("login")}}">برای دیدن تخفیف بن وارد شوید</a> </li>--}}
                                                @endif
                                                @if(session()->has("adminOrder_id"))
                                                    <li>
                                                        <a href="javascript:;" > قیمت تمام شده
                                                            <span  style="width: 53%;height: 100% ;text-align: center" id="customerPrice" value=""></span>
                                                        </a>
                                                    </li>
                                                @else
                                                    <li>
                                                        <a href="javascript:;" > قیمت برای شما
                                                            <span  style="width: 53%;height: 100% ;text-align: center" id="customerPrice"></span>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endif
                                            @endif
                                            @if(session()->has("adminOrder_id"))
                                                <button type="submit" id="orderButton1" class="btn btn-lg green col-md-12 col-xs-12 col-sm-12" ><i class="fa fa-cart-plus"></i>افزودن برای {{Session::get("customer_firstName")}} {{Session::get("customer_lastName")}}</button>
                                            @else
                                                @if($product->enable || (Auth::check() && Auth::user()->can(Config::get('constants.ORDER_ANY_THING')) ) )
                                                    @if($product->isFree && isset($isProductExistInOrder) && $isProductExistInOrder)
                                                        <a href="javascript:;" class="btn btn-lg default col-md-12 col-xs-12 col-sm-12 font-red">موجود در سبد</a>
                                                    @else
                                                        <button type="submit" id="orderButton1" class="btn btn-lg green col-md-12 col-xs-12 col-sm-12" ><i class="fa fa-cart-plus"></i>افزودن به سبد</button>
                                                    @endif
                                                @else
                                                    <a href="javascript:;" class="btn btn-lg default col-md-12 col-xs-12 col-sm-12 font-red">@if($product->id==183) این محصول رایگان است @else این محصول غیرفعال است@endif</a>
                                                @endif
                                            @endif

                                        </ul>
                                    </div>

                                    <div class="col-md-4">
                                            @if(in_array($productType ,[Config::get("constants.PRODUCT_TYPE_SIMPLE") , Config::get("constants.PRODUCT_TYPE_CONFIGURABLE")]))
                                                @if(isset($simpleInfoAttributes) && !$simpleInfoAttributes->isEmpty())
                                                    <div class="portlet sale-summary">
                                                        <div class="portlet-title">
                                                            <div class="caption font-red sbold">ویژگی ها</div>
                                                        </div>
                                                        <div class="portlet-body">
                                                            <ul class="list-unstyled">
                                                                @foreach($simpleInfoAttributes as $key => $simpleInfoAttribute)
                                                                    <li>
                                                                        <span class="sale-info"> {{$key}}
                                                                            <i class="fa fa-img-up"></i>
                                                                            </span>
                                                                        @foreach($simpleInfoAttribute as $key => $info)
                                                                            <span class="sale-num bold"> @if(count($simpleInfoAttribute)>1 && $key < (sizeof($simpleInfoAttribute)-1)) , @endif {{$info["name"]}}</span>
                                                                            @if(isset($info["type"]) && strcmp($info["type"],"information") != 0 )<input type="hidden" value="{{$info["value"]}}" name="attribute[]">@endif
                                                                        @endforeach
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endif
                                            @elseif(in_array($productType ,[Config::get("constants.PRODUCT_TYPE_SELECTABLE")]))
                                                @if(isset($simpleInfoAttributes) && !$simpleInfoAttributes->isEmpty() ||
                                                     isset($checkboxInfoAttributes) && !$checkboxInfoAttributes->isEmpty())
                                                    <div class="portlet sale-summary">
                                                        <div class="portlet-title">
                                                            <div class="caption font-red sbold">ویژگی ها</div>
                                                        </div>
                                                        <div class="portlet-body">
                                                            <ul class="list-unstyled">
                                                                @foreach($simpleInfoAttributes as $key => $simpleInfoAttribute)
                                                                    <li>
                                                                        <span class="sale-info"> {{$key}}
                                                                            <i class="fa fa-img-up"></i>
                                                                            </span>
                                                                        @foreach($simpleInfoAttribute as $key => $info)
                                                                            <span class="sale-num bold"> @if(count($simpleInfoAttribute)>1 && $key < (sizeof($simpleInfoAttribute)-1)) , @endif {{$info["name"]}}</span>
                                                                            @if(isset($info["type"]) && strcmp($info["type"],"information") != 0 )<input type="hidden" value="{{$info["value"]}}" name="attribute[]">@endif
                                                                        @endforeach
                                                                    </li>
                                                                @endforeach
                                                                @if(isset($checkboxInfoAttributes) && !$checkboxInfoAttributes->isEmpty())
                                                                    <li style="margin: 0% 5% 0% 5%">
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <div class="icheck-list">
                                                                                    @foreach($checkboxInfoAttributes as $checkboxArray)
                                                                                        @foreach($checkboxArray as $info)
                                                                                            <label>
                                                                                                {!! Form::checkbox('', null, null, ['class' => 'attribute icheck' , 'data-checkbox'=>'icheckbox_square-blue', 'checked' , 'disabled' ]) !!}{{$info["index"]}}
                                                                                            </label>
                                                                                        @endforeach
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif

                                            @if(isset($productSamplePhotos) && $productSamplePhotos->isNotEmpty())
                                                <div class="portlet sale-summary">
                                                    <div class="portlet-title">
                                                        <div class="caption font-red sbold">نمونه صفحات جزوه</div>
                                                    </div>
                                                    <div class="portlet-body" style="padding: 0px">
                                                        <div class="portfolio-content portfolio-2">
                                                        <div id="js-grid-mosaic2" class="cbp cbp-l-grid-mosaic">
                                                            @foreach($productSamplePhotos as $samplePhoto)
                                                                <div class="cbp-item">
                                                                    <a href="{{ route('image', ['category'=>'4','w'=>'1400' , 'h'=>'2000' ,  'filename' =>  $samplePhoto->file ]) }}" class="cbp-caption cbp-lightbox" data-title="@if(isset($samplePhoto->title[0])) {{$samplePhoto->title}} @else نمونه عکس {{$product->name}} @endif<br>@if(isset($samplePhoto->description[0])) {{$samplePhoto->description}} @endif">
                                                                        <div class="cbp-caption-defaultWrap">
                                                                            <img src="{{ route('image', ['category'=>'4','w'=>'100' , 'h'=>'135' ,  'filename' =>  $samplePhoto->file ]) }}" alt="@if(isset($samplePhoto->title[0])) {{$samplePhoto->title}} @else نمونه عکس {{$product->name}} @endif" > </div>
                                                                        <div class="cbp-caption-activeWrap">
                                                                            <div class="cbp-l-caption-alignCenter">
                                                                                <div class="cbp-l-caption-body">
                                                                                    <div class="cbp-l-caption-title" style="font-size: medium">@if(isset($samplePhoto->title[0])) {{$samplePhoto->title}} @endif</div>
                                                                                    <div class="cbp-l-caption-desc" style="font-size: 12px">@if(isset($samplePhoto->description[0])) {{$samplePhoto->description}} @endif</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if(strlen($product->file)>0)
                                                <div class="portlet sale-summary">
                                                    <div class="portlet-title">
                                                        <div class="caption font-red sbold">دانلود کاتالوگ</div>
                                                    </div>
                                                    <div class="portlet-body" style="text-align: center; padding-bottom: 6%;">
                                                        <a target="_blank" href="{{action("HomeController@download" , ["content"=>"کاتالوگ محصول","fileName"=>$product->file ])}}" class="icon-btn" style="background-color: #8E44AD ; "><div><i class="fa fa-download fa-3x bg-font-purple-sharp" aria-hidden="true"></i></div></a>
                                                    </div>
                                                </div>
                                            @endif

                                    <!--end row-->
                                    </div>

                                    <div class="col-md-4">
                                        @if(isset($productIntroVideo))
                                            <div class="portlet solid light grey-mint">
                                                <div class="portlet-title">
                                                    <div class="caption bg-font-dark sbold">کلیپ معرفی</div>
                                                </div>
                                                <div class="portlet-body">
                                                    <video controls style="width: 100%">
                                                        <source src="{{$productIntroVideo}}" type="video/mp4">
                                                        <span class="bold font-red">مرورگر شما HTML5 را پشتیبانی نمی کند</span>
                                                    </video>
                                                </div>
                                            </div>
                                            {{--<video controls style="width: 100%" preload="none">--}}
                                        @endif
                                        @if(isset($giftCollection) && $giftCollection->isNotEmpty())
                                            <div class="portlet sale-summary">
                                                <div class="portlet-title">
                                                    <div class="caption font-red sbold"><img src="/assets/extra/gift-box.png" width="25"> محصولات هدیه</div>
                                                </div>
                                                <div class="portlet-body" style="padding: 0px">
                                                    <ul class="list-unstyled">
                                                        @foreach($giftCollection as $gift)
                                                            <li class="text-center bold">
                                                                @if(strlen($gift["link"])>0)
                                                                    <a target="_blank" href="{{$gift["link"]}}">{{$gift["product"]->name}}</a>
                                                                @else
                                                                    {{$gift["product"]->name}}
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    @if(in_array($productType ,[Config::get("constants.PRODUCT_TYPE_SELECTABLE")]))
                                        <div class="col-md-8">
                                                    @if((isset($extraSelectCollection) && !$extraSelectCollection->isEmpty()) ||
                                                    (isset($extraCheckboxCollection) && !$extraCheckboxCollection->isEmpty()))
                                                        <div class="portlet sale-summary">
                                                            <div class="portlet-title">
                                                                <div class="caption font-red sbold">انتخاب خدمت</div>
                                                            </div>
                                                            <div class="portlet-body">
                                                                <ul class="list-unstyled">
                                                                    @if((isset($extraSelectCollection) && !$extraSelectCollection->isEmpty()) ||
                                                                     (isset($extraCheckboxCollection) && !$extraCheckboxCollection->isEmpty()))
                                                                        <li style="margin: 0% 5% 0% 5%">
                                                                            @include("product.partials.extraSelectCollection")
                                                                            @include("product.partials.extraCheckboxCollection" , ["withExtraCost"])
                                                                        </li>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="portlet sale-summary">
                                                        <div class="portlet-title">
                                                            <div class="caption font-red sbold">انتخاب محصول</div>
                                                        </div>
                                                        <div class="portlet-body">
                                                            <ul class="list-unstyled">
                                                                @if(isset($product->children) && !empty($product->children))
                                                                    @each('product.partials.showChildren', $product->children, 'product')
                                                                @endif
                                                            </ul>
                                                        </div>

                                                    </div>
                                        </div>
                                    @endif

                                    @if(in_array($productType ,[Config::get("constants.PRODUCT_TYPE_SIMPLE") , Config::get("constants.PRODUCT_TYPE_CONFIGURABLE")]))
                                        <div class="col-md-8">
                                                @if(isset($selectCollection) && !$selectCollection->isEmpty() ||
                                                isset($extraSelectCollection) && !$extraSelectCollection->isEmpty() ||
                                                isset($extraCheckboxCollection) && !$extraCheckboxCollection->isEmpty() ||
                                                isset($groupedCheckboxCollection) && !$groupedCheckboxCollection->isEmpty() ||
                                                isset($checkboxInfoAttributes) && !$checkboxInfoAttributes->isEmpty())
                                                    <div class="portlet sale-summary">
                                                        <div class="portlet-title">
                                                            <div class="caption font-red sbold">انتخاب گزینه ها</div>
                                                        </div>
                                                        <div class="portlet-body">
                                                            <ul class="list-unstyled">
                                                                @if(isset($checkboxInfoAttributes) && !$checkboxInfoAttributes->isEmpty())
                                                                    <li style="margin: 0% 5% 0% 5%">
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <div class="icheck-list">
                                                                                    @foreach($checkboxInfoAttributes as $checkboxArray)
                                                                                        @foreach($checkboxArray as $info)
                                                                                            <label>
                                                                                                {!! Form::checkbox('', null, null, ['class' => 'attribute icheck' , 'data-checkbox'=>'icheckbox_square-blue', 'checked' , 'disabled' ]) !!}{{$info["index"]}}
                                                                                            </label>
                                                                                        @endforeach
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endif
                                                                @if((isset($selectCollection) && !$selectCollection->isEmpty()) ||
                                                                     (isset($groupedCheckboxCollection) && !$groupedCheckboxCollection->isEmpty()))
                                                                    <li style="margin: 0% 5% 0% 5%">
                                                                        @if(isset($selectCollection))
                                                                            @foreach($selectCollection as $index => $select)

                                                                                <span class="sale-info"> {{ $index }}
                                                                                    <i class="fa fa-img-up"></i>
                                                                                                                </span>
                                                                                {!! Form::select('attribute[]',$select,null,['class' => 'form-control attribute']) !!}

                                                                            @endforeach
                                                                        @endif
                                                                        @if(isset($groupedCheckboxCollection))
                                                                            <div class="input-group">
                                                                                <div class="icheck-list">
                                                                                    @foreach($groupedCheckboxCollection as $checkboxArray)
                                                                                        @foreach($checkboxArray as $index => $checkbox)
                                                                                            <label>
                                                                                                {!! Form::checkbox('attribute[]', $index, null, ['class' => 'attribute icheck' , 'data-checkbox'=>'icheckbox_square-blue']) !!}
                                                                                                @if(isset($checkbox["index"])) {{$checkbox["index"]}} @endif @if(isset($checkbox["extraCost"][0])) (<span style="@if(isset($checkbox["extraCostWithDiscount"][0])) text-decoration: line-through;  @endif">{{$checkbox["extraCost"]}}</span> @if(isset($checkbox["extraCostWithDiscount"][0]))
                                                                                                        <span class="bg-font-dark" style="background: #ff7272;    padding: 0px 5px 0px 5px;">برای شما </span><span class="bg-font-dark" style="background: #ee5053;    padding: 0px 5px 0px 5px;">{{$checkbox["extraCostWithDiscount"]}}</span>
                                                                                                @endif) @endif
                                                                                            </label>
                                                                                        @endforeach
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </li>
                                                                @endif
                                                                @if((isset($extraSelectCollection) && !$extraSelectCollection->isEmpty()) ||
                                                                 (isset($extraCheckboxCollection) && !$extraCheckboxCollection->isEmpty()))
                                                                    <li style="margin: 0% 5% 0% 5%">
                                                                        @include("product.partials.extraSelectCollection")
                                                                        @include("product.partials.extraCheckboxCollection")
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endif
                                        </div>
                                    @endif
                                    <div class="col-md-8 profile-info" id="productShortDescription">
                                        {!! $product->shortDescription !!}
                                    </div>
                                {!! Form::hidden('product_id',$product->id) !!}
                                {!! Form::close() !!}
                            </div>
                            @if(isset($productSeenCount) && $productSeenCount > 0)
                            <div class="row" style="direction: ltr">
                                <div class="fa-item">
                                    <i class="fa fa-eye"></i> {{$productSeenCount}}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- END Portlet PORTLET-->
                </div>
            </div>
        @endif
        @if(isset($product->specialDescription))
            <div class="row">
                {!! $product->specialDescription !!}
            </div>
        @endif
        @if(!isset($descriptionIframe) || !$descriptionIframe)
        @if(isset($isLive) && $isLive !== false)
            @if(Auth::check())
                <div class="row" id="replayPrevious">
                    <div class="col-md-12">
                        <div  class="portlet light profile">
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3>تماشا/دانلود جلسه اول</h3>
                                    </div>
                                    <div class="col-md-8">
                                        <a href="{{action("EducationalContentController@show",130)}}" class="btn btn-lg green ">
                                            رفتن به صفحه تماشا </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div  class="portlet light profile">
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3>تماشا/دانلود جلسه دوم</h3>
                                    </div>
                                    <div class="col-md-8">
                                        <a href="{{action("EducationalContentController@show",131)}}" class="btn btn-lg green ">
                                            رفتن به صفحه تماشا </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div  class="portlet light profile">
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3>تماشا/دانلود جلسه سوم</h3>
                                    </div>
                                    <div class="col-md-8">
                                        <a href="{{action("EducationalContentController@show",144)}}" class="btn btn-lg green ">
                                            رفتن به صفحه تماشا </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div  class="portlet light profile">
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3>تماشا/دانلود جلسه چهارم</h3>
                                    </div>
                                    <div class="col-md-8">
                                        <a href="{{action("EducationalContentController@show",145)}}" class="btn btn-lg green ">
                                            رفتن به صفحه تماشا </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div  class="portlet light profile">
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3>تماشا/دانلود جلسه پنجم</h3>
                                    </div>
                                    <div class="col-md-8">
                                        <a href="{{action("EducationalContentController@show",156)}}" class="btn btn-lg green ">
                                            رفتن به صفحه تماشا </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div  class="portlet light profile">
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3>تماشا/دانلود جلسه ششم</h3>
                                    </div>
                                    <div class="col-md-8">
                                        <a href="{{action("EducationalContentController@show",157)}}" class="btn btn-lg green ">
                                            رفتن به صفحه تماشا </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(!Auth::check())
                <div class="row">
                    <div class="col-md-12">
                        <div  class="portlet light profile">
                            <div class="portlet-body text-center bold">
                                <h4><a href="{{route("login")}}">لطفا برای تماشای فیلم جلسات ابتدا وارد سایت شوید</a></h4>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        @endif
        @if( isset($product->longDescription[0]) || ($productsWithVideo->isNotEmpty() || $productsWithPamphlet->isNotEmpty()))
            <div class="row">
            <div class="col-md-12">
            <div class="portlet box yellow">
            <div class="portlet-body">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs ">
                        @if(isset($product->longDescription) && strlen($product->longDescription) >0)
                        <li class="active">
                            <a href="#tab_15_1" data-toggle="tab" class="bold  uppercase"> توضیحات اجمالی @if(isset($descriptionIframe) && $descriptionIframe) {{$product->name}} @endif</a>
                        </li>
                        @endif
                        @if(!isset($descriptionIframe) || !$descriptionIframe)
                        {{--@role((Config::get('constants.ROLE_ADMIN')))--}}
                                {{--@if(strcmp(getenv('SERVER'),"http://orduetalaee.ir")==0)--}}
                                    {{--<li>--}}
                                        {{--<a href="#tab_15_2" data-toggle="tab" class="bold  uppercase"> نظرات و پرسشهای شما </a>--}}
                                    {{--</li>--}}
                                {{--@endif--}}
                        {{--@endrole--}}

                        @endif
                            @if($productsWithVideo->isNotEmpty() || $productsWithPamphlet->isNotEmpty())
                                <li>
                                    <a href="#tab_15_3" data-toggle="tab" class="bold  uppercase">دانلود فیلم ها و جزوات</a>
                                </li>
                            @endif
                        @if(isset($descriptionIframe) && $descriptionIframe)
                            <a href="{{action("ProductController@show" , $product)}}" class="btn green uppercase"><i class="fa fa-cart-plus"></i>سفارش</a>
                        @endif
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_15_1">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- BEGIN Portlet PORTLET-->
                                    <div class="portlet light">
                                        {{--<div class="portlet-title">--}}
                                            {{--<div class="caption">--}}
                                                {{--<span class="caption-subject bold font-red uppercase">توضیحات اجمالی</span>--}}
                                            {{--</div>--}}
                                                {{--<div class="inputs">--}}
                                                    {{--<div class="portlet-input input-inline input-medium">--}}
                                                        {{--<a href="{{action("ProductController@show" , $product)}}" class="btn green uppercase"><i class="fa fa-cart-plus"></i>سفارش</a>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                        {{--</div>--}}
                                        <div class="portlet-body profile">
                                            @if(isset($descriptionIframe) && $descriptionIframe)
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        @if(isset($attributes) && !empty($attributes))
                                                            <div class="portlet sale-summary">
                                                                <div class="portlet-title">
                                                                    <div class="caption font-red sbold">ویژگی ها</div>
                                                                </div>
                                                                <div class="portlet-body">
                                                                    <ul class="list-unstyled">
                                                                        @foreach($attributes as $attribute)
                                                                            <li>
                                                                                    <span class="sale-info"> {{$attribute["displayName"]}}
                                                                                        <i class="fa fa-img-up"></i>
                                                                                    </span>
                                                                                <span class="sale-num bold"> {{$attribute["name"]}} </span>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    <!--end row-->
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row">
                                                <div class="col-md-12" style="text-align: right;" id="productLongDescription">
                                                        {!! $product->longDescription !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Portlet PORTLET-->
                                </div>
                            </div>
                        </div>
                        @if(!isset($descriptionIframe) || !$descriptionIframe)
                        {{--@role((Config::get('constants.ROLE_ADMIN')))--}}
                            {{--@if(strcmp(getenv('SERVER'),"http://orduetalaee.ir")==0)--}}
                                {{--<div class="tab-pane" id="tab_15_2">--}}
                                    {{--@if(isset($disqusPayload))--}}
                                        {{--<div id="disqus_thread"></div>--}}
                                        {{--<script>--}}
                                            {{--var disqus_config = function () {--}}
                                                {{--this.page.remote_auth_s3 = "{{$disqusPayload}}";--}}
                                                {{--this.page.api_key = "{{getenv('DISQUS_PUBLIC_KEY')}}";--}}
                                                {{--this.page.url = getenv('SERVER')+"/product/{{$product->id}}";--}}
                                                {{--this.page.identifier = "product/"+"{{$product->id}}";--}}
                                            {{--};--}}
                                            {{--(function() { // DON'T EDIT BELOW THIS LINE--}}
                                                {{--var d = document, s = d.createElement('script');--}}
                                                {{--s.src = '//orduetalaee.disqus.com/embed.js';--}}
                                                {{--s.setAttribute('data-timestamp', +new Date());--}}
                                                {{--(d.head || d.body).appendChild(s);--}}
                                            {{--})();--}}
                                        {{--</script>--}}
                                        {{--<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>--}}
                                    {{--@endif--}}

                            {{--</div>--}}
                            {{--@endif--}}
                        @endif

                        <div class="tab-pane" id="tab_15_3">
                            <div class="row">
                                <style>
                                    .videoList .slimScrollBar{
                                        background : rgb(37, 108, 156) !important;
                                        height: 30px;
                                    }
                                    .videoList .slimScrollRail{
                                        display: inherit !important;
                                        background-color: #5f5c5c !important;
                                    }
                                </style>
                                    @foreach($productsWithVideo as $key => $productVideos)
                                        <div class="col-md-6 videoList" style="margin-bottom: 10px" >
                                            <div class="mt-element-list">
                                                <div class="mt-list-head list-simple font-white bg-blue">
                                                    <div class="list-head-title-container">
                                                        <h4 class="list-title">فیلمهای {{$key}}</h4>
                                                    </div>
                                                </div>
                                                <div class="mt-list-container list-simple scroller" style="height: 200px">
                                                    <ul>
                                                        @foreach($productVideos as $video)
                                                            <li class="mt-list-item">
                                                                <div class="list-icon-container">
                                                                    <i class="fa fa-download"></i>
                                                                </div>
                                                                <div class="list-item-content">
                                                                    <p class="uppercase" style="    font-size: 16px;">
                                                                        <a href="{{action("HomeController@download" , ["content"=>"فایل محصول","fileName"=>$video["file"], "pId"=>$video["product_id"]  ])}}">دانلود {{$video["name"]}}</a>
                                                                    </p>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <style>
                                        .pamphletList .slimScrollBar{
                                            background : rgb(181, 73, 61) !important;
                                            height: 30px;
                                        }
                                        .pamphletList .slimScrollRail{
                                            display: inherit !important;
                                            background-color: #5f5c5c !important;
                                        }
                                    </style>
                                    @foreach($productsWithPamphlet as $key => $productPamphlets)
                                        <div class="col-md-6 pamphletList" style="margin-bottom: 10px">
                                            <div class="mt-element-list">
                                                <div class="mt-list-head list-simple font-white bg-red-flamingo-opacity">
                                                    <div class="list-head-title-container">
                                                        <h4 class="list-title">جزوه های {{$key}}</h4>
                                                    </div>
                                                </div>
                                                <div class="mt-list-container list-simple scroller" style="height: 100px">
                                                    <ul>
                                                        @foreach($productPamphlets as $pamphlet)
                                                            <li class="mt-list-item">
                                                                <div class="list-icon-container">
                                                                    <i class="fa fa-download"></i>
                                                                </div>
                                                                <div class="list-item-content">
                                                                    <p class="uppercase" style="    font-size: 16px;">
                                                                        <a href="{{action("HomeController@download" , ["content"=>"فایل محصول","fileName"=>$pamphlet["file"] , "pId"=>$pamphlet["product_id"] ])}}">دانلود {{$pamphlet["name"]}}</a>
                                                                    </p>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                    </div>
                                    @endforeach
                            </div>

                        </div>
                        {{--@endrole--}}
                    </div>
                </div>
                @if(!isset($descriptionIframe) || !$descriptionIframe)
                    @if($product->enable)
                        @if($product->isFree && isset($isProductExistInOrder) && $isProductExistInOrder)
                            <a href="javascript:;" class="btn btn-lg default col-md-12 col-xs-12 col-sm-12 font-red">موجود در سبد</a>
                        @else
                            <button type="button" id="orderButton2"  class="btn btn-lg green col-md-12 col-xs-12 col-sm-12"><i class="fa fa-cart-plus"></i>افزودن به سبد</button>
                        @endif
                    @else
                        <a href="javascript:;" class="btn btn-lg default col-md-12 col-xs-12 col-sm-12 font-red"> این محصول غیر فعال است</a>
                    @endif
                @endif
            </div>
        </div>

        </div>
        </div>
        @endif

        @if(!isset($descriptionIframe) || !$descriptionIframe)
            <div class="row">
                <div class="col-md-9">
                    <h3><div class="caption">

                            <span class="caption-subject text-info bold uppercase">محصولات دیگر</span>
                        </div></h3>
                </div>
                <div class="col-md-3">
                    <!-- Controls -->
                    <div class="controls pull-right xs-hidden">
                        <a class="right fa fa-chevron-right btn btn-info" href="#carousel-example"
                                                    data-slide="next"></a>
                        <a class="left fa fa-chevron-left btn btn-info" href="#carousel-example"
                           data-slide="prev"></a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="carousel-example" class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="col-item">
                                        <div class="photo">
                                            <img  src="/img/extra/landing/hamayeshAD-256x56.jpg"  class="img-responsive" alt="همایش ویژه دی ماه" />
                                        </div>
                                        <div class="info">
                                            <div class="row">
                                                <div class="price col-md-12">
                                                    <h5 class="bold text-center">
                                                        همایش ویژه دی ماه
                                                    </h5>
                                                    <h5 class="price-text-color bold">
                                                        <div class="text-center bold font-red" style="font-size: inherit">هم اکنون با تخفیف ویژه </div>
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="separator clear-left">
                                                <p class="">
                                                    <a  href="{{env("SERVER")}}/landing/1" class="btn btn-lg green hidden-sm"><i class="fa fa-cart-plus"></i>سفارش</a>
                                                </p>
                                            </div>
                                            <div class="clearfix">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @foreach($exclusiveOtherProducts as $otherProduct)
                                    <div class="col-md-3">
                                        <div class="col-item">
                                            <div class="photo">
                                                <img  src="{{ route('image', ['category'=>'4' , 'w'=>'254' , 'h'=>'254', 'filename' =>  $otherProduct->image ]) }}"  class="img-responsive" alt="عکس محصول@if(isset($otherProduct[0])) {{$otherProduct->name}} @endif" />
                                            </div>
                                            <div class="info">
                                                <div class="row">
                                                    <div class="price col-md-12">
                                                        <h5 class="bold text-center">
                                                            @if(strlen($otherProduct->name)>0 ) {{$otherProduct->name}} @endif</h5>
                                                        <h5 class="price-text-color bold">
                                                            @if($otherProduct->isFree)
                                                                <div class="text-center bold font-red" style="font-size: inherit">رایگان </div>
                                                            @elseif($otherProduct->calculatePayablePrice()["productDiscount"]+$otherProduct->calculatePayablePrice()["bonDiscount"]>0)
                                                                <div class="text-center bold font-red" style=" text-decoration: line-through;font-size: inherit">@if(isset($otherProduct->basePrice)){{number_format($otherProduct->basePrice)}} تومان@endif</div>
                                                                <div class="text-center bold font-green " style="font-size: inherit"> @if(Auth::check()) {{number_format((1-(($otherProduct->discount+$otherProduct->calculatePayablePrice()["bonDiscount"])/100))*$otherProduct->calculatePayablePrice()["cost"])}} @else @if(isset($otherProduct->basePrice)){{number_format(((1-($otherProduct->discount/100))*$otherProduct->basePrice))}} تومان@endif @endif</div>
                                                            @else
                                                                <div class="text-center bold font-green" style="padding-bottom: 28px;font-size: inherit">@if(isset($otherProduct->basePrice)){{number_format($otherProduct->basePrice)}} تومان@endif </div>
                                                            @endif
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="separator clear-left">
                                                    <p class="">
                                                        <a  href="{{action("ProductController@show" , $otherProduct)}}" class="btn btn-lg green hidden-sm"><i class="fa fa-cart-plus"></i>سفارش</a></p>
                                                </div>
                                                <div class="clearfix">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @foreach($otherProductChunks as $key=>$otherProductChunk)
                              <div class="item {{--@if($key == 0) active @endif--}}" >
                                  <div class="row">
                                        @foreach($otherProductChunk as $otherProduct)
                                            <div class="col-md-3">
                                                <div class="col-item">
                                                    <div class="photo">
                                                        <img  src="{{ route('image', ['category'=>'4' , 'w'=>'254' , 'h'=>'254', 'filename' =>  $otherProduct->image ]) }}"  class="img-responsive" alt="عکس محصول@if(isset($otherProduct[0])) {{$otherProduct->name}} @endif" />
                                                    </div>
                                                    <div class="info">
                                                        <div class="row">
                                                            <div class="price col-md-12">
                                                                <h5 class="bold text-center">
                                                                    @if(strlen($otherProduct->name)>0 ) {{$otherProduct->name}} @endif</h5>
                                                                <h5 class="price-text-color bold">
                                                                    @if($otherProduct->isFree)
                                                                        <div class="text-center bold font-red" style="font-size: inherit">رایگان </div>
                                                                    @elseif($otherProduct->calculatePayablePrice()["productDiscount"]+$otherProduct->calculatePayablePrice()["bonDiscount"]>0)
                                                                        <div class="text-center bold font-red" style=" text-decoration: line-through;font-size: inherit">@if(isset($otherProduct->basePrice)){{number_format($otherProduct->basePrice)}} تومان@endif</div>
                                                                        <div class="text-center bold font-green " style="font-size: inherit"> @if(Auth::check()) {{number_format((1-(($otherProduct->discount+$otherProduct->calculatePayablePrice()["bonDiscount"])/100))*$otherProduct->calculatePayablePrice()["cost"])}} @else @if(isset($otherProduct->basePrice)){{number_format(((1-($otherProduct->discount/100))*$otherProduct->basePrice))}} تومان@endif @endif</div>
                                                                    @else
                                                                        <div class="text-center bold font-green" style="padding-bottom: 28px;font-size: inherit">@if(isset($otherProduct->basePrice)){{number_format($otherProduct->basePrice)}} تومان@endif </div>
                                                                    @endif
                                                                </h5>
                                                            </div>
                                                            {{--<div class="rating hidden-sm col-md-6">--}}
                                                                {{--<i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">--}}
                                                                {{--</i><i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">--}}
                                                                {{--</i><i class="fa fa-star"></i>--}}
                                                            {{--</div>--}}
                                                        </div>
                                                        <div class="separator clear-left">
                                                            <p class="">
                                                                <a  href="{{action("ProductController@show" , $otherProduct)}}" class="btn btn-lg green hidden-sm"><i class="fa fa-cart-plus"></i>سفارش</a></p>
                                                        </div>
                                                        <div class="clearfix">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                  </div>
                              </div>
                        @endforeach
                    </div>
                </div>
                </div>
            </div>
        @endif

@endsection

@section("footerPageLevelPlugin")
    <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js" type="text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src="/assets/pages/scripts/ui-toastr.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/form-icheck.min.js" type="text/javascript"></script>
    {{--<script src="/assets/pages/scripts/portfolio-2.min.js" type="text/javascript"></script>--}}
    <script type="text/javascript">
                    (function($, window, document, undefined) {
                        'use strict';

                        // init cubeportfolio
                        $('#js-grid-mosaic').cubeportfolio({
                            filters: '#js-filters-mosaic',
                            loadMore: '#js-loadMore-mosaic',
                            loadMoreAction: 'click',
                            layoutMode: 'mosaic',
                            sortToPreventGaps: true,
                            mediaQueries: [{
                                width: 1500,
                                cols: 4
                            }, {
                                width: 1100,
                                cols: 4
                            }, {
                                width: 800,
                                cols: 4
                            }, {
                                width: 480,
                                cols: 4
                            }, {
                                width: 320,
                                cols: 4
                            }],
                            defaultFilter: '*',
                            animationType: 'quicksand',
                            gapHorizontal: 0,
                            gapVertical: 0,
                            gridAdjustment: 'responsive',
                            caption: 'minimal',
                            displayType: 'sequentially',
                            displayTypeSpeed: 100,

                            // lightbox
                            lightboxDelegate: '.cbp-lightbox',
                            lightboxGallery: true,
                            lightboxTitleSrc: 'data-title',
                            {{--lightboxCounter: '<div class="cbp-popup-lightbox-counter">{{current}} of {{total}}</div>',--}}
                            lightboxCounter: '<div class="cbp-popup-lightbox-counter"></div>',
                        });
                        $('#js-grid-mosaic2').cubeportfolio({
                            filters: '#js-filters-mosaic',
                            loadMore: '#js-loadMore-mosaic',
                            loadMoreAction: 'click',
                            layoutMode: 'mosaic',
                            sortToPreventGaps: true,
                            mediaQueries: [{
                                width: 1500,
                                cols: 4
                            }, {
                                width: 1100,
                                cols: 4
                            }, {
                                width: 800,
                                cols: 4
                            }, {
                                width: 480,
                                cols: 4
                            }, {
                                width: 320,
                                cols: 4
                            }],
                            defaultFilter: '*',
                            animationType: 'quicksand',
                            gapHorizontal: 0,
                            gapVertical: 0,
                            gridAdjustment: 'responsive',
                            caption: 'minimal',
                            displayType: 'sequentially',
                            displayTypeSpeed: 100,

                            // lightbox
                            lightboxDelegate: '.cbp-lightbox',
                            lightboxGallery: true,
                            lightboxTitleSrc: 'data-title',
                            lightboxCounter: '<div class="cbp-popup-lightbox-counter"> @{{current}} of  @{{total}}</div>',
                        });
                    })(jQuery, window, document);
                </script>
@endsection

@section("extraJS")
    <script src="/js/extraJS/jQueryNumberFormat/jquery.number.min.js" type="text/javascript"></script>
    @if(!isset($descriptionIframe) || !$descriptionIframe)
        <script>
            var liveNationalServer ="http://185.49.84.107:9092/index3.html";
            var liveYoutubeServer ="https://www.youtube.com/embed/Tjxys29-bKM";
            @if( $productType == Config::get("constants.PRODUCT_TYPE_SELECTABLE"))
                     @if(isset($childrenArray) && count($childrenArray)==1 && empty($childrenArray[0]["children"]))
                        $(".product").trigger('change').attr('checked', 'checked');
                    @endif
                var refreshPriceType= "productSelection";
            @else
                var refreshPriceType= "mainAttribute";
            @endif
            $(".isDefault").trigger('change').attr('checked', 'checked');
            @if($product->id == Config::get("constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_ROOT"))
                $(":checkbox[value="+{{Config::get('constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_DEFAULT')}}+"]").iCheck('disable');
                $( ".children_"+{{Config::get('constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_ALLTOGHETHER')}} ).append( "<input type='hidden' name='products[]' value='"+{{Config::get('constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_DEFAULT')}}+"'>" );
            @endif

            $("#liveFrame").attr("src", liveNationalServer);
            $(".chooseServerButton").click(function () {
                if($(this).attr("id") == "nationalServer")
                {
                    $("#liveFrame").attr("src", liveNationalServer);
                }else if($(this).attr("id") == "youtubeServer")
                {
                    $("#liveFrame").attr("src", liveYoutubeServer);
                }
                // $(".chooseServer").hide();
                // $("#liveFrame").fadeIn(3000);
            });
        </script>
        <script src="/js/extraJS/product-show-v12.js" type="text/javascript"></script>
    @endif
@endsection
