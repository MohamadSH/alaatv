@role((config("constants.ROLE_ADMIN")))
@foreach($roles as $role)
    <tr>
        <th></th>
        <td>@if(isset($role->name) && strlen($role->name)>0 ) {{ $role->name }}  @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        <td>@if(isset($role->display_name) && strlen($role->display_name)>0 ) {{ $role->display_name }}  @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        <td>@if(isset($role->description) && strlen($role->description)>0 ) {{ $role->description }}  @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        <td>@if(isset($role->created_at) && strlen($role->created_at)>0) {{ $role->CreatedAt_Jalali() }} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        <td>@if(isset($role->updated_at) && strlen($role->updated_at)>0) {{ $role->UpdatedAt_Jalali() }} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        <td>
            @if(sizeof($role->permissions) == 0)
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @else
                @foreach($role->permissions as $permission)
                    <br>
                    <small>{{$permission->display_name}}</small>
                @endforeach
            @endif
        </td>
        <td>
            @if(!$role->isDefault)
                <div class = "btn-group">
                    <button class = "btn btn-xs black dropdown-toggle" type = "button" data-toggle = "dropdown" aria-expanded = "false"> عملیات</button>
                    <ul class = "dropdown-menu" role = "menu">
                        @role((config("constants.ROLE_ADMIN")))
                        <li>
                            <a href = "{{action("Web\RoleController@edit" , $role)}}">
                                <i class = "fa fa-pencil"></i>
                                اصلاح
                            </a>
                        </li>

                        <li>
                            <a data-target = "#static-{{$role->id}}" data-toggle = "modal">
                                <i class = "fa fa-remove"></i>
                                حذف
                            </a>
                        </li>

                        @endrole
                    </ul>
                    <div id = "ajax-modal" class = "modal fade" tabindex = "-1"></div>
                    <!-- static -->

                    <!--begin::Modal-->
                    <div class = "modal fade" id = "static-{{$role->id}}" tabindex = "-1" role = "dialog" aria-hidden = "true">
                        <div class = "modal-dialog" role = "document">
                            <div class = "modal-content">
                                <div class = "modal-body">
                                    <p> آیا مطمئن هستید؟</p>
                                </div>
                                <div class = "modal-footer">
                                    <button type = "button" class = "btn btn-secondary" data-dismiss = "modal">خیر</button>
                                    <button type = "button" class = "btn btn-primary" data-dismiss = "modal" onclick = "removeRole('{{action("Web\RoleController@destroy" , $role)}}');">بله</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->

                </div>
            @else
                ندارد
            @endif
        </td>
        @endforeach
        @endrole