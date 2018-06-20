@extends("app",["pageName"=>"admin"])

@section("headPageLevelPlugin")
@endsection


@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{action("HomeController@index")}}">خانه</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <a href="{{action("HomeController@adminContent")}}">مدیریت محتوا</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>درج محتوای آموزشی</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    @include("systemMessage.flash")
    <div class="row">
        @include("systemMessage.flash")
        <div class="col-md-12">
            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet light">
                <div class="portlet-body">
                    <div class="row">
                        {!! Form::open(['method' => 'POST', 'action' => 'EducationalContentController@basicStore']) !!}
                        <div class="col-md-6">
                                {!! Form::text('contentset_id', null, ['class' => 'form-control', 'placeholder'=>'شماره درس', 'dir'=>'ltr']) !!}
                                <span class="help-block" >
                                    <strong></strong>
                                 </span>
                        </div>
                        <div class="col-md-6">
                                {!! Form::select('contenttype_id', $contenttypes, null,['class' => 'form-control']) !!}
                                <span class="help-block">
                                    <strong></strong>
                                </span>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="checkbox" id="orderCheckbox">
                                        <span></span>
                                    </span>
                                {!! Form::text('order', null, ['class' => 'form-control', 'placeholder'=>'ترتیب' , 'id'=>'order' , 'disabled', 'dir'=>'ltr']) !!}
                            </div>
                            <span class="help-block" >
                                    <strong></strong>
                            </span>
                        </div>
                        <div class="col-md-6">
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder'=>'عنوان']) !!}
                                <span class="help-block" >
                                    <strong></strong>
                                </span>
                        </div>
                        <div class="col-md-6">
                                {!! Form::text('hd', null, ['class' => 'form-control', 'placeholder'=>'لینک HD', 'dir'=>'ltr']) !!}
                                <span class="help-block" >
                                    <strong></strong>
                                </span>
                        </div>
                        <div class="col-md-6">
                                {!! Form::text('hq', null, ['class' => 'form-control', 'placeholder'=>'لینک hq', 'dir'=>'ltr']) !!}
                                <span class="help-block" >
                                    <strong></strong>
                                </span>
                        </div>
                        <div class="col-md-6">
                                {!! Form::text('240p', null, ['class' => 'form-control', 'placeholder'=>'لینک 240p', 'dir'=>'ltr']) !!}
                                <span class="help-block" >
                                    <strong></strong>
                                </span>
                        </div>
                        <div class="col-md-6">
                            {!! Form::text('thumbnail', null, ['class' => 'form-control', 'placeholder'=>'لینک تامبنیل' , 'dir'=>'ltr']) !!}
                            <span class="help-block" >
                                    <strong></strong>
                                </span>
                        </div>
                        <div class="col-md-12 text-center">
                            <input type="submit" value="درج">
                        </div>
                        {!! Form::close() !!}
                    </div>
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
    <script>
        $(document).on("click", "#orderCheckbox", function (){
            if($(this).prop("checked"))
            {
                $("#order").prop("disabled" , false);
            }
            else
            {
                $("#order").prop("disabled" , true);
            }
        });
    </script>
@endsection
