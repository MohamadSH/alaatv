@role(('admin'))
@extends('partials.templatePage',['pageName'=>'admin'])

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item" aria-current = "page">
                <a class = "m-link" href = "{{action("Web\AdminController@admin")}}">پنل مدیریتی</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">اصلاح نقش</a>
            </li>
        </ol>
    </nav>
@endsection

@section("content")
    <div class = "row">
        <div class = "col-md-2"></div>
        <div class = "col-md-8">
        @include("systemMessage.flash")
        <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-" id = "product-portlet">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
                            <h3 class = "m-portlet__head-text">
                                <i class = "fa fa-cogs"></i>
                                اصلاح {{$role->display_name}}
                            </h3>
                        </div>
                    </div>
                    <div class = "m-portlet__head-tools">
                        <a class = "btn m-btn--air btn-primary" href = "{{action("Web\AdminController@admin")}}"> بازگشت
                            <i class = "fa fa-angle-left"></i>
                        </a>
                    </div>
                </div>
                <div class = "m-portlet__body">
                    {!! Form::model($role,['files'=>true,'method' => 'PUT','action' => ['Web\RoleController@update',$role], 'class'=>'form-horizontal']) !!}
                    @include('role.form')
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->
        </div>
        <div class = "col-md-2"></div>
    </div>
@endsection

@section('page-js')
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
@endsection
@endrole
