@permission((Config::get('constants.SHOW_PERMISSION_ACCESS')))
@extends("app",["pageName"=>"admin"])

@section("headPageLevelPlugin")
    <link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
@endsection

@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <a href = "{{action("Web\HomeController@admin")}}">پنل مدیریتی</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>اصلاح اطلاعات دسترسی</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6 ">
        @include("systemMessage.flash")
        <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase">اصلاح اطلاعات دسترسی {{$permission->display_name}}</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a class = "btn btn-sm dark dropdown-toggle" href = "{{action("Web\HomeController@admin")}}"> بازگشت
                                <i class="fa fa-angle-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body form">
                    {!! Form::model($permission,['method' => 'PUT','action' => ['PermissionController@update',$permission], 'class'=>'form-horizontal']) !!}
                    @include('permission.form')
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->

        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
@endsection

@section("footerPageLevelScript")
@endsection
@endpermission


