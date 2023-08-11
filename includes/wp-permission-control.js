jQuery(document).ready(function ($) {
    $('a.show-add-permissions-form').on('click', function (e) {
        $('#permissions-add-form').slideToggle(200);
    });
});