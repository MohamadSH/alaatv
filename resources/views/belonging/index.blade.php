@permission((Config::get('constants.LIST_BELONGING_ACCESS')))
@extends('partials.templatePage',["pageName"=>$pageName])

@section("headPageLevelPlugin")
    {{--<link href="/acm/extra/persian-datepicker/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>--}}
    <link href = "/assets/global/plugins/datatables/datatables.min.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("metadata")
    <meta name = "_token" content = "{{ csrf_token() }}">
@endsection

@section("pageBar")
    <div class = "page-bar">
        <ul class = "page-breadcrumb">
            <li>
                <i class = "icon-home"></i>
                <a href = "{{route('web.index')}}">@lang('page.Home')</a>
                <i class = "fa fa-angle-left"></i>
            </li>
            @if(isset($user))
                <li>
                    <i class = "fa fa-cogs"></i>
                    <a href = "{{action("Web\AdminController@admin")}}">مدیریت کاربران</a>
                    <i class = "fa fa-angle-left"></i>
                </li>
            @endif
            <li>
                <span>لیست اسناد فنی@if(isset($user)) {{$user->firstName}} {{$user->lastName}}@endif</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class = "row">
        {{--Ajax modal loaded after inserting content--}}
        <div id = "ajax-modal" class = "modal fade" tabindex = "-1"></div>
    {{--Ajax modal for panel startup --}}

    <!-- /.modal -->
        <div class = "col-md-12">
            <!-- BEGIN USER BELONGINGS TABLE PORTLET-->
            <div class = "portlet box purple-intense">
                <div class = "portlet-title">
                    <div class = "caption">
                        <i class = "fa fa-th-list" aria-hidden = "true"></i>
                        لیست اسناد فنی@if(isset($user)) {{$user->firstName}} {{$user->lastName}}@endif</div>
                </div>
                <div class = "portlet-body" style = "display: block;">
                    <div class = "table-toolbar">
                        <div class = "row">
                            <div class = "col-md-6">
                                <div class = "btn-group">
                                    @permission((Config::get('constants.INSERT_BELONGING_ACCESS')))
                                    @if(isset($user))
                                        <a class = "addBelonging btn btn-outline purple-intense-stripe" data-target = "#addBelongingModal" data-toggle = "modal">
                                            <i class = "fa fa-plus" aria-hidden = "true"></i>
                                            ثبت اسناد فنی برای {{$user->firstName}} {{$user->lastName}} </a>

                                    <!-- responsive modal -->
                                        <div id = "addBelongingModal" class = "modal fade" tabindex = "-1">
                                            <div class = "modal-header">ثبت اسناد فنی جدید</div>
                                            {!! Form::open(['files'=>true,'method' => 'POST', 'action' => 'BelongingController@store' , 'class'=>'nobottommargin' ]) !!}
                                            <div class = "modal-body">
                                                {!! Form::text('name', null,['class' => 'form-control' , 'id' => 'userBelongingName', 'placeholder' => 'نام اسناد فنی']) !!}
                                                <span class="form-control-feedback" id = "userBelongingNameAlert">
                                                        <strong></strong>
                                                </span>
                                                {{--{!! Form::text('description', null,['class' => 'form-control' , 'id' => 'userBelongingDescription', 'placeholder' => 'توضیحات اسناد فنی']) !!}--}}
                                                {{--<span class="form-control-feedback" id="userBelongingDescriptionAlert">--}}
                                                {{--<strong></strong>--}}
                                                {{--</span>--}}
                                                <div class = "fileinput fileinput-new" id = "thumbnail-div" data-provides = "fileinput">
                                                    <div class = "input-group input-large">
                                                        <div class = "form-control uneditable-input input-fixed input-medium" data-trigger = "fileinput">
                                                            <i class = "fa fa-file fileinput-exists"></i>&nbsp;
                                                            <span class = "fileinput-filename"> </span>
                                                        </div>
                                                        <span class = "input-group-addon btn default btn-file">
                                                                        <span class = "fileinput-new">فایل سند فنی </span>
                                                                        <span class = "fileinput-exists"> تغییر </span>
                                                            {!! Form::file('file') !!} </span>
                                                        <a href = "javascript:" class = "input-group-addon btn red fileinput-exists" data-dismiss = "fileinput"> حذف</a>
                                                    </div>
                                                </div>
                                                {!! Form::hidden('userId', $user->id,['id'=>'belongingUserIdInput']) !!}
                                            </div>
                                            <div class = "modal-footer">
                                                <button type = "button" data-dismiss = "modal" class = "btn btn-outline dark">
                                                    بستن
                                                </button>
                                                <button type = "submit" class = "btn green">ثبت</button>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    @endif
                                    @endpermission
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class = "table table-striped table-bordered table-hover dt-responsive" width = "100%" id = "belonging_table">
                        <div id = "deleteBelongingConfirmationModal" class = "modal fade" tabindex = "-1" data-backdrop = "static" data-keyboard = "false">
                            <div class = "modal-header">حذف اسناد فنی
                                <span id = "deleteBelongingFullName"></span>
                            </div>
                            <div class = "modal-body">
                                <p> آیا مطمئن هستید؟</p>
                                {!! Form::hidden('belonging_id', null) !!}
                            </div>
                            <div class = "modal-footer">
                                <button type = "button" data-dismiss = "modal" class = "btn btn-outline dark">خیر</button>
                                <button type = "button" data-dismiss = "modal" class = "btn green" onclick = "removeBelonging()">بله
                                </button>
                            </div>
                        </div>
                        <thead>
                        <tr>
                            <th></th>
                            @if(!isset($user))
                                <th class = "all">مشتری</th> @endif
                            <th class = "min-tablet"> عنوان</th>
                            {{--<th class="all text-center">توضیح </th>--}}
                            <th class = "all"> سند فنی</th>
                            <th class = "none"> زمان ثبت نام</th>
                            <th class = "all"> عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($belongings) && !$belongings->isEmpty())
                            @foreach($belongings as $belonging)
                                <tr id = "{{$belonging->id}}">
                                    <th></th>
                                    {{--<th class="text-center">{{$counter++}}</th>--}}
                                    @if(!isset($user))
                                        <td>@if(!$belonging->users->isEmpty()) @if(isset($belonging->users->first()->firstName) || $belonging->users->first()->lastName){{$belonging->users->first()->firstName}} {{$belonging->users->first()->lastName}} @else
                                                <span class = "m-badge m-badge--wide label-sm m-badge--warning">کاربر ناشناس</span> @endif @else
                                                <span class = "m-badge m-badge--wide label-sm m-badge--danger">بدون مالک</span> @endif
                                        </td> @endif
                                    <td id = "belongingFullName_{{$belonging->id}}">@if(isset($belonging->name) && strlen($belonging->name)>0 ) {{ $belonging->name}} @else
                                            <span class = "m-badge m-badge--wide label-sm m-badge--danger">بدون توضیح</span> @endif
                                    </td>
                                    {{--                                    <td >@if(isset($belonging->description) && strlen($belonging->description)>0 ) {{ $belonging->description}} @else <span class="m-badge m-badge--wide label-sm m-badge--warning">بدون توضیح</span> @endif</td>--}}
                                    <td>@if(isset($belonging->file) && strlen($belonging->file)>0 )
                                            <a href = "{{action("Web\HomeController@download" , ["content"=>"سند فنی دارایی","fileName"=>$belonging->file ])}}" class = "btn btn-xs red">دانلود فایل</a> @else
                                            <span class = "m-badge m-badge--wide label-sm m-badge--danger">درج نشده</span> @endif
                                    </td>
                                    <td>@if(isset($belonging->created_at) ) {{ $belonging->CreatedAt_Jalali()}} @else
                                            <span class = "m-badge m-badge--wide label-sm m-badge--danger">درج نشده</span> @endif
                                    </td>
                                    <td>@permission((Config::get('constants.REMOVE_BELONGING_ACCESS')))
                                        <a class = "deleteBelonging" data-target = "#deleteBelongingConfirmationModal" data-toggle = "modal">
                                            <i class = "fa fa-remove" aria-hidden = "true"></i>
                                            حذف
                                        </a>
                                        @endpermission
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan = "7">
                                    <h4 class = "text-center bold">اسناد فنی برای این کاربر ثبت نشده است</h4>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src = "/assets/global/scripts/datatable.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/datatables/datatables.min.js" type = "text/javascript"></script>
    {{--<script src="/acm/extra/persian-datepicker/lib/bootstrap/js/bootstrap.min.js" type="text/javascript" ></script>--}}
    <script src = "/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type = "text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src = "/assets/pages/scripts/ui-extended-modals.min.js" type = "text/javascript"></script>
@endsection

@section("extraJS")
    <script src = "/js/extraJS/scripts/admin-makeDataTable.js" type = "text/javascript"></script>
    <script type = "application/javascript">

        jQuery(document).ready(function () {
            var newDataTable = $("#belonging_table").DataTable();
            newDataTable.destroy();
            makeDataTable("belonging_table");
        });

        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': window.Laravel.csrfToken,
                }
            });
        });

        $(document).on("click", ".deleteBelonging", function () {
            var belonging_id = $(this).closest('tr').attr('id');
            $("input[name=belonging_id]").val(belonging_id);
            $("#deleteBelongingFullName").text($("#belongingFullName_" + belonging_id).text());
        });

        function removeBelonging() {
            var belonging_id = $("input[name=belonging_id]").val();
            $.ajax({
                type: 'POST',
                url: 'belonging/' + belonging_id,
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
@endpermission
