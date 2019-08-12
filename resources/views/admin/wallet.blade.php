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
                {!! Form::open(['method' => 'POST', 'url' => route('admin.wallet.giveCredit') , 'id'=>'findUserForm'  ]) !!}
                    <div class = "m-portlet__body">
                        <div class = "row">
                            <div class = "col-md-6 form-group" id="nationalCodeFormGroup" >
                                <p>{!! Form::text('nationalCode', old('nationalCode'), ['class' => 'form-control', 'id' => 'nationalCode'  , 'maxlength'=>'10' , 'placeholder'=>'کد ملی']) !!}
                                        <span class="form-control-feedback ">
                                              <strong id="nationalCodeValidation">{{ $errors->first('nationalCode') }}</strong>
                                        </span>
                                </p>
                            </div>
                            <div class = "col-md-6 form-group" id="mobileFormGroup" >
                                <p>{!! Form::text('mobile', old('nationalCode'), ['class' => 'form-control', 'id' => 'mobile' , 'maxlength'=>'11' , 'placeholder'=>'موبایل']) !!}
                                        <span class="form-control-feedback">
                                              <strong id="mobileValidation">{{ $errors->first('mobile') }}</strong>
                                        </span>
                                </p>
                            </div>
                        </div>
                        <div class = "row">
                            <div class = "col-md-6 form-group" id="creditCodeFormGroup" >
                                <p>{!! Form::text('credit', old('credit'), ['class' => 'form-control', 'id' => 'credit'  , 'maxlength'=>'10' , 'placeholder'=>'مبلغ اعتبار (تومان)']) !!}
                                        <span class="form-control-feedback">
                                              <strong id="creditValidation" >{{ $errors->first('credit') }}</strong>
                                        </span>
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
@section('page-js')
    <script type="application/javascript">
        $(document).on('submit', '#findUserForm', function (e) {
            e.preventDefault();
            $('#mobileValidation').html('');
            $('#nationalCodeValidation').html('');
            $('#creditValidation').html('');
            $('#mobileFormGroup').removeClass('has-danger');
            $('#nationalCodeFormGroup').removeClass('has-danger');
            $('#creditFormGroup').removeClass('has-danger');
            formData = $('#findUserForm').serialize();
            $.ajax({
                type: $('#findUserForm').attr('method'),
                url: $('#findUserForm').attr('action'),
                data: formData,
                statusCode: {
                    //The status for when action was successful
                    200: function (response) {
                    },
                    //The status for when the user is not authorized for making the request
                    403: function (response) {
                        window.location.replace("/403");
                    },
                    404: function (response) {
                        window.location.replace("/404");
                    },
                    //The status for when form data is not valid
                    422: function (response) {
                        console.log($.parseJSON(response.responseText).errors);
                        $.each($.parseJSON(response.responseText).errors, function (index, value) {
                            console.log(index);
                            console.log(value);
                            console.log('#'+index+'Validation');
                            $('#'+index+'Validation').html(value);
                            $('#'+index+'FormGroup').addClass('has-danger');
                        });
                    },
                    //The status for when there is error php code
                    500: function (response) {
                    },
                    //The status for when there is error php code
                    503: function (response) {
                    }
                },
                contentType: false,
                processData: false
            });
        });
    </script>
@endsection
