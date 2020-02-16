@permission((config('constants.LIST_ORDER_ACCESS')))
@extends('partials.templatePage',['pageName'=>$pageName])

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .transactionItem {
            box-shadow: 0px 0px 10px 0px #A4AFFC;
            padding: 10px;
            margin: 5px;
            border-radius: 15px;
        }
        .Transaction_Total_Report {
            font-size: 14px;
            font-weight: bold;
        }

        .multiselect-native-select, .mt-multiselect {
            width: 100%;
        }
        #filterOrderForm .form-group {
            border-top: solid 1px #cecece;
            padding-top: 10px;
        }
        #filterOrderForm .form-group:first-child {
            border: none;
            padding-top: 0;
        }

    </style>
@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">پنل مدیریت سفاش ها</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col">

            <div class="m-portlet m-portlet--creative m-portlet--bordered-semi profileMenuPage profileMenuPage-filmVaJozve">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                تسویه حساب
                            </h3>
                        </div>
                    </div>

                </div>
                <div class="m-portlet__body">

                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <div class="m-divider m--margin-top-50">
                                    <span></span>
                                    <span>انتخاب محصول</span>
                                    <span></span>
                                </div>
                                <select class="mt-multiselect btn btn-default a--full-width"
                                        multiple="multiple"
                                        data-label="left"
                                        data-width="100%"
                                        data-filter="true"
                                        data-height="200"
                                        id="productId"
                                        name="product_id"
                                        title="انتخاب دسته">
                                    <option value="0"
                                            class="bold">
                                        هر محصولی
                                    </option>
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}"
                                                class="bold">
                                            #{{$product->id}}-{{$product->name}}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <div class="m-divider m--margin-top-50">
                                    <span></span>
                                    <span>وضعیت تسویه</span>
                                    <span></span>
                                </div>
                                <select class="mt-multiselect btn btn-default a--full-width"
                                        {{--                                  multiple="multiple"--}}
                                        data-label="left"
                                        data-width="100%"
                                        data-filter="true"
                                        data-height="200"
                                        id="checkoutStatus"
                                        name="checkoutStatus"
                                        title="وضعیت تسویه">
                                    @foreach($checkoutStatuses as $key => $checkoutStatus)
                                        <option value="{{$key}}" class="bold">
                                            {{$checkoutStatus}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 bold control-label">فیلتر تاریخ ثبت نهایی سفارش: </label>
                            <div class="col-md-10">
                                @include('admin.filters.timeFilter.createdAt' , ["id" => "dateFilter"])
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                                <label class = "control-label" style = "float: right;">
                                    <label class = "mt-checkbox mt-checkbox-outline">
                                        در هنگام فیلتر تسویه کن
                                        <input type = "checkbox" id = "checkoutEnable" value = "1" name = "checkoutEnable">
                                        <span class = "bg-grey-cararra"></span>
                                    </label>
                                </label>
                        </div>
                    </div>

                    <button type="button" class="btn m-btn--pill m-btn--air btn-info btnFilter">فیلتر</button>

                    <div class="reportOfFilter">
                        <span class="m-badge m-badge--info m-badge--wide m-badge--rounded report1">

                        </span>
                        <br>
                        <span class="report2">

                        </span>
                        <br>
                        <span class="report3">

                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script type="text/javascript">
        var ajaxActionUrl = '{{ $ajaxActionUrl }}';
    </script>
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/acm/AlaatvCustomFiles/js/admin/page-sales-report-v2.js') }}"
            type="text/javascript"></script>
@endsection
@endability
