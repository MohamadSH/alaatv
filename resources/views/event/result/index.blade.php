@if(isset($isSharifRegisterEvent) && $isSharifRegisterEvent)
    @foreach($eventresults as $eventresult)
        <tr>
            <th></th>
            <td>@if(isset($eventresult->user_id))
                    @if(strlen($eventresult->user->lastName) > 0)
                        <a target = "_blank" href = "{{action("Web\UserController@edit" , $eventresult->user)}}">{{$eventresult->user->lastName}}</a>
                    @else
                        <span class = "m-badge m-badge--wide label-sm m-badge--danger"> کاربر ناشناس </span>
                    @endif
                @endif
            </td>
            <td>
                @if(isset($eventresult->user_id))
                    @if(strlen($eventresult->user->firstName) > 0)
                        {{$eventresult->user->firstName}}
                    @else
                        <span class = "m-badge m-badge--wide label-sm m-badge--danger"> کاربر ناشناس </span>
                    @endif
                @endif
            </td>
            <td>
                @if(isset($eventresult->user->province) && strlen($eventresult->user->province)>0)
                    {{$eventresult->user->province}}
                @else
                    <span class = "m-badge m-badge--wide label-sm m-badge--warning"> درج نشده </span>
                @endif
            </td>
            <td>
                @if(isset($eventresult->user->city) && strlen($eventresult->user->city)>0)
                    {{$eventresult->user->city}}
                @else
                    <span class = "m-badge m-badge--wide label-sm m-badge--warning"> درج نشده </span>
                @endif
            </td>
            <td>@if(isset($eventresult->user_id) && isset($eventresult->user->mobile))  {{$eventresult->user->mobile}} @else
                    <span class = "m-badge m-badge--wide label-sm m-badge--danger">درج نشده </span> @endif</td>
            <td>@if(isset($eventresult->user_id) && isset($eventresult->user->major_id)) {{$eventresult->user->major->name}} @else
                    <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif </td>
            <td>@if(isset($eventresult->user_id) && isset($eventresult->user->grade_id)) {{$eventresult->user->grade->displayName}} @else
                    <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif </td>
            <td>@if(isset($eventresult->participationCodeHash) && strlen($eventresult->participationCodeHash)>0) {{$eventresult->participationCodeHash}} @else
                    <span class = "m-badge m-badge--wide label-sm m-badge--danger">بدون معدل </span> @endif</td>
            <td>
                @if(isset($eventresult->created_at))
                    {{$eventresult->CreatedAt_Jalali()}}
                @else
                    <span class = "m-badge m-badge--wide label-sm m-badge--danger">درج نشده </span>
                @endif
            </td>
        </tr>
    @endforeach
@else
    @foreach($eventresults as $eventresult)
        <tr>
            <th></th>
            <td>@if(isset($eventresult->user->id))
                    @if(strlen($eventresult->user->reverse_full_name) > 0)
                        <a target = "_blank" href = "{{action("Web\UserController@edit" , $eventresult->user)}}">{{$eventresult->user->full_name}}</a> @else
                        <span class = "m-badge m-badge--wide label-sm m-badge--danger"> کاربر ناشناس </span>@endif
                @endif
            </td>
            <td>@if(isset($eventresult->user->mobile))  {{$eventresult->user->mobile}} @else
                    <span class = "m-badge m-badge--wide label-sm m-badge--danger">درج نشده </span> @endif</td>
            <td>@if(isset($eventresult->user->city) && strlen($eventresult->user->city)>0) {{$eventresult->user->city}} @else
                    <span class = "m-badge m-badge--wide label-sm m-badge--warning"> درج نشده </span> @endif </td>
            <td>@if(isset($eventresult->reportFile[0]))
                    <a target = "_blank" href = "{{action("Web\HomeController@download" , ["content"=>"فایل کارنامه","fileName"=>$eventresult->reportFile ])}}" class = "btn btn-icon-only green">
                        <i class = "fa fa-download"></i>
                    </a> @else
                    <span class = "m-badge m-badge--wide label-sm m-badge--warning"> درج نشده </span> @endif </td>
            <td>@if(isset($eventresult->rank)) {{$eventresult->rank}} @else
                    <span class = "m-badge m-badge--wide label-sm m-badge--danger">درج نشده </span> @endif
            </td>
            <td>@if(isset($eventresult->enableReportPublish)) {{($eventresult->enableReportPublish)?'بله':'خیر'}} @else
                    <span class = "m-badge m-badge--wide label-sm m-badge--danger">درج نشده </span> @endif
            </td>
            <td style = "width: 20%">
                {!! Form::model($eventresult, ['method' => 'PUT', 'action' => ['Web\EventresultController@update', $eventresult] , 'id' => 'eventResultForm_'.$eventresult->id]) !!}
                <div class = "input-group">
                    <div class = "input-icon">
                        {!! Form::select('eventresultstatus_id', $eventResultStatuses, null, ['class' => 'form-control']) !!}
                    </div>
                    <span class = "input-group-btn">
                        <button type = "submit" class = "btn grey-mint eventResultUpdate" data-role = "{{$eventresult->id}}">تأیید</button>
                    </span>
                </div>
                {!! Form::close() !!}
            </td>
            <td>@if(isset($eventresult->comment) && strlen($eventresult->comment)>0) {{$eventresult->comment}} @else
                    <span class = "m-badge m-badge--wide label-sm m-badge--info">بدون نظر </span> @endif</td>
            <td>
                @if(isset($eventresult->created_at))
                    {{$eventresult->CreatedAt_Jalali()}}
                @else
                    <span class = "m-badge m-badge--wide label-sm m-badge--danger">درج نشده </span>
                @endif
            </td>
        </tr>
    @endforeach
@endif

