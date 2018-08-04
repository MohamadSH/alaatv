@permission((Config::get('constants.CONTENT_ADMIN_PANEL_ACCESS')))
@extends("app",["pageName"=>$pageName])

@section("headPageLevelPlugin")
    <link href="/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/jquery-multi-select/css/multi-select-rtl.css" rel="stylesheet" type="text/css" />
    <link href="/assets/extra/jplayer/dist/skin/blue.monday/css/jplayer.blue.monday.min.css" rel="stylesheet" type="text/css" />
@endsection

@section("metadata")
    @parent()
    <meta name="_token" content="{{ csrf_token() }}">
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
                <span>پنل مدیریت محتوا</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class="row">
        {{--Ajax modal loaded after inserting content--}}
        <div id="ajax-modal" class="modal fade" tabindex="-1"> </div>
        {{--Ajax modal for panel startup --}}

        <!-- /.modal -->
        <div class="col-md-12">

            {{--<div class="note note-info">--}}
                {{--<h4 class="block"><strong>توجه!</strong></h4>--}}
                {{--@role(('admin'))<p class="bold font-red" style="font-size: x-large">ادمین محترم لیست پاسخنامه های MBTI به این صفحه اضافه شده است . لطفا کش مرورگر خود را خالی کنید</p>@endrole--}}
                {{--<strong class="font-red"> اگر این بار اول است که از تاریخ ۳ اسفند به بعد از این پنل استفاده می کنید ، لطفا کش بروزر خود را خالی نمایید . با تشکر</strong>--}}
            {{--</div>--}}

                @permission((Config::get('constants.LIST_EDUCATIONAL_CONTENT_ACCESS')))
                <div class="portlet box red" id="educationalContent-portlet">
                    <span class="hidden" id="educationalContent-portlet-action">{{action("EducationalContentController@index")}}</span>
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>مدیریت محتوای آموزشی </div>
                        <div class="tools">
                            <img class="hidden" id="educationalContent-portlet-loading" src="{{Config::get('constants.ADMIN_LOADING_BAR_GIF')}}" alt="loading"  style="width: 50px;">
                            <a href="javascript:;" class="collapse" id="educationalContent-expand"> </a>
                            {{--<a href="#portlet-config" data-toggle="modal" class="config"> </a>--}}
                            <a href="javascript:;" class="reload"> </a>
                            <a href="javascript:;" class="remove"> </a>
                        </div>
                        <div class="tools"> </div>
                    </div>
                    <div class="portlet-body" style="display: block;">

                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="btn-group">
                                        @permission((Config::get('constants.INSERT_EDUCATIONAL_CONTENT_ACCESS')))
{{--                                        <a  class="btn btn-outline red" target="_blank" href="{{action("EducationalContentController@create2")}}"><i class="fa fa-plus"></i> افزودن محتوا </a>--}}
                                        <a  class="btn btn-outline red" target="_blank" href="{{action("EducationalContentController@create3")}}"><i class="fa fa-plus"></i> افزودن محتوا </a>
                                        @endpermission
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover dt-responsive " width="100%" id="educationalContent_table">
                            <thead>
                            <tr>
                                <th></th>
                                <th class="all"> نام </th>
                                {{--<th class="min-tablet"> ترتیب </th>--}}
                                <th class="desktop"> فعال/غیرفعال </th>
                                <th class="desktop"> مقطع </th>
                                <th class="desktop"> رشته </th>
                                <th class="desktop "> نوع محتوا </th>
                                <th class="none"> فایل ها  </th>
                                <th class="desktop"> توضیح </th>
                                <th class="none"> زمان نمایان شدن </th>
                                <th class="none"> زمان درج </th>
                                <th class="none"> زمان اصلاح </th>
                                <th class="all"> عملیات </th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--Loading by ajax--}}
                            </tbody>
                        </table>
                    </div>
                </div>
                @endpermission

                @permission((Config::get('constants.LIST_ASSIGNMENT_ACCESS')))
                <!-- BEGIN ASSIGNMENT TABLE PORTLET-->
                    <div class="portlet box purple" id="assignment-portlet">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i>مدیریت تمرین ها </div>
                            <div class="tools">
                                <img class="hidden" id="assignment-portlet-loading" src="{{Config::get('constants.ADMIN_LOADING_BAR_GIF')}}" alt="loading"  style="width: 50px;">
                                <a href="javascript:;" class="collapse" id="assignment-expand"> </a>
                                {{--<a href="#portlet-config" data-toggle="modal" class="config"> </a>--}}
                                <a href="javascript:;" class="reload"> </a>
                                <a href="javascript:;" class="remove"> </a>
                            </div>
                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body" style="display: block;">

                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="btn-group">
                                            @permission((Config::get('constants.INSERT_ASSIGNMENT_ACCESS')))
                                            <a id="sample_editable_1_new" class="btn btn-outline purple" data-toggle="modal" href="#responsive-assignment"><i class="fa fa-plus"></i> افزودن تمرین </a>
                                            <!-- responsive modal -->
                                            <div id="responsive-assignment" class="modal fade" tabindex="-1" data-width="760">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">افزودن تمرین جدید</h4>
                                                </div>
                                                {!! Form::open(['files'=>true,'method' => 'POST','action' => ['AssignmentController@store'], 'class'=>'nobottommargin' , 'id'=>'assignmentForm']) !!}
                                                <div class="modal-body">
                                                    <div class="row">
                                                        @include('assignment.form')
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                                <div class="modal-footer">
                                                    <button type="button" data-dismiss="modal" class="btn btn-outline dark" id="assignmentForm-close">بستن</button>
                                                    <button type="button" class="btn purple" id="assignmentForm-submit">ذخیره</button>
                                                </div>
                                            </div>
                                            @endpermission
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped table-bordered table-hover dt-responsive " width="100%" id="assignment_table">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th class="all"> نام </th>
                                    <th class="desktop"> توضیح </th>
                                    <th class="none"> رشته </th>
                                    <th class="none"> تعداد سؤالات </th>
                                    <th class="none"> سؤالات </th>
                                    <th class="none">  پاسخ </th>
                                    <th class="none"> تحلیل آزمون </th>
                                    <th class="min-tablet"> وضعیت </th>
                                    <th class="none"> زمان درج </th>
                                    <th class="none"> زمان اصلاح </th>
                                    <th class="all"> عملیات </th>
                                </tr>
                                </thead>
                                <tbody>
                                {{--Loading by ajax--}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END SAMPLE TABLE PORTLET-->
                @endpermission

                @permission((Config::get('constants.LIST_CONSULTATION_ACCESS')))
                <!-- BEGIN CONSULTATION TABLE PORTLET-->
                    <div class="portlet box blue" id="consultation-portlet">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i>مدیریت مشاوره ها </div>
                            <div class="tools">
                                <img class="hidden" id="consultation-portlet-loading" src="{{Config::get('constants.ADMIN_LOADING_BAR_GIF')}}" alt="loading"  style="width: 50px;">
                                <a href="javascript:;" class="collapse" id="consultation-expand"> </a>
                                {{--<a href="#portlet-config" data-toggle="modal" class="config"> </a>--}}
                                <a href="javascript:;" class="reload"> </a>
                                <a href="javascript:;" class="remove"> </a>
                            </div>
                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body" style="display: block;">

                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="btn-group">
                                            @permission((Config::get('constants.INSERT_CONSULTATION_ACCESS')))
                                            <a id="sample_editable_2_new" class="btn btn-outline blue" data-toggle="modal" href="#responsive-consultation"><i class="fa fa-plus"></i> افزودن مشاوره </a>
                                            <!-- responsive modal -->
                                            <div id="responsive-consultation" class="modal fade" tabindex="-1" data-width="760">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">افزودن مشاوره جدید</h4>
                                                </div>
                                                {!! Form::open(['files'=>true,'method' => 'POST','action' => ['ConsultationController@store'], 'class'=>'nobottommargin' , 'id'=>'consultationForm']) !!}
                                                <div class="modal-body">
                                                    <div class="row">
                                                        @include('consultation.form')
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                                <div class="modal-footer">
                                                    <button type="button" data-dismiss="modal" class="btn btn-outline dark" id="consultationForm-close">بستن</button>
                                                    <button type="button" class="btn blue" id="consultationForm-submit">ذخیره</button>
                                                </div>
                                            </div>
                                            @endpermission
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="consultation_table">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th class="all"> نام </th>
                                    <th class="desktop"> تامبنیل </th>
                                    <th class="desktop"> توضیح </th>
                                    <th class="none"> رشته </th>
                                    <th class="none">  فیلم </th>
                                    <th class="none"> متن </th>
                                    <th class="min-tablet"> وضعیت </th>
                                    <th class="none"> زمان درج </th>
                                    <th class="none"> زمان اصلاح </th>
                                    <th class="all"> عملیات </th>
                                </tr>
                                </thead>
                                <tbody>
                                {{--Loading by ajax--}}
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- END SAMPLE TABLE PORTLET-->
                @endpermission

                @permission((Config::get('constants.LIST_QUESTION_ACCESS')))
                <!-- BEGIN QUESTION TABLE PORTLET-->
                    <div class="portlet box yellow-casablanca" id="question-portlet">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i>مدیریت سؤالات مشاوره ای </div>
                            <div class="tools">
                                <img class="hidden" id="question-portlet-loading" src="{{Config::get('constants.ADMIN_LOADING_BAR_GIF')}}"  style="width: 50px;">
                                <a href="javascript:;" class="collapse" id="question-expand"> </a>
                                {{--<a href="#portlet-config" data-toggle="modal" class="config"> </a>--}}
                                @permission((Config::get('constants.LIST_QUESTION_ACCESS')))<a href="javascript:;" class="reload"> </a> @endpermission
                                <a href="javascript:;" class="remove"> </a>
                            </div>
                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body" style="display: block;">
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="btn-group">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="question_table">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th class="all"> دانش آموز </th>
                                    <th class="min-tablet">عنوان سؤال</th>
                                    <th class="all"> پخش </th>
                                    <th class="min-tablet"> دانلود </th>
                                    <th class="desktop"> وضعیت</th>
                                    <th class="desktop"> تاریخ پرسش</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{--Loading by ajax--}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END SAMPLE TABLE PORTLET-->
                @endpermission

                @permission((Config::get('constants.LIST_MBTIANSWER_ACCESS')))
                <!-- BEGIN QUESTION TABLE PORTLET-->
                <div class="portlet box " style="background-color: #e04ea6" id="mbtiAnswer-portlet">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs bg-font-dark"></i>لیست پاسخنامه های MBTI </div>
                        <div class="tools">
                            <img class="hidden" id="mbtiAnswer-portlet-loading" src="{{Config::get('constants.ADMIN_LOADING_BAR_GIF')}}"  style="width: 50px;">
                            <a href="javascript:;" class="collapse" id="mbtiAnswer-expand"> </a>
                            {{--<a href="#portlet-config" data-toggle="modal" class="config"> </a>--}}
                            @permission((Config::get('constants.LIST_MBTIANSWER_ACCESS')))<a href="javascript:;" class="reload"> </a> @endpermission
                            <a href="javascript:;" class="remove"> </a>
                        </div>
                        <div class="tools"> </div>
                    </div>
                    <div class="portlet-body" style="display: block;">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="mbtiAnswer_table">
                            <thead>
                            <tr>
                                <th></th>
                                <th class="all"> دانش آموز </th>
                                <th class="all"> شماره تماس </th>
                                <th class="min-tablet"> شهر </th>
                                <th class="min-tablet"> اردو </th>
                                <th class="none"> وضعیت سفارش </th>
                                <th class="desktop">عملیات</th>
                                <th class="desktop"> تاریخ ثبت</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--Loading by ajax--}}
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END SAMPLE TABLE PORTLET-->
                @endpermission

                @permission((Config::get('constants.LIST_EVENTRESULT_ACCESS')))
                <!-- BEGIN QUESTION TABLE PORTLET-->
                <div class="portlet box eventResult-portlet" style="background-color: #e04ea6">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs bg-font-dark"></i>لیست نتایج کنکور 96 </div>
                        <div class="tools">
                            <img class="hidden" id="konkurResult96-portlet-loading" src="{{Config::get('constants.ADMIN_LOADING_BAR_GIF')}}"  style="width: 50px;">
                            <a href="javascript:;" class="collapse" id="konkurResult96-expand"> </a>
                            {{--<a href="#portlet-config" data-toggle="modal" class="config"> </a>--}}
                            @permission((Config::get('constants.LIST_EVENTRESULT_ACCESS')))
                                <a href="javascript:;" class="reload" data-role="konkurResult96"> </a>
                            @endpermission
                            <a href="javascript:;" class="remove"> </a>
                        </div>
                        <div class="tools"> </div>
                    </div>
                    <div class="portlet-body" style="display: block;">
                        <div class="portlet box blue hidden" >
                            <style>
                                .form .form-row-seperated .form-group{
                                    border-bottom-color: #bfbfbf !important;
                                }
                            </style>
                            <div class="portlet-body form" style="border-top: #3598dc solid 1px" >
                                {!! Form::open(['class'=>'form-horizontal form-row-seperated' , 'id' => 'filterkonkurResult96Form']) !!}
                                        <input type="hidden" name="event_id[]" value="1">
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="konkurResult96_table">
                            <thead>
                            <tr>
                                <th></th>
                                <th class="all"> دانش آموز </th>
                                <th class="min-tablet"> شماره تماس </th>
                                <th class="min-tablet"> شهر </th>
                                <th class="min-tablet"> فایل کارنامه</th>
                                <th class="all"> رتبه </th>
                                <th class="min-tablet"> نظر </th>
                                <th class="min-tablet"> تاریخ درج </th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--Loading by ajax--}}
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END SAMPLE TABLE PORTLET-->

                <!-- BEGIN QUESTION TABLE PORTLET-->
                <div class="portlet box eventResult-portlet" style="background-color: #e04ea6">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs bg-font-dark"></i>لیست نتایج کنکور 97 </div>
                        <div class="tools">
                            <img class="hidden" id="konkurResult97-portlet-loading" src="{{Config::get('constants.ADMIN_LOADING_BAR_GIF')}}"  style="width: 50px;">
                            <a href="javascript:;" class="collapse" id="konkurResult97-expand"> </a>
                            {{--<a href="#portlet-config" data-toggle="modal" class="config"> </a>--}}
                            @permission((Config::get('constants.LIST_EVENTRESULT_ACCESS')))
                            <a href="javascript:;" class="reload" data-role="konkurResult97"> </a>
                            @endpermission
                            <a href="javascript:;" class="remove"> </a>
                        </div>
                        <div class="tools"> </div>
                    </div>
                    <div class="portlet-body" style="display: block;">
                        <div class="portlet box blue hidden" >
                            <style>
                                .form .form-row-seperated .form-group{
                                    border-bottom-color: #bfbfbf !important;
                                }
                            </style>
                            <div class="portlet-body form" style="border-top: #3598dc solid 1px" >
                                {!! Form::open(['class'=>'form-horizontal form-row-seperated' , 'id' => 'filterkonkurResult97Form']) !!}
                                    <input type="hidden" name="event_id[]" value="3">
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="konkurResult97_table">
                            <thead>
                            <tr>
                                <th></th>
                                <th class="all"> دانش آموز </th>
                                <th class="min-tablet"> شماره تماس </th>
                                <th class="min-tablet"> شهر </th>
                                <th class="min-tablet"> فایل کارنامه</th>
                                <th class="all"> رتبه </th>
                                <th class="min-tablet"> وضعیت </th>
                                <th class="min-tablet"> نظر </th>
                                <th class="min-tablet"> تاریخ درج </th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--Loading by ajax--}}
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END SAMPLE TABLE PORTLET-->
                @endpermission

                @permission((Config::get('constants.LIST_SHARIF_REGISTER_ACCESS')))
                <!-- BEGIN QUESTION TABLE PORTLET-->
                <div class="portlet box eventResult-portlet" style="background-color: #716c6f" >
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs bg-font-dark"></i>لیست پیش ثبت نام شریف </div>
                        <div class="tools">
                            <img class="hidden" id="sharifRegisterResult-loading" src="{{Config::get('constants.ADMIN_LOADING_BAR_GIF')}}"  style="width: 50px;">
                            <a href="javascript:;" class="collapse" id="sharifRegisterResult-expand"> </a>
                            @permission((Config::get('constants.LIST_SHARIF_REGISTER_ACCESS')))
                                <a href="javascript:;" class="reload" data-role="sharifRegisterResult"> </a>
                            @endpermission
                            <a href="javascript:;" class="remove"> </a>
                        </div>
                        <div class="tools"> </div>
                    </div>
                    <div class="portlet-body" style="display: block;">
                        <div class="portlet box blue hidden" >
                            <style>
                                .form .form-row-seperated .form-group{
                                    border-bottom-color: #bfbfbf !important;
                                }
                            </style>
                            <div class="portlet-body form" style="border-top: #3598dc solid 1px" >
                                {!! Form::open(['class'=>'form-horizontal form-row-seperated' , 'id' => 'filtersharifRegisterResultForm']) !!}
                                    <input type="hidden" name="event_id[]" value="2">
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sharifRegisterResult_table">
                            <thead>
                            <tr>
                                <th></th>
                                <th class="all"> نام خانوادگی </th>
                                <th class="all"> نام </th>
                                <th class="all"> استان </th>
                                <th class="all"> شهر </th>
                                <th class="min-tablet"> شماره تماس </th>
                                <th class="min-tablet">رشته</th>
                                <th class="all"> پایه </th>
                                <th class="all"> معدل </th>
                                <th class="min-tablet"> تاریخ ثبت نام </th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--Loading by ajax--}}
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END SAMPLE TABLE PORTLET-->
                @endpermission

                {{--@permission((Config::get('constants.LIST_ARTICLE_ACCESS')))--}}
                    {{--<!-- BEGIN ASSIGNMENT TABLE PORTLET-->--}}
                    {{--<div class="portlet box purple-plum" id="article-portlet">--}}
                        {{--<div class="portlet-title">--}}
                            {{--<div class="caption">--}}
                                {{--<i class="fa fa-cogs"></i>مدیریت مقالات </div>--}}
                            {{--<div class="tools">--}}
                                {{--<img class="hidden" id="article-portlet-loading" src="{{Config::get('constants.ADMIN_LOADING_BAR_GIF')}}"  style="width: 50px;">--}}
                                {{--<a href="javascript:;" class="collapse" id="article-expand"> </a>--}}
                                {{--<a href="#portlet-config" data-toggle="modal" class="config"> </a>--}}
                                {{--<a href="javascript:;" class="reload"> </a>--}}
                                {{--<a href="javascript:;" class="remove"> </a>--}}
                            {{--</div>--}}
                            {{--<div class="tools"> </div>--}}
                        {{--</div>--}}
                        {{--<div class="portlet-body" style="display: block;">--}}

                            {{--<div class="table-toolbar">--}}
                                {{--<div class="row">--}}
                                    {{--<div class="col-md-6">--}}

                                        {{--<div class="btn-group">--}}
                                            {{--@permission((Config::get('constants.INSERT_ARTICLE_ACCESS')))--}}
                                            {{--<a id="sample_editable_1_new" class="btn btn-outline blue-steel" href="{{action("ArticleController@create")}}"><i class="fa fa-plus"></i> افزودن مقاله </a>--}}
                                            {{--@endpermission--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<table class="table table-striped table-bordered table-hover dt-responsive " width="100%" id="article_table">--}}
                                {{--<thead>--}}
                                {{--<tr>--}}
                                    {{--<th></th>--}}
                                    {{--<th class="all"> نام </th>--}}
                                    {{--<th class="all"> عکس </th>--}}
                                    {{--<th class="all"> دسته </th>--}}
                                    {{--<th class="none"> خلاصه </th>--}}
                                    {{--<th class="none"> زمان اصلاح </th>--}}
                                    {{--<th class="all"> عملیات </th>--}}
                                {{--</tr>--}}
                                {{--</thead>--}}
                                {{--<tbody>--}}
                                {{--Loading by ajax--}}
                                {{--</tbody>--}}
                            {{--</table>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<!-- END SAMPLE TABLE PORTLET-->--}}
                {{--@endpermission--}}

                {{--@permission((Config::get('constants.LIST_ARTICLECATEGORY_ACCESS')))--}}
                {{--<!-- BEGIN ASSIGNMENT TABLE PORTLET-->--}}
                    {{--<div class="portlet box blue-steel" id="articlecategory-portlet">--}}
                    {{--<div class="portlet-title">--}}
                        {{--<div class="caption">--}}
                            {{--<i class="fa fa-cogs"></i>مدیریت دسته بندی مقالات </div>--}}
                        {{--<div class="tools">--}}
                            {{--<img class="hidden" id="articlecategory-portlet-loading" src="{{Config::get('constants.ADMIN_LOADING_BAR_GIF')}}"  style="width: 50px;">--}}
                            {{--<a href="javascript:;" class="collapse" id="articlecategory-expand"> </a>--}}
                            {{--<a href="#portlet-config" data-toggle="modal" class="config"> </a>--}}
                            {{--<a href="javascript:;" class="reload"> </a>--}}
                            {{--<a href="javascript:;" class="remove"> </a>--}}
                        {{--</div>--}}
                        {{--<div class="tools"> </div>--}}
                    {{--</div>--}}
                    {{--<div class="portlet-body" style="display: block;">--}}

                        {{--<div class="table-toolbar">--}}
                            {{--<div class="row">--}}
                                {{--<div class="col-md-6">--}}

                                    {{--<div class="btn-group">--}}
                                        {{--@permission((Config::get('constants.INSERT_ARTICLECATEGORY_ACCESS')))--}}
                                        {{--<a id="sample_editable_1_new" class="btn btn-outline blue-steel" data-toggle="modal" href="#responsive-articlecategory"><i class="fa fa-plus"></i> افزودن دسته بندی </a>--}}
                                        {{--<!-- responsive modal -->--}}
                                        {{--<div id="responsive-articlecategory" class="modal fade" tabindex="-1" data-width="760">--}}
                                            {{--<div class="modal-header">--}}
                                                {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>--}}
                                                {{--<h4 class="modal-title">افزودن دسته جدید</h4>--}}
                                            {{--</div>--}}
                                            {{--{!! Form::open(['method' => 'POST','action' => ['ArticlecategoryController@store'], 'class'=>'nobottommargin' , 'id'=>'articlecategoryForm']) !!}--}}
                                            {{--<div class="modal-body">--}}
                                                {{--<div class="row">--}}
                                                    {{--@include('articlecategory.form')--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--{!! Form::close() !!}--}}
                                            {{--<div class="modal-footer">--}}
                                                {{--<button type="button" data-dismiss="modal" class="btn btn-outline dark" id="articlecategoryForm-close">بستن</button>--}}
                                                {{--<button type="button" class="btn blue-steel" id="articlecategoryForm-submit">ذخیره</button>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--@endpermission--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<table class="table table-striped table-bordered table-hover dt-responsive " width="100%" id="articlecategory_table">--}}
                            {{--<thead>--}}
                            {{--<tr>--}}
                                {{--<th></th>--}}
                                {{--<th class="all"> نام </th>--}}
                                {{--<th class="all"> فعال بودن </th>--}}
                                {{--<th class="all"> زمان اصلاح </th>--}}
                                {{--<th class="none"> ترتیب : </th>--}}
                                {{--<th class="none"> خلاصه : </th>--}}
                                {{--<th class="all"> عملیات </th>--}}
                            {{--</tr>--}}
                            {{--</thead>--}}
                            {{--<tbody>--}}
                            {{--Loading by ajax--}}
                            {{--</tbody>--}}
                        {{--</table>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<!-- END SAMPLE TABLE PORTLET-->--}}
                {{--@endpermission--}}

        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src="/assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src="/assets/pages/scripts/ui-extended-modals.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/ui-toastr.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/components-editors.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/components-multi-select.min.js" type="text/javascript"></script>
