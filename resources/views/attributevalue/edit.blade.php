@permission((Config::get('constants.SHOW_ATTRIBUTEVALUE_ACCESS')))
@extends('partials.templatePage',['pageName'=>'admin'])

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
                <a class = "m-link" href = "#">اصلاح مقدار صفت</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class = "row">
        <div class = "col-md-2"></div>
        <div class = "col-md-8 ">
            <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
                            <h3 class = "m-portlet__head-text">
                                <i class = "fa fa-cogs m--margin-right-10"></i>
                                اصلاح مقدار صفت {{$attributevalue->name}}
                            </h3>
                        </div>
                    </div>
                    <div class = "m-portlet__head-tools">
                        <a class = "btn btn-primary m-btn m-btn--icon m-btn--wide" href = "{{action("Web\AttributeController@edit",$attribute)}}"> بازگشت
                            <i class = "fa fa-angle-left"></i>
                        </a>
                    </div>
                </div>
                <div class = "m-portlet__body">
                    {!! Form::model($attributevalue,['method' => 'PUT','action' => ['Web\AttributevalueController@update',$attributevalue], 'class'=>'form-horizontal']) !!}
                    @include('attributevalue.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@endpermission
