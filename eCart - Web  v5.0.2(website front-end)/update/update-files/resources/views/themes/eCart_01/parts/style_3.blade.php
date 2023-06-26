@if(isset($s->products) && is_array($s->products) && count($s->products))
<!---section polular categories-->
<section class="section-content padding-bottom ekartspec">
    <div class="container">
        <div class="outer_box px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
            <div class="title_same">
                <h4 class="title-section title-sec font-weight-bold">{{ $s->title }} <small class="text-muted short-desc">{{ $s->short_description }}</small></h4>
                @if(isset($s->slug) && $s->slug != "")
                <a href="{{ route('shop', ['section' => $s->slug]) }}" class="view  title-section viewall">{{__('msg.view_all')}}</a>
                @endif
            </div>
            <hr class="line">
            <div class="row respondiv">
                @php $maxProductShow = get('style_3.max_product_on_homne_page'); @endphp
                @foreach($s->products as $p)
                @if((--$maxProductShow) > -1)
                <div class="col-xl-4 col-lg-6 col-md-6 col-12 mb-2">
                    <div class="card-popular-category">
                        <a href="{{ route('product-single', $p->slug) }}">
                            <div class="col-4">
                                <div class="pop_img">
                                    <img class="rounded lazy" data-original="{{ $p->image }}" alt="{{ $p->name ?? 'Product Name'}}">
                                </div>
                            </div>
                        </a>
                        <div class="col-8">
                            <div class="text-wrap p-2 pop-text ">
                                <a href="{{ route('product-single', $p->slug) }}" class="title font-weight-bold product-name">{{ $p->name }}</a>
                                <span class="text-muted">@if(strlen(strip_tags($p->description)) > 60) {!! substr(strip_tags($p->description), 0,60)."..." !!} @else {!! substr(strip_tags($p->description), 0,60) !!} @endif</span>
                                <div class="price mt-1 ">
                                    <strong>{!! print_price($p) !!}</strong>&nbsp; <s class="text-muted">{!! print_mrp($p) !!}</s>
                                    <small class="text-success ml-3"> {{ get_savings_varients($p->variants[0]) }} </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</section>
<!---end section categories-->
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
