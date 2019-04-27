@extends("app",["pageName"=>"admin"])

@section("headPageLevelPlugin")
@endsection

@section('pageBar')

    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "flaticon-home-2 m--padding-right-5"></i>
                <a class = "m-link" href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item">
                <a class = "m-link" href = "{{action("Web\HomeController@adminContent")}}">مدیریت محتوا</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">درج محتوای آموزشی</a>
            </li>
        </ol>
    </nav>

@endsection

@section("content")
    @include("systemMessage.flash")
    <div class = "row">
        <div class = "col">
            <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
                            <h3 class = "m-portlet__head-text">
                                درج محتوای آموزشی
                            </h3>
                        </div>
                    </div>
                </div>
                <div class = "m-portlet__body">
                    {!! Form::open(['method' => 'POST', 'action' => 'Web\ContentController@basicStore']) !!}
                    <div class = "row">
                        <div class = "col-md-6">
                            {!! Form::text('contentset_id', null, ['class' => 'form-control m-input m-input--air', 'placeholder'=>'شماره درس', 'dir'=>'ltr']) !!}
                            <span class = "help-block">
                                    <strong></strong>
                                </span>
                        </div>
                        <div class = "col-md-6">
                            {!! Form::select('contenttype_id', $contenttypes, null,['class' => 'form-control m-input m-input--air']) !!}
                            <span class = "help-block">
                                    <strong></strong>
                                </span>
                        </div>
                        <div class = "col-md-6">
                            <div class = "form-group m-form__group">
                                <div class = "input-group">
                                    <div class = "input-group-prepend">
                                            <span class = "input-group-text">
                                                <label class = "m-checkbox m-checkbox--single m-checkbox--state m-checkbox--state-success">
                                                    <input type = "checkbox" checked = "" id = "orderCheckbox">
                                                    <span></span>
                                                </label>
                                            </span>
                                    </div>
                                    {!! Form::text('order', null, ['class' => 'form-control m-input m-input--air', 'placeholder'=>'ترتیب' , 'id'=>'order' , 'disabled', 'dir'=>'ltr']) !!}
                                </div>
                            </div>
                            <span class = "help-block">
                                    <strong></strong>
                                </span>
                        </div>
                        <div class = "col-md-6">
                            {!! Form::text('name', null, ['class' => 'form-control m-input m-input--air', 'placeholder'=>'عنوان']) !!}
                            <span class = "help-block">
                                    <strong></strong>
                                </span>
                        </div>
                        <div class = "col-md-6" id = "fileNameSection" style = "border: solid gray 0.5px; padding: 10px;">
                            <div class = "col-md-12">
                                <div class = "mt-radio-list">
                                    <label class = "mt-radio mt-radio-outline"> درج با اسم فایل
                                        <input class = "modeRadio" type = "radio" value = "filename" name = "mode" checked/>
                                        <span></span>
                                    </label>
                                </div>
                                {!! Form::text('fileName', null, ['class' => 'form-control m-input m-input--air', 'placeholder'=>'نام کامل فایل', 'dir'=>'ltr']) !!}
                                <span class = "help-block">
                                        <strong></strong>
                                    </span>
                            </div>
                        </div>
                        <div class = "col-md-6" id = "fileLinkSection" style = "border: solid gray 0.5px; padding: 10px;">
                            <div class = "col-md-12">
                                <div class = "mt-radio-list">
                                    <label class = "mt-radio mt-radio-outline"> درج با لینک
                                        <input class = "modeRadio" type = "radio" value = "filelink" name = "mode"/>
                                        <span></span>
                                    </label>
                                </div>
                                {!! Form::text('hd', null, ['class' => 'form-control m-input m-input--air', 'placeholder'=>'لینک کیفیت HD', 'dir'=>'ltr']) !!}
                                <span class = "help-block">
                                        <strong></strong>
                                    </span>
                            </div>
                            <div class = "col-md-12">
                                {!! Form::text('hq', null, ['class' => 'form-control m-input m-input--air', 'placeholder'=>'لینک کیفیت hq', 'dir'=>'ltr']) !!}
                                <span class = "help-block">
                                        <strong></strong>
                                    </span>
                            </div>
                            <div class = "col-md-12">
                                {!! Form::text('240p', null, ['class' => 'form-control m-input m-input--air', 'placeholder'=>'لینک کیفیت 240p', 'dir'=>'ltr']) !!}
                                <span class = "help-block">
                                        <strong></strong>
                                    </span>
                            </div>
                            <div class = "col-md-12">
                                {!! Form::text('thumbnail', null, ['class' => 'form-control m-input m-input--air', 'placeholder'=>'لینک تامبنیل', 'dir'=>'ltr']) !!}
                                <span class = "help-block">
                                        <strong></strong>
                                    </span>
                            </div>
                        </div>
                        <div class = "col-md-12 text-center m--margin-top-10">
                            <input type = "submit" class = "btn btn-lg m-btn--pill m-btn--air m-btn m-btn--gradient-from-success m-btn--gradient-to-accent" value = "درج">
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
@endsection

@section("footerPageLevelScript")
@endsection


@section('page-js')
    <script>

        $(document).ready(function () {
            var height = $("#fileLinkSection").height();
            $("#fileNameSection").css("min-height", height + 20);
            $("#fileLinkSection :input").not("[name=mode]").attr("disabled", true);
        });

        $(document).on("click", "#orderCheckbox", function () {
            if ($(this).prop("checked")) {
                $("#order").prop("disabled", false);
            } else {
                $("#order").prop("disabled", true);
            }
        });

        $(document).on("click", ".modeRadio", function () {
            var value = $(this).val();
            if (value == "filename") {
                $("#fileNameSection :input").not("[name=mode]").attr("disabled", false);
                $("#fileLinkSection :input").not("[name=mode]").attr("disabled", true);
            } else if (value == "filelink") {
                $("#fileNameSection :input").not("[name=mode]").attr("disabled", true);
                $("#fileLinkSection :input").not("[name=mode]").attr("disabled", false);
            }
        });
    </script>
@endsection
