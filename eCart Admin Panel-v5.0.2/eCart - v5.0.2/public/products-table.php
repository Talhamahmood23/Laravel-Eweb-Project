<section class="content-header">
    <h1>
        Products /
        <small><a href="home.php"><i class="fa fa-home"></i> Home</a></small>
    </h1>
    <ol class="breadcrumb">
        <a class="btn btn-block btn-default" href="add-product.php"><i class="fa fa-plus-square"></i> Add New
            Product</a>
    </ol>
</section>
<?php
if ($permissions['products']['read'] == 1) {
    ?>
    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-xs-12">
                <div class="box">
                    <!-- <div class="col-xs-6"> -->
                    <div class="box-header">
                        <div class="col-md-3">
                            <h4 class="box-title">Filter by Products Category</h4>
                            <form method="post">
                                <select id="category_id" name="category_id" placeholder="Select Category" required
                                    class="form-control col-xs-3" style="width: 300px;">
                                    <?php
                                    $Query = "select name, id from category";
                                    $db->sql($Query);
                                    $result = $db->getResult();
                                    if ($result) {
                                        ?>
                                        <option value="">All Products</option>
                                        <?php foreach ($result as $row) {
                                            if ($permissions['categories']['read'] == 1) {
                                                ?>
                                                <option value='<?= $row['id'] ?>'><?= $row['name'] ?></option>
                                            <?php }
                                        }
                                    }
                                    ?>
                                </select>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <h4 class="box-title">Filter by Products Sub-Category</h4>

                            <select id="subcategory_id" name="subcategory_id" placeholder="Select Sub-Category" required
                                class="form-control col-xs-3" style="width: 300px;">
                                <?php

                                ?>
                                <option value="">Select category</option>
                                <?php foreach ($result as $row) {
                                    if ($permissions['subcategories']['read'] == 1) {
                                        ?>
                                        <option value='<?= $row['id'] ?>'><?= $row['name'] ?></option>
                                    <?php }
                                }
                                // }
                                ?>
                            </select>

                        </div>
                    </div>
                    <div class="box-header"></div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id='products_table' class="table table-hover" data-toggle="table"
                            data-url="api-firebase/get-bootstrap-table-data.php?table=products"
                            data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true"
                            data-side-pagination="server" data-pagination="true" data-search="true"
                            data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams"
                            data-sort-name="id" data-sort-order="desc" data-show-export="true"
                            data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "products-list-<?= date('d-m-Y') ?>",
                            "ignoreColumn": ["operate"] 
                        }'>
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="product_id" data-sortable="true">Product ID</th>
                                    <th data-field="tax_id" data-sortable="true">Tax ID</th>
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="image">Image</th>
                                    <th data-field="price">Price</th>
                                    <th data-field="discounted_price">D.Price</th>
                                    <th data-field="measurement">Measurement</th>
                                    <th data-field="stock">Stock</th>
                                    <th data-field="hsn_code" data-visible="false">HSN code </th>
                                    <th data-field="serve_for">Availability</th>
                                    <th data-field="indicator">Indicator</th>
                                    <th data-field="description" data-visible="false">Description</th>
                                    <th data-field="manufacturer" data-visible="false">Manufacturer</th>
                                    <th data-field="made_in" data-visible="false">Made In</th>
                                    <th data-field="ratings" data-sortable="true">Ratings</th>
                                    <th data-field="return_status">Return</th>
                                    <th data-field="cancelable_status">Cancellation</th>
                                    <th data-field="till_status">Till Status</th>
                                    <th data-field="operate" data-events="actionEvents">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="separator"> </div>
        </div>
        <!-- /.row (main row) -->
    </section>
<?php } else { ?>
    <div class="alert alert-danger topmargin-sm" style="margin-top: 20px;">You have no permission to view products.</div>
<?php } ?>

<!-- <script>
    function queryParams(p) {
        return {
            "category_id": $('#category_id').val(),
            // "subcategory": $('#subcategory').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script> -->

<script>
    $('#category_id').on('change', function (e) {
        var category_id = $('#category_id').val();
        $.ajax({
            type: 'GET',
            url: "public/db-operation.php",
            data: 'get_subcategories_by_category=1&category_id=' + category_id,
            beforeSend: function () {
                $('#subcategory_id').html('<option>Please wait..</option>');
            },
            success: function (result) {
                $('#subcategory_id').html(result);
            }
        })

    });
    $('#subcategory_id').on('change', function () {
        $('#products_table').bootstrapTable('refresh');
    });
    $('#category_id').on('change', function () {
        id = $('#category_id').val();
        $('#products_table').bootstrapTable('refresh');
    });


    function queryParams(p) {
        return {
            "category_id": $('#category_id').val(),
            "subcategory_id": $('#subcategory_id').val(),

            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
    window.actionEvents = {
        'click .set-product-deactive': function (e, value, rows, index) {
            var p_id = $(this).data("id");
            $.ajax({
                url: 'public/db-operation.php',
                type: "get",
                data: 'id=' + p_id + '&product_status=1&type=deactive',
                success: function (result) {
                    if (result == 1)
                        $('#products_table').bootstrapTable('refresh');
                    else
                        alert('Error! Product could not be deactivated.');
                }
            });

        },
        'click .set-product-active': function (e, value, rows, index) {
            var p_id = $(this).data("id");
            $.ajax({
                url: 'public/db-operation.php',
                type: "get",
                data: 'id=' + p_id + '&product_status=1&type=active',
                success: function (result) {
                    if (result == 1)
                        $('#products_table').bootstrapTable('refresh');
                    else
                        alert('Error! Product could not be deactivated.');
                }
            });
        }
    };
</script>