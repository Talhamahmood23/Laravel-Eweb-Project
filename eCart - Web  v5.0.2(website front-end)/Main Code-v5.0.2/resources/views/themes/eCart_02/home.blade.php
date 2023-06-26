{{-- slider --}}
<div class="main-slider-sec">
    @if(Cache::has('sliders') && is_array(Cache::get('sliders')) && count(Cache::get('sliders')))
    <div class="slider-activation owl-carousel nav-style dot-style nav-dot-left" >
        @foreach(Cache::get('sliders') as $i => $s)
        @if($s->type == 'product')
        <a href="{{ route('product-single', $s->slug ?? '-') }}">
            @elseif($s->type == 'category')
            <a href="{{ route('category', $s->slug ?? '-') }}">
                @elseif($s->type == 'slider_url')
                <a href="{{$s->slider_url }}" target="_blank">
                    @else
                    @endif
                    <div class="single-slider-content height-100vh bg-img" data-dot="0{{$i+1}}" style="background-image:url('{{ $s->image }}');">
                        <div class="container">
                            <div class="row align-items-center">
                                @if( $s->image2 != "")
                                <div class="col-lg-5 col-md-6 col-12 col-sm-6">
                                    <div class="inner-slider-img slider-animated-content">
                                        <img class="animated" class="lazy" src="{{ $s->image2 }}" alt="">
                                    </div>
                                </div>
                                @endif
                                <div class="col-lg-7 col-md-6 col-12 col-sm-6">
                                    <div class="slider-content slider-animated-content ml-70">
                                        <h3 class="animated">{{ $s->title }}</h3>
                                        <p class="animated">{{ $s->short_description }}</p>
                                        @if( $s->title != "")
                                        <div class="btn-hover">
                                            <span class="animated norm-btn" href="{{ route('product-single', $s->slug ?? '-') }}">{{__('msg.shop_now')}}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
                </div>
                @endif
                </div>


                {{-- shipping area --}}
                <section class="shipping-content">
                    <div class="container">
                        <div class="main-content my-md-5 my-sm-2 my-5">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="single_shipping_content">
                                        <div class="shipping_icon">
                                            <em class="far fa-{{__('msg.iconbox1_i')}}"></em>
                                        </div>
                                        <div class="shipping_content">
                                            <h2>{{__('msg.iconbox1_h2')}}</h2>
                                            <p>{{__('msg.iconbox1_p')}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="single_shipping_content">
                                        <div class="shipping_icon">
                                            <em class="fab fa-{{__('msg.iconbox2_i')}}"></em>
                                        </div>
                                        <div class="shipping_content">
                                            <h2>{{__('msg.iconbox2_h2')}}</h2>
                                            <p>{{__('msg.iconbox2_p')}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="single_shipping_content">
                                        <div class="shipping_icon">
                                            <em class="fas fa-{{__('msg.iconbox3_i')}}"></em>
                                        </div>
                                        <div class="shipping_content">
                                            <h2>{{__('msg.iconbox3_h2')}}</h2>
                                            <p>{{__('msg.iconbox3_p')}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="single_shipping_content">
                                        <div class="shipping_icon">
                                            <em class="fas fa-{{__('msg.iconbox4_i')}}"></em>
                                        </div>
                                        <div class="shipping_content">
                                            <h2>{{__('msg.iconbox4_h2')}}</h2>
                                            <p>{{__('msg.iconbox4_p')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                {{-- all-content --}}
