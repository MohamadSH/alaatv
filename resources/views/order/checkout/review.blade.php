@extends('app' , ["pageName"=>$pageName])

@section('page-css')
    <link href="{{ mix('/css/checkout-review.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    
    @include('systemMessage.flash')
    
{{--    @include("partials.checkoutSteps" , ["step"=>2])--}}
    
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

                                                                    data-gtm-eec-product-id="{{ $simpleOrderProductItem->product->id }}"
                                                                    data-gtm-eec-product-name="{{ $simpleOrderProductItem->product->name }}"
                                                                    data-gtm-eec-product-price="{{ number_format($simpleOrderProductItem->product->price['final'], 2, '.', '') }}"
                                                                    data-gtm-eec-product-brand="آلاء"
                                                                    data-gtm-eec-product-category="-"
                                                                    data-gtm-eec-product-variant="-"
                                                                    data-gtm-eec-product-quantity="1"
                                                                    
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
    
    
                                                        <span class="m-badge m-badge--primary m-badge--wide m-badge--rounded notIncludedProductsInCoupon notIncludedProductsInCoupon-{{ $simpleOrderProductItem->product->id }} a--d-none">شامل کد تخفیف نمی شود</span>
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
                                                                <i class="fa fa-times"></i>
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
                                                                <i class="fa fa-times"></i>
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
                                                            <span class="m-badge m-badge--primary m-badge--wide m-badge--rounded notIncludedProductsInCoupon notIncludedProductsInCoupon-{{ $orderProductItemChild->product->id }} float-right a--d-none">شامل کد تخفیف نمی شود</span>
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
    
                <form method="GET" action="" id="frmGotoGateway">
                    <!--begin:: Widgets/Authors Profit-->
                    <div class="m-portlet m-portlet--bordered-semi CheckoutReviewTotalPriceWarper">
                        <div class="m-portlet__body" @if(optional(Auth::user())->id === null) style="padding-bottom: 0px !important;" @endif>
                            <div class="m-widget1 m--padding-5 costReportWraper">
        
                                @if(optional(Auth::user())->id !== null)
                                <div class="m-widget1__item">
                                    <div class="form-group m-form__group discountCodeWraper">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="مثال: codetakhfif" id="discountCodeValue"
                                                   @if(isset($coupon)) value="{{ $coupon['code'] }}" @endif>
                                            <div class="input-group-prepend">
                                                <button class="btn btn-success @if(isset($coupon)) a--d-none @endif" type="button" id="btnSaveDiscountCodeValue">
                                                    ثبت کد تخفیف
                                                </button>
                                                <button class="btn btn-danger @if(!isset($coupon)) a--d-none @endif" type="button" id="btnRemoveDiscountCodeValue">
                                                    حذف کد تخفیف
                                                </button>
                                            </div>
                                        </div>
                                    </div>
        
        
                                    <div class="alert alert-success alert-dismissible fade show couponReportWarper @if(!isset($coupon)) a--d-none @endif"
                                         role="alert">
                                        {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>--}}
                                        <div class="couponReport">
                                            @if(isset($coupon) && $coupon['type'] == config('constants.DISCOUNT_TYPE_COST'))
                                                کپن تخفیف
                                                <strong>{{$coupon['name']}}</strong>
                                                با
                                                {{number_format($coupon['discount'])}}
                                                تومان تخفیف برای سفارش شما ثبت شد.
                                            @elseif(isset($coupon))
                                                کپن تخفیف
                                                <strong>{{$coupon['name']}}</strong>
                                                با
                                                {{$coupon['discount']}}
                                                % تخفیف برای
                                                سفارش شما ثبت شده است.
                                            @endif
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="m-widget1__item">
                                    <div class="row align-items-center">
                                        <div class="col text-center addDonateWarper">
                                            <span>
                                                5،000 تومان به آلاء کمک
                                            </span>
    {{--                                        {{ dd($orderHasDonate) }}--}}
                                            <span class="m-bootstrap-switch m-bootstrap-switch--pill">
                                                <input type="checkbox" data-switch="true"
                                                       @if(isset($orderHasDonate) && $orderHasDonate)
                                                       @else
                                                       checked=""
                                                       @endif
                                                       data-on-text="نمی کنم"
                                                       data-on-color="danger"
                                                       data-off-text="می کنم"
                                                       data-off-color="success"
                                                       data-size="small"
                                                       {{--data-handle-width="40"--}}
                                                       id="hasntDonate">
                                            </span>
                                            <span>
                                                <img src="/acm/extra/sad.gif" class="face-sad" alt="face-sad" width="40">
                                                <img src="/acm/extra/happy.gif" class="face-happy" alt="face-happy" width="40">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="m-widget1__item baseCostWraper">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <h3 class="m-widget1__title">
                                                مبلغ خام :
                                            </h3>
    {{--                                        @if(isset($invoiceInfo['orderproductCount']))--}}
    {{--                                            <span class="m-widget1__desc">--}}
    {{--                                                شما {{ $invoiceInfo['orderproductCount'] }} محصول انتخاب کرده اید--}}
    {{--                                            </span>--}}
    {{--                                        @endif--}}
                                        </div>
                                        <div class="col m--align-right">
                                            @if(isset($invoiceInfo['price']['base']))
                                                <span class="m-widget1__number m--font-primary" id="baseCostValue">
                                                    {{ number_format($invoiceInfo['price']['base']) }} تومان
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget1__item yourProfitWraper">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <h3 class="m-widget1__title">
                                                سود شما از خرید
                                                <span>[تخفیف]</span>
                                                :
                                            </h3>
                                            {{--                                        <span class="m-widget1__desc">--}}
                                            {{--                                            شما در مجموع {{ round((1-($invoiceInfo['price']['final']/$invoiceInfo['price']['base']))*100, 2) }}% تخفیف گرفته اید--}}
                                            {{--                                        </span>--}}
                                        </div>
                                        <div class="col m--align-right">
                                            <span class="m-widget1__number m--font-success" id="yourProfitValue">
                                                {{ number_format($invoiceInfo['price']['discount']) }} تومان
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @if(optional(Auth::user())->id !== null)
                                    @if(isset($fromWallet))
                                        <div class="m-widget1__item useWalletReportWraper">
                                            <div class="row m-row--no-padding align-items-center">
                                                <div class="col">
                                                    <h3 class="m-widget1__title">
                                                        استفاده از کیف پول:
                                                    </h3>
                                                    <span class="m-widget1__desc"></span>
                                                </div>
                                                <div class="col m--align-right">
                                                    <span class="m-widget1__number m--font-success" id="useWalletValue">
                                                         {{ number_format($fromWallet) }} تومان
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="m-widget1__item">
                                        <div class="row m-row--no-padding align-items-center">
                                            <div class="col">
                                                <h3 class="m-widget1__title">
                                                    <i class="fa fa-money-bill-wave m--icon-font-size-lg3"></i>
                                                    پرداخت از درگاه بانک:
                                                </h3>
                                                <span class="m-widget1__desc"></span>
                                            </div>
                                            <div class="col m--align-right">
                                                <span class="m-widget1__number m--font-danger" id="finalPriceValue">
                                                     {{ number_format($invoiceInfo['price']['final'] - $fromWallet) }} تومان
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-widget1__item

                                    @if( ($invoiceInfo['price']['final'] - $fromWallet) <= 0) d-none @endif">
                                        <div class="m-form__group form-group text-center m--margin-top-10">
                                            <div class="m-radio-inline">
                                                <label class="m-radio m-radio--check-bold m-radio--state-info">
                                                    <input type="radio" name="radioBankType" value="{{route('redirectToBank', ['paymentMethod'=>'zarinpal', 'device'=>'web'])}}" data-bank-type="zarinpal">
                                                    <img src="/acm/extra/payment/gateway/zarinpal-logo.png" class="img-thumbnail bankLogo" alt="bank-logo" width="60">
                                                    <span></span>
                                                </label>
                                                <label class="m-radio m-radio--check-bold m-radio--state-info">
                                                    <input type="radio" name="radioBankType" value="{{route('redirectToBank', ['paymentMethod'=>'mellat', 'device'=>'web'])}}" data-bank-type="mellat" checked>
                                                    <img src="/acm/extra/payment/gateway/mellat-logo.png" class="img-thumbnail bankLogo" alt="bank-logo" width="60">
                                                    <span></span>
                                                </label>
                                                {{--                                            <label class="m-radio m-radio--check-bold m-radio--state-info">--}}
                                                {{--                                                <input type="radio" name="radioBankType" value="3">--}}
                                                {{--                                                <img src="/acm/extra/payment/gateway/pasargad-logo.jpg" class="img-thumbnail bankLogo" alt="bank-logo" width="60">--}}
                                                {{--                                                <span></span>--}}
                                                {{--                                            </label>--}}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="m-widget1__item">
                                        <div class="form-group m-form__group">
                                            <label for="customerDescription">
                                                اگر توضیحی در مورد سفارش خود دارید اینجا بنویسید:
                                            </label>
                                            <div class="m-input-icon m-input-icon--left">
                                                <textarea id="customerDescription" class="form-control m-input m-input--air"
                                                          placeholder="توضیح شما..." rows="2" name="customerDescription"
                                                          cols="50"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="m-widget1__item">
                                        <div class="row m-row--no-padding align-items-center">
                                            <div class="col">
                                                <h3 class="m-widget1__title">
                                                    <i class="fa fa-money-bill-wave m--icon-font-size-lg3"></i>
                                                    مبلغ قابل پرداخت:
                                                </h3>
                                                <span class="m-widget1__desc"></span>
                                            </div>
                                            <div class="col m--align-right">
                                                @if(isset($invoiceInfo['price']['final']))
                                                    <span class="m-widget1__number m--font-danger">
                                                         {{ number_format($invoiceInfo['price']['final']) }} تومان
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                            </div>
                            @if(optional(Auth::user())->id !== null)
                            <button type="submit"
                                    onclick="mApp.block('.CheckoutReviewTotalPriceWarper, .a--userCartList', {type: 'loader',state: 'info',});"
                                    class="btn btn-lg m-btn--square m-btn m-btn--gradient-from-success m-btn--gradient-to-accent btnGotoCheckoutPayment-desktop btnGotoCheckoutPayment">
                                ادامه و ثبت سفارش
                            </button>
                            @endif
                        </div>
                    </div>
                    <!--end:: Widgets/Authors Profit-->
                </form>
    
                @if(optional(Auth::user())->id === null)
        
                    <div class="m-portlet m-portlet--bordered-semi CheckoutReviewTotalPriceWarper">
                        <div class="m-portlet__body">
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                پیش از ثبت سفارش وارد حساب کاربری خود شوید.
                                <br>
                                با کد ملی ایران نیازی به ثبت نام نیست.
                            </div>
                            
                            <form class="m-login__form m-form" action="{{ action("Auth\LoginController@login") }}" method="post">
                                @if($errors->login->has('validation'))
                                    <div class="alert alert-danger">
                                        <button class="close" data-close="alert"></button>
                                        <span><strong>{{$errors->login->first('validation')}}</strong></span>
                                    </div>
                                @elseif($errors->login->has('credential'))
                                    <div class="alert alert-danger">
                                        <button class="close" data-close="alert"></button>
                                        <span><strong>{{$errors->login->first('credential')}}</strong></span>
                                    </div>
                                @elseif($errors->login->has('inActive'))
                                    <div class="alert alert-danger" dir="rtl">
                                        <button class="close" data-close="alert"></button>
                                        <span><strong>{{$errors->login->first('inActive')}}</strong></span>
                                    </div>
                                @endif
                                {{ csrf_field() }}
                                <div id="m-login__form_mobile" class="form-group m-form__group {{ $errors->has('mobile') ? ' has-danger' : '' }}">
                                    <input class="form-control m-input" type="text" placeholder="شماره موبایل" value="{{ old('mobile') }}" name="mobile" autocomplete="off">
                                    @if ($errors->has('mobile'))
                                        <div class="form-control-feedback">{{ $errors->first('mobile') }}</div>
                                    @endif
                                </div>
                                <div id="m-login__form_code" class="form-group m-form__group {{ $errors->has('nationalCode') ? ' has-danger' : '' }}">
                                    <input class="form-control m-input m-login__form-input--last " type="password" placeholder="کد ملی" value="{{ old('password') }}" name="password">
                                    @if ($errors->has('nationalCode'))
                                        <div class="form-control-feedback">{{ $errors->first('nationalCode') }}</div>
                                    @endif
                                </div>
                                <div class="m-login__form-action">
                                    <button id="m_login_signin_submit animated infinite heartBeat" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air animated infinite heartBeat" type="submit">ورود</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="row">
            <div class="col">
                <div class="m-alert m-alert--icon alert alert-warning empteCartAlert" role="alert">
                    <div class="m-alert__icon">
                        <i class="fa fa-exclamation-triangle"></i>
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
                            onclick="$('#frmGotoGateway').submit();mApp.block('.btnGotoCheckoutPayment_mobile, .a--userCartList', {type: 'loader',state: 'info',});"
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
                                    {{ number_format($invoiceInfo['price']['final'] - $fromWallet) }} تومان
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
        var addDonateUrl = '{{ action('Web\OrderController@addOrderproduct' , 180) }}';
        var removeDonateUrl = '{{ action('Web\OrderController@removeOrderproduct' , 180) }}';
        var OrderControllerSubmitCoupon = '{{ action('Web\OrderController@submitCoupon') }}';
        var OrderControllerRemoveCoupon = '{{ action('Web\OrderController@removeCoupon') }}';
        var userCredit = @if(isset($credit))
            {{ $credit }}
        @else
            0
        @endif;
        var orderHasDonate = @if(isset($orderHasDonate) && $orderHasDonate)
            1;
        @else
            0
        @endif;
        var orderHasCoupon = @if(isset($coupon))
            1;
        @else
            0
        @endif;
        var notIncludedProductsInCoupon =
        @if(isset($notIncludedProductsInCoupon))
                {!! json_encode($notIncludedProductsInCoupon) !!}
        @else
            []
        @endif
        ;
        var checkoutReviewProducts = [
            @if(isset($invoiceInfo['items']))
                @foreach($invoiceInfo['items'] as $key=>$orderProductItem)
                    @if($orderProductItem['grand']!==null)
                        {
                            id : '{{ $orderProductItem['grand']->id  }}',
                            name : '{{ $orderProductItem['grand']->name  }}',
                            price : '{{ number_format($orderProductItem['grand']->price['final'], 2, '.', '')   }}',
                            brand : 'آلاء',
                            category : '-',
                            variant : '-',
                            quantity: 1,
                        },
                    @endIf
                    @foreach($orderProductItem['orderproducts'] as $key=>$simpleOrderProductItem)
                        {
                            id : '{{ $simpleOrderProductItem->product->id  }}',
                            name : '{{ $simpleOrderProductItem->product->name  }}',
                            price : '{{ number_format($simpleOrderProductItem->product->price['final'], 2, '.', '')   }}',
                            brand : 'آلاء',
                            category : '-',
                            variant : '-',
                            quantity: 1,
                        },
                    @endforeach
                @endforeach
            @endif
        ];
    </script>
    <script src="{{ mix('/js/checkout-review.js') }}"></script>
@endsection
