@extends('app')

@section('page-css')
    <link href="{{ mix('/css/product-show-RaheAbrisham.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .fa-ban:before {
            content:"\f05e"
        }
    </style>
@endsection

@section('page-head')
    <!-- JSON-LD markup generated by Google Structured Data Markup Helper. -->
    <script type="application/ld+json">
    {
        "@context" : "http://schema.org",
        "@type" : "Product",
        "name" : " {{ $product->name }}",
        "image" : "{{ $product->photo }}?w=400&h=400",
        "sku": "{{ $product->id }}",
        "brand" : {
            "@type" : "Brand",

            "name" : "آلاء",
            "logo": {
                "@type": "ImageObject",
                "url": "https://cdn.alaatv.com/upload/Alaa-logo.png?w=182&h=224"
              }
        },
        "offers" : {
            "@type" : "Offer",
            "price" : "{{ $product->price['final'] }}",
            "priceCurrency" : "IRR",
            "url" : "{{ $product->url }}",
            "availability": "https://schema.org/InStock",
            "itemCondition": "https://schema.org/NewCondition"
        }
    }

    </script>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home m--padding-right-5"></i>
                <a class="m-link" href="{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item">
                <i class="fa fa-chalkboard-teacher"></i>
                <a class="m-link" href="{{ action("Web\ShopPageController") }}">محصولات آموزشی</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#"> {{ $product->name }} </a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')

    <div class="row m--margin-top-25">
        <div class="col">
            @include('systemMessage.flash')
        </div>
    </div>

    @include('product.partials.raheAbrisham.pictureAndMap')

    @include('product.partials.raheAbrisham.descriptionBox', [
        'title' => 'خرید مجدد دوره راه ابریشم',
        'closeIcon' => true,
        'class' => 'RepurchaseRow',
        'content' => view('product.partials.raheAbrisham.repurchase', compact('product'))
    ])

    @include('product.partials.raheAbrisham.descriptionBox', [
        'title' => 'راهنمایی آلایی هایی که تازه ثبت نام کردند',
        'closeIcon' => true,
        'class' => 'helpMessageRow',
        'content' => view('product.partials.raheAbrisham.helpMessage', ['periodDescription'=>$periodDescription]),
    ])

    @include('product.partials.raheAbrisham.entekhabeFarsang')

    <div class="row justify-content-center">
        <div class="col-md-6">
            @include('product.partials.raheAbrisham.descriptionBox', [
                'title' => 'توضیح مراحل راه ابریشم',
                'closeIcon' => true,
                'content' => view('product.partials.raheAbrisham.toziheMarahel'),
                'btnMoreText' => 'مطالعه کامل توضیحات',
            ])
        </div>
        <div class="col-md-6">
            @include('product.partials.raheAbrisham.descriptionBox', [
                'title' => 'راهنمای استفاده از این دوره',
                'closeIcon' => true,
                'content' => view('product.partials.raheAbrisham.rahnamaieEstefadeAzInDore'),
                'btnMoreText' => 'مطالعه کامل توضیحات',
            ])
        </div>
        <div class="col-md-9">
            @include('product.partials.raheAbrisham.descriptionBox', [
                'title' => 'نحوه دریافت هدایای ارزشمند آموزشی ویژه شما عزیزان',
                'closeIcon' => true,
                'content' => view('product.partials.raheAbrisham.nahveDariaftHadaia'),
            ])
        </div>
    </div>

    @include('product.partials.raheAbrisham.descriptionBox', [
        'title' => 'سوالات متداول درباره این دوره',
        'color' => 'transparentBack',
        'content' => view('product.partials.raheAbrisham.soalateMotedavel', compact('faqs'))
    ])



    @include('product.partials.raheAbrisham.descriptionBox', [
        'title' => 'توضیحات لحظه ای و آخرین تغییرات',
        'class' => 'liveDescriptionRow',
        'color' => 'red',
        'content' => view('product.partials.raheAbrisham.liveDescription', compact('liveDescriptions')),
        'btnMoreText' => (count($liveDescriptions)>1)?'مطالعه اخبار قبلی':false,
        'btnMoreClass' => 'showMoreLiveDescriptions',
    ])

@endsection

@section('page-js')
    <script>
        var TotalQuantityAddedToCart = 0;
        var parentProduct = {
            id : '{{ $product->id }}',
            name : '{{ $product->name }}',
            price : '{{ number_format($product->price['final'], 2, '.', '') }}',
            brand: 'آلاء',
            category : '-',
            variant : '{{ $product->type['hint'] }}',
            quantity: 1
        };
        var parentProductTags = '{{ ($product->tags !== null) ? implode(',',optional($product->tags)->tags) : '-' }}';
        var allSetsOfRaheAbrisham = [
                @foreach($sets as $setItem)
            {
                name: '{{$setItem->name}}',
                setId: {{$setItem->id}}
            },
            @endforeach
        ];
        var lastSetData = {
            set: {
                id: '{{$lastSet->id}}',
                name: '{{$lastSet->name}}',
                url: {
                    web: '{{$lastSet->show_url}}'
                }
            },
            files: {
                pamphlets: [

                    @foreach($lastSetPamphlets as $item)
                    {
                        name: '{{$item->name}}',
                        file: {
                            pamphlet: [
                                {
                                    link: '{{$item->file->first()->first()->link}}'
                                }
                            ]
                        },
                        @if(isset($item->section))
                        section: {
                            id: '{{$item->section_id}}',
                            name: '{{$item->section->name}}'
                        }
                        @endif
                    },
                    @endforeach
                ],
                videos: [

                    @foreach($lastSetVideos as $item)
                    {
                        title: '{{$item->name}}',
                            thumbnail: '{{$item->thumbnail}}',
                            url: {
                            web: '{{$item->url}}'
                        },
                        @if(isset($item->section))
                        section: {
                            id: '{{$item->section_id}}',
                            name: '{{$item->section->name}}'
                        }
                        @endif
                    },
                    @endforeach
                ]
            }
        };
    </script>
    <script src="{{ mix('/js/product-show-RaheAbrisham.js') }}"></script>
@endsection
