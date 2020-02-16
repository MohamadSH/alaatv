@permission((Config::get('constants.INSERT_PRODUCT_FILE_ACCESS')))
@extends('partials.templatePage',["pageName"=>"admin"])
@section("pageBar")
    <div class = "page-bar">
        <ul class = "page-breadcrumb">
            <li>
                <i class = "icon-home"></i>
                <a href = "{{route('web.index')}}">@lang('page.Home')</a>
                <i class = "fa fa-angle-left"></i>
            </li>
            <li>
                <a href = "{{action("Web\AdminController@adminProduct")}}">پنل مدیریتی محصولات</a>
                <i class = "fa fa-angle-left"></i>
            </li>
            <li>
                <a href = "{{action("Web\ProductController@edit" , $product)}}">اصلاح محصول {{$product->name}}</a>
                <i class = "fa fa-angle-left"></i>
            </li>
            <li>
                <span>ایجاد پیکر بندی محصول</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class = "row">
        <div class = "col-md-12">
            @include("systemMessage.flash")
            <div class = "portlet light ">
                <div class = "portlet-title">
                    <div class = "caption">
                        <i class = "icon-settings font-dark"></i>
                        <span class = "caption-subject font-dark sbold uppercase">پیکر بندی محصول <a href = "{{action("Web\ProductController@show" , $product)}}">{{$product->name}}</a></span>
                    </div>
                    <div class = "actions">
                        <div class = "btn-group">
                            <a class = "btn btn-sm dark dropdown-toggle" href = "{{action("Web\ProductController@edit" , $product)}}"> بازگشت
                                <i class = "fa fa-angle-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class = "portlet-body form">
                    {!! Form::open(['method' => 'POST', 'action' => ['ProductController@makeConfiguration', $product]]) !!}
                    @if(!$attributeCollection->isEmpty())
                        @foreach($attributeCollection as  $attribute)
                            <div class = "col-md-12">
                                <div class = "form-group">
                                    <label>{{$attribute["attribute"]->displayName}} ({{$attribute["attributeControl"]}}
                                                                                    )
                                    </label>
                                    <div class = "row list-group-item">
                                        <div class = "mt-checkbox-inline">
                                            @foreach($attribute["attributevalues"] as $attributevalue)
                                                <div class = "row">
                                                    <div class = "col-md-2">
                                                        <label class = "mt-checkbox">
                                                            <input type = "checkbox" value = "{{$attributevalue->id}}" name = "attributevalues[{{$attribute['attribute']->id}}][]" class = "attributevalueCheckbox" id = "checkbox_{{$attributevalue->id}}"> {{$attributevalue->name}}
                                                            <span class = "bg-grey-cararra"></span>
                                                        </label>
                                                    </div>
                                                    <div class = "col-md-10">
                                                        <input type = "text" name = "extraCost[{{$attributevalue->id}}]" id = "extraCost_{{$attributevalue->id}}" placeholder = "قیمت افزوده" dir = "ltr" size = "10" disabled>
                                                        <input type = "text" name = "order[{{$attributevalue->id}}]" id = "order_{{$attributevalue->id}}" placeholder = "ترتیب" dir = "ltr" size = "5" disabled>
                                                        <input type = "text" name = "description[{{$attributevalue->id}}]" id = "description_{{$attributevalue->id}}" size = "75" placeholder = "توضیحات" disabled>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                        {!! Form::submit('ایجاد' , ['class' => 'btn btn-circle blue-chambray form-control']) !!}
                    @else
                        <div class = "alert alert-info bold">
                            <h3 class = "bold" style = "text-align: center;">صفتی برای انتخاب وجود ندارد.</h3>
                        </div>
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
@section("extraJS")
    <script>
        $('body').on('click', '.attributevalueCheckbox', function () {
            var checkboxId = $(this).attr("id").split("_")[1];
            if ($(this).is(":checked")) {
                $("#extraCost_" + checkboxId).prop("disabled", false);
                $("#order_" + checkboxId).prop("disabled", false);
                $("#description_" + checkboxId).prop("disabled", false);
            } else {
                $("#extraCost_" + checkboxId).prop("disabled", true);
                $("#order_" + checkboxId).prop("disabled", true);
                $("#description_" + checkboxId).prop("disabled", true);
            }
        });

    </script>
@endsection
@endpermission
