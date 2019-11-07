@extends("app",["pageName"=>"admin"])

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
                <a class = "m-link" href = "{{route('web.admin.content')}}">پنل مدیریتی</a>
            </li>
            <li class = "breadcrumb-item" aria-current = "page">
                <a class = "m-link" href = "#">
                    اصلاح محتوای آموزشی
                </a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "{{route('c.show' , $content->id)}}">
                    {{$content->name}}
                </a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    @include("systemMessage.flash")

    @if(auth()->user()->hasRole('editContentDescription'))
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
                {!! Form::model($content , ['method' => 'POST','url' => route( 'c.update.pending.description' , $content) ,'accept-charset'=>'UTF-8']) !!}
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2 control-label" for="description">توضیح:
                        </label>
                        <div class="col-md-9">
                            {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'descriptionSummerNote', 'rows' => '5' ]) !!}
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    @else
        @if(isset($content->contentset_id))
            <div class="row">
                <div class="col">
                    <a style="width:100%" class="btn btn-focus" href="{{route('web.set.list.contents' , $content->contentset_id)}}">برای رفتن به ست این محتوا کلیک کنید</a>
                </div>
            </div>
        @endif

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

                {!! Form::open(['method' => 'POST', 'url'=>route('c.updateSet' , ['c'=>$content]) , 'class'=>'form-horizontal'  ,'accept-charset'=>'UTF-8']) !!}
                <div class = "form-group {{ $errors->has('newFileFullName') ? ' has-danger' : '' }}">
                    <label class = "control-label" for = "name">نام فایل کامل ( با دات ام پی فر) :</label>
                    {!! Form::text('newFileFullName', null, ['class' => 'form-control', 'id' => 'newFileFullName', 'dir'=>'ltr' ]) !!}
                    @if ($errors->has('newFileFullName'))
                        <span class="form-control-feedback">
                                    <strong>{{ $errors->first('newFileFullName') }}</strong>
                                </span>
                    @endif
                </div>
                <div class = "form-group {{ $errors->has('newContetnsetId') ? ' has-danger' : '' }}">
                    <label class = "control-label" for = "name">شماره ست :</label>
                    {!! Form::text('newContetnsetId', optional($contentset)->id, ['class' => 'form-control', 'id' => 'newContetnsetId', 'dir'=>'ltr' ]) !!}
                    @if ($errors->has('newContetnsetId'))
                        <span class="form-control-feedback">
                                         <strong>{{ $errors->first('newContetnsetId') }}</strong>
                                </span>
                    @endif
                </div>
                <button type = "submit" class = "btn btn-success">ذخیره</button>
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
                {!! Form::model($content , ['files'=>true,'method' => 'PUT','url' => route( 'c.update' , $content )  , 'id'=>'editForm' ,'accept-charset'=>'UTF-8' , 'enctype'=>'multipart/form-data']) !!}
                    @if(isset($contentset))
                        {!! Form::hidden('contentset', $contentset->id) !!}
                    @endif
                    @include('content.form2')
                {!! Form::close() !!}
            </div>
        </div>
    @endif
@endsection


@section('page-js')
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script src="{{ mix('/js/admin-content-edit.js') }}" type="text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/js/admin-edit-educationalContent.js" type = "text/javascript"></script>
    <script type="text/javascript">
        $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput({
            tagClass: 'm-badge m-badge--info m-badge--wide m-badge--rounded'
        });

        @permission((config('constants.ACCEPT_CONTENT_TMP_DESCRIPTION_ACCESS')))
        var dmp = new diff_match_patch();
        function launch() {
            var text1 = document.getElementById('descriptionSummerNote').value;
            var text2 = document.getElementById('tempDescriptionSummerNote').value;
            dmp.Diff_Timeout = 1;

            var d = dmp.diff_main(text1, text2);

            dmp.diff_cleanupSemantic(d);
            var ds = dmp.diff_prettyHtml(d);
            document.getElementById('descriptionComparisonOutput').innerHTML = ds;
        }

        function showTempDescription(){
            $('#tempDescriptionCol').removeClass('d-none');
        }

        $(document).ready(function () {
            launch();
        });
        @endpermission
    </script>
@endsection
