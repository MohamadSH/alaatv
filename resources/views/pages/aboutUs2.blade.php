@extends("app",["pageName"=>"aboutUs"])

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
@endsection

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

@section('title')
    <title>آلاء|درباره ما</title>
@endsection

@section("content")
    <!-- BEGIN CONTENT HEADER -->
    <div class="row margin-bottom-40 about-header" style="background-size: 1154px 500px ;background-image: url(/assets/extra/aboutUs-3.jpg);">
        <div class="col-md-12">
            {{--<h1 class="bold">درباره ما</h1>--}}
            {{--<h2>Life is either a great adventure or nothing</h2>--}}
            {{--<button type="button" class="btn btn-danger">JOIN US TODAY</button>--}}
        </div>
    </div>
    <div class="portlet light portlet-fit solid">
        <div class="portlet-title"></div>
        <div class="portlet-body">
            <div class="white-bg white-bg">
                <div class="row">
                    <div class="col-md-3"><img src="/assets/extra/tabatabai.jpg" alt="CEO" class="col-md-12"></div>
                    <div class="col-md-8">
                        <h3 class="bold">سيد مهدي طباطبائي متولد آذر ماه ١٣٥٣ تهران</h3>
                        <p class="bold" style="line-height: 25px; font-size: medium ; text-align: justify">دانش آموخته ي مهندسي شيمي نفت و بسيار علاقمند به امورآموزشى و فرهنگى است. در سال ١٣٨٤ شركت فني مهندسي تامكو را كه در زمينه هاي مهندسي و تحقيقاتي داراى مجوز و رزومه قابل توجه است، تاسيس كرد و هم اكنون نيز مديرعامل اين شركت موفق مى باشد. وى به مرور بر روي حرفه صنعت اسناد فنی متمركز شد و از سال ١٣٩٠ تا ١٣٩٣ بازرس سنديكاي اسناد فنی ايران بوده و هم اكنون عضو هيئت مديره و دبير اتحاديه ي اسناد فنی تهران است. در حال حاضر مدير مسئول مجله ي صنف و صنعت و همچنين مدير مركز آموزش فنى حرفه اى خانه ي مهارت اسناد فنی مي باشد و تلاش دارد با آموزش درست خدمات فني به سرويسكاران ضريب ايمني و سطح كيفيتي خدمات را ارتقاء دهد. در اين سال ها در كنار كار چندين ايده ي خلاقانه را پيگيري كرده كه حاصل آن دو ثبت اختراع در زمينه ي انتقال و جابجايي نفر و خودرو مي باشد .</p>
                        <div style="font-size: x-large">
                            <a href="https://www.linkedin.com/in/mehdi-tabatabaie-74210b68/"><i class="fa fa-linkedin-square"></i></a>
                            {{--<a href="https://t.me/Mehdi_tabatabai"><i class="fa fa-telegram"></i></a>--}}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END CONTENT HEADER -->

@endsection

