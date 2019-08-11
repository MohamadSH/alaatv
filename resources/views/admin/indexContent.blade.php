@extends('app')

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="flaticon-home-2 m--padding-right-5"></i>
                <a class="m-link" href="{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#">پنل مدیریت محتوا</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col">

            {{--<div class="note note-info">--}}
            {{--<h4 class="block"><strong>توجه!</strong></h4>--}}
            {{--@role(('admin'))<p class="bold m--font-danger" style="font-size: x-large">ادمین محترم لیست پاسخنامه های MBTI به این صفحه اضافه شده است . لطفا کش مرورگر خود را خالی کنید</p>@endrole--}}
            {{--<strong class="m--font-danger"> اگر این بار اول است که از تاریخ ۳ اسفند به بعد از این پنل استفاده می کنید ، لطفا کش بروزر خود را خالی نمایید . با تشکر</strong>--}}
            {{--</div>--}}

            @permission((config('constants.LIST_EDUCATIONAL_CONTENT_ACCESS')))
            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--head-solid-bg m-portlet--accent m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="content-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                مدیریت محتوای آموزشی
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <img class="d-none" id="content-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" alt="loading" style="width: 50px;">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                    <i class="fa fa-redo"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="content-expand">
                                    <i class="fa fa-expand-arrows-alt"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-times"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="portlet box blue" style="background: #e7ecf1">
                        {{--<div class="portlet-title">--}}
                        {{--<div class="caption "><h3 class="bold">--}}
                        {{--<i class="fa fa-filter"></i>فیلتر جدول</h3></div>--}}
                        {{--</div>--}}
                        <style>
                            .form .form-row-seperated .form-group {
                                border-bottom-color: #bfbfbf !important;
                            }
                        </style>
                        <div class="portlet-body form" style="border-top: #3598dc solid 1px">
                            {!! Form::open(['method' => 'GET','action' => ['Web\ContentController@index'],'class'=>'form-horizontal form-row-seperated' , 'id' => 'filterContentForm']) !!}
                            <div class="form-body m--padding-15" style="background: #e7ecf1">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-2 bold control-label">تاریخ درج :</label>
                                        <div class="col-md-10">
                                            <div class="row">
                                                {{--<label class="control-label" style="float: right;"><label class="mt-checkbox mt-checkbox-outline">--}}
                                                {{--<input type="checkbox" id="contentCreatedTimeEnable" value="1" name="createdTimeEnable" checked >--}}
                                                {{--<span class="bg-grey-cararra"></span>--}}
                                                {{--</label>--}}
                                                {{--</label>--}}
                                                <label class="control-label" style=" float: right;">از تاریخ</label>
                                                <div class="col-md-3 col-xs-12">
                                                    <input id="contentCreatedSince" type="text" class="form-control">
                                                    <input name="createdAtSince" id="contentCreatedSinceAlt" type="text" class="form-control d-none">
                                                </div>
                                                <label class="control-label" style="float: right;">تا تاریخ</label>
                                                <div class="col-md-3 col-xs-12">
                                                    <input id="contentCreatedTill" type="text" class="form-control">
                                                    <input name="createdAtTill" id="contentCreatedTillAlt" type="text" class="form-control d-none">
                                                </div>
                                            </div>
                                            {{--                                            @include('admin.filters.timeFilter.createdAt' , ["id" => "content" , "default" => true])--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <a href="javascript:" class="btn btn-lg bg-font-dark reload" style="background: #489fff">فیلتر</a>
                                        <img class="d-none" id="userBon-portlet-loading" src="{{config('constants.FILTER_LOADING_GIF')}}" width="5%">
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="btn-group">
                                    @permission((config('constants.INSERT_EDUCATIONAL_CONTENT_ACCESS')))
                                    {{--                                        <a  class="btn btn-outline red" target="_blank" href="{{action("Web\ContentController@create2")}}"><i class="fa fa-plus"></i> افزودن محتوا </a>--}}
                                    <a class="btn m-btn--pill m-btn--air btn-outline-danger" target="_blank" href="{{action("Web\ContentController@create2")}}">
                                        <i class="fa fa-plus"></i>
                                        افزودن محتوا
                                    </a>
                                    <a class="btn m-btn--pill m-btn--air btn-outline-danger" target="_blank" href="{{action("Web\ContentController@create")}}">
                                        <i class="fa fa-plus"></i>
                                        آپلود محتوا
                                    </a>
                                    <a class="btn m-btn--pill m-btn--air btn-outline-danger" target="_blank" href="{{action("Web\SetController@create")}}">
                                        <i class="fa fa-plus"></i>
                                        دسته محتوای جدید
                                    </a>
                                    @endpermission
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive " width="100%" id="content_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="all"> نام</th>
                            <th class="desktop"> فعال/غیرفعال</th>
                            <th class="desktop "> نوع محتوا</th>
                            <th class="none"> فایل ها</th>
                            <th class="desktop"> توضیح</th>
                            <th class="none"> زمان نمایان شدن</th>
                            <th class="none"> زمان درج</th>
                            <th class="none"> زمان اصلاح</th>
                            <th class="all"> عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--Loading by ajax--}}
                        </tbody>
                    </table>
                </div>
            </div>
            <!--end::Portlet-->
            @endpermission

            @if(false)
            @permission((config('constants.LIST_ASSIGNMENT_ACCESS')))
            <!-- BEGIN ASSIGNMENT TABLE PORTLET-->
            <div class="m-portlet m-portlet--head-solid-bg m-portlet--info m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="assignment-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                مدیریت تمرین ها
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <img class="d-none" id="assignment-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" alt="loading" style="width: 50px;">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                    <i class="fa fa-redo"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="assignment-expand">
                                    <i class="fa fa-expand-arrows-alt"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-times"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="btn-group">
                                    @permission((config('constants.INSERT_ASSIGNMENT_ACCESS')))
                                    <a id="sample_editable_1_new" class="btn btn-outline purple" data-toggle="modal" href="#responsive-assignment" data-target="#responsive-assignment">
                                        <i class="fa fa-plus"></i>
                                        افزودن تمرین
                                    </a>


                                    <!--begin::Modal-->
                                    <div class="modal fade" id="responsive-assignment" tabindex="-1" role="dialog" aria-labelledby="responsive-assignmentModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="responsive-assignmentModalLabel">افزودن تمرین جدید</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                {!! Form::open(['files'=>true,'method' => 'POST','action' => ['Web\AssignmentController@store'], 'class'=>'nobottommargin' , 'id'=>'assignmentForm']) !!}
                                                <div class="modal-body">
                                                    <div class="row">
                                                        @include('assignment.form')
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="assignmentForm-close">بستن</button>
                                                    <button type="button" class="btn btn-primary" id="assignmentForm-submit">ذخیره</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Modal-->@endpermission
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive " width="100%" id="assignment_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="all"> نام</th>
                            <th class="desktop"> توضیح</th>
                            <th class="none"> رشته</th>
                            <th class="none"> تعداد سؤالات</th>
                            <th class="none"> سؤالات</th>
                            <th class="none"> پاسخ</th>
                            <th class="none"> تحلیل آزمون</th>
                            <th class="min-tablet"> وضعیت</th>
                            <th class="none"> زمان درج</th>
                            <th class="none"> زمان اصلاح</th>
                            <th class="all"> عملیات</th>
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

            @permission((config('constants.LIST_CONSULTATION_ACCESS')))
            <!-- BEGIN CONSULTATION TABLE PORTLET-->
            <div class="m-portlet m-portlet--head-solid-bg m-portlet--primary m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="consultation-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                مدیریت مشاوره ها
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <img class="d-none" id="consultation-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" alt="loading" style="width: 50px;">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                    <i class="fa fa-redo"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="consultation-expand">
                                    <i class="fa fa-expand-arrows-alt"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-times"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    @permission((config('constants.INSERT_CONSULTATION_ACCESS')))
                                    <a id="sample_editable_2_new" class="btn btn-outline blue" data-toggle="modal" href="#responsive-consultation" data-target="#responsive-consultation">
                                        <i class="fa fa-plus"></i>
                                        افزودن مشاوره
                                    </a>

                                    <!--begin::Modal-->
                                    <div class="modal fade" id="responsive-consultation" tabindex="-1" role="dialog" aria-labelledby="responsive-consultationModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="responsive-consultationModalLabel">افزودن مشاوره جدید</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                {!! Form::open(['files'=>true,'method' => 'POST','action' => ['Web\ConsultationController@store'], 'class'=>'nobottommargin' , 'id'=>'consultationForm']) !!}
                                                <div class="modal-body">
                                                    <div class="row">
                                                        @include('consultation.form')
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="consultationForm-close">بستن</button>
                                                    <button type="button" class="btn btn-primary" id="consultationForm-submit">ذخیره</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Modal-->@endpermission
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="consultation_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="all"> نام</th>
                            <th class="desktop"> تامبنیل</th>
                            <th class="desktop"> توضیح</th>
                            <th class="none"> رشته</th>
                            <th class="none"> فیلم</th>
                            <th class="none"> متن</th>
                            <th class="min-tablet"> وضعیت</th>
                            <th class="none"> زمان درج</th>
                            <th class="none"> زمان اصلاح</th>
                            <th class="all"> عملیات</th>
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

            @permission((config('constants.LIST_QUESTION_ACCESS')))
            <!-- BEGIN QUESTION TABLE PORTLET-->
            <div class="m-portlet m-portlet--head-solid-bg m-portlet--success m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="question-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                مدیریت سؤالات مشاوره ای
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <img class="d-none" id="question-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" style="width: 50px;">
                        <ul class="m-portlet__nav">
                            @permission((config('constants.LIST_QUESTION_ACCESS')))
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                    <i class="fa fa-redo"></i>
                                </a>
                            </li>
                            @endpermission
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="question-expand">
                                    <i class="fa fa-expand-arrows-alt"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-times"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group"></div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="question_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="all"> دانش آموز</th>
                            <th class="min-tablet">عنوان سؤال</th>
                            <th class="all"> پخش</th>
                            <th class="min-tablet"> دانلود</th>
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

            @permission((config('constants.LIST_MBTIANSWER_ACCESS')))
            <!-- BEGIN QUESTION TABLE PORTLET-->
            <div class="m-portlet m-portlet--head-solid-bg m-portlet--warning m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="mbtiAnswer-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                لیست پاسخنامه های MBTI
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <img class="d-none" id="mbtiAnswer-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" style="width: 50px;">
                        <ul class="m-portlet__nav">
                            @permission((config('constants.LIST_MBTIANSWER_ACCESS')))
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                    <i class="fa fa-redo"></i>
                                </a>
                            </li>
                            @endpermission
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="mbtiAnswer-expand">
                                    <i class="fa fa-expand-arrows-alt"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-times"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group"></div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="mbtiAnswer_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="all"> دانش آموز</th>
                            <th class="all"> شماره تماس</th>
                            <th class="min-tablet"> شهر</th>
                            <th class="min-tablet"> اردو</th>
                            <th class="none"> وضعیت سفارش</th>
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
            @endif

            {{--@permission((config('constants.LIST_ARTICLE_ACCESS')))--}}
            {{--<!-- BEGIN ASSIGNMENT TABLE PORTLET-->--}}
            {{--<div class="portlet box purple-plum" id="article-portlet">--}}
            {{--<div class="portlet-title">--}}
            {{--<div class="caption">--}}
            {{--<i class="fa fa-cogs"></i>مدیریت مقالات </div>--}}
            {{--<div class="tools">--}}
            {{--<img class="d-none" id="article-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}"  style="width: 50px;">--}}
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
            {{--@permission((config('constants.INSERT_ARTICLE_ACCESS')))--}}
            {{--<a id="sample_editable_1_new" class="btn btn-outline blue-steel" href="{{action("Web\ArticleController@create")}}"><i class="fa fa-plus"></i> افزودن مقاله </a>--}}
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

            {{--@permission((config('constants.LIST_ARTICLECATEGORY_ACCESS')))--}}
            {{--<!-- BEGIN ASSIGNMENT TABLE PORTLET-->--}}
            {{--<div class="portlet box blue-steel" id="articlecategory-portlet">--}}
            {{--<div class="portlet-title">--}}
            {{--<div class="caption">--}}
            {{--<i class="fa fa-cogs"></i>مدیریت دسته بندی مقالات </div>--}}
            {{--<div class="tools">--}}
            {{--<img class="d-none" id="articlecategory-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}"  style="width: 50px;">--}}
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
            {{--@permission((config('constants.INSERT_ARTICLECATEGORY_ACCESS')))--}}
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

