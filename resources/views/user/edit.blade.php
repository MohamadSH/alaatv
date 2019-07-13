@permission((config('constants.SHOW_USER_ACCESS')))

@extends('app' , ['pageName' => 'admin'])

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        h2.m-portlet__head-label.m-portlet__head-label--success {
            white-space: nowrap;
            line-height: 50px;
        }
    </style>
@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "flaticon-home-2 m--padding-right-5"></i>
                <a class = "m-link" href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item">
                <a class = "m-link" href = "{{action("Web\AdminController@admin")}}">پنل مدیریتی</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#"> اصلاح اطلاعات کاربر</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    
    @include('systemMessage.flash')

    <div class = "row">
        <div class = "col-md-3"></div>
        <div class = "col-md-6">


            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class = "m-portlet m-portlet--creative m-portlet--bordered-semi">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
						<span class = "m-portlet__head-icon m--hide">
							<i class = "flaticon-statistics"></i>
						</span>
                            <h3 class = "m-portlet__head-text">

                            </h3>
                            <h2 class = "m-portlet__head-label m-portlet__head-label--success">
                                <i class = "flaticon-cogwheel"></i>
                                اصلاح اطلاعات

                                @if(!isset($user->firstName) && !isset($user->lastName))
                                کاربر
                                ناشناس
                                @else
                                    @if(isset($user->firstName))
                                        {{$user->firstName}}
                                    @endif
                                    @if(isset($user->lastName))
                                        {{$user->lastName}}
                                    @endif
                                @endif

                            </h2>
                        </div>
                    </div>
                    <div class = "m-portlet__head-tools">
                        <a class = "btn btn-sm btn-primary m-btn--air" href = "{{action("Web\AdminController@admin")}}"> بازگشت
                            <i class = "fa fa-angle-left"></i>
                        </a>
                    </div>
                </div>
                <div class = "m-portlet__body">

                    <div class = "portlet-body form">
                        {!! Form::model($user,['files'=>true,'method' => 'PUT','action' => ['Web\UserController@update',$user], 'class'=>'form-horizontal']) !!}
                        {!! Form::hidden('updateType',"total") !!}
                        @include('user.form',[$userStatuses , $majors ])
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->

        </div>
    </div>
@endsection


@section('page-js')
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/acm/AlaatvCustomFiles/js/admin/page-user-edit.js') }}" type="text/javascript"></script>
@endsection

@endpermission
