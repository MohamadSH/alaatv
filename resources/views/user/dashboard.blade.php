@extends('app' , ["pageName"=>$pageName])

@section('page-css')
    <link href="{{ mix('/css/user-dashboard.css') }}" rel="stylesheet" type="text/css"/>
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
    
    
    <div class="row blockWraper a--owl-carousel-row">
        <div class="col">
            <div class="m-portlet a--owl-carousel-Wraper" id="owlCarouselMyProduct">
                <div class="m-portlet__head a--owl-carousel-head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                <span class="redSquare"></span>
                                محصولات من
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
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
        
        
                        <div class="a--owl-carousel-init-loading">
                            <div class="lds-roller">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
        
                        <div class="m-widget_head-owlcarousel-items owl-carousel a--owl-carousel-type-2 myProduct">
                            @foreach($userAssetsCollection as $userAssetKey=>$userAsset)
                                @foreach($userAsset->products as $productKey=>$product)
                                    @include('block.partials.purchasedProducts')
                                @endforeach
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
    <script src="{{ mix('/js/user-dashboard.js') }}"></script>
@endsection
