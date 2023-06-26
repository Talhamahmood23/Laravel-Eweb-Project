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
?>
<?php include "header.php"; ?>
<html>

<head>
    <meta charset="utf-8">
    <script src="/ckeditor/ckeditor.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!-- Make sure the path to CKEditor is correct. -->

    <!--  <title>Scripts |
        <?= $settings['app_name'] ?> - Dashboard
    </title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {

    });

    function sendPushNotification(id) {
        var data = $('form#' + id).serialize();
        $('form#' + id).unbind('submit');
        $.ajax({
            url: "send-message.php",
            type: 'GET',
            data: data,
            beforeSend: function() {

            },
            success: function(data, textStatus, xhr) {
                $('.txt_message').val("");
            },
            error: function(xhr, textStatus, errorThrown) {

            }
        });

        return false;
    }
    </script>
    <style type="text/css">
    .container {
        width: 950px;
        margin: 0 auto;
        padding: 0;
    }

    h1 {
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        font-size: 24px;
        color: #777;
    }

    h1 .send_btn {
        background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#0096FF), to(#005DFF));
        background: -webkit-linear-gradient(0% 0%, 0% 100%, from(#0096FF), to(#005DFF));
        background: -moz-linear-gradient(center top, #0096FF, #005DFF);
        background: linear-gradient(#0096FF, #005DFF);
        text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);
        border-radius: 3px;
        color: #fff;
        padding: 3px;
    }

    div.clear {
        clear: both;
    }

    ul.devices {
        margin: 0;
        padding: 0;
    }

    ul.devices li {
        float: left;
        list-style: none;
        border: 1px solid #dedede;
        padding: 10px;
        margin: 0 15px 25px 0;
        border-radius: 3px;
        -webkit-box-shadow: 0 1px 5px rgba(0, 0, 0, 0.35);
        -moz-box-shadow: 0 1px 5px rgba(0, 0, 0, 0.35);
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.35);
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        color: #555;
        width: 100%;
        height: 150px;
        background-color: #ffffff;
    }

    ul.devices li label,
    ul.devices li span {
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        font-size: 12px;
        font-style: normal;
        font-variant: normal;
        font-weight: bold;
        color: #393939;
        display: block;
        float: left;
    }

    ul.devices li label {
        height: 25px;
        width: 50px;
    }

    ul.devices li textarea {
        float: left;
        resize: none;
    }

    ul.devices li .send_btn {
        background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#0096FF), to(#005DFF));
        background: -webkit-linear-gradient(0% 0%, 0% 100%, from(#0096FF), to(#005DFF));
        background: -moz-linear-gradient(center top, #0096FF, #005DFF);
        background: linear-gradient(#0096FF, #005DFF);
        text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);
        border-radius: 7px;
        color: #fff;
        padding: 4px 24px;
    }

    a {
        text-decoration: none;
        color: rgb(245, 134, 52);
    }
    </style> -->
</head>

<body>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Scripts</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
            </ol>
            <hr />
        </section>
        <?php
        include_once('includes/functions.php');
        ?>
        <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">scripts</h3>
                        </div>

                        <form id="script_form" method="post" action="" enctype="multipart/form-data">

                            <?php $sql = "select * from settings where variable = 'footer_script'";
                            $db->sql($sql);
                            $footer_res = $db->getResult(); ?>
                            <div class="box-body">

                                <input type="hidden" value="1" name="customer_scripts">
                                <?php $sql = "select * from settings where variable = 'header_script'";
                                $db->sql($sql);
                                $header_res = $db->getResult(); ?>

                                <div class="form-group">


                                    <h2>Custom Header Codes</h2><label for="a">(These codes will be added to the
                                        header
                                        to the site )</label>
                                    <textarea rows="7" name="header_script" id="header_script" cols="70"
                                        class="form-control" placeholder=""> <?= $header_res[0]['value'] ?></textarea>
                                    <!-- <label for="a">"Eg:-<style>body{background-color:#00a65;]}"</style></label> -->
                                    <label for="header_script">Example:</label>
                                    <code><label for="header_script">&lt;style&gt;body { background-color: #00a65; }&lt;/style&gt;</label></code>
                                    <br>
                                    <label for="header_script">Example:</label>
                                    <code><label for="header_script">&lt;script&gt;$("p").css("color", "red");&lt;/script&gt;</label></code>
                                </div>
                                <div class="form-group">
                                    <!-- <label for="a">Footer script :</label> -->
                                    <h2>Custom footer Codes</h2><label for="a">(These codes will be added to the
                                        footer
                                        to the site )</label>
                                    <textarea rows="7" name="footer_script" id="footer_script" cols="70"
                                        class="form-control" placeholder=""><?= $footer_res[0]['value'] ?></textarea>
                                    <label for="header_script">Example:</label>
                                    <code><label for="header_script">&lt;style&gt;body { background-color: #00a65; }&lt;/style&gt;</label></code>
                                    <br>
                                    <label for="header_script">Example:</label>
                                    <code><label for="header_script">&lt;script&gt;$("p").css("color", "red");&lt;/script&gt;</label></code>

                                    <div class="box-footer">
                                        <input type="submit" id="save" name="save" class="btn btn-primary"
                                            value="Save" />&nbsp;
                                        <div id="result"></div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </section>

        <script>
            // $('#script_form').on('submit', function(e) {
            //     e.preventDefault();

            //     var formData = new FormData(this);
            //     $.ajax({
            //         console.log("hello");
            //         type: 'POST',
            //         url: 'public/db-operation.php',
            //         data: formData,
            //         dataType: "json",
            //         cache: false,
            //         contentType: false,
            //         processData: false,
            //         // beforeSend: function() {
            //         //     $('#result').html('Please wait..');
            //         // },

            //         success: function(result) {
            //             $('#result').html(result);
            //             $('#result').show().delay(5000).fadeOut();
            //             // $('#result').html('Save Settings');


            //         }
            //     });

            // });


            $('#script_form').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({

                    type: 'POST',
                    url: 'public/db-operation.php',
                    data: formData,
                    beforeSend: function () {
                        $('#save').html('Please wait..');
                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        console.log(result);
                        $('#save').html("Save");
                        $('#result').show().delay(5000).fadeOut();
                        $('#result').html(result);
                    }
                });
            });
        </script>
    </div>
</body>

</html>

<?php include "footer.php"; ?>