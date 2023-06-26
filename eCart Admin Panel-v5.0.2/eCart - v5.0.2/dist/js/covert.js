$('#validate_code_website', '#validate_code_customer', 'validate_code_admin').validate({
    rules: {
        purchase_code: "required"
    }
});
$('#result_success_web , #result_fail_web , #result_success_cust , #result_fail_cust, #result_success_admin , #result_fail_admin').hide();

/* website */
$('#validate_code_website').on('submit', async function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    console.log(formData);
    if ($("#validate_code_website").validate().form()) {
        var item_id = '29260418';

        var code = $('#purchase_code_web').val();
        var flag = validURL(domain_url);

        if (flag) {
            var response = await validator(code, domain_url, item_id, formData); // for app
            console.log(response);
            if (response.error) {
                alert("Invalid Domain URL");
            } else {
                $('#result_success_web').html(response.message);
                $('#result_success_web').show().delay(6000).fadeOut();
            }
        } else {
            alert("Something went  wrong");
        }
    }
});

/* customer app */
$('#validate_code_customer').on('submit', async function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    console.log(formData);
    if ($("#validate_code_customer").validate().form()) {
        var item_id = '22015911';

        var code = $('#purchase_code_cust').val();
        var flag = validURL(domain_url);

        if (flag) {
            var response = await validator_customer(code, domain_url, item_id, formData); // for app
            console.log(response);
            if (response.error) {
                alert("Invalid Domain URL");
            } else {
                $('#result_success_cust').html(response.message);
                $('#result_success_cust').show().delay(6000).fadeOut();
            }
        } else {
            alert("Something went  wrong");
        }
    }
});

/* admin app */
$('#validate_code_admin').on('submit', async function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    console.log(formData);
    if ($("#validate_code_admin").validate().form()) {
        var item_id = '30288442';

        var code = $('#purchase_code_admin').val();
        var flag = validURL(domain_url);

        if (flag) {
            var response = await validator_admin(code, domain_url, item_id, formData); // for app
            console.log(response);
            if (response.error) {
                alert("Invalid Domain URL");
            } else {
                $('#result_success_admin').html(response.message);
                $('#result_success_admin').show().delay(6000).fadeOut();
            }
        } else {
            alert("Something went  wrong");
        }
    }
});
var myURL;
// '^(https?:\\/\\/)?' + // protocol
function validURL(myURL) {
    var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.?)+[a-z]{2,}|' + // domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))' + // ip (v4) address
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + //port
        '(\\?[;&amp;a-z\\d%_.~+=-]*)?' + // query string
        '(\\#[-a-z\\d_]*)?$', 'i');
    return pattern.test(myURL);
}

/* website */
async function validator(code, domain_url, item_id, formData) {
    let res;
    let response;
    await $.ajax({
        type: 'GET',
        url: 'https://wrteam.in/validator/home/validator_new?purchase_code=' + code + '&domain_url=' + domain_url + '&item_id=' + item_id,
        data: formData,
        beforeSend: function () {
            $('#webValidate').html('Please wait..');
        },
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: async function (result) {
            console.log(result);
            if (!result.error) {
                $('#result_success_web').html(result.message);
                $('#result_success_web').show().delay(6000).fadeOut();
                $('#validate_code_website')[0].reset();
                response_data = "code_bravo=" + result.purchase_code;
                response_data += "&time_check=" + result.token;
                response_data += "&code_adam=" + result.username;
                response_data += "&dr_firestone=" + result.item_id;
                response_data += "&add_dr_gold=1";
                await $.ajax({
                    type: 'POST',
                    url: 'public/db-operation.php',
                    data: response_data,
                    beforeSend: function () {
                        $('#webValidate').val('Please Wait..');
                    },
                    dataType: "json",
                    success: function (result) {
                        res = result;

                        if (result['error'] == false) {
                            $('#result_success_web').html(result.message);
                            $('#result_success_web').show().delay(6000).fadeOut();

                        } else {
                            $('#result_fail_web').html(result.message);
                            $('#result_fail_web').show().delay(6000).fadeOut();
                            $('#webValidate').html('Validate Now');
                        }
                    }
                });
            } else {
                res = result;
                $('#result_fail_web').html(result.message);
                $('#result_fail_web').show().delay(6000).fadeOut();
            }
            $('#webValidate').html('Validate Now');

        }
    });
    return res;

}

