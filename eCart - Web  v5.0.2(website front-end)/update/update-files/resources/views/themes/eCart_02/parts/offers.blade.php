{{-- big Offer banner --}}
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
<div class="main-content home-banner banner-sec-2 my-md-5 my-sm-2 my-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="banner_box_content">
                    @if(isset($o->type) && $o->type == "image")
                    <img class="lazy" data-original="{{ $o->image }}" alt="ad-1">
                    @elseif(isset($o->type) && $o->type == "video")
                    <video  controls>
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