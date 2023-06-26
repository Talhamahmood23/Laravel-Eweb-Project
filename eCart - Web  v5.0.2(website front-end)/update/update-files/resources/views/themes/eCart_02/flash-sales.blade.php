<!-- breadcumb -->
<section class="page_title corner-title overflow-visible">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                @if(isset($data['data']) && isset($data['data']) && is_array($data['data']) && count($data['data']))
                @foreach($data['data'] as $product)
                @if ($loop->first)
                <h1>{{$product->flash_sales_Name}}</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">{{__('msg.home')}}</a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{$product->flash_sales_Name}}
                    </li>
                </ol>
                <div class="divider-15 d-none d-xl-block"></div>
            </div>
            @endif
            @endforeach
            @endif
        </div>
    </div>
</section>
<!-- eof breadcumb -->
<div class="main-content my-3">
    <section class="inner_flash_sales">
        <div class="container-fluid">
            <div class="deals_product_inner">
                <div class="product_carousel_content ">
                    <div class="row">
                        @if(isset($data['data']) && isset($data['data']) && is_array($data['data']) && count($data['data']))
                        @foreach($data['data'] as $product)
                        <div class="col-12 col-md-6 col-lg-4 col-xl-4 col-xxl-3">
                            <article class="single_product flash_boder">
                                <figure>
                                    <div class="product_thumb">

                                        <div class="label_product">
                                            @if(!count(getInStockVarients($product)))
                                            <span class="label_sale">{{ __('msg.sold_out') }}</span>
                                            @endif
                                        </div><a class="primary_img" href="{{ route('product-single', $product->slug) }}"><img class="lazy" data-original="{{ $product->image}}" alt="deals"></a>
                                        <div class="action_links">
                                            <span class="inner product_data">

                                                <input type="hidden" class="slug" value="{{ $product->slug }}" data-slug="{{ $product->slug }}">
                                                <ul>
                                                    @if(count(getInStockVarients($product)))
                                                    <input type="hidden" class="id" name="id" value="{{ $product->product_id }}" data-id="{{ $product->product_id }}">
                                                    <input type="hidden" name="qty" value="1" class="qty" data-qty="1">
                                                    <input type="hidden" class="varient" data-varient="{{ $product->product_variant_id }}" name="varient"  value="{{ $product->product_variant_id }}" checked>
                                                    <input type="hidden" class="slug" value="{{ $product->slug }}" data-slug="{{ $product->slug }}">
                                                    <li class="add_to_cart addtocart_single" data-id="{{ $product->product_id }}" data-varient="{{ $product->product_variant_id }}" data-qty="1"><a title="Add to cart"><span class="fas fa-shopping-cart"></span></a></li>
                                                    <li class="quick_button productmodal_sale"><a title="quick view"><span class="fas fa-search"></span></a></li>
                                                    @endif
                                                    @if (session()->has('favourite'))
                                                    @if(in_array($product->id, session()->get('favourite')))
                                                    <li class="wishlist"><a  title="Add to Wishlist" class="saved" data-id='{{$product->id }}'></a></li>
                                                    @else
                                                    <li class="wishlist"><a  title="Add to Wishlist" class="save" data-id='{{ $product->id }}'></a></li>
                                                    @endif
                                                    @else
                                                    <li class="wishlist"><a  title="Add to Wishlist" class="{{ (isset($product->is_favorite) && intval($product->is_favorite)) ? 'saved' : 'save' }}" data-id='{{ $product->id }}'></a></li>
                                                    @endif
                                                </ul>
                                            </span>
                                        </div>
                                    </div>
                                    <figcaption class="product_content">
                                        <h4 class="product_name"><a href="{{ route('product-single', $product->slug) }}">{{ $product->product_name}}</a></h4>
                                        <p>{{ $product->category_name}}</p>
                                        <div class="product_reviews">
                                            <div class="comment_note">
                                                <div class="star_content">
                                                    @php
                                                    $arating=0;
                                                    $arating = floatval($product->product_ratings); @endphp
                                                    @for ($j = 1; $j <= 5; $j++)
                                                    @if ($arating < $j)
                                                    @if (is_float($arating) && (round($arating) == $j))
                                                    <em class="fas fa-star-half-alt"></em>
                                                    @else
                                                    <em class="far fa-star"></em>
                                                    @endif
                                                    @else
                                                    <em class="fas fa-star"></em>
                                                    @endif
                                                    @endfor
                                                    ({{$product->number_of_ratings}})
                                                </div>
                                            </div>
                                        </div>
                                        <div class="price_box">
                                            <span class="current_price">{{ Cache::get('currency') }} {{ $product->discounted_price}}</span>
                                            <span class="old_price"><s>{{ Cache::get('currency') }} {{ $product->price}}</s></span>
                                            <span class="discount-percentage discount-product">{{ get_savings_varients($product) }}</span>
                                        </div>
                                        <div class="product_timing">
                                            <div data-countdown="{{ $product->end_date}}"></div>
                                        </div>
                                    </figcaption>
                                </figure>
                            </article>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>