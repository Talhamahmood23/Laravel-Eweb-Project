<?php

session_start();

// set time for session timeout
$currentTime = time() + 25200;
$expired = 3600;

// if session not set go to login page
if (!isset($_SESSION['user'])) {
    header("location:index.php");
}

// if current time is more than session timeout back to login page
if ($currentTime > $_SESSION['timeout']) {
    session_destroy();
    header("location:index.php");
}

// destroy previous session timeout and create new one
unset($_SESSION['timeout']);
$_SESSION['timeout'] = $currentTime + $expired;
include "header.php"; ?>
<html>

<head>
    <title>Front End Policies | <?= $settings['app_name'] ?> - Dashboard</title>
    <style>
        .asterik {
            font-size: 20px;
            line-height: 0px;
            vertical-align: middle;
        }

        .tox .tox-menubar {
            background-color: #e7e8e7;
            display: flex;
            flex: 0 0 auto;
            flex-shrink: 0;
            flex-wrap: wrap;
            padding: 0 4px 0 4px;
        }

        .tox .tox-notification--warn,
        .tox .tox-notification--warning {
            background-color: #fffaea;
            border-color: #ffe89d;
            color: #222f3e;
            display: none;
        }
    </style>
</head>
</body>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?php
    include_once('includes/custom-functions.php');
    $fn = new custom_functions;

    $sql = "SELECT value FROM settings where variable='refund_policy'";
    $db->sql($sql);
    $res_refund = $db->getResult();
    $message = '';
    if (isset($_POST['btn_update'])) {
        if (ALLOW_MODIFICATION == 0 && !defined(ALLOW_MODIFICATION)) {
            echo '<label class="alert alert-danger">This operation is not allowed in demo panel!.</label>';
            return false;
        }
        if ($permissions['settings']['update'] == 1) {
            if (!empty($_POST['refund_policy']) || !empty($_POST['shipping_policy']) || !empty($_POST['delivery_returns_policy'])) {

                $refund_policy = $db->escapeString($fn->xss_clean($_POST['refund_policy']));
                $shipping_policy = $db->escapeString($fn->xss_clean($_POST['shipping_policy']));
                $delivery_returns_policy = $db->escapeString($fn->xss_clean($_POST['delivery_returns_policy']));

                if (empty($res_refund)) {
                    $sql = "INSERT INTO settings (variable,value) VALUES ('refund_policy','" . $refund_policy . "')";
                } else {
                    $sql = "UPDATE `settings` SET `value`='" . $refund_policy . "' WHERE `variable` = 'refund_policy'";
                }
                $db->sql($sql);
                $sql = "SELECT value FROM settings where variable='shipping_policy'";
                $db->sql($sql);
                $res_shipping = $db->getResult();

                if (empty($res_shipping)) {
                    $sql = "INSERT INTO settings (variable,value) VALUES ('shipping_policy','" . $shipping_policy . "')";
                } else {
                    $sql = "UPDATE `settings` SET `value`='" . $shipping_policy . "' WHERE `variable` = 'shipping_policy'";
                }
                $db->sql($sql);
                $sql = "SELECT value FROM settings where variable='delivery_returns_policy'";
                $db->sql($sql);
                $res_delivery = $db->getResult();

                if (empty($res_delivery)) {
                    $sql = "INSERT INTO settings (variable,value) VALUES ('delivery_returns_policy','$delivery_returns_policy')";
                } else {
                    $sql = "UPDATE `settings` SET `value`='" . $delivery_returns_policy . "' WHERE `variable` = 'delivery_returns_policy'";
                }
                $db->sql($sql);

                $message .= "<div class='alert alert-success'> Information Updated Successfully!</div>";
            }
        } else {
            $message .= "<label class='alert alert-danger'>You have no permission to update settings</label>";
        }
    }
    ?>
    <section class="content-header">
        <h1>Update Refund Policies</h1>
        <h4><?= $message ?></h4>
        <ol class="breadcrumb">
            <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
        </ol>
        <hr />
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-4" style="margin-bottom:10px;"> <?php if ($permissions['settings']['read'] == 1) { ?>
                    <a href='front-end-play-store-delivery-return-policy.php' target='_blank' class='btn btn-primary btn-sm'>Delivery & Returns Policy for Play Store</a>
                <?php } ?>
            </div>
            <div class="col-md-4" style="margin-bottom:10px;">
                <?php if ($permissions['settings']['read'] == 1) { ?>
                    <a href='front-end-play-store-refund-policy.php' target='_blank' class='btn btn-primary btn-sm'>Refund Policy for Play Store</a>
                <?php } ?>
            </div>
            <div class="col-md-4" style="margin-bottom:10px;">
                <?php if ($permissions['settings']['read'] == 1) { ?>
                    <a href='front-end-play-store-shipping-policy.php' target='_blank' class='btn btn-primary btn-sm'>Shipping Policy for Play Store</a>
                <?php } ?>
            </div>
        </div>

        <div class="row">

            <div class="col-md-12">
                <?php if ($permissions['settings']['read'] == 1) {
                    if ($permissions['settings']['update'] == 0) { ?>
                        <div class="alert alert-danger">You have no permission to update settings</div>
                    <?php } ?>

                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Update Refund Policies</h3>
                        </div>
                        <form method="post" enctype="multipart/form-data">
                            <?php
                            $sql = "SELECT value FROM settings where variable='refund_policy'";
                            $db->sql($sql);
                            $res_refund = $db->getResult();
                            ?>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="app_name">Refund Policy:</label><i class="address_note"></i>
                                    <textarea rows="10" cols="10" class="form-control addr_editor" name="refund_policy" id="refund_policy" required><?= !empty($res_refund) ? $res_refund[0]['value'] : ''; ?></textarea>
                                </div>
                                <div class="box-header with-border">
                                    <h3 class="box-title">Update Shipping Policies</h3>
                                </div>
                                <?php
                                $sql = "SELECT value FROM settings where variable='shipping_policy'";
                                $db->sql($sql);
                                $res_shipping = $db->getResult();
                                ?>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="app_name">Shipping Policies:</label><i class="address_note"></i>
                                        <textarea rows="10" cols="10" class="form-control addr_editor" name="shipping_policy" id="shipping_policy" required><?= !empty($res_shipping) ? $res_shipping[0]['value'] : ''; ?></textarea>
                                    </div>
                                </div>
                                <div class="box-header with-border">
                                    <h3 class="box-title">Update Delivery & Return Policies</h3>
                                </div>
                                <?php
                                $sql = "SELECT value FROM settings where variable='delivery_returns_policy'";
                                $db->sql($sql);
                                $res_delivery = $db->getResult();
                                ?>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="app_name">Delivery & Return Policies:</label><i class="address_note"></i>
                                        <textarea rows="10" cols="10" class="form-control addr_editor" name="delivery_returns_policy" id="delivery_returns_policy" required><?= !empty($res_delivery) ? $res_delivery[0]['value'] : ''; ?></textarea>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" class="btn-primary btn" value="Update" name="btn_update" />
                            </div>
                        </form>
                    <?php } else { ?>
                        <div class="alert alert-danger">You have no permission to view settings</div>
                    <?php } ?>

                    </div>
                    <!-- /.box -->
            </div>
        </div>
