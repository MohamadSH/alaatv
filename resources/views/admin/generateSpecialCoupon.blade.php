@extends('partials.templatePage')

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">تولید کپن تخفیف تصادفی</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')

    <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
        <div class = "m-portlet__body">

            {!! Form::open(['method'=>'POST' , 'action'=>'Web\CouponController@generateRandomCoupon' , 'id'=>'couponGeneratorForm']) !!}
            <input type = "hidden" name = "discounttype_id" value = "1">
            <input type = "hidden" name = "description" value = "تولید شده توسط {{Auth::user()->fullName}} برای تقدیر از گزارش خطای سایت">
            <input type = "hidden" name = "name" value = "هدیه کمک به آلا">
            <input type = "hidden" name = "enable" value = "1">

            <div class = "form-group">
                <input id = "hasLimitedProductsCheckbox" type = "checkbox" name = "hasLimitiedProducts" value = "1">&nbsp;<label class = "control-label" for = "hasLimitedProductsCheckbox">دارای محصولات خاص</label>
                <select class = "js-selectProduct-single" multiple = "multiple" id = "products" name = "products[]" style = "width: 100%;">
                    @foreach($productCollection as $item)
                        <optgroup label = "{{$item->name}}">
                            @if(count($childrenCollection[$item->id]) == 0)
                                <option value = "{{$item->id}}">{{$item->name}}</option>
                            @endif
                            @foreach($childrenCollection[$item->id] as $child)
                                <option value = "{{$child->id}}">{{$child->name}}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
            {{--<div class="form-group">--}}
            {{--<label for="exampleInputEmail1">نام کد تخفیف: </label>--}}
            {{--<input type="text" class="form-control" name="name" id="name" placeholder="نام کد تخیفیف: ">--}}
            {{--</div>--}}
            {{--<br>--}}
            <div class = "form-group">
                {{--<label for="exampleInputEmail1">درصد تخفیف: (بدون علامت %)</label>--}}
                <input type = "text" class = "form-control" id = "discount" name = "discount" placeholder = "درصد تخفیف: (بدون علامت %)">
            </div>

            <div class = "form-group">
                <div class = "row">
                    <div class = "col-md-3">
                        <input type = "radio" name = "usageLimitRadio" id = "userLimit_unlimited" value = "unlimited">&nbsp;<label class = "control-label" for = "userLimit_unlimited">بدون محدودیت</label>
                        <input type = "radio" name = "usageLimitRadio" id = "userLimit_limited" value = "limited" checked>&nbsp;<label class = "control-label" for = "userLimit_limited"> با محدودیت</label>
                    </div>

                    <div class = "col-md-9">
                        {!! Form::text('usageLimit', null, ['class' => 'form-control', 'id' => 'usageLimit' , 'dir'=>"ltr" , 'placeholder'=>'تعداد کپن']) !!}
                    </div>
                </div>
            </div>
            <hr>
            <div class = "form-group">
                <div class = "row">
                    <div class = "col">
                        <input type = "checkbox" name = "hasValidDateTime" id = "hasValidDateTime" value = "1">
                        <label class = "control-label" for = "hasValidDateTime">تعیین تاریخ استفاده</label>
                    </div>
                </div>
            </div>
            <div class = "form-group">
                <div class = "row">
                    <label class = "col-md-1 control-label">معتبر از</label>
                    <div class = "col-md-6">
                        <input id = "validSinceDate" type = "text" class = "form-control" disabled>
                        <input name = "validSinceDate" id = "validSinceDateAlt" type = "text" class = "form-control d-none" disabled>
                    </div>
                    <div class = "col-md-5">
                        <input name = "validSinceTime" id = "validSinceTime" type = "text" class = "form-control" dir = "ltr" disabled>
                    </div>
                </div>
            </div>

            <div class = "form-group">
                <div class = "row">
                    <label class = "col-md-1 control-label">معتبر تا</label>
                    <div class = "col-md-6">
                        <input id = "validTillDate" type = "text" class = "form-control" disabled>
                        <input name = "validTillDate" id = "validTillDateAlt" type = "text" class = "form-control d-none" disabled>
                    </div>
                    <div class = "col-md-5">
                        <input name = "validTillTime" id = "validTillTime" type = "text" class = "form-control" dir = "ltr" disabled>
                    </div>
                </div>
            </div>

            <br>
            <button class = "btn btn-info" id = "btnGenerateCoupon">ساخت کد</button>
            <hr>

            <div class = "alert alert-success" id = "successMessage" role = "alert">
                <div class = "serverMessaage"></div>
                کد تخفیف ساخته شده عبارت است از: <strong id = "generatedCoupon"></strong>
            </div>
            <div class = "alert alert-info" id = "infoMessage" role = "alert">لطفا کمی صبر کنید...</div>
            <div class = "alert alert-danger" id = "dangerMessage" role = "alert">
                <div class = "serverMessaage"></div>
            </div>


        </div>
    </div>

