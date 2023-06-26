@if(isset($data['data'])  && is_array($data['data']) && count($data['data']))
<!-- breadcumb -->
<section class="page_title corner-title overflow-visible">
   <div class="container">
      <div class="row">
         <div class="col-md-12 text-center">
            <h1>{{$data['data'][0]->title}}</h1>
            <ol class="breadcrumb">
               <li class="breadcrumb-item">
                  <a href="{{ route('blog') }}">{{__('msg.blog')}}</a>
               </li>
               <li class="breadcrumb-item active">
                  {{$data['data'][0]->title}}
               </li>
            </ol>
            <div class="divider-15 d-none d-xl-block"></div>
         </div>
      </div>
   </div>
</section>
<!-- eof breadcumb -->
@endif
<!-- blog-details -->
<div class="main-content">
<section class="blog_details">
   <div class="container-fluid">
      <div class="row">
         @if(isset($data['data'])  && is_array($data['data']) && count($data['data']))
         <div class="col-xl-8 col-lg-9 col-md-12 ">
            <!--blog grid area start-->
            <div class="outer_blog_content wow fadeInLeftBig">
               <article class="single_blog_content">
                  <figure>
                     <div class="inner_post_header wow fadeInLeft">
                        <h3 class="inner_post_title wow fadeInLeft">{{$data['data'][0]->title}}</h3>
                        <div class="blog_post_content wow fadeInLeft">
                           <div class="stats">
                              <p>{{__('msg.posted_on')}} {{ date(" F j, Y", strtotime($data['data'][0]->date_created)) }}</p>
                           </div>
                        </div>
                        <div class="blog_thumb wow fadeInLeft">
                           <img class="lazy" data-original="{{$data['data'][0]->image}}" alt="blog">
                        </div>
                        <figcaption class="blog_content">
                           <h6 class="blog-category blog-text-success"><em class="far fa-newspaper"></em>{{$data['data'][0]->category_name}}</h6>
                           <div class="post_content wow fadeInLeft">
                              @php echo $data['data'][0]->description; @endphp
                           </div>
                           <div class="tag_content wow fadeInLeft">
                              <div class="social_icons wow fadeInLeft">
                                 <p>{{__('msg.share_this_post')}}</p>
                                 <ul>
                                    <li>
                                       <a href="http://twitter.com/share?url={{url()->current()}}" target="_blank"><em class="fab fa-twitter"></em></a>
                                    </li>
                                    <li>
                                       <a href="https://facebook.com/sharer.php?u={{url()->current()}}" target="_blank"><em class="fab fa-facebook-f"></em></a>
                                    </li>
                                    <li>
                                       <a class="pinterest" href="http://pinterest.com/pin/create/button/?url=http://www.google.com&media={{ $data['data'][0]->image }}" target="_blank" title="pinterest"><em class="fab fa-pinterest"></em></a>
                                    </li>
                                    <li>
                                       <a class="linkedin" href="http://www.linkedin.com/shareArticle?mini=true&url={{url()->current()}}" target="_blank" ><em class="fab fa-linkedin"></em></a>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                        </figcaption>
                  </figure>
               </article>
               </div>
               <!--blog grid area start-->
            </div>
            @endif
            <div class="col-xl-4 col-lg-3 col-md-12">
               <div class="blog_sidebar_content1">
                  <div class="content_list widget_post">
                     @if(isset($data['blogcategories']) && is_array($data['blogcategories']) && count($data['blogcategories']))
                     <div class="widget_title wow fadeInRight">
                        <h3>{{ __('msg.categories') }}</h3>
                     </div>
                     <ul>
                        @foreach($data['blogcategories'] as $b =>$bg)
                        <li><a href="{{ route('blog-category', $bg->slug) }}">{{$bg->name}}</a></li>
                        @endforeach
                     </ul>
                     @endif
                  </div>
                  <div class="content_list widget_post">
                     @if(isset($data['datarecentblog']) && is_array($data['datarecentblog']) && count($data['datarecentblog']))
                     <div class="widget_title wow fadeInRight">
                        <h3>{{ __('msg.recent_blogs') }}</h3>
                     </div>
                     @foreach($data['datarecentblog'] as $b =>$bg)
                     <div class="post_content1 wow fadeInRight">
                        <div class="post_thumb">
                           <a href="{{ route('blog-single', $bg->slug) }}"><img class="lazy" data-original="{{ $bg->image }}" alt="{{ $bg->title }}"></a>
                        </div>
                        <div class="post_info">
                           <h4><a href="{{ route('blog-single', $bg->slug) }}">{{ $bg->title }}</a></h4>
                           <span><em class="far fa-clock"></em> {{ date(" F j, Y", strtotime($bg->date_created)) }} </span>
                        </div>
                     </div>
                     @endforeach
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </div>
</section>
</div>