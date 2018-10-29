@foreach( $employeeTimeSheets as $employeeTimeSheet)
    <tr>
        <th></th>
        @permission((Config::get('constants.LIST_EMPLOPYEE_WORK_SHEET')))
        <td>@if(isset($employeeTimeSheet->user_id)) {{$employeeTimeSheet->getEmployeeFullName()}} @else  درج
            نشده  @endif</td>
        @endpermission
        <td>@if(isset($employeeTimeSheet->date)) {{ $employeeTimeSheet->date }} @else  درج نشده  @endif</td>
        <td>@if(isset($employeeTimeSheet->date)) {{ $employeeTimeSheet->getDate("WEEK_DAY") }} @else  درج
            نشده  @endif</td>
        @permission((Config::get('constants.LIST_EMPLOPYEE_WORK_SHEET')))
        <td>
            <div class="btn-group">
                <button class="btn btn-xs black dropdown-toggle" type="button" data-toggle="dropdown"
                        aria-expanded="false"> عملیات
                    <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu" role="menu" id="{{$employeeTimeSheet->id}}">
                    @permission((Config::get('constants.EDIT_EMPLOPYEE_WORK_SHEET')))
                    <li>
                        <a target="_blank" href="{{action("EmployeetimesheetController@edit" , $employeeTimeSheet)}}">
                            <i class="fa fa-pencil"></i> اصلاح </a>
                    </li>
                    @endpermission
                    @permission((Config::get('constants.REMOVE_EMPLOPYEE_WORK_SHEET')))
                    <li>
                        <a class="deleteEmplpyeetimesheet" data-target="#deleteEmployeetimesheetConfirmationModal"
                           data-toggle="modal" data-id="{{$employeeTimeSheet->id}}">
                            <i class="fa fa-remove" aria-hidden="true"></i> حذف </a>
                    </li>
                    @endpermission
                </ul>
                <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
            </div>
        </td>
        @endpermission
        <td>@if($employeeTimeSheet->obtainShiftTime()) {{ $employeeTimeSheet->obtainShiftTime() }} @else  _  @endif</td>
        <td>@if($employeeTimeSheet->obtainRealWorkTime("HOUR_FORMAT")) {{ $employeeTimeSheet->obtainRealWorkTime("HOUR_FORMAT") }} @else
                _  @endif</td>
        <td>@if($employeeTimeSheet->obtainLunchTime()) {{ $employeeTimeSheet->obtainLunchTime() }} @else  _  @endif</td>
        <td>@if($employeeTimeSheet->obtainTotalBreakTime()) {{ $employeeTimeSheet->obtainTotalBreakTime() }} @else
                _ @endif</td>
        <td dir="ltr">@if($employeeTimeSheet->obtainWorkAndShiftDiff()) {{ $employeeTimeSheet->obtainWorkAndShiftDiff("HOUR_FORMAT") }} @else
                _ @endif</td>
        <td>{{ $employeeTimeSheet->userBeginTime }}</td>
        <td>{{ $employeeTimeSheet->userFinishTime }}</td>
        <td>{{ $employeeTimeSheet->clockIn }}</td>
        <td>{{ $employeeTimeSheet->beginLunchBreak }}</td>
        <td>{{ $employeeTimeSheet->finishLunchBreak }}</td>
        <td>{{ $employeeTimeSheet->clockOut }}</td>
        <td>{{ $employeeTimeSheet->breakDurationInSeconds }} </td>
        <td>@if(isset($employeeTimeSheet->timeSheetLock)) {{ $employeeTimeSheet->timeSheetLock }} @else <span
                    class="label label-sm label-danger"> درج نشده </span> @endif</td>
        @permission((Config::get('constants.LIST_EMPLOPYEE_WORK_SHEET')))
        <td>@if(isset($employeeTimeSheet->isPaid)) {{ $employeeTimeSheet->isPaid }} @else <span
                    class="label label-sm label-danger"> درج نشده </span> @endif</td>
        @endpermission
        <td>@if(isset($employeeTimeSheet->workdaytype_id)) {{ $employeeTimeSheet->workdaytype->displayName }} @else
                <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($employeeTimeSheet->employeeComment[0])) {!!   $employeeTimeSheet->employeeComment !!} @else <span
                    class="label label-sm label-info"> ندارد </span> @endif</td>
        <td>@if(isset($employeeTimeSheet->managerComment[0])) {!! $employeeTimeSheet->managerComment !!} @else <span
                    class="label label-sm label-info"> ندارد </span> @endif</td>
        @permission((Config::get('constants.LIST_EMPLOPYEE_WORK_SHEET')))
        <td>@if(isset($employeeTimeSheet->updated_at)) {{ $employeeTimeSheet->updated_at }} @else <span
                    class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($employeeTimeSheet->modifier_id)) {{ $employeeTimeSheet->getModifierFullName() }} @else <span
                    class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($employeeTimeSheet->created_at)) {{ $employeeTimeSheet->created_at }} @else <span
                    class="label label-sm label-danger"> درج نشده </span> @endif</td>
        @endpermission
    </tr>
@endforeach