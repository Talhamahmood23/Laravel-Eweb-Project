<section class="content-header">
    <h1>eCart Purchase Code <a href='purchase-code.php'></h1>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">



    <div class="row">
        <?php
        $isAuthWeb = $fn->get_settings('doctor_brown');
        if (!empty($isAuthWeb)) {

        ?>
            <div class="col-sm-4">
                <p class="alert alert-success"> Website is Already registerd!</p>
            </div>
            <div class="col-sm-4">
                <button type="submit" class="btn btn-primary" name="webDeregister" id="webDeregister" value="29260418">De-register web</button>
            </div>

    </div>
    <div class="row">
        <br><br>
        <div class="col-sm-4">
            <div><br>
                <p id="result_success_web" class="alert alert-success"></p>
            </div>
            <div><br>
                <p id="result_fail_web" class="alert alert-danger"></p>
            </div>
        </div>

    <?php } else { ?>

        <div class="col-md-6">
            <!-- general form elements -->
            <!-- website -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Validate the authentic purchase of website</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <form id="validate_code_website" method="GET">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter the Purchase Code shared by the customer for eCart</label>
                            <input type="text" class="form-control" id="purchase_code_web" name="purchase_code_web" placeholder="Enter the purchase code here" required>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="webValidate" id="webValidate">Validate Now</button>
                            <input type="reset" class="btn btn-warning" value="Clear" />
                            <div class="form-group">
                                <div><br>
                                    <p id="result_success_web" class="alert alert-success"></p>
                                </div>
                                <div><br>
                                    <p id="result_fail_web" class="alert alert-danger"></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.box -->
        </div>

    <?php } ?>
    </div>
    <div class="row">

        <?php
        $isAuthWeb = $fn->get_settings('doctor_brown_customer');
        if (!empty($isAuthWeb)) {

        ?>
            <div class="col-sm-4">
                <p class="alert alert-success"> Customer app is Already registerd!</p>
            </div>
            <div class="col-sm-4">
                <button type="submit" class="btn btn-primary" name="custDeregister" id="custDeregister" value="22015911">De-register app</button>
            </div>
    </div>
    <div class="row">
        <br><br>
        <div class="col-sm-4">
            <div><br>
                <p id="result_success_cust" class="alert alert-success"></p>
            </div>
            <div><br>
                <p id="result_fail_cust" class="alert alert-danger"></p>
            </div>
        </div>


    <?php } else { ?>

        <!-- customer app -->
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Validate the authentic purchase of customer app</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <form id="validate_code_customer" method="GET">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter the Purchase Code shared by the customer for eCart</label>
                            <input type="text" class="form-control" id="purchase_code_cust" name="purchase_code_cust" placeholder="Enter the purchase code here" required>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="custValidate" id="custValidate">Validate Now</button>
                            <input type="reset" class="btn btn-warning" value="Clear" />
                            <div class="form-group">
                                <div><br>
                                    <p id="result_success_cust" class="alert alert-success"></p>
                                </div>
                                <div><br>
                                    <p id="result_fail_cust" class="alert alert-danger"></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.box -->
        </div>
    <?php } ?>
    </div>

    <!-- admin app -->
    <div class="row">
        <?php
        $isAuthWeb = $fn->get_settings('doctor_brown_admin');
        if (!empty($isAuthWeb)) {

        ?>
            <div class="col-sm-4">
                <p class="alert alert-success"> Admin app is Already registerd!</p>
            </div>
            <div class="col-sm-4">
                <button type="submit" class="btn btn-primary" name="adminDeregister" id="adminDeregister" value="30288442">De-register app</button>
            </div>
    </div>
    <div class="row">
        <br><br>
        <div class="col-sm-4">
            <div><br>
                <p id="result_success_admin" class="alert alert-success"></p>
            </div>
            <div><br>
                <p id="result_fail_admin" class="alert alert-danger"></p>
            </div>
        </div>

    <?php } else { ?>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Validate the authentic purchase of admin app</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <form id="validate_code_admin" method="GET">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter the Purchase Code shared by the customer for eCart</label>
                            <input type="text" class="form-control" id="purchase_code_admin" name="purchase_code_admin" placeholder="Enter the purchase code here" required>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="adminValidate" id="adminValidate">Validate Now</button>
                            <input type="reset" class="btn btn-warning" value="Clear" />
                            <div class="form-group">
                                <div><br>
                                    <p id="result_success_admin" class="alert alert-success"></p>
                                </div>
                                <div><br>
                                    <p id="result_fail_admin" class="alert alert-danger"></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.box -->
        </div>
    <?php } ?>
    </div>
</section>

<div class="separator"> </div>
<script src="dist/js/jquery.validate.min.js"></script>
<script>
    var domain_url = '<?= DOMAIN_URL ?>';
</script>
<script src="dist/js/covert.js"></script>
<script src="dist/js/de-register.js"></script>
<?php $db->disconnect(); ?>