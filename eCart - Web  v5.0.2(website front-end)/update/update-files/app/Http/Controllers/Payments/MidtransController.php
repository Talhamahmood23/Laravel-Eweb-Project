<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Midtrans;

class MidtransController extends CartController {

    public function index() {

        $this->amount = session()->get('wallet_topup_amount', 0);

        if (floatval($this->amount) == 0) {
            $tmp = session()->get('tmp_payment');
            $amount = floatval($tmp['final_total']);

            $tmp[get('api-params.status')] = get('api-params.order-status.awaiting-payment');

            $order = $this->order_placed($tmp);
        } else {

            $amount = $this->amount;
        }

        $orderId = $order['data']['order_id'] ?? uniqid();

        $transaction_details = [
            'order_id' => $orderId,
            'gross_amount' => $amount
        ];

        $custom_expiry = [
            'start_time' => date("Y-m-d H:i:s O", time()),
            'unit' => 'day',
            'duration' => 2
        ];

        // Send this options if you use 3Ds in credit card request
        $credit_card_option = [
            'secure' => true,
            'channel' => 'migs'
        ];

        $transaction_data = [
            'transaction_details' => $transaction_details,
            // 'item_details' => $item_details,
            // 'customer_details' => $customer_details,
            'expiry' => $custom_expiry,
            'credit_card' => $credit_card_option,
        ];

        $token = Midtrans::getSnapToken($transaction_data);

        return view('payment-gateways.midtrans', compact('token', 'orderId'));
    }

    public function complete(Request $request) {

        $error = "Payment either cancelled / failed to initialize. Try again or try some other payment method. Thank you";

        $amount = session()->get('wallet_topup_amount', 0);
       //$this->isFromWallet=true;
        if (floatval($amount) == 0) {
            $this->isFromWallet = false;
        }
        else{
             $this->isFromWallet = true;
        }
        if ($request->status_code == 200) {

            $paymentMethods = Cache::get('payment_methods');

            $transaction_id = $request->transaction_id;

            $data['status'] = 'received';
            $data['update_order_status'] = '1';
            $data['id'] = $request->orderId;
            if ($this->isFromWallet == false) {
                $order = $this->post('order-process', ['data' => $data]);

                $response = $this->add_transaction($request->orderId, $paymentMethods, $transaction_id, true, $request->status_message, $request->amount);

                return redirect()->route('my-orders')->with('suc', $response['message']);
            
        } else {
            $this->message = session()->get('wallet_topup_message', 0);
            //dd($this->message);
            $response = $this->topup_wallet($amount, "Midtrans Wallet" );

            if ($response['error'] == false) {

                return redirect()->route('wallet-history')->with('suc', $response['message'] ?? '');
            } else {

                $error = $response['message'];
            }
        }

        if ($this->isFromWallet) {
            return redirect()->route('wallet-history')->with('err', $error);
        } else {
            return redirect()->route('checkout-payment')->with('err', $error);
        }
    }
    }

    public function cancel(Request $request) {

        $error = "Payment either cancelled / failed to initialize. Try again or try some other payment method. Thank you";

        if (isset($request->orderId)) {
            $data['delete_order'] = '1';
            $data['order_id'] = $request->orderId;
            $response = $this->post('order-process', ['data' => $data]);
            return redirect()->route('my-orders')->with('suc', $response['message']);
        } else {
            return redirect()->route('checkout-payment')->with('err', $error);
        }
        return redirect()->route('checkout-payment')->with('err', $error);
    }

}
