@if(isset($pageName) && strcmp($pageName,"dashboard")==0)
    @foreach($consultations as $consultation)
        <!-- TIMELINE ITEM -->
        <div class="timeline-item">
            <div class="timeline-badge">
                <img class="timeline-badge-userpic" src="/assets/global/img/extra/consultant.jpg" alt="تامبنیل مشاوره">
            </div>
            <div class="timeline-body">
                <div class="timeline-body-arrow"></div>
                <div class="timeline-body-head">
                    <div class="timeline-body-head-caption">
                        <a href="javascript:"
                           class="timeline-body-title font-blue-madison pull-left">{{ $consultation->name }}</a>
                        <span class="timeline-body-time font-grey-cascade">{{$consultation->CreatedAt_Jalali()}}</span>
                    </div>
                    <div class="timeline-body-head-actions">
                        @if(strlen($consultation->videoPageLink)>0 || strlen($consultation->textScriptLink)>0)
                            <div class="btn-group">
                                <button class="btn btn-circle green btn-outline btn-sm dropdown-toggle" type="button"
                                        data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> دانلود
                                    <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                    @if(strlen($consultation->videoPageLink)>0)
                                        <li>
                                            <a href="{{$consultation->videoPageLink}}">دانلود فیلم مشاوره </a>
                                        </li>
                                    @endif
                                    @if(strlen($consultation->textScriptLink)>0)
                                        <li>
                                            <a href="{{$consultation->textScriptLink}}">دانلود فایل متن مشاوره </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="timeline-body-content">
                    <span class="font-grey-cascade">{!! strip_tags($consultation->description) !!}</span>
                </div>
            </div>
        </div>
        <!-- END TIMELINE ITEM -->
    @endforeach
@else
    @permission((Config::get('constants.LIST_CONSULTATION_ACCESS')))
    @foreach( $consultations as $consultation)
        <tr>
            <th></th>
            <td>@if(isset($consultation->name) && strlen($consultation->name)>0) {{ $consultation->name }} @else <span
                        class="label label-sm label-danger"> درج نشده </span> @endif</td>
            <td>
                <div class="mt-element-overlay">
                    <div class="mt-overlay-1">
                        <img alt="تامبنیل مشاوره" class="timeline-badge-userpic" style="width: 60px ;height: 60px"
                             src="{{ route('image', [ 'category'=>'7','w'=>'60' , 'h'=>'60' , 'filename' =>  $consultation->thumbnail ]) }}"/>
                        <div class="mt-overlay">
                            <ul class="mt-info">
                                <li>
                                    <a class="btn default btn-outline" data-toggle="modal"
                                       href="#consultationThumbnail-{{$consultation->id}}">
                                        <i class="icon-magnifier"></i>
                                    </a>
                                </li>
                                <li>
                                    <a target="_blank" class="btn default btn-outline"
                                       href="{{action("HomeController@download" , ["content"=>"تامبنیل مشاوره","fileName"=>$consultation->thumbnail ])}}">
                                        <i class="icon-link"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Photo Modal -->
                <div id="consultationThumbnail-{{$consultation->id}}" class="modal fade" tabindex="-1" data-width="760">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">نمایش تامبنیل مشاوره</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="text-align: center;">
                            <img alt="تامبنیل مشاوره" style="width: 80%"
                                 src="{{ route('image', ['category'=>'7','w'=>'608' , 'h'=>'608' ,  'filename' =>  $consultation->thumbnail ]) }}"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-outline dark">بستن</button>
                    </div>
                </div>
            </td>
            <td>@if(isset($consultation->description) && strlen($consultation->description)>0) {!!  $consultation->description !!}  @else
                    <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
            <td>@if(isset($consultation->major->id)) @if(strlen($consultation->major->name)>0) {{ $consultation->major->name }} @else {{ $consultation->major->id }} @endif @else
                    <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
            <td>@if(isset($consultation->videoPageLink) && strlen($consultation->videoPageLink)>0) <a
                        href="{{ $consultation->videoPageLink }}">دانلود</a> @else <span
                        class="label label-sm label-danger"> درج نشده </span> @endif</td>
            <td>@if(isset($consultation->textScriptLink) && strlen($consultation->textScriptLink)>0) <a
                        href="{{ $consultation->textScriptLink }}">دانلود</a> @else <span
                        class="label label-sm label-danger"> درج نشده </span> @endif</td>
            <td>
                <span class="label label-sm @if($consultation->consultationstatus->id == 1) label-success @elseif($consultation->consultationstatus->id == 2) label-warning @endif"> {{ $consultation->consultationstatus->name }} </span>
            </td>
            <td>@if(isset($consultation->created_at) && strlen($consultation->created_at)>0) {{ $consultation->CreatedAt_Jalali() }} @else
                    <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
            <td>@if(isset($consultation->updated_at) && strlen($consultation->updated_at)>0) {{ $consultation->UpdatedAt_Jalali() }} @else
                    <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
            <td>
                <div class="btn-group">
                    <button class="btn btn-xs black dropdown-toggle" type="button" data-toggle="dropdown"
                            aria-expanded="false"> عملیات
                        <i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        @permission((Config::get('constants.SHOW_CONSULTATION_ACCESS')))
                        <li>
                            <a href="{{action("ConsultationController@edit" , $consultation)}}">
                                <i class="fa fa-pencil"></i> اصلاح </a>
                        </li>
                        @endpermission
                        @permission((Config::get('constants.REMOVE_CONSULTATION_ACCESS')))
                        <li>
                            <a data-target="#static-{{$consultation->id}}" data-toggle="modal">
                                <i class="fa fa-remove"></i> حذف </a>
                        </li>
                        @endpermission

                    </ul>
                    <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
                    <!-- static -->
                    @permission((Config::get('constants.REMOVE_CONSULTATION_ACCESS')))
                    <div id="static-{{$consultation->id}}" class="modal fade" tabindex="-1" data-backdrop="static"
                         data-keyboard="false">
                        <div class="modal-body">
                            <p> آیا مطمئن هستید؟ </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-outline dark">خیر</button>
                            <button type="button" data-dismiss="modal" class="btn green"
                                    onclick="removeConsultation('{{action("ConsultationController@destroy" , $consultation)}}');">
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
