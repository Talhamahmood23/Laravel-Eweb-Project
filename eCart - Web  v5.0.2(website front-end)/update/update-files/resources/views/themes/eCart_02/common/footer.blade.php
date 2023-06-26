{{-- subscribe sec --}}
<section class="subscribe-news">
    <div class="newsletter">
        <div class="container">
            <div class="newsletter-inner center-sm">
                <div class="row justify-content-center align-items-center">
                    <div class=" col-xl-10 col-md-12">
                        <div class="newsletter-bg">
                            <div class="row  align-items-center">
                                <div class="col-xl-6 col-lg-6">
                                    <div class="d-lg-flex align-items-center">
                                        <div class="newsletter-icon">
                                            <i class="far fa-envelope-open fa-3x"></i>
                                        </div>
                                        <div class="newsletter-title">
                                            <h2 class="main_title">{{ __('msg.subscribe_to_our_newsletter') }}</h2>
                                            <div class="sub-title">{{ __('msg.newsletter_line') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <form action="{{ route('newsletter') }}" method="POST" class="ajax-form">
                                        @csrf
                                        <div class="formResponse"></div>
                                        <div class="newsletter-box">
                                            <input type="email"  id="email" name="email" placeholder="Email Here..." required>
                                            <button title="Subscribe" name="submit" type="submit" class="btn-color">{{__('msg.subscribe2')}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- dark mode --}}
{{-- <div id="switch-mode"><span class="dark-mode mode-control"><em class="fas fa-moon"></em></span>
    <span class="light-mode mode-control d-none"><em class="fas fa-sun"></em></span></div> --}}

{{-- footer --}}
<footer class="footer" id="iconfooter3">
    <div class="container">
        <hr>
        <div class="footer-inner">
            <div class="footer-middle">
                <div class="row">
                    <div class="col-lg-3 f-col">
                        <div class="footer-static-block">
                            <span class="opener plus"></span>
                            <div class="f-logo">
                                <a href="{{ route('home') }}" class="">
                                    <img src="{{ (_asset(Cache::get('web_logo')) == '') ? _asset(Cache::get('web_logo')) : URL::asset('images/headerlogo.png')  }}" alt="Logo">
                                </a>
                            </div>
                            <div class="footer-respond">
                                <p>{{ Cache::get('common_meta_description', '') }}</p>
                                @if(trim(Cache::get('android_app_url', '')) != '')
                                <a target="_blank" href="{{ Cache::get('android_app_url', 'https://play.google.com') }}" class="app_button">
                                    <img class="lazy" data-original="{{ _asset(Cache::get('google_play', theme('images/google1.png'))) }}" alt="Google Play Store">
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 f-col">
                        <div class="footer-static-block">
                            <span class="opener plus"></span>
                            <h3 class="title">{{ __('msg.customer_services') }} <span class="animate-border animate-border border-black"></span><em class="fas fa-angle-down arrowdown"></em></h3>
                            <ul class="collapse dont-collapse-sm link">
                                <li><a href="{{ route('page', 'privacy-policy') }}">{{ __('msg.privay_policy')}}</a></li>
                                <li><a href="{{ route('page', 'tnc') }}">{{ __('msg.terms_and_conditions')}}</a></li>
                                <li><a href="{{ route('page', 'refund-policy') }}">{{ __('msg.refund policy')}}</a></li>
                                <li><a href="{{ route('page', 'shipping-policy') }}">{{ __('msg.shipping_policy')}}</a></li>
                                <li><a href="{{ route('page', 'delivery-returns-policy') }}">{{ __('msg.delivery_return_policy')}}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 f-col">
                        <div class="footer-static-block">
                            <span class="opener plus"></span>
                            <h3 class="title">{{ __('msg.recent_blogs') }} <span class="animate-border animate-border border-black"></span><em class="fas fa-angle-down arrowdown"></em></h3>
                            <ul class="collapse dont-collapse-sm address-footer">
                                @if(Cache::has('getblog') && is_array(Cache::get('getblog')) && count(Cache::get('getblog')))
                                @foreach(Cache::get('getblog') as $bg)
                                @if(!empty($bg->slug))
                                <li class="post_content1 wow fadeInRight">
                                    <div class="post_thumb">
                                        <a href="{{ route('blog-single', $bg->slug) }}"><img class="lazy" data-original="{{ $bg->image }}" alt="{{ $bg->title }}"></a>
                                    </div>
                                    <div class="post_info">
                                        <h4><a href="{{ route('blog-single', $bg->slug) }}">{{ $bg->title }}</a></h4>
                                        <span><em class="far fa-clock"></em> {{ date(" F j, Y", strtotime($bg->date_created)) }} </span>
                                    </div>
                                </li>
                                @endif
                                @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 f-col">
                        <div class="footer-static-block">
                            <span class="opener plus"></span>
                            <h3 class="title">{{ __('msg.address') }} <span class="animate-border animate-border border-black"></span><em class="fas fa-angle-down arrowdown"></em></h3>
                            <ul class="collapse dont-collapse-sm address-footer">
                                @php
                                $store_address = str_ireplace("<br>", ' ',  Cache::get('store_address') );
                                @endphp
                                @if(trim(Cache::get('store_address', '')) != '')
                                <li class="item">
                                    <em class="fas fa-map-marker"> </em>
                                    <p>{{ $store_address }}</p>
                                </li>
                                @endif
                                <li class="item">
                                    <em class="fas fa-envelope"> </em>
                                    <p> <a href="#">{{ Cache::get('support_email')}}</a> </p>
                                </li>
                                <li class="item">
                                    <em class="fas fa-phone"> </em>
                                    <p>{{ Cache::get('support_number')}}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="footer-bottom ">
                <div class="row mtb-30">
                    <div class="col-lg-6 ">
                        <div class="copy-right ">{{__('msg.copyright')}} &copy; {{date('Y')}} {{__('msg.made')}} <a href="{{ Cache::get('copy_right_url', '') }}" target="_blank">{{ Cache::get('copy_right_title', '') }}.</a>
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        @if(Cache::has('social_media') && is_array(Cache::get('social_media')) && count(Cache::get('social_media')))
                        <div class="footer_social pt-xs-15 center-sm">
                            <ul class="social-icon">
                                <li>
                                    <div class="title">{{__('msg.follow_us_on')}}</div>
                                </li>
                                @foreach(Cache::get('social_media') as $i => $c)
                                <li><a href="{{ $c->link }}" target="_blank"><em class="fab {{ $c->icon }}"></em></a></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row text-center mtb-30 ">
                    <div class="col-12 ">
                        <div class="site-link">
                            <ul>
                                <li><a href="{{ route('about') }}">{{ __('msg.about_us')}}</a></li>
                                <li><a href="{{ route('shop') }}">{{ __('msg.shop')}} </a></li>
                                <li><a href="{{ route('blog') }}">{{ __('msg.blog')}} </a></li>
                                <li><a href="{{ route('page', 'faq') }}">{{ __('msg.faq')}}</a></li>
                                <li><a href="{{ route('contact') }}">{{ __('msg.contact_us')}} </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-12 ">
                        <div class="payment">
                            <div class="payment_icon">
                                <ul>
                                    <li>
                                        @if(isset(Cache::get('payment_methods')->cod_payment_method) && Cache::get('payment_methods')->cod_payment_method == 1)
                                        <img class="lazy" data-original="{{URL::asset('images/cod.svg')}}" data-src="img/cards_all.svg" alt="" class="lazy">
                                        @endif
                                    </li>
                                    <li>
                                        @if(isset(Cache::get('payment_methods')->paypal_payment_method) && Cache::get('payment_methods')->paypal_payment_method == 1)
                                        <img class="lazy" data-original="{{URL::asset('images/paypal.svg')}}" data-src="img/cards_all.svg" alt="" class="lazy">
                                        @endif
                                    </li>
                                    <li>
                                        @if(isset(Cache::get('payment_methods')->payumoney_payment_method) && Cache::get('payment_methods')->payumoney_payment_method == 1)
                                        <img class="lazy" data-original="{{URL::asset('images/payu.svg')}}" data-src="img/cards_all.svg" alt="" class="lazy">
                                        @endif
                                    </li>
                                    <li>
                                        @if(isset(Cache::get('payment_methods')->razorpay_payment_method) && Cache::get('payment_methods')->razorpay_payment_method == 1)
                                        <img class="lazy" data-original="{{URL::asset('images/rozerpay.svg')}}" data-src="img/cards_all.svg" alt="" class="lazy">
                                        @endif
                                    </li>
                                    <li>
                                        @if(isset(Cache::get('payment_methods')->stripe_payment_method) && Cache::get('payment_methods')->stripe_payment_method == 1)
                                        <img class="lazy" data-original="{{URL::asset('images/stripe.svg')}}" data-src="img/cards_all.svg" alt="" class="lazy">
                                        @endif
                                    </li>
                                    <li>
                                        @if(isset(Cache::get('payment_methods')->midtrans_payment_method) && Cache::get('payment_methods')->midtrans_payment_method == 1)
                                        <img class="lazy" data-original="{{URL::asset('images/midtrans.svg')}}" data-src="img/cards_all.svg" alt="" class="lazy">
                                        @endif
                                    </li>
                                    <li>
                                        @if(isset(Cache::get('payment_methods')->flutterwave_payment_method) && Cache::get('payment_methods')->flutterwave_payment_method == 1)
                                        <img class="lazy" data-original="{{URL::asset('images/flutterwave.svg')}}" data-src="img/cards_all.svg" alt="" class="lazy">
                                        @endif
                                    </li>
                                    <li>
                                        @if(isset(Cache::get('payment_methods')->paystack_payment_method) && Cache::get('payment_methods')->paystack_payment_method == 1)
                                        <img class="lazy" data-original="{{URL::asset('images/paystack.svg')}}" data-src="img/cards_all.svg" alt="" class="lazy">
                                        @endif
                                    </li>
                                    <li>
                                        @if(isset(Cache::get('payment_methods')->paytm_payment_method) && Cache::get('payment_methods')->paytm_payment_method == 1)
                                        <img class="lazy" data-original="{{URL::asset('images/paytm.svg')}}" data-src="img/cards_all.svg" alt="" class="lazy">
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>

<script src="{{ theme('js/cartajax.js') }}"></script>
<script src="{{ theme('js/cartpageajax.js') }}"></script>
<script src="{{ theme('js/plugins.js') }}"></script>
<script src="{{ theme('js/semantic.min.js') }}"></script>
<script src="{{ theme('js/switcherdemo.js') }}"></script>
<script src="{{ theme('js/spectrum.min.js') }}"></script>
<script src="{{ theme('js/script.js') }}"></script>
{{-- <script src="{{ theme('js/rtlscript.js') }}"></script> --}}
<script src="{{ asset('js/lazy.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>

<?= Cache::get('footer_script'); ?>

@if(Cache::get('show_color_picker_in_website')=='1')
<div class="demo-style-switch" id="switch-style">
    <a id="toggle-switcher" class="switch-button"><em class="far fa-sun fa-spin"></em></a> 
    <div class="switched-options">
        <ul class="styles color-inputs">
            <li>
                <label>{{__('msg.custom_color')}}</label>
                <span class="sp-original-input-container">
                    <div class="sp-colorize-container sp-add-on">
                        <div class="sp-colorize"></div>
                    </div>
                    <input id="theme-color-master" value="#83B735" name="theme-color-master" class="spectrum with-add-on">
                </span>
            </li>
        </ul>
    </div>
    @endif
    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js"></script>
    <!-- TODO: Add SDKs for Firebase products that you want to use https://firebase.google.com/docs/web/setup#available-libraries -->
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-analytics.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-firestore.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js"></script>


    <script>
    var firebaseConfig = {
        apiKey: "c",
  authDomain: "om",
  projectId: "ev",
  storageBucket: "ecam",
  messagingSenderId: "2957",
  appId: "1:7c",
  measurementId: "G-8B"
    };
    firebase.initializeApp(firebaseConfig);
    firebase.analytics();
    var messaging = firebase.messaging();

    function initFirebaseMessagingRegistration() {
        messaging
                .requestPermission()
                .then(function () {
                    return messaging.getToken()
                })
                .then(function (token) {
                    console.log(token);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{ route("save-token") }}',
                        type: 'POST',
                        data: {
                            token: token
                        },
                        dataType: 'JSON',
                        success: function (response) {
                            //console.log(response);
                            // alert('Token saved successfully.');
                        },
                        error: function (err) {
                            console.log('User Chat Token Error' + err);
                        }
                    });
                }).catch(function (err) {
            console.log('User Chat Token Error' + err);
        });
    }

    messaging.onMessage(function (payload) {
        console.log(payload.data);
        const string = payload.data.data;

        var obj = jQuery.parseJSON(payload.data.data);
const url = window.location.origin;
        const noteTitle = obj.title;
        const noteOptions = {
            body: obj.message,
            icon: obj.image,
            
           data:{
            time: new Date(Date.now()).toString(),
             click_action: '/orders'
        }
        };
        new Notification(noteTitle, noteOptions);
    });

    $(document).ready(initFirebaseMessagingRegistration());
    </script>




