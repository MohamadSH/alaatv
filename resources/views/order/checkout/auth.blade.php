@extends("app")

@section("content")
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered ">
                <div class="portlet-body">
                    <div class="row">
                        @include("partials.checkoutSteps" , ["step"=>0])
                    </div>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            @include("partials.loginForm")
                        </div>
                    </div>
                    <br/>
                    <br/>
                    <br/>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("extraJS")
    @if(!empty($errors->getBags()))
        <script>
            jQuery(document).ready(function () {
                @if(!$errors->login->isEmpty())
                $("#signin-button").trigger("click");
                @else
                $("#signup-button").trigger("click");
                @endif
            });
        </script>
    @endif
@endsection