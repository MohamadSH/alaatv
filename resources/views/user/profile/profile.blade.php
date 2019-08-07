@extends('app' , ['pageName' => 'profile'])

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#"> پروفایل</a>
            </li>
        </ol>
    </nav>
@endsection

@section('page-css')
    <link href = "{{ mix('/css/user-profile.css') }}" rel = "stylesheet" type = "text/css"/>
@endsection

@section('content')

    @include('systemMessage.flash')

    <div class = "row">
        <div class = "col">
            {{--            Using this notification for some text at the top of the profile page        --}}
            {{--            @include("user.profile.topNotification")--}}

            {{--@include("user.profile.lotteryNotification" , [                                                            "userPoints"=>$userPoints ,--}}
            {{--"lotteryName"=>$lotteryName ,--}}
            {{--"exchangeAmount" => $exchangeAmount ,--}}
            {{--"userLottery" => $userLottery ,--}}
            {{--"prizeCollection" => $prizeCollection,--}}
            {{--"lotteryMessage" => $lotteryMessage,--}}
            {{--"lotteryRank" => $lotteryRank,--}}
            {{--])--}}
        </div>
    </div>

    <div class = "row">
        <div class = "col-md-3">
            <!-- BEGIN PROFILE SIDEBAR -->
        @include('partials.profileSidebar',[
                                        'user'=>$user ,
                                        'withInfoBox'=>true ,
                                        'withCompletionBox'=>true ,
                                        'withRegisterationDate'=>true,
                                        'withNavigation' => true,
                                        'withPhotoUpload' => true ,
                                          ]
                                          )
        <!-- END BEGIN PROFILE SIDEBAR -->
        </div>
        <div class = "col-md-9">
            @if(!$user->lockProfile)
                @include('user.profile.profileEditView' , [
                "withBio"=>true ,
                "withBirthdate"=>false ,
                "withIntroducer"=>false ,
                "text2"=>"کاربر گرامی ، پس از تکمیل تمام اطلاعا پروفایل شما قفل شده و امکان اصلاح اطلاعات وجود نخواهد داشت. لذا خواهشمند هستیم این اطلاعات را در صحت و دقت تکمیل کنید."
                ])
            @else
                @include('user.profile.profileView', ['withBio'=>true])
            @endif
            <div class = "m-portlet m-portlet--creative m-portlet--bordered-semi profileMenuPage profileMenuPage-sabteRotbe">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
						<span class = "m-portlet__head-icon m--hide">
							<i class = "flaticon-statistics"></i>
						</span>
                            <h3 class = "m-portlet__head-text">
                                ثبت کارنامه کنکور سراسری 97
                            </h3>
                            <h2 class = "m-portlet__head-label m-portlet__head-label--success">
                                <span>
                                    <i class = "fa fa-trophy"></i>
                                    ثبت رتبه 97
                                </span>
                            </h2>
                        </div>
                    </div>
                    <div class = "m-portlet__head-tools">

                    </div>
                </div>
                <div class = "m-portlet__body">
                    @if ($errors->any())
                        <div class = "alert alert-danger alert-dismissible fade show" role = "alert">
                            <button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close"></button>
                            <strong>خطا!</strong>
                            {!!  implode('', $errors->all('<div>:message</div>'))  !!}
                        </div>
                    @endif
                    <form method = "POST" id = "frmSabteRotbe" action = "{{ action('Web\EventresultController@store') }}" accept-charset = "UTF-8" enctype = "multipart/form-data">
                        @csrf
                        <input name = "event_id" type = "hidden" value = "3">
                        <input name = "eventresultstatus_id" type = "hidden" value = "1">
                        <div class = "form-body">
                            <div class = "row">
                                <div class = "col-md-12">
                                    <div class = "row">
                                        <div class = "col">
                                            <div class = "form-group m-form__group">
                                                <label for = "rank">
                                                    @if($userKonkurResult!==null)
                                                        رتبه شما
                                                    @else
                                                        رتبه شما(الزامی)
                                                    @endif</label>
                                                <div class = "m-input-icon m-input-icon--left">
                                                    <input type = "text" name = "rank" id = "rank" class = "form-control m-input m-input--air" placeholder = "رتبه شما" @if($userKonkurResult!==null)value = "{{ $userKonkurResult->rank }}" disabled = "disabled"
                                                            @endif
                                                    >
                                                    <span class = "m-input-icon__icon m-input-icon__icon--left">
                                                        <span>
                                                            <i class = "flaticon-placeholder"></i>
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        @if($userKonkurResult===null)
                                            <div class = "col">
                                                <div class = "form-group m-form__group">
                                                    <label for = "participationCode">شماره داوطلبی شما</label>
                                                    <div class = "m-input-icon m-input-icon--left">
                                                        <input type = "text" name = "participationCode" id = "participationCode" class = "form-control m-input m-input--air" placeholder = "شماره داوطلبی شما">
                                                        <span class = "m-input-icon__icon m-input-icon__icon--left">
                                                            <span>
                                                                <i class = "flaticon-placeholder"></i>
                                                            </span>
                                                        </span>
                                                    </div>
                                                    <span class = "m-form__help">شماره داوطلبی شما به صورت رمز شده ذخیره می شود و فقط مدیر سایت می تواند آن را مشاهده کند(حتی شما هم نمی بینید)</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class = "col-md-12">
                                    <div class = "row">
                                        @if($userKonkurResult===null)
                                            <div class = "col">
                                                <div class = "form-group m-form__group">
                                                    <label for = "reportFile">فایل کارنامه(الزامی)</label>
                                                    <div></div>
                                                    <div class = "custom-file">
                                                        <input name = "reportFile" type = "file" class = "custom-file-input m-input m-input--air" id = "reportFile">
                                                        <label class = "custom-file-label" for = "reportFile">انتخاب فایل</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class = "col">
                                            <div class = "form-group m-form__group">
                                                <div class = "m-input-icon m-input-icon--left">
                                                    <textarea rows = "5" name = "comment" placeholder = "آلاء چه نقشی در نتیجه شما داشته و چطور به شما کمک کرده؟" class = "form-control m-input m-input--air" @if($userKonkurResult!==null)disabled = "disabled"
                                                              @endif
                                                    >@if($userKonkurResult!==null){{ $userKonkurResult->comment }}@endif</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($userKonkurResult===null)
                                <div class = "row margin-top-20">
                                    <div class = "col-md-12">
                                        <div class = "form-group">
                                            <div class = "input-group">
                                                <div class = "m-checkbox-list">
                                                    <label class = "m-checkbox m-checkbox--state-primary m--font-danger bold">
                                                        <input value = "1" name = "enableReportPublish" type = "checkbox">
                                                        اجازه انتشار رتبه خود را در سایت می دهم
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class = "m-alert m-alert--icon alert alert-accent" role = "alert">
                                            <div class = "m-alert__icon">
                                                <i class = "fa fa-exclamation-triangle"></i>
                                            </div>
                                            <div class = "m-alert__text">
                                                <strong>توضیح: </strong> با زدن تیک بالا شما به ما اجازه می دهید تا رتبه ی شما را در سایت آلاء اعلام کنیم. اگر تمایلی به این کار ندارید می توانید این تیک را نزنید. بدیهی است که با زدن تیک فوق ، درج شماره داوطلبی الزامی خواهد بود .
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @if($userKonkurResult===null)
                            <div class = "form-actions row">
                                <div class = "col-md-12 margiv-top-10">
                                    <button type = "submit" id = "btnSabteRotbe" class = "btn m-btn--pill m-btn--air btn-primary">
                                        ثبت کارنامه
                                    </button>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
            <div class = "m-portlet m-portlet--creative m-portlet--bordered-semi profileMenuPage profileMenuPage-filmVaJozve">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
						<span class = "m-portlet__head-icon m--hide">
							<i class = "flaticon-statistics"></i>
						</span>
                            <h3 class = "m-portlet__head-text">
                                فیلم ها و جزواتی که خریده اید:
                            </h3>
                            <h2 class = "m-portlet__head-label m-portlet__head-label--info">
                                <span>
                                    <i class = "flaticon-multimedia-4"></i>
                                    فیلم ها و جزوات
                                </span>
                            </h2>
                        </div>
                    </div>
                    <div class = "m-portlet__head-tools">

                    </div>
                </div>
                <div class = "m-portlet__body">

                    {{--<div class="m-alert m-alert--icon alert alert-warning" role="alert">--}}
                    {{--<div class="m-alert__icon">--}}
                    {{--<i class="fa fa-exclamation-triangle"></i>--}}
                    {{--</div>--}}
                    {{--<div class="m-alert__text">--}}
                    {{--<strong>شما محصولی سفارش نداده اید!</strong>--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="text-center">--}}
                    {{--<button type="button" class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-info m-btn--gradient-to-accent">--}}
                    {{--مشاهده اردوها و هایش ها--}}
                    {{--</button>--}}
                    {{--</div>--}}

                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script src = "{{ mix('/js/user-profile.js') }}"></script>
@endsection
