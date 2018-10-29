@role((Config::get("constants.ROLE_ADMIN")))
@foreach($roles as $role)
    <tr>
        <th></th>
        <td>@if(isset($role->name) && strlen($role->name)>0 ) {{ $role->name }}  @else <span
                    class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($role->display_name) && strlen($role->display_name)>0 ) {{ $role->display_name }}  @else <span
                    class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($role->description) && strlen($role->description)>0 ) {{ $role->description }}  @else <span
                    class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($role->created_at) && strlen($role->created_at)>0) {{ $role->CreatedAt_Jalali() }} @else <span
                    class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($role->updated_at) && strlen($role->updated_at)>0) {{ $role->UpdatedAt_Jalali() }} @else <span
                    class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>
            @if(sizeof($role->permissions) == 0)
                <span class="label label-sm label-danger"> درج نشده </span>
            @else
                @foreach($role->permissions as $permission)
                    <br>
                    <small>{{$permission->display_name}}</small>
                @endforeach
            @endif
        </td>
        <td>
            @if(!$role->isDefault)
                <div class="btn-group">
                    <button class="btn btn-xs black dropdown-toggle" type="button" data-toggle="dropdown"
                            aria-expanded="false"> عملیات
                        <i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        @role((Config::get("constants.ROLE_ADMIN")))
                        <li>
                            <a href="{{action("RoleController@edit" , $role)}}">
                                <i class="fa fa-pencil"></i> اصلاح </a>
                        </li>

                        <li>
                            <a data-target="#static-{{$role->id}}" data-toggle="modal">
                                <i class="fa fa-remove"></i> حذف </a>
                        </li>

                        @endrole
                    </ul>
                    <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
                    <!-- static -->
                    <div id="static-{{$role->id}}" class="modal fade" tabindex="-1" data-backdrop="static"
                         data-keyboard="false">
                        <div class="modal-body">
                            <p> آیا مطمئن هستید؟ </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-outline dark">خیر</button>
                            <button type="button" data-dismiss="modal" class="btn green"
                                    onclick="removeRole('{{action("RoleController@destroy" , $role)}}');">بله
                            </button>
                        </div>
                    </div>
                </div>
            @else
                ندارد
            @endif
        </td>
        @endforeach
        @endrole