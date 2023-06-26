$(document).ready(function () {
    $(".productmodal").click(function (a) {
        a.preventDefault();
        a.stopPropagation();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        var slug = $(this).closest(".inner").find(".slug").val();
        console.log(slug);
        $.ajax({
            url: home + "productajax/" + slug,
            method: "GET",
            cache: false,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function () {
                $("#loader2").show();
            },
            success: function (response) {
                $("#loader2").hide();
                $("#productvariant").modal("show");
                console.log(response);
                var html = "";
                html +=
                        '<div class="row">' +
                        '<div class="col-lg-6 col-md-12 col-12">' +
                        '<div class="product-details-tab">' +
                        '<div id="img-1" class="zoomWrapper single-zoom">' +
                        '<img id="zoom1" class="main_image" src="' +
                        response.product.image +
                        '" alt="" data-zoom-image="' +
                        response.product.image +
                        '">' +
                        "</div>" +
                        ' <div class="single-zoom-thumb">' +
                        '<ul class="s-tab-zoom owl-carousel single-product-active thumb" id="gallery_01">';
                var count_other_image = response.product.other_images.length;
                if (count_other_image > 0) {
                    for (var i = 0; i < count_other_image; i++) {
                        html +=
                                "<li>" +
                                '<a class="elevatezoom-gallery active" data-update="" data-image="' +
                                response.product.other_images[i] +
                                '" data-zoom-image="' +
                                response.product.other_images[i] +
                                '"><img  src="' +
                                response.product.other_images[i] +
                                '" alt=""></a>' +
                                "</li>";
                    }
                }
                html += "</ul>" + "</div>" + "</div>" + "</div>";
                var saving1 = parseFloat(response.product.variants[0].price) - parseFloat(response.product.variants[0].discounted_price);
                var saving1_percentage = parseInt(100 - parseInt((response.product.variants[0].discounted_price * 100) / response.product.variants[0].price));
                html += '<div class=" col-lg-6 col-md-12 col-12">' + '<div class="product_details_right">' + '<form action="#">' + "<h1><a>" + response.title + "</a></h1>" + '<div class="product_ratting">' + "<ul>";
                for (var j = 1; j <= 5; j++) {
                    if (response.product.ratings < j) {
                        if (parseFloat(response.product.ratings) && Math.round(response.product.ratings) == j) {
                            html += '<li><em class="fas fa-star-half-alt"></em></a></li>';
                        } else {
                            html += '<li><em class="far fa-star"></em></li>';
                        }
                    } else {
                        html += '<li><a><em class="fas fa-star"></em></a></li>';
                    }
                }

                html +=
                        "(" +
                        response.product.number_of_ratings +
                        ")<ul>" +
                        "</div>" +
                        '<div class="price_box">' +
                        '<span class="old_price " id="price_mrp_' +
                        response.product.id +
                        '"> ' +
                        response.currency +
                        '<span class="value single_p">' +
                        "</span></span>" +
                        '<span class="current_price" id="price_offer_' +
                        response.product.id +
                        '"> ' +
                        response.currency +
                        '<span class="value">' +
                        "</span></span>" +
                        '<span class="current_price" id="price_regular_' +
                        response.product.id +
                        '"> ' +
                        response.currency +
                        '<span class="value">' +
                        "</span></span>" +
                        '<small class="pro_savings" id="price_savings_' +
                        response.product.id +
                        '"> ' +
                        response.you_save +
                        ": " +
                        response.currency +
                        ' <span class="value">' +
                        saving1.toFixed(2) +
                        " (" +
                        Math.round(saving1_percentage) +
                        "%off)</span></small>" +
                        "</div>" +
                        '<div class="product_desc">' +
                        "<p>" +
                        response.product.description +
                        "</p>" +
                        "</div>" +
                        '<div class="form product_data productmodal_data">' +
                        '<input type="hidden" class="name" name="name" value="' + response.product.name + '" data-name="' + response.product.name + '">' +
                        '<input type="hidden" class="image" name="image" value="' + response.product.image + '" data-image="' + response.product.image + '">' +
                        '<input type="hidden" class="price" name="price" value="" data-price="">' +
                        '<input type="hidden" name="id" class="productmodal_id" value="' +
                        response.product.id +
                        '" data-id="' +
                        response.product.id +
                        '">' +
                        '<input type="hidden" name="type" value="add">' +
                        '<input type="hidden" name="child_id" class="productmodal_varient"  value="' +
                        response.product.variants[0].id +
                        '" id="child_' +
                        response.product.id +
                        '">' +
                        '<div class="product-variant1">' +
                        '<div class="product-variant__label">Available in:</div>' +
                        '<div class="btn-group-toggle variant" data-toggle="buttons" id="varients">';
                var firstSelected = "active";
                var checked = "checked";
                var cart_stock = 0;
                $.each(response.product.variants, function (i, e) {
                    if (e.cart_count > 0 && (e.measurement_unit_name === 'gm' || e.measurement_unit_name === 'ml')) {
                        var stock_smallvarient = e.cart_count * e.measurement;
                        cart_stock += stock_smallvarient;
                    }
                    if (e.cart_count > 0 && (e.measurement_unit_name === 'kg' || e.measurement_unit_name === 'ltr')) {
                        var stock_bigvarient = e.cart_count * (e.measurement * 1000);
                        cart_stock += stock_bigvarient;
                    }
                });
                $.each(response.product.variants, function (i, e) {
                    if(e.stock > 0){
                    html += '<button class="btn product-variant__btn ' + firstSelected + '" data-id="' + response.product.id + '">' + e.measurement + " " + e.measurement_unit_name;
                    if (e.is_flash_sales === "true") {
                        var tax_discounted_price = parseFloat(e.flash_sales[0].discounted_price) + parseFloat((e.flash_sales[0].discounted_price * response.product.tax_percentage) / 100);
                    } else {
                        var tax_discounted_price = parseFloat(e.discounted_price) + parseFloat((e.discounted_price * response.product.tax_percentage) / 100);
                    }
                    var tax_mrp_price = parseFloat(e.price) + parseFloat((e.price * response.product.tax_percentage) / 100);
                    if (tax_discounted_price == 0) {
                        tax_discounted_price = tax_mrp_price;
                        tax_mrp_price = 0;
                    }
                    var saving = parseFloat(tax_mrp_price - tax_discounted_price);
                    var saving1_percentage = parseInt(100 - parseInt((tax_discounted_price * 100) / tax_mrp_price));
                    var max_cart_items_count = parseInt(response.settings.max_cart_items_count);
                    var cart_count = e.cart_count > 0 ? e.cart_count : 0;
                    if (e.stock) {
                        var stock = e.stock;
                    }
                    if (e.type == 'loose') {
                        if (e.stock_unit_name == 'kg' || e.stock_unit_name == 'ltr') {
                            var stock = e.stock * 1000;
                        }
                    }
                    html += '<input type="radio" hidden name="options"  class="productmodal_varient" id="option' + e.id +
                            '" data-varient="' + e.id +
                            '" value="' + e.id +
                            '" data-id="' + e.id +
                            '" data-price="' + parseFloat(tax_discounted_price).toFixed(2) +
                            '" data-tax="' + response.product.tax_percentage +
                            '" data-mrp="' + parseFloat(tax_mrp_price).toFixed(2) +
                            '" data-mrp_number="' + tax_mrp_price.toString().replace("/,/g", "") +
                            '" data-savings="' + parseFloat(saving).toFixed(2) +
                            " ( " + saving1_percentage +
                            ' %Off)" data-stock="' + stock +
                            '" data-max-allowed-stock = "' + max_cart_items_count +
                            '" data-cart_count = "' + cart_count +
                            '" data-varient-name="' + e.measurement_unit_name +
                            '" data-varient-number="' + e.measurement +
                            '" data-varient-type="' + e.type +
                            '" data-cart-stock="' + cart_stock +
                            '" data-qty = "' + cart_count +
                            '" data-main-image="' + response.product.image +
                            '" data-gallery-images = "' + e.images.join(',') + '" autocomplete = "off" ' +
                            ">" +
                            "</button>";
                    if (firstSelected == "active") {
                        firstSelected = "";
                    }
                    if (checked == "checked") {
                        checked = "";
                    }
                }
                });
                html +=
                        "</div>" +
                        "</div><br/>" +
                        '<div class="product_variant quantity productmodal_data">' +
                        "<label>quantity</label>" +
                        '<button class="cart-qty-minus button-minus button-minus-single-page" type="button" id="button-minus" value="-">-</button>' +
                        '<input class="qtyPicker qtyPicker-single-page qty productmodal_qty" id="qtyPicker_' +
                        response.product.id +
                        '"  type="number" name="qty" data-min="1" min="1" data-max="1" max="1" data-max-allowed="1" value="1" readonly>' +
                        '<button class="cart-qty-plus button-plus button-plus-single-page" type="button" id="button-plus" value="+">+</button>' +
                        '<button class="btn btn-primary  outline-inward addtocart" name="submit" type="submit"><em class="fas fa-shopping-cart pr-2"></em>add to cart</button>' +
                        '<li class=" btn ';
                if (response.product.is_favorite == true) {
                    html += "saved";
                } else {
                    html += "save";
                }

                html += '" data-id=' + response.product.id + "> </li>" + "</div>" + "</div>" + '<div class="product_meta">' + '<span>Category: <a href="#">' + response.product.category_name + "</a></span>" + "</div>" + "</form>" + "</div>";
                html += "</div></div>";
                $(".productmodaldetails").html(html);
                jQuery(function () {
                    jQuery(document).ready(function () {
                        setInterval(function () {
                            jQuery(".owl-carousel").owlCarousel({
                                items: 4,
                                loop: false,
                                margin: 10,
                                autoplay: true,
                                autoplayTimeout: 1000,
                                autoplayHoverPause: true,
                                nav: true,
                                navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
                            });
                            $("#zoom1").elevateZoom({
                                gallery: "gallery_01",
                                responsive: true,
                                cursor: "crosshair",
                                zoomWindowWidth: 200,
                                zoomWindowHeight: 300,
                                zoomType: "inner",
                            });
                        }, 150);
                    });
                });


                jQuery(function () {
                    jQuery(".variant .btn:first").click();
                });
            },
        });
    });
});
///////////////////////Sale Quick View//////////////////////////////////

