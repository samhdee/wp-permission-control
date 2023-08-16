jQuery(document).ready(function ($) {
    $('#permission_control_admin a.show_add_permission_form').on('click', function (e) {
        $('#add_permission_form').slideToggle(200);
        $([document.documentElement, document.body]).animate({
            scrollTop: $('#add_permission_form').offset().top
        }, 1000);
    });

    $('#permission_control_admin #cancel_add_permission').on('click', function (e) {
        e.preventDefault();
        $(
            '#permission_control_admin #add_permission_form select,' +
            '#permission_control_admin #add_permission_form input[type="text"]')
            .val('');
    });

    // Disable/endable les inputs après sélection du type
    $('#add_permission_form select').on('change', function () {
        const select = $(this);
        const selected_option = $(select).find('option:selected');
        const input_search = $(
            `#add_permission_form input` +
            `[data-taxo="${$(select).prop('id')}"]`
        );

        if ($(select).prop('id') == 'population_type_select') {
            if ($(selected_option).val() == 'role') {
                $('#population_search').hide();
                $('#role_select').show();
            } else {
                $('#population_search')
                    .show()
                    .prop('disabled', false)
                    .trigger('focus');
                $('#role_select').hide();
                $(selected_option).removeProp('selected');
            }
        } else {
            $(input_search)
                .prop('disabled', $(selected_option).val().length < 1)
                .val('')
                .trigger('focus');
        }

        $(select).parent().find('.wpc_label').toggle();
    });

    // Autocomplete population ou contenu
    $('#add_permission_form .thing_search').on('keyup', function () {
        const search_input = $(this);
        const search_results = $(`#wpc_${$(search_input).prop('id')}`);
        $(search_results).hide();

        if (
            $(`select#${$(search_input).data('taxo')}`).val().length == 0
            || $(search_input).val().length == 0
        ) {
            return;
        }


        $.post(
            wpcAjax.ajaxurl,
            {
                action: 'wpc_search',
                target: $(`#${$(search_input).data('taxo')} option:selected`).val(),
                value: $(search_input).val()
            },
            function (data) {
                if (data.length == 0) {
                    $(search_results)
                        .html('<div class="wpc_no_results">Aucun résultat</div>')
                        .show();
                    return;
                }

                const results_list = $('<ul></ul>');

                for (i in data) {
                    $(results_list).append(
                        `<li class="wpc_search_item">` +
                            `<a ` +
                                `href="#"` +
                                `data-result_id="${data[i].id}">` +
                                `${data[i].name}` +
                            `</a>` +
                        `</li>`);
                }

                $(search_results).empty().append($(results_list)).show();
            },
            'json'
        );
    });

    // Cache les résultats au clic en dehors
    $(document).mouseup(function(e) {
        var container = $('.wpc_search_results');

        // if the target of the click isn't the container nor a descendant of the container
        if (
            $(document).has('#add_permission_form')
            && $(container).is(':visible')
            && !container.is(e.target)
        ) {
            container.hide();
        }
    });
});