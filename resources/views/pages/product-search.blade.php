@extends("app" , ["pageName"=>"productsPortfolio"])

@section('right-aside')
@endsection

@section("pageBar")
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "flaticon-home-2"></i>
                <a class = "m-link" href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <i class = "fa fa-chalkboard-teacher"></i>
                محصولات آموزشی
            </li>
        </ol>
    </nav>
@endsection

@section("content")
    <div class = "row justify-content-center">
        @if($products->isEmpty())
            <div class = "note " style = "background-color: #00d4db;">
                <h4 class = "block bold" style = "text-align: center">کاربر گرامی در حال حاضر موردی برای ثبت نام وجود ندارد. همایشها و اردوهای بعدی به زودی اعلام خواهند شد.</h4>
            </div>
        @else
            @foreach($products as $product)
                @include('partials.widgets.product1',[
                'widgetTitle'      => $product->name,
                'widgetPic'        => $product->photo,
                'widgetLink'       => action("Web\ProductController@show", $product),
                'widgetPrice'      => $product->priceText,
                'widgetPriceLabel' => ($product->isFree || $product->basePrice == 0 ? 0 : 1)
                ])
            @endforeach
        @endif
    </div>
    <div class = "row">
        <div class = "col-xl-12 m--align-center">
            <div class = "m--block-inline">
                {{ $products->links() }}
            </div>

        </div>
    </div>
@endsection

