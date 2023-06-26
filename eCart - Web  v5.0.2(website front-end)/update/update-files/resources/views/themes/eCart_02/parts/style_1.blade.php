<div class="main-content my-md-5 my-sm-2 my-5">
    <section class="trending_content product_area">
        <div class="container-fluid">
            <div class="row">
                @if (Cache::has('flash-sales') && is_array(Cache::get('flash-sales')) && count(Cache::get('flash-sales')) && isset(Cache::get('flash-sales')->projects))
                <div class="col-xxl-3 col-xl-4 col-lg-5 col-md-12 col-12">
                    <div class="product_left_bar">
                        <div class="deals_product">
                            <div class="deals_title">
                                <h2>{{ __('msg.hot_deals') }}</h2>
                            </div>
                            <div class="deals_product_inner">
                                <div class="product_carousel_content deals_carousel owl-carousel">
                                    @foreach (Cache::get('flash-sales') as $fs)
                                    <article class="single_product">
                                        @if (!empty($fs->products))
                                        @foreach ($fs->products as $product)
                                        @if ($loop->first)
                                        <figure>
                                            <div class="product_thumb">
                                                <a class="primary_img"
                                                   href="{{ route('product-single', $product->slug ?? '-') }}"><img
                                                        class="lazy"
                                                        data-original="{{ $product->image }}"
                                                        alt="deals"></a>
                                                <div class="action_links">
                                                    <span class="inner product_data">
                                                        <input type="hidden" class="slug"
                                                               value="{{ $product->slug }}"
                                                               data-slug="{{ $product->slug }}">
                                                        <ul>
                                                            <input type="hidden" class="id"
                                                                   name="id"
                                                                   value="{{ $product->product_id }}"
                                                                   data-id="{{ $product->product_id }}">
                                                            <input type="hidden" name="qty"
                                                                   value="1" class="qty" data-qty="1">
                                                            <input type="hidden" class="varient"
                                                                   data-varient="{{ $product->product_variant_id }}"
                                                                   name="varient"
                                                                   value="{{ $product->product_variant_id }}"
                                                                   checked>
                                                            <input type="hidden" class="slug"
                                                                   value="{{ $product->slug }}"
                                                                   data-slug="{{ $product->slug }}">
                                                            <li class="add_to_cart addtocart_single"
                                                                data-id="{{ $product->product_id }}"
                                                                data-varient="{{ $product->product_variant_id }}"
                                                                data-qty="1"><a
                                                                    title="Add to cart"><span
                                                                        class="fas fa-shopping-cart"></span></a>
                                                            </li>
                                                            <li
                                                                class="quick_button productmodal_sale">
                                                                <a title="quick view"><span
                                                                        class="fas fa-search"></span></a>
                                                            </li>
                                                            <li class="wishlist"><a
                                                                    title="Add to Wishlist"
                                                                    class="{{ isset($product->is_favorite) && intval($product->is_favorite) ? 'saved' : 'save' }}"
                                                                    data-id='{{ $product->product_id }}'></a>
                                                            </li>
                                                        </ul>
                                                    </span>
                                                </div>
                                            </div>
                                            <figcaption class="product_content">
                                                <h4 class="product_name">
                                                    <a
                                                        href="{{ route('product-single', $product->slug ?? '-') }}">{{ $product->name }}</a>
                                                </h4>
                                                <p class="pb-2">{{ $product->category_name }}</p>
                                                <p>{{ $fs->title }}</p>
                                                <div class="product_reviews">
                                                    <div class="comment_note">
                                                        <div class="star_content">
                                                            @php
                                                            $arating = 0;
                                                            $arating = floatval($product->ratings);
                                                            @endphp
                                                            @for ($j = 1; $j <= 5; $j++)
                                                            @if ($arating <
                                                            $j) 
                                                            @if (is_float($arating) &&
                                                            round($arating)==$j)
                                                            <em class="fas
                                                                fa-star-half-alt"></em>
                                                            @else
                                                            <em class="far
                                                                fa-star"></em> @endif
                                                            @else
                                                            <em class="fas fa-star"></em>
                                                            @endif
                                                            @endfor
                                                            ({{ $product->number_of_ratings }})
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="price_box">
                                                    <span class="current_price">{{ Cache::get('currency') }}
                                                        {{ $product->discounted_price }}</span>
                                                    <span class="old_price"><s>{{ Cache::get('currency') }}
                                                            {{ $product->price }}</s></span>
                                                    <span
                                                        class="discount-percentage discount-product">{{ get_savings_varients($product) }}</span>
                                                </div>
                                                <div class="product_timing">
                                                    <div data-countdown="{{ $product->end_date }}"></div>
                                                </div>
                                            </figcaption>
                                        </figure>
                                        @endif
                                        @endforeach
                                        <a href="{{ route('sale-products', $fs->slug) }}" class="sale-view-all">View Sale</a>
                                    </article>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach(Cache::get('slider_offer_images') as $i => $c)
                    @if($c->image !== '')
                    <div class="banner_box_content  my-md-5 my-sm-2 my-5">
                        <img class="lazy" data-original="{{ $c->image }}" alt="ad-1">
                    </div>
                    @endif
                    @endforeach
                </div>
                @endif
                @if (isset($s->products) && is_array($s->products) && count($s->products))
                @if (Cache::has('flash-sales') && is_array(Cache::get('flash-sales')) && count(Cache::get('flash-sales')) && isset(Cache::get('flash-sales')->projects))
                <div class="col-xxl-9 col-xl-8 col-lg-7 col-md-12 col-12">
                @else
                <div class="col-xxl-12 col-xl-8 col-lg-7 col-md-12 col-12">
                @endif
                    <div class="product_right_bar">
                        <div class="product_container">
                            <div class="section_title">
                                <h2>{{ $s->title }}</h2>
                                <div class="desc_title">
                                    {{ $s->short_description }}
                                    @if (isset($s->slug) && $s->slug != '')
                                    <a href="{{ route('shop', ['section' => $s->slug]) }}"
                                       class="view title-section view-all">{{ __('msg.view_all') }}</a>
                                    @endif
                                </div>
                            </div>
                            <div class="product_carousel_content product_right_Carousel owl-carousel">
                                @php
                                $maxProductShow = get('style_1.max_product_on_homne_page2');
                                $i = 0;
                                @endphp
                                @foreach ($s->products as $p)
                                @php
                                $i++;
                                @endphp
                                @if (--$maxProductShow > -1)
                                @if ($i % 2 !== 0)
                                <div class="product_items">
                                    <article class="single_product">
                                        <figure>
                                            <div class="product_thumb">

                                                <a class="primary_img" href="{{ route('product-single', $p->slug) }}">
                                                    <img class="lazy" data-original="{{ $p->image }}" alt="{{ $p->name ?? 'Product Image' }}">
                                                </a>

                                                <div class="label_product">
                                                    @if (!count(getInStockVarients($p)))
                                                    <span class="label_sale">{{ __('msg.sold_out') }}</span>
                                                    @endif
                                                </div>
                                                <div class="action_links">
                                                    <span class="inner product_data">
                                                        <input type="hidden" class="slug" value="{{ $p->slug }}" data-slug="{{ $p->slug }}">
                                                        <ul>
                                                            @if (count(getInStockVarients($p)))
                                                            <input type="hidden" class="id" name="id" value="{{ $p->id }}" data-id="{{ $p->id }}">
                                                            <input type="hidden" name="qty" value="1" class="qty" data-qty="1">
                                                            @foreach (getInStockVarients($p) as $v)
                                                            <input type="hidden" class="varient" data-varient="{{ $v->id }}" name="varient" value="{{ $v->id }}" data-price='{{ get_price(get_price_varients($v)) }}' data-mrp='{{ get_price(get_mrp_varients($v)) }}' data-savings='{{ get_savings_varients($v) }}' checked>
                                                            @endforeach
                                                            <input type="hidden" class="slug" value="{{ $p->slug }}" data-slug="{{ $p->slug }}">
                                                            <input type="hidden" class="name" name="name" value="{{ $p->name }}" data-name="{{ $p->name }}">
                                                            <input type="hidden" class="image" name="image" value="{{ $p->image }}" data-image="{{ $p->image }}">
                                                            <input type="hidden" class="price" name="price" value="{{ print_price($p) }}" data-price="{{ print_price($p) }}">
                                                            @if (count(getInStockVarients($p)) > 1)
                                                            <li class="add_to_cart productmodal" data-bs-toggle="modal" data-bs-target="#modal_box" data-tab="login"><a title="Add to cart"><span class="fas fa-shopping-cart"></span></a></li>
                                                            @else
                                                            <li class="add_to_cart addtocart_single" data-id="{{ $p->id }}" data-varient="{{ $v->id }}" data-qty="1"><a title="Add to cart"><span class="fas fa-shopping-cart"></span></a></li>
                                                            @endif
                                                            <li class="quick_button productmodal"><a title="quick view"><span class="fas fa-search"></span></a></li>
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
                                                    </span>
                                                </div>
                                            </div>
                                            <figcaption class="product_content">
                                                <h4 class="product_name"><a href="{{ route('product-single', $p->slug) }}">
                                                        @if (strlen(strip_tags($p->name)) > 30) {!! substr(strip_tags($p->name), 0, 30) . '...' !!} @else {!! substr(strip_tags($p->name), 0, 30) !!} @endif
                                                    </a></h4>
                                                <p>
                                                <p>
                                                    <a href="#">{{ $p->category_name }}</a>
                                                </p>
                                                </p>
                                                <div class="product_reviews">
                                                    <div class="comment_note">
                                                        <div class="star_content">
                                                            @php
                                                            $arating = 0;
                                                            $arating = floatval($p->ratings); @endphp
                                                            @for ($j = 1; $j <= 5; $j++)
                                                            @if ($arating < $j)  @if (is_float($arating) &&
                                                            round($arating)==$j)
                                                            <em class="fas fa-star-half-alt"></em>
                                                            @else
                                                            <em class="far fa-star"></em> 
                                                            @endif
                                                            @else
                                                            <em class="fas fa-star"></em>
                                                            @endif
                                                            @endfor
                                                            ({{ $p->number_of_ratings }})
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="price_box">
                                                    <span class="current_price">{!! print_price($p) !!}</span>
                                                    <span class="old_price">{!! print_mrp($p) !!}</span>
                                                    @if(get_savings_varients($p->variants[0]))
                                                    <span class="discount-percentage discount-product">{{ get_savings_varients($p->variants[0]) }}</span>
                                                    @endif
                                                </div>

                                            </figcaption>
                                        </figure>
                                    </article>
                                    @endif
                                    @if ($i % 2 == 0)
                                    <article class="single_product">
                                        <figure>
                                            <div class="product_thumb">
                                                <a class="primary_img" href="{{ route('product-single', $p->slug) }}"><img class="lazy" data-original="{{ $p->image }}" alt="{{ $p->name ?? 'Product Image' }}"></a>
                                                <div class="label_product">
                                                    @if (!count(getInStockVarients($p)))
                                                    <span class="label_sale">{{ __('msg.sold_out') }}</span>
                                                    @endif
                                                </div>
                                                <div class="action_links">
                                                    <span class="inner product_data">
                                                        <ul>
                                                            @if (count(getInStockVarients($p)))
                                                            <input type="hidden" class="id" name="id" value="{{ $p->id }}" data-id="{{ $p->id }}">
                                                            <input type="hidden" name="qty" value="1" class="qty" data-qty="1">
                                                            @foreach (getInStockVarients($p) as $v)
                                                            <input type="hidden" class="varient" data-varient="{{ $v->id }}" name="varient" value="{{ $v->id }}" data-price='{{ get_price(get_price_varients($v)) }}' data-mrp='{{ get_price(get_mrp_varients($v)) }}' data-savings='{{ get_savings_varients($v) }}' checked>
                                                            @endforeach
                                                            <input type="hidden" class="slug" value="{{ $p->slug }}" data-slug="{{ $p->slug }}">
                                                            <input type="hidden" class="name" name="name" value="{{ $p->name }}" data-name="{{ $p->name }}">
                                                            <input type="hidden" class="image" name="image" value="{{ $p->image }}" data-image="{{ $p->image }}">
                                                            <input type="hidden" class="price" name="price" value="{{ print_price($p) }}" data-price="{{ print_price($p) }}">
                                                            @if (count(getInStockVarients($p)) > 1)
                                                            <li class="add_to_cart productmodal" data-bs-toggle="modal" data-bs-target="#modal_box" data-tab="login"><a title="Add to cart"><span class="fas fa-shopping-cart"></span></a></li>
                                                            @else
                                                            <li class="add_to_cart addtocart_single" data-id="{{ $p->id }}" data-varient="{{ $v->id }}" data-qty="1"><a title="Add to cart"><span class="fas fa-shopping-cart"></span></a></li>
                                                            @endif
                                                            <li class="quick_button productmodal"><a title="quick view"><span class="fas fa-search"></span></a></li>
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
                                                    </span>
                                                </div>
                                            </div>
                                            <figcaption class="product_content">
                                                <h4 class="product_name"><a href="{{ route('product-single', $p->slug) }}">
                                                        @if (strlen(strip_tags($p->name)) > 30) {!! substr(strip_tags($p->name), 0, 30) . '...' !!} @else {!! substr(strip_tags($p->name), 0, 30) !!} @endif
                                                    </a></h4>
                                                <p><a href="#">{{ $p->category_name }}</a></p>
                                                <div class="product_reviews">
                                                    <div class="comment_note">
                                                        <div class="star_content">
                                                            @php
                                                            $arating = 0;
                                                            $arating = floatval($p->ratings); @endphp
                                                            @for ($j = 1; $j <= 5; $j++)
                                                            @if ($arating < $j)  @if (is_float($arating) && round($arating)==$j)
                                                            <em class="fas fa-star-half-alt"></em>
                                                            @else
                                                            <em class="far fa-star"></em> 
                                                            @endif
                                                            @else
                                                            <em class="fas fa-star"></em>
                                                            @endif
                                                            @endfor
                                                            ({{ $p->number_of_ratings }})
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="price_box">
                                                    <span class="current_price">{!! print_price($p) !!}</span>
                                                    <span class="old_price">{!! print_mrp($p) !!}</span>
                                                    @if(get_savings_varients($p->variants[0]))
                                                    <span class="discount-percentage discount-product">{{ get_savings_varients($p->variants[0]) }}</span>
                                                    @endif
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </article>
                                </div>
                                @endif
                                @else
                                @break
                                @endif
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
                @if (isset($s->offer_images) && is_array($s->offer_images) && count($s->offer_images))
                <div class="popular_content">
                    @foreach($s->offer_images as $i => $o)
                    @if($o->type == 'products')
                        <a href="{{ route('product-single', $o->slug ?? '-') }}">
                    @elseif($o->type == 'category')
                        <a href="{{ route('category', $o->slug ?? '-') }}">
                    @elseif($o->type == 'offer_image_url')
                        <a href="{{$o->offer_image_url }}" target="_blank">
                    @else
                    @endif
                    @if($o->image !== '')
                    <div class="row my-md-5 my-sm-2 my-3">
                        <div class="col-md-12">
                            <div class="banner_box_content">
                                @if(isset($o->type) && $o->type == "image")
                                <img class="lazy w-100" data-original="{{ $o->image }}" alt="offer">
                                @elseif(isset($o->type) && $o->type == "video")
                                <video  controls class="w-100">
                                    <source src="{{ $o->image }}" type="video/mp4">
                                </video>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </a>
                    @endforeach
                </div>
                @endif
                @endif

            </div>
        </div>
    </section>
</div>