@section('page-js')
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/acm/AlaatvCustomFiles/js/admin/page-contentAdmin.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        /**
         * Start up jquery
         */
        jQuery(document).ready(function () {
        // @permission((config('constants.LIST_ASSIGNMENT_ACCESS')));
        //     $("#assignment-portlet .reload").trigger("click");
        //     $('#assignment_major').multiSelect();
        //     $("#assignment-expand").trigger("click");
        //     $('#assignmentSummerNote').summernote({
        //         lang: 'fa-IR',
        //         height: 300,
        //         popover: {
        //             image: [],
        //             link: [],
        //             air: []
        //         }
        //     });
        // @endpermission;
        // @permission((config('constants.LIST_CONSULTATION_ACCESS')));
        //     $("#consultation-portlet .reload").trigger("click");
        //     $('#consultation_major').multiSelect();
        //     $("#consultation-expand").trigger("click");
        //     $('#consultationSummerNote').summernote({
        //         lang: 'fa-IR',
        //         height: 300,
        //         popover: {
        //             image: [],
        //             link: [],
        //             air: []
        //         }
        //     });
        // @endpermission;
        // @permission((config('constants.LIST_QUESTION_ACCESS')));
        //     $("#question-portlet .reload").trigger("click");
        //     $("#question-expand").trigger("click");
        // @endpermission;
        // @permission((config('constants.LIST_MBTIANSWER_ACCESS')));
        //     $("#mbtiAnswer-portlet .reload").trigger("click");
        //     $("#mbtiAnswer-expand").trigger("click");
        // @endpermission;
        // @permission((config('constants.LIST_ARTICLE_ACCESS')));
        //     $("#article-portlet .reload").trigger("click");
        //     $("#article-expand").trigger("click");
        // @endpermission;
        //
        // @permission((config('constants.LIST_ARTICLECATEGORY_ACCESS')));
        //     $("#articlecategory-portlet .reload").trigger("click");
        //     $("#articlecategory-expand").trigger("click");
        // @endpermission;

        @permission((config('constants.LIST_EDUCATIONAL_CONTENT_ACCESS')));
            // $("#content-portlet .reload").trigger("click");
            $("#content-expand").trigger("click");
        @endpermission
        });
    </script>
@endsection
