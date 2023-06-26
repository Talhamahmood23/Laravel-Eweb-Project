<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;


class SslCommerzPaymentController extends CheckoutController
{
    private $amount = 0;
    private $isFromWallet = true;

    public function payViaAjax(Request $request)
    {
       
        $this->amount = $request->wallet_amount ?? '';
        
        $request->session()->put('wallet_topup_amount', $request->wallet_amount);
        
        if (floatval($this->amount) == 0) {
            $this->isFromWallet = false;
            
        }
        $user = $this->post('get-user', ['data' => ['get_user_data' => 1, 'user_id' => session()->get('user')['user_id']]]);
        
        $amount = $this->amount * 100;

        $loggedInUser = session()->get('user');

        $paymentMethods = Cache::get('payment_methods');


        $data = [];

        $cart = $this->getCart();

        $getProductId = $this->getProductId($cart);

        $getQty = $this->getQty($cart);

        $msg = msg('no_product_checkount');

        $return = false;
        if($this->isFromWallet == false){

        if (isset($cart['cart']) && is_array($cart['cart']) && count($cart['cart'])) {

            $data[api_param('place-order')] = api_param('get-val');

            $data[api_param('user-id')] = $loggedInUser['user_id'];

            $data[api_param('tax-percentage')] = $cart['tax'] ?? '';

            $data[api_param('tax-amount')] = $cart['tax_amount'] ?? 0;

            $data[api_param('total')] = $cart['subtotal'];

            $data[api_param('final-total')] = $cart['total'];

            $data[api_param('product-variant-id')] =  $getProductId;


            $data[api_param('quantity')] = $getQty;

            $data[api_param('mobile')] = $loggedInUser['mobile'];

            $data[api_param('delivery-charge')] = $cart['shipping'] ?? 0;


            $data[api_param('delivery-time')] = $request->deliverytime ?? '';

            $data[api_param('payment-method')] = api_param('SSLECOMMERZ');

            $data[api_param('address')] = $this->getAddress();

            $data['address_id'] = $cart['address']->id;

            $data[api_param('latitude')] = 0;

            $data[api_param('longitude')] = 0;

            $coupon = session()->get('discount', []);

            if (is_array($coupon) && count($coupon) && floatval($coupon['discount']) > 0) {

                $data[api_param('promo-code')] = $coupon['promo_code'];

                $data[api_param('promo-discount')] = $coupon['discount'];
            }

            $data[api_param('email')] = $loggedInUser['email'];

            $data[api_param('wallet-used')] = $request->wallet_used ?? "false";

           if ($data[api_param('wallet-used') ] == "true")
            {
                $data[api_param('wallet-balance') ] = $request->wallet_balance??0;

                if (floatval($user['balance']))
                {

                    if (floatval($user['balance']) > floatval($data[api_param('final-total') ]))
                    {

                        $data[api_param('final-total') ] = 0;

                    }
                    else
                    {

                        $data[api_param('final-total') ] = floatval($data[api_param('final-total') ]) - floatval($user['balance']);

                    }

                }

            }
            else
            {

                $data[api_param('wallet-balance') ] = 0;

            }

            $data[api_param('final-total') ] = $data[api_param('final-total') ];


            $request->session()
                ->put('tmp_sslecommerz', $data);
        }
        }
        else{
            $data[api_param('final-total')] = $this->amount;
            
        }

        //dd($paymentMethods);
        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.
        //$data = $request->session()->get('tmp_sslecommerz');

        $post_data = array();
        $post_data['total_amount'] = $data['final_total']; # You cant not pay less than 10
        
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function success(Request $request)
    {
        echo "Transaction is Successful";
        
         $this->amount = session()->get('wallet_topup_amount', 0);
         
        if(floatval($this->amount) == 0){
            $this->isFromWallet = false;
        }

        $error = "Payment either cancelled / failed to initialize. Try again or try some other payment method. Thank you";

        $amount = 0;

        #Check order status in order tabel against the transaction id or order id.

        $data = $request->session()->get('tmp_sslecommerz');

        $amount = $data['final_total'];
        $msg = "Payment completed successfully";
        $orderId = "";
        if($this->isFromWallet == false){
        $response = $this->order_placed($request->session()->get('tmp_sslecommerz'));

        $orderId = $response['data']['order_id'] ?? "";
        $transaction_id = uniqid();
        if (intval($orderId)) {
            $this->add_transaction($response['data']['order_id'], "tmp_sslecommerz", $transaction_id, true, $msg, $amount);
            return redirect()->route('my-orders')
                ->with('suc', $response['message'] ?? $msg);
        }

        $this->add_transaction($orderId, "tmp_sslecommerz", $transaction_id, false, $msg, $amount);
        return redirect()->route('checkout-payment')
            ->with('err', $response['message'] ?? $msg);
        }
        else{
            $response = $this->topup_wallet($this->amount, "sslecommerz");

                        if($response['error'] == false){

                            return redirect()->route('wallet-history')->with('suc', $response['message'] ?? '');

                        }else{

                            $error = $response['message'];
                        }
        }
    }

    public function fail(Request $request)
    {

        return redirect()->route('checkout-payment')->with('err', 'Order Failed. Please Try Again');
    }
}
