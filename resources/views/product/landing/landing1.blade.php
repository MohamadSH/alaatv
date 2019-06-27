@extends('app')

@section('page-css')
    <link href="{{ asset('/acm/AlaatvCustomFiles/components/imageWithCaption/style.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .sideItems .m-widget24__title {
            font-size: 30px !important;
        }

        .sideItems .m-widget24__desc {
            font-size: 15px !important;
        }

        .sideItems .flaticon-pie-chart {
            font-size: 30px !important;
        }
        .m-widget24 .m-widget24__item .m-widget24__stats {
            margin-top: 3.21rem;
        }
        .m-portlet.m-portlet--bordered.m-portlet--unair.portlet--lastPart .m-widget24__title {
            font-size: 1.5em !important;
        }
    </style>
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
                            <img src="/acm/extra/landing1/img/rally.jpg" alt="">
                            <h3 class="m-widget27__title m--font-light">
                                سبقت در پیچ اول رالی کنکور
                            </h3>
                            <div class="m-widget27__btn">
                                <button type="button" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--bolder d-none">
                                    ...
                                </button>
                            </div>
                        </div>
                        <div class="m-widget27__container">

                            <div class="container-fluid m--padding-right-40 m--padding-left-40">
                                <div class="row">
                                    <div class="col-md-3 order-2 order-sm-2 order-md-1 order-lg-1 sideItems">
                                        <div class="m-portlet m-portlet--bordered m-portlet--unair">
                                            <div class="m-portlet__body m--padding-10">
                                                <div class="m-widget24">
                                                    <div class="m-widget24__item">
                                                        <h4 class="m-widget24__title m--font-info">
                                                            ۵ + ۱
                                                        </h4>
                                                        <span class="m-widget24__stats m--font-info">
                                                            <img src="/assets/extra/landing1/img/like.png" style="height: 40px;">
                                                        </span>
                                                        <br>
                                                        <span class="m-widget24__desc">
                                                            هر درس
                                                        </span>
                                                        <div class="m--space-10"></div>
                                                        5 ساعت جمع بندی و نکته و تست داریم و 1 ساعت تست های پلاس مخصوص پزشکا و مهندسا
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet m-portlet--bordered m-portlet--unair">
                                            <div class="m-portlet__body m--padding-10">
                                                <div class="m-widget24">
                                                    <div class="m-widget24__item">
                                                        <h4 class="m-widget24__title m--font-success">
                                                            ۱/۳
                                                        </h4>
                                                        <span class="m-widget24__stats m--font-success">
                                                            <i class="flaticon-pie-chart"></i>
                                                        </span>
                                                        <br>
                                                        <span class="m-widget24__desc">
                                                            جمع بندی یک سوم کنکور
                                                        </span>
                                                        <div class="m--space-10"></div>
                                                        <div class="progress m-progress--sm">
                                                            <div class="progress-bar m--bg-success" role="progressbar" style="width: 33.33%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <span class="m-widget24__change">
                                                            کنکور
                                                        </span>
                                                        <span class="m-widget24__number">
                                                            ۳۳%
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet m-portlet--bordered m-portlet--unair portlet--lastPart">
                                            <div class="m-portlet__body m--padding-10">
                                                <div class="m-widget24">
                                                    <div class="m-widget24__item">
                                                        <h4 class="m-widget24__title m--font-warning">
                                                            اساتید آلاء
                                                        </h4>
                                                        <span class="m-widget24__stats m--font-warning">
                                                            <img src="/assets/extra/landing1/img/teacher-128.png" style="height: 40px;">
                                                        </span>
                                                        <br>
                                                        <span class="m-widget24__desc">
                                                            اساتیدی که می شناسید
                                                        </span>
                                                        <div class="m--space-10"></div>
                                                        <div class="progress m-progress--sm">
                                                            <div class="progress-bar m--bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <span class="m-widget24__change">
                                                            همه اساتید
                                                        </span>
                                                        <span class="m-widget24__number">
                                                            100%
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9 order-1 order-sm-1 order-md-2 order-lg-2">

                                        <div class="row justify-content-center">
                                            @foreach( $landingProducts as $product)
                                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 m--padding-left-5 m--padding-right-5 m--margin-top-5">
                                                    <div class="a--imageWithCaption">
                                                        @if(isset($product["product"]->image[0]))
                                                            <img src="{{$product["product"]->photo}}" alt="عکس محصول@if(isset($product["product"]->name[0])) {{$product["product"]->name}} @endif" class="img-thumbnail lazy-image">
                                                        @endif
        
                                                        
                                                        <a href="{{$product["product"]->url ?? '#'}}">
                                                            <div class="a--imageCaptionWarper">
                                                                <div class="a--imageCaptionContent">
                                                                    <div class="a--imageCaptionTitle">
                                                                        {{$product["product"]->name ?? '--'}}
                                                                    </div>
                                                                    <div class="a--imageCaptionDescription">
                                                                        <br>
                                                                        @if($product["product"]->isFree)
                                                                            <div class="cbp-l-caption-desc  bold m--font-danger product-potfolio-free">رایگان</div>
                                                                        @elseif($product["product"]->basePrice == 0)
                                                                            <div class="cbp-l-caption-desc  bold m--font-info product-potfolio-no-cost">قیمت: پس از انتخاب محصول</div>
                                                                        @elseif($product["product"]->price['discount'] > 0)
                                                                            @include('product.partials.price',['price' => $product["product"]->price])
                                                                        @else
                                                                            @include('product.partials.price',['price' => $product["product"]->price])
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    
                                                    <div class="text-center">
                                                        <a href="{{$product["product"]->url ?? '#'}}">
                                                            <button type="button" class="btn btn-sm m-btn--air btn-accent a--full-width m--margin-bottom-10">
                                                                خرید همایش
                                                            </button>
                                                        </a>
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
