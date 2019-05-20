@extends('app')
@section('page-css')
    <link href="{{ mix('/css/product-show.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="flaticon-home-2 m--padding-right-5"></i>
                <a class="m-link" href="{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item">
                <i class="fa fa-chalkboard-teacher"></i>
                <a class="m-link" href="{{ action("Web\ShopPageController") }}">محصولات آموزشی</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#"> {{ $product->name }} </a>
            </li>
        </ol>
    </nav>
@endsection
@section('content')

    <div class="row">
        <div class="col">
            @include('systemMessage.flash')
        </div>
    </div>

    <div class="row" id="a_top_section">
        <div class="col">
            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__body">
                    <!--begin::Section-->
                    <div class="m-section m-section--last">
                        <div class="m-section__content">
                            <!--begin::Preview-->
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="m--margin-bottom-45">
                                        <img src="{{$product->photo}}" alt="عکس محصول@if(isset($product->name)) {{$product->name}} @endif" class="img-fluid m--marginless"/>
                                        @if(isset($product->bons->first()->pivot->bonPlus))
                                            <div class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-success alert-dismissible fade show" role="alert">
                                                <div class="m-alert__icon">
                                                    <i class="flaticon-interface-9"></i>
                                                </div>
                                                <div class="m-alert__text">
                                                    <strong>تعداد بن {{ $product->bons->first()->pivot->bonPlus }}+</strong>
                                                </div>
                                            </div>
                                        @else
                                            <div class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-warning alert-dismissible fade show" role="alert">
                                                <div class="m-alert__icon">
                                                    <i class="flaticon-interface-9"></i>
                                                </div>
                                                <div class="m-alert__text">
                                                    این محصول بن ندارد
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    {{--نمونه جزوه--}}
                                    @include('product.partials.pamphlet')

                                    {{--@if(isset($product->introVideo) || $product->gift->isNotEmpty())--}}
                                        {{--نمونه جزوه--}}
                                        {{--@include('product.partials.pamphlet')--}}
                                    {{--@endif--}}

                                </div>
                                <div class="col">

                                    {{--ویژگی ها و دارای --}}
                                    <div class="row">
                                        @if(optional(optional(optional($product->attributes)->get('information'))->where('control', 'simple'))->count()>0 ||  optional(optional( optional($product->attributes)->get('main'))->where('control', 'simple'))->count()>0)
                                            <div class="col">

                                                <div class="m-portlet m-portlet--bordered m-portlet--full-height">
                                                    <div class="m-portlet__head">
                                                        <div class="m-portlet__head-caption">
                                                            <div class="m-portlet__head-title">
                                                                <h3 class="m-portlet__head-text">
                                                                    ویژگی ها
                                                                </h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="m-portlet__body m--padding-top-5 m--padding-bottom-5 m--padding-right-10 m--padding-left-10">
                                                        <!--begin::m-widget4-->
                                                        <div class="m-widget4">
    
                                                            @if(optional(optional(optional($product->attributes)->get('information'))->where('control', 'simple'))->count())
                                                                @foreach($product->attributes->get('information')->where('control', 'simple') as $key => $informationItem)

                                                                    <div class="m-widget4__item  m--padding-top-5 m--padding-bottom-5">
                                                                        <div class="m-widget4__img m-widget4__img--icon">
                                                                            <i class="flaticon-like m--font-info"></i>
                                                                        </div>
                                                                        <div class="m-widget4__info">
                                                                            <span class="m-widget4__text">
                                                                                {{ $informationItem->title . ': ' . $informationItem->data[0]->name }}
                                                                            </span>
                                                                        </div>
                                                                    </div>

                                                                @endforeach
                                                            @endif
    
                                                            @if(optional($product->attributes)->get('main') != null && $product->attributes->get('main')->where('control', 'simple'))
                                                                @foreach($product->attributes->get('main')->where('control', 'simple') as $key => $informationItem)

                                                                    <div class="m-widget4__item m--padding-top-5 m--padding-bottom-5">
                                                                        <div class="m-widget4__img m-widget4__img--icon">
                                                                            <i class="flaticon-like m--font-warning"></i>
                                                                        </div>
                                                                        <div class="m-widget4__info">
                                                                            <span class="m-widget4__text">
                                                                                {{ $informationItem->title . ': ' . $informationItem->data[0]->name }}
                                                                            </span>
                                                                        </div>

                                                                        @foreach($informationItem->data as $k => $info)
                                                                            @if(isset($info->id))
                                                                                <input type="hidden" value="{{ $info->id }}" name="attribute[]">
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                @endforeach
                                                            @endif

                                                        </div>
                                                        <!--end::Widget 9-->
                                                    </div>
                                                </div>

                                            </div>
                                        @endif
                                        @if(optional(optional(optional($product->attributes)->get('information'))->where('control', 'checkBox'))->count())
                                            <div class="col">

                                                <div class="m-portlet m-portlet--bordered m-portlet--full-height">
                                                    <div class="m-portlet__head">
                                                        <div class="m-portlet__head-caption">
                                                            <div class="m-portlet__head-title">
                                                                <h3 class="m-portlet__head-text">
                                                                    دارای
                                                                </h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="m-portlet__body m--padding-5">
                                                        <!--begin::m-widget4-->
                                                        <div class="m-widget4">
                                                            
                                                            @foreach($product->attributes->get('information')->where('control', 'checkBox') as $key => $informationItem)
                                                                <div class="m-widget4__item  m--padding-top-5 m--padding-bottom-5 m--padding-right-10 m--padding-left-10 a--full-width">
                                                                    {{ $informationItem->title }} :
                                                                </div>
                                                                @foreach($informationItem->data as $key => $informationItemData)
                                                                    <div class="m-widget4__item  m--padding-top-5 m--padding-bottom-5 m--padding-right-10 m--padding-left-10">
                                                                        <div class="m-widget4__img m-widget4__img--icon">
                                                                            <i class="fa fa-check"></i>
                                                                        </div>
                                                                        <div class="m-widget4__info">
                                                                            <span class="m-widget4__text">
                                                                                {{ $informationItemData->name }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endforeach

                                                        </div>
                                                        <!--end::Widget 9-->
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    {{--خدمات اضافی--}}
                                    @if(optional(optional($product->attributes)->get('extra'))->count())
                                        <div class="m-portlet  m-portlet--creative m-portlet--bordered-semi">
                                            <div class="m-portlet__head">
                                                <div class="m-portlet__head-caption col">
                                                    <div class="m-portlet__head-title">
                                                                    <span class="m-portlet__head-icon">
                                                                        <i class="flaticon-confetti"></i>
                                                                    </span>
                                                        <h3 class="m-portlet__head-text">
                                                            خدماتی که برای این محصول نیاز دارید را انتخاب کنید:
                                                        </h3>
                                                        <h2 class="m-portlet__head-label m-portlet__head-label--warning">
                                                            <span>خدمات</span>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-portlet__body">

                                                @include("product.partials.extraSelectCollection")
                                                @include("product.partials.extraCheckboxCollection" , ["withExtraCost"])

                                            </div>
                                        </div>
                                    @endif

                                    {{--محصول ساده یا قابل پیکربندی و یا قابل انتخاب--}}
                                    @if(in_array($product->type['id'] ,[config("constants.PRODUCT_TYPE_SELECTABLE")]))
                                        <div class="m-portlet m-portlet--bordered m-portlet--creative m-portlet--bordered-semi">
                                            <div class="m-portlet__head">
                                                <div class="m-portlet__head-caption col">
                                                    <div class="m-portlet__head-title">
                                                                <span class="m-portlet__head-icon">
                                                                    <i class="flaticon-multimedia-5"></i>
                                                                </span>
                                                        <h3 class="m-portlet__head-text">
                                                            موارد مورد نظر خود را انتخاب کنید:
                                                        </h3>
                                                        <h2 class="m-portlet__head-label m-portlet__head-label--info">
                                                            <span>انتخاب محصول</span>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-portlet__body">

                                                <ul class="m-nav m-nav--active-bg" id="m_nav" role="tablist">
                                                    @if(isset($product->children) && !empty($product->children))
                                                        @foreach($product->children as $p)
                                                            @include('product.partials.showChildren',['product' => $p , 'color' => 1])
                                                        @endforeach
                                                    @endif
                                                </ul>

                                            </div>
                                        </div>
                                    @elseif(in_array($product->type['id'] ,[Config::get("constants.PRODUCT_TYPE_SIMPLE")]))
                                    @elseif(in_array($product->type['id'], [Config::get("constants.PRODUCT_TYPE_CONFIGURABLE")]))
                                        <div class="m-portlet m-portlet--bordered m-portlet--creative m-portlet--bordered-semi">
                                            <div class="m-portlet__head">
                                                <div class="m-portlet__head-caption col">
                                                    <div class="m-portlet__head-title">
                                                                <span class="m-portlet__head-icon">
                                                                    <i class="flaticon-settings-1"></i>
                                                                </span>
                                                        <h3 class="m-portlet__head-text">
                                                            ویژگی های مورد نظر خود را انتخاب کنید:
                                                        </h3>
                                                        <h2 class="m-portlet__head-label m-portlet__head-label--info">
                                                            <span>ویژگی های محصول</span>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-portlet__body">
    
                                                @if(optional(optional(optional($product->attributes)->get('main'))->where('type', 'main'))->count()>0)

                                                    @if($product->attributes->get('main')->where('type', 'main')->where('control', 'dropDown')->count()>0)
                                                        @foreach($product->attributes->get('main')->where('type', 'main')->where('control', 'dropDown') as $index => $select)

                                                            <div class="form-group m-form__group">
                                                                <label for="exampleSelect1">{{ $select->title }}</label>
                                                                <select name="attribute[]" class="form-control m-input attribute">
                                                                    @foreach($select->data as $dropdownIndex => $dropdownOption)
                                                                        <option value="{{ $dropdownOption->id }}">{{ $dropdownOption->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                        @endforeach
                                                    @endif

                                                    @if($product->attributes->get('main')->where('type', 'main')->where('control', 'checkBox')->count()>0)
                                                        @foreach($product->attributes->get('main')->where('type', 'main')->where('control', 'checkBox') as $index => $select)

                                                            <label class="m-checkbox m-checkbox--air m-checkbox--state-success">
                                                                <input type="checkbox" name="attribute[]" value="{{ $select->data[0]->id }}" class="attribute">
                                                                {{ $select->data[0]->name }}
                                                                <span></span>
                                                            </label>

                                                        @endforeach
                                                    @endif

                                                @endif

                                            </div>
                                        </div>
                                    @endif

                                    {!! Form::hidden('product_id',$product->id) !!}

                                    {{--دکمه افزودن به سبد خرید--}}
                                    @if($product->enable)
                                        <h5 class="m--font-danger">
                                                <span id="a_product-price">
                                                    @if($product->priceText['discount'] == 0 )
                                                         {{ $product->priceText['basePriceText'] }}
                                                    @else
                                                        قیمت محصول: <strike>{{ $product->priceText['basePriceText'] }} </strike><br>
                                                        قیمت برای مشتری:  {{ $product->priceText['finalPriceText'] }}
                                                    @endif
                                                </span>
                                            <span id="a_product-discount"></span>
                                        </h5>

                                        <button class="btn m-btn--pill m-btn--air btn-primary btn-lg m-btn--icon btnAddToCart">
                                            <span>
                                                <i class="flaticon-bag"></i>
                                                <i class="fas fa-sync-alt fa-spin m--hide"></i>
                                                <span>افزودن به سبد خرید</span>
                                            </span>
                                        </button>
                                    @else
                                        <button class="btn btn-danger btn-lg m-btn  m-btn m-btn--icon">
                                                    <span>
                                                        <i class="flaticon-shopping-basket"></i>
                                                        <span>این محصول غیر فعال است.</span>
                                                    </span>
                                        </button>
                                    @endif

                                </div>
                                <div class="col-lg-4">

                                    <div class="m-portlet m-portlet--bordered-semi m-portlet--rounded-force m--margin-bottom-45 videoPlayerPortlet @if(!isset($product->introVideo)) m--hide @endif">
                                        <div class="m-portlet__head m-portlet__head--fit"></div>
                                        <div class="m-portlet__body m--padding-bottom-5">
                                            <div class="m-widget19">
                                                <div class="m-widget19__pic m-portlet-fit--top m-portlet-fit--sides">

                                                    <video
                                                            id="videoPlayer"
                                                            class="
                                                           video-js
                                                           vjs-fluid
                                                           vjs-default-skin
                                                           vjs-big-play-centered"
                                                            controls
                                                            {{-- preload="auto"--}}
                                                            preload="none"
                                                            poster = 'https://cdn.sanatisharif.ir/media/204/240p/204054ssnv.jpg'>
    
                                                        {{--                                                        <source--}}
                                                        {{--                                                                src="{{$product->introVideo}}"--}}
                                                        {{--                                                                id="videoPlayerSource"--}}
                                                        {{--                                                                type = 'video/mp4'/>--}}

                                                        {{--<p class="vjs-no-js">جهت پخش آنلاین فیلم، ابتدا مطمئن شوید که جاوا اسکریپت در مرور گر شما فعال است و از آخرین نسخه ی مرورگر استفاده می کنید.</p>--}}
                                                    </video>

                                                    <div class="m-widget19__shadow"></div>
                                                </div>
                                                <div class="m-widget19__content">
                                                    <div class="m-widget19__header">
                                                        <h4 id="videoPlayerTitle">
                                                            کلیپ معرفی
                                                        </h4>
                                                    </div>
                                                    <div class="m-widget19__body text-left" id="videoPlayerDescription"></div>
                                                </div>
                                            </div>
                                            </div>
                                    </div>

                                    @if(isset($product->gift) && $product->gift->isNotEmpty())
                                        <div class="m-portlet m-portlet--bordered m-portlet--creative m-portlet--bordered-semi m--margin-top-25">
                                            <div class="m-portlet__head">
                                                <div class="m-portlet__head-caption col">
                                                    <div class="m-portlet__head-title">
                                                        <span class="m-portlet__head-icon">
                                                            <i class="flaticon-gift"></i>
                                                        </span>
                                                        <h3 class="m-portlet__head-text">
                                                            این محصول شامل هدایای زیر می باشد:
                                                        </h3>
                                                        <h2 class="m-portlet__head-label m-portlet__head-label--accent">
                                                            <span>هدایا</span>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-portlet__body">
                                                <div class="row justify-content-center productGifts">
                                                    @foreach($product->gift as $gift)
                                                        <div class="col-12">
                                                            @if(strlen($gift->url)>0)
                                                                <a target="_blank" href="{{ $gift->url }}">
                                                                    <div>
                                                                        <img src="{{ $gift->photo }}" class="rounded-circle">
                                                                    </div>
                                                                    <div>
                                                                        <button type="button" class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-info m-btn--gradient-to-accent">
                                                                            {{ $gift->name }}
                                                                        </button>
                                                                    </div>
                                                                </a>
                                                            @else
                                                                <div>
                                                                    <img src="{{ $gift->photo }}" class="rounded-circle">
                                                                </div>
                                                                <div>
                                                                    <button type="button" class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-info m-btn--gradient-to-accent">
                                                                        {{ $gift->name }}
                                                                    </button>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    {{--@if(!isset($product->introVideo) && $product->gift->isEmpty())--}}
                                        {{--نمونه جزوه--}}
                                        {{--@include('product.partials.pamphlet')--}}
                                    {{--@endif--}}
                                </div>
                            </div>
                            <!--end::Preview-->
                        </div>
                    </div>
                    <!--end::Section-->
                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>

    @if(isset($product->specialDescription))
        <div class="row">
            {!! $product->specialDescription !!}
        </div>
    @endif
    <div class="row">
        <div class="col">

            <div class="m-portlet m-portlet--tabs productDetailes">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand  m-tabs-line--right m-tabs-line-danger" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#productInformation" role="tab" aria-selected="true">
                                    <i class="flaticon-information"></i>
                                    <h5>بررسی محصول {{ $product->name }}</h5>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <button class="btn m-btn--pill m-btn--air btn-primary btn-lg m-btn--icon btnAddToCart">
                                <span>
                                    <i class="flaticon-bag"></i>
                                    <i class="fas fa-sync-alt fa-spin m--hide"></i>
                                    <span>افزودن به سبد خرید</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="productInformation">
                            {!! $product->shortDescription !!}
                            @if( isset($product->longDescription[0] ) )
                                <div>
                                    {!!   $product->longDescription !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('page-js')
    <script src="{{ mix('/js/product-show.js') }}"></script>
    <script>

        var player = videojs('videoPlayer', {language: 'fa'});

        jQuery(document).ready(function () {
        
            @if( $product->introVideo )
            player.src([
                {type: "video/mp4", src: "{{ $product->introVideo }}"}
            ]);
            @endif

            player.nuevo({
                // logotitle:"آموزش مجازی آلاء",
                // logo:"https://sanatisharif.ir/image/11/135/67/logo-150x22_20180430222256.png",
                logocontrolbar: '/acm/extra/Alaa-logo.gif',
                // logoposition:"RT", // logo position (LT - top left, RT - top right)
                logourl: '//sanatisharif.ir',
                // related: related_videos,
                // shareUrl:"https://www.nuevolab.com/videojs/",
                // shareTitle: "Nuevo plugin for VideoJs Player",
                // slideImage:"//cdn.nuevolab.com/media/sprite.jpg",

                // videoInfo: true,
                // infoSize: 18,
                // infoIcon: "https://sanatisharif.ir/image/11/150/150/favicon_32_20180819090313.png",

                closeallow: false,
                mute: true,
                rateMenu: true,
                resume: true, // (false) enable/disable resume option to start video playback from last time position it was left
                // theaterButton: true,
                timetooltip: true,
                mousedisplay: true,
                endAction: 'related', // (undefined) If defined (share/related) either sharing panel or related panel will display when video ends.
                container: "inline",


                // limit: 20,
                // limiturl: "http://localdev.alaatv.com/videojs/examples/basic.html",
                // limitimage : "//cdn.nuevolab.com/media/limit.png", // limitimage or limitmessage
                // limitmessage: "اگه می خوای بقیه اش رو ببینی باید پول بدی :)",


                // overlay: "//domain.com/overlay.html" //(undefined) - overlay URL to display html on each pause event example: https://www.nuevolab.com/videojs/tryit/overlay

            });

            player.hotkeys({
                volumeStep: 0.1,
                seekStep: 5,
                alwaysCaptureHotkeys: true
            });

            player.pic2pic();

            // player.on('mode',function(event,mode) {
            //     console.log('mode: ', mode);
            //     let width = '100%';
            //     if(mode=='large') {
            //         // $('.productDetailesColumns .column1').addClass('order-2');
            //         // $('.productDetailesColumns .column2').addClass('order-3');
            //         $('.productDetailesColumns .column3').addClass('order-first');
            //         $('.productDetailesColumns .column3').removeClass('col-lg-4');
            //         $('.productDetailesColumns .column3').addClass('col-lg-12');
            //         $('.productDetailesColumns .column3 .videoPlayerPortlet').css({'width':'60%'});
            //     } else {
            //         // $('.productDetailesColumns .column1').removeClass('order-2');
            //         // $('.productDetailesColumns .column2').removeClass('order-3');
            //         $('.productDetailesColumns .column3').removeClass('order-first');
            //         $('.productDetailesColumns .column3').removeClass('col-lg-12');
            //         $('.productDetailesColumns .column3').addClass('col-lg-4');
            //         $('.productDetailesColumns .column3 .videoPlayerPortlet').css({'width':'100%'});
            //     }
            // });

        });

    </script>
@endsection
