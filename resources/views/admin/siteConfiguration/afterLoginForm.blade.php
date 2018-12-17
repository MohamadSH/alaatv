@extends("app" , ["pageName"=> "admin"])

@section("headPageLevelPlugin")
    <link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
@endsection

@section("headPageLevelStyle")
    <link href="/assets/pages/css/profile-rtl.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section("title")
    <title>آلاء|پیکربندی فرم لاگین</title>
@endsection

@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{action("HomeController@index")}}">@lang('page.Home')</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <i class="fa fa-cogs"></i>
                <span>پیکربندی سایت</span>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>مدیریت فرم بعد از ورود</span>
            </li>
        </ul>
    </div>
@endsection

@section("metadata")
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@section("bodyClass")
    class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed page-md"
@endsection

@section("content")
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PROFILE SIDEBAR -->
            <div class="profile-sidebar">
                <!-- PORTLET MAIN -->
            @include("partials.siteConfigurationSideBar")
            <!-- END PORTLET MAIN -->
            </div>
            <!-- END BEGIN PROFILE SIDEBAR -->
            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN PORTLET -->
                        <div class="portlet light ">
                            <div class="portlet-title">
                                <div class="caption caption-md">
                                    <i class="icon-bar-chart theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">جدول فیلدهای فرم</span>
                                    {{--<span class="caption-helper"><a href="{{action("UserController@completeRegister")}}">رفتن به صفحه ی تکمیل اطلاعات</a></span>--}}
                                </div>
                                <div class="actions">
                                    <div class="btn-group btn-group-devided" data-toggle="buttons">
                                        <label class="btn btn-transparent grey-salsa btn-circle btn-sm active">
                                            <a class="bg-font-dark" data-toggle="modal" href="#addFieldModal"><i
                                                        class="fa fa-plus" aria-hidden="true"></i> افزودن</a></label>
                                    </div>
                                </div>
                                <div class="modal fade" id="addFieldModal" tabindex="-1" role="basic"
                                     aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true"></button>
                                                <h4 class="modal-title">افزودن فیلد</h4>
                                            </div>
                                            <!-- BEGIN FORM-->
                                            {!! Form::open(['method' => 'POST' , 'action'=>"AfterLoginFormController@store" ,  'class'=>'form-horizontal']) !!}
                                            <div class="modal-body">
                                                <div class="form-body">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">انتخاب فیلد</label>
                                                        <div class="col-md-4">
                                                            {!! Form::select('name' , $availableFields, null, ['class' => 'form-control default',]) !!}
                                                            <span class="help-block">  </span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">نام قابل نمایش</label>
                                                        <div class="col-md-4">
                                                            <input name="displayName" type="text" class="form-control"
                                                                   placeholder="نامی که کاربر می بیند">
                                                            <span class="help-block">  </span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">ترتیب</label>
                                                        <div class="col-md-4">
                                                            <input name="order" type="text" class="form-control"
                                                                   placeholder="ترتیب قرار گرفتن در فرم">
                                                            <span class="help-block">  </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="form-actions">
                                                        <div class="row">
                                                            <div class="col-md-offset-3 col-md-9">
                                                                <button type="submit" class="btn green">افزودن</button>
                                                                <button type="button" class="dark btn btn-outline"
                                                                        data-dismiss="modal">بستن
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            {!! Form::close() !!}
                                            <!-- END FORM-->
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="custom-alerts alert alert-success fade in display-hide" id="successMessage">
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true"></button>
                                    <i class="fa fa-check-circle"></i>
                                    <span></span>
                                </div>
                                <div class="table-scrollable">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th> ترتیب</th>
                                            <th> نام فیلد</th>
                                            <th> نام قابل نمایش</th>
                                            <th> فعال/غیرفعال</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($afterLoginFormFields->isEmpty())
                                            <tr style="text-align: center">
                                                <td colspan="5">
                                                    اطلاعاتی برای نمایش وجود ندارد
                                                </td>
                                            </tr>
                                        @else
                                            @foreach($afterLoginFormFields as $afterLoginFormField)
                                                <tr id="{{$afterLoginFormField->id}}">
                                                    <td> {{$afterLoginFormField->order}} </td>
                                                    <td id="fieldName_{{$afterLoginFormField->id}}"> {{$afterLoginFormField->name}} </td>
                                                    <td> {{$afterLoginFormField->displayName}} </td>
                                                    <td> @if($afterLoginFormField->enable) <span
                                                                class="label label-sm label-success"> فعال </span> @else
                                                            <span class="label label-sm label-warning"> غیرفعال </span>  @endif
                                                    </td>
                                                    <td>
                                                        <span class="field_id hidden" id="{{$afterLoginFormField->id}}">ali</span>
                                                        <a class="btn btn-outline btn-circle dark btn-sm red deleteField"
                                                           data-toggle="modal" href="#removeFieldModal"><i
                                                                    class="fa fa-trash-o"></i> حذف</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                        <div class="modal fade" id="removeFieldModal" tabindex="-1" role="basic"
                                             aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-hidden="true"></button>
                                                        <h4 class="modal-title">حذف فیلد <span
                                                                    id="deleteFieldTitle"></span></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p> آیا مطمئن هستید؟ </p>
                                                        {!! Form::hidden('field_id', null) !!}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" data-dismiss="modal"
                                                                class="btn btn-outline dark">لغو
                                                        </button>
                                                        <button type="button" data-dismiss="modal" class="btn green"
                                                                onclick="removeField()">بله
                                                        </button>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                            </div>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- END PORTLET -->
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src="/assets/global/scripts/app.min.js" type="text/javascript"></script>
@endsection

@section("extraJS")
    <script type="text/javascript">
        $(document).ready(function () {
            @if(session()->has("success"))
            $("#successMessage > span").text("{{session()->pull("success")}}");
            $("#successMessage").show();
            @endif
        });
        /**
         * Set token for ajax request
         */
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': window.Laravel.csrfToken,
                }
            });
        });

        $(document).on("click", ".deleteField", function () {
//            var field_id = $(this).closest('span').find('.field_id').attr('id');
            var field_id = $(this).closest('tr').attr('id');
            $("input[name=field_id]").val(field_id);
            $("#deleteFieldTitle").text($("#fieldName_" + field_id).text());
        });

        function removeField() {
            var field_id = $("input[name=field_id]").val();
            $.ajax({
                type: 'POST',
                url: 'afterloginformcontrol/' + field_id,
                data: {_method: 'delete'},
                success: function (result) {
                    // console.log(result);
                    // console.log(result.responseText);
                    location.reload();
                },
                error: function (result) {
//                     console.log(result);
//                     console.log(result.responseText);
                }
            });
        }
    </script>
@endsection