$(document).ready(function () {
    $(".productmodal_sale").click(function (a) {
        a.preventDefault();
        a.stopPropagation();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        var slug = $(this).closest(".inner").find(".slug").val();
        console.log(slug);
        $.ajax({
            url: home + "productajax/" + slug,
            method: "GET",
            cache: false,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function () {
                $("#loader2").show();
            },
            success: function (response) {
                console.log(response);
                $("#loader2").hide();
                $("#productvariant").modal("show");
                var html = "";
                html +=
                        '<div class="row">' +
                        '<div class="col-lg-6 col-md-6 col-12">' +
                        '<div class="product-details-tab">' +
                        '<div id="img-1" class="zoomWrapper single-zoom">' +
                        '<a href="#"><img id="zoom3" src="' +
                        response.product.image +
                        '" alt="" data-zoom-image="' +
                        response.product.image +
                        '" width="200px" height="200px"></a>' +
                        "</div>" +
                        ' <div class="single-zoom-thumb">' +
                        '<ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">';
                var count_other_image = response.product.other_images.length;
                if (count_other_image > 0) {
                    for (var i = 0; i < count_other_image; i++) {
                        html +=
                                "<li>" +
                                '<a class="elevatezoom-gallery active" data-update="" data-image="' +
                                response.product.other_images[i] +
                                '" data-zoom-image="' +
                                response.product.other_images[i] +
                                '"><img  src="' +
                                response.product.other_images[i] +
                                '" alt=""></a>' +
                                "</li>";
                    }
                }
                html += "</ul>" + "</div>" + "</div>" + "</div>";
                var tax_discounted_price1 = parseFloat(response.productsale[0].discounted_price) + parseFloat((response.productsale[0].discounted_price * response.productsale[0].tax_percentage) / 100);
                var tax_mrp_price1 = parseFloat(response.productsale[0].price) + parseFloat((response.productsale[0].price * response.productsale[0].tax_percentage) / 100);
                var saving1 = parseFloat(tax_mrp_price1) - parseFloat(tax_discounted_price1);
                var saving1_percentage = parseInt(100 - parseInt((tax_discounted_price1 * 100) / tax_mrp_price1));
                html += '<div class=" col-lg-6 col-md-6 col-12">' + '<div class="product_details_right">' + '<form action="#">' + "<h1><a>" + response.title + "</a></h1>" + '<div class="product_ratting">' + "<ul>";
                for (var j = 1; j <= 5; j++) {
                    if (response.productsale[0].ratings < j) {
                        if (parseFloat(response.productsale[0].ratings) && Math.round(response.productsale[0].ratings) == j) {
                            html += '<li><em class="fas fa-star-half-alt"></em></a></li>';
                        } else {
                            html += '<li><em class="far fa-star"></em></li>';
                        }
                    } else {
                        html += '<li><a><em class="fas fa-star"></em></a></li>';
                    }
                }

                html +=
                        "(" +
                        response.product.number_of_ratings +
                        ")<ul>" +
                        "</div>" +
                        '<div class="price_box">' +
                        '<span class="current_price " id="price_offer_' +
                        response.product.id +
                        '"> ' +
                        response.currency +
                        '<span class="value">' +
                        parseFloat(tax_discounted_price1).toFixed(2) +
                        "</span></span>" +
                        '<span class="old_price" id="price_mrp_' +
                        response.product.id +
                        '"> ' +
                        response.currency +
                        '<span class="value single_p">' +
                        parseFloat(tax_mrp_price1).toFixed(2) +
                        "</span></span>" +
                        '<small class="pro_savings" id="price_savings_' +
                        response.product.id +
                        '"> ' +
                        response.you_save +
                        ": " +
                        response.currency +
                        ' <span class="value">' +
                        saving1.toFixed(2) +
                        " (" +
                        Math.round(saving1_percentage) +
                        "%off)</span></small>" +
                        "</div>" +
                        '<div class="product_desc">' +
                        "<p>" +
                        response.productsale[0].description +
                        "</p>" +
                        "</div>" +
                        '<div class="form product_data productmodal_data">' +
                        '<input type="hidden" name="id" class="productmodal_id" value="' +
                        response.productsale[0].id +
                        '" data-id="' +
                        response.productsale[0].id +
                        '">' +
                        '<input type="hidden" name="type" value="add">' +
                        '<input type="hidden" name="child_id" class="productmodal_varient"  value="' +
                        response.productsale[0].variants[0].id +
                        '" id="child_' +
                        response.productsale[0].id +
                        '">' +
                        '<div class="product-variant1">' +
                        '<div class="product-variant__label">Available in:</div>' +
                        '<div class="btn-group-toggle variant" data-toggle="buttons">';
                var firstSelected = "active";
                var checked = "checked";
                var cart_stock = 0;
                $.each(response.product.variants, function (i, e) {
                    if (e.cart_count > 0 && (e.measurement_unit_name === 'gm' || e.measurement_unit_name === 'ml')) {
                        var stock_smallvarient = e.cart_count * e.measurement;
                        cart_stock += stock_smallvarient;
                    }
                    if (e.cart_count > 0 && (e.measurement_unit_name === 'kg' || e.measurement_unit_name === 'ltr')) {
                        var stock_bigvarient = e.cart_count * (e.measurement * 1000);
                        cart_stock += stock_bigvarient;
                    }
                });
                $.each(response.product.variants, function (i, e) {
                    html += '<button class="btn product-variant__btn ' + firstSelected + '" data-id="' + response.product.id + '">' + e.measurement + " " + e.measurement_unit_name;
                    if (e.is_flash_sales === "true") {
                        var tax_discounted_price = parseFloat(e.flash_sales[0].discounted_price) + parseFloat((e.flash_sales[0].discounted_price * response.product.tax_percentage) / 100);
                    } else {
                        var tax_discounted_price = parseFloat(e.discounted_price) + parseFloat((e.discounted_price * response.product.tax_percentage) / 100);
                    }
                    var tax_mrp_price = parseFloat(e.price) + parseFloat((e.price * response.product.tax_percentage) / 100);
                    if (tax_discounted_price === 0) {
                        tax_discounted_price = tax_mrp_price;
                        tax_mrp_price = 0;
                    }
                    var saving = parseFloat(tax_mrp_price - tax_discounted_price);
                    var saving1_percentage = parseInt(100 - parseInt((tax_discounted_price * 100) / tax_mrp_price));
                    var max_cart_items_count = parseInt(response.settings.max_cart_items_count);
                    var cart_count = e.cart_count > 0 ? e.cart_count : 0;
                    if (e.stock) {
                        var stock = e.stock;
                    }
                    if (e.type == 'loose') {
                        if (e.stock_unit_name == 'kg' || e.stock_unit_name == 'ltr') {
                            var stock = e.stock * 1000;
                        }
                    }
                    html += '<input type="radio" hidden name="options"  class="productmodal_varient" id="option' + e.id +
                            '" data-varient="' + e.id +
                            '" value="' + e.id +
                            '" data-id="' + e.id +
                            '" data-price="' + parseFloat(tax_discounted_price).toFixed(2) +
                            '" data-tax="' + response.product.tax_percentage +
                            '" data-mrp="' + parseFloat(tax_mrp_price).toFixed(2) +
                            '" data-mrp_number="' + tax_mrp_price.toString().replace("/,/g", "") +
                            '" data-savings="' + parseFloat(saving).toFixed(2) +
                            " ( " + saving1_percentage +
                            ' %Off)" data-stock="' + stock +
                            '" data-max-allowed-stock = "' + max_cart_items_count +
                            '" data-cart_count = "' + cart_count +
                            '" data-varient-name="' + e.measurement_unit_name +
                            '" data-varient-number="' + e.measurement +
                            '" data-varient-type="' + e.type +
                            '" data-cart-stock="' + cart_stock +
                            '" data-qty = "' + cart_count + '" autocomplete = "off" ' +
                            ">" +
                            "</button>";
                    if (firstSelected == "active") {
                        firstSelected = "";
                    }
                    if (checked == "checked") {
                        checked = "";
                    }
                });
                html +=
                        "</div>" +
                        "</div><br/>" +
                        '<div class="product_variant quantity productmodal_data">' +
                        "<label>quantity</label>" +
                        '<input class="qtyPicker qty productmodal_qty" id="qtyPicker_' +
                        response.product.id +
                        '"  type="number" name="qty" data-min="1" min="1" data-max="' +
                        response.product.variants[0].stock +
                        '" max="' +
                        response.product.variants[0].stock +
                        '" value="1">' +
                        '<button class="btn btn-primary  outline-inward addtocart" name="submit" type="submit"><em class="fas fa-shopping-cart pr-2"></em>add to cart</button>' +
                        '<li class=" btn ';
                if (response.product.is_favorite == true) {
                    html += "saved";
                } else {
                    html += "save";
                }
                html += '" data-id=' + response.product.id + "> </li>" + "</div>" + "</div>" + '<div class="product_meta">' + '<span>Category: <a href="#">' + response.product.category_name + "</a></span>" + "</div>" + "</form>" + "</div>";
                html += "</div></div>";
                $(".productmodaldetails").html(html);
                jQuery(function () {
                    jQuery(document).ready(function () {
                        setInterval(function () {
                            jQuery(".owl-carousel").owlCarousel({
                                items: 4,
                                loop: false,
                                margin: 10,
                                autoplay: true,
                                autoplayTimeout: 1000,
                                autoplayHoverPause: true,
                                nav: true,
                                navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
                            });
                        }, 150);
                    });
                });
                $("#zoom3").elevateZoom({
                    gallery: "gallery_01",
                    responsive: true,
                    cursor: "crosshair",
                    zoomType: "inner",
                });
                $(window).resize(function (e) {
                    $(".zoomContainer").remove();
                    $("#zoom3").elevateZoom({
                        gallery: "gallery_01",
                        responsive: true,
                        cursor: "crosshair",
                        zoomType: "inner",
                    });
                });
            },
        });
    });
});
////////////Add to cart Single product///////////////////////////////////////////////////////////////////
$(document).ready(function () {
    $(".addtocart_single").click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        var id = $(this).closest(".product_data").find(".id").val();
        var varient = $(this).closest(".product_data").find(".varient").val();
        var qty = $(this).closest(".product_data").find(".qty").val();
        var name = $(this).closest(".product_data").find(".name").val();
        var image = $(this).closest(".product_data").find(".image").val();
        var price = $(this).closest(".product_data").find(".price").val();
        $.ajax({
            url: home + "cart/single/addajax",
            method: "POST",
            cache: false,
            dataType: "json",
            data: {
                id: id,
                varient: varient,
                qty: qty,
                name: name,
                image: image,
                price: price
            },
            success: function (response) {
                console.log(response);
                if (response.status) {
                    $(".cart_count").html($('<span class="item_count" id="item_count">' + response.totalcart + "</span>"));
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
    $(document).on("click", ".addtocart", function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
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
                    $(".cart_count").html($('<span class="item_count" id="item_count">' + response.totalcart + "</span>"));
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
    $(document).on("click", ".addtocart", function (e) {
        setTimeout(function () {
            e.preventDefault();
            var data = {
                _token: $("input[name=_token]").val(),
            };
            $.ajax({
                url: home + "cartajax",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    var html = "";
                    html +=
                            '<div class="cart_gallery">' +
                            '<div class="cart_close"> </div>' +
                            '<table id="myTable" class="table">' +
                            "<tbody>" +
                            "<tr>" +
                            '<td class="mini_cart-subtotal">' +
                            '<span class="mini_cart_close">' +
                            '<a href="#"><em class="fas fa-times"></em></a>' +
                            "</span>" +
                            '<span class="text-end innersubtotal">';
                    if (response.subtotal > 0) {
                        html += '<p class="product-name">' + response.total_msg + " : " + "<span>" + response.currency + parseFloat(response.subtotal).toFixed(2) + "</span>" + "</p>";
                    }

                    html += "</span>" + "</td>" + "</tr>";
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
                        html +=
                                '<tr class="cart1price">' +
                                '<td class="text-end checktrash cart">' +
                                '<figure class="itemside">' +
                                '<div class="aside">' +
                                '<img src="' +
                                e.image +
                                '" class="img-sm" alt="">' +
                                "</div>" +
                                '<figcaption class="info minicartinfo">' +
                                '<a href="" class="title text-dark">' +
                                e.name +
                                "</a>" +
                                '<span class="small text-muted">' +
                                e.measurement +
                                " " +
                                e.unit +
                                "</span><br/>" +
                                '<span class="price-wrap cartShow">' +
                                qty +
                                "</span>" +
                                '<form action="' +
                                home +
                                "cart/update/" +
                                e.product_id +
                                '" method="POST" class="cartEdit cartEditmini" >' +
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
                                '<input type="hidden" name="child_id" value="' +
                                e.product_variant_id +
                                '">' +
                                '<input type="hidden" name="product_id" value="' +
                                e.product_id +
                                '">' +
                                '<div class="button-container col pr-0 my-1">' +
                                '<button class="cart-qty-minus button-minus" type="button" id="button-minus" value="-">-</button>' +
                                '<input class="form-control qtyPicker productmodal_qty"  type="number" name="qty" data-min="1" min="1" data-max="' +
                                e.stock +
                                '" max="' +
                                e.stock +
                                '" data-max-allowed="' +
                                response.max_cart_items_count +
                                '" value="' +
                                qty +
                                '" readonly>' +
                                '<button class="cart-qty-plus button-plus" type="button" id="button-plus" value="+">+</button>' +
                                "</div>" +
                                "</form>";
                        if (qty > 1) {
                            if (e.discounted_price > 0) {
                                if (e.tax_percentage > 0) {
                                    var tax_price = parseFloat(e.discounted_price) + ((parseFloat(e.discounted_price) * parseFloat(e.tax_percentage)) / 100);
                                    html += 'x<small class="text-muted">' + response.currency + tax_price + "</small>";
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + e.discounted_price + " </small>";
                                }
                            } else {
                                if (e.tax_percentage > 0) {
                                    var tax_price = parseFloat(e.price) + ((parseFloat(e.price) * parseFloat(e.tax_percentage)) / 100);
                                    html += 'x<small class="text-muted">' + response.currency + tax_price + "</small>";
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + e.price + " </small>";
                                }
                            }
                        }

                        html += "</figcaption>" + "</figure>" + '<div class="price-wrap">' + '<var class="price">';
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

                        html +=
                                "</var>" +
                                "</div>" +
                                '<button class="btn btn-light btn-round btnEdit cartShow"><em class="fa fa-pencil-alt"></em></button>' +
                                '<button class="btn btn-light btn-round cartSave cartEdit"><em class="fas fa-check"></em></button>' +
                                '<button class="btn btn-light btn-round btnEdit cartEdit"><em class="fa fa-times"></em></button>' +
                                '<button type="submit" class="btn btn-light btn-round btnDelete cartDelete" data-varient="' +
                                e.product_variant_id +
                                '" ><em class="fas fa-trash-alt"></em></button>' +
                                "</td>" +
                                "</tr>";
                    });
                    html += "</tbody>" + "<tfoot>";
                    html +=
                            "<tr>" +
                            '<td colspan="" class="text-end checkoutbtn">' +
                            '<a href="" class="btn btn-primary cartDeleteallmini">' +
                            response.delete_all_msg +
                            ' <em class="fa fa-trash"></em></a><a href="' +
                            home +
                            'cart" class="btn btn-primary text-white">View Cart<em class="fab fa-opencart text-white"></em></a>';
                    html += "</td>" + '<td colspan="" class="text-end mini_cart-subtotal ">';
                    if (response.saved_price > 0) {
                        html += '<p class="product-name text-end">' + response.saved_price_msg + " : " + response.currency + parseFloat(response.saved_price).toFixed(2) + "<span></span></p>";
                    }
                    html += "</td>" + "</tr>";
                    html += "</tfoot>" + "</table>" + "</div>";
                    $(".mini_cart").html(html);
                },
            });
        }, 2000);
    });
});
///////////////////// GET Count of cart/////////////////////////////////
$(document).ready(function () {
    $(".addtocart_single").click(function (e) {
        setTimeout(function () {
            e.preventDefault();
            e.stopPropagation();
            var data = {
                _token: $("input[name=_token]").val(),
            };
            $.ajax({
                url: home + "cartajax",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    var html = "";
                    html +=
                            '<div class="cart_gallery">' +
                            '<div class="cart_close"> </div>' +
                            '<table id="myTable" class="table">' +
                            "<tbody>" +
                            "<tr>" +
                            '<td class="mini_cart-subtotal">' +
                            '<span class="mini_cart_close">' +
                            '<a href="#"><em class="fas fa-times"></em></a>' +
                            "</span>" +
                            '<span class="text-end innersubtotal">';
                    if (response.subtotal > 0) {
                        html += '<p class="product-name">' + response.total_msg + " : " + "<span>" + response.currency + parseFloat(response.subtotal).toFixed(2) + "</span>" + "</p>";
                    }

                    html += "</span>" + "</td>" + "</tr>";
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
                        html +=
                                '<tr class="cart1price">' +
                                '<td class="text-end checktrash cart">' +
                                '<figure class="itemside">' +
                                '<div class="aside">' +
                                '<img src="' +
                                e.image +
                                '" class="img-sm" alt="">' +
                                "</div>" +
                                '<figcaption class="info minicartinfo">' +
                                '<a href="" class="title text-dark">' +
                                e.name +
                                "</a>" +
                                '<span class="small text-muted">' +
                                e.measurement +
                                " " +
                                e.unit +
                                "</span><br/>" +
                                '<span class="price-wrap cartShow">' +
                                qty +
                                "</span>" +
                                '<form action="' +
                                home +
                                "cart/update/" +
                                e.product_id +
                                '" method="POST" class="cartEdit cartEditmini" >' +
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
                                '<input type="hidden" name="child_id" value="' +
                                e.product_variant_id +
                                '">' +
                                '<input type="hidden" name="product_id" value="' +
                                e.product_id +
                                '">' +
                                '<div class="button-container col pr-0 my-1">' +
                                '<button class="cart-qty-minus button-minus" type="button" id="button-minus" value="-">-</button>' +
                                '<input class="form-control qtyPicker productmodal_qty"  type="number" name="qty" data-min="1" min="1" data-max="' +
                                e.stock +
                                '" max="' +
                                e.stock +
                                '" data-max-allowed="' +
                                response.max_cart_items_count +
                                '" value="' +
                                qty +
                                '" readonly>' +
                                '<button class="cart-qty-plus button-plus" type="button" id="button-plus" value="+">+</button>' +
                                "</div>" +
                                "</form>";
                        if (qty > 1) {
                            if (e.discounted_price > 0) {
                                if (e.tax_percentage > 0) {
                                    var tax_price = parseFloat(e.discounted_price) + ((parseFloat(e.discounted_price) * parseFloat(e.tax_percentage)) / 100);
                                    html += 'x<small class="text-muted">' + response.currency + tax_price + "</small>";
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + e.discounted_price + " </small>";
                                }
                            } else {
                                if (e.tax_percentage > 0) {
                                    var tax_price = parseFloat(e.price) + ((parseFloat(e.price) * parseFloat(e.tax_percentage)) / 100);
                                    html += 'x<small class="text-muted">' + response.currency + tax_price + "</small>";
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + e.price + " </small>";
                                }
                            }
                        }

                        html += "</figcaption>" + "</figure>" + '<div class="price-wrap">' + '<var class="price">';
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

                        html +=
                                "</var>" +
                                "</div>" +
                                '<button class="btn btn-light btn-round btnEdit cartShow"><em class="fa fa-pencil-alt"></em></button>' +
                                '<button class="btn btn-light btn-round cartSave cartEdit"><em class="fas fa-check"></em></button>' +
                                '<button class="btn btn-light btn-round btnEdit cartEdit"><em class="fa fa-times"></em></button>' +
                                '<button type="submit" class="btn btn-light btn-round btnDelete cartDelete" data-varient="' +
                                e.product_variant_id +
                                '" ><em class="fas fa-trash-alt"></em></button>' +
                                "</td>" +
                                "</tr>";
                    });
                    html += "</tbody>" + "<tfoot>";
                    html +=
                            "<tr>" +
                            '<td colspan="" class="text-end checkoutbtn">' +
                            '<a href="" class="btn btn-primary cartDeleteallmini">' +
                            response.delete_all_msg +
                            ' <em class="fa fa-trash"></em></a><a href="' +
                            home +
                            'cart" class="btn btn-primary text-white">View Cart<em class="fab fa-opencart text-white"></em></a>';
                    html += "</td>" + '<td colspan="" class="text-end mini_cart-subtotal ">';
                    if (response.saved_price > 0) {
                        html += '<p class="product-name text-end">' + response.saved_price_msg + " : " + response.currency + parseFloat(response.saved_price).toFixed(2) + "<span></span></p>";
                    }
                    html += "</td>" + "</tr>";
                    html += "</tfoot>" + "</table>" + "</div>";
                    $(".mini_cart").html(html);
                },
            });
        }, 2000);
    });
});
// Delete Cart Data
$(function () {
    $(document).on("click", ".cartDelete", function (e) {
        e.preventDefault();
        var varient = $(this).data("varient");
        var data = {
            _token: $("input[name=_token]").val(),
            varient: varient,
        };
        $.ajax({
            url: home + "cart/remove/" + varient,
            type: "GET",
            dataType: "json",
            success: function (response) {
                     $(".cart_count").html($('<span class="item_count" id="item_count">' + response.totalcart + "</span>"));
                alertify.set("notifier", "position", "top-right");
                alertify.success(response.status);
                console.log(response);
                if (response.subtotal > 0) {
                    var html = "";
                    html +=
                            '<div class="cart_gallery">' +
                            '<div class="cart_close"> </div>' +
                            '<table id="myTable" class="table">' +
                            "<tbody>" +
                            "<tr>" +
                            '<td class="mini_cart-subtotal">' +
                            '<span class="mini_cart_close">' +
                            '<a href="#"><em class="fas fa-times"></em></a>' +
                            "</span>" +
                            '<span class="text-end innersubtotal">';
                    if (response.subtotal > 0) {
                        html += '<p class="product-name">' + response.total_msg + " : " + "<span>" + response.currency + parseFloat(response.subtotal).toFixed(2) + "</span>" + "</p>";
                    }

                    html += "</span>" + "</td>" + "</tr>";
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
                        html +=
                                '<tr class="cart1price">' +
                                '<td class="text-end checktrash cart">' +
                                '<figure class="itemside">' +
                                '<div class="aside">' +
                                '<img src="' +
                                e.image +
                                '" class="img-sm" alt="">' +
                                "</div>" +
                                '<figcaption class="info minicartinfo">' +
                                '<a href="" class="title text-dark">' +
                                e.name +
                                "</a>" +
                                '<span class="small text-muted">' +
                                e.measurement +
                                " " +
                                e.unit +
                                "</span><br/>" +
                                '<span class="price-wrap cartShow">' +
                                qty +
                                "</span>" +
                                '<form action="' +
                                home +
                                "cart/update/" +
                                e.product_id +
                                '" method="POST" class="cartEdit cartEditmini" >' +
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
                                '<input type="hidden" name="child_id" value="' +
                                e.product_variant_id +
                                '">' +
                                '<input type="hidden" name="product_id" value="' +
                                e.product_id +
                                '">' +
                                '<div class="button-container col pr-0 my-1">' +
                                '<button class="cart-qty-minus button-minus" type="button" id="button-minus" value="-">-</button>' +
                                '<input class="form-control qtyPicker productmodal_qty"  type="number" name="qty" data-min="1" min="1" data-max="' +
                                e.stock +
                                '" max="' +
                                e.stock +
                                '" data-max-allowed="' +
                                response.max_cart_items_count +
                                '" value="' +
                                qty +
                                '" readonly>' +
                                '<button class="cart-qty-plus button-plus" type="button" id="button-plus" value="+">+</button>' +
                                "</div>" +
                                "</form>";
                        if (qty > 1) {
                            if (e.discounted_price > 0) {
                                if (e.tax_percentage > 0) {
                                    var tax_price = parseFloat(e.discounted_price) + ((parseFloat(e.discounted_price) * parseFloat(e.tax_percentage)) / 100);
                                    html += 'x<small class="text-muted">' + response.currency + tax_price + "</small>";
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + e.discounted_price + " </small>";
                                }
                            } else {
                                if (e.tax_percentage > 0) {
                                    var tax_price = parseFloat(e.price) + ((parseFloat(e.price) * parseFloat(e.tax_percentage)) / 100);
                                    html += 'x<small class="text-muted">' + response.currency + tax_price + "</small>";
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + e.price + " </small>";
                                }
                            }
                        }

                        html += "</figcaption>" + "</figure>" + '<div class="price-wrap">' + '<var class="price">';
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

                        html +=
                                "</var>" +
                                "</div>" +
                                '<button class="btn btn-light btn-round btnEdit cartShow"><em class="fa fa-pencil-alt"></em></button>' +
                                '<button class="btn btn-light btn-round cartSave cartEdit"><em class="fas fa-check"></em></button>' +
                                '<button class="btn btn-light btn-round btnEdit cartEdit"><em class="fa fa-times"></em></button>' +
                                '<button type="submit" class="btn btn-light btn-round btnDelete cartDelete" data-varient="' +
                                e.product_variant_id +
                                '" ><em class="fas fa-trash-alt"></em></button>' +
                                "</td>" +
                                "</tr>";
                    });
                    html += "</tbody>" + "<tfoot>";
                    html +=
                            "<tr>" +
                            '<td colspan="" class="text-end checkoutbtn">' +
                            '<a href="" class="btn btn-primary cartDeleteallmini">' +
                            response.delete_all_msg +
                            ' <em class="fa fa-trash"></em></a><a href="' +
                            home +
                            'cart" class="btn btn-primary text-white">View Cart<em class="fab fa-opencart text-white"></em></a>';
                    html += "</td>" + '<td colspan="" class="text-end mini_cart-subtotal ">';
                    if (response.saved_price > 0) {
                        html += '<p class="product-name text-end">' + response.saved_price_msg + " : " + response.currency + parseFloat(response.saved_price).toFixed(2) + "<span></span></p>";
                    }
                    html += "</td>" + "</tr>";
                    html += "</tfoot>" + "</table>" + "</div>";
                    $(".mini_cart").html(html);
                } else {
                    var html = "";
                    html +=
                            '<span class="mini_cart_close"><a href="#"><em class="fas fa-times"></em></a></span><div class="text-center"><img src="' +
                            response.empty_card_img +
                            '" alt="No Items In Cart"><br><br><a href="/shop" class="btn btn-primary text-white mx-1"><em class="fa fa-chevron-left  mr-1"></em>' +
                            response.continue_shopping +
                            '</a><a href="/cart" class="btn btn-primary text-white"><em class="fab fa-opencart  mr-1"></em> View Cart</a></div>';
                    $(".mini_cart").html(html);
                }
             },
        });
    });
});
// Delete ALL DATA Cart Data
$(function () {
    $(document).on("click", ".cartDeleteallmini", function (e) {
        e.preventDefault();
        var varient = "all";
        var data = {
            _token: $("input[name=_token]").val(),
            varient: varient,
        };
        $.ajax({
            url: home + "cart/remove/" + varient,
            type: "GET",
            dataType: "json",
           success: function (response) {
                    var html = "";
                    html +=
                            '<div class="cart_gallery">' +
                            '<div class="cart_close"> </div>' +
                            '<table id="myTable" class="table">' +
                            "<tbody>" +
                            "<tr>" +
                            '<td class="mini_cart-subtotal">' +
                            '<span class="mini_cart_close">' +
                            '<a href="#"><em class="fas fa-times"></em></a>' +
                            "</span>" +
                            '<span class="text-end innersubtotal">';
                    if (response.subtotal > 0) {
                        html += '<p class="product-name">' + response.total_msg + " : " + "<span>" + response.currency + parseFloat(response.subtotal).toFixed(2) + "</span>" + "</p>";
                    }

                    html += "</span>" + "</td>" + "</tr>";
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
                        html +=
                                '<tr class="cart1price">' +
                                '<td class="text-end checktrash cart">' +
                                '<figure class="itemside">' +
                                '<div class="aside">' +
                                '<img src="' +
                                e.image +
                                '" class="img-sm" alt="">' +
                                "</div>" +
                                '<figcaption class="info minicartinfo">' +
                                '<a href="" class="title text-dark">' +
                                e.name +
                                "</a>" +
                                '<span class="small text-muted">' +
                                e.measurement +
                                " " +
                                e.unit +
                                "</span><br/>" +
                                '<span class="price-wrap cartShow">' +
                                qty +
                                "</span>" +
                                '<form action="' +
                                home +
                                "cart/update/" +
                                e.product_id +
                                '" method="POST" class="cartEdit cartEditmini" >' +
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
                                '<input type="hidden" name="child_id" value="' +
                                e.product_variant_id +
                                '">' +
                                '<input type="hidden" name="product_id" value="' +
                                e.product_id +
                                '">' +
                                '<div class="button-container col pr-0 my-1">' +
                                '<button class="cart-qty-minus button-minus" type="button" id="button-minus" value="-">-</button>' +
                                '<input class="form-control qtyPicker productmodal_qty"  type="number" name="qty" data-min="1" min="1" data-max="' +
                                e.stock +
                                '" max="' +
                                e.stock +
                                '" data-max-allowed="' +
                                response.max_cart_items_count +
                                '" value="' +
                                qty +
                                '" readonly>' +
                                '<button class="cart-qty-plus button-plus" type="button" id="button-plus" value="+">+</button>' +
                                "</div>" +
                                "</form>";
                        if (qty > 1) {
                            if (e.discounted_price > 0) {
                                if (e.tax_percentage > 0) {
                                    var tax_price = parseFloat(e.discounted_price) + ((parseFloat(e.discounted_price) * parseFloat(e.tax_percentage)) / 100);
                                    html += 'x<small class="text-muted">' + response.currency + tax_price + "</small>";
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + e.discounted_price + " </small>";
                                }
                            } else {
                                if (e.tax_percentage > 0) {
                                    var tax_price = parseFloat(e.price) + ((parseFloat(e.price) * parseFloat(e.tax_percentage)) / 100);
                                    html += 'x<small class="text-muted">' + response.currency + tax_price + "</small>";
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + e.price + " </small>";
                                }
                            }
                        }

                        html += "</figcaption>" + "</figure>" + '<div class="price-wrap">' + '<var class="price">';
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

                        html +=
                                "</var>" +
                                "</div>" +
                                '<button class="btn btn-light btn-round btnEdit cartShow"><em class="fa fa-pencil-alt"></em></button>' +
                                '<button class="btn btn-light btn-round cartSave cartEdit"><em class="fas fa-check"></em></button>' +
                                '<button class="btn btn-light btn-round btnEdit cartEdit"><em class="fa fa-times"></em></button>' +
                                '<button type="submit" class="btn btn-light btn-round btnDelete cartDelete" data-varient="' +
                                e.product_variant_id +
                                '" ><em class="fas fa-trash-alt"></em></button>' +
                                "</td>" +
                                "</tr>";
                    });
                    html += "</tbody>" + "<tfoot>";
                    html +=
                            "<tr>" +
                            '<td colspan="" class="text-end checkoutbtn">' +
                            '<a href="" class="btn btn-primary cartDeleteallmini">' +
                            response.delete_all_msg +
                            ' <em class="fa fa-trash"></em></a><a href="' +
                            home +
                            'cart" class="btn btn-primary text-white">View Cart<em class="fab fa-opencart text-white"></em></a>';
                    html += "</td>" + '<td colspan="" class="text-end mini_cart-subtotal ">';
                    if (response.saved_price > 0) {
                        html += '<p class="product-name text-end">' + response.saved_price_msg + " : " + response.currency + parseFloat(response.saved_price).toFixed(2) + "<span></span></p>";
                    }
                    html += "</td>" + "</tr>";
                    html += "</tfoot>" + "</table>" + "</div>";
                    $(".mini_cart").html(html);
                },
        });
    });
});
//edit cart quantity
$(function () {
    $(document).on("submit", ".cartEditmini", function (e) {
        var URL = $(location).attr("href");
        $.ajax({
            async: true,
            type: "POST",
            url: $(this).attr("action"),
            data: $(this).closest("form").serialize(),
            dataType: "json",
            success: function (response) {
                console.log(response);
                    var html = "";
                    html +=
                            '<div class="cart_gallery">' +
                            '<div class="cart_close"> </div>' +
                            '<table id="myTable" class="table">' +
                            "<tbody>" +
                            "<tr>" +
                            '<td class="mini_cart-subtotal">' +
                            '<span class="mini_cart_close">' +
                            '<a href="#"><em class="fas fa-times"></em></a>' +
                            "</span>" +
                            '<span class="text-end innersubtotal">';
                    if (response.subtotal > 0) {
                        html += '<p class="product-name">' + response.total_msg + " : " + "<span>" + response.currency + parseFloat(response.subtotal).toFixed(2) + "</span>" + "</p>";
                    }

                    html += "</span>" + "</td>" + "</tr>";
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
                        html +=
                                '<tr class="cart1price">' +
                                '<td class="text-end checktrash cart">' +
                                '<figure class="itemside">' +
                                '<div class="aside">' +
                                '<img src="' +
                                e.image +
                                '" class="img-sm" alt="">' +
                                "</div>" +
                                '<figcaption class="info minicartinfo">' +
                                '<a href="" class="title text-dark">' +
                                e.name +
                                "</a>" +
                                '<span class="small text-muted">' +
                                e.measurement +
                                " " +
                                e.unit +
                                "</span><br/>" +
                                '<span class="price-wrap cartShow">' +
                                qty +
                                "</span>" +
                                '<form action="' +
                                home +
                                "cart/update/" +
                                e.product_id +
                                '" method="POST" class="cartEdit cartEditmini" >' +
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
                                '<input type="hidden" name="child_id" value="' +
                                e.product_variant_id +
                                '">' +
                                '<input type="hidden" name="product_id" value="' +
                                e.product_id +
                                '">' +
                                '<div class="button-container col pr-0 my-1">' +
                                '<button class="cart-qty-minus button-minus" type="button" id="button-minus" value="-">-</button>' +
                                '<input class="form-control qtyPicker productmodal_qty"  type="number" name="qty" data-min="1" min="1" data-max="' +
                                e.stock +
                                '" max="' +
                                e.stock +
                                '" data-max-allowed="' +
                                response.max_cart_items_count +
                                '" value="' +
                                qty +
                                '" readonly>' +
                                '<button class="cart-qty-plus button-plus" type="button" id="button-plus" value="+">+</button>' +
                                "</div>" +
                                "</form>";
                        if (qty > 1) {
                            if (e.discounted_price > 0) {
                                if (e.tax_percentage > 0) {
                                    var tax_price = parseFloat(e.discounted_price) + ((parseFloat(e.discounted_price) * parseFloat(e.tax_percentage)) / 100);
                                    html += 'x<small class="text-muted">' + response.currency + tax_price + "</small>";
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + e.discounted_price + " </small>";
                                }
                            } else {
                                if (e.tax_percentage > 0) {
                                    var tax_price = parseFloat(e.price) + ((parseFloat(e.price) * parseFloat(e.tax_percentage)) / 100);
                                    html += 'x<small class="text-muted">' + response.currency + tax_price + "</small>";
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + e.price + " </small>";
                                }
                            }
                        }

                        html += "</figcaption>" + "</figure>" + '<div class="price-wrap">' + '<var class="price">';
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

                        html +=
                                "</var>" +
                                "</div>" +
                                '<button class="btn btn-light btn-round btnEdit cartShow"><em class="fa fa-pencil-alt"></em></button>' +
                                '<button class="btn btn-light btn-round cartSave cartEdit"><em class="fas fa-check"></em></button>' +
                                '<button class="btn btn-light btn-round btnEdit cartEdit"><em class="fa fa-times"></em></button>' +
                                '<button type="submit" class="btn btn-light btn-round btnDelete cartDelete" data-varient="' +
                                e.product_variant_id +
                                '" ><em class="fas fa-trash-alt"></em></button>' +
                                "</td>" +
                                "</tr>";
                    });
                    html += "</tbody>" + "<tfoot>";
                    html +=
                            "<tr>" +
                            '<td colspan="" class="text-end checkoutbtn">' +
                            '<a href="" class="btn btn-primary cartDeleteallmini">' +
                            response.delete_all_msg +
                            ' <em class="fa fa-trash"></em></a><a href="' +
                            home +
                            'cart" class="btn btn-primary text-white">View Cart<em class="fab fa-opencart text-white"></em></a>';
                    html += "</td>" + '<td colspan="" class="text-end mini_cart-subtotal ">';
                    if (response.saved_price > 0) {
                        html += '<p class="product-name text-end">' + response.saved_price_msg + " : " + response.currency + parseFloat(response.saved_price).toFixed(2) + "<span></span></p>";
                    }
                    html += "</td>" + "</tr>";
                    html += "</tfoot>" + "</table>" + "</div>";
                    $(".mini_cart").html(html);
                },
        });
        e.preventDefault();
    });
});
