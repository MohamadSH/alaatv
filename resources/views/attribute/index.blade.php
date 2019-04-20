@permission((config('constants.LIST_ATTRIBUTE_ACCESS')))
@foreach( $attributes as $attribute)
    <tr>
        <th></th>
        <td>@if(isset($attribute->name) && strlen($attribute->name)>0 ) {{ $attribute->name }}  @else <span
                    class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        <td>@if(isset($attribute->displayName) && strlen($attribute->displayName)>0 ) {{ $attribute->displayName }}  @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        <td>@if(isset($attribute->attributecontrol_id)) {{ $attribute->attributecontrol->name }}  @else <span
                    class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        <td>@if(isset($attribute->description) && strlen($attribute->description)>0 ) {{ $attribute->description }}  @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        <td>@if(isset($attribute->created_at) && strlen($attribute->created_at)>0) {{ $attribute->CreatedAt_Jalali() }} @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        <td>@if(isset($attribute->updated_at) && strlen($attribute->updated_at)>0) {{ $attribute->UpdatedAt_Jalali() }} @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        <td>
            <div class="btn-group">
                <button class="btn btn-xs black dropdown-toggle" type="button" data-toggle="dropdown"
                        aria-expanded="false"> عملیات
                    <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu" role="menu">
                    @permission((config('constants.SHOW_ATTRIBUTE_ACCESS')))
                    <li>
                        <a href = "{{action("Web\AttributeController@edit" , $attribute->id)}}">
                            <i class="fa fa-pencil"></i> اصلاح </a>
                    </li>
                    @endpermission
                    @permission((config('constants.REMOVE_ATTRIBUTE_ACCESS')))
                    <li>
                        <a data-target="#static-{{$attribute->id}}" data-toggle="modal">
                            <i class="fa fa-remove"></i> حذف </a>
                    </li>
                    @endpermission
                </ul>
                <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
                <!-- static -->
                @permission((config('constants.REMOVE_ATTRIBUTE_ACCESS')))

                <!--begin::Modal-->
                <div class="modal fade" id="static-{{$attribute->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <p> آیا مطمئن هستید؟ </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">خیر</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="removeAttributes('{{action("Web\AttributeController@destroy" , $attribute)}}');">بله</button>
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