<div class="row" id="a_top_section">
    <div class="col">
        <!--begin::Portlet-->
        <div class="m-portlet">
            <div class="m-portlet__body">

                @include('partials.favorite', [
                    'favActionUrl' => route('web.mark.favorite.product', [ 'product' => $product->id ]),
                    'unfavActionUrl' => route('web.mark.unfavorite.product', [ 'product' => $product->id ]),
                    'isFavored' => $isFavored
                ])

                <!--begin::Section-->
                <div class="m-section m-section--last">
                    <div class="m-section__content">
                        <!--begin::Preview-->
                        <div class="row PicAttributesIntroVideoRow">
                            <div class="col-lg-3 col-md-4 productPicColumn">
                                <div>
                                    <img src="{{$product->photo}}?w=400&h=400" alt="عکس محصول@if(isset($product->name)) {{$product->name}} @endif" class="img-fluid m--marginless a--full-width"/>
                                </div>

                            </div>
                            <div class="col-lg-5 col-md-8 productAttributesColumn">


                                {{--ویژگی ها و دارای --}}
                                <div class="row productAttributesRows">
                                    @if(optional(optional(optional($product->attributes)->get('information'))->where('control', 'simple'))->count()>0 ||  optional(optional( optional($product->attributes)->get('main'))->where('control', 'simple'))->count()>0)
                                        <div class="col">

                                            <div class="m-portlet m-portlet--bordered productAttributes">
                                                <div class="m-portlet__head">
                                                    <div class="m-portlet__head-caption">
                                                        <div class="m-portlet__head-title">
                                                            <h3 class="m-portlet__head-text">
                                                                ویژگی های محصول
                                                                 {{$product->name}}
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="m-portlet__body m--padding-top-5 m--padding-bottom-5 m--padding-right-10 m--padding-left-10">

                                                    <div class="row no-gutters attributeRow">
                                                        <div class="col">
                                                            <div class="productAttributesBox">
                                                                <div class="title">
                                                                    <div class="icon">
                                                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 60 60" xml:space="preserve">
                                                                            <g>
                                                                                <path d="M57,4h-7V1c0-0.553-0.447-1-1-1h-7c-0.553,0-1,0.447-1,1v3H19V1c0-0.553-0.447-1-1-1h-7c-0.553,0-1,0.447-1,1v3H3   C2.447,4,2,4.447,2,5v11v43c0,0.553,0.447,1,1,1h54c0.553,0,1-0.447,1-1V16V5C58,4.447,57.553,4,57,4z M43,2h5v3v3h-5V5V2z M12,2h5   v3v3h-5V5V2z M4,6h6v3c0,0.553,0.447,1,1,1h7c0.553,0,1-0.447,1-1V6h22v3c0,0.553,0.447,1,1,1h7c0.553,0,1-0.447,1-1V6h6v9H4V6z    M4,58V17h52v41H4z"/>
                                                                                <path d="M38,23h-7h-2h-7h-2h-9v9v2v7v2v9h9h2h7h2h7h2h9v-9v-2v-7v-2v-9h-9H38z M31,25h7v7h-7V25z M38,41h-7v-7h7V41z M22,34h7v7h-7   V34z M22,25h7v7h-7V25z M13,25h7v7h-7V25z M13,34h7v7h-7V34z M20,50h-7v-7h7V50z M29,50h-7v-7h7V50z M38,50h-7v-7h7V50z M47,50h-7   v-7h7V50z M47,41h-7v-7h7V41z M47,25v7h-7v-7H47z"/>
                                                                            </g>
                                                                        </svg>
                                                                    </div>
                                                                    <div class="text">
                                                                        سال تولید:
                                                                    </div>
                                                                </div>
                                                                <div class="value">
                                                                    {{implode('، ',(array)$product->info_attributes['productionYear'])}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="productAttributesBox">
                                                                <div class="title">
                                                                    <div class="icon">
                                                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 60 60" xml:space="preserve">
                                                                            <path d="M13,0c-1.547,0-3.033,0.662-4.078,1.817C7.895,2.954,7.389,4.476,7.525,6H7.5v48.958C7.5,57.738,9.762,60,12.542,60H52.5V11  V9V0H13z M9.5,54.958V9.998c0.836,0.629,1.875,1.002,3,1.002v46.996C10.842,57.973,9.5,56.621,9.5,54.958z M50.5,58h-36V11h3v25.201  c0,0.682,0.441,1.262,1.099,1.444c0.137,0.037,0.273,0.056,0.408,0.056c0.015,0,0.029-0.005,0.044-0.006  c0.045-0.001,0.088-0.012,0.133-0.017c0.103-0.012,0.202-0.033,0.299-0.066c0.048-0.016,0.093-0.035,0.138-0.056  c0.094-0.043,0.18-0.097,0.263-0.159c0.036-0.027,0.073-0.05,0.106-0.08c0.111-0.099,0.212-0.211,0.292-0.346l4.217-7.028  l4.217,7.029c0.327,0.545,0.939,0.801,1.55,0.687c0.045-0.008,0.089-0.002,0.134-0.014c0.657-0.183,1.099-0.763,1.099-1.444V11h19  V58z M29.64,9.483l-0.003,0.007L29.5,9.764v0.042l-0.1,0.23l0.1,0.152v0.112V34.39l-5-8.333l-5,8.333V10.236L21.118,7h9.764  L29.64,9.483z M32.118,9l2-4H19.882l-2,4h-4.67c-1.894,0-3.516-1.379-3.693-3.14c-0.101-0.998,0.214-1.957,0.887-2.701  C11.071,2.422,12.017,2,13,2h37.5v1h-5c-0.553,0-1,0.447-1,1s0.447,1,1,1h5v1h-4c-0.553,0-1,0.447-1,1s0.447,1,1,1h4v1H32.118z"/>
                                                                        </svg>
                                                                    </div>
                                                                    <div class="text">
                                                                        رشته:
                                                                    </div>
                                                                </div>
                                                                <div class="value">
                                                                    {{implode('، ',(array)$product->info_attributes['major'])}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="productAttributesBox">
                                                                <div class="title">
                                                                    <div class="icon">
                                                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 60 60" xml:space="preserve">
                                                                            <path d="M48.937,21.001l8.994-8.095c0.257-0.229,0.405-0.561,0.405-0.906c0-0.345-0.148-0.676-0.402-0.902l-8.997-8.097H29.664V1  c0-0.553-0.448-1-1-1s-1,0.447-1,1v2.001H10.061c-1.873,0-3.396,1.523-3.396,3.396v11.206c0,1.873,1.523,3.397,3.396,3.397h17.604  V23H11.063l-8.998,8.098C1.81,31.328,1.664,31.656,1.664,32s0.146,0.672,0.402,0.903L11.063,41h16.601v18c0,0.553,0.448,1,1,1  s1-0.447,1-1V41h20.604c1.873,0,3.396-1.523,3.396-3.396V26.396c0-1.873-1.523-3.396-3.396-3.396H29.664v-1.999H48.937z   M51.664,26.396v11.207c0,0.771-0.626,1.396-1.396,1.396H11.831l-7.778-7l7.778-7h38.437C51.038,25,51.664,25.626,51.664,26.396z   M8.664,17.604V6.397c0-0.771,0.626-1.396,1.396-1.396h38.108l7.778,7l-7.778,7H10.061C9.291,19.001,8.664,18.374,8.664,17.604z"/>
                                                                        </svg>
                                                                    </div>
                                                                    <div class="text">
                                                                        نظام کنکور:
                                                                    </div>
                                                                </div>
                                                                <div class="value">
                                                                    {{implode('،',(array)$product->info_attributes['educationalSystem'])}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="productAttributesBox">
                                                                <div class="title">
                                                                    <div class="icon">
                                                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 59 59" xml:space="preserve">
                                                                            <g>
                                                                                <path d="M20.187,28.313c-0.391-0.391-1.023-0.391-1.414,0s-0.391,1.023,0,1.414l9.979,9.979C28.938,39.895,29.192,40,29.458,40   c0.007,0,0.014-0.004,0.021-0.004c0.007,0,0.013,0.004,0.021,0.004c0.333,0,0.613-0.173,0.795-0.423l9.891-9.891   c0.391-0.391,0.391-1.023,0-1.414s-1.023-0.391-1.414,0L30.5,36.544V1c0-0.553-0.447-1-1-1s-1,0.447-1,1v35.628L20.187,28.313z"/>
                                                                                <path d="M36.5,16c-0.553,0-1,0.447-1,1s0.447,1,1,1h13v39h-40V18h13c0.553,0,1-0.447,1-1s-0.447-1-1-1h-15v43h44V16H36.5z"/>
                                                                            </g>
                                                                        </svg>
                                                                    </div>
                                                                    <div class="text">
                                                                        مدل دریافت
                                                                    </div>
                                                                </div>
                                                                <div class="value">
                                                                    {{implode('،',(array)$product->info_attributes['shippingMethod'])}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="productAttributesBox">
                                                                <div class="title">
                                                                    <div class="icon">
                                                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 60 60" xml:space="preserve">
                                                                            <g>
                                                                                <path d="M59,6H1C0.447,6,0,6.447,0,7v38c0,0.553,0.447,1,1,1h26v3h-5v5h16v-5h-5v-3h26c0.553,0,1-0.447,1-1V7   C60,6.447,59.553,6,59,6z M36,51v1H24v-1h5v-5h2v5H36z M58,44H33h-6H2V8h56V44z"/>
                                                                                <path d="M55,34H42.374l-0.085-0.075c-0.353-0.312-0.73-0.571-1.125-0.775l-4.621-2.989l-0.096-0.055   c-0.35-0.175-0.738-0.256-1.08-0.328c-0.109-0.022-0.251-0.053-0.367-0.083v-1.302c0.045-0.03,0.092-0.063,0.14-0.096   c0.677-0.466,0.994-0.699,1.185-0.968c0.693-0.981,1.387-2.037,1.83-3.171c0.961-0.44,1.846-1.29,1.846-2.369v-2.245   c0-0.413-0.162-0.816-0.48-1.196c-0.237-0.284-0.52-0.744-0.52-1.32v-1.054C38.937,13.562,37.183,9,31,9s-7.937,4.562-8,7v1.027   c0,0.576-0.282,1.036-0.519,1.319C22.162,18.728,22,19.131,22,19.544v2.245c0,0.964,0.793,1.647,1.353,2.04   c0.666,2.016,2.682,3.515,3.647,4.138v1.327c-0.261,0.254-1.059,0.633-1.416,0.803c-0.22,0.105-0.414,0.198-0.58,0.289l-4.685,2.72   c-0.396,0.216-0.777,0.496-1.132,0.83L19.119,34H14v7h41V34z M25.985,32.129c0.117-0.064,0.277-0.14,0.458-0.226   C27.582,31.361,29,30.687,29,29.455V26.81l-0.521-0.284c-0.787-0.429-2.912-1.902-3.289-3.547l-0.091-0.396l-0.341-0.221   c-0.618-0.399-0.734-0.604-0.758-0.573v-2.141c0.004-0.004,0.009-0.01,0.016-0.02C24.65,18.869,25,17.944,25,17.027v-1.001   C25.005,15.821,25.199,11,31,11c5.656,0,5.982,4.516,6,5v1.027c0,0.905,0.34,1.816,1,2.627l0.001,2.121   c-0.033,0.142-0.438,0.51-0.929,0.66l-0.497,0.153l-0.16,0.496c-0.339,1.053-1.028,2.106-1.673,3.026   c-0.103,0.102-0.516,0.386-0.737,0.539c-0.424,0.292-0.617,0.428-0.756,0.585L33,27.519V30c0,1.325,1.321,1.602,1.956,1.735   c0.203,0.042,0.431,0.09,0.56,0.143L38.796,34H22.761L25.985,32.129z M53,39H16v-3h4.069h21.379H53V39z"/>
                                                                                <path d="M55,10h-6v6h6V10z M53,14h-2v-2h2V14z"/>
                                                                                <path d="M12,34H5v7h7V34z M10,39H7v-3h3V39z"/>
                                                                            </g>
                                                                        </svg>
                                                                    </div>
                                                                    <div class="text">
                                                                        دبیر:
                                                                    </div>
                                                                </div>
                                                                <div class="value">
                                                                    {{implode('،',(array)$product->info_attributes['teacher'])}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row servicesRows">
                                                        <div class="col-12 servicesRow">
                                                            <span>
                                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.001 512.001" width="25" xml:space="preserve">
                                                                    <g transform="translate(0 -1)">
                                                                        <polygon style="fill:#FFFFFF;" points="256.001,478.877 256.001,171.677 8.534,171.677  "/>
                                                                        <g>
                                                                            <polygon style="fill:#A4C2F7;" points="256.001,478.877 256.001,171.677 503.467,171.677   "/>
                                                                            <polygon style="fill:#A4C2F7;" points="503.467,171.677 179.201,171.677 264.534,35.143 418.134,35.143   "/>
                                                                        </g>
                                                                        <polygon style="fill:#FFFFFF;" points="332.801,171.677 8.534,171.677 93.867,35.143 247.467,35.143  "/>

                                                                            <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="-48.7194" y1="653.6632" x2="-48.0494" y2="653.019" gradientTransform="matrix(426.6667 0 0 -443.7334 20900.0254 290102.25)">
                                                                            <stop offset="0" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.1717" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.2" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.2001" style="stop-color:#DAE4F4"/>
                                                                            <stop offset="0.2007" style="stop-color:#EBEBF4"/>
                                                                            <stop offset="0.2014" style="stop-color:#F6F1F4"/>
                                                                            <stop offset="0.2023" style="stop-color:#FDF4F4"/>
                                                                            <stop offset="0.205" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.2522" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.26" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.26" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.3974" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.42" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.4201" style="stop-color:#DAE4F4"/>
                                                                            <stop offset="0.4207" style="stop-color:#EBEBF4"/>
                                                                            <stop offset="0.4214" style="stop-color:#F6F1F4"/>
                                                                            <stop offset="0.4223" style="stop-color:#FDF4F4"/>
                                                                            <stop offset="0.425" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.4894" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.5" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.5" style="stop-color:#F9F2F4"/>
                                                                            <stop offset="0.5001" style="stop-color:#E8EBF4"/>
                                                                            <stop offset="0.5003" style="stop-color:#DDE5F4"/>
                                                                            <stop offset="0.5005" style="stop-color:#D6E2F4"/>
                                                                            <stop offset="0.501" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.7062" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.74" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.741" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.8346" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.85" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.851" style="stop-color:#D4E1F4"/>
                                                                        </linearGradient>
                                                                        <polygon style="fill:url(#SVGID_1_);" points="384.001,35.143 128.001,35.143 42.667,171.677 256.001,478.877 460.801,171.677    469.334,171.677  "/>
                                                                        <g>
                                                                            <path style="fill:#428DFF;" d="M256.001,487.41c-2.582,0.002-5.026-1.169-6.642-3.183L1.892,177.027    c-2.064-2.557-2.475-6.072-1.057-9.036c1.418-2.964,4.413-4.85,7.699-4.847h494.933c3.286-0.003,6.281,1.883,7.699,4.847    c1.418,2.964,1.007,6.48-1.057,9.036l-247.467,307.2C261.027,486.241,258.583,487.413,256.001,487.41L256.001,487.41z     M26.367,180.21l229.633,285.067L485.634,180.21H26.367z"/>
                                                                            <path style="fill:#428DFF;" d="M503.467,180.21H8.534c-3.103,0.001-5.962-1.683-7.465-4.397c-1.504-2.714-1.415-6.031,0.232-8.661    L86.634,30.618c1.559-2.493,4.293-4.008,7.233-4.008h324.267c2.941,0,5.674,1.515,7.233,4.008l85.333,136.533    c1.647,2.63,1.735,5.947,0.232,8.661C509.429,178.527,506.57,180.211,503.467,180.21z M23.934,163.143h464.133L413.401,43.677    h-314.8L23.934,163.143z"/>
                                                                            <path style="fill:#428DFF;" d="M256.001,487.41c-3.585,0.001-6.788-2.24-8.017-5.608L85.851,38.068    c-1.615-4.427,0.664-9.326,5.092-10.942c4.427-1.615,9.326,0.664,10.942,5.092l162.133,443.733    c0.955,2.617,0.572,5.535-1.024,7.817S258.786,487.41,256.001,487.41z"/>
                                                                            <path style="fill:#428DFF;" d="M256.001,478.877c-2.796,0.002-5.415-1.366-7.01-3.661c-1.596-2.295-1.965-5.227-0.99-7.847    l162.133-435.2c1.643-4.418,6.557-6.668,10.975-5.025c4.418,1.643,6.668,6.557,5.025,10.975l-162.133,435.2    C262.756,476.66,259.566,478.876,256.001,478.877z"/>
                                                                            <path style="fill:#428DFF;" d="M145.059,180.21c-3.292-0.001-6.289-1.896-7.703-4.869c-1.413-2.973-0.991-6.494,1.086-9.048    L249.376,29.76c2.977-3.646,8.343-4.195,11.996-1.226s4.214,8.333,1.254,11.993L151.692,177.06    C150.069,179.057,147.632,180.214,145.059,180.21L145.059,180.21z"/>
                                                                            <path style="fill:#428DFF;" d="M366.943,180.21c-2.573,0.004-5.01-1.153-6.633-3.15L249.376,40.527    c-1.932-2.366-2.452-5.584-1.365-8.438c1.088-2.854,3.617-4.91,6.634-5.391c3.016-0.481,6.06,0.687,7.981,3.062l110.933,136.533    c2.077,2.554,2.5,6.075,1.086,9.048C373.232,178.314,370.234,180.209,366.943,180.21L366.943,180.21z"/>
                                                                        </g>
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                            <span class="servicesCategory">خدماتی که دریافت می کنید:</span>
                                                            @foreach($product->info_attributes['services'] as $s)
                                                                <span class="servicesBadge"> {{ $s }} </span>
                                                            @endforeach
                                                        </div>
                                                        <div class="col-12 servicesRow">
                                                            @if(isset($product->info_attributes['courseDuration']))
                                                            <span>
                                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.001 512.001" width="25" xml:space="preserve">
                                                                    <g transform="translate(0 -1)">
                                                                        <polygon style="fill:#FFFFFF;" points="256.001,478.877 256.001,171.677 8.534,171.677  "/>
                                                                        <g>
                                                                            <polygon style="fill:#A4C2F7;" points="256.001,478.877 256.001,171.677 503.467,171.677   "/>
                                                                            <polygon style="fill:#A4C2F7;" points="503.467,171.677 179.201,171.677 264.534,35.143 418.134,35.143   "/>
                                                                        </g>
                                                                        <polygon style="fill:#FFFFFF;" points="332.801,171.677 8.534,171.677 93.867,35.143 247.467,35.143  "/>

                                                                            <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="-48.7194" y1="653.6632" x2="-48.0494" y2="653.019" gradientTransform="matrix(426.6667 0 0 -443.7334 20900.0254 290102.25)">
                                                                            <stop offset="0" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.1717" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.2" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.2001" style="stop-color:#DAE4F4"/>
                                                                            <stop offset="0.2007" style="stop-color:#EBEBF4"/>
                                                                            <stop offset="0.2014" style="stop-color:#F6F1F4"/>
                                                                            <stop offset="0.2023" style="stop-color:#FDF4F4"/>
                                                                            <stop offset="0.205" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.2522" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.26" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.26" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.3974" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.42" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.4201" style="stop-color:#DAE4F4"/>
                                                                            <stop offset="0.4207" style="stop-color:#EBEBF4"/>
                                                                            <stop offset="0.4214" style="stop-color:#F6F1F4"/>
                                                                            <stop offset="0.4223" style="stop-color:#FDF4F4"/>
                                                                            <stop offset="0.425" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.4894" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.5" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.5" style="stop-color:#F9F2F4"/>
                                                                            <stop offset="0.5001" style="stop-color:#E8EBF4"/>
                                                                            <stop offset="0.5003" style="stop-color:#DDE5F4"/>
                                                                            <stop offset="0.5005" style="stop-color:#D6E2F4"/>
                                                                            <stop offset="0.501" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.7062" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.74" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.741" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.8346" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.85" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.851" style="stop-color:#D4E1F4"/>
                                                                        </linearGradient>
                                                                        <polygon style="fill:url(#SVGID_1_);" points="384.001,35.143 128.001,35.143 42.667,171.677 256.001,478.877 460.801,171.677    469.334,171.677  "/>
                                                                        <g>
                                                                            <path style="fill:#428DFF;" d="M256.001,487.41c-2.582,0.002-5.026-1.169-6.642-3.183L1.892,177.027    c-2.064-2.557-2.475-6.072-1.057-9.036c1.418-2.964,4.413-4.85,7.699-4.847h494.933c3.286-0.003,6.281,1.883,7.699,4.847    c1.418,2.964,1.007,6.48-1.057,9.036l-247.467,307.2C261.027,486.241,258.583,487.413,256.001,487.41L256.001,487.41z     M26.367,180.21l229.633,285.067L485.634,180.21H26.367z"/>
                                                                            <path style="fill:#428DFF;" d="M503.467,180.21H8.534c-3.103,0.001-5.962-1.683-7.465-4.397c-1.504-2.714-1.415-6.031,0.232-8.661    L86.634,30.618c1.559-2.493,4.293-4.008,7.233-4.008h324.267c2.941,0,5.674,1.515,7.233,4.008l85.333,136.533    c1.647,2.63,1.735,5.947,0.232,8.661C509.429,178.527,506.57,180.211,503.467,180.21z M23.934,163.143h464.133L413.401,43.677    h-314.8L23.934,163.143z"/>
                                                                            <path style="fill:#428DFF;" d="M256.001,487.41c-3.585,0.001-6.788-2.24-8.017-5.608L85.851,38.068    c-1.615-4.427,0.664-9.326,5.092-10.942c4.427-1.615,9.326,0.664,10.942,5.092l162.133,443.733    c0.955,2.617,0.572,5.535-1.024,7.817S258.786,487.41,256.001,487.41z"/>
                                                                            <path style="fill:#428DFF;" d="M256.001,478.877c-2.796,0.002-5.415-1.366-7.01-3.661c-1.596-2.295-1.965-5.227-0.99-7.847    l162.133-435.2c1.643-4.418,6.557-6.668,10.975-5.025c4.418,1.643,6.668,6.557,5.025,10.975l-162.133,435.2    C262.756,476.66,259.566,478.876,256.001,478.877z"/>
                                                                            <path style="fill:#428DFF;" d="M145.059,180.21c-3.292-0.001-6.289-1.896-7.703-4.869c-1.413-2.973-0.991-6.494,1.086-9.048    L249.376,29.76c2.977-3.646,8.343-4.195,11.996-1.226s4.214,8.333,1.254,11.993L151.692,177.06    C150.069,179.057,147.632,180.214,145.059,180.21L145.059,180.21z"/>
                                                                            <path style="fill:#428DFF;" d="M366.943,180.21c-2.573,0.004-5.01-1.153-6.633-3.15L249.376,40.527    c-1.932-2.366-2.452-5.584-1.365-8.438c1.088-2.854,3.617-4.91,6.634-5.391c3.016-0.481,6.06,0.687,7.981,3.062l110.933,136.533    c2.077,2.554,2.5,6.075,1.086,9.048C373.232,178.314,370.234,180.209,366.943,180.21L366.943,180.21z"/>
                                                                        </g>
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                            <span class="servicesCategory">
                                                                مدت برنامه:
                                                            </span>

                                                            {{implode('،',(array)$product->info_attributes['courseDuration'])}}
                                                            [ {{implode('،',(array)$product->info_attributes['studyPlan'])}} ]
                                                            @endif
                                                        </div>
                                                        <div class="col-12 servicesRow">
                                                            @if(isset($product->info_attributes['accessoryServices']))
                                                                <span>
                                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.001 512.001" width="25" xml:space="preserve">
                                                                    <g transform="translate(0 -1)">
                                                                        <polygon style="fill:#FFFFFF;" points="256.001,478.877 256.001,171.677 8.534,171.677  "/>
                                                                        <g>
                                                                            <polygon style="fill:#A4C2F7;" points="256.001,478.877 256.001,171.677 503.467,171.677   "/>
                                                                            <polygon style="fill:#A4C2F7;" points="503.467,171.677 179.201,171.677 264.534,35.143 418.134,35.143   "/>
                                                                        </g>
                                                                        <polygon style="fill:#FFFFFF;" points="332.801,171.677 8.534,171.677 93.867,35.143 247.467,35.143  "/>

                                                                            <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="-48.7194" y1="653.6632" x2="-48.0494" y2="653.019" gradientTransform="matrix(426.6667 0 0 -443.7334 20900.0254 290102.25)">
                                                                            <stop offset="0" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.1717" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.2" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.2001" style="stop-color:#DAE4F4"/>
                                                                            <stop offset="0.2007" style="stop-color:#EBEBF4"/>
                                                                            <stop offset="0.2014" style="stop-color:#F6F1F4"/>
                                                                            <stop offset="0.2023" style="stop-color:#FDF4F4"/>
                                                                            <stop offset="0.205" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.2522" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.26" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.26" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.3974" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.42" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.4201" style="stop-color:#DAE4F4"/>
                                                                            <stop offset="0.4207" style="stop-color:#EBEBF4"/>
                                                                            <stop offset="0.4214" style="stop-color:#F6F1F4"/>
                                                                            <stop offset="0.4223" style="stop-color:#FDF4F4"/>
                                                                            <stop offset="0.425" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.4894" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.5" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.5" style="stop-color:#F9F2F4"/>
                                                                            <stop offset="0.5001" style="stop-color:#E8EBF4"/>
                                                                            <stop offset="0.5003" style="stop-color:#DDE5F4"/>
                                                                            <stop offset="0.5005" style="stop-color:#D6E2F4"/>
                                                                            <stop offset="0.501" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.7062" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.74" style="stop-color:#D4E1F4"/>
                                                                            <stop offset="0.741" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.8346" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.85" style="stop-color:#FFF5F4"/>
                                                                            <stop offset="0.851" style="stop-color:#D4E1F4"/>
                                                                        </linearGradient>
                                                                        <polygon style="fill:url(#SVGID_1_);" points="384.001,35.143 128.001,35.143 42.667,171.677 256.001,478.877 460.801,171.677    469.334,171.677  "/>
                                                                        <g>
                                                                            <path style="fill:#428DFF;" d="M256.001,487.41c-2.582,0.002-5.026-1.169-6.642-3.183L1.892,177.027    c-2.064-2.557-2.475-6.072-1.057-9.036c1.418-2.964,4.413-4.85,7.699-4.847h494.933c3.286-0.003,6.281,1.883,7.699,4.847    c1.418,2.964,1.007,6.48-1.057,9.036l-247.467,307.2C261.027,486.241,258.583,487.413,256.001,487.41L256.001,487.41z     M26.367,180.21l229.633,285.067L485.634,180.21H26.367z"/>
                                                                            <path style="fill:#428DFF;" d="M503.467,180.21H8.534c-3.103,0.001-5.962-1.683-7.465-4.397c-1.504-2.714-1.415-6.031,0.232-8.661    L86.634,30.618c1.559-2.493,4.293-4.008,7.233-4.008h324.267c2.941,0,5.674,1.515,7.233,4.008l85.333,136.533    c1.647,2.63,1.735,5.947,0.232,8.661C509.429,178.527,506.57,180.211,503.467,180.21z M23.934,163.143h464.133L413.401,43.677    h-314.8L23.934,163.143z"/>
                                                                            <path style="fill:#428DFF;" d="M256.001,487.41c-3.585,0.001-6.788-2.24-8.017-5.608L85.851,38.068    c-1.615-4.427,0.664-9.326,5.092-10.942c4.427-1.615,9.326,0.664,10.942,5.092l162.133,443.733    c0.955,2.617,0.572,5.535-1.024,7.817S258.786,487.41,256.001,487.41z"/>
                                                                            <path style="fill:#428DFF;" d="M256.001,478.877c-2.796,0.002-5.415-1.366-7.01-3.661c-1.596-2.295-1.965-5.227-0.99-7.847    l162.133-435.2c1.643-4.418,6.557-6.668,10.975-5.025c4.418,1.643,6.668,6.557,5.025,10.975l-162.133,435.2    C262.756,476.66,259.566,478.876,256.001,478.877z"/>
                                                                            <path style="fill:#428DFF;" d="M145.059,180.21c-3.292-0.001-6.289-1.896-7.703-4.869c-1.413-2.973-0.991-6.494,1.086-9.048    L249.376,29.76c2.977-3.646,8.343-4.195,11.996-1.226s4.214,8.333,1.254,11.993L151.692,177.06    C150.069,179.057,147.632,180.214,145.059,180.21L145.059,180.21z"/>
                                                                            <path style="fill:#428DFF;" d="M366.943,180.21c-2.573,0.004-5.01-1.153-6.633-3.15L249.376,40.527    c-1.932-2.366-2.452-5.584-1.365-8.438c1.088-2.854,3.617-4.91,6.634-5.391c3.016-0.481,6.06,0.687,7.981,3.062l110.933,136.533    c2.077,2.554,2.5,6.075,1.086,9.048C373.232,178.314,370.234,180.209,366.943,180.21L366.943,180.21z"/>
                                                                        </g>
                                                                    </g>
                                                                </svg>
                                                            </span>

                                                                <span class="servicesCategory">
                                                                    خدمات جانبی:
                                                                </span>

                                                                @foreach($product->info_attributes['accessoryServices'] as $s)
                                                                    <span class="servicesBadge"> {{ $s }} </span>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="col">
                                                            <div class="row videoInformation">
                                                                <div class="col">

                                                                    <div class="alert m-alert--default videoFilesPublishTime" role="alert">
                                                                        <span>
                                                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 52 52" xml:space="preserve" width="20">
                                                                                <g>
                                                                                    <path d="M26,0C11.664,0,0,11.663,0,26s11.664,26,26,26s26-11.663,26-26S40.336,0,26,0z M26,50C12.767,50,2,39.233,2,26   S12.767,2,26,2s24,10.767,24,24S39.233,50,26,50z"/>
                                                                                    <path d="M26,10c-0.552,0-1,0.447-1,1v22c0,0.553,0.448,1,1,1s1-0.447,1-1V11C27,10.447,26.552,10,26,10z"/>
                                                                                    <path d="M26,37c-0.552,0-1,0.447-1,1v2c0,0.553,0.448,1,1,1s1-0.447,1-1v-2C27,37.447,26.552,37,26,37z"/>
                                                                                </g>
                                                                            </svg>
                                                                        </span>
                                                                        زمان دریافت فایل های این همایش: {{ implode(' ',(array)$product->info_attributes['downloadDate']) }}
                                                                    </div>

                                                                    @if((isset($product->info_attributes['duration']) && !is_null($product->info_attributes['duration'])) ||
                                                                        (isset($product->info_attributes['durationTillNow']) && !is_null($product->info_attributes['durationTillNow'])))
                                                                    <div class="m-alert m-alert--air m-alert--square alert videoLength" role="alert">
                                                                        <div class="m-alert__text">
                                                                            <span>
                                                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 59 59" xml:space="preserve" width="30">
                                                                                    <line style="fill:none;stroke:#424A60;stroke-width:2;stroke-linecap:round;stroke-miterlimit:10;" x1="48.515" y1="13.615" x2="52.05" y2="10.08"/>
                                                                                    <rect x="50.464" y="5.665" transform="matrix(0.7071 -0.7071 0.7071 0.7071 9.5322 40.3433)" style="fill:#AFB6BB;" width="6.001" height="6"/>
                                                                                    <path style="fill:#3083C9;" d="M30.13,6c-2.008,0-3.96,0.235-5.837,0.666V13h-8c-0.553,0-1,0.447-1,1s0.447,1,1,1h8v5h-13  c-0.553,0-1,0.447-1,1s0.447,1,1,1h13v5h-18c-0.553,0-1,0.447-1,1s0.447,1,1,1h18v5h-22c-0.553,0-1,0.447-1,1s0.447,1,1,1h22v5h-16  c-0.553,0-1,0.447-1,1s0.447,1,1,1h16v5h-10c-0.553,0-1,0.447-1,1s0.447,1,1,1h10v7.334C26.17,57.765,28.122,58,30.13,58  c14.359,0,26-11.641,26-26S44.489,6,30.13,6z"/>
                                                                                    <path style="fill:#2B77AA;" d="M44,23.172c-0.348-0.346-0.896-0.39-1.293-0.104L29.76,32.433c-0.844,0.614-1.375,1.563-1.456,2.604  s0.296,2.06,1.033,2.797c0.673,0.673,1.567,1.044,2.518,1.044c1.138,0,2.216-0.549,2.886-1.47l9.363-12.944  C44.391,24.067,44.348,23.519,44,23.172z"/>
                                                                                    <path style="fill:#EFCE4A;" d="M43,21.293c-0.348-0.346-0.896-0.39-1.293-0.104L28.76,30.554c-0.844,0.614-1.375,1.563-1.456,2.604  s0.296,2.06,1.033,2.797C29.01,36.629,29.904,37,30.854,37c1.138,0,2.216-0.549,2.886-1.47l9.363-12.944  C43.391,22.188,43.348,21.64,43,21.293z"/>
                                                                                    <path style="fill:#424A60;" d="M28.293,6.084C28.954,6.034,29.619,6,30.293,6s1.339,0.034,2,0.084V3h2.5c0.828,0,1.5-0.672,1.5-1.5  v0c0-0.828-0.672-1.5-1.5-1.5h-9c-0.828,0-1.5,0.672-1.5,1.5v0c0,0.828,0.672,1.5,1.5,1.5h2.5V6.084z"/>
                                                                                    <g>
                                                                                        <path style="fill:#A1C8EC;" d="M30.293,5c-0.553,0-1,0.447-1,1v3c0,0.553,0.447,1,1,1s1-0.447,1-1V6   C31.293,5.447,30.846,5,30.293,5z"/>
                                                                                        <path style="fill:#A1C8EC;" d="M30.293,54c-0.553,0-1,0.447-1,1v3c0,0.553,0.447,1,1,1s1-0.447,1-1v-3   C31.293,54.447,30.846,54,30.293,54z"/>
                                                                                        <path style="fill:#A1C8EC;" d="M56.13,31h-3c-0.553,0-1,0.447-1,1s0.447,1,1,1h3c0.553,0,1-0.447,1-1S56.683,31,56.13,31z"/>
                                                                                        <path style="fill:#A1C8EC;" d="M43.63,8.617c-0.479-0.277-1.09-0.112-1.366,0.366l-1.5,2.599c-0.276,0.479-0.112,1.09,0.366,1.366   c0.157,0.091,0.329,0.134,0.499,0.134c0.346,0,0.682-0.18,0.867-0.5l1.5-2.599C44.272,9.505,44.108,8.893,43.63,8.617z"/>
                                                                                        <path style="fill:#A1C8EC;" d="M53.146,44.134l-2.598-1.5c-0.478-0.277-1.09-0.114-1.366,0.366   c-0.276,0.479-0.112,1.09,0.366,1.366l2.598,1.5C52.304,45.957,52.475,46,52.645,46c0.346,0,0.682-0.179,0.867-0.5   C53.789,45.021,53.625,44.41,53.146,44.134z"/>
                                                                                        <path style="fill:#A1C8EC;" d="M42.496,51.419c-0.277-0.48-0.89-0.644-1.366-0.366c-0.479,0.276-0.643,0.888-0.366,1.366l1.5,2.598   c0.186,0.321,0.521,0.5,0.867,0.5c0.17,0,0.342-0.043,0.499-0.134c0.479-0.276,0.643-0.888,0.366-1.366L42.496,51.419z"/>
                                                                                        <path style="fill:#A1C8EC;" d="M50.05,21.5c0.17,0,0.342-0.043,0.499-0.134l2.598-1.5c0.479-0.276,0.643-0.888,0.366-1.366   c-0.276-0.479-0.89-0.644-1.366-0.366l-2.598,1.5C49.07,19.91,48.906,20.521,49.183,21C49.368,21.321,49.704,21.5,50.05,21.5z"/>
                                                                                    </g>
                                                                                </svg>
                                                                            </span>
                                                                            @if(isset($product->info_attributes['duration']) && !is_null($product->info_attributes['duration']))
                                                                                مدت زمان: {{ implode(' ',(array)$product->info_attributes['duration']) }}
                                                                            @elseif(isset($product->info_attributes['durationTillNow']) && !is_null($product->info_attributes['durationTillNow']))
                                                                                مدت زمان تاکنون: {{ implode(' ',(array)$product->info_attributes['durationTillNow']) }}
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row priceAndAddToCartRow">
                                                        <div class="col-md-6 priceAndAddToCartCol">

                                                            {{--دکمه افزودن به سبد خرید--}}
                                                            @if($product->enable && !$isForcedGift)

                                                                @if($product->price['discount']>0)
                                                                    <div class="discount">

                                                                        <svg class="discountIcon" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 54 54" xml:space="preserve">
                                                                            <path style="fill:#DD352E;" d="M8.589,0C5.779,0,3.5,2.279,3.5,5.089V54l18-12l18,12V6c0-3.3,2.7-6,6-6H8.589z"/>
                                                                            <path style="fill:#B02721;" d="M45.41,0.005C42.151,0.054,39.5,2.73,39.5,6v17h11V5.135C50.5,2.315,48.225,0.03,45.41,0.005z"/>
                                                                        </svg>

                                                                        <div class="discountValue">

                                                                            <div class="discountValue-number">
                                                                                {{ ($product->price['discount']*100/$product->price['base']) }}%
                                                                            </div>
                                                                            <div class="discountValue-text">
                                                                                تخفیف
                                                                            </div>


                                                                        </div>

                                                                    </div>
                                                                @endif

                                                                <div class="price">
                                                                    @if($allChildIsPurchased)
                                                                        <div class="alert alert-info" role="alert">
                                                                            <strong>شما این محصول را خریده اید</strong>
                                                                        </div>
                                                                    @else
                                                                        <div>
                                                                            @if( $product->priceText['discount'] == 0 )
                                                                                {{ $product->priceText['basePriceText'] }}
                                                                            @else
                                                                                <div class="oldValue">{{ $product->priceText['basePriceText'] }} </div>
                                                                                <div class="newValue">{{ $product->priceText['finalPriceText'] }}</div>
                                                                            @endif
                                                                        </div>
                                                                    @endif
                                                                </div>

                                                            @else

                                                                @if($isForcedGift)
                                                                    @if($hasPurchasedShouldBuyProduct)
                                                                        <button class="btn btn-danger btn-lg m-btn  m-btn m-btn--icon">
                                                                            <span>
                                                                                <i class="flaticon-arrows"></i>
                                                                                <span>شما محصول راه ابریشم را خریداری کرده اید و این محصول به عنوان هدیه به شما تعلق خواهد گرفت</span>
                                                                            </span>
                                                                        </button>
                                                                    @else
                                                                        <a class="btn btn-focus btn-lg m-btn  m-btn m-btn--icon" href="{{ route('product.show' , $shouldBuyProductId ) }}">
                                                                            <span>
                                                                                <i class="flaticon-arrows"></i>
                                                                                <span>این محصول فروش تکی ندارد . برای تهیه این محصول باید  {{$shouldBuyProductName}} را تهیه کنید  برای خرید کلیک کنید</span>
                                                                            </span>
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                            @endif

                                                        </div>
                                                        <div class="col-md-6">

                                                            {{--دکمه افزودن به سبد خرید--}}
                                                            @if($product->enable && !$isForcedGift)

                                                                @if($allChildIsPurchased)
                                                                    <a class="btn m-btn m-btn--pill m-btn--air m-btn--gradient-from-focus m-btn--gradient-to-danger  animated infinite pulse" role="button" href="{{ action("Web\UserController@userProductFiles") }}">
                                                                        <i class="fa fa-play-circle"></i>
                                                                        مشاهده در صفحه فیلم ها و جزوه های من
                                                                    </a>
                                                                @else
                                                                    <button class="btn m-btn--air btn-success m-btn--icon m--margin-bottom-5 btnAddToCart gta-track-add-to-card">
                                                                        <span>
                                                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 52 52" xml:space="preserve" width="512" height="512" class="">
                                                                                <g>
                                                                                    <g>
                                                                                        <path d="M26,0C11.664,0,0,11.663,0,26s11.664,26,26,26s26-11.663,26-26S40.336,0,26,0z M26,50C12.767,50,2,39.233,2,26   S12.767,2,26,2s24,10.767,24,24S39.233,50,26,50z" data-original="#000000" class="active-path" data-old_color="#000000" style="fill:#FFFFFF"></path>
                                                                                        <path d="M38.5,25H27V14c0-0.553-0.448-1-1-1s-1,0.447-1,1v11H13.5c-0.552,0-1,0.447-1,1s0.448,1,1,1H25v12c0,0.553,0.448,1,1,1   s1-0.447,1-1V27h11.5c0.552,0,1-0.447,1-1S39.052,25,38.5,25z" data-original="#000000" class="active-path" data-old_color="#000000" style="fill:#FFFFFF"></path>
                                                                                    </g>
                                                                                </g>
                                                                            </svg>
                                                                            <i class="fas fa-sync-alt fa-spin m--hide"></i>
                                                                            <span>افزودن به سبد خرید</span>
                                                                        </span>
                                                                    </button>
                                                                @endif

                                                            @else
                                                                @if(!$product->enable)
                                                                    <button class="btn btn-danger btn-lg m-btn  m-btn m-btn--icon">
                                                                        <span>
                                                                            <i class="flaticon-shopping-basket"></i>
                                                                            <span>این محصول غیر فعال است.</span>
                                                                        </span>
                                                                    </button>
                                                                @endif
                                                            @endif



                                                        </div>
                                                    </div>

                                                    <!--begin::m-widget4-->
                                                    <div class="m-widget4 d-none">

                                                        @if(optional(optional(optional($product->attributes)->get('information'))->where('control', 'simple'))->count())
                                                            @foreach($product->attributes->get('information')->where('control', 'simple') as $key => $informationItem)
                                                                @if(count($informationItem->data) > 1)
                                                                    <div class="m-widget4__item m--padding-top-5 m--padding-bottom-5">
                                                                        <div class="m-widget4__img m-widget4__img--icon">
                                                                            <i class="flaticon-like m--font-info"></i>
                                                                        </div>
                                                                        <div class="m-widget4__info">
                                                                                <span class="m-widget4__text">
                                                                                    {{ $informationItem->title }}:
                                                                                </span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                @foreach($informationItem->data as $key => $informationItemData)

                                                                    <div class="m-widget4__item  m--padding-top-5 m--padding-bottom-5">
                                                                        <div class="m-widget4__img m-widget4__img--icon">
                                                                            @if(count($informationItem->data) === 1)
                                                                                <i class="flaticon-like m--font-info"></i>
                                                                            @else
                                                                                <i class="flaticon-interface-5 m--font-info"></i>
                                                                            @endif
                                                                        </div>
                                                                        <div class="m-widget4__info">
                                                                                <span class="m-widget4__text">
                                                                                    @if(count($informationItem->data) > 1)
                                                                                       {{ $informationItemData->name }}
                                                                                    @else
                                                                                        {{ $informationItem->title }}: {{ $informationItemData->name }}
                                                                                    @endif
                                                                                </span>
                                                                        </div>
                                                                    </div>

                                                                @endforeach
                                                            @endforeach
                                                        @endif

                                                        @if(optional($product->attributes)->get('main') != null && $product->attributes->get('main')->where('control', 'simple'))
                                                            @foreach($product->attributes->get('main')->where('control', 'simple') as $key => $informationItem)
                                                                @if(count($informationItem->data) > 1)
                                                                    <div class="m-widget4__item m--padding-top-5 m--padding-bottom-5">
                                                                        <div class="m-widget4__img m-widget4__img--icon">
                                                                            <i class="flaticon-like m--font-warning"></i>
                                                                        </div>
                                                                        <div class="m-widget4__info">
                                                                                <span class="m-widget4__text">
                                                                                    {{ $informationItem->title }}:
                                                                                </span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                @foreach($informationItem->data as $key => $informationItemData)
                                                                    <div class="m-widget4__item m--padding-top-5 m--padding-bottom-5">
                                                                        <div class="m-widget4__img m-widget4__img--icon">
                                                                            @if(count($informationItem->data) === 1)
                                                                                <i class="flaticon-like m--font-warning"></i>
                                                                            @else
                                                                                <i class="flaticon-interface-5 m--font-warning"></i>
                                                                            @endif
                                                                        </div>
                                                                        <div class="m-widget4__info">
                                                                                <span class="m-widget4__text">
                                                                                    @if(count($informationItem->data) > 1)
                                                                                        {{ $informationItemData->name }}
                                                                                    @else
                                                                                        {{ $informationItem->title }}: {{ $informationItemData->name }}
                                                                                    @endif
                                                                                </span>
                                                                        </div>
                                                                        @if(isset($informationItemData->id))
                                                                            <input type="hidden" value="{{ $informationItemData->id }}" name="attribute[]">
                                                                        @endif
                                                                    </div>
                                                                @endforeach
                                                            @endforeach
                                                        @endif

                                                    </div>
                                                    <!--end::Widget 9-->
                                                </div>
                                            </div>

                                        </div>
                                    @endif
                                    @if(optional(optional(optional($product->attributes)->get('information'))->where('control', 'checkBox'))->count() && false)
                                        <div class="col">
                                            <div class="m-portlet m-portlet--bordered m-portlet--full-height productInformation">
                                                <div class="m-portlet__head">
                                                    <div class="m-portlet__head-caption">
                                                        <div class="m-portlet__head-title">
                                                            <h3 class="m-portlet__head-text">
                                                                دارای
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="m-portlet__body m--padding-5">
                                                    <!--begin::m-widget4-->
                                                    <div class="m-widget4">

                                                        @foreach($product->attributes->get('information')->where('control', 'checkBox') as $key => $informationItem)
                                                            @if(count($informationItem->data) > 1)
                                                                <div class="m-widget4__item  m--padding-top-5 m--padding-bottom-5 m--padding-right-10 m--padding-left-10 a--full-width m--font-boldest">
                                                                    {{ $informationItem->title }}
                                                                </div>
                                                            @endif
                                                            @foreach($informationItem->data as $key => $informationItemData)
                                                                <div class="m-widget4__item  m--padding-top-5 m--padding-bottom-5 m--padding-right-10 m--padding-left-10">
                                                                    <div class="m-widget4__img m-widget4__img--icon">
                                                                        <i class="fa fa-check"></i>
                                                                    </div>
                                                                    <div class="m-widget4__info">
                                                                            <span class="m-widget4__text">
                                                                                @if(count($informationItem->data) > 1)
                                                                                    {{ $informationItemData->name }}
                                                                                @else
                                                                                    {{ $informationItem->title }}: {{ $informationItemData->name }}
                                                                                @endif
                                                                            </span>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endforeach

                                                    </div>
                                                    <!--end::Widget 9-->
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                {{--خدمات اضافی--}}
                                @if(optional(optional($product->attributes)->get('extra'))->count() && false)
                                    <div class="m-portlet  m-portlet--creative m-portlet--bordered-semi">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption col">
                                                <div class="m-portlet__head-title">
                                                                    <span class="m-portlet__head-icon">
                                                                        <i class="flaticon-confetti"></i>
                                                                    </span>
                                                    <h3 class="m-portlet__head-text">
                                                        خدماتی که برای این محصول نیاز دارید را انتخاب کنید:
                                                    </h3>
                                                    <h2 class="m-portlet__head-label m-portlet__head-label--warning">
                                                        <span>خدمات</span>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">

                                            @include("product.partials.extraSelectCollection")
                                            @include("product.partials.extraCheckboxCollection" , ["withExtraCost"])

                                        </div>
                                    </div>
                                @endif


                                {!! Form::hidden('product_id',$product->id) !!}


                            </div>

                            @if( isset($product->introVideo) || (isset($product->gift) && $product->gift->isNotEmpty()))
                                <div class="col-lg-4 col-md-4 productIntroVideoColumn">

                                    <div class="m-portlet m-portlet--bordered-semi m-portlet--rounded-force videoPlayerPortlet @if(!isset($product->introVideo)) m--hide @endif">
                                        <div class="m-portlet__body">
                                            <div class="m-widget19 a--nuevo-alaa-theme a--media-parent">
                                                <div class="m-widget19__pic m-portlet-fit--top m-portlet-fit--sides a--video-wraper">

                                                    @if( $product->introVideo )
                                                        <input type="hidden" name="introVideo"
                                                               value="{{ $product->introVideo }}">
                                                    @endif

                                                    <video
                                                            id="videoPlayer"
                                                            class="
                                                           video-js
                                                           vjs-fluid
                                                           vjs-default-skin
                                                           vjs-big-play-centered"
                                                            controls
                                                            {{-- preload="auto"--}}
                                                            preload="none"
                                                            @if(isset($product->introVideoThumbnail))
                                                            poster = "{{$product->introVideoThumbnail}}?w=400&h=225"
                                                            @else
                                                            poster = "https://cdn.alaatv.com/media/204/240p/204054ssnv.jpg"
                                                            @endif >

                                                        {{--                                                        <source--}}
                                                        {{--                                                                src="{{$product->introVideo}}"--}}
                                                        {{--                                                                id="videoPlayerSource"--}}
                                                        {{--                                                                type = 'video/mp4'/>--}}

                                                        {{--<p class="vjs-no-js">جهت پخش آنلاین فیلم، ابتدا مطمئن شوید که جاوا اسکریپت در مرور گر شما فعال است و از آخرین نسخه ی مرورگر استفاده می کنید.</p>--}}
                                                    </video>

                                                    <div class="m-widget19__shadow"></div>
                                                </div>
{{--                                                <div class="m-widget19__content">--}}
{{--                                                    <div class="m-widget19__header">--}}
{{--                                                        <h4 id="videoPlayerTitle">--}}
{{--                                                            کلیپ معرفی--}}
{{--                                                        </h4>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="m-widget19__body text-left" id="videoPlayerDescription"></div>--}}
{{--                                                </div>--}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="videoInformation">
                                        <div class="alert m-alert--default videoFilesPublishTime" role="alert">
                                            <span>
                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 52 52" xml:space="preserve" width="20">
                                                    <g>
                                                        <path d="M26,0C11.664,0,0,11.663,0,26s11.664,26,26,26s26-11.663,26-26S40.336,0,26,0z M26,50C12.767,50,2,39.233,2,26   S12.767,2,26,2s24,10.767,24,24S39.233,50,26,50z"/>
                                                        <path d="M26,10c-0.552,0-1,0.447-1,1v22c0,0.553,0.448,1,1,1s1-0.447,1-1V11C27,10.447,26.552,10,26,10z"/>
                                                        <path d="M26,37c-0.552,0-1,0.447-1,1v2c0,0.553,0.448,1,1,1s1-0.447,1-1v-2C27,37.447,26.552,37,26,37z"/>
                                                    </g>
                                                </svg>
                                            </span>
                                            زمان دریافت فایل های این همایش: {{ implode(' ',(array)$product->info_attributes['downloadDate']) }}
                                        </div>
                                        @if((isset($product->info_attributes['duration']) && !is_null($product->info_attributes['duration'])) ||
                                            (isset($product->info_attributes['durationTillNow']) && !is_null($product->info_attributes['durationTillNow'])))
                                        <div class="m-alert m-alert--air m-alert--square alert videoLength" role="alert">
                                            <div class="m-alert__text">
                                                <span>
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 59 59" xml:space="preserve" width="30">
                                                        <line style="fill:none;stroke:#424A60;stroke-width:2;stroke-linecap:round;stroke-miterlimit:10;" x1="48.515" y1="13.615" x2="52.05" y2="10.08"/>
                                                        <rect x="50.464" y="5.665" transform="matrix(0.7071 -0.7071 0.7071 0.7071 9.5322 40.3433)" style="fill:#AFB6BB;" width="6.001" height="6"/>
                                                        <path style="fill:#3083C9;" d="M30.13,6c-2.008,0-3.96,0.235-5.837,0.666V13h-8c-0.553,0-1,0.447-1,1s0.447,1,1,1h8v5h-13  c-0.553,0-1,0.447-1,1s0.447,1,1,1h13v5h-18c-0.553,0-1,0.447-1,1s0.447,1,1,1h18v5h-22c-0.553,0-1,0.447-1,1s0.447,1,1,1h22v5h-16  c-0.553,0-1,0.447-1,1s0.447,1,1,1h16v5h-10c-0.553,0-1,0.447-1,1s0.447,1,1,1h10v7.334C26.17,57.765,28.122,58,30.13,58  c14.359,0,26-11.641,26-26S44.489,6,30.13,6z"/>
                                                        <path style="fill:#2B77AA;" d="M44,23.172c-0.348-0.346-0.896-0.39-1.293-0.104L29.76,32.433c-0.844,0.614-1.375,1.563-1.456,2.604  s0.296,2.06,1.033,2.797c0.673,0.673,1.567,1.044,2.518,1.044c1.138,0,2.216-0.549,2.886-1.47l9.363-12.944  C44.391,24.067,44.348,23.519,44,23.172z"/>
                                                        <path style="fill:#EFCE4A;" d="M43,21.293c-0.348-0.346-0.896-0.39-1.293-0.104L28.76,30.554c-0.844,0.614-1.375,1.563-1.456,2.604  s0.296,2.06,1.033,2.797C29.01,36.629,29.904,37,30.854,37c1.138,0,2.216-0.549,2.886-1.47l9.363-12.944  C43.391,22.188,43.348,21.64,43,21.293z"/>
                                                        <path style="fill:#424A60;" d="M28.293,6.084C28.954,6.034,29.619,6,30.293,6s1.339,0.034,2,0.084V3h2.5c0.828,0,1.5-0.672,1.5-1.5  v0c0-0.828-0.672-1.5-1.5-1.5h-9c-0.828,0-1.5,0.672-1.5,1.5v0c0,0.828,0.672,1.5,1.5,1.5h2.5V6.084z"/>
                                                        <g>
                                                            <path style="fill:#A1C8EC;" d="M30.293,5c-0.553,0-1,0.447-1,1v3c0,0.553,0.447,1,1,1s1-0.447,1-1V6   C31.293,5.447,30.846,5,30.293,5z"/>
                                                            <path style="fill:#A1C8EC;" d="M30.293,54c-0.553,0-1,0.447-1,1v3c0,0.553,0.447,1,1,1s1-0.447,1-1v-3   C31.293,54.447,30.846,54,30.293,54z"/>
                                                            <path style="fill:#A1C8EC;" d="M56.13,31h-3c-0.553,0-1,0.447-1,1s0.447,1,1,1h3c0.553,0,1-0.447,1-1S56.683,31,56.13,31z"/>
                                                            <path style="fill:#A1C8EC;" d="M43.63,8.617c-0.479-0.277-1.09-0.112-1.366,0.366l-1.5,2.599c-0.276,0.479-0.112,1.09,0.366,1.366   c0.157,0.091,0.329,0.134,0.499,0.134c0.346,0,0.682-0.18,0.867-0.5l1.5-2.599C44.272,9.505,44.108,8.893,43.63,8.617z"/>
                                                            <path style="fill:#A1C8EC;" d="M53.146,44.134l-2.598-1.5c-0.478-0.277-1.09-0.114-1.366,0.366   c-0.276,0.479-0.112,1.09,0.366,1.366l2.598,1.5C52.304,45.957,52.475,46,52.645,46c0.346,0,0.682-0.179,0.867-0.5   C53.789,45.021,53.625,44.41,53.146,44.134z"/>
                                                            <path style="fill:#A1C8EC;" d="M42.496,51.419c-0.277-0.48-0.89-0.644-1.366-0.366c-0.479,0.276-0.643,0.888-0.366,1.366l1.5,2.598   c0.186,0.321,0.521,0.5,0.867,0.5c0.17,0,0.342-0.043,0.499-0.134c0.479-0.276,0.643-0.888,0.366-1.366L42.496,51.419z"/>
                                                            <path style="fill:#A1C8EC;" d="M50.05,21.5c0.17,0,0.342-0.043,0.499-0.134l2.598-1.5c0.479-0.276,0.643-0.888,0.366-1.366   c-0.276-0.479-0.89-0.644-1.366-0.366l-2.598,1.5C49.07,19.91,48.906,20.521,49.183,21C49.368,21.321,49.704,21.5,50.05,21.5z"/>
                                                        </g>
                                                    </svg>
                                                </span>
                                                @if(isset($product->info_attributes['duration']) && !is_null($product->info_attributes['duration']))
                                                    مدت زمان: {{ implode(' ',(array)$product->info_attributes['duration']) }}
                                                @elseif(isset($product->info_attributes['durationTillNow']) && !is_null($product->info_attributes['durationTillNow']))
                                                    مدت زمان تاکنون: {{ implode(' ',(array)$product->info_attributes['durationTillNow']) }}
                                                @endif

                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    @if(isset($product->gift) && $product->gift->isNotEmpty())
                                        <div class="m-portlet m-portlet--bordered m-portlet--creative m-portlet--bordered-semi m--margin-top-25">
                                            <div class="m-portlet__head">
                                                <div class="m-portlet__head-caption col">
                                                    <div class="m-portlet__head-title">
                                                        <span class="m-portlet__head-icon">
                                                            <i class="flaticon-gift"></i>
                                                        </span>
                                                        <h3 class="m-portlet__head-text">
                                                            این محصول شامل هدایای زیر می باشد:
                                                        </h3>
                                                        <h2 class="m-portlet__head-label m-portlet__head-label--accent">
                                                            <span>هدایا</span>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-portlet__body">
                                                <div class="row justify-content-center productGifts">
                                                    @foreach($product->gift as $gift)
                                                        <div class="col-12">
                                                            @if(strlen($gift->url)>0)
                                                                <a target="_blank" href="{{ $gift->url }}">
                                                                    <div>
                                                                        <img src="{{ $gift->photo }}" class="rounded-circle">
                                                                    </div>
                                                                    <div>
                                                                        <button type="button" class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-info m-btn--gradient-to-accent">
                                                                            {{ $gift->name }}
                                                                        </button>
                                                                    </div>
                                                                </a>
                                                            @else
                                                                <div>
                                                                    <img src="{{ $gift->photo }}" class="rounded-circle">
                                                                </div>
                                                                <div>
                                                                    <button type="button" class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-info m-btn--gradient-to-accent">
                                                                        {{ $gift->name }}
                                                                    </button>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
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