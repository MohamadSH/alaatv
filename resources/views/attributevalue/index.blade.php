<div class="form-group {{ $errors->has('') ? ' has-error' : '' }}">
    <label class="col-md-3 control-label" for="">جدول مقادیر صفت</label>
    <div class="col-md-9">
        <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
        <div class="btn-group">
            @permission((config('constants.INSERT_ATTRIBUTEVALUE_ACCESS')))
            <a class="btn btn-info m-btn m-btn--icon m-btn--wide" data-toggle="modal" href="#responsive-attributevalue" data-target="#responsive-attributevalue">
                <i class="fa fa-plus"></i> افزودن مقدار صفت
            </a>

            <!--begin::Modal-->
            <div class="modal fade" id="responsive-attributevalue" tabindex="-1" role="dialog" aria-labelledby="responsive-attributevalueModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="responsive-attributevalueModalLabel">افزودن مقدار صفت جدید</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        {!! Form::open(['method' => 'POST','action' => 'Web\AttributevalueController@store', 'class'=>'nobottommargin' , 'id' => 'attributevalueForm']) !!}
                        <div class="modal-body">
                            <div class="row">
                                @include('attributevalue.form')
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="attributegroupForm-close">بستن</button>
                            <button type="button" class="btn btn-primary" id="attributevalueForm-submit">ذخیره</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <!--end::Modal-->
            @endpermission
        </div>
    </div>
</div>

<div class="form-group {{ $errors->has('') ? ' has-error' : '' }}">
    <label class="col-md-3 control-label" for=""></label>
    <div class="col-md-9">
        <table class="table" width="100%">
            <thead>
            <tr>
                <th>مقدار</th>
                <th>توضیح</th>
                <th>اصلاح</th>
            </tr>
            </thead>
            <tbody>
            @if($attributevalues->isEmpty())
                <td>مقدار صفت درج نشده است</td>
            @else
                @foreach($attributevalues as $attributevalue)
                    <tr>
                        <td>@if(isset($attributevalue->name)) {{$attributevalue->name}} @else درج نشده@endif</td>
                        <td>@if(isset($attributevalue->description) && strlen($attributevalue->description) > 0) {{$attributevalue->description}} @else
                                درج نشده@endif</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-xs black dropdown-toggle" type="button" data-toggle="dropdown"
                                        aria-expanded="false"> عملیات
                                    <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    @permission((config('constants.EDIT_ATTRIBUTEVALUE_ACCESS')))
                                    <li>
                                        <a href = "{{action("Web\AttributevalueController@edit" , $attributevalue)}}">
                                            <i
                                                    class="fa fa-pencil"></i> اصلاح </a>
                                    </li>
                                    @endpermission
                                    @permission((config('constants.REMOVE_ATTRIBUTEVALUE_ACCESS')))
                                    <li>
                                        <a data-target="#static-{{$attributevalue->id}}" data-toggle="modal">
                                            <i class="fa fa-remove"></i> حذف </a>
                                    </li>
                                    @endpermission
                                </ul>

                                <!-- static -->
                                @permission((config('constants.REMOVE_ATTRIBUTEVALUE_ACCESS')))

                                <!--begin::Modal-->
                                <div class="modal fade" id="static-{{$attributevalue->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <p> آیا مطمئن هستید؟ </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">خیر</button>
                                                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="removeattributevalues('{{action("Web\AttributevalueController@destroy" , $attributevalue)}}');">بله</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Modal-->

                                @endpermission
                            </div>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
