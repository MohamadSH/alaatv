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

    @foreach($items as $item)
        <tr>
            <th></th>
            {{--        @if(isset($columns) && in_array("name",$columns))--}}
            <td>@if(isset($item->name[0])) <a target="_blank"
                                              href="{{action("ContentController@show" , $item)}}"> {{ $item->name }} </a> @else
                    <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
            {{--@endif--}}
            {{--        @if(isset($columns) && in_array("order",$columns))--}}
            {{--            <td>@if(isset($item->order)) {{ $item->order }} @else <span class="label label-sm label-danger"> درج نشده </span> @endif </td>--}}
            {{--@endif--}}
            {{--        @if(isset($columns) && in_array("enable",$columns))--}}
            <td>@if(isset($item->enable) && $item->enable) <span
                        class="label label-sm label-success">  فعال </span> @else <span
                        class="label label-sm label-danger"> غیر فعال </span> @endif</td>
            {{--@endif--}}
            {{--@if(isset($columns) && in_array("grade",$columns))--}}
            {{--<td>@if($item->grades->isNotEmpty()) @foreach($item->grades as $grade){{$grade->displayName}} @endforeach @else<span class="label label-sm label-danger">  درج نشده </span>@endif</td>--}}
            {{--@endif--}}
            {{--@if(isset($columns) && in_array("major",$columns))--}}
            {{--<td>@if($item->majors->isNotEmpty()) {{$item->major->name}} @else<span class="label label-sm label-danger">  درج نشده </span>@endif</td>--}}
            {{--@endif--}}
            {{--@if(isset($columns) && in_array("contentType",$columns))--}}
            <td>@if(isset($item->contenttype->id)) {{$item->contenttype->displayName}} @else<span
                        class="label label-sm label-danger">  نامشخص </span>@endif</td>
            {{--@endif--}}
            {{--@if(isset($columns) && in_array("file",$columns))--}}
            <td>
                @if($item->files->count() == 1)
                    <a target="_blank" href="" class="btn btn-circle green btn-outline btn-sm"><i
                                class="fa fa-download"></i> دانلود </a>
                @else
                    <div class="btn-group">
                        <button class="btn btn-circle green btn-outline btn-sm" data-toggle="dropdown"
                                aria-expanded="true">دانلود
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu">
                            @foreach($item->files as $file)
                                <li>
                                    <a target="_blank" href=""> فایل </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </td>
            {{--@endif--}}
            {{--@if(isset($columns) && in_array("show",$columns))--}}
            {{--<td style="text-align: center">--}}
            {{--<a target="_blank" href="{{action("ContentController@show" , $item)}}" class="btn blue"  >نمایش/ دانلود </a>--}}
            {{--</td>--}}
            {{--@endif--}}
            {{--@if(isset($columns) && in_array("description",$columns))--}}
            <td style="text-align: center">
                @if(isset($item->description[0]))
                    <button class="btn blue" data-target="#static-description-{{$item->id}}" data-toggle="modal">نمایش
                    </button>
                    <div id="static-description-{{$item->id}}" class="modal fade" tabindex="-1" data-backdrop="static"
                         data-keyboard="false">
                        <div class="modal-body" style="text-align: right">
                            {!! $item->description !!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-outline dark">بستن</button>
                        </div>
                    </div>
                @else <span class="label label-sm label-danger"> درج نشده </span>
                @endif
            </td>
            {{--@endif--}}
            {{--@if(isset($columns) && in_array("validSince",$columns))--}}
            <td class="center">@if(isset($item->validSince)) {{ $item->validSince_Jalali() }} @else <span
                        class="label label-sm label-danger"> درج نشده </span> @endif </td>
            {{--@endif--}}
            {{--@if(isset($columns) && in_array("created_at",$columns))--}}
            <td class="center">@if(isset($item->created_at)) {{ $item->CreatedAt_Jalali() }}  @else <span
                        class="label label-sm label-danger"> درج نشده </span> @endif </td>
            {{--@endif--}}
            {{--@if(isset($columns) && in_array("updated_at",$columns))--}}
            <td class="center">@if(isset($item->updated_at)) {{ $item->UpdatedAt_Jalali() }}  @else <span
                        class="label label-sm label-danger"> درج نشده </span> @endif </td>
            {{--@endif--}}
            {{--@if(isset($columns) && in_array("action",$columns))--}}
            <td>
                <div class="btn-group">
                    <button class="btn btn-xs black dropdown-toggle" type="button" data-toggle="dropdown"
                            aria-expanded="false"> عملیات
                        <i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        @permission((Config::get('constants.EDIT_EDUCATIONAL_CONTENT')))
                        <li>
                            <a target="_blank" href="{{action("ContentController@edit" , $item)}}">
                                <i class="fa fa-pencil"></i> اصلاح </a>
                        </li>
                        @endpermission
                        @permission((Config::get('constants.REMOVE_EDUCATIONAL_CONTENT_ACCESS')))
                        <li>
                            <a data-target="#static-{{$item->id}}" data-toggle="modal">
                                <i class="fa fa-remove"></i> حذف </a>
                        </li>
                        @endpermission

                    </ul>
                    <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
                    <!-- static -->
                    {{--@permission((Config::get('constants.REMOVE_PRODUCT_ACCESS')))--}}
                    <div id="static-{{$item->id}}" class="modal fade" tabindex="-1" data-backdrop="static"
                         data-keyboard="false">
                        <div class="modal-body">
                            <p> آیا مطمئن هستید؟ </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-outline dark">خیر</button>
                            <button type="button" data-dismiss="modal" class="btn green"
                                    onclick="removeContent('{{action("ContentController@destroy" , $item)}}');">بله
                            </button>
                        </div>
                    </div>
                    {{--@endpermission--}}
                </div>
            </td>
            {{--@endif--}}
        </tr>
    @endforeach

@endif