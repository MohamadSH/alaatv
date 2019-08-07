@foreach($usersurveyanswers as $usersurveyanswer)
    <tr>
        <td class = "highlight">
            @if(!isset($usersurveyanswer->first()->user->firstName) && !isset($usersurveyanswer->first()->user->lastName))
                <span class = "m-badge m-badge--wide label-sm m-badge--warning"> کاربر ناشناس </span>@else @if(isset($usersurveyanswer->first()->user->firstName)) {{$usersurveyanswer->first()->user->firstName}} @endif @if(isset($usersurveyanswer->first()->user->lastName)) {{$usersurveyanswer->first()->user->lastName}} @endif  @endif
        </td>
        <td class = "hidden-xs">@if(isset($usersurveyanswer->first()->user->major->id)) {{$usersurveyanswer->first()->user->major->name}} @endif</td>
        <td>
            <a href = "{{action("Web\ConsultationController@consultantEntekhabReshte" , ["user"=>$usersurveyanswer->first()->user])}}" class = "btn btn-outline btn-circle btn-sm purple">
                <i class = "fa fa-pencil"></i>
                رفتن به انتخاب رشته
            </a>
        </td>
    </tr>
@endforeach
