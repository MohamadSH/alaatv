@extends("app",["pageName"=> $pageName ])

@section('right-aside')
@endsection

@section("pageBar")
@endsection

@section('content')

    <style>
        .a--multi-level-search {
            display: none;
            margin-bottom: 20px;
            background: white;
            padding-top: 35px;
            -webkit-box-shadow: 0px 0px 5px 2px rgba(221,221,221,1);
            -moz-box-shadow: 0px 0px 5px 2px rgba(221,221,221,1);
            box-shadow: 0px 0px 5px 2px rgba(221,221,221,1);
        }
        .a--multi-level-search .selectorItem {

        }
        .a--multi-level-search .selectorItem .selectorItemTitle {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }
        .a--multi-level-search .selectorItem .subItem:hover {
            /*-webkit-box-shadow: 0px 0px 15px 0px #7FDBFF;*/
            /*-moz-box-shadow: 0px 0px 15px 0px #7FDBFF;*/
            /*box-shadow: 0px 0px 15px 0px #7FDBFF;*/
            background-color: #fd7e14;
            /*-moz-transform: scale(1.05);*/
            /*-webkit-transform: scale(1.05);*/
            /*-o-transform: scale(1.05);*/
            /*-ms-transform: scale(1.05);*/
            /*transform: scale(1.05);*/
        }
        .a--multi-level-search .selectorItem .subItem {
            white-space: nowrap;
            text-align: center;
            margin: 2px;
            padding: 10px 50px;
            background-color: #7FDBFF;
            /*border-radius: 4px;*/
            cursor: pointer;
            /*-webkit-box-shadow: 0px 0px 5px 0px #7FDBFF;*/
            /*-moz-box-shadow: 0px 0px 5px 0px #7FDBFF;*/
            /*box-shadow: 0px 0px 5px 0px #7FDBFF;*/
            transition-property: all;
            transition-duration: 0.3s;
        }
        .a--multi-level-search .selectorItem .select2 {
            max-width: 100%;
            min-width: 100%;
        }
        .a--multi-level-search .selectorItem[data-select-display="select2"] .select2-selection {
            border: none;
        }
        .a--multi-level-search .selectorItem .select2warper {
            margin: 10px 0;
            border: solid 3px #dbdbdb;
        }
        .a--multi-level-search .filterNavigationWarper {
            margin-bottom: 45px;
        }
        .a--multi-level-search .filterNavigationWarper .filterNavigationStep {
            text-align: center;
            position: relative;
            z-index: 0;
        }
        .a--multi-level-search .filterNavigationWarper .filterNavigationStep::before {
            content: " ";
            position: absolute;
            width: 100%;
            height: 5px;
            background-color: #42d70066;
            top: 8px;
            left: -50%;
            z-index: -1;
        }
        .a--multi-level-search .filterNavigationWarper .filterNavigationStep.current::before,
        .a--multi-level-search .filterNavigationWarper .filterNavigationStep.deactive::before {
            background-color: #f2f3f8;
        }
        .a--multi-level-search .filterNavigationWarper .filterNavigationStep:last-child::before {
            display: none;
        }
        .a--multi-level-search .filterNavigationWarper .filterNavigationStep::after {

        }
        .a--multi-level-search .filterNavigationWarper .filterNavigationStep.active  .filterStepText {
            box-shadow: 0px 0px 15px -1px rgba(0, 214, 64, 0.25);
        }
        .a--multi-level-search .filterNavigationWarper .filterNavigationStep.current .filterStepText {
            /*-webkit-box-shadow: 0px 0px 10px 2px rgba(0,227,51,1);*/
            /*-moz-box-shadow: 0px 0px 10px 2px rgba(0,227,51,1);*/
            /*box-shadow: 0px 0px 10px 2px rgba(0,227,51,1);*/
            box-shadow: 0px 0px 15px -1px rgba(0, 214, 64, 0.55);
        }
        .a--multi-level-search .filterNavigationWarper .filterNavigationStep.deactive   .filterStepText {
            /*-webkit-box-shadow: 0px 0px 15px 1px rgba(51, 40, 77, 0.21);*/
            /*-moz-box-shadow: 0px 0px 15px 1px rgba(51, 40, 77, 0.21);*/
            /*box-shadow: 0px 0px 15px 1px rgba(51, 40, 77, 0.21);*/
            box-shadow: 0px 0px 15px -1px rgba(51, 40, 77, 0.17);
        }
        .a--multi-level-search .filterNavigationWarper .filterNavigationStep .filterStepText {
            display: initial;
            background: white;
            padding: 12px;
            cursor: pointer;
        }
        .a--multi-level-search .filterNavigationWarper .filterNavigationStep .filterStepSelectedText {
            /*display: none;*/
            position: relative;
            top: 25px;
            width: 100%;
            text-align: center;
            background-color: white;
            -webkit-box-shadow: 0px 0px 5px 8px rgba(255,255,255,1);
            -moz-box-shadow: 0px 0px 5px 8px rgba(255,255,255,1);
            box-shadow: 0px 0px 5px 8px rgba(255,255,255,1);
        }








        .a--owl-carousel-type-1 .m-widget19__header {
            margin-right: -15px;
            margin-left: -15px;
        }
    </style>

    <div class="row">
        <div class="col a--multi-level-search" id="contentSearchFilter">

            <div class="row filterNavigationWarper">

            </div>

            <div class="row justify-content-center selectorItem" data-select-order="0" data-select-title="مقطع" data-select-display="grid" data-select-value="چهارم دبیرستان">
                <div class="col subItem">همه مقاطع</div>
                <div class="col subItem">دهم</div>
                <div class="col subItem">یازدهم</div>
                <div class="col subItem">کنکوری</div>
                <div class="col subItem">اول دبیرستان</div>
                <div class="col subItem">دوم دبیرستان</div>
                <div class="col subItem">سوم دبیرستان</div>
                <div class="col subItem">چهارم دبیرستان</div>
                <div class="col subItem">المپیاد</div>
            </div>

            <div class="row justify-content-center selectorItem" data-select-order="1" data-select-title="رشته" data-select-display="grid" data-select-value="ریاضی">
                <div class="col subItem">همه رشته ها</div>
                <div class="col subItem">ریاضی</div>
                <div class="col subItem">تجربی</div>
                <div class="col subItem">انسانی</div>
            </div>

            <div class="row justify-content-center selectorItem" data-select-order="2" data-select-title="درس" data-select-display="select2" data-select-value="المپیاد فیزیک">
                <div class="col subItem">همه دروس</div>
                <div class="col subItem">آمار و مدلسازی</div>
                <div class="col subItem">اخلاق</div>
                <div class="col subItem">المپیاد فیزیک</div>
                <div class="col subItem">المپیاد نجوم</div>
                <div class="col subItem">تحلیلی</div>
                <div class="col subItem">جبر و احتمال</div>
                <div class="col subItem">حسابان</div>
                <div class="col subItem">دیفرانسیل</div>
                <div class="col subItem">دین و زندگی</div>
                <div class="col subItem">ریاضی انسانی</div>
                <div class="col subItem">ریاضی تجربی</div>
                <div class="col subItem">ریاضی و آمار</div>
                <div class="col subItem">ریاضی پایه</div>
                <div class="col subItem">زبان انگلیسی</div>
                <div class="col subItem">زبان و ادبیات فارسی</div>
                <div class="col subItem">زیست شناسی</div>
                <div class="col subItem">شیمی</div>
                <div class="col subItem">عربی</div>
                <div class="col subItem">فیزیک</div>
                <div class="col subItem">مشاوره</div>
                <div class="col subItem">منطق</div>
                <div class="col subItem">هندسه پایه</div>
                <div class="col subItem">گسسته</div>
            </div>

            <div class="row justify-content-center selectorItem" data-select-order="3" data-select-title="دبیر" data-select-display="select2" data-select-value="ارشی" data-select-active="true">
                <div class="col subItem" value=""> همه دبیرها</div>
                <div class="col subItem" value="محمد_رضا_آقاجانی">محمد رضا آقاجانی</div>
                <div class="col subItem" value="رضا_آقاجانی">رضا آقاجانی</div>
                <div class="col subItem" value="محسن_آهویی">محسن آهویی</div>
                <div class="col subItem" value="ارشی"> ارشی</div>
                <div class="col subItem" value="مهدی_امینی_راد">مهدی امینی راد</div>
                <div class="col subItem" value="محمد_علی_امینی_راد">محمد علی امینی راد</div>
                <div class="col subItem" value="یاشار_بهمند">یاشار بهمند</div>
                <div class="col subItem" value="عمار_تاج_بخش">عمار تاج بخش</div>
                <div class="col subItem" value="مهدی_تفتی">مهدی تفتی</div>
                <div class="col subItem" value="محمد_صادق_ثابتی">محمد صادق ثابتی</div>
                <div class="col subItem" value="ابوالفضل_جعفری">ابوالفضل جعفری</div>
                <div class="col subItem" value="جعفری"> جعفری</div>
                <div class="col subItem" value="مصطفی_جعفری_نژاد">مصطفی جعفری نژاد</div>
                <div class="col subItem" value="مهدی_جلادتی">مهدی جلادتی</div>
                <div class="col subItem" value="سید_حسام_الدین_جلالی">سید حسام الدین جلالی</div>
                <div class="col subItem" value="جهانبخش"> جهانبخش</div>
                <div class="col subItem" value="روح_الله_حاجی_سلیمانی">روح الله حاجی سلیمانی</div>
                <div class="col subItem" value="مسعود_حدادی">مسعود حدادی</div>
                <div class="col subItem" value="محمد_حسین_انوشه">محمد حسین انوشه</div>
                <div class="col subItem" value="میثم__حسین_خانی">میثم حسین خانی</div>
                <div class="col subItem" value="محمد_حسین_شکیباییان">محمد حسین شکیباییان</div>
                <div class="col subItem" value="محمد_رضا_حسینی_فرد">محمد رضا حسینی فرد</div>
                <div class="col subItem" value="ناصر_حشمتی">ناصر حشمتی</div>
                <div class="col subItem" value="فرشید_داداشی">فرشید داداشی</div>
                <div class="col subItem" value="درویش"> درویش</div>
                <div class="col subItem" value="عباس_راستی_بروجنی">عباس راستی بروجنی</div>
                <div class="col subItem" value="داریوش_راوش">داریوش راوش</div>
                <div class="col subItem" value="شهروز_رحیمی">شهروز رحیمی</div>
                <div class="col subItem" value="پوریا_رحیمی">پوریا رحیمی</div>
                <div class="col subItem" value="علیرضا_رمضانی">علیرضا رمضانی</div>
                <div class="col subItem" value="جعفر_رنجبرزاده">جعفر رنجبرزاده</div>
                <div class="col subItem" value="امید_زاهدی">امید زاهدی</div>
                <div class="col subItem" value="هامون_سبطی">هامون سبطی</div>
                <div class="col subItem" value="رضا_شامیزاده">رضا شامیزاده</div>
                <div class="col subItem" value="شاه_محمدی"> شاه محمدی</div>
                <div class="col subItem" value="محسن_شهریان">محسن شهریان</div>
                <div class="col subItem" value="محمد_صادقی">محمد صادقی</div>
                <div class="col subItem" value="علی_صدری">علی صدری</div>
                <div class="col subItem" value="مهدی_صنیعی_طهرانی">مهدی صنیعی طهرانی</div>
                <div class="col subItem" value="پیمان_طلوعی">پیمان طلوعی</div>
                <div class="col subItem" value="علی_اکبر_عزتی">علی اکبر عزتی</div>
                <div class="col subItem" value="پدرام_علیمرادی">پدرام علیمرادی</div>
                <div class="col subItem" value="حمید_فدایی_فرد">حمید فدایی فرد</div>
                <div class="col subItem" value="کیاوش_فراهانی">کیاوش فراهانی</div>
                <div class="col subItem" value="بهمن_مؤذنی_پور">بهمن مؤذنی پور</div>
                <div class="col subItem" value="خسرو_محمد_زاده">خسرو محمد زاده</div>
                <div class="col subItem" value="عبدالرضا_مرادی">عبدالرضا مرادی</div>
                <div class="col subItem" value="حسن_مرصعی">حسن مرصعی</div>
                <div class="col subItem" value="سروش_معینی">سروش معینی</div>
                <div class="col subItem" value="محسن_معینی">محسن معینی</div>
                <div class="col subItem" value="محمدرضا_مقصودی">محمدرضا مقصودی</div>
                <div class="col subItem" value="جلال_موقاری">جلال موقاری</div>
                <div class="col subItem" value="نادریان"> نادریان</div>
                <div class="col subItem" value="میلاد_ناصح_زاده">میلاد ناصح زاده</div>
                <div class="col subItem" value="مهدی_ناصر_شریعت">مهدی ناصر شریعت</div>
                <div class="col subItem" value="جواد_نایب_کبیر">جواد نایب کبیر</div>
                <div class="col subItem" value="محمدامین_نباخته">محمدامین نباخته</div>
                <div class="col subItem" value="سیروس_نصیری">سیروس نصیری</div>
                <div class="col subItem" value="محمد_پازوکی">محمد پازوکی</div>
                <div class="col subItem" value="حامد_پویان_نظر">حامد پویان نظر</div>
                <div class="col subItem" value="کازرانیان"> کازرانیان</div>
                <div class="col subItem" value="کاظم_کاظمی">کاظم کاظمی</div>
                <div class="col subItem" value="وحید_کبریایی">وحید کبریایی</div>
                <div class="col subItem" value="حسین_کرد">حسین کرد</div>
            </div>

        </div>
    </div>
    @if(!empty($tags))
        @include("partials.search.tagLabel" , ["tags"=>$tags])
    @endif

    <div class="row">
        <div class="
            @if(optional($result->get('pamphlet'))->isNotEmpty() || optional($result->get('article'))->isNotEmpty())
                    col-12 col-md-9
            @else
                    col
            @endif">

            {{--{{ dd($result->get('product')) }}--}}
            <div class="row">
                @include('partials.search.video',[
                'items' => $result->get('product'),
                'title' => 'محصولات',
                'carouselType' => 'a--owl-carousel-type-1',
                'widgetId'=>'product-carousel',
                'type' => 'product'
                ])
            </div>
            <div class="row">
                @include('partials.search.contentset',[
                'items' => $result->get('set'),
                'type' => 'set'
                ])
            </div>
            <div class="row">
                @include('partials.search.video',['items' => $result->get('video')])
            </div>


            <div class="row">
                {{--@if(optional($result->get('product'))->isNotEmpty())--}}
                    {{--<div class = "col-12 m--margin-bottom-5">--}}
                        {{--<a href = "#" class = "m-link m-link--primary">--}}
                            {{--<h3 style = "font-weight: bold"><i class="la la-video-camera"></i> محصولات </h3>--}}
                        {{--</a>--}}
                        {{--<hr>--}}
                    {{--</div>--}}
                    {{--<div class = "col">--}}
                        {{--<div id = "video-carousel" class = "a--owl-carousel-type-1 owl-carousel owl-theme" data-per-page = "7">--}}
                            {{--@foreach($result->get('product') as $product)--}}
                                {{--<div class = "@if($widgetScroll) item @else col-lg-3 col-xl-4 col-md-4 col-xs-4 @endif">--}}
                                    {{--<!--begin:: Widgets/Blog-->--}}
                                    {{--<div class = "m-portlet m-portlet--bordered-semi m-portlet--full-height  m-portlet--rounded-force" style="min-height-: 286px">--}}
                                        {{--<div class = "m-portlet__head m-portlet__head--fit">--}}
                                            {{--<div class = "m-portlet__head-caption">--}}
                                                {{--<div class = "m-portlet__head-action">--}}
                                                    {{--<a href="{{action("Web\ProductController@show" , $product)}}" class = "btn btn-sm m-btn--pill btn-brand">مشاهده</a>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class = "m-portlet__body">--}}
                                            {{--<div class = "m-widget19">--}}
                                                {{--<div class = "m-widget19__pic m-portlet-fit--top m-portlet-fit--sides" >--}}
                                                    {{--<img src = "{{ $widgetPic }}" alt = " {{ $widgetTitle }}"/>--}}
                                                    {{--<div class = "m-widget19__shadow"></div>--}}
                                                {{--</div>--}}
                                                {{--<div class = "m-widget19__content">--}}
                                                    {{--<div class="m--margin-top-10">--}}
                                                        {{--<a href = "{{ $widgetLink }}" class = "m-link">--}}
                                                            {{--<h6>--}}
                                                                {{--<span class="m-badge m-badge--info m-badge--dot"></span> {{ $widgetTitle }}--}}
                                                            {{--</h6>--}}
                                                        {{--</a>--}}
                                                    {{--</div>--}}
                                                    {{--<div class = "m-widget19__header m--margin-top-10">--}}
                                                        {{--<div class = "m-widget19__user-img">--}}
                                                            {{--<img class = "m-widget19__img" src = "{{ $widgetAuthor->photo }}" alt = "{{ $widgetAuthor->full_name }}">--}}
                                                        {{--</div>--}}
                                                        {{--<div class = "m-widget19__info">--}}
                                                            {{--<span class = "m-widget19__username">--}}
                                                                {{--{{ $widgetAuthor->full_name }}--}}
                                                            {{--</span>--}}
                                                            {{--<br>--}}
                                                            {{--<span class = "m-widget19__time">--}}
                                                                {{--موسسه غیرتجاری آلاء--}}
                                                            {{--</span>--}}
                                                        {{--</div>--}}
                                                        {{--<div class = "m-widget19__stats">--}}
                                                            {{--<span class = "m-widget19__number m--font-brand">--}}
                                                                {{--{{ $widgetCount }}--}}
                                                            {{--</span>--}}
                                                            {{--<span class = "m-widget19__comment">--}}
                                                                {{--محتوا--}}
                                                            {{--</span>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class = "m-widget19__action">--}}
                                                    {{--<a href = "{{ $widgetLink }}" class = "btn m-btn--pill    btn-outline-warning m-btn m-btn--outline-2x ">نمایش فیلم های این دوره</a>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<!--end:: Widgets/Blog-->--}}
                                {{--</div>--}}
                            {{--@endforeach--}}
                        {{--</div>--}}
                        {{--<input id="owl--js-var-next-page-video-url" class = "m--hide" type = "hidden" value = '{{ $items->nextPageUrl() }}'>--}}
                    {{--</div>--}}
                {{--@endif--}}
            </div>
        </div>
        @if(optional($result->get('pamphlet'))->isNotEmpty() || optional($result->get('article'))->isNotEmpty())
            <div class="col-12 col-md-3">
                <div class="row">

                    {{--@include('partials.search.pamphlet',['items' => $result->get('pamphlet')])--}}
                    @if(optional($result->get('pamphlet'))->isNotEmpty())
                        <div class="col m-portlet m-portlet--full-height">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                            <i class="la la-file-pdf-o"></i>جزوات آلاء
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__body m--padding-left-5 m--padding-right-5">
                                <div class="tab-content">

                                    <div class="m-widget4">

                                        @foreach($result->get('pamphlet') as $content)
                                            <div class="m-widget4__item m--padding-top-5 m--padding-bottom-5">
                                                <div class="m-widget4__img m-widget4__img--pic">
                                                    <img src="@if(isset($content->author->photo)) {{ $content->author->photo }} @else /assets/app/media/img/users/100_14.jpg @endif" alt="">
                                                </div>
                                                <div class="m-widget4__info">
                                                        <span class="m-widget4__title">
                                                            <a href="{{ action("Web\ContentController@show" , $content) }}" class="m-link">
                                                                {{ $content->name }}
                                                            </a>
                                                        </span>
                                                    <br>
                                                    <span class="m-widget4__sub">
                                                            <a href="{{ action("Web\ContentController@show" , $content) }}" class="m-link">
                                                                {{ $content->author->full_name }}
                                                            </a>
                                                        </span>
                                                </div>
                                                @if(isset($content->thumbnail))
                                                    <div class="m-widget4__img m-widget4__img--pic">
                                                        <img src="{{ $content->thumbnail }}" alt="">
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach

                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif

                    {{--@include('partials.search.article',['items' => $result->get('article')])--}}
                    @if(optional($result->get('article'))->isNotEmpty())
                        <div class="col m-portlet m-portlet--full-height ">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                            <i class="la la-comment"></i>مقالات آموزشی
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__body m--padding-left-5 m--padding-right-5">
                                <div class="tab-content">

                                    <div class="m-widget4">

                                        @foreach($result->get('article') as $content)
                                            <div class="m-widget4__item m--padding-top-5 m--padding-bottom-5">
                                                <div class="m-widget4__img m-widget4__img--pic">
                                                    <img src="@if(isset($content->author->photo)) {{ $content->author->photo }} @else /assets/app/media/img/users/100_14.jpg @endif" alt="">
                                                </div>
                                                <div class="m-widget4__info">
                                                        <span class="m-widget4__title">
                                                            <a href="{{ action("Web\ContentController@show" , $content) }}" class="m-link">
                                                                {{ $content->name }}
                                                            </a>
                                                        </span>
                                                    <br>
                                                    <span class="m-widget4__sub">
                                                            <a href="{{ action("Web\ContentController@show" , $content) }}" class="m-link">
                                                                {{ $content->author->full_name }}
                                                            </a>
                                                        </span>
                                                </div>
                                                @if(isset($content->thumbnail))
                                                    <div class="m-widget4__img m-widget4__img--pic">
                                                        <img src="{{ $content->thumbnail }}" alt="">
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach

                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        @endif
    </div>

