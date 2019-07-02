jQuery(function($) {

    /**
     * Set notification message
     */
    if(sessionStorage.getItem('docs-message')) {
        $('#docs-message-content').html(sessionStorage.getItem('docs-message'));
        sessionStorage.removeItem('docs-message');
    } else {
        $('#docs-message').hide();
    }

    /**
     * Completely close message alert when 'x' is clicked
     */
    $('.close').click(function() {
        $('#docs-message').hide();
    });

    /**
     * Handle submit of any menu form using AJAX
     */
    $('.doc-form').submit(function() {
        var form_data = $(this).serialize();

        console.log(form_data);

        var data = {
            'action': 'handle_ajax_docs',
            form_data: form_data
        };
        
        $.post(ajaxurl, data, function(response) {
            console.log(response);

            sessionStorage.setItem('docs-message', response);

            window.location.reload();
        });

        return false;
    });
    
});