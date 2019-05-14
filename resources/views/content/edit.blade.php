@permission((Config::get('constants.EDIT_EDUCATIONAL_CONTENT')))@extends("app",["pageName"=>"admin"])

@section('page-css')

    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-summernote/summernote.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.min.css" rel = "stylesheet" type = "text/css"/>
{{--    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/dropzone/basic.min.css" rel = "stylesheet" type = "text/css"/>--}}
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/css/multi-select-rtl.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr-rtl.min.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel = "stylesheet" type = "text/css"/>


    <style>
        .datepicker-header {
            direction: ltr;
        }

        span.tag {
            direction: ltr;
        }
        
        #editForm .list-group .list-group-item .badge {
            font-size: 1rem;
        }
    </style>


@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "flaticon-home-2 m--padding-right-5"></i>
                <a class = "m-link" href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item" aria-current = "page">
                <a class = "m-link" href = "{{action("Web\HomeController@adminContent")}}">پنل مدیریتی</a>
            </li>
            <li class = "breadcrumb-item" aria-current = "page">
                <a class = "m-link" href = "#">
                    اصلاح محتوای آموزشی
                </a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "{{action("Web\ContentController@show" , $content->id)}}">
                    {{$content->name}}
                </a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class = "row">
        <div class = "col">
            @include("systemMessage.flash")
            {{--@if(!$errors->isEmpty())--}}
            {{--<div  class="custom-alerts alert alert-warning fade in margin-top-10">--}}
            {{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>--}}
            {{--<i class="fa fa-exclamation-triangle"></i>--}}
            {{--لطفا خطاهای ورودی را بطرف نمایید--}}
            {{--</div>--}}
            {{--@endif--}}
            <div class = "m-portlet m-portlet--mobile">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
                            <h3 class = "m-portlet__head-text">
                                تغییر اسم فایل ها
                            </h3>
                        </div>
                    </div>
                </div>
                <div class = "m-portlet__body">

                    {!! Form::open(['method' => 'POST','action' => ['Web\ContentController@basicStore'], 'class'=>'form-horizontal'  ,'accept-charset'=>'UTF-8']) !!}
                    <div class = "row">
                        <div class = "col">
                            {!! Form::hidden('educationalContentId',$content->id) !!}
                            <div class = "col-md-6">
                                {!! Form::text('newFileFullName', null, ['class' => 'form-control', 'placeholder'=>'نام فایل کامل ( با دات ام پی فر)', 'dir'=>'ltr']) !!}
                                {!! Form::text('newContetnsetId', optional($contentset)->id, ['class' => 'form-control', 'placeholder'=>'شماره درس', 'dir'=>'ltr']) !!}
                            </div>
                            <div class = "col-md-4">
                                <button type = "submit" class = "btn btn-success">ذخیره</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}


                </div>
            </div>

            <div class = "m-portlet m-portlet--mobile">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
                            <h3 class = "m-portlet__head-text">
                                حذف فایل
                            </h3>
                        </div>
                    </div>
                </div>
                <div class = "m-portlet__body">

                    <div id = "deleteFileConfirmationModal" class = "modal fade" tabindex = "-1" data-backdrop = "static" data-keyboard = "false">
                        <div class = "modal-header">حذف فایل</div>
                        <div class = "modal-body">
                            <p> آیا مطمئن هستید؟</p>
                            {!! Form::hidden('file_id', null) !!}
                            {!! Form::hidden('content_id', null) !!}
                        </div>
                        <div class = "modal-footer">
                            <button type = "button" data-dismiss = "modal" class = "btn btn-outline dark">خیر</button>
                            <button type = "button" data-dismiss = "modal" class = "btn green" id = "removeFileSubmit">بله
                            </button>
                        </div>
                    </div>
                    {!! Form::model($content , ['files'=>true,'method' => 'PUT','action' => ['Web\ContentController@update',$content], 'class'=>'form-horizontal' , 'id'=>'editForm' ,'accept-charset'=>'UTF-8' , 'enctype'=>'multipart/form-data']) !!}
                    @if(isset($contentset))
                        {!! Form::hidden('contentset', $contentset->id) !!}
                    @endif
                    @include('content.form2')
                    {!! Form::close() !!}

                </div>
            </div>

        </div>
    </div>
@endsection


@section('page-js')
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-summernote/summernote.min.js" type = "text/javascript"></script>
    <script src = "/acm/extra/persian-datepicker/lib/persian-date.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery.input-ip-address-control-1.0.min.js" type = "text/javascript"></script>
{{--    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/dropzone/dropzone.min.js" type = "text/javascript"></script>--}}
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/js/jquery.multi-select.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/select2/js/select2.full.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/js/bootstrap-modal.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-toastr.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-editors.js" type = "text/javascript"></script>
    <script src = "/acm/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/scripts/app.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/scripts/form-input-mask.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-bootstrap-multiselect.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-extended-modals.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-toastr.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/js/admin-makeMultiSelect.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/js/admin-edit-educationalContent.js" type = "text/javascript"></script>
    <script type="text/javascript">
        $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput({
            tagClass: 'm-badge m-badge--info m-badge--wide m-badge--rounded'
        });
    </script>
@endsection
@endpermission
