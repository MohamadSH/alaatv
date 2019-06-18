@extends('app' , ["pageName"=>$pageName])

@section('page-css')
    <link href="{{ mix('/css/page-shop.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="flaticon-home-2"></i>
                <a href="{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                فروشگاه آلاء
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    @include('partials.slideShow1' ,['marginBottom'=>'25', 'positionOfSlideShow'=>'صفحه فروشگاه'])
    <div class="m--clearfix"></div>
    <!--begin:: Widgets/Stats-->
    <div class="m-portlet shopNavItemsWraper">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl shopNavItems">
                <div class="col m--bg-danger shopNavItem">
                    <a target="_self" onclick="$('html,body').animate({scrollTop: $('.konkoor98').offset().top - 100},'slow');" href="#konkoor98">
                        <!--begin::Total Profit-->
                        <div class="m-widget24 m--align-center">
                            <div class="m-widget24__item">
                                <button class="btn m-btn m-btn--pill m-btn--air" type="button">
                                    <h2 class="m-widget24__title">
                                        همایش
                                        طلایی
                                    </h2>
                                </button>
                                <br>
                                <span class="m--font-light">
                                    <img src="{{ asset('/acm/extra/alaa-logo-small.gif') }}" width="20">
				                </span>
                                <div class="m--space-10"></div>
                            </div>
                        </div>
                        <!--end::Total Profit-->
                    </a>
                </div>
                <div class="col m--bg-warning shopNavItem">
                    <a target="_self" onclick="$('html,body').animate({scrollTop: $('.taftan').offset().top - 100},'slow');" href="#taftan">
                        <!--begin::Total Profit-->
                        <div class="m-widget24 m--align-center">
                            <div class="m-widget24__item">
                                <button class="btn m-btn m-btn--pill m-btn--air" type="button">
                                    <h2 class="m-widget24__title">
                                        همایش
                                        تفتان
                                    </h2>
                                </button>
                                <br>
                                <span class="m--font-light">
                                    <img src="{{ asset('/acm/extra/alaa-logo-small.gif') }}" width="20">
				                </span>
                                <div class="m--space-10"></div>
                            </div>
                        </div>
                        <!--end::Total Profit-->
                    </a>
                </div>
                <div class="col m--bg-success shopNavItem">
                    <a target="_self" onclick="$('html,body').animate({scrollTop: $('.konkoor2').offset().top - 100},'slow');" href="#konkoor2">
                        <!--begin::Total Profit-->
                        <div class="m-widget24 m--align-center">
                            <div class="m-widget24__item">
                                <button class="btn m-btn m-btn--pill m-btn--air" type="button">
                                    <h2 class="m-widget24__title">
                                        همایش
                                        1 + 5
                                    </h2>
                                </button>
                                <br>
                                <span class="m--font-light">
                                    <img src="{{ asset('/acm/extra/alaa-logo-small.gif') }}" width="20">
				                </span>
                                <div class="m--space-10"></div>
                            </div>
                        </div>
                        <!--end::Total Profit-->
                    </a>
                </div>
                <div class="col m--bg-accent shopNavItem">
                    <a target="_self" onclick="$('html,body').animate({scrollTop: $('.jozavat').offset().top - 100},'slow');" href="#jozavat">
                        <!--begin::Total Profit-->
                        <div class="m-widget24 m--align-center">
                            <div class="m-widget24__item">
                                <button class="btn m-btn m-btn--pill m-btn--air" type="button">
                                    <h2 class="m-widget24__title">
                                        جزوات
                                        آموزشی
                                    </h2>
                                </button>
                                <br>
                                <span class="m--font-light">
                                    <img src="{{ asset('/acm/extra/alaa-logo-small.gif') }}" width="20">
				                </span>
                                <div class="m--space-10"></div>
                            </div>
                        </div>
                        <!--end::Total Profit-->
                    </a>
                </div>
                <div class="col m--bg-info shopNavItem">
                    <a target="_self" onclick="$('html,body').animate({scrollTop: $('.konkoor1').offset().top - 100},'slow');" href="#konkoor1">
                        <!--begin::Total Profit-->
                        <div class="m-widget24 m--align-center">
                            <div class="m-widget24__item">
                                <button class="btn m-btn m-btn--pill m-btn--air" type="button">
                                    <h2 class="m-widget24__title">
                                        نظام قدیم
                                    </h2>
                                </button>
                                <br>
                                <span class="m--font-light">
                                    <img src="{{ asset('/acm/extra/alaa-logo-small.gif') }}" width="20">
				                </span>
                                <div class="m--space-10"></div>
                            </div>
                        </div>
                        <!--end::Total Profit-->
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--end:: Widgets/Stats-->
    
    @foreach($blocks as $block)
        @if($block->products->count() > 0)
            @include('product.partials.Block.block', [
                'blockCustomClass'=>'shopBlock a--owl-carousel-type-2'
            ])
        @endif
    @endforeach
    
    @include("partials.certificates")
@endsection

@section('page-js')
    <script src="{{ mix('/js/page-shop.js') }}"></script>
    <script>
        var gtmEecImpressions = [
            @foreach($blocks as $block)
                @foreach($block->products as $productKey=>$product)
                    {
                        id: '{{ $product->id }}',
                        name: '{{ $product->name }}',
                        category: '-',
                        list: '{{ $block->title }}',
                        position: '{{ $productKey }}'
                    },
            @endforeach
        @endforeach
        ];
        var gtmEecPromotions = [
                @foreach($slides as $slideKey=>$slide)
            {
                id: '{{ $slide->id }}',
                name: '{{ $slide->title }}',
                creative: 'اسلایدر صفحه فروشگاه',
                position: '{{ $slideKey }}'
            },
            @endforeach
        ];
    </script>
@endsection

