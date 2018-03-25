<div class="portlet light ">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-files-o " aria-hidden="true"></i>
            <span class="caption-subject font-dark sbold uppercase">جدول فایل های محصول</span>
        </div>
        @permission((Config::get('constants.INSERT_PRODUCT_FILE_ACCESS')))
        <div class="actions">
            <div class="btn-group">
                <a target="_blank" href="{{action("ProductfileController@create" , ["product"=>$product->id])}}" class="btn btn-sm blue-dark"><i class="fa fa-plus-circle"></i>آپلود فایل</a>
                <a class="btn btn-sm dark dropdown-toggle" data-toggle="modal" href="#createProductFile"><i class="fa fa-plus-circle"></i>درج فایل با لینک</a>
                <div id="createProductFile" class="modal fade" tabindex="-1" data-width="500">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">افزودن فایل جدید</h4>
                    </div>
                    {!! Form::open(['files'=>true, 'method' => 'POST','action' => 'ProductfileController@store', 'class'=>'nobottommargin']) !!}
                    @foreach($defaultProductFileOrders as $defaultProductFileOrder)
                        <input type="hidden" id="lastProductFileOrder_{{$defaultProductFileOrder["fileTypeId"]}}" value="{{$defaultProductFileOrder["lastOrder"]}}">
                    @endforeach
                    <div class="modal-body">
                        <div class="row">
                            @include('product.productFile.form')
                            {!! Form::hidden('product_id', $product->id) !!}
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" data-dismiss="modal" class="btn btn-outline dark">بستن</button>
                        <button type="submit" class="btn blue-hoki">ذخیره</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        @endpermission
    </div>
    <div class="portlet-body form">
        <div class="table-scrollable">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th class="text-center bold"> ترتیب </th>
                    <th class="text-center bold"> نام </th>
                    <th class="text-center bold"> نوع </th>
                    <th class="text-center bold"> فایل </th>
                    <th class="text-center bold"> فعال/غیرفعال </th>
                    <th class="text-center bold"> عملیات </th>
                    <th class="text-center bold" > تاریخ نمایان شدن </th>
                </tr>
                </thead>
                <tbody>
                @if(!$productFiles->isEmpty())
                    @foreach($productFiles as $file)
                        <tr class="text-center">
                            <td>@if(isset($file->order)){{$file->order}}@else <span class="label label-sm label-danger"> ندارد </span> @endif</td>
                            <td>@if(isset($file->name) && strlen($file->name) > 0){{$file->name}}@else <span class="label label-sm label-danger"> نا مشخص </span> @endif</td>
                            <td>@if(isset($file->productfiletype->id)){{$file->productfiletype->displayName}}@else <span class="label label-sm label-warning"> نا مشخص </span> @endif</td>
                            <td>
                                <a class="btn yellow" href="{{action("HomeController@download" , ["content"=>"فایل محصول","fileName"=>$file->file , "pId"=>$file->product_id ])}}">
                                    <i class="fa fa-download"></i>
                                    دانلود </a>
                            </td>
                            <td>@if($file->enable) <span class="label label-sm label-success"> فعال </span> @else <span class="label label-sm label-danger"> غیر فعال </span>  @endif</td>
                            <td>
                                @permission((Config::get('constants.EDIT_PRODUCT_FILE_ACCESS')))
                                <a class="btn btn-info" href="{{action("ProductfileController@edit" , $file)}}">
                                    <i class="fa fa-pencil"></i> اصلاح </a>
                                @endpermission
                            </td>
                            <td dir="ltr">@if($file->validSince) {{$file->validSince_Jalali()}} @else <span class="label label-sm label-info"> نامشخص </span>  @endif</td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="7" class="bold text-center">فایلی درج نشده است</td></tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
