@extends('partials.templatePage',['pageName'=>$pageName])

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home m--padding-right-5"></i>
{{--                <a class="m-link" href="{{route('web.index')}}">@lang('page.Home')</a>--}}
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#">پنل مدیریت بلاک ها</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')

    @include("systemMessage.flash")

    <div class="row">
        <div class="col">
            <!-- BEGIN BLOCK TABLE PORTLET-->
            <div class="m-portlet m-portlet--head-solid-bg m-portlet--accent m-portlet--head-sm" m-portlet="true" id="block-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                مدیریت بلاک ها
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <img class="d-none" id="block-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" alt="loading" style="width: 50px;">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                    <i class="fa fa-redo-alt"></i>
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
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a id="sample_editable_4_new" class="btn btn-info m-btn m-btn--icon m-btn--wide" data-toggle="modal" href="#responsive-block" data-target="#responsive-block">
                                        <i class="fa fa-plus"></i>
                                        افزودن بلاک
                                    </a>
                                    <!--begin::Modal-->
                                    <div class="modal fade" id="responsive-block" tabindex="-1" role="dialog" aria-labelledby="responsive-blockModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                {!! Form::open(['files'=>true,'method' => 'POST','action' => ['Web\BlockController@store'], 'class'=>'nobottommargin' , 'id'=>'blockForm']) !!}
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="responsive-blockModalLabel">افزودن بلاک جدید</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col">
                                                            @include('block.form' )
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                                    <button type="submit" class="btn btn-primary" id="blockForm-submit">ذخیره</button>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Modal-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--begin::Modal-->
                    <div class="modal fade" id="copyBlockModal" tabindex="-1" role="dialog" aria-labelledby="copyBlockModalModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="copyBlockModalModalLabel"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h4 class="modal-title">آیا برای کپی مطمئن هستید؟</h4>
                                    <input type="hidden" id="blockIdForCopy" value="">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">خیر</button>
                                    <button type="button" class="btn btn-primary" onclick="copyBlockInModal()">بله</button>
                                    <img class="d-none" id="copy-block-loading-image" src="{{config('constants.FILTER_LOADING_GIF')}}" alt="loading" height="25px" width="25px">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->

                    <!--begin::Modal-->
                    <div class="modal fade" id="removeBlockModal" tabindex="-1" role="dialog" aria-labelledby="removeBlockModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="removeBlockModalLabel"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h4 class="modal-title">
                                        آیا از حذف این بلاک اطمینان دارید؟
                                    </h4>
                                    <input type="hidden" id="block-removeLink" value="removeLink">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">خیر</button>
                                    <button type="submit" class="btn btn-primary btnRemoveBlockInModal" onclick="removeBlock()">بله</button>
                                    <img class="d-none" id="remove-block-loading-image" src="{{config('constants.FILTER_LOADING_GIF')}}" alt="loading" height="25px" width="25px">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->

                    <!--begin::Modal-->
                    <div class="modal fade" id="showBlockPhotoInModal" tabindex="-1" role="dialog" aria-labelledby="showBlockPhotoInModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="showBlockPhotoInModalLabel"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <img src="" alt="" class="a--full-width">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->


                    <!--begin::Modal-->
                    <div class="modal fade" id="static-longDescription" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-body">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->

                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="block_table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>#</th>
                                <th>عنوان</th>
                                <th>ترتیب</th>
                                <th>نوع</th>
                                <th>تعداد پیشنهادها</th>
                                <th>تعداد محتوا</th>
                                <th>تعداد دسته ها</th>
                                <th>تعداد محصولات</th>
                                <th>تعداد بنرها</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                        {{--Loading by ajax--}}
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/acm/AlaatvCustomFiles/js/admin/page-blockAdmin.js') }}" type="text/javascript"></script>
@endsection
