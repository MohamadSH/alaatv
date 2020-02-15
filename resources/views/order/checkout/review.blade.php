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
                                    class="btn m-btn--pill m-btn--air btn-warning btnAddMoreProductToCart-desktop">
                                <i class="flaticon-bag"></i>
                                افزودن محصول جدید به سبد
                            </button>
                            <button onclick="window.location.href='{{action('Web\ShopPageController')}}';mApp.block('.btnAddMoreProductToCartWraper', {type: 'loader',state: 'info',});"
                                    type="button"
                                    class="btn m-btn--pill m-btn--air btn-warning btnAddMoreProductToCart-mobile">
                                <i class="flaticon-bag"></i>
                                افزودن محصول جدید
                            </button>
                        </div>
                    </div>

                    <div class="m-portlet__body">
                        <!--begin::Content-->
                        <div class="tab-content">
                            <!--begin::m-widget5-->
                            <style>
                                .productAttributes {
                                    display: flex;
                                    flex-flow: column;
                                    flex-wrap: wrap;
                                    max-height: 150px;
                                }
                                .productAttributes .productAttributes-item {

                                }
                            </style>
                            <div class="m-widget5 a--list3 a--userCartList-items">
                                @if(isset($invoiceInfo['items']))
                                    @foreach($invoiceInfo['items'] as $key=>$orderProductItem)
                                        @if($orderProductItem['grand']===null)
                                            @foreach($orderProductItem['orderproducts'] as $key=>$simpleOrderProductItem)
                                                <div class="a--list3-item orderproductWithoutChildWarper">
                                                    <div class="a--list3-action-right">
                                                        <button type="button"
                                                                data-action="{{ action("Web\OrderproductController@destroy",$simpleOrderProductItem->id) }}"
                                                                data-name="{{ $simpleOrderProductItem->product->name  }}"
                                                                data-category="-"
                                                                data-variant="-"
                                                                data-productid="{{ $simpleOrderProductItem->product->id }}"
                                                                @include('partials.gtm-eec.product', ['position'=>$key, 'list'=>'سبد خرید', 'product'=>$simpleOrderProductItem->product, 'quantity'=>'1'])
                                                                class="btn btn-sm m-btn--pill m-btn--air btn-danger m--margin-right-5 btnRemoveOrderproduct">
                                                                    <span>
                                                                        <i class="flaticon-circle"></i>
                                                                        <span>حذف</span>
                                                                    </span>
                                                        </button>
                                                    </div>
                                                    <div class="a--list3-thumbnail">
                                                        <a target="_blank"
                                                           href="{{ $simpleOrderProductItem->product->url }}">
                                                            <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" class="lazy-image a--full-width" data-src="{{ $simpleOrderProductItem->product->photo }}" alt="{{ $simpleOrderProductItem->product->name }}" width="40" height="40">
                                                        </a>
                                                    </div>
                                                    <div class="a--list3-content">
                                                        <a href="{{ $simpleOrderProductItem->product->url }}" target="_blank">
                                                            <h2 class="a--list3-title">
                                                                {{ $simpleOrderProductItem->product->name }}
                                                            </h2>
                                                        </a>
                                                        <div class="a--list3-info"></div>
                                                        <div class="a--list3-desc">

                                                            @if(isset($simpleOrderProductItem->product->attributes))
                                                                <div class="productAttributes">
                                                                    @foreach($simpleOrderProductItem->product->attributes->filter(function ($value, $key) {return (($key==='main' || $key==='information'));}) as $productAttributeGroupKey=>$productAttributeGroup)
                                                                        @foreach($productAttributeGroup->filter(function ($value, $key) {return ($value->control==='simple');}) as $attributeItem)
                                                                            <div class="productAttributes-item">
                                                                                {{ $attributeItem->title }}
                                                                                : {{ $attributeItem->data[0]->name }}
                                                                            </div>
                                                                        @endforeach
                                                                    @endforeach
                                                                </div>
                                                            @endif

                                                            @if(isset($simpleOrderProductItem->attributevalues))
                                                                <div class="orderProductAttributeValues">
                                                                    @foreach($simpleOrderProductItem->attributevalues as $attributeGroupKey=>$attributeItem)
                                                                        <span class="m-badge m-badge--info m-badge--wide m-badge--rounded m--margin-bottom-5">{{ $attributeItem->name }}</span>
                                                                    @endforeach
                                                                </div>
                                                            @endif

                                                            @if($simpleOrderProductItem->attached_bons_number > 0)
                                                                <span class="m-badge m-badge--info m-badge--wide m-badge--rounded">
                                                                    <i class="flaticon-interface-9"></i>
                                                                    تعداد بن مصرفی:
                                                                    {{ $simpleOrderProductItem->attached_bons_number }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="a--list3-action-left">
                                                        @include('product.partials.price', ['price' => $simpleOrderProductItem['price'], 'extraCost' => $simpleOrderProductItem['price']['extraCost']])
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else

                                            <div class="orderproductWithChildWarper">

                                                <div class="a--list3-item hasChild">
                                                    <div class="a--list3-action-right"></div>
                                                    <div class="a--list3-thumbnail">
                                                        <a target="_blank"
                                                           href="{{ $orderProductItem['grand']->url }}">
                                                            <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" class="lazy-image a--full-width" data-src="{{ $orderProductItem['grand']->photo }}" alt="{{ $orderProductItem['grand']->name }}" width="40" height="40">
                                                        </a>
                                                    </div>
                                                    <div class="a--list3-content">
                                                        <a href="{{ $orderProductItem['grand']->url }}" target="_blank">
                                                            <h2 class="a--list3-title">
                                                                {{ $orderProductItem['grand']->name }}
                                                            </h2>
                                                        </a>
                                                        <div class="a--list3-info"></div>
                                                        <div class="a--list3-desc">


                                                            @if(isset($orderProductItem['grand']->attributes))
                                                                <div class="productAttributes">
                                                                    @foreach($orderProductItem['grand']->attributes->filter(function ($value, $key) {return (($key==='main' || $key==='information'));}) as $productAttributeGroupKey=>$productAttributeGroup)
                                                                        @foreach($productAttributeGroup->filter(function ($value, $key) {return ($value->control==='simple');}) as $attributeItem)
                                                                            <div class="productAttributes-item">
                                                                                {{ $attributeItem->title }}
                                                                                : {{ $attributeItem->data[0]->name }}
                                                                            </div>
                                                                        @endforeach
                                                                    @endforeach
                                                                </div>
                                                            @endif

                                                            @if(optional($orderProductItem['grand']->attributes)->get('information'))
                                                                <div class="orderProductAttributeValues">
                                                                    @foreach($orderProductItem['grand']->attributes->get('information') as $attributeGroupKey=>$attributeItem)
                                                                        <span class="m-badge m-badge--info m-badge--wide m-badge--rounded m--margin-bottom-5">{{ $attributeItem->title }} : {{ $attributeItem->data[0]->name }}</span>
                                                                    @endforeach
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="a--list3-action-left"></div>
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
                                                                @include('product.partials.price', ['price' => $orderProductItemChild['price'], 'extraCost' => $orderProductItemChild['price']['extraCost']])
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
                            <div class="m--padding-5 costReportWraper">

                                @if(optional(Auth::user())->id !== null)
                                <div class="costReportWraper-item">
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
                                <div class="costReportWraper-item">
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
                                <div class="costReportWraper-item baseCostWraper">
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
                                <div class="costReportWraper-item yourProfitWraper">
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
                                        <div class="costReportWraper-item useWalletReportWraper">
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
                                    <div class="costReportWraper-item">
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
                                    <div class="costReportWraper-item selectPaymentMethod @if( ($invoiceInfo['price']['final'] - $fromWallet) <= 0) d-none @endif">
                                        <div class="text-center m--margin-top-10">

                                            <div class="pretty p-default p-curve p-pulse">
                                                <input type="radio" name="radioBankType" value="{{route('redirectToBank', ['paymentMethod'=>'zarinpal', 'device'=>'web'])}}" data-bank-type="zarinpal" >
                                                <div class="state p-warning">
                                                    <img src="/acm/extra/payment/gateway/zarinpal-logo.png" class="img-thumbnail bankLogo" alt="bank-logo" width="60">
                                                    <label>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="pretty p-default p-curve p-pulse">
                                                <input type="radio" name="radioBankType" value="{{route('redirectToBank', ['paymentMethod'=>'mellat', 'device'=>'web'])}}" data-bank-type="mellat" checked>
                                                <div class="state p-warning">
                                                    <img src="/acm/extra/payment/gateway/mellat-logo.png" class="img-thumbnail bankLogo" alt="bank-logo" width="60">
                                                    <label>
                                                    </label>
                                                </div>
                                            </div>

{{--                                            <div class="pretty p-default p-curve p-pulse">--}}
{{--                                                <input type="radio" name="radioBankType" value="3" data-bank-type="pasargad">--}}
{{--                                                <div class="state p-warning">--}}
{{--                                                    <img src="/acm/extra/payment/gateway/pasargad-logo.jpg" class="img-thumbnail bankLogo" alt="bank-logo" width="60">--}}
{{--                                                    <label>--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}


                                        </div>
                                    </div>
                                    <div class="costReportWraper-item">
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
                                    <div class="costReportWraper-item">
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
                                    class="btn btn-lg m-btn--square m-btn btn-info btnGotoCheckoutPayment-desktop btnGotoCheckoutPayment">
                                ادامه و ثبت سفارش
                            </button>
                            @endif
                        </div>
                    </div>
                    <!--end:: Widgets/Authors Profit-->
                </form>

                @if(optional(Auth::user())->id === null)

                    <div class="m-portlet m-portlet--bordered-semi CheckoutReviewTotalPriceWarper loginFormBeforeBuy">
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


                <div class="row">
                    <div class="col-md-4 mx-auto">
                        <div class="text-center">
                            <img src="https://cdn.alaatv.com/upload/empty-cart.png" class="a--full-width" alt="empty-cart">
                            <strong>سبد خرید شما خالیست!</strong>
                            <br>
                            <button onclick="window.location.href='{{action('Web\ShopPageController')}}';mApp.block('.empteCartAlert', {type: 'loader',state: 'info',});"
                                    type="button"
                                    class="btn m-btn--pill m-btn--air btn-warning">
                                <i class="flaticon-bag"></i>
                                افزودن محصول به سبد
                            </button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    @endif

    <div class="m-portlet btnGotoCheckoutPayment_mobile {{(!isset($invoiceInfo['orderproductCount']) || $invoiceInfo['orderproductCount']===0) ? 'd-none' : ''}}">
        <div class="m-portlet__body">
            <div class="row">
                <div class="col-6">

                    @if(optional(Auth::user())->id === null)
                        <button type="button"
                                onclick="$('.loginFormBeforeBuy').AnimateScrollTo();"
                                class="btn btn-lg m-btn--square m-btn btn-info">
                            ورود و خرید
                        </button>
                    @else
                        <button type="button"
                                onclick="$('#frmGotoGateway').submit();mApp.block('.btnGotoCheckoutPayment_mobile, .a--userCartList', {type: 'loader',state: 'info',});"
                                class="btn btn-lg m-btn--square m-btn btn-info btnGotoCheckoutPayment">
                            ثبت سفارش
                        </button>
                    @endif
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
