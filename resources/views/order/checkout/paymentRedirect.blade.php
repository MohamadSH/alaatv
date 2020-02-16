@extends('partials.templatePage')
@section("pageBar")
@endsection

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
@endsection

@section("content")
    <div class="row">
        <div class="note note-info">
            <h2 class="block text-center">
                <img src="/assets/global/img/loading-spinner-blue.gif" alt="loading">
                در حال انتقال به صفحه پرداخت
            </h2>
        </div>
        <form action="{{$postUrl}}" method="{{$requestMethod}}" class="hidden" id="redirectForm">
            <input type="text" id="token" name="token" value="{{$redirectFormInfo["token"]}}" size="100px"/>
            <input type="text" id="language" name="language" value="{{$redirectFormInfo["language"]}}" size="5px"/>
            {{--<input type="submit" id="paymentRedirectSubmit" value="توکن" name="btnPymnt"/>--}}
        </form>
    </div>
@endsection

@section("extraJS")
    <script>
        $(document).ready(function () {
            $("#redirectForm").submit();
        });
    </script>
@endsection
