<section class="padding-bottom footerfix section-content order1">
    <a href="#" id="scroll"><span></span></a>
    <div class="page_title corner-title overflow-visible">
        <ol class="breadcrumb">
            <li class=" item-1"></li>
            <li class="breadcrumb-item"><a href="{{ route('my-account') }}">{{ __('msg.my_account') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('msg.orders') }}</li>
        </ol>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3 col-md-12 col-12 mb-4">
                @include("themes.".get('theme').".user.order-sidebar")
            </div>
            <div class="col-lg-9 col-md-12 col-12">

                <div class="card mb-4 shadow px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                    @if(isset($data['list']) && isset($data['list']['data']) && count($data['list']['data']))
                    @foreach($data['list']['data'] as $w)
                    <div class="row">
                        <div class="col">
                            <span class="text-dark product-name">{{ __('msg.ordered_id') }} :
                                {{ $w->id ?? '-' }}
                            </span>
                            <br>
                            <span class="text-dark product-name">{{ __('msg.order_date') }} :
                                {{ isset($w->date_added) ? date('d-m-Y', strtotime($w->date_added)) : '' }}
                            </span>
                        </div>
                        <div class="form-group orderview-details">
                            <div class="wallet-header">
                                <a href="{{ route('order-track-item', $w->id ?? 0) }}">
                                    <button class="btn btn-sm btn-primary">{{ __('msg.view_details') }}</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row no-gutters order">
                        <div class="">
                            @if(isset($w->items) && is_array($w->items) && count($w->items))
                            <p>{{count($w->items)}}  @if(count($w->items)=='1'){{__('msg.Item')}}@else{{__('msg.Items')}}@endif</p>
                            <p class="text-dark">
                                @foreach ($w->items as $itm)
                                @if (isset($itm->id) && intval($itm->id))
                                {{ $itm->name }},
                                @endif
                                @endforeach
                            </p>
                            @endif
                            <p>{{ get_price($w->final_total) }}</p>
                            <p>{{__('msg.via')}} {{ strtoupper($w->payment_method) }}</p>
                            <p>{{ strtoupper($w->active_status) }}</p>
                            <p class="btn btn-dark pe-none rounded"><em class="fas fa-motorcycle"></em> @if($w->local_pickup=='0'){{__('msg.door_step_delivery')}}@else{{__('msg.pickup_from_store')}}@endif</p>
                        </div>
                    </div>
                    <hr>
                    @endforeach
                    @else
                </div>
                <div class="row text-center">
                    <div class="col-12">
                        <br><br>
                        <h3>{{ __('msg.no_orders_found') }}.</h3>
                    </div>
                    <div class="col-12">
                        <br><br>
                        <a href="{{ route('shop') }}" class="btn btn-primary"><em class="fa fa-chevron-left mr-1"></em>
                            {{ __('msg.continue_shopping') }}
                        </a>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col">
                        @if (isset($data['last']) && $data['last'] != '')
                        <a href="{{ $data['last'] }}" class="btn btn-primary pull-left text-white">
                            <em class="fa fa-arrow-left"></em> {{ __('msg.previous') }}
                        </a>
                    </div>
                    @endif

                    <div class="col text-right">
                        @if (isset($data['next']) && $data['next'] != '')
                        <a href="{{ $data['next'] }}" class="btn btn-primary pull-right text-white">{{ __('msg.next') }}
                            <em class="ml-2 fa fa-arrow-right"></em>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>