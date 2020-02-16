@permission((Config::get('constants.SHOW_CONSULTATION_ACCESS')))
@extends('partials.templatePage',["pageName"=>"admin"])
@section("headPageLevelPlugin")
    <link href = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/assets/global/plugins/bootstrap-summernote/summernote.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/assets/global/plugins/jquery-multi-select/css/multi-select-rtl.css" rel = "stylesheet" type = "text/css"/>
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
                <a href = "{{action("Web\AdminController@admin")}}">پنل مدیریتی</a>
                <i class = "fa fa-angle-left"></i>
            </li>
            <li>
                <span>اصلاح مشاوره</span>
            </li>
        </ul>
    </div>
@endsection
@section("content")
    <div class = "row">
        <div class = "col-md-3"></div>
        <div class = "col-md-6 ">
        @include("systemMessage.flash")
        <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class = "portlet light ">
                <div class = "portlet-title">
                    <div class = "caption">
                        <i class = "icon-settings font-dark"></i>
                        <span class = "caption-subject font-dark sbold uppercase">اصلاح مشاوره {{$consultation->name}}</span>
                    </div>
                    <div class = "actions">
                        <div class = "btn-group">
                            <a class = "btn btn-sm dark dropdown-toggle" href = "{{action("Web\AdminController@adminContent")}}">
                                بازگشت
                                <i class = "fa fa-angle-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class = "portlet-body form">
                    {!! Form::model($consultation,['files'=>true,'method' => 'PUT','action' => ['ConsultationController@update',$consultation], 'class'=>'form-horizontal']) !!}
                    @include('consultation.form',[$consultationStatuses , $majors ])
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->

        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/bootstrap-summernote/summernote.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/select2/js/select2.full.min.js" type = "text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src = "/assets/pages/scripts/components-editors.min.js" type = "text/javascript"></script>
    <script src = "/assets/pages/scripts/components-multi-select.min.js" type = "text/javascript"></script>
@endsection
@section("extraJS")
    <script>
        jQuery(document).ready(function () {
            $('#consultation_major').multiSelect();
        });
    </script>
@endsection
@endpermission
