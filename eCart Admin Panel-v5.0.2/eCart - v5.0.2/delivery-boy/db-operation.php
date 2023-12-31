<?php
session_start();
include('../includes/crud.php');
$db = new Database();
$db->connect();
$db->sql("SET NAMES 'utf8'");

include_once('../includes/custom-functions.php');
$fn = new custom_functions;
$config = $fn->get_configurations();
$time_zone = $fn->set_timezone($config);
if (!$time_zone) {
    $response['error'] = true;
    $response['message'] = "Time Zone is not set.";
    print_r(json_encode($response));
    return false;
    exit();
}
if (ALLOW_MODIFICATION == 0 && !defined(ALLOW_MODIFICATION)) {
    echo '<label class="alert alert-danger">This operation is not allowed in demo panel!.</label>';
    return false;
}

if (isset($_POST['update_delivery_boy']) && isset($_POST['delivery_boy_id'])) {
    $id = $db->escapeString($fn->xss_clean($_POST['delivery_boy_id']));
    if (isset($_POST['old_password']) && $_POST['old_password'] != '') {
        $old_password = md5($_POST['old_password']);
        $sql = "SELECT `password` FROM delivery_boys WHERE id=" . $id;
        $db->sql($sql);
        $res = $db->getResult();
        if ($res[0]['password'] != $old_password) {
            echo "<label class='alert alert-danger'>Old password does't match.</label>";
            return false;
        }
    }
    if ($_POST['update_password'] != '' && $_POST['old_password'] == '') {
        echo "<label class='alert alert-danger'>Please enter old password.</label>";
        return false;
    }
    $name = $db->escapeString($fn->xss_clean($_POST['update_name']));
    $password = !empty($_POST['update_password']) ? $db->escapeString($fn->xss_clean($_POST['update_password'])) : '';
    // $password = '12345678';
    $address = $db->escapeString($fn->xss_clean($_POST['update_address']));
    $password = !empty($password) ? md5($password) : '';
    $update_dob = $db->escapeString($fn->xss_clean($_POST['update_dob']));
    $update_bank_name = $db->escapeString($fn->xss_clean($_POST['update_bank_name']));
    $update_account_number = $db->escapeString($fn->xss_clean($_POST['update_account_number']));
    $update_account_name = $db->escapeString($fn->xss_clean($_POST['update_account_name']));
    $update_ifsc_code = $db->escapeString($fn->xss_clean($_POST['update_ifsc_code']));
    $update_other_payment_info = !empty($_POST['update_other_payment_info']) ? $db->escapeString($fn->xss_clean($_POST['update_other_payment_info'])) : '';


    if ($_FILES['update_driving_license']['size'] != 0 && $_FILES['update_driving_license']['error'] == 0 && !empty($_FILES['update_driving_license'])) {
        $dr_image = $db->escapeString($fn->xss_clean($_POST['dr_image1']));
        $result = $fn->validate_image($_FILES["update_driving_license"]);
        if ($result) {
            echo " <span class='label label-danger'>Driving License image type must jpg, jpeg, gif, or png!</span>";
            return false;
            exit();
        }
        $target_path = '../upload/delivery-boy/';
        $dr_filename = microtime(true) . '.' . strtolower($extension);
        $dr_full_path = $target_path . "" . $dr_filename;
        if (!move_uploaded_file($_FILES["update_driving_license"]["tmp_name"], $dr_full_path)) {
            echo '<p class="alert alert-danger">Can not upload image.</p>';
            return false;
            exit();
        }
        if (!empty($dr_image)) {
            unlink($target_path . $dr_image);
        }
        $sql = "UPDATE delivery_boys SET `driving_license`='" . $dr_filename . "' WHERE `id`=" . $id;
        $db->sql($sql);
    }
    if ($_FILES['update_national_identity_card']['size'] != 0 && $_FILES['update_national_identity_card']['error'] == 0 && !empty($_FILES['update_national_identity_card'])) {
        $nic_image = $db->escapeString($fn->xss_clean($_POST['nic_image']));
        $result = $fn->validate_image($_FILES["update_national_identity_card"]);
        if ($result) {
            echo " <span class='label label-danger'>National Identity Card image type must jpg, jpeg, gif, or png!</span>";
            return false;
            exit();
        }
        $target_path = '../upload/delivery-boy/';
        $nic_filename = microtime(true) . '.' . strtolower($extension);
        $nic_full_path = $target_path . "" . $nic_filename;
        if (!move_uploaded_file($_FILES["update_national_identity_card"]["tmp_name"], $nic_full_path)) {
            echo '<p class="alert alert-danger">Can not upload image.</p>';
            return false;
            exit();
        }
        if (!empty($nic_image)) {
            unlink($target_path . $nic_image);
        }
        $sql = "UPDATE delivery_boys SET `national_identity_card`='" . $nic_filename . "' WHERE `id`=" . $id;
        $db->sql($sql);
    }

    if (!empty($password)) {
        $sql = "Update delivery_boys set `name`='" . $name . "',password='" . $password . "',`address`='" . $address . "' ,`dob`='$update_dob',`bank_account_number`='$update_account_number',`bank_name`='$update_bank_name',`account_name`='$update_account_name',`ifsc_code`='$update_ifsc_code',`other_payment_information`='$update_other_payment_info' where `id`=" . $id;
    } else {
        $sql = "Update delivery_boys set `name`='" . $name . "',`address`='" . $address . "',`dob`='$update_dob',`bank_account_number`='$update_account_number',`bank_name`='$update_bank_name',`account_name`='$update_account_name',`ifsc_code`='$update_ifsc_code',`other_payment_information`='$update_other_payment_info' where `id`=" . $id;
    }
    if ($db->sql($sql)) {
        echo "<label class='alert alert-success'>Information Updated Successfully.</label>";
    } else {
        echo "<label class='alert alert-danger'>Some Error Occurred! Please Try Again.</label>";
    }
}



