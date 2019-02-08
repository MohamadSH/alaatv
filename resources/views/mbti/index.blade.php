@permission((Config::get('constants.LIST_MBTIANSWER_ACCESS')))
@foreach($mbtiAnswers as $mbtiAnswer)
    <tr>
        <th></th>
        <td>@if(isset($mbtiAnswer->user->id)) @if(isset($mbtiAnswer->user->firstName) && strlen($mbtiAnswer->user->firstName)>0 || isset($mbtiAnswer->user->lastName) && strlen($mbtiAnswer->user->lastName)>0) @if(isset($mbtiAnswer->user->firstName) && strlen($mbtiAnswer->user->firstName)>0) {{ $mbtiAnswer->user->firstName}} @endif @if(isset($mbtiAnswer->user->lastName) && strlen($mbtiAnswer->user->lastName)>0) {{$mbtiAnswer->user->lastName}} @endif @else
                <span class="label label-sm label-danger"> کاربر ناشناس </span> @endif @endif</td>
        <td>@if(isset($mbtiAnswer->user->mobile))  {{$mbtiAnswer->user->mobile}} @else <span
                    class="label label-sm label-danger">درج نشده </span> @endif</td>
        <td>@if(isset($mbtiAnswer->user->city) && strlen($mbtiAnswer->user->city)>0) {{$mbtiAnswer->user->city}} @else
                <span class="label label-sm label-warning"> درج نشده </span> @endif </td>
        <td>@if(strlen($mbtiAnswer->getUserOrderInfo("productName"))>0) {{$mbtiAnswer->getUserOrderInfo("productName")}} @else
                <span class="label label-sm label-danger">درج نشده </span> @endif</td>
        <td>@if(strlen($mbtiAnswer->getUserOrderInfo("orderStatus"))>0)  <span
                    class="label label-sm label-success"> {{$mbtiAnswer->getUserOrderInfo("orderStatus")}} </span> @else
                <span class="label label-sm label-danger">درج نشده </span> @endif</td>
        <td>
            <div class="btn-group">
                <button class="btn btn-xs black dropdown-toggle" type="button" data-toggle="dropdown"
                        aria-expanded="false"> عملیات
                    <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a target="_blank" href = "{{action("Web\MbtianswerController@create" , ["action"=>"correctExam","user_id"=>$mbtiAnswer->user->id])}}">مشاهده
                                                                                                                                                               پاسخنامه</a>
                    </li>
                </ul>
            </div>
        </td>
        <td>
            {{$mbtiAnswer->CreatedAt_Jalali()}}
        </td>
    </tr>
@endforeach
@endpermission

