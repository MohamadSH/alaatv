@permission((config('constants.LIST_SLIDESHOW_ACCESS')))
@foreach($slides as $slide)
    <tr id="{{$slide->id}}">
        <td>
            {{$slide->order}}
        </td>
        <td id="slideName_{{$slide->id}}">
            @if(isset($slide->title) && strlen($slide->title)>0)
                {{$slide->title}}
            @else
                <span class="m-badge m-badge--wide label-sm m-badge--info">ندارد</span>
            @endif
        </td>
        <td>
            @if(isset($slide->shortDescription) && strlen($slide->shortDescription)>0)
                {{$slide->shortDescription}}
            @else
                <span class="m-badge m-badge--wide label-sm m-badge--info">ندارد</span>
            @endif</td>
        <td>
            @if(isset($slide->link))
                <a target="_blank" href="{{$slide->link}}"></a> {{$slide->link}}
            @else
                <span class="m-badge m-badge--wide label-sm m-badge--info">ندارد</span>
            @endif
        </td>
        <td>
            @if(isset($slide->websitepage))
                <a target="_blank" href="{{$slide->websitepage->url}}"></a> {{$slide->websitepage->displayName}}
            @else
                <span class="m-badge m-badge--wide label-sm m-badge--info">ندارد</span>
            @endif
        </td>
        
        <td>
            @if(isset($slide->photo) && strlen($slide->photo)>0)
                <div class="mt-element-overlay">
                    <div class="mt-overlay-1">
                        <img alt="عکس اسلاید @if(isset($slide->title[0])) {{$slide->title}} @endif"
                             class="timeline-badge-userpic"
                             style="width: 60px ;height: 60px"
                             src="{{ $slide->url }}"/>
                    </div>
                </div>

            @else
                <span class="m-badge m-badge--wide label-sm m-badge--warning"> ندارد </span>
            @endif
        </td>
        <td>
            @if($slide->isEnable)
                <span class="m-badge m-badge--wide label-sm m-badge--success"> فعال </span>
            @else
                <span class="m-badge m-badge--wide label-sm m-badge--warning"> غیرفعال </span>
            @endif
        </td>
        <td>
            <span class="slide_id hidden" id="{{$slide->id}}"></span>
            @permission((config('constants.EDIT_SLIDESHOW_ACCESS')))
            <a class="btn btn-sm btn-outline-warning m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air deleteSlide m--margin-right-20" href="{{action("Web\SlideShowController@edit" , $slide)}}">
                <span>
                    <i class="fa fa-edit"></i>
                    <span>اصلاح</span>
                </span>
            </a>
            @endpermission @permission((config('constants.REMOVE_SLIDESHOW_ACCESS')))
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
