//check user login or not
if (document.getElementById("user_id")) {
    var user_id = document.getElementById("user_id");
}
// Delete Cart Data
$(function () {
    $(document).on('click', '.cartDeletepage', function (e) {
        e.preventDefault();
        var varient = $(this).data('varient');
        var data = {
            '_token': $('input[name=_token]').val(),
            'varient': varient
        };
        $.ajax({
            url: "/cart/remove/" + varient,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                alertify.set('notifier', 'position', 'top-right');
                alertify.success(response.status);
                var html = '';
                if (response.totalcart > 0) {
                    if (response.areawise_deliverycharge == '1') {

                    } else {
                        if (response.subtotal < response.min_order_amount) {
                            html += '<div class="row justify-content-center">' +
                                    '<div class="col-md-12">' +
                                    '<div class="alert alert-warning">' + response.you_must_have_to_purchase + ' ' + response.currency + ' ' + response.min_order_amount + ' ' + response.to_place_order + '</div>' +
                                    '</div>' +
                                    '</div>';
                        } else if (response.shipping > 0) {
                            if (response.subtotal > 0 && response.subtotal < response.min_amount) {
                                html += ' <div class="row justify-content-center">' +
                                        '<div class="col-md-12">' +
                                        '<div class="alert alert-info">' + response.you_can_get_free_delivery_by_shopping_more_than + ' ' + response.currency + ' ' + response.min_amount + '</div>' +
                                        '</div>' +
                                        '</div>';
                            }
                        }
                    }
                    html += '<div class="row justify-content-center">' +
                            '<main class="col-md-12">' +
                            '<div class="card">' +
                            '<div class="table-responsive">' +
                            '<table id="myTable" class="table ">' +
                            '<thead>' +
                            '<tr class="cart1title">' +
                            '<th scope="col" class="product">' + response.product + '</th>' +
                            '<th scope="col" class="qty">' + response.qty + '</th>' +
                            '<th scope="col" class="price">' + response.price + '</th>' +
                            '<th scope="col" class="text-right cartext action"></th>' +
                            '</tr>' +
                            '</thead>' +
                            '<tbody id="movecart">';
                    $.each(response.items, function (i, e) {
                        if (e.qty > 0) {
                            var qty = e.qty;
                        } else {
                            var qty = response.cart_session[e.product_variant_id].quantity;
                        }
                        var max_cart_items_count = parseInt(response.settings.max_cart_items_count);
                    var cart_count = e.qty > 0 ? e.qty : 0;
                    //data-stock
                    if (e.stock) {
                        var stock = e.stock;
                    }
                    if (e.type == 'loose') {
                        if (e.stock_unit_name === 'kg' || e.stock_unit_name === 'ltr') {
                            var stock = e.stock * 1000;
                        }
                    }
                    var product_id = e.product_id;
                    //data-cart-stock-cart-page
                    var cart_stock_cart_page = 0;
                    var maxqty = 0;
                    $.each(response.items, function (i, e) {
                        if (e.qty > 0 && (e) && (e.unit === 'gm' || e.unit === 'ml') && e.product_id === product_id) {
                            var stock_smallvarient = e.qty * e.measurement;
                            cart_stock_cart_page += stock_smallvarient;
                            maxqty = e.stock;
                        }
                        if (e.qty > 0 && (e) && (e.unit === 'kg'|| e.unit === 'ltr') && e.product_id === product_id) {
                            var stock_bigvarient = e.qty * e.measurement * 1000;
                            cart_stock_cart_page += stock_bigvarient;
                            maxqty = e.stock * 1000;
                        }
                    })
                    var get_cart_stock_cart_page = maxqty - cart_stock_cart_page;
                        html += '<tr class="cart1price">' +
                                '<td>' +
                                '<a href="' + home + 'product/' + e.slug + '">' +
                                '<figure class="itemside">' +
                                '<div class="aside">' +
                                '<img src="' + e.image + '" class="img-sm" alt="' + e.name + '">' +
                                '</div>' +
                                '<figcaption class="info">' +
                                '<a href="' + home + 'product/' + e.slug + '" class="title text-dark">' + e.name + '</a>' +
                                '<p class="small text-muted">' + e.measurement + ' ' + e.unit + '</p>' +
                                '</figcaption>' +
                                '</figure>' +
                                '</a>' +
                                '</td>' +
                                '<td class="cart">' +
                                '<div class="price-wrap cartShow">' + qty + '</div>' +
                                '<form action="/cart/update/' + e.product_id + '" method="POST" class="cartEdit cartEditpage">' +
                                '<button class="pdp-btn trim btn active">' +
                                '<input hidden type="radio" name="options" ' +
                                "data-stock='" + stock + "' " +
                                "data-max-allowed-stock='" + max_cart_items_count + "' " +
                                "data-cart_count='" + cart_count + "' " +
                                "data-qty='" + qty + "' " +
                                "data-varient-name='" + e.unit + "' " +
                                "data-varient-number='" + e.measurement + "' " +
                                "data-varient-type='" + e.type + "' " +
                                "data-cart-stock-cart-page='" + get_cart_stock_cart_page + "' " +
                                "autocomplete='off'/> " +
                                '</button>' +
                                '<input type="hidden" name="child_id" value="' + e.product_variant_id + '">' +
                                '<input type="hidden" name="product_id" value="' + e.product_id + '">' +
                                '<div class="button-container col">' +
                                '<button class="cart-qty-minus button-minus" type="button" id="button-minus" value="-">-</button>' +
                                '<input class="form-control qtyPicker" type="number" name="qty" data-min="1" min="1" max="' + stock + '" data-max="' + stock + '" data-max-allowed="' + response.max_cart_items_count + '" value="' + qty + '" readonly>' +
                                '<button class="cart-qty-plus button-plus" type="button" id="button-plus" value="+">+</button>' +
                                '</div>' +
                                '</form>' +
                                '</td>' +
                                '<td>' +
                                '<div class="price-wrap">' +
                                '<var class="price">';
                        if (e.discounted_price > 0) {
                            if (e.tax_percentage > 0) {
                                var tax_price = parseFloat(e.discounted_price) + parseFloat((e.discounted_price * e.tax_percentage) / 100);
                                html += response.currency + parseFloat(tax_price * qty).toFixed(2);
                            } else {
                                html += response.currency + parseFloat(e.discounted_price * qty).toFixed(2);
                            }
                        } else {
                            if (e.tax_percentage > 0) {
                                var tax_price = parseFloat(e.price) + parseFloat((e.price * e.tax_percentage) / 100);
                                html += response.currency + parseFloat(tax_price * qty).toFixed(2);
                            } else {
                                html += response.currency + parseFloat(e.price * qty).toFixed(2);
                            }
                        }
                        html += '</var><br/>';
                        if (qty > 1) {
                            if (e.discounted_price > 0) {
                                if (e.tax_percentage > 0) {
                                    var tax_price = parseFloat(e.discounted_price) + ((parseFloat(e.discounted_price) * parseFloat(e.tax_percentage)) / 100);
                                    html += '<small class="text-muted">' + response.currency + tax_price + " each</small>";
                                } else {
                                    html += '<small class="text-muted">' + response.currency + e.discounted_price + " each</small>";
                                }
                            } else {
                                if (e.tax_percentage > 0) {
                                    var tax_price = parseFloat(e.price) + ((parseFloat(e.price) * parseFloat(e.tax_percentage)) / 100);
                                    html += '<small class="text-muted">' + response.currency + tax_price + " each</small>";
                                } else {
                                    html += '<small class="text-muted">' + response.currency + e.price + " each</small>";
                                }
                            }
                        }
                        html += '</div>' +
                                '</td>' +
                                '<td class="text-right checktrash">' +
                                '<button class="btn btn-light btn-round btnEdit cartShow"> <em class="fa fa-pencil-alt"></em></button>' +
                                '<button class="btn btn-light btn-round cartSave cartEdit cartEditpage"> <em class="fas fa-check"></em></button>' +
                                '<button class="btn btn-light btn-round btnEdit cartEdit"> <em class="fa fa-times"></em></button>' +
                                '<button class="btn btn-light btn-round cartDeletepage" data-varient="' + e.product_variant_id + '"><em class="fas fa-trash-alt"></em></button>';
                        if (user_id) {
                            html += '<br/>  <p class="save_for_later" data-varient="' + e.product_variant_id + '"> Save for Later </p>';
                        }
                        html += '</td>' +
                                '</tr>';
                    });
                } else {
                    html += '<tr>' +
                            '<td colspan="4" class="text-center">' +
                            '<img src="' + response.empty_card_img + '" alt="No Items In Cart">' +
                            '<br><br>' +
                            '<a href="' + home + 'shop" class="btn btn-primary"><em class="fa fa-chevron-left  mr-1"></em>' + response.continue_shopping + ' </a>' +
                            ' </td>' +
                            '</tr> ';
                }
                html += '</tbody>' +
                        '<tfoot id="price_section">';
                if (response.subtotal > 0) {
                    html += '<tr>' +
                            '<td colspan="2">';
                    if (response.local_pickup && response.local_pickup === '1') {
                        html += '<a class="deleviry__option">' +
                                '<input type="radio" name="pickup" value="door_step_delivery" checked>' + msg.door_step_delivery +
                                '<input type="radio" name="pickup" value="pickup_from_store" class="ms-3">' + msg.pickup_from_store +
                                '</a>';
                    }
                    html += '</td>' +
                            '<td class="text-right" colspan="2">' +
                            '<p class="product-name">' + response.subtotal_msg + '  : <span>' + response.currency + parseFloat(response.subtotal).toFixed(2) + '</span></p>';
                    html += '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td class="continue-shopping"><strong><span><a href="' + home + 'shop" class="btn btn-primary"><em class="fa fa-chevron-left mr-1"></em>' + response.continue_shopping + '</a></span></strong></td>' +
                            '<td></td>' +
                            '<td colspan="2" class="text-end">' +
                            '<a href="" class="btn btn-primary cartDeleteallpage mx-1">' + response.delete_all_msg + '  <em class="fa fa-trash"></em></a>';
                    if (user_id == '') {
                        html += '<a class="btn btn-primary login-popup">' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></a>';
                    } else {
                        if (response.subtotal >= response.min_order_amount) {
                            html += '<a id="door_step_delivery" href="' + home + 'checkout/address" class="btn btn-primary">' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></a>  <a id="pickup_from_store" href="' + home + 'checkout" class="btn btn-primary">' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></a>';
                        } else {
                            html += '<button class="btn btn-primary" disabled>' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></button>';
                        }
                    }
                    html += '</td></tr>';
                }
                html += '</tfoot></table></div></div></main></div>';
                $('.cartpageajax').html(html);
            }
        });
    });
});
// Delete ALL DATA Cart Data
$(function () {
    $(document).on('click', '.cartDeleteallpage', function (e) {

        e.preventDefault();
        var varient = 'all';
        var data = {
            '_token': $('input[name=_token]').val(),
            'varient': varient,
        };
        $.ajax({
            url: "/cart/remove/" + varient,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.subtotal > 0) {
                    var html = '';
                    if (response.subtotal > 0) {

                    } else {
                        html += '<tr>' +
                                '<td colspan="4" class="text-center">' +
                                '<img src="' + response.empty_card_img + '" alt="No Items In Cart">' +
                                '<br><br>' +
                                '<a href="' + home + 'shop" class="btn btn-primary"><em class="fa fa-chevron-left  mr-1"></em>' + response.continue_shopping + ' </a>' +
                                ' </td>' +
                                '</tr> ';
                    }
                    html += '</tbody>' +
                            '<tfoot id="price_section">';
                    if (response.subtotal > 0) {
                        html += '<tr>' +
                                '<td colspan="2">';
                        if (response.local_pickup && response.local_pickup === '1') {
                            html += '<a class="deleviry__option">' +
                                    '<input type="radio" name="pickup" value="door_step_delivery" checked>' + msg.door_step_delivery +
                                    '<input type="radio" name="pickup" value="pickup_from_store" class="ms-3">' + msg.pickup_from_store +
                                    '</a>';
                        }
                        html += '</td>' +
                                '<td class="text-right" colspan="2">' +
                                '<p class="product-name">' + response.subtotal_msg + '  : <span>' + response.currency + parseFloat(response.subtotal).toFixed(2) + '</span></p>';
                        html += '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="continue-shopping"><strong><span><a href="' + home + 'shop" class="btn btn-primary"><em class="fa fa-chevron-left mr-1"></em>' + response.continue_shopping + '</a></span></strong></td>' +
                                '<td></td>' +
                                '<td colspan="2" class="text-end">' +
                                '<a href="" class="btn btn-primary cartDeleteallpage mx-1">' + response.delete_all_msg + '  <em class="fa fa-trash"></em></a>';
                        if (user_id == '') {
                            html += '<a class="btn btn-primary login-popup">' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></a>';
                        } else {
                            if (response.subtotal >= response.min_order_amount) {
                                html += '<a id="door_step_delivery" href="' + home + 'checkout/address" class="btn btn-primary">' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></a>  <a id="pickup_from_store" href="' + home + 'checkout" class="btn btn-primary">' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></a>';
                            } else {
                                html += '<button class="btn btn-primary" disabled>' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></button>';
                            }
                        }
                        html += '</td></tr>';
                    }
                    html += '</tfoot></table></div></div></main></div>';
                    $('.cartpageajax').html(html);
                } else {
                    var html = "";
                    html +=
                            '<span class="mini_cart_close"><a href="#"><em class="fas fa-times"></em></a></span><div class="text-center"><img src="' +
                            response.empty_card_img +
                            '" alt="No Items In Cart"><br><br><a href="' + home + 'shop" class="btn btn-primary text-white mx-1"><em class="fa fa-chevron-left  mr-1"></em>' +
                            response.continue_shopping +
                            '</a><a href="' + home + 'cart" class="btn btn-primary text-white"><em class="fab fa-opencart  mr-1"></em> View Cart</a></div>';
                    $(".cartpageajax").html(html);
                }
            }
        });
    });
});
//edit cart quantity
$(document).on("submit", ".cartEditpage", function (e) {
    var URL = $(location).attr('href');
    $.ajax({
        async: true,
        type: "POST",
        url: $(this).attr('action'),
        data: $(this).closest('form').serialize(),
        dataType: 'json',
        success: function (response) {
            console.log(response);
            alertify.set('notifier', 'position', 'top-right');
            alertify.success(response.status);
            var html = '';
            if (response.totalcart > 0) {
                if (response.areawise_deliverycharge == '1') {

                } else {
                    if (response.subtotal < response.min_order_amount) {
                        html += '<div class="row justify-content-center">' +
                                '<div class="col-md-12">' +
                                '<div class="alert alert-warning">' + response.you_must_have_to_purchase + ' ' + response.currency + ' ' + response.min_order_amount + ' ' + response.to_place_order + '</div>' +
                                '</div>' +
                                '</div>';
                    } else if (response.shipping > 0) {
                        if (response.subtotal > 0 && response.subtotal < response.min_amount) {
                            html += ' <div class="row justify-content-center">' +
                                    '<div class="col-md-12">' +
                                    '<div class="alert alert-info">' + response.you_can_get_free_delivery_by_shopping_more_than + ' ' + response.currency + ' ' + response.min_amount + '</div>' +
                                    '</div>' +
                                    '</div>';
                        }
                    }
                }
                html += '<div class="row justify-content-center">' +
                        '<main class="col-md-12">' +
                        '<div class="card">' +
                        '<div class="table-responsive">' +
                        '<table id="myTable" class="table ">' +
                        '<thead>' +
                        '<tr class="cart1title">' +
                        '<th scope="col" class="product">' + response.product + '</th>' +
                        '<th scope="col" class="qty">' + response.qty + '</th>' +
                        '<th scope="col" class="price">' + response.price + '</th>' +
                        '<th scope="col" class="text-right cartext action"></th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody id="movecart">';
                $.each(response.items, function (i, e) {
                    if (e.qty > 0) {
                        var qty = e.qty;
                    } else {
                        var qty = response.cart_session[e.product_variant_id].quantity;
                    }
                    var max_cart_items_count = parseInt(response.settings.max_cart_items_count);
                    var cart_count = e.qty > 0 ? e.qty : 0;
                    //data-stock
                    if (e.stock) {
                        var stock = e.stock;
                    }
                    if (e.type == 'loose') {
                        if (e.stock_unit_name === 'kg' || e.stock_unit_name === 'ltr') {
                            var stock = e.stock * 1000;
                        }
                    }
                    var product_id = e.product_id;
                    //data-cart-stock-cart-page
                    var cart_stock_cart_page = 0;
                    var maxqty = 0;
                    $.each(response.items, function (i, e) {
                        if (e.qty > 0 && (e) && (e.unit === 'gm' || e.unit === 'ml') && e.product_id === product_id) {
                            var stock_smallvarient = e.qty * e.measurement;
                            cart_stock_cart_page += stock_smallvarient;
                            maxqty = e.stock;
                        }
                        if (e.qty > 0 && (e) && (e.unit === 'kg'|| e.unit === 'ltr') && e.product_id === product_id) {
                            var stock_bigvarient = e.qty * e.measurement * 1000;
                            cart_stock_cart_page += stock_bigvarient;
                            maxqty = e.stock * 1000;
                        }
                    })
                    var get_cart_stock_cart_page = maxqty - cart_stock_cart_page;
                    html += '<tr class="cart1price">' +
                            '<td>' +
                            '<a href="' + home + 'product/' + e.slug + '">' +
                            '<figure class="itemside">' +
                            '<div class="aside">' +
                            '<img src="' + e.image + '" class="img-sm" alt="' + e.name + '">' +
                            '</div>' +
                            '<figcaption class="info">' +
                            '<a href="' + home + 'product/' + e.slug + '" class="title text-dark">' + e.name + '</a>' +
                            '<p class="small text-muted">' + e.measurement + ' ' + e.unit + '</p>' +
                            '</figcaption>' +
                            '</figure>' +
                            '</a>' +
                            '</td>' +
                            '<td class="cart">' +
                            '<div class="price-wrap cartShow">' + qty + '</div>' +
                            '<form action="/cart/update/' + e.product_id + '" method="POST" class="cartEdit cartEditpage">' +
                            '<button class="pdp-btn trim btn active">' +
                            '<input hidden type="radio" name="options" ' +
                            "data-stock='" + stock + "' " +
                            "data-max-allowed-stock='" + max_cart_items_count + "' " +
                            "data-cart_count='" + cart_count + "' " +
                            "data-qty='" + qty + "' " +
                            "data-varient-name='" + e.unit + "' " +
                            "data-varient-number='" + e.measurement + "' " +
                            "data-varient-type='" + e.type + "' " +
                            "data-cart-stock-cart-page='" + get_cart_stock_cart_page + "' " +
                            "autocomplete='off'/> " +
                            '</button>' +
                            '<input type="hidden" name="child_id" value="' + e.product_variant_id + '">' +
                            '<input type="hidden" name="product_id" value="' + e.product_id + '">' +
                            '<div class="button-container col">' +
                            '<button class="cart-qty-minus button-minus" type="button" id="button-minus" value="-">-</button>' +
                            '<input class="form-control qtyPicker" type="number" name="qty" data-min="1" min="1" max="' + stock + '" data-max="' + stock + '" data-max-allowed="' + response.max_cart_items_count + '" value="' + qty + '" readonly>' +
                            '<button class="cart-qty-plus button-plus" type="button" id="button-plus" value="+">+</button>' +
                            '</div>' +
                            '</form>' +
                            '</td>' +
                            '<td>' +
                            '<div class="price-wrap">' +
                            '<var class="price">';
                    if (e.discounted_price > 0) {
                        if (e.tax_percentage > 0) {
                            var tax_price = parseFloat(e.discounted_price) + parseFloat((e.discounted_price * e.tax_percentage) / 100);
                            html += response.currency + parseFloat(tax_price * qty).toFixed(2);
                        } else {
                            html += response.currency + parseFloat(e.discounted_price * qty).toFixed(2);
                        }
                    } else {
                        if (e.tax_percentage > 0) {
                            var tax_price = parseFloat(e.price) + parseFloat((e.price * e.tax_percentage) / 100);
                            html += response.currency + parseFloat(tax_price * qty).toFixed(2);
                        } else {
                            html += response.currency + parseFloat(e.price * qty).toFixed(2);
                        }
                    }
                    html += '</var><br/>';
                    if (qty > 1) {
                        if (e.discounted_price > 0) {
                            if (e.tax_percentage > 0) {
                                var tax_price = parseFloat(e.discounted_price) + ((parseFloat(e.discounted_price) * parseFloat(e.tax_percentage)) / 100);
                                html += '<small class="text-muted">' + response.currency + tax_price + " each</small>";
                            } else {
                                html += '<small class="text-muted">' + response.currency + e.discounted_price + " each</small>";
                            }
                        } else {
                            if (e.tax_percentage > 0) {
                                var tax_price = parseFloat(e.price) + ((parseFloat(e.price) * parseFloat(e.tax_percentage)) / 100);
                                html += '<small class="text-muted">' + response.currency + tax_price + " each</small>";
                            } else {
                                html += '<small class="text-muted">' + response.currency + e.price + " each</small>";
                            }
                        }
                    }
                    html += '</div>' +
                            '</td>' +
                            '<td class="text-right checktrash">' +
                            '<button class="btn btn-light btn-round btnEdit cartShow"> <em class="fa fa-pencil-alt"></em></button>' +
                            '<button class="btn btn-light btn-round cartSave cartEdit cartEditpage"> <em class="fas fa-check"></em></button>' +
                            '<button class="btn btn-light btn-round btnEdit cartEdit"> <em class="fa fa-times"></em></button>' +
                            '<button class="btn btn-light btn-round cartDeletepage" data-varient="' + e.product_variant_id + '"><em class="fas fa-trash-alt"></em></button>';
                    if (user_id) {
                        html += '<br/>  <p class="save_for_later" data-varient="' + e.product_variant_id + '"> Save for Later </p>';
                    }
                    html += '</td>' +
                            '</tr>';
                });
            } else {
                html += '<tr>' +
                        '<td colspan="4" class="text-center">' +
                        '<img src="' + response.empty_card_img + '" alt="No Items In Cart">' +
                        '<br><br>' +
                        '<a href="' + home + 'shop" class="btn btn-primary"><em class="fa fa-chevron-left  mr-1"></em>' + response.continue_shopping + ' </a>' +
                        ' </td>' +
                        '</tr> ';
            }
            html += '</tbody>' +
                    '<tfoot id="price_section">';
            if (response.subtotal > 0) {
                html += '<tr>' +
                        '<td colspan="2">';
                if (response.local_pickup && response.local_pickup === '1') {
                    html += '<a class="deleviry__option">' +
                            '<input type="radio" name="pickup" value="door_step_delivery" checked>' + msg.door_step_delivery +
                            '<input type="radio" name="pickup" value="pickup_from_store" class="ms-3">' + msg.pickup_from_store +
                            '</a>';
                }
                html += '</td>' +
                        '<td class="text-right" colspan="2">' +
                        '<p class="product-name">' + response.subtotal_msg + '  : <span>' + response.currency + parseFloat(response.subtotal).toFixed(2) + '</span></p>';
                html += '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td class="continue-shopping"><strong><span><a href="' + home + 'shop" class="btn btn-primary"><em class="fa fa-chevron-left mr-1"></em>' + response.continue_shopping + '</a></span></strong></td>' +
                        '<td></td>' +
                        '<td colspan="2" class="text-end">' +
                        '<a href="" class="btn btn-primary cartDeleteallpage mx-1">' + response.delete_all_msg + '  <em class="fa fa-trash"></em></a>';
                if (user_id == '') {
                    html += '<a class="btn btn-primary login-popup">' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></a>';
                } else {
                    if (response.subtotal >= response.min_order_amount) {
                        html += '<a id="door_step_delivery" href="' + home + 'checkout/address" class="btn btn-primary">' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></a>  <a id="pickup_from_store" href="' + home + 'checkout" class="btn btn-primary">' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></a>';
                    } else {
                        html += '<button class="btn btn-primary" disabled>' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></button>';
                    }
                }
                html += '</td></tr>';
            }
            html += '</tfoot></table></div></div></main></div>';
            $('.cartpageajax').html(html);
        }
    });
    e.preventDefault();
});
// Save For Later ADD
$(function () {
    $(document).on('click', '.save_for_later', function (e) {
        var el = this;
        e.preventDefault();
        var varient = $(this).data('varient');
        $.ajax({
            url: "/save-for-later/" + varient,
            type: 'POST',
            dataType: 'json',
            success: function (response) {

                alertify.set('notifier', 'position', 'top-right');
                alertify.success(response.status);
                $(el).closest('tr').css('background', 'tomato');
                $(el).closest('tr').fadeOut(800, function () {
                    $(this).remove();
                });
                var image = response.product[0].item[0].image;
                var savelater = '<tr class="cart1price">' +
                        '<td>' +
                        '<a href="' + home + 'product/' + response.product[0].item[0].slug + '">' +
                        '<figure class="itemside">' +
                        '<div class="aside">' +
                        '<img src="' + response.product[0].item[0].image + '" class="img-sm" alt="' + response.product[0].item[0].name + '">' +
                        '</div>' +
                        '<figcaption class="info">' +
                        '<a href="' + home + 'product/' + response.product[0].item[0].slug + '" class="title text-dark">' + response.product[0].item[0].name + '</a>' +
                        '<p class="small text-muted">' + response.product[0].item[0].measurement + ' ' + response.product[0].item[0].unit + '</p>' +
                        '</figcaption>' +
                        '</figure>' +
                        '</a>' +
                        '</td>' +
                        '<td class="cart">' +
                        '<div class="price-wrap cartShow">' + response.product[0].qty + '</div>' +
                        '<form action="/cart/update/' + response.product[0].item[0].product_id + '" method="POST" class="cartEdit cartEditpage">' +
                        //@csrf
                        '<input type="hidden" name="child_id" value="' + response.product[0].item[0].product_variant_id + '">' +
                        '<input type="hidden" name="product_id" value="' + response.product[0].item[0].product_id + '">' +
                        '<div class="button-container col">' +
                        '</div>' +
                        '</form>' +
                        '</td>' +
                        '<td>' +
                        '<div class="price-wrap">' +
                        '<var class="price">';
                if (response.product[0].item[0].discounted_price > 0) {
                    if (response.product[0].item[0].tax_percentage > 0) {
                        var tax_price =
                                parseFloat(response.product[0].item[0].discounted_price) +
                                parseFloat(
                                        (response.product[0].item[0].discounted_price *
                                                response.product[0].item[0].tax_percentage) /
                                        100
                                        );
                        savelater +=
                                response.currency +
                                parseFloat(tax_price * response.product[0].qty).toFixed(2);
                    } else {
                        savelater +=
                                response.currency +
                                parseFloat(
                                        response.product[0].item[0].discounted_price * response.product[0].qty
                                        ).toFixed(2);
                    }
                } else {
                    if (response.product[0].item[0].tax_percentage > 0) {
                        var tax_price =
                                parseFloat(response.product[0].item[0].price) +
                                parseFloat(
                                        (response.product[0].item[0].price *
                                                response.product[0].item[0].tax_percentage) /
                                        100
                                        );
                        savelater +=
                                response.currency +
                                parseFloat(tax_price * response.product[0].qty).toFixed(2);
                    } else {
                        savelater +=
                                response.currency +
                                parseFloat(response.product[0].item[0].price * response.product[0].qty).toFixed(2);
                    }
                }
                savelater += '</var><br/>';
                if (response.product[0].qty > 1) {
                    if (response.product[0].item[0].discounted_price > 0) {
                        if (response.product[0].item[0].tax_percentage > 0) {
                            var tax_price =
                                    parseFloat(response.product[0].item[0].discounted_price) +
                                    parseFloat(
                                            (response.product[0].item[0].discounted_price *
                                                    response.product[0].item[0].tax_percentage) /
                                            100
                                            );
                            savelater +=
                                    '<small class="text-muted">' +
                                    response.currency +
                                    tax_price +
                                    " each</small>";
                        } else {
                            savelater +=
                                    '<small class="text-muted">' +
                                    response.currency +
                                    response.product[0].item[0].discounted_price +
                                    " each</small>";
                        }
                    } else {
                        if (response.product[0].item[0].tax_percentage > 0) {
                            var tax_price =
                                    response.product[0].item[0].price +
                                    parseFloat(
                                            (response.product[0].item[0].price *
                                                    response.product[0].item[0].tax_percentage) /
                                            100
                                            ).toFixed(2);
                            savelater +=
                                    '<small class="text-muted">' +
                                    response.currency +
                                    tax_price +
                                    "each</small>";
                        } else {
                            savelater +=
                                    '<small class="text-muted">' +
                                    response.currency +
                                    response.product[0].item[0].price +
                                    " each</small>";
                        }
                    }
                }
                savelater += '</div>' +
                        '</td>' +
                        '<td class="text-right checktrash">' +
                        '<a class="move_to_cart" data-varient="' + response.varient_id + '"> Move to Cart </a>' +
                        '</td>' +
                        '</tr>';
                $("#savelater").append(savelater);
                $("#price_section").empty();
                var price_section = '<tr><td colspan="2">';
                if (response.local_pickup && response.local_pickup === '1') {
                    price_section += '<a class="deleviry__option">' +
                            '<input type="radio" name="pickup" value="door_step_delivery" checked>' + msg.door_step_delivery +
                            '<input type="radio" name="pickup" value="pickup_from_store" class="ms-3">' + msg.pickup_from_store +
                            '</a>';
                }
                price_section += '</td>' +
                        '<td class="text-right" colspan="2">' +
                        '<p class="product-name">' + response.subtotal_msg + '  : <span>' + response.currency + parseFloat(response.subtotal).toFixed(2) + '</span></p>';
                price_section += '</td></tr>';
                price_section += '<tr>' +
                        '<td class="continue-shopping"><strong><span><a href="' + home + 'shop" class="btn btn-primary"><em class="fa fa-chevron-left mr-1"></em>' + response.continue_shopping + '</a></span></strong></td>' +
                        '<td></td>' +
                        '<td colspan="2" class="text-end">' +
                        '<a href="" class="btn btn-primary cartDeleteallpage mx-1">' + response.delete_all_msg + '  <em class="fa fa-trash"></em></a>';

                price_section += '<a id="door_step_delivery" href="' + home + 'checkout/address" class="btn btn-primary">' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></a>  <a id="pickup_from_store" href="' + home + 'checkout" class="btn btn-primary">' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></a>';

                price_section += '</td></tr></tfoot></table></div></div></main></div>';
                $("#price_section").append(price_section);
            }
        });
    });
});
// Move to Cart ADD
$(function () {
    $(document).on('click', '.move_to_cart', function (e) {
        var el = this;
        e.preventDefault();
        var varient = $(this).data('varient');
        $.ajax({
            url: "/move-to-cart/" + varient,
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                console.log(response);
                alertify.set('notifier', 'position', 'top-right');
                alertify.success(response.status);
                $(el).closest('tr').css('background', 'tomato');
                $(el).closest('tr').fadeOut(800, function () {
                    $(this).remove();
                });
                var movecart = '<tr class="cart1price">' +
                        '<td>' +
                        '<a href="' + home + 'product/' + response.product[0].item[0].slug + '">' +
                        '<figure class="itemside">' +
                        '<div class="aside">' +
                        '<img src="' + response.product[0].item[0].image + '" class="img-sm" alt="' + response.product[0].item[0].name + '">' +
                        '</div>' +
                        '<figcaption class="info">' +
                        '<a href="' + home + 'product/' + response.product[0].item[0].slug + '" class="title text-dark">' + response.product[0].item[0].name + '</a>' +
                        '<p class="small text-muted">' + response.product[0].item[0].measurement + ' ' + response.product[0].item[0].unit + '</p>' +
                        '</figcaption>' +
                        '</figure>' +
                        '</a>' +
                        '</td>' +
                        '<td class="cart">' +
                        '<div class="price-wrap cartShow">' + response.product[0].qty + '</div>' +
                        '<form action="/cart/update/' + response.product[0].item[0].product_id + '" method="POST" class="cartEdit cartEditpage">' +
                        //@csrf
                        '<input type="hidden" name="child_id" value="' + response.product[0].product_variant_id + '">' +
                        '<input type="hidden" name="product_id" value="' + response.product[0].product_id + '">' +
                        '<div class="button-container col">' +
                        '<button class="cart-qty-minus button-minus" type="button" id="button-minus" value="-">-</button>' +
                        '<input class="form-control qtyPicker" type="number" name="qty" data-min="1" min="1" max="' + response.product[0].item[0].stock + '" data-max="' + response.product[0].item[0].stock + '" data-max-allowed="' + response.max_cart_items_count + '" value="' + response.product[0].qty + '" readonly>' +
                        '<button class="cart-qty-plus button-plus" type="button" id="button-plus" value="+">+</button>' +
                        '</div> ' +
                        '</form>' +
                        '</td>' +
                        '<td>' +
                        '<div class="price-wrap">' +
                        '<var class="price">';
                if (response.product[0].item[0].discounted_price > 0) {
                    if (response.product[0].item[0].tax_percentage > 0) {
                        var tax_price =
                                parseFloat(response.product[0].item[0].discounted_price) +
                                parseFloat(
                                        (response.product[0].item[0].discounted_price *
                                                response.product[0].item[0].tax_percentage) /
                                        100
                                        );
                        movecart +=
                                response.currency +
                                parseFloat(tax_price * response.product[0].qty).toFixed(2);
                    } else {
                        movecart +=
                                response.currency +
                                parseFloat(
                                        response.product[0].item[0].discounted_price * response.product[0].qty
                                        ).toFixed(2);
                    }
                } else {
                    if (response.product[0].item[0].tax_percentage > 0) {
                        var tax_price =
                                parseFloat(response.product[0].item[0].price) +
                                parseFloat(
                                        (response.product[0].item[0].price *
                                                response.product[0].item[0].tax_percentage) /
                                        100
                                        );
                        movecart +=
                                response.currency +
                                parseFloat(tax_price * response.product[0].qty).toFixed(2);
                    } else {
                        movecart +=
                                response.currency +
                                parseFloat(response.product[0].item[0].price * response.product[0].qty).toFixed(2);
                    }
                }
                movecart += '</var><br/>';
                if (response.product[0].qty > 1) {
                    if (response.product[0].item[0].discounted_price > 0) {
                        if (response.product[0].item[0].tax_percentage > 0) {
                            var tax_price =
                                    parseFloat(response.product[0].item[0].discounted_price) +
                                    parseFloat(
                                            (response.product[0].item[0].discounted_price *
                                                    response.product[0].item[0].tax_percentage) /
                                            100
                                            );
                            movecart +=
                                    '<small class="text-muted">' +
                                    response.currency +
                                    tax_price +
                                    " each</small>";
                        } else {
                            movecart +=
                                    '<small class="text-muted">' +
                                    response.currency +
                                    response.product[0].item[0].discounted_price +
                                    " each</small>";
                        }
                    } else {
                        if (response.product[0].item[0].tax_percentage > 0) {
                            var tax_price =
                                    response.product[0].item[0].price +
                                    parseFloat(
                                            (response.product[0].item[0].price *
                                                    response.product[0].item[0].tax_percentage) /
                                            100
                                            ).toFixed(2);
                            movecart +=
                                    '<small class="text-muted">' +
                                    response.currency +
                                    tax_price +
                                    "each</small>";
                        } else {
                            movecart +=
                                    '<small class="text-muted">' +
                                    response.currency +
                                    response.product[0].item[0].price +
                                    " each</small>";
                        }
                    }
                }
                movecart += '</div>' +
                        '</td>' +
                        '<td class="text-right checktrash">' +
                        '<button class="btn btn-light btn-round btnEdit cartShow"> <em class="fa fa-pencil-alt"></em></button>' +
                        '<button class="btn btn-light btn-round cartSave cartEdit cartEditpage"> <em class="fas fa-check"></em></button>' +
                        '<button class="btn btn-light btn-round btnEdit cartEdit"> <em class="fa fa-times"></em></button>' +
                        '<button class="btn btn-light btn-round cartDeletepage" data-varient="' + response.product[0].item[0].product_variant_id + '"><em class="fas fa-trash-alt"></em></button>' +
                        '<br/>  <a class="save_for_later" data-varient="' + response.varient_id + '"> Save for Later </a>' +
                        '</td>' +
                        '</tr>';
                $("#movecart").append(movecart);
                $("#price_section").empty();
                $("#empty").empty();
                var price_section = '<tr><td colspan="2">';
                if (response.local_pickup && response.local_pickup === '1') {
                    price_section += '<a class="deleviry__option">' +
                            '<input type="radio" name="pickup" value="door_step_delivery" checked>' + msg.door_step_delivery +
                            '<input type="radio" name="pickup" value="pickup_from_store" class="ms-3">' + msg.pickup_from_store +
                            '</a>';
                }
                price_section += '</td>' +
                        '<td class="text-right" colspan="2">' +
                        '<p class="product-name">' + response.subtotal_msg + '  : <span>' + response.currency + response.subtotal.toFixed(2) + '</span></p>';
                price_section += '</td></tr>';
                price_section += '<tr>' +
                        '<td class="continue-shopping"><strong><span><a href="' + home + 'shop" class="btn btn-primary"><em class="fa fa-chevron-left mr-1"></em>' + response.continue_shopping + '</a></span></strong></td>' +
                        '<td></td>' +
                        '<td colspan="2" class="text-end">' +
                        '<a href="" class="btn btn-primary cartDeleteallpage mx-1">' + response.delete_all_msg + '  <em class="fa fa-trash"></em></a>';

                price_section += '<a id="door_step_delivery" href="' + home + 'checkout/address" class="btn btn-primary">' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></a>  <a id="pickup_from_store" href="' + home + 'checkout" class="btn btn-primary">' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></a>';

                price_section += '</td></tr></tfoot></table></div></div></main></div>';
                $("#price_section").append(price_section);
            }
        });
    });
});