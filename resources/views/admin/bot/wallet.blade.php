@extends("app",["pageName"=>$pageName])

@section("headPageLevelPlugin")

@endsection

@section("metadata")
    @parent()
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>بات</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    {{--Ajax modal loaded after inserting content--}}
    <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
    {{--Ajax modal for panel startup --}}
    <div class="row">
        @include("systemMessage.flash")
        <div class="col-md-12">
            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet light">
                <div class="portlet-body">
                    {!! Form::open(['method'=>'POST' , 'action'=>'HomeController@walletBot' , 'target'=>'_blank' ]) !!}
                    <label for="userGroup" class="control-label">
                        گروه کاربران:
                    </label>
                    <select name="userGroup">
                        <option value="0">انتخاب کنید</option>
                        <option value="1">5+1 و یک اردو و طلایی خریده اند</option>
                        <option value="2">5+1 و یک اردو خریده اند اما طلایی نه</option>
                        <option value="3">5+1 خریده اند و دیگر هیچی نخریده اند</option>
                        <option value="4">هیچی نخریده اند</option>
                        <option value="5">از محصولات دیگر خریده اند</option>
                        <option value="6">همایش 1+5 و طلایی خریده اند و اردو ندارند</option>
                        <option value="7">همایش طلایی را خریده اند</option>
                    </select>
                    <label for="userGroup" class="control-label">
                        <input type="checkbox" name="giveGift" value="1">
                        اعتبار اهداء کن
                    </label>
                    <input type="text" name="giftCost" value="" placeholder="مبلغ اهدایی">
                    <input type="submit" value="انجام بده">
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- END Portlet PORTLET-->
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")

@endsection

@section("footerPageLevelScript")

@endsection

@section("extraJS")

@endsection
