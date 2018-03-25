<div class="form-group {{ $errors->has('') ? ' has-error' : '' }}">
    <label class="col-md-3 control-label" for="">جدول مقادیر صفت</label>
    <div class="col-md-9">
        <div id="ajax-modal" class="modal fade" tabindex="-1"> </div>
        <div class="btn-group">
            @permission((Config::get('constants.INSERT_ATTRIBUTEVALUE_ACCESS')))
            <a class="btn btn-outline yellow-mint" data-toggle="modal" href="#responsive-attributevalue"><i class="fa fa-plus"></i> افزودن مقدار صفت </a>
            <!-- responsive modal -->
            <div id="responsive-attributevalue" class="modal fade" tabindex="-1" data-width="760">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">افزودن مقدار صفت جدید</h4>
                </div>
                {!! Form::open(['method' => 'POST','action' => 'AttributevalueController@store', 'class'=>'nobottommargin' , 'id' => 'attributevalueForm']) !!}
                <div class="modal-body">
                    <div class="row">
                        @include('attributevalue.form')
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-outline dark" id="attributegroupForm-close">بستن</button>
                    <button type="button" class="btn yellow-mint" id="attributevalueForm-submit">ذخیره</button>
                </div>
                {!! Form::close() !!}
            </div>
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
                            <td>@if(isset($attributevalue->description) && strlen($attributevalue->description) > 0) {{$attributevalue->description}} @else درج نشده@endif</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-xs black dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> عملیات
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        @permission((Config::get('constants.EDIT_ATTRIBUTEVALUE_ACCESS')))
                                        <li>
                                            <a href="{{action("AttributevalueController@edit" , $attributevalue)}}"><i class="fa fa-pencil"></i> اصلاح </a>
                                        </li>
                                        @endpermission
                                        @permission((Config::get('constants.REMOVE_ATTRIBUTEVALUE_ACCESS')))
                                        <li>
                                            <a data-target="#static-{{$attributevalue->id}}" data-toggle="modal">
                                                <i class="fa fa-remove"></i> حذف </a>
                                        </li>
                                        @endpermission
                                    </ul>

                                    <!-- static -->
                                    @permission((Config::get('constants.REMOVE_ATTRIBUTEVALUE_ACCESS')))
                                    <div id="static-{{$attributevalue->id}}" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                                        <div class="modal-body">
                                            <p> آیا مطمئن هستید؟ </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" data-dismiss="modal" class="btn btn-outline dark">خیر</button>
                                            <button type="button" data-dismiss="modal"  class="btn green" onclick="removeattributevalues('{{action("AttributevalueController@destroy" , $attributevalue)}}');" >بله</button>
                                        </div>
                                    </div>
                                    @endpermission
                                </div>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
