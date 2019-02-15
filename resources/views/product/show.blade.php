@extends("app")
@section('page-css')
    <style>
        /*fix rtl*/
        .m-checkbox>span:after {
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
        }
    </style>
    <style>
        /*fix IRANSans font for select input*/
        .form-control {
            font-family: IRANSans;
            font-size: 11px;
        }
    </style>
    <style>
        /*missed css*/
        .m-widget4__item.m-widget4__item--last, .m-widget4__item:last-child {
            border-bottom: 0;
        }
    </style>
    <style>
        /*media query*/
        @media (max-width: 767.98px) {
            .m-portlet__body {
                padding: 5px !important;
            }
            .m-demo__preview {
                padding: 0px !important;
            }
        }
    </style>

    <style>
        /*product page css*/
        .productGifts img {
            max-width: 100%;
        }
        .productGifts {
            text-align: center;
        }
    </style>
    <link href = "{{ mix('/css/product-show/product-show.css') }}" rel = "stylesheet" type = "text/css"/>
@endsection

@section("pageBar")
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "flaticon-home-2 m--padding-right-5"></i>
                <a class = "m-link" href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item">
                <i class = "flaticon-photo-camera m--padding-right-5"></i>
                <a class = "m-link" href = "{{ action("Web\ProductController@index") }}">محصولات آموزشی</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#"> {{ $product->name }} </a>
            </li>
        </ol>
    </nav>
