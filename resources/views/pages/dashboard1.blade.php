@extends("app" , ["pageName"=>$pageName])


@section("pageBar")

@endsection

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
@endsection

@section("content")
    <h1 class="hidden">همایش اردو فیلم جزوه تخته خاک سؤال مشاوره ریاضی فیزیک دیفرانسیل شیمی</h1>
    <h2 class="hidden">همایش اردو فیلم جزوه تخته خاک سؤال مشاوره ریاضی فیزیک دیفرانسیل شیمی</h2>
    @include("partials.slideShow1" ,["marginBottom"=>"25"])
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue" >
                <div class="visual">
                    <i class="fa fa-user"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="@if(isset($userCount)){{$userCount}} @else 0 @endif">0</span>
                    </div>
                    <div class="desc"> تعداد کل کاربران </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red">
                <div class="visual">
                    <i class="fa fa-question"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="@if(isset($consultingQuestionCount)){{$consultingQuestionCount}}@else 0 @endif">0</span> </div>
                    <div class="desc"> تعداد کل سؤالات مشاوره ای </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green">
                <div class="visual">
                    <i class="fa fa-play"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="@if(isset($consultationCount)){{$consultationCount}} @else 0 @endif">0</span>
                    </div>
                    <div class="desc"> تعداد کل مشاوره ها </div>
                </div>
            </a>
        </div>
        {{--<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">--}}
        {{--<a class="dashboard-stat dashboard-stat-v2 green">--}}
        {{--<div class="visual">--}}
        {{--<i class="attachPermissions" aria-hidden="true"></i>--}}
        {{--</div>--}}
        {{--<div class="details">--}}
        {{--<div class="number">--}}
        {{--<span data-counter="counterup" data-value="@if(isset($ordooRegisteredCount)){{$ordooRegisteredCount}} @else 0 @endif">0</span>--}}
        {{--</div>--}}
        {{--<div class="desc"> ثبت نام اردو تا الان </div>--}}
        {{--</div>--}}
        {{--</a>--}}
        {{--</div>--}}
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 purple">
                <div class="visual">
                    <i class="fa fa-calendar"></i>
                </div>
                <div class="details">
                    <div class="number" dir="ltr" >
                        <span data-counter="counterup" data-value="@if(isset($currentYear)) {{$currentYear}} @else 0 @endif">0</span>/<span data-counter="counterup" data-value="@if(isset($currentMonth)) {{$currentMonth}} @else 0 @endif">0</span>/<span data-counter="counterup" data-value="@if(isset($currentDay)) {{$currentDay}} @else 0 @endif">0</span> </div>
                    <div class="desc"> امروز </div>
                </div>
            </a>
        </div>
    </div>
    <!-- END DASHBOARD STATS 1-->
    {{--<div class="row">--}}
        {{--<div class="col-md-6">--}}
            {{--<div class="portlet light portlet-fit solid blue-dark">--}}
                {{--<div class="portlet-title">--}}
                    {{--<div class="caption">--}}
                        {{--<i class="fa fa-line-chart bg-font-dark"></i>--}}
                        {{--<span class="caption-subject bold bg-font-dark uppercase"> پیشرفت ثبت نام تخته خاک پسران</span>--}}
                        {{--<span class="caption-helper">برای تماشای فیلم ها بر روی دروس کلیک کنید</span>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="portlet-body">--}}
                    {{--<div class="row">--}}
                        {{--@foreach($boysBlocks as $boysBlock)--}}
                            {{--<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">--}}
                                {{--<div class="dashboard-stat2">--}}
                                    {{--<div class="display">--}}
                                        {{--<div class="number">--}}
                                            {{--<h3 class="font-green-soft">--}}
                                                {{--<span data-counter="counterup" data-value="{{$boysBlock["capacity"]}}">0</span>--}}
                                                {{--<small class="font-green-soft">نفر</small>--}}
                                            {{--</h3>--}}
                                            {{--<small>{{$boysBlock["displayName"]}}</small>--}}
                                        {{--</div>--}}
                                        {{--<div class="icon">--}}
                                            {{--<i class="icon-pie-chart"></i>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="progress-info">--}}
                                        {{--<div class="progress">--}}
                                        {{--<span style="width:@if($boysOrdooRegisteredCount<= 0) 0% @else @if(($boysOrdooRegisteredCount-$boysBlock["capacity"])  >= 0) 100% @else {{floor(($boysOrdooRegisteredCount /$boysBlock["capacity"]) * 100)}}% @endif @endif;" class="progress-bar progress-bar-success green-soft">--}}
                                            {{--<span class="sr-only">@if($boysOrdooRegisteredCount<= 0) 0% @else @if($boysOrdooRegisteredCount - $boysBlock["capacity"] >= 0) 100% @else {{floor(($boysOrdooRegisteredCount /$boysBlock["capacity"]) * 100)}}% @endif @endif میزان تکمیل شده</span>--}}
                                        {{--</span>--}}
                                        {{--</div>--}}
                                        {{--<div class="status">--}}
                                            {{--<div class="status-title"> میزان تکمیل شده </div>--}}
                                            {{--<div class="status-number">@if($boysOrdooRegisteredCount<= 0) 0% @else @if( ($boysOrdooRegisteredCount=$boysOrdooRegisteredCount-$boysBlock["capacity"]) >= 0)  100% @else {{ floor(( ($boysOrdooRegisteredCount + $boysBlock["capacity"]) /$boysBlock["capacity"]) * 100)}}% @endif @endif </div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--@endforeach--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="col-md-6">--}}
            {{--<div class="portlet light portlet-fit solid green-soft">--}}
                {{--<div class="portlet-title">--}}
                    {{--<div class="caption">--}}
                        {{--<i class="fa fa-line-chart bg-font-dark"></i>--}}
                        {{--<span class="caption-subject bold bg-font-dark uppercase"> پیشرفت ثبت نام تخته خاک دختران</span>--}}
                        {{--<span class="caption-helper">برای تماشای فیلم ها بر روی دروس کلیک کنید</span>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="portlet-body">--}}
                    {{--<div class="row">--}}
                        {{--@foreach($girlsBlocks as $girlsBlock)--}}
                            {{--<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">--}}
                                {{--<div class="dashboard-stat2">--}}
                                    {{--<div class="display">--}}
                                        {{--<div class="number">--}}
                                            {{--<h3 class="font-blue-dark">--}}
                                                {{--<span data-counter="counterup" data-value="{{$girlsBlock["capacity"]}}">0</span>--}}
                                                {{--<small class="font-blue-dark">نفر</small>--}}
                                            {{--</h3>--}}
                                            {{--<small>{{$girlsBlock["displayName"]}}</small>--}}
                                        {{--</div>--}}
                                        {{--<div class="icon">--}}
                                            {{--<i class="icon-pie-chart"></i>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="progress-info">--}}
                                        {{--<div class="progress">--}}
                                        {{--<span style="width:@if($girlsOrdooRegisteredCount<= 0) 0% @else @if(($girlsOrdooRegisteredCount-$girlsBlock["capacity"])  >= 0) 100% @else {{floor(($girlsOrdooRegisteredCount /$girlsBlock["capacity"]) * 100)}}% @endif @endif;" class="progress-bar progress-bar-success blue-dark">--}}
                                            {{--<span class="sr-only">@if($girlsOrdooRegisteredCount<= 0) 0% @else @if($girlsOrdooRegisteredCount - $girlsBlock["capacity"] >= 0) 100% @else {{floor(($girlsOrdooRegisteredCount /$girlsBlock["capacity"]) * 100)}}% @endif @endif میزان تکمیل شده</span>--}}
                                        {{--</span>--}}
                                        {{--</div>--}}
                                        {{--<div class="status">--}}
                                            {{--<div class="status-title"> میزان تکمیل شده </div>--}}
                                            {{--<div class="status-number">@if($girlsOrdooRegisteredCount<= 0) 0% @else @if( ($girlsOrdooRegisteredCount=$girlsOrdooRegisteredCount-$girlsBlock["capacity"]) >= 0)  100% @else {{ floor(( ($girlsOrdooRegisteredCount + $girlsBlock["capacity"]) /$girlsBlock["capacity"]) * 100)}}% @endif @endif </div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--@endforeach--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    <div class="row">
        <div class="col-md-12">
            <div class="portfolio-content portfolio-1" >
            @if($products->isEmpty())
                <div class="note " style="background-color: #00d4db;">
                    <h4 class="block bold" style="text-align: center">کاربر گرامی در حال حاضر موردی برای ثبت نام وجود ندارد. همایشها و اردوهای بعدی به زودی اعلام خواهند شد.</h4>
                </div>
            @else
                @include("partials.portfolioGrid" , ["withFilterButton" => false , "withAd"=>true])
            @endif
        </div>
        </div>
    </div>
    <div class="row">
        {{--<div class="col-md-6">--}}
            {{--<div class="portlet light portlet-fit ">--}}
                {{--<div class="portlet-title">--}}
                    {{--<div class="caption">--}}
                        {{--<i class="fa fa-book font-green"></i>--}}
                        {{--<span class="caption-subject bold font-green uppercase"> تایملاین تمرین</span>--}}
                        {{--<span class="caption-helper">به همراه کلید و فیلم تحلیل تمرین</span>--}}
                    {{--</div>--}}
                    {{--<div class="actions">--}}
                        {{--<div class="btn-group btn-group-devided" data-toggle="buttons">--}}
                            {{--<label class="btn red btn-outline btn-circle btn-sm active">--}}
                                {{--<input type="radio" name="options" class="toggle" id="option1">حالت ۱</label>--}}
                            {{--<label class="btn  red btn-outline btn-circle btn-sm">--}}
                                {{--<input type="radio" name="options" class="toggle" id="option2">حالت ۲</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="portlet-body">--}}
                    {{--<div class="scroller timeline  white-bg white-bg" style="height: @if($assignments->count() <= 1) 165px @else 280px @endif;">--}}
                        {{--@include("assignment.index" , ["pageName"=>$pageName])--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="col-md-6" id="mapColumn" >--}}
            {{--<div class="portlet light portlet-fit ">--}}
                {{--<div class="portlet-title">--}}
                    {{--<div class="caption">--}}
                        {{--<i class="fa fa-gift font-blue" aria-hidden="true"></i>--}}
                        {{--<span class="caption-subject bold font-blue uppercase">پوشش 80% زیست کنکور</span>--}}
                        {{--<span class="caption-helper"></span>--}}
                    {{--</div>--}}
                    {{--<div class="actions">--}}
                        {{--<div class="coming-soon-countdown no-padding">--}}
                            {{--<div id="defaultCountdown no-margin"> </div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="portlet-body">--}}
                    {{--<div class="white-bg white-bg" >--}}
                        {{--<a href="/product/69"><img class="dashboard-special-offer" src="/image/4/256/256/zist_20170417173318.jpg" alt="زیست کنکور" ></a>--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-md-3 col-sm-3 col-xs-6 text-stat">--}}
                                {{--<span class="label label-sm" style="background-color: rgb(7, 163, 204);">بدن انسان</span>--}}
                                {{--<h5 class="bold">اندام ها و دستگاههای بدن انسان</h5>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-3 col-sm-3 col-xs-6 text-stat">--}}
                                {{--<span class="label label-sm " style="background-color: rgb(34, 177, 71);">ژنتیک</span>--}}
                                {{--<h5 class="bold">مندلی، انسانی، جمعیت، مولکولی...</h5>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-3 col-sm-3 col-xs-6 text-stat">--}}
                                {{--<span class="label label-sm" style="background-color: rgb(237, 27, 36);">گیاهی</span>--}}
                                {{--<h5 class="bold">کل گیاهی سال دوم و سوم</h5>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-3 col-sm-3 col-xs-6 text-stat">--}}
                                {{--<span class="label label-sm" style="background-color: rgb(253, 244, 1);">مباحث داغ</span>--}}
                                {{--<h5 class="bold">فوتو سنتر و تنفس سلولی و...</h5>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="col-md-6" id="consultationColumn" >
            <div class="portlet light portlet-fit">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-video-camera font-red"></i>
                        <span class="caption-subject bold font-red uppercase"> تایملاین مشاوره</span>
                        <span class="caption-helper">فیلمهای مشاوره</span>
                    </div>
                    <div class="actions">
                        <a href="{{action("UserController@uploadConsultingQuestion")}}" class="btn btn-transparent dark btn-outline btn-circle btn-sm active">
                            برای پرسیدن سؤال مشاوره ای کلیک کنید</a>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="scroller timeline  white-bg white-bg @if($consultations->count() <= 1) dashboard-consultation-scroll-empty @else dashboard-consultation-scroll-notEmpty @endif">
                        @include("consultation.index" , ["pageName"=>$pageName])
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6" >
            <div class="portlet light portlet-fit">
                <div class="portlet-title">

                    <div class="caption">

                            <i class="fa fa-book font-red"></i>
                            <a href="{{action("EducationalContentController@search")}}"><span class="caption-subject bold font-red "> آخرین مطالب </span></a>
                            <span class="caption-helper">جزوه ، کتاب ، آزمون</span>

                    </div>
                </div>

                <div class="portlet-body">
                    @if($educationalContents->isEmpty())
                        <div class="timeline  white-bg white-bg">
                            <h4 class="block bold text-center" >کاربر گرامی در حال حاضر مطلبی برای مشاهده وجود ندارد.</h4>
                        </div>
                    @else
                        {{--<div class="scroller timeline  white-bg white-bg @if($articles->count() <= 1) height-165 @else height-400 @endif">--}}

                        {{--</div>--}}
                        <div class="scroller" data-always-visible="1" data-rail-visible="0">
                            @include("educationalContent.index" , ["pageName"=>"dashboard"])
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
    {{--<div class="row">--}}
        {{--<div class="col-md-12 ">--}}
            {{--<div class="portlet light portlet-fit ">--}}
                {{--<div class="portlet-title">--}}
                    {{--<div class="caption">--}}
                        {{--<i class="icon-microphone font-dark hide"></i>--}}
                        {{--<span class="caption-subject bold font-yellow uppercase"> همایش های نوروز ۹۵ تخته خاک</span>--}}
                        {{--<span class="caption-helper">برای تماشای فیلم ها بر روی دروس کلیک کنید</span>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="portlet-body">--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-md-4">--}}
                            {{--<a target="_blank" href="http://sanatisharif.ir/Sanati-Sharif-Lesson/11/19/">--}}
                                {{--<div class="mt-widget-2">--}}
                                    {{--<div class="mt-head" style="background-image: url(/assets/extra/hamayesh-fizik-95.jpg);">--}}
                                        {{--<div class="mt-head-user">--}}
                                            {{--<div class="mt-head-user-img">--}}
                                                {{--<img src="http://sanatisharif.ir/images/alaa-index.gif" alt="آلاء">--}}
                                            {{--</div>--}}
                                            {{--<div class="mt-head-user-info">--}}
                                                {{--<span class="mt-user-name">آقای کازرانیان</span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="mt-body">--}}
                                        {{--<h3 class="mt-body-title"> همایش فیزیک </h3>--}}
                                        {{--<p class="mt-body-description"> فیلم های همایش فیزیک در اردوی طلایی نوروز ۹۵  </p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                            {{--<a target="_blank" href="http://sanatisharif.ir/Sanati-Sharif-Lesson/15/19/">--}}
                                {{--<div class="mt-widget-2">--}}
                                    {{--<div class="mt-head" style="background-image: url(/assets/extra/hamayesh-zist-95.jpg);">--}}
                                        {{--<div class="mt-head-user">--}}
                                            {{--<div class="mt-head-user-img">--}}
                                                {{--<img src="http://sanatisharif.ir/images/alaa-index.gif" alt="آلاء">--}}
                                            {{--</div>--}}
                                            {{--<div class="mt-head-user-info">--}}
                                                {{--<span class="mt-user-name">آقای رحیمی</span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="mt-body">--}}
                                        {{--<h3 class="mt-body-title"> همایش زیست </h3>--}}
                                        {{--<p class="mt-body-description"> فیلم های همایش زیست در اردوی طلایی نوروز </p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</a>--}}

                        {{--</div>--}}
                        {{--<div class="col-md-4">--}}
                            {{--<a target="_blank" href="http://sanatisharif.ir/Sanati-Sharif-Lesson/10/19/">--}}
                                {{--<div class="mt-widget-2">--}}
                                    {{--<div class="mt-head" style="background-image: url(/assets/extra/hamayesh-shimi-95.jpg);">--}}
                                        {{--<div class="mt-head-user">--}}
                                            {{--<div class="mt-head-user-img">--}}
                                                {{--<img src="http://sanatisharif.ir/images/alaa-index.gif" alt="آلاء">--}}
                                            {{--</div>--}}
                                            {{--<div class="mt-head-user-info">--}}
                                                {{--<span class="mt-user-name">آقای آقاجانی</span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="mt-body">--}}
                                        {{--<h3 class="mt-body-title"> همایش شیمی </h3>--}}
                                        {{--<p class="mt-body-description"> فیلم های همایش شیمی در اردوی طلایی نوروز ۹۵ </p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                            {{--<a target="_blank" href="http://sanatisharif.ir/Sanati-Sharif-Lesson/5/19/">--}}
                                {{--<div class="mt-widget-2">--}}
                                    {{--<div class="mt-head" style="background-image: url(http://sanatisharif.ir/departmentlesson/arabi-124.jpg);">--}}
                                        {{--<div class="mt-head-user">--}}
                                            {{--<div class="mt-head-user-img">--}}
                                                {{--<img src="http://sanatisharif.ir/images/alaa-index.gif" alt="آلاء">--}}
                                            {{--</div>--}}
                                            {{--<div class="mt-head-user-info">--}}
                                                {{--<span class="mt-user-name">آقای ناصح زاده</span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="mt-body">--}}
                                        {{--<h3 class="mt-body-title"> همایش عربی </h3>--}}
                                        {{--<p class="mt-body-description"> فیلم های همایش عربی در اردوی طلایی نوروز ۹۵ </p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</a>--}}

                        {{--</div>--}}
                        {{--<div class="col-md-4">--}}
                            {{--<a target="_blank" href="http://sanatisharif.ir/Sanati-Sharif-Lesson/45/19/">--}}
                                {{--<div class="mt-widget-2">--}}
                                    {{--<div class="mt-head" style="background-image: url(assets/extra/hamayesh-adabiyat-95.jpg);">--}}
                                        {{--<div class="mt-head-user">--}}
                                            {{--<div class="mt-head-user-img">--}}
                                                {{--<img src="http://sanatisharif.ir/images/alaa-index.gif" alt="آلاء">--}}
                                            {{--</div>--}}
                                            {{--<div class="mt-head-user-info">--}}
                                                {{--<span class="mt-user-name" style="background: rgba(0, 0, 0, 0.6);">آقای حسین خانی</span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="mt-body">--}}
                                        {{--<h3 class="mt-body-title"> جمع بندی آرایه های ادبی </h3>--}}
                                        {{--<p class="mt-body-description"> فیلم های جمع بندی آرایه های ادبی اردوی طلایی نوروز ۹۵ </p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                            {{--<a target="_blank" href="http://sanatisharif.ir/Sanati-Sharif-Lesson/19/19/">--}}
                                {{--<div class="mt-widget-2">--}}
                                    {{--<div class="mt-head" style="background-image: url(http://sanatisharif.ir/departmentlesson/jabr.jpg);">--}}
                                        {{--<div class="mt-head-user">--}}
                                            {{--<div class="mt-head-user-img">--}}
                                                {{--<img src="http://sanatisharif.ir/images/alaa-index.gif" alt="آلاء">--}}
                                            {{--</div>--}}
                                            {{--<div class="mt-head-user-info">--}}
                                                {{--<span class="mt-user-name" style="background: rgba(0, 0, 0, 0.6);">آقای حسین کرد</span>--}}


                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="mt-body">--}}
                                        {{--<h3 class="mt-body-title"> همایش جبر و احتمال </h3>--}}
                                        {{--<p class="mt-body-description"> فیلم های همایش جبر رو احتمال در اردوی طلایی نوروز ۹۵ </p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div></div>--}}
    {{--</div>--}}

@endsection
@section("footerPageLevelPlugin")
    <script src="{{ mix('/js/footer_Page_Level_Plugin.js') }}" type="text/javascript"></script>
@endsection
@section("footerPageLevelScript")
    <script src="{{ mix('/js/Page_Level_Script_all.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        @if(Config::has("constants.SPECIAL_OFFER_DEADLINE"))
            var ComingSoon = function () {

                return {
                    //main function to initiate the module
                    init: function () {
                        var finish = new Date({{Config::get("constants.SPECIAL_OFFER_DEADLINE")}});
                        $('#defaultCountdown').countdown({until:finish  ,format: 'DHMS',
                            layout:  '<span class="countdown_row countdown_show4" >'+
                                        '{d<}'+
                                        '<span class="countdown_section bg-green" style="width: 24%"  >'+
                                            '<label class="countdown_amount" >{dn}</label>'+
                                            '<br>{dl}'+
                                            '</span>'+
                                            '{d>}'+
                                        '{h<}'+
                                        '<span class="countdown_section bg-green" style="width: 24%">'+
                                            '<label class="countdown_amount">{hn}</label>'+
                                            '<br>{hl}'+
                                            '</span>'+
                                            '{h>}'+
                                        '{m<}'+
                                        '<span class="countdown_section bg-green" style="width: 24%">'+
                                            '<label class="countdown_amount">{mn}</label>'+
                                        '<br>{ml}'+
                                        '</span>'+
                                        '{m>}'+
                                        '{s<}'+
                                        '<span class="countdown_section bg-green" style="width: 24%">'+
                                            '<label class="countdown_amount">{sn}</label>'+
                                            '<br>{sl}'+
                                            '</span>'+
                                            '{s>}'+
                                        '</span>',
                            description: 'تا پایان'
                        });
                    }

                };

            }();

            jQuery(document).ready(function() {
                ComingSoon.init();
            });
        @endif
    </script>
@endsection

@section("extraJS")
    <script type="text/javascript">
        (function($, window, document, undefined) {
            'use strict';

            // init cubeportfolio
            $('#js-grid-juicy-projects').cubeportfolio({
                filters: '#js-filters-juicy-projects',
                loadMore: '#js-loadMore-juicy-projects',
                loadMoreAction: 'click',
                layoutMode: 'grid',
                defaultFilter: '*',
                animationType: 'quicksand',
                gapHorizontal: 35,
                gapVertical: 30,
                gridAdjustment: 'responsive',
                mediaQueries: [{
                    width: 1500,
                    cols: 5
                }, {
                    width: 1100,
                    cols: 4
                }, {
                    width: 800,
                    cols: 3
                }, {
                    width: 480,
                    cols: 2
                }, {
                    width: 320,
                    cols: 1
                }],
                caption: 'overlayBottomReveal',
                displayType: 'sequentially',
                displayTypeSpeed: 80,

                // lightbox
                lightboxDelegate: '.cbp-lightbox',
                lightboxGallery: true,
                lightboxTitleSrc: 'data-title',
                lightboxCounter: '<div class="cbp-popup-lightbox-counter" style="direction:ltr">@{{current}} of @{{total}}</div>',

                // singlePage popup
                singlePageDelegate: '.cbp-singlePage',
                singlePageDeeplinking: true,
                singlePageStickyNavigation: true,
                singlePageCounter: '<div class="cbp-popup-singlePage-counter" style="direction:ltr">@{{current}} of @{{total}}</div>',
                singlePageCallback: function(url, element) {
                    // to update singlePage content use the following method: this.updateSinglePage(yourContent)
                    var t = this;

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'html',
                        timeout: 10000
                    })
                        .done(function(result) {
                            t.updateSinglePage(result);
                        })
                        .fail(function() {
                            t.updateSinglePage('AJAX Error! Please refresh the page!');
                        });
                },
            });

        })(jQuery, window, document);
    </script>
@endsection
