@if(Cache::has('offers') && is_array(Cache::get('offers')) && count(Cache::get('offers')))
@foreach(Cache::get('offers') as $o)
@if($o->offer_type == 'products')
    <a href="{{ route('product-single', $o->slug ?? '-') }}">
@elseif($o->offer_type == 'category')
    <a href="{{ route('category', $o->slug ?? '-') }}">
@elseif($o->offer_type == 'offer_image_url')
    <a href="{{$o->offer_image_url }}" target="_blank">
@else
@endif
@if(isset($o->image) && trim($o->image) !== "")
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