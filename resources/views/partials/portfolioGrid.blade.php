@if(isset($withFilterButton) && $withFilterButton)
    <div id="js-filters-juicy-projects" class="cbp-l-filters-button" dir="ltr">
    <div data-filter="*" class="cbp-filter-item btn dark btn-outline uppercase"> همه
        {{--<div class="cbp-filter-counter"></div>--}}
    </div>
    <div data-filter=".hamayesh" class="cbp-filter-item btn dark btn-outline uppercase "> همایش ها
        {{--<div class="cbp-filter-counter"></div>--}}
    </div>
    <div data-filter=".ketab" class="cbp-filter-item-active cbp-filter-item btn dark btn-outline uppercase"> کتاب ها
        {{--<div class="cbp-filter-counter"></div>--}}
    </div>
    <div data-filter=".ordoo" class="cbp-filter-item-active cbp-filter-item btn dark btn-outline uppercase"> اردوها
        {{--<div class="cbp-filter-counter"></div>--}}
    </div>
</div>
@endif
<div id="js-grid-juicy-projects" class="cbp" >
    @if(strcmp(url()->current() , action("HomeController@index")) == 0)
        <div class="cbp-item hamayesh " >
            <div class="cbp-caption">
                <div class="cbp-caption-defaultWrap">
                    <img  src="http://takhtekhak.com/image/4/256/256/arabi-naseh_20180206093949.jpg"  alt="جمع بندی عربی کنکور میلاد ناصح زاده">
                </div>
                <div class="cbp-caption-activeWrap">
                    <div class="cbp-l-caption-alignCenter">
                        <div class="cbp-l-caption-body">
                            {{--ToDo : add get parameter to action--}}
                            {{--<a href="{{action("ProductController@showPartial" , $product)}}" class="cbp-singlePage cbp-l-caption-buttonLeft btn red uppercase" >اطلاعات بیشتر</a>--}}
                            <a href="{{action("ProductController@showLive" , 183)}}" class="btn green uppercase">تماشا</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cbp-l-grid-projects-title uppercase text-center">جمع بندی عربی کنکور</div>
            <div class="cbp-l-grid-projects-desc text-center bold font-red product-potfolio-no-cost">تماشای رایگان</div>

        </div>
    @endif
    @if(isset($withAd) && $withAd)
    <div class="cbp-item hamayesh " >
        <div class="cbp-caption">
            <div class="cbp-caption-defaultWrap">
                <img  src="/img/extra/landing/hamayeshAD-256x56.jpg"  alt="همایش ویژه دی ماه">
            </div>
            <div class="cbp-caption-activeWrap">
                <div class="cbp-l-caption-alignCenter">
                    <div class="cbp-l-caption-body">
                        {{--ToDo : add get parameter to action--}}
                        {{--<a href="{{action("ProductController@showPartial" , $product)}}" class="cbp-singlePage cbp-l-caption-buttonLeft btn red uppercase" >اطلاعات بیشتر</a>--}}
                        <a href="{{action("ProductController@landing1")}}" class="btn green uppercase">سفارش</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="cbp-l-grid-projects-title uppercase text-center">همایش ویژه دی ماه</div>
        <div class="cbp-l-grid-projects-desc text-center bold font-red product-potfolio-no-cost">قیمت: پس از انتخاب محصول</div>

    </div>
    @endif
    @foreach($products as $product)
        <div class="cbp-item @if(str_contains($product->name, 'همایش')) hamayesh @elseif(str_contains($product->name, 'اردو')) ordoo @elseif(str_contains($product->name, 'کتاب')) ketab @endif " >
            <div class="cbp-caption">
                <div class="cbp-caption-defaultWrap">
                    @if(strlen($product->image)>0)<img  src="{{ route('image', ['category'=>'4','w'=>'256' , 'h'=>'256' ,  'filename' =>  $product->image ]) }}"  alt="عکس محصول@if(isset($product->name[0])) {{$product->name}} @endif"> @endif
                </div>
                <div class="cbp-caption-activeWrap">
                    <div class="cbp-l-caption-alignCenter">
                        <div class="cbp-l-caption-body">
                            {{--ToDo : add get parameter to action--}}
                            <a href="{{action("ProductController@showPartial" , $product)}}" class="cbp-singlePage cbp-l-caption-buttonLeft btn red uppercase" >اطلاعات بیشتر</a>
                            <a href="{{action("ProductController@show" , $product)}}" class="btn green uppercase"><i class="fa fa-shopping-cart"></i>سفارش</a>
                        </div>
                    </div>
                </div>
            </div>
            @if(strlen($product->name)>0)<div class="cbp-l-grid-projects-title uppercase text-center">{{$product->name}}</div>@endif
            {{--ToDo: add code for product discount--}}
            @if($product->isFree)
                <div class="cbp-l-grid-projects-desc text-center bold font-red product-potfolio-free" >رایگان </div>
            @elseif($product->basePrice == 0)
                <div class="cbp-l-grid-projects-desc text-center bold font-blue product-potfolio-no-cost">قیمت: پس از انتخاب محصول</div>
            @elseif($costCollection[$product->id]["productDiscount"]+$costCollection[$product->id]["bonDiscount"]>0)
                <div class="cbp-l-grid-projects-desc text-center bold font-red product-potfolio-real-cost">@if(isset($costCollection[$product->id]["cost"])){{number_format($costCollection[$product->id]["cost"])}} تومان@endif</div>
                <div class="cbp-l-grid-projects-desc text-center bold font-green product-potfolio-discount-cost"> @if(Auth::check()) {{number_format((1 - ($costCollection[$product->id]["bonDiscount"] / 100)) * ((1 - ($costCollection[$product->id]["productDiscount"] / 100)) * $costCollection[$product->id]["cost"]))}} @else @if(isset($costCollection[$product->id]["cost"])){{number_format(((1-($costCollection[$product->id]["productDiscount"]/100))*$costCollection[$product->id]["cost"]))}} تومان@endif @endif</div>
            @else
                <div class="cbp-l-grid-projects-desc text-center bold font-green product-potfolio-no-discount">@if(isset($costCollection[$product->id]["cost"])){{number_format($costCollection[$product->id]["cost"])}} تومان@endif </div>
            @endif

        </div>
        {{--@endif--}}
    @endforeach
</div>
<a class="btn red btn-outline sbold hidden" id="welcomeMessage" data-toggle="modal" href="#basic"></a>