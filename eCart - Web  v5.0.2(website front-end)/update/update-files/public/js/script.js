"use strict";
var nekot='';
var ipa_lru='';
$(document).ready(function() {
    $("body").on("submit", ".addToCart", function() {
        if ($(this).find("select[name=child_id] option:selected").val() == 0) {
            $(this).find("select[name=child_id]").focus().vibrate({
                stopAfterTime: 2
            });
            return false;
        } else {
            return true;
        }
    });
    $("body").on("click", ".button-plus", function() {
        var qP = $(this).parent().parent().find(".qtyPicker");
        var v = $(this).parent().parent().find(".active input[type=radio][name=options]").data();
        console.log(v);
        if(v.varientType=='packet'){
        var cpage_stock = $(this).parent().parent().find(".qtyPicker").data("max");
        var cpage_stock_allowed = $(this).parent().parent().find(".qtyPicker").data("max-allowed");
        var nP = parseInt(qP.val()) + 1;
        if (v) {
            var checkval = v.maxAllowedStock > v.stock ? v.stock : v.maxAllowedStock;
            var stock = v.stock;
            var maxAllowedStock = v.maxAllowedStock;
        } else {
            var checkval = cpage_stock_allowed > cpage_stock ? cpage_stock : cpage_stock_allowed;
            var stock = cpage_stock;
            var maxAllowedStock = cpage_stock_allowed;
        }
        console.log(checkval);
        if (checkval > nP - 1) {
            qP.val(nP);
            $(this).parent().parent().find(".button-minus").removeAttr("disabled");
        } else {
            $(this).attr("disabled", "disabled");
        }
        if (nP - 1 == parseInt(stock)) {
            alertify.set("notifier", "position", "top-center");
            alertify.warning("Oops! Limited stock available.");
        }
        if (nP - 1 == parseInt(maxAllowedStock)) {
            alertify.set("notifier", "position", "top-center");
            alertify.warning("Oops! You reached maximum items allowed in cart.");
        }
        var qty = $(".qtyPicker-single-page").val();
        $(".active input[type=radio][name=options]").attr("data-qty", qty).change();
        }
        //for loose products
        if(v.varientType=='loose'){
        var cpage_stock = $(this).parent().parent().find(".qtyPicker").data("max");
        var varient_name = v.varientName;
        var varient_number = v.varientNumber;
        var used_stock = varient_name == 'kg' || varient_name == 'ltr'  ? 1000 : 1;
        
        if(v.cartStock > 0){
            //pine
        var loose_stock = parseFloat((cpage_stock-v.cartStock) - used_stock*(parseInt(qP.val())-v.qty)*varient_number);
        console.log('this');
        }
        else{
            //beans
           var loose_stock = parseFloat(cpage_stock - used_stock*(parseInt(qP.val()))*varient_number);
        }
        if(v.cartStockCartPage > 0){
         var loose_stock = parseFloat(v.cartStockCartPage - used_stock*((parseInt(qP.val())-v.qty)*varient_number));   
        }
        
        var cpage_stock_allowed = $(this).parent().parent().find(".qtyPicker").data("max-allowed");
        var nP = parseInt(qP.val()) + 1;
        if (v) {
            //for product page
            var checkval = loose_stock;
            var stock = loose_stock;
            var maxAllowedStock = v.maxAllowedStock;
        } else {
            //for cart page
            var checkval = cpage_stock_allowed > cpage_stock ? cpage_stock : cpage_stock_allowed;
            var stock = cpage_stock;
            var maxAllowedStock = cpage_stock_allowed;
        }
        console.log(loose_stock);
        console.log(used_stock);
        console.log(varient_number);
        if (loose_stock+1 > used_stock*varient_number) {
            qP.val(nP);
            $(this).parent().parent().find(".button-minus").removeAttr("disabled");
        } else {
            $(this).attr("disabled", "disabled");
            alertify.set("notifier", "position", "top-center");
            alertify.warning("Oops! Limited stock available.");
        }
        if(loose_stock >= 0){
        $(this).parent().parent().find(".qtyPicker").attr("data-max", loose_stock).change();
        }
        
        if (nP - 1 == parseInt(maxAllowedStock)) {
            alertify.set("notifier", "position", "top-center");
            alertify.warning("Oops! You reached maximum items allowed in cart.");
        }
        var qty = $(".qtyPicker-single-page").val();
        $(".active input[type=radio][name=options]").attr("data-qty", qty).change();
        }
        
    });
    $("body").on("click", ".button-minus", function() {
        var v = $(".active input[type=radio][name=options]").data();
        var qP = $(this).parent().parent().find(".qtyPicker");
        var nP = parseInt(qP.val()) - 1;
        if(v.varientType=='packet'){
        if (qP.data("min") <= nP) {
            qP.val(nP);
            $(this).parent().parent().find(".button-plus").removeAttr("disabled");
            $(this).parent().parent().find(".button-plus-cart").removeAttr("disabled");
        } else {
            $(this).attr("disabled", "disabled");
        }
        var qty = $(".qtyPicker-single-page").val();
        $(".active input[type=radio][name=options]").attr("data-qty", qty).change();
    }
    if(v.varientType=='loose'){
        var cpage_stock = $(this).parent().parent().find(".qtyPicker").data("max");
        var varient_name = v.varientName;
        var varient_number = v.varientNumber;
        var used_stock = varient_name == 'kg' || varient_name == 'ltr'  ? 1000 : 1;
        var loose_stock = parseFloat(cpage_stock - used_stock*(parseInt(qP.val()-1))*varient_number)-v.cartStock;
        console.log(cpage_stock);
        if (qP.data("min") <= nP) {
            qP.val(nP);
            $(this).parent().parent().find(".button-plus").removeAttr("disabled");
            $(this).parent().parent().find(".button-plus-cart").removeAttr("disabled");
        } else {
            $(this).attr("disabled", "disabled");
        }
        var qty = $(".qtyPicker-single-page").val();
        $(".active input[type=radio][name=options]").attr("data-qty", qty).change();
        
        if(loose_stock >= 0){
        $(this).parent().parent().find(".qtyPicker").attr("data-max", loose_stock).change();
        }
    }
    });
    if ($('[data-toggle="tooltip"]').length > 0) {
        $('[data-toggle="tooltip"]').tooltip();
    }
    $("body").on("change", ".addToCart select[name=child_id]", function() {
        var val = $(this).find("option:selected").val();
        if (val > 0) {
            $(".actualPrice").html($(this).find("option:selected").data("price")).show();
            $(".rangePrice").hide();
        } else {
            $(".actualPrice").hide();
            $(".rangePrice").show();
        }
    });
    $("body").on("change", "select[name=child_id]", function() {
        var selected = $(this).find("option:selected");
        $("#productPrice" + $(this).data("id")).html(selected.data("price"));
        if (selected.data("mrp") == "") {
            $("#productMrp" + $(this).data("id")).hide();
        } else {
            $("#productMrp" + $(this).data("id"))
                .html(selected.data("mrp"))
                .show();
        }
        $("#productTitle" + $(this).data("id")).html(selected.text());
        if (selected.data("discount") != "") {
            $("#productDiscount" + $(this).data("id"))
                .html(selected.data("discount"))
                .show();
        } else {
            $("#productDiscount" + $(this).data("id")).hide();
        }
    });
    $(document).on("click", ".btnEdit", function() {
        $(this).closest("tr").find(".cartShow").toggle();
        $(this).closest("tr").find(".cartEdit").toggle();
    });
    $(document).on("click", ".cartSave", function() {
        var tr = $(this).closest("tr");
        if (tr.find("form.cartEdit").find("input[name=qty]").val() == tr.find(".price-wrap.cartShow").html()) {
            tr.find(".cartShow").toggle();
            tr.find(".cartEdit").toggle();
        } else {
            tr.find("form.cartEdit").submit();
        }
    });
    $("#btnRegister").on("click", function(e) {
        $("#cardLogin").hide();
        $("#registerError").hide();
        $("#phone").val("");
        $("#cardRegister input[type=hidden][name=action]").val("1");
        $("#cardRegister").show();
        $("#cardRegister .card-title").html("Register");
        $(".alreadyLogin").show();
        $(".backToLogin").hide();
    });
    $(".btnLogin").on("click", function(e) {
        $("#cardLogin").show();
        $("#cardRegister").hide();
    });
    $("#btnForgot").on("click", function(e) {
        $("#cardLogin").hide();
        $("#registerError").hide();
        $("#phone").val("");
        $("#cardRegister input[type=hidden][name=action]").val("0");
        $("#cardRegister .card-title").html("Forgot Password");
        $("#cardRegister").show();
        $(".alreadyLogin").hide();
        $(".backToLogin").show();
    });
    // search function -->
    $("#searchForm").on("submit", function(e) {
        e.preventDefault();
        var s = $(this).find("input[name=s][type=text]").val().trim();
        if (s != "") {
            window.location.href = $(this).attr("action") + "/" + s;
        }
    });
    // end search function -->

    $(document).on("focus", ".select2-selection.select2-selection--single", function(e) {
        $(this).closest(".select2-container").siblings("select:enabled").select2("open");
    });
    // reset password -->
    $("#formResetPassword").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr("action"),
            type: $(this).attr("method"),
            data: $(this).serialize(),
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status === false) {
                    $("#errorResetPassword").html(data.message).show();
                } else {
                    window.location.href = home;
                }
            },
        });
    });
    // end reset password -->

    $(".ajax-form").on("submit", function(e) {
        e.preventDefault();
        var formResponse = $(this).find(".formResponse");
        formResponse.html("").hide();
        var submit = $(this).find("button[type=submit]");
        submit.attr("disabled", "disabled");
        $.ajax({
            url: $(this).attr("action"),
            type: $(this).attr("method"),
            data: $(this).serialize(),
            success: function(response) {
                console.log(response);
                var data = response;
                if (IsJsonString(response) == true) {
                    data = JSON.parse(response);
                }

                var msg = "Something Went Wrong";
                if (data.error === true) {
                    if (data.message != "") {
                        msg = data.message;
                    }

                    formResponse.html("<div class='alert alert-danger'>" + msg + "</div>").show();
                    submit.removeAttr("disabled");
                } else {
                    msg = "Success";
                    if (data.message != "") {
                        msg = data.message;
                    }

                    formResponse.html("<div class='alert alert-success'>" + msg + "</div>").show();
                }

                if (typeof data.url !== "undefined" && data.url != "") {
                    window.location.href = data.url;
                } else {
                    submit.removeAttr("disabled");
                }
            },
        });
    });
    $("#checkoutProceedBtn").on("click", function(e) {
        e.preventDefault();
        $("#paymentMethodError").html("").hide();
        var selectedPaymentMethod = $("input[type=radio][name=paymentMethod]:checked");
        if (typeof selectedPaymentMethod.val() === "undefined") {
            $("#paymentMethodError").show();
        } else {
            $("#checkoutProceed input[type=hidden][name=paymentMethod]").val(selectedPaymentMethod.val());
            var deliveryTime = $("input[type=radio][name=deliverTime]:checked").val();
            var deliverDay = $("input[type=radio][name=deliverDay]:checked").val();
            $("#checkoutProceed input[type=hidden][name=deliveryTime]").val(deliveryTime + " - " + deliverDay);
        }
    });
    // favourite -->
    $("body").on("click", ".saved", function() {
        var i = $(this);
        i.removeClass("saved").addClass("save");
        var id = i.data("id");
        $.post(
            home + "favourite-post/remove", {
                id: i.data("id"),
            },
            function(data, status) {
                if (data == "login") {
                    $("#myModal").each(function() {
                        $(this).modal("show");
                    });
                } else {
                    try {
                        var r = JSON.parse(data);
                        console.log(data);
                        if ((r.error ?? true) == true) {
                            i.removeClass("saved").addClass("save");
                        }
                    } catch (e) {
                        i.removeClass("saved").addClass("save");
                    }
                }
                $('#fav' + id).fadeOut(200, function() {
                    $(this).remove();
                });
            }
        );
    });
    $("body").on("click", ".save", function() {
        var i = $(this);
        i.removeClass("save").addClass("saved");
        $.post(
            home + "favourite-post/add", {
                id: i.data("id"),
            },
            function(data, status) {
                if (data == "login") {
                    $("#myModal").each(function() {
                        $(this).modal("show");
                    });
                } else {
                    try {
                        var r = JSON.parse(data);
                        console.log(data);
                        if ((r.error ?? true) == true) {
                            i.removeClass("save").addClass("saved");
                        }
                    } catch (e) {
                        i.removeClass("save").addClass("saved");
                    }
                }
            }
        );
    });
    // end favourite -->
    $(document).on("click", ".variant .btn", function(e) {
        e.preventDefault();
        var id = $(this).data("id");
        var v = $(this).find("input[type=radio][name=options]").data();
        console.log(v);
        $("#child_" + id).val(v.id);
        if (v.saleEndTime) {
            $("#product_timing").show();
            $("#product_timing").attr("data-countdown", v.saleEndTime).change();
            $("[data-countdown]").each(function() {
                var $this = $(this),
                    finalDate = $(this).attr("data-countdown");
                $this.countdown(finalDate, function(event) {
                    $this.html(
                        event.strftime(
                            '<div class="countdown_area"><div class="single_countdown"><div class="countdown_number">%D</div><div class="countdown_title">day</div></div><div class="single_countdown"><div class="countdown_number">%H</div><div class="countdown_title">hour</div></div><div class="single_countdown"><div class="countdown_number">%M</div><div class="countdown_title">min</div></div><div class="single_countdown"><div class="countdown_number">%S</div><div class="countdown_title">sec</div></div></div>'
                        )
                    );
                });
            });
        } else {
            $("#product_timing").hide();
        }
        $("#qtyPicker_" + id).attr("data-max", v.stock).change();
        $("#qtyPicker_" + id).attr("data-max-allowed", v.maxAllowedStock).change();
        $("#qtyPicker_" + id).attr("max", v.stock).change();
        $("#qtyPicker_" + id).attr("value", v.cart_count).change();
        $("#qtyPicker_" + id).attr("data-varient-name", v.varientName).change();
        if (v.mrp_number > 0) {
            $("#price_mrp_" + id)
                .show()
                .find(".value")
                .html(v.mrp);
            $("#price_savings_" + id)
                .show()
                .find(".value")
                .html(v.savings);
            $("#price_offer_" + id)
                .show()
                .find(".value")
                .html(v.price)
                .show();
            $("#price_regular_" + id).hide();
        } else {
            $("#price_mrp_" + id).hide();
            $("#price_savings_" + id).hide();
            $("#price_offer_" + id).hide();
            $("#price_regular_" + id).show().find(".value").html(v.price);
        }
        
        var qty = $(this).find("input[type=radio][name=options]").attr("data-cart_count")>1?$(this).find("input[type=radio][name=options]").attr("data-cart_count"):1;
        
        $("#qtyPicker_" + id).val(qty).change();
        $(".button-plus-single-page").removeAttr("disabled");
        $(".button-minus-single-page").removeAttr("disabled");
        
        //varient main image/gallery image
        if(v.galleryImages){
        $(".main_image").attr("src", v.mainImage);
        $(".image").attr("value", v.mainImage);
        $(".image").attr("data-image", v.mainImage);
        var html = '<ul class="reset-ul d-flex flex-wrap list-thumb-gallery">' +
        '<li class="col-sm-3 col-3 thumb-gallery-smallimg"><a class="thumbnail" data-target="#myCarouselArticle" data-slide-to="0">' +
        '<img class="img-fluid" src="' + v.mainImage + '"/>' +
        '</a>' +
        '</li>';

        var gallery_images = v.galleryImages.split(',');
        $.each(gallery_images, function (i, item) {
        html += '<li class="col-sm-3 col-3 thumb-gallery-smallimg"><a class="thumbnail" data-target="#myCarouselArticle" data-slide-to="'+(i+1)+'">' +
                '<img class="img-fluid" src="' + item + '" alt="" /></a></li>';
        });
        html += '</ul>';
       
        $("#slider-thumbs").html(html);
        
        var mainimage_change = '<ol class="carousel-indicators">';
        var gallery_images2 = v.galleryImages.split(',');
        $.each(gallery_images2, function (i, item) {
        mainimage_change += '<li data-target="#myCarouselArticle" data-slide-to="'+i+'"></li>';
        });
        mainimage_change += '</ol><div class="carousel-inner" role="listbox"><div class="carousel-item active"><img class="outerdetailimg" src="' + v.mainImage + '" alt=""></div>';
        
        $.each(gallery_images2, function (i, item) {
        mainimage_change += '<div class="carousel-item"><img class="outerdetailimg" src="' + item + '" alt=""></div>';
        });
        mainimage_change +='</div><a class="carousel-control-prev" href="#myCarouselArticle" role="button" data-slide="prev"><em class="fa fa-angle-left text-dark font-weight-bold"></em></a><a class="carousel-control-next" href="#myCarouselArticle" role="button" data-slide="next"><em class="fa fa-angle-right text-dark font-weight-bold"></em></a>';
       
        $("#myCarouselArticle").html(mainimage_change);
        
     
        }
    });
    $(document).on("click", ".button-plus-single-page", function(e) {
        var v = $(".active input[type=radio][name=options]").data();
        var qtylimit = $(".qtyPicker-single-page").val();
    });
    $("form").each(function(index, value) {
        $(this).find(".variant .btn:first").click();
    });
    $(".qtyPicker").on("change", function() {
        if (parseInt($(this).val()) < 1) {
            $(this).val(1);
        } else if (parseInt($(this).val()) >= $(this).data("max-allowed")) {
            $(this).val($(this).data("max-allowed"));
        }
    });
    $("select[name=varient]").on("change", function(e) {
        var id = $(this).data("id");
        var selected = $(this).find("option:selected");
        $("#price_" + id).html(selected.data("price"));
        $("#mrp_" + id).html(selected.data("mrp"));
        $("#savings_" + id).html(selected.data("savings"));
    });
    $(".footerfix").css("min-height", $(window).height() - 525);
    // home pade side menu category -->
    $("#navContainer").on("click", "li", function() {
        $(this).children("ul").toggleClass("active");
        $("#navContainer li").not(this).children("ul").removeClass("active");
    });
    // sub-header -->
    $(".dropdown").on(
        "hover",
        function() {
            $(this).find(".dropdown-menu").stop(true, true).delay(200).fadeIn(500);
        },
        function() {
            $(this).find(".dropdown-menu").stop(true, true).delay(200).fadeOut(500);
        }
    );
    $("#myCarouselArticle").carousel({
        interval: 10000,
    });
    $("#address").addClass("address-show");
    $("#editAddress").addClass("address-hide");
    $("#addAddress").addClass("address-hide");
    $("#dateError").addClass("error-hide");
    $("#timeError").addClass("error-hide");
    $("#paymentError").addClass("error-hide");
    $("#otp-error").addClass("error-hide");
    $("#otpError").addClass("error-hide");
    $("#errorResetPassword").addClass("error-hide");
    $("#registerError").addClass("error-hide");
    $("#cardOtp").addClass("card-hide");
    $("#cardResetPassword").addClass("card-hide");
    $("#registerError").addClass("error-hide");
    $("#backToLogin").addClass("error-hide");
    $("a[data-confirm]").on("click", function(ev) {
        var href = $(this).attr("href");
        $("#orderConfirm").find(".modal-title").text($(this).attr("data-confirm"));
        $("#modal-btn-yes").attr("href", href);
        $("#orderConfirm").modal({
            show: true
        });
        return false;
    });
    $("a[data-confirm]").on("click", function(ev) {
        var href = $(this).attr("href");
        $("#modal").find(".modal-title").text($(this).attr("data-confirm"));
        $("#modal-btn-yes").attr("href", href);
        $("#modal").modal("show");
        return false;
    });
    $("a[data-bs-confirm]").on("click", function(ev) {
        var href = $(this).attr("href");
        $("#orderConfirm").find(".modal-title").text($(this).attr("data-bs-confirm"));
        $("#modal-btn-yes").attr("href", href);
        $("#orderConfirm").modal({
            show: true
        });
        return false;
    });
    $("a[data-bs-confirm]").on("click", function(ev) {
        var href = $(this).attr("href");
        $("#modal").find(".modal-title").text($(this).attr("data-bs-confirm"));
        $("#modal-btn-yes").attr("href", href);
        $("#modal").modal("show");
        return false;
    });
    $(window).on("scroll", function() {
        if ($(this).scrollTop() > 200) {
            $("#scroll").fadeIn();
        } else {
            $("#scroll").fadeOut();
        }
    });
    $("#scroll").on("click", function() {
        return $("html, body").animate({
            scrollTop: 0
        }, 600);
    });
    // sub categories list and grid view
    $("#list1").click(function(event) {
        event.preventDefault();
        $("#products .item1").addClass("list-group-item");
        $("#products .item1").parent("div").addClass("col-12").removeClass("col-xl-3 col-lg-4 col-md-4 col-sm-6 col-subgrid-3");
    });
    $("#grid1").click(function(event) {
        event.preventDefault();
        $("#products .item1").removeClass("list-group-item");
        $("#products .item1").addClass("grid-group-item").parent("div").addClass("col-lg-4 col-md-4 col-sm-6 col-xl-3 col-subgrid-3").removeClass("col-12");
    });
    // shop page grid and list
    $("#list").click(function(event) {
        event.preventDefault();
        $("#products .item1").addClass("list-group-item");
        $("#products .item1").parent("div").addClass("col-12").removeClass("col-xl-4 col-lg-6 col-md-6 col-sm-6 col-grid-3");
    });
    $("#grid").click(function(event) {
        event.preventDefault();
        $("#products .item1").removeClass("list-group-item");
        $("#products .item1").addClass("grid-group-item").parent("div").addClass("col-lg-6 col-md-6 col-sm-6 col-xl-4 col-grid-3").removeClass("col-12");
    });
    $("#sort").on("change", function(e) {
        $("input[type=hidden][name=sort]").val($(this).val());
        $("#filter").submit();
    });
    $(".subs").on("change", function() {
        var sub_ids = [];
        $(".subs:checked").each(function() {
            sub_ids.push($(this).val());
        });
        if (sub_ids.length > 0) {
            $("#filter input[type=hidden][name=sub-category]").val(sub_ids.join(","));
        } else if (sub_ids.length == 0) {
            $("#filter input[type=hidden][name=sub-category]").val("");
        }
        $("#filter").submit();
    });
    $(".cats").on("change", function() {
        var cat_ids = [];
        $(".cats:checked").each(function() {
            cat_ids.push($(this).val());
        });
        if (cat_ids.length > 0) {
            $("#filter input[type=hidden][name=category]").val(cat_ids.join(","));
        } else if (cat_ids.length == 0) {
            $("#filter input[type=hidden][name=category]").val("");
        }
        $("#filter").submit();
    });
    $(".discount_filter").on("change", function() {
        var discount_ids = [];
        $(".discount_filter:checked").each(function() {
            discount_ids.push($(this).val());
        });
        if (discount_ids.length > 0) {
            $("#filter input[type=hidden][name=discount_filter]").val(discount_ids.join(","));
            $("#filter").submit();
        }
    });
    $(".out_of_stock").on("change", function() {
        var out_of_stock_ids = [];
        $(".out_of_stock:checked").each(function() {
            out_of_stock_ids.push($(this).val());
        });
        if (out_of_stock_ids.length > 0) {
            $("#filter input[type=hidden][name=out_of_stock]").val(out_of_stock_ids.join(","));
            $("#filter").submit();
        }
    });
    var slider = $("#slider-range");
    slider.slider({
        range: true,
        min: slider.data("min"),
        max: slider.data("max"),
        values: [slider.data("selected-min"), slider.data("selected-max")],
        slide: function(event, ui) {
            $("input[type=number][name=min_price]").val(ui.values[0]);
            $("input[type=number][name=max_price]").val(ui.values[1]);
        },
    });
    $("#filter").on("submit", function() {
        $(this).find("button[type=submit]").click();
    });
    // faq
    $(".faq-content .collapse").on("show.bs.collapse", function() {
        var id = $(this).attr("id");
        $('a[href="#' + id + '"]')
            .closest(".panel-heading")
            .addClass("active-accordion");
        $('a[href="#' + id + '"] .panel-title span').html('<i class="fas fa-minus"></i>');
    });
    $(".faq-content .collapse").on("hide.bs.collapse", function() {
        var id = $(this).attr("id");
        $('a[href="#' + id + '"]')
            .closest(".panel-heading")
            .removeClass("active-accordion");
        $('a[href="#' + id + '"] .panel-title span').html('<i class="fas fa-plus"></i>');
    });
});

