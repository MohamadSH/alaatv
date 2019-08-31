@permission((Config::get('constants.EDIT_EDUCATIONAL_CONTENT')))@extends("app",["pageName"=>"admin"])

@section('page-css')

    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
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
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item" aria-current = "page">
                <a class = "m-link" href = "{{action("Web\AdminController@adminContent")}}">پنل مدیریتی</a>
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

                    {!! Form::open(['method' => 'POST','action' => ['Web\ContentController@updateSet'], 'class'=>'form-horizontal'  ,'accept-charset'=>'UTF-8']) !!}
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
                            </h3>
                        </div>
                    </div>
                </div>
                <div class = "m-portlet__body">

{{--                    <div id = "deleteFileConfirmationModal" class = "modal fade" tabindex = "-1" data-backdrop = "static" data-keyboard = "false">--}}
{{--                        <div class = "modal-header">حذف فایل</div>--}}
{{--                        <div class = "modal-body">--}}
{{--                            <p> آیا مطمئن هستید؟</p>--}}
{{--                            {!! Form::hidden('file_id', null) !!}--}}
{{--                            {!! Form::hidden('content_id', null) !!}--}}
{{--                        </div>--}}
{{--                        <div class = "modal-footer">--}}
{{--                            <button type = "button" data-dismiss = "modal" class = "btn btn-outline dark">خیر</button>--}}
{{--                            <button type = "button" data-dismiss = "modal" class = "btn green" id = "removeFileSubmit">بله--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
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
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/js/admin-edit-educationalContent.js" type = "text/javascript"></script>
    <script type="text/javascript">
        $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput({
            tagClass: 'm-badge m-badge--info m-badge--wide m-badge--rounded'
        });
    </script>
@endsection
@endpermission
