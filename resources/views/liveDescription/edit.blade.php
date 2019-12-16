@extends('app')

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
                <a class="m-link" href="{{route('product.edit' , $liveDescription->product)}}">اصلاح اطلاعات محصول</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#">اصلاح اطلاعات توضیح لحظه ای</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    @include("systemMessage.flash")
    <form method="POST" action="{{route('livedescription.update' , $liveDescription)}}">
        @method('PUT')
        @csrf
        <div class = "form-group">
            <label>عنوان</label>
            <input type="text" name="title" value="{{$liveDescription->title}}">
        </div>
        <div class = "form-group">
            <label>توضیح</label>
            <textarea id="productLiveDescriptionSummerNote" name="description">{{$liveDescription->description}}</textarea>
        </div>
        <input type="submit" name="submit" value="ذخیره">
    </form>

@endsection

@section('page-js')
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script>
        $('#productLiveDescriptionSummerNote').summernote({
            lang: 'fa-IR',
            height: 300,
            popover: {
                image: [],
                link: [],
                air: []
            }
        });
    </script>
@endsection
