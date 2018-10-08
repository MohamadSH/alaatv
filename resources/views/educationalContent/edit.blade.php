@permission((Config::get('constants.EDIT_EDUCATIONAL_CONTENT')))
@extends("app",["pageName"=>"admin"])

@section("headPageLevelPlugin")
    <link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
    <link href="/assets/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/jquery-multi-select/css/multi-select-rtl.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
    <style>
        .datepicker-header{
            direction: ltr;
        }
        span.tag{
            direction: ltr;
        }
    </style>
@endsection

@section("metadata")
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{action("HomeController@index")}}">خانه</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <a href="{{action("HomeController@adminContent")}}">پنل مدیریتی</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>اصلاح محتوای آموزشی</span>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span><a target="_blank" href="{{action("EducationalContentController@show" , $educationalContent->id)}}">{{$educationalContent->name}}</a></span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class="row">
        <div class="col-md-12">
            @include("systemMessage.flash")
            {{--@if(!$errors->isEmpty())--}}
            {{--<div  class="custom-alerts alert alert-warning fade in margin-top-10">--}}
            {{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>--}}
            {{--<i class="fa fa-exclamation-triangle"></i>--}}
            {{--لطفا خطاهای ورودی را بطرف نمایید--}}
            {{--</div>--}}
            {{--@endif--}}
            <div class="portlet light">
                <div class="portlet-body">
                    <div class="col-md-12">
                        <h4>تغییر اسم فایل ها</h4>
                    </div>
                    <div class="row">
                        {!! Form::open(['method' => 'POST','action' => ['EducationalContentController@basicStore'], 'class'=>'form-horizontal'  ,'accept-charset'=>'UTF-8']) !!}
                        {!! Form::hidden('educationalContentId',$educationalContent->id) !!}
                        <div class="col-md-6">
                            {!! Form::text('newFileFullName', null, ['class' => 'form-control', 'placeholder'=>'نام فایل کامل ( با دات ام پی فر)', 'dir'=>'ltr']) !!}
                            {!! Form::text('newContetnsetId', optional($contentset)->id, ['class' => 'form-control', 'placeholder'=>'شماره درس', 'dir'=>'ltr']) !!}
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success">ذخیره</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="portlet light">
                <div class="portlet-body">
                    <div class="row">
                        <div id="deleteFileConfirmationModal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                            <div class="modal-header">حذف فایل </div>
                            <div class="modal-body">
                                <p> آیا مطمئن هستید؟ </p>
                                {!! Form::hidden('file_id', null) !!}
                                {!! Form::hidden('educationalContent_id', null) !!}
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-outline dark">خیر</button>
                                <button type="button" data-dismiss="modal"  class="btn green" id="removeFileSubmit" >بله</button>
                            </div>
                        </div>
                        {!! Form::model($educationalContent , ['files'=>true,'method' => 'PUT','action' => ['EducationalContentController@update',$educationalContent], 'class'=>'form-horizontal' , 'id'=>'editForm' ,'accept-charset'=>'UTF-8' , 'enctype'=>'multipart/form-data']) !!}
                            @if(isset($contentset))
                                {!! Form::hidden('contentset', $contentset->id) !!}
                            @endif
                            @include('educationalContent.form2')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
    <script src="/assets/extra/persian-datepicker/lib/persian-date.js" type="text/javascript" ></script>
    <script src="/assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/dropzone/dropzone.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src="/assets/pages/scripts/components-editors.min.js" type="text/javascript"></script>
    <script src="/assets/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js" type="text/javascript" ></script>
    <script src="/assets/pages/scripts/form-input-mask.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/components-bootstrap-multiselect.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/ui-extended-modals.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/ui-toastr.min.js" type="text/javascript"></script>
@endsection


@section("extraJS")
    <script src="/js/extraJS/scripts/admin-makeMultiSelect.js" type="text/javascript"></script>
    <script src="/js/extraJS/edit-educationalContent.js" type="text/javascript"></script>
@endsection
@endpermission