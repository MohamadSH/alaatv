@role((Config::get("constants.ROLE_ADMIN")))
@extends("app",["pageName"=>$pageName])

@section("headPageLevelPlugin")
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
                <a href="{{action("IndexPageController")}}">@lang('page.Home')</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>افزودن کاربر همراه سفارش</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    {{--Ajax modal loaded after inserting content--}}
    <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
    {{--Ajax modal for panel startup --}}
    <div class="row">
        @include("systemMessage.flash")
        <div class="col-md-12">
            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet light">
                <div class="portlet-body">
                    <div class="row">
                        {!! Form::open(['method' => 'POST', 'action' => 'HomeController@registerUserAndGiveOrderproduct']) !!}
                        <div class="col-md-6">
                            <p>{!! Form::text('firstName', null, ['class' => 'form-control', 'id' => 'firstName' , 'placeholder'=>'نام']) !!}
                                <span class="help-block">
                                    <strong></strong>
                                 </span>
                            </p>
                            <p>{!! Form::text('nationalCode', null, ['class' => 'form-control', 'id' => 'nationalCode'  , 'maxlength'=>'10' , 'placeholder'=>'کد ملی']) !!}
                                <span class="help-block">
                                      <strong></strong>
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p>{!! Form::text('lastName', null, ['class' => 'form-control', 'id' => 'lastName' , 'placeholder'=>'نام خانوادگی']) !!}
                                <span class="help-block">
                         <strong></strong>
                        </span>
                            </p>
                            <p>{!! Form::text('mobile', null, ['class' => 'form-control', 'id' => 'mobile' , 'maxlength'=>'11' , 'placeholder'=>'موبایل']) !!}
                                <span class="help-block">
                            <strong></strong>
                         </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p>{!! Form::select('major_id', $majors, null,['class' => 'form-control', 'id' => 'userMajor', 'placeholder' => 'رشته نامشخص']) !!}
                                <span class="help-block">
                                    <strong></strong>
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p>{!! Form::select('gender_id', $genders, null,['class' => 'form-control', 'id' => 'userGender', 'placeholder' => 'جنسیت نامشخص']) !!}
                                <span class="help-block">
                                 <strong></strong>
                                </span>
                            </p>
                        </div>
                        <input type="submit" value="درج">
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <!-- END Portlet PORTLET-->
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")

@endsection

@section("footerPageLevelScript")

@endsection

@section("extraJS")

@endsection
@endrole