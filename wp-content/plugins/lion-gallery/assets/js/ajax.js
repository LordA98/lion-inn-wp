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
     * When toggle is clicked - set hidden var for post
     */
    function setPostVar($inputName, $caller) {
        $parentListItemId = $($caller).closest("tr").attr("id");
        $('input[name='+$inputName+']').val($parentListItemId);
    }

    /**
     * Handle submit of any menu form using AJAX
     */
    $('.gallery-form').submit(function() {
        setPostVar("edit-gallery", this);

        var form_data = $(this).serialize();

        var data = {
            'action': 'handle_ajax_lg',
            form_data: form_data
        };

        console.log(data);
        
        $.post(ajaxurl, data, function(response) {
            sessionStorage.setItem('message', response);

            window.location.reload();
        });

        return false;
    });
    
});