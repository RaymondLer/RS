$(function() {
    
    // Reload page
    $("[type=reset]").click(function (e) {
        e.preventDefault();
        location = location;
    });
   

    $("[data-check]").click(function (e) { 
        e.preventDefault();
        var name = $(this).data("check");
        $(`[name="${name}"]`).prop("checked", true);
    });
   
    // Uncheck all checkboxes
    $("[data-uncheck]").click(function (e) { 
        e.preventDefault();
        var name = $(this).data("uncheck");
        $(`[name="${name}"]`).prop("checked", false);
    });
});