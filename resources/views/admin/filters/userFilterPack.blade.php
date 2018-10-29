<div class="form-group">
    <div class="row">
        <div class="col-lg-6 col-md-6">
            @include('admin.filters.productsFilter' , ["withCheckbox"   => 1  , "listType" => "configurables" ])
        </div>
        <div class="col-lg-6 col-md-6">
            @include('admin.filters.productsFilter' , ["name" => "orderProducts[]" , "withCheckbox"   => 1 ,
                    "enableName" => "orderProductEnable" , "enableId"=>"orderProductEnable" , "description" => 1 , "id" => "orderProducts" , "withoutOrder" => 1 , "everyProduct" => 1 ])
        </div>
    </div>
    <div class="row" style="margin-top: 2%">
        <div class="col-md-12">
            <div class="col-lg-4 col-md-4">
                @include('admin.filters.orderstatusFilter')
            </div>
            <div class="col-lg-4 col-md-4">
                @include('admin.filters.paymentstatusFilter')
            </div>
            <div class="col-md-4">
                @include("admin.filters.checkoutStatusFilter")
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-lg-4 col-md-4">
        @include('admin.filters.roleFilter')
    </div>
    <div class="col-lg-4 col-md-4">
        @include('admin.filters.majorFilter' , ["withEnableCheckbox"=>true])
    </div>
    <div class="col-lg-4 col-md-4">
        @include('admin.filters.couponFilter')
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-lg-4 col-md-4">
            @include('admin.filters.postalCodeFilter')
        </div>
        <div class="col-lg-4 col-md-4">
            @include('admin.filters.provinceFilter')
        </div>
        <div class="col-lg-4 col-md-4">
            @include('admin.filters.cityFilter')
        </div>
    </div>
    <div class="row" style="margin-top: 2%">
        <div class="col-lg-4 col-md-4">
            @include('admin.filters.addressFilter')
        </div>
        <div class="col-lg-4 col-md-4">
            @include('admin.filters.schoolFilter')
        </div>
        <div class="col-lg-4 col-md-4">
            @include('admin.filters.emailFilter')
        </div>
    </div>
</div>
<div class="form-group">
    @include('admin.filters.identityFilter')
</div>
<div class="form-group">
    <div class="col-lg-3 col-md-3">
        @include('admin.filters.genderFilter' , ["genders" => $gendersWithUnknown])
    </div>
    <div class="col-lg-3 col-md-3">
        @include('admin.filters.lockProfileStatus')
    </div>
    <div class="col-lg-3 col-md-3">
        @include('admin.filters.mobileNumberVerification')
    </div>
    <div class="col-lg-3 col-md-3">
        @include('admin.filters.userStatusFilter')
    </div>
</div>
<div class="form-group">
    <label class="col-lg-2 col-md-2 bold control-label">تاریخ ثبت نام : </label>
    <div class="col-lg-10 col-md-10">
        @include('admin.filters.timeFilter.createdAt' , ["default" => true , "id" => "user"])
    </div>
    <label class="col-lg-2 col-md-2 bold control-label">تاریخ اصلاح : </label>
    <div class="col-lg-10 col-md-10">
        @include('admin.filters.timeFilter.updatedAt' , ["id" => "user"])
    </div>
</div>
