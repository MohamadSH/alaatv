@permission((config('constants.LIST_PRODUCT_ACCESS')))
@foreach($items as $item)
    <tr>
        <th></th>
        <td>
            @if(isset($item->name) && strlen($item->name)>0)
                <a target = "_blank" href = "{{action("Web\ProductController@show" , $item)}}"> {{ $item->name }} </a> @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif </td>
        <td>
            @if(isset($item->basePrice) && strlen($item->basePrice)>0)
                {{ $item->basePrice }}
            @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>
        <td>
            @if(isset($item->discount) ) {{$item->discount}} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif
        </td>
        <td>
            <div class = "mt-element-overlay">
                <div class = "mt-overlay-1">
                    <img alt = "عکس محصول @if(isset($item->name[0])) {{$item->name}} @endif" class = "timeline-badge-userpic" style = "width: 60px ;height: 60px" src = "{{ route('image', ['category'=>'4','w'=>'60' , 'h'=>'60' ,  'filename' =>  $item->image ]) }}"/>
                    <div class = "mt-overlay">
                        <ul class = "mt-info">
                            <li>
                                <a class = "btn default btn-outline" data-toggle = "modal" href = "#profileimage-{{$item->id}}">
                                    <i class = "icon-magnifier"></i>
                                </a>
                            </li>
                            <li>
                                <a target = "_blank" class = "btn default btn-outline" href = "{{action("Web\HomeController@download" , ["content"=>"عکس محصول","fileName"=>$item->image ])}}">
                                    <i class = "icon-link"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- image Modal -->
            <div id = "profileimage-{{$item->id}}" class = "modal fade" tabindex = "-1" data-width = "760">
                <div class = "modal-header">
                    <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true"></button>
                    <h4 class = "modal-title">نمایش عکس محصول</h4>
                </div>
                <div class = "modal-body">
                    <div class = "row" style = "text-align: center;">
                        <img alt = "عکس محصول @if(isset($item->name[0])) {{$item->name}} @endif" style = "width: 80%" src = "{{ route('image', ['category'=>'4','w'=>'608' , 'h'=>'608' ,  'filename' =>  $item->image ]) }}"/>
                    </div>
                </div>
                <div class = "modal-footer">
                    <button type = "button" data-dismiss = "modal" class = "btn btn-outline dark">بستن</button>
                </div>
            </div>
        </td>
        <td style = "text-align: center">
            @if(isset($item->shortDescription) && strlen($item->shortDescription)>0)
                <button class = "btn blue" data-target = "#static-shortDescription-{{$item->id}}" data-toggle = "modal">
                    نمایش
                </button>
            @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
            <div id = "static-shortDescription-{{$item->id}}" class = "modal fade" tabindex = "-1" data-backdrop = "static" data-keyboard = "false">
                <div class = "modal-body" style = "text-align: right">
                    {!! $item->shortDescription !!}
                </div>
                <div class = "modal-footer">
                    <button type = "button" data-dismiss = "modal" class = "btn btn-outline dark">بستن</button>
                </div>
            </div>
        </td>
        <td style = "text-align: center">
            @if(isset($item->longDescription) && strlen($item->longDescription)>0)
                <button class = "btn blue" data-target = "#static-longDescription-{{$item->id}}" data-toggle = "modal">
                    نمایش
                </button> @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif
            <div id = "static-longDescription-{{$item->id}}" class = "modal fade" tabindex = "-1" data-backdrop = "static" data-keyboard = "false">
                <div class = "modal-body" style = "text-align: right">
                    {!! $item->longDescription !!}
                </div>
                <div class = "modal-footer">
                    <button type = "button" data-dismiss = "modal" class = "btn btn-outline dark">بستن</button>
                </div>
            </div>
        </td>
        <td>
            @if(isset($item->producttype->id))
                @if(strlen($item->producttype->name)>0)
                    {{ $item->producttype->displayName }}
                @else
                    {{ $item->producttype->id }}
                @endif
            @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>
        <td>
            @if(isset($item->enable) && $item->enable)
                <span class = "m-badge m-badge--wide label-sm m-badge--success">  فعال </span>
            @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> غیر فعال </span>
            @endif
        </td>
        <td>
            @if(isset($item->amount) ) {{$item->amount}} @else  بدون محدودیت  @endif
        </td>
        <td>
            @if(isset($item->file) && strlen($item->file)>0)
                <a target = "_blank" href = "{{action("Web\HomeController@download" , ["content"=>"کاتالوگ محصول","fileName"=>$item->file ])}}" class = "btn btn-icon-only blue">
                    <i class = "fa fa-download"></i>
                </a>
            @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>
        <td>
            @if(isset($item->slogan) && strlen($item->slogan)>0)
                {!! $item->slogan !!}
            @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>
        <td>
            @if(isset($item->order) && strlen($item->order)>0) {!!   $item->order !!} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif
        </td>
        <td>
            @if(isset($item->attributeset->id))
                @if(strlen($item->attributeset->name)>0)
                    {{ $item->attributeset->name }}
                @else
                    {{ $item->producttype->id }}
                @endif
            @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>
        <td class = "center">@if(isset($item->validSince) && strlen($item->validSince)>0) {{ $item->validSince_Jalali() }} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif </td>
        <td class = "center">@if(isset($item->validUntil) && strlen($item->validUntil)>0) {{ $item->validUntil_Jalali() }} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif </td>
        <td class = "center">@if(isset($item->created_at) && strlen($item->created_at)>0) {{ $item->CreatedAt_Jalali() }}  @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif </td>
        <td class = "center">
            @if(isset($item->updated_at) && strlen($item->updated_at)>0) {{ $item->UpdatedAt_Jalali() }}  @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif </td>
        <td class = "center">
            @if(!$item->bons->isEmpty())
                {{$item->bons->first()->pivot->bonPlus}}
            @else
                <span class = "m-badge m-badge--wide label-sm m-badge--warning"> بدون بن </span>
            @endif
        </td>
        <td class = "center">
            @if(!$item->bons->isEmpty())
                {{$item->bons->first()->pivot->discount}}
            @else
                <span class = "m-badge m-badge--wide label-sm m-badge--warning"> بدون بن </span>
            @endif
        </td>
        <td>
            <div class = "btn-group">
                <button class = "btn btn-xs black dropdown-toggle" type = "button" data-toggle = "dropdown" aria-expanded = "false"> عملیات</button>
                <ul class = "dropdown-menu" role = "menu">
                    @permission((config('constants.SHOW_PRODUCT_ACCESS')))
                    <li>
                        <a target = "_blank" href = "{{action("Web\ProductController@edit" , $item)}}">
                            <i class = "fa fa-pencil"></i>
                            اصلاح
                        </a>
                    </li>
                    @endpermission @permission((config('constants.REMOVE_PRODUCT_ACCESS')))
                    <li>
                        <a data-target = "#static-{{$item->id}}" data-toggle = "modal">
                            <i class = "fa fa-remove"></i>
                            حذف
                        </a>
                    </li>
                    @endpermission @permission((config('constants.COPY_PRODUCT_ACCESS')))
                    <li>
                        <a class = "copyProduct" data-action = "{{action("Web\ProductController@copy" , $item)}}" data-target = "#copyProductModal" data-toggle = "modal">
                            <i class = "fa fa-files-o"></i>
                            کپی از محصول
                        </a>
                    </li>
                    @endpermission

                </ul>
                <div id = "ajax-modal" class = "modal fade" tabindex = "-1"></div>
                <!-- static -->@permission((config('constants.REMOVE_PRODUCT_ACCESS')))


                <!--begin::Modal-->
                <div class = "modal fade" id = "static-{{$item->id}}" tabindex = "-1" role = "dialog" aria-hidden = "true">
                    <div class = "modal-dialog" role = "document">
                        <div class = "modal-content">
                            <div class = "modal-body">
                                <p> آیا مطمئن هستید؟</p>
                            </div>
                            <div class = "modal-footer">
                                <button type = "button" class = "btn btn-secondary" data-dismiss = "modal">خیر</button>
                                <button type = "button" class = "btn btn-primary" data-dismiss = "modal" onclick = "removeProduct('{{action("Web\ProductController@destroy" , $item)}}');">بله</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Modal-->

                @endpermission
            </div>
        </td>
    </tr>
@endforeach
@endpermission
