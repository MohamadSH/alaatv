@extends('app')

@section('page-css')
    <link href="{{ mix("/css/content-show.css") }}" rel="stylesheet">
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home m--padding-right-5"></i>
                <a class="m-link" href="{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item">
                <i class="flaticon-photo-camera m--padding-right-5"></i>
                <a class="m-link"
                   href="{{ action("Web\ContentController@index") }}">@lang('content.Educational Content Of Alaa')</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#"> {{ $content->displayName }} </a>
            </li>
        </ol>
    </nav>
    <input id="js-var-contentId" class="m--hide" type="hidden" value='{{ $content->id }}'>
    <input id="js-var-contentDName" class="m--hide" type="hidden" value='{{ $content->displayName }}'>
    <input id="js-var-contentUrl" class="m--hide" type="hidden"
           value='{{action("Web\ContentController@show" , $content)}}'>
    <input id="js-var-contentEmbedUrl" class="m--hide" type="hidden"
           value='{{action("Web\ContentController@embed" , $content)}}'>
@endsection

@section('content')
    <div class="row">

        <div class="col-12 col-sm-12 col-md-12 col-lg-8 mx-auto">

            @if(!$user_can_see_content)
                <div class="m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert alert-info alert-dismissible fade show"
                     role="alert">
                    <div class="m-alert__icon">
                        <i class="flaticon-exclamation-1"></i>
                        <span></span>
                    </div>
                    <div class="m-alert__text">
                        <strong>{{ $message }}</strong>
                    </div>
                    @if($productsThatHaveThisContent->isNotEmpty())
                        <div class="m-alert__actions" style="width: 160px;">
                            <button type="button"
                                    class="btn m-btn--air btn-warning btn-sm m-btn m-btn--pill m-btn--wide scrollToOwlCarouselParentProducts">
                                مشاهده محصولات
                            </button>
                        </div>
                    @endif
                    <div class="m-alert__close">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            {{--            @if(!isset($videosWithSameSet) or $videosWithSameSet->count() === 0)--}}
            {{--                <div class="alert alert-info" role="alert">--}}
            {{--                    <strong>حیف!</strong> این مجموعه فیلم ندارد.--}}
            {{--                </div>--}}
            {{--            @endif--}}

            @if(isset($content->template))
                @if(optional($content->template)->name == "video1")
                <!--begin::Portlet-->
                    <div class="m-portlet m-portlet--mobile">
                        <div class="m-portlet__body a--nuevo-alaa-theme a--media-parent">
                            <div class="a--video-wraper">
                                <video id="video-{{ $content->id }}"
                                       class="video-js vjs-fluid vjs-default-skin vjs-big-play-centered" controls
                                       preload="none" height='360' width="640" poster='{{ $content->thumbnail }}'>
                                    @if($user_can_see_content)
                                        @foreach($content->getVideos() as $source)
                                            <source src="{{ $source->link }}" type='video/mp4' res="{{ $source->res }}"
                                                    @if(strcmp( $source->res,"240p") == 0)
                                                    default
                                                    @endif
                                                    label="{{ $source->caption }}"/>
                                        @endforeach
                                    @endif
                                    <p class="vjs-no-js">@lang('content.javascript is disables! we need it to play a video')</p>
                                </video>
                            </div>
                            <div class="m--clearfix"></div>
                            <div class="m--margin-top-10">
                                @if(isset($videosWithSameSet) and $videosWithSameSet->isNotEmpty())
                                    <nav aria-label="Page navigation" class="table-responsive">
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item">
                                                <a class="page-link"
                                                   href="{{action("Web\ContentController@show" , $videosWithSameSet->first()["content"])}}"
                                                   aria-label="اولین">
                                                    <span aria-hidden="true">&laquo;</span>
                                                    <span class="sr-only">اولین</span>
                                                </a>
                                            </li>
                                            @foreach($videosWithSameSetL->take(-5) as $item)

                                                <li class="page-item @if($item["content"]->id == $content->id) active @endif">
                                                    <a class="page-link"
                                                       href="{{action("Web\ContentController@show" , $item["content"])}}">{{ $item["content"]->order }}</a>
                                                </li>

                                            @endforeach
                                            @foreach($videosWithSameSetR->take(6) as $item)

                                                <li class="page-item @if($item["content"]->id == $content->id) active @endif">
                                                    <a class="page-link"
                                                       href="{{action("Web\ContentController@show" , $item["content"])}}">{{ $item["content"]->order }}</a>
                                                </li>

                                            @endforeach
                                            <li class="page-item">
                                                <a class="page-link"
                                                   href="{{action("Web\ContentController@show" , $videosWithSameSet->last()["content"])}}"
                                                   aria-label="آخرین">
                                                    <span aria-hidden="true">&raquo;</span>
                                                    <span class="sr-only">آخرین</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                @endif
                                @if($productsHasThisContentThroughBlockCollection->count() > 0)
                                    @foreach($productsHasThisContentThroughBlockCollection as $productKey=>$product)
                                        @if($product->type['type'] === 'simple')
                                            <button
                                                data-gtm-eec-product-id="{{$product->id}}"
                                                data-gtm-eec-product-name="{{$product->name}}"
                                                data-gtm-eec-product-price="@if($product->price){{$product->price['final']}}@endif"
                                                data-gtm-eec-product-brand="آلاء"
                                                data-gtm-eec-product-category="-"
                                                data-gtm-eec-product-variant="-"
                                                data-gtm-eec-product-quantity="1"
                                                data-gtm-eec-product-position="{{ $productKey }}"
                                                data-gtm-eec-product-list="نمونه فیلم-دکمه افزودن به سبد"
                                                class="btn m-btn--air btn-success m-btn--icon m--margin-bottom-5 a--gtm-eec-product btnAddToCart" data-pid="{{ $product->id }}">
                                                <span>
                                                    <i class="fa fa-cart-arrow-down"></i>
                                                    <i class="fas fa-sync-alt fa-spin m--hide"></i>
                                                    <span>افزودن {{ $product->name }} به سبد خرید</span>
                                                </span>
                                            </button>
                                        @else
                                            <a class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-info m-btn--gradient-to-accent btnViewProductPage">
                                                مشاهده
                                                {{ $product->name }}
                                            </a>
                                        @endif
                                    @endforeach
                                @endif

                                @if(!$user_can_see_content && $productsThatHaveThisContent->isNotEmpty())
                                    @foreach($productsThatHaveThisContent as $productKey=>$product)
                                        @if($product->type['type'] === 'simple')
                                            <button
                                                    data-gtm-eec-product-id="{{$product->id}}"
                                                    data-gtm-eec-product-name="{{$product->name}}"
                                                    data-gtm-eec-product-price="@if($product->price){{ number_format($product->price['final'], 2, '.', '') }}@endif"
                                                    data-gtm-eec-product-brand="آلاء"
                                                    data-gtm-eec-product-category="-"
                                                    data-gtm-eec-product-variant="-"
                                                    data-gtm-eec-product-quantity="1"
                                                    data-gtm-eec-product-position="{{ $productKey }}"
                                                    data-gtm-eec-product-list="محصولاتی که شامل این محتوا هستند-دکمه افزودن به سبد"
                                                    class="btn m-btn--air btn-success m-btn--icon m--margin-bottom-5 a--gtm-eec-product btnAddToCart" data-pid="{{ $product->id }}">
                                            <span>
                                                <i class="fa fa-cart-arrow-down"></i>
                                                <i class="fas fa-sync-alt fa-spin m--hide"></i>
                                                <span>افزودن {{ $product->name }} به سبد خرید</span>
                                            </span>
                                            </button>
                                        @else
                                            <a class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-info m-btn--gradient-to-accent btnViewProductPage">
                                                مشاهده
                                                {{ $product->name }}
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col text-center m--margin-bottom-5">
{{--                            <a href="{{ route('landing.5') }}"--}}
{{--                               class="a--gtm-eec-advertisement a--gtm-eec-advertisement-click"--}}
{{--                               data-gtm-eec-promotion-id="contentShowPage-rightSide-0"--}}
{{--                               data-gtm-eec-promotion-name="همایش های دانلودی آلاء"--}}
{{--                               data-gtm-eec-promotion-creative="سمت راست صفحه بالای توضیحات کانتنت"--}}
{{--                               data-gtm-eec-promotion-position="0">--}}
{{--                                <img src="{{ asset('/acm/extra/ads/gif/970-90.gif') }}" class="a--full-width">--}}
{{--                                --}}{{--                            <img src="{{ asset('/acm/extra/ads/gif/300-250.gif') }}" class="a--full-width">--}}
{{--                            </a>--}}
                        </div>
                    </div>

                    <div class="m-portlet m-portlet--mobile">
                        <div class="m-portlet__body a--nuevo-alaa-theme">

                            <h1 class="m--regular-font-size-lg3 m--font-bold m--font-focus">{{ $content->displayName }}</h1>
                            @if(isset($content->author_id))
                                <div class="m-widget3">
                                    <div class="m-widget3__item">
                                        <div class="m-widget3__header">
                                            <div class="m-widget3__user-img">
                                                <img class="m-widget3__img lazy-image" data-src="{{ $content->author->photo }}"
                                                     alt="{{ $author }}">
                                            </div>
                                            <div class="m-widget3__info">
                                                <span class="m-widget3__username">
                                                {{ $author }}
                                                </span>
                                                @if(isset($contentSetName))
                                                    <br>
                                                    <h3 class="m-widget3__time m--font-info">
                                                        {{ $contentSetName }}
                                                    </h3>
                                                @endif
                                            </div>
                                            @if($userCanSeeCounter)
                                                <span class="m-widget3__status m--font-info m--block-inline">
                                                    <i class="fa fa-eye"> {{ $seenCount }}</i>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="m-widget3__body">
                                            <div class="m-widget3__text">

                                                @if(strlen($content->description) > 2000)
                                                    <div class="a--summarize-text">
                                                        <div class="a--summarize-text-toggleBtn">
                                                            <button class="btn btn-accent m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
                                                                <i class="fa fa-angle-double-down"></i>
                                                            </button>
                                                        </div>
                                                        <div class="a--summarize-text-content">
                                                            {!! $content->description !!}
                                                        </div>
                                                    </div>
                                                @else
                                                    {!! $content->description !!}
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-separator m-separator--space m-separator--dashed"></div>
                            @endif
                            @if($user_can_see_content)
                                <h3 class="m--regular-font-size-lg4 m--font-boldest2 m--font-focus">
                                    لینک های مستقیم دانلود این فیلم
                                </h3>
                                <div class="row">
                                    @if(isset($content->file) and $content->file->isNotEmpty())
                                        <div class="col-md-4 text-justify">

                                            <p>
                                                با IDM یا ADM و یا wget دانلود کنید.
                                            </p>
                                        @foreach($content->file->get('video') as $file)
                                            <!--begin::m-widget4-->
                                                <div class="m-widget4">
                                                    <div class="m-widget4__item">
                                                        <div class="m-widget4__img m-widget4__img--icon">
                                                            <img data-src="/assets/app/media/img/files/mp4.svg" alt="mp4" class="lazy-image">
                                                        </div>
                                                        <div class="m-widget4__info">
                                                            <a href="{{ $file->link }}?download=1" class="m-link">
                                                    <span class="m-widget4__text">
                                                    دانلود فایل {{$file->caption}}{{ isset($file->size[0]) ? "(".$file->size. ")":""  }}
                                                    </span>
                                                            </a>
                                                        </div>
                                                        <div class="m-widget4__ext">
                                                            <a href="{{ $file->link }}?download=1" class="m-widget4__icon">
                                                                <i class="fa fa-download"></i>
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!--end::Widget 4-->
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="col-md-8">

                                        <div class="row">
                                            <div class="col-md-6 text-center m--margin-bottom-5">
{{--                                                <a href="{{ route('landing.8') }}"--}}
{{--                                                   class="a--gtm-eec-advertisement a--gtm-eec-advertisement-click"--}}
{{--                                                   data-gtm-eec-promotion-id="contentShowPage-rightSide-1"--}}
{{--                                                   data-gtm-eec-promotion-name="قرعه کشی گوشی"--}}
{{--                                                   data-gtm-eec-promotion-creative="جلوی لینک های مستقیم دانلود این فیلم"--}}
{{--                                                   data-gtm-eec-promotion-position="0">--}}
{{--                                                    <img data-src="{{ asset('/acm/extra/ads/gif/300-250.gif') }}" class="a--full-width lazy-image">--}}
{{--                                                    --}}{{--                            <img src="{{ asset('/acm/extra/ads/gif/300-250.gif') }}" class="a--full-width">--}}
{{--                                                </a>--}}
                                            </div>
                                            <div class="col-md-6 text-center m--margin-bottom-5">
{{--                                                <a href="{{ route('landing.5') }}"--}}
{{--                                                   class="a--gtm-eec-advertisement a--gtm-eec-advertisement-click"--}}
{{--                                                   data-gtm-eec-promotion-id="contentShowPage-rightSide-2"--}}
{{--                                                   data-gtm-eec-promotion-name="همایش های دانلودی آلاء"--}}
{{--                                                   data-gtm-eec-promotion-creative="جلوی لینک های مستقیم دانلود این فیلم"--}}
{{--                                                   data-gtm-eec-promotion-position="1">--}}
{{--                                                    <img src="{{ asset('/acm/extra/ads/gif/300-251.gif') }}" class="a--full-width">--}}
{{--                                                    --}}{{--                            <img src="{{ asset('/acm/extra/ads/gif/300-250.gif') }}" class="a--full-width">--}}
{{--                                                </a>--}}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endif

                            <div class="m-separator m-separator--space m-separator--dashed"></div>
                            @if(!empty($tags))
                                @include("partials.search.tagLabel" , ["tags"=>$tags])
                            @endif
                        </div>
                    </div>
                    <!--end::Portlet-->
                @elseif(optional($content->template)->name == "pamphlet1" )
                <!--begin::Portlet-->
                    <div class="m-portlet m-portlet--mobile">
                        <div class="m-portlet__body">
                            <div class="m-portlet__body-progress">Loading</div>
                            <!--begin::m-widget5-->
                            <div class="m-widget5">
                                <div class="m-widget5__item">
                                    <div class="m-widget5__content">
                                        <div class="m-widget5__pic">
                                            <img class="m-widget7__img img-fluid lazy-image"
                                                 data-src="/assets/app/media/img/files/pdf.svg" alt="pdf">
                                        </div>
                                        <div class="m-widget5__section">
                                            <h4 class="m-widget5__title">
                                                {{ $content->displayName  }}
                                            </h4>
                                            <div class="m-widget5__info">
                                                @if($user_can_see_content)
                                                    <div class="btn-group m-btn-group" role="group" aria-label="...">
                                                        @foreach($content->getPamphlets() as $file)
                                                            <a href="{{ $file->link }}" target="_blank"
                                                               title="دانلود مستقیم">
                                                                <button type="button" class="btn btn-primary">
                                                                    دانلود {{ $file->caption }}
                                                                </button>
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-widget5__content"></div>
                                </div>
                            </div>
                            <!--end::m-widget5-->
                            <div class="m-separator m-separator--space m-separator--dashed"></div>
                            @if(!empty($tags))
                                @include("partials.search.tagLabel" , ["tags"=>$tags])
                            @endif
                        </div>
                    </div>
                    <!--end::Portlet-->

                    <div class="row">
                        <div class="col text-center m--margin-bottom-5">
{{--                            <a href="{{ route('landing.5') }}"--}}
{{--                               class="a--gtm-eec-advertisement a--gtm-eec-advertisement-click "--}}
{{--                               data-gtm-eec-promotion-id="contentShowPage-rightSide-0"--}}
{{--                               data-gtm-eec-promotion-name="همایش های دانلودی آلاء"--}}
{{--                               data-gtm-eec-promotion-creative="سمت راست صفحه بالای توضیحات کانتنت"--}}
{{--                               data-gtm-eec-promotion-position="0">--}}
{{--                                <img src="{{ asset('/acm/extra/ads/gif/970-90.gif') }}" class="a--full-width">--}}
{{--                            </a>--}}
                        </div>
                    </div>

                    @if(isset($content->description[0]))
                    <!--begin::Portlet-->
                        <div class="m-portlet m-portlet--mobile">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                            درباره
                                            @if(isset($contentSetName))
                                                <small>
                                                    {{ $content->displayName  }}
                                                </small>
                                            @endif
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__body">
                                <div>

                                    @if(strlen($content->description) > 2000)
                                        <div class="a--summarize-text">
                                            <div class="a--summarize-text-toggleBtn">
                                                <button class="btn btn-accent m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
                                                    <i class="fa fa-angle-double-down"></i>
                                                </button>
                                            </div>
                                            <div class="a--summarize-text-content">
                                                {!! $content->description !!}
                                            </div>
                                        </div>
                                    @else
                                        {!! $content->description !!}
                                    @endif

                                </div>
                            </div>
                        </div>
                        <!--end::Portlet-->
                    @endif

                @elseif(optional($content->template)->name == "article1")
                <!--begin::Portlet-->
                    <div class="m-portlet">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        {{$content->name}}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="m-portlet__body-progress">Loading</div>
                            <div>
                                {!! $content->context !!}
                            </div>
                            <div class="m-separator m-separator--space m-separator--dashed"></div>
                            @if(!empty($tags))
                                @include("partials.search.tagLabel" , ["tags"=>$tags])
                            @endif
                        </div>
                    </div>
                    <!--end::Portlet-->

                    <div class="row">
                        <div class="col text-center m--margin-bottom-5">
{{--                            <a href="{{ route('landing.5') }}"--}}
{{--                               class="a--gtm-eec-advertisement a--gtm-eec-advertisement-click "--}}
{{--                               data-gtm-eec-promotion-id="contentShowPage-rightSide-0"--}}
{{--                               data-gtm-eec-promotion-name="همایش های دانلودی آلاء"--}}
{{--                               data-gtm-eec-promotion-creative="سمت راست صفحه بالای توضیحات کانتنت"--}}
{{--                               data-gtm-eec-promotion-position="0">--}}
{{--                                <img src="{{ asset('/acm/extra/ads/gif/970-90.gif') }}" class="a--full-width">--}}
{{--                            </a>--}}
                        </div>
                    </div>
                @endif
            @else
                <div class="alert alert-danger" role="alert">
                    <strong>خطا!</strong> خطا لطفا لینک این صفحه را برای ما ارسال کنید تا بررسی شود.
                </div>
            @endif
            @if($pamphletsWithSameSet->count() > 0 and $pamphletsWithSameSet->where("content.id" , "<>",$content->id)->isNotEmpty())
            <!--begin::Portlet-->
                <div class="m-portlet m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_7">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="flaticon-share"></i>
                            </span>
                                <h3 class="m-portlet__head-text m--icon-font-size-sm3">
                                    جزوات {{ $contentSetName }}
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="#" m-portlet-tool="toggle"
                                       class="m-portlet__nav-link m-portlet__nav-link--icon">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div
                                style="min-height: 900px;"
                                {{--                                class="m-scrollable" data-scrollable="true" data-height="450" data-scrollbar-shown="true"--}}
                        >
                        @foreach($pamphletsWithSameSet as  $item)
                            <!--begin::m-widget4-->
                                <div class="m-widget4">
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__img m-widget4__img--icon">
                                            <img data-src="/assets/app/media/img/files/pdf.svg" alt="pdf" class="lazy-image">
                                        </div>
                                        <div class="m-widget4__info">
                                            <a href="{{ action("Web\ContentController@show" , $item["content"]) }}"
                                               class="m-link m--font-light">
                                                <span class="m-widget4__text ">
                                                    {{ $item["content"]->name }}
                                                </span>
                                            </a>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a href="{{ action("Web\ContentController@show" , $item["content"]) }}"
                                               class="m-widget4__icon">
                                                <i class="m--link fa fa-chevron-left"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Widget 4-->
                                <div class="m-separator m-separator--space m-separator--dashed"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!--end::Portlet-->
            @endif
        </div>
        @if(isset($videosWithSameSet) and $videosWithSameSet->count() > 0)
            <div class="col-12 col-sm-12 col-md-12 col-lg-4">
                <!--begin::Portlet-->

                <div class="row">
                    <div class="col text-center m--margin-bottom-5">
                        <a href="{{ route('landing.8') }}"
                           class="a--gtm-eec-advertisement a--gtm-eec-advertisement-click "
                           data-gtm-eec-promotion-id="shop-ghorekeshi3"
                           data-gtm-eec-promotion-name="قرعه کشی گوشی"
                           data-gtm-eec-promotion-creative="سمت چپ صفحه بالای لیست کانتنت های مشابه"
                           data-gtm-eec-promotion-position="0">
                            <img data-src="{{ asset('/acm/extra/ads/gif/970-90(1).gif') }}" class="a--full-width lazy-image">
                        </a>
                    </div>
                </div>
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    فیلم ها
                                    @if(isset($contentSetName))
                                        <small>
                                            {{ $contentSetName }}
                                        </small>
                                    @endif
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body m--padding-10">
                        <div id="playListScroller"
                             class="m-scrollable11"
                             data-scrollable="true"
{{--                             data-height="{{ min($videosWithSameSet->count(),(optional($content->template)->name == "video1" ?  11 : 4)) * 103 }}"--}}
                             data-height="360"
                             data-scrollbar-shown="true">
                            <div class="m-portlet__body-progress">Loading</div>

                            <!--begin::m-widget5-->
                            <div class="a-widget5">
                                @foreach($videosWithSameSet as $item)
                                    <div class="a-widget5__item" id="playlistItem_{{ $item["content"]->id }}">
                                        <div class="a-widget5__content  {{ $item["content"]->id == $content->id ? 'm--bg-info' : '' }}">
                                            <div class="a-widget5__pic">
                                                <a class="m-link a--full-width"
                                                   href="{{action("Web\ContentController@show" , $item["content"])}}">
                                                    <img class="m-widget7__img a--full-width lazy-image"
                                                         width="170" height="96"
                                                         src="https://cdn.alaatv.com/loder.jpg?w=1&h=1"
                                                         data-src="{{ isset($item["thumbnail"]) ? $item["thumbnail"]."?w=210&h=118":'' }}"
                                                         alt="{{ $item["content"]->name }}">
                                                </a>
                                            </div>
                                            <div class="a-widget5__section">
                                                <h4 class="a-widget5__title">
                                                    <a class="m-link"
                                                       href="{{action("Web\ContentController@show" , $item["content"])}}">
                                                        {!! str_limit($item["content"]->display_name, 45, ' ...') !!}
                                                    </a>
                                                </h4>
                                                <div class="a-widget5__info">
                                                    <div class="content-description">
                                                        {!! str_limit(clearHtml($item["content"]->description), 100, ' ...') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!--end::m-widget5-->

                        </div>
                    </div>
                </div>
                <!--end::Portlet-->
                <div>
{{--                    <a href="https://alaatv.com/product/312"--}}
{{--                       data-tooltip-content="همایش طلایی شیمی کنکور"--}}
{{--                       class="a--gtm-eec-advertisement a--gtm-eec-advertisement-click"--}}
{{--                       data-gtm-eec-promotion-id="contentShowPage-leftSide-1"--}}
{{--                       data-gtm-eec-promotion-name="همایش طلایی شیمی کنکور"--}}
{{--                       data-gtm-eec-promotion-creative="سمت چپ صفحه پایین لیست کانتنت های مشابه"--}}
{{--                       data-gtm-eec-promotion-position="0">--}}
{{--                        <img src="http://uupload.ir/files/u8r8_banner-1.gif" alt="همایش طلایی شیمی کنکور"--}}
{{--                             class="m--img-centered a--full-width"/>--}}
{{--                    </a>--}}
{{--                    <a href="https://alaatv.com/product/312"--}}
{{--                       data-tooltip-content="همایش طلایی ریاضی تجربی کنکور"--}}
{{--                       class="a--gtm-eec-advertisement a--gtm-eec-advertisement-click"--}}
{{--                       data-gtm-eec-promotion-id="contentShowPage-leftSide-1"--}}
{{--                       data-gtm-eec-promotion-name="همایش طلایی ریاضی تجربی کنکور"--}}
{{--                       data-gtm-eec-promotion-creative="سمت چپ صفحه پایین لیست کانتنت های مشابه"--}}
{{--                       data-gtm-eec-promotion-position="0">--}}
{{--                        <img data-src="https://cdn.alaatv.com/upload/riaziTajrobiKonkurNabakhte.gif" alt="همایش طلایی ریاضی تجربی کنکور"--}}
{{--                             class="m--img-centered a--full-width lazy-image"/>--}}
{{--                    </a>--}}
                </div>
            </div>
        @endif
    </div>

    @if($productsThatHaveThisContent->isNotEmpty())
        <div class="row a--owl-carousel-row blockWraper-hasProduct">
            <div class="col">
                <div class="m-portlet a--owl-carousel-Wraper" id="owlCarouselParentProducts">
                    <div class="m-portlet__head a--owl-carousel-head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    <span class="redSquare"></span>
                                    محصولاتی که شامل این محتوا هستند
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <a href="#"
                               class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air btn-viewGrid" title="نمایش شبکه ای">
                                <i class="fa fa-th"></i>
                            </a>
                            <a href="#"
                               class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air btn-viewOwlCarousel" title="نمایش افقی">
                                <i class="fa fa-exchange-alt"></i>
                            </a>
                        </div>
                    </div>
                    <div class="m-portlet__body m-portlet__body--no-padding a--owl-carousel-body">

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

                        <div class="m-widget_head-owlcarousel-items owl-carousel a--owl-carousel-type-2 carousel_block_owlCarouselParentProducts">
                            @foreach($productsThatHaveThisContent as $productKey=>$product)
                                <div class="item carousel a--block-item a--block-type-product"
                                     data-position="{{ $productKey }}"
                                     data-gtm-eec-product-id="{{ $product->id }}"
                                     data-gtm-eec-product-name="{{ $product->name }}"
                                     data-gtm-eec-product-price="{{ number_format($product->price['final'], 2, '.', '') }}"
                                     data-gtm-eec-product-brand="آلاء"
                                     data-gtm-eec-product-category="-"
                                     data-gtm-eec-product-variant="-"
                                     data-gtm-eec-product-position="{{ $productKey }}"
                                     data-gtm-eec-product-list="محصولاتی که شامل این محتوا هستند">

                                    <div class="a--block-imageWrapper">
                                        <a href="{{ $product->url }}"
                                           class="a--block-imageWrapper-image a--gtm-eec-product a--gtm-eec-product-click d-block"
                                           data-gtm-eec-product-id="{{ $product->id }}"
                                           data-gtm-eec-product-name="{{ $product->name }}"
                                           data-gtm-eec-product-price="{{ number_format($product->price['final'], 2, '.', '') }}"
                                           data-gtm-eec-product-brand="آلاء"
                                           data-gtm-eec-product-category="-"
                                           data-gtm-eec-product-variant="-"
                                           data-gtm-eec-product-position="{{ $productKey }}"
                                           data-gtm-eec-product-list="محصولاتی که شامل این محتوا هستند">
                                            <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" data-src="{{ $product->photo }}" alt="{{ $product->name }}" class="a--block-image lazy-image" width="400" height="400" />
                                        </a>
                                    </div>
                                    <div class="a--block-infoWrapper">
                                        <div class="a--block-titleWrapper">
                                            <a href="{{ $product->url }}"
                                               class="m-link a--owl-carousel-type-2-item-subtitle a--gtm-eec-product-click"
                                               data-gtm-eec-product-id="{{ $product->id }}"
                                               data-gtm-eec-product-name="{{ $product->name }}"
                                               data-gtm-eec-product-price="{{ number_format($product->price['final'], 2, '.', '') }}"
                                               data-gtm-eec-product-brand="آلاء"
                                               data-gtm-eec-product-category="-"
                                               data-gtm-eec-product-variant="-"
                                               data-gtm-eec-product-position="{{ $productKey }}"
                                               data-gtm-eec-product-list="محصولاتی که شامل این محتوا هستند">
                                                <span class="m-badge m-badge--danger m-badge--dot"></span>
                                                {{ $product->name }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif

    @foreach($contentBlocks as $block)
        @include('block.partials.block', [
        'blockCustomClass'=> 'contentBlock',
        'blockCustomId'=>'sectionId-'.$block->class,
        'blockType'=>(isset($block->sets) && $block->sets->count()>0)?'set':(isset($block->products) && $block->products->count()>0?'product':'content'),
        'blockUrlDisable'=>false,
        ])
    @endforeach
    <div class="AlaaAdDom" alaa-ad-preloadimage="1"></div>
@endsection

@section('page-js')
    <script type="text/javascript" defer>
        var related_videos = [
            @if(!is_null(min(13,$videosWithSameSet->count())))
                @foreach($videosWithSameSet->random( min(13,$videosWithSameSet->count())) as $item)
                    @if($item["content"]->id != $content->id)
                        {!!
                            json_encode([
                                'thumb' => (isset($item["thumbnail"]))?$item["thumbnail"]:"",
                                'url' => action("Web\ContentController@show" , $item["content"]),
                                'title' => ($item["content"]->display_name),
                                'duration' => '20:00'
                            ])
                        !!},
                    @endif
                @endforeach
            @endif
        ];

        (function (w, d, i) {
            var fp = 'https://ads.alaatv.com/js/engine.js',
                l = 'AlaaAdEngine',
                s = 'script',
                da = new Date(),
                v = ''.concat(da.getFullYear(),(da.getMonth()+1),da.getDate(),da.getHours()),
                f = d.getElementsByTagName(s)[0],
                j = d.createElement(s);
            w[l] = w[l] || {};
            w[l].UUID=i;
            j.async = true;
            j.src = fp + '?uuid=' + i + '&v=' + v;
            f.parentNode.insertBefore(j, f);
        })(window, document, '35b39d4b-517b-44bc-85c4-44f93242836f');
    </script>
    <script src="{{ mix("/js/content-show.js") }}" type="text/javascript"></script>
    <script>
        $('.contentBlock').OwlCarouselType2({
            OwlCarousel: {
                center: false,
                loop: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    400: {
                        items: 2
                    },
                    600: {
                        items: 3
                    },
                    800: {
                        items: 4
                    },
                    1000: {
                        items: 5
                    }
                },
                btnSwfitchEvent: function() {
                    imageObserver.observe();
                    gtmEecProductObserver.observe();
                },
                onTranslatedEvent: function(event) {
                    imageObserver.observe();
                    gtmEecProductObserver.observe();
                }
            },
            grid: {
                columnClass: 'col-12 col-sm-6 col-md-3 gridItem',
                btnSwfitchEvent: function() {
                    imageObserver.observe();
                    gtmEecProductObserver.observe();
                }
            },
            defaultView: 'OwlCarousel', // OwlCarousel or grid
            childCountHideOwlCarousel: 4
        });
    </script>
@endsection

