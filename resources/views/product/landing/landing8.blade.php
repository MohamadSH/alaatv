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


        .m-portlet--creative .m-portlet__head-caption {
            width: 100%;
            text-align: center;
        }
        .m-portlet--creative .m-portlet__head {
            height: 0px !important;
        }
        .m-widget27 .m-widget27__pic::before {
            background: none;
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
                                    <div class="col-md-4 order-2 order-sm-2 order-md-1 order-lg-1 sideItems">
                                        
                                        <div class="m-portlet m-portlet--creative m-portlet--first m-portlet--bordered-semi">
                                            <div class="m-portlet__head">
                                                <div class="m-portlet__head-caption">
                                                    <div class="m-portlet__head-title">
                                                        <h2 class="m-portlet__head-label m-portlet__head-label--info">
                                                            <span>
                                                                همایش طلایی آلاء
                                                            </span>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-portlet__body">
            
                                                <span class="m-badge m-badge--danger m-badge--dot"></span>
                                                جمع بندی حداقل 80 درصد مباحث کنکور
                                                <br>
                                                <span class="m-badge m-badge--danger m-badge--dot"></span>
                                                حل تست های فراوان آموزشی و نکته دار
                                                <br>
                                                <span class="m-badge m-badge--danger m-badge--dot"></span>
                                                پیش بینی و بررسی تست های احتمالی کنکور
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
                                                همایش طلایی؛ یک نقشه راه مطمئن، از مسیری کوتاه و قابل اعتماد برای موفقیت تا روز کنکور است.
                                                
                                            </div>
                                        </div>
    
                                        <div class="m-portlet m-portlet--creative m-portlet--first m-portlet--bordered-semi m--margin-top-50">
                                            <div class="m-portlet__head">
                                                <div class="m-portlet__head-caption">
                                                    <div class="m-portlet__head-title">
                                                        <h2 class="m-portlet__head-label m-portlet__head-label--info">
                                                            <span>
                                                                همایش های طلایی آلاء
                                                            </span>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-portlet__body">
    
                                                <span class="m-badge m-badge--danger m-badge--dot"></span>
                                                هنوز خودتون رو توی بزرگراه رقابت کنکور نمی بینید
                                                <br>
                                                <span class="m-badge m-badge--danger m-badge--dot"></span>
                                                ویا در مسیر هستید اما سرعت مناسبی ندارید
                                                <br>
                                                <span class="m-badge m-badge--danger m-badge--dot"></span>
                                                و یا نیاز به یک جمع بندی تمام کننده دارید

                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-8 order-1 order-sm-1 order-md-2 order-lg-2">
                                        
                                        <div class="row justify-content-center">
                                            @foreach( $landingProducts as $product)
                                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 m--padding-left-5 m--padding-right-5 m--margin-top-5 a--imageWithCaption @foreach ($product["majors"] as $major) {{ $major }} @endforeach">
                                                    @if(isset($product["product"]->image[0]))
                                                        <img src="{{$product["product"]->photo}}" alt="عکس محصول@if(isset($product["product"]->name[0])) {{$product["product"]->name}} @endif" class="img-thumbnail">
                                                    @endif
                                                    <a href="{{$product["product"]->url ?? '#'}}">
                                                        <div class="a--imageCaptionWarper">
                                                            <div class="a--imageCaptionContent">
                                                                <div class="a--imageCaptionTitle">
                                                                    {{$product["product"]->name ?? '--'}}
                                                                </div>
                                                                <div class="a--imageCaptionDescription">
                                                                    ثبت نام در همایش
                                                                    <br>
                                                                    @if($product["product"]->isFree)
                                                                        <div class="cbp-l-caption-desc  bold m--font-danger product-potfolio-free">رایگان
                                                                        </div>
                                                                    @elseif($product["product"]->basePrice == 0)
                                                                        <div class="cbp-l-caption-desc  bold m--font-info product-potfolio-no-cost">قیمت: پس از انتخاب محصول
                                                                        </div>
                                                                    @elseif($costCollection[$product["product"]->id]["productDiscount"]+$costCollection[$product["product"]->id]["bonDiscount"]>0)
                                                                        <div class="cbp-l-caption-desc  bold m--font-danger product-potfolio-real-cost">@if(isset($costCollection[$product["product"]->id]["cost"])){{number_format($costCollection[$product["product"]->id]["cost"])}}تومان@endif</div>
                                                                        <div class="cbp-l-caption-desc  bold font-green product-potfolio-discount-cost">فقط @if(Auth::check()) {{number_format((1 - ($costCollection[$product["product"]->id]["bonDiscount"] / 100)) * ((1 - ($costCollection[$product["product"]->id]["productDiscount"] / 100)) * $costCollection[$product["product"]->id]["cost"]))}} @else @if(isset($costCollection[$product["product"]->id]["cost"])){{number_format(((1-($costCollection[$product["product"]->id]["productDiscount"]/100))*$costCollection[$product["product"]->id]["cost"]))}}تومان@endif @endif</div>
                                                                    @else
                                                                        <div class="cbp-l-caption-desc bold font-green product-potfolio-no-discount">@if(isset($costCollection[$product["product"]->id]["cost"])){{number_format($costCollection[$product["product"]->id]["cost"])}}تومان@endif </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
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
