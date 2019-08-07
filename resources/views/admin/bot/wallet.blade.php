@extends('app',['pageName'=>$pageName])

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">بات</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    {{--Ajax modal loaded after inserting content--}}
    <div id = "ajax-modal" class = "modal fade" tabindex = "-1"></div>
    {{--Ajax modal for panel startup --}}

    @include("systemMessage.flash")

    <div class = "row">
        <div class = "col">
            <!-- BEGIN Portlet PORTLET-->
            <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class = "m-portlet__body">
                    {!! Form::open(['method'=>'POST' , 'action'=>'Web\BotsController@walletBot' , 'target'=>'_blank' ]) !!}
                    <label for = "userGroup" class = "control-label">
                        گروه کاربران:
                    </label>
                    <select name = "userGroup">
                        <option value = "0">انتخاب کنید</option>
                        <option value = "1">5+1 و یک اردو و طلایی خریده اند</option>
                        <option value = "2">5+1 و یک اردو خریده اند اما طلایی نه</option>
                        <option value = "3">5+1 خریده اند و دیگر هیچی نخریده اند</option>
                        <option value = "4">هیچی نخریده اند</option>
                        <option value = "5">از محصولات دیگر خریده اند</option>
                        <option value = "6">همایش 1+5 و طلایی خریده اند و اردو ندارند</option>
                        <option value = "7">همایش طلایی را خریده اند</option>
                    </select>
                    <label for = "userGroup" class = "control-label">
                        <input type = "checkbox" name = "giveGift" value = "1">
                        اعتبار اهداء کن
                    </label>
                    <input type = "text" name = "giftCost" value = "" placeholder = "مبلغ اهدایی">
                    <input type = "submit" value = "انجام بده">
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- END Portlet PORTLET-->
        </div>
    </div>
@endsection
