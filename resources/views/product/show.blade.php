@extends('partials.templatePage')

@section('page-css')
    <link href="{{ mix('/css/product-show.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        @if(
            (
                is_null(optional(optional(optional($block)->sets)->first())->getActiveContents2()) ||
                $block->sets->first()->getActiveContents2()->count() === 0
            ) &&
            (
                is_null(optional($block)->getActiveContent()) ||
                $block->getActiveContent()->count() === 0
            )
        )
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
        @if($liveDescriptions->isEmpty())
        .productInfoNav-liveDescription {
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

@section('page-head')
    <!-- JSON-LD markup generated by Google Structured Data Markup Helper. -->
    <script type="application/ld+json">
    {
        "@context" : "http://schema.org",
        "@type" : "Product",
        "name" : " {{ $product->name }}",
        "image" : "{{ $product->photo }}?w=400&h=400",
        "sku": "{{ $product->id }}",
        "brand" : {
            "@type" : "Brand",

            "name" : "آلاء",
            "logo": {
                "@type": "ImageObject",
                "url": "https://cdn.alaatv.com/upload/Alaa-logo.png?w=182&h=224"
              }
        },
        "offers" : {
            "@type" : "Offer",
            "price" : "{{ $product->price['final'] }}",
            "priceCurrency" : "IRR",
            "url" : "{{ $product->url }}",
            "availability": "https://schema.org/InStock",
            "itemCondition": "https://schema.org/NewCondition"
        }
    }

    </script>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home m--padding-right-5"></i>
                <a class="m-link" href="{{route('web.index')}}">@lang('page.Home')</a>
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

    @if(in_array($product->type['id'] ,[config("constants.PRODUCT_TYPE_SIMPLE")]))
        @include('product.partials.showPage-topSection-simple')
    @elseif(in_array($product->type['id'], [config("constants.PRODUCT_TYPE_CONFIGURABLE"), config("constants.PRODUCT_TYPE_SELECTABLE")]))
        @include('product.partials.showPage-topSection-selectable')
    @endif

    {{-- پیش نمایش ست ها --}}
    @include('product.partials.previewSetsOfProduct', ['sets'=> ($allChildrenSets->count() > 0) ? $allChildrenSets->first()['sets'] : $sets, 'products'=> $allChildrenSets])

    {{--نمونه فیلم--}}
    @include('block.partials.main', [
        'blockTitle'=>view('product.partials.productInfoNav', ['targetId'=>'sampleVideo' , 'product'=>$product , 'isForcedGift'=>$isForcedGift]),
        'blockUrlDisable'=>true,
        'blockType'=>'productSampleVideo',
        'imageDimension'=>'?w=300&h=169',
        'squareSing'=>false,
        'blockCustomClass'=>'a--owl-carousel-type-2 productShowBlock sampleVideo a--block-widget-1',
        'blockCustomId'=>'Block-sampleVideo',
        'btnLoadMore'=>true
        ])

    {{--نمونه جزوه--}}
    @include('product.partials.pamphlet')

    {{--  بررسی محصول  --}}
    @if(mb_strlen(trim(strip_tags($product->shortDescription))) > 0 || mb_strlen(trim(strip_tags($product->longDescription))) > 0)
        <div class="row m--margin-top-10">
            <div class="col m--margin-bottom-25">
                <div class="m-portlet m-portlet--tabs productDetailes boxed" id="productDetailes">
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


                                        @if($hasUserPurchasedProduct)
                                            <a class="btn m-btn m-btn--pill m-btn--air btn-info animated infinite pulse" role="button" href="{{ action("Web\UserController@userProductFiles") }}">
                                                <i class="fa fa-play-circle"></i>
                                                <span class="d-none d-sm-none d-md-inline-block d-lg-inline-block">
                                                    مشاهده در صفحه فیلم ها و جزوه های من
                                                </span>
                                            </a>
                                        @else
{{--                                            <button class="btn m-btn--air btn-success m-btn--icon btnAddToCart gta-track-add-to-card">--}}
{{--                                                <span>--}}
{{--                                                    <i class="fa fa-cart-arrow-down"></i>--}}
{{--                                                    <i class="fas fa-sync-alt fa-spin m--hide"></i>--}}
{{--                                                    <span>افزودن به سبد خرید</span>--}}
{{--                                                </span>--}}
{{--                                            </button>--}}
                                        @endif


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

    {{--  توضیحات لحظه ای  --}}
    @if($liveDescriptions->isNotEmpty())
        <div class="row m--margin-top-10">
            <div class="col m--margin-bottom-25">
                <div class="m-portlet m-portlet--tabs productLiveDescription" id="productLiveDescription">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    @include('product.partials.productInfoNav', ['targetId'=>'productLiveDescription'])
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="tab-content">
                            <div class="m-timeline-3">
                                <div class="m-timeline-3__items">
                                    @foreach($liveDescriptions as $liveDescription)
                                        <div class="m-timeline-3__item m-timeline-3__item--info">
                                            <span class="m-timeline-3__item-time">{{$liveDescription->CreatedAt_Jalali_WithTime()}}</span>
                                            <div class="m-timeline-3__item-desc">
                                            <span class="m-timeline-3__item-user-name">
                                                <a  class="m-timeline-3__item-link">
                                                    {{$liveDescription->title}}
                                                </a>
                                            </span>
                                                <br>
                                                <span class="m-timeline-3__item-text">
                                                    {!!  $liveDescription->description !!}
                                            </span>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{--  محصولات مرتبط  --}}
    @include('block.partials.main', [
        'blockTitle'=>view('product.partials.productInfoNav', ['targetId'=>'relatedProduct', 'product'=>$product , 'isForcedGift'=>$isForcedGift]),
        'blockUrlDisable'=>true,
        'blockType'=>'product',
        'squareSing'=>false,
        'blockCustomClass'=>'a--owl-carousel-type-2 productShowBlock relatedProduct',
        'blockCustomId'=>'Block-relatedProduct',
        'btnLoadMore'=>true
        ])

    {{--دکمه افزودن به سبد خرید موبایل --}}
    @include('product.partials.btnAddToCartForMobileDevice')

