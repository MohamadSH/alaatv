@extends('partials.templatePage' , ["pageName"=>"contactUs"])

@section("content")
    @include("systemMessage.flash")

    <button id = "btnFire">ارسال</button>
@endsection


@section("page-js")
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '#btnFire', function () {
                $.ajax({
                    url: "http://192.168.4.2:9071/paymentRedirect/zarinpal",
                    type: "POST",

                    success: function (data, textStatus, request) {
                        alert(request.getResponseHeader('some_header'));
                        console.log('success: ' + request.getAllResponseHeaders());
                    },
                    error: function (request, textStatus, errorThrown) {
                        console.log('error- h: ' + request.getResponseHeader('location') + ' - textStatus: ' + textStatus + ' - errorThrown: ' + errorThrown);
                    }

                    // data: {},
                    // dataType: "html"
                })
                // .done(function(msg) {
                //     console.log('done: '+ msg);
                // }).fail(function(jqXHR, textStatus) {
                //     console.log('fail- jqXHR:'+jqXHR.getAllResponseHeaders()+' - textStatus: '+textStatus);
                // })
                ;
            })
        });
    </script>
@endsection
