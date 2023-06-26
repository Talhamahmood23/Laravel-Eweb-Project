(function ($) {
    ("use strict");

    /*---stickey menu---*/
    $(window).on('scroll',function() {
        var scroll = $(window).scrollTop();
        if (scroll < 100) {
         $(".sticky-header").removeClass("sticky");
        }else{
         $(".sticky-header").addClass("sticky");
        }
    });
    
    //************Dark-mode****************//

    // toogle color mode
    $("#switch-mode").on("click", function () {
        $("body").toggleClass("dark-mode");
        if ($("body").hasClass("dark-mode")) {
            $(this).find(".dark-mode").addClass("d-none");
            $(this).find(".light-mode").removeClass("d-none");
        } else {
            $(this).find(".dark-mode").removeClass("d-none");
            $(this).find(".light-mode").addClass("d-none");
        }
    });

    /*--- Tooltip Active---*/
    $(
        ".action_links ul li a,.add_to_cart a,.footer_social_link ul li a"
    ).tooltip({
        animated: "fade",
        placement: "top",
        container: "body",
    });

    /*--- niceSelect categories ---*/
    $(".select_option").niceSelect();

    /*---categories slideToggle---*/
    $(".categories_title").on("click", function () {
        $(this).toggleClass("active");
        $(".header_categories_toggle").slideToggle("medium");
    });

    /*---widget sub categories---*/
    $(".sub_categories1 > a").on("click", function () {
        $(this).toggleClass("active");
        $(".dropdown_categories1").slideToggle("medium");
    });

    /*---widget sub categories---*/
    $(".sub_categories2 > a").on("click", function () {
        $(this).toggleClass("active");
        $(".dropdown_categories2").slideToggle("medium");
    });

    /*---widget sub categories---*/
    $(".sub_categories3 > a").on("click", function () {
        $(this).toggleClass("active");
        $(".dropdown_categories3").slideToggle("medium");
    });


    /*----------  Category more toggle  ----------*/

    $(".header_categories_toggle li.hidden").hide();
    $("#more-btn").on("click", function (e) {
        e.preventDefault();
        $(".header_categories_toggle li.hidden").toggle(500);
        var htmlBefore =
            '<i class="fa fa-minus" aria-hidden="true"></i> Less Categories';
        var htmlAfter =
            '<i class="fa fa-plus" aria-hidden="true"></i> More Categories';

        if ($(this).html() == htmlBefore) {
            $(this).html(htmlAfter);
        } else {
            $(this).html(htmlBefore);
        }
    });

    /*---Category menu---*/
    function categorySubMenuToggle() {
        $(".header_categories_toggle li.header_menu_item > a").on(
            "click",
            function () {
                if ($(window).width() < 991) {
                    $(this).removeAttr("href");
                    var element = $(this).parent("li");
                    if (element.hasClass("open")) {
                        element.removeClass("open");
                        element.find("li").removeClass("open");
                        element.find("ul").slideUp();
                    } else {
                        element.addClass("open");
                        element.children("ul").slideDown();
                        element.siblings("li").children("ul").slideUp();
                        element.siblings("li").removeClass("open");
                        element.siblings("li").find("li").removeClass("open");
                        element.siblings("li").find("ul").slideUp();
                    }
                }
            }
        );
        $(".header_categories_toggle li.header_menu_item > a").append(
            '<span class="expand"></span>'
        );
    }
    categorySubMenuToggle();

    /*---search box slideToggle---*/
    $(".header_search_box > a").on("click", function () {
        $(this).toggleClass("active");
        $(".search_widget").slideToggle("medium");
    });

    /*---header account slideToggle---*/
    $(".header_account > a").on("click", function () {
        $(this).toggleClass("active");
        $(".dropdown_account").slideToggle("medium");
    });

    /*---slide toggle activation---*/

    /*---mini cart activation---*/
    $(document).on("click", ".mini_cart_wrapper > a", function () {
        $(".mini_cart,.mobile_overlay").addClass("active");
    });

    $(document).on("click", ".mini_cart_close,.mobile_overlay", function () {
        $(".mini_cart,.mobile_overlay").removeClass("active");
    });

    /*---canvas menu activation---*/
    $(".bar_open,.mobile_overlay").on("click", function () {
        $(".mobile_wrapper,.mobile_overlay").addClass("active");
    });

    $(".bar_close,.mobile_overlay").on("click", function () {
        $(".mobile_wrapper,.mobile_overlay").removeClass("active");
    });

    /*---Off Canvas Menu---*/
    var $offcanvasNav = $(".header_main_menu"),
        $offcanvasNavSubMenu = $offcanvasNav.find(".sub-menu");
    $offcanvasNavSubMenu
        .parent()
        .prepend(
            '<span class="menu-expand"><i class="fa fa-angle-down"></i></span>'
        );

    $offcanvasNavSubMenu.slideUp();

    $offcanvasNav.on("click", "li a, li .menu-expand", function (e) {
        var $this = $(this);
        if (
            $this
                .parent()
                .attr("class")
                .match(/\b(header_submenu_item|has-children|has-sub-menu)\b/) &&
            ($this.attr("href") === "#" || $this.hasClass("menu-expand"))
        ) {
            e.preventDefault();
            if ($this.siblings("ul:visible").length) {
                $this.siblings("ul").slideUp("slow");
            } else {
                $this
                    .closest("li")
                    .siblings("li")
                    .find("ul:visible")
                    .slideUp("slow");
                $this.siblings("ul").slideDown("slow");
            }
        }
        if (
            $this.is("a") ||
            $this.is("span") ||
            $this.attr("clas").match(/\b(menu-expand)\b/)
        ) {
            $this.parent().toggleClass("menu-open");
        } else if (
            $this.is("li") &&
            $this.attr("class").match(/\b('header_submenu_item')\b/)
        ) {
            $this.toggleClass("menu-open");
        }
    });


})(jQuery);