@endsection

@section('page-js')
    <script>
        var TotalQuantityAddedToCart = 0;
        var parentProduct = {
            id : '{{ $product->id }}',
            name : '{{ $product->name }}',
            price : '{{ number_format($product->price['final'], 2, '.', '') }}',
            brand: 'آلاء',
            category : '-',
            variant : '{{ $product->type['hint'] }}',
            quantity: 1
        };
        var parentProductTags = '{{ ($product->tags !== null) ? implode(',',optional($product->tags)->tags) : '-' }}';
        var allProductsSets = @if($allChildrenSets->count() > 0) {!! json_encode($allChildrenSets) !!} @else [
            {
                id: parentProduct.id,
                name: parentProduct.name,
                sets: [
                    @foreach($sets as $set)
                    {
                        id: '{{$set->id}}',
                        name: '{{$set->name}}'
                    },
                    @endforeach
                ]
            }
        ]
        @endif
            ;
        var lastSetData = {
            set: {
                id: '{{$lastSet->id}}',
                name: '{{$lastSet->name}}',
                url: {
                    web: '{{$lastSet->show_url}}'
                }
            },
            files: {
                pamphlets: [

                        @foreach($lastSetPamphlets as $item)
                    {
                        name: '{{$item->name}}',
                        file: {
                            pamphlet: [
                                {
                                    link: '{{$item->file->first()->first()->link}}'
                                }
                            ]
                        },
                        @if(isset($item->section))
                        section: {
                            id: '{{$item->section_id}}',
                            name: '{{$item->section->name}}'
                        }
                        @endif
                    },
                    @endforeach
                ],
                videos: [

                        @foreach($lastSetVideos as $item)
                    {
                        title: '{{$item->name}}',
                        thumbnail: '{{$item->thumbnail}}',
                        url: {
                            web: '{{$item->url}}'
                        },
                        @if(isset($item->section))
                        section: {
                            id: '{{$item->section_id}}',
                            name: '{{$item->section->name}}'
                        }
                        @endif
                    },
                    @endforeach
                ]
            }
        };
    </script>

    <script src="{{ mix('/js/product-show.js') }}"></script>
@endsection
