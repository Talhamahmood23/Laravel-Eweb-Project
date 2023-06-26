<!-- icon section -->
<!-- breadcumb -->
<section class="page_title corner-title overflow-visible">
   <div class="container">
      <div class="row">
         <div class="col-md-12 text-center">
            <h1>{{ __('msg.contact_page') }}</h1>
            <ol class="breadcrumb">
               <li class="breadcrumb-item">
                  <a href="{{ route('home') }}"> {{ __('msg.home') }}</a>
               </li>
               <li class="breadcrumb-item active">
                  {{ __('msg.contact_page') }}
               </li>
            </ol>
            <div class="divider-15 d-none d-xl-block"></div>
         </div>
      </div>
   </div>
</section>


<section class="iconsec mt-5 padding-bottom">
    <div class="divider-p-top-lg"></div>
    <div class="container">
        <div class="card px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
            <div class="row">
                <div class="col-md-4">
                    <div class="icondiv justify-content-center d-flex tossing">
                        <img class="lazy" data-original="{{ asset('images/icon1.png') }}" alt="phone">
                    </div>
                    <h6 class="text-center my-3 font-weight-bold title-contact">{{ __('msg.call_us1') }}</h6>
                    <p class="text-center text-capitalize"><strong class="font-weight-bold">{{ __('msg.phone') }}</strong>
                        {{ Cache::get('support_number') }}
                    </p>
                </div>
                <div class="col-md-4">
                    <div class="icondiv justify-content-center d-flex floating">
                        <img class="lazy" data-original="{{ asset('images/icon2.png') }}" alt="location">
                    </div>
                    <h6 class="text-center my-3 font-weight-bold title-contact">{{ __('msg.Visit Us') }}</h6>
                    <p class="text-center text-capitalize">
                        <strong class="font-weight-bold">{{ __('msg.Address') }}</strong>
                        {{ Cache::get('store_address') }}
                    </p>
                </div>
                <div class="col-md-4">
                    <div class="icondiv justify-content-center d-flex pulse">
                        <img class="lazy" data-original="{{ asset('images/icon3.png') }}" alt="visit">
                    </div>
                    <h6 class="text-center my-3 font-weight-bold title-contact">{{ __('msg.Write Us') }}</h6>
                    <p class="text-center text-capitalize">
                        <strong class="font-weight-bold">{{ __('msg.Email') }}</strong>{{ Cache::get('support_email') }}
                    </p>
                </div>
            </div>
            <!-- eof icon sec -->
            <!-- contact form -->
            <div class="contactsec1">
                <div class="divider-top-md"></div>
                <div class="wrap">
                    <form class="cool-b4-form" action="{{ route('contact') }}" method="POST">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" id="name">
                                    <label for="name">{{ __('msg.Name') }}</label>
                                    <span class="input-highlight"></span>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" id="email">
                                    <label for="email">{{ __('msg.Email') }}</label>
                                    <span class="input-highlight"></span>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control contact_phone" name="phone">
                                    <label for="phone">{{ __('msg.Phone Number') }}</label>
                                    <span class="input-highlight"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea name="message" id="message" class="form-control"></textarea>
                                    <label for="message">{{ __('msg.Message') }}</label>
                                    <span class="input-highlight"></span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 mb-5 buttons-type">
                            <button type="submit" class="btn btn-primary">{{ __('msg.Submit') }}</button>
                        </div>
                    </form>
                    <div class="divider-p-bottom-lg"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- eof contact form -->

<!-- map -->
<section class="mapsec padding-bottom">
    <div class="container">
        <div class="card px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
            <div class="row">
                <div class="mapcontent col-md-12" id="map">
                    <iframe width="100%" height="400" frameborder="0" style="border:0;" allowfullscreen=""
                        aria-hidden="false" tabindex="0"
                        src="https://maps.google.com/maps?q=+{{ Cache::get('map_latitude') }}+,+{{ Cache::get('map_longitude') }}+&hl=en&z=18&amp;output=embed">
                    </iframe>
                </div>
            </div>
        </div>
        <div class="divider-bottom-md"></div>
    </div>
</section>
<!-- eof map -->