if (isset($_POST['add_delivery_boy']) && $_POST['add_delivery_boy'] == 1) {

    // if (!checkadmin($auth_username)) {
    //     echo "<label class='alert alert-danger'>Access denied - You are not authorized to access this page.</label>";
    //     return false;
    // }
    // if ($permissions['delivery_boys']['create'] == 0) {
    //     echo '<label class="alert alert-danger">You have no permission to create delivery boy</label>';
    //     return false;
    // }

    $name = $db->escapeString($fn->xss_clean($_POST['name']));

    $mobile = $db->escapeString($fn->xss_clean($_POST['mobile']));
    $address = $db->escapeString($fn->xss_clean($_POST['address']));
    $bonus = $db->escapeString($fn->xss_clean($_POST['bonus']));
    $dob = $db->escapeString($fn->xss_clean($_POST['dob']));
    $bank_name = $db->escapeString($fn->xss_clean($_POST['bank_name']));
    $bonus_method = $db->escapeString($fn->xss_clean($_POST['bonus_method']));
    $other_payment_info = (isset($_POST['other_payment_info']) && !empty($_POST['other_payment_info'])) ? $db->escapeString($fn->xss_clean($_POST['other_payment_info'])) : '';
    $account_number = $db->escapeString($fn->xss_clean($_POST['account_number']));
    $account_name = $db->escapeString($fn->xss_clean($_POST['account_name']));
    $ifsc_code = $db->escapeString($fn->xss_clean($_POST['ifsc_code']));
    $password = $db->escapeString($fn->xss_clean($_POST['password']));
    $password = md5($password);
    $sql = 'SELECT id FROM delivery_boys WHERE mobile=' . $mobile;
    $db->sql($sql);
    $res = $db->getResult();
    $count = $db->numRows($res);
    if ($count > 0) {
        echo '<label class="alert alert-danger">Mobile Number Already Exists!</label>';
        return false;
    }
    $target_path = '../upload/delivery-boy/';
    if ($_FILES['driving_license']['error'] == 0 && $_FILES['driving_license']['size'] > 0) {
        if (!is_dir($target_path)) {
            mkdir($target_path, 0777, true);
        }
        $extension = pathinfo($_FILES["driving_license"]["name"])['extension'];
        $result = $fn->validate_image($_FILES["driving_license"]);
        if ($result) {
            echo " <span class='label label-danger'>Driving License image type must jpg, jpeg, gif, or png!</span>";
            return false;
            exit();
        }

        $dr_filename = microtime(true) . '.' . strtolower($extension);
        $dr_full_path = $target_path . "" . $dr_filename;
        if (!move_uploaded_file($_FILES["driving_license"]["tmp_name"], $dr_full_path)) {
            echo "<p class='alert alert-danger'>Invalid directory to load image!</p>";
            return false;
        }
    }
    if ($_FILES['national_identity_card']['error'] == 0 && $_FILES['national_identity_card']['size'] > 0) {
        if (!is_dir($target_path)) {
            mkdir($target_path, 0777, true);
        }
        $extension = pathinfo($_FILES["national_identity_card"]["name"])['extension'];
        $result = $fn->validate_image($_FILES["national_identity_card"]);
        if ($result) {
            echo " <span class='label label-danger'>National Identity Card image type must jpg, jpeg, gif, or png!</span>";
            return false;
            exit();
        }

        $nic_filename = microtime(true) . '.' . strtolower($extension);
        $nic_full_path = $target_path . "" . $nic_filename;
        if (!move_uploaded_file($_FILES["national_identity_card"]["tmp_name"], $nic_full_path)) {
            echo "<p class='alert alert-danger'>Invalid directory to load image!</p>";
            return false;
        }
    }
    $sql = "INSERT INTO delivery_boys (`name`,`mobile`,`password`,`address`,`bonus`, `driving_license`, `national_identity_card`, `dob`, `bank_account_number`, `bank_name`, `account_name`, `ifsc_code`,`other_payment_information`,`bonus_method`) VALUES ('$name', '$mobile', '$password', '$address','$bonus','$dr_filename', '$nic_filename', '$dob','$account_number','$bank_name','$account_name','$ifsc_code','$other_payment_info','$bonus_method')";
    if ($db->sql($sql)) {
        echo '<label class="alert alert-success">Delivery Boy Added Successfully!</label>';
    } else {
        echo '<label class="alert alert-danger">Some Error Occrred! please try again.</label>';
    }
}
