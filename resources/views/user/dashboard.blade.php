@extends('app' , ["pageName"=>$pageName])

@section('page-css')
    <link href="{{ mix('/css/user-dashboard.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .a--owlCarousel .carousel {
            transition-property: transform;
            transition-duration: 0.7s;
        }

        .btn-viewOwlcarousel {
            display: none;
        }

        .a--owlCarousel .owl-item.active.center .carousel {
            -moz-transform: scale(1.2);
            -webkit-transform: scale(1.2);
            -o-transform: scale(1.2);
            -ms-transform: scale(1.2);
            transform: scale(1.2);
        }

        .a--owlCarousel .owl-item.active.center .background-solid.carousel {
            background-color: #3c00b14d !important;
        }

        .a--owlCarousel .owl-item.active.center .background-gradient.carousel {
            background: rgb(255, 184, 34) !important;
            background: linear-gradient(90deg, rgba(255, 184, 34, 1) 0%, rgba(52, 191, 163, 1) 100%) !important;
        }

        .a--owlCarousel .carousel .a--owlCarousel-item-image {
            position: relative;
            bottom: 20px;
            width: 90%;
            margin: auto;
            border-radius: 4px;
            -webkit-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
            -moz-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
        }
        .a--owlCarousel .carousel {
            -webkit-box-shadow: 0 1px 15px 1px rgba(55, 41, 84, 0.3) !important;
            box-shadow: 0 1px 15px 1px rgba(55, 41, 84, 0.3) !important;
            margin-top: 45px !important;
            margin-bottom: 30px !important;
        }

        .a--owlCarousel .owl-prev {
            right: 0;
            background: linear-gradient(270deg, rgba(47, 47, 47, 0.6) 0%, rgba(100, 94, 111, 0.5) 40%, rgba(216, 195, 255, 0) 100%) !important;
        }

        .a--owlCarousel .owl-next {
            left: 0;
            background: linear-gradient(90deg, rgba(47, 47, 47, 0.6) 0%, rgba(100, 94, 111, 0.5) 40%, rgba(216, 195, 255, 0) 100%) !important;
        }

        .a--owlCarousel .owl-prev, .a--owlCarousel .owl-next {
            position: absolute;
            top: 0;
            height: 100%;
            width: 40px;
            color: white !important;
            transition-property: width;
            transition-duration: 0.5s;
            /*background: rgb(47,47,47) !important;*/
        }
        .a--owlCarousel .owl-prev:hover,
        .a--owlCarousel .owl-next:hover {
            width: 70px;
        }

        .a--owlCarousel-slide-detailes {
            position: relative;
            -webkit-box-shadow: 0px -15px 60px -17px rgba(0,0,0,0.75);
            -moz-box-shadow: 0px -15px 60px -17px rgba(0,0,0,0.75);
            box-shadow: 0px -15px 60px -17px rgba(0,0,0,0.75);
        }
        .a--owlCarousel-slide-detailes::before {
            content: ' ';
            width: 0;
            height: 0;
            border-left: 21px solid transparent;
            border-right: 20px solid transparent;
            border-bottom: 20px solid white;
            position: absolute;
            top: -20px;
            right: calc(50% - 20px);
        }







        .subCategoryWarper .subCategoryItem {
            background: rgb(255, 184, 34) !important;
            background: linear-gradient(90deg, rgba(255, 184, 34, 1) 0%, rgba(52, 191, 163, 1) 100%) !important;
            text-align: center;
            margin: 5px 0;
            padding: 10px;
            border-radius: 4px;
            border: dotted 5px white;
        }

        .m-widget30, .gridView-myProduct {
            position: relative;
        }
    </style>
@endsection

@section('right-aside')
@endsection
@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="flaticon-home-2"></i>
                <a href="{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item">
                <i class="flaticon-user"></i>
                <a href="{{ action("Web\UserController@show",[$user]) }}">@lang('page.Profile')</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                داشبورد
            </li>
        </ol>
    </nav>
@endsection

