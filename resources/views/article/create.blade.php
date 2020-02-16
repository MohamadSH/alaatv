@permission((Config::get('constants.INSERT_ARTICLE_ACCESS')))
@extends('partials.templatePage',["pageName"=>"admin"])

@section("headPageLevelPlugin")
    <link href = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/assets/global/plugins/bootstrap-summernote/summernote.css" rel = "stylesheet" type = "text/css"/>
@endsection


@section("pageBar")
    <div class = "page-bar">
        <ul class = "page-breadcrumb">
            <li>
                <i class = "icon-home"></i>
                <a href = "{{route('web.index')}}">@lang('page.Home')</a>
                <i class = "fa fa-angle-left"></i>
            </li>
            <li>
                <a href = "{{action("Web\AdminController@adminContent")}}">پنل مدیریتی</a>
                <i class = "fa fa-angle-left"></i>
            </li>
            <li>
                <span>ایجاد مقاله</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class = "row">
        <div class = "col-md-3"></div>
        <div class = "col-md-8">
            @include("systemMessage.flash")
            {!! Form::open(['files'=>true,'method' => 'POST','action' => 'ArticleController@store', 'class'=>'form-horizontal']) !!}
            @include('article.form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/bootstrap-summernote/summernote.min.js" type = "text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src = "/assets/pages/scripts/components-editors.min.js" type = "text/javascript"></script>
@endsection


@section("extraJS")
    <script>
        //        $('#briefSummerNote').summernote({height: 200});
        $('#bodySummerNote').summernote({
            lang: 'fa-IR',
            height: 300,
            popover: {
                image: [],
                link: [],
                air: []
            }
        });
    </script>

    <script>
        countChar(document.getElementById('title'), 50, 60, 100, '#progressbar_title');
        countChar(document.getElementById('brief'), 150, 160, 200, '#progressbar_brief');

        /**
         *
         * @param val
         * @param aNumberOfChar
         * @param bNumberOfChar
         * @param progress
         */
        function countChar(val, aNumberOfChar, bNumberOfChar, maxChar, progress) {
            var len = val.value.length;
            var $progressbar = $(progress);

            var w = Math.round(100 * len / maxChar);
            //            console.log(w);
            if (w < Math.round(100 * aNumberOfChar / maxChar)) {
                $progressbar.css("width", w + "%");
                $progressbar.css("background-color", '#ff5329');
            } else if (w <= Math.round(100 * bNumberOfChar / maxChar)) {
                $progressbar.css("width", w + "%");
                $progressbar.css("background-color", '#00aa11');
            } else {
                $progressbar.css("width", w + "%");
                $progressbar.css("background-color", '#ff0000');
            }
        }
    </script>
@endsection
@endpermission
