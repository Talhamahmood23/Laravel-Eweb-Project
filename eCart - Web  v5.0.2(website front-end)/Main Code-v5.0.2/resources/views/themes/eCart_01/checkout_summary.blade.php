@include("themes.$theme.common.msg")
<section class="section-content footerfix padding-bottom mt-5">
    <a href="#" id="scroll"><span></span></a>
    <div class="container">
        <div class="card px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded mb-4">
            <div class="row">
                <div class="col-md-3 col-sm-4 col-12 text-center">
                    <a href="{{ route('cart') }}"><span class="icon dark"><em class="fa fa-chevron-circle-right  delivery-icon"></em>{{__('msg.cart')}}</span></a>
                </div>
                @if(isset($data['address']) && is_array($data['address']))
                <div class="col-md-3 col-sm-4 col-12 text-center">
                    <a href="{{ route('checkout-address') }}"><span class="icon dark"><em class="fa fa-chevron-circle-right delivery-icon"></em>{{__('msg.address')}}</span></a>
                </div>
                @endif
                <div class="col-md-3 col-sm-4 col-12 text-center">
                    <span class="icon dark"><em class="fa fa-chevron-circle-right delivery-icon"></em>{{__('msg.checkout')}}</span>
                </div>

                <div class="col-md-3 col-sm-4 col-12 text-center payment-icon">
                    <span class="icon dark"><em class="fa fa-chevron-circle-right"></em> {{__('msg.payment')}}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-12">
                <div id="data-step1" class="account-content px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded" data-temp="tabdata">
                    <div class="cart-main-content py-2 py-lg-5">
                        <div class="container">
                            <h3 class="cart-page-title">{{ __('msg.order_summary') }}</h3>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="table_description">
                                        <div class="cart_page-content">
                                            <table aria-describedby="cart-table">
                                                <thead>
                                                    <tr class="cart-header">
                                                        <th scope="col" class="header_product_thumb">{{__('msg.image')}}</th>
                                                        <th scope="col" class="header_product_name">{{__('msg.product')}}</th>
                                                        <th scope="col" class="header_product-price">{{__('msg.price')}}</th>
                                                        <th scope="col" class="header_product_quantity">{{__('msg.qty')}}</th>
                                                        <th scope="col" class="header_product_total">{{__('msg.subtotal')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($data['cart']['cart']) && is_array($data['cart']['cart']) && count($data['cart']['cart']))
                                                    @foreach($data['cart']['cart'] as $p)
                                                    @if(isset($p))
                                                    <tr>
                                                        <td class="header_product_thumb"><a href="#"><img class="lazy" data-original="{{ $p->image }}" alt=""></a></td>
                                                        <td class="header_product_name">
                                                            <a href="#">{{ strtoupper($p->name) ?? '-' }}</a>
                                                            <p class="small text-muted text-center">
                                                                {{ get_varient_name($p) }}
                                                                @if(intval($p->discounted_price))
                                                                ({{intval($p->discounted_price)}} X {{($p->qty ?? 1)}})
                                                                @else
                                                                ({{intval($p->price)}} X {{($p->qty ?? 1)}})
                                                                @endif
                                                                <br>{{ __('msg.tax')." (".$p->tax_percentage  }}%
                                                                {{ $p->tax_title  }})
                                                            </p>
                                                        </td>
                                                        <td class="header_product-price">@if(intval($p->discounted_price))
                                                            @if (isset($p->tax_percentage) && $p->tax_percentage >
                                                            0)
                                                            {{ $p->discounted_price+($p->discounted_price*$p->tax_percentage/100) ?? '' }}
                                                            @else
                                                            {{ $p->discounted_price ?? '' }}
                                                            @endif
                                                            @else
                                                            @if (isset($p->tax_percentage) && $p->tax_percentage >
                                                            0)
                                                            {{ $p->price+($p->price*$p->tax_percentage/100) ?? '' }}
                                                            @else
                                                            {{ $p->price ?? '' }}
                                                            @endif
                                                            @endif
                                                        </td>
                                                        <td class="header_product_quantity">
                                                            {{ $p->qty }}
                                                        </td>
                                                        <td class="header_product_total">@if(intval($p->discounted_price))
                                                            @if (isset($p->tax_percentage) && $p->tax_percentage >
                                                            0)
                                                            {{ ($p->discounted_price+($p->discounted_price*$p->tax_percentage/100)) * ($p->qty ?? 1) }}
                                                            @else
                                                            {{ $p->discounted_price * ($p->qty ?? 1) }}
                                                            @endif
                                                            @else
                                                            @if (isset($p->tax_percentage) && $p->tax_percentage >
                                                            0)
                                                            {{ ($p->price+($p->price*$p->tax_percentage/100)) * ($p->qty ?? 1) }}
                                                            @else
                                                            {{ $p->price * ($p->qty ?? 1) }}
                                                            @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="cart_submit">
                                            <a href="{{ route('shop') }}" class="btn cart_shopping"><em class="fas fa-angle-double-left"></em>&nbsp;&nbsp;{{__('msg.continue_shopping')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if(isset($data['code_list']) && is_array($data['code_list']) && count($data['code_list']))
                                @if(isset($data['code_list'][0]->id))
                                <div class="col-lg-4 col-md-4 col-12 ">
                                    <div class="discount-code-wrapper">
                                        <div class="title-wrap">
                                            <h4 class="cart-bottom-title section-bg-gray">{{__('msg.use_coupan_code')}}</h4>
                                        </div>
                                        @if(intval($data['coupon'] ?? 0))
                                        <div class="form-group" id='couponAppliedDiv'>
                                            <label class="title-sec">{{__('msg.coupon_code')}}</label>
                                            <div class="alert alert-success">{{ $data['coupon']['promo_code_message'] }}</div>
                                            <div class="input-group">
                                                <input type="text" class="form-control" value="{{ $data['coupon']['promo_code'] }}" disabled="disabled" placeholder="Coupon code">
                                                <span class="input-group-append">
                                                    <a href="{{ route('coupon-remove') }}" class="btn btn-danger" id='removeCoupon'>x</a>
                                                </span>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="discount-code">
                                            <p>{{__('msg.enter_your_coupon_code_if_you_have_one')}}</p>
                                            <form action="{{ route('coupon-apply') }}" method="POST" class='ajax-form {{ intval($data['coupon'] ?? 0) ? 'address-hide' : '' }}' id='couponForm'>
                                                <input type="hidden" name="total" value="{{ $data['total'] }}">
                                                <div class='formResponse'></div>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="coupon" value="{{ $data['coupon']['promo_code'] ?? '' }}" placeholder="Coupon code">
                                                    <span class="input-group-append">
                                                        <button class="btn btn-primary">{{__('msg.apply_coupan')}}</button>
                                                    </span>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-12 ">
                                    <div class="discount-code-wrapper coupan__wrapper">
                                        <div class="title-wrap">
                                            <h4 class="cart-bottom-title section-bg-gray">{{__('msg.offers')}}</h4>
                                        </div>

                                        <div class="discount-code">
                                            <p>{{__('msg.copy_and_paste_code_in_coupan_code_to_get_exciting_discount')}}</p>
                                            @foreach($data['code_list'] as $c)
                                            @if(isset($c->id) && !($c->is_validate[0]->error))
                                            <div class="inner__sec_discount mb-2">
                                                <h5 class="">{{$c->is_validate[0]->promo_code_message}}</h5>
                                                <p class="themeclr">You will save {{$c->is_validate[0]->discount}} with this code</p>
                                                <p class="pt-1 coupan_text">{{$c->promo_code}}</p>
                                            </div>
                                            @else
                                            <div class="inner__sec_discount mb-2">
                                                <h5 class="">{{$c->message}}</h5>
                                                <p class="redclr">{{$c->is_validate[0]->message}}</p>
                                                <p class="pt-1 coupan_text">{{$c->promo_code}}</p>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endif
                                <div class="col-lg-4 col-md-4 col-12 ">
                                    <div class="grand-total-content">
                                        <div class="title-wrap">
                                            <h4 class="cart-bottom-title section-bg-gary-cart">{{__('msg.cart_total')}}</h4>
                                        </div>
                                        <h5>{{__('msg.subtotal')}} : <span>{{ get_price(sprintf("%0.2f",$data['subtotal'] ?? '-')) }}</span></h5>
                                        @if(isset($data['shipping']) && floatval($data['shipping']))
                                        <h5>{{__('msg.delivery_charge')}} : <span>
                                                {{ get_price(sprintf("%0.2f",$data['shipping'])) }}</span>
                                        </h5>
                                        @endif
                                        @if(isset($data['coupon']['discount']) && floatval($data['coupon']['discount']))
                                        <h5>{{__('msg.discount')}} :
                                            <span>{{ get_price(sprintf("%0.2f",$data['coupon']['discount'])) ?? '-' }}</span>
                                        </h5>
                                        @endif
                                        @if(isset($data['saved_price']) && floatval($data['saved_price']))
                                        <h5>{{__('msg.saved_price')}} :
                                            <span>{{ get_price(sprintf("%0.2f",$data['saved_price'])) }}</span>
                                        </h5>
                                        @endif
                                        <a href="{{ route('checkout-payment') }}">{{__('msg.Proceed to Payment')}}&nbsp;&nbsp;<em class="fas fa-angle-double-right"></em></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

