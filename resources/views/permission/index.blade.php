@permission((Config::get('constants.LIST_PERMISSION_ACCESS')))
@foreach($permissions as $permission)
    <tr>
        <th></th>
        <td>@if(isset($permission->name) && strlen($permission->name)>0 ) {{ $permission->name }}  @else <span
                    class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($permission->display_name) && strlen($permission->display_name)>0 ) {{ $permission->display_name }}  @else
                <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($permission->description) && strlen($permission->description)>0 ) {{ $permission->description }}  @else
                <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($permission->created_at) && strlen($permission->created_at)>0) {{ $permission->CreatedAt_Jalali() }} @else
                <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($permission->updated_at) && strlen($permission->updated_at)>0) {{ $permission->UpdatedAt_Jalali() }} @else
                <span class="label label-sm label-danger"> درج نشده </span> @endif</td>

        <td>
            <div class="btn-group">
                <button class="btn btn-xs black dropdown-toggle" type="button" data-toggle="dropdown"
                        aria-expanded="false"> عملیات
                    <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu" role="menu">
                    @permission((Config::get('constants.SHOW_PERMISSION_ACCESS')))
                    <li>
                        <a href = "{{action("Web\PermissionController@edit" , $permission)}}">
                            <i class="fa fa-pencil"></i> اصلاح </a>
                    </li>
                    @endpermission
                    @permission((Config::get('constants.REMOVE_PERMISSION_ACCESS')))
                    <li>
                        <a data-target="#static-{{$permission->id}}" data-toggle="modal">
                            <i class="fa fa-remove"></i> حذف </a>
                    </li>
                    @endpermission
                </ul>
                <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
                <!-- static -->
                @permission((Config::get('constants.REMOVE_PERMISSION_ACCESS')))
                <div id="static-{{$permission->id}}" class="modal fade" tabindex="-1" data-backdrop="static"
                     data-keyboard="false">
                    <div class="modal-body">
                        <p> آیا مطمئن هستید؟ </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-outline dark">خیر</button>
                        <button type="button" data-dismiss="modal" class="btn green" onclick = "removePermission('{{action("Web\PermissionController@destroy" , $permission)}}');">
                            بله
                        </button>
                    </div>
                </div>
                @endpermission
            </div>
    </tr>
@endforeach
@endpermission
