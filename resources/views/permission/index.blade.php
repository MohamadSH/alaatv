@permission((config('constants.LIST_PERMISSION_ACCESS')))
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
                    @permission((config('constants.SHOW_PERMISSION_ACCESS')))
                    <li>
                        <a href = "{{action("Web\PermissionController@edit" , $permission)}}">
                            <i class="fa fa-pencil"></i> اصلاح </a>
                    </li>
                    @endpermission
                    @permission((config('constants.REMOVE_PERMISSION_ACCESS')))
                    <li>
                        <a data-target="#static-{{$permission->id}}" data-toggle="modal">
                            <i class="fa fa-remove"></i> حذف </a>
                    </li>
                    @endpermission
                </ul>
                <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
                <!-- static -->
                @permission((config('constants.REMOVE_PERMISSION_ACCESS')))
                <!--begin::Modal-->
                <div class="modal fade" id="static-{{$permission->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <p> آیا مطمئن هستید؟ </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">خیر</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="removePermission('{{action("Web\PermissionController@destroy" , $permission)}}');">بله</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Modal-->
                @endpermission
            </div>
    </tr>
@endforeach
@endpermission
