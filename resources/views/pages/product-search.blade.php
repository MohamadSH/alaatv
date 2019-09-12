@extends("app" , ["pageName"=>"productsPortfolio"])

@section("pageBar")
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home"></i>
                <a class="m-link" href="{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <i class="fa fa-chalkboard-teacher"></i>
                محصولات آموزشی
            </li>
        </ol>
    </nav>
@endsection

@section("content")

    <div class="row justify-content-center">
        @if($products->isEmpty())
            <div class="alert alert-info" role="alert">
                <strong>
                    کاربر گرامی در حال حاضر موردی برای ثبت نام وجود ندارد. همایشها و اردوهای بعدی به زودی اعلام خواهند شد.
                </strong>
            </div>
        @else
            @foreach($products as $product)
                @include('partials.widgets.product1',[
                'widgetTitle'      => $product->name,
                'widgetPic'        => $product->photo,
                'widgetLink'       => action("Web\ProductController@show", $product),
                'widgetTagsQuery'  => $tagsQuery,
                'widgetPrice'      => $product->price,
                'widgetPriceLabel' => ($product->isFree || $product->basePrice == 0 ? 0 : 1)
                ])
            @endforeach
        @endif
    </div>
    <div class="row">
        <div class="col-xl-12 m--align-center">
            <div class="m--block-inline">
                {{ $products->links() }}
            </div>

        </div>
    </div>
@endsection