/* customer app */
async function validator_customer(code, domain_url, item_id, formData) {
    let res;
    let response;
    await $.ajax({
        type: 'GET',
        url: 'https://wrteam.in/validator/home/validator_new?purchase_code=' + code + '&domain_url=' + domain_url + '&item_id=' + item_id,
        data: formData,
        beforeSend: function () {
            $('#custValidate').html('Please wait..');
        },
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: async function (result) {
            console.log(result);
            if (!result.error) {
                $('#result_success_cust').html(result.message);
                $('#result_success_cust').show().delay(6000).fadeOut();
                $('#validate_code_customer')[0].reset();
                response_data = "code_bravo=" + result.purchase_code;
                response_data += "&time_check=" + result.token;
                response_data += "&code_adam=" + result.username;
                response_data += "&dr_firestone=" + result.item_id;
                response_data += "&add_dr_silver=1";
                await $.ajax({
                    type: 'POST',
                    url: 'public/db-operation.php',
                    data: response_data,
                    beforeSend: function () {
                        $('#custValidate').val('Please Wait..');
                    },
                    dataType: "json",
                    success: function (result) {
                        res = result;

                        if (result['error'] == false) {
                            $('#result_success_cust').html(result.message);
                            $('#result_success_cust').show().delay(6000).fadeOut();

                        } else {
                            $('#result_fail_cust').html(result.message);
                            $('#result_fail_cust').show().delay(6000).fadeOut();
                            $('#custValidate').html('Validate Now');
                        }
                    }
                });
            } else {
                res = result;
                $('#result_fail_cust').html(result.message);
                $('#result_fail_cust').show().delay(6000).fadeOut();
            }
            $('#custValidate').html('Validate Now');

        }
    });
    return res;

}

/* admin app */
async function validator_admin(code, domain_url, item_id, formData) {
    let res;
    let response;
    await $.ajax({
        type: 'GET',
        url: 'https://wrteam.in/validator/home/validator_new?purchase_code=' + code + '&domain_url=' + domain_url + '&item_id=' + item_id,
        data: formData,
        beforeSend: function () {
            $('#adminValidate').html('Please wait..');
        },
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: async function (result) {
            console.log(result);
            if (!result.error) {
                $('#result_success_admin').html(result.message);
                $('#result_success_admin').show().delay(6000).fadeOut();
                $('#validate_code_admin')[0].reset();
                response_data = "code_bravo=" + result.purchase_code;
                response_data += "&time_check=" + result.token;
                response_data += "&code_adam=" + result.username;
                response_data += "&dr_firestone=" + result.item_id;
                response_data += "&add_dr_dimond=1";
                await $.ajax({
                    type: 'POST',
                    url: 'public/db-operation.php',
                    data: response_data,
                    beforeSend: function () {
                        $('#adminValidate').val('Please Wait..');
                    },
                    dataType: "json",
                    success: function (result) {
                        res = result;

                        if (result['error'] == false) {
                            $('#result_success_admin').html(result.message);
                            $('#result_success_admin').show().delay(6000).fadeOut();

                        } else {
                            $('#result_fail_admin').html(result.message);
                            $('#result_fail_admin').show().delay(6000).fadeOut();
                            $('#adminValidate').html('Validate Now');
                        }
                    }
                });
            } else {
                res = result;
                $('#result_fail_admin').html(result.message);
                $('#result_fail_admin').show().delay(6000).fadeOut();
            }
            $('#adminValidate').html('Validate Now');

        }
    });
    return res;

}