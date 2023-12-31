<!-- breadcumb -->
<section class="page_title corner-title overflow-visible">
   <div class="container">
      <div class="row">
         <div class="col-md-12 text-center">
            <h1>{{__('msg.my_account')}}</h1>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"> <a href="{{ route('home') }}">{{__('msg.home')}}</a> </li>
               <li class="breadcrumb-item active"> {{__('msg.my_account')}} </li>
            </ol>
            <div class="divider-15 d-none d-xl-block"></div>
         </div>
      </div>
   </div>
</section>
<!-- eof breadcumb -->
<div class="main-content">
   <section class="checkout-section ptb-70">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-3 col-md-12 col-12 mb-4">
               @include("themes.".get('theme').".user.sidebar")
             </div>
            <div class="col-lg-9 col-md-12 col-12">
               <div id="data-step1" class="account-content" data-temp="tabdata">
                  <div class="dashboard-right">
                     <form method='POST' enctype="multipart/form-data" id="profile_form">
                        @csrf
                        <div class="row">
                           <div class="col-xl-4 col-md-6 col-lg-6 mb-lg-0 mb-md-3 mb-sm-5 mb-4">
                              <div class="dash-bg-right dash-bg-right1">
                                 <div class="reward-body-dtt">
                                    <div class="reward-img-icon">
                                       <img id="user_profile" class="lazy" data-original="{{ $data['profile']['profile'] }}" alt="User">
                                       <div class="img-add">
                                          <input type="file" name="profile" accept="image/*" id="file" />
                                          <label for="file"><i class="fas fa-camera"></i></label>
                                          <input type="text" class="form-control" disabled placeholder="Upload File" id="file1" hidden>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-xl-8 col-lg-6 col-md-6 mb-lg-0 mb-md-3 mb-sm-5 mb-4">
                              <div class="dash-bg-right dash-bg-right1">
                                 <div class="add-cash-body">
                                    <div class="row">
                                       <div class="col-lg-12 col-md-12">
                                          <div class="form-group mt-1">
                                             <label class="control-label">{{__('msg.name')}}</label>
                                             <div class="ui search focus">
                                                <div class="ui left icon input card-detail-desc">
                                                   <input class="card-inputfield " type="text" name="name" value="{{ $data['profile']['name'] }}" required>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       &nbsp;
                                       <div class="col-lg-12 col-md-12">
                                          <div class="form-group mt-1">
                                             <label class="control-label">{{__('msg.email')}}</label>
                                             <div class="ui search focus">
                                                <div class="ui left icon input card-detail-desc">
                                                   <input class="card-inputfield " type="email" name="email" value="{{ $data['profile']['email'] }}">
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       &nbsp;
                                       <div class="col-lg-12 col-md-12">
                                          <div class="form-group mt-1 mb-4">
                                             <label class="control-label">{{__('msg.mobile')}}</label>
                                             <div class="ui search focus">
                                                <div class="ui left icon input card-detail-desc">
                                                   <input class="card-inputfield " type="text" value="{{ $data['profile']['mobile'] }}" disabled="disabled">
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <input type="hidden" value="{{ $data['profile']['user_id'] }}" class="form-control" name="id">
                                    <button type="submit" name="submit" value="submit" id="submit_btn" class=" btn btn-primary">{{__('msg.update')}}</button>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>
