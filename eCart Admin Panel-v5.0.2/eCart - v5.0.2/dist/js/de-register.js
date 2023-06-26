/* Deregister web */

$('#webDeregister').click(function () {
    let purchase_code = prompt("Please enter your purchase code here", "");
    let text;
    text = $.trim(purchase_code);
    // console.log(text);

    var item_id = $(this).val();

    $.ajax({
        type: 'POST',
        url: 'public/db-operation.php',
        data: { 'web_item_id': item_id },
        beforeSend: function () {
            $('#webDeregister').html('Please wait..');
        },
        dataType: 'json',
        success: async function (result) {
            // console.log(result);

            var code_bravo = result.code_bravo;
            // console.log(code_bravo);
            var time_check = result.time_check;
            var dr_firestone = result.dr_firestone;
            console.log(domain_url);
            if (!result.error) {
                var form = new FormData();
                form.append("code_bravo", code_bravo);
                form.append("dr_firestone", dr_firestone);
                form.append("time_check", time_check);
                form.append("domain_url", domain_url);
                if (text == code_bravo) {
                    // console.log("match");
                    await $.ajax({
                        type: 'POST',
                        url: 'https://wrteam.in/validator/home/deregister',
                        data: form,
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        // crossDomain: true,
                        success: function (result) {
                            if (!result.error) {
                                var de_register = result.time_check;
                                // console.log(de_register)
                                let res;
                                $.ajax({
                                    type: 'POST',
                                    url: 'public/db-operation.php',
                                    data: { 'de_register_web': de_register },
                                    dataType: 'json',

                                    success: async function (result) {
                                        // console.log(result);
                                        res = result;
                                        if (result['error'] == false) {
                                            $('#result_success_web').html(result.message);
                                            $('#result_success_web').show().delay(6000).fadeOut();
                                            $('#webDeregister').html('De-register web');
                                            setTimeout(function () {
                                                location.reload();
                                            }, 4000);
                                        } else {
                                            $('#result_fail_web').html(result.message);
                                            $('#result_fail_web').show().delay(6000).fadeOut();
                                            $('#webDeregister').html('De-register web');
                                        }
                                    },
                                });

                            }
                        }
                    });

                }
                else {
                    // console.log("not match");
                    $('#result_fail_web').html("Entered purchase code is not correct, please check your purchase code and try again!");
                    $('#result_fail_web').show().delay(6000).fadeOut();
                    $('#webDeregister').html('De-register web');
                }

            }

        },
    });

});

/* Deregister customer app */

$('#custDeregister').click(function () {

    let purchase_code = prompt("Please enter your purchase code here", "");
    let text;
    text = $.trim(purchase_code);

    var item_id = $(this).val();

    $.ajax({
        type: 'POST',
        url: 'public/db-operation.php',
        data: { 'cust_item_id': item_id },
        beforeSend: function () {
            $('#custDeregister').html('Please wait..');
        },
        dataType: 'json',
        success: async function (result) {
            console.log(result);

            var code_bravo = result.code_bravo;
            console.log(code_bravo);
            var time_check = result.time_check;
            var dr_firestone = result.dr_firestone;
            console.log(domain_url);
            if (!result.error) {
                var form = new FormData();
                form.append("code_bravo", code_bravo);
                form.append("dr_firestone", dr_firestone);
                form.append("time_check", time_check);
                form.append("domain_url", domain_url);
                if (text == code_bravo) {
                    // console.log("match");
                    await $.ajax({
                        type: 'POST',
                        url: 'https://wrteam.in/validator/home/deregister',
                        data: form,
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        // crossDomain: true,
                        success: function (result) {
                            if (!result.error) {
                                var de_register = result.time_check;
                                // console.log(de_register)
                                let res;
                                $.ajax({
                                    type: 'POST',
                                    url: 'public/db-operation.php',
                                    data: { 'de_register_cust': de_register },
                                    dataType: 'json',

                                    success: async function (result) {
                                        // console.log(result);
                                        res = result;
                                        if (result['error'] == false) {
                                            $('#result_success_cust').html(result.message);
                                            $('#result_success_cust').show().delay(6000).fadeOut();
                                            $('#custDeregister').html('De-register app');
                                            setTimeout(function () {
                                                location.reload();
                                            }, 4000);
                                        } else {
                                            $('#result_fail_cust').html(result.message);
                                            $('#result_fail_cust').show().delay(6000).fadeOut();
                                            $('#custDeregister').html('De-register app');
                                        }
                                    },
                                });

                            }
                        }
                    });


                }
                else {
                    $('#result_fail_cust').html("Entered purchase code is not correct, please check your purchase code and try again!");
                    $('#result_fail_cust').show().delay(6000).fadeOut();
                    $('#custDeregister').html('De-register app');
                }
            }

        },
    });

});

/* Deregister admin app */

$('#adminDeregister').click(function () {

    let purchase_code = prompt("Please enter your purchase code here", "");
    let text;
    text = $.trim(purchase_code);

    var item_id = $(this).val();

    $.ajax({
        type: 'POST',
        url: 'public/db-operation.php',
        data: { 'admin_item_id': item_id },
        beforeSend: function () {
            $('#adminDeregister').html('Please wait..');
        },
        dataType: 'json',
        success: async function (result) {
            console.log(result);

            var code_bravo = result.code_bravo;
            console.log(code_bravo);
            var time_check = result.time_check;
            var dr_firestone = result.dr_firestone;
            console.log(domain_url);
            if (!result.error) {
                var form = new FormData();
                form.append("code_bravo", code_bravo);
                form.append("dr_firestone", dr_firestone);
                form.append("time_check", time_check);
                form.append("domain_url", domain_url);
                if (text == code_bravo) {
                    // console.log("match");
                    await $.ajax({
                        type: 'POST',
                        url: 'https://wrteam.in/validator/home/deregister',
                        data: form,
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        // crossDomain: true,
                        success: function (result) {
                            if (!result.error) {
                                var de_register = result.time_check;
                                // console.log(de_register)
                                let res;
                                $.ajax({
                                    type: 'POST',
                                    url: 'public/db-operation.php',
                                    data: { 'de_register_admin': de_register },
                                    dataType: 'json',

                                    success: async function (result) {
                                        // console.log(result);
                                        res = result;
                                        if (result['error'] == false) {
                                            $('#result_success_admin').html(result.message);
                                            $('#result_success_admin').show().delay(6000).fadeOut();
                                            $('#adminDeregister').html('De-register app');
                                            setTimeout(function () {
                                                location.reload();
                                            }, 4000);
                                        } else {
                                            $('#result_fail_admin').html(result.message);
                                            $('#result_fail_admin').show().delay(6000).fadeOut();
                                            $('#adminDeregister').html('De-register app');
                                        }
                                    },
                                });

                            }
                        }
                    });


                }
                else {
                    $('#result_fail_admin').html("Entered purchase code is not correct, please check your purchase code and try again!");
                    $('#result_fail_admin').show().delay(6000).fadeOut();
                    $('#adminDeregister').html('De-register app');
                }
            }

        },
    });

});