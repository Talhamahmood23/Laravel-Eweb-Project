<section class="page_title corner-title overflow-visible">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>{{ $data['product']->name ?? '-' }}</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">{{ __('msg.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{ $data['product']->name ?? '-' }}
                    </li>
                </ol>
                <div class="divider-15 d-none d-xl-block"></div>
            </div>
        </div>
    </div>
</section>
<!-- eof breadcumb -->

{{-- all-content --}}
<div class="main-content my-5">
    {{-- product detail --}}
    <section class="product-detail-sec my-sm-2 my-3 ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-6 col-12 my-md-3">
                    <div class="product-details-tab">
                        @if (count(getInStockVarients($data['product'])))
                        @else
                        <div class="label_product">
                            <span class="label_sale">{{ __('msg.sold_out') }}</span>
                        </div>
                        @endif
                        <div id="img-1" class="zoomWrapper single-zoom">
                            <img id="zoom1" class="lazy main_image" src="{{ $data['product']->image }}" alt="{{ $data['product']->name ?? 'Product Image' }}" data-zoom-image="" alt="big-1">
                        </div>
                        <div class="single-zoom-thumb">
                                <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                                    @php $count=1; @endphp
                                    <li>
                                        <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{ $data['product']->image }}" data-zoom-image="{{ $data['product']->image }}" >
                                            <img src="{{ $data['product']->image }}" alt="{{ $data['product']->name ?? 'Product Image' }}" />
                                        </a>
                                    </li>
                                    @foreach($data['product']->other_images as $index => $img)
                                    <li>
                                        <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{ $img }}" data-zoom-image="{{ $img }}" >
                                            <img src="{{ $img }}" alt="{{ $data['product']->name ?? 'Product Image' }}" />
                                        </a>
                                    </li>
                                    @php $count++; @endphp
                                    @endforeach
                                </ul>
                            </div>
                    </div>
                </div>
                <div class=" col-xl-5 col-lg-6 col-md-6 col-12 my-md-3">
                    <div class="product_details_right productdetails2">
                        <h1>{{ $data['product']->name ?? '-' }}</h1>
                        <div class="product_ratting">
                            @if (isset($data['product']->ratings))
                            @php $arating = floatval($data['product']->ratings); @endphp
                            <ul>
                                @for ($j = 1; $j <= 5; $j++) @if ($arating < $j) @if (is_float($arating) && round($arating)==$j) <li><a><em class="fas fa-star-half-alt"></em></a></li>
                                @else
                                <li><a><em class="far fa-star"></em></a></li> @endif
                                @else
                                <li><a><em class="fas fa-star"></em></a></li>
                                @endif
                                @endfor
                                ({{ $data['product']->number_of_ratings }})
                            </ul>
                            @endif
                        </div>
                        @if (count(getInStockVarients($data['product'])))
                        <div class="price_box">
                            <span class="current_price" id="price_offer_{{ $data['product']->id }}">{{ Cache::get('currency') }}
                                <span class='value'></span>
                            </span>
                            <span class="old_price" id="price_mrp_{{ $data['product']->id }}">{{ Cache::get('currency') }}
                                <span class='value single_p'></span>
                            </span>
                            <span class="current_price" id="price_regular_{{ $data['product']->id }}">{{ Cache::get('currency') }}
                                <span class='value'></span>
                            </span>
                            <small class="pro_savings" id="price_savings_{{ $data['product']->id }}">{{ __('msg.you_save') }}:
                                {{ Cache::get('currency') }} <span class='value'></span>
                            </small>
                        </div>
                        <div class="product_desc">
                            <p>
                                @if (strlen($data['product']->description) > 200)
                                {!! substr($data['product']->description, 0, 200) . '...' !!}
                                @else {!! substr($data['product']->description, 0, 200) !!}
                                @endif
                            </p>
                            @if (strlen($data['product']->description) > 200)
                            <a class="more-content" href="#desc" id="description">{{ __('msg.read_more') }}</a>
                            @endif
                        </div>

                        <div class="form">
                            <form action="{{ route('cart-add') }}" class="addToCart" method="POST">
                                @csrf
                                <input type="hidden" class="name" name="name" value="{{ $data['product']->name }}" data-name="{{ $data['product']->name }}">
                                <input type="hidden" class="image" name="image" value="{{ $data['product']->image }}" data-image="{{ $data['product']->image }}">
                                <input type="hidden" class="price" name="price" value="" data-price="">
                                <input type="hidden" name='id' value='{{ $data['product']->id }}'>
                                <input type="hidden" name="type" value='add'>
                                <input type="hidden" name="child_id" value='0' id="child_{{ $data['product']->id }}">
                                <div class="product-variant1">
                                    <div class="product-variant__label mt-2">Available In :</div>
                                    <div class="product-variant__list variant btn-group-toggle" data-toggle="buttons" id="varients">
                                        @php $firstSelected = true; @endphp
                                        @foreach (getInStockVarients($data['product']) as $v)
                                        <button class="product-variant__btn pdp-btn product-variant__btn--active trim btn {{ $firstSelected }}" data-id="{{ $data['product']->id }}">
                                            {{ get_varient_name($v) }}

                                            @php
                                            $session_qty = '';
                                            if(isset($data['cart']['cart_session']) && !empty($data['cart']['cart_session'])){
                                            $session_qty = $data['cart']['cart_session'][$v->id]['quantity'] ?? '1';
                                            }
                                            @endphp
                                            <input hidden type="radio" name="options" id="option{{ $v->id }}" value="{{ $v->id }}" data-id='{{ $v->id }}' data-price='@php $tax_discounted_price = get_price_varients($v) + (get_price_varients($v) * get_pricetax_varients($data['product']->tax_percentage)) / 100; print number_format($tax_discounted_price, 2);@endphp' data-tax='{{ get_pricetax_varients($data['product']->tax_percentage) }}'
                                            data-mrp='@php $mrp_varients = get_mrp_varients($v);
                                            if ($mrp_varients !== '') {
                                            $tax_mrp_price = (int) get_mrp_varients($v) + ((int) get_mrp_varients($v) * (int) get_pricetax_varients($data['product']->tax_percentage)) / 100; print number_format($tax_mrp_price, 2);
                                            }
                                            @endphp'
                                            data-mrp_number='@php $tax_mrp_price_number = intval(preg_replace('/[^\d.]/', '', $tax_mrp_price));  print  $tax_mrp_price_number; @endphp'
                                            data-savings='{{ get_savings_varients($v, false) }}'
                                            data-stock='{{ intval(getMaxQty($v)) }}'
                                            data-max-allowed-stock='{{ intval(getMaxQtyAllowed($data['product'])) }}'
                                            data-cart_count='{{ intval(get_cart_count($v,$session_qty)) }}'
                                            data-qty='{{ intval(get_cart_count($v,$session_qty)) }}'
                                            data-sale-end-time='{{get_sale_end_time($v)}}'
                                            data-varient-name='{{ get_unit_name($v) }}'
                                            data-varient-number='{{ get_unit_number($v) }}'
                                            data-varient-type='{{ get_product_type($v) }}'
                                            data-cart-stock='{{ get_cart_stock($data['product']) }}'
                                            data-main-image='{{ get_main_image($data['product']) }}'
                                            data-gallery-images='{{ get_gallery_images(($v)) }}'
                                            autocomplete="off">
                                        </button>
                                        @if ($firstSelected == true)
                                        {{ $firstSelected = false }}
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="product_timing">
                                    <div id="product_timing" data-countdown=""></div>
                                </div>
                                <div class="product_variant quantity">
                                    <label>quantity :</label>
                                    <button class="cart-qty-minus button-minus button-minus-single-page" type="button" id="button-minus" value="-">-</button>
                                    <input class="qtyPicker " type="number" id="qtyPicker_{{ $data['product']->id }}" name="qty" data-min="1" min="1" max="1" data-max="1" data-max-allowed="1" value="1" data-varient-name='{{ get_unit_name($v) }}'readonly>
                                    <button class="cart-qty-plus button-plus " type="button" id="button-plus" value="+">+</button>
                                    <button class="btn btn-primary  outline-inward" type="submit"><em class="fas fa-shopping-cart pr-2"></em>&nbsp;&nbsp;{{__('msg.add_to_cart')}}</button>
                                    @if (session()->has('favourite'))
                                    @if(in_array($p->id, session()->get('favourite')))
                                    <li class="wishlist"><a  title="Add to Wishlist" class="saved" data-id='{{ $p->id }}'></a></li>
                                    @else
                                    <li class="wishlist"><a  title="Add to Wishlist" class="save" data-id='{{ $p->id }}'></a></li>
                                    @endif
                                    @else
                                    <li class="btn btn-primary pro_fav {{ (isset($data['product']->is_favorite) && intval($data['product']->is_favorite)) ? 'saved' : 'save' }}" data-id='{{ $data['product']->id }}'></li>
                                    @endif
                                </div>
                            </form>
                        </div>
                        @endif
                        <div class="product_meta">
                            <span>Category: <a href="#">{{ $data['product']->category_name }}</a></span>
                        </div>
                        <div class="priduct_social">
                            <ul>
                                <li>
                                    <a class="facebook" href="https://facebook.com/sharer.php?u={{ url()->current() }}" target="_blank" title="facebook"><em class="fab fa-facebook-f"></em>{{__('msg.Facebook')}}</a>
                                </li>
                                <li>
                                    <a class="twitter" href="http://twitter.com/share?url={{ url()->current() }}" target="_blank" title="twitter"><em class="fab fa-twitter"></em>{{__('msg.Twitter')}}</a>
                                </li>
                                <li>
                                    <a class="pinterest" href="http://pinterest.com/pin/create/button/?url=http://www.google.com&media={{ $data['product']->image }}" target="_blank" title="pinterest"><em class="fab fa-pinterest"></em>{{__('msg.pinterest')}}</a>
                                </li>
                                <li>
                                    <a class="linkedin" href="http://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}" target="_blank" title="linkedin"><em class="fab fa-linkedin"></em>{{__('msg.linkedin')}}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-content text-center policycontent">
                            @if (isset($data['product']->return_status))
                            <div class="col-md-3">
                                <div class="card productcard returnpolicy">
                                    @if (intval($data['product']->return_status))
                                    <div class="card-img pb-2">
                                        <span class="creativity">
                                            <img class="lazy" data-original="{{ asset('images/returnable.svg') }}" alt="Returnable">
                                        </span>
                                    </div>
                                    <div class="card-box">
                                        <h6 class="card-title text-center">{{ Cache::get('max-product-return-days') }}{{ __('msg.days') }} {{ __('msg.returnable') }}</h6>
                                    </div>
                                    @else
                                    <div class="card-img pb-2">
                                        <span class="creativity">
                                            <img class="lazy" data-original="{{ asset('images/not-returnable.svg') }}" alt="notReturnable">
                                        </span>
                                    </div>
                                    <div class="card-box">
                                        <h6 class="card-title text-center">{{ __('msg.not_returnable') }}</h6>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            @if (isset($data['product']->cancelable_status))
                            <div class="col-md-3">
                                <div class="card productcard returnpolicy">
                                    @if (intval($data['product']->cancelable_status))
                                    <div class="card-img pb-2">
                                        <span class="creativity">
                                            <img class="lazy" data-original="{{ asset('images/cancellable.svg') }}" alt="Cancellable">
                                        </span>
                                    </div>
                                    <div class="card-box">
                                        <h6 class="card-title text-center">{{ __('msg.order_can_cancel_till_order') }} {{ ($data['product']->till_status ?? '') }}</h6>
                                    </div>
                                    @else
                                    <div class="card-img pb-2">
                                        <span class="creativity">
                                            <img class="lazy" data-original="{{ asset('images/not-cancellable.svg') }}" alt="notCancellable">
                                        </span>
                                    </div>
                                    <div class="card-box">
                                        <h6 class="card-title text-center">{{ __('msg.not_cancellable') }}</h6>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-12 col-md-12 col-12 my-lg-3 my-md-3">
                    <div class="respond-change">
                        <div class="block-content-inner policy-content">
                            <div class="shipping-content-inner">
                                <div>
                                    <i class="fas fa-truck-moving"></i>
                                    <h5>{{ __('msg.FREE') }}<br>{{ __('msg.SHIPPING') }}</h5>
                                </div>
                                <div>
                                    <i class="fas fa-file-invoice-dollar"></i>
                                    <h5>{{ __('msg.100% MONEY') }}<br>{{ __('msg.BACK GUARANTEE') }}</h5>
                                </div>
                                <div>
                                    <i class="fas fa-headset"></i>
                                    <h5>{{ __('msg.ONLINE') }}<br>{{ __('msg.SUPPORT 24/7') }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="home-banner">
                            <div class="banner_box_content">
                                @if (Cache::has('advertisements') && is_array(Cache::get('advertisements')) && count(Cache::get('advertisements')))
                                @foreach (Cache::get('advertisements') as $advt)
                                @if (isset($advt->ad1) && trim($advt->ad1) !== '')
                                <img class="lazy" data-original="{{ $advt->ad1 }}" alt="ad-1">
                                @endif
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--product info start-->
    <section class="product_d_info my-sm-2 my-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-9 col-lg-7 col-md-12 col-12  my-sm-2 my-3">
                    <div class="product_d_inner">
                        <div class="product_info_button">
                            <ul class="nav" role="tablist">
                                <li>
                                    <a class="active" data-bs-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false" id="desc">{{ __('msg.description') }}</a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">{{ __('msg.reviews') }}</a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tab" href="#shipping-delivery" role="tab" aria-controls="shipping-delivery" aria-selected="false">{{ __('msg.shipping & delivery') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="info" role="tabpanel">
                                <div class="product_info_content">
                                    <p> {!! $data['product']->description !!} </p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="reviews" role="tabpanel">
                                <div class="reviews_wrapper">
                                    <div id="reviews_wrapper">
                                        @if (isset($data['rating']['product_review']) && is_array($data['rating']) && count($data['rating']))
                                        @foreach ($data['rating']['product_review'] as $r)
                                        <div class="reviews_comment_box" id="review-{{ $r->id }}">
                                            <div class="comment_thmb">
                                                <img class="lazy" data-original="{{ $r->user_profile }}" alt="user-profile">
                                            </div>
                                            <div class="comment_text">
                                                <div class="reviews_meta">
                                                    <div class="star_rating">
                                                        <ul>
                                                            @for ($j = 1; $j <= 5; $j++) @if ($r->rate < $j) @if(is_float($r->rate) && round($r->rate)==$j)`
                                                            <li>
                                                                <a><em class="fas fa-star-half-alt"></em></a>
                                                            </li>
                                                            @else
                                                            <li>
                                                                <a><em class="far fa-star"></em></a>
                                                            </li>
                                                            @endif
                                                            @else
                                                            <li>
                                                                <a><em class="fas fa-star"></em></a>
                                                            </li>
                                                            @endif
                                                            @endfor
                                                        </ul>
                                                    </div>
                                                    <p><strong>{{ $r->username }} -</strong><span class="date">
                                                            {{ date(' F j, Y', strtotime($r->date_added)) }} </span></p>
                                                    <span class="review">{{ $r->review }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                    @if ($data['rating']['review_eligible'] == '1')
                                    <div class="comment_title">
                                        <h2>{{__('msg.add_a_review')}}</h2>
                                    </div>
                                    <div class="product_ratting mb-10">
                                        <h3>{{__('msg.your_rating')}}</h3>
                                        <select id="combostar">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="product_review_form">
                                        <form action="{{ route('product-ratings') }} " method="POST" id="review_form">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12">
                                                    @if (isLoggedIn())
                                                    @php
                                                    $user_id = session()->get('user')['user_id'];
                                                    @endphp
                                                    @endif
                                                    <input hidden type="text" name="rate" id="starcount">
                                                    <input hidden type="number" name="product_id" value="{{ $data['product']->id }}">
                                                    @if (isLoggedIn())
                                                    <input hidden type="number" name="user_id" value="{{ $user_id }}">
                                                    @endif
                                                    <input hidden type="text" name="slug" value="{{ $data['product']->slug }}">
                                                </div>
                                                <div class="col-12">
                                                    <label for="review_comment">{{__('msg.your_review')}} </label>
                                                    <textarea name="review" id="review_comment"></textarea>
                                                </div>
                                            </div>
                                            <button type="submit" name="submit">{{__('msg.Submit')}}</button>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="tab-pane fade" id="shipping-delivery" role="tabpanel">
                                <p>
                                    {!! $data['product']->shipping_delivery !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- featured product --}}
                @if (isset($data['sections']['sections']) && is_array($data['sections']['sections']) && count($data['sections']['sections']))
                <div class="col-xl-3 col-lg-5 col-md-12 col-12  my-sm-2 my-3">
                    @foreach ($data['sections']['sections'] as $section)
                    @if ($section->style == 'style_3')
                    <div class="pro-feature-right">
                        <div class="pro-feature-inner featured-product-carousel">
                            <div class="section_title">
                                <h2>{{ $section->title }}</h2>
                            </div>
                            <div class="feature_product_area product_carousel pro-featured-detail owl-carousel">
                                @php
                                $i = 0;
                                @endphp
                                @foreach ($section->products as $p)
                                @php
                                $i++;
                                @endphp
                                @if ($i % 2 !== 0)
                                <div class="product_items">
                                    <article class="single_product">
                                        <figure>
                                            <div class="product_thumb">
                                                <a class="primary_img" href="{{ route('product-single', $p->slug) }}"><img class="lazy" data-original="{{ $p->image }}" alt=""></a>
                                            </div>
                                            <div class="label_product">@if(!count(getInStockVarients($p)))
                                                <span class="label_sale">{{ __('msg.sold_out') }}</span>
                                                @endif
                                            </div>
                                            <figcaption class="product_content">
                                                <h4 class="product_name"><a href="{{ route('product-single', $p->slug) }}">{{ $p->name }}</a>
                                                </h4>
                                                <div class="action_links">
                                                    <span class="inner product_data">
                                                        <ul>
                                                            @if(count(getInStockVarients($p)))
                                                            <input type="hidden" class="id" name="id" value="{{ $p->id }}" data-id="{{ $p->id }}">
                                                            <input type="hidden" name="qty" value="1" class="qty" data-qty="1">
                                                            @foreach(getInStockVarients($p) as $v)
                                                            <input type="hidden" class="varient" data-varient="{{ $v->id }}" name="varient" value="{{ $v->id }}"  data-price='{{ get_price(get_price_varients($v)) }}' data-mrp='{{ get_price(get_mrp_varients($v)) }}' data-savings='{{ get_savings_varients($v) }}' checked>
                                                            @endforeach
                                                            <input type="hidden" class="slug" value="{{ $p->slug }}" data-slug="{{ $p->slug }}">
                                                            @if(count(getInStockVarients($p))>1)
                                                            <li class="add_to_cart productmodal">
                                                                <a title="Add to cart"><span class="fas fa-shopping-cart"></span></a>
                                                            </li>
                                                            @else
                                                            <li class="add_to_cart addtocart_single" data-id="{{ $p->id }}" data-varient="{{ $v->id }}" data-qty="1">
                                                                <a title="Add to cart"><span class="fas fa-shopping-cart"></span></a>
                                                            </li>
                                                            @endif
                                                            <li class="quick_button productmodal">
                                                                <a title="quick view"><span class="fas fa-search"></span></a>
                                                            </li>
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
                                                <div class="product_rating">
                                                    @if ($p->ratings > 0)
                                                    <ul>
                                                        @php $arating = floatval($p->ratings); @endphp
                                                        @for ($j = 1; $j <= 5; $j++) @if ($arating < $j) @if(is_float($arating) && round($arating)==$j) <li><a><em class="fas fa-star-half-alt"></em></a></li>
                                                        @else
                                                        <li>
                                                            <a><em class="far fa-star"></em></a>
                                                        </li>
                                                        @endif
                                                        @else
                                                        <li>
                                                            <a><em class="fas fa-star"></em></a>
                                                        </li>
                                                        @endif
                                                        @endfor
                                                        <li>({{ $p->number_of_ratings }})</li>
                                                    </ul>
                                                    @endif
                                                </div>
                                                <div class="price_box2">
                                                    <span class="current_price">{!! print_mrp($p) !!}</span>
                                                    <span class="old_price">{!! print_price($p) !!}</span>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </article>
                                    @endif
                                    @if ($i % 2 == 0)
                                    <article class="single_product">
                                        <figure>
                                            <div class="product_thumb">
                                                <a class="primary_img" href="{{ route('product-single', $p->slug) }}"><img class="lazy" data-original="{{ $p->image }}" alt=""></a>
                                            </div>
                                            <div class="label_product">@if(!count(getInStockVarients($p)))
                                                <span class="label_sale">{{ __('msg.sold_out') }}</span>
                                                @endif
                                            </div>
                                            <figcaption class="product_content">
                                                <h4 class="product_name"><a href="{{ route('product-single', $p->slug) }}">{{ $p->name }}</a></h4>
                                                <div class="action_links">
                                                    <span class="inner product_data">
                                                        <ul>
                                                            @if(count(getInStockVarients($p)))
                                                            <input type="hidden" class="id" name="id" value="{{ $p->id }}" data-id="{{ $p->id }}">
                                                            <input type="hidden" name="qty" value="1" class="qty" data-qty="1">
                                                            @foreach(getInStockVarients($p) as $v)
                                                            <input type="hidden" class="varient" data-varient="{{ $v->id }}" name="varient" value="{{ $v->id }}"  data-price='{{ get_price(get_price_varients($v)) }}' data-mrp='{{ get_price(get_mrp_varients($v)) }}' data-savings='{{ get_savings_varients($v) }}' checked>
                                                            @endforeach
                                                            <input type="hidden" class="slug" value="{{ $p->slug }}" data-slug="{{ $p->slug }}">
                                                            @if(count(getInStockVarients($p))>1)
                                                            <li class="add_to_cart productmodal">
                                                                <a title="Add to cart"><span class="fas fa-shopping-cart"></span></a>
                                                            </li>
                                                            @else
                                                            <li class="add_to_cart addtocart_single" data-id="{{ $p->id }}" data-varient="{{ $v->id }}" data-qty="1">
                                                                <a title="Add to cart"><span class="fas fa-shopping-cart"></span></a>
                                                            </li>
                                                            @endif
                                                            <li class="quick_button productmodal">
                                                                <a title="quick view"><span class="fas fa-search"></span></a>
                                                            </li>
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
                                                <div class="product_rating">
                                                    @if ($p->ratings > 0)
                                                    <ul>
                                                        @php $arating = floatval($p->ratings); @endphp
                                                        @for ($j = 1; $j <= 5; $j++) @if ($arating < $j) @if(is_float($arating) && round($arating)==$j) <li><a><em class="fas fa-star-half-alt"></em></a></li>
                                                        @else
                                                        <li>
                                                            <a><em class="far fa-star"></em></a>
                                                        </li>
                                                        @endif
                                                        @else
                                                        <li>
                                                            <a><em class="fas fa-star"></em></a>
                                                        </li>
                                                        @endif
                                                        @endfor
                                                        <li>({{ $p->number_of_ratings }})</li>
                                                    </ul>
                                                    @endif
                                                </div>
                                                <div class="price_box2">
                                                    <span class="current_price">{!! print_mrp($p) !!}</span>
                                                    <span class="old_price">{!! print_price($p) !!}</span>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </article>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            @endif
    </section>
    {{-- featured product --}}
    {{-- similar product --}}
    @if(isset($data['similarProducts']) &&  !empty($data['similarProducts']))
    <section class="similar-product-sec mb-lg-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="product_right_bar">
                        <div class="product_container">
                            <div class="section_title">
                                <h2>{{__('msg.similar_products')}}</h2>
                                <div class="desc_title">
                                    Add new product to weekly show up
                                </div>
                            </div>
                            <div class="product_carousel_content similar-pro-carousel owl-carousel">
                                @php   $maxProductShow = get('style_2.max_product_on_homne_page'); @endphp
                                @foreach($data['similarProducts'] as $p)
                                @if((--$maxProductShow) > -1)
                                <div class="product_items">
                                    <article class="single_product">
                                        <figure>
                                            <div class="product_thumb">
                                                <a class="primary_img" href="{{ route('product-single', $p->slug) }}"><img
                                                        class="lazy" data-original="{{ $p->image == NULL ? get_main_image($p->variants[0]) : $p->image }}" alt="{{ $p->name ?? 'Product Image' }}"></a>
                                                <div class="label_product">
                                                    @if(!count(getInStockVarients($p)))
                                                    <span class="label_sale">{{ __('msg.sold_out') }}</span>
                                                    @endif
                                                </div>
                                                <div class="action_links">
                                                    <span class="inner product_data">
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
                                                            <li class="add_to_cart productmodal"><a title="Add to cart"><span class="fas fa-shopping-cart"></span></a></li>
                                                            @else
                                                            <li class="add_to_cart addtocart_single" data-id="{{ $p->id }}" data-varient="{{ $v->id }}" data-qty="1"><a title="Add to cart"><span class="fas fa-shopping-cart"></span></a></li>
                                                            @endif
                                                            @endif
                                                            <li class="quick_button productmodal"><a title="quick view"><span class="fas fa-search"></span></a></li>
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
                                                <h4 class="product_name"><a href="{{ route('product-single', $p->slug) }}">{{ $p->name }}</a></h4>
                                                <p>{{ $p->category_name }}</p>
                                                <div class=" product_ratting product_rating">
                                                    <ul>
                                                        @php $arating = floatval($p->ratings); @endphp
                                                        @for ($j = 1; $j <= 5; $j++)
                                                        @if ($arating < $j)
                                                        @if (is_float($arating) && (round($arating) == $j))
                                                        <li><a><em class="fas fa-star-half-alt"></em></a></li>
                                                        @else
                                                        <li><a><em class="far fa-star"></em></a></li>
                                                        @endif
                                                        @else
                                                        <li><a><em class="fas fa-star"></em></a></li>
                                                        @endif
                                                        @endfor
                                                        <li>({{$p->number_of_ratings}})</li>
                                                    </ul>
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
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
</div>
<script>
    $(function () {
        $('#combostar').on('change', function () {
            $('#starcount').val($(this).val());
        });
        $('#combostar').combostars();
    });

    $('#review_form').on('submit', function (e) {
        e.preventDefault();
        var fd = new FormData(this);
        if (confirm('Are you sure?')) {

            var token = <?php echo json_encode($data['token']); ?>;

            fd.append('accesskey', '90336');
            fd.append('add_products_review', '1');
            $.ajax({
                type: 'POST',
                url: ipa_lru + 'get-all-products.php',
                data: fd,
                headers: {
                    Authorization: 'Bearer ' + token
                },
                beforeSend: function () {
                    $('#submit_btn').html('Please wait..');
                },
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function (result) {
                    if (result['error'] == true) {
                        swal("" + result['message'] + "",
                                "After product delivered, than you can review this product.",
                                "error");
                    }
                    if (result['error'] == false) {
                        swal("Success!", "" + result['message'] + "", "success");
                        var user_id = result.data[0].user_id;
                        var message = result.message;
                        var id = result.data[0].id;
                        var review = result.data[0].review;
                        var rate = result.data[0].rate;
                        var username = result.data[0].username;
                        var date_added = result.data[0].date_added;
                        var user_profile = result.data[0].user_profile;
                        var month_name = function (dt) {
                            mlist = ["January", "February", "March", "April", "May", "June",
                                "July", "August", "September", "October", "November",
                                "December"
                            ];
                            return mlist[dt.getMonth()];
                        };
                        var month = month_name(new Date(date_added));
                        var date = new Date(date_added),
                                yr = date.getFullYear(),
                                day = date.getDate(),
                                newDate = month + ' ' + day + ', ' + yr;
                        var reviewadd = $("#reviews_wrapper").find("#review-" + id);
                        var review_add = '<div class="reviews_comment_box" id="review-' + id +
                                '">' +
                                '<div class="comment_thmb">' +
                                '<img src="' + user_profile + '" alt="user-profile">' +
                                '</div>' +
                                '<div class="comment_text">' +
                                '<div class="reviews_meta">' +
                                '<div class="star_rating">' +
                                '<ul>';
                        var rate5 = 5;
                        for (var j = 1; j <= rate5; j++) {
                            if (rate < j) {
                                if (parseFloat(rate) && (Math.round(rate) == j)) {
                                    review_add +=
                                            '<li><em class="fas fa-star-half-alt"></em></a></li>';
                                } else {
                                    review_add += '<li><em class="far fa-star"></em></li>';
                                }

                            } else {
                                review_add += '<li><a><em class="fas fa-star"></em></a></li>';
                            }

                        }

                        review_add += '</ul>' +
                                '</div>' +
                                '<p><strong>' + username + ' - </strong> <span class="date">' +
                                newDate + '</span> </p>' +
                                '<span class="review">' + review + '</span>' +
                                '</div>' +
                                '</div>' +
                                '</div>';

                        if (message == "Review updated Successfully!") {
                            var rate5 = 5;
                            var update_rate = "";
                            update_rate += '<span>';

                            for (var j = 1; j <= rate5; j++) {
                                if (rate < j) {
                                    if (parseFloat(rate) && (Math.round(rate) == j)) {
                                        update_rate +=
                                                '<li><em class="fas fa-star-half-alt"></em></a></li>';
                                    } else {
                                        update_rate += '<li><em class="far fa-star"></em></li>';
                                    }

                                } else {
                                    update_rate += '<li><a><em class="fas fa-star"></em></a></li>';
                                }
                            }
                            update_rate += '</span>';

                            $("#reviews_wrapper").find("#review-" + id).find('p').children('.date')
                                    .text(newDate);

                            $("#reviews_wrapper").find("#review-" + id).find('.review').text(
                                    review);
                            $("#reviews_wrapper").find("#review-" + id).find('ul').html(
                                    update_rate);
                        }
                        if (message == "Review Added Successfully!") {
                            $("#reviews_wrapper").append(review_add);
                        }

                    }
                }
            });
        }
    });
</script>
