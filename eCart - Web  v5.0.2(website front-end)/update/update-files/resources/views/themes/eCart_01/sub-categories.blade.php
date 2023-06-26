<section class="page_title corner-title overflow-visible">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                @if(isset($data['sub-categories']))
                <h1>{{$data['sub-categories'][0]->category_name}}</h1>
                @endif
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">{{__('msg.home')}}</a>
                    </li>
                    <li class="breadcrumb-item active">
                        @if(isset($data['sub-categories']))
                        {{$data['sub-categories'][0]->category_name}}
                        @endif
                    </li>
                </ol>
                <div class="divider-15 d-none d-xl-block"></div>
            </div>
        </div>
    </div>
</section>


<section class="footerfix section-content padding-bottom mt-5 sub_catege_sec">
    <a href="#" id="scroll"><span></span></a>
    <div class="container">
        {{-- home supplis sub categories --}}
        <div class="outer_box px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded mb-3">
            {{-- title --}}
            <h4 class="title-section title-sec font-weight-bold">{{__('msg.Home_Supplies')}}</h4>
            <hr class="line">
            {{-- eof title --}}
            {{-- row data --}}
            <div class="row no-gutter">
                @if(isset($data['sub-categories']))
                @foreach ($data['sub-categories'] as $c)
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12 col-style2-2">
                    <a href="{{ route('shop', ['category' => $data['category']->slug, 'sub-category' => $c->slug]) }}" class="mt-2">
                        <figure class="card card-product-grid styletwo_height my-2">
                            <div class="img-wrap">
                                <img class="lazy" data-original="{{ $c->image }}" alt="{{ $c->name ?? '' }}">
                            </div>
                            <figcaption class="info-wrap">
                                <div class="text-wrap p-1 text-center">
                                    <h4 class="subtitle font-weight-bold product-name">{{ $c->name }}</h4>
                                    <p class="text-muted style-desc pt-2">{{ $c->subtitle }}</p>
                                </div>
                            </figcaption>
                        </figure>
                    </a>
                </div>
                @endforeach
                @else
                <div class="row">
                    <div class="col">
                        <br><br>
                        <h1 class="text-center">{{__('msg.no_subcategory_found')}}</h1>
                    </div>
                </div>
                @endif
            </div>  {{-- eof row data --}}
        </div>
        {{-- eof home supplies --}}

        {{-- list grid home supplies --}}
        <nav class="navbar navbar-md navbar-light bg-white gridviewdiv px-2 py-4 px-md-4 py-md-3 shadow-sm rounded">
            <div class="col-md-6 col-sm-6 col-12">
                <div class="row">
                    <div class="list_grid_content">
                        <div id="list1">
                            <em class="fa fa-list fa-lg" data-view="list-view"></em>
                        </div>
                        <div id="grid1">
                            <em class="selected fa fa-th fa-lg" data-view="grid-view"></em>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        @if(isset($data['list']) && isset($data['list']) && is_array($data['list']) && count($data['list']))
        <div id="products">
            @foreach($data['list'] as $p)
            @if(isset($p->variants) && count($p->variants))
            <div class="grid_shop col-lg-4 col-md-4 col-sm-6 col-xl-3 col-subgrid-3 mb-2">
                <div class="item1 px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                    <div class="add-to-fav">
                        <button type="button" class="btn {{ (isset($p->is_favorite) && intval($p->is_favorite)) ? 'saved' : 'save' }}" data-id='{{ $p->id }}' />
                    </div>
                    <a href="{{ route('product-single', $p->slug ?? '-') }}">
                        <div class="thumbnail">
                            <a href="{{ route('product-single', $p->slug ?? '-') }}">
                                <div class="img-event">
                                    <img class="group list-group-image img-fluid" src="{{ $p->image }}" alt="{{ $p->image }}">
                                </div>
                            </a>
                            <div class="caption card-body">
                                <div class="text-wrap">
                                    <a href="{{ route('product-single', $p->slug ?? '-') }}" class="title font-weight-bold product-name">{{ $p->name }}</a>
                                    <span class="text-muted description1">@if(strlen(strip_tags($p->description)) > 18) {!! substr(strip_tags($p->description), 0,18) ."..." !!} @else {!! substr(strip_tags($p->description), 0,18) !!} @endif</span>
                                    <div class="price">
                                        <strong id="price_{{ $p->id }}">{!! print_price($p) !!}</strong> &nbsp; <s class="text-muted" id="mrp_{{ $p->id }}">{!! print_mrp($p) !!}</s>
                                        <small class="text-success" id="savings_{{ $p->id }}"> {{ get_savings_varients($p->variants[0]) }} </small>
                                    </div>

                                    @if(count(getInStockVarients($p)))
                                    <span class="inner d-block m-auto product_data">
                                        <form action='{{ route('cart-add-single-varient') }}' method="POST">
                                            <input type="hidden" class="id" name="id" value="{{ $p->id }}" data-id="{{ $p->id }}">
                                            <input type="hidden" name="qty" value="1" class="qty" data-qty="1">
                                            @foreach(getInStockVarients($p) as $v)
                                            <input type="hidden" class="varient" data-varient="{{ $v->id }}" name="varient" value="{{ $v->id }}"  data-price='{{ get_price(get_price_varients($v)) }}' data-mrp='{{ get_price(get_mrp_varients($v)) }}' data-savings='{{ get_savings_varients($v) }}' checked>
                                            @endforeach
                                            <input type="hidden" class="slug" value="{{ $p->slug }}" data-slug="{{ $p->slug }}">
                                            @if(count(getInStockVarients($p))>1)
                                            <button type="submit" class="btn cart-1  productmodal">
                                                <div class="dub-arrow"><em class="fa fa-shopping-cart"></em></div>
                                                <span>{{__('msg.add_to_cart')}}</span>
                                            </button>
                                            @else
                                            <button type="submit" class="btn cart-1 addtocart_single" data-id="{{ $p->id }}" data-varient="{{ $v->id }}" data-qty="1">
                                                <div class="dub-arrow"><em class="fa fa-shopping-cart"></em></div>
                                                <span>{{__('msg.add_to_cart')}}</span>
                                            </button>
                                            @endif
                                        </form>
                                    </span>
                                    @else
                                    <div class="content_label">
                                        <span class="sold-out">{{ __('msg.sold_out') }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endif
            @endforeach
        </div>
        <div class="row">
            <div class="col"><br></div>
        </div>
        <div class="row">
            <div class="col text-center shoppagination">
                @php
                $number_of_pages =  ceil($data['number_of_pages']);
                $currentpage = '1';
                $currentpage = request()->input('page');
                @endphp
                @if($number_of_pages > 1)
                @for($page = max(1, $currentpage - 2); $page <= min($currentpage + 4, $number_of_pages); $page++)
                @php $pageprevious = $page-1;
                @endphp
                @if($currentpage == $page )
                <span class="active btn btn-light" >{{ $page }}</span>
                @else
                <a href="{{Request::url()}}?page={{ $page }}" class="btn btn-primary text-white"> {{ $page }} </a>
                @endif
                @endfor
                @endif
            </div>
            @else
            <div class="row">
                <div class="col">
                    <br><br>
                    <h1 class="text-center">{{__('msg.no_product_found')}}</h1>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>