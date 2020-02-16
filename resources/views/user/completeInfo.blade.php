@extends('partials.templatePage')

@section("headPageLevelPlugin")
    <link href = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("headPageLevelStyle")
    <link href = "/assets/pages/css/profile-2-rtl.min.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("css")
    @parent()
    <style>
        .widget-thumb .widget-thumb-wrap .widget-thumb-icon {
            height: unset !important;
            width: unset !important;
        }
    </style>
@endsection

@section("pageBar")
@show

@section("content")
    <h1 class = "page-title"> فرم تکمیل اطلاعات
        <small class = "m--font-danger">لطفا در کمال دقت و صحت تکمیل نمایید</small>
    </h1>
    @include("systemMessage.flash")
    {!! Form::model($user,['files'=>true , 'method'=>'POST' , 'action' => ['UserController@completeInformation',$user] ,'role'=>'form' , 'class'=>'form-horizontal ' ]) !!}
    <div class = "portlet box blue-hoki">
        <div class = "portlet-title" style = "background: #404040 !important">
            <div class = "caption">
                شما در {{$userProduct}} ثبت نام نموده اید
            </div>
            <div class = "actions">
                <button type = "submit" class = "btn btn-sm" style = "background: #67BCDB !important;">
                    <i class = "fa fa-pencil"></i>
                    ذخیره
                </button>
            </div>
        </div>
        <div class = "portlet-body">
            <div class = "tabbable-line tabbable-full-width">
                <div class = "row widget-row margin-bottom-20">
                    <div class = "col-md-3 col-lg-3 col-sd-3 col-xs-12">
                        <!-- BEGIN WIDGET THUMB -->
                        <div class = "widget-thumb text-uppercase margin-bottom-20 " style = "background: #EFEFEF;">
                            <h4 class = "widget-thumb-heading">میزان تکمیل اطلاعات</h4>
                            <div class = "widget-thumb-wrap ">
                                <img class = "widget-thumb-icon" src = "/img/extra/checklist-icon.png">
                                <div class = "widget-thumb-body ">
                                    <span class = "widget-thumb-subtitle @if($completionPercentage==100) font-green @endif">%</span>
                                    <span class = "widget-thumb-body-stat @if($completionPercentage==100) font-green @endif" data-counter = "counterup" data-value = "{{(isset($completionPercentage))?$completionPercentage:0}}">0</span>
                                </div>
                            </div>
                        </div>
                        <!-- END WIDGET THUMB -->
                    </div>
                    <div class = "col-md-9 col-lg-9 col-sd-9 col-xs-12">
                        <div class = "m-heading-1 border-blue m-bordered">
                            <p class = "text-justify">
                                کاربر گرامی توجه داشته باشید که پس از تکمیل اطلاعات به میزان ۱۰۰ درصد ، فرم
                                <strong class = "m--font-danger">قفل</strong> خواهد شد و قادر به اطلاح اطلاعات نخواهید بود. لذا خواهشمند است اطلاعات را در کمال صحت و دقت وارد نمایید.
                            </p>
                        </div>
                    </div>
                </div>
                <div class = "row profile-account">
                    <div class = "col-md-3 col-lg-3 col-sd-3 col-xs-12">
                        <ul class = "ver-inline-menu tabbable margin-bottom-10">
                            <li class = "active">
                                <a data-toggle = "tab" href = "#tab_1-1">
                                    <img src = "/img/extra/person-icon-rs.png">
                                    مشخصات فردی
                                </a>
                                <span class = "after"> </span>
                            </li>
                            @if(isset($userHasMedicalQuestions) && $userHasMedicalQuestions)
                                <li>
                                    <a data-toggle = "tab" href = "#tab_2-2">
                                        <img src = "/img/extra/doctor-icon.svg" height = "35px" width = "35px">
                                        اطلاعات پزشکی
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a data-toggle = "tab" href = "#tab_3-3">
                                    <img src = "/img/extra/education-icon-rs.png">
                                    اطلاعات تحصیلی
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class = "col-md-9 col-lg-9 col-sd-9 col-xs-12">
                        <div class = "tab-content">
                            <div id = "tab_1-1" class = "tab-pane active">
                                <div class = "form-body margin-top-30">
                                    <div class = "col-lg-6 col-md-6 col-sd-6 col-xs-12">
                                        <div class = "form-group">
                                            <label class = "control-label col-md-3 col-lg-3 col-sd-3 col-xs-12">نام</label>
                                            <div class = "col-md-9 col-lg-9 col-sd-9 col-xs-12">
                                                {{--{!! Form::text("firstName" , null , ["class"=>"form-control"]) !!}--}}
                                                <text class = "form-control-static" style = "margin-top:0px !important;">@if(isset($user)){{$user->firstName}}@else
                                                        - @endif</text>
                                                <span class="form-control-feedback"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class = "col-lg-6 col-md-6 col-sd-6 col-xs-12">
                                        <div class = "form-group">
                                            <label class = "control-label col-md-3 col-lg-3 col-sd-3 col-xs-12">نام خانوادگی</label>
                                            <div class = "col-md-9 col-lg-9 col-sd-9 col-xs-12">
                                                {{--{!! Form::text("lastName" , null , ["class"=>"form-control"]) !!}--}}
                                                <text class = "form-control-static" style = "margin-top:0px !important;">@if(isset($user)){{$user->lastName}}@else
                                                        - @endif</text>
                                                <span class="form-control-feedback"> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class = "col-lg-6 col-md-6 col-sd-6 col-xs-12">
                                        <div class = "form-group">
                                            <label class = "control-label col-md-3 col-lg-3 col-sd-3 col-xs-12">کد ملی</label>
                                            <div class = "col-md-9 col-lg-9 col-sd-9 col-xs-12">
                                                {{--                                                {!! Form::text("nationalCode" , null , ["class"=>"form-control" , "dir"=>"ltr"]) !!}--}}
                                                <text class = "form-control-static" style = "margin-top:0px !important;">@if(isset($user)){{$user->nationalCode}}@else
                                                        - @endif</text>
                                                <span class="form-control-feedback">  </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class = "col-lg-6 col-md-6 col-sd-6 col-xs-12">
                                        <div class = "form-group">
                                            <label class = "control-label col-md-3 col-lg-3 col-sd-3 col-xs-12">جنسیت</label>
                                            <div class = "col-md-9 col-lg-9 col-sd-9 col-xs-12">
                                                @if(in_array("gender_id" , $lockedFields) || $completionPercentage == 100)
                                                    <text class = "form-control-static" style = "margin-top:0px !important;">@if(isset($user->gender_id)){{$user->gender->name}}@else
                                                            - @endif</text>
                                                @else
                                                    {!! Form::select('gender_id' , $genders, null, ['class' => 'form-control']) !!}
                                                @endif
                                                <span class="form-control-feedback"> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class = "col-lg-6 col-md-6 col-sd-6 col-xs-12">
                                        <div class = "form-group">
                                            <label class = "control-label col-md-3 col-lg-3 col-sd-3 col-xs-12">موبایل</label>
                                            <div class = "col-md-9 col-lg-9 col-sd-9 col-xs-12">
                                                {{--{!! Form::text("mobile" , null , ["class"=>"form-control" , "dir"=>"ltr"]) !!}--}}
                                                <text class = "form-control-static" style = "margin-top:0px !important;">@if(isset($user)){{$user->mobile}}@else
                                                        - @endif</text>
                                                <span class="form-control-feedback">  </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class = "col-lg-6 col-md-6 col-sd-6 col-xs-12">
                                        <div class = "form-group">
                                            <label class = "control-label col-md-3 col-lg-3 col-sd-3 col-xs-12">شماره ثابت</label>
                                            <div class = "col-md-9 col-lg-9 col-sd-9 col-xs-12">
                                                @if(in_array("phone" , $lockedFields)  || $completionPercentage == 100)
                                                    <text class = "form-control-static" style = "margin-top:0px !important;">@if(isset($user->phone)){{$user->phone}}@else
                                                            - @endif</text>
                                                @else
                                                    {!! Form::text("phone" , null , ["class"=>"form-control" , "dir"=>"ltr"]) !!}
                                                @endif
                                                <span class="form-control-feedback"> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class = "col-lg-6 col-md-6 col-sd-6 col-xs-12">
                                        <div class = "form-group">
                                            <label class = "control-label col-md-3 col-lg-3 col-sd-3 col-xs-12">شماره پدر</label>
                                            <div class = "col-md-9 col-lg-9 col-sd-9 col-xs-12">
                                                @if($completionPercentage == 100)
                                                    <text class = "form-control-static" style = "margin-top:0px !important;">{{(isset($parentsNumber["father"]))?$parentsNumber["father"]:"-"}}</text>
                                                @else
                                                    {!! Form::text("parentMobiles[father]" , (isset($parentsNumber["father"]))?$parentsNumber["father"]:null , ["class"=>"form-control" , "dir"=>"ltr"]) !!}
                                                @endif
                                                <span class="form-control-feedback">  </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class = "col-lg-6 col-md-6 col-sd-6 col-xs-12">
                                        <div class = "form-group">
                                            <label class = "control-label col-md-3 col-lg-3 col-sd-3 col-xs-12">شماره مادر</label>
                                            <div class = "col-md-9 col-lg-9 col-sd-9 col-xs-12">
                                                @if($completionPercentage == 100)
                                                    <text class = "form-control-static" style = "margin-top:0px !important;">{{(isset($parentsNumber["mother"]))?$parentsNumber["mother"]:"-"}}</text>
                                                @else
                                                    {!! Form::text("parentMobiles[mother]" , (isset($parentsNumber["mother"]))?$parentsNumber["mother"]:null , ["class"=>"form-control" , "dir"=>"ltr"]) !!}
                                                @endif
                                                <span class="form-control-feedback"> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class = "col-lg-6 col-md-6 col-sd-6 col-xs-12">
                                        <div class = "form-group">
                                            <label class = "control-label col-md-3 col-lg-3 col-sd-3 col-xs-12">استان</label>
                                            <div class = "col-md-9 col-lg-9 col-sd-9 col-xs-12">
                                                @if(in_array("province" , $lockedFields)  || $completionPercentage == 100)
                                                    <text class = "form-control-static" style = "margin-top:0px !important;">@if(isset($user->province)){{$user->province}}@else
                                                            - @endif</text>
                                                @else
                                                    {!! Form::text("province" , null , ["class"=>"form-control"]) !!}
                                                @endif
                                                <span class="form-control-feedback"> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class = "col-lg-6 col-md-6 col-sd-6 col-xs-12">
                                        <div class = "form-group">
                                            <label class = "control-label col-md-3 col-lg-3 col-sd-3 col-xs-12">شهر</label>
                                            <div class = "col-lg-9 col-md-9 col-sd-9 col-xs-12">
                                                @if(in_array("city" , $lockedFields)  || $completionPercentage == 100)
                                                    <text class = "form-control-static" style = "margin-top:0px !important;">@if(isset($user->city)){{$user->city}}@else
                                                            - @endif</text>
                                                @else
                                                    {!! Form::text("city" , null , ["class"=>"form-control"]) !!}
                                                @endif
                                                <span class="form-control-feedback">  </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class = "col-lg-6 col-md-6 col-sd-6 col-xs-12">
                                        <div class = "form-group">
                                            <label class = "control-label col-md-3 col-lg-3 col-sd-3 col-xs-12">آدرس</label>
                                            <div class = "col-md-9 col-lg-9 col-sd-9 col-xs-12">
                                                @if(in_array("address" , $lockedFields)  || $completionPercentage == 100)
                                                    <text class = "form-control-static" style = "margin-top:0px !important;">@if(isset($user->address)){{$user->address}}@else
                                                            - @endif</text>
                                                @else
                                                    {!! Form::text("address" , null , ["class"=>"form-control"]) !!}
                                                @endif
                                                <span class="form-control-feedback"> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class = "col-lg-6 col-md-6 col-sd-6 col-xs-12">
                                        <div class = "form-group">
                                            <label class = "control-label col-md-3 col-lg-3 col-sd-3 col-xs-12">کد پستی</label>
                                            <div class = "col-lg-9 col-md-9 col-sd-9 col-xs-12">
                                                @if(in_array("postalCode" , $lockedFields)  || $completionPercentage == 100)
                                                    <text class = "form-control-static" style = "margin-top:0px !important;">@if(isset($user->postalCode)){{$user->postalCode}}@else
                                                            - @endif</text>
                                                @else
                                                    {!! Form::text("postalCode" , null , ["class"=>"form-control"]) !!}
                                                @endif
                                                <span class="form-control-feedback">  </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class = "col-md-12 col-lg-12 col-sd-12 col-xs-12">
                                        <hr>
                                    </div>
                                    <div class = "col-lg-12 col-md-12 col-sd-12 col-xs-12 text-center">
                                        <div class = "form-group {{ $errors->has('photo') ? ' has-danger' : '' }}">
                                            <div class = "fileinput fileinput-new" data-provides = "fileinput">
                                                <div class = "fileinput-new thumbnail" style = "width: 200px; height: 150px;">
                                                    <img src = "{{ $user->photo }}"  alt = "عکس پروفایل"/>
                                                </div>
                                                <div class = "fileinput-preview fileinput-exists thumbnail" style = "max-width: 200px; max-height: 150px;"></div>
                                                @if( $completionPercentage < 100)
                                                    <div>
                                                                        <span class = "btn default btn-file">
                                                                            <span class = "fileinput-new"> انتخاب عکس </span>
                                                                            <span class = "fileinput-exists"> تغییر </span>
                                                                            <input type = "file" name = "photo"> </span>
                                                        <a href = "javascript:" class = "btn default fileinput-exists" data-dismiss = "fileinput"> حذف</a>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class = "clearfix margin-top-10">
                                                <span class = "m-badge m-badge--wide m-badge--danger">توجه! </span>&nbsp;
                                                <span> دقت نمایید که حجم عکس مورد نظر باید حداکثر ۲۰۰ کیلوبایت و فرمت آن jpg و یا png باشد. </span>
                                            </div>
                                            @if ($errors->has('photo'))
                                                <span class="form-control-feedback">
                                                <strong>{{ $errors->first('photo') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id = "tab_2-2" class = "tab-pane">
                                <div class = "form-body margin-top-30">
                                    <p class = "bold">لطفا در مواردی که مشکل و یا توضیحی ندارید ، فیلد مربوطه را خالی بگذارید</p>
                                    <div class = "col-lg-3 col-md-3 col-sd-3 col-xs-12">
                                        <div class = "form-group">
                                            <label class = "control-label">گروه خونی:</label>
                                            @if($completionPercentage == 100)
                                                <text class = "form-control-static" style = "margin-top:0px !important;">{{(isset($user->bloodtype_id))?$user->bloodtype->name:"-"}}</text>
                                            @else
                                                {!! Form::select('bloodtype_id' , $bloodTypes, null, ['class' => 'form-control']) !!}
                                            @endif
                                        </div>
                                    </div>
                                    <div class = "col-md-12 col-lg-12 col-sd-12 col-xs-12">
                                        <div class = "form-group">
                                            <label class = "control-label">آلرژی به ماده خاص:</label>
                                            @if($completionPercentage == 100)
                                                <text class = "form-control-static" style = "margin-top:0px !important;">{{(isset($user->allergy))?$user->allergy:"-"}}</text>
                                            @else
                                                {!! Form::textarea('allergy', null, ['class' => 'form-control' , "rows"=>"3"]) !!}
                                            @endif
                                        </div>
                                    </div>
                                    <div class = "col-md-12 col-lg-12 col-sd-12 col-xs-12">
                                        <div class = "form-group">
                                            <label class = "control-label">دارای بیماری یا شرایط پزشکی خاص:</label>
                                            @if($completionPercentage == 100)
                                                <text class = "form-control-static" style = "margin-top:0px !important;">{{(isset($user->medicalCondition))?$user->medicalCondition:"-"}}</text>
                                            @else
                                                {!! Form::textarea('medicalCondition', null, ['class' => 'form-control' , "rows"=>"3"]) !!}
                                            @endif
                                        </div>
                                    </div>
                                    <div class = "col-md-12 col-lg-12 col-sd-12 col-xs-12">
                                        <div class = "form-group">
                                            <label class = "control-label">دارای رژیم غذایی خاص:</label>
                                            @if($completionPercentage == 100)
                                                <text class = "form-control-static" style = "margin-top:0px !important;">{{(isset($user->diet))?$user->diet:"-"}}</text>
                                            @else
                                                {!! Form::textarea('diet', null, ['class' => 'form-control' , "rows"=>"3"]) !!}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id = "tab_3-3" class = "tab-pane">
                                <div class = "form-body margin-top-30">
                                    <div class = "col-lg-4 col-md-4 col-sd-4 col-xs-12">
                                        <div class = "form-group" style = "padding: 0px 5px 5px 5px;">
                                            <label class = "control-label">رشته:</label>
                                            @if(in_array("major_id" , $lockedFields)  || $completionPercentage == 100)
                                                <text class = "form-control-static" style = "margin-top:0px !important;">@if(isset($user->major_id)){{$user->major->name}}@else
                                                        - @endif</text>
                                            @else
                                                {!! Form::select('major_id' , $majors, null, ['class' => 'form-control']) !!}
                                            @endif
                                        </div>
                                    </div>
                                    <div class = "col-lg-4 col-md-4 col-sd-4 col-xs-12">
                                        <div class = "form-group" style = "padding: 0px 5px 5px 5px;">
                                            <label class = "control-label">مقطع:</label>
                                            @if($completionPercentage == 100)
                                                <text class = "form-control-static" style = "margin-top:0px !important;">@if(isset($user->grade_id)){{$user->grade->displayName}}@else
                                                        - @endif</text>
                                            @else
                                                {!! Form::select('grade_id' , $grades, null, ['class' => 'form-control']) !!}
                                            @endif
                                        </div>
                                    </div>
                                    <div class = "col-lg-4 col-md-4 col-sd-4 col-xs-12">
                                        <div class = "form-group" style = "padding: 0px 5px 5px 5px;">
                                            <label class = "control-label">نام مدرسه:</label>
                                            @if(in_array("school" , $lockedFields)  || $completionPercentage == 100)
                                                <text class = "form-control-static" style = "margin-top:0px !important;">@if(isset($user->school)){{$user->school}}@else
                                                        - @endif</text>
                                            @else
                                                {!! Form::text("school" , null , ["class"=>"form-control"]) !!}
                                            @endif
                                        </div>
                                    </div>
                                    <div class = "col-md-12 col-lg-12 col-sd-12 col-xs-12">
                                        <hr>
                                        @if(isset($order))
                                            {!! Form::hidden('order',$order->id) !!}
                                        @endif
                                    </div>
                                    <h4 class = "bold font-grey-salsa">توضیحات شخصی</h4>
                                    <div class = "col-md-12 col-lg-12 col-sd-12 col-xs-12">
                                        <div class = "form-group">
                                            <label class = "control-label">در چه آزمون هایی شرکت خواهید کرد ؟</label>
                                            {!! Form::hidden('customerExtraInfoQuestion[1]','در چه آزمون هایی شرکت خواهید کرد ؟') !!}
                                            @if($completionPercentage == 100)
                                                <text class = "form-control-static" style = "margin-top:0px !important;">{{(isset($customerExtraInfo[1]->info))?$customerExtraInfo[1]->info:"-"}}</text>
                                            @else
                                                {!! Form::textarea('customerExtraInfoAnswer[1]', (isset($customerExtraInfo[1]->info))?$customerExtraInfo[1]->info:null, ['class' => 'form-control' , "rows"=>"3"]) !!}
                                            @endif
                                        </div>
                                    </div>
                                    <div class = "col-md-12 col-lg-12 col-sd-12 col-xs-12">
                                        <div class = "form-group">
                                            <label class = "control-label">در چه درس هایی احساس ضعف می کنید ؟ (توضیح بدید)</label>
                                            {!! Form::hidden('customerExtraInfoQuestion[2]','در چه درس هایی احساس ضعف می کنید ؟ (توضیح بدید)') !!}
                                            @if($completionPercentage == 100)
                                                <text class = "form-control-static" style = "margin-top:0px !important;">{{(isset($customerExtraInfo[2]->info))?$customerExtraInfo[2]->info:"-"}}</text>
                                            @else
                                                {!! Form::textarea('customerExtraInfoAnswer[2]', (isset($customerExtraInfo[2]->info))?$customerExtraInfo[2]->info:null, ['class' => 'form-control' , "rows"=>"3"]) !!}
                                            @endif
                                        </div>
                                    </div>
                                    <div class = "col-md-12 col-lg-12 col-sd-12 col-xs-12">
                                        <div class = "form-group">
                                            <label class = "control-label" style = "text-align: right">ساعت و نحوه مطالعات شما تا الان چطور بوده؟ (درسهای پیش 1 ، پایه و پیش 2) هر کدوم رو چه مقدار مطالعه کردید و وضعیت خودتون رو کامل توضیج بدید</label>
                                            {!! Form::hidden('customerExtraInfoQuestion[3]','ساعت و نحوه مطالعات شما تا الان چطور بوده؟ (درسهای پیش 1 ، پایه و پیش 2) هر کدوم رو چه مقدار مطالعه کردید و وضعیت خودتون رو کامل توضیج بدید') !!}
                                            @if($completionPercentage == 100)
                                                <text class = "form-control-static" style = "margin-top:0px !important;">{{(isset($customerExtraInfo[3]->info))?$customerExtraInfo[3]->info:"-"}}</text>
                                            @else
                                                {!! Form::textarea('customerExtraInfoAnswer[3]', (isset($customerExtraInfo[3]->info))?$customerExtraInfo[3]->info:null, ['class' => 'form-control' , "rows"=>"3"]) !!}
                                            @endif
                                        </div>
                                    </div>
                                    <div class = "col-md-12 col-lg-12 col-sd-12 col-xs-12">
                                        <div class = "form-group">
                                            <label class = "control-label">توضیحات تکمیلی که نیازه ما بدونیم(که فکر می کنید در شناخت وضعیت تحصیلی شما مفیده)</label>
                                            {!! Form::hidden('customerExtraInfoQuestion[4]','توضیحات تکمیلی که نیازه ما بدونیم(که فکر می کنید در شناخت وضعیت تحصیلی شما مفیده)') !!}
                                            @if($completionPercentage == 100)
                                                <text class = "form-control-static" style = "margin-top:0px !important;">{{(isset($customerExtraInfo[4]->info))?$customerExtraInfo[4]->info:"-"}}</text>
                                            @else
                                                {!! Form::textarea('customerExtraInfoAnswer[4]', (isset($customerExtraInfo[4]->info))?$customerExtraInfo[4]->info:null, ['class' => 'form-control' , "rows"=>"3"]) !!}
                                            @endif
                                        </div>
                                    </div>
                                    <div class = "col-md-12 col-lg-12 col-sd-12 col-xs-12">
                                        <hr>
                                    </div>
                                    <div class = "col-md-12 col-lg-12 col-sd-12 col-xs-12">
                                        <p class = "text-justify">
                                            شما می توانید کارنامه های آزمون هایی که شرکت نموده اید و یا هر فایل دیگری که فکر می کنید به مشاورین در هدایت تحصیلی شما کمک می کند را در اینجا آپلود نمایید
                                            <br>
                                            <span class = "bold">                                            لطفا در صورت امکان تمام این فایل ها را به صورت <label class = "font-yellow-gold bold">zip</label> یا <label class = "font-yellow-gold bold">rar</label> درآورده و یکجا آپلود نمایید</span>
                                        </p>
                                        <div class = "form-group {{ $errors->has('file') ? ' has-danger' : '' }}">
                                            <label class = "control-label col-md-3 col-lg-3 col-sd-3 col-xs-12"></label>
                                            <div class = "col-md-9 col-lg-9 col-sd-9 col-xs-12">
                                                <div class = "fileinput fileinput-new" data-provides = "fileinput">
                                                    <div class = "input-group input-large">
                                                        <div class = "form-control uneditable-input input-fixed input-medium" data-trigger = "fileinput">
                                                            <i class = "fa fa-file fileinput-exists"></i>&nbsp;
                                                            <span class = "fileinput-filename"> </span>
                                                        </div>
                                                        <span class = "input-group-addon btn default btn-file">
                                                                        <span class = "fileinput-new"> انتخاب فایل </span>
                                                                        <span class = "fileinput-exists"> تغییر </span>
                                                                        <input type = "file" name = "file"> </span>
                                                        <a href = "javascript:" class = "input-group-addon btn red fileinput-exists" data-dismiss = "fileinput"> حذف</a>
                                                    </div>
                                                </div>

                                                <span class = "form-control-feedback @if (!$errors->has('file')) m--font-info @endif">
                                                <strong>@if ($errors->has('file')){{ $errors->first('file') }} @else
                                                        فرمت های مجاز: jpg,jpeg,png,pdf,zip,rar @endif</strong>
                                            </span>
                                            </div>

                                        </div>
                                        <ul>
                                            <h5 class = "bold">فایل های آپلود شده:</h5>
                                            @forelse($orderFiles as $orderFile)
                                                {{--<li><a target="_blank" class="btn blue" href="{{action("Web\HomeController@download" , ["content"=>"فایل سفارش","fileName"=>$orderFile->file ])}}"><i class="fa fa-download"></i>{{$orderFile->file}}</a></li>--}}
                                                <li>
                                                    <a target = "_blank" href = "{{action("Web\HomeController@download" , ["content"=>"فایل سفارش","fileName"=>$orderFile->file ])}}">{{$orderFile->file}}</a>
                                                </li>
                                            @empty
                                                <p class = "bold m--font-danger-mint">تاکنون فایلی آپلود نشده است</p>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-md-9-->
                    </div>
                </div>
            </div>
            <div class = "row">
                <hr>
            </div>

            <div class = "row">
                <div class = "col-md-3 col-lg-3 col-sd-3 col-xs-12">
                    <h4 class = "bold">چگونه با اردو طلایی آشنا شدید؟</h4>
                    {!! Form::hidden('customerExtraInfoQuestion[0]','چگونه با اردو طلایی آشنا شدید؟') !!}
                </div>
                <div class = "col-md-9 col-lg-9 col-sd-9 col-xs-12">
                    @if($completionPercentage == 100)
                        <text class = "form-control-static" style = "margin-top:0px !important;">{{(isset($customerExtraInfo[0]->info))?$customerExtraInfo[0]->info:"-"}}</text>
                    @else
                        {!! Form::text('customerExtraInfoAnswer[0]', (isset($customerExtraInfo[0]->info))?$customerExtraInfo[0]->info:null, ['class' => 'form-control']) !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section("footerPageLevelPlugin")
    <script src = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/counterup/jquery.waypoints.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/counterup/jquery.counterup.min.js" type = "text/javascript"></script>
@endsection

