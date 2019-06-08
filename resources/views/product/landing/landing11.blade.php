@extends('app')

@section('page-css')
    <link href="{{ mix('/css/page-landing7.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .m-portlet__head {
            background: white;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="m-portlet m-portlet--head-overlay m-portlet--full-height  m-portlet--rounded-force">
    
                <div>
                    <img src="https://cdn.sanatisharif.ir/upload/landing/sslide-5.jpg" class="a--full-width">
                </div>
                <div class="m-portlet__body">
                    <div class="m-widget27 m-portlet-fit--sides">
                        <div class="m-widget27__container">
                            <div class="container-fluid m--padding-right-40 m--padding-left-40">
                                
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
                                                    رتبه های زیر ۱۰۰۰ کنکور ۹۸
                                                </h4>
                                            </span>
                                            <span></span>
                                        </div>
                                        <br>
                                        رتبه های زیر ۱۰۰۰ فردای اعلام نتایج با بازگشت سرمایه گذاری خود به صورت نقدی، هزینه ای برای همایش ها یا دیگر محصولات آلاء نپرداخته اند.
                                        <br>
                                        <span class="m-badge m-badge--info m-badge--dot"></span> رتبه‌های مناطق، شاهد و ایثارگر و کشور قابل قبول است
                                        <br>
                                        <span class="m-badge m-badge--info m-badge--dot"></span> آغاز طرح از تاریخ ۲۶ اردیبهشت ۹۸
    
                                        <br>
                                        <br>
                                        
                                        رتبه های زیر ۱۰۰۰ هر سه رشته ریاضی و تجربی و انسانی آلاء در کنکور ۹۸، هزینه تمام محصولات و همایش های خریداری شده از ۲۶ اردیبهشت ۹۸ تا روز کنکور را به عنوان
                                        <span class="m--font-primary">هدیه و بورس تحصیلی سال دوازدهم</span>
                                        دریافت خواهند کرد.
    
                                        <br>
                                        <br>
                                        <div class="m--font-boldest text-center">با استعداد و تلاش خودتون، اولین مزد زحماتتون رو از ما بگیرید.</div>
                                        
                                        <br>
                                        <br>
                                        <h5 class="m--margin-top-35 text-center d-none">با آلاء مستحکم در مسیر موفقیت خواهید بود.</h5>
                                        <br>
    
                                        <div class="alert alert-warning" role="alert">
                                            <strong>
                                                آلاء با تمام بضاعت خودش، مخاطبین وفادارش رو با بهترین توانایی هاشون به میدان کنکور میفرسته.
                                            </strong>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                            </div>
                            
                            <style>
                                .titleSvg {
                                    position: relative;
                                    min-width: 100%;
                                    max-width: 100%;
                                    margin: 0;
                                    padding: 0;
                                }
                                .titleSvg .titleSvg-title {
                                    color: white;
                                    text-align: center;
                                    position: absolute;
                                    top: calc( 50% - 1.4rem );
                                    z-index: 1;
                                    width: 100%;
                                    font-weight: bold;
                                    font-size: 1.4rem;
                                }
                                .titleSvg .titleSvg-svg {
                                    width: 100%;
                                    height: auto;
                                }
                            </style>
    
                            <div class="titleSvg">
        
                                <div class="titleSvg-title">
                                    همایش های آلاء
                                </div>
        
                                <div class="titleSvg-svg">
    
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" viewBox="0 0 1006 175">
                                        <g transform=""><linearGradient id="lg-0.6590519274487807" x1="0" x2="1" y1="0" y2="0">
                                                <stop stop-color="#c200ff" offset="0"></stop>
                                                <stop stop-color="#ff8e14" offset="1"></stop>
                                            </linearGradient><path d="" fill="url(#lg-0.6590519274487807)" opacity="0.4">
                                                <animate attributeName="d" dur="3.125s" repeatCount="indefinite" keyTimes="0;0.333;0.667;1" calcmod="spline" keySplines="0.2 0 0.2 1;0.2 0 0.2 1;0.2 0 0.2 1" begin="0s" values="M0 0M 0 148.3603266419768Q 125.75 167.62691291975392 251.5 163.24870471747494T 503 148.56849626660775T 754.5 160.16133642280226T 1006 163.73616375014524L 1006 27.68251598523709Q 880.25 22.678720998402625 754.5 13.56819858502682T 503 17.352128437561873T 251.5 11.565186448759945T 0 24.022673589027434Z;M0 0M 0 167.37002005622512Q 125.75 155.26552681383168 251.5 149.73654386967158T 503 161.03770745600093T 754.5 166.8170233183639T 1006 166.13528249476548L 1006 22.259634389706846Q 880.25 22.81595481427798 754.5 14.592670430797T 503 18.214765891627366T 251.5 12.158419840129127T 0 20.69613625300704Z;M0 0M 0 151.89140672038525Q 125.75 158.9959041269568 251.5 151.85031653747052T 503 164.78272881462135T 754.5 150.8252429616693T 1006 148.52240901534827L 1006 21.819791615252754Q 880.25 35.43445997858898 754.5 26.58236519339352T 503 17.227453690705673T 251.5 13.114365462149692T 0 10.58495430178425Z;M0 0M 0 148.3603266419768Q 125.75 167.62691291975392 251.5 163.24870471747494T 503 148.56849626660775T 754.5 160.16133642280226T 1006 163.73616375014524L 1006 27.68251598523709Q 880.25 22.678720998402625 754.5 13.56819858502682T 503 17.352128437561873T 251.5 11.565186448759945T 0 24.022673589027434Z"></animate>
                                            </path><path d="" fill="url(#lg-0.6590519274487807)" opacity="0.4">
                                                <animate attributeName="d" dur="3.125s" repeatCount="indefinite" keyTimes="0;0.333;0.667;1" calcmod="spline" keySplines="0.2 0 0.2 1;0.2 0 0.2 1;0.2 0 0.2 1" begin="-0.78125s" values="M0 0M 0 152.7464982893665Q 125.75 162.56173801881687 251.5 161.00015226256815T 503 152.5639564218824T 754.5 155.65906260747693T 1006 167.75676636122898L 1006 22.443219931808898Q 880.25 25.50328753235886 754.5 18.42044865444403T 503 23.798605230849553T 251.5 20.698247081291825T 0 7.971633905967266Z;M0 0M 0 166.75405403748783Q 125.75 159.53029850140786 251.5 150.69012350302864T 503 161.797827897116T 754.5 156.38873939287163T 1006 147.70267042099925L 1006 21.81931660528869Q 880.25 17.842185517502042 754.5 15.615395348872298T 503 20.988111440592732T 251.5 13.462140204080754T 0 15.301701136170479Z;M0 0M 0 167.82945859994697Q 125.75 162.9864857555736 251.5 159.0660236917999T 503 163.06239000345712T 754.5 164.352310707141T 1006 152.88901124317545L 1006 22.09773136843502Q 880.25 26.781132690756685 754.5 17.43165192930202T 503 14.049351688209853T 251.5 25.30538986345462T 0 26.43403384492921Z;M0 0M 0 152.7464982893665Q 125.75 162.56173801881687 251.5 161.00015226256815T 503 152.5639564218824T 754.5 155.65906260747693T 1006 167.75676636122898L 1006 22.443219931808898Q 880.25 25.50328753235886 754.5 18.42044865444403T 503 23.798605230849553T 251.5 20.698247081291825T 0 7.971633905967266Z"></animate>
                                            </path><path d="" fill="url(#lg-0.6590519274487807)" opacity="0.4">
                                                <animate attributeName="d" dur="3.125s" repeatCount="indefinite" keyTimes="0;0.333;0.667;1" calcmod="spline" keySplines="0.2 0 0.2 1;0.2 0 0.2 1;0.2 0 0.2 1" begin="-1.5625s" values="M0 0M 0 162.47351041879784Q 125.75 161.9565598326895 251.5 153.6218040555995T 503 165.0303940314862T 754.5 157.6952939465913T 1006 156.23135110010404L 1006 21.284029454937695Q 880.25 17.66728649340877 754.5 9.433921219951685T 503 18.19354928251923T 251.5 20.36593256373429T 0 16.707981120010928Z;M0 0M 0 147.6653700477613Q 125.75 167.17270876344074 251.5 158.78135336408442T 503 165.78810167479108T 754.5 162.69838020292462T 1006 158.00374206076356L 1006 17.432945605551893Q 880.25 13.947384209184845 754.5 11.599173209052381T 503 10.156507892431605T 251.5 24.38675735533517T 0 26.656459315211393Z;M0 0M 0 150.48448239473186Q 125.75 164.94350529489412 251.5 160.80848869717047T 503 147.25455707905073T 754.5 155.9642836498495T 1006 157.00285429710266L 1006 23.939910094177314Q 880.25 15.781960756053603 754.5 8.005496669044518T 503 8.366521607880287T 251.5 23.757145328866017T 0 13.61913232955142Z;M0 0M 0 162.47351041879784Q 125.75 161.9565598326895 251.5 153.6218040555995T 503 165.0303940314862T 754.5 157.6952939465913T 1006 156.23135110010404L 1006 21.284029454937695Q 880.25 17.66728649340877 754.5 9.433921219951685T 503 18.19354928251923T 251.5 20.36593256373429T 0 16.707981120010928Z"></animate>
                                            </path><path d="" fill="url(#lg-0.6590519274487807)" opacity="0.4">
                                                <animate attributeName="d" dur="3.125s" repeatCount="indefinite" keyTimes="0;0.333;0.667;1" calcmod="spline" keySplines="0.2 0 0.2 1;0.2 0 0.2 1;0.2 0 0.2 1" begin="-2.34375s" values="M0 0M 0 157.93274512887098Q 125.75 166.13756075263984 251.5 161.70875989283064T 503 166.61495339952302T 754.5 161.08428044232T 1006 150.87862185874437L 1006 24.014845249451227Q 880.25 25.502257146363043 754.5 18.86592390003358T 503 16.929778312313772T 251.5 7.889061280907285T 0 25.563468544820346Z;M0 0M 0 158.91811886079523Q 125.75 161.87239923854872 251.5 153.81491922824193T 503 154.1527837045062T 754.5 156.8654227514579T 1006 160.01717304574214L 1006 14.478916561092134Q 880.25 27.52994186724675 754.5 24.96053110572636T 503 9.560388609827783T 251.5 12.78364569184157T 0 21.61590034104256Z;M0 0M 0 162.61717723759298Q 125.75 164.08243832682638 251.5 163.32402106353774T 503 162.619726075305T 754.5 148.96028158443212T 1006 153.22600047856108L 1006 22.40863123252069Q 880.25 15.236185523772171 754.5 12.825559619879456T 503 23.974089291380302T 251.5 26.456957628007643T 0 20.710285050292327Z;M0 0M 0 157.93274512887098Q 125.75 166.13756075263984 251.5 161.70875989283064T 503 166.61495339952302T 754.5 161.08428044232T 1006 150.87862185874437L 1006 24.014845249451227Q 880.25 25.502257146363043 754.5 18.86592390003358T 503 16.929778312313772T 251.5 7.889061280907285T 0 25.563468544820346Z"></animate>
                                            </path></g>
                                    </svg>
                                    
                                </div>
    
                            </div>
    
                            @foreach($blocks as $blockKey=>$block)
                                @if($block->products->count() > 0)
                                    @include('product.partials.Block.block', [
                                            'blockCustomClass'=>'landing7Block-'.$blockKey.' a--owl-carousel-type-2 ',
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
    <script src="{{ mix('/js/page-shop.js') }}"></script>
    <script src="{{ asset('/acm/AlaatvCustomFiles/components/aSticky/aSticky.js') }}"></script>
    <script>


        var sections = [
        @foreach($blocks as $blockKey=>$block)
            @if($block->products->count() > 0)
                'landing7Block-{{ $blockKey }}',
            @endif
        @endforeach
        ];
        
        $(document).on('click', '.btnScroll', function (e) {
            e.preventDefault();
            let blockId = $(this).attr('href');
            if ($('.' + blockId).length > 0) {
                $([document.documentElement, document.body]).animate({
                    scrollTop: $('.'+blockId).offset().top - $('#m_header').height()
                }, 500);
            }
        });

        $(document).ready(function () {
            for (let section in sections) {
                $('.'+sections[section]+' .m-portlet__head').sticky({
                    container: '.'+sections[section],
                    topSpacing: $('#m_header').height(),
                    zIndex: 99
                });
            }
        });
    </script>
@endsection
