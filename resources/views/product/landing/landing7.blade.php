@extends('app')

@section('page-css')
    <link href="{{ mix('/css/page-landing7.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="m-portlet m-portlet--head-overlay m-portlet--full-height  m-portlet--rounded-force">
    
                <div>
                    <img src="https://cdn.sanatisharif.ir/upload/landing/sslide-5.jpg" class="a--full-width">
                </div>
                <div class="m-portlet__body">
                    <div class="m-widget27 m-portlet-fit--sides">
                        <div class="m-widget27__container">
                            <div class="container-fluid m--padding-right-40 m--padding-left-40">
                                
                                <div class="row">
                                    <div class="col text-center">
                                        <h3 class="text-center">
                                            <a href="{{ action("Web\ShopPageController") }}" class="m-link"><span class="m--font-primary">👈همایش ها، کاملا رایگان👉</span></a>
                                        </h3>
                                        برای کسانی که استعداد و تلاش را یکجا به کار گرفته اند
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 mx-auto">
                                        <div class="m-divider m--margin-top-25">
                                            <span></span>
                                            <span>
                                                <h4>
                                                    رتبه های زیر ۱۰۰۰ کنکور ۹۸
                                                </h4>
                                            </span>
                                            <span></span>
                                        </div>
                                        <br>
                                        رتبه های زیر ۱۰۰۰ فردای اعلام نتایج با بازگشت سرمایه گذاری خود به صورت نقدی، هزینه ای برای همایش ها یا دیگر محصولات آلاء نپرداخته اند.
                                        <br>
                                        <span class="m-badge m-badge--info m-badge--dot"></span> رتبه‌های مناطق، شاهد و ایثارگر و کشور قابل قبول است
                                        <br>
                                        <span class="m-badge m-badge--info m-badge--dot"></span> آغاز طرح از تاریخ ۲۶ اردیبهشت ۹۸
    
                                        <br>
                                        <br>
                                        
                                        رتبه های زیر ۱۰۰۰ هر سه رشته ریاضی و تجربی و انسانی آلاء در کنکور ۹۸، هزینه تمام محصولات و همایش های خریداری شده از ۲۶ اردیبهشت ۹۸ تا روز کنکور را به عنوان
                                        <span class="m--font-primary">هدیه و بورس تحصیلی سال دوازدهم</span>
                                        دریافت خواهند کرد.
    
                                        <br>
                                        <br>
                                        <div class="m--font-boldest text-center">با استعداد و تلاش خودتون، اولین مزد زحماتتون رو از ما بگیرید.</div>
                                        
                                        <br>
                                        <br>
                                        <div class="alert alert-warning text-center" role="alert">
                                            <strong>
                                                آلاء با تمام بضاعت خودش، مخاطبین وفادارش رو با بهترین توانایی هاشون به میدان کنکور میفرسته.
                                            </strong>
                                        </div>
                                        
                                        
                                        
                                        <h5 class="m--margin-top-35 text-center d-none">با آلاء مستحکم در مسیر موفقیت خواهید بود.</h5>
                                        <br>
                                        
                                    </div>
                                </div>
                                
                            </div>
                            
{{--                            <div class="row">--}}
{{--                                <div class="col">--}}
{{--                                    <img src="{{ asset('/assets/extra/landing7/title.png') }}" alt="همایش های آلاء" class="a--full-width">--}}
{{--                                </div>--}}
{{--                            </div>--}}
    
                            <div class="row alaaMaghtaLogoWraper">
                                <div class="col col-md-4">
                                    <a href="konkoor98" class="btnScroll">
                                        <img src="{{ asset('/assets/extra/landing7/80.png') }}" class="a--full-width alaaMaghtaLogo">
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a href="taftan" class="btnScroll">
                                        <img src="{{ asset('/assets/extra/landing7/60.png') }}" class="a--full-width alaaMaghtaLogo">
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a href="konkoor2" class="btnScroll">
                                        <img src="{{ asset('/assets/extra/landing7/33.png') }}" class="a--full-width alaaMaghtaLogo">
                                    </a>
                                </div>
                            </div>
    
    
                            @foreach($blocks as $block)
                                @if($block->products->count() > 0)
                                    
                                    <div class="row shopBlock blockId-{{ $block->id }} {{ $block->class }}" >
                                        <div class="col">
                                            <div class="m-portlet  m-portlet--bordered OwlCarouselType2-shopPage" id="owlCarousel_{{ $block->id }}">
                                                <div class="m-portlet__head">
                                                    <div class="m-portlet__head-caption">
                                                        <div class="m-portlet__head-title">
                                                            <h3 class="m-portlet__head-text">
                                                                <a href="{{ $block->url }}" class="m-link">
                                                                    {{ $block->title }}
                                                                </a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div class="m-portlet__head-tools">
                                                        <a href="#" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air d-none d-md-block d-lg-block d-sm-block btn-viewGrid">
                                                            <i class="fa flaticon-shapes"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air btn-viewOwlCarousel">
                                                            <i class="flaticon-more-v4"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="m-portlet__body m-portlet__body--no-padding">
                                                    <!--begin::Widget 30-->
                                                    <div class="m-widget30">
                                
                                                        <div class="m-widget_head">
                                                            <div class="m-widget_head-owlcarousel-items owl-carousel a--owl-carousel-type-2 carousel_block_{{ $block->id }}">
                                                                @foreach($block->products as $productKey=>$product)
                                                                    <div class="m-widget_head-owlcarousel-item carousel background-gradient" data-position="{{ $productKey }}">
                                                                        <a href="{{ $product->url }}" >
                                                                            <img class="a--owl-carousel-type-2-item-image" src="{{ $product->photo }}">
                                                                        </a>
                                                                        <div class="m--font-primary a--owl-carousel-type-2-item-title">
                                                    <span class="m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                        @if($product->price['final']!=$product->price['base'])
                                                            <span class="m-badge m-badge--warning a--productRealPrice">{{ number_format($product->price['base']) }}</span>
                                                        @endif
                                                        {{ number_format($product->price['final']) }} تومان
                                                        @if($product->price['final']!==$product->price['base'])
                                                            <span class="m-badge m-badge--info a--productDiscount">{{ round((1-($product->price['final']/$product->price['base']))*100) }}%</span>
                                                        @endif
                                                    </span>
                                                                        </div>
                                                                        <a href="{{ $product->url }}" target="_blank" class="m-link a--owl-carousel-type-2-item-subtitle">{{ $product->name }}</a>
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
                                    
                                @endif
                            @endforeach
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('page-js')
    <script src="{{ mix('/js/page-shop.js') }}"></script>
    <script>
        $(document).on('click', '.btnScroll', function (e) {
            e.preventDefault();
            let blockId = $(this).attr('href');
            if ($('.' + blockId).length > 0) {
                $([document.documentElement, document.body]).animate({
                    scrollTop: $('.'+blockId).offset().top - 75
                }, 500);
            }
        });
    </script>
@endsection
