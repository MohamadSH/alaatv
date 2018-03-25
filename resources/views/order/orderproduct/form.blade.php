<div class="form-body">
    <div class="form-group">
        <div class="col-md-6">
            <label class="col-lg-3 col-md-3 col-sm-3 control-label bold" >نام کالا</label>
            <div class="col-md-9 col-md-9 col-sm-9">
                @if (isset($orderproduct->product->name))
                    <text class="form-control-static" >{{$orderproduct->product->name}}</text>
                @else
                    <text class="form-control-static" >خطا در نام کالا</text>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <label for="changeProduct" class="col-lg-3 col-md-3 col-sm-3 control-label">
                <label class="mt-checkbox mt-checkbox-outline">
                    <input type="checkbox" value="1" name="changeProduct" id="changeProduct"  />
                    <span></span>
                </label>تغییر کالا
            </label>
            <div class="col-lg-9 col-md-9 col-sm-9">
                <div class="col-lg-12 col-md-12">
                    <label class="mt-checkbox mt-checkbox-outline">
                        <input class="newProductSelect" type="checkbox" value="1" name="newProductBonPlus"  disabled />
                        <span></span>
                    </label><small class="bold">بن محصول جدید را به کاربر بده(اگر دارد)</small>
                </div>
                @include("admin.filters.productsFilter" , [ "listType"=>"childSelect", "selectType"=>"searchable" , 'label'=>["caption"=>""] ,"name"=>"newProductId" , "class"=>"newProductSelect" , "id"=>"newProductSelect" , "defaultValue"=>["value"=>0 , "caption"=>"انتخاب کنید"] , "disabled"=>true])
                <span class="help-block bold font-blue">قیمت: <lable id="newProductCostLabel">0</lable> تومان</span>
                <input type="hidden" id="newProductCostInput" name="newProductCost" >
            </div>
        </div>

    </div>
    <div class="form-group">
        <div class="col-md-6">
            <label for="changeCost" class="col-lg-4 col-md-4 col-sm-4 control-label">
                <label class="mt-checkbox mt-checkbox-outline">
                    <input type="checkbox" value="1" name="changeCost" id="changeCost"  />
                    <span></span>
                </label>تغییر قیمت(تومان)</label>
            <div class="col-md-8 col-md-8 col-sm-8">
                    {!! Form::text('cost', (isset($orderproduct)?$orderproduct->calculatePayableCost(true):null), ['class' => 'form-control', 'id' => 'cost' , 'dir'=>'ltr' , 'disabled']) !!}
                    @if ($errors->has('cost'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cost') }}</strong>
                        </span>
                    @endif
            </div>
        </div>
        <div class="col-md-6">
            <label class="col-lg-3 col-md-3 col-sm-3 control-label" >وضعیت تسویه</label>
            <div class="col-md-9 col-md-9 col-sm-9">
                {!! Form::select('checkoutstatus_id',$checkoutStatuses,null,['class' => 'form-control' ,'placeholder'=>'نا مشخص']) !!}
            </div>
        </div>
    </div>
</div>