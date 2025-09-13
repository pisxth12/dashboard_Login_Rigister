$(document).ready(function () {
    let role = localStorage.getItem("role");

    if (role !== "admin") {
        $('[data-content="dashboard"]').hide();
        $('[data-content="add_product"]').hide();
    }

    $('.btn-nav').click(function () {
        let contentType = $(this).data('content');
        $('#main_content').empty();

        if (contentType === 'home') {
            $('#main_content').html($('#home_template').html());
        } else if (contentType === 'product') {
            $('#main_content').html($('#product_template').html());
        } else if (contentType === "dashboard") {
            $('#main_content').html($('#dashboard_template').html());
            initCharts();
        } else if (contentType === "add_product") {
            $('#main_content').html($('#add_product').html());
        }
    });
});



