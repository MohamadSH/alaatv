@permission((Config::get('constants.SHOW_ATTRIBUTEVALUE_ACCESS')))
@extends("app",["pageName"=>"admin"])

@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <a href = "{{action("Web\HomeController@adminProduct")}}">پنل مدیریت محصولات</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>اصلاح مقدار صفت</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 ">
        @include("systemMessage.flash")
        <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase">اصلاح مقدار صفت {{$attributevalue->name}}</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a class="btn btn-sm dark dropdown-toggle" href = "{{action("Web\AttributeController@edit",$attribute)}}"> بازگشت
                                <i class="fa fa-angle-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body form">
                    {!! Form::model($attributevalue,['method' => 'PUT','action' => ['AttributevalueController@update',$attributevalue], 'class'=>'form-horizontal']) !!}
                    @include('attributevalue.form')
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->
        </div>
    </div>
@endsection

@endpermission
