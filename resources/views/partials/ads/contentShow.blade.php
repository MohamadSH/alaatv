@if($id==='contentShowPage-leftSide-1')
    <div class="a--desktop-show">
        <a href="{{ $link  }}"
           data-toggle="m-tooltip" title="" data-placement="top" data-original-title="{{ $name }}"
           class="a--gtm-eec-advertisement a--gtm-eec-advertisement-click"
           data-gtm-eec-promotion-id="{{ $id }}"
           data-gtm-eec-promotion-name="{{ $name }}"
           data-gtm-eec-promotion-creative="{{ $creative }}"
           data-gtm-eec-promotion-position="{{ $position }}">
            <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" data-src="{{ $imgSrc }}" class="a--full-width lazy-image" alt="{{ $name }}" width="{{ $imgWidth }}" height="{{ $imgHeight }}">
        </a>
    </div>
@elseif($id==='contentShowPage-rightSide-0')
    <div class="row">
        <div class="col text-center m--margin-bottom-5 a--mobile-show a--tablet-show">
            <a href="{{ action("Web\ShopPageController") }}"
               data-toggle="m-tooltip" title="" data-placement="top" data-original-title="{{ $name }}"
               class="a--gtm-eec-advertisement a--gtm-eec-advertisement-click"
               data-gtm-eec-promotion-id="{{ $id }}"
               data-gtm-eec-promotion-name="{{ $name }}"
               data-gtm-eec-promotion-creative="{{ $creative }}"
               data-gtm-eec-promotion-position="{{ $position }}">
                <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" data-src="{{ $imgSrc }}" class="a--full-width lazy-image" alt="{{ $name }}" width="{{ $imgWidth }}" height="{{ $imgHeight }}">
            </a>
        </div>
    </div>
@endif
