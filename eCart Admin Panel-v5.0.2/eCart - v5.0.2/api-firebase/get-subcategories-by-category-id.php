<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once('../includes/crud.php');
$db = new Database();
$db->connect();
include_once('../includes/variables.php');
include_once('verify-token.php');
include_once('../includes/custom-functions.php');
$fn = new custom_functions;

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

/* 
1.get-subcategories-by-category-id.php
    accesskey:90336 
    category_id:28 
    limit:10    // {optional}
    offset:0    // {optional}
*/

if (!verify_token()) {
    return false;
}
if (isset($_POST['accesskey']) && isset($_POST['category_id'])) {

    $access_key_received = $db->escapeString($fn->xss_clean($_POST['accesskey']));
    $category_id = $db->escapeString($fn->xss_clean($_POST['category_id']));
    $limit = (isset($_POST['limit']) && !empty($_POST['limit']) && is_numeric($_POST['limit'])) ? $db->escapeString($fn->xss_clean($_POST['limit'])) : 10;
    $offset = (isset($_POST['offset']) && !empty($_POST['offset']) && is_numeric($_POST['offset'])) ? $db->escapeString($fn->xss_clean($_POST['offset'])) : 0;

    if ($access_key_received == $access_key) {
        $sql_query = "SELECT *,(SELECT name FROM category c WHERE subcategory.category_id=c.id) as category_name FROM subcategory WhERE category_id='" . $category_id . "' ORDER BY row_order + 0 ASC";
        $db->sql($sql_query);
        $res = $db->getResult();
        $db->disconnect();
        if (!empty($res)) {
            for ($i = 0; $i < count($res); $i++) {
                $res[$i]['image'] = (!empty($res[$i]['image'])) ? DOMAIN_URL . '' . $res[$i]['image'] : '';
            }
            $response['error'] = false;
            $response['message'] = "Categories retrived successfully!";
            $response['data'] = $res;
        } else {
            $response['error'] = true;
            $response['message'] = "No data found!";
        }
        print_r(json_encode($response));
    } else {
        $response['error'] = true;
        $response['message'] = "accesskey is incorrect.";
        print_r(json_encode($response));
    }
} else {
    $response['error'] = true;
    $response['message'] = "accesskey and category id are required.";
    print_r(json_encode($response));
}
