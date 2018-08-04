@if(isset($isSharifRegisterEvent) && $isSharifRegisterEvent)
    @foreach($eventresults as $eventresult)
        <tr >
            <th></th>
            <td>@if(isset($eventresult->user_id))
                    @if(strlen($eventresult->user->lastName) > 0)
                        <a target="_blank" href="{{action("UserController@edit" , $eventresult->user)}}">{{$eventresult->user->lastName}}</a>
                    @else
                        <span class="label label-sm label-danger"> کاربر ناشناس </span>
                    @endif
                @endif
            </td>
            <td>
                @if(isset($eventresult->user_id))
                    @if(strlen($eventresult->user->firstName) > 0)
                        {{$eventresult->user->firstName}}
                    @else
                        <span class="label label-sm label-danger"> کاربر ناشناس </span>
                    @endif
                @endif
            </td>
            <td>
                @if(isset($eventresult->user->province) && strlen($eventresult->user->province)>0)
                    {{$eventresult->user->province}}
                @else
                    <span class="label label-sm label-warning"> درج نشده </span>
                @endif
            </td>
            <td>
                @if(isset($eventresult->user->city) && strlen($eventresult->user->city)>0)
                    {{$eventresult->user->city}}
                @else
                    <span class="label label-sm label-warning"> درج نشده </span>
                @endif
            </td>
            <td>@if(isset($eventresult->user_id) && isset($eventresult->user->mobile))  {{$eventresult->user->mobile}} @else <span class="label label-sm label-danger">درج نشده </span> @endif</td>
            <td>@if(isset($eventresult->user_id) && isset($eventresult->user->major_id)) {{$eventresult->user->major->name}} @else <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
            <td>@if(isset($eventresult->user_id) && isset($eventresult->user->grade_id)) {{$eventresult->user->grade->displayName}} @else <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
            <td>@if(isset($eventresult->participationCodeHash) && strlen($eventresult->participationCodeHash)>0) {{$eventresult->participationCodeHash}} @else <span class="label label-sm label-danger">بدون معدل </span> @endif</td>
            <td>
                @if(isset($eventresult->created_at))
                    {{$eventresult->CreatedAt_Jalali()}}
                @else
                    <span class="label label-sm label-danger">درج نشده </span>
                @endif
            </td>
        </tr>
    @endforeach
@else
    @foreach($eventresults as $eventresult)
        <tr >
            <th></th>
            <td>@if(isset($eventresult->user->id))
                    @if(strlen($eventresult->user->getFullName("lastNameFirst")) > 0) <a target="_blank" href="{{action("UserController@edit" , $eventresult->user)}}">{{$eventresult->user->getFullName()}}</a> @else <span class="label label-sm label-danger"> کاربر ناشناس </span>@endif
                @endif
            </td>
            <td>@if(isset($eventresult->user->mobile))  {{$eventresult->user->mobile}} @else <span class="label label-sm label-danger">درج نشده </span> @endif</td>
            <td>@if(isset($eventresult->user->city) && strlen($eventresult->user->city)>0) {{$eventresult->user->city}} @else <span class="label label-sm label-warning"> درج نشده </span> @endif </td>
            <td>@if(isset($eventresult->reportFile[0])) <a target="_blank" href="{{action("HomeController@download" , ["content"=>"فایل کارنامه","fileName"=>$eventresult->reportFile ])}}" class="btn btn-icon-only green"><i class="fa fa-download"></i></a> @else <span class="label label-sm label-warning"> درج نشده </span> @endif </td>
            <td>@if(isset($eventresult->rank)) {{$eventresult->rank}} @else <span class="label label-sm label-danger">درج نشده </span> @endif</td>
            <td>@if(isset($eventresult->eventresultstatus_id)) {{$eventresult->eventresultstatus}} @else <span class="label label-sm label-warning">نامشخص </span> @endif</td>
            <td>@if(isset($eventresult->comment) && strlen($eventresult->comment)>0) {{$eventresult->comment}} @else <span class="label label-sm label-info">بدون نظر </span> @endif</td>
            <td>
                @if(isset($eventresult->created_at))
                    {{$eventresult->CreatedAt_Jalali()}}
                @else
                    <span class="label label-sm label-danger">درج نشده </span>
                @endif
            </td>
        </tr>
    @endforeach
@endif

