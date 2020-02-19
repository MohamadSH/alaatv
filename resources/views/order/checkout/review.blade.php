@extends('partials.templatePage' , ["pageName"=>$pageName])

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
{{--                                                <img src="/acm/extra/sad.gif" class="face-sad" alt="face-sad" width="40">--}}
                                                <svg width="40" height="40" class="face-sad" version="1.1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 50.8 50.7" xml:space="preserve"><g id="XMLID_46_"><path id="XMLID_349_" d="M49.5 18.9c-.6-3.1-2.8-5.7-4.8-8-6.3-7.1-16.6-11.7-26-8.2-.8.3-1.6.7-2.3 1.1h-.1l-.1.1c-1.6.9-3.7 2-5.1 3.2-2.9 2.6-5.6 5.7-7.5 9.1C-.8 22.8 2 33.7 6.2 39.7c5.3 7.6 15.9 12.1 25.1 9.5 1.6-.5 3.1-1.2 4.6-2 7.8-3.9 11.7-9.3 13.1-17.6.5-3.4 1.1-7.3.5-10.7z" fill="#b1b0f8"/><path id="XMLID_346_" d="M49.6 23.8c-.6 3.8-1.5 7.9-3.5 11.3-1.9 3.1-4.7 5.5-7.9 7.2-6.6 3.4-14.7 3.5-21.5.6-3.2-1.4-6.1-3.5-8.2-6.3-2.1-2.9-3.6-6.2-4.7-9.6-.7-2.4-1.4-5.3-1.5-8.2-2.5 6.6.1 15.6 3.8 21 5.3 7.6 15.9 12.1 25.1 9.5 1.6-.5 3.1-1.2 4.6-2 7.8-3.9 11.7-9.3 13.1-17.6.3-2.1.7-4.4.8-6.7 0 .2 0 .5-.1.8z" fill="#7f7fec"/><path xmlns="http://www.w3.org/2000/svg" id="XMLID_343_" d="M19.1 22.5c.2-.3.3-.8.4-1.2 0-1.2-.8-2.2-1.8-2.3-1.1 0-2 .9-2 2.1 0 .6.2 1.1.5 1.6.8-.3 2-.2 2.9-.2z" fill="#1f2e48"/><path id="XMLID_340_" d="M29.3 32.4c-.4 0-.8-.3-.8-.7-.2-1.6-1.1-3.5-2.7-3.6-1.6-.1-2.7 1.7-3.1 3.4-.1.4-.6.7-1 .6-.4-.1-.7-.6-.6-1 .6-2.3 2.3-4.8 4.8-4.6 2.6.2 3.9 2.8 4.2 5 .1.5-.2.9-.7 1 0-.1-.1-.1-.1-.1z" fill="#4a4ae1"/><path xmlns="http://www.w3.org/2000/svg" id="XMLID_337_" fill="#d0e9fd" d="M14.9 24.5c-.4 0-.7-.2-.8-.6-.1-.4.1-.9.6-1 .7-.2 1.4-.3 2.1-.4.5 0 .9.3.9.7 0 .5-.3.9-.7.9l-1.8.3c-.1.1-.2.1-.3.1z"/><path xmlns="http://www.w3.org/2000/svg" id="XMLID_332_" fill="#d0e9fd" d="M6.3 34.5h-.2c-.5-.1-.7-.6-.6-1 .3-1.2.7-2.4 1.2-3.4.2-.4.7-.6 1.1-.4.4.2.6.7.4 1.1-.4 1-.8 2-1.1 3.1-.1.3-.4.6-.8.6zm3-6.2c-.2 0-.4-.1-.5-.2-.4-.3-.4-.8-.1-1.2.8-1 1.7-1.8 2.7-2.5.4-.3.9-.2 1.2.2.3.4.2.9-.2 1.2-.9.6-1.7 1.3-2.4 2.2-.3.2-.5.3-.7.3z"/><path xmlns="http://www.w3.org/2000/svg" id="XMLID_329_" fill="#d0e9fd" d="M5.8 39.9c-.4 0-.8-.4-.8-.8V37c0-.5.4-.8.9-.8s.8.4.8.9V39c0 .5-.4.9-.9.9.1 0 0 0 0 0z"/><path xmlns="http://www.w3.org/2000/svg" id="XMLID_325_" fill="#1f2e48" d="M32.1 22.5c-.2-.3-.3-.8-.4-1.2 0-1.2.8-2.2 1.8-2.3 1.1 0 2 .9 2 2.1 0 .6-.2 1.1-.5 1.6-.8-.3-2-.2-2.9-.2z"/><path xmlns="http://www.w3.org/2000/svg" id="XMLID_322_" fill="#d0e9fd" d="M36.3 24.5h-.2c-.6-.2-1.2-.3-1.8-.3-.5 0-.8-.5-.7-.9 0-.5.5-.8.9-.7.7.1 1.4.2 2.1.4.4.1.7.6.6 1-.2.3-.5.5-.9.5z"/><path xmlns="http://www.w3.org/2000/svg" id="XMLID_317_" fill="#d0e9fd" d="M44.9 34.5c-.4 0-.7-.3-.8-.6-.3-1.1-.6-2.1-1.1-3.1-.2-.4 0-.9.4-1.1.4-.2.9 0 1.1.4.5 1.1.9 2.2 1.2 3.4.1.5-.2.9-.6 1h-.2zM42 28.3c-.2 0-.5-.1-.7-.3-.7-.9-1.5-1.6-2.4-2.2-.4-.3-.5-.8-.2-1.2.3-.4.8-.5 1.2-.2 1 .7 1.9 1.5 2.7 2.5.3.4.2.9-.1 1.2-.2.1-.3.2-.5.2z"/><path xmlns="http://www.w3.org/2000/svg" id="XMLID_314_" fill="#d0e9fd" d="M45.4 39.9c-.5 0-.9-.4-.8-.9v-1.9c0-.5.3-.9.8-.9s.9.3.9.8v2.1c-.1.5-.5.8-.9.8z"/><path xmlns="http://www.w3.org/2000/svg" id="XMLID_50_" fill="#5f5ff1" d="M13.6 18.5c-.4 0-.7-.3-.8-.7-.1-.5.2-.9.7-1 2.7-.5 6.6-3.8 7.6-6.3.2-.4.7-.6 1.1-.5.4.2.6.7.5 1.1-1.2 3.1-5.6 6.7-8.9 7.3-.1 0-.1.1-.2.1z"/><path xmlns="http://www.w3.org/2000/svg" id="XMLID_48_" d="M39.7 18.5h-.2c-3.3-.6-7.7-4.3-8.9-7.3-.2-.4 0-.9.5-1.1.4-.2.9 0 1.1.5 1 2.5 4.9 5.8 7.6 6.3.5.1.8.5.7 1 0 .3-.4.6-.8.6z" fill="#5f5ff1"/></g></svg>

                                                <svg width="40" height="40" class="face-happy" version="1.1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 50.8 50.7" xml:space="preserve"><g id="XMLID_370_"><path id="XMLID_386_" d="M47.7 16.2c-1.3-2.5-3.1-4.8-4.8-7.1-4.7-6-13.4-9.2-21-8.2C.2 4-7.3 36.2 12.6 47c4.7 2.6 10.1 3 15.4 2.6 10-.8 19.5-9.1 21.6-19 1-4.8.3-10-1.9-14.4z" fill="#f0d05b"/><path id="XMLID_383_" d="M33.1 29c-1 12.1-15.6 9.7-15.2 0 2.9 2.9 11.1 2.5 15.2 0z" fill="#f8fafb"/><path id="XMLID_381_" d="M49.4 20.9c0 1.3 0 2.6-.1 3.9-.4 4.1-1.4 8.2-4 11.4-2.2 2.8-5.3 4.8-8.5 6.2-6.8 3-15.1 3.6-22.2 1-3.3-1.2-6.2-3.2-8.3-6-2.3-3.1-3.5-7-4.1-10.7-.3-1.9-.5-3.8-.5-5.6-2.2 9.6.9 20.5 10.9 25.9 4.7 2.6 10.1 3 15.4 2.6 10-.8 19.5-9.1 21.6-19 .7-3.2.6-6.6-.2-9.7z" fill="#ecb03b"/><path id="XMLID_378_" d="M20.6 14.9c-.3-3.3-2.8-3.3-3.7-2.4-1.5 1.4-1.3 2.1-1.9 2.1-.5 0-.4-.7-1.9-2.1-.9-.9-3.4-.9-3.7 2.4-.3 3.2 4 7.2 5.6 7.2 1.6 0 5.9-4 5.6-7.2z" fill="#db5353"/><path id="XMLID_376_" d="M41.6 14.9c-.3-3.3-2.8-3.3-3.7-2.4-1.5 1.4-1.3 2.1-1.9 2.1s-.4-.7-1.9-2.1c-.9-.9-3.4-.9-3.7 2.4-.3 3.2 4 7.2 5.6 7.2 1.6 0 5.9-4 5.6-7.2z" fill="#db5353"/><path id="XMLID_372_" d="M25.6 38.1h-.5c-4-.3-8.2-3.5-8-9.1 0-.3.2-.6.5-.8.3-.1.7 0 .9.2 2.3 2.4 10.1 2.3 14.1-.1.3-.2.6-.2.9 0 .3.2.4.5.4.8-.4 6.3-4.4 9-8.3 9zm-6.7-7.4c.6 3.5 3.5 5.5 6.3 5.7 2.7.2 5.9-1.3 6.8-5.9-3.9 1.7-9.7 1.9-13.1.2z" fill="#dd8f28"/></g></svg>

{{--                                                <img src="/acm/extra/happy.gif" class="face-happy" alt="face-happy" width="40">--}}
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
                                                <input type="radio" name="radioBankType" value="{{route('redirectToBank', ['paymentMethod'=>'zarinpal', 'device'=>'web'])}}" data-bank-type="zarinpal" checked>
                                                <div class="state p-warning">
                                                    <img src="/acm/extra/payment/gateway/zarinpal-logo.png" class="img-thumbnail bankLogo" alt="bank-logo" width="60">
                                                    <label>
                                                    </label>
                                                </div>
                                            </div>

{{--
                                            <div class="pretty p-default p-curve p-pulse">
                                                <input type="radio" name="radioBankType" value="{{route('redirectToBank', ['paymentMethod'=>'mellat', 'device'=>'web'])}}" data-bank-type="mellat" checked>
                                                <div class="state p-warning">
                                                    <img src="/acm/extra/payment/gateway/mellat-logo.png" class="img-thumbnail bankLogo" alt="bank-logo" width="60">
                                                    <label>
                                                    </label>
                                                </div>
                                            </div>
--}}

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
