@extends('partials.templatePage' , ['pageName'=> 'admin'])

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
    <link href = "" rel = "stylesheet" type = "text/css"/>
{{--    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/css/profile-rtl.css" rel = "stylesheet" type = "text/css"/>--}}
@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item" aria-current = "page">
                <a class = "m-link" href = "#">پیکربندی سایت</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">مدیریت فرم بعد از ورود</a>
            </li>
        </ol>
    </nav>
@endsection

@section("content")
    <div class = "row">
        <div class = "col">
            <!-- PORTLET MAIN -->
        @include("partials.siteConfigurationSideBar" )
        <!-- END PORTLET MAIN -->
        </div>
    </div>

    <div class = "row">
        <div class = "col">

            <div class = "m-portlet m-portlet--head-sm" m-portlet = "true" id = "m_portlet_tools_3">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
                            <span class = "m-portlet__head-icon">
                                <i class = "flaticon-browser"></i>
                            </span>
                            <h3 class = "m-portlet__head-text">
                                جدول فیلدهای فرم
                            </h3>
                        </div>
                    </div>
                    <div class = "m-portlet__head-tools">
                        <ul class = "m-portlet__nav">
                            <li class = "m-portlet__nav-item">
                                <a href = "#addFieldModal" data-toggle = "modal" data-target = "#addFieldModal" class = "m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class = "flaticon-plus"></i>
                                    افزودن
                                </a>
                            </li>
                        </ul>
                        <div class = "modal fade" id = "addFieldModal" tabindex = "-1" role = "basic" aria-hidden = "true">
                            <div class = "modal-dialog">
                                <div class = "modal-content">
                                    <div class = "modal-header">
                                        <h5 class = "modal-title" id = "exampleModalLabel">افزودن فیلد</h5>
                                        <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close">
                                            <span aria-hidden = "true">×</span>
                                        </button>
                                    </div>
                                    <!-- BEGIN FORM-->
                                    {!! Form::open(['method' => 'POST' , 'action'=>"Web\AfterLoginFormController@store" ,  'class'=>'form-horizontal']) !!}
                                    <div class = "modal-body">
                                        <div class = "form-body">
                                            <div class = "form-group">
                                                <div class = "row">
                                                    <label class = "col-md-3 control-label">انتخاب فیلد</label>
                                                    <div class = "col-md-4">
                                                        {!! Form::select('name' , $availableFields, null, ['class' => 'form-control default',]) !!}
                                                        <span class="form-control-feedback">  </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "form-group">
                                                <div class = "row">
                                                    <label class = "col-md-3 control-label">نام قابل نمایش</label>
                                                    <div class = "col-md-4">
                                                        <input name = "displayName" type = "text" class = "form-control" placeholder = "نامی که کاربر می بیند">
                                                        <span class="form-control-feedback">  </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "form-group">
                                                <div class = "row">
                                                    <label class = "col-md-3 control-label">ترتیب</label>
                                                    <div class = "col-md-4">
                                                        <input name = "order" type = "text" class = "form-control" placeholder = "ترتیب قرار گرفتن در فرم">
                                                        <span class="form-control-feedback">  </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class = "modal-footer">
                                            <div class = "form-actions">
                                                <div class = "row">
                                                    <div class = "col">
                                                        <button type = "submit" class = "btn m-btn--air btn-success">افزودن</button>
                                                        <button type = "button" class = "btn m-btn--air btn-outline-brand" data-dismiss = "modal">بستن</button>
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
                </div>
                <div class = "m-portlet__body">

                    <div class = "custom-alerts alert alert-success fade in display-hide" id = "successMessage">
                        <button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true"></button>
                        <i class = "fa fa-check-circle"></i>
                        <span></span>
                    </div>
                    <div class = "table-scrollable">
                        <table class = "table table-hover">
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
                                <tr style = "text-align: center">
                                    <td colspan = "5">
                                        اطلاعاتی برای نمایش وجود ندارد
                                    </td>
                                </tr>
                            @else
                                @foreach($afterLoginFormFields as $afterLoginFormField)
                                    <tr id = "{{$afterLoginFormField->id}}">
                                        <td> {{$afterLoginFormField->order}} </td>
                                        <td id = "fieldName_{{$afterLoginFormField->id}}"> {{$afterLoginFormField->name}} </td>
                                        <td> {{$afterLoginFormField->displayName}} </td>
                                        <td>
                                            @if($afterLoginFormField->enable)
                                                <span class = "m-badge m-badge--success m-badge--wide">فعال</span>
                                            @else
                                                <span class = "m-badge m-badge--danger m-badge--wide">غیرفعال</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class = "field_id d-none" id = "{{$afterLoginFormField->id}}">{{$afterLoginFormField->id}}</span>
                                            <a class = "btn btn-sm btn-outline-danger m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air deleteField" data-toggle = "modal" href = "#removeFieldModal">
                                                    <span>
                                                        <i class = "flaticon-delete"></i>
                                                        <span>حذف</span>
                                                    </span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class = "modal fade" id = "removeFieldModal" tabindex = "-1" role = "basic" aria-hidden = "true">
                        <div class = "modal-dialog">
                            <div class = "modal-content">
                                <div class = "modal-header">
                                    <h5 class = "modal-title" id = "deleteFieldTitle">حذف فیلد</h5>
                                    <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close">
                                        <span aria-hidden = "true">×</span>
                                    </button>
                                </div>
                                <div class = "modal-body">
                                    <p> آیا مطمئن هستید؟</p>
                                    {!! Form::hidden('field_id', null) !!}
                                </div>
                                <div class = "modal-footer">
                                    <button type = "button" data-dismiss = "modal" class = "btn m-btn--air btn-outline-brand">لغو</button>
                                    <button type = "button" data-dismiss = "modal" class = "btn m-btn--air btn-success" onclick = "removeField()">بله</button>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script type = "text/javascript">
        $(document).ready(function () {
            @if(session()->has("success"))
            $("#successMessage > span").text("{{session()->pull("success")}}");
            $("#successMessage").show();
            @endif
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
