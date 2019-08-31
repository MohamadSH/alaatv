@permission((config('constants.SHOW_ORDER_ACCESS')))

@extends("app",["pageName"=>"admin"])

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home m--padding-right-5"></i>
                <a class="m-link" href="{{route('web.index')}}">@lang('page.Home')</a>
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
    {{--Ajax modal loaded after inserting content--}}
    <div id = "ajax-modal" class = "modal fade" tabindex = "-1"></div>
    {{--Ajax modal for panel startup --}}

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
                                    آیتم های پاک شده سفارش
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#portlet_tab4" role="tab">
                                    <i class="flaticon-coins"></i>
                                    تراکنش های موفق سفارش
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#portlet_tab5" role="tab">
                                    <i class="flaticon-coins"></i>
                                    کل تراکنش های سفارش
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

                                @foreach($orderproducts as $orderproduct)
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
                                               class="btn btn-primary btn-sm btn-outline sbold uppercase">
                                                <i class="fa fa-pencil-square-o"></i>
                                                اصلاح
                                            </a>
                                            <button class="btn btn-danger btn-sm btn-outline sbold removeOrderproduct"
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
                            <!--begin::Modal-->
                            <div class="modal fade" id="orderproductRecycleModal" tabindex="-1" role="dialog"
                                 aria-labelledby="orderproductExchangeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                بازگردانی محصول سفارش
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="orderProductIdForRecycle" value="">
                                            <input type="hidden" name="orderProductRestoreActionUrl" value="">
                                            آیا اطمینان دارید؟
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">خیر
                                            </button>
                                            <button type="submit" class="btn btn-primary btnRecycleOrderproductInModal">بله</button>
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

                                @foreach($trashedOrderproducts as $orderproduct)
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
                                               class="btn btn-primary btn-sm btn-outline sbold uppercase">
                                                <i class="fa fa-pencil-square-o"></i>
                                                اصلاح
                                            </a>
                                            @if(strlen($orderproduct->deleted_at)>0)
                                                <button class="btn btn-danger btn-sm btn-outline sbold recycleOrderproduct"
                                                        id="orderProductId_{{$orderproduct->id}}"
                                                        data-order-product-id="{{$orderproduct->id}}"
                                                        data-toggle="modal"
                                                        data-target="#orderproductRecycleModal"
                                                        data-action="{{route('web.orderproduct.restore')}}">
                                                    <i class="fa fa-recycle"></i>
                                                    بازگردانی
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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
                                                    اصلاح
                                                </a>
                                            </td>
                                            <td style="text-align: center">
                                                <a class="deleteTransaction"
                                                   data-target="#deleteTransactionConfirmationModal" data-toggle="modal">
                                                    <i class="fa fa-trash fa-lg m--font-danger" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="portlet_tab5" role="tabpanel">

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
                                                    اصلاح
                                                </a>
                                            </td>
                                            <td style="text-align: center">
                                                <a class="deleteTransaction"
                                                   data-target="#deleteTransactionConfirmationModal" data-toggle="modal">
                                                    <i class="fa fa-trash fa-lg m--font-danger" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

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

    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        var TRANSACTION_STATUS_UNPAID = {{ config("constants.TRANSACTION_STATUS_UNPAID") }};
        var csrf_token = '{{ csrf_token() }}';
        var actionUrl_detachOrderproduct = '{{action('Web\OrderController@detachOrderproduct')}}';
        var order_id = {{$order->id}};
    </script>
    <script src="{{ asset('/acm/AlaatvCustomFiles/js/admin/page-order-edit.js') }}" type="text/javascript"></script>

    @if(strcmp(Session::pull("validationFailed") , "insertTransaction")==0 && !$errors->isEmpty())
    <script type="text/javascript">
        jQuery(document).ready(function () {
            $(".insertTransaction-button").trigger("click");
        });
    </script>
    @endif

@endsection

@endpermission
