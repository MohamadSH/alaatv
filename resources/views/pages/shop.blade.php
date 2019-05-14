@extends('app' , ["pageName"=>$pageName])

@section('page-css')
    <link href = "{{ mix('/css/page-shop.css') }}" rel = "stylesheet" type = "text/css"/>
@endsection
@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "flaticon-home-2"></i>
                <a href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                فروشگاه آلاء
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    @include('partials.slideShow1' ,['marginBottom'=>'25'])
    <div class = "m--clearfix"></div>
    <!--begin:: Widgets/Stats-->
    <div class = "m-portlet ">
        <div class = "m-portlet__body  m-portlet__body--no-padding">
            <div class = "row m-row--no-padding m-row--col-separator-xl">
                <div class = "col-xs-3 col-md-3 col-lg-3 col-xl-3 m--bg-warning">
                    <a target = "_self" onclick = "$('html,body').animate({scrollTop: $('.konkoor1').offset().top - 100},'slow');" href = "#konkoor1">
                        <!--begin::Total Profit-->
                        <div class = "m-widget24 m--align-center">
                            <div class = "m-widget24__item">
                                <h2 class = "m-widget24__title">
                                    کنکور نظام قدیم
                                </h2>
                                <br>
                                <span class = "m-widget24__desc m--font-light">
                                آلاء
                                </span>
                                <div class = "m--space-10"></div>
                            </div>
                        </div>
                        <!--end::Total Profit-->
                    </a>
                </div>
                <div class = "col-xs-3 col-md-3 col-lg-3 col-xl-3 m--bg-accent">
                    <a target = "_self" onclick = "$('html,body').animate({scrollTop: $('.konkoor2').offset().top - 100},'slow');" href = "#konkoor2">
                        <!--begin::Total Profit-->
                        <div class = "m-widget24 m--align-center">
                            <div class = "m-widget24__item">
                                <h2 class = "m-widget24__title">
                                    کنکور نظام جدید
                                </h2>
                                <br>
                                <span class = "m-widget24__desc m--font-light">
				            آلاء
				            </span>
                                <div class = "m--space-10"></div>
                            </div>
                        </div>
                        <!--end::Total Profit-->
                    </a>
                </div>
                <div class = "col-xs-3 col-md-3 col-lg-3 col-xl-3 m--bg-success">
                    <a target = "_self" onclick = "$('html,body').animate({scrollTop: $('.yazdahom').offset().top - 100},'slow');" href = "#yazdahom">
                        <!--begin::Total Profit-->
                        <div class = "m-widget24 m--align-center">
                            <div class = "m-widget24__item">
                                <h2 class = "m-widget24__title">
                                    پایه یازدهم
                                </h2>
                                <br>
                                <span class = "m-widget24__desc m--font-light">
				            آلاء
				            </span>
                                <div class = "m--space-10"></div>
                            </div>
                        </div>
                        <!--end::Total Profit-->
                    </a>
                </div>
                <div class = "col-xs-3 col-md-3 col-lg-3 col-xl-3 m--bg-fill-info">
                    <a target = "_self" onclick = "$('html,body').animate({scrollTop: $('.dahom').offset().top - 100},'slow');" href = "#dahom">
                        <!--begin::Total Profit-->
                        <div class = "m-widget24 m--align-center">
                            <div class = "m-widget24__item">
                                <h2 class = "m-widget24__title">
                                    پایه دهم
                                </h2>
                                <br>
                                <span class = "m-widget24__desc m--font-light">
				            آلاء
				            </span>
                                <div class = "m--space-10"></div>
                            </div>
                        </div>
                        <!--end::Total Profit-->
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--end:: Widgets/Stats-->
    
    @foreach($blocks as $block)
        @if($block->products->count() > 0)
    
    
            <div class = "row blockId-{{ $block->id }} {{ $block->class }}">
                <div class = "col">
                    <div class = "m-portlet  m-portlet--bordered" id = "owlCarousel_{{ $block->id }}">
                        <div class = "m-portlet__head">
                            <div class = "m-portlet__head-caption">
                                <div class = "m-portlet__head-title">
                                    <h3 class = "m-portlet__head-text">
                                        <a href = "{{ $block->url }}" class = "m-link">
                                            {{ $block->title }}
                                        </a>
                                    </h3>
                                </div>
                            </div>
                            <div class = "m-portlet__head-tools">
                                <a href = "#" class = "btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air d-none d-md-block d-lg-block d-sm-block btn-viewGrid">
                                    <i class = "fa flaticon-shapes"></i>
                                </a>
                                <a href = "#" class = "btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air btn-viewOwlCarousel">
                                    <i class = "flaticon-more-v4"></i>
                                </a>
                            </div>
                        </div>
                        <div class = "m-portlet__body m-portlet__body--no-padding">
                            <!--begin::Widget 30-->
                            <div class = "m-widget30">
                        
                                <div class = "m-widget_head">
                                    <div class = "m-widget_head-owlcarousel-items owl-carousel a--owl-carousel-type-2 carousel_block_{{ $block->id }}">
                                        @foreach($block->products as $productKey=>$product)
                                            <div class = "m-widget_head-owlcarousel-item carousel background-gradient" data-position = "{{ $productKey }}">
                                                <a href="{{ $product->url }}" >
                                                    <img class = "a--owl-carousel-type-2-item-image" src = "{{ $product->photo }}">
                                                </a>
                                                <br>
                                                <div class = "m--font-primary">
                                                    <span class="m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
{{--                                                        @if($product->price['final']!=$product->price['base'])--}}
{{--                                                            <span class="m-badge m-badge--warning a--productRealPrice">{{ number_format($product->price['base']) }}</span>--}}
{{--                                                        @endif--}}
                                                        <span class="m-badge m-badge--warning a--productRealPrice">15,000</span>
                                                        {{ number_format($product->price['final']) }} تومان
{{--                                                        @if($product->price['final']!==$product->price['base'])--}}
{{--                                                            <span class="m-badge m-badge--info a--productDiscount">{{ (1-($product->price['final']/$product->price['base']))*100 }}%</span>--}}
{{--                                                        @endif--}}
                                                        <span class="m-badge m-badge--info a--productDiscount">22%</span>
                                                    </span>
                                                </div>
                                                <br>
                                                <a href="{{ $product->url }}" target="_blank" class="m-link">{{ $product->name }}</a>
                                            </div>
                                        @endforeach
                                    </div>
                            
                                </div>
                            </div>
                            <!--end::Widget 30-->
                        </div>
                    </div>
                </div>
            </div>
    
            
{{--            --}}
{{--            <div class = "row {{ $block->class }}">--}}

