
<section class="section-content padding-bottom mt-3 spacingrm">
    <a href="#" id="scroll"><span></span></a>
    <div class="container">
        @if(Cache::has('sliders') && is_array(Cache::get('sliders')) && count(Cache::get('sliders')))
        <div class="col-12 p-0">
            <div class="slider12">
                <!-- ================== COMPONENT SLIDER  BOOTSTRAP  ==================  -->
                <div id="carouselDocumentationIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @for($i =0; $i < count(Cache::get('sliders')); $i++)
                        <li data-target="#carouselDocumentationIndicators" data-slider-to="{{$i}}" {{ $i == 0 ? 'class="active"' : ''}}></i>
                            @endfor
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        @foreach(Cache::get('sliders') as $i => $s)
                        <div class="carousel-item {{ $i == 0 ? 'active' : ''}}">
                            @if($s->type == 'product')
                            <a href="{{ route('product-single', $s->slug ?? '-') }}"><img class="d-block img-fluid" src="{{ $s->image }}" alt="{{ $s->name }}" ></a>
                            @elseif($s->type == 'category')
                            <a href="{{ route('category', $s->slug ?? '-') }}"><img class="d-block img-fluid" src="{{ $s->image }}" alt="{{ $s->name }}"></a>
                            @elseif($s->type == 'slider_url')
                            <a href="{{ $s->slider_url  ?? '-' }}" target="_blank"><img class="d-block img-fluid" src="{{ $s->image }}" alt="{{ $s->name }}"></a>
                            @else
                            <img class="d-block img-fluid" src="{{ $s->image }}" alt="{{ $s->name }}">
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselDocumentationIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">{{__('msg.previous')}}</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselDocumentationIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">{{__('msg.next')}}</span>
                    </a>
                </div>
            </div>
        </div><!-- col-->
        <!-- ==================  COMPONENT SLIDER BOOTSTRAP end.// ==================  .// -->
        @endif
    </div> <!-- card-body.// -->
</section>
