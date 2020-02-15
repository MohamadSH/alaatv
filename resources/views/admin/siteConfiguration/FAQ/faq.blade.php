@extends('app')

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
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#">پیکربندی سایت</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <!-- PORTLET MAIN -->
        @include("partials.siteConfigurationSideBar" , ["section"=>"faq"])
        <!-- END PORTLET MAIN -->
        </div>
    </div>
    <div class="row">
        <div class="col">

            @include("systemMessage.flash")

            {!! Form::open(['files' => true , 'method' => 'POST' , 'url' => [route('web.setting.faq.update' , $setting)] , 'class'=>'form-horizontal']) !!}
            <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                افزودن سؤال
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    @include('admin.siteConfiguration.FAQ.form')
                    {!! Form::submit('ذخیره' , ['class' => 'btn m-btn--pill btn-success m--margin-left-15']) !!}
                </div>
            </div>
            {!! Form::close() !!}

            <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                جدول سؤالات
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%">
                        <thead>
                        <tr>
                            <th>ترتیب</th>
                            <th>عنوان</th>
                            <th>متن</th>
                            <th>فیلم</th>
                            <th>عکس</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(empty($faqs))
                            <tr style="text-align:center">
                                <td colspan="6">اطلاعاتی برای نمایش وجود ندارد</td>
                            </tr>
                        @else
                            @foreach($faqs as $faq)
                                <tr>
                                    <td>{{$faq->order}}</td>
                                    <td>@if(isset($faq->title)) {{$faq->title}} @else <span
                                            class="m-badge m-badge--danger m-badge--wide">ندارد</span>  @endif</td>
                                    <td>@if(isset($faq->body)) {{$faq->body}} @else <span
                                            class="m-badge m-badge--danger m-badge--wide">ندارد</span>  @endif</td>
                                    <td>@if(isset($faq->video)) <a target="_blank"
                                                                   href="{{$faq->video}}">{{$faq->video}}</a> @else
                                            <span class="m-badge m-badge--danger m-badge--wide">ندارد</span>  @endif
                                    </td>
                                    <td>@if(isset($faq->photo)) <a target="_blank"
                                                                   href="{{\App\Websitesetting::getFaqPhoto($faq)}}"><img
                                                width="250" height="100"
                                                src="{{\App\Websitesetting::getFaqPhoto($faq)}}"
                                                alt="عکس {{$faq->title}}"></a> @else <span
                                            class="m-badge m-badge--danger m-badge--wide">ندارد</span>  @endif</td>
                                    <td>
                                        <ul>
                                            <li><a target="_blank"
                                                   href="{{route('web.setting.faq.edit' , ['Websitesetting'=>$setting , 'faqId'=>$faq->id])}}">اصلاح</a>
                                            </li>
                                            <li><a href="#"
                                                   onclick="deleteFaq('{{route('web.setting.faq.delete' , ['Websitesetting'=>$setting , 'faqId'=>$faq->id])}}');">حذف</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script>
        function deleteFaq(url) {
            $.ajax({
                type: 'POST',
                url: url,
                data: {_method: 'delete'},
                statusCode: {
                    //The status for when action was successful
                    200: function (response) {
                        toastr["success"]("سؤال با موفقیت حذف شد!", "پیام سیستم");
                        window.location.reload();
                    },
                    500: function (response) {
                        toastr["error"]("سؤال با موفقیت حذف شد!", "پیام سیستم");
                    },
                },
            });
        }
    </script>
@endsection
