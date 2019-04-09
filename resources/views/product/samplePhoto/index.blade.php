<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    جدول نمونه عکسهای محصول
                </h3>
            </div>
        </div>
        @permission((config('constants.INSERT_PRODUCT_SAMPLE_PHOTO_ACCESS')))
            <div class="m-portlet__head-tools">
                <div class="actions">
                    <div class="btn-group">
                        <a class="btn btn-sm dark dropdown-toggle" data-toggle="modal" href="#createProductPhoto"><i
                                    class="fa fa-plus-circle"></i>افزودن نمونه عکس

                        </a>
                        <div id="createProductPhoto" class="modal fade" tabindex="-1" data-width="500">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">افزودن نمونه عکس</h4>
                            </div>
                            {!! Form::open(['files'=>true, 'method' => 'POST','action' => 'Web\ProductphotoController@store', 'class'=>'nobottommargin']) !!}
                            <div class="modal-body">
                                <div class="row">
                                    @include('product.samplePhoto.form')
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
            </div>
        @endpermission


    </div>
    <div class="m-portlet__body">
        <div class="table-scrollable">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th class="text-center bold"> ترتیب</th>
                    <th class="text-center bold"> عنوان</th>
                    <th class="text-center bold"> متن توضیجی</th>
                    <th class="text-center bold"> فایل</th>
                    <th class="text-center bold"> فعال/غیرفعال</th>
                    <th class="text-center bold"> عملیات</th>
                </tr>
                </thead>
                <tbody>
                @if(!$productPhotos->isEmpty())
                    @foreach($productPhotos as $photo)
                        <tr class="text-center">
                            <td>@if(isset($photo->order)){{$photo->order}}@else <span
                                        class="label label-sm label-danger"> ندارد </span> @endif</td>
                            <td>@if(isset($photo->title[0])){{$photo->title}}@else <span
                                        class="label label-sm label-danger"> نا مشخص </span> @endif</td>
                            <td>@if(isset($photo->description[0])){{$photo->description}}@else <span
                                        class="label label-sm label-danger"> نا مشخص </span> @endif</td>
                            <td>
                                <div class="mt-element-overlay">
                                    <div class="mt-overlay-1">
                                        <img alt="عکس محصول @if(isset($photo->title[0])) {{$photo->title}} @endif"
                                             class="timeline-badge-userpic" style="width: 60px ;height: 60px"
                                             src="{{ route('image', ['category'=>'4','w'=>'60' , 'h'=>'60' ,  'filename' =>  $photo->file ]) }}"/>
                                        <div class="mt-overlay">
                                            <ul class="mt-info">
                                                <li>
                                                    <a class="btn default btn-outline" data-toggle="modal"
                                                       href="#productPhoto-{{$photo->id}}">
                                                        <i class="icon-magnifier"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a target="_blank" class="btn default btn-outline" href = "{{action("Web\HomeController@download" , ["content"=>"عکس محصول","fileName"=>$photo->file ])}}">
                                                        <i class="icon-link"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- image Modal -->
                                <div id="productPhoto-{{$photo->id}}" class="modal fade" tabindex="-1" data-width="760">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true"></button>
                                        <h4 class="modal-title">نمایش عکس محصول</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row" style="text-align: center;">
                                            <img alt="عکس محصول @if(isset($photo->title[0])) {{$photo->title}} @endif"
                                                 style="width: 80%"
                                                 src="{{ route('image', ['category'=>'4','w'=>'608' , 'h'=>'608' ,  'filename' =>  $photo->file ]) }}"/>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" data-dismiss="modal" class="btn btn-outline dark">بستن
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td>@if($photo->enable) <span class="label label-sm label-success"> فعال </span> @else <span
                                        class="label label-sm label-danger"> غیر فعال </span>  @endif</td>
                            <td>
                                @permission((config('constants.EDIT_PRODUCT_SAMPLE_PHOTO_ACCESS')))
                                <a class = "btn btn-info" href = "{{action("Web\ProductphotoController@edit" , $photo)}}">
                                    <i class="fa fa-pencil"></i> اصلاح </a>
                                @endpermission
                                @permission((config('constants.REMOVE_PRODUCT_SAMPLE_PHOTO_ACCESS')))
                                <a class="btn btn-danger" onclick = "removePhoto('{{action("Web\ProductphotoController@destroy" , $photo)}}')"
                                   data-id="{{$photo->id}}">
                                    <i class="fa fa-times"></i> حذف </a>
                                @endpermission
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="bold text-center">عکسی درج نشده است</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>