@permission((config('constants.LIST_SLIDESHOW_ACCESS')))
@foreach($slides as $slide)
    <tr id="{{$slide->id}}">
        <td> {{$slide->order}} </td>
        <td id="slideName_{{$slide->id}}">@if(isset($slide->title) && strlen($slide->title)>0) {{$slide->title}} @else
                <span class="label label-sm label-info">ندارد</span> @endif</td>
        <td>@if(isset($slide->shortDescription) && strlen($slide->shortDescription)>0) {{$slide->shortDescription}} @else
                <span class="label label-sm label-info">ندارد</span> @endif</td>
        <td>@if(isset($slide->link)) <a target="_blank" href="{{$slide->link}}"></a> {{$slide->link}} @else <span
                    class="label label-sm label-info">ندارد</span> @endif</td>
        <td>
            @if(isset($slide->photo) && strlen($slide->photo)>0)
                <div class="mt-element-overlay">
                    <div class="mt-overlay-1">
                        <img alt="عکس اسلاید @if(isset($slide->title[0])) {{$slide->title}} @endif"
                             class="timeline-badge-userpic" style="width: 60px ;height: 60px"
                             src="{{ route('image', ['category'=>$slideDisk,'w'=>'60' , 'h'=>'60' ,  'filename' =>  $slide->photo ]) }}"/>
                        <div class="mt-overlay">
                            <ul class="mt-info">
                                <li>
                                    <a class="btn default btn-outline" data-toggle="modal"
                                       href="#profileimage-{{$slide->id}}"><i class="icon-magnifier"></i></a>
                                </li>
                                <li>
                                    <a target="_blank" class="btn default btn-outline" href = "{{action("Web\HomeController@download" , ["content"=>$slideContentName,"fileName"=>$slide->photo ])}}">
                                        <i class="icon-link"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- image Modal -->
                <div class="modal fade" id="profileimage-{{$slide->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">نمایش عکس اسلاید</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row" style="text-align: center;">
                                    <img alt="عکس اسلاید @if(isset($slide->title[0])) {{$slide->title}} @endif"
                                         style="width: 80%"
                                         src="{{ route('image', ['category'=>$slideDisk,'w'=>'608' , 'h'=>'608' ,  'filename' =>  $slide->photo ]) }}"/>
                                </div>
                                <div class="modal-footer">
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="button" class="dark btn btn-outline" data-dismiss="modal">
                                                    بستن
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <span class="label label-sm label-warning"> ندارد </span>
            @endif
        </td>
        <td>
            @if($slide->isEnable)
                <span class="label label-sm label-success"> فعال </span>
            @else
                <span class="label label-sm label-warning"> غیرفعال </span>
            @endif
        </td>
        <td>
            <span class="slide_id hidden" id="{{$slide->id}}"></span>
            @permission((config('constants.EDIT_SLIDESHOW_ACCESS')))
            <a class="btn btn-sm btn-outline-warning m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air deleteSlide m--margin-right-20" href = "{{action("Web\SlideShowController@edit" , $slide)}}">
                <span>
                    <i class="flaticon-edit"></i>
                    <span>اصلاح</span>
                </span>
            </a>
            @endpermission
            @permission((config('constants.REMOVE_SLIDESHOW_ACCESS')))
            <a class="btn btn-sm btn-outline-danger m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air deleteSlide" data-toggle="modal" href="#removeSlideModal">
                <span>
                    <i class="flaticon-delete"></i>
                    <span>حذف</span>
                </span>
            </a>
            @endpermission
        </td>
    </tr>
@endforeach
@endpermission