@extends('app',['pageName'=>'admin'])

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
                <a class="m-link" href="{{action("Web\AdminController@adminProduct")}}">پنل مدیریتی محصولات</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#">اصلاح اطلاعات محصول</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a class="m-link" href="@if($product->hasParents()) {{action("Web\ProductController@edit" , $product->parents->first())}} @else{{action("Web\AdminController@adminProduct")}}@endif">
                    بازگشت
                </a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')

    @include("systemMessage.flash")

    <div class="row">
        <div class="col-md-6">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                اصلاح اطلاعات
                                <a class="m-link" href="{{action("Web\ProductController@show" , $product)}}">{{$product->name}}</a>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-portlet__body-progress">Loading</div>
                    {!! Form::model($product,['files'=>true,'method' => 'PUT','action' => ['Web\ProductController@update',$product], 'class'=>'form-horizontal']) !!}
                        @include('product.form' )
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->
        </div>

{{--        @permission((config('constants.LIST_PRODUCT_FILE_ACCESS')))--}}
        <div class="col-md-6 ">
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    @if($product->producttype->id == config("constants.PRODUCT_TYPE_CONFIGURABLE"))
                                        پیکربندی محصول ٬
                                    @endif
                                    <a href="{{action("Web\ProductController@show" , $product)}}">{{$product->name}}</a>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">نام</th>
                                <th class="text-center">مشاهده</th>
                                <th class="text-center">ویرایش</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if($sets->isEmpty())
                                    <tr style="text-align: center;">
                                        <td colspan="3">ندارد</td>
                                    </tr>
                                @else
                                    @foreach($sets as $set)
                                        <tr>
                                            <td>{{ $set->name }}</td>
                                            <td>
                                                <a target="_blank" href="{{ action('Web\SetController@indexContent', $set->id) }}" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
                                                    <i class="flaticon-medical"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a target="_blank" href="{{ action('Web\SetController@edit', $set->id) }}" class="btn btn-warning m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
                                                    <i class="flaticon-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
{{--        @endpermission--}}

        @if($product->hasChildren())
        <div class="col-md-6 ">
        @permission((config('constants.LIST_CONFIGURE_PRODUCT_ACCESS')))
                @include('product.partials.configureTableForm')
        @endpermission
        </div>
        @endif

        <div class="col-md-12">
        <!-- BEGIN BLOCK TABLE PORTLET-->
        <div class="m-portlet m-portlet--head-solid-bg m-portlet--accent m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="liveDescription-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                        <i class="fa fa-cogs"></i>
                    </span>
                        <h3 class="m-portlet__head-text">
                            بلاک ها
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="fa fa-angle-down"></i>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="block-expand">
                                <i class="fa fa-expand-arrows-alt"></i>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="fa fa-times"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                @include('product.partials.productBlock' )
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
        </div>

        <div class="col-md-12">
        @permission((config('constants.LIST_LIVE_DESCRIPTION_ACCESS')))
        <!-- BEGIN LIVE DESCRIPTION TABLE PORTLET-->
        <div class="m-portlet m-portlet--head-solid-bg m-portlet--accent m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="productFiles-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                        <i class="fa fa-cogs"></i>
                    </span>
                        <h3 class="m-portlet__head-text">
                            توضیحات لحظه ای
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="fa fa-angle-down"></i>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="liveDescription-expand">
                                <i class="fa fa-expand-arrows-alt"></i>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="fa fa-times"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                {!! Form::open(['method'=>'POST' , 'route'=>'livedescription.store']) !!}
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                <div class = "form-group">
                    <input type="text" name="title" placeholder="عنوان">
                </div>
                <div class = "form-group">
                    <textarea id="productLiveDescriptionSummerNote" name="description" placeholder="توضیح"></textarea>
                </div>
                    <input type="submit" value="ذخیره">
                {!! Form::close() !!}
                <hr>
                @if($liveDescriptions->isNotEmpty())
                    <ul>
                        @foreach($liveDescriptions as $liveDescription)
                            <li>
                                <h5  style="font-weight: bolder"><span style="color:red;text-decoration: underline">عنوان: </span>{{$liveDescription->title}}</h5>
                                <p  style="font-size:1.2rem ; direction: ltr"><span style="color:red;text-decoration: underline">تاریخ : </span>{{$liveDescription->CreatedAt_Jalali_WithTime()}}</p>
                                <p style="font-size:1.2rem"><span style="color:red;text-decoration: underline">توضیح :</span> {!! $liveDescription->description !!}</p>
                                <a class="btn btn-accent" target="_blank" href="{{route('livedescription.edit' , $liveDescription)}}">اصلاح</a>
                                <a  href="#" class="btn btn-danger removeLiveDescription" data-action="{{route('livedescription.destroy' , $liveDescription)}}" >حذف</a>
                            </li>
                            <hr>
                        @endforeach
                    </ul>
                @else
                    <h4>اطلاعاتی برای نمایش وجود ندارد</h4>
                @endif
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
        @endpermission
        </div>

        <div class="col-md-12">
        @permission((config('constants.LIST_PERIOD_DESCRIPTION_ACCESS')))
        <!-- BEGIN LIVE DESCRIPTION TABLE PORTLET-->
        <div class="m-portlet m-portlet--head-solid-bg m-portlet--accent m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="periodDescription-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                        <i class="fa fa-cogs"></i>
                    </span>
                        <h3 class="m-portlet__head-text">
                            توضیحات بازه ای
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="fa fa-angle-down"></i>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="periodDescription-expand">
                                <i class="fa fa-expand-arrows-alt"></i>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="fa fa-times"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                {!! Form::open(['method'=>'POST' , 'route'=>'periodDescription.store']) !!}
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                <div class = "form-group">
                    <input id = "periodDescriptionSince" type = "text" class = "form-control" value = "" dir = "ltr">
                    <input name = "since" id = "periodDescriptionSinceAlt" type = "text" class = "form-control d-none">
                </div>
                <div class = "form-group">
                    <input id = "periodDescriptionTill" type = "text" class = "form-control" value = "" dir = "ltr">
                    <input name = "till" id = "periodDescriptionTillAlt" type = "text" class = "form-control d-none">
                </div>
                <div class = "form-group">
                    <textarea id="productPeriodDescriptionSummerNote" name="description" placeholder="توضیح"></textarea>
                </div>
                    <input type="submit" value="ذخیره">
                {!! Form::close() !!}
                <hr>
                @if($descriptionsWithPeriod->isNotEmpty())
                    <ul>
                        @foreach($descriptionsWithPeriod as $descriptionWithPeriod)
                            <li>
                                <p  style="font-size:1.2rem ; direction: ltr"><span style="color:red;text-decoration: underline">از تاریخ : </span>{{$descriptionWithPeriod->Since_Jalali()}}</p>
                                <p  style="font-size:1.2rem ; direction: ltr"><span style="color:red;text-decoration: underline">تا تاریخ : </span>{{$descriptionWithPeriod->Until_Jalali()}}</p>
                                <p style="font-size:1.2rem"><span style="color:red;text-decoration: underline">توضیح :</span> {!! $descriptionWithPeriod->description !!}</p>
                                <a class="btn btn-accent" target="_blank" href="{{route('periodDescription.edit' , $descriptionWithPeriod)}}">اصلاح</a>
                                <a  href="#" class="btn btn-danger removePeriodDescription" data-action="{{route('periodDescription.destroy' , $descriptionWithPeriod)}}" >حذف</a>
                            </li>
                            <hr>
                        @endforeach
                    </ul>
                @else
                    <h4>اطلاعاتی برای نمایش وجود ندارد</h4>
                @endif
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
        @endpermission
        </div>

        <div class="col-md-12">
        @permission((config('constants.LIST_PERIOD_DESCRIPTION_ACCESS')))
        <!-- BEGIN LIVE DESCRIPTION TABLE PORTLET-->
        <div class="m-portlet m-portlet--head-solid-bg m-portlet--accent m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="periodDescription-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                        <i class="fa fa-cogs"></i>
                    </span>
                        <h3 class="m-portlet__head-text">
                            سؤالات متدول
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="fa fa-angle-down"></i>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="periodDescription-expand">
                                <i class="fa fa-expand-arrows-alt"></i>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="fa fa-times"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                {!! Form::open(['method'=>'POST' , 'route'=>'faq.store']) !!}
                <input type="hidden" name="product_id" value="{{$product->id}}">
                <div class = "form-group">
                    <input type="text" name="title" placeholder="عنوان">
                </div>
                <div class = "form-group">
                    <textarea id="productFaqSummerNote" name="body" placeholder="توضیح"></textarea>
                </div>
                    <input type="submit" value="ذخیره">
                {!! Form::close() !!}
                <hr>
                @if($faqs->isNotEmpty())
                    <ul>
                        @foreach($faqs as $faq)
                            <li>
                                <h5  style="font-weight: bolder"><span style="color:red;text-decoration: underline">عنوان: </span>{{$faq->title}}</h5>
                                <p style="font-size:1.2rem"><span style="color:red;text-decoration: underline">توضیح :</span> {!! $faq->body !!}</p>
                                <a class="btn btn-accent" target="_blank" href="{{route('faq.edit' , $faq)}}">اصلاح</a>
                                <a  href="#" class="btn btn-danger removeFaq" data-action="{{route('faq.destroy' , $faq)}}" >حذف</a>
                            </li>
                            <hr>
                        @endforeach
                    </ul>
                @else
                    <h4>اطلاعاتی برای نمایش وجود ندارد</h4>
                @endif
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
        @endpermission
        </div>

        <div class="col-md-12">
        <!-- BEGIN PRODUCT TABLE PORTLET-->
        <div class="m-portlet m-portlet--head-solid-bg m-portlet--accent m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="productFiles-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                        <i class="fa fa-cogs"></i>
                    </span>
                        <h3 class="m-portlet__head-text">
                            فایل های محصول
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                <i class="fa fa-redo-alt"></i>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="fa fa-angle-down"></i>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="productFile-expand">
                                <i class="fa fa-expand-arrows-alt"></i>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="fa fa-times"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                @include('product.productFile.index')
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
        </div>

        <div class="col-md-12">
        @permission((config('constants.LIST_PRODUCT_SAMPLE_PHOTO_ACCESS')))
            <!-- BEGIN PRODUCT TABLE PORTLET-->
            <div class="m-portlet m-portlet--head-solid-bg m-portlet--info m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="productPictures-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="fa fa-cogs"></i>
                        </span>
                            <h3 class="m-portlet__head-text">
                                نمونه عکسهای محصول
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                    <i class="fa fa-redo-alt"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="samplePhoto-expand">
                                    <i class="fa fa-expand-arrows-alt"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-times"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    @include('product.samplePhoto.index')
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
        @endpermission
        </div>

        <div class="col-md-12">
        <!-- BEGIN PRODUCT TABLE PORTLET-->
        <div class="m-portlet m-portlet--head-solid-bg m-portlet--primary m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="productComplimentary-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="fa fa-cogs"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            محصولات دوست
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                <i class="fa fa-redo-alt"></i>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="fa fa-angle-down"></i>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="complementaryProduct-expand">
                                <i class="fa fa-expand-arrows-alt"></i>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="fa fa-times"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                @include("product.complimentary")
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
        </div>

        <div class="col-md-12">
        <!-- BEGIN PRODUCT TABLE PORTLET-->
        <div class="m-portlet m-portlet--head-solid-bg m-portlet--success m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="productGift-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="fa fa-cogs"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            محصولات هدیه
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                <i class="fa fa-redo-alt"></i>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="fa fa-angle-down"></i>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="giftProduct-expand">
                                <i class="fa fa-expand-arrows-alt"></i>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="fa fa-times"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                @include("product.gift")
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
        </div>

        <div class="col-md-12">
        <!--begin::Modal-->
        <div class="modal fade" id="removeProductGiftModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {!! Form::open(['action' => ['Web\ProductController@removeGift' , $product] ,'class'=>'form-horizontal' , 'class' => 'removeProductGiftForm']) !!}
                    <div class="modal-body">
                        <p> آیا مطمئن هستید؟</p>
                        {!! Form::hidden('giftId',null) !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">خیر</button>
                        <button type="submit" class="btn btn-primary">بله</button>
                        <img class="hidden" id="remove-product-gift-loading-image" src="{{config('constants.FILTER_LOADING_GIF')}}" alt="loading" height="25px" width="25px">
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <!--end::Modal-->
        </div>

    </div>

@endsection

@section('page-js')
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script>

        function removePhotoShowModal(actionLink, photoAddress) {
            $('#removeProductPhotoActionLink').val(actionLink);
            $('#removeProductPhoto img').attr('src', photoAddress);
            $('#removeProductPhoto').modal('show');
        }

        function iterateTagsArray(tagsFromTree) {

            tagsFromTree = tagsFromTree.flat(1);
            var uniqueTagsFromTree = [...new Set(tagsFromTree)];
            var tagsFromTreeLength = uniqueTagsFromTree.length;
            for (var i = 0; i < tagsFromTreeLength; i++) {
                uniqueTagsFromTree[i] = filterTagString(uniqueTagsFromTree[i]);
            }

            var oldTags = $("input.productTags").tagsinput()[0].itemsArray;
            var oldTagsLength = oldTags.length;
            for (var i = 0; i < oldTagsLength; i++) {
                oldTags[i] = filterTagString(oldTags[i]);
            }

            var newTags = oldTags.concat(uniqueTagsFromTree);
            var uniqueNewTags = [...new Set(newTags)];

            return uniqueNewTags;
        }

        function filterTagString(tagString) {
            tagString = persianJs(tagString).arabicChar().toEnglishNumber().toString();
            tagString = tagString.split(' ').join('_');
            return tagString;
        }

        $("input.productTags").tagsinput({
            tagClass: 'm-badge m-badge--info m-badge--wide m-badge--rounded'
        });
        /**
         * Start up jquery
         */
        jQuery(document).ready(function () {

            $('form.form-horizontal').submit(function(e) {



                var stringTagsFromTree = $('#tagsString').val();
                var tagsArray = iterateTagsArray(JSON.parse(stringTagsFromTree));
                $("input.productTags").tagsinput('removeAll');

                var tagsArrayLength = tagsArray.length;
                for (var i = 0; i < tagsArrayLength; i++) {
                    $("input.productTags").tagsinput('add', tagsArray[i]);
                }

            });

            /*
             validdSince
             */
            $("#productFileValidSince").persianDatepicker({
                altField: '#productFileValidSinceAlt',
                altFormat: "YYYY MM DD",
                observer: true,
                format: 'YYYY/MM/DD',
                altFieldFormatter: function (unixDate) {
                    var d = new Date(unixDate).toISOString();
                    return d;
                }
            });
            $('#productShortDescriptionSummerNote').summernote({
                lang: 'fa-IR',
                height: 300,
                popover: {
                    image: [],
                    link: [],
                    air: []
                },
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'hr']],
                    ['view', ['fullscreen', 'codeview']],
                    ['help', ['help']],
                    ['mybutton', ['multiColumnButton']]
                ],
                buttons: {
                    multiColumnButton: summernoteMultiColumnButton
                }
            });
            $('#productLongDescriptionSummerNote').summernote({
                lang: 'fa-IR',
                height: 300,
                popover: {
                    image: [],
                    link: [],
                    air: []
                },
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'hr']],
                    ['view', ['fullscreen', 'codeview']],
                    ['help', ['help']],
                    ['mybutton', ['multiColumnButton']]
                ],
                buttons: {
                    multiColumnButton: summernoteMultiColumnButton
                }
            });
            $('#productSpecialDescriptionSummerNote').summernote({
                lang: 'fa-IR',
                height: 300,
                popover: {
                    image: [],
                    link: [],
                    air: []
                },
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'hr']],
                    ['view', ['fullscreen', 'codeview']],
                    ['help', ['help']],
                    ['mybutton', ['multiColumnButton']]
                ],
                buttons: {
                    multiColumnButton: summernoteMultiColumnButton
                }
            });

            $('#productLiveDescriptionSummerNote').summernote({
                lang: 'fa-IR',
                height: 300,
                popover: {
                    image: [],
                    link: [],
                    air: []
                },
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'hr']],
                    ['view', ['fullscreen', 'codeview']],
                    ['help', ['help']],
                    ['mybutton', ['multiColumnButton']]
                ],
                buttons: {
                    multiColumnButton: summernoteMultiColumnButton
                }
            });

            $('#productPeriodDescriptionSummerNote').summernote({
                lang: 'fa-IR',
                height: 300,
                popover: {
                    image: [],
                    link: [],
                    air: []
                },
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'hr']],
                    ['view', ['fullscreen', 'codeview']],
                    ['help', ['help']],
                    ['mybutton', ['multiColumnButton']]
                ],
                buttons: {
                    multiColumnButton: summernoteMultiColumnButton
                }
            });

            $('#productFaqSummerNote').summernote({
                lang: 'fa-IR',
                height: 300,
                popover: {
                    image: [],
                    link: [],
                    air: []
                },
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'hr']],
                    ['view', ['fullscreen', 'codeview']],
                    ['help', ['help']],
                    ['mybutton', ['multiColumnButton']]
                ],
                buttons: {
                    multiColumnButton: summernoteMultiColumnButton
                }
            });

            $("#periodDescriptionSince").persianDatepicker({
                altField: '#periodDescriptionSinceAlt',
                altFormat: "YYYY MM DD",
                observer: true,
                format: 'YYYY/MM/DD',
                altFieldFormatter: function (unixDate) {
                    var d = new Date(unixDate).toISOString();
                    d = d.substring(0, d.indexOf('T'));
                    return d;
                }
            });

            $("#periodDescriptionTill").persianDatepicker({
                altField: '#periodDescriptionTillAlt',
                altFormat: "YYYY MM DD",
                observer: true,
                format: 'YYYY/MM/DD',
                altFieldFormatter: function (unixDate) {
                    var d = new Date(unixDate).toISOString();
                    d = d.substring(0, d.indexOf('T'));
                    return d;
                }
            });
        });

        $(document).on('change', '#productFileTypeSelect', function () {
            var lastOrder = $('#lastProductFileOrder_' + $(this).val()).val();
            $('#productFileOrder').val(lastOrder);
        });

        $(document).on('click', '.removeLiveDescription', function () {
            $.ajax({
                type: 'POST',
                url: $(this).data('action'),
                data: {_method:'DELETE'},
                statusCode: {
                    200: function (response) {
                        toastr['success']('توضیح لحظه ای با موفقیت حذف شد', 'پیام سیستم');
                        location.reload();
                    },
                    401: function (ressponse) {
                        toastr['error']('خطای 401', 'پیام سیستم');
                    },
                    403: function (response) {
                        toastr['error']('خطای 403. دسترسی غیرمجاز', 'پیام سیستم');
                    },
                    404: function (response) {
                        toastr['error']('خطای 404. یافت نشد', 'پیام سیستم');
                    },
                    500: function (response) {
                        console.log(response.responseText);
                        toastr['error']('خطای 500 . خطای برنامه!', 'پیام سیستم');
                    },
                    503: function (response) {
                        toastr['error']('خطای 503', 'پیام سیستم');
                    }
                }
            });
        });

        $(document).on('click', '.removePeriodDescription', function () {
            $.ajax({
                type: 'POST',
                url: $(this).data('action'),
                data: {_method:'DELETE'},
                statusCode: {
                    200: function (response) {
                        toastr['success']('توضیح بازه ای با موفقیت حذف شد', 'پیام سیستم');
                        location.reload();
                    },
                    401: function (ressponse) {
                        toastr['error']('خطای 401', 'پیام سیستم');
                    },
                    403: function (response) {
                        toastr['error']('خطای 403. دسترسی غیرمجاز', 'پیام سیستم');
                    },
                    404: function (response) {
                        toastr['error']('خطای 404. یافت نشد', 'پیام سیستم');
                    },
                    500: function (response) {
                        console.log(response.responseText);
                        toastr['error']('خطای 500 . خطای برنامه!', 'پیام سیستم');
                    },
                    503: function (response) {
                        toastr['error']('خطای 503', 'پیام سیستم');
                    }
                }
            });
        });

        $(document).on('click', '.removeFaq', function () {
            $.ajax({
                type: 'POST',
                url: $(this).data('action'),
                data: {_method:'DELETE'},
                statusCode: {
                    200: function (response) {
                        toastr['success']('سوال متداول با موفقیت حذف شد', 'پیام سیستم');
                        location.reload();
                    },
                    401: function (ressponse) {
                        toastr['error']('خطای 401', 'پیام سیستم');
                    },
                    403: function (response) {
                        toastr['error']('خطای 403. دسترسی غیرمجاز', 'پیام سیستم');
                    },
                    404: function (response) {
                        toastr['error']('خطای 404. یافت نشد', 'پیام سیستم');
                    },
                    500: function (response) {
                        console.log(response.responseText);
                        toastr['error']('خطای 500 . خطای برنامه!', 'پیام سیستم');
                    },
                    503: function (response) {
                        toastr['error']('خطای 503', 'پیام سیستم');
                    }
                }
            });
        });
    </script>

    <script src="/acm/AlaatvCustomFiles/js/admin/page-productAdmin.js" type="text/javascript"></script>
@endsection
