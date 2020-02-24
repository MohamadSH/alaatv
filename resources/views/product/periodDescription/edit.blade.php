@extends('partials.templatePage')

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home m--padding-right-5"></i>
                <a class="m-link" href="{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a class="m-link" href="{{route('web.admin.product')}}">پنل مدیریتی محصولات</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="{{route('product.edit' , $periodDescription->product)}}">اصلاح اطلاعات محصول</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#">اصلاح اطلاعات توضیح لحظه ای</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <form method="POST" action="{{route('periodDescription.update' , $periodDescription)}}">
        @method('PUT')
        @csrf
        <div class = "form-group">
            <input id = "periodDescriptionSince" type = "text" class = "form-control" value = "" dir = "ltr">
            <input name = "since" id = "periodDescriptionSinceAlt" type = "text" class = "form-control d-none">
        </div>
        <div class = "form-group">
            <input id = "periodDescriptionTill" type = "text" class = "form-control" value = "" dir = "ltr">
            <input name = "till" id = "periodDescriptionTillAlt" type = "text" class = "form-control d-none">
        </div>
        <div class = "form-group">
            <label>توضیح</label>
            <textarea id="productPeriodDescriptionSummerNote" name="description">{{$periodDescription->description}}</textarea>
        </div>
        <input type="submit" name="submit" value="ذخیره">
    </form>

@endsection

@section('page-js')
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script>
        $('#productPeriodDescriptionSummerNote').summernote({
            lang: 'fa-IR',
            height: 300,
            popover: {
                image: [],
                link: [],
                air: []
            },
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'hr']],
                ['view', ['fullscreen', 'codeview']],
                ['help', ['help']],
                ['mybutton', ['multiColumnButton']]
            ],
            buttons: {
                multiColumnButton: summernoteMultiColumnButton
            }
        });

        $("#periodDescriptionSince").persianDatepicker({
            altField: '#periodDescriptionSinceAlt',
            altFormat: "YYYY MM DD",
            observer: true,
            format: 'YYYY/MM/DD',
            altFieldFormatter: function (unixDate) {
                var d = new Date(unixDate).toISOString();
                d = d.substring(0, d.indexOf('T'));
                return d;
            }
        });

        $("#periodDescriptionSince").val('{{$periodDescription->Since_Jalali()}}');

        $("#periodDescriptionTill").persianDatepicker({
            altField: '#periodDescriptionTillAlt',
            altFormat: "YYYY MM DD",
            observer: true,
            format: 'YYYY/MM/DD',
            altFieldFormatter: function (unixDate) {
                var d = new Date(unixDate).toISOString();
                d = d.substring(0, d.indexOf('T'));
                return d;
            }
        });
        $("#periodDescriptionTill").val('{{$periodDescription->Until_Jalali()}}');
    </script>
@endsection
