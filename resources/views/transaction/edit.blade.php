@permission((Config::get('constants.SHOW_TRANSACTION_ACCESS')))
@extends("app",["pageName"=>"admin"])

@section("headPageLevelPlugin")
    <link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.css" rel="stylesheet"
          type="text/css"/>
@endsection
@section("metadata")
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{action("HomeController@index")}}">@lang('page.Home')</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <a href="{{action("HomeController@adminOrder")}}">پنل مدیریتی</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>اصلاح اطلاعات تراکنش</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class="row">

        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="col-md-3"></div>
        <div class="col-md-6">
            @include("systemMessage.flash")
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase"> اصلاح اطلاعات تراکنش @if(!isset($transaction->order->user->firstName) && !isset($transaction->order->user->lastName))
                                کاربر
                                ناشناس @else @if(isset($transaction->order->user->firstName)){{$transaction->order->user->firstName}} @endif @if(isset($transaction->order->user->lastName)) {{$transaction->order->user->lastName}} @endif @endif</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a class="btn btn-sm dark dropdown-toggle" href="{{action("HomeController@adminOrder")}}">
                                بازگشت
                                <i class="fa fa-angle-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="form-body form">
                        {!! Form::model($transaction,['method' => 'PUT','action' => ['TransactionController@update',$transaction], 'class'=>'form-horizontal']) !!}
                        @include('transaction.form' , ["id"=>["paymentmethod"=>"paymentmethod_id"] , "withCheckbox"=>["deadline_at" , "completed_at"]])
                        <div class="row static-info margin-top-20" style="text-align: left">
                            <div class="col-md-9">
                                {!! Form::submit('اصلاح', ['class' => 'btn dark' ] ) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div><!-- END SAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->

    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/acm/extra/persian-datepicker/lib/persian-date.js" type="text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src="/acm/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js"
            type="text/javascript"></script>
@endsection
@section("extraJS")
    <script type="text/javascript">
        jQuery(document).ready(function () {
            $('#transactionDeadlineAtEnable').change(function () {
                if ($(this).prop('checked') === true) {
                    $('#transactionDeadlineAt').attr('disabled', false);
                }
                else {
                    $('#transactionDeadlineAt').attr('disabled', true);
                }
            });
            $('#transactionCompletedAtEnable').change(function () {
                if ($(this).prop('checked') === true) {
                    $('#transactionCompletedAt').attr('disabled', false);
                }
                else {
                    $('#transactionCompletedAt').attr('disabled', true);
                }
            });

            $("#transactionDeadlineAt").persianDatepicker({
                altField: '#transactionDeadlineAtAlt',
                altFormat: "YYYY MM DD",
                observer: true,
                format: 'YYYY/MM/DD',
                altFieldFormatter: function (unixDate) {
                    var d = new Date(unixDate).toISOString();
                    return d;
                }
            });

            $("#transactionCompletedAt").persianDatepicker({
                altField: '#transactionCompletedAtAlt',
                altFormat: "YYYY MM DD",
                observer: true,
                format: 'YYYY/MM/DD',
                altFieldFormatter: function (unixDate) {
                    var d = new Date(unixDate).toISOString();
                    return d;
                }
            });
        });
    </script>
@endsection
@endpermission