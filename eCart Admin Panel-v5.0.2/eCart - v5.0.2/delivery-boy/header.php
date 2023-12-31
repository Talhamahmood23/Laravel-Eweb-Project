<?php
if (!isset($_SESSION['delivery_boy_id']) && !isset($_SESSION['name'])) {
    header("location:index.php");
}
include_once('../includes/crud.php');
$db = new Database();
$db->connect();
$db->sql("SET NAMES 'utf8'");

include('../includes/variables.php');
include_once('../includes/custom-functions.php');

$fn = new custom_functions();
$config = $fn->get_configurations();
$time_zone = $fn->set_timezone($config);
if (!$time_zone) {
    $response['error'] = true;
    $response['message'] = "Time Zone is not set.";
    print_r(json_encode($response));
    return false;
    exit();
}

$settings['app_name'] = $config['app_name'];
$words = explode(" ", $settings['app_name']);
$acronym = "";
foreach ($words as $w) {
    $acronym .= $w[0];
}
$currency = $fn->get_settings('currency');
$settings['currency'] = $currency;
$logo = $fn->get_settings('logo');

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/ico" href="<?= '../dist/img/' . $logo ?>">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link href="../dist/css/multiple-select.css" rel="stylesheet" />
    <!-- folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../dist/css/print.css" type="text/css" media="print">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
    <script src="../plugins/jQuery/jquery-3.3.1.min.js"></script>
    <script src="../plugins/jQueryUI/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            var date = new Date();
            var currentMonth = date.getMonth() - 10;
            var currentDate = date.getDate();
            var currentYear = date.getFullYear() - 10;

            $('.datepicker').datepicker({
                minDate: new Date(currentYear, currentMonth, currentDate),
                dateFormat: 'yy-mm-dd',
            });
        });
    </script>
    <script language="javascript">
        function printpage() {
            window.print();
        }
    </script>
    <link rel="stylesheet" href="../plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap-table.css" />
    <link rel="stylesheet" href="../bootstrap/css/bootstrap-table-filter-control.css" />

    <link rel="stylesheet" href="../dist/css/jquery.fancybox.min.css" />
    <script src="../dist/js/jquery.fancybox.min.js"></script>

    <link href="../plugins/select2/select2.min.css" rel="stylesheet" />
    <script src="../plugins/select2/select2-4.0.6.min.js"></script>

    <link rel="stylesheet" href="../dist/css/lightbox.min.css">
    <script src="../dist/js/lightbox.min.js"></script>
</head>

<body class="hold-transition skin-blue fixed sidebar-mini sidebar-collapse">
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a href="home.php" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">
                    <h2><?= $acronym ?></h2>
                </span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">
                    <h3><?= $settings['app_name'] ?></h3>
                </span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <?php
                        $sql_query = "SELECT * FROM `delivery_boys` where id=" . $_SESSION['delivery_boy_id'];
                        $db->sql($sql_query);
                        $result = $db->getResult();
                        foreach ($result as $row) {
                            $user = $row['name'];
                            $email = $row['mobile'];
                        ?>
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="../images/avatar.png" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?= $_SESSION['name']; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="../images/avatar.png" class="img-circle" alt="User Image">
                                        <p>
                                            <?= $_SESSION['name']; ?>
                                        </p>
                                    </li>
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="delivery-boy-profile.php" class="btn btn-default btn-flat"> Edit Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="logout.php" class="btn btn-default btn-flat">Log out</a>
                                        </div>
                                    </li>
                                    <!-- Menu Body -->
                                    <!-- Menu Footer-->
                                </ul>
                            </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <!-- <div class="user-panel">
                    <div class="pull-left image">
                      <img src="images/avatar.png" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                      <p><? //=$user;
                            ?></p>
                    <?php } ?>
                      <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                    </div>-->
                <!-- search form -->
                <!--<form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                      <input type="text" name="q" class="form-control" placeholder="Search...">
                      <span class="input-group-btn">
                        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                      </span>
                    </div>
                    </form>-->
                <!-- /.search form -->
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <li class="treeview">
                        <a href="home.php">
                            <i class="fa fa-home" class="active"></i> <span>Home</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="orders.php">
                            <i class="fa fa-shopping-cart"></i>
                            <span>Orders</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="fund-transfers.php">
                            <i class="fa fa-inr"></i>
                            <span>Fund Transfers</span>
                        </a>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>
</body>

</html>