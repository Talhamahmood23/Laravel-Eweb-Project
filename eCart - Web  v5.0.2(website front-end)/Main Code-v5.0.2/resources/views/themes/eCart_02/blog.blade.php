<!-- breadcumb -->
<section class="page_title corner-title overflow-visible">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>{{__('msg.blog')}}</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">{{__('msg.home')}}</a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{__('msg.blog')}}
                    </li>
                </ol>
                <div class="divider-15 d-none d-xl-block"></div>
            </div>
        </div>
    </div>
</section>
<!-- eof breadcumb -->
<!-- blog-details -->
<div class="main-content">
    <section class="blog_details">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 ">
                    <!--blog grid area start-->
                    <div class="outer_blog_content wow fadeInLeftBig">
                        <div class="blog-sec mt-5 mb-5">
                            <div class="row">
                                @if(isset($data['data'])  && is_array($data['data']) && count($data['data']))
                                @foreach($data['data'] as $b =>$bg)
                                @if(!empty($bg->slug))
                                <div class="col-md-6 col-lg-6 col-xl-4 col-xxl-3 col-12 blogrespon">
                                    <a href="{{ route('blog-category', $bg->slug) }}">
                                        <div class="blog-card blog-card-blog">
                                            <div class="blog-card-image wow fadeInLeft">
                                                <img alt="blog" class="img lazy" data-original="{{ $bg->image }}">
                                                <div class="ripple-cont"></div>
                                            </div>
                                            <div class="blog-table wow fadeInLeft">
                                                <h4 class="blog-card-caption text-center">
                                                    <a href="{{ route('blog-category', $bg->slug) }}">{{ $bg->name }} </a>
                                                </h4>

                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endif
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <!--blog grid area start-->
                </div>
            </div>
        </div>
    </section>
</div>
<!-- eof details -->