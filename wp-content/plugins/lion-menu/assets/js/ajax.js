jQuery(function($) {

    /**
     * Set notification message
     */
    if(sessionStorage.getItem('message')) {
        $('#message-content').html(sessionStorage.getItem('message'));
        sessionStorage.removeItem('message');
    } else {
        $('#message').hide();
    }

    /**
     * Completely close message alert when 'x' is clicked
     */
    $('.close').click(function() {
        $('#message').hide();
    });

    /**
     * Handle submit of any menu form using AJAX
     */
    $('.menu-form').submit(function() {
        var form_data = $(this).serialize();

        var data = {
            'action': 'handle_ajax',
            form_data: form_data
        };
        
        $.post(ajaxurl, data, function(response) {
            console.log(response);

            sessionStorage.setItem('message', response);

            window.location.reload();
        });

        return false;
    });
    
});