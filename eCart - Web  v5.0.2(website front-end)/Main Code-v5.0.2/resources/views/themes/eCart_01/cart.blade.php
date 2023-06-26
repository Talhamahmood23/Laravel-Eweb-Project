@include("themes.$theme.common.msg")

<!-- breadcumb -->
<section class="page_title corner-title overflow-visible">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>{{__('msg.shopping_cart')}}</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> {{ __('msg.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{__('msg.shopping_cart')}}</li>
                    </li>
                </ol>
                <div class="divider-15 d-none d-xl-block"></div>
            </div>
        </div>
    </div>
</section>

<section class="section-content footerfix padding-bottom">
    <a href="#" id="scroll"><span></span></a>

    <div class="container mt-5">
        <div class="outer_box px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">

            <span class="cartpageajax">
                @if(Cache::get('area-wise-delivery-charge')=='1')

                @else
                @if(Cache::has('min_order_amount') && intval($data['data']['subtotal']) <= intval(Cache::get('min_order_amount')))
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="alert alert-warning">{{__('msg.you_must_have_to_purchase')}} {{ get_price(Cache::get('min_order_amount')) }} {{__('msg.to_place_order')}}</div>
                    </div>
                </div>
                @elseif(intval(Cache::get('min_amount', 0)) && intval($data['data']['shipping']))
                @if(intval($data['data']['subtotal']) && intval($data['data']['subtotal']) < Cache::get('min_amount'))
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="alert alert-info">{{__('msg.you_can_get_free_delivery_by_shopping_more_than')}} {{ get_price(Cache::get('min_amount')) }}</div>
                    </div>
                </div>
                @endif
                @endif
                @endif
                <div class="row justify-content-center">
                    <main class="col-md-12">
                        <div class="card">
                            <div class="table-responsive">
                                <table id="myTable" class="table ">
                                    <thead>
                                        <tr class="cart1title">
                                            <th scope="col" class="product">{{__('msg.product')}}</th>
                                            <th scope="col" class="qty">{{__('msg.qty')}}</th>
                                            <th scope="col" class="price">{{__('msg.price')}}</th>
                                            <th scope="col" class="text-right cartext action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="movecart">
                                        @if(isset($data['data']['cart']) && is_array($data['data']['cart']) && count($data['data']['cart']))
                                        @foreach($data['data']['cart'] as $p)
                                        @if(isset($p))
                                        @php
                                        if(isset($p->qty) &&  ($p->qty) > 0){
                                        $session_qty = '';
                                        $qty = $p->qty;
                                        }else{
                                        $qty = $data['cart']['cart_session'][$p->product_variant_id]['quantity'];
                                        $session_qty = $data['cart']['cart_session'][$p->product_variant_id]['quantity'] ?? '1';
                                        }
                                        @endphp
                                        <tr class="cart1price cartpage" id="{{ $p->product_variant_id }}">
                                            <td>
                                                <a href="{{ route('product-single', $p->slug) }}">
                                                    <figure class="itemside">
                                                        <div class="aside">
                                                            <img src="{{ $p->image }}" class="img-sm" alt="{{ $p->name ?? 'Product Image' }}">
                                                        </div>
                                                        <figcaption class="info">
                                                            <a href="{{ route('product-single', $p->slug) }}" class="title text-dark">{{ $p->name ?? '-' }}</a>
                                                            <p class="small text-muted">{{ get_varient_name($p) ?? '-' }}</p>
                                                        </figcaption>
                                                    </figure>
                                                </a>
                                            </td>
                                            <td class="cart">
                                                <div class="price-wrap cartShow">{{ $qty }}</div>
                                               
                                                <form action="{{ route('cart-update', $p->product_id) }}" method="POST" class="cartEdit cartEditpage">
                                                    @csrf
                                                    <button class="pdp-btn trim btn active">
                                                        <input hidden type="radio" name="options"
                                                               data-stock='{{ intval(getMaxQty($p)) }}'
                                                               data-max-allowed-stock='{{ intval(getMaxQtyAllowed($p)) }}'
                                                               data-cart_count='{{ intval(get_cart_count($p,$session_qty)) }}'
                                                               data-qty='{{ $qty ?? 1 }}'
                                                               data-sale-end-time='{{get_sale_end_time($p)}}'
                                                               data-varient-name='{{ get_unit_name($p) }}'
                                                               data-varient-number='{{ get_unit_number($p) }}'
                                                               data-varient-type='{{ get_product_type($p) }}'
                                                               data-cart-stock-cart-page='{{ get_cart_stock_cart_page($data['cart']['cart'], $p->product_id, $session_qty) }}'
                                                               autocomplete="off">
                                                    </button>
                                                    <input type="hidden" name="child_id" value="{{ $p->product_variant_id }}">
                                                    <input type="hidden" name="product_id" value="{{ $p->product_id }}">
                                                    <div class="button-container col">
                                                        <button class="cart-qty-minus button-minus" type="button" id="button-minus" value="-">-</button>
                                                        <input class="form-control qtyPicker" type="number" name="qty" data-min="1" min="1" max="{{ intval(getMaxQty($p)) }}" data-max="{{ intval(getMaxQty($p)) }}" data-max-allowed="{{ Cache::get('max_cart_items_count') }}" value="{{ $qty ?? 1 }}" readonly>
                                                        <button class="cart-qty-plus button-plus" type="button" id="button-plus" value="+">+</button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td>
                                                <div class="price-wrap">
                                                    <var class="price">
                                                        @if(isset($p->tax_percentage) && $p->tax_percentage > 0)
                                                        @if(intval($p->discounted_price))
                                                        @php
                                                        $tax_price = $p->discounted_price + ($p->discounted_price * $p->tax_percentage/100);
                                                        @endphp
                                                        {{ get_price(sprintf("%0.2f", $tax_price * ($qty ?? 1) )) }}
                                                        @else
                                                        @php
                                                        $tax_price = $p->price + ($p->price * $p->tax_percentage/100);
                                                        @endphp
                                                        {{ get_price(sprintf("%0.2f",$tax_price * ($qty ?? 1) )) }}
                                                        @endif
                                                        @else
                                                        @if(intval($p->discounted_price))
                                                        {{ get_price(sprintf("%0.2f", $p->discounted_price * ($qty ?? 1) )) }}
                                                        @else
                                                        {{ get_price(sprintf("%0.2f", $p->price * ($qty ?? 1) )) }}
                                                        @endif
                                                        @endif
                                                    </var>
                                                    <br> 
                                                    @if(intval($qty) > 1)
                                                    <small class="text-muted">
                                                        @if(isset($p->tax_percentage) && $p->tax_percentage > 0)
                                                        @if(intval($p->discounted_price))
                                                        @php
                                                        $tax_price = $p->discounted_price + ($p->discounted_price * $p->tax_percentage/100);
                                                        @endphp
                                                        {{ get_price(sprintf("%0.2f", $tax_price  )) }} {{ ($qty > 0) ? ' each' : '' }}
                                                        @else
                                                        @php
                                                        $tax_price = $p->price + ($p->price * $p->tax_percentage/100);
                                                        @endphp
                                                        {{ get_price(sprintf("%0.2f",$tax_price  )) }} {{ ($qty > 0) ? ' each' : '' }}
                                                        @endif
                                                        @else
                                                        @if(intval($p->discounted_price))
                                                        {{ get_price(sprintf("%0.2f", $p->discounted_price  )) }} {{ ($qty > 0) ? ' each' : '' }}
                                                        @else
                                                        {{ get_price(sprintf("%0.2f", $p->price  )) }} {{ ($qty > 0) ? ' each' : '' }}
                                                        @endif
                                                        @endif  
                                                        @endif
                                                </div>
                                            </td>
                                            <td class="text-right checktrash">
                                                <button class="btn btn-light btn-round btnEdit cartShow"> <em class="fa fa-pencil-alt"></em></button>
                                                <button class="btn btn-light btn-round cartSave cartEdit"> <em class="fas fa-check"></em></button>
                                                <button class="btn btn-light btn-round btnEdit cartEdit"> <em class="fa fa-times"></em></button>
                                                <button class="btn btn-light btn-round cartDeletepage" data-varient="{{ $p->product_variant_id }}"><em class="fas fa-trash-alt"></em></button>
                                                @if(isLoggedIn())<p class="save_for_later" data-varient="{{ $p->product_variant_id }}"> Save for Later </p>@endif
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        @else
                                        <tr id="empty">
                                            <td colspan="4" class="text-center">
                                                <img src="{{ asset('images/empty-cart.png') }}" alt="No Items In Cart">
                                                <br><br>
                                                <a href="{{ route('shop') }}" class="btn btn-primary"><em class="fa fa-chevron-left  mr-1"></em>{{__('msg.continue_shopping')}}</a>
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>

                                    <tfoot id="price_section">
                                        @if(isset($data['data']['cart']) && is_array($data['data']['cart']) && count($data['data']['cart']))
                                        <tr>
                                            <td colspan="2" class="py-3">
                                                @if(Cache::has('local-pickup') && Cache::get('local-pickup')=='1')
                                                <a class="deleviry__option">
                                                    <input type="radio" name="pickup" value="door_step_delivery" checked>{{__('msg.door_step_delivery')}}
                                                    <input type="radio" name="pickup" value="pickup_from_store" class="ms-3">{{__('msg.pickup_from_store')}}
                                                </a>
                                                @endif
                                            </td>
                                            <td class="text-end" colspan="2">
                                                <p class="product-name deleviry__option">{{__('msg.subtotal')}} : <span>{{ get_price(sprintf("%0.2f",$data['data']['subtotal'])) ?? '-' }}</span></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="continue-shopping"><strong><span><a href="{{ route('shop') }}" class="btn btn-primary"><em class="fa fa-chevron-left mr-1"></em>{{__('msg.continue_shopping')}}</a></span></strong></td>
                                            @if(isset($data['data']['cart']) && is_array($data['data']['cart']) && count($data['data']['cart']))
                                            <td></td>

                                            <td colspan="2" class="text-right">
                                                <a href="" class="btn btn-primary cartDeleteallpage">{{__('msg.delete_all')}} <em class="fa fa-trash"></em></a>
                                                @if(!isLoggedIn())
                                                <a class="btn btn-primary login-popup">{{__('msg.checkout')}}
                                                    <em class="fa fa-arrow-right"></em>
                                                </a>
                                                @else
                                                @if(Cache::has('min_order_amount') && intval($data['data']['subtotal']) >= intval(Cache::get('min_order_amount')))
                                                <a id="door_step_delivery" href="{{ route('checkout-address') }}" class="btn btn-primary">{{__('msg.checkout')}} <em class="fa fa-arrow-right"></em></a>
                                                <a id="pickup_from_store" href="{{ route('checkoutcoupon') }}" class="btn btn-primary">{{__('msg.checkout')}} <em class="fa fa-arrow-right"></em></a>
                                                @else
                                                @if(Cache::get('area-wise-delivery-charge')=='1')
                                                <a id="door_step_delivery" href="{{ route('checkout-address') }}" class="btn btn-primary">{{__('msg.checkout')}} <em class="fa fa-arrow-right"></em></a>
                                                <a id="pickup_from_store" href="{{ route('checkoutcoupon') }}" class="btn btn-primary">{{__('msg.checkout')}} <em class="fa fa-arrow-right"></em></a>
                                                @else
                                                <button class="btn btn-primary disable">{{__('msg.checkout')}} <em class="fa fa-arrow-right"></em></button>
                                                @endif
                                                @endif
                                                @endif
                                            </td>
                                            @endif
                                        </tr>
                                        @endif
                                    </tfoot>

                                </table>
                            </div>
                        </div>
                    </main>
                </div>
            </span>
        </div>
        <!-------Save for Later-------->
        @if(isLoggedIn())
        <div class="row justify-content-center">
            <main class="col-md-12 mt-3">
                <div class="outer_box px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                    <h5 class="mb-5 title-sec text-left text-capitalize">{{__('msg.save_for_later')}}</h5>
                    <div class="table-responsive">
                        <table id="myTable" class="table ">
                            <thead>
                                <tr class="cart1title">
                                    <th scope="col" class="product">{{__('msg.product')}}</th>
                                    <th scope="col" class="qty">{{__('msg.qty')}}</th>
                                    <th scope="col" class="price">{{__('msg.price')}}</th>
                                    <th scope="col" class="text-right cartext action">Action</th>
                                </tr>
                            </thead>
                            <tbody id="savelater">
                                @if(isset($data['save_later'][0]) && is_array($data['save_later']) && count($data['save_later']))
                                @foreach($data['save_later'] as $p)
                                @if(!empty($p->item[0]->slug))
                                <tr class="cart1price">
                                    <td>
                                        <a href="{{ route('product-single', $p->item[0]->slug) }}">
                                            <figure class="itemside">
                                                <div class="aside">
                                                    <img src="{{ $p->item[0]->image }}" class="img-sm" alt="{{ $p->item[0]->name ?? 'Product Image' }}">
                                                </div>
                                                <figcaption class="info">
                                                    <a href="{{ route('product-single', $p->item[0]->slug) }}" class="title text-dark">{{ $p->item[0]->name ?? '-' }}</a>
                                                    <p class="small text-muted">{{ get_varient_name($p->item[0]) ?? '-' }}</p>
                                                </figcaption>
                                            </figure>
                                        </a>
                                    </td>
                                    <td class="cart">
                                        <div class="price-wrap cartShow">{{ $p->qty }}</div>
                                        <form action="{{ route('cart-update', $p->product_id) }}" method="POST" class="cartEdit cartEditpage">
                                            @csrf
                                            <input type="hidden" name="child_id" value="{{ $p->product_variant_id }}">
                                            <input type="hidden" name="product_id" value="{{ $p->product_id }}">
                                            <div class="button-container col">
                                                <button class="cart-qty-minus button-minus" type="button" id="button-minus" value="-">-</button>
                                                <input class="form-control qtyPicker" type="number" name="qty" data-min="1" min="1" max="{{ intval(getMaxQty($p->item[0])) }}" data-max="{{ intval(getMaxQty($p->item[0])) }}" value="{{ $p->qty }}" readonly>
                                                <button class="cart-qty-plus button-plus" type="button" id="button-plus" value="+">+</button>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="price-wrap">
                                            <var class="price">
                                                @if(isset($p->item[0]->tax_percentage) && $p->item[0]->tax_percentage > 0)
                                                @if(intval($p->item[0]->discounted_price))
                                                @php
                                                $tax_price = $p->item[0]->discounted_price + ($p->item[0]->discounted_price * $p->item[0]->tax_percentage/100);
                                                @endphp
                                                {{ get_price(sprintf("%0.2f", $tax_price * ($p->qty ?? 1) )) }}
                                                @else
                                                @php
                                                $tax_price = $p->item[0]->price + ($p->item[0]->price * $p->item[0]->tax_percentage/100);
                                                @endphp
                                                {{ get_price(sprintf("%0.2f",$tax_price * ($p->qty ?? 1) )) }}
                                                @endif
                                                @else
                                                @if(intval($p->item[0]->discounted_price))
                                                {{ get_price(sprintf("%0.2f", $p->item[0]->discounted_price * ($p->qty ?? 1) )) }}
                                                @else
                                                {{ get_price(sprintf("%0.2f", $p->item[0]->price * ($p->qty ?? 1) )) }}
                                                @endif
                                                @endif
                                            </var>
                                            <br> 
                                            @if(intval($p->qty) > 1)
                                            @if(intval($p->item[0]->discounted_price))
                                            <small class="text-muted">
                                                @if(isset($p->item[0]->tax_percentage) && $p->item[0]->tax_percentage > 0)
                                                @php
                                                $tax_price = $p->item[0]->discounted_price +
                                                ($p->item[0]->discounted_price *
                                                $p->item[0]->tax_percentage/100);
                                                @endphp
                                                {{ get_price($tax_price) }}{{ ($p->qty > 0) ? ' each' : '' }}

                                                @else
                                                {{ get_price($p->item[0]->discounted_price) }}{{ ($p->qty > 0) ? ' each' : '' }}</small>
                                            @endif
                                            @endif
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-right checktrash">
                                        <p class="move_to_cart" data-varient="{{ $p->product_variant_id }}"> Move to Cart </p>
                                    </td>
                                </tr>

                                @endif
                                @endforeach
                                @else
                                <tr id="empty_savelater">
                                    <td colspan="4"> No products exists in save for later.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
        @endif

    </div>
</section>