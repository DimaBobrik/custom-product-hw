$(document).ready(function () {
    $('.gallery-image').click(function () {
        $('.product-image').attr('src', $(this).attr('src'));
    });
    $('.media-tabs .btn').click(function () {
        $('.media-tabs .btn').removeClass('active');
        $(this).addClass('active');
        $('.media-holder > div').removeClass('show');
        let tabId = $(this).attr('data-tab');
        $('.media-holder .' + tabId).addClass('show');
    });
});