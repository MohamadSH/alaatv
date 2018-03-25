@permission((Config::get('constants.LIST_ATTRIBUTESET_ACCESS')))
@foreach( $attributesets as $attributeset)
    <tr>
        <th></th>
        <td>@if(isset($attributeset->name) && strlen($attributeset->name)>0 ) {{ $attributeset->name }}  @else <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($attributeset->description) && strlen($attributeset->description)>0 ) {{ $attributeset->description }}  @else <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($attributeset->created_at) && strlen($attributeset->created_at)>0) {{ $attributeset->CreatedAt_Jalali() }} @else <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($attributeset->updated_at) && strlen($attributeset->updated_at)>0) {{ $attributeset->UpdatedAt_Jalali() }} @else <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>
            <div class="btn-group">
                <button class="btn btn-xs black dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> عملیات
                    <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu" role="menu">
                    @permission((Config::get('constants.SHOW_ATTRIBUTESET_ACCESS')))
                    <li>
                        <a href="{{action("AttributesetController@edit" , $attributeset)}}">
                            <i class="fa fa-pencil"></i> اصلاح </a>
                    </li>
                    @endpermission
                    @permission((Config::get('constants.REMOVE_ATTRIBUTESET_ACCESS')))
                    <li>
                        <a data-target="#static-{{$attributeset->id}}" data-toggle="modal">
                            <i class="fa fa-remove"></i> حذف </a>
                    </li>
                    @endpermission
                </ul>
                <div id="ajax-modal" class="modal fade" tabindex="-1"> </div>
                <!-- static -->
                @permission((Config::get('constants.REMOVE_ATTRIBUTESET_ACCESS')))
                <div id="static-{{$attributeset->id}}" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-body">
                        <p> آیا مطمئن هستید؟ </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-outline dark">خیر</button>
                        <button type="button" data-dismiss="modal"  class="btn green" onclick="removeAttributesets('{{action("AttributesetController@destroy" , $attributeset)}}');" >بله</button>
                    </div>
                </div>
                @endpermission
            </div>
        </td>
    </tr>
@endforeach
@endpermission