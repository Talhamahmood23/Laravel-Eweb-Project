{{-- big advertise banner --}}
@if(Cache::has('advertisements') && is_array(Cache::get('advertisements')) && count(Cache::get('advertisements')))
<section class="shipping-content my-md-5 my-sm-2 my-3">
   <div class="main-content">
      {{-- advertise-banner-images --}}
      <div class="home-banner banner-sec-1">
         <div class="container-fluid">
            <div class="row">
               @foreach(Cache::get('advertisements') as $advt)
               @if(isset($advt->ad1) && trim($advt->ad1) !== "")
               <div class="col col-md-4 col-sm-12  col-12">
                  <div class="banner_box_content">
                     <img class="lazy" data-original="{{ $advt->ad1 }}" alt="ad-1">
                  </div>
               </div>
               @endif
               @if(isset($advt->ad2) && trim($advt->ad2) !== "")
               <div class="col col-md-4 col-sm-12  col-12">
                  <div class="banner_box_content">
                     <img class="lazy" data-original="{{ $advt->ad2 }}" alt="ad-2">
                  </div>
               </div>
               @endif
               @if(isset($advt->ad3) && trim($advt->ad3) !== "")
               <div class="col col-md-4 col-sm-12  col-12">
                  <div class="banner_box_content">
                     <img class="lazy" data-original="{{ $advt->ad3 }}" alt="ad-3">
                  </div>
               </div>
               @endif
               @endforeach
            </div>
         </div>
      </div>
      {{-- new arrival --}}
   </div>
</section>
@endif
