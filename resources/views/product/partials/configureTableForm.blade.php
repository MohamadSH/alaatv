<!-- BEGIN SAMPLE FORM PORTLET-->
<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    @if($product->producttype->id == config("constants.PRODUCT_TYPE_CONFIGURABLE"))
                        پیکربندی محصول ٬
                    @endif
                    <a href="{{action("Web\ProductController@show" , $product)}}">{{$product->name}}</a>
                </h3>
            </div>
        </div>
    </div>
    <div class="m-portlet__body">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th class="text-center"> نام محصول</th>
                <th class="text-center"> قیمت پایه</th>
                @permission((config('constants.EDIT_CONFIGURE_PRODUCT_ACCESS')))
                <th class="text-center" colspan="2"> عملیات</th>
                @endpermission
            </tr>
            </thead>
            <tbody>
            @if($product->hasChildren())
                @foreach($product->children as $child)
                    {!! Form::open(['method' => 'PUT','action' => ['Web\ProductController@childProductEnable',$child]]) !!}
                    <tr>
                        <td class="col-md-8 text-center"> {{$child->name}} </td>
                        <td class="col-md-8 text-center"> {{$child->basePrice}} </td>
                        @permission((config('constants.EDIT_CONFIGURE_PRODUCT_ACCESS')))
                        @if($child->enable)
                            <td class="col-md-2 text-center">{!! Form::submit('غیر فعال کردن' , ['class' => 'btn btn-danger']) !!} </td>
                        @else
                            <td class="col-md-2 text-center">{!! Form::submit('فعال کردن' , ['class' => 'btn btn-success']) !!} </td>
                        @endif
                        <td class="col-md-2 text-center">
                            <a class="btn btn-info" href="{{action("Web\ProductController@edit" , $child)}}">اصلاح</a>
                        </td>
                        @endpermission
                    </tr>
                    {!! Form::close() !!}
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
<!-- END SAMPLE FORM PORTLET-->{{--@if($product->producttype->id == config("constants.PRODUCT_TYPE_CONFIGURABLE"))--}}{{--@permission((config('constants.INSERT_CONFIGURE_PRODUCT_ACCESS')))--}}{{--<!-- BEGIN SAMPLE FORM PORTLET-->--}}{{--<div class="portlet light ">--}}{{--<div class="portlet-body">--}}{{--<div class="clearfix text-center">--}}{{--<a href="{{action("Web\ProductController@createConfiguration" , $product)}}" type="button" class="btn btn-info btn-lg bold">--}}{{--<li class="fa fa-plus-circle"></li>  ایجاد پیکر بندی</a>--}}{{--</div>--}}{{--</div>--}}{{--</div>--}}{{--<!--END SAMPLE FORM PORTLET-->--}}{{--@endpermission--}}{{--@endif--}}
