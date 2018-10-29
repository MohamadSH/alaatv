@permission((Config::get('constants.LIST_USER_ACCESS')))

@foreach( $users as $user)
    <tr>
        <th></th>
        <td id="userFullName_{{$user->id}}">@if(isset($user->lastName[0])) {{$user->lastName}} @else <span class="label label-sm label-danger">نامشخص </span> @endif</td>
        <td>@if(isset($user->firstName[0])) {{$user->firstName}} @else <span class="label label-sm label-danger">نامشخص </span> @endif</td>
        <td>@if(isset($user->major->id)) {{ $user->major->name }} @else  @endif</td>
        {{--<td>--}}
                        {{--<div class="mt-element-overlay">--}}
                                    {{--<div class="mt-overlay-1">--}}
                                        {{--<img alt="عکس پروفایل" class="timeline-badge-userpic" style="width: 60px ;height: 60px" src="{{ route('image', [ 'category'=>'1','w'=>'60' , 'h'=>'60' , 'filename' =>  $user->photo ]) }}" />--}}
                                            {{--<div class="mt-overlay">--}}
                                                {{--<ul class="mt-info">--}}
                                                    {{--<li>--}}
                                                        {{--<a class="btn default btn-outline" data-toggle="modal" href="#profilePhoto-{{$user->id}}">--}}
                                                            {{--<i class="icon-magnifier"></i>--}}
                                                        {{--</a>--}}
                                                    {{--</li>--}}
                                                    {{--<li>--}}
                                                        {{--<a target="_blank" class="btn default btn-outline" href="{{action("HomeController@download" , ["content"=>"عکس پروفایل","fileName"=>$user->photo ])}}">--}}
                                                            {{--<i class="icon-link"></i>--}}
                                                        {{--</a>--}}
                                                    {{--</li>--}}
                                                {{--</ul>--}}
                                            {{--</div>--}}
                                    {{--</div>--}}
                        {{--</div>--}}
                   {{--<!-- Photo Modal -->--}}
                    {{--<div id="profilePhoto-{{$user->id}}" class="modal fade" tabindex="-1" data-width="760">--}}
                        {{--<div class="modal-header">--}}
                            {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>--}}
                            {{--<h4 class="modal-title">نمایش عکس پروفایل</h4>--}}
                        {{--</div>--}}
                        {{--<div class="modal-body">--}}
                            {{--<div class="row" style="text-align: center;">--}}
                                {{--<img alt="عکس پروفایل"  style="width: 80%"  src="{{ route('image', ['category'=>'1','w'=>'608' , 'h'=>'608' ,  'filename' =>  $user->photo ]) }}"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="modal-footer">--}}
                            {{--<button type="button" data-dismiss="modal" class="btn btn-outline dark">بستن</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
        {{--</td>--}}
        <td>@if(isset($user->nationalCode) && strlen($user->nationalCode)>0) {{ $user->nationalCode }} @else <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        @permission((Config::get('constants.SHOW_USER_MOBILE')))
        <td>@if(isset($user->mobile) && strlen($user->mobile)>0) {{ ltrim($user->mobile, '0')}} @else <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        @endpermission
        @permission((Config::get('constants.SHOW_USER_EMAIL')))
        <td>@if(isset($user->email) && strlen($user->email)>0) {{ $user->email }} @else <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        @endpermission
        <td>@if(isset($user->city) && strlen($user->city)>0) {{ $user->city }} @else <span class="label label-sm label-warning"> درج نشده </span>  @endif</td>
        <td>@if(isset($user->province) && strlen($user->province)>0) {{ $user->province }} @else <span class="label label-sm label-warning"> درج نشده </span> @endif</td>
        <td>@if($user->hasVerifiedMobile()) <span class="label label-sm label-success">احراز هویت کرده</span> @else
                <span class="label label-sm label-danger"> نامعتبر </span> @endif</td>
        <td>@if(isset($user->postalCode) && strlen($user->postalCode)>0) {{ $user->postalCode }} @else <span class="label label-sm label-warning"> درج نشده </span> @endif</td>
        <td>@if(isset($user->address) && strlen($user->address)>0) {{ $user->address }} @else <span class="label label-sm label-warning"> درج نشده </span> @endif</td>
        {{--<td>@if(isset($user->major->id)) @if(strlen($user->major->name)>0) {{ $user->major->name }} @else {{ $user->major->id }} @endif @else <span class="label label-sm label-danger"> درج نشده </span> @endif</td>--}}
        <td>@if(isset($user->school) && strlen($user->school)>0) {{ $user->school }} @else <span class="label label-sm label-warning"> درج نشده </span> @endif</td>
        <td><span class="label label-sm @if(strcmp($user->userstatus->name , "active")==0) label-success @elseif(strcmp($user->userstatus->name , "inactive")==0) label-warning @endif"> {{ $user->userstatus->displayName }} </span></td>
        <td>@if(isset($user->created_at) && strlen($user->created_at)>0) {{ $user->CreatedAt_Jalali() }} @else <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($user->updated_at) && strlen($user->updated_at)>0) {{ $user->UpdatedAt_Jalali() }} @else <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if($user->roles->isEmpty()) <span class="label label-sm label-info"> ندارد </span>
            @else <br>
                @foreach($user->roles as $role)
                    {{ $role->display_name }}
                    <br>
                @endforeach
            @endif
        </td>
        <td>{{$user->userHasBon(Config::get("constants.BON1"))}}</td>
        <td>
            <div class="btn-group">
                <button class="btn btn-xs black dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> عملیات
                    <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu" role="menu" id="{{$user->id}}">
                    @permission((Config::get('constants.SHOW_USER_ACCESS')))
                    <li>
                        <a target="_blank" href="{{action("UserController@edit" , $user)}}">
                            <i class="fa fa-pencil"></i> اصلاح </a>
                    </li>
                    @endpermission
                    @permission((Config::get('constants.REMOVE_USER_ACCESS')))
                    <li>
                        <a class="deleteUser" data-target="#deleteUserConfirmationModal" data-toggle="modal">
                            <i class="fa fa-remove" aria-hidden="true"></i> حذف </a>
                    </li>
                    @endpermission
                    @permission((Config::get('constants.INSERT_ORDER_ACCESS')))
                    <li>
                        <a target="_blank" href="{{action("OrderController@create" , ["customer_id"=>$user->id])}}"><i class="fa fa-plus" aria-hidden="true"></i> درج سفارش </a>
                    </li>
                    @endpermission
                    @permission((Config::get('constants.INSERT_USER_BON_ACCESS')))
                    <li>
                        <a class="addBon"  data-target="#addBonModal"  data-toggle="modal">
                            <i class="fa fa-plus" aria-hidden="true"></i> تخصیص بن </a>
                    </li>
                    @endpermission
                    @permission((Config::get('constants.SEND_SMS_TO_USER_ACCESS')))
                    <li>
                        <a class="sendSms"  data-target="#smsModal"  data-toggle="modal">
                            <i class="fa fa-envelope" aria-hidden="true"></i> ارسال پیامک </a>
                    </li>
                    @endpermission
                    {{--@permission((Config::get('constants.SEND_SMS_TO_USER_ACCESS')))--}}
                    <li>
                        <a href="{{action("ContactController@index", ["user" => $user])}}">
                            <i class="fa fa-address-book"></i> دفترچه تلفن </a>
                    </li>
                    {{--@endpermission--}}
                </ul>
                <div id="ajax-modal" class="modal fade" tabindex="-1"> </div>
            </div>
        </td>
    </tr>
@endforeach
@endpermission