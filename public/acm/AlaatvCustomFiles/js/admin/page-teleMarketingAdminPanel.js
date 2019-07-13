
jQuery(document).ready(function () {
//            $("#order-portlet .reload").trigger("click");
    var newDataTable = $("#order_table").DataTable();
    newDataTable.destroy();
    makeDataTable("order_table");
    $("#order-expand").trigger("click");
});