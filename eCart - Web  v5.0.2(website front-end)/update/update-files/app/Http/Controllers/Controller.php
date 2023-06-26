<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;
use Firebase\JWT\JWT;
use Prophecy\Call\Call;
use function GuzzleHttp\json_decode;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    public $client;

    public function __construct() {
        $this->client = new \GuzzleHttp\Client(['base_uri' => config('ekart.api_url')]);
    }

    public function init($reload = false) {
        $lmt = Cache::get('lmt', 0);
        if ($reload || $lmt + config('ekart.reload_settings') < time()) {
            $this->all_data();
            $this->update_settings();
            $this->update_advertisements();
            $this->update_sliders();
            $this->update_getblog();
            $this->update_flash_sales();
        } else {
            if (!Cache::has('logo')) {
                $this->update_settings();
            }
            if (!Cache::has('sliders')) {
                $this->update_sliders();
            }
            if (!Cache::has('advertisements')) {
                $this->update_advertisements();
            }
            if (!Cache::has('getblog')) {
                $this->update_getblog();
            }
            if (!Cache::has('flash_sales')) {
                $this->update_flash_sales();
            }
        }
    }

    function post($api, $params = array(), $die = false) {

        try {
            $return = [];

            $data = $params['data'] ?? [];

            $token = $this->generate_token();

            $data[config('ekart.access_key')] = config('ekart.access_key_val');

            $response = $this->client->post(config("ekart.apis.$api"), ['headers' => ["Authorization" => "Bearer $token"], 'form_params' => $data]);

            if ($response->getStatusCode() === 200) {
                if ($die) {
                    echo "Bearer $token<br><br>";
                    echo "API URL : " . get("apis.$api") . "<br><br>";
                    echo "Params : <pre>";
                    var_dump($data);
                    echo "</pre><br><br>";
                    echo "API Response : " . $response->getBody();
                    die();
                }
                $return = $this->response($response->getBody(), $params);
            }
            return $return;
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            if (isset($_GET['debug']) && $_GET['debug'] == true) {
                echo $e->getMessage();
            } else {
                $theme = get('theme');
                echo view("themes.$theme.error");
            }
        }
    }

    function nekot() {
        return $this->generate_token();
    }

    function ipa_lru() {
        return get('api_url');
    }

    function response($return = [], $params = []) {
        $return = (array) getJSON($return);
        $error = true;
        if (isset($return['error'])) {
            if (is_bool($return['error'])) {
                if ($return['error'] === false) {
                    $error = false;
                }
            } elseif (is_string($return['error'])) {
                if ($return['error'] === "false") {
                    $error = false;
                }
            }
        }
        if (!$error) {
            $data_param = 'data';
            if (isset($params['data_param'])) {
                $data_param = $params['data_param'];
            }
            if (isset($return[$data_param])) {
                $return = (array) $return[$data_param];
            }
        }
        return $return;
    }

    function generate_token() {
        return jwt::encode(config('ekart.jwt_payload'), config('ekart.jwt_secret_key'), config('ekart.jwt_alg'));
    }

    public function html($view, $data = array(), $reload = false) {
        $this->init($reload);
        $theme = get('theme');

        if ($theme == 'eCart_01') {
            if (Cache::get('website_under_maintenance') == 1) {
                echo view("themes.$theme.underconstruction");
                die();
            }
            if (isLoggedIn()) {
                $data['cart'] = $this->getCart();
            } else {
                $data['cart'] = $this->getCart_offline();
            }
            if (isLoggedIn()) {
                $user = $this->post('get-user', ['data' => ['get_user_data' => 1, 'user_id' => session()->get('user')['user_id']]]);
                echo view("themes.$theme.common.header", compact('view', 'data', 'user'));
            } else {
                echo view("themes.$theme.common.header", compact('view', 'data'));
            }
           
            echo view("themes.$theme.$view", compact('theme', 'data'));
            echo view("themes.$theme.login");

            if ($view == "home") {
                echo view("themes.$theme.parts.offers");
                echo view("themes.$theme.parts.categories");
                if (Cache::has('sections') && is_array(Cache::get('sections')) && count(Cache::get('sections'))) {
                    foreach (Cache::get('sections') as $s) {
                        echo view("themes.$theme.parts." . $s->style, compact('theme', 's', 'view'));
                    }
                }
            }
            echo view("themes.$theme.common.footer");
        } else {
            if (Cache::get('website_under_maintenance') == 1) {
                echo view("themes.$theme.underconstruction");
                die();
            }
            if (isLoggedIn()) {
                $data['cart'] = $this->getCart();
            } else {
                $data['cart'] = $this->getCart_offline();
            }
            if (isLoggedIn()) {
                $user = $this->post('get-user', ['data' => ['get_user_data' => 1, 'user_id' => session()->get('user') ['user_id']]]);
                echo view("themes.$theme.common.header", compact('view', 'data', 'user'));
            } else {
                echo view("themes.$theme.common.header", compact('view', 'data'));
            }
            echo view("themes.$theme.login");
            echo view("themes.$theme.$view", compact('theme', 'data'));
            if ($view == "home") {
                echo view("themes.$theme.parts.offers");
                echo view("themes.$theme.parts.categories");
                if (Cache::has('sections') && is_array(Cache::get('sections')) && count(Cache::get('sections'))) {
                    foreach (Cache::get('sections') as $s) {
                        echo view("themes.$theme.parts." . $s->style, compact('theme', 's', 'view'));
                    }
                }
            }

            echo view("themes.$theme.common.footer");
        }
        return true;
    }

    public function all_data() {
        $all_data = $this->post('get-all-data', ['data' => ['pincode_id' => Cache::get('pincode')]]);
    
        if (isLoggedIn()) {
            $all_data = $this->post('get-all-data', ['data' => ['pincode_id' => Cache::get('pincode'), 'user_id' => session()->get('user')['user_id']]]);
        }
       
        if (isset($all_data['error']) && $all_data['error']) {
            
        } else {
            $categories = $all_data['categories'];
           
            if (count($categories)) {
                $category = [];
                for ($i = 0; $i < count($categories); $i++) {
                    $slug = getSlug($categories[$i]->name, $category);
                    $categories[$i]->slug = $slug;
                    $category[$slug] = $categories[$i];
                }
                Cache::put('categories', $category);
               
                if (isset($all_data['settings'])) {
                    $settings = $all_data['settings'];
                    foreach ($settings as $k => $v) {
                        if ($k == "payment_methods") {
                            Cache::put('payment_methods',$v);
                        } elseif ($k == "front_end_settings") {
                            // $frontEndSettings = $v;
                            // foreach ($frontEndSettings as $k1 => $v1) {
                            //     Cache::put($k1, $v1);
                            // }
                            Cache::put('front_end_settings',$v);
                        } elseif ($k == "time_slot_config") {
                            $v =$v;
                            if (($v->is_time_slots_enabled ?? 0) == 1 && ($v->time_slot_config ?? 0) == 1) {
                                $getTimeSlot = $this->post('settings', ['data' => ['get_time_slots' => 1, 'setting' => 1]]);
                                if (!($getTimeSlot['error'] ?? true)) {
                                    $v->slots = $getTimeSlot['time_slots'];
                                    Cache::put('timeslot', $v);
                                }
                            }
                            Cache::put('delivery_starts_from', $v->delivery_starts_from - 1 ?? 0);
                            Cache::put('allowed_days', Cache::get('delivery_starts_from') + (($v->allowed_days ?? 10) - 1));
                        } else {
                            Cache::put($k, $v);
                        }
                    }
                }
                $social_media = $all_data['social_media'];
                if (count($social_media)) {
                    $socialmedia = [];
                    for ($i = 0; $i < count($social_media); $i++) {
                        $slug = getSlug($social_media[$i]->icon, $socialmedia);
                        $social_media[$i]->icon = $slug;
                        $socialmedia[$slug] = $social_media[$i];
                    }
                    Cache::put('social_media', $socialmedia);
                }
                $flash_sales = $all_data['flash_sales'];
                if (count($flash_sales)) {
                    Cache::put('flash-sales', $flash_sales);
                }
                $sliders = $all_data['slider_images'];
                if (!\is_null($sliders)) {
                    if (count($sliders)) {
                        if (isset($sliders['error']) && $sliders['error']) {
                            return false;
                        } else {
                            Cache::put('sliders', $sliders);
                        }
                    }
                }
                $offers = $all_data['offer_images'];
                Cache::put('offers', $offers);
                $category_offer_images = $all_data['category_offer_images'];
                Cache::put('category_offer_images', $category_offer_images);
                $slider_offer_images = $all_data['slider_offer_images'];
                Cache::put('slider_offer_images', $slider_offer_images);

                $all_sections = $all_data['sections'];
                
                Cache::forget('sections');
                if (is_array($all_sections) && count($all_sections)) {
                    if (isset($all_sections['error']) && $all_sections['error']) {
                        return false;
                    } else {
                        $sections = [];
                        foreach ($all_sections as $r) {
                            if (isset($r->title)) {
                                $r->slug = getSlug($r->title, $sections);
                                $sections[$r->slug] = $r;
                            }
                        }

                        Cache::put('sections', $sections);

                        return true;
                    }
                }

                return true;
            } else {
                return false;
            }
        }
        Cache::put('lmt', time());
    }

    public function update_settings() {
        $settings = $this->post('settings', ['data' => ['all' => true]]);

        if ($settings) {
            foreach ($settings as $k => $v) {
                if ($k == "payment_methods") {
                    Cache::put('payment_methods', json_decode($v));
                } elseif ($k == "front_end_settings") {
                    $frontEndSettings = \json_decode($v);
                    foreach ($frontEndSettings as $k1 => $v1) {
                        Cache::put($k1, $v1);
                    }
                } elseif ($k == "time_slot_config") {
                    $v = \json_decode($v);
                    if (($v->is_time_slots_enabled ?? 0) == 1) {
                        if (($v->time_slot_config ?? 0) == 1) {
                            $getTimeSlot = $this->post('settings', ['data' => ['get_time_slots' => 1, 'setting' => 1]]);
                            if (($getTimeSlot['error'] ?? true) == false) {
                                $v->slots = $getTimeSlot['time_slots'];
                                Cache::put('timeslot', $v);
                            }
                        }
                    }
                    Cache::put('delivery_starts_from', $v->delivery_starts_from - 1 ?? 0);
                    Cache::put('allowed_days', Cache::get('delivery_starts_from') + (($v->allowed_days ?? 10) - 1));
                } else {
                    Cache::put($k, $v);
                }
            }
            Cache::put('lmt', time());
        } else {
            die('Please set url in .env, ekart.php file according documentation');
        }
    }

    public function update_social_media($social_media = []) {
        if (empty($social_media)) {
            $social_media = $this->post('get-social-media', []);
        }
        if (isset($social_media['error']) && $social_media['error']) {
            
        }
        if (count($social_media)) {
            $socialmedia = [];
            for ($i = 0; $i < count($social_media); $i++) {
                $slug = getSlug($social_media[$i]->icon, $socialmedia);
                $social_media[$i]->icon = $slug;
                $socialmedia[$slug] = $social_media[$i];
            }
            Cache::put('social_media', $socialmedia);
            return true;
        } else {
            return false;
        }
    }

    public function update_categories($categories = []) {
        if (empty($categories)) {
            $categories = $this->post('get-categories', []);
        }
        if (isset($categories['error']) && $categories['error']) {
            die('No Data Found. Please Add Data On Admin Panel');
        }
       
        if (count($categories)) {
            $category = [];
            for ($i = 0; $i < count($categories); $i++) {
                $slug = getSlug($categories[$i]->name, $category);
                $categories[$i]->slug = $slug;
                $category[$slug] = $categories[$i];
            }
            Cache::put('categories', $category);
            return true;
        } else {
            return false;
        }
    }

    public function update_sliders() {
        $sliders = $this->post('slider-images', ['data' => [api_param('get-slider-images') => api_param('get-val')]]);

        if (!\is_null($sliders)) {
            if (count($sliders)) {
                if (isset($sliders['error']) && $sliders['error']) {
                    return false;
                } else {
                    Cache::put('sliders', $sliders);
                }
                return true;
            } else {
                return false;
            }
        }
    }

   

    public function update_advertisements() {
        return Cache::put('advertisements', $this->post('advertisements', ['data' => [' ']]));
    }

    public function update_getblog() {
        return Cache::put('getblog', $this->post('getblog', ['data' => ['get_blogs' => 1, 'limit' => 2, 'sort' => 'id', 'order' => 'DESC']]));
    }

    public function update_flash_sales() {
        return Cache::put('flash-sales', $this->post('flash-sales', ['data' => ['get-all-flash-sales' => 1]]));
    }

    public function update_sections() {
        $data = [api_param('get-all-sections') => api_param('get-val')];

        if (isLoggedIn()) {
            $data[api_param('user-id')] = session()->get('user') ['user_id'];
        }
        $response = $this->post('sections', ['data' => $data, 'data_param' => 'sections']);

        if (is_array($response) && count($response)) {
            if (isset($response['error']) && $response['error']) {
                return false;
            } else {
                $sections = [];
                foreach($response as $r) {
                    if(isset($r->title)) {
                        $r->slug = getSlug($r->title, $sections);
                        $sections[$r->slug] = $r;
                    }
                }
                Cache::put('sections', $sections);

                return true;
            }
        } else {
            return false;
        }
    }

    public function getCart() {
        if (isLoggedIn()) {

            $cart = $this->post('cart', ['data' => ['get_user_cart' => 1, 'user_id' => session()->get('user') ['user_id']]]);

            $addresses = session()->get('checkout-address');

            $settings = $this->post('settings', ['data' => ['settings' => 1, 'get_timezone' => 1]]);

            $data['subtotal'] = 0;

            $data['mrptotal'] = 0;

            $data['cart'] = [];

            if (is_array($cart) && count($cart) && !($cart['error'] ?? false)) {

                $total_tax = 0;

                foreach ($cart as $c) {

                    if (isset($c) && intval($c->qty ?? 0)) {

                        $item_mrpprice = get_price_mrp($c, 0) * ($c->qty ?? 1);

                        $data['mrptotal'] += $item_mrpprice;

                        $item_price = get_price_varients($c, 0, 0) * ($c->qty ?? 1);

                        $data['subtotal'] += $item_price;

                        $total_tax += ($item_price * ($c->tax_percentage ?? 0) / 100);
                    }
                }
                $coupon = session()->get('discount', []);

                $data['coupon'] = $coupon;

                $data['saved_price'] = $data['mrptotal'] - $data['subtotal'] + floatval($coupon['discount'] ?? 0);

                $data['cart'] = $cart;

                $data['total'] = $data['subtotal'];

                if (floatval(Cache::get('tax', 0)) > 0) {

                    $data['tax'] = (floatval(Cache::get('tax', 0)) > 0) ? number_format(Cache::get('tax'), 2) : 0;

                    $data['tax_amount'] = (floatval(Cache::get('tax', 0)) > 0) ? floatval(floatval(Cache::get('tax')) * $data['subtotal'] / 100) : 0;
                } else {

                    $data['tax'] = '';

                    $data['tax_amount'] = $total_tax;
                }
                $data['subtotal'] += $data['tax_amount'];
                $data['total'] += $data['tax_amount'];

                $data['shipping'] = (intval($data['subtotal']) < Cache::get('min_amount', 0) && Cache::has('delivery_charge')) ? floatval(Cache::get('delivery_charge')) : 0;

                if ($settings['settings']->area_wise_delivery_charge == 1) {
                    $data['address'] = session()->get('checkout-address');

                    if (isset($data['address']) && isset($data['address']->delivery_charges)) {
                        if ($data['subtotal'] < floatval($data['address']->minimum_free_delivery_order_amount)) {
                            $data['shipping'] = $data['address']->delivery_charges;
                        } else {
                            $data['shipping'] = 0;
                        }
                    } else {
                        if (isset($addresses[0]) && isset($addresses[0]->delivery_charges)) {
                            foreach ($addresses as $a) {

                                if ($a->is_default == 1) {
                                    if ($data['subtotal'] < floatval($a->minimum_free_delivery_order_amount)) {
                                        $data['shipping'] = $a->delivery_charges;
                                    } else {
                                        $data['shipping'] = 0;
                                    }
                                } else {
                                    if ($data['subtotal'] < floatval($addresses[0]->minimum_free_delivery_order_amount)) {
                                        $data['shipping'] = $addresses[0]->delivery_charges;
                                    } else {
                                        $data['shipping'] = 0;
                                    }
                                }
                            }
                        }
                    }
                }
                $data['address'] = session()->get('checkout-address');
                if ($data['address'] == null) {
                    $data['shipping'] = 0;
                }
                $data['total'] += $data['shipping'];

                $coupon = session()->get('discount', []);

                $data['coupon'] = $coupon;

                $data['total'] -= floatval($coupon['discount'] ?? 0);
            }
            $data['address'] = session()->get('checkout-address');
            return $data;
                    }
    }

    public function getCart_offline() {

        if (!isLoggedIn()) {

            $get_session_varient_ids = session()->get('variant_ids', []);

            $varient_ids = implode(',', $get_session_varient_ids);

            $cart = $this->post('get-variants-offline', ['data' => ['get_variants_offline' => 1, 'variant_ids' => $varient_ids]]);

            $settings = $this->post('settings', ['data' => ['settings' => 1, 'get_timezone' => 1]]);

            $data['subtotal'] = 0;

            $data['mrptotal'] = 0;

            $data['cart'] = [];

            if (session()->has('cart')) {
                $data['cart_session'] = session()->get('cart');
                
                if (!empty($data['cart_session'])) {
                    foreach ($data['cart_session'] as $entry) {
                        $qtydata[] = $entry['quantity'];
                    }

                    $qtys = implode(',', $qtydata);
                }
            }

            if (is_array($cart) && count($cart) && !($cart['error'] ?? false)) {

                $total_tax = 0;

                foreach ($cart as $c) {

                    $qty = $data['cart_session'][$c->product_variant_id]['quantity'];

                    if (isset($c)) {

                        $item_mrpprice = get_price_mrp($c, 0) * ($c->qty ?? 1);

                        $data['mrptotal'] += $item_mrpprice;

                        $item_price = get_price_varients($c, 0, 0) * ($qty ?? 1);

                        $data['subtotal'] += $item_price;

                        $total_tax += ($item_price * ($c->tax_percentage ?? 0) / 100);
                    }
                }
                $coupon = session()->get('discount', []);

                $data['coupon'] = $coupon;

                $data['saved_price'] = $data['mrptotal'] - $data['subtotal'] + floatval($coupon['discount'] ?? 0);

                $data['cart'] = $cart;

                $data['total'] = $data['subtotal'];

                if (floatval(Cache::get('tax', 0)) > 0) {

                    $data['tax'] = (floatval(Cache::get('tax', 0)) > 0) ? number_format(Cache::get('tax'), 2) : 0;

                    $data['tax_amount'] = (floatval(Cache::get('tax', 0)) > 0) ? floatval(floatval(Cache::get('tax')) * $data['subtotal'] / 100) : 0;
                } else {

                    $data['tax'] = '';

                    $data['tax_amount'] = $total_tax;
                }
                $data['subtotal'] += $data['tax_amount'];
                $data['total'] += $data['tax_amount'];

                $data['shipping'] = (intval($data['subtotal']) < Cache::get('min_amount', 0) && Cache::has('delivery_charge')) ? floatval(Cache::get('delivery_charge')) : 0;

                if ($settings['settings']->area_wise_delivery_charge == 1) {
                    $data['address'] = session()->get('checkout-address');

                    if (isset($data['address']) && isset($data['address']->delivery_charges)) {
                        if ($data['subtotal'] < floatval($data['address']->minimum_free_delivery_order_amount)) {
                            $data['shipping'] = $data['address']->delivery_charges;
                        } else {
                            $data['shipping'] = 0;
                        }
                    } else {
                        if (isset($addresses[0]) && isset($addresses[0]->delivery_charges)) {
                            foreach ($addresses as $a) {

                                if ($a->is_default == 1) {
                                    if ($data['subtotal'] < floatval($a->minimum_free_delivery_order_amount)) {
                                        $data['shipping'] = $a->delivery_charges;
                                    } else {
                                        $data['shipping'] = 0;
                                    }
                                } else {
                                    if ($data['subtotal'] < floatval($addresses[0]->minimum_free_delivery_order_amount)) {
                                        $data['shipping'] = $addresses[0]->delivery_charges;
                                    } else {
                                        $data['shipping'] = 0;
                                    }
                                }
                            }
                        }
                    }
                }

                $data['total'] += $data['shipping'];

                $coupon = session()->get('discount', []);

                $data['coupon'] = $coupon;

                $data['total'] -= floatval($coupon['discount'] ?? 0);
            }
            $data['address'] = session()->get('checkout-address');

           return $data;
        }
    }

    public function pagination($list, $routeName = "", $page = 0, $limit = 10) {

        $total = $list['total'] ?? 0;

        $lastPage = "";

        if (intval($page - 1) > - 1) {

            if (intval($page - 1) == 0) {

                $lastPage = route($routeName);
            } else {

                $lastPage = route($routeName, ['page' => $page - 1]);
            }
        }

        $nextPage = "";

        if (intval($total / $limit) > $page) {

            $nextPage = route($routeName, ['page' => $page + 1]);
        }

        return ['list' => $list, 'limit' => $limit, 'total' => $total, 'page' => $page, 'lastPage' => $lastPage, 'nextPage' => $nextPage];
    }

    public function ekart() {

        echo env("API_URL");
    }

}
