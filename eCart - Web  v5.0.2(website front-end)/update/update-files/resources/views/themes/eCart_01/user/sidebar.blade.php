
    <div class="card mb-3 px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
        <div class="card-body">
            <div class="profile-header-img">
                <div class="navbar-brand">
                    <a href="{{ route('home') }}">
                        <img src="{{ _asset(Cache::get('web_logo')) }}" alt="logo">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="list-group px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded card">
        <a href="{{ route('my-account') }}" class="list-group-item"><em class="fa fa-user"></em><span class="side-menu">{{__('msg.my_profile')}}</span></a>
        <a href="{{ route('change-password') }}" class="list-group-item"><em class="fa fa-asterisk"></em><span class="side-menu">{{__('msg.change_password')}}</span></a>
        <a href="{{ route('my-orders') }}" class="list-group-item"><em class="fas fa-taxi"></em><span class="side-menu">{{__('msg.my_orders')}}</span></a>
        <a href="{{ route('notification') }}" class="list-group-item"><em class="fa fa-bell"></em><span class="side-menu">{{__('msg.notifications')}}</span></a>
        <a href="{{ route('favourite') }}" class="list-group-item"><em class="fa fa-heart"></em><span class="side-menu">{{__('msg.favourite')}}</span></a>
        <a href="{{ route('refer-earn') }}" class="list-group-item"><em class="fas fa-rupee-sign"></em><span class="side-menu">{{ __('msg.refer_and_earn') }}</span></a>
        <a href="{{ route('transaction-history') }}" class="list-group-item"><em class="fa fa-outdent"></em><span class="side-menu">{{__('msg.transaction_history')}}</span></a>
        <a href="{{ route('addresses') }}" class="list-group-item"><em class="fa fa-wrench"></em><span class="side-menu">{{__('msg.manage_addresses')}}</span></a>
        <a href="{{ route('logout') }}" class="list-group-item"><em class="fa fa-sign-out-alt"></em><span class="side-menu">{{__('msg.logout')}}</span></a>
    </div>
