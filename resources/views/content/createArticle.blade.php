@permission((Config::get('constants.INSERT_EDUCATIONAL_CONTENT_ACCESS')))
@extends('partials.templatePage',["pageName"=>"admin"])

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


@section("pageBar")
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item">
                <a class = "m-link" href = "{{route('web.admin.content')}}">مدیریت محتوا</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">درح مقاله</a>
            </li>
        </ol>
    </nav>
@endsection

@section("content")
    @include("systemMessage.flash")
            <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
                            <h3 class = "m-portlet__head-text">
                                درج مقاله
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    {!! Form::open(['method' => 'POST','url' => route('c.store'), 'class'=>'form-horizontal']) !!}
                        {!! Form::input('hidden','isFree',1) !!}
                        {!! Form::input('hidden','contenttype_id' , config('constants.CONTENT_TYPE_ARTICLE')) !!}
                    <div class = "row">
                        <div class = "col">
                        @include('content.form' , ['include'=> ['file','set']])
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
@endsection

@section('page-js')
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput({
            tagClass: 'm-badge m-badge--info m-badge--wide m-badge--rounded'
        });
        $('#descriptionSummerNote').summernote({
            lang: 'fa-IR',
            height: 300,
            popover: {
                image: [],
                link: [],
                air: []
            }
        });
        $('#contextSummerNote').summernote({
            lang: 'fa-IR',
            height: 300,
            popover: {
                image: [],
                link: [],
                air: []
            }
        });

        $("#validSinceDate").persianDatepicker({
            altField: '#validSinceDateAlt',
            altFormat: "YYYY MM DD",
            observer: true,
            format: 'YYYY/MM/DD',
            altFieldFormatter: function (unixDate) {
                var d = new Date(unixDate).toISOString();
                d = d.substring(0, d.indexOf('T'));
                return d;
            }
        });

        $("#validSinceTime").inputmask("hh:mm", {
            placeholder: "",
            clearMaskOnLostFocus: true
        });
    </script>
@endsection
@endpermission
