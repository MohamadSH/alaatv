@foreach( $employeeTimeSheets as $employeeTimeSheet)
    <tr>
        <th></th>
        @permission((config('constants.LIST_EMPLOPYEE_WORK_SHEET')))
        <td>
            @if(isset($employeeTimeSheet->user_id))
                {{$employeeTimeSheet->getEmployeeFullName()}}
            @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>
        @endpermission
        <td>
            @if(isset($employeeTimeSheet->date))
                {{ $employeeTimeSheet->date }}
            @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>
        <td>
            @if(isset($employeeTimeSheet->date))
                {{ $employeeTimeSheet->getDate("WEEK_DAY") }}
            @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>
        @permission((config('constants.LIST_EMPLOPYEE_WORK_SHEET')))
        <td>
            <div class="dropdown">
                <button class="btn btn-accent dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    عملیات
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start">
                    @permission((config('constants.EDIT_EMPLOPYEE_WORK_SHEET')))
                    <a class="dropdown-item" target="_blank" href="{{action("Web\EmployeetimesheetController@edit" , $employeeTimeSheet)}}">
                        <i class="fa fa-edit"></i>
                        اصلاح
                    </a>
                    @endpermission
                    @permission((config('constants.REMOVE_EMPLOPYEE_WORK_SHEET')))
                    <a class="dropdown-item deleteEmplpyeetimesheet" data-target="#deleteEmployeetimesheetConfirmationModal" data-toggle="modal" data-id="{{$employeeTimeSheet->id}}">
                        <i class="flaticon-delete"></i>
                        حذف
                    </a>
                    @endpermission
                </div>
            </div>
        </td>
        @endpermission
        <td>
            @if($employeeTimeSheet->obtainShiftTime())
                {{ $employeeTimeSheet->obtainShiftTime() }}
            @else
                _
            @endif
        </td>
        <td>
            @if($employeeTimeSheet->obtainRealWorkTime("HOUR_FORMAT"))
                {{ $employeeTimeSheet->obtainRealWorkTime("HOUR_FORMAT") }}
            @else
                _
            @endif
        </td>
        <td>
            @if($employeeTimeSheet->obtainLunchTime())
                {{ $employeeTimeSheet->obtainLunchTime() }}
            @else
                _
            @endif
        </td>
        <td>
            @if($employeeTimeSheet->obtainTotalBreakTime())
                {{ $employeeTimeSheet->obtainTotalBreakTime() }}
            @else
                _
            @endif
        </td>
        <td dir="ltr">
            @if(
                    $employeeTimeSheet->obtain_work_and_shift_diff_in_hour &&
                    $employeeTimeSheet->obtain_work_and_shift_diff_in_hour !='00:00'
                )
                @if(strpos($employeeTimeSheet->obtain_work_and_shift_diff_in_hour,'منفی')!=false)
                    {{ $employeeTimeSheet->obtain_work_and_shift_diff_in_hour }}
                @else
                    {{ $employeeTimeSheet->obtain_work_and_shift_diff_in_hour }}
                    @if($employeeTimeSheet->overtime_status_id==config('constants.EMPLOYEE_OVERTIME_STATUS_CONFIRMED'))
                        <span class="m-badge m-badge--wide label-sm m-badge--success"> اضافه کاری تایید شده </span>
                    @elseif($employeeTimeSheet->overtime_status_id==config('constants.EMPLOYEE_OVERTIME_STATUS_REJECTED'))
                        <span class="m-badge m-badge--wide label-sm m-badge--danger"> اضافه کاری رد شده </span>
                    @elseif($employeeTimeSheet->overtime_status_id==config('constants.EMPLOYEE_OVERTIME_STATUS_UNCONFIRMED'))
                        <span class="m-badge m-badge--wide label-sm m-badge--warning"> اضافه کاری تایید نشده </span>
                    @endif

                @endif
            @else
                _
            @endif
        </td>
        <td>{{ $employeeTimeSheet->userBeginTime }}</td>
        <td>{{ $employeeTimeSheet->userFinishTime }}</td>
        <td>{{ $employeeTimeSheet->clockIn }}</td>
        <td>{{ $employeeTimeSheet->beginLunchBreak }}</td>
        <td>{{ $employeeTimeSheet->finishLunchBreak }}</td>
        <td>{{ $employeeTimeSheet->clockOut }}</td>
        <td>{{ $employeeTimeSheet->breakDurationInSeconds }} </td>
        <td>
            @if(isset($employeeTimeSheet->timeSheetLock))
                {{ $employeeTimeSheet->timeSheetLock }}
            @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>
        @permission((config('constants.LIST_EMPLOPYEE_WORK_SHEET')))
        <td>
            @if(isset($employeeTimeSheet->isPaid))
                {{ $employeeTimeSheet->isPaid }}
            @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>
        @endpermission
        <td>
            @if(isset($employeeTimeSheet->workdaytype_id))
                {{ $employeeTimeSheet->workdaytype->displayName }}
            @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>
        <td>
            @if(isset($employeeTimeSheet->employeeComment[0]))
                {!!   $employeeTimeSheet->employeeComment !!}
            @else
                <span class="m-badge m-badge--wide label-sm m-badge--info"> ندارد </span>
            @endif
        </td>
        <td>
            @if(isset($employeeTimeSheet->managerComment[0]))
                {!! $employeeTimeSheet->managerComment !!}
            @else
                <span class="m-badge m-badge--wide label-sm m-badge--info"> ندارد </span>
            @endif
        </td>
        @permission((config('constants.LIST_EMPLOPYEE_WORK_SHEET')))
        <td>
            @if(isset($employeeTimeSheet->updated_at))
                {{ $employeeTimeSheet->updated_at }}
            @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>
        <td>
            @if(isset($employeeTimeSheet->modifier_id))
                {{ $employeeTimeSheet->getModifierFullName() }}
            @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>
        <td>
            @if(isset($employeeTimeSheet->created_at))
                {{ $employeeTimeSheet->created_at }}
            @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>
        @endpermission
    </tr>
@endforeach
