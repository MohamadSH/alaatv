@permission((config('constants.LIST_USER_ACCESS')))

@foreach( $items as $item)
    <tr>

        <th></th>
        <td id = "userFullName_{{$item->id}}">
            @if(isset($item->lastName[0]))
                {{$item->lastName}}
            @else
                <span class = "m-badge m-badge--danger m-badge--wide">نامشخص</span>
            @endif
        </td>
        <td>
            @if(isset($item->firstName[0]))
                {{$item->firstName}}
            @else
                <span class = "m-badge m-badge--danger m-badge--wide">نامشخص</span>
            @endif
        </td>
        <td>
            @if(isset($item->major->id))
                {{ $item->major->name }}
            @else
            @endif
        </td>
        {{--<td>--}}
        {{--<div class="mt-element-overlay">--}}
        {{--<div class="mt-overlay-1">--}}
        {{--<img alt="عکس پروفایل" class="timeline-badge-userpic" style="width: 60px ;height: 60px" src="{{ $user->photo }}" />--}}
        {{--<div class="mt-overlay">--}}
        {{--<ul class="mt-info">--}}
        {{--<li>--}}
        {{--<a class="btn default btn-outline" data-toggle="modal" href="#profilePhoto-{{$item->id}}">--}}
        {{--<i class="icon-magnifier"></i>--}}
        {{--</a>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<a target="_blank" class="btn default btn-outline" href="{{action("Web\HomeController@download" , ["content"=>"عکس پروفایل","fileName"=>$item->photo ])}}">--}}
        {{--<i class="icon-link"></i>--}}
        {{--</a>--}}
        {{--</li>--}}
        {{--</ul>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<!-- Photo Modal -->--}}
        {{--<div id="profilePhoto-{{$item->id}}" class="modal fade" tabindex="-1" data-width="760">--}}
        {{--<div class="modal-header">--}}
        {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>--}}
        {{--<h4 class="modal-title">نمایش عکس پروفایل</h4>--}}
        {{--</div>--}}
        {{--<div class="modal-body">--}}
        {{--<div class="row" style="text-align: center;">--}}
        {{--<img alt="عکس پروفایل"  style="width: 80%"  src="{{ $item->photo }}"/>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="modal-footer">--}}
        {{--<button type="button" data-dismiss="modal" class="btn btn-outline dark">بستن</button>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</td>--}}
        <td>
            @if(isset($item->nationalCode) && strlen($item->nationalCode)>0)
                {{ $item->nationalCode }}
            @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>
        @permission((config('constants.SHOW_USER_MOBILE')))
        <td>
            @if(isset($item->mobile) && strlen($item->mobile)>0)
                {{ ltrim($item->mobile, '0')}}
            @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>
        @endpermission @permission((config('constants.SHOW_USER_EMAIL')))
        <td>
            @if(isset($item->email) && strlen($item->email)>0)
                {{ $item->email }}
            @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>
        @endpermission
        <td>
            @if(isset($item->city) && strlen($item->city)>0)
                {{ $item->city }}
            @else
                <span class = "m-badge m-badge--warning m-badge--wide">درج نشده</span>
            @endif
        </td>
        <td>
            @if(isset($item->province) && strlen($item->province)>0)
                {{ $item->province }}
            @else
                <span class = "m-badge m-badge--warning m-badge--wide">درج نشده</span>
            @endif
        </td>
        <td>
            @if($item->hasVerifiedMobile())
                <span class = "m-badge m-badge--success m-badge--wide">احراز هویت کرده</span>
            @else
                <span class = "m-badge m-badge--danger m-badge--wide">نامعتبر</span>
            @endif
        </td>
        <td>
            @if(isset($item->postalCode) && strlen($item->postalCode)>0)
                {{ $item->postalCode }}
            @else
                <span class = "m-badge m-badge--warning m-badge--wide">درج نشده</span>
            @endif
        </td>
        <td>
            @if(isset($item->address) && strlen($item->address)>0)
                {{ $item->address }}
            @else
                <span class = "m-badge m-badge--warning m-badge--wide">درج نشده</span>
            @endif
        </td>
        {{--<td>@if(isset($item->major->id)) @if(strlen($item->major->name)>0) {{ $item->major->name }} @else {{ $item->major->id }} @endif @else <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>--}}
        <td>
            @if(isset($item->school) && strlen($item->school)>0)
                {{ $item->school }}
            @else
                <span class = "m-badge m-badge--warning m-badge--wide">درج نشده</span>
            @endif
        </td>
        <td>
            <span class = "m-badge @if(strcmp($item->userstatus->name , "active")==0) m-badge--success @elseif(strcmp($item->userstatus->name , "inactive")==0) m-badge--warning @endif m-badge--wide">
                {{ $item->userstatus->displayName }}
            </span>
        </td>
        <td>
            @if(isset($item->created_at) && strlen($item->created_at)>0)
                {{ $item->CreatedAt_Jalali() }}
            @else
                <span class = "m-badge m-badge--danger m-badge--wide">درج نشده</span>
            @endif
        </td>
        <td>
            @if(isset($item->updated_at) && strlen($item->updated_at)>0)
                {{ $item->UpdatedAt_Jalali() }}
            @else
                <span class = "m-badge m-badge--danger m-badge--wide">درج نشده</span>
            @endif
        </td>
        <td>
            @if($item->roles->isEmpty())
                <span class = "m-badge m-badge--info m-badge--wide">ندارد</span>
            @else
                <br>
                @foreach($item->roles as $role)
                    {{ $role->display_name }}
                    <br>
                @endforeach
            @endif
        </td>
        <td>
            {{$item->userHasBon(config("constants.BON1"))}}
        </td>

        <td>
            <div class = "btn-group">
                <button class = "btn btn-xs dropdown-toggle" type = "button" data-toggle = "dropdown" aria-expanded = "false"> عملیات</button>
                <ul class = "dropdown-menu" role = "menu" id = "{{$item->id}}">
                    @permission((config('constants.SHOW_USER_ACCESS')))
                    <li>
                        <a target = "_blank" href = "{{route('user.edit' , $item)}}">
                            <i class = "fa fa-pencil"></i>
                            اصلاح
                        </a>
                    </li>
                    @endpermission
                    @role((config("constants.ROLE_ADMIN")))
                    <li>
                        <a target = "_blank" href = "{{route('web.admin.cacheclear' , ['user'=>1 , 'id'=>$item->id])}}">
                            <i class = "fa fa-battery-empty"></i>
                            خالی کردن کش کاربر
                        </a>
                    </li>
                    @endrole
                    {{--@permission((config('constants.REMOVE_USER_ACCESS')))--}}
                    <li>
                        <a class = "deleteUser" data-target = "#deleteUserConfirmationModal" data-toggle = "modal">
                            <i class = "fa fa-remove" aria-hidden = "true"></i>
                            حذف
                        </a>
                    </li>
                    {{--@endpermission--}}
                    {{--@permission((config('constants.INSERT_USER_BON_ACCESS')))--}}
                    <li>
                        <a class = "addBon" data-target = "#addBonModal" data-toggle = "modal">
                            <i class = "fa fa-plus" aria-hidden = "true"></i>
                            تخصیص بن
                        </a>
                    </li>
                    {{--@endpermission--}}
                    {{--@permission((config('constants.SEND_SMS_TO_USER_ACCESS')))--}}
                    <li>
                        <a class = "sendSms" data-target = "#smsModal" data-toggle = "modal">
                            <i class = "fa fa-envelope" aria-hidden = "true"></i>
                            ارسال پیامک
                        </a>
                    </li>
                    {{--@endpermission--}}
                    {{--@permission((config('constants.SEND_SMS_TO_USER_ACCESS')))--}}
                    <li>
                        <a href = "{{action("Web\ContactController@index", ["user" => $item])}}">
                            <i class = "fa fa-address-book"></i>
                            دفترچه تلفن
                        </a>
                    </li>
                    {{--@endpermission--}}
                </ul>
                <div id = "ajax-modal" class = "modal fade" tabindex = "-1"></div>
            </div>
        </td>


    </tr>
@endforeach
@endpermission
