@extends("app" , ["pageName" => "profile"])

@section("headPageLevelPlugin")
    <link href = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/assets/global/plugins/icheck/skins/all.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("headPageLevelStyle")
    <link href = "/assets/pages/css/profile-rtl.min.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("bodyClass")
    class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed page-md"
@endsection

@section("pageBar")
    <div class = "page-bar">
        <ul class = "page-breadcrumb">
            <li>
                <i class = "icon-home"></i>
                <a href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
                <i class = "fa fa-angle-left"></i>
            </li>
            <li>
                <span>پروفایل</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class = "row">
        <div class = "col-md-12">
            <!-- BEGIN PROFILE SIDEBAR -->
            <div class = "profile-sidebar">
                @include('partials.profileSidebar' , [
                                            "withRegisterationDate"=>true,
                                            "withNavigation" => true,
                                            ]
                        )
            </div>
            <!-- END BEGIN PROFILE SIDEBAR -->
            <!-- BEGIN PROFILE CONTENT -->
            <div class = "profile-content">
                @include("systemMessage.flash")
                <div class = "row">
                    <div class = "col-md-12">
                        <div class = "portlet light ">
                            <div class = "portlet-title tabbable-line">
                                <div class = "caption caption-md">
                                    <i class = "icon-globe theme-font hide"></i>
                                    <span class = "caption-subject font-blue-madison bold uppercase">ثبت کارنامه {{$event->displayName}}</span>
                                </div>
                            </div>
                            <div class = "portlet-body">
                                @if(isset($userEventReport))
                                    <div class = "row">
                                        <div class = "col-md-6">
                                            <div class = "col-md-12">
                                                <h2 class = "control-label ">رتبه شما:
                                                    <text class = "form-control-static bold"> {{$userEventReport->rank}} </text>
                                                </h2>
                                            </div>
                                            <div class = "col-md-12">
                                                <a target = "_blank" class = "btn blue" href = "{{action("Web\HomeController@download" , ["content"=>"فایل کارنامه","fileName"=>$userEventReport->reportFile ])}}">دانلود فایل کارنامه</a>
                                            </div>
                                        </div>
                                        <div class = "col-md-6">

                                            @if(isset($userEventReport->comment) && strlen($userEventReport->comment)>0)
                                                <h2 class = "control-label ">نظر شما:</h2>
                                                <text class = "form-control-static bold" style = "font-size: medium ; color:green;text-align: justify"> {{$userEventReport->comment}} </text>
                                            @else
                                                {!! Form::open(['method' => 'PUT','action' => ['Web\EventresultController@update' , $userEventReport ] ]) !!}
                                                <textarea rows = "5" name = "comment" placeholder = "آلاء چه نقشی در نتیجه شما داشته و چطور به شما کمک کرده؟" class = "form-control"></textarea>
                                                {!! Form::submit('ثبت', ['class' => 'btn blue']) !!}
                                                {!! Form::close() !!}
                                            @endif

                                        </div>
                                    </div>
                                @else
                                    {!! Form::open(['files'=>true,'method' => 'POST','action' => ['Web\EventresultController@store'] ]) !!}
                                    {{ csrf_field() }}
                                    {!! Form::hidden('event_id',$event->id) !!}
                                    {!! Form::hidden('eventresultstatus_id',1) !!}
                                    <div class = "form-body">
                                        <div class = "row">
                                            <div class = "col-md-12">
                                                <div class = "col-md-6">
                                                    <div class = "form-group {{ $errors->has('rank') ? ' has-danger' : '' }}">
                                                        <div class = "input-icon">
                                                            <i class = "fa fa-pencil" aria-hidden = "true"></i>
                                                            <input id = "rank" class = "form-control placeholder-no-fix" type = "text" value = "{{old("rank")}}" name = "rank" placeholder = "رتبه شما(الزامی)"/>

                                                        </div>
                                                        @if ($errors->has('rank'))
                                                            <span class="form-control-feedback">
                                                                    <strong>{{ $errors->first('rank') }}</strong>
                                                                </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class = "col-md-6">
                                                    <div class = "form-group {{ $errors->has('participationCode') ? ' has-danger' : '' }}">
                                                        {{--<label for="participationCode" class="control-label">شماره داوطلبی شما</label>--}}
                                                        <div class = "input-icon">
                                                            <i class = "fa fa-pencil" aria-hidden = "true"></i>
                                                            <input id = "participationCode" class = "form-control placeholder-no-fix" type = "text" value = "{{old("participationCode")}}" name = "participationCode" placeholder = "شماره داوطلبی شما"/>
                                                            <span class="form-control-feedback">شماره داوطلبی شما به صورت رمز شده ذخیره می شود و فقط مدیر سایت می تواند آن را مشاهده کند(حتی شما هم نمی بینید)</span>
                                                        </div>
                                                        @if ($errors->has('participationCode'))
                                                            <span class="form-control-feedback">
                                                                    <strong>{{ $errors->first('participationCode') }}</strong>
                                                                </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "col-md-12">
                                                <div class = "col-md-6">
                                                    <label class = "control-label" for = "reportFile">فایل کارنامه(الزامی)</label>
                                                    <div class = "form-group {{ $errors->has('reportFile') ? ' has-danger' : '' }}">

                                                        <div class = "fileinput fileinput-new" data-provides = "fileinput">
                                                            <div class = "input-group input-large ">
                                                                <div class = "form-control uneditable-input input-fixed input-medium" data-trigger = "fileinput">
                                                                    <i class = "fa fa-file fileinput-exists"></i>&nbsp;
                                                                    <span class = "fileinput-filename"></span>
                                                                </div>
                                                                <span class = "input-group-addon btn default btn-file">
                                                                                                    <span class = "fileinput-new"> انتخاب فایل </span>
                                                                                                    <span class = "fileinput-exists"> تغییر </span>
                                                                    {!! Form::file('reportFile' , ['id'=>'reportFile']) !!} </span>
                                                                <a href = "javascript:" class = "input-group-addon btn red fileinput-exists" data-dismiss = "fileinput"> حذف</a>
                                                            </div>
                                                        </div>
                                                        @if ($errors->has('reportFile'))
                                                            <span class="form-control-feedback">
                                                                        <strong>{{ $errors->first('reportFile') }}</strong>
                                                                    </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class = "col-md-6">
                                                    {{--                                                            {!! Form::textarea('comment', null, ['class' => '' , 'row'=>'2',  'placeholder' => 'نظر شما']) !!}--}}
                                                    <textarea rows = "5" name = "comment" placeholder = "آلاء چه نقشی در نتیجه شما داشته و چطور به شما کمک کرده؟" class = "form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class = "row margin-top-20">
                                            <div class = "col-md-12">
                                                <div class = "form-group">
                                                    <div class = "input-group">
                                                        <div class = "icheck-list">
                                                            <label class = "m--font-danger bold">
                                                                <input name = "enableReportPublish" type = "checkbox" class = "icheck" data-checkbox = "icheckbox_flat-green">
                                                                اجازه انتشار رتبه خود را در سایت می دهم
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "col-md-12">
                                                <div class = "custom-alerts alert alert-info fade in" style = "text-align: justify ; background-color: #d9edf7 ; color:#31708f">
                                                    <strong>توضیح: </strong> با زدن تیک بالا شما به ما اجازه می دهید تا رتبه ی شما را در سایت آلاء اعلام کنیم. اگر تمایلی به این کار ندارید می توانید این تیک را نزنید. بدیهی است که با زدن تیک فوق ، درج شماره داوطلبی الزامی خواهد بود .
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        @if(!isset(Auth::user()->firstName) ||
                                        !isset(Auth::user()->lastName) ||
                                        !isset(Auth::user()->major->id))
                                            <div class = "row">
                                                @if(!isset(Auth::user()->firstName))
                                                    <div class = "col-md-6">
                                                        <div class = "form-group {{ $errors->has('firstName') ? ' has-danger' : '' }}">
                                                            <label for = "firstName" class = "control-label">نام:
                                                                <span class = "required" aria-required = "true"> * </span>
                                                            </label>
                                                            <div class = "input-icon">
                                                                <i class = "fa fa-pencil" aria-hidden = "true"></i>
                                                                <input id = "firstName" class = "form-control placeholder-no-fix" type = "text" value = "{{old("firstName")}}" name = "firstName"/>
                                                            </div>
                                                            @if ($errors->has('firstName'))
                                                                <span class="form-control-feedback">
                                                                        <strong>{{ $errors->first('firstName') }}</strong>
                                                                    </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                                @if(!isset(Auth::user()->lastName))
                                                    <div class = "col-md-6">
                                                        <div class = "form-group {{ $errors->has('lastName') ? ' has-danger' : '' }}">
                                                            <label for = "firstName" class = "control-label">نام خانوادگی:
                                                                <span class = "required" aria-required = "true"> * </span>
                                                            </label>
                                                            <div class = "input-icon">
                                                                <i class = "fa fa-pencil" aria-hidden = "true"></i>
                                                                <input id = "lastName" class = "form-control placeholder-no-fix" type = "text" value = "{{old("lastName")}}" name = "lastName"/>
                                                            </div>
                                                            @if ($errors->has('lastName'))
                                                                <span class="form-control-feedback">
                                                                        <strong>{{ $errors->first('lastName') }}</strong>
                                                                     </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class = "row">
                                                @if(!isset(Auth::user()->major->id))
                                                    <div class = "col-md-6">
                                                        <div class = "form-group {{ $errors->has('major_id') ? ' has-danger' : '' }}">
                                                            <label for = "major_id" class = "control-label">رشته:
                                                                <span class = "required" aria-required = "true"> * </span>
                                                            </label>
                                                            <div class = "input-large ">
                                                                {!! Form::select('major_id',$majors,null,['class' => 'form-control', 'id' => 'major_id']) !!}
                                                            </div>
                                                            @if ($errors->has('major_id'))
                                                                <span class="form-control-feedback">
                                                                     <strong>{{ $errors->first('major_id') }}</strong>
                                                                 </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <hr>
                                        @endif
                                    </div>
                                    <div class = "form-actions row">
                                        <div class = "col-md-12 margiv-top-10">
                                            <button type = "submit" class = "btn green"> ثبت کارنامه</button>
                                        </div>
                                    </div>
                                @endif
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->

        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/jquery.sparkline.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/counterup/jquery.waypoints.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/counterup/jquery.counterup.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/morris/morris.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/icheck/icheck.min.js" type = "text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src = "/assets/pages/scripts/profile.min.js" type = "text/javascript"></script>
    <script src = "/assets/pages/scripts/dashboard.min.js" type = "text/javascript"></script>
    <script src = "/assets/pages/scripts/form-icheck.min.js" type = "text/javascript"></script>

@endsection
