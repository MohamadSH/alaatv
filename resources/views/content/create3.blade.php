@extends("app",["pageName"=>"admin"])

@section("headPageLevelPlugin")
@endsection


@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <a href = "{{action("Web\HomeController@adminContent")}}">مدیریت محتوا</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>درج محتوای آموزشی</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    @include("systemMessage.flash")
    <div class="row">
        @include("systemMessage.flash")
        <div class="col-md-12">
            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet light">
                <div class="portlet-body">
                    <div class="row">
                        {!! Form::open(['method' => 'POST', 'action' => 'ContentController@basicStore']) !!}
                        <div class="col-md-6">
                            {!! Form::text('contentset_id', null, ['class' => 'form-control', 'placeholder'=>'شماره درس', 'dir'=>'ltr']) !!}
                            <span class="help-block">
                                    <strong></strong>
                                 </span>
                        </div>
                        <div class="col-md-6">
                            {!! Form::select('contenttype_id', $contenttypes, null,['class' => 'form-control']) !!}
                            <span class="help-block">
                                    <strong></strong>
                                </span>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="checkbox" id="orderCheckbox">
                                        <span></span>
                                    </span>
                                {!! Form::text('order', null, ['class' => 'form-control', 'placeholder'=>'ترتیب' , 'id'=>'order' , 'disabled', 'dir'=>'ltr']) !!}
                            </div>
                            <span class="help-block">
                                    <strong></strong>
                            </span>
                        </div>
                        <div class="col-md-6">
                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder'=>'عنوان']) !!}
                            <span class="help-block">
                                    <strong></strong>
                                </span>
                        </div>
                        <div class="col-md-6" id="fileNameSection" style="border: solid gray 0.5px; padding: 10px;">
                            <div class="col-md-12">
                                <div class="mt-radio-list">
                                    <label class="mt-radio mt-radio-outline"> درج با اسم فایل
                                        <input class="modeRadio" type="radio" value="filename" name="mode" checked/>
                                        <span></span>
                                    </label>
                                </div>
                                {!! Form::text('fileName', null, ['class' => 'form-control', 'placeholder'=>'نام کامل فایل', 'dir'=>'ltr']) !!}
                                <span class="help-block">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6" id="fileLinkSection" style="border: solid gray 0.5px; padding: 10px;">
                            <div class="col-md-12">
                                <div class="mt-radio-list">
                                    <label class="mt-radio mt-radio-outline"> درج با لینک
                                        <input class="modeRadio" type="radio" value="filelink" name="mode"/>
                                        <span></span>
                                    </label>
                                </div>
                                {!! Form::text('hd', null, ['class' => 'form-control', 'placeholder'=>'لینک کیفیت HD', 'dir'=>'ltr']) !!}
                                <span class="help-block">
                                    <strong></strong>
                                </span>
                            </div>
                            <div class="col-md-12">
                                {!! Form::text('hq', null, ['class' => 'form-control', 'placeholder'=>'لینک کیفیت hq', 'dir'=>'ltr']) !!}
                                <span class="help-block">
                                    <strong></strong>
                                </span>
                            </div>
                            <div class="col-md-12">
                                {!! Form::text('240p', null, ['class' => 'form-control', 'placeholder'=>'لینک کیفیت 240p', 'dir'=>'ltr']) !!}
                                <span class="help-block">
                                    <strong></strong>
                                </span>
                            </div>
                            <div class="col-md-12">
                                {!! Form::text('thumbnail', null, ['class' => 'form-control', 'placeholder'=>'لینک تامبنیل', 'dir'=>'ltr']) !!}
                                <span class="help-block">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-12 text-center margin-top-10">
                            <input type="submit" value="درج">
                        </div>
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
    <script>

        $(document).ready(function () {
            var height = $("#fileLinkSection").height();
            $("#fileNameSection").css("min-height", height + 20);
            $("#fileLinkSection :input").not("[name=mode]").attr("disabled", true);
        });

        $(document).on("click", "#orderCheckbox", function () {
            if ($(this).prop("checked")) {
                $("#order").prop("disabled", false);
            }
            else {
                $("#order").prop("disabled", true);
            }
        });

        $(document).on("click", ".modeRadio", function () {
            var value = $(this).val();
            if (value == "filename") {
                $("#fileNameSection :input").not("[name=mode]").attr("disabled", false);
                $("#fileLinkSection :input").not("[name=mode]").attr("disabled", true);
            }
            else if (value == "filelink") {
                $("#fileNameSection :input").not("[name=mode]").attr("disabled", true);
                $("#fileLinkSection :input").not("[name=mode]").attr("disabled", false);
            }
        });
    </script>
@endsection
