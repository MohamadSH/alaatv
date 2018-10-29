@if(isset($pageName) && strcmp($pageName,"dashboard")==0)
    @foreach($assignments as $assignment)
        <div class="timeline">
            <!-- TIMELINE ITEM -->
            <div class="timeline-item">
                <div class="timeline-badge">
                    <img class="timeline-badge-userpic" src="/assets/global/img/extra/assignment-timeline-resize.jpg">
                </div>
                <div class="timeline-body">
                    <div class="timeline-body-arrow"></div>
                    <div class="timeline-body-head">
                        <div class="timeline-body-head-caption">
                            <a href="javascript:"
                               class="timeline-body-title font-blue-madison">{{$assignment->name}}</a>
                            <span class="timeline-body-time font-grey-cascade">{{$assignment->CreatedAt_Jalali()}}</span>
                        </div>
                        <div class="timeline-body-head-actions">
                            @if(strlen($assignment->questionFile)>0 || strlen($assignment->solutionFile)>0 || strlen($assignment->analysisVideoLink)>0)
                                <div class="btn-group">
                                    <button class="btn btn-circle green btn-sm dropdown-toggle" type="button"
                                            data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                        دانلود
                                        <i class="fa fa-angle-down"></i>
                                    </button>

                                    <ul class="dropdown-menu pull-right" role="menu">
                                        @if(strlen($assignment->questionFile)>0)
                                            <li>
                                                <a href="{{action("HomeController@download" , ["content"=>"تمرین","fileName"=>$assignment->questionFile ])}}">دانلود
                                                    تمرین </a>
                                            </li>
                                        @endif
                                        @if(strlen($assignment->solutionFile)>0)
                                            <li>
                                                <a href="{{action("HomeController@download" , ["content"=>"پاسخ تمرین","fileName"=>$assignment->solutionFile ])}}">دانلود
                                                    کلید تمرین </a>
                                            </li>
                                        @endif
                                        @if(strlen($assignment->analysisVideoLink)>0)
                                            <li>
                                                <a href="{{ $assignment->analysisVideoLink }}">دانلود فیلم تحلیل
                                                    تمرین </a>
                                            </li>
                                        @endif
                                        {{--<li class="divider"> </li>--}}
                                        {{--<li>--}}
                                        {{--<a href="javascript:;">Separated link </a>--}}
                                        {{--</li>--}}
                                    </ul>

                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="timeline-body-content">

                        <span class="font-grey-cascade">{!!  $assignment->description  !!}</span>
                    </div>
                </div>
            </div>
            <!-- END TIMELINE ITEM -->
        </div>
    @endforeach
@else
    @permission((Config::get('constants.LIST_ASSIGNMENT_ACCESS')))
    @foreach($assignments as $assignment)
        <tr>
            <th></th>
            <td>@if(isset($assignment->name) && strlen($assignment->name)>0) {{ $assignment->name }} @else <span
                        class="label label-sm label-danger"> درج نشده </span> @endif </td>
            <td>@if(isset($assignment->description) && strlen($assignment->description)>0) {!!   $assignment->description !!} @else
                    <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
            <td>@if(isset($assignment->major->id)) @if(strlen($assignment->major->name)>0) {{ $assignment->major->name }} @else {{ $assignment->major->id }} @endif @else
                    <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
            <td>@if(isset($assignment->numberOfQuestions) && strlen($assignment->numberOfQuestions)>0) {{ $assignment->numberOfQuestions }} @else
                    <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
            <td>@if(isset($assignment->questionFile) && strlen($assignment->questionFile)>0) <a
                        href="{{action("HomeController@download" , ["content"=>"تمرین","fileName"=>$assignment->questionFile ])}}">
                    دانلود </a> @else <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
            <td>@if(isset($assignment->solutionFile) && strlen($assignment->solutionFile)>0) <a
                        href="{{action("HomeController@download" , ["content"=>"پاسخ تمرین","fileName"=>$assignment->solutionFile ])}}">
                    دانلود </a> @else <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
            <td>@if(isset($assignment->analysisVideoLink) && strlen($assignment->analysisVideoLink)>0) <a
                        href="{{ $assignment->analysisVideoLink }}"> دانلود </a> @else <span
                        class="label label-sm label-danger"> درج نشده </span> @endif </td>
            <td>
                @if(isset($assignment->assignmentstatus->id))
                    <span class="label label-sm  @if($assignment->assignmentstatus->id == 1) label-success @elseif($assignment->assignmentstatus->id == 2) label-warning @endif">@if(strlen($assignment->assignmentstatus->name)>0)  {{ $assignment->assignmentstatus->name }} @else {{ $assignment->assignmentstatus->id }} @endif </span>
                @else
                    <span class="label label-sm label-danger"> درج نشده </span>
                @endif
            </td>
            <td class="center">@if(isset($assignment->created_at) && strlen($assignment->created_at)>0) @else <span
                        class="label label-sm label-danger"> درج نشده </span> @endif {{ $assignment->CreatedAt_Jalali() }}
            </td>
            <td class="center">@if(isset($assignment->updated_at) && strlen($assignment->updated_at)>0) @else <span
                        class="label label-sm label-danger"> درج نشده </span> @endif {{ $assignment->UpdatedAt_Jalali() }}
            </td>
            <td>
                <div class="btn-group">
                    <button class="btn btn-xs black dropdown-toggle" type="button" data-toggle="dropdown"
                            aria-expanded="false"> عملیات
                        <i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        @permission((Config::get('constants.SHOW_ASSIGNMENT_ACCESS')))
                        <li>
                            <a href="{{action("AssignmentController@edit" , $assignment)}}">
                                <i class="fa fa-pencil"></i> اصلاح </a>
                        </li>
                        @endpermission
                        @permission((Config::get('constants.REMOVE_ASSIGNMENT_ACCESS')))
                        <li>
                            <a data-target="#static-{{$assignment->id}}" data-toggle="modal">
                                <i class="fa fa-remove"></i> حذف </a>
                        </li>
                        @endpermission

                    </ul>
                    <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
                    <!-- static -->
                    @permission((Config::get('constants.REMOVE_ASSIGNMENT_ACCESS')))
                    <div id="static-{{$assignment->id}}" class="modal fade" tabindex="-1" data-backdrop="static"
                         data-keyboard="false">
                        <div class="modal-body">
                            <p> آیا مطمئن هستید؟ </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-outline dark">خیر</button>
                            <button type="button" data-dismiss="modal" class="btn green"
                                    onclick="removeAssignment('{{action("AssignmentController@destroy" , $assignment)}}');">
                                بله
                            </button>
                        </div>
                    </div>
                    @endpermission
                </div>
            </td>
        </tr>
    @endforeach
    @endpermission
@endif
