@if(isset($pageName))
    <ul class="feeds">
    @foreach($contentCollection as $content)
        <!-- TIMELINE ITEM -->
            <li>
                <a href="{{action("ContentController@show", $content["id"])}}">
                    <div class="col1">
                        <div class="cont">
                            <div class="cont-col1">
                                <div class="label label-sm label-danger">
                                    <i class="fa fa-file-pdf-o"></i>
                                </div>
                            </div>
                            <div class="cont-col2">
                                <div class="desc">
                                        {{$content["displayName"]}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col2">
                        <div class="date">{{$content["validSince_Jalali"]}}</div>
                    </div>
                </a>
            </li>
            <!-- END TIMELINE ITEM -->
        @endforeach

    </ul>
@else

@foreach($contents as $content)
<tr >
        <th></th>
        @if(isset($columns) && in_array("name",$columns))
            <td>@if(isset($content->name[0])) <a target="_blank" href="{{action("ContentController@show" , $content)}}"> {{ $content->name }} </a> @else <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
        @endif
        @if(isset($columns) && in_array("order",$columns))
            <td>@if(isset($content->order)) {{ $content->order }} @else <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
        @endif
        @if(isset($columns) && in_array("enable",$columns))
            <td>@if(isset($content->enable) && $content->enable) <span class="label label-sm label-success">  فعال </span> @else <span class="label label-sm label-danger"> غیر فعال </span> @endif</td>
        @endif
        @if(isset($columns) && in_array("grade",$columns))
            <td>@if($content->grades->isNotEmpty()) @foreach($content->grades as $grade){{$grade->displayName}} @endforeach @else<span class="label label-sm label-danger">  درج نشده </span>@endif</td>
        @endif
        @if(isset($columns) && in_array("major",$columns))
            <td>@if($content->majors->isNotEmpty()) {{$content->major->name}} @else<span class="label label-sm label-danger">  درج نشده </span>@endif</td>
        @endif
        @if(isset($columns) && in_array("contentType",$columns))
            <td>@if($content->contenttypes->isNotEmpty()) @foreach($content->contenttypes as $contenttype){{$contenttype->displayName}} @endforeach @else<span class="label label-sm label-danger">  درج نشده </span>@endif</td>
        @endif
        @if(isset($columns) && in_array("file",$columns))
            <td>
                @if($content->files->count() == 1)
                    <a target="_blank" href="{{action("HomeController@download" , ["fileName"=>$content->files->first()->uuid ])}}" class="btn btn-circle green btn-outline btn-sm"><i class="fa fa-download"></i> دانلود </a>
                @else
                    <div class="btn-group">
                        <button class="btn btn-circle green btn-outline btn-sm" data-toggle="dropdown" aria-expanded="true">دانلود
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu">
                            @foreach($content->files as $file)
                                <li>
                                    <a target="_blank" href="{{action("HomeController@download" , ["fileName"=>$file->uuid ])}}" > فایل {{$file->pivot->caption}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </td>
        @endif
        @if(isset($columns) && in_array("show",$columns))
            <td style="text-align: center">
                <a target="_blank" href="{{action("ContentController@show" , $content)}}" class="btn blue"  >نمایش/ دانلود </a>
            </td>
        @endif
        @if(isset($columns) && in_array("description",$columns))
            <td style="text-align: center">
                @if(isset($content->description[0]))
                    <button class="btn blue" data-target="#static-description-{{$content->id}}" data-toggle="modal">نمایش </button>
                    <div id="static-description-{{$content->id}}" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                        <div class="modal-body" style="text-align: right">
                            {!! $content->description !!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-outline dark">بستن</button>
                        </div>
                    </div>
                @else <span class="label label-sm label-danger"> درج نشده </span>
                @endif
            </td>
        @endif
        @if(isset($columns) && in_array("validSince",$columns))
            <td class="center">@if(isset($content->validSince)) {{ $content->validSince_Jalali() }} @else <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
        @endif
        @if(isset($columns) && in_array("created_at",$columns))
            <td class="center">@if(isset($content->created_at)) {{ $content->CreatedAt_Jalali() }}  @else <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
        @endif
        @if(isset($columns) && in_array("updated_at",$columns))
            <td class="center">@if(isset($content->updated_at)) {{ $content->UpdatedAt_Jalali() }}  @else <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
        @endif
        @if(isset($columns) && in_array("action",$columns))
            <td>
            <div class="btn-group">
                <button class="btn btn-xs black dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> عملیات
                    <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu" role="menu">
                    @permission((Config::get('constants.EDIT_EDUCATIONAL_CONTENT')))
                    <li>
                        <a target="_blank" href="{{action("ContentController@edit" , $content)}}">
                            <i class="fa fa-pencil"></i> اصلاح </a>
                    </li>
                    @endpermission
                    @permission((Config::get('constants.REMOVE_EDUCATIONAL_CONTENT_ACCESS')))
                    <li>
                        <a data-target="#static-{{$content->id}}" data-toggle="modal">
                            <i class="fa fa-remove"></i> حذف </a>
                    </li>
                    @endpermission

                </ul>
                <div id="ajax-modal" class="modal fade" tabindex="-1"> </div>
                <!-- static -->
                {{--@permission((Config::get('constants.REMOVE_PRODUCT_ACCESS')))--}}
                <div id="static-{{$content->id}}" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-body">
                        <p> آیا مطمئن هستید؟ </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-outline dark">خیر</button>
                        <button type="button" data-dismiss="modal"  class="btn green" onclick="removeContent('{{action("ContentController@destroy" , $content)}}');" >بله</button>
                    </div>
                </div>
                {{--@endpermission--}}
            </div>
        </td>
        @endif
    </tr>
@endforeach

@endif