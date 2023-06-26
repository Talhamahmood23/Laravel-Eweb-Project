<div class="account-sidebar account-tab mb-sm-30">
   <div class="dark-bg tab-title-bg">
      <div class="heading-part">
         <div class="sub-title text-center"><span></span><em class="far fa-user"></em>{{__('msg.my_orders')}}
         </div>
      </div>
   </div>
   <div class="account-tab-inner">
      <ul class="account-tab-stap">
         <li>
            <a href="{{ route('my-orders') }}"><em class="fas fa-align-justify"></em>{{__('msg.all_orders')}}<i class="fa fa-angle-right"></i> </a>
         </li>
         <li>
             <a href="{{ route('my-orders', 'processed') }}"><em class="fas fa-tasks"></em>{{__('msg.in_process')}}<i class="fa fa-angle-right"></i> </a>
         </li>
         <li>
            <a href="{{ route('my-orders', 'received') }}"><em class="fas fa-list-ul"></em> {{__('msg.received')}}<i class="fa fa-angle-right"></i> </a>
         </li>
         <li>
            <a href="{{ route('my-orders', 'shipped') }}"><em class="fas fa-ship"></em>{{__('msg.shipped')}}<i class="fa fa-angle-right"></i> </a>
         </li>
         <li>
            <a href="{{ route('my-orders', 'delivered') }}"><em class="fas fa-truck"></em>{{__('msg.delivered')}}<i class="fa fa-angle-right"></i> </a>
         </li>
         <li>
            <a href="{{ route('my-orders', 'cancelled') }}"><em class="fas fa-ban"></em>{{__('msg.cancelled')}}<i class="fa fa-angle-right"></i> </a>
         </li>
         <li>
            <a href="{{ route('my-orders', 'returned') }}"><em class="fas fa-undo"></em>{{__('msg.returned')}}<i class="fa fa-angle-right"></i> </a>
         </li>
      </ul>
   </div>
</div>