@endsection

@section('page-js')
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function () {

            $('#successMessage').fadeOut(0);
            $('#dangerMessage').fadeOut(0);
            $('#infoMessage').fadeOut(0);
            $("#hasLimitedProductsCheckbox").trigger("click");

            $('.js-selectProduct-single').select2({
                placeholder: 'یک محصول را انتخاب کنید:'
            });
            $(document).on('click', '#btnGenerateCoupon', function (e) {
                e.preventDefault();
                $('#successMessage').fadeOut(0);
                $('#dangerMessage').fadeOut(0);
                $('#infoMessage').fadeIn(0);

                $('.serverMessaage').html('');
                $('#generatedCoupon').html('');
                var couponForm = $("#couponGeneratorForm");
                $.ajax({

                    url: couponForm.attr("action"),
                    type: 'POST',
                    data: couponForm.serialize(),
                    dataType: 'json',
                    success: function (result) {

                        $('.serverMessaage').html(result.message);
                        $('#generatedCoupon').html(result.code);

                        $('#successMessage').fadeIn(0);
                        $('#dangerMessage').fadeOut(0);
                        $('#infoMessage').fadeOut(0);
                    },
                    error: function (error) {
                        $('.serverMessaage').html(error.message);

                        $('#successMessage').fadeOut(0);
                        $('#infoMessage').fadeOut(0);
                        $('#dangerMessage').fadeIn(0);
                    }
                });
            });
        });


        $(document).on('click', '#hasLimitedProductsCheckbox', function () {
            console.log("in checked");
            if ($("#hasLimitedProductsCheckbox").is(':checked')) {
                console.log("in if checked");
                $("#products").attr("disabled", false);
            } else {
                $("#products").attr("disabled", true);
            }
        });

        $(document).on('click', '#userLimit_limited', function () {
            $("#usageLimit").attr("disabled", false);
        });

        $(document).on('click', '#userLimit_unlimited', function () {
            $("#usageLimit").attr("disabled", true);
        });

        $(document).on('click', '#hasValidDateTime', function () {
            if ($("#hasValidDateTime").is(':checked')) {
                $("#validSinceDate").attr("disabled", false);
                $("#validSinceDateAlt").attr("disabled", false);
                $("#validSinceTime").attr("disabled", false);
                $("#validTillDate").attr("disabled", false);
                $("#validTillDateAlt").attr("disabled", false);
                $("#validTillTime").attr("disabled", false);
            } else {
                $("#validSinceDate").attr("disabled", true);
                $("#validSinceDateAlt").attr("disabled", true);
                $("#validSinceTime").attr("disabled", true);
                $("#validTillDate").attr("disabled", true);
                $("#validTillDateAlt").attr("disabled", true);
                $("#validTillTime").attr("disabled", true);
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
            clearMaskOnLostFocus: true
        });

        $("#validTillDate").persianDatepicker({
            altField: '#validTillDateAlt',
            altFormat: "YYYY MM DD",
            observer: true,
            format: 'YYYY/MM/DD',
            altFieldFormatter: function (unixDate) {
                var d = new Date(unixDate).toISOString();
                d = d.substring(0, d.indexOf('T'));
                return d;
            }
        });

        $("#validTillTime").inputmask("hh:mm", {
            clearMaskOnLostFocus: true
        });
    </script>
@endsection
