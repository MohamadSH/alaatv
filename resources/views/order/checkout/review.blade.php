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

    <div class="hidden">
        @include("systemMessage.flash")
    </div>

    @if(isset(request()->route()->parameters['modelNo']) && request()->route()->parameters['modelNo']==2)
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

                            <button type="button" class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-primary m-btn--gradient-to-info btnAddMoreProductToCart-desktop">
                                <i class="flaticon-bag"></i>
                                افزودن محصول جدید به سبد
                            </button>
                            <button type="button" class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-primary m-btn--gradient-to-info btnAddMoreProductToCart-mobile">
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

                                <div class="m-widget5__item">
                                    <div class="m-widget5__content">
                                        <div class="m-widget5__pic" style="padding: 0px; width: auto;">
                                            <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5">
                                                <span>
                                                    <i class="flaticon-circle"></i>
                                                    <span>حذف</span>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="m-widget5__pic">
                                            <img class="m-widget7__img" src="/assets/app/media/img//products/product6.jpg" alt="">
                                        </div>
                                        <div class="m-widget5__section">
                                            <div class=" d-none d-md-block d-lg-block d-xl-block">
                                                <h4 class="m-widget5__title">
                                                    جزوه دوره جنسی خانم ها
                                                </h4>
                                                <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                            </div>
                                        </div>
                                        <div class="d-sm-none d-md-none d-lg-none m--margin-top-10">
                                            <h4 class="m-widget5__title">
                                                جزوه دوره جنسی خانم ها
                                            </h4>
                                            <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                        </div>
                                    </div>
                                    <div class="m-widget5__content">
                                        <div class="m-widget5__stats1">
                                        <span class = "m-nav__link-badge">
                                            <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                15,000 تومان
                                                <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                            </span>
                                        </span>
                                        </div>
                                        <div class="m-widget5__stats2">
                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill">
                                                <i class="la la-close"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget5__item">
                                    <div class="m-widget5__content">
                                        <div class="m-widget5__pic" style="padding: 0px; width: auto;">
                                            <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5">
                                                <span>
                                                    <i class="flaticon-circle"></i>
                                                    <span>حذف</span>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="m-widget5__pic">
                                            <img class="m-widget7__img" src="/assets/app/media/img//products/product6.jpg" alt="">
                                        </div>
                                        <div class="m-widget5__section">
                                            <div class=" d-none d-md-block d-lg-block d-xl-block">
                                                <h4 class="m-widget5__title">
                                                    جزوه دوره جنسی خانم ها
                                                </h4>
                                                <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                            </div>
                                        </div>
                                        <div class="d-sm-none d-md-none d-lg-none m--margin-top-10">
                                            <h4 class="m-widget5__title">
                                                جزوه دوره جنسی خانم ها
                                            </h4>
                                            <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                        </div>
                                    </div>
                                    <div class="m-widget5__content">
                                        <div class="m-widget5__stats1">
                                        <span class = "m-nav__link-badge">
                                            <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                15,000 تومان
                                                <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                            </span>
                                        </span>
                                        </div>
                                        <div class="m-widget5__stats2">
                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill">
                                                <i class="la la-close"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="orderproductWithChildWarper">

                                    <div class="m-widget5__item hasChild">
                                        <div class="m-widget5__content">
                                            <div class="m-widget5__pic" style="padding: 0px; width: auto;">
                                                <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                </button>
                                            </div>
                                            <div class="m-widget5__pic">
                                                <img class="m-widget7__img" src="/assets/app/media/img//products/product6.jpg" alt="">
                                            </div>
                                            <div class="m-widget5__section">
                                                <div class=" d-none d-md-block d-lg-block d-xl-block">
                                                    <h4 class="m-widget5__title">
                                                        جزوه دوره جنسی خانم ها
                                                    </h4>
                                                    <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                                </div>
                                            </div>
                                            <div class="d-sm-none d-md-none d-lg-none m--margin-top-10">
                                                <h4 class="m-widget5__title">
                                                    جزوه دوره جنسی خانم ها
                                                </h4>
                                                <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                            </div>
                                        </div>
                                        <div class="m-widget5__content">
                                            <div class="m-widget5__stats1">
                                                <span class = "m-nav__link-badge">
                                                    <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                        <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                        15,000 تومان
                                                        <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                    </span>
                                                </span>
                                            </div>
                                            <div class="m-widget5__stats2">
                                                <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill">
                                                    <i class="la la-close"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="m-widget5__item childOfParent">

                                        <div class="childItem">

                                            <div class="childRemoveBtnWarper">
                                                <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                </button>
                                            </div>

                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                <i class="la la-close"></i>
                                            </a>

                                            <div class="childTitle">
                                                جزوه دوره جنسی خانم ها
                                            </div>
                                            <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                            </div>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="childItem">

                                            <div class="childRemoveBtnWarper">
                                                <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                </button>
                                            </div>

                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                <i class="la la-close"></i>
                                            </a>

                                            <div class="childTitle">
                                                جزوه دوره جنسی خانم ها
                                            </div>
                                            <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                            </div>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="childItem">

                                            <div class="childRemoveBtnWarper">
                                                <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                </button>
                                            </div>

                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                <i class="la la-close"></i>
                                            </a>

                                            <div class="childTitle">
                                                جزوه دوره جنسی خانم ها
                                            </div>
                                            <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                            </div>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="childItem">

                                            <div class="childRemoveBtnWarper">
                                                <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                </button>
                                            </div>

                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                <i class="la la-close"></i>
                                            </a>

                                            <div class="childTitle">
                                                جزوه دوره جنسی خانم ها
                                            </div>
                                            <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                            </div>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="childItem">

                                            <div class="childRemoveBtnWarper">
                                                <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                </button>
                                            </div>

                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                <i class="la la-close"></i>
                                            </a>

                                            <div class="childTitle">
                                                جزوه دوره جنسی خانم ها
                                            </div>
                                            <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                            </div>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="childItem">

                                            <div class="childRemoveBtnWarper">
                                                <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                </button>
                                            </div>

                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                <i class="la la-close"></i>
                                            </a>

                                            <div class="childTitle">
                                                جزوه دوره جنسی خانم ها
                                            </div>
                                            <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                            </div>

                                            <div class="clearfix"></div>
                                        </div>

                                    </div>

                                </div>
                                <div class="m-widget5__item">
                                    <div class="m-widget5__content">
                                        <div class="m-widget5__pic" style="padding: 0px; width: auto;">
                                            <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5">
                                                <span>
                                                    <i class="flaticon-circle"></i>
                                                    <span>حذف</span>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="m-widget5__pic">
                                            <img class="m-widget7__img" src="/assets/app/media/img//products/product6.jpg" alt="">
                                        </div>
                                        <div class="m-widget5__section">
                                            <div class=" d-none d-md-block d-lg-block d-xl-block">
                                                <h4 class="m-widget5__title">
                                                    جزوه دوره جنسی خانم ها
                                                </h4>
                                                <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                            </div>
                                        </div>
                                        <div class="d-sm-none d-md-none d-lg-none m--margin-top-10">
                                            <h4 class="m-widget5__title">
                                                جزوه دوره جنسی خانم ها
                                            </h4>
                                            <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                        </div>
                                    </div>
                                    <div class="m-widget5__content">
                                        <div class="m-widget5__stats1">
                                        <span class = "m-nav__link-badge">
                                            <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                15,000 تومان
                                                <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                            </span>
                                        </span>
                                        </div>
                                        <div class="m-widget5__stats2">
                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill">
                                                <i class="la la-close"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget5__item">
                                    <div class="m-widget5__content">
                                        <div class="m-widget5__pic" style="padding: 0px; width: auto;">
                                            <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5">
                                                <span>
                                                    <i class="flaticon-circle"></i>
                                                    <span>حذف</span>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="m-widget5__pic">
                                            <img class="m-widget7__img" src="/assets/app/media/img//products/product6.jpg" alt="">
                                        </div>
                                        <div class="m-widget5__section">
                                            <div class=" d-none d-md-block d-lg-block d-xl-block">
                                                <h4 class="m-widget5__title">
                                                    جزوه دوره جنسی خانم ها
                                                </h4>
                                                <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                            </div>
                                        </div>
                                        <div class="d-sm-none d-md-none d-lg-none m--margin-top-10">
                                            <h4 class="m-widget5__title">
                                                جزوه دوره جنسی خانم ها
                                            </h4>
                                            <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                        </div>
                                    </div>
                                    <div class="m-widget5__content">
                                        <div class="m-widget5__stats1">
                                        <span class = "m-nav__link-badge">
                                            <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                15,000 تومان
                                                <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                            </span>
                                        </span>
                                        </div>
                                        <div class="m-widget5__stats2">
                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill">
                                                <i class="la la-close"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="orderproductWithChildWarper">

                                    <div class="m-widget5__item hasChild">
                                        <div class="m-widget5__content">
                                            <div class="m-widget5__pic" style="padding: 0px; width: auto;">
                                                <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                </button>
                                            </div>
                                            <div class="m-widget5__pic">
                                                <img class="m-widget7__img" src="/assets/app/media/img//products/product6.jpg" alt="">
                                            </div>
                                            <div class="m-widget5__section">
                                                <div class=" d-none d-md-block d-lg-block d-xl-block">
                                                    <h4 class="m-widget5__title">
                                                        جزوه دوره جنسی خانم ها
                                                    </h4>
                                                    <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                                </div>
                                            </div>
                                            <div class="d-sm-none d-md-none d-lg-none m--margin-top-10">
                                                <h4 class="m-widget5__title">
                                                    جزوه دوره جنسی خانم ها
                                                </h4>
                                                <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                            </div>
                                        </div>
                                        <div class="m-widget5__content">
                                            <div class="m-widget5__stats1">
                                                <span class = "m-nav__link-badge">
                                                    <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                        <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                        15,000 تومان
                                                        <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                    </span>
                                                </span>
                                            </div>
                                            <div class="m-widget5__stats2">
                                                <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill">
                                                    <i class="la la-close"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="m-widget5__item childOfParent">

                                        <div class="childItem">

                                            <div class="childRemoveBtnWarper">
                                                <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                </button>
                                            </div>

                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                <i class="la la-close"></i>
                                            </a>

                                            <div class="childTitle">
                                                جزوه دوره جنسی خانم ها
                                            </div>
                                            <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                            </div>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="childItem">

                                            <div class="childRemoveBtnWarper">
                                                <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                </button>
                                            </div>

                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                <i class="la la-close"></i>
                                            </a>

                                            <div class="childTitle">
                                                جزوه دوره جنسی خانم ها
                                            </div>
                                            <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                            </div>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="childItem">

                                            <div class="childRemoveBtnWarper">
                                                <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                </button>
                                            </div>

                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                <i class="la la-close"></i>
                                            </a>

                                            <div class="childTitle">
                                                جزوه دوره جنسی خانم ها
                                            </div>
                                            <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                            </div>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="childItem">

                                            <div class="childRemoveBtnWarper">
                                                <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                </button>
                                            </div>

                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                <i class="la la-close"></i>
                                            </a>

                                            <div class="childTitle">
                                                جزوه دوره جنسی خانم ها
                                            </div>
                                            <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                            </div>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="childItem">

                                            <div class="childRemoveBtnWarper">
                                                <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                </button>
                                            </div>

                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                <i class="la la-close"></i>
                                            </a>

                                            <div class="childTitle">
                                                جزوه دوره جنسی خانم ها
                                            </div>
                                            <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                            </div>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="childItem">

                                            <div class="childRemoveBtnWarper">
                                                <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                </button>
                                            </div>

                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                <i class="la la-close"></i>
                                            </a>

                                            <div class="childTitle">
                                                جزوه دوره جنسی خانم ها
                                            </div>
                                            <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                            </div>

                                            <div class="clearfix"></div>
                                        </div>

                                    </div>

                                </div>
                                <div class="m-widget5__item">
                                    <div class="m-widget5__content">
                                        <div class="m-widget5__pic" style="padding: 0px; width: auto;">
                                            <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5">
                                                <span>
                                                    <i class="flaticon-circle"></i>
                                                    <span>حذف</span>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="m-widget5__pic">
                                            <img class="m-widget7__img" src="/assets/app/media/img//products/product6.jpg" alt="">
                                        </div>
                                        <div class="m-widget5__section">
                                            <div class=" d-none d-md-block d-lg-block d-xl-block">
                                                <h4 class="m-widget5__title">
                                                    جزوه دوره جنسی خانم ها
                                                </h4>
                                                <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                            </div>
                                        </div>
                                        <div class="d-sm-none d-md-none d-lg-none m--margin-top-10">
                                            <h4 class="m-widget5__title">
                                                جزوه دوره جنسی خانم ها
                                            </h4>
                                            <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                        </div>
                                    </div>
                                    <div class="m-widget5__content">
                                        <div class="m-widget5__stats1">
                                        <span class = "m-nav__link-badge">
                                            <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                15,000 تومان
                                                <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                            </span>
                                        </span>
                                        </div>
                                        <div class="m-widget5__stats2">
                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill">
                                                <i class="la la-close"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget5__item">
                                    <div class="m-widget5__content">
                                        <div class="m-widget5__pic" style="padding: 0px; width: auto;">
                                            <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5">
                                                <span>
                                                    <i class="flaticon-circle"></i>
                                                    <span>حذف</span>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="m-widget5__pic">
                                            <img class="m-widget7__img" src="/assets/app/media/img//products/product6.jpg" alt="">
                                        </div>
                                        <div class="m-widget5__section">
                                            <div class=" d-none d-md-block d-lg-block d-xl-block">
                                                <h4 class="m-widget5__title">
                                                    جزوه دوره جنسی خانم ها
                                                </h4>
                                                <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                            </div>
                                        </div>
                                        <div class="d-sm-none d-md-none d-lg-none m--margin-top-10">
                                            <h4 class="m-widget5__title">
                                                جزوه دوره جنسی خانم ها
                                            </h4>
                                            <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                        </div>
                                    </div>
                                    <div class="m-widget5__content">
                                        <div class="m-widget5__stats1">
                                        <span class = "m-nav__link-badge">
                                            <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                15,000 تومان
                                                <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                            </span>
                                        </span>
                                        </div>
                                        <div class="m-widget5__stats2">
                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill">
                                                <i class="la la-close"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget5__item">
                                    <div class="m-widget5__content">
                                        <div class="m-widget5__pic" style="padding: 0px; width: auto;">
                                            <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5">
                                                <span>
                                                    <i class="flaticon-circle"></i>
                                                    <span>حذف</span>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="m-widget5__pic">
                                            <img class="m-widget7__img" src="/assets/app/media/img//products/product6.jpg" alt="">
                                        </div>
                                        <div class="m-widget5__section">
                                            <div class=" d-none d-md-block d-lg-block d-xl-block">
                                                <h4 class="m-widget5__title">
                                                    جزوه دوره جنسی خانم ها
                                                </h4>
                                                <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                            </div>
                                        </div>
                                        <div class="d-sm-none d-md-none d-lg-none m--margin-top-10">
                                            <h4 class="m-widget5__title">
                                                جزوه دوره جنسی خانم ها
                                            </h4>
                                            <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                        </div>
                                    </div>
                                    <div class="m-widget5__content">
                                        <div class="m-widget5__stats1">
                                        <span class = "m-nav__link-badge">
                                            <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                15,000 تومان
                                                <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                            </span>
                                        </span>
                                        </div>
                                        <div class="m-widget5__stats2">
                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill">
                                                <i class="la la-close"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget5__item">
                                    <div class="m-widget5__content">
                                        <div class="m-widget5__pic" style="padding: 0px; width: auto;">
                                            <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5">
                                                <span>
                                                    <i class="flaticon-circle"></i>
                                                    <span>حذف</span>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="m-widget5__pic">
                                            <img class="m-widget7__img" src="/assets/app/media/img//products/product6.jpg" alt="">
                                        </div>
                                        <div class="m-widget5__section">
                                            <div class=" d-none d-md-block d-lg-block d-xl-block">
                                                <h4 class="m-widget5__title">
                                                    جزوه دوره جنسی خانم ها
                                                </h4>
                                                <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                            </div>
                                        </div>
                                        <div class="d-sm-none d-md-none d-lg-none m--margin-top-10">
                                            <h4 class="m-widget5__title">
                                                جزوه دوره جنسی خانم ها
                                            </h4>
                                            <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                        </div>
                                    </div>
                                    <div class="m-widget5__content">
                                        <div class="m-widget5__stats1">
                                        <span class = "m-nav__link-badge">
                                            <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                15,000 تومان
                                                <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                            </span>
                                        </span>
                                        </div>
                                        <div class="m-widget5__stats2">
                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill">
                                                <i class="la la-close"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="orderproductWithChildWarper">

                                    <div class="m-widget5__item hasChild">
                                        <div class="m-widget5__content">
                                            <div class="m-widget5__pic" style="padding: 0px; width: auto;">
                                                <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                </button>
                                            </div>
                                            <div class="m-widget5__pic">
                                                <img class="m-widget7__img" src="/assets/app/media/img//products/product6.jpg" alt="">
                                            </div>
                                            <div class="m-widget5__section">
                                                <div class=" d-none d-md-block d-lg-block d-xl-block">
                                                    <h4 class="m-widget5__title">
                                                        جزوه دوره جنسی خانم ها
                                                    </h4>
                                                    <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                                </div>
                                            </div>
                                            <div class="d-sm-none d-md-none d-lg-none m--margin-top-10">
                                                <h4 class="m-widget5__title">
                                                    جزوه دوره جنسی خانم ها
                                                </h4>
                                                <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                            </div>
                                        </div>
                                        <div class="m-widget5__content">
                                            <div class="m-widget5__stats1">
                                                <span class = "m-nav__link-badge">
                                                    <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                        <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                        15,000 تومان
                                                        <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                    </span>
                                                </span>
                                            </div>
                                            <div class="m-widget5__stats2">
                                                <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill">
                                                    <i class="la la-close"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="m-widget5__item childOfParent">

                                        <div class="childItem">

                                            <div class="childRemoveBtnWarper">
                                                <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                </button>
                                            </div>

                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                <i class="la la-close"></i>
                                            </a>

                                            <div class="childTitle">
                                                جزوه دوره جنسی خانم ها
                                            </div>
                                            <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                            </div>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="childItem">

                                            <div class="childRemoveBtnWarper">
                                                <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                </button>
                                            </div>

                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                <i class="la la-close"></i>
                                            </a>

                                            <div class="childTitle">
                                                جزوه دوره جنسی خانم ها
                                            </div>
                                            <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                            </div>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="childItem">

                                            <div class="childRemoveBtnWarper">
                                                <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                </button>
                                            </div>

                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                <i class="la la-close"></i>
                                            </a>

                                            <div class="childTitle">
                                                جزوه دوره جنسی خانم ها
                                            </div>
                                            <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                            </div>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="childItem">

                                            <div class="childRemoveBtnWarper">
                                                <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                </button>
                                            </div>

                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                <i class="la la-close"></i>
                                            </a>

                                            <div class="childTitle">
                                                جزوه دوره جنسی خانم ها
                                            </div>
                                            <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                            </div>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="childItem">

                                            <div class="childRemoveBtnWarper">
                                                <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                </button>
                                            </div>

                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                <i class="la la-close"></i>
                                            </a>

                                            <div class="childTitle">
                                                جزوه دوره جنسی خانم ها
                                            </div>
                                            <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                            </div>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="childItem">

                                            <div class="childRemoveBtnWarper">
                                                <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                </button>
                                            </div>

                                            <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                <i class="la la-close"></i>
                                            </a>

                                            <div class="childTitle">
                                                جزوه دوره جنسی خانم ها
                                            </div>
                                            <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                            </div>

                                            <div class="clearfix"></div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                            <!--end::m-widget5-->
                        </div>
                        <!--end::Content-->
                    </div>
                </div>
                <!--end:: Widgets/Best Sellers-->  </div>
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
                                        شما 4 کالا انتخاب کرده اید
                                    </span>
                                    </div>
                                    <div class="col m--align-right">
                                    <span class="m-widget1__number m--font-danger">
                                        ۲۰,۰۰۰ تومان
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">
                                            سود شما از خرید :
                                        </h3>
                                        <span class="m-widget1__desc">
                                        شما در مجموع 26% تخفیف گرفته اید
                                    </span>
                                    </div>
                                    <div class="col m--align-right">
                                    <span class="m-widget1__number m--font-success">
                                        ۵,۱۰۰ تومان
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">
                                            <i class="la la-money m--icon-font-size-lg3"></i>
                                            مبلغ قابل پرداخت:
                                        </h3>
                                        <span class="m-widget1__desc">

                                    </span>
                                    </div>
                                    <div class="col m--align-right">
                                    <span class="m-widget1__number m--font-brand">
                                         ۱۴,۹۰۰ تومان
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-lg m-btn--square m-btn m-btn--gradient-from-success m-btn--gradient-to-accent btnGotoCheckoutPayment-desktop btnGotoCheckoutPayment">
                            ادامه و ثبت سفارش
                        </button>
                    </div>
                </div>
                <!--end:: Widgets/Authors Profit-->
            </div>
        </div>
    @else
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
                            <button type="button" class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-primary m-btn--gradient-to-info btnAddMoreProductToCart-desktop">
                                <i class="flaticon-bag"></i>
                                افزودن محصول جدید به سبد
                            </button>
                            <button type="button" class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-primary m-btn--gradient-to-info btnAddMoreProductToCart-mobile">
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

                                @foreach($invoiceInfo['purchasedOrderproducts'] as $key=>$orderProductItem)
                                    @if(false)
                                        <div class="orderproductWithChildWarper">

                                            <div class="m-widget5__item hasChild">
                                                <div class="m-widget5__content">
                                                    <div class="m-widget5__pic" style="padding: 0px; width: auto;">
                                                        <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                        </button>
                                                    </div>
                                                    <div class="m-widget5__pic">
                                                        <img class="m-widget7__img" src="/assets/app/media/img//products/product6.jpg" alt="">
                                                    </div>
                                                    <div class="m-widget5__section">
                                                        <div class=" d-none d-md-block d-lg-block d-xl-block">
                                                            <h4 class="m-widget5__title">
                                                                جزوه دوره جنسی خانم ها
                                                            </h4>
                                                            <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                                        </div>
                                                    </div>
                                                    <div class="d-sm-none d-md-none d-lg-none m--margin-top-10">
                                                        <h4 class="m-widget5__title">
                                                            جزوه دوره جنسی خانم ها
                                                        </h4>
                                                        <span class="m-widget5__desc">
                                            دبیر : جلال موقاری
                                        </span>
                                                    </div>
                                                </div>
                                                <div class="m-widget5__content">
                                                    <div class="m-widget5__stats1">
                                                <span class = "m-nav__link-badge">
                                                    <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                        <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                        15,000 تومان
                                                        <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                    </span>
                                                </span>
                                                    </div>
                                                    <div class="m-widget5__stats2">
                                                        <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill">
                                                            <i class="la la-close"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="m-widget5__item childOfParent">

                                                <div class="childItem">

                                                    <div class="childRemoveBtnWarper">
                                                        <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                        </button>
                                                    </div>

                                                    <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                        <i class="la la-close"></i>
                                                    </a>

                                                    <div class="childTitle">
                                                        جزوه دوره جنسی خانم ها
                                                    </div>
                                                    <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                                    </div>

                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="childItem">

                                                    <div class="childRemoveBtnWarper">
                                                        <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                        </button>
                                                    </div>

                                                    <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                        <i class="la la-close"></i>
                                                    </a>

                                                    <div class="childTitle">
                                                        جزوه دوره جنسی خانم ها
                                                    </div>
                                                    <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                                    </div>

                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="childItem">

                                                    <div class="childRemoveBtnWarper">
                                                        <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                        </button>
                                                    </div>

                                                    <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                        <i class="la la-close"></i>
                                                    </a>

                                                    <div class="childTitle">
                                                        جزوه دوره جنسی خانم ها
                                                    </div>
                                                    <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                                    </div>

                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="childItem">

                                                    <div class="childRemoveBtnWarper">
                                                        <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                        </button>
                                                    </div>

                                                    <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                        <i class="la la-close"></i>
                                                    </a>

                                                    <div class="childTitle">
                                                        جزوه دوره جنسی خانم ها
                                                    </div>
                                                    <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                                    </div>

                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="childItem">

                                                    <div class="childRemoveBtnWarper">
                                                        <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                        </button>
                                                    </div>

                                                    <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                        <i class="la la-close"></i>
                                                    </a>

                                                    <div class="childTitle">
                                                        جزوه دوره جنسی خانم ها
                                                    </div>
                                                    <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                                    </div>

                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="childItem">

                                                    <div class="childRemoveBtnWarper">
                                                        <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5 btnRemoveOrderproduct">
                                                    <span>
                                                        <i class="flaticon-circle"></i>
                                                        <span>حذف</span>
                                                    </span>
                                                        </button>
                                                    </div>

                                                    <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill btnRemoveOrderproduct-child">
                                                        <i class="la la-close"></i>
                                                    </a>

                                                    <div class="childTitle">
                                                        جزوه دوره جنسی خانم ها
                                                    </div>
                                                    <div class="childPrice">
                                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                    15,000 تومان
                                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                </span>
                                                    </div>

                                                    <div class="clearfix"></div>
                                                </div>

                                            </div>

                                        </div>
                                    @else
                                        <div class="m-widget5__item">
                                            <div class="m-widget5__content">
                                                <div class="m-widget5__pic" style="padding: 0px; width: auto;">
                                                    <button type="button" class="btn btn-sm m-btn--pill m-btn--air btn-danger d-none d-md-block d-lg-block d-xl-block m--margin-right-5">
                                                        <span>
                                                            <i class="flaticon-circle"></i>
                                                            <span>حذف</span>
                                                        </span>
                                                    </button>
                                                </div>
                                                <div class="m-widget5__pic">
                                                    <img class="m-widget7__img" src="{{ $orderProductItem->product->photo }}" alt="">
                                                </div>
                                                <div class="m-widget5__section">
                                                    <div class=" d-none d-md-block d-lg-block d-xl-block">
                                                        <h4 class="m-widget5__title">
                                                            {{ $orderProductItem->product->name }}
                                                        </h4>
                                                        <span class="m-widget5__desc">
                                                            @foreach($orderProductItem->product->attributes as $attributeGroupKey=>$attributeGroup)
                                                                @foreach($attributeGroup as $attributeItem)
                                                                    @if(($attributeGroupKey=='main' || $attributeGroupKey=='information') && $attributeItem->control=='simple')
                                                                        {{ $attributeItem->title }} : {{ $attributeItem->data[0]->name }}
                                                                        <br>
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="d-sm-none d-md-none d-lg-none m--margin-top-10">
                                                    <h4 class="m-widget5__title">
                                                        {{ $orderProductItem->product->name }}
                                                    </h4>
                                                    <span class="m-widget5__desc">
                                                            @foreach($orderProductItem->product->attributes as $attributeGroupKey=>$attributeGroup)
                                                            @foreach($attributeGroup as $attributeItem)
                                                                @if(($attributeGroupKey=='main' || $attributeGroupKey=='information') && $attributeItem->control=='simple')
                                                                    {{ $attributeItem->title }} : {{ $attributeItem->data[0]->name }}
                                                                    <br>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="m-widget5__content">
                                                <div class="m-widget5__stats1">
                                                    <span class = "m-nav__link-badge">
                                                        <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                                            <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                                            {{ number_format($orderProductItem->cost) }} تومان
                                                            <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="m-widget5__stats2">
                                                    <a href="#" class="btn btn-default m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill">
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
                                            شما {{ count($invoiceInfo['purchasedOrderproducts']) }} کالا انتخاب کرده اید
                                        </span>
                                    </div>
                                    <div class="col m--align-right">
                                    <span class="m-widget1__number m--font-danger">
                                        {{ number_format($invoiceInfo['totalCost']) }} تومان
                                    </span>
                                    </div>
                                </div>
                            </div>
                            @if($invoiceInfo['totalCost']>$invoiceInfo['payableCost'])
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <h3 class="m-widget1__title">
                                                سود شما از خرید :
                                            </h3>
                                            <span class="m-widget1__desc">
                                            شما در مجموع {{ ($invoiceInfo['payableCost']/$invoiceInfo['totalCost'])*100 }}% تخفیف گرفته اید
                                        </span>
                                        </div>
                                        <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-success">
                                            {{ number_format($invoiceInfo['totalCost']-$invoiceInfo['payableCost']) }} تومان
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
                                    <span class="m-widget1__number m--font-brand">
                                         {{ number_format($invoiceInfo['payableCost']) }} تومان
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-lg m-btn--square m-btn m-btn--gradient-from-success m-btn--gradient-to-accent btnGotoCheckoutPayment-desktop btnGotoCheckoutPayment">
                            ادامه و ثبت سفارش
                        </button>
                    </div>
                </div>
                <!--end:: Widgets/Authors Profit-->
            </div>
        </div>
    @endif

    <div class="m-portlet btnGotoCheckoutPayment_mobile">
        <div class="m-portlet__body">
            <div class="row">
                <div class="col-6">
                    <button type="button" class="btn btn-lg m-btn--square m-btn m-btn--gradient-from-success m-btn--gradient-to-accent btnGotoCheckoutPayment">
                        ثبت سفارش
                    </button>
                </div>
                <div class="col-6">
                    <div class="priceReport">
                        <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                            <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                            15,000 تومان
                            <span class="m-badge m-badge--info a--productDiscount">20%</span>
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
                topSpacing: 70,
                zIndex: 99
            });
            // $('.btnGotoCheckoutPayment').sticky({
            //     topSpacing: 70,
            //     zIndex: 99,
            //     getWidthFrom: '.CheckoutReviewTotalPriceWarper'
            // });
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
        {{--$(document).on("click", ".removeOrderproduct", function () {--}}
            {{--$.ajax({--}}
                {{--type: "DELETE",--}}
                {{--url: $(this).data("action"),--}}
                {{--data: {_token: "{{ csrf_token() }}" },--}}
                {{--statusCode: {--}}
                    {{--//The status for when action was successful--}}
                    {{--200: function (response) {--}}
                        {{--// console.log(response);--}}
                        {{--location.reload();--}}
                    {{--},--}}
                    {{--//The status for when the user is not authorized for making the request--}}
                    {{--403: function (response) {--}}
                        {{--window.location.replace("/403");--}}
                    {{--},--}}
                    {{--//The status for when the user is not authorized for making the request--}}
                    {{--401: function (response) {--}}
                        {{--window.location.replace("/403");--}}
                    {{--},--}}
                    {{--//Method Not Allowed--}}
                    {{--405: function (response) {--}}
{{--//                        console.log(response);--}}
{{--//                        console.log(response.responseText);--}}
                        {{--location.reload();--}}
                    {{--},--}}
                    {{--404: function (response) {--}}
                        {{--window.location.replace("/404");--}}
                    {{--},--}}
                    {{--//The status for when form data is not valid--}}
                    {{--422: function (response) {--}}
                        {{--// console.log(response);--}}
                    {{--},--}}
                    {{--//The status for when there is error php code--}}
                    {{--500: function (response) {--}}
                        {{--// console.log(response.responseText);--}}
{{--//                            toastr["error"]("خطای برنامه!", "پیام سیستم");--}}
                    {{--},--}}
                    {{--//The status for when there is error php code--}}
                    {{--503: function (response) {--}}
                        {{--toastr["error"]("خطای پایگاه داده!", "پیام سیستم");--}}
                    {{--}--}}
                {{--}--}}
            {{--});--}}
        {{--});--}}
    </script>
@endsection