</div>
</section>
<div class="separator"> </div>
</div><!-- /.content-wrapper -->
</body>

</html>
<?php include "footer.php"; ?>
<script type="text/javascript">
    $(document).ready(function() {
        ltr = '<svg width="20" height="20"><path d="M11 5h7a1 1 0 010 2h-1v11a1 1 0 01-2 0V7h-2v11a1 1 0 01-2 0v-6c-.5 0-1 0-1.4-.3A3.4 3.4 0 017.8 10a3.3 3.3 0 010-2.8 3.4 3.4 0 011.8-1.8L11 5zM4.4 16.2L6.2 15l-1.8-1.2a1 1 0 011.2-1.6l3 2a1 1 0 010 1.6l-3 2a1 1 0 11-1.2-1.6z" fill-rule="evenodd"></path></svg>';
        rtl = '<svg width="20" height="20"><path d="M8 5h8v2h-2v12h-2V7h-2v12H8v-7c-.5 0-1 0-1.4-.3A3.4 3.4 0 014.8 10a3.3 3.3 0 010-2.8 3.4 3.4 0 011.8-1.8L8 5zm12 11.2a1 1 0 11-1 1.6l-3-2a1 1 0 010-1.6l3-2a1 1 0 111 1.6L18.4 15l1.8 1.2z" fill-rule="evenodd"></path></svg>';
        html = '( Use ' + ltr + ' for LTR and use ' + rtl + ' for RTL )';
        $('.address_note').append(html);
    });
</script>