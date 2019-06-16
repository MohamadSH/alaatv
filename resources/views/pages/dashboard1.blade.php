@extends("app" , ["pageName"=>$pageName])

@section('page-css')
    <link href="{{ mix('/css/page-homePage.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .ribbon {
            top: calc(20px - 46px) !important;
            right: calc(5% - 5px) !important;
        }
        .a--owl-carousel-type-2-gridViewWarper .ribbon {
            top: calc(20px - 32px) !important;
            right: calc(5% - 5px) !important;
        }
        /*media query*/
        @media (max-width: 767.98px) {
            .homePageNavigation .row[class*="m-row--col-separator-"] > div:last-child {
                border-bottom: 1px solid #ebedf2;
            }
        }
    </style>
@endsection

@section("content")
    @include("partials.slideShow1" ,["marginBottom"=>"25"])
    
    <div class="m--clearfix"></div>
    <!--begin:: Widgets/Stats-->
    <div class="m-portlet homePageNavigation">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl shopNavItems">
                <div class="col-6 col-md-3 m--bg-warning shopNavItem">
                    <a target="_self" onclick="$('html,body').animate({scrollTop: $('.konkoor1').offset().top - 100},'slow');" href="#konkoor1">
                        <!--begin::Total Profit-->
                        <div class="m-widget24 m--align-center">
                            <div class="m-widget24__item">
                                <button class="btn m-btn m-btn--pill m-btn--air" type="button">
                                    <h2 class="m-widget24__title">
                                        کنکور نظام قدیم
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
                <div class="col-6 col-md-3 m--bg-accent shopNavItem">
                    <a target="_self" onclick="$('html,body').animate({scrollTop: $('.konkoor2').offset().top - 100},'slow');" href="#konkoor2">
                        <!--begin::Total Profit-->
                        <div class="m-widget24 m--align-center">
                            <div class="m-widget24__item">
                                <button class="btn m-btn m-btn--pill m-btn--air" type="button">
                                    <h2 class="m-widget24__title">
                                        کنکور نظام جدید
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
                <div class="col-6 col-md-3 m--bg-success shopNavItem">
                    <a target="_self" onclick="$('html,body').animate({scrollTop: $('.yazdahom').offset().top - 100},'slow');" href="#yazdahom">
                        <!--begin::Total Profit-->
                        <div class="m-widget24 m--align-center">
                            <div class="m-widget24__item">
                                <button class="btn m-btn m-btn--pill m-btn--air" type="button">
                                    <h2 class="m-widget24__title">
                                        پایه یازدهم
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
                <div class="col-6 col-md-3 m--bg-info shopNavItem">
                    <a target="_self" onclick="$('html,body').animate({scrollTop: $('.dahom').offset().top - 100},'slow');" href="#dahom">
                        <!--begin::Total Profit-->
                        <div class="m-widget24 m--align-center">
                            <div class="m-widget24__item">
                                <button class="btn m-btn m-btn--pill m-btn--air" type="button">
                                    <h2 class="m-widget24__title">
                                        پایه دهم
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
        <div class="m-portlet__body  m-portlet__body--no-padding m--padding-top-5">
            <div class="row m-row--no-padding m-row--col-separator-xl shopNavItems">
                <div class="col-12 col-md-6 m--bg-info shopNavItem">
                    <a target="_self" href="{{ route('landing.5') }}">
                        <!--begin::Total Profit-->
                        <div class="m-widget24 m--align-center">
                            <div class="m-widget24__item">
                                <button class="btn m-btn m-btn--pill m-btn--air" type="button">
                                    <h2 class="m-widget24__title">
                                        همایش های دانلودی نظام قدیم
                                    </h2>
                                </button>
                                <div class="m--space-10"></div>
                            </div>
                        </div>
                        <!--end::Total Profit-->
                    </a>
                </div>
                <div class="col-12 col-md-6 m--bg-accent shopNavItem">
                    <a target="_self" href="{{ route('landing.8') }}">
                        <!--begin::Total Profit-->
                        <div class="m-widget24 m--align-center">
                            <div class="m-widget24__item">
                                <button class="btn m-btn m-btn--pill m-btn--air" type="button">
                                    <h2 class="m-widget24__title">
                                        همایش های دانلودی نظام جدید
                                    </h2>
                                </button>
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
        @include('product.partials.Block.block', [
            'blockCustomClass'=>$block->class.' a--content-carousel-1 dasboardLessons',
            'blockCustomId'=>'sectionId-'.$block->class,
            'blockType'=>(isset($block->sets) && $block->sets->count()>0)?'set':(isset($block->products) && $block->products->count()>0?'product':'content'),
            'blockUrlDisable'=>false,
        ])
        {{--            @foreach($section["ads"] as $image => $link)--}}
        {{--                @include('partials.bannerAds', ['img'=>$image , 'link'=>$link])--}}
        {{--            @endforeach--}}
    @endforeach
    
{{--    @foreach($sections as $section)--}}
{{--        @if($section['lessons']->count() > 0)--}}
{{--            @include('product.partials.owl-carousel.widget1', [--}}
{{--                'contentCustomClass'=>$section["class"].' a--content-carousel-1 dasboardLessons',--}}
{{--                'contentCustomId'=>'sectionId-'.$section["class"],--}}
{{--                'contentTitle'=>$section["descriptiveName"],--}}
{{--                'contentUrl'=>urldecode(action("Web\ContentController@index" , ["tags" => $section["tags"]])),--}}
{{--                'contentSets'=>$section["lessons"]--}}
{{--            ])--}}
{{--            @foreach($section["ads"] as $image => $link)--}}
{{--                @include('partials.bannerAds', ['img'=>$image , 'link'=>$link])--}}
{{--            @endforeach--}}
{{--        @endif--}}
{{--    @endforeach--}}
    
    @include("partials.certificates")
@endsection

@section('page-js')
    <script>
        var sections = [
        @foreach($sections as $section)
            @if($section['lessons']->count() > 0)
                    '{{ $section["class"] }}',
            @endif
        @endforeach
        ];
    </script>
    <script src="{{ mix('/js/page-homePage.js') }}"></script>
@endsection