function loadOptions(element, url, clear = false, open = false, triggerChange = false, selected = 0) {
    if (clear == true) {
        element.find("option").remove();
    }
    $.ajax({
        url: url,
        success: function(response) {
            var data = JSON.parse(response);
            $.each(data, function(id, item) {
                if (element.val() != item.id) {
                    var isSelected = false;
                    if (selected == item.id) {
                        isSelected = true;
                    }
                    element.append(new Option(item.name, item.id, isSelected, isSelected));
                }
            });
            element.select2("close");
            if (open == true) {
                element.select2("open");
            }
            if (triggerChange == true) {
                element.trigger("change");
            }
        },
    });
}

function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

function address() {
    if ($("#address").hasClass("address-show")) {
        $("#addAddress").removeClass("address-hide");
        $("#addAddress").addClass("address-show");
        $("#address").removeClass("address-show");
        $("#address").addClass("address-hide");
    } else {
        $("#editAddress").addClass("address-hide");
        $("#addAddress").addClass("address-show");
    }
}

function copycode() {
    /* Get the text field */
    var copyText = document.getElementById("referCode");
    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /*For mobile devices*/

    /* Copy the text inside the text field */
    document.execCommand("copy");
}

function autocomplete(inp, arr) {
    /*the autocomplete function takes two arguments,
     the text field element and an array of possible autocompleted values:*/
    var currentFocus;
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function(e) {
        var a,
            b,
            i,
            val = this.value;
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) {
            return false;
        }
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        for (i = 0; i < arr.length; i++) {
            var pos = arr[i].toUpperCase().indexOf(val.toUpperCase());
            /*check if the item starts with the same letters as the text field value:*/
            if (pos > -1) {
                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV");
                /*make the matching letters bold:*/
                b.innerHTML = arr[i].substr(0, pos);
                b.innerHTML += "<strong>" + arr[i].substr(pos, val.length) + "</strong>";
                b.innerHTML += arr[i].substr(pos + val.length);
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function(e) {
                    /*insert the value for the autocomplete text field:*/
                    inp.value = this.getElementsByTagName("input")[0].value;
                    /*close the list of autocompleted values,
                     (or any other open lists of autocompleted values:*/
                    closeAllLists();
                });
                a.appendChild(b);
            }
        }
    });
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
             increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 38) {
            //up
            /*If the arrow UP key is pressed,
             decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (x) x[currentFocus].click();
            }
        }
    });

    function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x) return false;
        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = x.length - 1;
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
    }

    function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }

    function closeAllLists(elmnt) {
        /*close all autocomplete lists in the document,
         except the one passed as an argument:*/
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }
    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function(e) {
        closeAllLists(e.target);
    });
}
$(function() {
    $.ajax({
        url: home + "autocomplete",
        method: "GET",
        dataType: "json",
        success: function(response) {
            var availableTags = response;
            /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
            autocomplete(document.getElementById("search"), availableTags);
        },
    });
});
$(document).on("click", ".file-upload", function() {
    var file = $(this).parent().parent().parent().find(".file");
    file.trigger("click");
});
$('input[name="profile"]').on("change", function(e) {
    var fileName = e.target.files[0].name;
    $("#file1").val(fileName);
    var reader = new FileReader();
    reader.onload = function(f) {
        document.getElementById("user_profile").src = f.target.result;
    };
    reader.readAsDataURL(this.files[0]);
});
$(function () {
        $.ajax({
            type: "GET",
            url: home +"nekot",
            success: function (result) {
                 nekot = result;
            },
        });
    });
    
    $(function () {
        $.ajax({
            type: "GET",
            url: home +"ipa_lru",
            success: function (result) {
                 ipa_lru = result;
            },
        });
    });
