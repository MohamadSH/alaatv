@permission((config('constants.SHOW_ORDER_ACCESS')))

@extends("app",["pageName"=>"admin"])

@section('page-css')
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet"
          type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/select2/css/select2.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/select2/css/select2-bootstrap.min.css"
          rel="stylesheet" type="text/css"/>
    
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css"
          rel="stylesheet" type="text/css"/>
    {{--<link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>--}}
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.css"
          rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/css/multi-select-rtl.css"
          rel="stylesheet" type="text/css"/>
    <link href="/acm/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css"
          rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/font/glyphicons-halflings/glyphicons-halflings.css"
          rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="flaticon-home-2 m--padding-right-5"></i>
                <a class="m-link" href="{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a class="m-link" href="{{action("Web\AdminController@adminOrder")}}">پنل مدیریت سفارش ها</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a target="_blank" class="m-link" href="{{action("Web\UserController@edit" , $order->user)}}">
                    اصلاح اطلاعات سفارش {{$order->user->firstName}} {{$order->user->lastName}}
                </a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <!--begin::Modal-->
    <div class="modal fade" id="responsive-transaction" tabindex="-1" role="dialog"
         aria-labelledby="orderproductExchangeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderproductExchangeModalLabel">
                        افزودن تراکنش جدید
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['files'=>true,'method' => 'POST','action' => ['Web\TransactionController@store'], 'class'=>'nobottommargin' ]) !!}
                <div class="modal-body">
                    @include('transaction.form' , ["class"=>["paymentmethod"=>"paymentMethodName"] , "name"=>["paymentmethod"=>"paymentMethodName"] , "id"=>["paymentmethod"=>"paymentMethodName"]])
                    {{--<span class="form-control-feedback m--font-info">( دقت شود از میان اطلاعات شماره مرجع ، شماره پیگیری و شماره چک که اطلاعات بانکی یک تراکنش محسوب می شوند ، تمامی آنها برای هر تراکنش وجود ندارد و نیاز به وارد نمودن همه ی آنها نیست)</span>--}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="userForm-close">بستن</button>
                    <button type="submit" class="btn btn-primary">ذخیره</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!--end::Modal-->
    <!--begin::Modal-->
    <div class="modal fade" id="deleteTransactionConfirmationModal" tabindex="-1" role="dialog"
         aria-labelledby="orderproductExchangeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderproductExchangeModalLabel">
                        حذف تراکنش
                        <span id="deleteTransactionFullName"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p> آیا مطمئن هستید؟</p>
                    {!! Form::hidden('transaction_id', null) !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">خیر</button>
                    <button type="submit" class="btn btn-primary" onclick="removeTransaction()">بله</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->
    @include('systemMessage.flash')
    
    <div class="row">
        <div class="col">
            <div class="m-portlet m-portlet--tabs">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs-line m-tabs-line--success m-tabs-line--2x" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#portlet_tab1"
                                   role="tab">
                                    <i class="flaticon-exclamation"></i>
                                    اطلاعات سفارش
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#portlet_tab2" role="tab">
                                    <i class="flaticon-open-box"></i>
                                    محصولات سفارش
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#portlet_tab3" role="tab">
                                    <i class="flaticon-coins"></i>
                                    تراکنش های موفق سفارش
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#portlet_tab4" role="tab">
                                    <i class="flaticon-coins"></i>
                                    کل تراکنش های سفارش
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#portlet_tab5" role="tab">
                                    <i class="flaticon-coins"></i>
                                    تمام آیتم های سفارش
                                </a>
                            </li>
                            
                            @if($orderArchivedTransactions->isNotEmpty())
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#portlet_tab6" role="tab">
                                        <i class="flaticon-piggy-bank"></i>
                                        تراکنش های موفق بایگانی شده
                                    </a>
                                </li>
                            @endif
                        
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab1" role="tabpanel">
                            
                            @if (Session::has('userBonError'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"></button>
                                    {{ Session::pull('userBonError') }}
                                </div>
                            @endif
                            <div class="row">
                                <div class="col">
                                    {!! Form::model($order,['files'=>true,'method' => 'PUT','action' => ['Web\OrderController@update',$order], 'class'=>'form-horizontal']) !!}
                                    @include('order.form')
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col">
                                                {!! Form::submit('اصلاح', ['class' => 'btn m-btn--pill m-btn--air btn-success']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        
                        </div>
                        <div class="tab-pane" id="portlet_tab2" role="tabpanel">
    
    
                            <!--begin::Modal-->
                            <div class="modal fade" id="orderproductRemoveModal" tabindex="-1" role="dialog"
                                 aria-labelledby="orderproductExchangeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="orderproductExchangeModalLabel">
                                                حذف محصول سفارش
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="orderProductIdForRemove" value="">
                                            آیا اطمینان دارید؟
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">خیر
                                            </button>
                                            <button type="submit" class="btn btn-primary btnRemoveOrderproductInModal">بله</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Modal-->
                            
                            <table class="table table-striped table-bordered table-hover table-checkable order-column"
                                   id="sample_1">
                                <thead>
                                <tr>
                                    <th>
                                        {{--<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">--}}
                                        {{--<input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />--}}
                                        {{--<span></span>--}}
                                        {{--</label>--}}
                                    </th>
                                    <th>
                                        <i class="fa fa-cart-arrow-down"></i>
                                        نام محصول
                                    </th>
                                    <th class="hidden-xs">
                                        <i class="fa fa-question"></i>
                                        ویژگی ها
                                    </th>
                                    <th>
                                        <i class="fa fa-dollar"></i>
                                        قیمت تمام شده به تومان (با در نظر گرفتن تخفیف ها)
                                    </th>
                                    <th>
                                        <i class="fa fa-dollar"></i>
                                        قیمت محصول به تومان(در زمان خرید)
                                    </th>
                                    <th>
                                        <i class="fa fa-percent"></i>
                                        تخفیف بن
                                    </th>
                                    <th>
                                        <i class="fa fa-percent"></i>
                                        تخفیف محصول
                                    </th>
                                    <th>
                                        <i class="fa fa-dollar"></i>
                                        مبلغ تخفیف داده شده(تومان)
                                    </th>
                                    @if(isset($order->coupon->id))
                                        <th>
                                            <i class="fa fa-percent"></i>
                                            مشمول کپن؟
                                        </th>
                                    @endif
                                    <th>
                                        <i class="fa fa-dollar"></i>
                                        وضعیت تسویه
                                    </th>
                                    <th>
                                        <i class="fa fa-cogs"></i>
                                        عملیات
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                
                                @foreach($order->orderproducts as $orderproduct)
{{--                                    {{ dd($orderproduct) }}--}}
{{--                                    {{ dd($orderproduct->discountPercentage) }}--}}
                                    <tr class="odd gradeX">
                                        <td>
                                            @if($orderproduct->orderproducttype_id == config("constants.ORDER_PRODUCT_GIFT"))
                                                <img src="/acm/extra/gift-box.png" width="25">
                                            @else
                                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                    <input name="orderproductsCheckbox[]" type="checkbox"
                                                           class="checkboxes" value="{{$orderproduct->id}}"/>
                                                    <span></span>
                                                </label>
                                            @endif
                                        </td>
                                        <td>
                                            <a target="_blank"
                                               href="@if($orderproduct->product->hasParents()) {{action("Web\ProductController@show" , $orderproduct->product->parents->first())}}@else {{action("Web\ProductController@show" , $orderproduct->product)}} @endif"> {{$orderproduct->product->name}} </a>
                                        </td>
                                        <td class="hidden-xs">
                                            @if($order->orderproducts)
                                                @if(isset($orderproduct->product->id))
                                                    @foreach($orderproduct->product->attributevalues('main')->get() as $attributevalue)
                                                        <span class="bold">{{$attributevalue->attribute->displayName}}</span>
                                                        : {{$attributevalue->name}} @if(isset(   $attributevalue->pivot->description) && strlen($attributevalue->pivot->description)>0 ) {{$attributevalue->pivot->description}} @endif
                                                        <br>
                                                    @endforeach
                                                    @foreach($orderproduct->attributevalues as $extraAttributevalue)
                                                        <span class="bold">{{$extraAttributevalue->attribute->displayName}}</span>
                                                        :{{$extraAttributevalue->name}}
                                                        (+ {{number_format($extraAttributevalue->pivot->extraCost)}}
                                                        تومان)
                                                        <br>
                                                    @endforeach
                                                    <br>
                                                @endif
                                            @else
                                                <span class="m-badge m-badge--wide m-badge--danger">ندارد</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($orderproduct->product->isFree)
                                                رایگان
                                            @else
                                                {{number_format($orderproduct->price['final'])}}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            {{number_format($orderproduct->price['base'])}}
                                        </td>
                                        <td class="text-center">
                                            {{$orderproduct->userbons->sum("pivot.usageNumber")}} بن
                                            <span class="m-badge m-badge--wide label-sm m-badge--info label-mini"> {{$orderproduct->getTotalBonDiscountPercentage()}}
                                                % </span>
                                        </td>
                                        <td class="text-center">
                                            {{$orderproduct->discountPercentage}}%
                                        </td>
                                        <td class="text-center">
                                            {{$orderproduct->discountAmount}}
                                        </td>
                                        @if(isset($order->coupon->id))
                                            <td class="text-center">
                                                @if($orderproduct->includedInCoupon)
                                                    بله
                                                @else
                                                    خیر
                                                @endif
                                            </td>
                                        @endif
                                        <td class="text-center">
                                            @if(isset($orderproduct->checkoutstatus_id)){{$orderproduct->checkoutstatus->displayName}}
                                            @else نامشخص
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{action("Web\OrderproductController@edit" , $orderproduct)}}"
                                               class="btn blue btn-sm btn-outline sbold uppercase">
                                                <i class="fa fa-pencil-square-o"></i>
                                                اصلاح
                                            </a>
                                            <button class="btn red btn-sm btn-outline sbold removeOrderproduct"
                                                    id="orderProductId_{{$orderproduct->id}}"
                                                    data-order-product-id="{{$orderproduct->id}}"
                                                    data-toggle="modal"
                                                    data-target="#orderproductRemoveModal">
                                                <i class="fa fa-trash"></i>
                                                حذف
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-warning m-btn m-btn--icon m-btn--wide mt-sweetalert"
                                            id="detachOrderproducts" disabled data-title="آیا مطمئن هستید؟"
                                            data-type="warning" data-allow-outside-click="true"
                                            data-show-confirm-button="true" data-show-cancel-button="true"
                                            data-cancel-button-class="btn-danger" data-cancel-button-text="خیر"
                                            data-confirm-button-text="بله" data-confirm-button-class="btn-info">
                                        ساختن سفارش از انتخاب شده ها
                                    </button>
                                    <button class="btn btn-primary m-btn m-btn--icon m-btn--wide"
                                            id="orderproductExchangeButton" data-toggle="modal"
                                            data-target="#orderproductExchange" disabled="">
                                        تعویض آیتم های انتخاب شده
                                    </button>
                                    
                                    <!--begin::Modal-->
                                    <div class="modal fade" id="orderproductExchange" tabindex="-1" role="dialog"
                                         aria-labelledby="orderproductExchangeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="orderproductExchangeModalLabel">تعویض
                                                        آیتم های انتخاب شده</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                {!! Form::open(['action' => ['Web\OrderController@exchangeOrderproduct' , $order] , 'method'=>'POST' ,'class'=>'form-horizontal form-row-seperated']) !!}
                                                <div class="modal-body">
                                                    <div class="form-body">
                                                        @foreach($order->orderproducts as $orderproduct)
                                                            <div class="row orderproductDiv"
                                                                 id="orderproductDiv_{{$orderproduct->id}}"
                                                                 style="display: none">
                                                                <div class="col-md-4">
                                                                    محصول فعلی:
                                                                    <text class="form-control-static m--font-info">{{$orderproduct->product->name}}</text>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    پرداخت شده:
                                                                    <text class="form-control-static m--font-info"
                                                                          id="orderproductExchangeOriginalCost_{{$orderproduct->id}}">{{$orderproduct->obtainOrderproductCost(true)["final"]}}</text>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="row">
                                                                        <label class="col-md-4 control-label ">
                                                                            محصول جدید
                                                                        </label>
                                                                        <div class="col-md-8">
                                                                            @include("admin.filters.productsFilter" , [ "listType"=>"childSelect" , "selectType"=>"searchable", "name"=>"exchange-a[".$orderproduct->id."][orderproductExchangeNewProduct]" , "class"=>"orderproductExchangeNewProductSelect" , "dataRole"=>$orderproduct->id , "defaultValue"=>["value"=>0 , "caption"=>"انتخاب کنید"]])
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div>
                                                                        {!! Form::text('exchange-a['.$orderproduct->id.'][orderproductExchangeNewCost]',null,['class' => 'orderproductExchangeNewCost form-control' ,'id' =>'orderproductExchangeNewCost_'.$orderproduct->id  , 'disabled', 'dir'=>'ltr' , 'data-role'=>$orderproduct->id , 'placeholder'=>'قیمت جدید' ]) !!}
                                                                    </div>
                                                                    <div>
                                                                        {!! Form::text('exchange-a['.$orderproduct->id.'][orderproductExchangeNewDiscountAmount]',null,['class' => 'orderproductExchangeNewDiscountAmount form-control' ,'id' =>'orderproductExchangeNewDiscountAmount_'.$orderproduct->id  , 'disabled', 'dir'=>'ltr' , 'placeholder'=>'تخفیف جدید' ]) !!}
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <hr>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <h4 class="bold text-center">
                                                                    بدهی به کاربر:
                                                                    <span id="orderproductExchangeDebt">0</span>
                                                                    تومان
                                                                </h4>
                                                            </div>
                                                            <div class="col-12">
                                                                <hr>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mt-repeater">
                                                                    <div data-repeater-list="exchange-b">
                                                                        <div data-repeater-item
                                                                             class="mt-repeater-item mt-overflow">
                                                                            {{--<label class="control-label"></label>--}}
                                                                            <div class="mt-repeater-cell">
                                                                                <div class="row">
                                                                                    <div class="col-md-7">
                                                                                        @include("admin.filters.productsFilter" , ["listType"=>"childSelect", "name"=>"newOrderproductProduct" , "class"=>"orderproductExchange-newOrderproductProduct" , "defaultValue"=>["value"=>0 , "caption"=>"انتخاب کنید"]])
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        {!! Form::text('neworderproductCost',null,['class' => 'form-control neworderproductCost'  , 'dir'=>'ltr' ]) !!}
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                        <a href="javascript:"
                                                                                           data-repeater-delete
                                                                                           class="m--padding-5 a--full-width btn btn-danger m-btn m-btn--icon mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
                                                                                            <i class="flaticon-delete"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <a href="javascript:" data-repeater-create
                                                                       class="btn btn-success mt-repeater-add">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6"
                                                                 style="   border-right: #eeeeef solid 1px;">
                                                                <div class="mt-checkbox-list">
                                                                    <label class="mt-checkbox mt-checkbox-outline">
                                                                        <input name="orderproductExchangeTransacctionCheckbox"
                                                                               class="icheck" value="1" type="checkbox"
                                                                               id="orderproductExchangeTransacctionCheckbox">
                                                                        ثبت تراکنش
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                                <fieldset id="orderproductExchangeTransacction"
                                                                          disabled>
                                                                    @include("transaction.form" , ["transactionPaymentmethods"=>$offlineTransactionPaymentMethods , "excluded"=>["authority" , "paycheckNumber" , "order_id" , "deadline_at" , "completed_at" ] , "defaultValues"=>["transactionstatus"=>config("constants.TRANSACTION_STATUS_SUCCESSFUL")] , "id"=>["cost"=>"orderproductExchangeTransactionCost"] ])
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">بستن
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">ذخیره</button>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Modal-->
                                
                                </div>
                            </div>
                            <hr>
                            <h4 class="bold">آیتم های افزوده سفارش</h4>
                            <span class="form-control-feedback m--font-danger"> قیمت این آیتم ها به قیمت کل سبد اضافه می شود</span>
                            <ul>
                                @foreach($order->orderproducts as $orderproduct)
                                    @if($orderproduct->attributevalues->where("pivot.extraCost" , ">" , "0")->isNotEmpty())
                                        @foreach($orderproduct->attributevalues->where("pivot.extraCost" , ">" , "0") as $attributevalue)
                                            <li>{{$attributevalue->name}}
                                                : {{number_format($attributevalue->pivot->extraCost)}} تومان
                                            </li>
                                        @endforeach
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="tab-pane" id="portlet_tab3" role="tabpanel">
                            <div class="alert alert-success alert-dismissible fade show removeTransactionSuccess d-none" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                تراکنش با موفقیت اصلاح شد
                            </div>
                            <div class="alert alert-danger alert-dismissible fade show removeTransactionError d-none" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                <span></span>
                            </div>
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="btn-group">
                                            {{--@permission((config('constants.INSERT_USER_ACCESS')))--}}
                                            <a class="btn m-btn--air btn-info m--margin-bottom-10 insertTransaction-button"
                                               data-toggle="modal" href="#responsive-transaction">
                                                <i class="fa fa-plus"></i>
                                                افزودن تراکنش
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                                    
                                    <thead>
                                        <tr>
                                            <th class="d-none"></th>
                                            <th> روش پرداخت</th>
                                            <th>درگاه</th>
                                            <th> وضعیت تراکنش</th>
                                            <th> تراکنش والد</th>
                                            <th> مبلغ(تومان)</th>
                                            <th> شماره تراکنش</th>
                                            <th> شماره مرجع</th>
                                            <th> شماره پیگیری</th>
                                            <th> شماره چک</th>
                                            <th> توضیح مدیریتی</th>
                                            <th> اصلاح</th>
                                            <th> حذف</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orderTransactions as $transaction)
                                        <tr id="{{$transaction->id}}">
                                            <td class="d-none">
                                                {{$transaction->id}}
                                            </td>
                                            <td>
                                                @if(isset($transaction->paymentmethod->displayName[0]))
                                                    {{$transaction->paymentmethod->displayName}}
                                                @else
                                                    <span class="m-badge m-badge--wide label-sm m-badge--danger"> ندارد </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($transaction->transactiongateway))
                                                    {{ $transaction->transactiongateway->displayName }}
                                                @else
                                                    <span class="m-badge m-badge--wide label-sm m-badge--info">بدون درگاه</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($transaction->transactionstatus->id))
                                                    {{$transaction->transactionstatus->displayName}}
                                                @else
                                                    <span class="m-badge m-badge--wide label-sm m-badge--warning"> ندارد </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($transaction->hasParents())
                                                    <a target="_blank"
                                                       href="{{action('Web\TransactionController@edit' , $transaction->getGrandParent())}}">
                                                        رفتن به تراکنش
                                                    </a>
                                                @else
                                                    ندارد
                                                @endif
                                            </td>
                                            <td id="transactionFullName_{{$transaction->id}}" dir="ltr">
                                                @if(isset($transaction->cost))
                                                    {{number_format($transaction->cost)}}
                                                @else
                                                    <span class="m-badge m-badge--wide label-sm m-badge--danger"> ندارد </span>
                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                @if(strlen($transaction->transactionID)>0)
                                                    {{$transaction->transactionID}}
                                                @else
                                                    <span class="m-badge m-badge--wide label-sm m-badge--info"> ندارد </span>
                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                @if(strlen($transaction->referenceNumber)>0)
                                                    {{$transaction->referenceNumber}}
                                                @else
                                                    <span class="m-badge m-badge--wide label-sm m-badge--info"> ندارد </span>
                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                @if(strlen($transaction->traceNumber)>0)
                                                    {{$transaction->traceNumber}}
                                                @else
                                                    <span class="m-badge m-badge--wide label-sm m-badge--info "> ندارد </span>
                                                @endif
                                            </td>
                                            <td style="text-align: center">@if(strlen($transaction->paycheckNumber)>0){{$transaction->paycheckNumber}} @else
                                                    <span class="m-badge m-badge--wide label-sm m-badge--info "> ندارد </span> @endif
                                            </td>
                                            <td style="text-align: center">@if(strlen($transaction->managerComment)>0){{$transaction->managerComment}} @else
                                                    <span class="m-badge m-badge--wide label-sm m-badge--info "> ندارد </span> @endif
                                            </td>
                                            <td style="text-align: center">
                                                <a class="edit" href="javascript:">
                                                    <i class="flaticon-edit m--font-success" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                            <td style="text-align: center">
                                                <a class="deleteTransaction"
                                                   data-target="#deleteTransactionConfirmationModal" data-toggle="modal">
                                                    <i class="fa fa-trash fa-lg m--font-danger" aria-hidden="true"></i>
                                                </a>
                                                <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="portlet_tab4" role="tabpanel">
                            <div class="alert alert-success alert-dismissible fade show removeTransactionSuccess d-none" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                تراکنش با موفقیت اصلاح شد
                            </div>
                            <div class="alert alert-danger alert-dismissible fade show removeTransactionError d-none" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                <span></span>
                            </div>
{{--                            <div class="table-toolbar">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-6">--}}
{{--                                        <div class="btn-group">--}}
{{--                                            --}}{{--@permission((config('constants.INSERT_USER_ACCESS')))--}}
{{--                                            <a class="btn m-btn--air btn-info m--margin-bottom-10 insertTransaction-button"--}}
{{--                                               data-toggle="modal" href="#responsive-transaction">--}}
{{--                                                <i class="fa fa-plus"></i>--}}
{{--                                                افزودن تراکنش--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered" id="sample_editable_2">
                                    <thead>
                                        <tr>
                                            <th class="d-none"></th>
                                            <th> روش پرداخت</th>
                                            <th>درگاه</th>
                                            <th> وضعیت تراکنش</th>
                                            <th> تراکنش والد</th>
                                            <th> مبلغ(تومان)</th>
                                            <th> شماره تراکنش</th>
                                            <th> شماره مرجع</th>
                                            <th> شماره پیگیری</th>
                                            <th> شماره چک</th>
                                            <th> توضیح مدیریتی</th>
                                            <th> اصلاح</th>
                                            <th> حذف</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($totalTransactions as $transaction)
                                            <tr id="{{$transaction->id}}">
                                                <td class="d-none">
                                                    {{$transaction->id}}
                                                </td>
                                                <td>
                                                    @if(isset($transaction->paymentmethod->displayName[0]))
                                                        {{$transaction->paymentmethod->displayName}}
                                                    @else
                                                        <span class="m-badge m-badge--wide label-sm m-badge--danger"> ندارد </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($transaction->transactiongateway))
                                                        {{ $transaction->transactiongateway->displayName }}
                                                    @else
                                                        <span class="m-badge m-badge--wide label-sm m-badge--info">بدون درگاه</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($transaction->transactionstatus->id))
                                                        {{$transaction->transactionstatus->displayName}}
                                                    @else
                                                        <span class="m-badge m-badge--wide label-sm m-badge--warning"> ندارد </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($transaction->hasParents())
                                                        <a target="_blank"
                                                           href="{{action('Web\TransactionController@edit' , $transaction->getGrandParent())}}">
                                                            رفتن به تراکنش
                                                        </a>
                                                    @else
                                                        ندارد
                                                    @endif
                                                </td>
                                                <td id="transactionFullName_{{$transaction->id}}" dir="ltr">
                                                    @if(isset($transaction->cost))
                                                        {{number_format($transaction->cost)}}
                                                    @else
                                                        <span class="m-badge m-badge--wide label-sm m-badge--danger"> ندارد </span>
                                                    @endif
                                                </td>
                                                <td style="text-align: center">
                                                    @if(strlen($transaction->transactionID)>0)
                                                        {{$transaction->transactionID}}
                                                    @else
                                                        <span class="m-badge m-badge--wide label-sm m-badge--info"> ندارد </span>
                                                    @endif
                                                </td>
                                                <td style="text-align: center">
                                                    @if(strlen($transaction->referenceNumber)>0)
                                                        {{$transaction->referenceNumber}}
                                                    @else
                                                        <span class="m-badge m-badge--wide label-sm m-badge--info"> ندارد </span>
                                                    @endif
                                                </td>
                                                <td style="text-align: center">
                                                    @if(strlen($transaction->traceNumber)>0)
                                                        {{$transaction->traceNumber}}
                                                    @else
                                                        <span class="m-badge m-badge--wide label-sm m-badge--info "> ندارد </span>
                                                    @endif
                                                </td>
                                                <td style="text-align: center">
                                                    @if(strlen($transaction->paycheckNumber)>0)
                                                        {{$transaction->paycheckNumber}}
                                                    @else
                                                        <span class="m-badge m-badge--wide label-sm m-badge--info "> ندارد </span>
                                                    @endif
                                                </td>
                                                <td style="text-align: center">
                                                    @if(strlen($transaction->managerComment)>0)
                                                        {{$transaction->managerComment}}
                                                    @else
                                                        <span class="m-badge m-badge--wide label-sm m-badge--info "> ندارد </span>
                                                    @endif
                                                </td>
                                                <td style="text-align: center">
                                                    <a href="{{ action('Web\TransactionController@edit', $transaction) }}" target="_blank">
                                                        <i class="flaticon-edit m--font-success" aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                                <td style="text-align: center">
                                                    <a class="deleteTransaction"
                                                       data-target="#deleteTransactionConfirmationModal" data-toggle="modal">
                                                        <i class="fa fa-trash fa-lg m--font-danger" aria-hidden="true"></i>
                                                    </a>
                                                    <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="portlet_tab5" role="tabpanel">
                            <table class="table table-striped table-bordered table-hover table-checkable order-column"
                                   id="sample_1">
                                <thead>
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        <i class="fa fa-cart-arrow-down"></i>
                                        نام محصول
                                    </th>
                                    <th class="hidden-xs">
                                        <i class="fa fa-question"></i>
                                        ویژگی ها
                                    </th>
                                    <th>
                                        <i class="fa fa-dollar"></i>
                                        قیمت تمام شده به تومان (با در نظر گرفتن تخفیف ها)
                                    </th>
                                    <th>
                                        <i class="fa fa-dollar"></i>
                                        قیمت محصول به تومان(در زمان خرید)
                                    </th>
                                    <th>
                                        <i class="fa fa-percent"></i>
                                        تخفیف بن
                                    </th>
                                    <th>
                                        <i class="fa fa-percent"></i>
                                        تخفیف محصول
                                    </th>
                                    <th>
                                        <i class="fa fa-dollar"></i>
                                        مبلغ تخفیف داده شده(تومان)
                                    </th>
                                    @if(isset($order->coupon->id))
                                        <th>
                                            <i class="fa fa-percent"></i>
                                            مشمول کپن؟
                                        </th>
                                    @endif
                                    <th>
                                        <i class="fa fa-dollar"></i>
                                        وضعیت تسویه
                                    </th>
                                    <th>
                                        تاریخ ایجاد
                                    </th>
                                    <th>
                                        تاریخ ویرایش
                                    </th>
                                    <th>
                                        تاریخ حذف
                                    </th>
                                    <th>
                                        <i class="fa fa-cogs"></i>
                                        عملیات
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
            
                                @foreach($order->orderproducts()->withTrashed()->get() as $orderproduct)
                                    <tr class="odd gradeX">
                                        <td>
                                            {{ $orderproduct->id }}
                                        </td>
                                        <td>
                                            <a target="_blank"
                                               href="@if($orderproduct->product->hasParents()) {{action("Web\ProductController@show" , $orderproduct->product->parents->first())}}@else {{action("Web\ProductController@show" , $orderproduct->product)}} @endif"> {{$orderproduct->product->name}} </a>
                                        </td>
                                        <td class="hidden-xs">
                                            @if($order->orderproducts)
                                                @if(isset($orderproduct->product->id))
                                                    @foreach($orderproduct->product->attributevalues('main')->get() as $attributevalue)
                                                        <span class="bold">{{$attributevalue->attribute->displayName}}</span>
                                                        : {{$attributevalue->name}} @if(isset(   $attributevalue->pivot->description) && strlen($attributevalue->pivot->description)>0 ) {{$attributevalue->pivot->description}} @endif
                                                        <br>
                                                    @endforeach
                                                    @foreach($orderproduct->attributevalues as $extraAttributevalue)
                                                        <span class="bold">{{$extraAttributevalue->attribute->displayName}}</span>
                                                        :{{$extraAttributevalue->name}}
                                                        (+ {{number_format($extraAttributevalue->pivot->extraCost)}}
                                                        تومان)
                                                        <br>
                                                    @endforeach
                                                    <br>
                                                @endif
                                            @else
                                                <span class="m-badge m-badge--wide m-badge--danger">ندارد</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($orderproduct->product->isFree)
                                                رایگان
                                            @else
                                                {{number_format($orderproduct->price['final'])}}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            {{number_format($orderproduct->price['base'])}}
                                        </td>
                                        <td class="text-center">
                                            {{$orderproduct->userbons->sum("pivot.usageNumber")}} بن
                                            <span class="m-badge m-badge--wide label-sm m-badge--info label-mini"> {{$orderproduct->getTotalBonDiscountPercentage()}}
                                                % </span>
                                        </td>
                                        <td class="text-center">
                                            {{$orderproduct->discountPercentage}}%
                                        </td>
                                        <td class="text-center">
                                            {{$orderproduct->discountAmount}}
                                        </td>
                                        @if(isset($order->coupon->id))
                                            <td class="text-center">
                                                @if($orderproduct->includedInCoupon)
                                                    بله
                                                @else
                                                    خیر
                                                @endif
                                            </td>
                                        @endif
                                        <td class="text-center">
                                            @if(isset($orderproduct->checkoutstatus_id))
                                                {{$orderproduct->checkoutstatus->displayName}}
                                            @else
                                                نامشخص
                                            @endif
                                        </td>
                                        <td class="needConvertToJalali">
                                            {{ $orderproduct->created_at }}
                                        </td>
                                        <td class="needConvertToJalali">
                                            {{ $orderproduct->updated_at }}
                                        </td>
                                        <td class="needConvertToJalali">
                                            {{ $orderproduct->deleted_at }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{action("Web\OrderproductController@edit" , $orderproduct)}}"
                                               class="btn blue btn-sm btn-outline sbold uppercase">
                                                <i class="fa fa-pencil-square-o"></i>
                                                اصلاح
                                            </a>
                                            <button class="btn red btn-sm btn-outline sbold removeOrderproduct"
                                                    id="orderProductId_{{$orderproduct->id}}"
                                                    data-order-product-id="{{$orderproduct->id}}"
                                                    data-toggle="modal"
                                                    data-target="#orderproductRemoveModal">
                                                <i class="fa fa-trash"></i>
                                                حذف
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="portlet_tab6" role="tabpanel">
                            
                            @if($orderArchivedTransactions->isNotEmpty())
                                <table class="table table-striped table-hover table-bordered" id="">
                                    <div id="deleteTransactionConfirmationModal" class="modal fade" tabindex="-1"
                                         data-backdrop="static" data-keyboard="false">
                                        <div class="modal-header">حذف تراکنش
                                            <span id="deleteTransactionFullName"></span>
                                        </div>
                                        <div class="modal-body">
                                            <p> آیا مطمئن هستید؟</p>
                                            {!! Form::hidden('transaction_id', null) !!}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" data-dismiss="modal" class="btn btn-outline dark">
                                                خیر
                                            </button>
                                            <button type="button" data-dismiss="modal" class="btn green"
                                                    onclick="removeTransaction()">بله
                                            </button>
                                        </div>
                                    </div>
                                    <thead>
                                    <tr>
                                        <th> روش پرداخت</th>
                                        <th> وضعیت تراکنش</th>
                                        <th> تراکنش پدر</th>
                                        <th> مبلغ(تومان)</th>
                                        <th> شماره تراکنش</th>
                                        <th> شماره مرجع</th>
                                        <th> شماره پیگیری</th>
                                        <th> شماره چک</th>
                                        <th> توضیح مدیریتی</th>
                                        <th> اصلاح</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orderArchivedTransactions as $transaction)
                                        <tr id="{{$transaction->id}}">
                                            <td>@if(strlen($transaction->paymentmethod->displayName)>0){{$transaction->paymentmethod->displayName}} @else
                                                    <span class="m-badge m-badge--wide label-sm m-badge--danger"> ندارد </span> @endif
                                            </td>
                                            <td>@if(isset($transaction->transactionstatus->id)){{$transaction->transactionstatus->displayName}} @else
                                                    <span class="m-badge m-badge--wide label-sm m-badge--warning"> ندارد </span> @endif
                                            </td>
                                            <td>@if($transaction->hasParents())
                                                    <a target="_blank"
                                                       href="{{action('Web\TransactionController@edit' , $transaction->getGrandParent())}}">رفتن
                                                        به تراکنش</a> @else ندارد @endif
                                            </td>
                                            <td id="transactionFullName_{{$transaction->id}}"
                                                dir="ltr">@if(isset($transaction->cost)){{number_format($transaction->cost)}} @else
                                                    <span class="m-badge m-badge--wide label-sm m-badge--danger"> ندارد </span> @endif
                                            </td>
                                            <td style="text-align: center">@if(strlen($transaction->transactionID)>0){{$transaction->transactionID}} @else
                                                    <span class="m-badge m-badge--wide label-sm m-badge--info"> ندارد </span> @endif
                                            </td>
                                            <td style="text-align: center">@if(strlen($transaction->referenceNumber)>0){{$transaction->referenceNumber}} @else
                                                    <span class="m-badge m-badge--wide label-sm m-badge--info"> ندارد </span> @endif
                                            </td>
                                            <td style="text-align: center">@if(strlen($transaction->traceNumber)>0){{$transaction->traceNumber}} @else
                                                    <span class="m-badge m-badge--wide label-sm m-badge--info "> ندارد </span> @endif
                                            </td>
                                            <td style="text-align: center">@if(strlen($transaction->paycheckNumber)>0){{$transaction->paycheckNumber}} @else
                                                    <span class="m-badge m-badge--wide label-sm m-badge--info "> ندارد </span> @endif
                                            </td>
                                            <td style="text-align: center">@if(strlen($transaction->managerComment)>0){{$transaction->managerComment}} @else
                                                    <span class="m-badge m-badge--wide label-sm m-badge--info "> ندارد </span> @endif
                                            </td>
                                            <td style="text-align: center">
                                                <a target="_blank" class="edit"
                                                   href="{{action("Web\TransactionController@edit" , $transaction)}}">
                                                    <i class="fa fa-pencil-square fa-lg font-green"
                                                       aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
    </div>
@endsection


@section('page-js')
    
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/datatable.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
    {{--<script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>--}}
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
{{--    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>--}}
    <script src="/acm/extra/persian-datepicker/lib/persian-date.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/jQueryNumberFormat/jquery.number.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/app.js" type="text/javascript"></script>
    
    {{--<script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js" type="text/javascript"></script>--}}
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-repeater/jquery.repeater.min.js" type="text/javascript"></script>
    
{{--    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-extended-modals.min.js" type="text/javascript"></script>--}}
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-toastr.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-multi-select.min.js" type="text/javascript"></script>
    <script src="/acm/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-bootstrap-multiselect.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-confirmations.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/makeSelect2Single.js" type="text/javascript"></script>
    
    {{--<script src="/acm/AlaatvCustomFiles/js/admin/page-ordersAdmin.js" type="text/javascript"></script>--}}
    {{--<script src="/acm/AlaatvCustomFiles/js/admin/makeDataTable.js" type="text/javascript"></script>--}}
    {{--<script src="/acm/AlaatvCustomFiles/js/admin-makeMultiSelect.js" type="text/javascript"></script>--}}
    
    
    <script type="text/javascript">


        convertElementContentToJalali('.needConvertToJalali');
        function convertElementContentToJalali(elementQuerySelect) {
            $(elementQuerySelect).each(function () {
                var content = $(this).html().trim();
                if (content === '') {
                    return true;
                }
                var unixDate = new Date(content).getTime();
                var jalaliDateObject = new persianDate(unixDate);
                var jalaliDateTime = jalaliDateObject.format("YYYY/M/D HH:m:s");
                $(this).html(jalaliDateTime);
            });
        }
        
        $('select.select2')
            .select2({closeOnSelect: true})
            .on('select2:select', function (event) {
                $('select.select2').select2("close");
            })
            .on('select2:close', function (event) {
                $('select.select2').select2('destroy');
                $('select.select2').select2({closeOnSelect: true});
                $('select.select2').select2("close");
                $('select.select2').select2("close");
            });
        
        
        var TableDatatablesEditable = function () {

            var handleTable = function () {

                function restoreRow(oTable, nRow) {
                    var aData = oTable.fnGetData(nRow);
                    var jqTds = $('>td', nRow);

                    for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                        oTable.fnUpdate(aData[i], nRow, i, false);
                    }

                    oTable.fnDraw();
                }

                function editRow(oTable, nRow) {
                    var aData = oTable.fnGetData(nRow);
                    var jqTds = $('>td', nRow);
//                    console.log(aData);
                    if (aData.length > 2) {
                        var i;
                        for (i = 0; i < aData.length - 2; i++) {
                            if (aData[i].includes("ندارد"))
                                aData[i] = "";
                            if (i <= 1) {
                                jqTds[i].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[i] + '" disabled>';
                            } else {
                                jqTds[i].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[i] + '">';
                            }

                        }
                        jqTds[i].innerHTML = '<a class="edit"  href="">ذخیره</a>';
                        jqTds[++i].innerHTML = '<a class="cancel" href="">لغو</a>';
                    }
                }

                function saveRow(oTable, nRow) {
                    var jqInputs = $('input', nRow);
                    // var newData = [jqInputs.context.id];
                    var newData = [];
                    if (jqInputs.length > 0) {
                        let i = 0;
                        for (; i < jqInputs.length; i++) {
                            newData.push(jqInputs[i].value);
                            oTable.fnUpdate(jqInputs[i].value, nRow, i, false);
                        }
                        oTable.fnUpdate('<a class="edit" href="javascript:;"><i class="fa fa-pencil-square fa-lg font-green" aria-hidden="true"></i></a>', nRow, i, false);
                        oTable.fnUpdate('<a class="deleteTransaction"  data-target="#deleteTransactionConfirmationModal" data-toggle="modal"><i class="fa fa-trash fa-lg m--font-danger" aria-hidden="true"></i></a>', nRow, ++i, false);
                    }
                    oTable.fnDraw();
                    updateRow(newData);
                }

                function cancelEditRow(oTable, nRow) {
                    var jqInputs = $('input', nRow);
                    oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                    oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                    oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
                    oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
                    oTable.fnUpdate('<a class="edit" href="">اصلاح</a>', nRow, 4, false);
                    oTable.fnDraw();
                }

                var table = $('#sample_editable_1');
                var table_totalTransaction = $('#sample_editable_2');

                let datatableConfig = {

                    // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                    // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js).
                    // So when dropdowns used the scrollable div should be removed.
                    //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

                    "lengthMenu": [
                        [5, 15, 20, -1],
                        [5, 15, 20, "All"] // change per page values here
                    ],

                    // Or you can use remote translation file
                    //"language": {
                    //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
                    //},

                    // set the initial value
                    "pageLength": 5,

                    "language": {
                        "lengthMenu": " _MENU_ رکوردها"
                    },
                    "columnDefs": [{ // set default column settings
                        'orderable': true,
                        'targets': [0]
                    }, {
                        "searchable": true,
                        "targets": [0]
                    }],
                    "order": [
                        [0, "asc"]
                    ] // set first column as a default sort by asc
                };
                var oTable = table.dataTable(datatableConfig);
                var oTable_totalTransaction = table_totalTransaction.dataTable(datatableConfig);

                var nEditing = null;
                var nNew = false;

                var nEditing_totalTransaction = null;
                var nNew_totalTransaction = false;

                $('#sample_editable_1_new').click(function (e) {
                    e.preventDefault();

                    if (nNew && nEditing) {
                        if (confirm("سطر قبلی ذخیره نشده است ، آیا می خواهید آن را ذخیره کنید؟")) {
                            saveRow(oTable, nEditing); // save
                            $(nEditing).find("td:first").html("بدون عنوان");
                            nEditing = null;
                            nNew = false;

                        } else {
                            oTable.fnDeleteRow(nEditing); // cancel
                            nEditing = null;
                            nNew = false;

                            return;
                        }
                    }

                    var aiNew = oTable.fnAddData(['', '', '', '', '', '']);
                    var nRow = oTable.fnGetNodes(aiNew[0]);
                    editRow(oTable, nRow);
                    nEditing = nRow;
                    nNew = true;
                });

                table.on('click', '.delete', function (e) {
                    e.preventDefault();

                    if (confirm("آیا از حذف سطر مطمئن هستید ?") == false) {
                        return;
                    }

                    var nRow = $(this).parents('tr')[0];
                    oTable.fnDeleteRow(nRow);
                    alert("سطر حذف شد ! حال باید آن را از پایگاه داده حذف کنید");
                });

                table.on('click', '.cancel', function (e) {
                    e.preventDefault();
                    if (nNew) {
                        oTable.fnDeleteRow(nEditing);
                        nEditing = null;
                        nNew = false;
                    } else {
                        restoreRow(oTable, nEditing);
                        nEditing = null;
                    }
                });

                table.on('click', '.edit', function (e) {
                    console.log('edit clicked');
                    e.preventDefault();
                    nNew = false;

                    /* Get the row as a parent of the link that was clicked on */
                    var nRow = $(this).parents('tr')[0];

                    if (nEditing !== null && nEditing != nRow) {
                        /* Currently editing - but not this row - restore the old before continuing to edit mode */
                        restoreRow(oTable, nEditing);
                        editRow(oTable, nRow);
                        nEditing = nRow;
                    } else if (nEditing == nRow && this.innerHTML == "ذخیره") {
                        /* Editing this row and want to save it */
                        saveRow(oTable, nEditing);
                        nEditing = null;
//                        alert("اصلاح انجام شد! حال باید پایگاه داده را اصلاح کنید");
                    } else {
                        /* No edit in progress - let's start one */
                        editRow(oTable, nRow);
                        nEditing = nRow;
                    }
                });
                
                table_totalTransaction.on('click', '.delete', function (e) {
                    
                    console.log('hji');
                    e.preventDefault();

                    if (confirm("آیا از حذف سطر مطمئن هستید ?") == false) {
                        return;
                    }

                    var nRow = $(this).parents('tr')[0];
                    oTable_totalTransaction.fnDeleteRow(nRow);
                    alert("سطر حذف شد ! حال باید آن را از پایگاه داده حذف کنید");
                });
                
            };

            return {

                //main function to initiate the module
                init: function () {
                    handleTable();
                }

            };

        }();
        var FormRepeater = function () {

            return {
                //main function to initiate the module
                init: function () {
                    $('.mt-repeater').each(function () {
                        $(this).repeater({
                            show: function () {
                                var elements = $(this).find(':input');

                                var matches = elements.attr("name").match(/\[[^\]]+\]/g);
                                if (matches === null) {
                                    return true;
                                }
                                matches = matches[0].match(/(\d+)/);
                                var id = matches[0];

                                $.each(elements, function (index, value) {
                                    var matches = $(value).attr("name").match(/\[[^\]]+\]/g);
                                    if (matches === null) {
                                        return true;
                                    }
                                    var name = matches[matches.length - 1].replace(/\[|\]/g, '');
                                    $(value).attr("id", name + "_" + id);
                                    $(value).attr("data-role", id);
                                });

                                $(this).slideDown();
                            },

                            hide: function (deleteElement) {
                                if (confirm('آیا مطمئن هستید؟')) {
                                    $(this).slideUp(deleteElement);
                                }
                            },

                            ready: function (setIndexes) {
                                var elements = $(".mt-repeater-item.mt-overflow").find(':input');

                                var matches = elements.attr("name").match(/\[[^\]]+\]/g);
                                if (matches === null) {
                                    return true;
                                }
                                matches = matches[0].match(/(\d+)/);
                                var id = matches[0];


                                $.each(elements, function (index, value) {
                                    var matches = $(value).attr("name").match(/\[[^\]]+\]/g);
                                    if (matches === null) {
                                        return true;
                                    }
                                    var name = matches[matches.length - 1].replace(/\[|\]/g, '');
                                    $(value).attr("id", name + "_" + id);
                                    $(value).attr("data-role", id);
                                });
                            }
                        });
                    });
                }

            };

        }();

        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': window.Laravel.csrfToken,
                }
            });
        });

        function paymentMethodState(element) {
            if (element.val() == "online") {
                $('input[name="referenceNumber"]').attr('disabled', true);
                $('input[name="authority"]').attr('disabled', false);
                $('input[name="traceNumber"]').attr('disabled', true);
                $('input[name="paycheckNumber"]').attr('disabled', true);
            } else if (element.val() == "cash") {
                $('input[name="referenceNumber"]').attr('disabled', true);
                $('input[name="authority"]').attr('disabled', true);
                $('input[name="traceNumber"]').attr('disabled', true);
                $('input[name="paycheckNumber"]').attr('disabled', true);
            } else if (element.val() == "paycheck") {
                $('input[name="referenceNumber"]').attr('disabled', true);
                $('input[name="authority"]').attr('disabled', true);
                $('input[name="traceNumber"]').attr('disabled', true);
                $('input[name="paycheckNumber"]').attr('disabled', false);
            } else {
                $('input[name="referenceNumber"]').attr('disabled', false);
                $('input[name="authority"]').attr('disabled', true);
                $('input[name="traceNumber"]').attr('disabled', false);
                $('input[name="paycheckNumber"]').attr('disabled', true);
            }
        }

        function transactionStatusState(element) {
            if (element.val() == {{config("constants.TRANSACTION_STATUS_UNPAID")}}) {
                $('#transactionDeadlineAt').attr('disabled', false);
                $('#transactionDeadlineAtAlt').attr('disabled', false);
                $('#transactionCompletedAt').attr('disabled', true);
                $('#transactionCompletedAtAlt').attr('disabled', true);
                $('#paymentMethodName').attr('disabled', true);
                $('input[name="referenceNumber"]').attr('disabled', true);
                $('input[name="authority"]').attr('disabled', true);
                $('input[name="traceNumber"]').attr('disabled', true);
                $('input[name="paycheckNumber"]').attr('disabled', true);
            } else {
                $('#transactionDeadlineAt').attr('disabled', true);
                $('#transactionDeadlineAtAlt').attr('disabled', true);
                $('#transactionCompletedAt').attr('disabled', false);
                $('#transactionCompletedAtAlt').attr('disabled', false);
                $('#paymentMethodName').attr('disabled', false);
                // paymentMethodState($('#paymentMethodName'));
                $('input[name="referenceNumber"]').attr('disabled', false);
                $('input[name="authority"]').attr('disabled', false);
                $('input[name="traceNumber"]').attr('disabled', false);
                $('input[name="paycheckNumber"]').attr('disabled', false);
            }
        }

        jQuery(document).ready(function () {
            TableDatatablesEditable.init();
            FormRepeater.init();
            SweetAlert.init();
            
            @if(strcmp(Session::pull("validationFailed") , "insertTransaction")==0 && !$errors->isEmpty())
            $(".insertTransaction-button").trigger("click");
            @endif

            $("#transactionDeadlineAt").persianDatepicker({
                altField: '#transactionDeadlineAtAlt',
                altFormat: "YYYY MM DD",
                observer: true,
                format: 'YYYY-MM-DD',
                altFieldFormatter: function (unixDate) {
                    // var d = new Date(unixDate).toISOString();
                    let targetDatetime = new Date(unixDate);
                    let formatted_date = targetDatetime.getFullYear() + "-" + (targetDatetime.getMonth() + 1) + "-" + targetDatetime.getDate();
                    return formatted_date;
                }
            });

            $("#transactionCompletedAt").persianDatepicker({
                altField: '#transactionCompletedAtAlt',
                altFormat: "YYYY-MM-DD",
                observer: true,
                format: 'YYYY/MM/DD',
                altFieldFormatter: function (unixDate) {
                    // var d = new Date(unixDate).toISOString();
                    let targetDatetime = new Date(unixDate);
                    let formatted_date = targetDatetime.getFullYear() + "-" + (targetDatetime.getMonth() + 1) + "-" + targetDatetime.getDate();
                    return formatted_date;
                }
            });

            // paymentMethodState($('#paymentMethodName'));
            transactionStatusState($("#transactionstatus_id"));
            
        });
        
        $(document).on("change", "#enableBonPlus", function () {
            if (this.checked) {
                $('input[name="bonPlus"]').attr('disabled', false);
            } else {
                $('input[name="bonPlus"]').attr('disabled', true);
            }
        });

        $(document).on("click", ".deleteTransaction", function () {
            var transaction_id = $(this).closest('tr').attr('id');
            $("input[name=transaction_id]").val(transaction_id);
            $("#deleteTransactionFullName").text($("#transactionFullName_" + transaction_id).text());
        });

        function removeTransaction() {
            var transaction_id = $("input[name=transaction_id]").val();
            $.ajax({
                type: 'POST',
                url: '/transaction/' + transaction_id,
                data: {_method: 'delete'},
                success: function (result) {
                    // console.log(result);
                    // console.log(result.responseText);
                    location.reload();
                },
                error: function (result) {
//                     console.log(result);
//                     console.log(result.responseText);
                }
            });
        }

        function updateRow(newData) {
            console.log('newData: ', newData);
            var transaction_id = $("input[name=transaction_id]").val();
            $.ajax({
                type: 'PUT',
                url: '/transaction/' + newData[0],
                data: {
                    cost: newData[5],
                    transactionID: newData[6],
                    referenceNumber: newData[7],
                    traceNumber: newData[8],
                    paycheckNumber: newData[9],
                    managerComment: newData[10]
                },
                success: function (result) {
                    $(".removeTransactionSuccess").removeClass("d-none");
                   location.reload();
                },
                error: function (result) {
                    $(".removeTransactionError").removeClass("d-none");
                    $(".removeTransactionError > span").html(result.responseText);
                    // console.log(JSON.parse(result.responseText));
                    console.log(result.responseText);
                    // console.log(result.responseText);
                }
            });
        }

        $('#changeProduct').click(function () {
            if ($('#changeProduct').prop('checked') == true) {
                $('#productSelect').attr('disabled', false);
            } else {
                $('#productSelect').attr('disabled', true);
            }
        });

        $(document).on("change", ".paymentMethodName", function () {

            // paymentMethodState($(this));
        });

        $(document).on("change", "#transactionstatus_id", function () {

            transactionStatusState($(this));
        });

        $(document).on("click", ".removeOrderproduct", function () {
            let orderProductId = $(this).data('order-product-id');
            $('input[type="hidden"][name="orderProductIdForRemove"]').val(orderProductId);
        });
        
        $(document).on("click", ".btnRemoveOrderproductInModal", function () {
            let orderProductId = $('input[type="hidden"][name="orderProductIdForRemove"]').val();
            $.ajax({
                type: "DELETE",
                url: '/orderproduct/' + orderProductId,
                data: {_token: "{{ csrf_token() }}"},
                statusCode: {
                    //The status for when action was successful
                    200: function (response) {
                        // console.log(response);
                        location.reload();
                    },
                    //The status for when the user is not authorized for making the request
                    403: function (response) {
                        window.location.replace("/403");
                    },
                    //The status for when the user is not authorized for making the request
                    401: function (response) {
                        window.location.replace("/403");
                    },
                    //Method Not Allowed
                    405: function (response) {
//                        console.log(response);
//                        console.log(response.responseText);
                        location.reload();
                    },
                    404: function (response) {
                        window.location.replace("/404");
                    },
                    //The status for when form data is not valid
                    422: function (response) {
                        // console.log(response);
                    },
                    //The status for when there is error php code
                    500: function (response) {
                        // console.log(response.responseText);
//                            toastr["error"]("خطای برنامه!", "پیام سیستم");
                    },
                    //The status for when there is error php code
                    503: function (response) {
                        toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
                    }
                }
            });
        });

        var TableDatatablesManaged = function () {

            var initTable1 = function () {

                var table = $('#sample_1');

                // begin first table
                table.dataTable({

                    // Internationalisation. For more info refer to http://datatables.net/manual/i18n
                    "language": {
                        "aria": {
                            "sortAscending": ": activate to sort column ascending",
                            "sortDescending": ": activate to sort column descending"
                        },
                        "emptyTable": "داده ای برای نمایش وجود ندارد",
                        "info": "نمایش _START_ تا    _END_ از _TOTAL_ داده",
                        "infoEmpty": "داده ای یافت نشد",
                        "infoFiltered": "(filtered1 from _MAX_ total records)",
                        "lengthMenu": "نمایش _MENU_",
                        "search": "Search:",
                        "zeroRecords": "No matching records found",
                        "paginate": {
                            "previous": "Prev",
                            "next": "Next",
                            "last": "Last",
                            "first": "First"
                        }
                    },
                    "paging": false,
                    "searching": false,
                    // Or you can use remote translation file
                    //"language": {
                    //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
                    //},

                    // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                    // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js).
                    // So when dropdowns used the scrollable div should be removed.
                    //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

                    "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

                    "lengthMenu": [
                        [5, 15, 20, -1],
                        [5, 15, 20, "All"] // change per page values here
                    ],
                    // set the initial value
                    "pageLength": 5,
                    "pagingType": "bootstrap_full_number",
                    "columnDefs": [
                        {  // set default column settings
                            'orderable': false,
                            'targets': [0]
                        },
                        {
                            "searchable": false,
                            "targets": [0]
                        },
                        {
                            "className": "dt-right",
                            //"targets": [2]
                        }
                    ],
                    "order": [
                        [1, "asc"]
                    ] // set first column as a default sort by asc
                });

                var tableWrapper = jQuery('#sample_1_wrapper');

                table.find('.group-checkable').change(function () {
                    var set = jQuery(this).attr("data-set");
                    var checked = jQuery(this).is(":checked");
                    jQuery(set).each(function () {
                        if (checked) {
                            $(this).prop("checked", true);
                            $(this).parents('tr').addClass("active");
                        } else {
                            $(this).prop("checked", false);
                            $(this).parents('tr').removeClass("active");
                        }
                    });
                });

                table.on('change', 'tbody tr .checkboxes', function () {
                    $(this).parents('tr').toggleClass("active");
                    var ck_box = $('.checkboxes:checked').length;
                    if (ck_box == 0) {
                        $("#detachOrderproducts").prop('disabled', true);
                        $("#orderproductExchangeButton").prop('disabled', true);
                    } else {
                        $("#detachOrderproducts").prop('disabled', false);
                        $("#orderproductExchangeButton").prop('disabled', false);
                    }

                });
            };

            return {

                //main function to initiate the module
                init: function () {
                    if (!jQuery().dataTable) {
                        return;
                    }

                    initTable1();
                }

            };

        }();

        if (App.isAngularJsApp() === false) {
            jQuery(document).ready(function () {
                TableDatatablesManaged.init();
            });
        }

        var detachOrderproductAjax;
        var SweetAlert = function () {

            return {
                //main function to initiate the module
                init: function () {
                    $('.mt-sweetalert').each(function () {
                        var sa_title = $(this).data('title');
                        var sa_message = $(this).data('message');
                        var sa_type = $(this).data('type');
                        var sa_allowOutsideClick = $(this).data('allow-outside-click');
                        var sa_showConfirmButton = $(this).data('show-confirm-button');
                        var sa_showCancelButton = $(this).data('show-cancel-button');
                        var sa_closeOnConfirm = $(this).data('close-on-confirm');
                        var sa_closeOnCancel = $(this).data('close-on-cancel');
                        var sa_confirmButtonText = $(this).data('confirm-button-text');
                        var sa_cancelButtonText = $(this).data('cancel-button-text');
                        var sa_popupTitleSuccess = $(this).data('popup-title-success');
                        var sa_popupMessageSuccess = $(this).data('popup-message-success');
                        var sa_popupTitleCancel = $(this).data('popup-title-cancel');
                        var sa_popupMessageCancel = $(this).data('popup-message-cancel');
                        var sa_confirmButtonClass = $(this).data('confirm-button-class');
                        var sa_cancelButtonClass = $(this).data('cancel-button-class');

                        $(this).click(function () {
                            //console.log(sa_btnClass);
                            swal({
                                    title: sa_title,
                                    text: sa_message,
                                    type: sa_type,
                                    allowOutsideClick: sa_allowOutsideClick,
                                    showConfirmButton: sa_showConfirmButton,
                                    showCancelButton: sa_showCancelButton,
                                    confirmButtonClass: sa_confirmButtonClass,
                                    cancelButtonClass: sa_cancelButtonClass,
                                    closeOnConfirm: sa_closeOnConfirm,
                                    closeOnCancel: sa_closeOnCancel,
                                    confirmButtonText: sa_confirmButtonText,
                                    cancelButtonText: sa_cancelButtonText,
                                },
                                function (isConfirm) {
                                    if (isConfirm) {
                                        var orderproductIds = $("input[name='orderproductsCheckbox[]']:checked").map(function () {
                                            return $(this).val();
                                        }).get();
                                        if (detachOrderproductAjax) {
                                            detachOrderproductAjax.abort();
                                        }
                                        toastr.options = {
                                            "closeButton": true,
                                            "debug": false,
                                            "positionClass": "toast-top-center",
                                            "onclick": null,
                                            "showDuration": "1000",
                                            "hideDuration": "1000",
                                            "timeOut": "5000",
                                            "extendedTimeOut": "1000",
                                            "showEasing": "swing",
                                            "hideEasing": "linear",
                                            "showMethod": "fadeIn",
                                            "hideMethod": "fadeOut"
                                        };
                                        detachOrderproductAjax = $.ajax({
                                            type: "POST",
                                            url: "{{action('Web\OrderController@detachOrderproduct')}}",
                                            data: {orderproducts: orderproductIds, order:{{$order->id}}  },
                                            statusCode: {
                                                200: function (response) {
                                                    console.log('detachOrderproductAjax: ', response);
                                                    // console.log($.parseJSON(response.responseText)) ;
                                                    location.reload();
                                                },
                                                //The status for when the user is not authorized for making the request
                                                401: function (ressponse) {
                                                    location.reload();
                                                },
                                                403: function (response) {
                                                    window.location.replace("/403");
                                                },
                                                404: function (response) {
                                                    window.location.replace("/404");
                                                },
                                                //The status for when form data is not valid
                                                422: function (response) {
                                                    //
                                                },
                                                //The status for when there is error php code
                                                500: function (response) {
                                                    console.log(response.responseText);
                                                },
                                                //The status for when there is error php code
                                                503: function (response) {
                                                    toastr["error"]($.parseJSON(response.responseText).message, "پیام سیستم");
                                                }
                                            }
                                        });
                                        // swal(sa_popupTitleSuccess, sa_popupMessageSuccess, "success");
                                    } else {
                                        // swal(sa_popupTitleCancel, sa_popupMessageCancel, "error");
                                    }
                                });
                        });
                    });

                }
            }

        }();

        function obtainDebt() {
            var debt = 0;
            $('.orderproductExchangeNewCost').each(function (i, obj) {
                var orderproduct = $(this).data("role");
                var originalCost = $("#orderproductExchangeOriginalCost_" + orderproduct).text();
                var newCost = $(this).val();
                if (newCost.length > 0)
                    debt = debt + (parseInt(originalCost) - parseInt(newCost));
            });
            $('.orderproductExchangeNewDiscountAmount').each(function (i, obj) {
                var newDiscountAmount = $(this).val();
                if (newDiscountAmount.length > 0)
                    debt = parseInt(debt) + parseInt(newDiscountAmount);
            });
            $('.neworderproductCost').each(function (i, obj) {
                var newCost = $(this).val();
                if (newCost.length > 0)
                    debt = debt - newCost;
            });

            var transactionCost = $("#orderproductExchangeTransactionCost").val();
            if (transactionCost.length > 0) debt = debt - parseInt(transactionCost);
            if (debt < 0) $("#orderproductExchangeDebt").css("color", "red");
            else $("#orderproductExchangeDebt").css("color", "black");
            return debt;
        }

        $(document).on("click", "#orderproductExchangeButton", function () {
            var orderproductIds = $("input[name='orderproductsCheckbox[]']:checked").map(function () {
                return $(this).val();
            }).get();

            $(".orderproductDiv").hide();
            $(".orderproductDiv :input").attr("disabled", true);

            $.each(orderproductIds, function (index, value) {
                $("#orderproductDiv_" + value).show();
                $("#orderproductDiv_" + value + " :input").attr("disabled", false);
            });

        });


        $(document).on("change", ".orderproductExchangeNewProductSelect", function () {
            var orderproduct = $(this).data("role");
            if ($(this).find(':selected').val() != 0) {
                var cost = $(this).find(':selected').data('content');
                $("#orderproductExchangeNewCost_" + orderproduct).val(cost);
            } else {
                $("#orderproductExchangeNewCost_" + orderproduct).val(null);
            }

            var debt = obtainDebt();
            if (debt < 0)
                $("#orderproductExchangeDebt").text(obtainDebt()).number(true).append("-");
            else
                $("#orderproductExchangeDebt").text(obtainDebt()).number(true);
        });

        $('.orderproductExchangeNewCost').on('input', function (e) {
            var debt = obtainDebt();
            if (debt < 0)
                $("#orderproductExchangeDebt").text(obtainDebt()).number(true).append("-");
            else
                $("#orderproductExchangeDebt").text(obtainDebt()).number(true);
        });

        $('.orderproductExchangeNewDiscountAmount').on('input', function (e) {
            var debt = obtainDebt();
            if (debt < 0)
                $("#orderproductExchangeDebt").text(obtainDebt()).number(true).append("-");
            else
                $("#orderproductExchangeDebt").text(obtainDebt()).number(true);
        });

        $(document).on("change", ".orderproductExchange-newOrderproductProduct", function () {
            var orderproduct = $(this).data("role");
            if ($(this).find(':selected').val() != 0) {
                var cost = $(this).find(':selected').data('content');
                $("#neworderproductCost_" + orderproduct).val(cost);
            } else {
                $("#neworderproductCost_" + orderproduct).val(null);
            }
            var debt = obtainDebt();
            if (debt < 0)
                $("#orderproductExchangeDebt").text(obtainDebt()).number(true).append("-");
            else
                $("#orderproductExchangeDebt").text(obtainDebt()).number(true);
        });

        $('.neworderproductCost').on('input', function (e) {
            var debt = obtainDebt();
            if (debt < 0)
                $("#orderproductExchangeDebt").text(obtainDebt()).number(true).append("-");
            else
                $("#orderproductExchangeDebt").text(obtainDebt()).number(true);
        });

        $("#orderproductExchangeTransactionCost").on('input', function (e) {
            var debt = obtainDebt();
            if (debt < 0)
                $("#orderproductExchangeDebt").text(obtainDebt()).number(true).append("-");
            else
                $("#orderproductExchangeDebt").text(obtainDebt()).number(true);
        });

        $("#orderproductExchangeTransacctionCheckbox").on('change', function (e) {
            if ($(this).is(':checked')) {
                $("#orderproductExchangeTransacction").prop("disabled", false);
            } else {
                $("#orderproductExchangeTransacction").prop("disabled", true);
            }
        });
    
    </script>

@endsection

@endpermission
