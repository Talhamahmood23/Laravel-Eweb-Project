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
    <title>Manager App Privacy-Policy | <?= $settings['app_name'] ?> - Dashboard</title>
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

    $sql = "SELECT value FROM settings where variable='manager_app_privacy_policy'";
    $db->sql($sql);
    $res_privacy = $db->getResult();
    $message = '';
    if (isset($_POST['btn_update'])) {
        if(ALLOW_MODIFICATION==0 && !defined (ALLOW_MODIFICATION)){
            echo '<label class="alert alert-danger">This operation is not allowed in demo panel!.</label>';
            return false;
        }
        if ($permissions['settings']['update'] == 1) {
            if (!empty($_POST['privacy_policy'])  || !empty($_POST['terms_conditions'])) {

                $privacy_policy = $db->escapeString($fn->xss_clean($_POST['privacy_policy']));
                $terms_conditions=$db->escapeString($fn->xss_clean($_POST['terms_conditions']));

                if (empty($res_privacy)) {
                    $sql1 = "INSERT INTO settings (variable,value) VALUES ('manager_app_privacy_policy','" . $privacy_policy . "')";
                } else {
                    $sql1 = "UPDATE `settings` SET `value`='" . $privacy_policy . "' WHERE `variable` = 'manager_app_privacy_policy'";
                }
                
                $sql = "SELECT value FROM settings where variable='manager_app_terms_conditions'";
                $db->sql($sql);
                $res_terms = $db->getResult();
                
               if(empty($res_terms)){
                    $sql = "INSERT INTO settings (variable,value) VALUES ('manager_app_terms_conditions','".$terms_conditions."')";
                }else{
                    $sql = "UPDATE `settings` SET `value`='".$terms_conditions."' WHERE `variable` = 'manager_app_terms_conditions'";
                }
                if($db->sql($sql1) && $db->sql($sql)){
                    $message .= "<div class='alert alert-success'> Information Updated Successfully!</div>";
                }else{
                    $message .= "<div class='alert alert-danger'> Information not Updated!</div>";
                }                
            }
        } else {
            $message .= "<label class='alert alert-danger'>You have no permission to update settings</label>";
        }
    }
    ?>
    <section class="content-header">
        <h1>Manager App Privacy Policy</h1>
        <h4><?= $message ?></h4>
        <ol class="breadcrumb">
            <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
        </ol>
        <hr />
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-4" style="margin-bottom:10px;"></div>
            <div class="col-md-4" style="margin-bottom:10px;">
                <?php if ($permissions['settings']['read'] == 1) { ?>
                    <a href='manager-app-play-store-privacy-policy.php' target='_blank' class='btn btn-primary btn-sm'>Manager App Privacy Policy Page for Play Store</a>
                <?php } ?>
            </div>
            <div class="col-md-4" style="margin-bottom:10px;">
                <?php if($permissions['settings']['read']==1){?>
                <a href='manager-app-play-store-terms-conditions.php' target='_blank' class='btn btn-primary btn-sm'>Manager App Terms Conditions Page for Play Store</a>
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
                            <h3 class="box-title">Update Privacy Policy</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->


                        <form method="post" enctype="multipart/form-data">
                            <?php
                            $sql = "SELECT value FROM settings where variable='manager_app_privacy_policy'";
                            $db->sql($sql);
                            $res_privacy = $db->getResult();
                            ?>
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="app_name">Privacy Policy:</label><i class="address_note"></i>
                                    <textarea class="form-control addr_editor" name="privacy_policy" id="privacy_policy" required><?= !empty($res_privacy) ? $res_privacy[0]['value'] : ''; ?></textarea>
                                </div>
                                <div class="box-header with-border">
                                    <h3 class="box-title">Update Terms Conditions</h3>
                                </div>
                                <?php
                                $sql = "SELECT value FROM settings where variable='manager_app_terms_conditions'";
                                $db->sql($sql);
                                $res_terms = $db->getResult();
                                ?>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="app_name">Terms & Conditions:</label><i class="address_note"></i>
                                        <textarea class="form-control addr_editor" name="terms_conditions" id="terms_conditions" required><?= !empty($res_terms) ? $res_terms[0]['value'] : ''; ?></textarea>
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
<script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        ltr = '<svg width="20" height="20"><path d="M11 5h7a1 1 0 010 2h-1v11a1 1 0 01-2 0V7h-2v11a1 1 0 01-2 0v-6c-.5 0-1 0-1.4-.3A3.4 3.4 0 017.8 10a3.3 3.3 0 010-2.8 3.4 3.4 0 011.8-1.8L11 5zM4.4 16.2L6.2 15l-1.8-1.2a1 1 0 011.2-1.6l3 2a1 1 0 010 1.6l-3 2a1 1 0 11-1.2-1.6z" fill-rule="evenodd"></path></svg>';
        rtl = '<svg width="20" height="20"><path d="M8 5h8v2h-2v12h-2V7h-2v12H8v-7c-.5 0-1 0-1.4-.3A3.4 3.4 0 014.8 10a3.3 3.3 0 010-2.8 3.4 3.4 0 011.8-1.8L8 5zm12 11.2a1 1 0 11-1 1.6l-3-2a1 1 0 010-1.6l3-2a1 1 0 111 1.6L18.4 15l1.8 1.2z" fill-rule="evenodd"></path></svg>';
        html = '( Use ' + ltr + ' for LTR and use ' + rtl + ' for RTL )';
        $('.address_note').append(html);
    });
</script>