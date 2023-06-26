@if(isset($s->products) && is_array($s->products) && count($s->products))
<!-- section trending products -->
<section class="section-content padding-bottom card-trand spacingrm">
    <div class="container">
        <div class="outer_box px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
            <h4 class="title-section title-sec font-weight-bold">{{ $s->title }} <small class="text-secondary short-desc">{{ $s->short_description }}</small></h4>
            <hr class="line">
            <div class="card-product-trend-1 card-deal-1">
                <div class="row no-gutters items-wrap mx-auto">
                    @php   $maxProductShow = get('style_1.max_product_on_homne_page'); @endphp
                    @foreach($s->products as $p)
                    @if((--$maxProductShow) > -1)
                    <div class=" card col-xs-12 col-sm-6 col-md-4 col-lg-3 col-cust-2">
                        <figure class="newinner">
                            <a href="{{ route('product-single', $p->slug) }}" class="img-wrap">
                                <img class="lazy" data-original="{{ $p->image }}" alt="{{ $p->name ?? 'Product Image'}}">
                            </a>
                            <div class="text-wrap py-3">
                                <a href="{{ route('product-single', $p->slug) }}" class="title font-weight-bold product-name mb-2">{{ $p->name }}</a>
                                <span class="text-muted style-desc">
                                    @if(strlen(strip_tags($p->description)) > 20) {!! substr(strip_tags($p->description), 0,20)."..." !!} @else {!! substr(strip_tags($p->description), 0,20) !!} @endif
                                </span>
                                <div class="price mt-2 ">
                                    <strong>{!! print_price($p) !!}</strong> &nbsp; <s class="text-muted">{!! print_mrp($p) !!}</s>
                                    <small class="off_price"> {{ get_savings_varients($p->variants[0]) }} </small>
                                </div>
                            </div>
                        </figure>
                    </div>
                    @else
                    @break
                    @endif
                    @endforeach

                    <div class="col-heading content-body col-md-3 col-12 col-lg-3  col-cust-2">
                        <header class="section-heading">
                            <h3 class="section-title ml-4">{{ $s->title }}</h3>
                            <p class="ml-4">{{ $s->short_description }}</p>
                        </header><!-- sect-heading -->

                        <div class="col text-left ml-2">
                            <a type="button" href="{{ route('shop', ['section' => $s->slug]) }}" class="view-all btn btn-primary">{{__('msg.view_all')}}</a>
                        </div>
                    </div> <!-- col.// -->
                </div>
            </div>
        </div>
    </div>
</section>
<!--end tranding products-->
@endif
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
</a>
@endforeach
@endif
