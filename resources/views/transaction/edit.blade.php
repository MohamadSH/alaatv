@permission((config('constants.SHOW_TRANSACTION_ACCESS')))

@extends('app' , ['pageName' => 'admin'])

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        h2.m-portlet__head-label.m-portlet__head-label--success {
            white-space: nowrap;
            line-height: 50px;
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
            <li class = "breadcrumb-item">
                <a class = "m-link" href = "{{action("Web\AdminController@admin")}}">پنل مدیریتی</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#"> اصلاح اطلاعات تراکنش</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')

    @include("systemMessage.flash")

    <div class = "row">


        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class = "col-md-3"></div>
        <div class = "col-md-6">


            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class = "m-portlet m-portlet--creative m-portlet--bordered-semi">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
						<span class = "m-portlet__head-icon m--hide">
							<i class = "flaticon-statistics"></i>
						</span>
                            <h3 class = "m-portlet__head-text">

                            </h3>
                            <h2 class = "m-portlet__head-label m-portlet__head-label--success">
                                <i class = "flaticon-cogwheel"></i>

                                اصلاح اطلاعات تراکنش
                                @if(!isset($transaction->order->user->firstName) && !isset($transaction->order->user->lastName))
                                کاربر ناشناس
                                @else
                                    <a target="_blank" href="{{action('Web\UserController@edit' , $transaction->order->user)}}">
                                    @if(isset($transaction->order->user->firstName))
                                        {{$transaction->order->user->firstName}}
                                    @endif
                                    @if(isset($transaction->order->user->lastName))
                                        {{$transaction->order->user->lastName}}
                                    @endif
                                    </a>
                                @endif

                            </h2>
                        </div>
                    </div>
                    <div class = "m-portlet__head-tools">
                        <a class = "btn btn-sm btn-primary m-btn--air" href = "{{action("Web\AdminController@adminOrder")}}">
                            بازگشت
                            <i class = "fa fa-angle-left"></i>
                        </a>
                    </div>
                </div>
                <div class = "m-portlet__body">


                    <div class = "form-body form">
                        {!! Form::model($transaction,['method' => 'PUT','action' => ['Web\TransactionController@update',$transaction], 'class'=>'form-horizontal']) !!}
                        @include('transaction.form' , ["id"=>["paymentmethod"=>"paymentmethod_id"] , "withCheckbox"=>["deadline_at" , "completed_at"]])
                        <div class = "row static-info margin-top-20" style = "text-align: left">
                            <div class = "col-md-9">
                                {!! Form::submit('اصلاح', ['class' => 'btn btn-lg m-btn--air btn-warning' ] ) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>


                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->

        </div>
        <!-- END SAMPLE FORM PORTLET-->

    </div>
@endsection


@section('page-js')

    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script type = "text/javascript">
        jQuery(document).ready(function () {
            $('#transactionDeadlineAtEnable').change(function () {
                if ($(this).prop('checked') === true) {
                    $('#transactionDeadlineAt').attr('disabled', false);
                } else {
                    $('#transactionDeadlineAt').attr('disabled', true);
                }
            });
            $('#transactionCompletedAtEnable').change(function () {
                if ($(this).prop('checked') === true) {
                    $('#transactionCompletedAt').attr('disabled', false);
                } else {
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