@endsection
@section('page-js')

    <script src = "/acm/page-content-search.js" type = "text/javascript"></script>
    <script src="{{ asset('/acm/AlaatvCustomFiles/js/page-content-search.js') }}"></script>

    <script>
        jQuery(document).ready( function() {
            // var owl2 = jQuery('.a--owl-carousel-type-2.owl-carousel');
            // owl2.each(function () {
            //     $(this).owlCarousel({
            //         stagePadding: 40,
            //         loop: false,
            //         rtl:true,
            //         nav:false,
            //         dots: false,
            //         margin:15,
            //         mouseDrag: true,
            //         touchDrag: true,
            //         pullDrag: true,
            //         responsiveClass:true,
            //         responsive:{
            //             0:{
            //                 items:1,
            //             },
            //             600:{
            //                 items:2,
            //             },
            //             1200:{
            //                 items:4
            //             },
            //             1600:{
            //                 items:5
            //             }
            //         }
            //     });
            // });
        });
    </script>
@endsection

{{--
@section("content")
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
            <!-- BEGIN PORTLET-->
            <div class="portlet light " id="productPortlet">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-globe font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">محصولات آلاء</span>
                    </div>
                </div>
                <div class="portlet-body" id="productDiv">
                    <div class="row">
                        <section class="productSlider slider" style="width: 95%;margin-top: 0px ; margin-bottom: 15px;">
                        </section>
                    </div>
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>
    <div class="row">
        <!-- BEGIN PORTLET-->
        <div class="portlet light contentPortlet">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-globe font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase">فیلم ها و جزوات آموزشی آلاء</span>
                    --}}
{{--{!! $tagLabels !!}--}}{{--

                </div>
                <ul class="nav nav-tabs">
                    @if($items->where("type" , "article")->first()["totalitems"] > 0)
                        <li>
                            <a href="#tab_content_article" data-toggle="tab"> Article </a>
                        </li>
                    @endif
                    <li>
                        <a href="#tab_content_pamphlet" data-toggle="tab"> PDF </a>
                    </li>
                    <li class="active">
                        <a href="#tab_content_video" data-toggle="tab">Video</a>
                    </li>
                </ul>
            </div>
            <div class="portlet-body ">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_content_video">
                        {!!  $items->where("type" , "video")->first()["view"] !!}
                    </div>
                    <div class="tab-pane text-center" id="tab_content_pamphlet">
                        {!! $items->where("type" , "pamphlet")->first()["view"]  !!}
                    </div>
                    <div class="tab-pane text-center" id="tab_content_article">
                        {!! $items->where("type" , "article")->first()["view"]  !!}
                    </div>
                </div>

            </div>
        </div>
        <!-- END PORTLET-->
    </div>
    <!--
    -- js variables
    -->
    <div style="display: none">
        <input id="js-var-tags" type="hidden" value='@json($tags,JSON_UNESCAPED_UNICODE)'>
        <input id="js-var-extraTags" type="hidden" value='@json($extraTags,JSON_UNESCAPED_UNICODE)'>
        <input id="js-var-contentIndexUrl" type="hidden" value='{{action('ContentController@index')}}'>
        <input id="js-var-productIndexUrl" type="hidden" value='{{action('ProductController@index')}}'>
        <input id="js-var-setIndexUrl" type="hidden" value='{{action('ContentsetController@index')}}'>
    </div>
@endsection--}}
