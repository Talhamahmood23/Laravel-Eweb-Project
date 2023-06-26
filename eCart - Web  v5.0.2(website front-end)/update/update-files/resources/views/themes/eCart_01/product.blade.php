<!-- product detail page -->
<div class="section-content mt-5">
    <a href="#" id="scroll"><span></span></a>
    <div class="container padding-bottom">
        <div class="card px-2 py-4 px-md-5 py-md-5 bg-white shadow-sm rounded">
            <!--Grid row-->
            <div class="row">
                <!--Grid column-->
                <div class="col-xl-5 col-lg-6 col-md-12 col-12">
                    <div class="product_carousel_sec mb-3">
                        @if (count(getInStockVarients($data['product'])))
                        @else
                        <div class="content_label">
                            <span class="sold-out">{{ __('msg.sold_out') }}</span>
                        </div>
                        @endif
                        @php $count=1; @endphp
                        <div class="wrap-gallery-article">
                            <div id="myCarouselArticle" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#myCarouselArticle" data-slide-to="0"
                                        {{ $count == 0 ? 'class="active"' : '' }}>
                                    </li>
                                    @if (isset($data['product']->other_images) && is_array($data['product']->other_images)
                                    && count($data['product']->other_images))
                                    @foreach ($data['product']->other_images as $index => $img)
                                    <li data-target="#myCarouselArticle" data-slide-to="{{ $count }}"></li>
                                    @php $count++; @endphp
                                    @endforeach
                                    @endif
                                </ol>
                                <div class="carousel-inner" role="listbox">
                                    <div class="carousel-item active">
                                        <img class="outerdetailimg" src="{{ $data['product']->image }}" alt="{{ $data['product']->name ?? 'Product Image' }}">
                                    </div>
                                    @if (isset($data['product']->other_images) && is_array($data['product']->other_images)
                                    && count($data['product']->other_images))
                                    @foreach ($data['product']->other_images as $index => $img)
                                    <div class="carousel-item">
                                        <img class="outerdetailimg" src="{{ $img }}" alt="{{ $data['product']->name ?? 'Product Image' }}">
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                                <a class="carousel-control-prev" href="#myCarouselArticle" role="button" data-slide="prev">
                                    <em class="fa fa-angle-left text-dark font-weight-bold"></em>
                                </a>

                                <a class="carousel-control-next" href="#myCarouselArticle" role="button" data-slide="next">
                                    <em class="fa fa-angle-right text-dark font-weight-bold"></em>
                                </a>
                            </div>
                            <br>

                            <div class="row hidden-xs " id="slider-thumbs">
                                <!-- Bottom switcher of slider -->
                                <ul class="reset-ul d-flex flex-wrap list-thumb-gallery">
                                    <li class="col-sm-3 col-3 thumb-gallery-smallimg">
                                        <a class="thumbnail" data-target="#myCarouselArticle" data-slide-to="0">
                                            <img class="img-fluid lazy" data-original="{{ $data['product']->image }}" alt="{{ $data['product']->name ?? 'Product Image' }}">
                                        </a>
                                    </li>
                                    @php $count=1; @endphp
                                    @foreach ($data['product']->other_images as $index => $img)
                                    <li class="col-sm-3 col-3 thumb-gallery-smallimg">
                                        <a class="thumbnail thumbnailimg" data-target="#myCarouselArticle"
                                           data-slide-to="{{ $count }}">
                                            <img class="img-fluid lazy" data-original="{{ $img }}" alt="{{ $data['product']->name ?? 'Product Image' }}">
                                        </a>
                                    </li>
                                    @php $count++; @endphp
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
                <!--Grid column-->
                <!--Grid column-->
                <div class="col-xl-7 col-lg-6 col-md-12 col-12 ">
                    <div class="productdetails2">
                        <aside class="add-to-fav">
                            <button type="button" class="btn {{ isset($data['product']->is_favorite) && intval($data['product']->is_favorite) ? 'saved' : 'save' }}" data-id='{{ $data['product']->id }}' />
                        </aside>
                        <!--Content-->
                        <div class="product-text-left">
                            <p class="lead title-sec ">{{ $data['product']->name ?? '-' }}</p>
                            <hr class="proline">
                            <p class="read-more desc">
                                @if (strlen($data['product']->description) > 200)
                                {!! substr($data['product']->description, 0, 200) . '...' !!} @else {!!
                                substr($data['product']->description, 0, 200) !!} @endif
                                @if (strlen($data['product']->description) > 200)
                                <a class="more-content" href="#desc" id="description">{{ __('msg.read_more') }}</a>
                                @endif
                            </p>
                            @if (count(getInStockVarients($data['product'])))
                            <hr class="proline">
                            <p class="text-muted" id="price_mrp_{{ $data['product']->id }}">
                                <del>{{ __('msg.price') }}: <span class='value'></span></del>
                            </p>
                            <h5 class="title-sec" id="price_offer_{{ $data['product']->id }}">
                                {{ __('msg.offer_price') }}: {{ Cache::get('currency') }} <span class='value'></span>
                            </h5>
                            <h5 class="" id="price_regular_{{ $data['product']->id }}">
                                {{ __('msg.price') }}:
                                <span class='value'></span>
                            </h5>
                            <small class="text-primary"
                                   id="price_savings_{{ $data['product']->id }}">{{ __('msg.you_save') }}:
                                {{ Cache::get('currency') }} <span class='value'></span>
                            </small>
                            <div class="form">
                                <form action="{{ route('cart-add') }}" class="addToCart" method="POST">
                                    @csrf
                                    <input type="hidden" name='id' value='{{ $data['product']->id }}'>
                                    <input type="hidden" name="type" value='add'>
                                    <input type="hidden" name="child_id" value='0' id="child_{{ $data['product']->id }}">

                                    <div class="button-container col row mt-4">
                                        <button class="cart-qty-minus button-minus button-minus-single-page" type="button" id="button-minus" value="-">-</button>
                                        <input class="form-control qtyPicker qtyPicker-single-page" id="qtyPicker_{{ $data['product']->id }}"  type="number" name="qty" data-min="1" min="1" max="1" data-max="1" data-max-allowed="1" value="1"  readonly>
                                        <button class="cart-qty-plus button-plus button-plus-single-page" type="button" id="button-plus" value="+">+</button>
                                    </div>


                                    <div class="row mt-4">
                                        <div class="form-group col">
                                            <div class="btn-group-toggle variant" data-toggle="buttons">
                                                @php $firstSelected = true; @endphp
                                                @foreach (getInStockVarients($data['product']) as $v)

                                                <button class="btn" data-id="{{ $data['product']->id }}">
                                                    <span class="text-dark name">{{ get_varient_name($v) }}</span><br>
                                                    <small> {{ __('msg.option_from') }}{{ get_price_varients($v) }}</small>
                                                    @php
                                                    $session_qty = '';
                                                    if(isset($data['cart']['cart_session']) && !empty($data['cart']['cart_session'])){
                                                    $session_qty = $data['cart']['cart_session'][$v->id]['quantity'] ?? '1';
                                                    }
                                                    @endphp
                                                    <input type="radio" name="options" id="option{{ $v->id }}" value="{{ $v->id }}" data-id='{{ $v->id }}'
                                                           data-price='@php $tax_discounted_price = get_price_varients($v) + (get_price_varients($v) * get_pricetax_varients($data['product']->tax_percentage)) /100; print
                                                    number_format($tax_discounted_price, 2); @endphp '

                                                    data-tax='{{ get_pricetax_varients($data['product']->tax_percentage) }}'

                                                    data-mrp='@php
                                                    $aa = get_mrp_varients($v);
                                                    if ($aa !== '') {
                                                    $tax_mrp_price = (int) get_mrp_varients($v) + ((int)
                                                    get_mrp_varients($v) * (int)
                                                    get_pricetax_varients($data['product']->tax_percentage)) / 100;
                                                    print number_format($tax_mrp_price, 2);
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
                                    </div>
                                    <div class="form-group">
                                        @if (intval($data['product']->indicator) == 2)
                                        <img class="lazy" data-original="{{ asset('images/nonvag.svg') }}" alt="Not Vegetarian Product">
                                        <span class="text-left ml-1"> {{ __('msg.not') }}
                                            <strong>{{ __('msg.vegetarian') }}</strong>
                                            {{ __('msg.v_product') }}.
                                        </span>
                                        @elseif(intval($data['product']->indicator) == 1)
                                        <img class="lazy" data-original="{{ asset('images/vag.svg') }}" alt="Vegetarian Product">
                                        <span class="text-left ml-1"> {{ __('msg.this_is') }}
                                            <strong>{{ __('msg.vegetarian') }}</strong>
                                            {{ __('msg.v_product') }}.
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group product_button">
                                        <button type="submit" name="submit" class="custom-btn btn-1">
                                            <em class="fa fa-shopping-cart"> <span class="text-uppercase ml-2">{{ __('msg.add_to_cart') }}</span></em>
                                        </button>
                                            {{-- <button class="buy-now btn btn-primary text-center text-uppercase text-white" type="submit" name="submit" value="buynow"> <span class="buy-now1">{{__('msg.buy_now')}}</span></button>
                                        --}}
                                    </div>
                                </form>
                            </div>
                            @endif
                            <div class="card-content text-center policycontent">
                                @if (isset($data['product']->return_status))
                                <div class="col-md-3">
                                    <div class="card productcard returnpolicy">
                                        @if (intval($data['product']->return_status))
                                        <div class="card-img pb-                                            2">
                                        <span class="creativity">
                                                        <img class="lazy" data-original="{{ asset('images/returnable.svg') }}" alt="Returnable">
                                                    </span>
                                                    </div>
                                                    <div class="card-box">
                                                        <h6 class="card-title text-center">
                                                            {{ Cache::get('max-product-return-days') }}
                                                            {{ __('msg.days') }} {{ __('msg.returnable') }}
                                                        </h6>
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
                                                                <h6 class="card-title text-center">
                                                                    {{ __('msg.order_can_cancel_till_order') }}
                                                                    {{-- {{ strtoupper($data['product']->till_status ?? '') }} --}}
                                                                </h6>
                                                            </div>
                                                            @else
                                                            <div class="card-img pb-2">
                                                                <span class="creativity">
                                                                    <img class="lazy" data-original="{{ asset('images/not-cancellable.svg') }}" alt="notCancellable">
                                                                </span>
                                                            </div>
                                                            <div class="card-box">
                                                                <h6 class="card-title text-center">{{ __('msg.not_cancellable') }}
                                                                </h6>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @endif
                                                    </div>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    {{-- return and cancelable --}}
                                                    <!--returnable and cancelable status-->
                                                    <div class="features1 service-quality padding-bottom">
                                                        <div class="container text-center justify-content-center">
                                                            <span class="border-line"></span>
                                                        </div>
                                                    </div>
                                                    <!--end returnable and cancelable status-->
                                                    <!--Grid row tab content-->
                                                    <div class="row padding-bottom">
                                                        <div class="col-md-12 mt-3">
                                                            <!-- Nav tabs -->
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active product-info title-sec" href="#desc" role="tab" data-toggle="tab">{{ __('msg.product_details') }}</a>
                                                                </li>
                                                            </ul>

                                                            <!-- Tab panes -->
                                                            <div class="tab-content rounded product-info-tab">
                                                                <div role="tabpanel" class="tab-pane active bg-white text-dark" id="desc">{!! $data['product']->description !!}</div>
                                                                @if (isset($data['product']->manufacturer) && trim($data['product']->manufacturer) != '')
                                                                <p>{{ __('msg.manufacturer') }} : {{ $data['product']->manufacturer }}</p>
                                                                @endif
                                                                @if (isset($data['product']->made_in) && trim($data['product']->made_in) != '')
                                                                <p>{{ __('msg.made_in') }} : {{ $data['product']->made_in }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    </div>



                                                    <!--similar product-content-->
                                                    @if (isset($data['similarProducts']) && !empty($data['similarProducts']))
                                                    <section class="section-content padding-bottom sellpro similarpro">
                                                        <div class="container">
                                                            <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                                                                <div class="similar_title_same">
                                                                    <h4 class="title-sec title-section font-weight-bold">{{ __('msg.similar_products') }}
                                                                        <a href="{{ route('shop') }}" class=" viewall">{{ __('msg.view_all') }}</a>
                                                                    </h4>
                                                                </div>
                                                                <hr class="line">
                                                                <div class="row no-gutter">
                                                                    @php $maxProductShow = get('similar-product-load-limit'); @endphp
                                                                    @foreach ($data['similarProducts'] as $p)
                                                                    @if (--$maxProductShow > -1)
                                                                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12 col-style2-2">
                                                                        <figure class="card card-product-grid styletwo_height my-2">
                                                                            <aside class="add-to-fav">
                                                                                <button type="button" class="btn {{ isset($p->is_favorite) && intval($p->is_favorite) ? 'saved' : 'save' }}" data-id='{{ $p->id }}'></button>
                                                                            </aside>
                                                                            <a href="{{ route('product-single', $p->slug) }}" class="img-wrap"> <img class="lazy" data-original="{{ $p->image }}" alt="{{ $p->name ?? 'Product Image' }}"> </a>
                                                                            <figcaption class="info-wrap">
                                                                                <div class="text-wrap p-2 text-center">
                                                                                    <a href="{{ route('product-single', $p->slug) }}" class="title font-weight-bold product-name">{{ $p->name }}</a>

                                                                                    <span class="text-muted style-desc">
                                                                                        @if (strlen(strip_tags($p->description)) > 20)
                                                                                        {!! substr(strip_tags($p->description), 0, 20) . '...' !!} @else {!!
                                                                                        substr(strip_tags($p->description), 0, 20) !!}
                                                                                        @endif
                                                                                    </span>
                                                                                    <div class="price mt-1 ">
                                                                                        <strong id="price_{{ $p->id }}">{!! print_price($p) !!}</strong>
                                                                                        &nbsp; <s class="text-muted" id="mrp_{{ $p->id }}">{!! print_mrp($p) !!}</s>
                                                                                        <small class="text-success" id="savings_{{ $p->id }}">
                                                                                            {{ get_savings_varients($p->variants[0]) }}
                                                                                        </small>
                                                                                    </div>
                                                                                </div>
                                                                            </figcaption>
                                                                            @if (count(getInStockVarients($p)))
                                                                            <span class="inner product_data">
                                                                                {{-- <form action='{{ route('cart-add-single-varient') }}' method="POST"> --}}
                                                                                <input type="hidden" class="id" name="id" value="{{ $p->id }}" data-id="{{ $p->id }}">
                                                                                <input type="hidden" name="qty" value="1" class="qty" data-qty="1">

                                                                                @foreach (getInStockVarients($p) as $v)
                                                                                <input type="hidden" class="varient" data-varient="{{ $v->id }}" name="varient"
                                                                                       value="{{ $v->id }}" data-price='{{ get_price(get_price_varients($v)) }}'
                                                                                       data-mrp='{{ get_price(get_mrp_varients($v)) }}'
                                                                                       data-savings='{{ get_savings_varients($v) }}' checked>
                                                                                @endforeach

                                                                                <input type="hidden" class="slug" value="{{ $p->slug }}" data-slug="{{ $p->slug }}">
                                                                                @if (count(getInStockVarients($p)) > 1)
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
                                                                                {{-- </form> --}}
                                                                            </span>
                                                                            @else
                                                                            <div class="content_label">
                                                                                <span class="sold-out">{{ __('msg.sold_out') }}</span>
                                                                            </div>
                                                                            @endif
                                                                        </figure>
                                                                    </div>
                                                                    @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </section>
                                                    @endif
                                                    <!--end similar product content-->
                                                    <!-- end product detail page -->
                                                    <script>
                                                        $(document).ready(function () {
                                                            $('.carousel').carousel({
                                                                interval: false
                                                            });
                                                        })
                                                    </script>
