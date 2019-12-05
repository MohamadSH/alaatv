@extends('app')

@section('page-css')
    <link href="{{ mix('/css/page-landing8.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="m-portlet m-portlet--head-overlay m-portlet--full-height  m-portlet--rounded-force">
                <div class="m-portlet__head m-portlet__head--fit-">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text m--font-light d-none">
                                ...
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools"></div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-widget27 m-portlet-fit--sides">
                        <div class="m-widget27__pic">
                            <img src="https://cdn.alaatv.com/upload/landing8_banner2.jpg" alt="" class="lazy-image">
                            <h3 class="m-widget27__title m--font-light">

                            </h3>
                            <div class="m-widget27__btn">
                                <button type="button" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--bolder d-none">
                                    ...
                                </button>
                            </div>
                        </div>
                        <div class="m-widget27__container">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-4 order-2 order-sm-2 order-md-1 order-lg-1 sideItems">


                                        <div class="row justify-content-center">
                                            <div class="col m--margin-bottom-30">
                                                <div class="lessonsTimesWraper">
                                                    <div class="lessonsTimesWraper-header">
                                                        <div class="lessonsTimesWraper-header-top">
                                                            <img src="https://cdn.alaatv.com/upload/Alaa-logo-free.png" alt="آلاء">
                                                        </div>
                                                        <div class="lessonsTimesWraper-header-bottom">
                                                            <h2>همایش های گدار آلاء</h2>
                                                            <br>
                                                            <span class="lessonsTimesWraper-header-bottom-slogan">
                                                               جمع بندی نیم سال اول دوازدهم
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="lessonsTimesWraper-body">
                                                        <table>
                                                            <tbody>
                                                            @foreach( $productHoures as $item)
                                                                <tr onclick="window.location.href = '{{ $item['url'] }}';">
                                                                    <td>
                                                                        <a href="{{ $item['url'] }}">
                                                                            {{ $item['name'] }}
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ $item['url'] }}">
                                                                            @if($item['hours'] == 0)
                                                                                به زودی
                                                                            @else
                                                                                {{ $item['hours'] }} ساعت
                                                                            @endif
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="lessonsTimesWraper-footer">
                                                        <div class="lessonsTimesWraper-footer-slogan animated infinite pulse">
                                                            همایش های
                                                            <br>
                                                            کنکوری
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="m-portlet m-portlet--creative m-portlet--first m-portlet--bordered-semi">
                                            <div class="m-portlet__head">
                                                <div class="m-portlet__head-caption">
                                                    <div class="m-portlet__head-title">
                                                        <h2 class="m-portlet__head-label m-portlet__head-label--info">
                                                            <span>
                                                                همایش گدار آلاء
                                                            </span>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-portlet__body">

                                                <span class="m-badge m-badge--danger m-badge--dot"></span>
                                                جمع بندی کنکوری نیمسال اول دوازدهم
                                                <br>
                                                <span class="m-badge m-badge--danger m-badge--dot"></span>
                                                حل تست های فراوان آموزشی و مهارتی
                                                <br>
                                                <span class="m-badge m-badge--danger m-badge--dot"></span>
                                                مناسب برای آزمون های آزمایشی دی و فروردین
                                                <br>
                                                <span class="m-badge m-badge--danger m-badge--dot"></span>
                                                مناسب برای آزمون های دی ماه مدارس
                                                <br>
                                                <span class="m-badge m-badge--danger m-badge--dot"></span>
                                                یک منبع کامل و مورد اعتماد

                                            </div>
                                        </div>

                                        <div class="m-portlet m-portlet--creative m-portlet--first m-portlet--bordered-semi m--margin-top-50">
                                            <div class="m-portlet__head">
                                                <div class="m-portlet__head-caption">
                                                    <div class="m-portlet__head-title">
                                                        <h2 class="m-portlet__head-label m-portlet__head-label--info">
                                                            <span>
                                                                برنامه دقیق و منسجم
                                                            </span>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-portlet__body">

                                                <span class="m-badge m-badge--danger m-badge--dot"></span>
                                                همایش گدار؛ یک راه مطمئن، کوتاه و قابل اعتماد برای آغاز مسیر موفقیت در کنکور است.

                                            </div>
                                        </div>

                                        <div class="m-portlet m-portlet--creative m-portlet--first m-portlet--bordered-semi m--margin-top-50">
                                            <div class="m-portlet__head">
                                                <div class="m-portlet__head-caption">
                                                    <div class="m-portlet__head-title">
                                                        <h2 class="m-portlet__head-label m-portlet__head-label--info">
                                                            <span>
                                                                مسیر موفقیت
                                                            </span>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-portlet__body">

                                                <span class="m-badge m-badge--danger m-badge--dot"></span>
                                                هنوز خودت رو توی بزرگراه رقابت کنکور نمی بینی؟
                                                <br>
                                                <span class="m-badge m-badge--danger m-badge--dot"></span>
                                                ویا در مسیر هستی اما سرعت مناسبی نداری؟
                                                <br>
                                                <span class="m-badge m-badge--danger m-badge--dot"></span>
                                                و یا نیاز به یک جمع بندی تمام کننده داری؟
                                                <br>
                                                <br>
                                                <span style="padding: 5px;background: #ff9a17;color: white;font-weight: bold;">این همایش مناسب شماست</span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-8 order-1 order-sm-1 order-md-2 order-lg-2 mainItems">
                                        {{--                                        <div class="row justify-content-center">--}}
                                        {{--                                            <div class="col text-center">--}}
                                        {{--                                                <div class="m-divider m--margin-bottom-30">--}}
                                        {{--                                                    <span></span>--}}
                                        {{--                                                    <span>تا شروع کنکور</span>--}}
                                        {{--                                                    <span></span>--}}
                                        {{--                                                </div>--}}
                                        {{--                                                <div class="konkourTimer"></div>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}

                                        <div class="row justify-content-center">
                                            <div class="col m--margin-bottom-10">
                                                <div class="lessonsTimesWraper">
                                                    <div class="lessonsTimesWraper-header">
                                                        <div class="lessonsTimesWraper-header-top">
                                                            <img src="https://cdn.alaatv.com/upload/Alaa-logo-free.png" alt="آلاء">
                                                        </div>
                                                        <div class="lessonsTimesWraper-header-bottom">
                                                            <h2>همایش های گدار آلاء</h2>
                                                            <br>
                                                            <span class="lessonsTimesWraper-header-bottom-slogan">
                                                                جمع بندی نیم سال اول دوازدهم
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="lessonsTimesWraper-body">
                                                        <table>
                                                            <tbody>
                                                            @foreach( $productHoures as $item)
                                                                <tr onclick="window.location.href = '{{ $item['url'] }}';">
                                                                    <td>
                                                                        <a href="{{ $item['url'] }}">
                                                                            {{ $item['name'] }}
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ $item['url'] }}">
                                                                            @if($item['hours'] == 0)
                                                                                به زودی
                                                                            @else
                                                                                {{ $item['hours'] }} ساعت
                                                                            @endif
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="lessonsTimesWraper-footer">
                                                        <div class="lessonsTimesWraper-footer-slogan animated infinite heartBeat">
                                                            همایش های
                                                            <br>
                                                            کنکوری
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            @foreach( $landingProducts as $productKey=>$product)

                                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 m--padding-left-5 m--padding-right-5 m--margin-top-5">

                                                    <div class="productItem">

                                                        @if($product['product']->price['final'] !== $product['product']->price['base'])
                                                            <div class="ribbon">
                                                                <span>
                                                                    <div class="glow">&nbsp;</div>
                                                                    {{ round((1-($product['product']->price['final']/$product['product']->price['base']))*100) }}%
                                                                    <span>تخفیف</span>
                                                                </span>
                                                            </div>
                                                        @endif

                                                        <div class="a--imageWithCaption">
                                                            @if(isset($product['product']->image[0]))
                                                                <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" data-src="{{$product['product']->photo}}?w=300&h=300" alt="عکس محصول@if(isset($product['product']->name[0])) {{$product['product']->name}} @endif" class="img-thumbnail lazy-image" width="400" height="400">
                                                            @endif


                                                            <a href="{{$product['product']->url ?? '#'}}"
                                                               class="a--gtm-eec-product a--gtm-eec-product-click"
                                                               data-gtm-eec-product-id="{{ $product['product']->id }}"
                                                               data-gtm-eec-product-name="{{ $product['product']->name }}"
                                                               data-gtm-eec-product-price="{{ number_format($product['product']->price['final'], 2, '.', '') }}"
                                                               data-gtm-eec-product-brand="آلاء"
                                                               data-gtm-eec-product-category="-"
                                                               data-gtm-eec-product-variant="-"
                                                               data-gtm-eec-product-position="{{ $productKey }}"
                                                               data-gtm-eec-product-list="لندینگ8-همایش طلایی-80درصد کنکور">
                                                                <div class="a--imageCaptionWarper">
                                                                    <div class="a--imageCaptionContent">
                                                                        <div class="a--imageCaptionTitle">
                                                                            {{$product['product']->name ?? '--'}}
                                                                        </div>
                                                                        <div class="a--imageCaptionDescription">
                                                                            <br>
                                                                            @if($product['product']->isFree)
                                                                                <div class="cbp-l-caption-desc  bold m--font-danger product-potfolio-free">رایگان</div>
                                                                            @elseif($product['product']->basePrice == 0)
                                                                                <div class="cbp-l-caption-desc  bold m--font-info product-potfolio-no-cost">قیمت: پس از انتخاب محصول</div>
                                                                            @elseif($product['product']->price['discount'] > 0)
                                                                                @include('product.partials.price',['price' => $product['product']->price])
                                                                            @else
                                                                                @include('product.partials.price',['price' => $product['product']->price])
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>

                                                        <div class="text-center">
                                                            <a href="{{$product['product']->url ?? '#'}}">
                                                                <button type="button" class="btn btn-sm m-btn--air btn-accent a--full-width m--margin-bottom-10">
                                                                    اطلاعات بیشتر
                                                                </button>
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
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ mix('/js/page-landing8.js') }}"></script>
@endsection
