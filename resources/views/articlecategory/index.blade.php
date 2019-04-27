@permission((Config::get('constants.LIST_ARTICLECATEGORY_ACCESS')))
@foreach( $articlecategories as $articlecategory)
    <tr id = "{{$articlecategory->id}}">
        <th></th>
        <td>@if(isset($articlecategory->name) && strlen($articlecategory->name)>0) {{ $articlecategory->name}} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif </td>
        <td>@if(isset($articlecategory->enable) && strlen($articlecategory->enable)>0) @if($articlecategory->enable == 1)
                <span class = "m-badge m-badge--wide label-sm m-badge--success">فعال</span> @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger">غیر فعال</span> @endif @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif </td>
        <td>@if(isset($articlecategory->updated_at) && strlen($articlecategory->updated_at)>0) {{ $articlecategory->UpdatedAt_Jalali()}} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif </td>
        <td>@if(isset($articlecategory->order) && strlen($articlecategory->order)>0) {{ $articlecategory->order}} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif </td>
        <td>@if(isset($articlecategory->description) && strlen($articlecategory->description)>0) {{ $articlecategory->description}} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif </td>
        <td>
            <div class = "btn-group">
                <button class = "btn btn-xs black dropdown-toggle" type = "button" data-toggle = "dropdown" aria-expanded = "false"> عملیات
                    <i class = "fa fa-angle-down"></i>
                </button>
                <ul class = "dropdown-menu" role = "menu">
                    @permission((Config::get('constants.SHOW_ARTICLECATEGORY_ACCESS')))
                    <li>
                        <a href = "{{action("Web\ArticlecategoryController@edit" , $articlecategory)}}">
                            <i class = "fa fa-pencil"></i>
                            اصلاح
                        </a>
                    </li>
                    @endpermission @permission((Config::get('constants.REMOVE_ARTICLECATEGORY_ACCESS')))
                    <li>
                        <a data-target = "#static-{{$articlecategory->id}}" data-toggle = "modal">
                            <i class = "fa fa-remove"></i>
                            حذف
                        </a>
                    </li>
                    @endpermission
                </ul>
                <div id = "ajax-modal" class = "modal fade" tabindex = "-1"></div>
                <!-- static -->@permission((Config::get('constants.REMOVE_ARTICLECATEGORY_ACCESS')))
                <div id = "static-{{$articlecategory->id}}" class = "modal fade" tabindex = "-1" data-backdrop = "static" data-keyboard = "false">
                    <div class = "modal-body">
                        <p> آیا مطمئن هستید؟</p>
                    </div>
                    <div class = "modal-footer">
                        <button type = "button" data-dismiss = "modal" class = "btn btn-outline dark">خیر</button>
                        <button type = "button" data-dismiss = "modal" class = "btn green" onclick = "removeArticlecategory('{{action("Web\ArticlecategoryController@destroy" , $articlecategory)}}');">
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