@if (Session::has('success'))
    <div class="custom-alerts alert alert-success fade in margin-top-10">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        <i class="fa fa-check-circle"></i>
        {!!   Session::pull('success') !!}
    </div>
@elseif(isset($success))
    <div class="custom-alerts alert alert-success fade in margin-top-10">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        <i class="fa fa-check-circle"></i>
        {{ $success }}
    </div>
@endif
@if (Session::has('error'))
    <div class="custom-alerts alert alert-danger fade in margin-top-10">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        <i class="fa fa-times-circle"></i>
        {{ Session::pull('error') }}
    </div>
@elseif (isset($error))
    <div class="custom-alerts alert alert-danger fade in margin-top-10">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        <i class="fa fa-times-circle"></i>
        {{ $error }}
    </div>
@endif
@if (Session::has('warning'))
    <div class="custom-alerts alert alert-warning fade in margin-top-10">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        <i class="fa fa-exclamation-triangle"></i>
        {{ Session::pull('warning') }}
    </div>
@endif
@if (Session::has('info'))
    <div class="custom-alerts alert alert-info fade in margin-top-10">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        <i class="fa fa-exclamation-circle"></i>
        <strong>توجه! </strong>{{ Session::pull('info') }}
    </div>
@endif

