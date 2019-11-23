<style>
    .m-portlet.transparentBack {
        background-color: transparent;
        box-shadow: none;
    }
    .m-portlet.transparentBack .m-portlet__head {
        background-color: transparent;
        border: none;
    }
    .m-portlet.transparentBack .m-portlet__body {
        padding: 0;
    }
</style>
<div class="row">
    <div class="col">
        <div class="m-portlet @if(isset($color) && $color === 'transparentBack') transparentBack @elseif(isset($color) && $color === 'red') m-portlet--danger m-portlet--head-solid-bg @endif">
            @if(isset($title))
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                @if(isset($closeIcon) && $closeIcon === true)
                                    <i class="fa fa-times"></i>
                                @endif
                                
                                @if(isset($color) && $color === 'red')
                                    <span class="whiteSquare"></span>
                                @else
                                    <span class="redSquare"></span>
                                @endif
                                
                                <p class="display-6 a--margin-0">
                                    {!! $title !!}
                                </p>
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools"></div>
                </div>
            @endif
            <div class="m-portlet__body">
                {!! $content !!}
                @if(isset($btnMoreText))
                    <div class="text-right">
                        <button type="button" class="btn m-btn--square btn-metal">
                            {{ $btnMoreText }}
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>