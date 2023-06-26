{{-- popular categories --}}
@if(Cache::has('categories') && is_array(Cache::get('categories')) && count(Cache::get('categories')))
<div class="main-content mt-4 my-md-2">
    <section class="popular-categories my-md-5 my-sm-2 my-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="popular_title">
                        <h2>{{__('msg.popular_categories')}}</h2>
                        <div class="pop_desc_title">{{__('msg.Add Popular Categories to weekly show up')}} </div>
                    </div>
                    <div class="popular_content">
                        <div class="popular-cat owl-carousel"> @foreach(Cache::get('categories') as $i => $c)
                            @if($c->web_image !== '')
                            <div class="pop_item-listcategories">

                                <div class="pop_list-categories">
                                    <div class="pop_thumb-category"> <a href="{{ route('category', $i) }}">
                                            <img class="lazy" data-original="{{ $c->web_image }}" alt="{{ $c->name ?? 'Category' }}"></a>
                                    </div>
                                    <div class="pop_desc_listcat">
                                        <div class="name_categories">
                                            <h4>{{ $c->name }}</h4>
                                        </div>
                                        <div class="number_product">{{ $c->subtitle }}</div>
                                        <div class="view-more">
                                            <a href="{{ route('category', $i) }}">{{__('msg.shop_now')}} &nbsp;
                                                <i class="fas fa-chevron-circle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="pop_item-listcategories rounded">

                                <div class="pop_list-categories ">
                                    <div class="pop_thumb-category rounded">
                                        <a href="{{ route('category', $i) }}">
                                            <img class="lazy" data-original="{{ $c->image }}" alt="{{ $c->name ?? 'Category' }}">
                                        </a>
                                    </div>
                                    <div class="pop_desc_listcat">
                                        <div class="name_categories">
                                            <h4>{{ $c->name }}</h4>
                                        </div>
                                        <div class="number_product">{{ $c->subtitle }}</div>
                                        <div class="view-more">
                                            <a href="{{ route('category', $i) }}">{{__('msg.shop_now')}} &nbsp;
                                                <i class="fas fa-chevron-circle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <!------------Category Offer Image-------------->
                <div class="col-md-12">
                    <div class="popular_content">
                        @if(Cache::has('category_offer_images') && is_array(Cache::get('category_offer_images')) && count(Cache::get('category_offer_images')))
                        @foreach(Cache::get('category_offer_images') as $i => $o)
                        @if($o->offer_type == 'products')
                            <a href="{{ route('product-single', $o->slug ?? '-') }}">
                                @elseif($o->offer_type == 'category')
                                <a href="{{ route('category', $o->slug ?? '-') }}">
                                    @elseif($o->offer_type == 'offer_image_url')
                                    <a href="{{$o->offer_image_url }}" target="_blank">
                                @else
                            @endif
                        @if($o->image !== '')
                        <div class="main-content home-banner banner-sec-2 my-md-5 my-sm-2 my-3">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="banner_box_content">
                                            @if(isset($o->type) && $o->type == "image")
                                            <img class="lazy w-100" data-original="{{ $o->image }}" alt="offer">
                                            @elseif(isset($o->type) && $o->type == "video")
                                            <video  controls class="w-100">
                                                <source src="{{ $o->image }}" type="video/mp4">
                                            </video>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </a>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endif
