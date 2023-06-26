<section class="section-content padding-bottom mt-5 footerfix checkout__address">
    <a href="#" id="scroll"><span></span></a>
    <div class="container">
        <div class="card px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded mb-4">
            <div class="row">
                <div class="col-md-3 col-sm-4 col-12 text-center">
                    <a href="{{ route('cart') }}"><span class="icon dark"><em class="fa fa-chevron-circle-right  delivery-icon"></em>{{__('msg.cart')}}</span></a>
                </div>
                <div class="col-md-3 col-sm-4 col-12 text-center">
                    <span class="icon dark"><em class="fa fa-chevron-circle-right delivery-icon"></em>{{__('msg.address')}}</span>
                </div>
                <div class="col-md-3 col-sm-4 col-12 text-center">
                    <span class="icon dark"><em class="fa fa-chevron-circle-right"></em>{{__('msg.checkout')}}</span>
                </div>
                
                <div class="col-md-3 col-sm-4 col-12 text-center payment-icon">
                    <span class="icon dark"><em class="fa fa-chevron-circle-right"></em> {{__('msg.payment')}}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-12">
                @if (isset($data['address']) && is_array($data['address']) && count($data['address']))
                <div id="data-step1" class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                    <div class="m-0" id="address">
                        <div id="mydesc">
                            <div class="col-12 mb-20">
                                <div class="heading-part">
                                    <h3 class="sub-heading">{{__('msg.account_information')}}</h3>
                                </div>
                                <hr>
                            </div>
                            <form action="{{ route('checkout') }}" method="POST">
                                <div class="row">
                                    @foreach ($data['address'] as $a)
                                    @if (isset($a->id) && intval($a->id))
                                    <div class="col-md-6 mb-1">
                                        <div class="cart-total-table address-box commun-table ">
                                            <div class="table-responsive">
                                                <table class="table table-shopping-cart" aria-describedby="mydesc" aria-hidden="true">
                                                    <thead>
                                                        <tr class="delivery-address">
                                                            <th>
                                                                <input type="radio" name="id" value="{{ $a->id }}" {{ count($data['address']) == 1 || (isset($a->is_default) && intval($a->is_default)) ? 'checked=checked' : '' }}>
                                                                {{ $a->type }}
                                                                <span class="form-group edit-delete">
                                                                    <button class="btn editAddress" data-data='{{ json_encode($a) }}'>
                                                                        <em class="fa fa-pencil-alt"></em>
                                                                    </button>
                                                                    <a href="{{ route('address-remove', $a->id) }}" class="btn"> <em class="fas fa-times text-danger"></em></a>
                                                                </span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <ul class="check_address_inner">
                                                                    <li class="inner-heading">
                                                                        <b>{{ $a->name ?? '' }}</b>
                                                                    </li>
                                                                    <li>
                                                                        <p>{{ $a->address ?? '' }},
                                                                            {{ $a->area_name ?? '' }}<br>
                                                                            {{ $a->city_name ?? '' }}
                                                                            -
                                                                            {{ $a->pincode ?? '' }}<br>
                                                                            {{ __('msg.mobile') }}:
                                                                            {{ ($a->country_code ?? '') . ' ' . ($a->mobile ?? '-') }}
                                                                        </p>
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="add_new_address_btn col-md-6">
                                        <span onclick="address()" class="btn btn-primary">{{ __('msg.add_new_address') }}&nbsp;&nbsp;<em class="fas fa-plus"></em></span>
                                    </div>
                                    @if (isset($data['address'][0]))
                                    <div class="add_new_address_btn col-md-6">
                                        <button type="submit" class="btn btn-primary add-to-cart float-right">{{ __('msg.Proceed to Checkout') }}&nbsp;&nbsp;<em class="fas fa-angle-double-right"></em></button>
                                    </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-12" id="editAddress">
                        <div class="card dash-bg-right dash-bg-right1">
                            <h3>{{ __('msg.edit_address') }}</h3>
                            <hr class="mb-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg">
                                        <form action="{{ route('address-add') }}" id='formEditAddress' method="POST">
                                            <input type="hidden" name="id">
                                            <input type="hidden" name="latitude" value="0">
                                            <input type="hidden" name="longitude" value="0">
                                            <input type="hidden" name="country_code" value="0">

                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1">
                                                        <label>{{ __('msg.name') }}</label>
                                                        <div class="ui search focus">
                                                            <div class="ui left icon1 input card-detail-desc">
                                                                <input class="form-control" name="name" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1">
                                                        <label>{{ __('msg.mobile_no') }}</label>
                                                        <div class="ui search focus">
                                                            <div class="ui left icon1 input card-detail-desc">
                                                                <input class="form-control" id='editPhone' type="number" name="mobile">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1">
                                                        <label>{{ __('msg.alternate_mobile_no') }}</label>
                                                        <div class="ui search focus">
                                                            <div class="ui left icon1 input card-detail-desc">
                                                                <input class="form-control" type="number" name="alternate_mobile">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1">
                                                        <label>{{ __('msg.address') }}</label>
                                                        <div class="ui search focus">
                                                            <div class="ui left icon1 input card-detail-desc">
                                                                <input class="form-control" type="text" name="address">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1">
                                                        <label>{{ __('msg.landmark') }}</label>
                                                        <div class="ui search focus">
                                                            <div class="ui left icon1 input card-detail-desc">
                                                                <input class="form-control" type="text" name="landmark">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1">
                                                        <label>{{ __('msg.pincode') }}</label>
                                                        <div class="ui search focus">
                                                            <div class="ui left icon1 input card-detail-desc">
                                                                <input class="form-control" type="number" name="pincode">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1">
                                                        <label>{{ __('msg.select_city') }}</label>
                                                        <br>
                                                        <select name='city' class="form-control" required></select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1">
                                                        <label>{{ __('msg.select_area') }}</label>
                                                        <br>
                                                        <select name='area' class="form-control" required></select>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1">
                                                        <label>{{ __('msg.state') }}</label>
                                                        <div class="ui search focus">
                                                            <div class="ui left icon1 input card-detail-desc">
                                                                <input class="form-control" type="text" name="state" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1">
                                                        <label>{{ __('msg.country') }}</label>
                                                        <div class="ui search focus">
                                                            <div class="ui left icon1 input card-detail-desc">
                                                                <input class="form-control" type="text" name="country" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />

                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1">
                                                        <label class="radio-inline">
                                                            <input class="mr-2" type="radio" name="type" checked value="Home">{{ __('msg.home') }}
                                                        </label>
                                                        <label class="radio-inline  ml-5">
                                                            <input class="mr-2" type="radio" name="type" value="Work">{{ __('msg.work') }}
                                                        </label>
                                                        <label class="radio-inline  ml-5">
                                                            <input class="mr-2" type="radio" name="type" value="Other">{{ __('msg.other') }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1">
                                                        <input type="checkbox" name="is_default" class=" mt-1" />
                                                        <label class="control-label" for="default-address">{{ __('msg.set_as_default_address') }}</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group text-left">
                                                        <button type="submit" class="btn btn-primary  text-uppercase">{{ __('msg.update') }} </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12 text-left">
                                                    <div class="form-group">
                                                        <button class="btn btn-primary text-uppercase AddEditAddressCancel">{{ __('msg.cancel') }} </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="row padding-bottom {{ count($data['address']) > 0 ? '' : 'visible' }}">
                    <div class="col-md-12" id="addAddress">
                        <div class="card dash-bg-right dash-bg-right1">
                            <h3>{{ __('msg.add_new_address') }}</h3>
                            <hr class="mb-0">
                            <div class="card-body add-cash-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <form action="{{ route('address-add') }}" id='formAddAddress' method='POST'>
                                            <input type="hidden" name="latitude" value="0">
                                            <input type="hidden" name="longitude" value="0">
                                            <input type="hidden" name="country_code" value="0">

                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1">
                                                        <label class="">{{ __('msg.name') }}</label>
                                                        <div class="ui search focus">
                                                            <div class="ui left icon1 input card-detail-desc">
                                                                <input class="form-control card-inputfield" name="name" type="text" placeholder="Name" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1">
                                                        <label>{{ __('msg.mobile_no') }}</label>
                                                        <div class="ui search focus">
                                                            <div class="ui left icon1 input card-detail-desc">
                                                                <input class="form-control card-inputfield" id='addPhone' type="number" placeholder="Mobile No" name="mobile" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />

                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1">
                                                        <label>{{ __('msg.alternate_mobile_no') }}</label>
                                                        <div class="ui search focus">
                                                            <div class="ui left icon1 input card-detail-desc">
                                                                <input class="form-control" type="number" placeholder="Altername Mobile No" name="alternate_mobile">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1">
                                                        <label>{{ __('msg.address') }}</label>
                                                        <div class="ui search focus">
                                                            <div class="ui left icon1 input card-detail-desc">
                                                                <input class="form-control" type="text" placeholder="Address" name="address" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />

                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1">
                                                        <label>{{ __('msg.landmark') }}</label>
                                                        <div class="ui search focus">
                                                            <div class="ui left icon1 input card-detail-desc">
                                                                <input class="form-control" type="text" placeholder="Landmark" name="landmark" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1">
                                                        <label>{{ __('msg.pincode') }}</label>
                                                        <div class="ui search focus">
                                                            <div class="ui left icon1 input card-detail-desc">
                                                                <input class="form-control" type="number" placeholder="Pincode" name="pincode" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <br />
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1">
                                                        <label>{{ __('msg.select_city') }}</label>
                                                        <br>
                                                        <select name='city' class="form-control" required></select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1">
                                                        <label>{{ __('msg.select_area') }}</label>
                                                        <br>
                                                        <select name='area' class="form-control" required></select>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1">
                                                        <label>{{ __('msg.state') }}</label>
                                                        <div class="ui search focus">
                                                            <div class="ui left icon1 input card-detail-desc">
                                                                <input class="form-control" type="text" name="state" required placeholder="State">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1">
                                                        <label>{{ __('msg.country') }}</label>
                                                        <div class="ui search focus">
                                                            <div class="ui left icon1 input card-detail-desc">
                                                                <input class="form-control" type="text" name="country" required placeholder="Country">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />

                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1">
                                                        <label class="radio-inline">
                                                            <input class="mr-2 " type="radio" name="type" value="Home" checked>{{ __('msg.home') }}
                                                        </label>
                                                        <label class="radio-inline  ml-5">
                                                            <input class="mr-2" type="radio" name="type" value="Work">{{ __('msg.work') }}
                                                        </label>
                                                        <label class="radio-inline  ml-5">
                                                            <input class="mr-2" type="radio" name="type" value="Other">{{ __('msg.other') }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mt-1 mb-4 mt-3">
                                                        <input type="checkbox" name="is_default" class=" mt-1" />
                                                        <label class="control-label" for="default-address">{{ __('msg.set_as_default_address') }}</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group text-left">
                                                        <button type="submit" class="btn btn-primary  text-uppercase">{{ __('msg.add_new_address') }} </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group text-left">
                                                        <button class="btn btn-primary  text-uppercase AddEditAddressCancel">{{ __('msg.cancel') }} </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
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
<script src="{{ asset('js/address.js') }}"></script>