@section('content')

    @include('systemMessage.flash')

    {{--{{ $user }}--}}


    {{--{{ $userAssetsCollection }}--}}
    {{--{{ dd($userAssetsCollection[0]->products[0]->name) }}--}}



    <div class="row">
        <div class="col">
            <div class="m-portlet  m-portlet--bordered">
                <div class="m-portlet__head m--padding-top-20">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                محصولات من
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="#" class="m-portlet__nav-link btn btn--sm m-btn--pill btn-secondary m-btn d-none d-md-block d-lg-block d-sm-block btn-viewAll" data-itemclass="myProduct">
                            نمایش همه
                        </a>
                        <a href="#" class="m-portlet__nav-link btn btn--sm m-btn--pill btn-secondary m-btn btn-viewOwlcarousel" data-itemclass="myProduct">
                            نمایش مختصر
                        </a>
                    </div>
                </div>
                <div class="m-portlet__body m-portlet__body--no-padding">
                    <!--begin::Widget 30-->
                    <div class="m-widget30">

                        <div class="m-widget_head">
                            <div class="m-widget_head-owlcarousel-items owl-carousel a--owlCarousel myProduct">
                                <div class="m-widget_head-owlcarousel-item carousel background-gradient" data-position="0">
                                    <img class="a--owlCarousel-item-image" src="/assets/app/media/img/products/product7.jpg">
                                    حسابان
                                    <hr>
                                    <div class="m-btn-group m-btn-group--pill btn-group m-btn-group m-btn-group--pill btn-group-sm"
                                         role="group" aria-label="Small button group">
                                        <button type="button" class="btn btn-warning">
                                            <i class="flaticon-edit-1"></i>
                                            جزوات
                                        </button>
                                        <button type="button" class="btn btn-success">
                                            <i class="la la-film"></i>
                                            فیلم ها
                                        </button>
                                    </div>
                                </div>
                                <div class="m-widget_head-owlcarousel-item carousel" data-position="1">
                                    <img class="a--owlCarousel-item-image" src="/assets/app/media/img/products/product1.jpg">
                                    فیزیک
                                    <hr>

                                    <a class="btn btn-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill a--owlCarousel-show-detailes">
                                        <i class="flaticon-more-v6"></i>
                                    </a>

                                </div>
                                <div class="m-widget_head-owlcarousel-item carousel background-gradient" data-position="2">
                                    <img class="a--owlCarousel-item-image" src="/assets/app/media/img/products/product2.jpg">
                                    شیمی
                                    <hr>
                                    <div class="m-btn-group m-btn-group--pill btn-group m-btn-group m-btn-group--pill btn-group-sm"
                                         role="group" aria-label="Small button group">
                                        <button type="button" class="btn btn-warning">
                                            <i class="flaticon-edit-1"></i>
                                            جزوات
                                        </button>
                                        <button type="button" class="btn btn-success">
                                            <i class="la la-film"></i>
                                            فیلم ها
                                        </button>
                                    </div>
                                </div>
                                <div class="m-widget_head-owlcarousel-item carousel background-gradient" data-position="3">
                                    <img class="a--owlCarousel-item-image" src="/assets/app/media/img/products/product3.jpg">
                                    زیست
                                    <hr>
                                    <div class="m-btn-group m-btn-group--pill btn-group m-btn-group m-btn-group--pill btn-group-sm"
                                         role="group" aria-label="Small button group">
                                        <button type="button" class="btn btn-warning">
                                            <i class="flaticon-edit-1"></i>
                                            جزوات
                                        </button>
                                        <button type="button" class="btn btn-success">
                                            <i class="la la-film"></i>
                                            فیلم ها
                                        </button>
                                    </div>
                                </div>
                                <div class="m-widget_head-owlcarousel-item carousel" data-position="4">
                                    <img class="a--owlCarousel-item-image" src="/assets/app/media/img/products/product4.jpg">
                                    حسابان
                                    <hr>
                                    <a class="btn btn-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill a--owlCarousel-show-detailes">
                                        <i class="flaticon-more-v6"></i>
                                    </a>
                                </div>
                                <div class="m-widget_head-owlcarousel-item carousel background-gradient" data-position="5">
                                    <img class="a--owlCarousel-item-image" src="/assets/app/media/img/products/product5.jpg">
                                    هندسه
                                    <hr>
                                    <div class="m-btn-group m-btn-group--pill btn-group m-btn-group m-btn-group--pill btn-group-sm"
                                         role="group" aria-label="Small button group">
                                        <button type="button" class="btn btn-warning">
                                            <i class="flaticon-edit-1"></i>
                                            جزوات
                                        </button>
                                        <button type="button" class="btn btn-success">
                                            <i class="la la-film"></i>
                                            فیلم ها
                                        </button>
                                    </div>
                                </div>
                                <div class="m-widget_head-owlcarousel-item carousel background-gradient" data-position="6">
                                    <img class="a--owlCarousel-item-image" src="/assets/app/media/img/products/product6.jpg">
                                    حسابان
                                    <hr>
                                    <div class="m-btn-group m-btn-group--pill btn-group m-btn-group m-btn-group--pill btn-group-sm"
                                         role="group" aria-label="Small button group">
                                        <button type="button" class="btn btn-warning">
                                            <i class="flaticon-edit-1"></i>
                                            جزوات
                                        </button>
                                        <button type="button" class="btn btn-success">
                                            <i class="la la-film"></i>
                                            فیلم ها
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="m-widget_head-owlcarousel-items owl-carousel a--owlCarousel row gridView-myProduct">
                            </div>
                        </div>
                        <div class="m-portlet a--owlCarousel-slide-detailes">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                            مجموعه های محصول خریداری شده
                                        </h3>
                                    </div>



                                </div>
                                <div class="m-portlet__head-tools">
                                    <a class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air a--owlCarousel-hide-detailes">
                                        <i class="la la-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="m-portlet__body subCategoryWarper a--owlCarousel-slide-iteDetail-1">
                                <div class="row justify-content-center">
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="subCategoryItem">
                                            شیمی
                                            <hr>
                                            <div class="m-btn-group m-btn-group--pill btn-group m-btn-group m-btn-group--pill btn-group-sm"
                                                 role="group" aria-label="Small button group">
                                                <button type="button" class="btn btn-warning">
                                                    <i class="flaticon-edit-1"></i>
                                                    جزوات
                                                </button>
                                                <button type="button" class="btn btn-success">
                                                    <i class="la la-film"></i>
                                                    فیلم ها
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="subCategoryItem">
                                            شیمی
                                            <hr>
                                            <div class="m-btn-group m-btn-group--pill btn-group m-btn-group m-btn-group--pill btn-group-sm"
                                                 role="group" aria-label="Small button group">
                                                <button type="button" class="btn btn-warning">
                                                    <i class="flaticon-edit-1"></i>
                                                    جزوات
                                                </button>
                                                <button type="button" class="btn btn-success">
                                                    <i class="la la-film"></i>
                                                    فیلم ها
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="subCategoryItem">
                                            شیمی
                                            <hr>
                                            <div class="m-btn-group m-btn-group--pill btn-group m-btn-group m-btn-group--pill btn-group-sm"
                                                 role="group" aria-label="Small button group">
                                                <button type="button" class="btn btn-warning">
                                                    <i class="flaticon-edit-1"></i>
                                                    جزوات
                                                </button>
                                                <button type="button" class="btn btn-success">
                                                    <i class="la la-film"></i>
                                                    فیلم ها
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="subCategoryItem">
                                            شیمی
                                            <hr>
                                            <div class="m-btn-group m-btn-group--pill btn-group m-btn-group m-btn-group--pill btn-group-sm"
                                                 role="group" aria-label="Small button group">
                                                <button type="button" class="btn btn-warning">
                                                    <i class="flaticon-edit-1"></i>
                                                    جزوات
                                                </button>
                                                <button type="button" class="btn btn-success">
                                                    <i class="la la-film"></i>
                                                    فیلم ها
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="subCategoryItem">
                                            شیمی
                                            <hr>
                                            <div class="m-btn-group m-btn-group--pill btn-group m-btn-group m-btn-group--pill btn-group-sm"
                                                 role="group" aria-label="Small button group">
                                                <button type="button" class="btn btn-warning">
                                                    <i class="flaticon-edit-1"></i>
                                                    جزوات
                                                </button>
                                                <button type="button" class="btn btn-success">
                                                    <i class="la la-film"></i>
                                                    فیلم ها
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__body subCategoryWarper a--owlCarousel-slide-iteDetail-4">
                                <div class="row justify-content-center">
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="subCategoryItem">
                                            هندسه
                                            <hr>
                                            <div class="m-btn-group m-btn-group--pill btn-group m-btn-group m-btn-group--pill btn-group-sm"
                                                 role="group" aria-label="Small button group">
                                                <button type="button" class="btn btn-warning">
                                                    <i class="flaticon-edit-1"></i>
                                                    جزوات
                                                </button>
                                                <button type="button" class="btn btn-success">
                                                    <i class="la la-film"></i>
                                                    فیلم ها
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="subCategoryItem">
                                            هندسه
                                            <hr>
                                            <div class="m-btn-group m-btn-group--pill btn-group m-btn-group m-btn-group--pill btn-group-sm"
                                                 role="group" aria-label="Small button group">
                                                <button type="button" class="btn btn-warning">
                                                    <i class="flaticon-edit-1"></i>
                                                    جزوات
                                                </button>
                                                <button type="button" class="btn btn-success">
                                                    <i class="la la-film"></i>
                                                    فیلم ها
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="subCategoryItem">
                                            هندسه
                                            <hr>
                                            <div class="m-btn-group m-btn-group--pill btn-group m-btn-group m-btn-group--pill btn-group-sm"
                                                 role="group" aria-label="Small button group">
                                                <button type="button" class="btn btn-warning">
                                                    <i class="flaticon-edit-1"></i>
                                                    جزوات
                                                </button>
                                                <button type="button" class="btn btn-success">
                                                    <i class="la la-film"></i>
                                                    فیلم ها
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--end::Widget 30-->
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col">
            <div class="m-portlet  m-portlet--bordered">
                <div class="m-portlet__head m--padding-top-20">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                دسته های مورد علاقه من
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                m-dropdown-toggle="hover">
                                <a href="#"
                                   class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-secondary m-btn  ">
                                    All
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav">
                                                    <li class="m-nav__section m-nav__section--first">
                                                        <span class="m-nav__section-text">Quick Actions</span>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-share"></i>
                                                            <span class="m-nav__link-text">Activity</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                            <span class="m-nav__link-text">Messages</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-info"></i>
                                                            <span class="m-nav__link-text">FAQ</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                            <span class="m-nav__link-text">Support</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__separator m-nav__separator--fit">
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="#"
                                                           class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">Cancel</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body m-portlet__body--no-padding">
                    <!--begin::Widget 30-->
                    <div class="m-widget30">

                        <div class="m-widget_head">
                            <div class="m-widget_head-owlcarousel-items owl-carousel a--owlCarousel myFavoritSet">
                                <div data-position="0" class="m-widget_head-owlcarousel-item carousel">
                                    فیزیک
                                </div>
                                <div data-position="1" class="m-widget_head-owlcarousel-item carousel">
                                    فیزیک
                                </div>
                                <div data-position="2" class="m-widget_head-owlcarousel-item carousel">
                                    فیزیک
                                </div>
                                <div data-position="3" class="m-widget_head-owlcarousel-item carousel">
                                    فیزیک
                                </div>
                                <div data-position="4" class="m-widget_head-owlcarousel-item carousel">
                                    فیزیک
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--end::Widget 30-->
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="m-portlet  m-portlet--bordered">
                <div class="m-portlet__head m--padding-top-20">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                محتوای مورد علاقه من
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                m-dropdown-toggle="hover">
                                <a href="#"
                                   class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-secondary m-btn  ">
                                    All
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav">
                                                    <li class="m-nav__section m-nav__section--first">
                                                        <span class="m-nav__section-text">Quick Actions</span>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-share"></i>
                                                            <span class="m-nav__link-text">Activity</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                            <span class="m-nav__link-text">Messages</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-info"></i>
                                                            <span class="m-nav__link-text">FAQ</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                            <span class="m-nav__link-text">Support</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__separator m-nav__separator--fit">
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="#"
                                                           class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">Cancel</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body m-portlet__body--no-padding">
                    <!--begin::Widget 30-->
                    <div class="m-widget30">

                        <div class="m-widget_head">
                            <div class="m-widget_head-owlcarousel-items owl-carousel a--owlCarousel myFavoriteContent">
                                <div data-position="0" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owlCarousel-item-image" src="/assets/app/media/img/products/product11.jpg">
                                    فیزیک
                                </div>
                                <div data-position="1" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owlCarousel-item-image" src="/assets/app/media/img/products/product10.jpg">
                                    فیزیک
                                </div>
                                <div data-position="2" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owlCarousel-item-image" src="/assets/app/media/img/products/product9.jpg">
                                    فیزیک
                                </div>
                                <div data-position="3" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owlCarousel-item-image" src="/assets/app/media/img/products/product8.jpg">
                                    فیزیک
                                </div>
                                <div data-position="4" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owlCarousel-item-image" src="/assets/app/media/img/products/product7.jpg">
                                    فیزیک
                                </div>
                                <div data-position="5" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owlCarousel-item-image" src="/assets/app/media/img/products/product6.jpg">
                                    فیزیک
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--end::Widget 30-->
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="m-portlet  m-portlet--bordered">
                <div class="m-portlet__head m--padding-top-20">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                محصولات مورد علاقه من
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                m-dropdown-toggle="hover">
                                <a href="#"
                                   class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-secondary m-btn  ">
                                    All
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav">
                                                    <li class="m-nav__section m-nav__section--first">
                                                        <span class="m-nav__section-text">Quick Actions</span>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-share"></i>
                                                            <span class="m-nav__link-text">Activity</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                            <span class="m-nav__link-text">Messages</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-info"></i>
                                                            <span class="m-nav__link-text">FAQ</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                            <span class="m-nav__link-text">Support</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__separator m-nav__separator--fit">
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="#"
                                                           class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">Cancel</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body m-portlet__body--no-padding">
                    <!--begin::Widget 30-->
                    <div class="m-widget30">

                        <div class="m-widget_head">
                            <div class="m-widget_head-owlcarousel-items owl-carousel a--owlCarousel myFavoriteProducts">
                                <div data-position="0" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owlCarousel-item-image" src="/assets/app/media/img/products/product11.jpg">
                                    فیزیک
                                </div>
                                <div data-position="1" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owlCarousel-item-image" src="/assets/app/media/img/products/product10.jpg">
                                    فیزیک
                                </div>
                                <div data-position="2" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owlCarousel-item-image" src="/assets/app/media/img/products/product9.jpg">
                                    فیزیک
                                </div>
                                <div data-position="3" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owlCarousel-item-image" src="/assets/app/media/img/products/product8.jpg">
                                    فیزیک
                                </div>
                                <div data-position="4" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owlCarousel-item-image" src="/assets/app/media/img/products/product7.jpg">
                                    فیزیک
                                </div>
                                <div data-position="5" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owlCarousel-item-image" src="/assets/app/media/img/products/product6.jpg">
                                    فیزیک
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--end::Widget 30-->
                </div>
            </div>
        </div>
    </div>




    <!--begin::Modal-->
    <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <i class="flaticon-edit-1"></i>
                        جزوات
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col">
                            <div class="m-widget6">
                                <div class="m-widget6__head">
                                    <div class="m-widget6__item">
                                        <span class="m-widget6__caption">
                                            عنوان
                                        </span>
                                        <span class="m-widget6__caption">
                                            دانلود/مشاهده
                                        </span>
                                    </div>
                                </div>
                                <div class="m-widget6__body">
                                    <div class="m-widget6__item">
                                        <span class="m-widget6__text">
                                         جزوه یک
                                        </span>
                                        <span class="m-widget6__text">
                                            <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
                                                <button type="button" class="m-btn btn btn-success">
                                                    <i class="la la-download"></i>
                                                </button>
                                                <button type="button" class="m-btn btn btn-info">
                                                    <i class="la la-eye"></i>
                                                </button>
                                            </div>
                                        </span>
                                    </div>
                                    <div class="m-widget6__item">
                                        <span class="m-widget6__text">
                                         جزوه یک
                                        </span>
                                        <span class="m-widget6__text">
                                            <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
                                                <button type="button" class="m-btn btn btn-success">
                                                    <i class="la la-download"></i>
                                                </button>
                                                <button type="button" class="m-btn btn btn-info">
                                                    <i class="la la-eye"></i>
                                                </button>
                                            </div>
                                        </span>
                                    </div>
                                    <div class="m-widget6__item">
                                        <span class="m-widget6__text">
                                         جزوه یک
                                        </span>
                                        <span class="m-widget6__text">
                                            <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
                                                <button type="button" class="m-btn btn btn-success">
                                                    <i class="la la-download"></i>
                                                </button>
                                                <button type="button" class="m-btn btn btn-info">
                                                    <i class="la la-eye"></i>
                                                </button>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="m_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <i class="la la-film"></i>
                        فیلم ها
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col">
                            <div class="m-widget6">
                                <div class="m-widget6__head">
                                    <div class="m-widget6__item">
                                        <span class="m-widget6__caption">
                                            عنوان
                                        </span>
                                        <span class="m-widget6__caption">
                                            دانلود/مشاهده
                                        </span>
                                    </div>
                                </div>
                                <div class="m-widget6__body">
                                    <div class="m-widget6__item">
                                        <span class="m-widget6__text">
                                         فیلم یک
                                        </span>
                                        <span class="m-widget6__text">
                                            <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
                                                <button type="button" class="m-btn btn btn-success">
                                                    <i class="la la-download"></i>
                                                </button>
                                                <button type="button" class="m-btn btn btn-info">
                                                    <i class="la la-eye"></i>
                                                </button>
                                            </div>
                                        </span>
                                    </div>
                                    <div class="m-widget6__item">
                                        <span class="m-widget6__text">
                                         فیلم یک
                                        </span>
                                        <span class="m-widget6__text">
                                            <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
                                                <button type="button" class="m-btn btn btn-success">
                                                    <i class="la la-download"></i>
                                                </button>
                                                <button type="button" class="m-btn btn btn-info">
                                                    <i class="la la-eye"></i>
                                                </button>
                                            </div>
                                        </span>
                                    </div>
                                    <div class="m-widget6__item">
                                        <span class="m-widget6__text">
                                         فیلم یک
                                        </span>
                                        <span class="m-widget6__text">
                                            <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
                                                <button type="button" class="m-btn btn btn-success">
                                                    <i class="la la-download"></i>
                                                </button>
                                                <button type="button" class="m-btn btn btn-info">
                                                    <i class="la la-eye"></i>
                                                </button>
                                            </div>
                                        </span>
                                    </div>
                                    <div class="m-widget6__item">
                                        <span class="m-widget6__text">
                                         فیلم یک
                                        </span>
                                        <span class="m-widget6__text">
                                            <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
                                                <button type="button" class="m-btn btn btn-success">
                                                    <i class="la la-download"></i>
                                                </button>
                                                <button type="button" class="m-btn btn btn-info">
                                                    <i class="la la-eye"></i>
                                                </button>
                                            </div>
                                        </span>
                                    </div>
                                    <div class="m-widget6__item">
                                        <span class="m-widget6__text">
                                         فیلم یک
                                        </span>
                                        <span class="m-widget6__text">
                                            <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
                                                <button type="button" class="m-btn btn btn-success">
                                                    <i class="la la-download"></i>
                                                </button>
                                                <button type="button" class="m-btn btn btn-info">
                                                    <i class="la la-eye"></i>
                                                </button>
                                            </div>
                                        </span>
                                    </div>
                                    <div class="m-widget6__item">
                                        <span class="m-widget6__text">
                                         فیلم یک
                                        </span>
                                        <span class="m-widget6__text">
                                            <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
                                                <button type="button" class="m-btn btn btn-success">
                                                    <i class="la la-download"></i>
                                                </button>
                                                <button type="button" class="m-btn btn btn-info">
                                                    <i class="la la-eye"></i>
                                                </button>
                                            </div>
                                        </span>
                                    </div>
                                    <div class="m-widget6__item">
                                        <span class="m-widget6__text">
                                         فیلم یک
                                        </span>
                                        <span class="m-widget6__text">
                                            <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
                                                <button type="button" class="m-btn btn btn-success">
                                                    <i class="la la-download"></i>
                                                </button>
                                                <button type="button" class="m-btn btn btn-info">
                                                    <i class="la la-eye"></i>
                                                </button>
                                            </div>
                                        </span>
                                    </div>
                                    <div class="m-widget6__item">
                                        <span class="m-widget6__text">
                                         فیلم یک
                                        </span>
                                        <span class="m-widget6__text">
                                            <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
                                                <button type="button" class="m-btn btn btn-success">
                                                    <i class="la la-download"></i>
                                                </button>
                                                <button type="button" class="m-btn btn btn-info">
                                                    <i class="la la-eye"></i>
                                                </button>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->

