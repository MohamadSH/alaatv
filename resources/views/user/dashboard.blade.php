@extends('app' , ["pageName"=>$pageName])

@section('page-css')
    <link href="{{ mix('/css/user-dashboard.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/acm/AlaatvCustomFiles/css/page-user-dashboard.css') }}" rel="stylesheet" type="text/css"/>
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
                        <a href="#" class="m-portlet__nav-link btn btn--sm m-btn--pill btn-secondary m-btn d-none d-md-block d-lg-block d-sm-block btn-viewGrid" data-item-id="owlCarouselMyProduct">
                            نمایش همه
                        </a>
                        <a href="#" class="m-portlet__nav-link btn btn--sm m-btn--pill btn-secondary m-btn a--d-none btn-viewOwlCarousel" data-item-id="owlCarouselMyProduct">
                            نمایش مختصر
                        </a>
                    </div>
                </div>
                <div class="m-portlet__body m-portlet__body--no-padding">
                    <!--begin::Widget 30-->
                    <div class="m-widget30" id="owlCarouselMyProduct">

                        <div class="m-widget_head">

                            <div class="m-widget_head-owlcarousel-items owl-carousel a--owl-carousel-type-2 myProduct">
                                <div class="m-widget_head-owlcarousel-item carousel background-gradient" data-position="0">
                                    <img class="a--owl-carousel-type-2-item-image" src="/assets/app/media/img/products/product7.jpg">
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
                                    <img class="a--owl-carousel-type-2-item-image" src="/assets/app/media/img/products/product1.jpg">
                                    فیزیک
                                    <hr>

                                    <a class="btn btn-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill a--owl-carousel-type-2-show-detailes">
                                        <i class="flaticon-more-v6"></i>
                                    </a>

                                </div>
                                <div class="m-widget_head-owlcarousel-item carousel background-gradient" data-position="2">
                                    <img class="a--owl-carousel-type-2-item-image" src="/assets/app/media/img/products/product2.jpg">
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
                                    <img class="a--owl-carousel-type-2-item-image" src="/assets/app/media/img/products/product3.jpg">
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
                                    <img class="a--owl-carousel-type-2-item-image" src="/assets/app/media/img/products/product4.jpg">
                                    حسابان
                                    <hr>
                                    <a class="btn btn-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill a--owl-carousel-type-2-show-detailes">
                                        <i class="flaticon-more-v6"></i>
                                    </a>
                                </div>
                                <div class="m-widget_head-owlcarousel-item carousel background-gradient" data-position="5">
                                    <img class="a--owl-carousel-type-2-item-image" src="/assets/app/media/img/products/product5.jpg">
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
                                    <img class="a--owl-carousel-type-2-item-image" src="/assets/app/media/img/products/product6.jpg">
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

                        </div>
                        <div class="m-portlet a--owl-carousel-type-2-slide-detailes">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                            مجموعه های محصول خریداری شده
                                        </h3>
                                    </div>
                                </div>
                                <div class="m-portlet__head-tools">
                                    <a class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air a--owl-carousel-type-2-hide-detailes">
                                        <i class="la la-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="m-portlet__body subCategoryWarper a--owl-carousel-type-2-slide-iteDetail-1">
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
                            <div class="m-portlet__body subCategoryWarper a--owl-carousel-type-2-slide-iteDetail-4">
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
                        <a href="#" class="m-portlet__nav-link btn btn--sm m-btn--pill btn-secondary m-btn d-none d-md-block d-lg-block d-sm-block btn-viewGrid" data-item-id="owlCarouselMyFavoritSet">
                            نمایش همه
                        </a>
                        <a href="#" class="m-portlet__nav-link btn btn--sm m-btn--pill btn-secondary m-btn a--d-none btn-viewOwlCarousel" data-item-id="owlCarouselMyFavoritSet">
                            نمایش مختصر
                        </a>
                    </div>
                </div>
                <div class="m-portlet__body m-portlet__body--no-padding">
                    <!--begin::Widget 30-->
                    <div class="m-widget30" id="owlCarouselMyFavoritSet">

                        <div class="m-widget_head">

                            <div class="m-widget_head-owlcarousel-items owl-carousel a--owl-carousel-type-2 myProduct">

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

                        <div class="m-portlet a--owl-carousel-type-2-slide-detailes">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                            مجموعه های محصول خریداری شده
                                        </h3>
                                    </div>
                                </div>
                                <div class="m-portlet__head-tools">
                                    <a class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air a--owl-carousel-type-2-hide-detailes">
                                        <i class="la la-times"></i>
                                    </a>
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
                            <div class="m-widget_head-owlcarousel-items owl-carousel a--owl-carousel-type-2 myFavoriteContent">
                                <div data-position="0" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owl-carousel-type-2-item-image" src="/assets/app/media/img/products/product11.jpg">
                                    فیزیک
                                </div>
                                <div data-position="1" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owl-carousel-type-2-item-image" src="/assets/app/media/img/products/product10.jpg">
                                    فیزیک
                                </div>
                                <div data-position="2" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owl-carousel-type-2-item-image" src="/assets/app/media/img/products/product9.jpg">
                                    فیزیک
                                </div>
                                <div data-position="3" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owl-carousel-type-2-item-image" src="/assets/app/media/img/products/product8.jpg">
                                    فیزیک
                                </div>
                                <div data-position="4" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owl-carousel-type-2-item-image" src="/assets/app/media/img/products/product7.jpg">
                                    فیزیک
                                </div>
                                <div data-position="5" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owl-carousel-type-2-item-image" src="/assets/app/media/img/products/product6.jpg">
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
                            <div class="m-widget_head-owlcarousel-items owl-carousel a--owl-carousel-type-2 myFavoriteProducts">
                                <div data-position="0" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owl-carousel-type-2-item-image" src="/assets/app/media/img/products/product11.jpg">
                                    فیزیک
                                </div>
                                <div data-position="1" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owl-carousel-type-2-item-image" src="/assets/app/media/img/products/product10.jpg">
                                    فیزیک
                                </div>
                                <div data-position="2" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owl-carousel-type-2-item-image" src="/assets/app/media/img/products/product9.jpg">
                                    فیزیک
                                </div>
                                <div data-position="3" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owl-carousel-type-2-item-image" src="/assets/app/media/img/products/product8.jpg">
                                    فیزیک
                                </div>
                                <div data-position="4" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owl-carousel-type-2-item-image" src="/assets/app/media/img/products/product7.jpg">
                                    فیزیک
                                </div>
                                <div data-position="5" class="m-widget_head-owlcarousel-item carousel">
                                    <img class="a--owl-carousel-type-2-item-image" src="/assets/app/media/img/products/product6.jpg">
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
    <script src="{{ asset('/acm/AlaatvCustomFiles/js/page-user-dashboard.js') }}"></script>

@endsection