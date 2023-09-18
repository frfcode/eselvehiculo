$(document).ready(function (e) {
    var tmp = 0;
    $('button[id="btn_panel_elemnt"]').each(function (index) {
        $(this).click(function () {
            if ($('div[id="panel_element"]').eq(index).hasClass("d-none")) {
                $(this).removeClass("active");
                $('div[id="panel_element"]').eq(index).removeClass("d-none");
                $('div[id="panel_element"]').eq(tmp).addClass("d-none");
                $('div[id="panel_element"]').eq(tmp).remove("active");
                tmp = index;
            }
        });
    });

    // SHOPPING CART LIST
    let getBtnCartShopping = $("#btn_shopping_cart");
    let getCartMenu = $("#shopping_cart");

    getBtnCartShopping.on("click", function (e) {
        e.preventDefault();
        if (getCartMenu.hasClass("panel-hide")) {
            getCartMenu.removeClass("panel-hide");
        } else {
            getCartMenu.addClass("panel-hide");
        }
    });
});
