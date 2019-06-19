@extends('app' , ["pageName"=>$pageName])

@section('page-css')
    <link href="{{ mix('/css/checkout-review.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    
    @include('systemMessage.flash')
    
    @include("partials.checkoutSteps" , ["step"=>2])
    
    @if(isset($invoiceInfo['orderproductCount']) && $invoiceInfo['orderproductCount']>0)
        <div class="row">
            <div class="col-xl-8 a--userCartList">
                <!--begin:: Widgets/Best Sellers-->
                <div class="m-portlet m-portlet--full-height ">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    سبد خرید
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools btnAddMoreProductToCartWraper">
                            <button onclick="window.location.href='{{action('Web\ShopPageController')}}';mApp.block('.btnAddMoreProductToCartWraper', {type: 'loader',state: 'info',});"
                                    type="button"
                                    class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-primary m-btn--gradient-to-info btnAddMoreProductToCart-desktop">
                                <i class="flaticon-bag"></i>
                                افزودن محصول جدید به سبد
                            </button>
                            <button onclick="window.location.href='{{action('Web\ShopPageController')}}';mApp.block('.btnAddMoreProductToCartWraper', {type: 'loader',state: 'info',});"
                                    type="button"
                                    class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-primary m-btn--gradient-to-info btnAddMoreProductToCart-mobile">
                                <i class="flaticon-bag"></i>
                                افزودن محصول جدید
                            </button>
                        </div>
                    </div>
                    
                    <div class="m-portlet__body">
                        <!--begin::Content-->
                        <div class="tab-content">
                            <!--begin::m-widget5-->
                            <div class="m-widget5 a--userCartList-items">
                                @if(isset($invoiceInfo['items']))
                                    @foreach($invoiceInfo['items'] as $key=>$orderProductItem)
                                        @if($orderProductItem['grand']===null)
                                            @foreach($orderProductItem['orderproducts'] as $key=>$simpleOrderProductItem)
                                                <div class="m-widget5__item orderproductWithoutChildWarper">
                                                    <div class="m-widget5__content">
                                                        <div class="m-widget5__pic btnRemoveOrderproduct-desktop-warper">
                                                            <button type="button"
                                                                    data-action="{{ action("Web\OrderproductController@destroy",$simpleOrderProductItem->id) }}"
                                                                    data-name="{{ $simpleOrderProductItem->product->name  }}"
                                                                    data-category="-"
                                                                    data-variant="-"
                                                                    data-productid="{{ $simpleOrderProductItem->product->id }}"
                                                                    class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                                    <span>
                                                                        <i class="flaticon-circle"></i>
                                                                        <span>حذف</span>
                                                                    </span>
                                                            </button>
                                                        </div>
                                                        <div class="m-widget5__pic">
                                                            <a class="m-link" target="_blank"
                                                               href="{{ $simpleOrderProductItem->product->url }}">
                                                                <img class="m-widget7__img"
                                                                     src="{{ $simpleOrderProductItem->product->photo }}"
                                                                     alt="">
                                                            </a>
                                                        </div>
                                                        <div class="m-widget5__section">
                                                            <div class="d-none d-sm-block d-md-block d-lg-block d-xl-block">
                                                                <h4 class="m-widget5__title">
                                                                    <a class="m-link" target="_blank"
                                                                       href="{{ $simpleOrderProductItem->product->url }}">
                                                                        {{ $simpleOrderProductItem->product->name }}
                                                                    </a>
                                                                </h4>
                                                                <span class="m-widget5__desc">
                                                                    @if(isset($simpleOrderProductItem->product->attributes))
                                                                        @foreach($simpleOrderProductItem->product->attributes as $productAttributeGroupKey=>$productAttributeGroup)
                                                                            @foreach($productAttributeGroup as $attributeItem)
                                                                                @if(($productAttributeGroupKey=='main' || $productAttributeGroupKey=='information') && $attributeItem->control=='simple')
                                                                                    {{ $attributeItem->title }}
                                                                                    : {{ $attributeItem->data[0]->name }}
                                                                                    <br>
                                                                                @endif
                                                                            @endforeach
                                                                        @endforeach
                                                                    @endif
                                                                    @if(isset($simpleOrderProductItem->attributevalues))
                                                                        @foreach($simpleOrderProductItem->attributevalues as $attributeGroupKey=>$attributeItem)
                                                                            <span class="m-badge m-badge--info m-badge--wide m-badge--rounded m--margin-bottom-5">{{ $attributeItem->name }}</span>
                                                                        @endforeach
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="d-sm-none d-md-none d-lg-none m--margin-top-10">
                                                            <h4 class="m-widget5__title">
                                                                {{ $simpleOrderProductItem->product->name }}
                                                            </h4>
                                                            <span class="m-widget5__desc">
                                                                @if(isset($simpleOrderProductItem->product->attributes))
                                                                    @foreach($simpleOrderProductItem->product->attributes as $attributeGroupKey=>$attributeGroup)
                                                                        @foreach($attributeGroup as $attributeItem)
                                                                            @if(($attributeGroupKey=='main' || $attributeGroupKey=='information') && $attributeItem->control=='simple')
                                                                                {{ $attributeItem->title }}
                                                                                : {{ $attributeItem->data[0]->name }}
                                                                                <br>
                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach
                                                                @endif
                                                                @if(isset($simpleOrderProductItem->attributevalues))
                                                                    @foreach($simpleOrderProductItem->attributevalues as $attributeGroupKey=>$attributeItem)
                                                                        <span class="m-badge m-badge--info m-badge--wide m-badge--rounded m--margin-bottom-5">{{ $attributeItem->name }}</span>
                                                                    @endforeach
                                                                @endif
                                                            </span>
                                                        </div>
                                                        @if($simpleOrderProductItem->attached_bons_number > 0)
                                                            <span class="m-badge m-badge--info m-badge--wide m-badge--rounded">
                                                                <i class="flaticon-interface-9"></i>
                                                                تعداد بن مصرفی:
                                                                {{ $simpleOrderProductItem->attached_bons_number }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="m-widget5__content">
                                                        <div class="m-widget5__stats1">
                                                            <span class="m-nav__link-badge">
                                                                <span class="m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                                    @if($simpleOrderProductItem['price']['final']!=$simpleOrderProductItem['price']['base'])
                                                                        <span class="m-badge m-badge--warning a--productRealPrice">{{ number_format($simpleOrderProductItem['price']['base']+$simpleOrderProductItem['price']['extraCost']) }}</span>
                                                                    @endif
                                                                    {{ number_format($simpleOrderProductItem['price']['final']+$simpleOrderProductItem['price']['extraCost']) }} تومان
                                                                    @if($simpleOrderProductItem['price']['final']!==$simpleOrderProductItem['price']['base'])
                                                                        <span class="m-badge m-badge--info a--productDiscount">{{ round((1-($simpleOrderProductItem['price']['final']/$simpleOrderProductItem['price']['base']))*100) }}%</span>
                                                                    @endif
                                                                </span>
                                                            </span>
                                                        </div>
                                                        <div class="m-widget5__stats2">
                                                            <a href="#"
                                                               data-action="{{action("Web\OrderproductController@destroy",$simpleOrderProductItem->id)}}"
                                                               data-name="{{ $simpleOrderProductItem->product->name  }}"
                                                               data-category="-"
                                                               data-variant="-"
                                                               data-productid="{{ $simpleOrderProductItem->product->id }}"
                                                               class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct">
                                                                <i class="la la-close"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="orderproductWithChildWarper">
                                                
                                                <div class="m-widget5__item hasChild">
                                                    <div class="m-widget5__content">
                                                        <div class="m-widget5__pic">
                                                            <button class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 a--visibility-hidden"
                                                                    type="button">
                                                            <span>
                                                                <i class="flaticon-circle"></i>
                                                                <span>حذف</span>
                                                            </span>
                                                            </button>
                                                        </div>
                                                        <div class="m-widget5__pic">
                                                            <a class="m-link" target="_blank"
                                                               href="{{ $orderProductItem['grand']->url }}">
                                                                <img class="m-widget7__img"
                                                                     src="{{ $orderProductItem['grand']->photo }}"
                                                                     alt="">
                                                            </a>
                                                        </div>
                                                        
                                                        {{--attribute value in desktop--}}
                                                        <div class="m-widget5__section">
                                                            <div class=" d-none d-md-block d-lg-block d-xl-block">
                                                                <h4 class="m-widget5__title">
                                                                    <a class="m-link" target="_blank"
                                                                       href="{{ $orderProductItem['grand']->url }}">
                                                                        {{ $orderProductItem['grand']->name }}
                                                                    </a>
                                                                </h4>
                                                                <span class="m-widget5__desc">
                                                                    @if(isset($orderProductItem['grand']->attributes))
                                                                        @foreach($orderProductItem['grand']->attributes as $productAttributeGroupKey=>$productAttributeGroup)
                                                                            @foreach($productAttributeGroup as $attributeItem)
                                                                                @if(($productAttributeGroupKey=='main' || $productAttributeGroupKey=='information') && $attributeItem->control=='simple')
                                                                                    {{ $attributeItem->title }}
                                                                                    : {{ $attributeItem->data[0]->name }}
                                                                                    <br>
                                                                                @endif
                                                                            @endforeach
                                                                        @endforeach
                                                                    @endif
                                                                    
                                                                    @if(optional($orderProductItem['grand']->attributes)->get('information'))
                                                                        @foreach($orderProductItem['grand']->attributes->get('information') as $attributeGroupKey=>$attributeItem)
                                                                            <span class="m-badge m-badge--info m-badge--wide m-badge--rounded m--margin-bottom-5">{{ $attributeItem->title }} : {{ $attributeItem->data[0]->name }}</span>
                                                                        @endforeach
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        </div>
                                                        
                                                        {{--attribute value in mobile--}}
                                                        <div class="d-sm-none d-md-none d-lg-none m--margin-top-10">
                                                            <h4 class="m-widget5__title">
                                                                {{ $orderProductItem['grand']->name }}
                                                            </h4>
                                                            <span class="m-widget5__desc">
                                                                @if(isset($orderProductItem['grand']->attributes))
                                                                    @foreach($orderProductItem['grand']->attributes as $productAttributeGroupKey=>$productAttributeGroup)
                                                                        @foreach($productAttributeGroup as $attributeItem)
                                                                            @if(($productAttributeGroupKey=='main' || $productAttributeGroupKey=='information') && $attributeItem->control=='simple')
                                                                                {{ $attributeItem->title }}
                                                                                : {{ $attributeItem->data[0]->name }}
                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach
                                                                @endif
                                                                @if(isset($orderProductItem['grand']->attributevalues))
                                                                    @foreach($orderProductItem['grand']->attributevalues as $attributeGroupKey=>$attributeItem)
                                                                        <span class="m-badge m-badge--info m-badge--wide m-badge--rounded m--margin-bottom-5">{{ $attributeItem->name }}</span>
                                                                    @endforeach
                                                                @endif
                                                            </span>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="m-widget5__content">
                                                        <div class="m-widget5__stats1">
                                                        
                                                        </div>
                                                        <div class="m-widget5__stats2">
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="m-widget5__item childOfParent">
                                                    @foreach($orderProductItem['orderproducts'] as $keyChild=>$orderProductItemChild)
                                                        <div class="childItem">
                                                            
                                                            <div class="childRemoveBtnWarper">
                                                                <button type="button"
                                                                        data-action="{{action("Web\OrderproductController@destroy", $orderProductItemChild->id)}}"
                                                                        data-name="{{ $orderProductItemChild->product->name  }}"
                                                                        data-category="-"
                                                                        data-variant="-"
                                                                        data-productid="{{ $orderProductItemChild->product->id }}"
                                                                        class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                                <span>
                                                                    <i class="flaticon-circle"></i>
                                                                    <span>حذف</span>
                                                                </span>
                                                                </button>
                                                            </div>
                                                            
                                                            <button type="button"
                                                                    data-action="{{action("Web\OrderproductController@destroy", $orderProductItemChild->id)}}"
                                                                    data-name="{{ $orderProductItemChild->product->name  }}"
                                                                    data-category="-"
                                                                    data-variant="-"
                                                                    data-productid="{{ $orderProductItemChild->product->id }}"
                                                                    class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct btnRemoveOrderproduct-child">
                                                                <i class="la la-close"></i>
                                                            </button>
                                                            
                                                            <div class="childTitle">
                                                                {{ $orderProductItemChild->product->name }}
                                                            </div>
                                                            <div class="childPrice">
                                                                <span class="m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                                    @if($orderProductItemChild['price']['final']!=$orderProductItemChild['price']['base'])
                                                                        <span class="m-badge m-badge--warning a--productRealPrice">{{ number_format($orderProductItemChild['price']['base']+$orderProductItemChild['price']['extraCost']) }}</span>
                                                                    @endif
                                                                    {{ number_format($orderProductItemChild['price']['final']+$orderProductItemChild['price']['extraCost']) }} تومان
                                                                    @if(($orderProductItemChild->discountDetail['price']['bonDiscount']+$orderProductItemChild['price']['discountDetail']['productDiscount'])>0)
                                                                        <span class="m-badge m-badge--info a--productDiscount">{{ $orderProductItemChild->discountDetail['price']['bonDiscount']+$orderProductItemChild['price']['discountDetail']['productDiscount'] }}%</span>
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            
                                                            <div class="clearfix"></div>
    
    
                                                            @if($orderProductItemChild->attached_bons_number > 0)
                                                                <span class="m-badge m-badge--info m-badge--wide m-badge--rounded m--margin-top-5">
                                                                    <i class="flaticon-interface-9"></i>
                                                                    تعداد بن مصرفی:
                                                                    {{ $orderProductItemChild->attached_bons_number }}
                                                                </span>
                                                            @endif
                                                            
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endIf
                                    @endforeach
                                @endif
                            </div>
                            <!--end::m-widget5-->
                        </div>
                        <!--end::Content-->
                    </div>
                </div>
                <!--end:: Widgets/Best Sellers-->
            </div>
            <div class="col-xl-4">
                <!--begin:: Widgets/Authors Profit-->
                <div class="m-portlet m-portlet--bordered-semi CheckoutReviewTotalPriceWarper">
                    <div class="m-portlet__body">
                        <div class="m-widget1 m--padding-5">
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">
                                            مبلغ کل :
                                        </h3>
                                        @if(isset($invoiceInfo['orderproductCount']))
                                            <span class="m-widget1__desc">
                                                شما {{ $invoiceInfo['orderproductCount'] }} محصول انتخاب کرده اید
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col m--align-right">
                                        @if(isset($invoiceInfo['price']['base']))
                                            <span class="m-widget1__number m--font-danger">
                                                {{ number_format($invoiceInfo['price']['base']) }} تومان
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if(isset($invoiceInfo['price']['base']) && isset($invoiceInfo['price']['final']) && $invoiceInfo['price']['base']>$invoiceInfo['price']['final'])
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <h3 class="m-widget1__title">
                                                سود شما از خرید :
                                            </h3>
                                            <span class="m-widget1__desc">
                                            شما در مجموع {{ round((1-($invoiceInfo['price']['final']/$invoiceInfo['price']['base']))*100, 2) }}% تخفیف گرفته اید
                                        </span>
                                        </div>
                                        <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-success">
                                            {{ number_format($invoiceInfo['price']['base']-$invoiceInfo['price']['final']) }} تومان
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">
                                            <i class="la la-money m--icon-font-size-lg3"></i>
                                            مبلغ قابل پرداخت:
                                        </h3>
                                        <span class="m-widget1__desc"></span>
                                    </div>
                                    <div class="col m--align-right">
                                        @if(isset($invoiceInfo['price']['final']))
                                            <span class="m-widget1__number m--font-primary">
                                                 {{ number_format($invoiceInfo['price']['final']) }} تومان
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button"
                                onclick="window.location.href='{{action('Web\OrderController@checkoutPayment')}}';mApp.block('.CheckoutReviewTotalPriceWarper', {type: 'loader',state: 'info',});"
                                class="btn btn-lg m-btn--square m-btn m-btn--gradient-from-success m-btn--gradient-to-accent btnGotoCheckoutPayment-desktop btnGotoCheckoutPayment">
                            ادامه و ثبت سفارش
                        </button>
                    </div>
                </div>
                <!--end:: Widgets/Authors Profit-->
            </div>
        </div>
    @else
        <div class="row">
            <div class="col">
                <div class="m-alert m-alert--icon alert alert-warning empteCartAlert" role="alert">
                    <div class="m-alert__icon">
                        <i class="la la-warning"></i>
                    </div>
                    <div class="m-alert__text text-center">
                        <strong>سبد خرید شما خالیست!</strong>
                        <br>
                        <button onclick="window.location.href='{{action('Web\ShopPageController')}}';mApp.block('.empteCartAlert', {type: 'loader',state: 'info',});"
                                type="button"
                                class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-primary m-btn--gradient-to-info">
                            <i class="flaticon-bag"></i>
                            افزودن محصول به سبد
                        </button>
                    </div>
                    <div class="m-alert__close pull-left">
                        <button type="button" class="close" data-close="alert" aria-label="Hide"></button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <div class="m-portlet btnGotoCheckoutPayment_mobile">
        <div class="m-portlet__body">
            <div class="row">
                <div class="col-6">
                    <button type="button"
                            onclick="window.location.href='{{action('Web\OrderController@checkoutPayment')}}';mApp.block('.btnGotoCheckoutPayment_mobile', {type: 'loader',state: 'info',});"
                            class="btn btn-lg m-btn--square m-btn m-btn--gradient-from-success m-btn--gradient-to-accent btnGotoCheckoutPayment">
                        ثبت سفارش
                    </button>
                </div>
                <div class="col-6">
                    <div class="priceReport">
                        <span class="m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                            @if(isset($invoiceInfo['price']['base']) && isset($invoiceInfo['price']['final']) && $invoiceInfo['price']['base']>$invoiceInfo['price']['final'])
                                <span class="m-badge m-badge--warning a--productRealPrice">{{ number_format($invoiceInfo['price']['base']) }}</span>
                                <span class="m-badge m-badge--info a--productDiscount">{{ round((1-($invoiceInfo['price']['final']/$invoiceInfo['price']['base']))*100) }}%</span>
                            @endif
                            @if(isset($invoiceInfo['price']['final']))
                                {{ number_format($invoiceInfo['price']['final']) }} تومان
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-js')
    <script>
        var checkoutReviewProducts = [
            @foreach($invoiceInfo['items'] as $key=>$orderProductItem)
                @if($orderProductItem['grand']!==null)
                    {
                        id : '{{ $orderProductItem['grand']->id  }}',
                        name : '{{ $orderProductItem['grand']->name  }}',
                        quantity: 1,
                        category : '-',
                        variant : '-'
                    },
                @endIf
                @foreach($orderProductItem['orderproducts'] as $key=>$simpleOrderProductItem)
                    {
                        id : '{{ $simpleOrderProductItem->product->id  }}',
                        name : '{{ $simpleOrderProductItem->product->name  }}',
                        quantity: 1,
                        category : '-',
                        variant : '-'
                    },
                @endforeach
            @endforeach
        ];
    </script>
    <script src="{{ mix('/js/checkout-review.js') }}"></script>
@endsection
