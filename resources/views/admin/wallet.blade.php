@extends('app')

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">پنل کیف پول</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    {{--Ajax modal loaded after inserting content--}}
    <div id = "ajax-modal" class = "modal fade" tabindex = "-1"></div>
    {{--Ajax modal for panel startup --}}

    @include("systemMessage.flash")
    @permission((config('constants.GIVE_WALLET_CREDIT')))
    <div class = "row">
        <div class = "col-md-12">
            <!-- BEGIN Portlet PORTLET-->
            <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
                {!! Form::open(['method' => 'POST', 'url' => route('admin.wallet.giveCredit')  ]) !!}
                <div class = "m-portlet__body">
                    <div class = "row">
                        <div class = "col-md-6 form-group {{($errors->has('nationalCode')?'has-danger':'')}}">
                            <p>{!! Form::text('nationalCode', old('nationalCode'), ['class' => 'form-control', 'id' => 'nationalCode'  , 'maxlength'=>'10' , 'placeholder'=>'کد ملی']) !!}
                                @if ($errors->has('nationalCode'))
                                    <span class="form-control-feedback ">
                                              <strong>{{ $errors->first('nationalCode') }}</strong>
                                        </span>
                                @endif
                            </p>
                        </div>
                        <div class = "col-md-6 form-group {{($errors->has('mobile')?'has-danger':'')}}">
                            <p>{!! Form::text('mobile', old('nationalCode'), ['class' => 'form-control', 'id' => 'mobile' , 'maxlength'=>'11' , 'placeholder'=>'موبایل']) !!}
                                @if ($errors->has('mobile'))
                                    <span class="form-control-feedback">
                                              <strong>{{ $errors->first('mobile') }}</strong>
                                        </span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-6 form-group {{($errors->has('credit')?'has-danger':'')}}">
                            <p>{!! Form::text('credit', old('credit'), ['class' => 'form-control', 'id' => 'credit'  , 'maxlength'=>'10' , 'placeholder'=>'مبلغ اعتبار (تومان)']) !!}
                                @if ($errors->has('credit'))
                                    <span class="form-control-feedback">
                                              <strong>{{ $errors->first('credit') }}</strong>
                                        </span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class = "col-12 text-center">
                            <input type = "submit" value = "اهدای اعتبار">
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- END Portlet PORTLET-->
        </div>
    </div>
    @endpermission
@endsection
