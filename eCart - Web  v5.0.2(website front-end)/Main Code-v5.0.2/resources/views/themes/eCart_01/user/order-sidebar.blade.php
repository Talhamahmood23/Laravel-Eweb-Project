<aside class="padding-bottom">
    <div class="list-group card px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
        <a href="{{ route('my-orders') }}" class="list-group-item"> <span><em class="fas fa-align-justify mr-2"></em> {{__('msg.all_orders')}}</span></a>
        <a href="{{ route('my-orders', 'processed') }}" class="list-group-item"> <span><em class="fa fa-tasks mr-2"></em> {{__('msg.in_process')}}</span></a>
        <a href="{{ route('my-orders', 'received') }}" class="list-group-item"> <span><em class="fa fa-list-ul mr-2"></em> {{__('msg.received')}}</span></a>
        <a href="{{ route('my-orders', 'shipped') }}" class="list-group-item"> <span><em class="fa fa-ship mr-2"></em> {{__('msg.shipped')}}</span></a>
        <a href="{{ route('my-orders', 'delivered') }}" class="list-group-item"> <span><em class="fa fa-truck mr-2"></em> {{__('msg.delivered')}}</span></a>
        <a href="{{ route('my-orders', 'cancelled') }}" class="list-group-item"> <span><em class="fa fa-ban mr-2"></em> {{__('msg.cancelled')}}</span></a>
        <a href="{{ route('my-orders', 'returned') }}" class="list-group-item"> <span><em class="fa fa-undo mr-2"></em> {{__('msg.returned')}}</span></a>
   </div>
</aside>