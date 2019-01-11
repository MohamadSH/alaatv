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
                <a href="{{action("IndexPageController")}}">@lang('page.Home')</a>
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
                    {!! Form::open(['files'=>'true' , 'method'=>'POST' , 'action'=>'HomeController@excelBot' , 'target'=>'_blank' ]) !!}
                    <input type="file" name="file">
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
