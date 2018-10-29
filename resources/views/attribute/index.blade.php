@permission((Config::get('constants.LIST_ATTRIBUTE_ACCESS')))
@foreach( $attributes as $attribute)
    <tr>
        <th></th>
        <td>@if(isset($attribute->name) && strlen($attribute->name)>0 ) {{ $attribute->name }}  @else <span
                    class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($attribute->displayName) && strlen($attribute->displayName)>0 ) {{ $attribute->displayName }}  @else
                <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($attribute->attributecontrol_id)) {{ $attribute->attributecontrol->name }}  @else <span
                    class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($attribute->description) && strlen($attribute->description)>0 ) {{ $attribute->description }}  @else
                <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($attribute->created_at) && strlen($attribute->created_at)>0) {{ $attribute->CreatedAt_Jalali() }} @else
                <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($attribute->updated_at) && strlen($attribute->updated_at)>0) {{ $attribute->UpdatedAt_Jalali() }} @else
                <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>
            <div class="btn-group">
                <button class="btn btn-xs black dropdown-toggle" type="button" data-toggle="dropdown"
                        aria-expanded="false"> عملیات
                    <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu" role="menu">
                    @permission((Config::get('constants.SHOW_ATTRIBUTE_ACCESS')))
                    <li>
                        <a href="{{action("AttributeController@edit" , $attribute->id)}}">
                            <i class="fa fa-pencil"></i> اصلاح </a>
                    </li>
                    @endpermission
                    @permission((Config::get('constants.REMOVE_ATTRIBUTE_ACCESS')))
                    <li>
                        <a data-target="#static-{{$attribute->id}}" data-toggle="modal">
                            <i class="fa fa-remove"></i> حذف </a>
                    </li>
                    @endpermission
                </ul>
                <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
                <!-- static -->
                @permission((Config::get('constants.REMOVE_ATTRIBUTE_ACCESS')))
                <div id="static-{{$attribute->id}}" class="modal fade" tabindex="-1" data-backdrop="static"
                     data-keyboard="false">
                    <div class="modal-body">
                        <p> آیا مطمئن هستید؟ </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-outline dark">خیر</button>
                        <button type="button" data-dismiss="modal" class="btn green"
                                onclick="removeAttributes('{{action("AttributeController@destroy" , $attribute)}}');">
                            بله
                        </button>
                    </div>
                </div>
                @endpermission
            </div>
        </td>
    </tr>
@endforeach
@endpermission