<!-- breadcumb -->
<section class="page_title corner-title overflow-visible">
   <div class="container">
      <div class="row">
         <div class="col-md-12 text-center">
            <h1>{{$data['title']}}</h1>
            <ol class="breadcrumb">
               <li class="breadcrumb-item">
                  <a href="{{ route('blog') }}">{{__('msg.blog')}}</a>
               </li>
               <li class="breadcrumb-item active">
                  {{$data['title']}}
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
                      
                        @if(isset($data['data'])  && is_array($data['data']) && count($data['data']) && !empty($data['data']))
                        @foreach($data['data'] as $b =>$bg)
                        
                        <div class="col-md-4 blogrespon">
                           <div class="blog-card blog-card-blog">
                              <div class="blog-card-image wow fadeInLeft">
                                 <a href="{{ route('blog-single', $bg->slug) }}">
                                    <img alt="blog" class="lazy img" data-original="{{ $bg->image }}">
                                 </a>
                                 <div class="ripple-cont"></div>
                              </div>
                              <div class="blog-table wow fadeInLeft">
                                 <h6 class="blog-category blog-text-success"><em class="far fa-newspaper"></em>{{ $bg->category_name }}</h6>
                                 <h4 class="blog-card-caption">
                                    <a href="{{ route('blog-single', $bg->slug) }}">{{ $bg->title }} </a>
                                 </h4>
                                 <p class="blog-card-description">@if(strlen(strip_tags($bg->description)) > 180) {!! substr(strip_tags($bg->description), 0,180) ."..." !!} @else {!! substr(strip_tags($bg->description), 0,180) !!} @endif</p>
                                 <div class="ftr">
                                    <a href="{{ route('blog-single', $bg->slug) }}">Read More{{__('msg.read_more')}}</a>
                                    <div class="stats"> <em class="far fa-clock"></em>  {{ date(" F j, Y", strtotime($bg->date_created)) }}  </div>
                                 </div>
                              </div>
                           </div>
                        </div>
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
