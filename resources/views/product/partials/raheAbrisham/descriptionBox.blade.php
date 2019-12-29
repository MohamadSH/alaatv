<div class="row @if(isset($class)) {{$class}} @endif descriptionBox">
    <div class="col">
        <div class="m-portlet @if(isset($color) && $color === 'transparentBack') transparentBack @elseif(isset($color) && $color === 'red') m-portlet--danger m-portlet--head-solid-bg @endif">
            @if(isset($title))
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                @if(isset($closeIcon) && $closeIcon === true)
                                    <i class="fa fa-times btnCloseDescriptionBox"></i>
                                @endif

                                @if(isset($color) && $color === 'red')
                                    <span class="whiteSquare"></span>
                                @else
                                    <span class="redSquare"></span>
                                @endif

                                <p class="display-6 m--marginless">
                                    {!! $title !!}
                                </p>
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools"></div>
                </div>
            @endif
            <div class="m-portlet__body">
                <div class="content @if(isset($btnMoreText) && $btnMoreText!==false) compact @endif">
                    {!! $content !!}
                </div>
                @if(isset($btnMoreText) && $btnMoreText!==false)
                    <div class="text-right">
                        <button type="button" class="btn m-btn--square btn-metal readMoreBtn @if(isset($btnMoreClass)) {{$btnMoreClass}} @endif" data-read-more-text="{{ $btnMoreText }}">
                            {{ $btnMoreText }}
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