$("#profile_form").on("submit", function(e) {
    e.preventDefault();
    var fd = new FormData(this);
    if (confirm("Are you sure?")) {
        var files = $("#file")[0].files[0];
        fd.append("profile", files);
        fd.append("accesskey", "90336");
        fd.append("type", "edit-profile");
        $.ajax({
            type: "POST",
            url: ipa_lru+"user-registration.php",
            data: fd,
            dataType: "json",
            headers: {
                Authorization: "Bearer " + nekot,
            },
            beforeSend: function() {
                $("#submit_btn").html("Please wait..");
            },
            contentType: false,
            processData: false,
            success: function(result) {
                console.log(result);
                if (!result["error"]) {
                    $("#submit_btn").html("Update");
                    swal("Success!", result["message"], "success");
                }
            },
        });
    }
});
$("#bank_receipt_form").on("submit", function(e) {
    e.preventDefault();
    var formData = new FormData(this);

    if (confirm("Are you sure?")) {
        $.ajax({
            type: "POST",
            url: ipa_lru + 'order-process.php',
            data: formData,
            dataType: "json",
            headers: {
                Authorization: "Bearer " + nekot,
            },
            beforeSend: function() {
                $("#submit_btn").html("Please wait..");
            },
            contentType: false,
            processData: false,
            success: function(result) {
                console.log(result);
                console.log(result.data[0].attachment);
                if (!result["error"]) {
                    $("#submit_btn").html("Update");
                    swal("Success!", result["message"], "success");
                    var image_add = '';
                    $.each(result.data[0].attachment, function(i, e) {

                        image_add += '<span class="image_data" id="image_data' + e.id + '">' +
                            '<input type="hidden" name="order_id" value="' + result.data[0].id + '" class="order_id">' +
                            '<input type="hidden" name="accesskey" value="90336" class="accesskey">' +
                            '<input type="hidden" name="delete_bank_transfers_attachment" value="1" class="delete_bank_transfers_attachment">' +
                            '<input type="hidden" name="id" value="' + e.id + '" class="id">' +
                            '<a href="' + e.image + '" target="_blank" class="outer_receipt"><img src="' + e.image + '" class="receipt_img img-fluid"></a><i class="fa fa-times attach_image_delete"></i>' +
                            '</span>';
                    });
                    $('.r_attach').html(image_add);
                }
            },
        });
    }
});
$("input[type=radio][name=payment_method]").change(function() {
    var paybtn = document.getElementsByClassName("paybtn");
    var sslbuttons = document.getElementsByClassName("sslbuttons");
    var total_payble = $("input[name='total_payable']").val();
    console.log(total_payble);
    if (this.value == "sslecommerz") {
        if ($("#wallet").prop("checked") == true) {
            if (total_payble == 0) {
                $(paybtn).show();
                $(sslbuttons).hide();
            } else {
                $(paybtn).hide();
                $(sslbuttons).show();
            }
        } else {
            $(paybtn).hide();
            $(sslbuttons).show();
        }
    } else {
        $(paybtn).show();
        $(sslbuttons).hide();
    }

    var ddate = document.getElementsByClassName("deliverDay");
    // console.log(ddate);
});
$("#proceed").on("click", function() {
    var paybtn = document.getElementsByClassName("paybtn");
    var sslbuttons = document.getElementsByClassName("sslbuttons");
    var total_payble = $("input[name='total_payable']").val();
    var sslecommerz = $("input[name='payment_method']:checked").val();
    console.log(sslecommerz);
    if (sslecommerz == "sslecommerz") {
        if ($("#wallet").prop("checked") == true) {
            if (total_payble == 0) {
                $(paybtn).show();
                $(sslbuttons).hide();
            } else {
                $(paybtn).hide();
                $(sslbuttons).show();
            }
        } else {
            $(paybtn).hide();
            $(sslbuttons).show();
        }
    } else {
        $(paybtn).show();
        $(sslbuttons).hide();
    }

    var ddate = document.getElementsByClassName("deliverDay");
    // console.log(ddate);
});
$(document).ready(function() {
    $("img.lazy").lazyload();
});
$("body").on("click", ".button-plus-cart", function() {
    var button_id = $(this).attr("id");
    //console.log(button_id);

    var qP = $(this).parent().parent().find(".qtyPicker");
    var qPdata = qP.data();
    //console.log(qPdata.max);
    var nP = parseInt(qP.val()) + 1;
    var checkval = qPdata.maxAllowed > qPdata.max ? qPdata.max : qPdata.maxAllowed;
    if (checkval > nP - 1) {
        qP.val(nP);
        $(this).parent().parent().find(".button-minus").removeAttr("disabled");
    } else {
        $(this).attr("disabled", "disabled");
    }

    if (nP - 1 == parseInt(qPdata.max)) {
        alertify.set("notifier", "position", "top-center");
        alertify.warning("Oops! Limited stock available.");
    }
    if (nP - 1 == parseInt(qPdata.maxAllowed)) {
        alertify.set("notifier", "position", "top-center");
        alertify.warning("Oops! You reached maximum items allowed in cart.");
    }
});
if (error_code && error_code != null && error_code == 5) {
    $(function() {
        $("#myModal").modal("show");
    });
}
if (refer == 'refer') {
    if (friends_code && friends_code != null) {
        $(function() {
            $("#myModal").modal("show");
        });
    }
}

