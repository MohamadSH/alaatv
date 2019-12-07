@extends('app')

@section('page-css')
    <link href="{{ mix('/css/page-landing9.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="m-portlet m-portlet--head-overlay m-portlet--full-height  m-portlet--rounded-force">

                <div>
                    <img src="/acm/extra/taftan_landing1.jpg" class="a--full-width">
                </div>
                <div class="m-portlet__body">
                    <div class="m-widget27 m-portlet-fit--sides">
                        <div class="m-widget27__container">
                            {{--<div class="container-fluid m--padding-right-40 m--padding-left-40">

                                <div class="row">
                                    <div class="col text-center">
                                        <h3 class="text-center">
                                            <a href="{{ action("Web\ShopPageController") }}" class="m-link"><span class="m--font-primary">👈همایش ها، کاملا رایگان👉</span></a>
                                        </h3>
                                        برای کسانی که استعداد و تلاش را یکجا به کار گرفته اند
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 mx-auto">
                                        <div class="m-divider m--margin-top-25">
                                            <span></span>
                                            <span>
                                                <h4>
                                                    رتبه زیر 1000 بیار تا:
                                                </h4>
                                            </span>
                                            <span></span>
                                        </div>

                                        <p class="text-center">
                                            <br>
                                            در هر رشته ای و در هر سهمیه ای
                                            <br>
                                            هر هزینه ای که از 26 اردیبهشت تا 18 خرداد 98 در سایت آلاء برای خرید محصولات یا همایش ها پرداخت کرده اید به عنوان بورس و هدیه آلاء به شما برگردد.
                                        </p>

                                        <div class="m--font-boldest text-center">با استعداد و تلاش خودتون، اولین مزد زحماتتون رو از ما بگیرید.</div>

                                        <h5 class="m--margin-top-35 text-center d-none">با آلاء مستحکم در مسیر موفقیت خواهید بود.</h5>

                                        <div class="alert alert-warning text-center m--margin-top-20" role="alert">
                                            <strong>
                                                آلاء با تمام بضاعت خودش، مخاطبین وفادارش رو با بهترین توانایی هاشون به میدان کنکور میفرسته.
                                            </strong>
                                        </div>

                                    </div>
                                </div>

                            </div>--}}


                            @foreach($blocks as $blockKey=>$block)
                                @if($block->products->count() > 0)
                                    @include('block.partials.block', [
                                            'blockCustomClass'=>'landing7Block-'.$blockKey.' a--owl-carousel-type-2 OwlCarouselType2-landing9',
                                            'blockType'=>'product2',
                                            'blockCustomId'=>$block->class
                                        ])
                                @endif
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('page-js')
    <script>
        var sections = [
        @foreach($blocks as $blockKey=>$block)
            @if($block->products->count() > 0)
                'landing7Block-{{ $blockKey }}',
            @endif
        @endforeach
        ];
    </script>
    <script src="{{ mix('/js/page-landing9.js') }}"></script>
@endsection
