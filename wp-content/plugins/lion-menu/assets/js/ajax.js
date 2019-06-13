jQuery(function($) {

    $('.menu-form').submit(function(event) {
        var form_data = $(this).serialize();

        var data = {
            'action': 'handle_ajax',
            form_data: form_data
        };
        
        $.post(ajaxurl, data, function(response) {
            console.log(response);
            
            // Confirmation Messages Here

            location.reload();
        });

        return false;
    });
    
});