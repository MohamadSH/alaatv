@permission((Config::get('constants.LIST_PRODUCT_ACCESS')))
    @foreach($products as $product)
        <tr >
            <th></th>
            <td>@if(isset($product->name) && strlen($product->name)>0) <a target="_blank" href="{{action("ProductController@show" , $product)}}"> {{ $product->name }} </a> @else <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
            <td>@if(isset($product->basePrice) && strlen($product->basePrice)>0) {{ $product->basePrice }} @else <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
            <td>@if(isset($product->discount) ) {{$product->discount}} @else <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
            <td>
                <div class="mt-element-overlay">
                    <div class="mt-overlay-1">
                        <img  alt="عکس محصول @if(isset($product->name[0])) {{$product->name}} @endif"  class="timeline-badge-userpic" style="width: 60px ;height: 60px" src="{{ route('image', ['category'=>'4','w'=>'60' , 'h'=>'60' ,  'filename' =>  $product->image ]) }}"  />
                            <div class="mt-overlay">
                                <ul class="mt-info">
                                    <li>
                                        <a class="btn default btn-outline" data-toggle="modal" href="#profileimage-{{$product->id}}">
                                            <i class="icon-magnifier"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a target="_blank" class="btn default btn-outline" href="{{action("HomeController@download" , ["content"=>"عکس محصول","fileName"=>$product->image ])}}">
                                            <i class="icon-link"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                    </div>
                </div>
                <!-- image Modal -->
                <div id="profileimage-{{$product->id}}" class="modal fade" tabindex="-1" data-width="760">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">نمایش عکس محصول</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="text-align: center;">
                            <img  alt="عکس محصول @if(isset($product->name[0])) {{$product->name}} @endif"  style="width: 80%" src="{{ route('image', ['category'=>'4','w'=>'608' , 'h'=>'608' ,  'filename' =>  $product->image ]) }}" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-outline dark">بستن</button>
                    </div>
                </div>
            </td>
            <td style="text-align: center">@if(isset($product->shortDescription) && strlen($product->shortDescription)>0) <button class="btn blue" data-target="#static-shortDescription-{{$product->id}}" data-toggle="modal">نمایش </button> @else <span class="label label-sm label-danger"> درج نشده </span> @endif
                <div id="static-shortDescription-{{$product->id}}" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-body" style="text-align: right">
                        {!! $product->shortDescription !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-outline dark">بستن</button>
                    </div>
                </div>
            </td>
            <td style="text-align: center">@if(isset($product->longDescription) && strlen($product->longDescription)>0) <button class="btn blue" data-target="#static-longDescription-{{$product->id}}" data-toggle="modal">نمایش </button> @else <span class="label label-sm label-danger"> درج نشده </span> @endif
                <div id="static-longDescription-{{$product->id}}" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-body" style="text-align: right">
                            {!! $product->longDescription !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-outline dark">بستن</button>
                    </div>
                </div>
            </td>
            <td>@if(isset($product->producttype->id)) @if(strlen($product->producttype->name)>0) {{ $product->producttype->displayName }} @else {{ $product->producttype->id }} @endif @else <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
            <td>@if(isset($product->enable) && $product->enable) <span class="label label-sm label-success">  فعال </span> @else <span class="label label-sm label-danger"> غیر فعال </span> @endif</td>
            <td>@if(isset($product->amount) ) {{$product->amount}} @else  بدون محدودیت  @endif</td>
            <td>@if(isset($product->file) && strlen($product->file)>0)
                <a target="_blank" href="{{action("HomeController@download" , ["content"=>"کاتالوگ محصول","fileName"=>$product->file ])}}" class="btn btn-icon-only blue"><i class="fa fa-download"></i></a>@else <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
            <td>@if(isset($product->slogan) && strlen($product->slogan)>0) {!!   $product->slogan !!} @else <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
            <td>@if(isset($product->order) && strlen($product->order)>0) {!!   $product->order !!} @else <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
            <td>@if(isset($product->attributeset->id)) @if(strlen($product->attributeset->name)>0) {{ $product->attributeset->name }} @else {{ $product->producttype->id }} @endif @else <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
            <td class="center">@if(isset($product->validSince) && strlen($product->validSince)>0) {{ $product->validSince_Jalali() }} @else <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
            <td class="center">@if(isset($product->validUntil) && strlen($product->validUntil)>0) {{ $product->validUntil_Jalali() }} @else <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
            <td class="center">@if(isset($product->created_at) && strlen($product->created_at)>0) {{ $product->CreatedAt_Jalali() }}  @else <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
            <td class="center">@if(isset($product->updated_at) && strlen($product->updated_at)>0) {{ $product->UpdatedAt_Jalali() }}  @else <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
            <td class="center">@if(!$product->bons->isEmpty()) {{$product->bons->first()->pivot->bonPlus}} @else <span class="label label-sm label-warning"> بدون بن </span> @endif </td>
            <td class="center">@if(!$product->bons->isEmpty()) {{$product->bons->first()->pivot->discount}} @else <span class="label label-sm label-warning"> بدون بن </span> @endif </td>
            <td>
                <div class="btn-group">
                    <button class="btn btn-xs black dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> عملیات
                        <i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        @permission((Config::get('constants.SHOW_PRODUCT_ACCESS')))
                        <li>
                            <a target="_blank" href="{{action("ProductController@edit" , $product)}}">
                                <i class="fa fa-pencil"></i> اصلاح </a>
                        </li>
                        @endpermission
                        @permission((Config::get('constants.REMOVE_PRODUCT_ACCESS')))
                        <li>
                            <a data-target="#static-{{$product->id}}" data-toggle="modal">
                                <i class="fa fa-remove"></i> حذف </a>
                        </li>
                        @endpermission
                        @permission((Config::get('constants.COPY_PRODUCT_ACCESS')))
                        <li>
                            <a class="copyProduct" data-action="{{action("ProductController@copy" , $product)}}" data-target="#copyProductModal" data-toggle="modal">
                                <i class="fa fa-files-o"></i> کپی از محصول </a>
                        </li>
                        @endpermission

                    </ul>
                    <div id="ajax-modal" class="modal fade" tabindex="-1"> </div>
                    <!-- static -->
                    @permission((Config::get('constants.REMOVE_PRODUCT_ACCESS')))
                    <div id="static-{{$product->id}}" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                        <div class="modal-header">
                            <h4 class="modal-title">آیا مطمئن هستید؟</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-outline dark">خیر</button>
                            <button type="button" data-dismiss="modal"  class="btn green" onclick="removeProduct('{{action("ProductController@destroy" , $product)}}');" >بله</button>
                        </div>
                    </div>
                    @endpermission
                </div>
            </td>
        </tr>
    @endforeach
@endpermission