// lazy load
$(document).ready(function() {
    $("img.lazy").lazyload({
        placeholder: home + "public/images/placeholder.png",
    });
});
$("body").on("click", ".user_deactive_btn", function() {
    alertify.set("notifier", "position", "top-center");
    alertify.warning(msg.Your_Account_is_De_active_ask_on_Customer_Support);
});
if (deactivate_user == "0") {
    $(function() {
        $("button").addClass("disabled");
        $("button").parent("").addClass("user_deactive_btn");
        $(".btn").addClass("disabled");
        $(".btn").parent("").addClass("user_deactive_btn");
        $(".save_for_later").addClass("disabled");
        $(".save_for_later").parent("").addClass("user_deactive_btn");
        $(".move_to_cart").addClass("disabled");
        $(".move_to_cart").parent("").addClass("user_deactive_btn");
    });
}
$("#sslczPayBtn").on("click", function() {
    $("#orderConfirm").modal("hide");
    console.log('orderConfirm');
});
//Bank Transfer Warning show at payment page
$("input[type=radio][name=payment_method]").change(function() {
    if (this.value == "bank_transfer") {
        $('.bank_transfer_warning').show();
    } else {
        $('.bank_transfer_warning').hide();
    }
});
////////////Delete Image receipt from order details///////////////////////////////////////////////////////////////////
$(function() {
    $(document).on('click', '.attach_image_delete', function(e) {

        e.preventDefault();
        e.stopPropagation();
        var accesskey = $(this).closest(".image_data").find(".accesskey").val();
        var delete_bank_transfers_attachment = $(this).closest(".image_data").find(".delete_bank_transfers_attachment").val();
        var order_id = $(this).closest(".image_data").find(".order_id").val();
        var id = $(this).closest(".image_data").find(".id").val();
        console.log(id);
        if (confirm("Are you sure?")) {
            $.ajax({
                method: "POST",
                url: ipa_lru + 'order-process.php',
                data: {
                    accesskey: accesskey,
                    delete_bank_transfers_attachment: delete_bank_transfers_attachment,
                    order_id: order_id,
                    id: id
                },
                headers: {
                    Authorization: "Bearer " + nekot,
                },
                success: function(result) {
                    console.log(result);
                    if (!result["error"]) {

                        swal("Success!", "Image deleted successfully!", "success");

                        $('#image_data' + id).fadeOut(200, function() {
                            $(this).remove();
                        });
                    }
                },
            });
        }
    });
});
$(document).on("click", ".login-popup", function () {
    $("#myModal").modal("show");
});

//cart page-check local pickup or door step delivery
$(document).on("change", "input[type=radio][name=pickup]", function () {
    if (this.value == "door_step_delivery") {
        $('#door_step_delivery').show();
        $('#pickup_from_store').hide();
    } else {
       
        $('#door_step_delivery').hide();
        $('#pickup_from_store').show();
    }
});

