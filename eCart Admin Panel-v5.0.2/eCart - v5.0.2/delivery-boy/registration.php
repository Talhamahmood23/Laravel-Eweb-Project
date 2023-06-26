<?php session_start();
ob_start();
include_once('../includes/crud.php');
$db = new Database;
include_once('../includes/custom-functions.php');
$fn = new custom_functions();
$db->connect();
date_default_timezone_set('Asia/Kolkata');
$sql = "SELECT * FROM settings";
$db->sql($sql);
$res = $db->getResult();
$settings = json_decode($res[5]['value'], 1);
$logo = $fn->get_settings('logo');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/ico" href="<?= DOMAIN_URL . 'dist/img/' . $logo ?>">
    <title>Delivery Boy Registration</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
            folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="../plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
</head>

<body>
    <!-- Content Wrapper. Contains page content -->
    <div class="col-md-4 col-md-offset-4 " style="margin-top:5px;">
        <!-- general form elements -->
        <div class='row'>
            <div class="text-center">
                <img src="<?= '../dist/img/' . $logo; ?>" height="100">
                <h3>Delivery Boy Registration form</h3>
            </div>
            <div class="box box-primary col-md-12">
                <!-- form start -->
                <form method="post" id="add_form" action="db-operation.php" enctype="multipart/form-data">
                    <input type="hidden" id="add_delivery_boy" name="add_delivery_boy" required="" value="1" aria-required="true">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="">Mobile</label>
                        <!-- <input type="text" name="country_code" title="Error Message" pattern="[1-9]{1}[0-9]{9}">  -->
                        <input type="number" class="form-control" name="mobile" minlength="10" maxlength="10">
                    </div>
                    <div class=" form-group">
                        <label for="">Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>

                    <div class="form-group">
                        <label for="">Confirm Password</label>
                        <input type="password" class="form-control" name="confirm_password">
                    </div>
                    <div class="form-group">
                        <label for="">Date Of Birth</label>
                        <input type="date" class="form-control" name="dob" id="dob" required>
                    </div>


                    <div class="form-group">
                        <label for="">Bonus</label>
                        <input type="number" class="form-control" name="bonus" id="bonus" value="10" min="0"><br>
                    </div>
                    <div class="form-group">
                        <label for="">Delivery Boy Bonus Method</label>
                        <select name="bonus_method" class="form-control">

                            <option value="percentage">Percentage</option>
                            <option value="rupees" selected>Rupees</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Driving License</label>
                        <input type="file" name="driving_license" id="driving_license" required /><br>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">National Identity Card</label>
                        <input type="file" name="national_identity_card" id="national_identity_card" required /><br>
                    </div>
                    <div class="form-group">
                        <label for="">Bank's IFSC Code</label>
                        <input type="text" class="form-control" name="ifsc_code" required>
                    </div>
                    <div class="form-group">
                        <label for="">Bank Name</label>
                        <input type="text" class="form-control" name="bank_name" required>
                    </div>
                    <div class="form-group">
                        <label for="">Account Number</label>
                        <input type="text" class="form-control" name="account_number" required>
                    </div>
                    <div class="form-group">
                        <label for="">Bank Account Name</label>
                        <input type="text" class="form-control" name="account_name" required>
                    </div>
                    <div class="form-group">
                        <label for="">Address</label>
                        <textarea name="address" id="address" rows='3' class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Other Payment Information</label>
                        <textarea name="other_payment_info" id="other_payment_info" rows='3' class="form-control"></textarea>
                    </div>


                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" id="submit_btn" name="btnAdd">Add</button>
                        <input type="reset" class="btn-warning btn" value="Clear" />
                        <a href="index.php" class="btn pull-right">Back to Login Page?</a>
                    </div>
                    <div class="form-group">
                        <div id="result" style="display: none;"></div>
                    </div>
                </form>
            </div>
        </div><!-- /.box -->
    </div>
    </div>
    </div>
    </div>
</body>

</html>

<script>
    // $('#pincode_id').select2({
    //     width: 'element',
    //     placeholder: 'type in pincodes to search',

    // });
    $('#add_form').validate({
        ignore: [],
        debug: false,
        rules: {
            name: "required",
            mobile: "required",
            password: "required",
            address: "required",
            confirm_password: {
                required: true,
                equalTo: "#password"
            }
        }
    });
</script>

<script>
    $('#add_form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        if ($("#add_form").validate().form()) {
            if (confirm('Are you sure?Want to Add Delivery Boy')) {
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    beforeSend: function() {
                        $('#submit_btn').html('Please wait..');
                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(result) {
                        console.log(result);
                        $('#result').html(result);
                        $('#result').show().delay(6000).fadeOut();
                        $('#submit_btn').html('Submit');
                        $('#add_form')[0].reset();
                        // $('#pincode_id').val(null).trigger('change');
                        // $('#pincode_id').select2({
                        //     placeholder: "type in pincode to search"
                        // });
                        setTimeout(function() {
                            window.location = "../delivery-boy/";
                        }, 5000);
                    }
                });
            }
        }
    });
</script>