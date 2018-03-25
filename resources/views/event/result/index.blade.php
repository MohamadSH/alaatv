@permission((Config::get('constants.LIST_EVENTRESULT_ACCESS')))
@foreach($eventresults as $eventresult)
    <tr >
        <th></th>
        <td>@if(isset($eventresult->user->id))
                @if(strlen($eventresult->user->getFullName("lastNameFirst")) > 0) <a target="_blank" href="{{action("UserController@edit" , $eventresult->user)}}">{{$eventresult->user->getFullName("lastNameFirst")}}</a> @else <span class="label label-sm label-danger"> کاربر ناشناس </span>@endif
            @endif
        </td>
        <td>@if(isset($eventresult->user->mobile))  {{$eventresult->user->mobile}} @else <span class="label label-sm label-danger">درج نشده </span> @endif</td>
        <td>@if(isset($eventresult->user->city) && strlen($eventresult->user->city)>0) {{$eventresult->user->city}} @else <span class="label label-sm label-warning"> درج نشده </span> @endif </td>
        <td>@if(isset($eventresult->reportFile[0])) <a target="_blank" href="{{action("HomeController@download" , ["content"=>"فایل کارنامه","fileName"=>$eventresult->reportFile ])}}" class="btn btn-icon-only green"><i class="fa fa-download"></i></a> @else <span class="label label-sm label-warning"> درج نشده </span> @endif </td>
        <td>@if(isset($eventresult->rank)) {{$eventresult->rank}} @else <span class="label label-sm label-danger">درج نشده </span> @endif</td>
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
@endpermission

