@permission((Config::get('constants.SHOW_ATTRIBUTEGROUP_ACCESS')))
@extends('partials.templatePage',['pageName'=>'admin'])

@section('page-css')
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/css/multi-select-rtl.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item" aria-current = "page">
                <a class = "m-link" href = "{{action("Web\AdminController@adminProduct")}}">پنل مدیریت محصولات</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">اصلاح اطلاعات گروه صفت</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class = "row">
        <div class = "col-md-2"></div>
        <div class = "col-md-8">
            @include("systemMessage.flash")

            <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
                            <h3 class = "m-portlet__head-text">
                                <i class = "fa fa-cogs m--margin-right-10"></i>
                                اصلاح اطلاعات گروه صفت {{$attributegroup->name}}
                            </h3>
                        </div>
                    </div>
                    <div class = "m-portlet__head-tools">
                        <a class = "btn btn-primary m-btn m-btn--icon m-btn--wide" href = "{{action("Web\AttributesetController@edit" , $attributeset)}}"> بازگشت
                            <i class = "fa fa-angle-left"></i>
                        </a>
                    </div>
                </div>
                <div class = "m-portlet__body">
                    {!! Form::model($attributegroup,['method' => 'PUT','action' => ['Web\AttributegroupController@update',$attributegroup], 'class'=>'form-horizontal']) !!}
                    @include('attributegroup.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src = "/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/select2/js/select2.full.min.js" type = "text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src = "/assets/pages/scripts/components-multi-select.min.js" type = "text/javascript"></script>
@endsection


@section("extraJS")
    <script>
        jQuery(document).ready(function () {
            $('#group_attributes').multiSelect();
        });
    </script>
@endsection
@endpermission
