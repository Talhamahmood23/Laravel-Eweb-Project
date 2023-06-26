<!-- breadcumb -->
<section class="page_title corner-title overflow-visible">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                @if(isset($data['title']))
                <h1>{{$data['title']}}</h1>
                @endif
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">{{__('msg.home')}}</a>
                    </li>
                    <li class="breadcrumb-item active">
                        @if(isset($data['title']))
                        {{$data['title']}}
                        @endif
                    </li>
                </ol>
                <div class="divider-15 d-none d-xl-block"></div>
            </div>
        </div>
    </div>
</section>
<!-- eof breadcumb -->

<section class="mb-lg-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="product_right_bar">
                    <div class="product_container">
                        <div class="section_title">
                            <h2>&nbsp; </h2>
                            <div class="desc_title">
                                &nbsp;
                                <br/>
                            </div>
                        </div>
                        @if(isset($data['sub-categories']))
                        <div class="product_carousel_content subcategory-carousel owl-carousel">
                            @foreach ($data['sub-categories'] as $c)
                            <div class="product_items">
                                <article class="single_product">
                                    <figure>
                                        <div class="product_thumb">
                                            <a class="primary_img" href="{{ route('shop', ['category' => $data['category']->slug, 'sub-category' => $c->slug]) }}"><img class="lazy" data-original="{{ $c->image }}" alt="{{ $c->name ?? '' }}"></a>
                                        </div>
                                        <figcaption class="product_content">
                                            <h4 class="product_name"><a href="{{ route('shop', ['category' => $data['category']->slug, 'sub-category' => $c->slug]) }}">{{ $c->name }}</a></h4>
                                            <p class="pb-4">{{ $c->subtitle }}</p>
                                        </figcaption>
                                    </figure>
                                </article>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        @if(isset($data['list']) && isset($data['list']) && is_array($data['list']) && count($data['list']))
                        @foreach($data['list'] as $p)
                        @if(isset($p->variants) && count($p->variants))
                        @if ($loop->first)
                        <div class="shop_toolbar_content mt-3">
                            <div class="shop_toolbar_btn">
                                <button data-role="grid-view" type="button" class="active btn-grid-view" data-toggle="tooltip" title="grid"></button>
                                <button data-role="list-view" type="button" class="btn-list-view" data-toggle="tooltip" title="List"></button>
                                @php
                                $number = 0;
                                @endphp
                                @if(isset($data['list']) && isset($data['list']) && is_array($data['list']) && count($data['list']))
                                @foreach($data['list'] as $p)
                                <?php $number++ ?>
                                @endforeach
                                @endif
                                <div class="letter">
                                    <small> {{ $number.' Items out of ' }}{{ (isset($data['total']) && intval($data['total'])) ?  $data['total'].' Items' : '' }}</small>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endif
                        @endforeach

                        <!--shop toolbar end-->

                        <div class="row right_shop_content grid-view">
                            @foreach($data['list'] as $p)
                            @if(isset($p->variants) && count($p->variants))
                            <div class="col-xxl-2 col-xl-4 col-md-4 col-sm-6 col-12">
                                <div class="single_product_content">
                                    <div class="inner_product_content">
                                        <a class="img_content" href="{{ route('product-single', $p->slug ?? '-') }}"><img class="lazy" data-original="{{ $p->image == NULL ? get_main_image($p->variants[0]) : $p->image }}" alt="{{ $p->image }}"></a>
                                        <div class="label_product">@if(!count(getInStockVarients($p)))
                                            <span class="label_sale">{{ __('msg.sold_out') }}</span>
                                            @endif
                                        </div>
                                        <div class="share_links inner product_data">
                                            @if(count(getInStockVarients($p)))
                                            <form action="{{ route('cart-add-single-varient') }}" method="POST">
                                                <input type="hidden" class="id" name="id" value="{{ $p->id }}" data-id="{{ $p->id }}">
                                                <input type="hidden" name="qty" value="1" class="qty" data-qty="1">
                                                @foreach(getInStockVarients($p) as $v)
                                                <input type="hidden" class="varient" data-varient="{{ $v->id }}" name="varient" value="{{ $v->id }}"  data-price='{{ get_price(get_price_varients($v)) }}' data-mrp='{{ get_price(get_mrp_varients($v)) }}' data-savings='{{ get_savings_varients($v) }}' checked>
                                                @endforeach
                                                <input type="hidden" class="slug" value="{{ $p->slug }}" data-slug="{{ $p->slug }}">
                                                <input type="hidden" class="name" name="name" value="{{ $p->name }}" data-name="{{ $p->name }}">
                                                <input type="hidden" class="image" name="image" value="{{ $p->image }}" data-image="{{ $p->image }}">
                                                <input type="hidden" class="price" name="price" value="{{ print_price($p) }}" data-price="{{ print_price($p) }}">
                                                <ul>
                                                    @if(count(getInStockVarients($p))>1)
                                                    <li class="add_to_cart productmodal">
                                                        <a  title="Add to cart"><span class="fas fa-shopping-cart"></span></a>
                                                    </li>
                                                    @else
                                                    <li class="add_to_cart addtocart_single" data-id="{{ $p->id }}" data-varient="{{ $v->id }}" data-qty="1">
                                                        <a title="Add to cart"><span class="fas fa-shopping-cart"></span></a>
                                                    </li>
                                                    @endif
                                                    @endif
                                                    @if (session()->has('favourite'))
                                                    @if(in_array($p->id, session()->get('favourite')))
                                                    <li class="wishlist"><a  title="Add to Wishlist" class="saved" data-id='{{ $p->id }}'></a></li>
                                                    @else
                                                    <li class="wishlist"><a  title="Add to Wishlist" class="save" data-id='{{ $p->id }}'></a></li>
                                                    @endif
                                                    @else
                                                    <li class="wishlist"><a  title="Add to Wishlist" class="{{ (isset($p->is_favorite) && intval($p->is_favorite)) ? 'saved' : 'save' }}" data-id='{{ $p->id }}'></a></li>
                                                    @endif
                                                </ul>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="product_content inner_grid_content">
                                        <h4 class="product_name">
                                            <a href="{{ route('product-single', $p->slug ?? '-') }}">{{ $p->name }}</a>
                                        </h4>
                                        <p>{{ $p->category_name }}</p>
                                        <div class="price_box">
                                            <span class="current_price" id="price_{{ $p->id }}">{!! print_price($p) !!}</span>
                                            <span class="old_price" id="mrp_{{ $p->id }}">{!! print_mrp($p) !!}</span>
                                            @if(get_savings_varients($p->variants[0]))
                                            <span class="discount-percentage discount-product" id="savings_{{ $p->id }}">{{ get_savings_varients($p->variants[0]) }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="product_content inner_list_content">
                                        <h4 class="product_name">
                                            <a href="{{ route('product-single', $p->slug ?? '-') }}">{{ $p->name }}</a>
                                        </h4>
                                        <p>{{ $p->category_name }}</p>
                                        @if($p->ratings > 0)
                                        <div class="product_rating">
                                            <ul>
                                                @php $arating = floatval($p->ratings); @endphp
                                                @for ($j = 1; $j <= 5; $j++)
                                                @if ($arating < $j)
                                                @if (is_float($arating) && (round($arating) == $j))
                                                <li><a><em class="fas fa-star-half-alt"></em></a></li>
                                                @else
                                                <li><a><em class="fas fa-star-empty"></em></a></li>
                                                @endif
                                                @else
                                                <li><a><em class="fas fa-star"></em></a></li>
                                                @endif
                                                @endfor
                                                <li>({{$p->number_of_ratings}})</li>
                                            </ul>
                                        </div>
                                        @endif
                                        <div class="price_box">
                                            <span class="current_price">{!! print_mrp($p) !!}</span>
                                            <span class="old_price">{!! print_price($p) !!}</span>
                                            @if(get_savings_varients($p->variants[0]))
                                            <span class="discount-percentage discount-product" id="savings_{{ $p->id }}">{{ get_savings_varients($p->variants[0]) }}</span>
                                            @endif
                                        </div>
                                        <div class="product_desc">
                                            <p>@if(strlen(strip_tags($p->description)) > 180) {!! substr(strip_tags($p->description), 0,180) ."..." !!} @else {!! substr(strip_tags($p->description), 0,180) !!} @endif</p>
                                        </div>
                                        <div class="share_links list_action_right inner product_data">
                                            <ul>
                                                @if(count(getInStockVarients($p)))
                                                <input type="hidden" class="id" name="id" value="{{ $p->id }}" data-id="{{ $p->id }}">
                                                <input type="hidden" name="qty" value="1" class="qty" data-qty="1">
                                                @foreach(getInStockVarients($p) as $v)
                                                <input type="hidden" class="varient" data-varient="{{ $v->id }}" name="varient" value="{{ $v->id }}"  data-price='{{ get_price(get_price_varients($v)) }}' data-mrp='{{ get_price(get_mrp_varients($v)) }}' data-savings='{{ get_savings_varients($v) }}' checked>
                                                @endforeach
                                                <input type="hidden" class="slug" value="{{ $p->slug }}" data-slug="{{ $p->slug }}">
                                                <input type="hidden" class="name" name="name" value="{{ $p->name }}" data-name="{{ $p->name }}">
                                                <input type="hidden" class="image" name="image" value="{{ $p->image }}" data-image="{{ $p->image }}">
                                                <input type="hidden" class="price" name="price" value="{{ print_price($p) }}" data-price="{{ print_price($p) }}">
                                                @if(count(getInStockVarients($p))>1)
                                                <li class="add_to_cart productmodal" data-bs-toggle="modal" data-bs-target="#modal_box" data-tab="login">
                                                    <a title="Add to cart">{{__('msg.add_to_cart')}}</span></a>
                                                </li>
                                                @else
                                                <li class="add_to_cart addtocart_single" data-id="{{ $p->id }}" data-varient="{{ $v->id }}" data-qty="1">
                                                    <a title="Add to cart">{{__('msg.add_to_cart')}}</span></a>
                                                </li>
                                                @endif
                                                @endif
                                                @if (session()->has('favourite'))
                                                @if(in_array($p->id, session()->get('favourite')))
                                                <li class="wishlist"><a  title="Add to Wishlist" class="saved" data-id='{{ $p->id }}'></a></li>
                                                @else
                                                <li class="wishlist"><a  title="Add to Wishlist" class="save" data-id='{{ $p->id }}'></a></li>
                                                @endif
                                                @else
                                                <li class="wishlist"><a  title="Add to Wishlist" class="{{ (isset($p->is_favorite) && intval($p->is_favorite)) ? 'saved' : 'save' }}" data-id='{{ $p->id }}'></a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach

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
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
