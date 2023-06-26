<!--shop page -->
<section class="section-content padding-bottom mt-5">
    <a href="#" id="scroll"><span></span></a>
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-4 col-xl-3 col-12 filter mb-3">
                <div class="card px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                    <div class="pt-4">
                        <legend class="mb-1 p-0 title-sec">{{__('msg.filter_by')}}</legend>
                        <hr class="line mb-0 pb-0">
                    </div>
                    <form action='#' method="GET" id='filter'>
                        <input type="hidden" name="s" value="{{ isset($_GET['s']) ? trim($_GET['s']) : ''}}">
                        <input type="hidden" name="section" value="{{ isset($_GET['section']) ? trim($_GET['section']) : ''}}">
                        <input type="hidden" name="category" value="{{ isset($_GET['category']) ? trim($_GET['category']) : ''}}">
                        <input type="hidden" name="sub-category" value="{{ isset($_GET['sub-category']) ? trim($_GET['sub-category']) : ''}}">
                        <input type="hidden" name="sort" value="{{ isset($_GET['sort']) ? trim($_GET['sort']) : ''}}">
                        <input type="hidden" name="discount_filter" value="{{ isset($_GET['discount_filter']) ? trim($_GET['discount_filter']) : ''}}">
                        <input type="hidden" name="out_of_stock" value="{{ isset($_GET['out_of_stock']) ? trim($_GET['out_of_stock']) : ''}}">
                        <div>
                            <br>
                            <h5 class="mb-3 name title-sec">{{__('msg.price')}}</h5>
                            <div class="row">
                                <div class="col">
                                    <div id="slider-range" data-min="{{ intval($data['total_min_price']) }}" data-max="{{ intval($data['total_max_price']) }}" data-selected-min="{{  $data['total_min_price']}}" data-selected-max="{{ $data['total_max_price']}}"></div>
                                    <br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="number" name="min_price" value="{{  $data['total_min_price']}}" class="form-control text-center">
                                </div>
                                <div class="col">
                                    <input type="number" name="max_price" value="{{  $data['total_max_price']}}" class="form-control text-center">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <br>
                                    <button type="submit" name="submit" class="btn btn-primary btn-block">{{__('msg.filter')}}</button>
                                </div>
                            </div>
                        </div>
                        <br>
                    </form>
                    <br>
                    @if(isset($data['categories']) && is_array($data['categories']) && count($data['categories']))
                    <div>
                        <h5 class="mb-3 name">{{__('msg.category')}}</h5>
                        <div class="text ml-4 ">
                            @foreach($data['categories'] as $c)
                            @if(isset($c->name) && trim($c->name) != "")
                            <div class="custom-control custom-checkbox pb-2">
                                <input type="checkbox" class="custom-control-input cats" id="cat-{{ $c->id }}" value="{{ $c->slug }}" {{ (isset($data['selectedCategory']) && is_array($data['selectedCategory']) && in_array($c->slug, $data['selectedCategory'])) ? 'checked' : ''}}>
                                <label class="custom-control-label" for="cat-{{ $c->id }}">{{ $c->name }}</label>
                                @if(isset($data['selectedCategory']) && is_array($data['selectedCategory'])  )
                                @foreach($data['selectedCategory'] as $cat)
                                @if(isset(Cache::get('categories',[])[$cat]) && isset(Cache::get('categories',[])[$cat]->childs) && $c->name == Cache::get('categories',[])[$cat]->name)
                                <br>
                                <div>
                                    <!--<h5 class="mb-3 name">{{ Cache::get('categories',[])[$cat]->name }}</h5>-->
                                    <div class="text ml-4">
                                        @foreach(Cache::get('categories',[])[$cat]->childs as $c)
                                        <div class="custom-control custom-checkbox pb-2">
                                            <input type="checkbox" class="custom-control-input subs" id="sub-{{ $c->id }}" value="{{ $c->slug }}" {{ (isset($data['selectedSubCategory']) && is_array($data['selectedSubCategory']) && in_array($c->slug, $data['selectedSubCategory'])) ? 'checked' : ''}}>
                                            <label class="custom-control-label" for="sub-{{ $c->id }}">{{ $c->name }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                @endif
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <br>

                </div>
            </div>
            <div class="col-md-8 col-xl-9 col-lg-7 col-12 shopdetails">

                <nav class="navbar navbar-md navbar-light bg-white gridviewdiv px-2 py-4 px-md-4 py-md-3 shadow-sm rounded">
                    <div class="col-md-6 col-sm-6 col-12">
                        <div class="row">
                            <div class="list_grid_content">
                                <div id="list">
                                    <em class= "fa fa-list fa-lg" data-view ="list-view"></em>
                                </div>
                                <div id="grid">
                                    <em class="selected fa fa-th fa-lg" data-view ="grid-view"></em>
                                </div>

                                @php
                                $number = 0;
                                @endphp
                                @if(isset($data['list']) && isset($data['list']['data']) && is_array($data['list']['data']) && count($data['list']['data']))
                                @foreach($data['list']['data'] as $p)
                                <?php $number++ ?>
                                @endforeach
                                @endif
                                <div class="letter">
                                    <small> {{ $number.' Items out of ' }}{{ (isset($data['total']) && intval($data['total'])) ?  $data['total'].' Items' : '' }}</small>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-12">
                        <div class="gridviewselect">
                            <div class="row">
                                <div class="select"> {{__('msg.sort_by')}}:  </div>
                                <div class="select1">
                                    <select class="form-control innerselect1" id="sort">
                                        <option value=""> {{__('msg.relevent')}} </option>
                                        <option value="new" {{ (isset($_GET['sort']) && $_GET['sort'] == 'new') ? 'selected' : '' }}>{{__('msg.new')}}</option>
                                        <option value="old" {{ (isset($_GET['sort']) && $_GET['sort'] == 'old') ? 'selected' : '' }}>{{__('msg.old')}}</option>
                                        <option value="low" {{ (isset($_GET['sort']) && $_GET['sort'] == 'low') ? 'selected' : '' }}>{{__('msg.low_to_high')}}</option>
                                        <option value="high" {{ (isset($_GET['sort']) && $_GET['sort'] == 'high') ? 'selected' : '' }}>{{__('msg.high_to_low')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>


                @if(isset($data['list']) && isset($data['list']['data']) && is_array($data['list']['data']) && count($data['list']['data']))

                <div id="products">

                    @foreach($data['list']['data'] as $p)
                    @if(count($p->variants))

                    <div class="grid_shop col-sm-6 col-xl-4 col-lg-6 col-md-6 col-grid-3 mb-2">
                        <div class="item1 px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                            <div class="add-to-fav">
                                <button type="button" class="btn {{ (isset($p->is_favorite) && intval($p->is_favorite)) ? 'saved' : 'save' }}" data-id='{{ $p->id }}' />
                            </div>
                            <a href="{{ route('product-single', $p->slug ?? '-') }}">
                                <div class="thumbnail">
                                    <a href="{{ route('product-single', $p->slug ?? '-') }}">
                                        <div class="img-event">
                                            <img class="group list-group-image img-fluid lazy" data-original="{{ $p->image }}" alt="{{ $p->image }}">
                                        </div>
                                    </a>
                                    <div class="caption card-body">
                                        <div class="text-wrap">
                                            <a href="{{ route('product-single', $p->slug ?? '-') }}" class="title font-weight-bold product-name">{{ $p->name }}</a>
                                            <span class="text-muted description1">@if(strlen(strip_tags($p->description)) > 18) {!! substr(strip_tags($p->description), 0,18) ."..." !!} @else {!! substr(strip_tags($p->description), 0,18) !!} @endif</span>
                                            <div class="price">
                                                <strong id="price_{{ $p->id }}">{!! print_price($p) !!}</strong> &nbsp; <s class="text-muted" id="mrp_{{ $p->id }}">{!! print_mrp($p) !!}</s>
                                                <small class="text-success" id="savings_{{ $p->id }}"> {{ get_savings_varients($p->variants[0]) }} </small>
                                            </div>
                                        </div>
                                        @if(count(getInStockVarients($p)))
                                        <span class="inner d-block m-auto product_data">
                                            <form action='{{ route('cart-add-single-varient') }}' method="POST">
                                                <input type="hidden" class="id" name="id" value="{{ $p->id }}" data-id="{{ $p->id }}">
                                                <input type="hidden" name="qty" value="1" class="qty" data-qty="1">
                                                @foreach(getInStockVarients($p) as $v)
                                                <input type="hidden" class="varient" data-varient="{{ $v->id }}" name="varient" value="{{ $v->id }}"  data-price='{{ get_price(get_price_varients($v)) }}' data-mrp='{{ get_price(get_mrp_varients($v)) }}' data-savings='{{ get_savings_varients($v) }}' checked>
                                                @endforeach
                                                <input type="hidden" class="slug" value="{{ $p->slug }}" data-slug="{{ $p->slug }}">
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
                                            </form>
                                        </span>
                                        @else
                                        <div class="content_label">
                                            <span class="sold-out">{{ __('msg.sold_out') }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                <div class="row">
                    <div class="col"><br></div>
                </div>
                <div class="row">
                    <div class="col text-center shoppagination">
                        @php
                        $number_of_pages =  ceil($data['number_of_pages']);
                        $currentpage = '1';
                        $currentpage = request()->input('page');
                        @endphp
                        @if($number_of_pages > 1)
                        @for($page = max(1, $currentpage - 2); $page <= min($currentpage + 4, $number_of_pages); $page++)
                        @php $pageprevious = $page-1;
                        @endphp
                        @if(request()->query('min_price')!== NULL OR request()->query('category')!== NULL OR request()->query('s')!== NULL OR request()->query('section')!== NULL)
                        @if($currentpage == $page )
                        <a href="javascript:void(0)" class="active" >{{ $page }}</a>
                        @else
                        <a href="{{Request::fullUrl()}}&page={{ $page }}" class="active btn btn-primary text-white"> {{ $page }} </a>
                        {{-- <a href="{{Request::fullUrl()}}&page={{ $page }}" @if($currentpage == $page ) class="active btn btn-primary text-white" @else class="btn btn-shopping" @endif> {{ $page }} </a> --}}
                        @endif
                        @else
                        @if($currentpage == $page )
                        <a href="javascript:void(0)" class="active btn btn-light" >{{ $page }}</a>
                        @else
                        <a href="shop?page={{ $page }}" class="btn btn-primary text-white">{{ $page }}</a>
                        @endif
                        @endif
                        {{-- <a href="shop?page={{ $page }}" @if($currentpage == $page ) class="active btn btn-primary text-white" @else class="btn btn-shopping" @endif>{{ $page }}  </a> --}}
                        @endfor
                        @endif
                    </div>
                    @else
                    <div class="row">
                        <div class="col">
                            <br><br>
                            <h1 class="text-center">{{__('msg.no_product_found')}}</h1>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End shop page -->