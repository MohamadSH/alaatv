@if($id==='setShow-TopOfList-mobileShow')
    <div class="row">
        <div class="col a--mobile-show a--tablet-show m--margin-bottom-10">
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
    </div>
@elseif($id==='setShow-TopOfList-desktopShow')
    <a href="{{ $link  }}"
       data-toggle="m-tooltip" title="" data-placement="top" data-original-title="{{ $name }}"
       class="a--gtm-eec-advertisement a--gtm-eec-advertisement-click"
       data-gtm-eec-promotion-id="{{ $id }}"
       data-gtm-eec-promotion-name="{{ $name }}"
       data-gtm-eec-promotion-creative="{{ $creative }}"
       data-gtm-eec-promotion-position="{{ $position }}">
        <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" data-src="{{ $imgSrc }}" class="a--full-width lazy-image" alt="{{ $name }}" width="{{ $imgWidth }}" height="{{ $imgHeight }}">
    </a>
@endif
