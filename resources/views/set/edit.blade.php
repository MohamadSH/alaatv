@extends('app',['pageName'=>'admin'])

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .fileinput img {
            max-width: 100%;
            min-width: 100%;
        }

        .multiselect-native-select, .mt-multiselect {
            width: 100%;
        }
    </style>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home m--padding-right-5"></i>
                <a class="m-link" href="{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a class="m-link" href="{{action("Web\AdminController@adminProduct")}}">پنل مدیریتی محصولات</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#">اصلاح اطلاعات دسته</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')

    @include("systemMessage.flash")

    @include('set.form', ['editForm' => true])

@endsection

@section('page-js')
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/js/admin/page-productAdmin.js" type="text/javascript"></script>
    <script>

        jQuery(document).ready(function () {

            var selectedProducts = {!! json_encode($setProducts->pluck('id')) !!};

            $("input.setTags").tagsinput({
                tagClass: 'm-badge m-badge--info m-badge--wide m-badge--rounded'
            });

            $('#productShortDescriptionSummerNote').summernote({
                lang: 'fa-IR',
                height: 300,
                popover: {
                    image: [],
                    link: [],
                    air: []
                }
            });

            makeDataTable('productTable');

            $(document).on('click', '.btnAttachProductToSet', function(){
                let setProduct = $('#setProduct').val();
                alert('ابتدا مقادیر سلکت شده به بک اند فرستاده می شوند سپس صفحه رفرش می شود.');
            });

            $('#setProduct').multiselect('select', selectedProducts);
            
        });
    </script>
@endsection
