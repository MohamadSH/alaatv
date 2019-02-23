@extends("app")

@section("pageBar")

@endsection

@section('page-css')
    <style>
        .CheckoutReviewTotalPriceWarper .m-portlet__body {
            position: relative;
            padding: 10px 10px 40px 10px !important;
        }
        .CheckoutReviewTotalPriceWarper .btnGotoCheckoutPayment {
            position: absolute;
            bottom: 0px;
            left: 0px;
            right: 0px;
            width: 100%;
        }
        .a--userCartList .m-portlet__head {
            background: white;
        }
        .is-sticky .btnGotoCheckoutPayment {
            left: auto;
            right: auto;
            bottom: auto;
        }
        /*.orderproductWithChildWarper .m-widget5__item.childOfParent .m-widget5__item:last-child {*/
            /*border-bottom: .07rem dashed #ebedf2;*/
            /*margin-bottom: 0px;*/
        /*}*/

        .orderproductWithChildWarper .childOfParent .childIcon {
            display: table-cell;
            vertical-align: middle;
        }


        .orderproductWithChildWarper {
            border-bottom: .07rem dashed #ebedf2;
            border-radius: 7px;
            padding-top: 20px;
            margin: -20px -15px 15px;
            position: relative;
        }
        .orderproductWithChildWarper .hasChild {
            margin-bottom: 0;
            border-bottom: none;
            padding-left: 15px;
            padding-right: 15px;
        }
        .orderproductWithChildWarper .hasChild .m-widget5__stats2 {
            left: -10px;
        }
        .orderproductWithChildWarper .childOfParent {
            border: solid 3px #ff9000;
            padding: 5px 40px 5px 45px;
            border-radius: 7px;
            border-bottom: solid 3px #ff9000!important;
            position: relative;
        }
        .orderproductWithChildWarper .childOfParent:before {
            content: ' ';
            width: 0;
            height: 0;
            border-left: 21px solid transparent;
            border-right: 20px solid transparent;
            border-bottom: 20px solid #ff9000;
            position: absolute;
            top: -20px;
            right: 95px;
        }
        .orderproductWithChildWarper .childOfParent .childItem:last-child,
        .orderproductWithChildWarper:last-child {
            border: none;
        }
        .orderproductWithChildWarper .childOfParent .childItem {
            position: relative;
            border-bottom: .07rem dashed #ebedf2;
            margin: 5px 0px;
            padding: 0px 0px 5px 0px;
        }
        .orderproductWithChildWarper .childOfParent .childItem .childTitle,
        .orderproductWithChildWarper .childOfParent .childItem .childRemoveBtnWarper {
            float: right;
            line-height: 35px;
            margin-left: 5px;
        }
        .orderproductWithChildWarper .childOfParent .childItem .childTitle {

        }
        .orderproductWithChildWarper .childOfParent .childItem .childPrice {
            float: left;
        }
        .orderproductWithChildWarper .childOfParent .childItem .childRemoveBtnWarper {
            position: relative;
        }

        .orderproductWithChildWarper .m-widget7__img,
        .orderproductWithoutChildWarper .m-widget5__pic .m-widget7__img {
            max-width: 100%;
        }


        .a--userCartList .m-portlet__body .orderproductWithChildWarper .m-widget5__item.hasChild .m-widget5__content .m-widget5__pic {
            padding: 0px; width: auto;
        }
    </style>

    <style>
        /*media query*/
        @media (min-width: 767.98px) {
            .btnAddMoreProductToCart-desktop {
                display: block;
            }
            .btnAddMoreProductToCart-mobile {
                display: none;
            }

            .btnGotoCheckoutPayment-desktop {
                display: block;
            }
            .btnGotoCheckoutPayment_mobile {
                display: none;
            }

            .btnRemoveOrderproduct-child {
                display: none !important;
            }
            .a--userCartList .m-widget5__stats2 {
                display: none !important;
            }
        }
        @media (max-width: 767.98px) {
            .a--userCartList .m-widget5__item {
                position: relative;
            }
            .a--userCartList .m-widget5__stats1 {
                position: absolute;
                left: 0px;
                top: 30px;
            }
            .a--userCartList .m-widget5__stats2 {
                position: absolute;
                top: -30px;
                left: -24px;
                display: block;
            }

            .btnAddMoreProductToCart-desktop {
                display: none;
            }
            .btnAddMoreProductToCart-mobile {
                display: block;
            }


            .btnGotoCheckoutPayment-desktop {
                display: none;
            }
            .btnGotoCheckoutPayment_mobile {
                display: block;
                position: fixed;
                right: 0px;
                width: 100%;
                bottom: 0px;
                z-index: 99999;
                margin: 0px;
                -webkit-box-shadow: 0px 5px 25px 0px rgba(0,0,0,0.75);
                -moz-box-shadow: 0px 5px 25px 0px rgba(0,0,0,0.75);
                box-shadow: 0px 5px 25px 0px rgba(0,0,0,0.75);
            }
            .btnGotoCheckoutPayment_mobile .m-portlet__body {
                padding: 0px;
            }
            .btnGotoCheckoutPayment_mobile .btnGotoCheckoutPayment {
                width: 100%;
            }
            .btnGotoCheckoutPayment_mobile .priceReport {
                height: 100%;
                text-align: center;
            }
            .btnGotoCheckoutPayment_mobile .priceReport .a--productPrice {
                position: relative;
                top: 10px;
            }
            #m_scroll_top {
                bottom: 60px;
            }
            .m-grid__item.m-footer {
                display: none;
            }

            .orderproductWithChildWarper {
                margin-left: 0px;
            }
            .orderproductWithChildWarper .hasChild .m-widget5__stats2 {
                left: -10px;
            }
            .orderproductWithChildWarper .childOfParent .btnRemoveOrderproduct-child {
                position: absolute !important;
                left: -28px;
                top: -9px;
            }
            .orderproductWithChildWarper .childOfParent {
                padding: 5px 10px 5px 30px !important;
            }
            .orderproductWithChildWarper .childOfParent .childItem .childTitle,
            .orderproductWithChildWarper .childOfParent .childItem .childRemoveBtnWarper,
            .orderproductWithChildWarper .childOfParent .childItem .childPrice {
                float: none;
            }
            .btnRemoveOrderproduct-child {
                display: block;
            }
        }
    </style>
