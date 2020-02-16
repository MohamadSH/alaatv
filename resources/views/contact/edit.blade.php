{{--@permission((Config::get('constants.SHOW_PRODUCT_ACCESS')))--}}
@extends('partials.templatePage',["pageName"=>"admin"])

@section("headPageLevelPlugin")
    <link href = "/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/assets/global/plugins/bootstrap-toastr/toastr-rtl.min.css" rel = "stylesheet" type = "text/css"/>
@endsection


@section("pageBar")
    <div class = "page-bar">
        <ul class = "page-breadcrumb">
            <li>
                <i class = "icon-home"></i>
                <a href = "{{action("Web\AdminController@admin")}}">پنل مدیریتی</a>
                <i class = "fa fa-angle-left"></i>
            </li>
            <li>
                <a href = "{{action("Web\ContactController@index", ["user" => $contact->user])}}">لیست مخاطبین</a>
                <i class = "fa fa-angle-left"></i>
            </li>
            <li>
                <span>اصلاح اطلاعات مخاطب</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class = "row">
        <div class = "col-md-3"></div>
        <div class = "col-md-6">
        @include("systemMessage.flash")
        <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class = "portlet light ">
                <div class = "portlet-title">
                    <div class = "caption">
                        <i class = "icon-settings font-dark"></i>
                        <span class = "caption-subject font-dark sbold uppercase">اصلاح اطلاعات مخاطب {{$contact->name}}</span>
                    </div>
                    <div class = "actions">
                        <div class = "btn-group">
                            <a class = "btn btn-sm dark dropdown-toggle" href = "{{action("Web\ContactController@index", ["user" => $contact->user])}}"> بازگشت
                                <i class = "fa fa-angle-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class = "portlet-body form">
                    {!! Form::model($contact,['method' => 'PUT','action' => ['ContactController@update',$contact], 'class'=>'form-horizontal']) !!}
                    @include('contact.form')
                    {!! Form::close() !!}

                    {{--Adding Phone Number Modal--}}
                    <div id = "addPhone" class = "modal fade" tabindex = "-1" data-width = "500" data-backdrop = "static">
                        <div class = "modal-header">افزودن شماره</div>
                        {!! Form::open(['method' => 'POST' , 'action' => 'PhoneController@store' , 'class'=>'nobottommargin' , 'id' => 'phoneNumberForm']) !!}
                        <div class = "modal-body">
                            {!! Form::hidden('contact_id', $contact->id) !!}
                            <div class = "row">
                                <div class = "col-md-6">
                                    {!! Form::text('phoneNumber', null, ['class' => 'form-control', 'id' => 'phoneNumber'  , 'placeholder'=>'شماره تلفن']) !!}
                                    <span class="form-control-feedback" id = "phoneNumberAlert">
                                                <strong></strong>
                                            </span>
                                </div>
                                <div class = "col-md-6">
                                    {!! Form::select('phonetype_id', $phonetypes, null, ['class' => 'form-control', 'id' => 'phoneType']) !!}
                                    <span class="form-control-feedback" id = "phoneTypeAlert">
                                                <strong></strong>
                                            </span>
                                </div>
                            </div>
                            <div class = "row">
                                <div class = "col-md-6">
                                    {!! Form::text('priority', null, ['class' => 'form-control', 'id' => 'priority'  , 'placeholder'=>'الویت شماره']) !!}
                                    <span class="form-control-feedback" id = "priorityAlert">
                                            <strong></strong>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class = "modal-footer">
                            <div class = "form-group">
                                <div class = "col-md-4">
                                    <button type = "button" data-dismiss = "modal" class = "btn btn-outline dark" id = "numberPhone-close">بستن
                                    </button>
                                    <button type = "button" data-dismiss = "modal" class = "btn green" id = "numberPhone-submit">ذخیره
                                    </button>
                                    {{--                                        {!! Form::submit('ذخیره' , ['class' => 'btn green' , 'data-dismiss' => "modal"]) !!}--}}
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src = "/assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/bootstrap-toastr/toastr.min.js" type = "text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src = "/assets/pages/scripts/ui-extended-modals.min.js" type = "text/javascript"></script>
    <script src = "/assets/pages/scripts/ui-toastr.min.js" type = "text/javascript"></script>
@endsection

@section("extraJS")
    <script type = "text/javascript">
        $(document).on("click", "#numberPhone-submit", function () {
            var formData = $("#phoneNumberForm").serialize();
            $.ajax({
                type: "POST",
                url: $("#phoneNumberForm").attr("action"),
                data: formData,
                statusCode: {
                    //The status for when action was successful
                    200: function (response) {
//                        $("#userForm-close").trigger("click");
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "positionClass": "toast-top-center",
                            "onclick": null,
                            "showDuration": "1000",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        };
                        toastr["success"]("درج شماره با موفقیت انجام شد!", "پیام سیستم");
                        setTimeout(function () {
                            location.reload(true);
                        }, 2000);
                    },
                    //The status for when the user is not authorized for making the request
                    403: function (response) {
                        window.location.replace("/403");
                    },
                    404: function (response) {
                        window.location.replace("/404");
                    },
                    //The status for when form data is not valid
                    422: function (response) {
                        var errors = $.parseJSON(response.responseText);
//                        console.log(errors);
                        $.each(errors, function (index, value) {
                            switch (index) {
                                case "phoneNumber":
                                    $("#phoneNumber").parent().addClass("has-danger");
                                    $("#phoneNumberAlert > strong").html(value);
                                    break;
                                case "phonetype_id":
                                    $("#phoneType").parent().addClass("has-danger");
                                    $("#phoneTypeAlert > strong").html(value);
                                    break;
                                case "priority":
                                    $("#priority").parent().addClass("has-danger");
                                    $("#priorityAlert > strong").html(value);
                                    break;
                            }
                        });
//                        $("#addPhoneButton").trigger("click");
                    },
                    //The status for when there is error php code
                    500: function (response) {
                        // console.log(response.responseText);
                        toastr["error"]("خطای برنامه!", "پیام سیستم");
                    },
                    //The status for when there is error php code
                    503: function (response) {
                        toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
                    }
                }
            });
        });
    </script>
@endsection
{{--@endpermission--}}
