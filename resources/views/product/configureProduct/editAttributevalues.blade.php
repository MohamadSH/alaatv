@permission((Config::get('constants.EDIT_CONFIGURE_PRODUCT_ACCESS')))
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
                <span>اصلاح مقادیر صفتها</span>
            </li>
        </ul>
        <button type = "button" class = "btn btn-lg dark" style = "float:left" onclick = "$('#updateAttributevaluesForm').submit()">دخیره
        </button>
    </div>
@endsection

@section("content")
    <div class = "row">
        <div class = "col-md-12">
            <div class = "portlet light ">
                {{--<div class="portlet-title">--}}
                {{--<div class="caption">--}}
                {{--<i class="icon-settings font-dark"></i>--}}
                {{--<span class="caption-subject font-dark sbold uppercase">صفت های اصلی</span>--}}
                {{--</div>--}}
                {{--</div>--}}
                <div class = "portlet-body">
                    {!! Form::open(['method' => 'POST', 'action' => ['ProductController@updateAttributevalues', $product] , 'id'=>'updateAttributevaluesForm']) !!}
                    <div class = "tabbable-custom nav-justified">
                        <ul class = "nav nav-tabs nav-justified">
                            @foreach($attributeValuesCollection as $key=>$item)
                                <li class = "@if($key == 1 ) active @endif">
                                    <a href = "#tab_1_1_{{$key}}" data-toggle = "tab"> {{$item["displayName"]}} </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class = "tab-content">
                            @foreach($attributeValuesCollection as $key=>$attributes)
                                <div class = "tab-pane @if($key == 1 ) active @endif" id = "tab_1_1_{{$key}}">

                                    @foreach($attributes["attributes"] as $attribute)
                                        <div class = "row">
                                            <h4 class = "text-center" style = "background: gray;color: white;padding: 10px 0px 10px;">{{$attribute["name"]}}</h4>
                                            @foreach($attribute["values"] as $value)
                                                <div class = "col-md-3">
                                                    {!! Form::checkbox('attributevalues[]', $value->id, null, ['class' => '' ,'id'=>'attributevalue_'.$value->id,  'data-checkbox'=>'icheckbox_square-blue' , (in_array($value->id,$attribute["productAttributevalues"]->pluck("id")->toArray()))?"checked":""]) !!}
                                                    <label for = "attributevalue_{{$value->id}}">{{$value->name}}</label>
                                                </div>
                                                <div class = "col-md-4">
                                                    {!! Form::text('extraCost['.$value->id.']', null, ['class' => 'form-control' , 'dir' => 'ltr' , 'placeholder'=>'قیمت افزوده به تومان']) !!}
                                                </div>
                                                <div class = "col-md-5">
                                                    {!! Form::text('description['.$value->id.']', null, ['class' => 'form-control' ,  'placeholder'=>'توضیح']) !!}
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach

                                </div>
                            @endforeach
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
@endpermission