{{--                <div class = "col-12">--}}
{{--                    <div class = "a--devider-with-title">--}}
{{--                        <div class = "a--devider-title">--}}
{{--                            <a href = "{{ $block->url }}" class = "m-link m-link--primary">--}}
{{--                                {{ $block->title }}--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class = "col-12">--}}
{{--                    <div class = "a--owl-carousel-type-1 owl-carousel owl-theme">--}}
{{--                        @foreach($block->products as $product)--}}
{{--                            @include('partials.widgets.product2',[--}}
{{--                                'widgetTitle'      => $product->name,--}}
{{--                                'widgetPic'        => $product->photo,--}}
{{--                                'widgetLink'       => $product->url,--}}
{{--                                'widgetPrice'      => $product->priceText['basePriceText'] ,--}}
{{--                                'widgetPriceLabel' => ($product->isFree || $product->basePrice == 0 ? 0 : 1)--}}
{{--                                ])--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

            {{--@foreach($section["ads"] as $image => $link)
                @include('partials.bannerAds', ['img'=>$image , 'link'=>$link])
            @endforeach--}}
        @endif
    @endforeach


    <div class = "m-portlet">
        <div class = "m-portlet__body  m-portlet__body--no-padding">

            <div class = "m-stack m-stack--ver m-stack--desktop-and-tablet m-stack--demo ">
                <div class = "m-stack__item m-stack__item--center m-stack__item--middle">
                    <img src = "/acm/extra/Alaa-logo.gif" class = "img-fluid m--img-centered" alt = "فیلم کنکور آلاء"/>
                </div>
                <div class = "m-stack__item m-stack__item--center m-stack__item--middle">
                    <p class = "text-justify">
                        آلاء پنجره ای است رو به دور نمای آموزش کشور که می کوشد با اساتید کار بلد و مخاطبان پر تعداد و متعهد خود آموزش همگانی را در چهار گوشه ی این سرزمین در دسترس فرزندان ایران قرار دهد.
                        <br>
                        خدمات اصلی آموزش در آلاء کاملا رایگان بوده و درآمد خدمات جانبی آن صرف برپا نگه داشتن و دوام این مجموعه عام المنفعه می شود. محصولات ما پیش تر با نام های آلاء و تخته خاک در اختیار مخاطبان قرار می گرفت که برای سهولت در مدیریت و دسترسی کاربران اکنون انحصارا با نام آلاء منتشر می شود.
                    </p>
                </div>
                <div class = "m-stack__item m-stack__item--center m-stack__item--middle">
                    <img src = "/acm/extra/sharif-logo.png" class = "img-fluid m--img-centered" alt = "دبیرستان دانشگاه شریف آلاء"/>
                </div>
                <div class = "m-stack__item m-stack__item--center m-stack__item--middle">
                    <p class = "text-justify">
                        دبیرستان دانشگاه صنعتی شریف در سال 1383 تاسیس و زیر نظر دانشگاه صنعتی شریف فعالیت خود را آغاز کرد. فعالیت های آموزشی آلاء با نظارت دبیرستان دانشگاه شریف انجام می شود.
                    </p>
                </div>
            </div>
        </div>
    </div>

    @include("partials.certificates")
@endsection

@section('page-js')
    <script src = "{{ mix('/js/page-shop.js') }}"></script>
    
    <script>
    
        @foreach($blocks as $block)
            @if($block->products->count() > 0)
                $('#owlCarousel_{{ $block->id }}').OwlCarouselType2();
            @endif
        @endforeach

    </script>
@endsection
