@permission((Config::get('constants.SHOW_SITE_CONFIG_ACCESS')))@extends('app' , ['pageName'=> 'admin'])

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">پیکربندی سایت</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class = "row">
        <div class = "col">
            <!-- PORTLET MAIN -->
        @include("partials.siteConfigurationSideBar" , ["section"=>"websiteSetting"])
        <!-- END PORTLET MAIN -->
        </div>
    </div>
    <div class = "row">
        <div class = "col">

        @include("systemMessage.flash")

        <!-- BEGIN PORTLET -->
            {!! Form::open(['files' => true , 'method' => 'PUT' , 'action' => ['Web\WebsiteSettingController@update', $setting] , 'class'=>'form-horizontal']) !!}
            <div class = "m-portlet m-portlet--tabs">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-tools a--full-width">
                        <ul class = "nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role = "tablist">
                            <li class = "nav-item m-tabs__item">
                                <a class = "nav-link m-tabs__link active" data-toggle = "tab" href = "#m_tabs_6_1" role = "tab">
                                    <i class = "fa fa-cogs"></i>
                                    مشخصات سایت
                                </a>
                            </li>
                            <li class = "nav-item m-tabs__item">
                                <a class = "nav-link m-tabs__link" data-toggle = "tab" href = "#m_tabs_6_2" role = "tab">
                                    <i class = "fa fa-briefcase"></i>
                                    SEO صفحه اصلی
                                </a>
                            </li>
                            <li class = "nav-item m-tabs__item">
                                <a class = "nav-link m-tabs__link" data-toggle = "tab" href = "#m_tabs_6_3" role = "tab">
                                    <i class = "fa fa-bell"></i>
                                    مشخصات شعبه اصلی
                                </a>
                            </li>
                            <li class = "nav-item m-tabs__item">
                                <a class = "nav-link m-tabs__link" data-toggle = "tab" href = "#m_tabs_6_4" role = "tab">
                                    <i class = "fa fa-bell"></i>
                                    شبکه های اجتماعی
                                </a>
                            </li>
                            <li class = "nav-item m-tabs__item">
                                <a class = "nav-link m-tabs__link" data-toggle = "tab" href = "#m_tabs_6_5" role = "tab">
                                    <i class = "fa fa-bell"></i>
                                    لوگو
                                </a>
                            </li>
                        </ul>

                        @permission((Config::get('constants.EDIT_SITE_CONFIG_ACCESS')))
                        {!! Form::submit("اصلاح" , ['class' => 'btn m-btn--pill btn-success m--margin-left-15']) !!}
                        @endpermission

                    </div>
                </div>
                <div class = "m-portlet__body">
                    <div class = "tab-content">
                        <div class = "tab-pane active" id = "m_tabs_6_1" role = "tabpanel">
                            <div class = "row">
                                @if(isset($wSetting->site->titleBar))
                                    <div class = "form-group col-md-6">
                                        <label class = "control-label col-md-3">تایتل بار</label>
                                        <div class = "col-md-9">
                                            {!! Form::text("titleBar", $wSetting->site->titleBar, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                @endif
                                @if(isset($wSetting->site->name))
                                    <div class = "form-group col-md-6">
                                        <label class = "control-label col-md-3">نام سایت</label>
                                        <div class = "col-md-9">
                                            {!! Form::text("siteName", $wSetting->site->name, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                @endif
                                @if(isset($wSetting->site->companyName))
                                    <div class = "form-group col-md-6">
                                        <label class = "control-label col-md-3">نام شرکت</label>
                                        <div class = "col-md-9">
                                            {!! Form::text("siteCompanyName", $wSetting->site->companyName, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                @endif
                                @if(isset($wSetting->site->footer))
                                    <div class = "form-group col-md-6">
                                        <label class = "control-label col-md-3">جمله فوتر</label>
                                        <div class = "col-md-9">
                                            {!! Form::text("siteFooter", $wSetting->site->footer, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class = "row">
                                @if(isset($wSetting->site->rules))
                                    <div class = "form-group col-md-12">
                                        <label class = "control-label col-md-1">قوانین</label>
                                        <div class = "col-md-11">
                                            {!! Form::textarea('siteRules', $wSetting->site->rules, ['class' => 'form-control' , 'placeholder' => 'قوانین']) !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class = "tab-pane" id = "m_tabs_6_2" role = "tabpanel">
                            <div class = "row">
                                <div class = "form-group col-md-12">
                                    <label class = "control-label col-md-2">تایتل</label>
                                    <div class = "col-md-10">
                                        @if(isset($wSetting->site->seo->homepage->metaTitle))
                                            {!! Form::text("homeMetaTitle", $wSetting->site->seo->homepage->metaTitle, ['class' => 'form-control' , 'id'=>'metaTitle' , 'placeholder' => 'meta title' , 'onkeyup' => "countChar(this,50,".Config::get("constants.UI_META_TITLE_LIMIT").",".Config::get("constants.UI_META_TITLE_LIMIT").",'#progressbar_metaTitle')" , 'maxlength'=>Config::get("constants.UI_META_TITLE_LIMIT")]) !!}
                                            <div class = "progress" style = "width: 100%; text-align: right; float: right;">
                                                <div id = "progressbar_metaTitle" class = "progress-bar" style = "text-align: right; float: right;"></div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class = "form-group col-md-12">
                                    <label class = "control-label col-md-2">کیورد(keywords)</label>
                                    <div class = "col-md-10">
                                        @if(isset($wSetting->site->seo->homepage->metaKeywords))
                                            {!! Form::text("homeMetaKeywords", $wSetting->site->seo->homepage->metaKeywords, ['class' => 'form-control' , 'id'=>'metaKeywords', 'placeholder' => 'meta keywords' , 'onkeyup' => "countChar(this,".Config::get("constants.UI_META_KEYWORD_LIMIT").",".Config::get("constants.UI_META_KEYWORD_LIMIT").",".Config::get("constants.UI_META_KEYWORD_LIMIT").",'#progressbar_metaKeywords')" , 'maxlength'=>Config::get("constants.UI_META_KEYWORD_LIMIT")]) !!}
                                            <div class = "progress" style = "width: 100%; text-align: right; float: right;">
                                                <div id = "progressbar_metaKeywords" class = "progress-bar" style = "text-align: right; float: right;"></div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class = "form-group col-md-12">
                                    <label class = "control-label col-md-2">توضیح</label>
                                    <div class = "col-md-10">
                                        @if(isset($wSetting->site->seo->homepage->metaDescription))
                                            {!! Form::textarea('homeMetaDescription', $wSetting->site->seo->homepage->metaDescription, ['class' => 'form-control' , 'id'=>'metaDescription', 'placeholder' => 'meta description' , 'onkeyup' => "countChar(this,".Config::get("constants.UI_META_DESCRIPTION_LIMIT").",".Config::get("constants.UI_META_DESCRIPTION_LIMIT").",".Config::get("constants.UI_META_DESCRIPTION_LIMIT").",'#progressbar_metaDescription')" , 'maxlength'=>Config::get("constants.UI_META_DESCRIPTION_LIMIT")]) !!}
                                            <div class = "progress" style = "width: 100%; text-align: right; float: right;">
                                                <div id = "progressbar_metaDescription" class = "progress-bar" style = "text-align: right; float: right;"></div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class = "tab-pane" id = "m_tabs_6_3" role = "tabpanel">
                            <div class = "row">
                                @if(isset($wSetting->branches->main->displayName))
                                    <div class = "form-group col-md-6">
                                        <label class = "control-label col-md-3">نام</label>
                                        <div class = "col-md-9">
                                            {!! Form::text("branchesName", $wSetting->branches->main->displayName, ['class' => 'form-control']) !!}
                                            {{--<text class="form-control list-group-item" >{{$wSetting->branches->main->displayName}}</text>--}}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <hr>
                            <div class = "row">
                                @if(isset($wSetting->branches->main->address->city))
                                    <div class = "form-group col-md-6">
                                        <label class = "control-label col-md-3">شهر</label>
                                        <div class = "col-md-9">
                                            {!! Form::text("addressCity", $wSetting->branches->main->address->city, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                @endif
                                @if(isset($wSetting->branches->main->address->street))
                                    <div class = "form-group col-md-6">
                                        <label class = "control-label col-md-3">خیابان</label>
                                        <div class = "col-md-9">
                                            {!! Form::text("addressStreet", $wSetting->branches->main->address->street, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                @endif
                                @if(isset($wSetting->branches->main->address->avenue))
                                    <div class = "form-group col-md-6">
                                        <label class = "control-label col-md-3">خیابان فرعی</label>
                                        <div class = "col-md-9">
                                            {!! Form::text("addressAvenue", $wSetting->branches->main->address->avenue, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                @endif
                                @if(isset($wSetting->branches->main->address->extra))
                                    <div class = "form-group col-md-6">
                                        <label class = "control-label col-md-3">توضیح تکمیلی</label>
                                        <div class = "col-md-9">
                                            {!! Form::text("addressExtra", $wSetting->branches->main->address->extra, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                @endif
                                @if(isset($wSetting->branches->main->address->plateNumber))
                                    <div class = "form-group col-md-6">
                                        <label class = "control-label col-md-3">پلاک</label>
                                        <div class = "col-md-9">
                                            {!! Form::text("addressPlateNumber", $wSetting->branches->main->address->plateNumber, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <hr>
                            <div class = "row">
                                @foreach($wSetting->branches->main->contacts as $contact)
                                    <div class = "form-group col-md-6">
                                        <label class = "control-label col-md-3">شماره تلفن</label>
                                        <div class = "col-md-9">
                                            {!! Form::text("branchesContactsNumber[]", $contact->number, ['class' => 'form-control', 'dir' => 'ltr']) !!}
                                        </div>
                                    </div>
                                    <div class = "form-group col-md-6">
                                        <label class = "control-label col-md-3">توضیح</label>
                                        <div class = "col-md-9">
                                            {!! Form::text("branchesContactsDescription[]", $contact->description, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr>
                            <div class = "row">
                                @foreach($wSetting->branches->main->emergencyContacts as $contact)
                                    <div class = "form-group col-md-6">
                                        <label class = "control-label col-md-3">شماره تلفن اضطراری</label>
                                        <div class = "col-md-9">
                                            {!! Form::text("branchesEmergencyContactsNumber[]", $contact->number, ['class' => 'form-control', 'dir' => 'ltr']) !!}
                                        </div>
                                    </div>
                                    <div class = "form-group col-md-6">
                                        <label class = "control-label col-md-3">توضیح</label>
                                        <div class = "col-md-9">
                                            {!! Form::text("branchesEmergencyContactsDescription[]", $contact->description, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <hr>
                            {{--<div class="row">--}}
                            {{--@foreach($wSetting->branches->main->faxes as $fax)--}}
                            {{--<div class="form-group col-md-6">--}}
                            {{--<label class="control-label col-md-3">شماره فکس</label>--}}
                            {{--<div class="col-md-9">--}}
                            {{--{!! Form::text("faxNumber[]", $fax->number, ['class' => 'form-control', 'dir' => 'ltr']) !!}--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="form-group col-md-6">--}}
                            {{--<label class="control-label col-md-3">توضیح</label>--}}
                            {{--<div class="col-md-9">--}}
                            {{--{!! Form::text("branchesEmergencyContactsDescription[]", $fax->description, ['class' => 'form-control']) !!}--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--@endforeach--}}
                            {{--</div>--}}
                            {{--<hr>--}}
                            <div class = "row">
                                @foreach($wSetting->branches->main->emails as $email)
                                    <div class = "form-group col-md-6">
                                        <label class = "control-label col-md-3">ایمیل</label>
                                        <div class = "col-md-9">
                                            {!! Form::text("branchesEmails", $email->address, ['class' => 'form-control', 'dir' => 'ltr']) !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class = "tab-pane" id = "m_tabs_6_4" role = "tabpanel">
                            <div class = "row">
                                <div class = "col-12">
                                    <div class = "form-group">
                                        <label class = "control-label col-md-3">عنوان کانال تلگرام</label>
                                        <div class = "col-md-9">
                                            {!! Form::text("telegramName", $wSetting->socialNetwork->telegram->channel->name, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class = "row">
                                    @if(isset($wSetting->socialNetwork->telegram->channel->link))
                                        <div class = "form-group col-md-8">
                                            <div class = "row">
                                                <label class = "control-label col-md-3">لینک</label>
                                                <div class = "col-md-9">
                                                    {!! Form::text("telegramLink", $wSetting->socialNetwork->telegram->channel->link, ['class' => 'form-control', 'dir' => 'ltr']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if(isset($wSetting->socialNetwork->telegram->channel->admin))
                                        <div class = "form-group col-md-8">
                                            <div class = "row">
                                                <label class = "control-label col-md-3">ادمین</label>
                                                <div class = "col-md-9">
                                                    {!! Form::text("telegramAdmin", $wSetting->socialNetwork->telegram->channel->admin, ['class' => 'form-control', 'dir' => 'ltr']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                {{--<div class="row">--}}
                                {{--@if(isset($wSetting->socialNetwork->instagram->channel->link))--}}
                                {{--<div class="form-group col-md-8">--}}
                                {{--<label class="control-label col-md-3">لینک اینستاگرام</label>--}}
                                {{--<div class="col-md-9">--}}
                                {{--{!! Form::text("instagramLink", $wSetting->socialNetwork->instagram->channel->link, ['class' => 'form-control', 'dir' => 'ltr']) !!}--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--@endif--}}
                                {{--</div>--}}
                                {{--<div class="row">--}}
                                {{--@if(isset($wSetting->socialNetwork->facebook[0]->link))--}}
                                {{--<div class="form-group col-md-8">--}}
                                {{--<label class="control-label col-md-3">لینک فیسبوک</label>--}}
                                {{--<div class="col-md-9">--}}
                                {{--{!! Form::text("facebookLink", $wSetting->socialNetwork->facebook[0]->link, ['class' => 'form-control', 'dir' => 'ltr']) !!}--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--@endif--}}
                                {{--</div>--}}
                                {{--<div class="row">--}}
                                {{--@if(isset($wSetting->socialNetwork->twitter[0]->link))--}}
                                {{--<div class="form-group col-md-8">--}}
                                {{--<label class="control-label col-md-3">لینک توئیتر</label>--}}
                                {{--<div class="col-md-9">--}}
                                {{--{!! Form::text("twitterLink", $wSetting->socialNetwork->twitter[0]->link, ['class' => 'form-control', 'dir' => 'ltr']) !!}--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--@endif--}}
                                {{--</div>--}}
                                {{--<div class="row">--}}
                                {{--@if(isset($wSetting->socialNetwork->googleplus[0]->link))--}}
                                {{--<div class="form-group col-md-8">--}}
                                {{--<label class="control-label col-md-3">لینک گوگل پلاس</label>--}}
                                {{--<div class="col-md-9">--}}
                                {{--{!! Form::text("googleplusLink", $wSetting->socialNetwork->googleplus[0]->link, ['class' => 'form-control', 'dir' => 'ltr']) !!}--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--@endif--}}
                                {{--</div>--}}
                            </div>
                        </div>
                        <div class = "tab-pane" id = "m_tabs_6_5" role = "tabpanel">
                            <div class = "row">
                                <div class = "col-md-6 text-center">
                                    <label class = "control-label bold">favicon</label>
                                    <br>
                                    <br>
                                    <div class = "fileinput fileinput-new" data-provides = "fileinput">
                                        <div class = "fileinput-new thumbnail" style = "width: 200px; height: 150px;">
                                            <img src = "{{isset($wSetting->site->favicon) && strlen($wSetting->site->favicon) > 0  ? route('image', ['category'=>'11','w'=>'140' , 'h'=>'140' ,  'filename' =>  $wSetting->site->favicon ]) : "../assets/pages/media/works/img1.jpg"}}" class = "img-responsive" alt = "لوگو سر تیتر سایت"/>
                                        </div>
                                        <div class = "fileinput-preview fileinput-exists thumbnail" style = "max-width: 200px; max-height: 150px;"></div>
                                        <br>
                                        <div>
                                                                <span class = "btn-file">
                                                                    <span class = "fileinput-new btn btn-success"><i class = "fa fa-plus"></i>انتخاب عکس</span>
                                                                    <span class = "fileinput-exists btn"> تغییر </span>
                                                                    <input type = "file" name = "favicon"> </span>
                                            <a href = "javascript:" class = "btn red fileinput-exists" id = "favicon-remove" data-dismiss = "fileinput"> حذف</a>
                                        </div>
                                    </div>
                                    <span class = "form-control-feedback m--font-danger">سایز ۳۰×۳۰ پیکسل</span>
                                </div>
                                <div class = "col-md-6 text-center">
                                    <label class = "control-label bold">لوگو سایت</label>
                                    <br>
                                    <br>
                                    <div class = "fileinput fileinput-new" data-provides = "fileinput">
                                        <div class = "fileinput-new thumbnail" style = "width: 200px; height: 150px;">
                                            <img src = "{{isset($wSetting->site->siteLogo) && strlen($wSetting->site->siteLogo) > 0  ? route('image', ['category'=>'11','w'=>'140' , 'h'=>'140' ,  'filename' =>  $wSetting->site->siteLogo ]) : "../assets/pages/media/works/img1.jpg"}}" class = "img-responsive" alt = "لوگو کناره سایت"/>
                                        </div>
                                        <div class = "fileinput-preview fileinput-exists thumbnail" style = "max-width: 200px; max-height: 150px;"></div>
                                        <br>
                                        <div>
                                                                <span class = "btn-file">
                                                                    <span class = "fileinput-new btn btn-success"><i class = "fa fa-plus"></i>انتخاب عکس</span>
                                                                    <span class = "fileinput-exists btn"> تغییر </span>
                                                                    <input type = "file" name = "siteLogo"> </span>
                                            <a href = "javascript:" class = "btn red fileinput-exists" id = "siteLogo-remove" data-dismiss = "fileinput"> حذف</a>
                                        </div>
                                    </div>
                                    <span class = "form-control-feedback m--font-danger">سایز ۱۴×۹۴ پیکسل</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
        <!-- END PORTLET -->

        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script>
        countChar(document.getElementById('metaTitle'), 50,{{Config::get("constants.UI_META_TITLE_LIMIT")}},{{Config::get("constants.UI_META_TITLE_LIMIT")}}, '#progressbar_metaTitle');
        countChar(document.getElementById('metaKeywords'),{{Config::get("constants.UI_META_KEYWORD_LIMIT")}},{{Config::get("constants.UI_META_KEYWORD_LIMIT")}},{{Config::get("constants.UI_META_KEYWORD_LIMIT")}}, '#progressbar_metaKeywords');
        countChar(document.getElementById('metaDescription'),{{Config::get("constants.UI_META_DESCRIPTION_LIMIT")}},{{Config::get("constants.UI_META_DESCRIPTION_LIMIT")}},{{Config::get("constants.UI_META_DESCRIPTION_LIMIT")}}, '#progressbar_metaDescription');

        /**
         *
         * @param val
         * @param aNumberOfChar
         * @param bNumberOfChar
         * @param progress
         */
        function countChar(val, aNumberOfChar, bNumberOfChar, maxChar, progress) {
            var len = val.value.length;
            var $progressbar = $(progress);

            var w = Math.round(100 * len / maxChar);
            //            console.log(w);
            if (w < Math.round(100 * aNumberOfChar / maxChar)) {
                $progressbar.css("width", w + "%");
                $progressbar.css("background-color", '#ff5329');
            } else if (w <= Math.round(100 * bNumberOfChar / maxChar)) {
                $progressbar.css("width", w + "%");
                $progressbar.css("background-color", '#00aa11');
            } else {
                $progressbar.css("width", w + "%");
                $progressbar.css("background-color", '#ff0000');
            }
        }
    </script>
@endsection

@endpermission
