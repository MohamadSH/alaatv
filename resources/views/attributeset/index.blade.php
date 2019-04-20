@permission((config('constants.LIST_ATTRIBUTESET_ACCESS')))
@foreach( $attributesets as $attributeset)
    <tr>
        <th></th>
        <td>@if(isset($attributeset->name) && strlen($attributeset->name)>0 ) {{ $attributeset->name }}  @else <span
                    class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        <td>@if(isset($attributeset->description) && strlen($attributeset->description)>0 ) {{ $attributeset->description }}  @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        <td>@if(isset($attributeset->created_at) && strlen($attributeset->created_at)>0) {{ $attributeset->CreatedAt_Jalali() }} @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        <td>@if(isset($attributeset->updated_at) && strlen($attributeset->updated_at)>0) {{ $attributeset->UpdatedAt_Jalali() }} @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        <td>
            <div class="btn-group">
                <button class="btn btn-xs black dropdown-toggle" type="button" data-toggle="dropdown"
                        aria-expanded="false"> عملیات
                    <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu" role="menu">
                    @permission((config('constants.SHOW_ATTRIBUTESET_ACCESS')))
                    <li>
                        <a href = "{{action("Web\AttributesetController@edit" , $attributeset)}}">
                            <i class="fa fa-pencil"></i> اصلاح </a>
                    </li>
                    @endpermission
                    @permission((config('constants.REMOVE_ATTRIBUTESET_ACCESS')))
                    <li>
                        <a data-target="#static-{{$attributeset->id}}" data-toggle="modal">
                            <i class="fa fa-remove"></i> حذف </a>
                    </li>
                    @endpermission
                </ul>
                <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
                <!-- static -->
                @permission((config('constants.REMOVE_ATTRIBUTESET_ACCESS')))


                <!--begin::Modal-->
                <div class="modal fade" id="static-{{$attributeset->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <p> آیا مطمئن هستید؟ </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">خیر</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="removeAttributesets('{{action("Web\AttributesetController@destroy" , $attributeset)}}');">بله</button>
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