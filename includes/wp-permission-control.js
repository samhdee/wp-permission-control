jQuery(document).ready(function ($) {
    $('#permission_control_admin a.show_add_permission_form').on('click', function (e) {
        $('#add_permission_form').slideToggle(200);
        $([document.documentElement, document.body]).animate({
            scrollTop: $('#add_permission_form').offset().top
        }, 1000);
    });

    $('#permission_control_admin #cancel_add_permission').on('click', function (e) {
        e.preventDefault();
        $('#permission_control_admin #add_permission_form select, #permission_control_admin #add_permission_form input[type="text"]').val('');
    });

    $('#add_permission_form #type_select').on('change', function () {
        const option = $(this).find('option:selected');
        $('#add_permission_form input').prop('disabled', $(option).val() == '');
        $('#add_permission_form #target_search').prop('placeholder', $(option).text());
    });

    $('#add_permission_form .thing_search').on('keyup', function () {
        if ($('#add_permission_form #type_select option:selected').val() == '') {
            return;
        }

        $.post(
            wpcAjax.ajaxurl,
            {
                action: 'wpc_search',
                type: $('#add_permission_form #type_select option:selected').val(),
                value: $(this).val()
            },
            function (data) {
                console.log(data);
            },
            'json'
        );
    });
});