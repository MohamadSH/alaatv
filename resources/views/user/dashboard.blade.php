@extends('app')

@section('page-css')
    <link href="{{ mix('/css/user-dashboard.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    @if(isset($user))
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
    @endif
@endsection

@section('content')

    @include('systemMessage.flash')

    @if(isset($userInfoCompletion))
        <input type="hidden" value="{{$userInfoCompletion}}" id="js-var-userInfo-cmpletion">
    @endif

    @if(isset($user) && $userInfoCompletion>=60)
        @if(optional($userAssetsCollection->where('title', 'محصولات من')->first->products)->count() > 0)

            <div class="row m--margin-bottom-10">
                <div class="col text-center">
                    <div class="btn-group m-btn-group btn-group-rounded" role="group" aria-label="...">
                        <button type="button" class="btn btn-secondary btnShowFavorites">علاقه مندی ها</button>
                        <button type="button" class="btn btn-warning btnShowPurchase">محصولات من</button>
                    </div>
                </div>
            </div>
            <style>
                .sortingFilterCol::-webkit-scrollbar {
                    display: none;
                }
                .sortingFilterCol {
                    overflow-y: auto;
                    -ms-overflow-style: none;
                }
            </style>
            <div class="row myProductsRow justify-content-center boxed">
                <div class="col-12">
                    <div class="row">
                        <div class="col text-center sortingFilterCol">
                            <div class="sortingFilter">
                                <div class="sortingFilter-item title" data-toggle="m-tooltip" data-placement="top"
                                     data-original-title="مرتب سازی بر اساس">
                                    <span>
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                             viewBox="0 0 56 56" xml:space="preserve" width="25">
                                            <g>
                                                <path
                                                    d="M8,41.08V2c0-0.553-0.448-1-1-1S6,1.447,6,2v39.08C2.613,41.568,0,44.481,0,48c0,3.859,3.14,7,7,7s7-3.141,7-7   C14,44.481,11.387,41.568,8,41.08z M7,53c-2.757,0-5-2.243-5-5s2.243-5,5-5s5,2.243,5,5S9.757,53,7,53z"/>
                                                <path
                                                    d="M29,20.695V2c0-0.553-0.448-1-1-1s-1,0.447-1,1v18.632c-3.602,0.396-6.414,3.456-6.414,7.161s2.812,6.765,6.414,7.161V54   c0,0.553,0.448,1,1,1s1-0.447,1-1V34.891c3.4-0.577,6-3.536,6-7.098S32.4,21.272,29,20.695z M27.793,33   c-2.871,0-5.207-2.336-5.207-5.207s2.335-5.207,5.207-5.207S33,24.922,33,27.793S30.664,33,27.793,33z"/>
                                                <path
                                                    d="M56,8c0-3.859-3.14-7-7-7s-7,3.141-7,7c0,3.519,2.613,6.432,6,6.92V54c0,0.553,0.448,1,1,1s1-0.447,1-1V14.92   C53.387,14.432,56,11.519,56,8z M49,13c-2.757,0-5-2.243-5-5s2.243-5,5-5s5,2.243,5,5S51.757,13,49,13z"/>
                                            </g>
                                        </svg>
                                    </span>

                                </div>
                                <div class="sortingFilter-item date">
                                    @include('partials.CustomSelect', ['class'=>'sort', 'items'=>[
                                            [
                                                'name'=> 'جدید ترین ها',
                                                'value'=> 'data-sort1',
                                                'selected'=> true
                                            ],
                                            [
                                                'name'=> 'قدیمی ترین ها',
                                                'value'=> 'data-sort2',
                                            ],
                                        ]
                                    ])
                                </div>
                                <div class="sortingFilter-item subject">

                                    @include('partials.CustomSelect', ['class'=>'filter', 'items'=>$categoryArray])

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 productsCol">


                    <div class="produtItems">
                        @foreach($userAssetsCollection as $userAssetKey=>$userAsset)
                            @if($userAsset->title === 'محصولات من')
                                @foreach($userAsset->products as $productKey=>$product)

                                    @include('user.partials.dashboard.productItem', [
                                        'key'=> $productKey,
                                        'name'=> $product->name,
                                        'src'=> $product->photo,
                                        'sets'=> $product->sets->sortBy('pivot.order'),
                                        'category'=> $product->category,
                                        'sort1' => $product->sorting['completed_at_desc'],
                                        'sort2' => $product->sorting['completed_at_asc']
                                    ])

                                @endforeach
                            @endif
                        @endforeach
                    </div>


                </div>
                <div class="col-md-7 contentsetOfProductCol">

                    <div class="m-portlet">

                        <div class="m-portlet__body">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active show" data-toggle="tab" href="#searchResult_video">فیلم ها</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#searchResult_pamphlet">جزوات</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show text-center" id="searchResult_video" role="tabpanel">


                                    <div class="searchResult text-left">
                                        <div class="listType">


                                        </div>
                                    </div>

                                    <input type="hidden" id="videoContentNextPageUrl">
                                    <div class="m-loader m-loader--success searchResultLoading_video"></div>
                                    <div role="alert" class="alert alert-info fade show noVideoMessage">
                                        <strong>فیلمی وجود ندارد</strong>
                                    </div>
                                    <button type="button"
                                            class="btn m-btn m-btn--pill m-btn--air m-btn--gradient-from-info m-btn--gradient-to-warning btnLoadMore animated infinite heartBeat"
                                            data-content-type="video">
                                        بیشتر ...
                                    </button>

                                </div>
                                <div class="tab-pane text-center" id="searchResult_pamphlet" role="tabpanel">


                                    <div class="m-widget4 text-left">


                                    </div>

                                    <input type="hidden" id="pamphletContentNextPageUrl">
                                    <div class="m-loader m-loader--success searchResultLoading_pamphlet"></div>
                                    <div role="alert" class="alert alert-info fade show noPamphletMessage">
                                        <strong>جزوه ای وجود ندارد</strong>
                                    </div>
                                    <button type="button"
                                            class="btn m-btn m-btn--pill m-btn--air m-btn--gradient-from-info m-btn--gradient-to-warning btnLoadMore animated infinite heartBeat"
                                            data-content-type="pamphlet">
                                        بیشتر ...
                                    </button>

                                </div>


                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal fade contentModal" id="smallScreenModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="videoModalLabel">

                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row myFavoritesRow boxed">
            <div class="col">
                @if((!is_null($userAssetsCollection->where('title', '!=', 'محصولات من')->pluck('products')->first()) && $userAssetsCollection->where('title', '!=', 'محصولات من')->pluck('products')->first()->count() > 0) ||
                (!is_null($userAssetsCollection->where('title', '!=', 'محصولات من')->pluck('contents')->first()) &&  $userAssetsCollection->where('title', '!=', 'محصولات من')->pluck('contents')->first()->count()) > 0 ||
                ( !is_null($userAssetsCollection->where('title', '!=', 'محصولات من')->pluck('sets')->first()) &&  $userAssetsCollection->where('title', '!=', 'محصولات من')->pluck('sets')->first()->count()) > 0)
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
                @else
                    <div class="alert alert-info" role="alert">
                        <strong>تا کنون موردی را به علاقه مندی های خود اضافه نکرده اید</strong>
                    </div>
                @endif
            </div>
        </div>

        @else

            <div class="alert alert-info" role="alert">
                <strong>هنوز از آلاء خرید نکرده اید.</strong>
                <a href="{{ action("Web\ShopPageController") }}" class="m-nav__link">
                    <button type="button" class="btn m-btn m-btn--gradient-from-warning m-btn--gradient-to-danger m--margin-5">محصولت آلاء</button>
                </a>
            </div>

        @endif
    @elseif(isset($user))

        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            اطلاعات شما کامل نیست.
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">

                <div class="alert alert-info" role="alert">
                    <strong>برای مشاهده فیلم ها و جزوات ابتدا اطلاعات خود را کامل کنید.</strong>
                </div>

                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <div class="completeUserInfo"></div>
                    </div>
                </div>


            </div>
        </div>

        <input type="hidden" value="{{route('web.authenticatedUser.profile.update')}}" id="js-var-actionUrl-profile-update">

        <input type="hidden" value="{{$user->firstName}}" id="js-var-userData-name">
        <input type="hidden" value="{{$user->lastName}}" id="js-var-userData-lastName">
        <input type="hidden" value="{{$user->province}}" id="js-var-userData-province">
        <input type="hidden" value="{{$user->city}}" id="js-var-userData-city">
        <input type="hidden" value="{{Session::token()}}" id="js-var-formData-token">
    @endif


@endsection

@section('page-js')
    <script src="{{ mix('/js/user-dashboard.js') }}"></script>
@endsection
