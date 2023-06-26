
@if(isset($s->products) && is_array($s->products) && count($s->products))
<!--section recently added and new on ekart -->
<section class="section-content padding-bottom sellpro">
    <div class="container">
        <div class="outer_box px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
            <div class="title_same">
                @if(isset($s->title) && $s->title != "")
                <h4 class="title-section title-sec font-weight-bold">{{ $s->title }} <small class="text-muted short-desc"> {{ $s->short_description }}</h4>
                @if(isset($s->slug) && $s->slug != "")
                <a href="{{ route('shop', ['section' => $s->slug]) }}" class=" viewall">{{__('msg.view_all')}}</a>
                @endif
                @endif
            </div>
            <hr class="line">
            <div class="row no-gutter">
                @php   $maxProductShow = get('style_2.max_product_on_homne_page'); @endphp
                @foreach($s->products as $p)
                @if((--$maxProductShow) > -1)
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12 col-style2-2">
                    <figure class="card card-product-grid styletwo_height my-2">
                        <aside class="add-to-fav">
                            @if (session()->has('favourite'))
                            @if(in_array($p->id, session()->get('favourite')))
                            <button  title="Add to Wishlist" class="btn saved" data-id='{{ $p->id }}'>
                                @else
                                <button  title="Add to Wishlist" class="btn save" data-id='{{ $p->id }}'>
                                    @endif
                                    @else
                                    <button  title="Add to Wishlist" class="btn {{ (isset($p->is_favorite) && intval($p->is_favorite)) ? 'saved' : 'save' }}" data-id='{{ $p->id }}'>
                                        @endif

                                        </aside>
                                        <a href="{{ route('product-single', $p->slug) }}" class="img-wrap"> <img class="lazy" data-original="{{ $p->image }}" alt="{{ $p->name ?? 'Product Image' }}"> </a>
                                        <figcaption class="info-wrap">
                                            <div class="text-wrap p-1 text-center">
                                                <a href="{{ route('product-single', $p->slug) }}" class="title font-weight-bold product-name">{{ $p->name }}</a>

                                                <span class="text-muted style-desc">
                                                    @if(strlen(strip_tags($p->description)) > 20) {!! substr(strip_tags($p->description), 0,20)."..." !!} @else {!! substr(strip_tags($p->description), 0,20) !!} @endif
                                                </span>
                                                <div class="price mt-1 ">
                                                    <strong id="price_{{ $p->id }}">{!! print_price($p) !!}</strong> &nbsp; <s class="text-muted" id="mrp_{{ $p->id }}">{!! print_mrp($p) !!}</s>
                                                    <small class="off_price" id="savings_{{ $p->id }}"> {{ get_savings_varients($p->variants[0]) }} </small>
                                                </div>
                                            </div>
                                        </figcaption>
                                        @if(count(getInStockVarients($p)))
                                        <span class="inner product_data">
                                            <!--<form action='{{ route('cart-add-single-varient') }}' method="POST"> -->
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
                                            <button type="submit"  class="btn cart-1  productmodal">
                                                <div class="dub-arrow"><em class="fa fa-shopping-cart"></em></div>
                                                <span>{{__('msg.add_to_cart')}}</span>
                                            </button>
                                            @else
                                            <button type="submit"  class="btn cart-1 addtocart_single" data-id="{{ $p->id }}" data-varient="{{ $v->id }}" data-qty="1">
                                                <div class="dub-arrow"><em class="fa fa-shopping-cart"></em></div>
                                                <span>{{__('msg.add_to_cart')}}</span>
                                            </button>
                                            @endif
                                            <!--</form> -->
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
                                        <!--section end recently added and new on ekart -->
                                        @if (isset($s->offer_images) && is_array($s->offer_images) && count($s->offer_images))
                                        @foreach($s->offer_images as $i => $o)
                                        @if($o->offer_type == 'products')
<a href="{{ route('product-single', $o->slug ?? '-') }}">
@elseif($o->offer_type == 'category')
<a href="{{ route('category', $o->slug ?? '-') }}">
@elseif($o->offer_type == 'offer_image_url')
<a href="{{$o->offer_image_url }}" target="_blank">
@else
@endif
                                        @if($o->image !== '')
                                        <section class="section-content banneradvertise spacingrm">
                                            <div class="container">
                                                <article class="padding-bottom">
                                                    <div class="banner_outer">
                                                        @if(isset($o->type) && $o->type == "image")
                                                        <img class="lazy w-100" data-original="{{ $o->image }}" alt="offer">
                                                        @elseif(isset($o->type) && $o->type == "video")
                                                        <video  controls autoplay class="w-100">
                                                            <source src="{{ $o->image }}" type="video/mp4">
                                                        </video>
                                                        @endif
                                                    </div>
                                                </article>
                                            </div>
                                        </section>
                                        @endif
                                        @endforeach
                                        @endif
                                        @endif
