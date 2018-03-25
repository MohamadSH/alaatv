@permission((Config::get('constants.LIST_ATTRIBUTEGROUP_ACCESS')))
@foreach($attributegroups as $attributegroup)
    <tr >
        <th></th>
        <td>@if(isset($attributegroup->name) && strlen($attributegroup->name)>0) {{ $attributegroup->name }} @else <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
        <td>@if(isset($attributegroup->description) && strlen($attributegroup->description)>0) {!!   $attributegroup->description !!} @else <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>
            @if($attributegroup->attributes()->get()->isEmpty())
                <span class="label label-sm label-danger"> درج نشده </span>
            @else
                @foreach($attributegroup->attributes()->pluck('displayName') as $attribute)
                    {{$attribute}}
                    <br>
                @endforeach
            @endif
        </td>
        <td class="center">@if(isset($attributegroup->created_at) && strlen($attributegroup->created_at)>0) @else <span class="label label-sm label-danger"> درج نشده </span> @endif {{ $attributegroup->CreatedAt_Jalali() }} </td>
        <td class="center">@if(isset($attributegroup->updated_at) && strlen($attributegroup->updated_at)>0) @else <span class="label label-sm label-danger"> درج نشده </span> @endif {{ $attributegroup->UpdatedAt_Jalali() }} </td>
        <td>
            <div class="btn-group">
                <button class="btn btn-xs black dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> عملیات
                    <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu" role="menu">
                    @permission((Config::get('constants.SHOW_ATTRIBUTEGROUP_ACCESS')))
                    <li>
                        <a href="{{action("AttributegroupController@edit" , $attributegroup)}}">
                            <i class="fa fa-pencil"></i> اصلاح </a>
                    </li>
                    @endpermission
                    @permission((Config::get('constants.REMOVE_ATTRIBUTEGROUP_ACCESS')))
                    <li>
                        <a data-target="#static-{{$attributegroup->id}}" data-toggle="modal">
                            <i class="fa fa-remove"></i> حذف </a>
                    </li>
                    @endpermission

                </ul>
                <div id="ajax-modal" class="modal fade" tabindex="-1"> </div>
                <!-- static -->
                @permission((Config::get('constants.REMOVE_ATTRIBUTEGROUP_ACCESS')))
                <div id="static-{{$attributegroup->id}}" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-body">
                        <p> آیا مطمئن هستید؟ </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-outline dark">خیر</button>
                        <button type="button" data-dismiss="modal"  class="btn green" onclick="removeAttributegroup('{{action("AttributegroupController@destroy" , $attributegroup)}}');" >بله</button>
                    </div>
                </div>
                @endpermission
            </div>
        </td>
    </tr>
@endforeach
@endpermission