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

    <div class = "alert alert-success alert-dismissible fade hidden" id="successAlert"  role = "alert">
        <button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close"></button>
        <strong id="successMessage" >
            {!!   Session::pull('success') !!}
        </strong>
    </div>
    <div class = "alert alert-danger alert-dismissible fade hidden" id="errorAlert" role = "alert">
        <button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close"></button>
        <strong id="errorMessage">
            {{ Session::pull('error') }}
        </strong>
    </div>
    @permission((config('constants.GIVE_WALLET_CREDIT')))
    <div class = "row">
        <div class = "col-md-12">
            <!-- BEGIN Portlet PORTLET-->
            <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
                {!! Form::open(['method' => 'POST', 'url' => route('web.admin.wallet.giveCredit') , 'id'=>'findUserForm'  ]) !!}
                <div class = "m-portlet__body">
                    <div class = "row">
                        <div class = "col-md-6 form-group" id="nationalCodeFormGroup" >
                            <p>{!! Form::text('nationalCode', old('nationalCode'), ['class' => 'form-control', 'id' => 'nationalCode'  , 'maxlength'=>'10' , 'placeholder'=>'کد ملی']) !!}
                                <span class="form-control-feedback ">
                                              <strong id="nationalCodeValidation"></strong>
                                        </span>
                            </p>
                        </div>
                        <div class = "col-md-6 form-group" id="mobileFormGroup" >
                            <p>{!! Form::text('mobile', old('nationalCode'), ['class' => 'form-control', 'id' => 'mobile' , 'maxlength'=>'11' , 'placeholder'=>'موبایل']) !!}
                                <span class="form-control-feedback">
                                              <strong id="mobileValidation"></strong>
                                        </span>
                            </p>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-6 form-group" id="creditFormGroup" >
                            <p>{!! Form::text('credit', old('credit'), ['dir'=>'ltr' , 'class' => 'form-control', 'id' => 'credit'  , 'maxlength'=>'10' , 'placeholder'=>'مبلغ اعتبار (تومان)']) !!}
                                <span class="form-control-feedback">
                                      <strong id="creditValidation" ></strong>
                                    </span>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class = "col-12 text-center">
                            <input type = "submit" value = "اهدای اعتبار">
                            <img alt="loading" style="display: none" id="loading-image" height="30" width="30" src="{{asset('/acm/extra/loading-arrow.gif')}}">
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
            $('#errorMessage').html('');
            $('#successMessage').html('');
            $('.alert').addClass('hidden');
            $('.alert').removeClass('show');
            $('#loading-image').show();
            formData = $('#findUserForm').serialize();
            $.ajax({
                type: $('#findUserForm').attr('method'),
                url: $('#findUserForm').attr('action'),
                data: formData,
                statusCode: {
                    //The status for when action was successful
                    200: function (response) {
                        if(response.error != undefined && response.error != null){
                            if(response.error.code == 404){
                                $('#errorMessage').html('کاربر مورد نظر یافت نشد');
                            }else if(response.error.code == 503){
                                $('#errorMessage').html('خطایی رخ داده است. لطفا به ادمین اطلاع دهید');
                            }
                            $('#errorAlert').removeClass('hidden');
                            $('#errorAlert').addClass('show');
                        }else{
                            $('#successMessage').html('اعتبار '+$('#credit').val()+' تومان با موفقیت به '+response.userFullName+' افزوده شد');
                            $('#successAlert').removeClass('hidden');
                            $('#successAlert').addClass('show');
                            $('#findUserForm')[0].reset();
                        }
                        $('#loading-image').hide();
                    },
                    422: function (response) {
                        $.each($.parseJSON(response.responseText).errors, function (index, value) {
                            $('#'+index+'Validation').html(value);
                            $('#'+index+'FormGroup').addClass('has-danger');
                        });
                        $('#loading-image').hide();
                    },
                },
            });
        });
    </script>
@endsection
