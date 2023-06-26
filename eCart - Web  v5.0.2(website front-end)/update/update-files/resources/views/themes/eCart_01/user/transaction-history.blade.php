<!-- breadcumb -->
<section class="page_title corner-title overflow-visible">
   <div class="container">
      <div class="row">
         <div class="col-md-12 text-center">
            <h1>{{__('msg.transaction_history')}}</h1>
            <ol class="breadcrumb">
               <li class="breadcrumb-item">
                  <a href="{{ route('my-account') }}">{{__('msg.my_account')}}</a>
               </li>
               <li class="breadcrumb-item active">
                  {{__('msg.transaction_history')}}
               </li>
            </ol>
            <div class="divider-15 d-none d-xl-block"></div>
         </div>
      </div>
   </div>
</section>
<!-- eof breadcumb -->
<div class="main-content">
   <section class="checkout-section ptb-70 transaction_history">
      <div class="container">
         <div class="row">
            <div class="col-lg-3 col-md-12 col-12 mb-4">
               @include("themes.".get('theme').".user.sidebar")
            </div>
            <div class="col-lg-9 col-md-12 col-12">
               <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded mb-5">
               <div class="dash-bg-right dash-bg-right1 no_history">
                  @if(isset($data['list']) && isset($data['list']['data']) && count($data['list']['data']))
                  <div class="dash-bg-right-title">
                     <h4></h4>
                  </div>
                  <div class="active-offers-body">
                     <div class="table-responsive">
                        <table aria-describedby="wallet-table" class="table offer-table earning-table">
                           <thead class="thead-s-offer">
                              <tr>
                                 <th scope="col">{{__('msg.id')}}</th>
                                 <th scope="col">{{__('msg.payment_gateway')}}</th>
                                 <th scope="col">{{__('msg.date_and_time')}}</th>
                                 <th scope="col">{{__('msg.message')}}</th>
                                 <th scope="col">{{__('msg.amount')}}</th>
                                 <th scope="col">{{__('msg.status')}}</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($data['list']['data'] as $w)
                              <tr>
                                 <td>#{{ $w->id }}</td>
                                 <td>{{ strtoupper($w->type) }}</td>
                                 <td>{{ date('d-M-Y H:i A', strtotime($w->date_created)) }}</td>
                                 <td>{{ $w->message }}</td>
                                 <td>{{ get_price($w->amount, false) }}</td>
                                 <td>
                                    <button class="btn btn-sm btn-{{ ($w->status == 'canceled') ? 'danger' : 'success'}}">{{ strtoupper($w->status) }}</button></strong>
                                 </td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                  </div>
                  @else
                  <div class="row text-center">
                     <div class="col-12">
                        <br><br>
                        <h3>{{__('msg.no_transaction_history_found')}}</h3>
                     </div>
                     <div class="col-12">
                        <br><br>
                        <a href="{{ route('shop') }}" class="btn btn-primary"> <em class="fa fa-chevron-left mr-1"></em>{{__('msg.continue_shopping')}}</a>
                     </div>
                  </div>
                  @endif
                  <div class="row">
                     <div class="col">
                        @if(isset($data['last']) && $data['last'] != "")
                        <a href="{{ $data['last'] }}" class="btn btn-primary pull-left text-white"> {{__('msg.previous')}} <em class="fa fa-arrow-left"></em></a>
                        @endif
                     </div>
                     <div class="col favnext text-right">
                        @if(isset($data['next']) && $data['next'] != "")
                        <a href="{{ $data['next'] }}" class="btn btn-primary pull-right text-white"><em class="fa fa-arrow-right"></em> {{__('msg.next')}} </a>
                        @endif
                     </div>
                  </div>
               </div>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>