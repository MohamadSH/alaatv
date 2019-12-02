@extends('app' , ["pageName"=>$pageName])

@section('page-css')
    <link href="{{ mix('/css/user-dashboard.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/acm/AlaatvCustomFiles/components/CustomDropDown/style.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home"></i>
                <a class="m-link" href="{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item">
                <i class="fa fa-user"></i>
                <a class="m-link" href="{{ action("Web\UserController@show",[$user]) }}">@lang('page.Profile')</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                داشبورد
            </li>
        </ol>
    </nav>
@endsection

@section('content')

    @include('systemMessage.flash')


    <style>
        .btn-group-rounded button:first-child {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }
        .btn-group-rounded button:last-child {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }
    </style>
    <div class="row m--margin-bottom-10">
        <div class="col text-center">
            <div class="btn-group m-btn-group btn-group-rounded" role="group" aria-label="...">
                <button type="button" class="btn btn-secondary">علاقه مندی ها</button>
                <button type="button" class="btn btn-warning">محصولات من</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <style>
                .sortingFilter {
                    margin-bottom: 10px;
                }
                .sortingFilter .sortingFilter-item {
                    display: inline-block;
                    margin-left: 10px;
                }
            </style>
            <div class="sortingFilter">
                <div class="sortingFilter-item title">
                    <span>
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 56 56" xml:space="preserve" width="25">
                            <g>
                                <path d="M8,41.08V2c0-0.553-0.448-1-1-1S6,1.447,6,2v39.08C2.613,41.568,0,44.481,0,48c0,3.859,3.14,7,7,7s7-3.141,7-7   C14,44.481,11.387,41.568,8,41.08z M7,53c-2.757,0-5-2.243-5-5s2.243-5,5-5s5,2.243,5,5S9.757,53,7,53z"/>
                                <path d="M29,20.695V2c0-0.553-0.448-1-1-1s-1,0.447-1,1v18.632c-3.602,0.396-6.414,3.456-6.414,7.161s2.812,6.765,6.414,7.161V54   c0,0.553,0.448,1,1,1s1-0.447,1-1V34.891c3.4-0.577,6-3.536,6-7.098S32.4,21.272,29,20.695z M27.793,33   c-2.871,0-5.207-2.336-5.207-5.207s2.335-5.207,5.207-5.207S33,24.922,33,27.793S30.664,33,27.793,33z"/>
                                <path d="M56,8c0-3.859-3.14-7-7-7s-7,3.141-7,7c0,3.519,2.613,6.432,6,6.92V54c0,0.553,0.448,1,1,1s1-0.447,1-1V14.92   C53.387,14.432,56,11.519,56,8z M49,13c-2.757,0-5-2.243-5-5s2.243-5,5-5s5,2.243,5,5S51.757,13,49,13z"/>
                            </g>
                        </svg>
                    </span>
                    مرتب سازی بر اساس:
                </div>
                <div class="sortingFilter-item date">
                    @include('partials.CustomSelect', ['items'=>[
                            [
                                'name'=> 'جدید ترین ها',
                                'value'=> 'جدید ترین ها',
                                'selected'=> true
                            ],
                            [
                                'name'=> 'قدیمی ترین ها',
                                'value'=> 'قدیمی ترین ها',
                            ],
                        ]
                    ])
                </div>
                <div class="sortingFilter-item subject">
                    @include('partials.CustomSelect', ['items'=>[
                            [
                                'name'=> 'همایش طلایی',
                                'value'=> 'همایش طلایی',
                                'selected'=> true
                            ],
                            [
                                'name'=> 'همایش گدار',
                                'value'=> 'همایش گدار'
                            ],
                            [
                                'name'=> 'همایش تفتان',
                                'value'=> 'همایش تفتان'
                            ],
                            [
                                'name'=> 'همایش راه ابریشم',
                                'value'=> 'همایش راه ابریشم'
                            ],
                        ]
                    ])
                </div>
            </div>
        </div>
    </div>
    <style>
        .myProductsRow {
            margin-bottom: 100px;
        }




        .productItem {
            background: white;
            margin-top: 10px;
        }
        .productItem .productItem-image {

        }
        .productItem .productItem-description {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        .productItem .productItem-description .title {
            font-size: 2rem;
            font-weight: bold;
        }
        .productItem .productItem-description .action {
            margin-top: 30px;
        }
        .productItem .productItem-description .action .btn {
            padding: 10px 40px;
            border-radius: 5px;
        }
        .productItem .productItem-description .action .btn.btn-warning {
            margin-left: 30px;
        }
    </style>
    <div class="row myProductsRow">
        <div class="col-md-8 productsCol">
            @include('user.partials.dashboard.productItem', [
                'name'=> 'همایش گدار شیمی آلاء',
                'src'=> 'https://cdn.alaatv.com/upload/images/product/p7 (4)_20190517134806.jpg',
            ])
            @include('user.partials.dashboard.productItem', [
                'name'=> 'راه ابریشم ریاضی تجربی آلاء',
                'src'=> 'https://cdn.alaatv.com/upload/images/product/pr4_20191007173649.jpg',
            ])
        </div>
        <div class="col-md-4 setsOfProductCol"></div>
    </div>

    <div class="row blockWraper a--owl-carousel-row">
        <div class="col">
            <div class="m-portlet a--owl-carousel-Wraper" id="owlCarouselMyProduct">
                <div class="m-portlet__head a--owl-carousel-head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                <span class="redSquare"></span>
                                محصولات خریداری شده من
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools d-none">
                        <a href="#"
                           class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air btn-viewGrid"
                           title="نمایش شبکه ای">
                            <i class="fa fa-th"></i>
                        </a>
                        <a href="#"
                           class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air btn-viewOwlCarousel"
                           title="نمایش افقی">
                            <i class="fa fa-exchange-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="m-portlet__body m-portlet__body--no-padding a--owl-carousel-body">

                    @if($user->completion() < 60)
                        <div class="alert alert-warning" role="alert">
                            <strong>برای دانلود محصولات خریداری شده ، درصد تکمیل پروفایل شما باید حداقل 60 درصد
                                باشد </strong>
                            <a href="{{action('Web\UserController@show' , $user)}}"
                               class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-info m-btn--gradient-to-accent">تکمیل
                                پروفایل</a>
                        </div>
                    @else

                        <div class="m-widget_head-owlcarousel-items owl-carousel a--owl-carousel-type-2 myProduct">
                            @foreach($userAssetsCollection as $userAssetKey=>$userAsset)
                                @if($userAsset->title === 'محصولات من')
                                    @foreach($userAsset->products as $productKey=>$product)
                                        @include('block.partials.purchasedProducts')
                                    @endforeach
                                @endif
                            @endforeach
                        </div>

                        @if(count($userAssetsCollection->filter(function ($value, $key) {return $value->title === 'محصولات من'; })->all())===0)
                            <div class="alert alert-info" role="alert">
                                <strong> هنوز از آلاء خرید نکرده اید. </strong>
                                بعد از اینکه از آلاء خرید کنید، امکان مشاهده خریدهای شما در این قسمت فراهم می شود.
                            </div>
                        @endif

                        <div class="m-portlet a--owl-carousel-slide-detailes">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                            مجموعه های محصول خریداری شده
                                        </h3>
                                    </div>
                                </div>
                                <div class="m-portlet__head-tools">
                                    <a class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air a--owl-carousel-hide-detailes">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>

                            @foreach($userAssetsCollection as $userAssetKey=>$userAsset)
                                @if($userAsset->title === 'محصولات من')
                                    @foreach($userAsset->products as $productKey=>$product)
                                        @if(count($product->sets)>1)
                                            <div
                                                class="m-portlet__body subCategoryWarper a--owl-carousel-slide-iteDetail-{{ $productKey }}">
                                                <div class="row justify-content-center">
                                                    @foreach($product->sets as $setKey=>$set)
                                                        @if($set->getActiveContents2(config('constants.CONTENT_TYPE_PAMPHLET'))->isNotEmpty() || $set->getActiveContents2(config('constants.CONTENT_TYPE_VIDEO'))->isNotEmpty())
                                                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                                                <div class="subCategoryItem">
                                                                    <div class="subCategoryItem-title">
                                                                        {{ $set->name }}
                                                                    </div>
                                                                    <hr>
                                                                    <div
                                                                        class="m-btn-group m-btn-group--pill btn-group m-btn-group m-btn-group--pill btn-group-sm"
                                                                        role="group" aria-label="Small button group">
                                                                        @if($set->getActiveContents2(config('constants.CONTENT_TYPE_PAMPHLET'))->isNotEmpty())
                                                                            <button type="button"
                                                                                    class="btn btn-warning btnViewPamphlet"
                                                                                    data-content-type="pamphlet"
                                                                                    data-content-url="{{ $set->contentUrl.'&orderBy=order' }}">
                                                                                <i class="fa fa-edit"></i>
                                                                                جزوات
                                                                            </button>
                                                                        @endif
                                                                        @if($set->getActiveContents2(config('constants.CONTENT_TYPE_VIDEO'))->isNotEmpty())
                                                                            <button type="button"
                                                                                    class="btn btn-success btnViewVideo"
                                                                                    data-content-type="video"
                                                                                    data-content-url="{{ $set->contentUrl.'&orderBy=order' }}">
                                                                                <i class="fa fa-film"></i>
                                                                                فیلم ها
                                                                            </button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>

    @foreach($userAssetsCollection as $userFavoritesKey=>$block)

        @if($block->title!=="محصولات من")

            @include('block.partials.block', [
                'blockCustomClass'=>$block->class.' userFavorites',
                'blockCustomId'=>'owlCarouselMyFavoritProducts',
                'blockType'=>'product',
                'blockTitle'=>'محصولات مورد علاقه من',
                'blockUrlDisable'=>false,
            ])

            @include('block.partials.block', [
                'blockCustomClass'=>$block->class.' userFavorites',
                'blockCustomId'=>'owlCarouselMyFavoritContent',
                'blockType'=>'content',
                'blockTitle'=>'فیلم های مورد علاقه من',
                'blockUrlDisable'=>false,
            ])

            @include('block.partials.block', [
                'blockCustomClass'=>$block->class.' userFavorites',
                'blockCustomId'=>'owlCarouselMyFavoritSet',
                'blockType'=>'set',
                'blockTitle'=>'مجموعه های مورد علاقه من',
                'blockUrlDisable'=>false,
            ])

        @endif
    @endforeach

    <!--begin::Modal-->
    <div class="modal fade" id="pamphletModal" tabindex="-1" role="dialog" aria-labelledby="pamphletModalModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pamphletModalModalLabel">
                        <i class="fa fa-edit"></i>
                        جزوات
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="m-widget6">
                                <div class="m-widget6__head">
                                    <div class="m-widget6__item">
                                        <span class="m-widget6__caption">
                                            عنوان
                                        </span>
                                        <span class="m-widget6__caption">
                                            مشاهده / دانلود
                                        </span>
                                    </div>
                                </div>
                                <div class="m-widget6__body">

                                </div>
                            </div>
                        </div>

                        <div class="col-12 text-center">
                            <input type="hidden" id="pamphletContentNextPageUrl">
                            <button type="button"
                                    class="btn m-btn m-btn--pill m-btn--air m-btn--gradient-from-info m-btn--gradient-to-warning btnLoadMoreInModal animated infinite heartBeat"
                                    data-content-type="pamphlet">
                                بیشتر ...
                            </button>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade contentModal" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel">
                        <i class="fa fa-film"></i>
                        فیلم ها
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="m-widget6">
                                <div class="m-widget6__head">
                                    <div class="m-widget6__item">
                                        <span class="m-widget6__caption">
                                            عنوان
                                        </span>
                                        <span class="m-widget6__caption">
                                            مشاهده / دانلود
                                        </span>
                                    </div>
                                </div>
                                <div class="m-widget6__body">

                                </div>
                            </div>
                        </div>

                        <div class="col-12 text-center">
                            <input type="hidden" id="videoContentNextPageUrl">
                            <button type="button"
                                    class="btn m-btn m-btn--pill m-btn--air m-btn--gradient-from-info m-btn--gradient-to-warning btnLoadMoreInModal animated infinite heartBeat"
                                    data-content-type="video">
                                بیشتر ...
                            </button>
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
    <script src="{{ asset('/acm/AlaatvCustomFiles/components/CustomDropDown/js.js') }}"></script>
    <script src="{{ mix('/js/user-dashboard.js') }}"></script>
    <script>
        CustomDropDown.init({
            elementId: 'selectProductSet',
            onChange: function (data) {
                console.log(data);
                // { index: 2, totalCount: 5, value: "3", text: "فرسنگ سوم" }
            }
        });

    </script>
@endsection
