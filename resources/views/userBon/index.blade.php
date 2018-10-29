@permission((Config::get('constants.LIST_USER_BON_ACCESS')))
@foreach($userbons as $userbon)
    <tr id="{{$userbon->id}}">
        <th></th>
        <td id="userBonFullName_{{$userbon->id}}">@if(strlen($userbon->user->getFullName("lastNameFirst")) > 0) <a
                    target="_blank"
                    href="{{action("UserController@edit" , $userbon->user)}}">{{$userbon->user->getFullName("lastNameFirst")}}</a> @else
                <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
        <td>@if(isset($userbon->totalNumber) && strlen($userbon->totalNumber)>0 ) {{ $userbon->totalNumber }}  @else
                <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($userbon->userbonstatus)) @if($userbon->userbonstatus->id == Config::get("constants.USERBON_STATUS_ACTIVE"))
                <span class="label label-sm label-info">استفاده نکرده</span> @elseif($userbon->userbonstatus->id == Config::get("constants.USERBON_STATUS_EXPIRED"))
                <span class="label label-sm label-danger">{{$userbon->userbonstatus->displayName}}</span> @elseif($userbon->userbonstatus->id == Config::get("constants.USERBON_STATUS_USED"))
                <span class="label label-sm label-success">{{$userbon->userbonstatus->displayName}}</span> @endif @else
                <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($userbon->orderproduct)) {{$userbon->orderproduct->product->name}} @else <span
                    class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($userbon->created_at) && strlen($userbon->created_at)>0) {{ $userbon->CreatedAt_Jalali() }} @else
                <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>
            <div class="btn-group">
                <button class="btn btn-xs black dropdown-toggle" type="button" data-toggle="dropdown"
                        aria-expanded="false"> عملیات
                    <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu" role="menu" id="{{$userbon->id}}">
                    {{--@userbon((Config::get('constants.SHOW_userbon_ACCESS')))--}}
                    {{--<li>--}}
                    {{--<a href="{{action("userbonController@edit" , $userbon)}}">--}}
                    {{--<i class="fa fa-pencil"></i> اصلاح </a>--}}
                    {{--</li>--}}
                    {{--@enduserbon--}}
                    @permission((Config::get('constants.REMOVE_USER_BON_ACCESS')))
                    <li>
                        <a class="deleteUserBon" data-target="#deleteUserBonConfirmationModal" data-toggle="modal">
                            <i class="fa fa-remove"></i> حذف </a>
                    </li>
                    @endpermission
                </ul>
            </div>
    </tr>
@endforeach
@endpermission
