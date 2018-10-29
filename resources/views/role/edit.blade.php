@role(('admin'))
@extends("app",["pageName"=>"admin"])

@section("headPageLevelPlugin")
    <link href="/assets/global/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css" rel="stylesheet"
          type="text/css"/>
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
                <a href="{{action("HomeController@admin")}}">پنل مدیریتی</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>اصلاح نقش</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
        @include("systemMessage.flash")
        <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase">اصلاح {{$role->display_name}}</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a class="btn btn-sm dark dropdown-toggle" href="{{action("HomeController@admin")}}"> بازگشت
                                <i class="fa fa-angle-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body form">
                    {!! Form::model($role,['files'=>true,'method' => 'PUT','action' => ['RoleController@update',$role], 'class'=>'form-horizontal']) !!}
                    @include('role.form')
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->

        </div>
    </div>
@endsection

@section("footerPageLevelScript")
    <script src="/assets/pages/scripts/components-bootstrap-multiselect.min.js" type="text/javascript"></script>
@endsection

@section("extraJS")
    <script src="/js/extraJS/scripts/admin-makeMultiSelect.js" type="text/javascript"></script>
@endsection
@endrole
