<!-- breadcumb -->
<section class="page_title corner-title overflow-visible">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>{{__('msg.favourites')}}</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('my-account') }}">{{__('msg.my_account')}}</a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{__('msg.favourites')}}
                    </li>
                </ol>
                <div class="divider-15 d-none d-xl-block"></div>
            </div>
        </div>
    </div>
</section>
<!-- eof breadcumb -->
<div class="main-content">
    <section class="favourite_sec checkout-section ptb-70">
        <div class="container-fluid">
            <div class="row">
                @if(isLoggedIn())
                <div class="col-lg-3 col-md-12 col-12 mb-4">
                    @include("themes.".get('theme').".user.sidebar")
                </div>
                <div class="col-lg-9 col-md-12">
                    @else
                    <div class="col-lg-12 col-md-12">
                        @endif
                        <!--shop wrapper start-->
                        <!--shop toolbar start-->
                        <div class="shop_toolbar_content">
                            <div class="shop_toolbar_btn">
                                <button data-role="grid-view" type="button" class="active btn-grid-view" data-toggle="tooltip" title="grid"></button>
                                <button data-role="list-view" type="button"  class="btn-list-view" data-toggle="tooltip" title="List"></button>
                            </div>
                        </div>
                        <!--shop toolbar end-->
                        @if(isset($data['list']) && isset($data['list']['data']) && is_array($data['list']['data']) && count($data['list']['data']))
                        <div class="row right_shop_content grid-view">
                            @foreach($data['list']['data'] as $p)
                            @if(isset($p->variants))
                            <div class="col-xxl-3 col-xl-4 col-md-4 col-sm-6 col-12" id="fav{{ $p->id }}">
                                <div class="single_product_content">
                                    <div class="inner_product_content">
                                        <a class="img_content" href="{{ route('product-single', $p->slug ?? '-') }}">
                                            <img class="lazy" data-original="{{ $p->image == NULL ? get_main_image($p->variants[0]) : $p->image }}" alt="{{ $p->image }}">
                                        </a>
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
                                                        <a title="Add to cart"><span class="fas fa-shopping-cart"></span></a>
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
                                                    <li class="wishlist"><a  title="Add to Wishlist" class="{{ (isset($p->is_favorite) && intval($p->is_favorite)) ? 'saved' : 'save' }}" data-id='{{  $p->id }}'></a></li>
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
                                        <div class="price_box">
                                            <span class="current_price" id="price_{{ $p->id }}">{!! print_price($p) !!}</span>
                                            <span class="old_price" id="mrp_{{ $p->id }}">{!! print_mrp($p) !!}</span>
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
                                                <li class="add_to_cart productmodal" data-bs-toggle="modal" data-bs-target="#modal_box" data-tab="login"><a title="Add to cart">Add to Cart</span></a></li>
                                                @else
                                                <li class="add_to_cart addtocart_single" data-id="{{ $p->id }}" data-varient="{{ $v->id }}" data-qty="1"><a title="Add to cart">Add to Cart</span></a></li>
                                                @endif
                                                @endif
                                                @if (session()->has('favourite'))
                                                @if(in_array($p->id, session()->get('favourite')))
                                                <li class="wishlist"><a  title="Add to Wishlist" class="saved" data-id='{{ $p->id }}'></a></li>
                                                @else
                                                <li class="wishlist"><a  title="Add to Wishlist" class="save" data-id='{{ $p->id }}'></a></li>
                                                @endif
                                                @else
                                                <li class="wishlist"><a  title="Add to Wishlist" class="{{ (isset($p->is_favorite) && intval($p->is_favorite)) ? 'saved' : 'save' }}" data-id='{{  $p->id }}'></a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        @endif

                        <div class="row">
                            <div class="col ">
                                @if (isset($data['last']) && $data['last'] != '')
                                <a href="{{ $data['last'] }}" class="btn btn-primary pull-left text-white"><em class="fa fa-arrow-left"></em> {{ __('msg.previous') }}</a>
                                @endif
                            </div>
                            <div class="col favnext text-right">
                                @if (isset($data['next']) && $data['next'] != '')
                                <a href="{{ $data['next'] }}" class="btn btn-primary pull-right text-white">{{ __('msg.next') }}
                                    <em class="fa fa-arrow-right"></em>
                                </a>
                                @endif
                            </div>
                        </div>

                        <!--shop toolbar end-->
                        <!--shop wrapper end-->
                    </div>
                </div>
            </div>
    </section>
</div>