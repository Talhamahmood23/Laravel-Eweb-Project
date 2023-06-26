<section class="section-content footerfix padding-bottom mt-5 checkoutpayment">
    <a href="#" id="scroll"><span></span></a>
    <div class="container">
        <div class="card px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded mb-4">
            <div class="row">
                
                <div class="col-md-4 col-sm-4 col-12 text-center">
                    <a href="{{ route('checkout-address') }}"><span class="icon dark"><em class="fa fa-chevron-circle-right delivery-icon"></em> {{__('msg.address')}}</span></a>
                </div>
                <div class="col-md-4 col-sm-4 col-12 text-center">
                    <span class="icon dark"><em class="fa fa-chevron-circle-right delivery-icon"></em>{{__('msg.payment')}}</span>
                </div>
            </div>
        </div>

        <main>
            <div>
                <div class="row">
                    <div class="col-md-12" id="balance">
                        <div class="card shadow p-3 mb-4">
                            <div class="custom-control title-sec custom-checkbox mb-1">
                                <input type="checkbox" class="custom-control-input" id="wallet" data-amount='{{ $data['user']['balance'] ?? '0' }}' />
                                <label class="custom-control-label" for="wallet">{{__('msg.wallet_balance')}}</label>
                            </div>
                            <small class="text-muted custom-control">{{__('msg.total_balance')}}: {{ get_price($data['user']['balance'] ?? '0', false) }}</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        @if(isset(Cache::get('timeslot')->slots) && count(Cache::get('timeslot')->slots))
                        <div class="card shadow mb-4">
                            <h3 class="card-title title-sec ml-3 mt-3" id="myDec">{{__('msg.select_delivery_day')}}</h3>
                            <table class="table table-borderless table-shopping-cart" aria-describedby="myDec"
                                   aria-hidden="true">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <div class="alert alert-danger" id="dateError">{{__('msg.select_suitable_delivery_date')}}</div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group calender w-100">
                                                    <div id="calendar">
                                                        <div id="datepicker"
                                                             data-start='{{ Cache::get('delivery_starts_from', 0) }}'
                                                             data-end='{{ Cache::get('allowed_days', 0) }}'>
                                                        </div>
                                                        <em class="calender-icon fa fa-calendar-o"></em> <span id='deliveryDatePrint'></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <h3 class="title-sec card-title ml-3" id="myDec3">{{__('msg.select_delivery_time')}}</h3>
                            <table class="table table-borderless table-shopping-cart" aria-describedby="myDec3" aria-hidden="true">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <div class="alert alert-danger" id="timeError">{{__('select_payment_suitable_delivery_time')}}</div>
                                            </div>
                                            <div class="form-group" id="time">
                                                @foreach(Cache::get('timeslot')->slots as $slot)
                                                @if($slot->status == 1)
                                                <label class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="deliverTime"
                                                           value="{{ $slot->title }}" data-from="{{ $slot->from_time }}"
                                                           data-to="{{ $slot->to_time }}"
                                                           data-last="{{ $slot->last_order_time }}">
                                                    <span class="custom-control-label"> {{ $slot->title }}</span>
                                                </label>
                                                @endif
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow">
                            <h3 class="card-title title-sec ml-3 mt-3" id="myDec2">{{__('msg.payment_method')}}</h3>
                            <table class="table table-borderless table-shopping-cart" aria-describedby="myDec2" aria-hidden="true">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <div class="alert alert-danger" id="paymentError">{{__('msg.select_payment_method')}}</div>
                                            </div>
                                            <div class="form-group">
                                                @if(isset(Cache::get('payment_methods')->cod_payment_method) &&
                                                Cache::get('payment_methods')->cod_payment_method == 1)
                                                <label class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" value="cod" name='payment_method' checked>
                                                    <span class="custom-control-label">{{__('msg.cash_on_delivery')}}</span>
                                                </label>
                                                @endif
                                                @if(isset(Cache::get('payment_methods')->paypal_payment_method) &&
                                                Cache::get('payment_methods')->paypal_payment_method == 1)
                                                <label class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" value="paypal" name='payment_method'>
                                                    <span class="custom-control-label"> {{__('msg.paypal')}}</span>
                                                </label>
                                                @endif
                                                @if(isset(Cache::get('payment_methods')->payumoney_payment_method) &&
                                                Cache::get('payment_methods')->payumoney_payment_method == 1)
                                                <label class="custom-control custom-radio" id="PayUMoney">
                                                    <input class="custom-control-input" type="radio" value="payumoney" name='payment_method'>
                                                    <span class="custom-control-label"> {{__('msg.PayUMoney')}}</span>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" value="payumoney-bolt" name='payment_method'>
                                                    <span class="custom-control-label"> {{__('msg.PayUMoney')}}</span>
                                                </label>
                                                @endif
                                                @if(isset(Cache::get('payment_methods')->razorpay_payment_method) &&
                                                Cache::get('payment_methods')->razorpay_payment_method == 1)
                                                <label class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" value="razorpay" name='payment_method'>
                                                    <span class="custom-control-label"> {{__('msg.Razorpay')}}</span>
                                                </label>
                                                @endif
                                                @if(isset(Cache::get('payment_methods')->stripe_payment_method) &&
                                                Cache::get('payment_methods')->stripe_payment_method == 1)
                                                <label class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" value="stripe" name='payment_method'>
                                                    <span class="custom-control-label"> {{__('msg.Stripe')}}</span>
                                                </label>
                                                @endif

                                                @if(isset(Cache::get('payment_methods')->flutterwave_payment_method) &&
                                                Cache::get('payment_methods')->flutterwave_payment_method == 1)
                                                <label class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" value="flutterwave" name='payment_method'>
                                                    <span class="custom-control-label"> {{__('msg.flutterwave')}}</span>
                                                </label>
                                                @endif
                                                @if(isset(Cache::get('payment_methods')->paystack_payment_method) &&
                                                Cache::get('payment_methods')->paystack_payment_method == 1)
                                                <label class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" value="paystack" name='payment_method'>
                                                    <span class="custom-control-label"> {{__('msg.paystack')}}</span>
                                                </label>
                                                @endif
                                                @if(isset(Cache::get('payment_methods')->paytm_payment_method) &&
                                                Cache::get('payment_methods')->paytm_payment_method == 1)
                                                <label class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" value="paytm" name='payment_method'>
                                                    <span class="custom-control-label"> {{__('msg.paytm')}}</span>
                                                </label>
                                                @endif
                                                @if (isset(Cache::get('payment_methods')->ssl_method) && Cache::get('payment_methods')->ssl_method == 1)
                                                <label class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" value="sslecommerz" name='payment_method'>
                                                    <span class="custom-control-label"> {{__('msg.SSLECOMMERZ')}}</span>
                                                </label>
                                                @endif
                                                @if (isset(Cache::get('payment_methods')->direct_bank_transfer_method) && Cache::get('payment_methods')->direct_bank_transfer_method == 1)
                                                <label class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" value="bank_transfer" name='payment_method'>
                                                    <span class="custom-control-label"> {{__('msg.bank_transfer')}}</span>
                                                </label>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="text-center mb-3">
                                <a role="button" data-confirm="Confirm Order Amount">
                                    <button id='proceed' class="btn btn-primary text-uppercase add-to-cart">
                                        {{__('msg.procced')}} <em class="fa fa-arrow-right"></em>
                                    </button>
                                </a>
                            </p>
                        </div>
                        <div class="alert alert-warning col-lg-12 mt-10 bank_transfer_warning">
                            <p><strong>{{__('msg.Instruction')}} <br></strong> {{__('msg.bank_detail_instruction1')}}<br/>{{__('msg.bank_detail_instruction2')}}</p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- The Modal -->
            <div id="orderConfirm" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content px-3">
                        <div class="modal-header">
                            <p class="font-weight-bold">{{__('msg.confirm_order_amount')}}</p>
                            <button type="button" class="close rtl_close_inner" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <tr>
                                <td>
                                    <p class="product-name pb-1">{{__('msg.subtotal')}} :
                                        <span>{{ $data['subtotal'] ?? '-' }}</span></p>
                                    
                                    @if(isset($data['shipping']) && floatval($data['shipping']))
                                    <p class="product-name pb-1">{{__('msg.delivery_charge')}} : <span>+
                                            {{ get_price($data['shipping']) }}</span></p>
                                    @endif
                                    @if(isset($data['coupon']['discount']) && floatval($data['coupon']['discount']))
                                    <p class="product-name pb-1">{{__('msg.discount')}} : <span>-
                                            {{ get_price($data['coupon']['discount']) }}</span></p>
                                    @endif
                                    <p class="product-name pb-1">{{__('msg.total')}} : <span> {{ $data['total'] }}</span>
                                    </p>
                                </td>
                            </tr>
                            <tr class="text-left">
                                <td>
                                    <strong>
                                        <p class="checkout-total walletNotUsed pb-1">{{ __('msg.final_total')}} :
                                            <span>{{ $data['total'] }}</span></p>

                                        @if(intval($data['user']['balance'] ?? 0))
                                        @if(floatval($data['user']['balance']) > floatval($data['total']))
                                        <p class="product-name walletUsed pb-1">{{__('msg.wallet_from')}} :
                                            <span>{{ floatval($data['total']) }}</span></p>
                                        <p class="checkout-total walletUsed">{{__('msg.total_payable')}} :
                                            <span>0</span><input type="hidden" value="0" name="total_payable"></p>

                                        @else
                                        <p class="product-name walletUsed pb-1">{{__('msg.wallet_from')}} :
                                            <span>-{{ $data['user']['balance'] ?? '0' }}</span></p>
                                        <p class="checkout-total walletUsed pb-1">{{__('msg.total_payable')}} :
                                            <span>{{ floatval($data['total']) - floatval($data['user']['balance']) }}</span>
                                            <input type="hidden" value="{{ floatval($data['total']) - floatval($data['user']['balance']) }}" name="total_payable">
                                        </p>
                                        @endif
                                        @endif
                                    </strong>
                                </td>
                            </tr>

                            <div class="cancel_confirm">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('msg.cancel')}}</button>
                                <form action="{{ route('checkout-proceed') }}" method="POST" class="paybtn">
                                    <input type="hidden" name="deliverDay" id="date" class="deliveryDate">
                                    <input type="hidden" name="deliveryTime" class="deliveryTime">
                                    <input type="hidden" name="paymentMethod">
                                    <input type="hidden" name="wallet_used" value="false">
                                    @if(intval($data['user']['balance'] ?? 0))
                                    @if(floatval($data['user']['balance']) > floatval($data['total']))
                                    <input type="hidden" name="wallet_balance" value="{{ floatval($data['total']) }}">
                                    @else
                                    <input type="hidden" name="wallet_balance" value="{{ floatval($data['user']['balance']) }}">
                                    @endif
                                    @else
                                    <input type="hidden" name="wallet_balance" value="0">
                                    @endif
                                    <button type="submit" name="submit" value="submit" class="btn btn-primary ml-2">{{__('msg.confirm')}}</button>
                                </form>
                                <form action="{{ route('checkout-sslecommerz-init') }}" method="POST" class="sslbuttons">
                                    <div class="Place-order mt-25">
                                        <button class="" id="sslczPayBtn"
                                                token="if you have any token validation"
                                                postdata="your javascript arrays or objects which requires in backend"
                                                order="test time"> Pay Now</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</section>
<script>
    (function (window, document) {
        var loader = function () {
            var script = document.createElement("script"),
                    tag = document.getElementsByTagName("script")[0];
            script.src = "{{ asset('js/payment-gateway-sslcommerz.js') }}?" + Math.random().toString(36).substring(
                    7);
            tag.parentNode.insertBefore(script, tag);
        };
        window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload",
                loader);

    })(window, document);
</script>
<script src="{{ asset('js/checkout-payment.js') }}"></script>
