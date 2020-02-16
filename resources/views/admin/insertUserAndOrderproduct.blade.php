@role((Config::get("constants.ROLE_ADMIN")))
@extends('partials.templatePage',['pageName'=>$pageName])

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">افزودن کاربر همراه سفارش</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    {{--Ajax modal loaded after inserting content--}}
    <div id = "ajax-modal" class = "modal fade" tabindex = "-1"></div>
    {{--Ajax modal for panel startup --}}

    @include("systemMessage.flash")

    <div class = "row">
        <div class = "col-md-12">
            <!-- BEGIN Portlet PORTLET-->
            <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
                {!! Form::open(['method' => 'POST', 'action' => 'Web\AdminController@registerUserAndGiveOrderproduct']) !!}
                <div class = "m-portlet__body">
                    <div class = "row">
                        <div class = "col-md-6">
                            <p>{!! Form::text('firstName', null, ['class' => 'form-control', 'id' => 'firstName' , 'placeholder'=>'نام']) !!}
                                <span class="form-control-feedback">
                                    <strong></strong>
                                 </span>
                            </p>
                            <p>{!! Form::text('nationalCode', null, ['class' => 'form-control', 'id' => 'nationalCode'  , 'maxlength'=>'10' , 'placeholder'=>'کد ملی']) !!}
                                <span class="form-control-feedback">
                                      <strong></strong>
                                </span>
                            </p>
                        </div>
                        <div class = "col-md-6">
                            <p>{!! Form::text('lastName', null, ['class' => 'form-control', 'id' => 'lastName' , 'placeholder'=>'نام خانوادگی']) !!}
                                <span class="form-control-feedback">
                         <strong></strong>
                        </span>
                            </p>
                            <p>{!! Form::text('mobile', null, ['class' => 'form-control', 'id' => 'mobile' , 'maxlength'=>'11' , 'placeholder'=>'موبایل']) !!}
                                <span class="form-control-feedback">
                            <strong></strong>
                         </span>
                            </p>
                        </div>
                        <div class = "col-md-6">
                            <p>{!! Form::select('major_id', $majors, null,['class' => 'form-control', 'id' => 'userMajor', 'placeholder' => 'رشته نامشخص']) !!}
                                <span class="form-control-feedback">
                                    <strong></strong>
                                </span>
                            </p>
                        </div>
                        <div class = "col-md-6">
                            <p>{!! Form::select('gender_id', $genders, null,['class' => 'form-control', 'id' => 'userGender', 'placeholder' => 'جنسیت نامشخص']) !!}
                                <span class="form-control-feedback">
                                 <strong></strong>
                                </span>
                            </p>
                        </div>
                        <div class = "col-12 text-center">
                            <input type = "submit" value = "درج">
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- END Portlet PORTLET-->
        </div>
    </div>
@endsection

@endrole