@endsection
@section("content")
    @include("systemMessage.flash")
    <div class = "row" id="a_top_section">
        <div class = "col-xl-12">
            <!--begin::Portlet-->
            <div class = "m-portlet m-portlet--mobile">
                <div class = "m-portlet__body">
                    <!--begin::Section-->
                    <div class = "m-section m-section--last">
                        <div class = "m-section__content">
                            <!--begin::Preview-->
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <div class = "m--margin-bottom-45">
                                        <img src = "{{ route('image', ['category'=>'4','w'=>'338' , 'h'=>'338' ,  'filename' =>  $product->image ]) }}" alt = "عکس محصول@if(isset($product->name)) {{$product->name}} @endif" class = "img-fluid m--marginless"/>
                                    </div>

                                    @if(isset($product->introVideo) || $product->gift->isNotEmpty())
                                        {{--نمونه جزوه--}}
                                        @include('product.partials.pamphlet')
                                    @endif

                                </div>
                                <div class = "col">

                                    {{--ویژگی ها و دارای --}}
                                    <div class="row">
                                        @if(optional(optional($product->attributes->get('information'))->where('control', 'simple'))->count()>0 || optional($product->attributes->get('main'))->where('control', 'simple')->count()>0)
                                            <div class="col">

                                                <div class="m-portlet">
                                                    <div class="m-portlet__head">
                                                        <div class="m-portlet__head-caption">
                                                            <div class="m-portlet__head-title">
                                                                <h3 class="m-portlet__head-text">
                                                                    ویژگی ها
                                                                </h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="m-portlet__body m--padding-top-5 m--padding-bottom-5">
                                                        <!--begin::m-widget4-->
                                                        <div class="m-widget4">

                                                            @if(optional(optional($product->attributes->get('information'))->where('control', 'simple'))->count())
                                                                @foreach($product->attributes->get('information')->where('control', 'simple') as $key => $informationItem)

                                                                    <div class="m-widget4__item  m--padding-top-5 m--padding-bottom-5">
                                                                        <div class="m-widget4__img m-widget4__img--icon">
                                                                            <i class = "flaticon-like m--font-info"></i>
                                                                        </div>
                                                                        <div class="m-widget4__info">
                                                                            <span class="m-widget4__text">
                                                                                {{ $informationItem->title . ': ' . $informationItem->data[0]->name }}
                                                                            </span>
                                                                        </div>
                                                                    </div>

                                                                @endforeach
                                                            @endif

                                                            @if(optional($product->attributes->get('main')) != null && optional($product->attributes->get('main'))->where('control', 'simple'))
                                                                @foreach($product->attributes->get('main')->where('control', 'simple') as $key => $informationItem)

                                                                    <div class="m-widget4__item m--padding-top-5 m--padding-bottom-5">
                                                                        <div class="m-widget4__img m-widget4__img--icon">
                                                                            <i class = "flaticon-like m--font-warning"></i>
                                                                        </div>
                                                                        <div class="m-widget4__info">
                                                                            <span class="m-widget4__text">
                                                                                {{ $informationItem->title . ': ' . $informationItem->data[0]->name }}
                                                                            </span>
                                                                        </div>

                                                                        @foreach($informationItem->data as $k => $info)
                                                                            @if(isset($info->id))
                                                                                <input type = "hidden" value = "{{ $info->id }}" name = "attribute[]">
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                @endforeach
                                                            @endif

                                                        </div>
                                                        <!--end::Widget 9-->
                                                    </div>
                                                </div>

                                            </div>
                                        @endif
                                        @if(optional(optional($product->attributes->get('information'))->where('control', 'checkBox'))->count())
                                            <div class="col">

                                                <div class="m-portlet">
                                                    <div class="m-portlet__head">
                                                        <div class="m-portlet__head-caption">
                                                            <div class="m-portlet__head-title">
                                                                <h3 class="m-portlet__head-text">
                                                                    دارای
                                                                </h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="m-portlet__body m--padding-top-5 m--padding-bottom-5">
                                                        <!--begin::m-widget4-->
                                                        <div class="m-widget4">

                                                            @foreach($product->attributes->get('information')->where('control', 'checkBox') as $key => $informationItem)
                                                                <div class="m-widget4__item  m--padding-top-5 m--padding-bottom-5">
                                                                    <div class="m-widget4__img m-widget4__img--icon">
                                                                        <i class="fa fa-check"></i>
                                                                    </div>
                                                                    <div class="m-widget4__info">
                                                                                    <span class="m-widget4__text">
                                                                                        {{ $informationItem->title . ': ' . $informationItem->data[0]->name }}
                                                                                    </span>
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                        </div>
                                                        <!--end::Widget 9-->
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    {{--خدمات اضافی--}}
                                    @if(optional($product->attributes->get('extra'))->count())
                                        <div class="m-portlet m-portlet--creative m-portlet--bordered-semi">
                                            <div class="m-portlet__head">
                                                <div class="m-portlet__head-caption col">
                                                    <div class="m-portlet__head-title">
                                                                    <span class="m-portlet__head-icon">
                                                                        <i class="flaticon-confetti"></i>
                                                                    </span>
                                                        <h3 class="m-portlet__head-text">
                                                            خدماتی که برای این محصول نیاز دارید را انتخاب کنید:
                                                        </h3>
                                                        <h2 class="m-portlet__head-label m-portlet__head-label--warning">
                                                            <span>خدمات</span>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-portlet__body">

                                                @include("product.partials.extraSelectCollection")
                                                @include("product.partials.extraCheckboxCollection" , ["withExtraCost"])

                                            </div>
                                        </div>
                                    @endif

                                    {{--محصول ساده یا قابل پیکربندی و یا قابل انتخاب--}}
                                    @if(in_array($product->type['id'] ,[config("constants.PRODUCT_TYPE_SELECTABLE")]))
                                        <div class="m-portlet m-portlet--creative m-portlet--bordered-semi">
                                            <div class="m-portlet__head">
                                                <div class="m-portlet__head-caption col">
                                                    <div class="m-portlet__head-title">
                                                                <span class="m-portlet__head-icon">
                                                                    <i class="flaticon-multimedia-5"></i>
                                                                </span>
                                                        <h3 class="m-portlet__head-text">
                                                            موارد مورد نظر خود را انتخاب کنید:
                                                        </h3>
                                                        <h2 class="m-portlet__head-label m-portlet__head-label--info">
                                                            <span>انتخاب محصول</span>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-portlet__body">

                                                <ul class = "m-nav m-nav--active-bg" id = "m_nav" role = "tablist">
                                                    @if(isset($product->children) && !empty($product->children))
                                                        @foreach($product->children as $p)
                                                            @include('product.partials.showChildren',['product' => $p , 'color' => 1])
                                                        @endforeach
                                                    @endif
                                                </ul>

                                            </div>
                                        </div>
                                    @elseif(in_array($product->type['id'] ,[Config::get("constants.PRODUCT_TYPE_SIMPLE")]))
                                    @elseif(in_array($product->type['id'], [Config::get("constants.PRODUCT_TYPE_CONFIGURABLE")]))
                                        <div class="m-portlet m-portlet--creative m-portlet--bordered-semi">
                                            <div class="m-portlet__head">
                                                <div class="m-portlet__head-caption col">
                                                    <div class="m-portlet__head-title">
                                                                <span class="m-portlet__head-icon">
                                                                    <i class="flaticon-settings-1"></i>
                                                                </span>
                                                        <h3 class="m-portlet__head-text">
                                                            ویژگی های مورد نظر خود را انتخاب کنید:
                                                        </h3>
                                                        <h2 class="m-portlet__head-label m-portlet__head-label--info">
                                                            <span>ویژگی های محصول</span>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-portlet__body">

                                                @if(optional(optional($product->attributes->get('main'))->where('type', 'main'))->count()>0)

                                                    @if($product->attributes->get('main')->where('type', 'main')->where('control', 'dropDown')->count()>0)
                                                        @foreach($product->attributes->get('main')->where('type', 'main')->where('control', 'dropDown') as $index => $select)

                                                            <div class="form-group m-form__group">
                                                                <label for="exampleSelect1">{{ $select->title }}</label>
                                                                <select name="attribute[]"  class="form-control m-input attribute">
                                                                    @foreach($select->data as $dropdownIndex => $dropdownOption)
                                                                        <option value="{{ $dropdownOption->id }}">{{ $dropdownOption->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                        @endforeach
                                                    @endif


                                                    @if($product->attributes->get('main')->where('type', 'main')->where('control', 'checkBox')->count()>0)
                                                        @foreach($product->attributes->get('main')->where('type', 'main')->where('control', 'checkBox') as $index => $select)

                                                            <label class="m-checkbox m-checkbox--air m-checkbox--state-success">
                                                                <input type="checkbox" name="attribute[]" value="{{ $select->data[0]->id }}" class="attribute">
                                                                {{ $select->data[0]->name }}
                                                                <span></span>
                                                            </label>

                                                        @endforeach
                                                    @endif

                                                    @if(isset($groupedCheckboxCollection))
                                                        <div class="input-group">
                                                            <div class="icheck-list">
                                                                @foreach($groupedCheckboxCollection as $checkboxArray)
                                                                    @foreach($checkboxArray as $index => $checkbox)
                                                                        <label>
                                                                            {!! Form::checkbox('attribute[]', $index, null, ['class' => 'attribute icheck' , 'data-checkbox'=>'icheckbox_square-blue']) !!}
                                                                            @if(isset($checkbox["index"])) {{$checkbox["index"]}} @endif
                                                                            @if(isset($checkbox["extraCost"][0]))
                                                                                (
                                                                                <span style="@if(isset($checkbox["extraCostWithDiscount"][0])) text-decoration: line-through;  @endif">{{$checkbox["extraCost"]}}</span>
                                                                                @if(isset($checkbox["extraCostWithDiscount"][0]))
                                                                                    <span class="bg-font-dark"
                                                                                          style="background: #ff7272;    padding: 0px 5px 0px 5px;">برای شما </span>
                                                                                    <span class="bg-font-dark"
                                                                                          style="background: #ee5053;    padding: 0px 5px 0px 5px;">{{$checkbox["extraCostWithDiscount"]}}</span>
                                                                                @endif
                                                                            @endif
                                                                        </label>
                                                                    @endforeach
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif

                                                @endif

                                            </div>
                                        </div>
                                    @endif

                                    {!! Form::hidden('product_id',$product->id) !!}

                                    {{--دکمه افزودن به سبد خرید--}}
                                    @if($product->enable)
                                        <h5 class="m--font-danger">
                                                    <span id="a_product-price">
                                                        {{ $product->priceText }}
                                                    </span>
                                            <span id = "a_product-discount"></span>
                                        </h5>

                                        <button class="btn m-btn--pill m-btn--air btn-primary btn-lg m-btn--icon btnAddToCart">
                                            <span>
                                                <i class="flaticon-shopping-basket"></i>
                                                <i class="fas fa-sync-alt fa-spin" style="display: none;"></i>
                                                <span>افزودن به سبد خرید</span>
                                            </span>
                                        </button>
                                    @else
                                        <button class="btn btn-danger btn-lg m-btn  m-btn m-btn--icon">
                                                    <span>
                                                        <i class="flaticon-shopping-basket"></i>
                                                        <span>این محصول غیر فعال است.</span>
                                                    </span>
                                        </button>
                                    @endif

                                </div>

                                <div class="col-lg-3">
                                    @if(isset($product->introVideo))
                                        <div class="m-portlet m-portlet--bordered-semi m-portlet--rounded-force m--margin-bottom-45">
                                                <div class="m-portlet__head m-portlet__head--fit"></div>
                                                <div class="m-portlet__body m--padding-bottom-5">
                                                    <div class="m-widget19">
                                                        <div class="m-widget19__pic m-portlet-fit--top m-portlet-fit--sides"
                                                             style="min-height-: 286px">

                                                            <video id="videoPlayer"
                                                                   class="video-js vjs-fluid vjs-default-skin vjs-big-play-centered"
                                                                   controls
                                                                   preload="auto"
                                                                   style="width: 100%"
                                                                   poster='https://cdn.sanatisharif.ir/media/204/240p/204054ssnv.jpg'>

                                                                <source src="{{$product->introVideo}}" id="videoPlayerSource" type='video/mp4' />

                                                                <p class="vjs-no-js">جهت پخش آنلاین فیلم، ابتدا مطمئن شوید که جاوا اسکریپت در مرور
                                                                    گر شما فعال است و از آخرین نسخه ی مرورگر استفاده می کنید.</p>
                                                            </video>


                                                            {{--<video controls style="width: 100%">--}}
                                                            {{--<source src="{{$product->introVideo}}" type="video/mp4">--}}
                                                            {{--<span class="bold font-red">مرورگر شما HTML5 را پشتیبانی نمی کند</span>--}}
                                                            {{--</video>--}}

                                                            <div class="m-widget19__shadow"></div>
                                                        </div>
                                                        <div class="m-widget19__content">
                                                            <div class="m-widget19__header">
                                                                <h4 id="videoPlayerTitle">
                                                                    کلیپ معرفی
                                                                </h4>
                                                            </div>
                                                            <div class="m-widget19__body text-left" id="videoPlayerDescription">
                                                                {{----}}
                                                                {{--Lorem Ipsum is simply dummy text of the printing and--}}
                                                                {{--typesetting industry scrambled it to make text of the--}}
                                                                {{--printing and typesetting industry scrambled a type--}}
                                                                {{--specimen book text of the dummy text of the printing--}}
                                                                {{--printing and typesetting industry scrambled dummy text--}}
                                                                {{--of the printing.--}}
                                                                {{--<button type="button"--}}
                                                                        {{--class="btn m-btn m-btn--pill m-btn--air m-btn--gradient-from-focus m-btn--gradient-to-danger"--}}
                                                                        {{--id="btnShowVideoLink"--}}
                                                                        {{--data-videosrc=""--}}
                                                                        {{--data-videotitle=""--}}
                                                                        {{--data-videodes="">--}}
                                                                    {{--<span>--}}
                                                                        {{--<i class="fa fa-play-circle"></i>--}}
                                                                        {{--<span>پخش</span>--}}
                                                                    {{--</span>--}}
                                                                {{--</button>--}}

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    @endif
                                    @if(isset($product->gift) && $product->gift->isNotEmpty())
                                        <div class="m-portlet m-portlet--creative m-portlet--bordered-semi m--margin-top-25">
                                            <div class="m-portlet__head">
                                                <div class="m-portlet__head-caption col">
                                                    <div class="m-portlet__head-title">
                                                        <span class="m-portlet__head-icon">
                                                            <i class="flaticon-gift"></i>
                                                        </span>
                                                        <h3 class="m-portlet__head-text">
                                                            این محصول شامل هدایای زیر می باشد:
                                                        </h3>
                                                        <h2 class="m-portlet__head-label m-portlet__head-label--accent">
                                                            <span>هدایا</span>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-portlet__body">
                                                <div class="row justify-content-center productGifts">
                                                    @foreach($product->gift as $gift)
                                                        <div class="col-12">
                                                            @if(strlen($gift->url)>0)
                                                                <a target="_blank" href="{{ $gift->url }}">
                                                                    <div>
                                                                        <img src="{{ $gift->photo }}" class="rounded-circle">
                                                                    </div>
                                                                    <div>
                                                                        <button type="button" class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-info m-btn--gradient-to-accent">
                                                                            {{ $gift->name }}
                                                                        </button>
                                                                    </div>
                                                                </a>
                                                            @else
                                                                <div>
                                                                    <img src="{{ $gift->photo }}" class="rounded-circle">
                                                                </div>
                                                                <div>
                                                                    <button type="button" class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-info m-btn--gradient-to-accent">
                                                                        {{ $gift->name }}
                                                                    </button>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!isset($product->introVideo) && $product->gift->isEmpty())
                                        {{--نمونه جزوه--}}
                                        @include('product.partials.pamphlet')
                                    @endif
                                </div>
                            </div>
                            <!--end::Preview-->
                        </div>
                    </div>
                    <!--end::Section-->
                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
    @if(isset($product->specialDescription))
        <div class = "row">
            {!! $product->specialDescription !!}
        </div>
    @endif
    <div class = "row">
        <div class = "col">

            {{--<div class="m-portlet m-portlet--tabs">--}}
                {{--<div class="m-portlet__head">--}}
                    {{--<div class="m-portlet__head-tools">--}}
                        {{--<ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand  m-tabs-line--right m-tabs-line-danger" role="tablist">--}}
                            {{--<li class="nav-item m-tabs__item">--}}
                                {{--<a class="nav-link m-tabs__link active show" data-toggle="tab" href="#productInformation" role="tab" aria-selected="true">--}}
                                    {{--<i class="flaticon-information"></i>--}}
                                    {{--<h5>بررسی محصول {{ $product->name }}</h5>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    {{--<div class="m-portlet__head-caption">--}}
                        {{--<div class="m-portlet__head-title">--}}
                            {{--<button class="btn m-btn--pill m-btn--air btn-primary btn-lg m-btn--icon btnAddToCart">--}}
                                            {{--<span>--}}
                                                {{--<i class="flaticon-shopping-basket"></i>--}}
                                                {{--<i class="fas fa-sync-alt fa-spin" style="display: none;"></i>--}}
                                                {{--<span>افزودن به سبد خرید</span>--}}
                                            {{--</span>--}}
                            {{--</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="m-portlet__body">--}}
                    {{--<div class="tab-content">--}}
                        {{--<div class="tab-pane active show" id="productInformation">--}}
                            {{--{!! $product->shortDescription !!}--}}
                            {{--@if( isset($product->longDescription[0] ) )--}}
                                {{--<div>--}}
                                    {{--{!!   $product->longDescription !!}--}}
                                {{--</div>--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

















            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-progress">
                        <div class="progress m-progress--sm">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="m-portlet__head-wrapper">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-notepad"></i>
						</span>
                                <h3 class="m-portlet__head-text">
                                    بررسی محصول {{ $product->name }}
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary  m-btn m-btn--icon m-btn--wide m-btn--md btnAddToCart">
                                    <span>
                                        <i class="flaticon-shopping-basket"></i>
                                        <span>افزودن به سبد خرید</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <form class="m-form m-form--label-align-left- m-form--state-" id="m_form">
                        <!--begin: Form Body -->
                        <div class="m-portlet__body">
                            <div class="row">
                                <div class="col-xl-8 offset-xl-2">
                                    {!! $product->shortDescription !!}
                                    @if( isset($product->longDescription[0] ) )
                                        <div>
                                            {!!   $product->longDescription !!}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <!--end::Portlet-->
        </div>
    </div>
@endsection
@section("page-js")
    {{--<script src="{{ mix('/js/product-show.js') }}"></script>--}}
    <script src="{{ asset('/acm/product-show-v13.js') }}"></script>
    {{--<script src="{{ asset('/acm/page-product-show.js') }}"></script>--}}
    <script src="{{ asset('/acm/page-product-saveCookie.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.js-selectProduct-single').select2({
                placeholder: 'یک محصول را انتخاب کنید:'
            });

            var player = null;

            player = videojs('videoPlayer',{nuevo : true} ,function(){
                this.nuevoPlugin({
                    // plugin options here
                    logocontrolbar: '/assets/extra/Alaa-logo.gif',
                    logourl: '//sanatisharif.ir',

                    videoInfo: true,
                    relatedMenu: true,
                    zoomMenu: true,
                    mirrorButton: true,
                    // related: related_videos,
                    // endAction: 'related',
                });
            });

            $(document).on('click', '.btnShowVideoLink', function() {
                var videoSrc = $(this).attr('data-videosrc');
                var videoTitle = $(this).attr('data-videotitle');
                var videoDescription = $(this).attr('data-videodes');
                var sources = [{"type": "video/mp4", "src": videoSrc}];

                $("#videoPlayer").find("#videosrc").attr("src", videoSrc);
                $("#videoPlayerTitle").html(videoTitle);
                $("#videoPlayerDescription").html(videoDescription);

                player.pause();
                player.src(sources);
                player.load();
                // $("html, body").animate({ scrollTop: 0 }, "slow");
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#videoPlayer").offset().top
                }, "slow");
            });
        });
        $(document).ready(function() {
            $("#lightgallery").lightGallery();
        });
    </script>



@endsection