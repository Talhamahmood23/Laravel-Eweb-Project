<section class="section-content padding-bottom">
    <a href="#" id="scroll"><span></span></a>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-2 px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                    <div class="row mt-2 mb-0">
                        <div class="ml-2 form-group col">
                            <span>{{ __('msg.order_otp') }} : {{ $data['list']->otp }}</span><br/>
                            <span class="text-dark product-name">{{ __('msg.ordered_id') }} :
                                {{ $data['list']->id }}</span><br>
                            <span class="text-dark product-name">{{ __('msg.order_date') }} : {{ $data['list']->date_added ? date('d-m-Y', strtotime($data['list']->date_added)) : '' }}</span>

                            @if ($data['list']->payment_method == 'bank_transfer')
                            <hr/>

                            <h6>{{ __('msg.Account Details!') }} :<br/><br/>
                                <ul>
                                    <li>{{ __('msg.Account Name') }} : {{ Cache::get('payment_methods')->account_name }}</li>
                                    <li>{{ __('msg.Account Number') }} : {{ Cache::get('payment_methods')->account_number }}</li>
                                    <li>{{ __('msg.Bank Name') }} : {{ Cache::get('payment_methods')->bank_name }}</li>
                                    <li>{{ __('msg.Bank Code') }} : {{ Cache::get('payment_methods')->bank_code }}</li>
                                </ul>

                            </h6>
                            <h6>{{ __('msg.Note') }} : {{ Cache::get('payment_methods')->notes }}</h6>
                            <hr/>
                            <h6>{{ __('msg.Bank Payment Receipt') }} : </h6>

                            <div class="col-12">
                                <form method='POST' enctype="multipart/form-data" id="bank_receipt_form">
                                    @csrf
                                    <input class="fileinput" type="file" name="image[]" accept="image/jpeg,image/jpg,image/png,application/pdf,image/x-eps" id="bank_receipt" multiple required/>
                                    <input type="hidden" name="order_id" value="{{ $data['list']->id }}">
                                    <input type="hidden" name="accesskey" value="90336">
                                    <input type="hidden" name="upload_bank_transfers_attachment" value="1">
                                    <button type="submit" name="submit" value="submit" id="submit_btn" class=" btn btn-primary">{{__('msg.Send')}}</button>
                                </form>

                                <h6 class="r_attach">
                                    @foreach ($data['list']->attachment as $attach)
                                    <span class="image_data" id="image_data{{$attach->id}}">
                                        <input type="hidden" name="order_id" value="{{ $data['list']->id }}" class="order_id">
                                        <input type="hidden" name="accesskey" value="90336" class="accesskey">
                                        <input type="hidden" name="delete_bank_transfers_attachment" value="1" class="delete_bank_transfers_attachment">
                                        <input type="hidden" name="id" value="{{$attach->id}}" class="id">
                                        <a href="{{$attach->image}}" target="_blank" class="outer_receipt">
                                            <img src="{{$attach->image}}" class="receipt_img img-fluid">
                                        </a>
                                        <i class="fa fa-times attach_image_delete"></i>
                                    </span>
                                    @endforeach
                                </h6>
                            </div>

                            @endif
                        </div>
                    </div>
                    <hr class="mt-0">

                    @foreach ($data['list']->items as $itm)
                    @php
                    $allStatus = ['received' => 0, 'processed' => 1, 'shipped' => 2, 'delivered' => 3];
                    $orderPlaced = '';
                    $orderProcessed = '';
                    $orderShipped = '';
                    $orderReady_to_pickup='';
                    $orderDelivered = '';
                    $orderCancelled = '';
                    $orderReturned = '';
                    foreach ($itm->status as $s) {
                    if ($s[0] == 'received') {
                    $orderPlaced = $s[1];
                    } elseif ($s[0] == 'processed') {
                    $orderProcessed = $s[1];
                    } elseif ($s[0] == 'shipped') {
                    $orderShipped = $s[1];
                    } elseif ($s[0] == 'ready_to_pickup') {
                    $orderReady_to_pickup = $s[1];
                    } elseif ($s[0] == 'delivered') {
                    $orderDelivered = $s[1];
                    } elseif ($s[0] == 'cancelled') {
                    $orderCancelled = $s[1];
                    } elseif ($s[0] == 'returned') {
                    $orderReturned = $s[1];
                    }
                    }
                    @endphp

                    <div class="row no-gutters mb-3">
                        <div class="order_img_content">
                            <img class="fav-image" src="{{ $itm->image }}" alt="{{ $itm->name ?? '' }}">
                            <div class="card-body">
                                <a href="#" class="card-title text-dark">{{ strtoupper($itm->name) }}
                                    <small>{{ strtoupper(($itm->measurement ?? '') . ' ' . ($itm->unit ?? '')) }}</small></a>
                                <p class="small text-muted mb-0">{{ __('msg.qty') }} : {{ $itm->quantity }}</p>
                                <p class="card-text mb-0">
                                    <span class="font-weight-bold text-dark">{{ get_price($itm->sub_total) }}</span>
                                </p>
                                <small class="text-primary font-weight-bold">
                                    {{ __('msg.via') }}
                                    {{ strtoupper($data['list']->payment_method ?? '') }}
                                </small>

                                <p>
                                    <span class="form-group font-weight-bold text-success">{{ strtoupper($itm->active_status) }}</span>
                                </p>
                                @if ($orderCancelled == '')
                                @if (intval($itm->cancelable_status) && intval($allStatus[$itm->active_status] ?? 0) <= intval($allStatus[$itm->till_status ?? 0]))
                                <span class="form-group orderalign">
                                    <a role="button" href="{{ route('order-item-status', ['orderId' => $data['list']->id, 'orderItemId' => $itm->id, 'status' => 'cancelled']) }}" data-confirm="Are you sure, you want to cancel this item?">
                                        <button class="btn btn-sm btn-primary">
                                            {{ __('msg.cancel_item') }}
                                        </button>
                                    </a>
                                </span>
                                @endif
                                @if ($orderDelivered != '' && intval($itm->return_status))
                                <span class="form-group orderalign">
                                    <a role="button" href="{{ route('order-item-status', ['orderId' => $data['list']->id, 'orderItemId' => $itm->id, 'status' => 'returned']) }}"
                                       data-confirm="Are you sure, you want to return this item?">
                                        <button class="btn btn-sm btn-primary">
                                            {{ __('msg.return_item') }}
                                        </button>
                                    </a>
                                </span>
                                @endif
                                @endif

                            </div>
                        </div>
                    </div>
                    @endforeach
                    @php
                    $allStatus = ['received' => 0, 'processed' => 1, 'shipped' => 2, 'delivered' => 3];
                    $orderPlaced = '';
                    $orderProcessed = '';
                    $orderShipped = '';
                    $orderReady_to_pickup='';
                    $orderDelivered = '';
                    $orderCancelled = '';
                    $orderReturned = '';
                    foreach ($data['list']->status as $s) {
                    if ($s[0] == 'received') {
                    $orderPlaced = $s[1];
                    } elseif ($s[0] == 'processed') {
                    $orderProcessed = $s[1];
                    } elseif ($s[0] == 'shipped') {
                    $orderShipped = $s[1];
                    } elseif ($s[0] == 'ready_to_pickup') {
                    $orderReady_to_pickup = $s[1];
                    }elseif ($s[0] == 'delivered') {
                    $orderDelivered = $s[1];
                    } elseif ($s[0] == 'cancelled') {
                    $orderCancelled = $s[1];
                    } elseif ($s[0] == 'returned') {
                    $orderReturned = $s[1];
                    }
                    }
                    @endphp
                    @if (count($itm->status))
                    <div class="track-order">
                        <div class="bs-wizard">
                            @if ($orderPlaced != '')
                            <div class="bs-wizard-step complete">
                                <div class="text-center bs-wizard-stepnum">{{ __('msg.order_placed') }}</div>
                                <div class="progress">
                                    <div class="progress-bar"></div>
                                </div>
                                <a href="javascript:void(0)" class="bs-wizard-dot"></a>
                                <div class="bs-wizard-info text-center text-muted">
                                    {{ date('d-m-Y', strtotime($orderPlaced)) }}
                                </div>
                                <div class="bs-wizard-info text-center text-muted">
                                    {{ date('h:i:s A', strtotime($orderPlaced)) }}
                                </div>
                            </div>
                            @endif
                            @if ($orderProcessed != '')
                            <div class="bs-wizard-step complete">
                                <!-- complete -->
                                <div class="text-center bs-wizard-stepnum">
                                    {{ __('msg.order_processed') }}
                                </div>
                                <div class="progress">
                                    <div class="progress-bar"></div>
                                </div>
                                <a href="javascript:void(0)" class="bs-wizard-dot"></a>
                                <div class="bs-wizard-info text-center text-muted">
                                    {{ date('d-m-Y', strtotime($orderProcessed)) }}
                                </div>
                                <div class="bs-wizard-info text-center text-muted">
                                    {{ date('h:i:s A', strtotime($orderProcessed)) }}
                                </div>
                            </div>
                            @elseif($orderCancelled == "")
                            <div class="bs-wizard-step disabled">
                                <!-- complete -->
                                <div class="text-center bs-wizard-stepnum">
                                    {{ __('msg.order_processed') }}
                                </div>
                                <div class="progress">
                                    <div class="progress-bar"></div>
                                </div>
                                <a href="#" class="bs-wizard-dot"></a>
                            </div>
                            @endif
                            @if($data['list']->local_pickup == '1')
                            @if ($orderReady_to_pickup != '')
                            <div class="bs-wizard-step complete">
                                <!-- complete -->
                                <div class="text-center bs-wizard-stepnum">
                                    {{ __('msg.ready_to_pickup') }}
                                </div>
                                <div class="progress">
                                    <div class="progress-bar"></div>
                                </div>
                                <a href="javascript:void(0)" class="bs-wizard-dot"></a>
                                <div class="bs-wizard-info text-center text-muted">
                                    {{ date('d-m-Y', strtotime($orderReady_to_pickup)) }}
                                </div>
                                <div class="bs-wizard-info text-center text-muted">
                                    {{ date('h:i:s A', strtotime($orderReady_to_pickup)) }}
                                </div>
                            </div>
                            @elseif($orderCancelled == "")
                            <div class="bs-wizard-step disabled">
                                <!-- complete -->
                                <div class="text-center bs-wizard-stepnum">
                                    {{ __('msg.ready_to_pickup') }}</div>
                                <div class="progress">
                                    <div class="progress-bar"></div>
                                </div>
                                <a href="#" class="bs-wizard-dot"></a>
                            </div>
                            @endif
                            @else
                            @if ($orderShipped != '')
                            <div class="bs-wizard-step complete">
                                <!-- complete -->
                                <div class="text-center bs-wizard-stepnum">
                                    {{ __('msg.order_shipped') }}
                                </div>
                                <div class="progress">
                                    <div class="progress-bar"></div>
                                </div>
                                <a href="javascript:void(0)" class="bs-wizard-dot"></a>
                                <div class="bs-wizard-info text-center text-muted">
                                    {{ date('d-m-Y', strtotime($orderShipped)) }}
                                </div>
                                <div class="bs-wizard-info text-center text-muted">
                                    {{ date('h:i:s A', strtotime($orderShipped)) }}
                                </div>
                            </div>
                            @elseif($orderCancelled == "")
                            <div class="bs-wizard-step disabled">
                                <!-- complete -->
                                <div class="text-center bs-wizard-stepnum">
                                    {{ __('msg.order_shipped') }}</div>
                                <div class="progress">
                                    <div class="progress-bar"></div>
                                </div>
                                <a href="#" class="bs-wizard-dot"></a>
                            </div>
                            @endif
                            @endif
                            @if ($orderDelivered != '')
                            <div class="bs-wizard-step complete">
                                <!-- active -->
                                <div class="text-center bs-wizard-stepnum">
                                    {{ __('msg.order_delivered') }}
                                </div>
                                <div class="progress">
                                    <div class="progress-bar"></div>
                                </div>
                                <a href="javascript:void(0)" class="bs-wizard-dot"></a>
                                <div class="bs-wizard-info text-center text-muted">
                                    {{ date('d-m-Y', strtotime($orderDelivered)) }}
                                </div>
                                <div class="bs-wizard-info text-center text-muted">
                                    {{ date('h:i:s A', strtotime($orderDelivered)) }}
                                </div>
                            </div>
                            @elseif($orderCancelled == "")
                            <div class="bs-wizard-step disabled">
                                <!-- complete -->
                                <div class="text-center bs-wizard-stepnum">
                                    {{ __('msg.order_delivered') }}</div>
                                <div class="progress">
                                    <div class="progress-bar"></div>
                                </div>
                                <a href="#" class="bs-wizard-dot"></a>
                            </div>
                            @endif
                            @if($orderCancelled != "")
                            <div class="bs-wizard-step complete">
                                <!-- active -->
                                <div class="text-center bs-wizard-stepnum">
                                    {{ __('msg.order_cancelled') }}
                                </div>
                                <div class="progress">
                                    <div class="progress-bar"></div>
                                </div>
                                <a href="javascript:void(0)" class="bs-wizard-dot"></a>
                                <div class="bs-wizard-info text-center text-muted">
                                    {{ date('d-m-Y', strtotime($orderCancelled)) }}
                                </div>
                                <div class="bs-wizard-info text-center text-muted">
                                    {{ date('h:i:s A', strtotime($orderCancelled)) }}
                                </div>
                            </div>
                            @endif
                            @if ($itm->applied_for_return == true)
                            @if ($orderReturned != '')
                            <div class="bs-wizard-step disabled">
                                <!-- active -->
                                <div class="text-center bs-wizard-stepnum">
                                    {{ __('msg.order_returned') }}
                                </div>
                                <div class="progress">
                                    <div class="progress-bar"></div>
                                </div>
                                <a href="javascript:void(0)" class="bs-wizard-dot"></a>
                                <div class="bs-wizard-info text-center text-muted">
                                    {{ date('d-m-Y', strtotime($orderDelivered)) }}
                                </div>
                                <div class="bs-wizard-info text-center text-muted">
                                    {{ date('h:i:s A', strtotime($orderDelivered)) }}
                                </div>
                            </div>
                            @elseif($orderCancelled == "")
                            <div class="bs-wizard-step disabled">
                                <!-- complete -->
                                <div class="text-center bs-wizard-stepnum">
                                    {{ __('msg.order_returned') }}</div>
                                <div class="progress">
                                    <div class="progress-bar"></div>
                                </div>
                                <a href="#" class="bs-wizard-dot"></a>
                            </div>
                            @endif
                            @endif
                        </div>
                    </div>
                    <hr>
                    <span class="form-group orderalign ms-3 mb-3">
                        <a role="button" href="{{ route('order-status', ['orderId' => $data['list']->id, 'status' => 'cancelled']) }}" data-confirm="Are you sure, you want to cancel this order?">
                            <button class="btn btn-sm btn-warning">
                                {{ __('msg.cancel_order') }}
                            </button>
                        </a>
                    </span>
                    <span class="form-group orderalign mb-3">
                        <a role="button" href="{{ route('re-order', ['orderId' => $data['list']->id]) }}" data-confirm="Are you sure, you want to re-order this order?">
                            <button class="btn btn-sm btn-primary">
                                {{ __('msg.re_order') }}
                            </button>
                        </a>
                    </span>
                    @if($itm->active_status == 'delivered') 
                    <span class="form-group orderalign mb-3">
                        <a role="button" href="{{ route('invoice_pdf', ['orderId' => $data['list']->id]) }}" class="btn btn-sm btn-dark" target="_blank">
                            <i class="fas fa-file-invoice pe-2"></i>{{ __('msg.invoice') }}
                        </a>
                    </span>
                    @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-md-6 col-12">
                <div class="card  px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded mb-2">
                    <span class="m-2 font-weight-bold text-dark">{{ __('msg.price_detail') }}</span>

                    <div class="row mr-5">
                        <div class="ml-2 form-group col">
                            <span class="text-dark product-name">{{ __('msg.items_amount') }} : </span>
                        </div>
                        <div class="form-group">
                            <span class="price2">{{ get_price($data['list']->total, false) }}</span>
                        </div>
                    </div>

                    <div class="row mr-5">
                        <div class="ml-2 form-group col">
                            <span class="text-dark product-name">{{ __('msg.delivery_charge') }} : </span>
                        </div>
                        <div class="form-group">
                            <span class="price2">+ {{ get_price($data['list']->delivery_charge, false) }}</span>
                        </div>
                    </div>

                    <div class="row mr-5">
                        <div class="ml-2 form-group col">
                            <span
                                class="text-dark product-name">{{ __('msg.tax') }}({{ $data['list']->tax_percentage }}%)
                                : </span>
                        </div>
                        <div class="form-group">
                            <span class="price2">+ {{ get_price($data['list']->tax_amount, false) }}</span>
                        </div>
                    </div>

                    <div class="row mr-5">
                        <div class="ml-2 form-group col">
                            <span class="text-dark product-name">{{ __('msg.discount') }}(0%) : </span>
                        </div>
                        <div class="form-group">
                            <span class="price2">- {{ get_price($data['list']->discount, false) }}</span>
                        </div>
                    </div>

                    <div class="row mr-5">
                        <div class="ml-2 form-group col">
                            <span class="text-dark product-name">{{ __('msg.total') }} : </span>
                        </div>
                        <div class="form-group">
                            <span class="price">{{ get_price(floatval($data['list']->total) + floatval($data['list']->delivery_charge) + floatval($data['list']->tax_amount) - floatval($data['list']->discount), false) }}</span>
                        </div>
                    </div>

                    <div class="row mr-5">
                        <div class="ml-2 form-group col">
                            <span class="text-dark product-name">{{ __('msg.promo_code_discount') }} : </span>
                        </div>
                        <div class="form-group">
                            <span class="price2">- {{ get_price($data['list']->promo_discount, false) }}</span>
                        </div>
                    </div>

                    <div class="row mr-5">
                        <div class="ml-2 form-group col">
                            <span class="text-dark product-name">{{ __('msg.wallet_balance') }} : </span>
                        </div>
                        <div class="form-group">
                            <span class="price2">-{{ get_price($data['list']->wallet_balance, false) }}</span>
                        </div>
                    </div>

                    <div class="row mr-5">
                        <div class="ml-2 form-group col">
                            <span class="text-dark font-weight-bold">{{ __('msg.final_total') }} : </span>
                        </div>
                        <div class="form-group">
                            <span class="text-primary font-weight-bold">{{ get_price($data['list']->final_total, false) }}</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card  px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded mb-2">
                    <span class="m-2 font-weight-bold text-dark">{{ __('msg.other_details') }}</span>
                    <div class="ml-4">
                        <div class="row">
                            <div class="form-group">
                                <span class="text-dark product-name">{{ __('msg.name') }} : {{ $data['list']->user_name }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <span class="text-dark product-name">{{ __('msg.mobile_no') }}: {{ $data['list']->mobile }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <span class="text-dark product-name">{{ __('msg.address') }} : {{ $data['list']->address ?? '' }}</span>
                            </div>
                        </div>
                        @if($data['list']->local_pickup == '1')
                        <div class="row">
                            <div class="form-group">
                                <span class="text-dark product-name">{{ __('msg.estimate_pickup_time') }} : {{  $data['list']->pickup_time ? date(" F j, Y h:i:sa", strtotime($data['list']->pickup_time)) :  __('msg.please_wait_till_accept_order') }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <span class="text-dark product-name">{{ __('msg.seller_note') }} : {{  $data['list']->seller_notes }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <span class="text-dark product-name">{{ __('msg.seller_details') }} : <br/><em class="fa fa-store"></em>{{ (Cache::get('store_address')) }}<br/><em class="fa fa-phone"></em> {{ (Cache::get('support_number')) }}<br/>
                                    <a class="btn btn-dark" href="https://maps.google.com/?q={{ (Cache::get('map_latitude')) }},{{ (Cache::get('map_longitude')) }}" target="_blank"><i class="fas fa-map-marker-alt pe-2"></i>{{ __('msg.get_shop_direction') }}</a></span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!--- cancel confirm box -->
        <div class="modal" id="modal">
            <div class="modal-dialog mt-2">
                <div class="modal-content">
                    <div class="modal-body">
                        <span class="text-dark text-center">{{ __('msg.are_you_sure') }}</span>
                        <div class="row mr-1">
                            <a href="" id="modal-btn-yes" class="btn text-primary font-weight-bold">{{ __('msg.yes') }}</a>
                            <button type="button" class="btn font-weight-bold text-primary" data-dismiss="modal">{{ __('msg.no') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--- cancel confirm box -->
    </div>
</section>
