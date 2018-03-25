@permission((Config::get('constants.LIST_SLIDESHOW_ACCESS')))
@foreach($slides as $slide)
    <tr id="{{$slide->id}}">
        <td> {{$slide->order}} </td>
        <td id="slideName_{{$slide->id}}">@if(isset($slide->title) && strlen($slide->title)>0) {{$slide->title}} @else <span class="label label-sm label-info">ندارد</span> @endif</td>
        <td>@if(isset($slide->shortDescription) && strlen($slide->shortDescription)>0) {{$slide->shortDescription}} @else <span class="label label-sm label-info">ندارد</span> @endif</td>
        <td>@if(isset($slide->link)) <a target="_blank" href="{{$slide->link}}"></a> {{$slide->link}} @else <span class="label label-sm label-info">ندارد</span> @endif</td>
        <td>
            @if(isset($slide->photo) && strlen($slide->photo)>0)
                <div class="mt-element-overlay">
                    <div class="mt-overlay-1">
                        <img alt="عکس اسلاید @if(isset($slide->title[0])) {{$slide->title}} @endif" class="timeline-badge-userpic" style="width: 60px ;height: 60px" src="{{ route('image', ['category'=>$slideDisk,'w'=>'60' , 'h'=>'60' ,  'filename' =>  $slide->photo ]) }}"  />
                        <div class="mt-overlay">
                            <ul class="mt-info">
                                <li>
                                        <a class="btn default btn-outline" data-toggle="modal" href="#profileimage-{{$slide->id}}"  ><i class="icon-magnifier"></i></a>
                                </li>
                                <li>
                                    <a target="_blank" class="btn default btn-outline" href="{{action("HomeController@download" , ["content"=>$slideContentName,"fileName"=>$slide->photo ])}}">
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
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">نمایش عکس اسلاید</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row" style="text-align: center;">
                                    <img alt="عکس اسلاید @if(isset($slide->title[0])) {{$slide->title}} @endif"  style="width: 80%" src="{{ route('image', ['category'=>$slideDisk,'w'=>'608' , 'h'=>'608' ,  'filename' =>  $slide->photo ]) }}" />
                                </div>
                                <div class="modal-footer">
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="button" class="dark btn btn-outline" data-dismiss="modal">بستن</button>
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
        <td> @if($slide->isEnable) <span class="label label-sm label-success"> فعال </span> @else <span class="label label-sm label-warning"> غیرفعال </span>  @endif</td>
        <td>
            <span class="slide_id hidden" id="{{$slide->id}}"></span>
            @permission((Config::get('constants.EDIT_SLIDESHOW_ACCESS')))
                <a class="btn btn-outline btn-circle dark btn-sm blue deleteSlide"  href="{{action("SlideShowController@edit" , $slide)}}" ><i class="fa fa-pencil"></i> اصلاح</a>
            @endpermission
            @permission((Config::get('constants.REMOVE_SLIDESHOW_ACCESS')))
                <a class="btn btn-outline btn-circle dark btn-sm red deleteSlide" data-toggle="modal" href="#removeSlideModal"  ><i class="fa fa-trash-o"></i> حذف</a>
            @endpermission
        </td>
    </tr>
@endforeach
@endpermission