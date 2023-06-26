<?php
/* api list and theme change */
return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or`
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME'),

    //'theme' => 'eCart_02',

    'home_url' => env("APP_URL", "https://websiteurl.com/"),

    'api_url' => env("API_URL", "https://adminpanelurl.com/api-firebase/"),

    'asset_url' => env("ASSET_URL1", "https://adminpanelurl.com/dist/img/"),
    
    'access_key' => env("ACCESS_KEY", "accesskey"),

    'access_key_val' => env("ACCESS_KEY_VAL", "90336"),

    'reload_settings' => (30 * 60 * 60 * 24),

    'jwt_secret_key' => env("JWT_SECRET_KEY", "replace_with_your_strong_jwt_secret_key"),

    'jwt_payload' => [

        'iat' => time(), /* issued at time */

        'iss' => 'eKart',

        'exp' => time() + (30 * 60), /* expires after 1 minute */

        'sub' => 'eKart Authentication',

        'web' => '29260418',

    ],

    'jwt_alg' => 'HS256',



    'apis' => [

        'get-categories' => 'get-categories.php',

        'get-social-media' => 'get-social-media.php',

        'get-sub-categories' => 'get-subcategories-by-category-id.php',

        'get-cities' => 'get-cities.php',

        'get-areas' => 'get-areas-by-city-id.php',

        'get-products-by-category' => 'get-products-by-category-id.php',

        'get-products-by-subcategory' => 'get-products-by-subcategory-id.php',

        'get-product' => 'get-product-by-id.php',

        'order-process' => 'order-process.php',

        'set-device' => 'set-device.php',

        'user-registration' => 'user-registration.php',

        'login' => 'login.php',

        'offers' => 'offer-images.php',

        'advertisements' => 'get-product-advt.php',

        'products-search' => 'products-search.php',

        'get-similar-products' => 'get-similar-products.php',

        'sections' => 'sections.php',

        'settings' => 'settings.php',

        'slider-images' => 'slider-images.php',

        'test' => 'test.php',

        'validate-promo-code' => 'validate-promo-code.php',

        'cart' => 'cart.php',

        'favorites' => 'favorites.php',

        'products' => 'get-all-products.php',

        'flash-sales' => 'flash-sales.php',

        'shop' => 'shop.php',

        'faq' => 'get-faqs.php',

        'getblog' => 'get-blogs.php',

        'addresses' => 'user-addresses.php',

        'get-user' => 'get-user-data.php',

        'wallet-history' => 'get-user-transactions.php',

        'razorpay-order' => 'create-razorpay-order.php',

        'paypal-ipn' => '../paypal/ipn.php',

        'newsletter' => 'newsletter.php',

        'midtrans-order' => '../midtrans/create-payment.php',
        
        'get-variants-offline' => 'get-variants-offline.php',
        
        'get-products-offline' =>'get-products-offline.php',
        
        'get-all-data' => 'get-all-data.php',
        
        'store-fcm-id' => 'store-fcm-id.php'
        
    ],

    'api-params' => [

        'mobile' => 'mobile',

        'password' => 'password',

        'register' => 'register',

        'name' => 'name',

        'email' => 'email',

        'profile' => 'profile',

        'password' => 'password',

        'pincode' => 'pincode',

        'street' => 'street',

        'latitude' => 'latitude',

        'longitude' => 'longitude',

        'user-id' => 'user_id',

        'edit-profile' => 'edit-profile',

        'upload_profile' => 'upload_profile',

        'address' => 'address',

        'wallet-used' => 'wallet_used',

        'wallet-balance' => 'wallet_balance',

        'change-password' => 'change-password',

        'verify-user' => 'verify-user',

        'promo-code' => 'promo_code',

        'promo-discount' => 'promo_discount',

        'city-id' => 'city_id',

        'area-id' => 'area_id',

        'country-code' => 'country_code',

        'product-id' => 'product_id',

        'sub-category' => 'subcat',

        'category-id' => 'category_id',

        'sub-category-id' => 'subcategory_id',

        'cat-id' => 'cat_id',

        'search' => 'search',

        'products-search' => 'products-search',

        'get-orders' => 'get_orders',

        'place-order' => 'place_order',

        'tax-percentage' => 'tax_percentage',

        'tax-amount' => 'tax_amount',

        'quantity' => 'quantity',

        'get-slider-images' => 'get-slider-images',

        'get-offer-images' => 'get-offer-images',

        'get-all-sections' => 'get-all-sections',

        'get-val' => 1,

        'type' => 'type',

        'id' => 'id',

        'limit' => 'limit',

        'offset' => 'offset',

        'total' => 'total',

        'final-total' => 'final_total',

        'product-variant-id' => 'product_variant_id',

        'get_similar_products' => 'get_similar_products',

        'delivery-charge' => 'delivery_charge',

        'delivery-time' => 'delivery_time',

        'payment-method' => 'payment_method',

        'sort' => 'sort',

        'page' => 'page',

        'referral-code' => 'referral_code',

        'friends-code' => 'friends_code',

        'status' => 'status',

        'SSLECOMMERZ' => 'SSLECOMMERZ',
        
        'local_pickup' => 'local_pickup',

        'get_order_invoice' => 'get_order_invoice',
        
        'get_promo_codes' =>'get_promo_codes',
        
        'validate_promo_code' =>'validate_promo_code',
        

        'order-status' => [

            'awaiting-payment' => 'awaiting_payment',
            
            'received' => 'received',
        ]

    ],

    'payment_method' => [

        'cod' => 'C.O.D',

        'paypal' => 'PayPal',

        'payumoney' => 'PayUMoney',

        'razorpay' => 'RazorPay',

    ],

    'load-item-limit' => 12,

    'similar-product-load-limit' => 5,

    'show_price_range_in_discounted_price' => false,

    'show_price_range_in_price' => true,

    'style_1' => [

        'max_product_on_homne_page' => 4,

        'max_product_on_homne_page2' => 20

    ],

    'style_2' => [

        'max_product_on_homne_page' => 10,

        'max_product_on_homne_page2' => 10

    ],

    'style_3' => [

        'max_product_on_homne_page' => 3,

        'max_product_on_homne_page2' => 10

    ],

];