@endsection

@section("metadata")
    @parent
    <meta name="_token" content="{{ csrf_token() }}">
@endsection


@section('content')

    <div class="row">
        <div class="col">
            @include("systemMessage.flash")
        </div>
    </div>

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
                    <div class="m-portlet__head-tools">
                            <button onclick="window.location.href='{{action('Web\ProductController@search')}}';" type="button" class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-primary m-btn--gradient-to-info btnAddMoreProductToCart-desktop">
                                <i class="flaticon-bag"></i>
                                افزودن محصول جدید به سبد
                            </button>
                            <button onclick="window.location.href='{{action('Web\ProductController@search')}}';" type="button" class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-primary m-btn--gradient-to-info btnAddMoreProductToCart-mobile">
                                <i class="flaticon-bag"></i>
                                افزودن محصول جدید
                            </button>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <!--begin::Content-->
                    <div class="tab-content">
                        <!--begin::m-widget5-->
                        <div class="m-widget5">
                            @foreach($invoiceInfo['orderproducts'] as $key=>$orderProductItem)
                                @if($orderProductItem->count()>1)
                                    <div class="orderproductWithChildWarper">

                                        <div class="m-widget5__item hasChild">
                                            <div class="m-widget5__content">
                                                <div class="m-widget5__pic">
                                                    <button class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5"
                                                            type="button"
                                                            style="visibility: hidden;">
                                                        <span>
                                                            <i class="flaticon-circle"></i>
                                                            <span>حذف</span>
                                                        </span>
                                                    </button>
                                                </div>
                                                <div class="m-widget5__pic">
                                                    <a class="m-link" target="_blank" href="{{ $orderProductItem->first()->grandProduct->url }}">
                                                        <img class="m-widget7__img" src="{{ $orderProductItem->first()->grandProduct->photo }}" alt="">
                                                    </a>
                                                </div>

                                                {{--attribute value in desktop--}}
                                                <div class="m-widget5__section">
                                                    <div class=" d-none d-md-block d-lg-block d-xl-block">
                                                        <h4 class="m-widget5__title">
                                                            <a class="m-link" target="_blank" href="{{ $orderProductItem->first()->grandProduct->url }}">
                                                                {{ $orderProductItem->first()->grandProduct->name }}
                                                            </a>
                                                        </h4>
                                                        <span class="m-widget5__desc">
                                                            @if(isset($orderProductItem->first()->grandProduct->attributes))
                                                                @foreach($orderProductItem->first()->grandProduct->attributes as $productAttributeGroupKey=>$productAttributeGroup)
                                                                    @foreach($productAttributeGroup as $attributeItem)
                                                                        @if(($productAttributeGroupKey=='main' || $productAttributeGroupKey=='information') && $attributeItem->control=='simple')
                                                                            {{ $attributeItem->title }} : {{ $attributeItem->data[0]->name }}
                                                                            <br>
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                            @endif
                                                            @if(isset($orderProductItem->first()->attributevalues))
                                                                @foreach($orderProductItem->first()->attributevalues as $attributeGroupKey=>$attributeItem)
                                                                    <span class="m-badge m-badge--info m-badge--wide m-badge--rounded m--margin-bottom-5">{{ $attributeItem->name }}</span>
                                                                @endforeach
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>

                                                {{--attribute value in mobile--}}
                                                <div class="d-sm-none d-md-none d-lg-none m--margin-top-10">
                                                    <h4 class="m-widget5__title">
                                                        {{ $orderProductItem->first()->grandProduct->name }}
                                                    </h4>
                                                    <span class="m-widget5__desc">
                                                        @if(isset($orderProductItem->first()->grandProduct->attributes))
                                                            @foreach($orderProductItem->first()->grandProduct->attributes as $productAttributeGroupKey=>$productAttributeGroup)
                                                                @foreach($productAttributeGroup as $attributeItem)
                                                                    @if(($productAttributeGroupKey=='main' || $productAttributeGroupKey=='information') && $attributeItem->control=='simple')
                                                                        {{ $attributeItem->title }} : {{ $attributeItem->data[0]->name }}
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        @endif
                                                        @if(isset($orderProductItem->first()->attributevalues))
                                                            @foreach($orderProductItem->first()->attributevalues as $attributeGroupKey=>$attributeItem)
                                                                <span class="m-badge m-badge--info m-badge--wide m-badge--rounded m--margin-bottom-5">{{ $attributeItem->name }}</span>
                                                            @endforeach
                                                        @endif
                                                    </span>
                                                </div>

                                            </div>
                                            <div class="m-widget5__content">
                                                <div class="m-widget5__stats1">
                                                    {{--<span class = "m-nav__link-badge">--}}
                                                        {{--<span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">--}}
                                                            {{--<span class="m-badge m-badge--warning a--productRealPrice">14,000</span>--}}
                                                            {{--15,000 تومان--}}
                                                            {{--<span class="m-badge m-badge--info a--productDiscount">20%</span>--}}
                                                        {{--</span>--}}
                                                    {{--</span>--}}
                                                </div>
                                                <div class="m-widget5__stats2">
                                                    {{--<a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill">--}}
                                                        {{--<i class="la la-close"></i>--}}
                                                    {{--</a>--}}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="m-widget5__item childOfParent">

                                            @foreach($orderProductItem as $keyChild=>$orderProductItemChild)
                                                <div class="childItem">

                                                    <div class="childRemoveBtnWarper">
                                                        <button type="button"
                                                                data-action="{{action("Web\OrderproductController@destroy", $orderProductItemChild->id)}}"
                                                                class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                            <span>
                                                                <i class="flaticon-circle"></i>
                                                                <span>حذف</span>
                                                            </span>
                                                        </button>
                                                    </div>

                                                    <button type="button"
                                                       data-action="{{action("Web\OrderproductController@destroy", $orderProductItemChild->id)}}"
                                                       class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct btnRemoveOrderproduct-child">
                                                        <i class="la la-close"></i>
                                                    </button>

                                                    <div class="childTitle">
                                                        {{ $orderProductItemChild->product->name }}
                                                    </div>
                                                    <div class="childPrice">
                                                        <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                            @if($orderProductItemChild->price['customerPrice']!=$orderProductItemChild->price['cost'])
                                                                <span class="m-badge m-badge--warning a--productRealPrice">{{ number_format($orderProductItemChild->price['cost']+$orderProductItemChild->price['extraCost']) }}</span>
                                                            @endif
                                                            {{ number_format($orderProductItemChild->price['customerPrice']+$orderProductItemChild->price['extraCost']) }} تومان
                                                            @if(($orderProductItemChild->price['bonDiscount']+$orderProductItemChild->price['productDiscount'])>0)
                                                                <span class="m-badge m-badge--info a--productDiscount">{{ $orderProductItemChild->price['bonDiscount']+$orderProductItemChild->price['productDiscount'] }}%</span>
                                                            @endif
                                                        </span>
                                                    </div>

                                                    <div class="clearfix"></div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="m-widget5__item orderproductWithoutChildWarper">
                                        <div class="m-widget5__content">
                                            <div class="m-widget5__pic" style="padding: 0px; width: auto;">
                                                <button type="button"
                                                        data-action="{{action("Web\OrderproductController@destroy",$orderProductItem->first()->id)}}"
                                                        class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                </button>
                                            </div>
                                            <div class="m-widget5__pic">
                                                <a class="m-link" target="_blank" href="{{ $orderProductItem->first()->product->url }}">
                                                    <img class="m-widget7__img" src="{{ $orderProductItem->first()->product->photo }}" alt="">
                                                </a>
                                            </div>
                                            <div class="m-widget5__section">
                                                <div class=" d-none d-md-block d-lg-block d-xl-block">
                                                    <h4 class="m-widget5__title">
                                                        <a class="m-link" target="_blank" href="{{ $orderProductItem->first()->product->url }}">
                                                            {{ $orderProductItem->first()->product->name }}
                                                        </a>
                                                    </h4>
                                                    <span class="m-widget5__desc">
                                                        @if(isset($orderProductItem->first()->product->attributes))
                                                            @foreach($orderProductItem->first()->product->attributes as $productAttributeGroupKey=>$productAttributeGroup)
                                                                @foreach($productAttributeGroup as $attributeItem)
                                                                    @if(($productAttributeGroupKey=='main' || $productAttributeGroupKey=='information') && $attributeItem->control=='simple')
                                                                        {{ $attributeItem->title }} : {{ $attributeItem->data[0]->name }}
                                                                        <br>
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        @endif
                                                        @if(isset($orderProductItem->first()->attributevalues))
                                                            @foreach($orderProductItem->first()->attributevalues as $attributeGroupKey=>$attributeItem)
                                                                <span class="m-badge m-badge--info m-badge--wide m-badge--rounded m--margin-bottom-5">{{ $attributeItem->name }}</span>
                                                            @endforeach
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="d-sm-none d-md-none d-lg-none m--margin-top-10">
                                                <h4 class="m-widget5__title">
                                                    {{ $orderProductItem->first()->product->name }}
                                                </h4>
                                                <span class="m-widget5__desc">
                                                    @if(isset($orderProductItem->first()->product->attributes))
                                                        @foreach($orderProductItem->first()->product->attributes as $attributeGroupKey=>$attributeGroup)
                                                            @foreach($attributeGroup as $attributeItem)
                                                                @if(($attributeGroupKey=='main' || $attributeGroupKey=='information') && $attributeItem->control=='simple')
                                                                    {{ $attributeItem->title }} : {{ $attributeItem->data[0]->name }}
                                                                    <br>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    @endif
                                                    @if(isset($orderProductItem->first()->attributevalues))
                                                        @foreach($orderProductItem->first()->attributevalues as $attributeGroupKey=>$attributeItem)
                                                            <span class="m-badge m-badge--info m-badge--wide m-badge--rounded m--margin-bottom-5">{{ $attributeItem->name }}</span>
                                                        @endforeach
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                        <div class="m-widget5__content">
                                            <div class="m-widget5__stats1">
                                            <span class = "m-nav__link-badge">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    @if($orderProductItem->first()->price['customerPrice']!=$orderProductItem->first()->price['cost'])
                                                        <span class="m-badge m-badge--warning a--productRealPrice">{{ number_format($orderProductItem->first()->price['cost']+$orderProductItem->first()->price['extraCost']) }}</span>
                                                    @endif
                                                    {{ number_format($orderProductItem->first()->price['customerPrice']+$orderProductItem->first()->price['extraCost']) }} تومان
                                                    @if(($orderProductItem->first()->price['bonDiscount']+$orderProductItem->first()->price['productDiscount'])>0)
                                                        <span class="m-badge m-badge--info a--productDiscount">{{ $orderProductItem->first()->price['bonDiscount']+$orderProductItem->first()->price['productDiscount'] }}%</span>
                                                    @endif
                                                </span>
                                            </span>
                                            </div>
                                            <div class="m-widget5__stats2">
                                                <a href="#"
                                                   data-action="{{action("Web\OrderproductController@destroy",$orderProductItem->first()->id)}}"
                                                   class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct">
                                                    <i class="la la-close"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endIf
                            @endforeach
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
                                    <span class="m-widget1__desc">
                                        شما {{ $invoiceInfo['orderproductCount'] }} محصول انتخاب کرده اید
                                    </span>
                                </div>
                                <div class="col m--align-right">
                                <span class="m-widget1__number m--font-danger">
                                    {{ number_format($invoiceInfo['orderproductsRawCost']) }} تومان
                                </span>
                                </div>
                            </div>
                        </div>
                        @if($invoiceInfo['orderproductsRawCost']>$invoiceInfo['totalCost'])
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">
                                            سود شما از خرید :
                                        </h3>
                                        <span class="m-widget1__desc">
                                        شما در مجموع {{ round((1-($invoiceInfo['totalCost']/$invoiceInfo['orderproductsRawCost']))*100) }}% تخفیف گرفته اید
                                    </span>
                                    </div>
                                    <div class="col m--align-right">
                                    <span class="m-widget1__number m--font-success">
                                        {{ number_format($invoiceInfo['orderproductsRawCost']-$invoiceInfo['totalCost']) }} تومان
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
                                <span class="m-widget1__number m--font-primary">
                                     {{ number_format($invoiceInfo['totalCost']) }} تومان
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button"
                            onclick="window.location.href='{{action('Web\OrderController@checkoutPayment')}}';"
                            class="btn btn-lg m-btn--square m-btn m-btn--gradient-from-success m-btn--gradient-to-accent btnGotoCheckoutPayment-desktop btnGotoCheckoutPayment">
                        ادامه و ثبت سفارش
                    </button>
                </div>
            </div>
            <!--end:: Widgets/Authors Profit-->
        </div>
</div>

    <div class="m-portlet btnGotoCheckoutPayment_mobile">
        <div class="m-portlet__body">
            <div class="row">
                <div class="col-6">
                    <button type="button"
                            onclick="window.location.href='{{action('Web\OrderController@checkoutPayment')}}';"
                            class="btn btn-lg m-btn--square m-btn m-btn--gradient-from-success m-btn--gradient-to-accent btnGotoCheckoutPayment">
                        ثبت سفارش
                    </button>
                </div>
                <div class="col-6">
                    <div class="priceReport">
                        <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                            @if($invoiceInfo['orderproductsRawCost']>$invoiceInfo['totalCost'])
                                <span class="m-badge m-badge--warning a--productRealPrice">{{ number_format($invoiceInfo['orderproductsRawCost']) }}</span>
                                <span class="m-badge m-badge--info a--productDiscount">{{ round((1-($invoiceInfo['totalCost']/$invoiceInfo['orderproductsRawCost']))*100) }}%</span>
                            @endif
                            {{ number_format($invoiceInfo['totalCost']) }} تومان
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-js')

    <script src="{{ mix('/js/checkout-review.js') }}"></script>

    <script type="text/javascript">


        $(document).ready(function() {
            $('.a--userCartList .m-portlet__head').sticky({
                topSpacing: $('#m_header').height(),
                zIndex: 99
            });

            $(document).on('click', '.btnRemoveOrderproduct', function () {

                mApp.block('.a--userCartList', {
                    overlayColor: "#000000",
                    type: "loader",
                    state: "success",
                    message: "کمی صبر کنید..."
                });
                mApp.block('.CheckoutReviewTotalPriceWarper', {
                    type: "loader",
                    state: "success",
                });

                $.ajax({
                    type: 'DELETE',
                    url: $(this).data('action'),
                    data: {_token: "{{ csrf_token() }}" },
                    statusCode: {
                        //The status for when action was successful
                        200: function (response) {
                            // console.log(response);
                            location.reload();
                        },
                        //The status for when the user is not authorized for making the request
                        403: function (response) {
                            window.location.replace("/403");
                        },
                        //The status for when the user is not authorized for making the request
                        401: function (response) {
                            window.location.replace("/403");
                        },
                        //Method Not Allowed
                        405: function (response) {
//                        console.log(response);
//                        console.log(response.responseText);
                            location.reload();
                        },
                        404: function (response) {
                            window.location.replace("/404");
                        },
                        //The status for when form data is not valid
                        422: function (response) {
                            // console.log(response);
                        },
                        //The status for when there is error php code
                        500: function (response) {
                            // console.log(response.responseText);
//                            toastr["error"]("خطای برنامه!", "پیام سیستم");
                        },
                        //The status for when there is error php code
                        503: function (response) {
                            toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
                        }
                    }
                });
            });
        });
        // $(window).load(function(){
        //     $('.btnGotoCheckoutPayment').sticky({ topSpacing: 0 });
        // });
        // $(window).load(function(){
        //     $('.a--userCartList .m-portlet__head').sticky({ topSpacing: 0 });
        // });

        /**
         * Set token for ajax request
         */
        {{--$(function () {--}}
            {{--$.ajaxSetup({--}}
                {{--headers: {--}}
                    {{--'X-CSRF-TOKEN': window.Laravel.csrfToken,--}}
                {{--}--}}
            {{--});--}}
        {{--});--}}
        {{--$(document).on("click", "#printBill", function () {--}}
{{--//                $("#printBill-loading").show(0).delay(2000).hide(0);--}}
            {{--$("#printBill-div").print({--}}
                {{--timeout: 500,--}}
                {{--title: "{{$wSetting->site->name}}",--}}
                {{--noPrintSelector: ".no-print",--}}
{{--//                    stylesheet:"/assets/global/css/components-md-rtl.min.css"--}}
            {{--});--}}
        {{--});--}}
    </script>
@endsection