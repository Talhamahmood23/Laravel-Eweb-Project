<?php
// start session
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
include "header.php";
include_once('includes/functions.php');
$allowed = ALLOW_MODIFICATION;
?>
<html>

<head>
    <title> Offers | <?= $settings['app_name'] ?> - Dashboard</title>
    <script src="dist/js/jquery.min.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="content-wrapper">
        <section class="content-header">
            <h1> Offers for Customers</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
            </ol>
            <hr />
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <?php if ($permissions['new_offers']['create'] == 0) { ?>
                        <div class="alert alert-danger">You have no permission to create offers</div>
                    <?php } ?>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Offers here</h3>
                        </div>
                        <form id="offer_form" method="post" action="api-firebase/offer-images.php" enctype="multipart/form-data">
                            <div class="box-body">
                                <input type='hidden' name='accesskey' id='accesskey' value='90336' />
                                <input type='hidden' name='add-image' id='add-image' value='1' />
                                <input type='hidden' name='ajax_call' value='1' />
                                <div class="form-group">
                                    <label for="type">Type :</label>
                                    <select name="type" id="type" class="form-control" required>
                                        <option value="video">Video</option>
                                        <option value="image">Image</option>
                                    </select>
                                </div>

                                <div class="form-group" id="image" style="display:none;">
                                    <label for="offer_type">Offer Type :</label>
                                    <select name="offer_type" id="offer_type" class="form-control" required>
                                        <option value="default">Default</option>
                                        <option value="category">Category</option>
                                        <option value="products">Product</option>
                                        <option value="offer_image_url">Offer URL</option>
                                    </select>
                                </div>

                                <div class="form-group" id="category" style="display:none;">
                                    <label for="category">Categories :</label>
                                    <select name="category" id="category" class="form-control">
                                        <?php
                                        $sql = "SELECT * FROM `category` order by id DESC";
                                        $db->sql($sql);
                                        $categories_result = $db->getResult();
                                        ?>
                                        <?php if ($permissions['categories']['read'] == 1) { ?>
                                            <option value="">Select Category</option>
                                            <?php foreach ($categories_result as $value) { ?>
                                                <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <option value="">Select Category</option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group" id="products" style="display:none;">
                                    <label for="products">Products :</label>
                                    <select name="products" id="products" class="form-control">
                                        <?php

                                        $sql = "SELECT * FROM `products`";
                                        $db->sql($sql);
                                        $products_result = $db->getResult();

                                        ?>
                                        <?php if ($permissions['products']['read'] == 1) { ?>
                                            <option value="">Select Product</option>
                                            <?php foreach ($products_result as $value) { ?>
                                                <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <option value="">Select Product</option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="image">Offer Image / Video (Video Ratio 16:9) :</label>
                                    <input type='file' name="image" id="image" required />
                                </div>

                                <div class="form-group">
                                    <label for="position">Position :</label>
                                    <select name="position" id="position" class="form-control" required>
                                        <option value="top">Top</option>
                                        <option value="below_slider">Below Slider</option>
                                        <option value="below_category">Below Category</option>
                                        <option value="below_flash_sales">Below Flash Sales</option>
                                        <option value="below_section">Below Section</option>
                                    </select>
                                </div>
                                <div class="form-group" id="section_positions" style="display:none;">
                                    <label for="section_position">Section Position :</label>
                                    <select name="section_position" id="section_position" class="form-control">
                                        <?php
                                        $sql = "SELECT * FROM `sections` order by id DESC";
                                        $db->sql($sql);
                                        $section_res = $db->getResult();
                                        ?>
                                        <option value="">Select Section</option>
                                        <?php foreach ($section_res as $value) { ?>
                                            <option value="<?= $value['id'] ?>"><?= $value['title'] ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group" id="link_1" style="display:none;">
                                    <label for="offer_image_url">Link : </label>
                                    <input type="url" placeholder="http://example.com" class="form-control" name="offer_image_url" id="offer_image_url">
                                </div>
                            </div>
                            <div class="box-footer">
                                <input type="submit" id="submit_btn" class="btn-primary btn" value="Upload" />
                            </div>
                        </form>
                        <div id="result"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <?php if ($permissions['new_offers']['read'] == 1) { ?>
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Manage Offer Section</h3>
                            </div>
                            <table id="offers_table" class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=offers" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="type">Type</th>
                                        <th data-field="offer_type">Offer Type</th>
                                        <th data-field="offer_type_id">Type Id</th>
                                        <th data-field="image">Image</th>
                                        <th data-field="offer_image_url">URL</th>
                                        <th data-field="position">Position</th>
                                        <th data-field="section_position">Section Position</th>
                                        <th data-field="status">Status</th>
                                        <th data-field="date_created" data-visible="false">Date Created</th>
                                        <th data-field="operate" data-events="actionEvents">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-danger">You have no permission to view new offer.</div>
                    <?php } ?>
                </div>
            </div>
        </section>
    </div>
    <script>
        var allowed = '<?= $allowed; ?>';

        $("#position").change(function() {
            type = $("#position").val();
            if (type == 'below_section') {
                $("#section_positions").show();
            } else {
                $("#section_positions").hide();
            }
        });

        $('#offer_form').on('submit', function(e) {
            e.preventDefault();
            if (allowed == 0) {
                alert('Sorry! This operation is not allowed in demo panel!.');
                window.location.reload();
                return false;
            }
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                dataType: 'json',
                beforeSend: function() {
                    $('#submit_btn').val('Please wait..').attr('disabled', true);
                },
                cache: false,
                contentType: false,
                processData: false,
                success: function(result) {
                    $('#result').html(result.message);
                    $('#result').show().delay(2000).fadeOut();
                    $('#submit_btn').val('Upload').attr('disabled', false);
                    $('#image').val('');
                    $('#offers_table').bootstrapTable('refresh');
                        location.reload();
                    
                }
            });

        });
    </script>
    <script>
        $(document).on('click', '.delete-offer', function() {
            if (confirm('Are you sure?')) {
                id = $(this).data("id");
                image = $(this).data("image");
                $.ajax({
                    url: 'api-firebase/offer-images.php',
                    type: "get",
                    data: 'accesskey=90336&id=' + id + '&image=' + image + '&type=delete-offer&ajax_call=1',
                    success: function(result) {
                        if (result == 1) {
                            $('#offers_table').bootstrapTable('refresh');
                        }
                        if (result == 2) {
                            alert('You have no permission to delete new offers');
                        }
                        if (result == 0) {
                            alert('Error! offer could not be deleted');

                        }

                    }
                });
            }
        });
    </script>
    <script>
        window.actionEvents = {
            'click .set-offers-deactive': function(e, value, rows, index) {
                var id = $(this).data("id");
                $.ajax({
                    url: 'public/db-operation.php',
                    type: "get",
                    data: 'id=' + id + '&offer_status=1&type=deactive',
                    success: function(result) {
                        if (result == 1)
                            $('#offers_table').bootstrapTable('refresh');
                        else
                            alert('Error! Offers could not be activated.');
                    }
                });

            },
            'click .set-offers-active': function(e, value, rows, index) {
                var id = $(this).data("id");
                $.ajax({
                    url: 'public/db-operation.php',
                    type: "get",
                    data: 'id=' + id + '&offer_status=1&type=active',
                    success: function(result) {
                        if (result == 1)
                            $('#offers_table').bootstrapTable('refresh');
                        else
                            alert('Error! Offers could not be deactivated.');
                    }
                });
            }
        };

        $("#type").change(function() {
            type = $("#type").val();
            if (type == "video") {
                $("#image").hide();
                $("#category").hide();
                $("#products").hide();
            }
            if (type == "image") {
                $("#image").show();
            }
        });

        $("#offer_type").change(function() {
            type = $("#offer_type").val();
            if (type == "default") {
                $("#category").hide();
                $("#products").hide();
                $("#link_1").hide();
            }
            if (type == "category") {
                $("#category").show();
                $("#products").hide();
                $("#link_1").hide();
            }
            if (type == "products") {
                $("#category").hide();
                $("#link_1").hide();
                $("#products").show();
            }
            if (type == "offer_image_url") {
                $("#category").hide();
                $("#products").hide();
                $("#link_1").show();
            }
        });
    </script>
</body>

</html>
<?php include "footer.php"; ?>