@permission((config('constants.LIST_ATTRIBUTEGROUP_ACCESS')))
@foreach($attributegroups as $attributegroup)
    <tr>
        <th></th>
        <td>@if(isset($attributegroup->name) && strlen($attributegroup->name)>0) {{ $attributegroup->name }} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif </td>
        <td>@if(isset($attributegroup->description) && strlen($attributegroup->description)>0) {!!   $attributegroup->description !!} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        <td>
            @if($attributegroup->attributes()->get()->isEmpty())
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @else
                @foreach($attributegroup->attributes()->pluck('displayName') as $attribute)
                    {{$attribute}}
                    <br>
                @endforeach
            @endif
        </td>
        <td class = "center">@if(isset($attributegroup->created_at) && strlen($attributegroup->created_at)>0) @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif {{ $attributegroup->CreatedAt_Jalali() }}
        </td>
        <td class = "center">@if(isset($attributegroup->updated_at) && strlen($attributegroup->updated_at)>0) @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif {{ $attributegroup->UpdatedAt_Jalali() }}
        </td>
        <td>
            <div class = "btn-group">
                <button class = "btn btn-xs black dropdown-toggle" type = "button" data-toggle = "dropdown" aria-expanded = "false"> عملیات
                    <i class = "fa fa-angle-down"></i>
                </button>
                <ul class = "dropdown-menu" role = "menu">
                    @permission((config('constants.SHOW_ATTRIBUTEGROUP_ACCESS')))
                    <li>
                        <a href = "{{action("Web\AttributegroupController@edit" , $attributegroup)}}">
                            <i class = "fa fa-pencil"></i>
                            اصلاح
                        </a>
                    </li>
                    @endpermission @permission((config('constants.REMOVE_ATTRIBUTEGROUP_ACCESS')))
                    <li>
                        <a data-target = "#static-{{$attributegroup->id}}" data-toggle = "modal">
                            <i class = "fa fa-remove"></i>
                            حذف
                        </a>
                    </li>
                    @endpermission

                </ul>
                <div id = "ajax-modal" class = "modal fade" tabindex = "-1"></div>
                <!-- static -->@permission((config('constants.REMOVE_ATTRIBUTEGROUP_ACCESS')))

                <!--begin::Modal-->
                <div class = "modal fade" id = "static-{{$attributegroup->id}}" tabindex = "-1" role = "dialog" aria-hidden = "true">
                    <div class = "modal-dialog" role = "document">
                        <div class = "modal-content">
                            <div class = "modal-body">
                                <p> آیا مطمئن هستید؟</p>
                            </div>
                            <div class = "modal-footer">
                                <button type = "button" class = "btn btn-secondary" data-dismiss = "modal">خیر</button>
                                <button type = "button" class = "btn btn-primary" data-dismiss = "modal" onclick = "removeAttributegroup('{{action("Web\AttributegroupController@destroy" , $attributegroup)}}');">بله</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Modal-->

                @endpermission
            </div>
        </td>
    </tr>
@endforeach
@endpermission