<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class SavelaterController extends Controller {

    public function index() {
        echo \GuzzleHttp\json_encode($this->post('products', ['data' => ['get_all_products_name' => '1']]));
    }

    public function saveforlater($varient_id) {
        if (!isLoggedIn()) {

            return redirect()->route('home')->with('error_code', 5);
        } else {

            $data = ['add_save_for_later' => 1, 'user_id' => session()->get('user')['user_id'], 'product_variant_id' => $varient_id];
            $result = $this->post('cart', ['data' => $data]);

            if (!$result) {
                return redirect()->back()
                                ->with('err', $result['message']);
            } else {
                if ($result != NULL) {
                    $product = $result;
                     $data1 = $this->getCart();
                    $totalcart = count($data1['cart']);
                    $subtotal = $data1['subtotal'];
                    $tax_amount = $data1['tax_amount'] ?? ' ';
                    $shipping = $data1['shipping'] ?? ' ';
                    $total = $data1['total'] ?? ' ';
                    $saved_price = $data1['saved_price'] ?? ' ';
                    echo json_encode(array(
                        'varient_id' => $varient_id,
                        'currency' => (Cache::has('currency') ? Cache::get('currency') : ''),
                        'product' => $product,
                        'totalcart' => $totalcart,
                        'subtotal' => $subtotal,
                        'tax_amount' => $tax_amount,
                        'shipping' => $shipping,
                        'total' => $total,
                        'saved_price' => $saved_price,
                        'subtotal_msg' => __('msg.subtotal'),
                        'tax_msg' => __('msg.tax'),
                        'delivery_charge_msg' => __('msg.delivery_charge'),
                        'discount_msg' => __('msg.discount'),
                        'total_msg' => __('msg.total'),
                        'delete_all_msg' => __('msg.delete_all'),
                        'checkout_msg' => __('msg.checkout'),
                        'saved_price_msg' => __('msg.saved_price'),
                        'continue_shopping' => __('msg.continue_shopping'),
                        'empty_card_img' => asset('images/empty-cart.png'),
                        'you_must_have_to_purchase' => __('msg.you_must_have_to_purchase'),
                        'to_place_order' => __('msg.to_place_order'),
                        'you_can_get_free_delivery_by_shopping_more_than' => __('msg.you_can_get_free_delivery_by_shopping_more_than'),
                        'min_order_amount' => Cache::get('min_order_amount'),
                        'qty' => __('msg.qty'),
                        'price' => __('msg.price'),
                        'min_amount' => Cache::get('min_amount'),
                        'max_cart_items_count' => Cache::get('max_cart_items_count'),
                        'local_pickup' => Cache::get('local-pickup'),
                        'status' => 'Moved Item to Save for later',
                    ));
                    die;
                    return;
                } else {
                    return redirect()->back()
                                    ->with('err', $result['message']);
                }
            }
        }
    }

    public function movetocart($varient_id) {
        if (!isLoggedIn()) {
            return redirect()->route('home')->with('error_code', 5);
        } else {

            $data = ['remove_save_for_later' => 1, 'user_id' => session()->get('user')['user_id'], 'product_variant_id' => $varient_id];
            $result = $this->post('cart', ['data' => $data]);

            if (!$result) {
                return redirect()->back()
                                ->with('err', $result['message']);
            } else {
                if ($result != NULL) {
                    $product = $result;
                    $data1 = $this->getCart();
                    $totalcart = count($data1['cart']);
                    $subtotal = $data1['subtotal'];
                    $tax_amount = $data1['tax_amount'] ?? ' ';
                    $shipping = $data1['shipping'] ?? ' ';
                    $total = $data1['total'] ?? ' ';
                    $saved_price = $data1['saved_price'] ?? ' ';
                    echo json_encode(array(
                        'varient_id' => $varient_id,
                        'currency' => (Cache::has('currency') ? Cache::get('currency') : ''),
                        'product' => $product,
                        'totalcart' => $totalcart,
                        'subtotal' => $subtotal,
                        'tax_amount' => $tax_amount,
                        'shipping' => $shipping,
                        'subtotal_msg' => __('msg.subtotal'),
                        'tax_msg' => __('msg.tax'),
                        'delivery_charge_msg' => __('msg.delivery_charge'),
                        'discount_msg' => __('msg.discount'),
                        'total_msg' => __('msg.total'),
                        'total' => $total,
                        'saved_price' => $saved_price,
                        'delete_all_msg' => __('msg.delete_all'),
                        'checkout_msg' => __('msg.checkout'),
                        'saved_price_msg' => __('msg.saved_price'),
                        'continue_shopping' => __('msg.continue_shopping'),
                        'empty_card_img' => asset('images/empty-cart.png'),
                        'you_must_have_to_purchase' => __('msg.you_must_have_to_purchase'),
                        'to_place_order' => __('msg.to_place_order'),
                        'you_can_get_free_delivery_by_shopping_more_than' => __('msg.you_can_get_free_delivery_by_shopping_more_than'),
                        'min_order_amount' => Cache::get('min_order_amount'),
                        'qty' => __('msg.qty'),
                        'price' => __('msg.price'),
                        'min_amount' => Cache::get('min_amount'),
                        'max_cart_items_count' => Cache::get('max_cart_items_count'),
                        'local_pickup' => Cache::get('local-pickup'),
                        'status' => 'Moved Item in Cart',
                    ));
                    die;
                    return;
                } else {
                    return redirect()->back()->with('err', $result['message']);
                }
            }
        }
    }

}
