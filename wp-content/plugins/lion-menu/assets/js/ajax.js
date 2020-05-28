jQuery(function ($) {

    /**
     * Set notification message
     */
    if (sessionStorage.getItem('menuMessage')) {
        $('#lm-message-content').html(sessionStorage.getItem('menuMessage'));
        sessionStorage.removeItem('menuMessage');
    } else {
        $('#lm-message').hide();
    }

    /**
     * Completely close message alert when 'x' is clicked
     */
    $('.close').click(function () {
        $('#lm-message').hide();
    });

    /**
     * Handle submit of any menu form using AJAX
     */
    $('.menu-form').submit(function () {
        var form_data = $(this).serialize();

        var data = {
            'action': 'handle_ajax',
            form_data: form_data
        };

        $.post(ajaxurl, data, function (response) {
            console.log(response);

            sessionStorage.setItem('menuMessage', response);

            window.location.reload();
        });

        return false;
    });

});