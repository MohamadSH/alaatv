<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    جدول فایل های محصول
                </h3>
            </div>
        </div>
        @permission((Config::get('constants.INSERT_PRODUCT_FILE_ACCESS')))
        <div class="m-portlet__head-tools">

            <div class="actions">
                <div class="btn-group">
                    <a target="_blank" href="{{action("Web\ProductfileController@create" , ["product"=>$product->id])}}" class="btn m-btn--pill m-btn--air btn-primary">
                        <i class="fa fa-plus-circle"></i>
                        آپلود فایل
                    </a>
                    <a class="btn m-btn--pill m-btn--air btn-primary"
                            data-toggle="modal" href="#createProductFile" data-target="#createProductFile">
                        <i class="fa fa-plus-circle"></i>
                        درج فایل با لینک
                    </a>


                    <!--begin::Modal-->
                    <div class="modal fade" id="createProductFile" tabindex="-1" role="dialog" aria-labelledby="createProductFileModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createProductFileModalLabel">افزودن فایل جدید</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                    </button>
                                </div>
                                {!! Form::open(['files'=>true, 'method' => 'POST','action' => 'Web\ProductfileController@store', 'class'=>'nobottommargin']) !!}
                                @foreach($defaultProductFileOrders as $defaultProductFileOrder)
                                    <input type="hidden" id="lastProductFileOrder_{{$defaultProductFileOrder["fileTypeId"]}}" value="{{$defaultProductFileOrder["lastOrder"]}}">
                                @endforeach
                                <div class="modal-body">
                                    <div class="row">
                                        @include('product.productFile.form')
                                        {!! Form::hidden('product_id', $product->id) !!}
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                    <button type="submit" class="btn btn-primary">ذخیره</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->


                </div>
            </div>

        </div>
        @endpermission
    </div>
    <div class="m-portlet__body">

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th class="text-center bold"> ترتیب</th>
                    <th class="text-center bold"> نام</th>
                    <th class="text-center bold"> نوع</th>
                    <th class="text-center bold"> فایل</th>
                    <th class="text-center bold"> فعال/غیرفعال</th>
                    <th class="text-center bold"> عملیات</th>
                    <th class="text-center bold"> تاریخ نمایان شدن</th>
                </tr>
                </thead>
                <tbody>
                @if(!$productFiles->isEmpty())
                    @foreach($productFiles as $file)
                        <tr class="text-center">
                            <td>@if(isset($file->order)){{$file->order}}@else
                                    <span class="m-badge m-badge--wide label-sm m-badge--danger"> ندارد </span> @endif
                            </td>
                            <td>@if(isset($file->name) && strlen($file->name) > 0){{$file->name}}@else
                                    <span class="m-badge m-badge--wide label-sm m-badge--danger"> نا مشخص </span> @endif
                            </td>
                            <td>@if(isset($file->productfiletype->id)){{$file->productfiletype->displayName}}@else
                                    <span class="m-badge m-badge--wide label-sm m-badge--warning"> نا مشخص </span> @endif
                            </td>
                            <td>
                                <a class="btn yellow" href="{{action("Web\HomeController@download" , ["content"=>"فایل محصول","fileName"=>$file->file , "pId"=>$file->product_id ])}}">
                                    <i class="fa fa-download"></i>
                                    دانلود
                                </a>
                            </td>
                            <td>@if($file->enable)
                                    <span class="m-badge m-badge--wide label-sm m-badge--success"> فعال </span> @else
                                    <span class="m-badge m-badge--wide label-sm m-badge--danger"> غیر فعال </span>  @endif
                            </td>
                            <td>
                                @permission((Config::get('constants.EDIT_PRODUCT_FILE_ACCESS')))
                                <a class="btn btn-info" href="{{action("Web\ProductfileController@edit" , $file)}}">
                                    <i class="fa fa-pencil"></i>
                                    اصلاح
                                </a>
                                @endpermission
                            </td>
                            <td dir="ltr">@if($file->validSince) {{$file->validSince_Jalali()}} @else
                                    <span class="m-badge m-badge--wide label-sm m-badge--info"> نامشخص </span>  @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="bold text-center">فایلی درج نشده است</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
