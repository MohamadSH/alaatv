<div class="row">
    <div class="col">

        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                </button>
                <strong>
                    {!!   Session::pull('success') !!}
                </strong>
            </div>
        @elseif(isset($success))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                </button>
                <strong>
                    {{ $success }}
                </strong>
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                </button>
                <strong>
                    {{ Session::pull('error') }}
                </strong>
            </div>
        @elseif (isset($error))
            <div class="custom-alerts alert alert-danger fade in margin-top-10">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <i class="fa fa-times-circle"></i>
                {{ $error }}
            </div>
        @endif
        @if (Session::has('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                </button>
                <strong>
                    {{ Session::pull('warning') }}
                </strong>
            </div>
        @endif
        @if (Session::has('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                </button>
                <strong>توجه! </strong>{{ Session::pull('info') }}
            </div>
        @endif


    </div>
</div>