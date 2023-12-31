<?php
header('Access-Control-Allow-Origin: *');
require 'razorpay/Razorpay.php';

header("Content-Type: application/json");
include_once('../includes/custom-functions.php');
$fn = new custom_functions;
include_once('../includes/crud.php');
$db = new Database();
$db->connect();

$config = $fn->get_configurations();
$time_slot_config = $fn->time_slot_config();
$time_zone = $fn->set_timezone($config);
if (!$time_zone) {
    $response['error'] = true;
    $response['message'] = "Time Zone is not set.";
    print_r(json_encode($response));
    return false;
    exit();
}

use Razorpay\Api\Api;

if (isset($_POST) && isset($_POST['accesskey']) && isset($_POST['amount']) && !empty($_POST['amount']) && is_numeric($_POST['amount'])) {
    include_once('../includes/variables.php');
    $order = [];

    $access_key_received = isset($_POST['accesskey']) && !empty($_POST['accesskey']) ? $db->escapeString($fn->xss_clean($_POST['accesskey'])) : '';
    if ($access_key_received != $access_key) {
        $order['error'] = true;
        $order['message'] = "Invalid access key passed.";
        echo json_encode($order);
        return false;
        exit(0);
    }

    $data = $fn->get_settings('payment_methods', true);
    $app_settings = $fn->get_settings('system_timezone', true);
    // print_r($data);
    $app_name = $app_settings['app_name'];
    $app_name = $fn->xss_clean((strtolower($app_name)));
    $app_name = str_replace('-', '', $app_name);
    $app_name = str_replace(' ', '-', $app_name);

    $key = $data['razorpay_key'];
    $razorpay_secret_key = $data['razorpay_secret_key'];

    if ($data['razorpay_payment_method']) {
        $api = new Api($key, $razorpay_secret_key); /* Razorpay credentials */

        $amount = $db->escapeString($fn->xss_clean($_POST['amount']));
        $receipt = (isset($_POST['receipt']) && !empty($_POST['receipt'])) ? $db->escapeString($fn->xss_clean($_POST['receipt'])) : $app_name . '-' . rand(100, 999);

        $razorpay_order = $api->order->create(
            array(
                'receipt' => $receipt,
                'amount' => $amount,
                'payment_capture' => 1,
                'currency' => 'INR'
            )
        );
        // print_r($razorpay_order->created_at);

        $order['error'] = false;
        $order['message'] = "Order initiated successfully. ";
        $order['id'] = $razorpay_order->id;
        $order['amount'] = $razorpay_order->amount;
        $order['entity'] = $razorpay_order->entity;
        $order['amount_paid'] = $razorpay_order->amount_paid;
        $order['amount_due'] = $razorpay_order->amount_due;
        $order['currency'] = $razorpay_order->currency;
        $order['receipt'] = $razorpay_order->receipt;
        $order['offer_id'] = !empty($razorpay_order->offer_id) ? $razorpay_order->offer_id : "";
        $order['status'] = $razorpay_order->status;
        $order['attempts'] = $razorpay_order->attempts;
        $order['created_at'] = $razorpay_order->created_at;
        echo json_encode($order);
    } else {
        $order['error'] = true;
        $order['message'] = "Order could not be created! Try another method";
        echo json_encode($order);
    }
} else {
    $order['error'] = true;
    $order['message'] = "Please pass all the fields.";
    echo json_encode($order);
}