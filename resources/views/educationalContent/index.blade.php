@if(isset($pageName))
    <ul class="feeds">
    @foreach($educationalContentCollection as $educationalContent)
        <!-- TIMELINE ITEM -->
            <li>
                <a href="{{action("EducationalContentController@show", $educationalContent["id"])}}">
                    <div class="col1">
                        <div class="cont">
                            <div class="cont-col1">
                                <div class="label label-sm label-danger">
                                    <i class="fa fa-file-pdf-o"></i>
                                </div>
                            </div>
                            <div class="cont-col2">
                                <div class="desc">
                                        {{$educationalContent["displayName"]}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col2">
                        <div class="date">{{$educationalContent["validSince_Jalali"]}}</div>
                    </div>
                </a>
            </li>
            <!-- END TIMELINE ITEM -->
        @endforeach

    </ul>
@else

@foreach($educationalContents as $educationalContent)
<tr >
        <th></th>
        @if(isset($columns) && in_array("name",$columns))
            <td>@if(isset($educationalContent->name[0])) <a target="_blank" href="{{action("EducationalContentController@show" , $educationalContent)}}"> {{ $educationalContent->name }} </a> @else <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
        @endif
        @if(isset($columns) && in_array("order",$columns))
            <td>@if(isset($educationalContent->order)) {{ $educationalContent->order }} @else <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
        @endif
        @if(isset($columns) && in_array("enable",$columns))
            <td>@if(isset($educationalContent->enable) && $educationalContent->enable) <span class="label label-sm label-success">  فعال </span> @else <span class="label label-sm label-danger"> غیر فعال </span> @endif</td>
        @endif
        @if(isset($columns) && in_array("grade",$columns))
            <td>@if($educationalContent->grades->isNotEmpty()) @foreach($educationalContent->grades as $grade){{$grade->displayName}} @endforeach @else<span class="label label-sm label-danger">  درج نشده </span>@endif</td>
        @endif
        @if(isset($columns) && in_array("major",$columns))
            <td>@if($educationalContent->majors->isNotEmpty()) {{$educationalContent->displayMajors()}} @else<span class="label label-sm label-danger">  درج نشده </span>@endif</td>
        @endif
        @if(isset($columns) && in_array("contentType",$columns))
            <td>@if($educationalContent->contenttypes->isNotEmpty()) @foreach($educationalContent->contenttypes as $contenttype){{$contenttype->displayName}} @endforeach @else<span class="label label-sm label-danger">  درج نشده </span>@endif</td>
        @endif
        @if(isset($columns) && in_array("file",$columns))
            <td>
                @if($educationalContent->files->count() == 1)
                    <a target="_blank" href="{{action("HomeController@download" , ["fileName"=>$educationalContent->files->first()->uuid ])}}" class="btn btn-circle green btn-outline btn-sm"><i class="fa fa-download"></i> دانلود </a>
                @else
                    <div class="btn-group">
                        <button class="btn btn-circle green btn-outline btn-sm" data-toggle="dropdown" aria-expanded="true">دانلود
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu">
                            @foreach($educationalContent->files as $file)
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
                <a target="_blank" href="{{action("EducationalContentController@show" , $educationalContent)}}" class="btn blue"  >نمایش/ دانلود </a>
            </td>
        @endif
        @if(isset($columns) && in_array("description",$columns))
            <td style="text-align: center">
                @if(isset($educationalContent->description[0]))
                    <button class="btn blue" data-target="#static-description-{{$educationalContent->id}}" data-toggle="modal">نمایش </button>
                    <div id="static-description-{{$educationalContent->id}}" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                        <div class="modal-body" style="text-align: right">
                            {!! $educationalContent->description !!}
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
            <td class="center">@if(isset($educationalContent->validSince)) {{ $educationalContent->validSince_Jalali() }} @else <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
        @endif
        @if(isset($columns) && in_array("created_at",$columns))
            <td class="center">@if(isset($educationalContent->created_at)) {{ $educationalContent->CreatedAt_Jalali() }}  @else <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
        @endif
        @if(isset($columns) && in_array("updated_at",$columns))
            <td class="center">@if(isset($educationalContent->updated_at)) {{ $educationalContent->UpdatedAt_Jalali() }}  @else <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
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
                        <a target="_blank" href="{{action("EducationalContentController@edit" , $educationalContent)}}">
                            <i class="fa fa-pencil"></i> اصلاح </a>
                    </li>
                    @endpermission
                    @permission((Config::get('constants.REMOVE_EDUCATIONAL_CONTENT_ACCESS')))
                    <li>
                        <a data-target="#static-{{$educationalContent->id}}" data-toggle="modal">
                            <i class="fa fa-remove"></i> حذف </a>
                    </li>
                    @endpermission

                </ul>
                <div id="ajax-modal" class="modal fade" tabindex="-1"> </div>
                <!-- static -->
                {{--@permission((Config::get('constants.REMOVE_PRODUCT_ACCESS')))--}}
                <div id="static-{{$educationalContent->id}}" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-body">
                        <p> آیا مطمئن هستید؟ </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-outline dark">خیر</button>
                        <button type="button" data-dismiss="modal"  class="btn green" onclick="removeEducationalContent('{{action("EducationalContentController@destroy" , $educationalContent)}}');" >بله</button>
                    </div>
                </div>
                {{--@endpermission--}}
            </div>
        </td>
        @endif
    </tr>
@endforeach

@endif