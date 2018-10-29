<!-- BEGIN SAMPLE FORM PORTLET-->
<div class="portlet light ">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-settings font-dark"></i>
            <span class="caption-subject font-dark sbold uppercase">@if($product->producttype->id == Config::get("constants.PRODUCT_TYPE_CONFIGURABLE"))
                    پیکربندی محصول ٬@endif<a
                        href="{{action("ProductController@show" , $product)}}">{{$product->name}}</a></span>
        </div>
        @permission((Config::get('constants.EDIT_CONFIGURE_PRODUCT_ACCESS')))

        @endpermission
        {{--<div class="actions">--}}
        {{--<div class="btn-group">--}}
        {{--<a class="btn btn-sm btn-info dropdown-toggle" href="{{action("ProductController@completeEachChild", $product)}}" >افزودن فرزند--}}
        {{--<i class="fa fa-angle-left"></i>--}}
        {{--</a>--}}
        {{--</div>--}}
        {{--</div>--}}
    </div>
    <div class="portlet-body form">
        <div class="table-scrollable">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th class="text-center"> نام محصول</th>
                    <th class="text-center"> قیمت پایه</th>
                    @permission((Config::get('constants.EDIT_CONFIGURE_PRODUCT_ACCESS')))
                    <th class="text-center" colspan="2"> عملیات</th>
                    @endpermission
                </tr>
                </thead>
                <tbody>
                @if($product->hasChildren())
                    @foreach($product->children as $child)
                        {!! Form::open(['method' => 'PUT','action' => ['ProductController@childProductEnable',$child]]) !!}
                        <tr>
                            <td class="col-md-8 text-center"> {{$child->name}} </td>
                            <td class="col-md-8 text-center"> {{$child->basePrice}} </td>
                            @permission((Config::get('constants.EDIT_CONFIGURE_PRODUCT_ACCESS')))
                            @if($child->enable)
                                <td class="col-md-2 text-center">{!! Form::submit('غیر فعال کردن' , ['class' => 'btn red']) !!} </td>
                            @else
                                <td class="col-md-2 text-center">{!! Form::submit('فعال کردن' , ['class' => 'btn green-meadow']) !!} </td>
                            @endif
                            <td class="col-md-2 text-center"><a class="btn btn-info"
                                                                href="{{action("ProductController@edit" , $child)}}">اصلاح</a>
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
</div>
<!-- END SAMPLE FORM PORTLET-->
{{--@if($product->producttype->id == Config::get("constants.PRODUCT_TYPE_CONFIGURABLE"))--}}
{{--@permission((Config::get('constants.INSERT_CONFIGURE_PRODUCT_ACCESS')))--}}
{{--<!-- BEGIN SAMPLE FORM PORTLET-->--}}
{{--<div class="portlet light ">--}}
{{--<div class="portlet-body">--}}
{{--<div class="clearfix text-center">--}}
{{--<a href="{{action("ProductController@createConfiguration" , $product)}}" type="button" class="btn btn-info btn-lg bold">--}}
{{--<li class="fa fa-plus-circle"></li>  ایجاد پیکر بندی</a>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--<!--END SAMPLE FORM PORTLET-->--}}
{{--@endpermission--}}
{{--@endif--}}