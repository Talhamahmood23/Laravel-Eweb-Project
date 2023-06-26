@if(Cache::has('categories') && is_array(Cache::get('categories')) && count(Cache::get('categories')))
<!--section categories popular categories transparent image-->
<section class="section-content padding-bottom popular-categories">
    <div class="container">
        <div class="outer_box px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
            <h4 class="title-section title-sec font-weight-bold">{{__('msg.popular_categories')}}</h4>
            <hr class="line">
            <div class="row">
                @foreach(Cache::get('categories') as $i => $c)
                <div class="col-lg-4 col-md-6 col-12 mb-2">
                    @if($c->web_image !== '')
                    <div class="item popular web">
                        <img class="category-item lazy w-100" data-original="{{ $c->web_image }}" alt="{{ $c->name ?? 'Category' }}">
                        <span class="overlay-text">
                            <p class="text-dark title font-weight-bold name mb-0">{{ $c->name }}</p>
                            <small class="text-muted subtitle">{{ $c->subtitle }}</small>
                            <p class="mt-1">
                                <a href="{{ route('category', $i) }}" class="shop-now">{{__('msg.shop_now')}} <em class="fa fa-chevron-right shopnow_arrow"></em></a>
                            </p>
                        </span>
                    </div>
                    @else
                    <div class="item category-item-card rounded">
                        <div class="rounded-pop">
                            <img class="category-item-rounded lazy w-100" data-original="{{ $c->image }}" alt="{{ $c->name ?? 'Category' }}">
                        </div>
                        <span class="overlay-text">
                            <p class="text-dark title font-weight-bold name mb-0">{{ $c->name }}</p>
                            <small class="text-muted subtitle">{{ $c->subtitle }}</small>
                            <p class="mt-1">
                                <a href="{{ route('category', $i) }}" class="shop-now">{{__('msg.shop_now')}} <em class="fa fa-chevron-right shopnow_arrow"></em></a>
                            </p>
                        </span>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!--end section categories-->
@if(Cache::has('category_offer_images') && is_array(Cache::get('category_offer_images')) && count(Cache::get('category_offer_images')))
@foreach(Cache::get('category_offer_images') as $i => $c)
@if($c->offer_type == 'products')
                            <a href="{{ route('product-single', $c->slug ?? '-') }}">
                                @elseif($c->offer_type == 'category')
                                <a href="{{ route('category', $c->slug ?? '-') }}">
                                    @elseif($c->offer_type == 'offer_image_url')
                                    <a href="{{$c->offer_image_url }}" target="_blank">
                                @else
                            @endif
@if($c->image !== '')
<section class="section-content banneradvertise spacingrm">
    <div class="container">
        <article class="padding-bottom">
            <div class="banner_outer">
                @if(isset($c->type) && $c->type == "image")
                <img class="lazy w-100" data-original="{{ $c->image }}" alt="offer">
                @elseif(isset($c->type) && $c->type == "video")
                <video  controls autoplay class="w-100">
                    <source src="{{ $c->image }}" type="video/mp4">
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
