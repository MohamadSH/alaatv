@permission((Config::get('constants.LIST_USER_BON_ACCESS')))
@foreach($userbons as $userbon)
    <tr id="{{$userbon->id}}">
        <th></th>
        <td id="userBonFullName_{{$userbon->id}}">@if(strlen($userbon->user->reverse_full_name) > 0) <a
                    target="_blank" href = "{{action("Web\UserController@edit" , $userbon->user)}}">{{$userbon->user->reverse_full_name}}</a> @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif </td>
        <td>@if(isset($userbon->totalNumber) && strlen($userbon->totalNumber)>0 ) {{ $userbon->totalNumber }}  @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        <td>@if(isset($userbon->userbonstatus)) @if($userbon->userbonstatus->id == Config::get("constants.USERBON_STATUS_ACTIVE"))
                <span class="m-badge m-badge--wide label-sm m-badge--info">استفاده نکرده</span> @elseif($userbon->userbonstatus->id == Config::get("constants.USERBON_STATUS_EXPIRED"))
                <span class="m-badge m-badge--wide label-sm m-badge--danger">{{$userbon->userbonstatus->displayName}}</span> @elseif($userbon->userbonstatus->id == Config::get("constants.USERBON_STATUS_USED"))
                <span class="m-badge m-badge--wide label-sm m-badge--success">{{$userbon->userbonstatus->displayName}}</span> @endif @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        <td>@if(isset($userbon->orderproduct)) {{$userbon->orderproduct->product->name}} @else <span
                    class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        <td>@if(isset($userbon->created_at) && strlen($userbon->created_at)>0) {{ $userbon->CreatedAt_Jalali() }} @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        <td>
            <div class="btn-group">
                <button class="btn btn-xs black dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> عملیات</button>
                <ul class="dropdown-menu" role="menu" id="{{$userbon->id}}">
                    {{--@userbon((Config::get('constants.SHOW_userbon_ACCESS')))--}}
                    {{--<li>--}}
                    {{--<a href="{{action("Web\userbonController@edit" , $userbon)}}">--}}
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
