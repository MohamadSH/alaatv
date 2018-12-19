@extends("app")
@section("pageBar")
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "flaticon-home-2 m--padding-right-5"></i>
                <a class = "m-link" href = "{{action("HomeController@index")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item">
                <i class = "flaticon-photo-camera m--padding-right-5"></i>
                <a class = "m-link" href = "{{ action("ProductController@index") }}">محصولات آموزشی</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#"> {{ $product->name }} </a>
            </li>
        </ol>
    </nav>
@endsection
@section("content")
    @include("systemMessage.flash")
    <div class = "row" id="a_top_section">
        <div class = "col-xl-12">
            <!--begin::Portlet-->
            <div class = "m-portlet m-portlet--mobile">
                <div class = "m-portlet__body">
                    <!--begin::Section-->
                    <div class = "m-section m-section--last">
                        <div class = "m-section__content">
                            <!--begin::Preview-->
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <div class = "">
                                        <?PHP
                                        $gg =  route('image', ['category'=>'4','w'=>'338' , 'h'=>'338' ,  'filename' =>  $product->image ]);
                                        ?>
                                        <img src = "{{ str_replace('http://192.168.4.2:9071', 'https://sanatisharif.ir', $gg) }}" alt = "عکس محصول@if(isset($product->name[0])) {{$product->name}} @endif" class = "img-fluid m--marginless"/>
                                    </div>
                                    @if(isset($productSamplePhotos) && $productSamplePhotos->isNotEmpty())
                                        <div class="m--space-10"></div>
                                        <h5>نمونه جزوه</h5>
                                        <div class="m-nav-grid">
                                            @foreach ($productSamplePhotos->chunk(3) as $chunk)
                                                <div class="m-nav-grid__row">
                                                    @foreach ($chunk as $samplePhoto)
                                                        <a href="{{ route('image', ['category'=>'4','w'=>'1400' , 'h'=>'2000' ,  'filename' =>  $samplePhoto->file ]) }}"
                                                           target="_blank"
                                                           class="m-nav-grid__item">
                                                            <?PHP
                                                            $gg = route('image', ['category'=>'4','w'=>'100' , 'h'=>'135' ,  'filename' =>  $samplePhoto->file ]);

                                                            echo $gg;
                                                            ?>
                                                            <img src="{{ str_replace('http://192.168.4.2:9071', 'https://sanatisharif.ir', $gg)  }}"
                                                                 alt="@if(isset($samplePhoto->title[0])) {{$samplePhoto->title}} @else نمونه عکس {{$product->name}} @endif">
                                                            {{--<span class="m-nav-grid__text">{{ isset($samplePhoto->title[0]) ? $samplePhoto->title : '--' }}</span>
                                                            <br>--}}
                                                            <span class="m-nav-grid__text">{{ isset($samplePhoto->description[0]) ? $samplePhoto->description : '--' }}</span>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                </div>
                                <div class = "col-lg-6">
                                    <div class = "m-demo" data-code-preview = "true" data-code-html = "true" data-code-js = "false">
                                        <div class = "m-demo__preview">
                                            {!! Form::open(['method' => 'POST','action' => ['OrderproductController@store'] ]) !!}
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="m-list-search">
                                                        <div class="m-list-search__results">
                                                            <span class="m-list-search__result-category m-list-search__result-category--first">
                                                                ویژگی‌ها
                                                            </span>
                                                            @foreach($simpleInfoAttributes as $key => $simpleInfoAttribute)
                                                                <a href="#" class="m-list-search__result-item">
                                                                    <span class="m-list-search__result-item-icon"><i class="flaticon-like m--font-warning"></i></span>
                                                                    <span class="m-list-search__result-item-text">{{$key . ': ' . collect($simpleInfoAttribute)->implode('name',',') }}</span>
                                                                </a>
                                                                @foreach($simpleInfoAttribute as $k => $info)
                                                                    @if(isset($info["type"]) && strcmp($info["type"],"information") != 0 )
                                                                        <input type = "hidden" value = "{{ $info["value"] }}" name = "attribute[]">
                                                                    @endif
                                                                @endforeach
                                                            @endforeach

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    @if(isset($checkboxInfoAttributes) && !$checkboxInfoAttributes->isEmpty())
                                                        <div class="m-list-search">
                                                            <div class="m-list-search__results">
                                                            <span class="m-list-search__result-category m-list-search__result-category--first">
                                                                دارای
                                                            </span>
                                                                @foreach($checkboxInfoAttributes as $checkboxArray)
                                                                    @foreach($checkboxArray as $info)
                                                                        <a href="#" class="m-list-search__result-item">
                                                                            <span class="m-list-search__result-item-icon"><i class="la la-check m--font-focus"></i></span>
                                                                            <span class="m-list-search__result-item-text">{{ $info["index"]  }}</span>
                                                                        </a>
                                                                    @endforeach
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                                <div class = "m-separator m-separator--space m-separator--dashed"></div>


                                                @if((isset($extraSelectCollection) && !$extraSelectCollection->isEmpty()) ||
                                                    (isset($extraCheckboxCollection) && !$extraCheckboxCollection->isEmpty()))
                                                    <div class="portlet sale-summary">
                                                        <div class="portlet-title">
                                                            <div class="caption font-red sbold">انتخاب خدمت</div>
                                                        </div>
                                                        <div class="portlet-body">
                                                            <ul class="list-unstyled">
                                                                <li style="margin: 0% 5% 0% 5%">
                                                                    @include("product.partials.extraSelectCollection")
                                                                    @include("product.partials.extraCheckboxCollection" , ["withExtraCost"])
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class = "m-separator m-separator--space m-separator--dashed"></div>
                                                @endif

                                                @if(in_array($productType ,[Config::get("constants.PRODUCT_TYPE_SELECTABLE")]))

                                                    <ul class = "m-nav m-nav--active-bg" id = "m_nav" role = "tablist">
                                                        @if(isset($product->children) && !empty($product->children))
                                                            @foreach($product->children as $p)
                                                                @include('product.partials.showChildren',['product' => $p , 'color' => 1])
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                    <div class = "m-separator m-separator--space m-separator--dashed"></div>
                                                @elseif(in_array($productType ,[Config::get("constants.PRODUCT_TYPE_SIMPLE")]))

                                                @elseif(in_array($productType, [Config::get("constants.PRODUCT_TYPE_CONFIGURABLE")]))
                                                        @if((isset($selectCollection) && !$selectCollection->isEmpty()) ||
                                                         (isset($groupedCheckboxCollection) && !$groupedCheckboxCollection->isEmpty()))
                                                            <li style="margin: 0% 5% 0% 5%">
                                                                @if(isset($selectCollection))
                                                                    @foreach($selectCollection as $index => $select)

                                                                        <span class="sale-info"> {{ $index }}
                                                                            <i class="fa fa-img-up"></i>
                                                                                                            </span>
                                                                        {!! Form::select('attribute[]',$select,null,['class' => 'form-control attribute']) !!}

                                                                    @endforeach
                                                                @endif
                                                                @if(isset($groupedCheckboxCollection))
                                                                    <div class="input-group">
                                                                        <div class="icheck-list">
                                                                            @foreach($groupedCheckboxCollection as $checkboxArray)
                                                                                @foreach($checkboxArray as $index => $checkbox)
                                                                                    <label>
                                                                                        {!! Form::checkbox('attribute[]', $index, null, ['class' => 'attribute icheck' , 'data-checkbox'=>'icheckbox_square-blue']) !!}
                                                                                        @if(isset($checkbox["index"])) {{$checkbox["index"]}} @endif
                                                                                        @if(isset($checkbox["extraCost"][0]))
                                                                                            (
                                                                                            <span style="@if(isset($checkbox["extraCostWithDiscount"][0])) text-decoration: line-through;  @endif">{{$checkbox["extraCost"]}}</span>
                                                                                            @if(isset($checkbox["extraCostWithDiscount"][0]))
                                                                                                <span class="bg-font-dark"
                                                                                                      style="background: #ff7272;    padding: 0px 5px 0px 5px;">برای شما </span>
                                                                                                <span class="bg-font-dark"
                                                                                                      style="background: #ee5053;    padding: 0px 5px 0px 5px;">{{$checkbox["extraCostWithDiscount"]}}</span>
                                                                                            @endif
                                                                                        @endif
                                                                                    </label>
                                                                                @endforeach
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </li>
                                                        @endif
                                                @endif
                                                {!! Form::hidden('product_id',$product->id) !!}
                                                @if($product->enable)
                                                    <h5 class="m--font-danger">
                                                        <span id="a_product-price">
                                                            {{ $product->priceText }}
                                                        </span>
                                                        <span id = "a_product-discount"></span>
                                                    </h5>

                                                    <a href="{{ action("OrderproductController@store", $product)  }}" class="btn btn-primary btn-lg m-btn  m-btn m-btn--icon">
                                                        <span>
                                                            <i class="flaticon-shopping-basket"></i>
                                                            <span>افزودن به سبد خرید</span>
                                                        </span>
                                                    </a>
                                                @else
                                                    <a href="#" class="btn btn-danger btn-lg m-btn  m-btn m-btn--icon">
                                                            <span>
                                                                <i class="flaticon-shopping-basket"></i>
                                                                <span>این محصول غیر فعال است.</span>
                                                            </span>
                                                    </a>
                                                @endif
                                            {!! Form::close() !!}
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-3">
                                    @if(isset($giftCollection) && $giftCollection->isNotEmpty())
                                        <div class="portlet sale-summary">
                                            <div class="portlet-title">
                                                <div class="caption font-red sbold"><img
                                                            src="/acm/extra/gift-box.png" width="25"> محصولات
                                                                                                      هدیه
                                                </div>
                                            </div>
                                            <div class="portlet-body" style="padding: 0px">
                                                <ul class="list-unstyled">
                                                    @foreach($giftCollection as $gift)
                                                        <li class="text-center bold">
                                                            @if(strlen($gift["link"])>0)
                                                                <a target="_blank"
                                                                   href="{{$gift["link"]}}">{{$gift["product"]->name}}</a>
                                                            @else
                                                                {{$gift["product"]->name}}
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                    @if(isset($product->introVideo))
                                        <div class="portlet solid light grey-mint">
                                            <div class="portlet-title">
                                                <div class="caption bg-font-dark sbold">کلیپ معرفی</div>
                                            </div>
                                            <div class="portlet-body">
                                                <video controls style="width: 100%">
                                                    <source src="{{$product->introVideo}}" type="video/mp4">
                                                    <span class="bold font-red">مرورگر شما HTML5 را پشتیبانی نمی کند</span>
                                                </video>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!--end::Preview-->
                        </div>
                    </div>
                    <!--end::Section-->
                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
    @if(isset($product->specialDescription))
        <div class = "row">
            {!! $product->specialDescription !!}
        </div>
    @endif
    <div class = "row">
        <div class = "col-xl-12">
            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-progress">
                        <div class="progress m-progress--sm">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="m-portlet__head-wrapper">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-notepad"></i>
						</span>
                                <h3 class="m-portlet__head-text">
                                    بررسی محصول {{ $product->name }}
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary  m-btn m-btn--icon m-btn--wide m-btn--md">
                                    <span>
                                        <i class="flaticon-shopping-basket"></i>
                                        <span>افزودن به سبد خرید</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <form class="m-form m-form--label-align-left- m-form--state-" id="m_form">
                        <!--begin: Form Body -->
                        <div class="m-portlet__body">
                            <div class="row">
                                <div class="col-xl-8 offset-xl-2">
                                    {!! $product->shortDescription !!}
                                    @if( isset($product->longDescription[0] ) )
                                        <div>
                                            {!!   $product->longDescription !!}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <!--end::Portlet-->
        </div>
    </div>
@endsection
