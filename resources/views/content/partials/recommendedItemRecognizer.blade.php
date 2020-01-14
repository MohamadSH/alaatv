@foreach($recommendedItems as $key => $recommendedItem)
    @if($recommendedItem->item_type === 'product')
        @include('partials.widgets.ScollCarousel.items.product.type2', [
            'product'=>$recommendedItem,
            'gtmEecList'=>$gtmEecList,
            'responsiveClass'=>'',
            'productKey'=>$key,
            'key'=>$key,
            'sort'=>(isset($sort) ? $sort : false)
        ])
    @elseif($recommendedItem->item_type === 'set')
        @include('partials.widgets.ScollCarousel.items.set.type1', [
            'set'=>$recommendedItem,
            'responsiveClass'=>'',
            'key'=>$key,
            'sort'=>(isset($sort) ? $sort : false)
        ])
    @elseif($recommendedItem->item_type === 'content')
        @include('partials.widgets.ScollCarousel.items.content.type1', [
            'content'=>$recommendedItem,
            'responsiveClass'=>'',
            'key'=>$key,
            'sort'=>(isset($sort) ? $sort : false)
        ])
    @endif
@endforeach