@endsection

@section('page-js')

    <script src="{{ mix('/js/user-dashboard.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {

            var myProductAlaaOwlCarouselOptions = {
                center: true,
                rtl: true,
                loop: true,
                nav: true,
                margin: 10,
                responsive:{
                    0:{
                        items:1
                    },
                    400:{
                        items:2
                    },
                    600:{
                        items:3
                    },
                    800:{
                        items:4
                    },
                    1000:{
                        items:5
                    }
                },
                // onDragged: callback,
                onTranslated : callback
            };
            let myProductAlaaOwlCarousel = $('.a--owlCarousel.myProduct');
            let myFavoritSetAlaaOwlCarousel = $('.a--owlCarousel.myFavoritSet');
            let myFavoritContentAlaaOwlCarousel = $('.a--owlCarousel.myFavoriteContent');
            let myProductsContentAlaaOwlCarousel = $('.a--owlCarousel.myFavoriteProducts');

            // a--owlCarousel.owlCarousel('destroy');
            myProductAlaaOwlCarousel.owlCarousel(myProductAlaaOwlCarouselOptions);
            myFavoritSetAlaaOwlCarousel.owlCarousel({
                center: true,
                rtl: true,
                loop: true,
                nav: true,
                margin: 10,
                responsive:{
                    0:{
                        items:1
                    },
                    400:{
                        items:2
                    },
                    600:{
                        items:3
                    },
                    800:{
                        items:4
                    },
                    1000:{
                        items:5
                    }
                }
            });
            myFavoritContentAlaaOwlCarousel.owlCarousel({
                center: true,
                rtl: true,
                loop: true,
                nav: true,
                margin: 10,
                responsive:{
                    0:{
                        items:1
                    },
                    400:{
                        items:2
                    },
                    600:{
                        items:3
                    },
                    800:{
                        items:4
                    },
                    1000:{
                        items:5
                    }
                }
            });
            myProductsContentAlaaOwlCarousel.owlCarousel({
                center: true,
                rtl: true,
                loop: true,
                nav: true,
                margin: 10,
                responsive:{
                    0:{
                        items:1
                    },
                    400:{
                        items:2
                    },
                    600:{
                        items:3
                    },
                    800:{
                        items:4
                    },
                    1000:{
                        items:5
                    }
                }
            });
            showAlaaOwlCarouselItemDetail();
            function callback(event) {
                showAlaaOwlCarouselItemDetail();
            }

            function showAlaaOwlCarouselItemDetail() {
                let alaaOwlCarouselItemDetailClass = 'a--owlCarousel-slide-iteDetail-' + $('.a--owlCarousel .owl-item.active.center .carousel').data('position');
                $('.subCategoryWarper').fadeOut();
                let aOwlCarouselSlideDetailes = $('.a--owlCarousel-slide-detailes');
                let alaaOwlCarouselItemDetailObject = $('.'+alaaOwlCarouselItemDetailClass);
                aOwlCarouselSlideDetailes.slideUp();
                if (alaaOwlCarouselItemDetailObject.length>0) {
                    aOwlCarouselSlideDetailes.fadeIn();
                    alaaOwlCarouselItemDetailObject.slideDown();
                }
            }

            $(document).on('click', '.carousel', function () {
                let position = $(this).data('position');
                let parents = $(this).parents();
                let owlCarousel = null;

                if (parents.hasClass('myProduct')) {
                    console.log('myProduct');
                    owlCarousel = myProductAlaaOwlCarousel;
                } else if (parents.hasClass('myFavoritSet')) {
                    console.log('myFavoritSet');
                    owlCarousel = myFavoritSetAlaaOwlCarousel;
                } else if (parents.hasClass('myFavoriteContent')) {
                    console.log('myFavoriteContent');
                    owlCarousel = myFavoritContentAlaaOwlCarousel;
                } else if (parents.hasClass('myFavoriteProducts')) {
                    console.log('myFavoriteContent');
                    owlCarousel = myProductsContentAlaaOwlCarousel;
                }
                if (owlCarousel!==null) {
                    owlCarousel.trigger('to.owl.carousel', position);
                }
            });
            $(document).on('click', '.btn-viewAll', function () {
                $('.gridView-myProduct').html('');

                $('.subCategoryWarper').fadeOut(0);
                $('.a--owlCarousel-slide-detailes').slideUp(0);
                $('.btn-viewAll').fadeOut(0);
                $('.btn-viewAll').css('cssText', 'display: none !important;');
                $('.btn-viewOwlcarousel').fadeIn(0);

                let itemClass = $(this).data('itemclass');
                $('.a--owlCarousel.' + itemClass).owlCarousel('destroy');
                let gridView = $('.gridView-' + itemClass);
                $('.' + itemClass + ' .carousel').each(function() {
                    gridView.append('<div class="col-12 col-sm-6 col-md-3">' + $(this)[0].outerHTML + '</div>');
                });
                $('.' + itemClass).fadeOut();
                gridView.fadeIn();
            });
            $(document).on('click', '.btn-viewOwlcarousel', function () {
                $('.gridView-myProduct').html('');

                $('.subCategoryWarper').fadeOut(0);
                $('.a--owlCarousel-slide-detailes').slideUp(0);
                $('.btn-viewAll').fadeIn(0);
                $('.btn-viewOwlcarousel').fadeOut(0);


                $('.m-portlet.a--owlCarousel-slide-detailes').css({
                    'display': 'block',
                    'position': 'relative',
                    'width': 'auto',
                    'top': '0'
                });
                $('#detailesWarperPointerStyle').html('');



                let itemClass = $(this).data('itemclass');
                $('.a--owlCarousel.' + itemClass).owlCarousel(myProductAlaaOwlCarouselOptions);
                let gridView = $('.gridView-' + itemClass);
                gridView.fadeOut(0);
                $('.' + itemClass).fadeIn();

                showAlaaOwlCarouselItemDetail();
            });
            $(document).on('click', '.a--owlCarousel-hide-detailes', function () {
                $('.a--owlCarousel-slide-detailes').slideUp();
                $('.subCategoryWarper').fadeOut();
                $('.gridView-myProduct > div').css({
                    'margin-bottom': '0px'
                });
            });
            $(document).on('click', '.gridView-myProduct .a--owlCarousel-show-detailes', function () {
                $('.gridView-myProduct > div').css({
                    'margin-bottom': '0px'
                });

                let parent = $(this).parent('.m-widget_head-owlcarousel-item.carousel');
                let position = parent.data('position');


                let alaaOwlCarouselItemDetailClass = 'a--owlCarousel-slide-iteDetail-' + position;
                $.when($('.subCategoryWarper').fadeOut(0)).done(function() {

                    let aOwlCarouselSlideDetailes = $('.a--owlCarousel-slide-detailes');
                    let alaaOwlCarouselItemDetailObject = $('.'+alaaOwlCarouselItemDetailClass);
                    $.when(aOwlCarouselSlideDetailes.slideUp(0)).done(function() {

                        if (alaaOwlCarouselItemDetailObject.length>0) {
                            aOwlCarouselSlideDetailes.fadeIn();
                            alaaOwlCarouselItemDetailObject.slideDown();
                        }


                        let detailesWarper = $('.m-portlet.a--owlCarousel-slide-detailes');
                        let target = $('.gridView-myProduct .carousel[data-position="' + position + '"]');
                        let targetCol = target.parent();
                        targetCol.css({
                            'margin-bottom': parseInt(detailesWarper.outerHeight()) + 'px'
                        });
                        // let positionTop = parseInt(target.outerHeight()) + parseInt(target.css('margin-bottom')) + parseInt(target.css('padding-bottom')) + 35;
                        let positionTop = parseInt(targetCol.outerHeight()) + parseInt(targetCol.position().top);
                        let positionLeftOfPointer = parseInt(targetCol.position().left) + (parseInt(targetCol.outerWidth()) / 2) - 5;
                        console.log(targetCol);
                        detailesWarper.css({
                            'display': 'block',
                            'position': 'absolute',
                            'width': '100%',
                            'z-index': '1',
                            'top': positionTop + 'px'
                        });
                        let detailesWarperPointerStyle = $('#detailesWarperPointerStyle');
                        if (detailesWarperPointerStyle.length===0) {
                            detailesWarper.append('<div id="detailesWarperPointerStyle"></div>');
                        }
                        $('#detailesWarperPointerStyle').html('<style>.a--owlCarousel-slide-detailes::before { right: auto; left: ' + positionLeftOfPointer + 'px; }</style>');


                    });
                });
            });
            $(document).on('click', '.btn.btn-warning', function () {
                $('#m_modal_1').modal('show');
            });
            $(document).on('click', '.btn.btn-success', function () {
                $('#m_modal_2').modal('show');
            });
        });

    </script>
@endsection