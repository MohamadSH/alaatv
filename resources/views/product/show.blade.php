@extends('app')

@section('page-css')
    <link href="{{ mix('/css/product-show.css') }}" rel="stylesheet" type="text/css"/>
    <style>
    
        .btnAddToCart {
            font-size: 1.2rem;
            background-color: #00cc1b;
        }
    
        @if(!isset($block) || !isset($block->contents) || $block->contents->count() === 0)
            .productInfoNav-sampleVideo {
            display: none !important;
        }
        @endif
        @if(!isset($product->samplePhotos) || $product->samplePhotos->count() === 0)
            .productInfoNav-samplePamphlet {
            display: none !important;
        }
        @endif
        
        @if(
            mb_strlen(trim(strip_tags($product->shortDescription))) === 0 &&
            mb_strlen(trim(strip_tags($product->longDescription))) === 0
        )
            .productInfoNav-detailes {
            display: none !important;
        }
        @endif
        @if(!isset($block) || !isset($block->products) || $block->products->count() === 0)
            .productInfoNav-relatedProduct {
            display: none !important;
        }
        @endif
    </style>
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
            <div class="m-portlet">
                <div class="m-portlet__body">
                    <!--begin::Section-->
                    <div class="m-section m-section--last">
                        <div class="m-section__content">
                            <!--begin::Preview-->
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="m--margin-bottom-45">
                                        <img src="{{$product->photo}}" alt="عکس محصول@if(isset($product->name)) {{$product->name}} @endif" class="img-fluid m--marginless a--full-width"/>
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

                                </div>
                                <div class="col">

                                    {{--ویژگی ها و دارای --}}
                                    <div class="row">
                                        @if(optional(optional(optional($product->attributes)->get('information'))->where('control', 'simple'))->count()>0 ||  optional(optional( optional($product->attributes)->get('main'))->where('control', 'simple'))->count()>0)
                                            <div class="col">

                                                <div class="m-portlet m-portlet--bordered m-portlet--full-height productAttributes">
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
                                                                    @if(count($informationItem->data) > 1)
                                                                        <div class="m-widget4__item m--padding-top-5 m--padding-bottom-5">
                                                                            <div class="m-widget4__img m-widget4__img--icon">
                                                                                <i class="flaticon-like m--font-info"></i>
                                                                            </div>
                                                                            <div class="m-widget4__info">
                                                                                <span class="m-widget4__text">
                                                                                    {{ $informationItem->title }}:
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    @foreach($informationItem->data as $key => $informationItemData)

                                                                        <div class="m-widget4__item  m--padding-top-5 m--padding-bottom-5">
                                                                            <div class="m-widget4__img m-widget4__img--icon">
                                                                                @if(count($informationItem->data) === 1)
                                                                                    <i class="flaticon-like m--font-info"></i>
                                                                                @else
                                                                                    <i class="flaticon-interface-5 m--font-info"></i>
                                                                                @endif
                                                                            </div>
                                                                            <div class="m-widget4__info">
                                                                                <span class="m-widget4__text">
                                                                                    @if(count($informationItem->data) > 1)
                                                                                       {{ $informationItemData->name }}
                                                                                    @else
                                                                                        {{ $informationItem->title }}: {{ $informationItemData->name }}
                                                                                    @endif
                                                                                </span>
                                                                            </div>
                                                                        </div>
            
                                                                    @endforeach
                                                                @endforeach
                                                            @endif
    
                                                            @if(optional($product->attributes)->get('main') != null && $product->attributes->get('main')->where('control', 'simple'))
                                                                @foreach($product->attributes->get('main')->where('control', 'simple') as $key => $informationItem)
                                                                    @if(count($informationItem->data) > 1)
                                                                        <div class="m-widget4__item m--padding-top-5 m--padding-bottom-5">
                                                                            <div class="m-widget4__img m-widget4__img--icon">
                                                                                <i class="flaticon-like m--font-warning"></i>
                                                                            </div>
                                                                            <div class="m-widget4__info">
                                                                                <span class="m-widget4__text">
                                                                                    {{ $informationItem->title }}:
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    @foreach($informationItem->data as $key => $informationItemData)
                                                                        <div class="m-widget4__item m--padding-top-5 m--padding-bottom-5">
                                                                            <div class="m-widget4__img m-widget4__img--icon">
                                                                                @if(count($informationItem->data) === 1)
                                                                                    <i class="flaticon-like m--font-warning"></i>
                                                                                @else
                                                                                    <i class="flaticon-interface-5 m--font-warning"></i>
                                                                                @endif
                                                                            </div>
                                                                            <div class="m-widget4__info">
                                                                                <span class="m-widget4__text">
                                                                                    @if(count($informationItem->data) > 1)
                                                                                        {{ $informationItemData->name }}
                                                                                    @else
                                                                                        {{ $informationItem->title }}: {{ $informationItemData->name }}
                                                                                    @endif
                                                                                </span>
                                                                            </div>
                                                                            @if(isset($informationItemData->id))
                                                                                <input type="hidden" value="{{ $informationItemData->id }}" name="attribute[]">
                                                                            @endif
                                                                        </div>
                                                                    @endforeach
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

                                                <div class="m-portlet m-portlet--bordered m-portlet--full-height productInformation">
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
                                                                @if(count($informationItem->data) > 1)
                                                                    <div class="m-widget4__item  m--padding-top-5 m--padding-bottom-5 m--padding-right-10 m--padding-left-10 a--full-width m--font-boldest">
                                                                        {{ $informationItem->title }}
                                                                    </div>
                                                                @endif
                                                                @foreach($informationItem->data as $key => $informationItemData)
                                                                    <div class="m-widget4__item  m--padding-top-5 m--padding-bottom-5 m--padding-right-10 m--padding-left-10">
                                                                        <div class="m-widget4__img m-widget4__img--icon">
                                                                            <i class="fa fa-check"></i>
                                                                        </div>
                                                                        <div class="m-widget4__info">
                                                                            <span class="m-widget4__text">
                                                                                @if(count($informationItem->data) > 1)
                                                                                    {{ $informationItemData->name }}
                                                                                @else
                                                                                    {{ $informationItem->title }}: {{ $informationItemData->name }}
                                                                                @endif
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
                                                            @foreach($select->data as $selectData)
                                                                <label class="m-checkbox m-checkbox--air m-checkbox--state-success">
                                                                    <input type="checkbox" name="attribute[]" value="{{ $selectData->id }}" class="attribute">
                                                                    {{ $selectData->name }}
                                                                    <span></span>
                                                                </label>
                                                            @endforeach
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

                                        <button class="btn m-btn--air btn-success m-btn--icon btnAddToCart">
                                            <span>
                                                <i class="fa fa-cart-arrow-down"></i>
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
    
                                @if( isset($product->introVideo) || (isset($product->gift) && $product->gift->isNotEmpty()))
                                <div class="col-lg-4">

                                    <div class="m-portlet m-portlet--bordered-semi m-portlet--rounded-force m--margin-bottom-45 videoPlayerPortlet @if(!isset($product->introVideo)) m--hide @endif">
                                        <div class="m-portlet__body">
                                            <div class="m-widget19 a--nuevo-alaa-theme a--media-parent">
                                                <div class="m-widget19__pic m-portlet-fit--top m-portlet-fit--sides a--video-wraper">
                                                    
                                                    @if( $product->introVideo )
                                                        <input type="hidden" name="introVideo"
                                                               value="{{ $product->introVideo }}">
                                                    @endif
                                                    
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
                                                            poster = '@if(isset($product->introVideoThumbnail)) {{$product->introVideoThumbnail}} @else https://cdn.sanatisharif.ir/media/204/240p/204054ssnv.jpg @endif'>
    
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
                                </div>
                                @endif
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

    {{--نمونه فیلم--}}
    @include('product.partials.Block.block', [
        'blockTitle'=>view('product.partials.productInfoNav', ['targetId'=>'sampleVideo']),
        'blockUrlDisable'=>true,
        'blockType'=>'content',
        'blockCustomClass'=>'a--owl-carousel-type-2 productShowBlock sampleVideo a--block-widget-1',
        'blockCustomId'=>'Block-sampleVideo'
        ])
    
    {{--نمونه جزوه--}}
    @include('product.partials.pamphlet')
    
    @if(isset($product->specialDescription) && mb_strlen(trim(strip_tags($product->specialDescription))) > 0)
    
        <div class="m-portlet m-portlet--tabs m--margin-bottom-10">
            <div class="m-portlet__body">
                {!! $product->specialDescription !!}
            </div>
        </div>
        
    @endif
    
    @if(mb_strlen(trim(strip_tags($product->shortDescription))) > 0 || mb_strlen(trim(strip_tags($product->longDescription))) > 0)
        <div class="row">
            <div class="col m--margin-bottom-25">
                <div class="m-portlet m-portlet--tabs productDetailes" id="productDetailes">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    @include('product.partials.productInfoNav', ['targetId'=>'productDetailes'])
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <p class="m-portlet__nav-link m-portlet__nav-link--icon">
                                        
                                        <button class="btn m-btn--air btn-success m-btn--icon btnAddToCart">
                                            <span>
                                                <i class="fa fa-cart-arrow-down"></i>
                                                <i class="fas fa-sync-alt fa-spin m--hide"></i>
                                                <span>افزودن به سبد خرید</span>
                                            </span>
                                        </button>
                                        
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="productInformation">
                                {!! $product->shortDescription !!}
                                @if( isset($product->longDescription) && strlen($product->longDescription) > 0 )
                                    <div>
                                        {!! $product->longDescription !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @include('product.partials.Block.block', [
        'blockTitle'=>view('product.partials.productInfoNav', ['targetId'=>'relatedProduct']),
        'blockUrlDisable'=>true,
        'blockType'=>'product',
        'blockCustomClass'=>'a--owl-carousel-type-2 productShowBlock relatedProduct',
        'blockCustomId'=>'Block-relatedProduct'
        ])
    
@endsection

@section('page-js')
    <script src="{{ mix('/js/product-show.js') }}"></script>
@endsection