@endsection

@section("extraJS")
    <script src="/js/extraJS/admin-indexContent.js" type="text/javascript"></script>
    <script src="/js/extraJS/scripts/admin-makeDataTable.js" type="text/javascript"></script>
    <script src="/assets/extra/jplayer/dist/jplayer/jquery.jplayer.min.js"  type="text/javascript"></script>
    <script type="text/javascript">
        /**
         * Start up jquery
         */
        jQuery(document).ready(function() {
            @permission((Config::get('constants.LIST_ASSIGNMENT_ACCESS')))
                $("#assignment-portlet .reload").trigger("click");
                $('#assignment_major').multiSelect();
                $("#assignment-expand").trigger("click");
                $('#assignmentSummerNote').summernote({height: 300});
            @endpermission
            @permission((Config::get('constants.LIST_CONSULTATION_ACCESS')))
                $("#consultation-portlet .reload").trigger("click");
                $('#consultation_major').multiSelect();
                $("#consultation-expand").trigger("click");
                $('#consultationSummerNote').summernote({height: 300});
            @endpermission
            @permission((Config::get('constants.LIST_QUESTION_ACCESS')))
                $("#question-portlet .reload").trigger("click");
                $("#question-expand").trigger("click");
            @endpermission
            @permission((Config::get('constants.LIST_MBTIANSWER_ACCESS')))
                $("#mbtiAnswer-portlet .reload").trigger("click");
                $("#mbtiAnswer-expand").trigger("click");
            @endpermission

            @permission((Config::get('constants.LIST_ARTICLE_ACCESS')))
                $("#article-portlet .reload").trigger("click");
                $("#article-expand").trigger("click");
            @endpermission

            @permission((Config::get('constants.LIST_ARTICLECATEGORY_ACCESS')))
                $("#articlecategory-portlet .reload").trigger("click");
                $("#articlecategory-expand").trigger("click");
            @endpermission

            @permission((Config::get('constants.LIST_EVENTRESULT_ACCESS')))
            $("#eventResult-portlet .reload").trigger("click");
            $("#konkurResult96-expand").trigger("click");
            $("#konkurResult97-expand").trigger("click");
            @endpermission

            @permission((Config::get('constants.LIST_SHARIF_REGISTER_ACCESS')))
            $(".eventResult-portlet .reload").trigger("click");
            $("#sharifRegisterResult-expand").trigger("click");
            @endpermission

            @permission((Config::get('constants.LIST_EDUCATIONAL_CONTENT_ACCESS')))
            // $("#educationalContent-portlet .reload").trigger("click");
            $("#educationalContent-expand").trigger("click");
            @endpermission


        });
    </script>
@endsection
@endpermission