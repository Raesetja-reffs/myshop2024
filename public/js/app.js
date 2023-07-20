$(document).ready(function() {
    // On hover, toggle the "active" class
    // $(document).on("mouseenter", ".flexdatalist-results li", function() {
    //     $(this).addClass("active");
    // });

    // $(document).on("mouseleave", ".flexdatalist-results li", function() {
    //     $(this).removeClass("active");
    // });

    $.ui.dialog.prototype.options.open = function() {
        $(this).closest(".ui-dialog")
        .find(".ui-dialog-titlebar-close")
        .html("<span style='margin: 0px;' class='ui-icon ui-icon-circle-close'></span>");
        $(this).closest(".ui-dialog")
        .find(".ui-dialog-titlebar-close").css({"border-radius": "2px", "height": "18px", "border": "1px solid #c5c5c5"});
    };
});
