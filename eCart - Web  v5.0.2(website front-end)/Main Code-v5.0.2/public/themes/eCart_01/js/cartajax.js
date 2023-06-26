////////////open product varient modal///////////////////////////////////////////////////////////////////
$(document).ready(function () {
    $('.productmodal').click(function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var slug = $(this).closest('.inner').find('.slug').val();
        $.ajax({
            url: home + "productajax/" + slug,
            method: 'GET',
            beforeSend: function () {
                $("#loader").show();
            },
            success: function (response) {
                $("#loader").hide();
                $('#productvariant').modal('show');
                console.log(response);
                var html = '';
                html +=
                        '<div class="row">' +
                        '<div class="col-lg-6 col-md-12 col-12 pics text-center productdetails1">' +
                        '<div class="wrap-gallery-article">' +
                        '<div id="myCarouselArticle" class="carousel slide" data-ride="carousel">' +
                        '<div class="carousel-inner" role="listbox">' +
                        '<div class="carousel-item active">' +
                        '<img class="outerdetailimg" src="' + response.product.image + '" alt="' + response.product.name + '">' +
                        '</div>';
                var count_other_image = response.product.other_images.length;
                if (count_other_image > 0) {
                    $.each(response.product.other_images, function (i, e) {
                        html += '<div class="carousel-item">' +
                                '<img class="outerdetailimg" src="' + e.other_images + '" alt=" ">' +
                                '</div>';
                    });
                }
                html += '</div>' +
                        '<a class="carousel-control-prev" href="#myCarouselArticle" role="button" data-slide="prev">' +
                        '<em class="fa fa-angle-left text-dark font-weight-bold"></em>' +
                        '</a>' +
                        '<a class="carousel-control-next" href="#myCarouselArticle" role="button" data-slide="next">' +
                        '<em class="fa fa-angle-right text-dark font-weight-bold"></em>' +
                        '</a>' +
                        '</div>' +
                        '<br>' +
                        '<div class="row hidden-xs " id="slider-thumbs">' +
                        '<ul class="reset-ul d-flex flex-wrap list-thumb-gallery">' +
                        '<li class="col-sm-3 col-3 thumb-gallery-smallimg">' +
                        '<a class="thumbnail" data-target="#myCarouselArticle" data-slide-to="0">' +
                        '<img class="img-fluid" src="' + response.product.image + '" alt="' + response.product.name + '">' +
                        '</a>' +
                        '</li>';
                var count = 1;
                $.each(response.product.other_images, function (i, e) {
                    html += '<li class="col-sm-3 col-3 thumb-gallery-smallimg">' +
                            '<a class="thumbnail thumbnailimg" data-target="#myCarouselArticle" data-slide-to="">' +
                            '<img class="img-fluid" src="" alt="">' +
                            '</a>' +
                            '</li>';
                    count++;
                });
                html += '</ul>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-lg-6 col-md-12 col-12 productdetails2 ">' +
                        '<aside class="add-to-fav" >' +
                        '<button type="button" class="btn ';
                if (response.product.is_favorite == true) {
                    html += 'saved';
                } else {
                    html += 'save';
                }

                var saving1 =
                        parseFloat(response.product.variants[0].price) - parseFloat(response.product.variants[0].discounted_price);
                var saving1_percentage =
                        parseInt(100 - parseInt(response.product.variants[0].discounted_price * 100 / response.product.variants[0].price));
                html += '"data-id=' + response.product.id + ' />' +
                        '</aside>' +
                        '<div class="text-left">' +
                        '<p class="lead title-sec font-weight-bold">' + response.title + '</p>' +
                        '<p></p>' +
                        '<hr class="line1 ml-0">' +
                        '<p class="mt-2 read-more desc">' + response.product.description + '</p>' +
                        '<hr class="line1 ml-0"><p class="text-muted" id="price_mrp_' + response.product.id + '"><del>' + response.price + ': ' + response.currency + ' <span class="value"></span></del></p>' +
                        '<h5 class="font-weight-bold title-sec" id="price_offer_' + response.product.id + '">' + response.offer_price + ': ' + response.currency + ' <span class="value"></span></h5>' +
                        '<h5 class="" id="price_regular_' + response.product.id + '">' + response.price + ':' + response.currency + ' <span class="value"></span></h5>' +
                        '<small class="pro_savings" id="price_savings_' + response.product.id + '"> ' + response.you_save + ': ' + response.currency + ' <span class="value">' + saving1.toFixed(2) + ' (' + Math.round(saving1_percentage) + '%off)</span></small>' +
                        '<div class="form product_data productmodal_data">' +
                        //'<form action="/cart/add" class="addToCart" method="POST">'+
                        //'@csrf'+
                        '<input type="hidden" class="name" name="name" value="' + response.product.name + '" data-name="' + response.product.name + '">' +
                        '<input type="hidden" class="image" name="image" value="' + response.product.image + '" data-image="' + response.product.image + '">' +
                        '<input type="hidden" class="price" name="price" value="" data-price="">' +
                        '<input type="hidden" name="id" class="productmodal_id" value="' + response.product.id + '" data-id="' + response.product.id + '">' +
                        '<input type="hidden" name="type" value="add">' +
                        '<input type="hidden" name="child_id"  value="' + response.product.variants[0].id + '" id="child_' + response.product.id + '">' +
                        '<div class="button-container col productmodal_data">' +
                        '<button class="cart-qty-minus button-minus" type="button" id="button-minus" value="-">-</button>' +
                        '<input class="form-control qtyPicker qtyPicker-single-page qty productmodal_qty" id="qtyPicker_' + response.product.id + '"  type="number" name="qty" data-min="1" min="1" data-max="1" max="1" value="1" readonly>' +
                        '<button class="cart-qty-plus button-plus button-plus-single-page" type="button" id="button-plus" value="+">+</button>' +
                        '</div>' +
                        '<div class="row mt-4">' +
                        '<div class="form-group col">' +
                        '<div class="btn-group-toggle variant" data-toggle="buttons">';
                var firstSelected = 'active';
                var checked = 'checked';
                var cart_stock = 0;
                $.each(response.product.variants, function (i, e) {
                    if (e.cart_count > 0 && e.measurement_unit_name === 'gm') {
                        var stock_smallvarient = e.cart_count * e.measurement;
                        cart_stock += stock_smallvarient;
                    }
                    if (e.cart_count > 0 && e.measurement_unit_name === 'kg') {
                        var stock_bigvarient = e.cart_count * (e.measurement * 1000);
                        cart_stock += stock_bigvarient;
                    }
                });
                $.each(response.product.variants, function (i, e) {
                    if(e.stock > 0){
                    html += '<button class="btn ' + firstSelected + '" data-id="' + response.product.id + '" >' +
                            '<span class="text-dark name">' + e.measurement + ' ' + e.measurement_unit_name + '</span><br>' +
                            '<small> ' + response.option_from + ' ' + e.discounted_price + ' </small>';
                    var tax_discounted_price = parseFloat(e.discounted_price) + parseFloat(e.discounted_price * response.product.tax_percentage / 100);
                    var tax_mrp_price = parseFloat(e.price) + parseFloat(e.price * response.product.tax_percentage / 100);
                    if (tax_discounted_price === 0) {
                        tax_discounted_price = tax_mrp_price;
                        tax_mrp_price = 0;
                    }
                    var saving = parseFloat(tax_mrp_price - tax_discounted_price);
                    var saving1_percentage = parseInt(100 - parseInt(tax_discounted_price * 100 / tax_mrp_price));
                    var max_cart_items_count = parseInt(response.settings.max_cart_items_count);
                    var cart_count = e.cart_count > 0 ? e.cart_count : 0;
                    if (e.stock) {
                        var stock = e.stock;
                    }
                    if (e.type == 'loose') {
                        if (e.stock_unit_name == 'kg') {
                            var stock = e.stock * 1000;
                        }
                    }
                    html += '<input type="radio" name="options"  class="productmodal_varient" id="option' + e.id + '" data-varient="' + e.id + '"  value="' + e.id + '" data-id="' + e.id + '" data-price="' + parseFloat(tax_discounted_price).toFixed(2) + '" data-tax="' + response.product.tax_percentage + '" data-mrp="' + parseFloat(tax_mrp_price).toFixed(2) + '" data-mrp_number="' + tax_mrp_price.toString().replace('/,/g', '') +
                            '" data-savings="' + parseFloat(saving).toFixed(2) + ' ( ' + saving1_percentage + ' %Off)" \n\
data-stock="' + stock + '" data-max-allowed-stock="' + max_cart_items_count + '" data-cart_count="' + cart_count + '" data-varient-name="' + e.measurement_unit_name +
                            '" data-varient-number="' + e.measurement +
                            '" data-varient-type="' + e.type +
                            '" data-cart-stock="' + cart_stock +
                            '" data-qty = "' + cart_count +
                            '" data-main-image="' + response.product.image +
                            '" data-gallery-images = "' + e.images.join(',') + '" autocomplete = "off" ' +
                            ">" +
                            "</button>";
                    if (firstSelected == 'active') {
                        firstSelected = '';
                    }
                    if (checked == 'checked') {
                        checked = '';
                    }
                }
                });
                html += '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="form-group">';
                var indicator1 = response.product.indicator;
                if (parseInt(indicator1) == 2) {
                    html += '<img src="' + response.nonvagimg + '" alt="Not Vegetarian Product">' +
                            '<span class="text-left ml-1">' + response.not + '<strong>' + response.vegetarian + '</strong> ' + response.v_product + '.</span>';
                }
                if (parseInt(indicator1) == 0) {
                    html += '<img src="' + response.vagimg + '" alt="Vegetarian Product">' +
                            '<span class="text-left ml-1">' + response.this_is + ' <strong>' + response.vegetarian + '</strong> ' + response.v_product + '.</span>';
                }
                html += '</div>' +
                        '<div class="form-group text-left add-to-cart1">' +
                        '<button type="submit" name="submit" class="btn btn-primary addtocart">' +
                        '<em class="fa fa-shopping-cart"> <span class="text-uppercase ml-2">' + response.add_to_cart + '</span></em>' +
                        '</button>' +
                        // '<button class="buy-now btn btn-primary text-center text-uppercase text-white addtocart" type="submit" name="submit" value="buynow"> <span class="buy-now1">'+response.buy_now+'</span></button>'+
                        '</div>' +
                        //'</form>'+
                        '</div>' +
                        '</div>';
                html += '</div></div>';
                $('.productmodaldetails').html(html);
                jQuery(function () {
                    jQuery('.variant .btn:first').click();
                });

            }
        });
    });
});
////////////Add to cart Single product///////////////////////////////////////////////////////////////////
$(document).ready(function () {
    $('.addtocart_single').click(function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var id = $(this).closest(".product_data").find(".id").val();
        var varient = $(this).closest(".product_data").find(".varient").val();
        var qty = $(this).closest(".product_data").find(".qty").val();
        var name = $(this).closest(".product_data").find(".name").val();
        var image = $(this).closest(".product_data").find(".image").val();
        var price = $(this).closest(".product_data").find(".price").val();
        $.ajax({
            url: home + "cart/single/addajax",
            method: "POST",
            data: {
                id: id,
                varient: varient,
                qty: qty,
                name: name,
                image: image,
                price: price,
            },
            success: function (response) {
                if (response.status) {
                    $('.cart_count').html($('<span class="item_count" id="item_count">' + response.totalcart + '</span>'));
                }
                alertify.set("notifier", "position", "top-right");
                if (response.status) {
                    alertify.success(response.status);
                } else {
                    alertify.warning(response.status_warning);
                }

            },
        });
    });
});
////////////Add to cart varient product///////////////////////////////////////////////////////////////////
$(function () {
    $(document).on('click', '.addtocart', function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var id = $(".productmodal_id").val();
        var varient = $(".productmodal_varient").val();
        var qty = $(this).closest(".product_data").find(".qty").val();
        var name = $(this).closest(".product_data").find(".name").val();
        var image = $(this).closest(".product_data").find(".image").val();
        var price = $(this).closest(".product_data").find(".price").val();
        $.ajax({
            url: home + "cart/single/addajax",
            method: "POST",
            data: {
                id: id,
                varient: varient,
                qty: qty,
                name: name,
                image: image,
                price: price
            },
            success: function (response) {
                if (response.status) {
                    $('.cart_count').html($('<span class="item_count" id="item_count">' + response.totalcart + '</span>'));

                }
                alertify.set("notifier", "position", "top-right");
                if (response.status) {
                    alertify.success(response.status);
                } else {
                    alertify.warning(response.status_warning);
                }
            },
        });
    });
});
////////////Add to cart varient product///////////////////////////////////////////////////////////////////
$(function () {
    $(document).on('click', '.addtocart', function (e) {
        setTimeout(function () {
            e.preventDefault();
            var data = {
                '_token': $('input[name=_token]').val(),
            };
            $.ajax({
                url: home + "cartajax",
                method: "GET",
                dataType: 'json',
                success: function (response) {
                    $('.cart_count').html($('<span class="item_count" id="item_count">' + response.totalcart + '</span>'));
                    var html = '';
                    html += '<div class="cart_gallery">' +
                            '<div class="cart_close"> </div>' +
                            '<table id="myTable" class="table">' +
                            '<tbody>' +
                            '<tr>' +
                            '<td class="mini_cart-subtotal">' +
                            '<span class="mini_cart_close">' +
                            '<a href="#"><em class="fas fa-times"></em></a>' +
                            '</span>' +
                            '<span class="text-right innersubtotal">';
                    if (response.subtotal > 0) {
                        html += '<p class="product-name">' + response.total_msg + ' : ' +
                                '<span>' + response.currency + parseFloat(response.subtotal).toFixed(2) + '</span>' +
                                '</p>';
                    }
                    html += '</span>' +
                            '</td>' +
                            '</tr>';
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
                            if (e.qty > 0 && (e) && (e.unit === 'kg' || e.unit === 'ltr') && e.product_id === product_id) {
                                var stock_bigvarient = e.qty * e.measurement * 1000;
                                cart_stock_cart_page += stock_bigvarient;
                                maxqty = e.stock * 1000;
                            }
                        })
                        var get_cart_stock_cart_page = maxqty - cart_stock_cart_page;
                        html += '<tr class="cart1price">' +
                                '<td class="text-right checktrash cart">' +
                                '<figure class="itemside">' +
                                '<div class="aside">' +
                                '<img src="' + e.image + '" class="img-sm" alt="">' +
                                '</div>' +
                                '<figcaption class="info minicartinfo">' +
                                '<a href="' + home + 'product/' + e.slug + '" class="title text-dark">' + e.name + '</a>' +
                                '<span class="small text-muted">' + e.measurement + ' ' + e.unit + '</span><br/>' +
                                '<span class="price-wrap cartShow">' + qty + '</span>' +
                                '<form action="' + home + 'cart/update/' + e.product_id + '" method="POST" class="cartEdit cartEditmini" >' +
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
                                '<div class="button-container col pr-0 my-1">' +
                                '<button class="cart-qty-minus button-minus" type="button" id="button-minus-' + e.product_variant_id + '" value="-">-</button>' +
                                '<input class="form-control qtyPicker productmodal_qty"  type="number" name="qty" data-min="1" min="1" data-max="' + e.stock + '" max="' + e.stock + '" data-max-allowed="' + response.max_cart_items_count + '" value="' + qty + '" readonly>' +
                                '<button class="cart-qty-plus button-plus-cart" type="button" id="button-plus-' + e.product_variant_id + '" value="+">+</button>' +
                                '</div>' +
                                '</form>';
                        if (qty > 1) {


                            if (e.discounted_price > 0) {
                                if (e.tax_percentage > 0) {
                                    var tax_price = parseFloat(e.discounted_price) + parseFloat(e.discounted_price * e.tax_percentage / 100);
                                    html += 'x<small class="text-muted">' + response.currency + tax_price + ' </small>';
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + e.discounted_price + ' </small>';
                                }

                            } else {
                                if (e.tax_percentage > 0) {
                                    var tax_price = e.price + parseFloat(e.price * e.tax_percentage / 100).toFixed(2);
                                    html += 'x<small class="text-muted">' + response.currency + tax_price + ' </small>';
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + e.price + ' </small>';
                                }

                            }
                        }

                        html +=
                                '</figcaption>' +
                                '</figure>' +
                                '<div class="price-wrap">' +
                                '<var class="price">';
                        if (e.discounted_price > 0) {
                            if (e.tax_percentage > 0) {
                                var tax_price = parseFloat(e.discounted_price) + parseFloat(e.discounted_price * e.tax_percentage / 100);
                                html += response.currency + parseFloat(tax_price * qty).toFixed(2);
                            } else {
                                html += response.currency + parseFloat(e.discounted_price * qty).toFixed(2);
                            }

                        } else {
                            if (e.tax_percentage > 0) {
                                var tax_price = parseFloat(e.price) + parseFloat(e.price * e.tax_percentage / 100);
                                html += response.currency + parseFloat(tax_price * qty).toFixed(2);
                            } else {
                                html += response.currency + parseFloat(e.price * qty).toFixed(2);
                            }

                        }

                        html += '</var>' +
                                '</div>' +
                                '<button class="btn btn-light btn-round btnEdit cartShow"><em class="fa fa-pencil-alt"></em></button>' +
                                '<button class="btn btn-light btn-round cartSave cartEdit"><em class="fas fa-check"></em></button>' +
                                '<button class="btn btn-light btn-round btnEdit cartEdit"><em class="fa fa-times"></em></button>' +
                                '<button type="submit" class="btn btn-light btn-round btnDelete cartDelete" data-varient="' + e.product_variant_id + '" ><em class="fas fa-trash-alt"></em></button>' +
                                '</td>' +
                                '</tr>';
                    });
                    html += '</tbody>' +
                            '<tfoot>' +
                            '<tr>' +
                            '<td colspan="" class="text-right checkoutbtn">' +
                            '<a href="" class="btn btn-primary cartDeleteallmini">' + response.delete_all_msg + ' <em class="fa fa-trash"></em></a>';

                    html += '<a href="' + home + 'cart" class="btn btn-primary text-white">View Cart <em class="fab fa-opencart text-white"></em></a>';

                    html += '</td>' +
                            '<td colspan="" class="text-right mini_cart-subtotal ">';
                    if (response.saved_price > 0) {
                        html += '<p class="product-name text-right">' + response.saved_price_msg + ' : ' + response.currency + parseFloat(response.saved_price).toFixed(2) + '<span></span></p>';
                    }
                    html += '</td>' +
                            '</tr>' +
                            '</tfoot>' +
                            '</table>' +
                            '</div>';
                    $('.mini_cart').html(html);
                },
            });
        }, 2000);
    });
});
///////////////////// GET Count of cart/////////////////////////////////
$(document).ready(function () {
    $('.addtocart_single').click(function (e) {
        setTimeout(function () {
            e.preventDefault();
            var data = {
                '_token': $('input[name=_token]').val(),
            };
            $.ajax({
                url: home + "cartajax",
                method: "GET",
                dataType: 'json',
                success: function (response) {
                    $('.cart_count').html($('<span class="item_count" id="item_count">' + response.totalcart + '</span>'));
                    console.log(response);
                    var html = '';
                    html += '<div class="cart_gallery">' +
                            '<div class="cart_close"> </div>' +
                            '<table id="myTable" class="table">' +
                            '<tbody>' +
                            '<tr>' +
                            '<td class="mini_cart-subtotal">' +
                            '<span class="mini_cart_close">' +
                            '<a href="#"><em class="fas fa-times"></em></a>' +
                            '</span>' +
                            '<span class="text-right innersubtotal">';
                    if (response.subtotal > 0) {
                        html += '<p class="product-name">' + response.total_msg + ' : ' +
                                '<span>' + response.currency + parseFloat(response.subtotal).toFixed(2) + '</span>' +
                                '</p>';
                    }
                    html += '</span>' +
                            '</td>' +
                            '</tr>';
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
                            if (e.qty > 0 && (e) && (e.unit === 'kg' || e.unit === 'ltr') && e.product_id === product_id) {
                                var stock_bigvarient = e.qty * e.measurement * 1000;
                                cart_stock_cart_page += stock_bigvarient;
                                maxqty = e.stock * 1000;
                            }
                        })
                        var get_cart_stock_cart_page = maxqty - cart_stock_cart_page;
                        html += '<tr class="cart1price">' +
                                '<td class="text-right checktrash cart">' +
                                '<figure class="itemside">' +
                                '<div class="aside">' +
                                '<img src="' + e.image + '" class="img-sm" alt="">' +
                                '</div>' +
                                '<figcaption class="info minicartinfo">' +
                                '<a href="' + home + 'product/' + e.slug + '" class="title text-dark">' + e.name + '</a>' +
                                '<span class="small text-muted">' + e.measurement + ' ' + e.unit + '</span><br/>' +
                                '<span class="price-wrap cartShow">' + qty + '</span>' +
                                '<form action="' + home + 'cart/update/' + e.product_id + '" method="POST" class="cartEdit cartEditmini" >' +
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
                                '<div class="button-container col pr-0 my-1">' +
                                '<button class="cart-qty-minus button-minus" type="button" id="button-minus-' + e.product_variant_id + '" value="-">-</button>' +
                                '<input class="form-control qtyPicker productmodal_qty"  type="number" name="qty" data-min="1" min="1" data-max="' + stock + '" max="' + stock + '" data-max-allowed="' + response.max_cart_items_count + '" value="' + qty + '" readonly>' +
                                '<button class="cart-qty-plus button-plus" type="button" id="button-plus-' + e.product_variant_id + '" value="+">+</button>' +
                                '</div>' +
                                '</form>';
                        if (qty > 1) {


                            if (e.discounted_price > 0) {
                                if (e.tax_percentage > 0) {
                                    var tax_price = parseFloat(e.discounted_price) + parseFloat(e.discounted_price * e.tax_percentage / 100);
                                    html += 'x<small class="text-muted">' + response.currency + tax_price + ' </small>';
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + e.discounted_price + ' </small>';
                                }

                            } else {
                                if (e.tax_percentage > 0) {
                                    var tax_price = e.price + parseFloat(e.price * e.tax_percentage / 100).toFixed(2);
                                    html += 'x<small class="text-muted">' + response.currency + tax_price + ' </small>';
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + e.price + ' </small>';
                                }

                            }
                        }

                        html +=
                                '</figcaption>' +
                                '</figure>' +
                                '<div class="price-wrap">' +
                                '<var class="price">';
                        if (e.discounted_price > 0) {
                            if (e.tax_percentage > 0) {
                                var tax_price = parseFloat(e.discounted_price) + parseFloat(e.discounted_price * e.tax_percentage / 100);
                                html += response.currency + parseFloat(tax_price * qty).toFixed(2);
                            } else {
                                html += response.currency + parseFloat(e.discounted_price * qty).toFixed(2);
                            }

                        } else {
                            if (e.tax_percentage > 0) {
                                var tax_price = parseFloat(e.price) + parseFloat(e.price * e.tax_percentage / 100);
                                html += response.currency + parseFloat(tax_price * qty).toFixed(2);
                            } else {
                                html += response.currency + parseFloat(e.price * qty).toFixed(2);
                            }

                        }

                        html += '</var>' +
                                '</div>' +
                                '<button class="btn btn-light btn-round btnEdit cartShow"><em class="fa fa-pencil-alt"></em></button>' +
                                '<button class="btn btn-light btn-round cartSave cartEdit"><em class="fas fa-check"></em></button>' +
                                '<button class="btn btn-light btn-round btnEdit cartEdit"><em class="fa fa-times"></em></button>' +
                                '<button type="submit" class="btn btn-light btn-round btnDelete cartDelete" data-varient="' + e.product_variant_id + '" ><em class="fas fa-trash-alt"></em></button>' +
                                '</td>' +
                                '</tr>';
                    });
                    html += '</tbody>' +
                            '<tfoot>' +
                            '<tr>' +
                            '<td colspan="" class="text-right checkoutbtn">' +
                            '<a href="" class="btn btn-primary cartDeleteallmini">' + response.delete_all_msg + ' <em class="fa fa-trash"></em></a>';

                    html += '<a href="' + home + 'cart" class="btn btn-primary text-white">View Cart <em class="fab fa-opencart text-white"></em></a>';

                    html += '</td>' +
                            '<td colspan="" class="text-right mini_cart-subtotal ">';
                    if (response.saved_price > 0) {
                        html += '<p class="product-name text-right">' + response.saved_price_msg + ' : ' + response.currency + parseFloat(response.saved_price).toFixed(2) + '<span></span></p>';
                    }
                    html += '</td>' +
                            '</tr>' +
                            '</tfoot>' +
                            '</table>' +
                            '</div>';
                    $('.mini_cart').html(html);
                },
            });
        }, 2000);
    });
});
// Delete Cart Data
$(function () {
    $(document).on('click', '.cartDelete', function (e) {

        e.preventDefault();
        var varient = $(this).data('varient');
        var data = {
            '_token': $('input[name=_token]').val(),
            'varient': varient,
        };
        $.ajax({
            url: home + "cart/remove/" + varient,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $('.cart_count').html($('<span class="item_count" id="item_count">' + response.totalcart + '</span>'));
                // console.log(response);
                alertify.set('notifier', 'position', 'top-right');
                alertify.success(response.status);
                if (response.total > 0) {
                    var html = '';
                    html += '<div class="cart_gallery">' +
                            '<div class="cart_close"> </div>' +
                            '<table id="myTable" class="table">' +
                            '<tbody>' +
                            '<tr>' +
                            '<td class="mini_cart-subtotal">' +
                            '<span class="mini_cart_close">' +
                            '<a href="#"><em class="fas fa-times"></em></a>' +
                            '</span>' +
                            '<span class="text-right innersubtotal">';
                    if (response.subtotal > 0) {
                        html += '<p class="product-name">' + response.total_msg + ' : ' +
                                '<span>' + response.currency + parseFloat(response.subtotal).toFixed(2) + '</span>' +
                                '</p>';
                    }
                    html += '</span>' +
                            '</td>' +
                            '</tr>';
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
                            if (e.qty > 0 && (e) && (e.unit === 'kg' || e.unit === 'ltr') && e.product_id === product_id) {
                                var stock_bigvarient = e.qty * e.measurement * 1000;
                                cart_stock_cart_page += stock_bigvarient;
                                maxqty = e.stock * 1000;
                            }
                        })
                        var get_cart_stock_cart_page = maxqty - cart_stock_cart_page;
                        html += '<tr class="cart1price">' +
                                '<td class="text-right checktrash cart">' +
                                '<figure class="itemside">' +
                                '<div class="aside">' +
                                '<img src="' + e.image + '" class="img-sm" alt="">' +
                                '</div>' +
                                '<figcaption class="info minicartinfo">' +
                                '<a href="' + home + 'product/' + e.slug + '" class="title text-dark">' + e.name + '</a>' +
                                '<span class="small text-muted">' + e.measurement + ' ' + e.unit + '</span><br/>' +
                                '<span class="price-wrap cartShow">' + qty + '</span>' +
                                '<form action="' + home + 'cart/update/' + e.product_id + '" method="POST" class="cartEdit cartEditmini" >' +
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
                                '<div class="button-container col pr-0 my-1">' +
                                '<button class="cart-qty-minus button-minus" type="button" id="button-minus-' + e.product_variant_id + '" value="-">-</button>' +
                                '<input class="form-control qtyPicker productmodal_qty"  type="number" name="qty" data-min="1" min="1" data-max="' + stock + '" max="' + stock + '" data-max-allowed="' + response.max_cart_items_count + '" value="' + qty + '" readonly>' +
                                '<button class="cart-qty-plus button-plus" type="button" id="button-plus-' + e.product_variant_id + '" value="+">+</button>' +
                                '</div>' +
                                '</form>';
                        if (qty > 1) {


                            if (e.discounted_price > 0) {
                                if (e.tax_percentage > 0) {
                                    var tax_price = parseFloat(e.discounted_price) + parseFloat(e.discounted_price * e.tax_percentage / 100);
                                    html += 'x<small class="text-muted">' + response.currency + tax_price + ' </small>';
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + e.discounted_price + ' </small>';
                                }

                            } else {
                                if (e.tax_percentage > 0) {
                                    var tax_price = e.price + parseFloat(e.price * e.tax_percentage / 100).toFixed(2);
                                    html += 'x<small class="text-muted">' + response.currency + tax_price + ' </small>';
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + e.price + ' </small>';
                                }

                            }
                        }

                        html +=
                                '</figcaption>' +
                                '</figure>' +
                                '<div class="price-wrap">' +
                                '<var class="price">';
                        if (e.discounted_price > 0) {
                            if (e.tax_percentage > 0) {
                                var tax_price = parseFloat(e.discounted_price) + parseFloat(e.discounted_price * e.tax_percentage / 100);
                                html += response.currency + parseFloat(tax_price * qty).toFixed(2);
                            } else {
                                html += response.currency + parseFloat(e.discounted_price * qty).toFixed(2);
                            }

                        } else {
                            if (e.tax_percentage > 0) {
                                var tax_price = parseFloat(e.price) + parseFloat(e.price * e.tax_percentage / 100);
                                html += response.currency + parseFloat(tax_price * qty).toFixed(2);
                            } else {
                                html += response.currency + parseFloat(e.price * qty).toFixed(2);
                            }

                        }

                        html += '</var>' +
                                '</div>' +
                                '<button class="btn btn-light btn-round btnEdit cartShow"><em class="fa fa-pencil-alt"></em></button>' +
                                '<button class="btn btn-light btn-round cartSave cartEdit"><em class="fas fa-check"></em></button>' +
                                '<button class="btn btn-light btn-round btnEdit cartEdit"><em class="fa fa-times"></em></button>' +
                                '<button type="submit" class="btn btn-light btn-round btnDelete cartDelete" data-varient="' + e.product_variant_id + '" ><em class="fas fa-trash-alt"></em></button>' +
                                '</td>' +
                                '</tr>';
                    });
                    html += '</tbody>' +
                            '<tfoot>' +
                            '<tr>' +
                            '<td colspan="" class="text-right checkoutbtn">' +
                            '<a href="" class="btn btn-primary cartDeleteallmini">' + response.delete_all_msg + ' <em class="fa fa-trash"></em></a>';

                    html += '<a href="' + home + 'cart" class="btn btn-primary text-white">View Cart <em class="fab fa-opencart text-white"></em></a>';

                    html += '</td>' +
                            '<td colspan="" class="text-right mini_cart-subtotal ">';
                    if (response.saved_price > 0) {
                        html += '<p class="product-name text-right">' + response.saved_price_msg + ' : ' + response.currency + parseFloat(response.saved_price).toFixed(2) + '<span></span></p>';
                    }
                    html += '</td>' +
                            '</tr>' +
                            '</tfoot>' +
                            '</table>' +
                            '</div>';
                    $('.mini_cart').html(html);
                } else {
                    var html = '';
                    html += '<div class="text-center"><img src="' + response.empty_card_img + '" alt="No Items In Cart"><br><br><a href="' + home + 'shop" class="btn btn-primary text-white"><em class="fa fa-chevron-left  mr-1"></em>' + response.continue_shopping + '</a></div>';
                    $('.mini_cart').html(html);
                }
            }
        });
    });
});
// Delete ALL DATA Cart Data
$(function () {
    $(document).on('click', '.cartDeleteallmini', function (e) {

        e.preventDefault();
        var varient = 'all';
        var data = {
            '_token': $('input[name=_token]').val(),
            'varient': varient,
        };
        $.ajax({
            url: home + "cart/remove/" + varient,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $('.cart_count').html($('<span class="item_count" id="item_count">' + response.totalcart + '</span>'));
                //console.log(response);
                alertify.set('notifier', 'position', 'top-right');
                alertify.success(response.status);
                if (response.total > 0) {
                    var html = '';
                    html += '<div class="cart_gallery">' +
                            '<div class="cart_close"> </div>' +
                            '<table id="myTable" class="table">' +
                            '<tbody>' +
                            '<tr>' +
                            '<td class="mini_cart-subtotal">' +
                            '<span class="mini_cart_close">' +
                            '<a href="#"><em class="fas fa-times"></em></a>' +
                            '</span>' +
                            '<span class="text-right innersubtotal">';
                    if (response.subtotal > 0) {
                        html += '<p class="product-name">' + response.total_msg + ' : ' +
                                '<span>' + response.currency + parseFloat(response.subtotal).toFixed(2) + '</span>' +
                                '</p>';
                    }
                    html += '</span>' +
                            '</td>' +
                            '</tr>';
                    $.each(response.items, function (i, e) {

                        html += '<tr class="cart1price">' +
                                '<td class="text-right checktrash cart">' +
                                '<figure class="itemside">' +
                                '<div class="aside">' +
                                '<img src="' + e.image + '" class="img-sm" alt="">' +
                                '</div>' +
                                '<figcaption class="info minicartinfo">' +
                                '<a href="' + home + 'product/' + e.slug + '" class="title text-dark">' + e.name + '</a>' +
                                '<span class="small text-muted">' + e.measurement + ' ' + e.unit + '</span><br/>' +
                                '<span class="price-wrap cartShow">' + e.qty + '</span>' +
                                '<form action="' + home + 'cart/update/' + e.product_id + '" method="POST" class="cartEdit cartEditmini" >' +
                                //'@csrf'+

                                '<input type="hidden" name="child_id" value="' + e.product_variant_id + '">' +
                                '<input type="hidden" name="product_id" value="' + e.product_id + '">' +
                                '<div class="button-container col pr-0 my-1">' +
                                '<button class="cart-qty-minus button-minus" type="button" id="button-minus-' + e.product_variant_id + '" value="-">-</button>' +
                                '<input class="form-control qtyPicker productmodal_qty"  type="number" name="qty" data-min="1" min="1" data-max="' + e.stock + '" max="' + e.stock + '" data-max-allowed="' + response.max_cart_items_count + '" value="' + e.qty + '" readonly>' +
                                '<button class="cart-qty-plus button-plus-cart" type="button" id="button-plus-' + e.product_variant_id + '" value="+">+</button>' +
                                '</div>' +
                                '</form>';
                        if (e.qty > 1) {


                            if (e.discounted_price > 0) {
                                if (e.tax_percentage > 0) {
                                    var tax_price = parseFloat(e.discounted_price) + parseFloat(e.discounted_price * e.tax_percentage / 100);
                                    html += 'x<small class="text-muted">' + response.currency + tax_price + ' </small>';
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + e.discounted_price + ' </small>';
                                }

                            } else {
                                if (e.tax_percentage > 0) {
                                    var tax_price = e.price + parseFloat(e.price * e.tax_percentage / 100).toFixed(2);
                                    html += 'x<small class="text-muted">' + response.currency + tax_price + ' </small>';
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + e.price + ' </small>';
                                }

                            }
                        }

                        html +=
                                '</figcaption>' +
                                '</figure>' +
                                '<div class="price-wrap">' +
                                '<var class="price">';
                        if (e.discounted_price > 0) {
                            if (e.tax_percentage > 0) {
                                var tax_price = parseFloat(e.discounted_price) + parseFloat(e.discounted_price * e.tax_percentage / 100);
                                html += response.currency + parseFloat(tax_price * e.qty).toFixed(2);
                            } else {
                                html += response.currency + parseFloat(e.discounted_price * e.qty).toFixed(2);
                            }

                        } else {
                            if (e.tax_percentage > 0) {
                                var tax_price = parseFloat(e.price) + parseFloat(e.price * e.tax_percentage / 100);
                                html += response.currency + parseFloat(tax_price * e.qty).toFixed(2);
                            } else {
                                html += response.currency + parseFloat(e.price * e.qty).toFixed(2);
                            }

                        }

                        html += '</var>' +
                                '</div>' +
                                '<button class="btn btn-light btn-round btnEdit cartShow"><em class="fa fa-pencil-alt"></em></button>' +
                                '<button class="btn btn-light btn-round cartSave cartEdit"><em class="fas fa-check"></em></button>' +
                                '<button class="btn btn-light btn-round btnEdit cartEdit"><em class="fa fa-times"></em></button>' +
                                '<button type="submit" class="btn btn-light btn-round btnDelete cartDelete" data-varient="' + e.product_variant_id + '" ><em class="fas fa-trash-alt"></em></button>' +
                                '</td>' +
                                '</tr>';
                    });
                    html += '</tbody>' +
                            '<tfoot>' +
                            '<tr>' +
                            '<td colspan="" class="text-right checkoutbtn">' +
                            '<a href="" class="btn btn-primary cartDeleteallmini">' + response.delete_all_msg + ' <em class="fa fa-trash"></em></a>';

                    html += '<a href="' + home + 'cart" class="btn btn-primary text-white">View Cart <em class="fab fa-opencart text-white"></em></a>';

                    html += '</td>' +
                            '<td colspan="" class="text-right mini_cart-subtotal ">';
                    if (response.saved_price > 0) {
                        html += '<p class="product-name text-right">' + response.saved_price_msg + ' : ' + response.currency + parseFloat(response.saved_price).toFixed(2) + '<span></span></p>';
                    }
                    html += '</td>' +
                            '</tr>' +
                            '</tfoot>' +
                            '</table>' +
                            '</div>';
                    $('.mini_cart').html(html);
                } else {
                    var html = '';
                    html += '<span class="mini_cart_close"><a href="#"><em class="fas fa-times"></em></a></span><div class="text-center"><img src="' + response.empty_card_img + '" alt="No Items In Cart"><br><br><a href="' + home + 'shop" class="btn btn-primary text-white mx-1"><em class="fa fa-chevron-left  mr-1"></em>' + response.continue_shopping + '</a><a href="' + home + 'cart" class="btn btn-primary text-white"> View Cart <em class="fab fa-opencart text-white"></em></a></div>';
                    $('.mini_cart').html(html);
                }
            }
        });
    });
});
//edit cart quantity
$(function () {
    $(document).on("submit", ".cartEditmini", function (e) {

        var URL = $(location).attr('href');
        $.ajax({
            async: true,
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).closest('form').serialize(),
            dataType: 'json',
            success: function (response) {
                $('.cart_count').html($('<span class="item_count" id="item_count">' + response.totalcart + '</span>'));
                var html = '';
                html += '<div class="cart_gallery">' +
                        '<div class="cart_close"> </div>' +
                        '<table id="myTable" class="table">' +
                        '<tbody>' +
                        '<tr>' +
                        '<td class="mini_cart-subtotal">' +
                        '<span class="mini_cart_close">' +
                        '<a href="#"><em class="fas fa-times"></em></a>' +
                        '</span>' +
                        '<span class="text-right innersubtotal">';
                if (response.subtotal > 0) {
                    html += '<p class="product-name">' + response.total_msg + ' : ' +
                            '<span>' + response.currency + parseFloat(response.subtotal).toFixed(2) + '</span>' +
                            '</p>';
                }
                html += '</span>' +
                        '</td>' +
                        '</tr>';
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
                        if (e.qty > 0 && (e) && (e.unit === 'kg' || e.unit === 'ltr') && e.product_id === product_id) {
                            var stock_bigvarient = e.qty * e.measurement * 1000;
                            cart_stock_cart_page += stock_bigvarient;
                            maxqty = e.stock * 1000;
                        }
                    })
                    var get_cart_stock_cart_page = maxqty - cart_stock_cart_page;
                    html += '<tr class="cart1price">' +
                            '<td class="text-right checktrash cart">' +
                            '<figure class="itemside">' +
                            '<div class="aside">' +
                            '<img src="' + e.image + '" class="img-sm" alt="">' +
                            '</div>' +
                            '<figcaption class="info minicartinfo">' +
                            '<a href="' + home + 'product/' + e.slug + '" class="title text-dark">' + e.name + '</a>' +
                            '<span class="small text-muted">' + e.measurement + ' ' + e.unit + '</span><br/>' +
                            '<span class="price-wrap cartShow">' + qty + '</span>' +
                            '<form action="' + home + 'cart/update/' + e.product_id + '" method="POST" class="cartEdit cartEditmini" >' +
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
                            '<div class="button-container col pr-0 my-1">' +
                            '<button class="cart-qty-minus button-minus" type="button" id="button-minus-' + e.product_variant_id + '" value="-">-</button>' +
                            '<input class="form-control qtyPicker productmodal_qty"  type="number" name="qty" data-min="1" min="1" data-max="' + stock + '" max="' + stock + '" data-max-allowed="' + response.max_cart_items_count + '" value="' + qty + '" readonly>' +
                            '<button class="cart-qty-plus button-plus" type="button" id="button-plus-' + e.product_variant_id + '" value="+">+</button>' +
                            '</div>' +
                            '</form>';
                    if (qty > 1) {


                        if (e.discounted_price > 0) {
                            if (e.tax_percentage > 0) {
                                var tax_price = parseFloat(e.discounted_price) + parseFloat(e.discounted_price * e.tax_percentage / 100);
                                html += 'x<small class="text-muted">' + response.currency + tax_price + ' </small>';
                            } else {
                                html += 'x<small class="text-muted">' + response.currency + e.discounted_price + ' </small>';
                            }

                        } else {
                            if (e.tax_percentage > 0) {
                                var tax_price = e.price + parseFloat(e.price * e.tax_percentage / 100).toFixed(2);
                                html += 'x<small class="text-muted">' + response.currency + tax_price + ' </small>';
                            } else {
                                html += 'x<small class="text-muted">' + response.currency + e.price + ' </small>';
                            }

                        }
                    }

                    html +=
                            '</figcaption>' +
                            '</figure>' +
                            '<div class="price-wrap">' +
                            '<var class="price">';
                    if (e.discounted_price > 0) {
                        if (e.tax_percentage > 0) {
                            var tax_price = parseFloat(e.discounted_price) + parseFloat(e.discounted_price * e.tax_percentage / 100);
                            html += response.currency + parseFloat(tax_price * qty).toFixed(2);
                        } else {
                            html += response.currency + parseFloat(e.discounted_price * qty).toFixed(2);
                        }

                    } else {
                        if (e.tax_percentage > 0) {
                            var tax_price = parseFloat(e.price) + parseFloat(e.price * e.tax_percentage / 100);
                            html += response.currency + parseFloat(tax_price * qty).toFixed(2);
                        } else {
                            html += response.currency + parseFloat(e.price * qty).toFixed(2);
                        }

                    }

                    html += '</var>' +
                            '</div>' +
                            '<button class="btn btn-light btn-round btnEdit cartShow"><em class="fa fa-pencil-alt"></em></button>' +
                            '<button class="btn btn-light btn-round cartSave cartEdit"><em class="fas fa-check"></em></button>' +
                            '<button class="btn btn-light btn-round btnEdit cartEdit"><em class="fa fa-times"></em></button>' +
                            '<button type="submit" class="btn btn-light btn-round btnDelete cartDelete" data-varient="' + e.product_variant_id + '" ><em class="fas fa-trash-alt"></em></button>' +
                            '</td>' +
                            '</tr>';
                });
                html += '</tbody>' +
                        '<tfoot>' +
                        '<tr>' +
                        '<td colspan="" class="text-right checkoutbtn">' +
                        '<a href="" class="btn btn-primary cartDeleteallmini">' + response.delete_all_msg + ' <em class="fa fa-trash"></em></a>';

                html += '<a href="' + home + 'cart" class="btn btn-primary text-white">View Cart <em class="fab fa-opencart text-white"></em></a>';

                html += '</td>' +
                        '<td colspan="" class="text-right mini_cart-subtotal ">';
                if (response.saved_price > 0) {
                    html += '<p class="product-name text-right">' + response.saved_price_msg + ' : ' + response.currency + parseFloat(response.saved_price).toFixed(2) + '<span></span></p>';
                }
                html += '</td>' +
                        '</tr>' +
                        '</tfoot>' +
                        '</table>' +
                        '</div>';
                $('.mini_cart').html(html);
            }
        });
        e.preventDefault();
    });
});
