@extends("app",["pageName"=>"aboutUs"])

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
@endsection

{{--@section("title")--}}
{{--<title>آلاء|درباره ما</title>--}}
{{--@endsection--}}

@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{action("HomeController@index")}}">خانه</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>درباره ما</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <!-- BEGIN CONTENT HEADER -->
    <div class="row margin-bottom-40 about-header"
         style="background-size: 1154px 500px ;background-image: url(/assets/extra/conference.jpg);">
        <div class="col-md-12" style="background: rgba(0, 0, 0, 0.6);color: #fff; height: 100%">
            <h1>درباره ما</h1>
            <h2><span class="font-green-haze bold">آلاء </span>با همکاری <span class="font-yellow-mint bold">آلاء</span>در
                نوروز ۹۴ با برگزاری اولین اردوی نوروزی خود فعالیت در این عرصه را آغاز کرد . </h2>
            <h2>ما طلایی ترین اردوی دوران تحصیلی شما را با بهترین کیفیت و قیمت برایتان رقم میزنیم</h2>
            <h2 class="font-red bold">مدیر مسئول : رضا شامیزاده</h2>
            {{--<button type="button" class="btn btn-danger">ارسال پیام</button>--}}
        </div>
    </div>
    <!-- END CONTENT HEADER -->

@endsection

