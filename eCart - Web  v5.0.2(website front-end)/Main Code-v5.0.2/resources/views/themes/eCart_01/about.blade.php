
<section class="section-content footerfix about_sec_content">
    <a href="#" id="scroll"><span></span></a>
    <div class="page_title corner-title overflow-visible">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>{{__('msg.about_us')}}</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">{{__('msg.home')}}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>{{__('msg.more')}}</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{__('msg.about_us')}}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- about company --}}
    <div class="about-us ">
        <div class="container">
            <div class=" px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="about-us-img text-center">
                            <a href="#">
                                <img class="lazy" data-original="{{theme('images/aboutus.png')}}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 align-self-center">
                        <div class="about-us-content">
                            <p class="peragraph-blog">{!! $data['content'] !!}</p>
                            <div class="about-us-btn btn-hover hover-border-none">
                                <a class="btn-color-white btn-color-theme-bg black-color" href="{{route('shop')}}">{{__('msg.shop_now')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

         {{-- feature --}}
    <div class="feature-area section-padding-3">
        <div class="container">
             <div class=" px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                <div class="row">
                    <div class="d-block m-auto text-center heading-feature">
                        <h2 class="text-capitalize">{{__('msg.What We Provide')}}</h2>
                        <span class="animate-border mb-40 mx-auto"></span>
                    </div>
                </div>
                <div class="feature-border feature-border-about">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="feature-wrap mb-30 text-center">
                                <i class="fas fa-star fa-2x"></i>
                                <h5>{{__('msg.Best Product')}}</h5>
                                <span>{{__('msg.Best Queality Products')}}</span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="feature-wrap mb-30 text-center">
                                <i class="fas fa-cog fa-2x"></i>
                                <h5>{{__('msg.100% fresh')}}</h5>
                                <span>{{__('msg.Best Queality Products')}}</span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="feature-wrap mb-30 text-center">
                                <i class="fas fa-user-lock fa-2x"></i>
                                <h5>{{__('msg.Secure Payment')}}</h5>
                                <span>{{__('msg.Best Queality Products')}}</span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="feature-wrap mb-30 text-center">
                                <i class="fas fa-mug-hot fa-2x"></i>
                                <h5>{{__('msg.Best Wood')}}</h5>
                                <span>{{__('msg.Best Queality Products')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
        </div>
    </div>

</section>